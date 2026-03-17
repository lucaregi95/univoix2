<?php
session_start();
require_once("../bdd/connexion.php");

// Redirige si l'utilisateur n'est pas connecté
if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    header("location:connexion.php?page=p");
    exit();
}

// Mise à jour des informations personnelles (nom, prénom, age, pseudo)
if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['age']) && isset($_POST['pseudo']) && isset($_POST['id_inscrit'])) {
    $sqlUpdate = "UPDATE inscrit SET nom = :nom, prenom = :prenom, age = :age, pseudo = :pseudo WHERE id_inscrit = :id";
    $queryUpdate = $connexion->prepare($sqlUpdate);
    $queryUpdate->execute(array(
            'nom'    => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'age'    => $_POST['age'],
            'pseudo' => $_POST['pseudo'],
            'id'     => $_POST['id_inscrit']
    ));
}

// Mise à jour des handicaps : supprime les anciens puis insère les nouveaux
if(isset($_POST['handicaps']) && !empty($_POST['handicaps'])) {
    // Suppression de tous les handicaps actuels de l'utilisateur via une jointure
    $sqlDelete_handi = "DELETE ih FROM inscrithandicap ih INNER JOIN inscrit i ON i.id_inscrit = ih.ref_inscrit WHERE i.id_inscrit = :id";
    $queryDelete_handi = $connexion->prepare($sqlDelete_handi);
    $queryDelete_handi->execute(['id' => $_POST['id_inscrit']]);

    // Insère chaque handicap choisi (envoyé en CSV depuis le JS) en récupérant l'ID via le nom
    $sqlUpdate_handi = "INSERT INTO inscrithandicap (ref_inscrit, ref_handicap) SELECT :id, h.id_handicap FROM handicap h WHERE h.nom = :nom";
    $queryUpdate_handi = $connexion->prepare($sqlUpdate_handi);

    // explode découpe la chaîne CSV en tableau de noms de handicaps
    $handicapsChoisis = explode(',', $_POST['handicaps']);
    foreach($handicapsChoisis as $nomHandicap) {
        // trim retire les espaces parasites qui pourraient entourer le nom
        $nomHandicap = trim($nomHandicap);
        if($nomHandicap !== '') {
            $queryUpdate_handi->execute([
                    'id'  => $_POST['id_inscrit'],
                    'nom' => $nomHandicap
            ]);
        }
    }
}

// Récupère le type de daltonisme choisi parmi les trois switches (un seul actif à la fois)
$types_daltonisme  = ['deuteranopie', 'tritanopie', 'protanopie'];
foreach ($types_daltonisme as $type) {
    $daltonisme_choisi = 'aucun';
    if (isset($_POST[$type]) && $_POST[$type] === 'on') {
        $daltonisme_choisi = $type;
        break;
    }
}

// Convertit la valeur du switch dyslexie en 0 ou 1 pour la BDD
$dyslexie_choisie = (isset($_POST['police_dyslexique']) && $_POST['police_dyslexique'] === 'on') ? 1 : 0;

// Met à jour les préférences d'accessibilité en BDD
if(isset($_POST['id_inscrit'])) {
    $sqlAccess = "UPDATE inscrit SET daltonisme = :daltonisme, dyslexie = :dyslexie WHERE id_inscrit = :id";
    $queryAccess = $connexion->prepare($sqlAccess);
    $queryAccess->execute([
            'daltonisme' => $daltonisme_choisi,
            'dyslexie'   => $dyslexie_choisie,
            'id'         => $_POST['id_inscrit']
    ]);
}

// Met à jour la session pour que les changements soient actifs immédiatement
$_SESSION['daltonisme'] = $daltonisme_choisi;
$_SESSION['dyslexie']   = (bool)$dyslexie_choisie;

$message     = "";
$avatar_path = "";
$id          = $_SESSION['id'];

// Récupère les informations de l'utilisateur connecté
$sql = "SELECT id_inscrit, nom, prenom, age, email, pseudo, daltonisme, dyslexie FROM inscrit WHERE id_inscrit = :id";
$query = $connexion->prepare($sql);
$query->execute(["id" => $id]);
$resultat = $query->fetch();

// Récupère les handicaps de l'utilisateur via la table de liaison
// PDO::FETCH_COLUMN retourne un tableau simple de valeurs (juste les noms des handicaps)
$sql_handicaps = "SELECT h.nom FROM handicap h INNER JOIN inscrithandicap ih ON h.id_handicap = ih.ref_handicap WHERE ih.ref_inscrit = :id";
$query_handicaps = $connexion->prepare($sql_handicaps);
$query_handicaps->execute(["id" => $id]);
$handicap_utilisateur = $query_handicaps->fetchAll(PDO::FETCH_COLUMN);

// Gestion de l'upload de l'avatar
if(isset($_FILES['file']) && $_FILES['file']['error'] != 4){
    $tmpName  = $_FILES['file']['tmp_name'];
    $name     = $_FILES['file']['name'];
    $size     = $_FILES['file']['size'];
    $error    = $_FILES['file']['error'];

    // Isole l'extension du fichier uploadé : explode sur "." puis end() récupère le dernier élément
    $tabExtension = explode('.', $name);
    $extension    = strtolower(end($tabExtension));
    $extensions   = ['jpg','jpeg','png','gif'];
    $maxSize      = 2000000;

    if(in_array($extension, $extensions) && $size <= $maxSize && $error == 0){
        // Supprime tous les anciens avatars de l'utilisateur (tous formats confondus)
        foreach($extensions as $ext){
            $oldFile = "../img/avatar/".$id.".".$ext;
            if(file_exists($oldFile)) unlink($oldFile);
        }

        $file       = $id.".".$extension;
        $uploadPath = "../img/avatar/".$file;

        // Déplace le fichier temporaire vers le dossier avatar définitif
        if(move_uploaded_file($tmpName, $uploadPath)){
            $avatar_path = $uploadPath;
            $message = '<div class="alert alert-success">Avatar téléchargé avec succès !</div>';
        } else {
            $message = '<div class="alert alert-danger">Erreur lors du téléchargement</div>';
        }
    } else {
        if(!in_array($extension, $extensions)){
            $message = '<div class="alert alert-danger">Extension non autorisée (jpg, png, jpeg, gif uniquement)</div>';
        } elseif($size > $maxSize){
            $message = '<div class="alert alert-danger">Fichier trop volumineux (max 2 Mo)</div>';
        } else {
            $message = '<div class="alert alert-danger">Une erreur est survenue lors du téléchargement</div>';
        }
    }
}

// Daltonisme
if (isset($resultat['daltonisme']) && $resultat['daltonisme'] !== '') {
    $daltonisme_session = $resultat['daltonisme'];
} elseif (isset($_SESSION['daltonisme'])) {
    $daltonisme_session = $_SESSION['daltonisme'];
} else {
    $daltonisme_session = 'aucun';
}

// Dyslexie
if (isset($resultat['dyslexie'])) {
    $dyslexie_session = (bool)$resultat['dyslexie'];
} elseif (isset($_SESSION['dyslexie'])) {
    $dyslexie_session = $_SESSION['dyslexie'];
} else {
    $dyslexie_session = false;
}
$_SESSION['daltonisme'] = $daltonisme_session;
$_SESSION['dyslexie']= $dyslexie_session;

// Palettes de couleurs selon le type de daltonisme
$palettes = [
        'aucun'        => ['danger'=>'#dc3545','danger_rgb'=>'220,53,69', 'danger_dark'=>'#58151c','danger_bg_subtle'=>'#f8d7da','danger_border_subtle'=>'#f1aeb5','link'=>'#0d6efd','link_rgb'=>'13,110,253','tag_bg'=>'#dc3545','switch_on'=>'#dc3545'],
        'deuteranopie' => ['danger'=>'#0055cc','danger_rgb'=>'0,85,204',  'danger_dark'=>'#002a66','danger_bg_subtle'=>'#cce0ff','danger_border_subtle'=>'#99c1ff','link'=>'#e07b00','link_rgb'=>'224,123,0', 'tag_bg'=>'#0055cc','switch_on'=>'#0055cc'],
        'tritanopie'   => ['danger'=>'#cc3300','danger_rgb'=>'204,51,0',  'danger_dark'=>'#661a00','danger_bg_subtle'=>'#ffe5dd','danger_border_subtle'=>'#ffbba8','link'=>'#007a33','link_rgb'=>'0,122,51',  'tag_bg'=>'#cc3300','switch_on'=>'#cc3300'],
        'protanopie'   => ['danger'=>'#6600cc','danger_rgb'=>'102,0,204', 'danger_dark'=>'#330066','danger_bg_subtle'=>'#ead5ff','danger_border_subtle'=>'#cc99ff','link'=>'#007acc','link_rgb'=>'0,122,204', 'tag_bg'=>'#6600cc','switch_on'=>'#6600cc'],
];
$p = isset($palettes[$daltonisme_session]) ? $palettes[$daltonisme_session] : $palettes['aucun'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniVoix - Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style/style_public/profil.css" rel="stylesheet">
    <?php if ($daltonisme_session !== 'aucun' || $dyslexie_session): ?>
        <style id="accessibilite-overrides">
            <?php if ($daltonisme_session !== 'aucun'): ?>
            :root {
                --bs-danger:               <?= $p['danger'] ?>;
                --bs-danger-rgb:           <?= $p['danger_rgb'] ?>;
                --bs-danger-text-emphasis: <?= $p['danger_dark'] ?>;
                --bs-danger-bg-subtle:     <?= $p['danger_bg_subtle'] ?>;
                --bs-danger-border-subtle: <?= $p['danger_border_subtle'] ?>;
                --bs-link-color:           <?= $p['link'] ?>;
                --bs-link-color-rgb:       <?= $p['link_rgb'] ?>;
                --bs-link-hover-color:     <?= $p['danger'] ?>;
            }
            .btn-danger:hover,.btn-danger:active,.btn-danger:focus-visible{background-color:<?= $p['danger_dark'] ?> !important;border-color:<?= $p['danger_dark'] ?> !important;}
            .btn-outline-danger:hover,.btn-outline-danger:active{background-color:<?= $p['danger'] ?> !important;border-color:<?= $p['danger'] ?> !important;color:#fff !important;}
            .form-control:focus,.form-select:focus{border-color:<?= $p['danger'] ?> !important;box-shadow:0 0 0 .25rem rgba(<?= $p['danger_rgb'] ?>,.25) !important;}
            .form-check-input.custom-switch:checked{background-color:<?= $p['switch_on'] ?> !important;border-color:<?= $p['switch_on'] ?> !important;}
            .tag{background:<?= $p['tag_bg'] ?> !important;}
            <?php endif; ?>
            <?php if ($dyslexie_session): ?>
            @font-face{font-family:'OpenDyslexic';src:url('https://cdn.jsdelivr.net/npm/open-dyslexic@1.0.3/OpenDyslexic-Regular.otf') format('opentype');font-weight:normal;}
            @font-face{font-family:'OpenDyslexic';src:url('https://cdn.jsdelivr.net/npm/open-dyslexic@1.0.3/OpenDyslexic-Bold.otf') format('opentype');font-weight:bold;}
            *,*::before,*::after{font-family:'OpenDyslexic',Arial,sans-serif !important;}
            body{line-height:1.8 !important;letter-spacing:.05em !important;word-spacing:.15em !important;background-color:#fdfaf3 !important;}
            body,p,li,td,label{font-size:1.05rem !important;}
            <?php endif; ?>
        </style>
    <?php endif; ?>
</head>

<body style="font-family:'Candara'" class="bg-light">

<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">
        <a href="acceuil.php"><img alt="" class="navbar-brand fw-bold" src="../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link" href="specialistes.php">Spécialistes</a>
        <a class="nav-link" href="forum.php">Forum</a>
        <a class="nav-link" href="aides.php">Aides</a>
        <a class="nav-link" href="presentation.php">Handicaps</a>
        <?php
        $avatar = null;
        require_once("avatar.php"); ?>
        <li class="nav-item dropdown fs-5">
            <a class="nav-link dropdown-toggle text-danger fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="rounded-circle" alt="pdp" src="<?= $avatar ?>" width="40px" height="40px"/> &nbsp;<?= $_SESSION["prenom"] ?> <?= $_SESSION["nom"] ?>
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="profil.php">Profil</a></li>
                <li><a class="dropdown-item" href="deconnexion.php">Se déconnecter</a></li>
            </ul>
        </li>
    </div>
</nav>

<div class="container my-5">

    <?php if ($message) echo $message; ?>

    <!-- enctype="multipart/form-data" est obligatoire pour l'upload de fichier -->
    <form action="profil.php" method="POST" enctype="multipart/form-data">
        <div class="card border border-danger border-3 shadow-sm">
            <div class="card-body p-5">
                <h2 class="fw-bold mb-4">Vos informations personnelles</h2>
                <div class="row g-5">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nom :</label>
                            <input type="text" name="nom" class="form-control" value="<?= $resultat["nom"] ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Prénom :</label>
                            <input type="text" name="prenom" class="form-control" value="<?= $resultat["prenom"] ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">E-mail :</label>
                            <!-- disabled : le champ est affiché mais non modifiable ni envoyé en POST -->
                            <input type="email" name="email" class="form-control" value="<?= $resultat["email"] ?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Age :</label>
                            <input type="number" name="age" class="form-control" value="<?= $resultat["age"] ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pseudo :</label>
                            <input type="text" name="pseudo" class="form-control" value="<?= $resultat["pseudo"] ?>">
                        </div>
                        <!-- Champ caché transmettant l'ID de l'utilisateur au traitement PHP -->
                        <input type="hidden" name="id_inscrit" id="inscrit" value="<?= $_SESSION['id'] ?>">
                    </div>

                    <div class="col-md-5">
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <label class="form-label fw-semibold mb-0">Police pour Dyslexique :</label>
                                <div class="form-check form-switch">
                                    <!-- Pré-coche le switch si la dyslexie est active en session -->
                                    <input class="form-check-input custom-switch" type="checkbox" name="police_dyslexique" role="switch" value="on" <?= $dyslexie_session ? 'checked' : '' ?>>
                                </div>
                            </div>
                            <h3>Handicaps :</h3>
                            <div class="d-flex gap-2 align-items-start mb-1">
                                <div class="tag-input-box flex-grow-1" id="tagBox" onclick="document.getElementById('tagSearch').focus()">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#aaa" class="bi bi-search flex-shrink-0" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                    </svg>
                                    <input type="text" id="tagSearch" placeholder="Rechercher un trouble...">
                                </div>
                                <button type="button" class="btn-help" title="Sélectionnez un ou plusieurs troubles dans la liste" onclick="alert('Cliquez sur un trouble dans la liste pour l\'ajouter. Cliquez à nouveau pour le retirer.')">?</button>
                            </div>
                            <div class="tag-dropdown" id="tagDropdown">
                                <div class="tag-empty" id="tagEmpty">Aucun résultat</div>
                            </div>
                            <!-- Champ caché qui recevra la liste des handicaps en CSV depuis le JS -->
                            <input type="hidden" name="handicaps" id="handicapsInput" value="">
                        </div>
                    </div>

                    <div class="col-md-4 text-center">
                        <label class="form-label fw-semibold d-block mb-3">Avatar :</label>
                        <div class="mb-3">
                            <div class="avatar-preview" id="avatarPreview">
                                <?php if ($avatar != "../img/avatar/default.png"): ?>
                                    <img src="<?= $avatar ?>" alt="Avatar">
                                <?php else: ?>
                                    <div class="text-center text-muted">Avatar</div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- Input fichier caché, déclenché par le bouton via onclick -->
                        <input type="file" name="file" id="fileInput" class="d-none" accept="image/jpeg,image/png,image/jpg,image/gif">
                        <button type="button" class="btn btn-outline-danger" onclick="document.getElementById('fileInput').click()">
                            Choisir une image
                        </button>
                        <small class="d-block text-muted mt-2">Max 2 Mo (JPG, PNG, GIF)</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Switches de daltonisme : un seul peut être actif à la fois (géré en JS) -->
        <div class="card border border-danger border-3 shadow-sm mt-4">
            <div class="card-body p-5">
                <h2 class="fw-bold mb-4">Accessibilité - Daltonisme</h2>
                <div class="row mt-4">
                    <div class="col-md-4 d-flex align-items-center justify-content-start gap-3">
                        <label class="form-label mb-0 fw-semibold">Deutéranopie :</label>
                        <div class="form-check form-switch">
                            <!-- Pré-coche le switch correspondant au daltonisme actif en session -->
                            <input class="form-check-input custom-switch daltonisme-switch" type="checkbox" name="deuteranopie" role="switch" value="on" <?= ($daltonisme_session === 'deuteranopie') ? 'checked' : '' ?>>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-start gap-3">
                        <label class="form-label mb-0 fw-semibold">Tritanopie :</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input custom-switch daltonisme-switch" type="checkbox" name="tritanopie" role="switch" value="on" <?= ($daltonisme_session === 'tritanopie') ? 'checked' : '' ?>>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-start gap-3">
                        <label class="form-label mb-0 fw-semibold">Protanopie :</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input custom-switch daltonisme-switch" type="checkbox" name="protanopie" role="switch" value="on" <?= ($daltonisme_session === 'protanopie') ? 'checked' : '' ?>>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center my-4">
            <button type="submit" class="btn btn-danger btn-lg px-5 py-2">Sauvegarder les changements</button>
        </div>
    </form>
</div>

<footer class="footer-wrap">
    <div class="footer-top">
        <div class="footer-col">
            <h4>Nous contacter</h4>

            <a href="https://mail.google.com/mail/?view=cm&to=univoix@gmail.com&su=Prise de contact"
               target="_blank">univoix@gmail.com</a>
        </div>
        <div class="footer-col">
            <h4>Soutien & écoute</h4>
            <div class="urgence-item"><span class="urgence-num">3114</span><span class="urgence-label">Prévention suicide (24h/24)</span></div>
            <div class="urgence-item"><span class="urgence-num">3977</span><span class="urgence-label">Maltraitance personnes âgées / handicap</span></div>
            <div class="urgence-item"><span class="urgence-num">0800 235 236</span><span class="urgence-label">Fil santé jeunes (gratuit)</span></div>
        </div>
        <div class="footer-col">
            <h4>Aide aux personnes vulnérables</h4>
            <div class="urgence-item"><span class="urgence-num">119</span><span class="urgence-label">Enfance en danger</span></div>
            <div class="urgence-item"><span class="urgence-num">114</span><span class="urgence-label">Urgence sourdes / malentendantes</span></div>
            <div class="urgence-item"><span class="urgence-num">0800 360 360</span><span class="urgence-label">Info handicap — aidants familiaux</span></div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2026 — Luca Regi, Nassim Kharfouche, Prosper Fajnzyn — Tous droits réservés</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const options = [
        "TDAH", "Autisme", "Trouble du Spectre Autistique", "Maladie chronique",
        "Dyslexie", "Dyscalculie", "Dyspraxie", "Troubles anxieux",
        "Dépression", "Haut Potentiel Intellectuel", "Autre",
    ];

    const selected      = new Set();
    const tagSearch     = document.getElementById('tagSearch');
    const tagBox        = document.getElementById('tagBox');
    const tagDropdown   = document.getElementById('tagDropdown');
    const tagEmpty      = document.getElementById('tagEmpty');
    const handicapsInput = document.getElementById('handicapsInput');

    // Génère dynamiquement les options de la liste
    options.forEach(opt => {
        const div = document.createElement('div');
        div.className     = 'tag-option';
        div.dataset.value = opt;
        div.innerHTML     = `<span>${opt}</span><div class="tag-check"></div>`;
        div.addEventListener('click', () => toggle(opt, div));
        tagDropdown.insertBefore(div, tagEmpty);
    });

    // Ajoute ou retire un handicap du Set
    function toggle(value, el) {
        if (selected.has(value)) {
            selected.delete(value);
            el.classList.remove('selected');
            // CSS.escape : sécurise les caractères spéciaux dans le sélecteur CSS généré dynamiquement
            tagBox.querySelector(`.tag[data-value="${CSS.escape(value)}"]`)?.remove();
        } else {
            selected.add(value);
            el.classList.add('selected');
            addTag(value);
        }
        updateHiddenInput();
        tagSearch.focus();
    }

    // Crée et insère visuellement un tag dans la zone de saisie
    function addTag(value) {
        const tag = document.createElement('span');
        tag.className     = 'tag';
        tag.dataset.value = value;
        tag.innerHTML     = `${value}<button type="button" class="tag-remove" title="Retirer">×</button>`;
        tag.querySelector('.tag-remove').addEventListener('click', e => {
            e.stopPropagation();
            selected.delete(value);
            tag.remove();
            tagDropdown.querySelector(`.tag-option[data-value="${CSS.escape(value)}"]`)?.classList.remove('selected');
            updateHiddenInput();
        });
        tagBox.insertBefore(tag, tagSearch);
    }

    // Met à jour le champ caché avec la liste CSV des handicaps sélectionnés
    function updateHiddenInput() {
        handicapsInput.value = Array.from(selected).join(',');
    }

    // Filtre la liste selon la saisie
    tagSearch.addEventListener('input', () => {
        const q = tagSearch.value.toLowerCase().trim();
        let visible = 0;
        tagDropdown.querySelectorAll('.tag-option').forEach(item => {
            const match = item.dataset.value.toLowerCase().includes(q);
            item.classList.toggle('hidden', !match);
            if (match) visible++;
        });
        tagEmpty.style.display = visible === 0 ? 'block' : 'none';
    });

    // Supprime le dernier tag sélectionné si Backspace est pressé avec un champ vide
    tagSearch.addEventListener('keydown', e => {
        if (e.key === 'Backspace' && tagSearch.value === '' && selected.size > 0) {
            const last = [...selected].pop();
            selected.delete(last);
            tagBox.querySelector(`.tag[data-value="${CSS.escape(last)}"]`)?.remove();
            tagDropdown.querySelector(`.tag-option[data-value="${CSS.escape(last)}"]`)?.classList.remove('selected');
            updateHiddenInput();
        }
    });

    // Prévisualise l'image choisie localement avant upload
    // FileReader.readAsDataURL : lit le fichier en base64 pour l'afficher dans un <img> sans l'uploader
    document.getElementById('fileInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('avatarPreview').innerHTML = `<img src="${event.target.result}" alt="Avatar">`;
            };
            reader.readAsDataURL(file);
        }
    });

    // Au chargement de la page : pré-sélectionne les handicaps stockés en BDD
    // Les données PHP sont injectées directement en JSON dans le JS via json_encode
    document.addEventListener('DOMContentLoaded', function() {
        const handicapsFromDB = <?= json_encode($handicap_utilisateur) ?>;
        handicapsFromDB.forEach(handicap => {
            const cleanHandicap = handicap.trim();
            const option = tagDropdown.querySelector(`.tag-option[data-value="${CSS.escape(cleanHandicap)}"]`);
            if (option) {
                selected.add(cleanHandicap);
                option.classList.add('selected');
                addTag(cleanHandicap);
            }
        });
        updateHiddenInput();
    });

    // Gestion des switches daltonisme : un seul actif à la fois
    // Quand un switch est coché, tous les autres sont décochés
    document.querySelectorAll('.daltonisme-switch').forEach(function(sw) {
        sw.addEventListener('change', function() {
            if (this.checked) {
                document.querySelectorAll('.daltonisme-switch').forEach(function(other) {
                    if (other !== sw) other.checked = false;
                });
            }
        });
    });
</script>

</body>
</html>