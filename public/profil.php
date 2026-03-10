<?php
session_start();
require_once("../bdd/connexion.php");

if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    header("location:connexion.php?page=p");
    exit();
}

$message = "";
$avatar_path = "";

$id = $_SESSION['id'];

$sql = "SELECT nom, prenom, age, email, pseudo 
        FROM inscrit 
        WHERE id_inscrit = :id";

$query = $connexion->prepare($sql);
$query->execute(["id"=>$id]);
$resultat = $query->fetch();

$sql_handicaps = "SELECT h.nom
                  FROM handicap h
                  INNER JOIN inscrithandicap ih 
                  ON h.id_handicap = ih.ref_handicap
                  WHERE ih.ref_inscrit = :id";

$query_handicaps = $connexion->prepare($sql_handicaps);
$query_handicaps->execute(["id"=>$id]);
$handicap_utilisateur = $query_handicaps->fetchAll(PDO::FETCH_COLUMN);


/* =============================
   TRAITEMENT UPLOAD AVATAR
   ============================= */

if(isset($_FILES['file']) && $_FILES['file']['error'] != 4){

    $tmpName = $_FILES['file']['tmp_name'];
    $name = $_FILES['file']['name'];
    $size = $_FILES['file']['size'];
    $error = $_FILES['file']['error'];

    $tabExtension = explode('.', $name);
    $extension = strtolower(end($tabExtension));

    $extensions = ['jpg','jpeg','png','gif'];
    $maxSize = 2000000;

    if(in_array($extension,$extensions) && $size <= $maxSize && $error == 0){

        /* supprimer ancien avatar */
        foreach($extensions as $ext){
            $oldFile = "../img/avatar/".$id.".".$ext;
            if(file_exists($oldFile)){
                unlink($oldFile);
            }
        }

        /* nom fichier = id utilisateur */
        $file = $id.".".$extension;
        $uploadPath = "../img/avatar/".$file;

        if(move_uploaded_file($tmpName,$uploadPath)){

            $avatar_path = $uploadPath;

            $message = '<div class="alert alert-success">
                        Avatar téléchargé avec succès !
                        </div>';

        }else{

            $message = '<div class="alert alert-danger">
                        Erreur lors du téléchargement
                        </div>';
        }

    }else{

        if(!in_array($extension,$extensions)){

            $message = '<div class="alert alert-danger">
                        Extension non autorisée (jpg, png, jpeg, gif uniquement)
                        </div>';

        }elseif($size > $maxSize){

            $message = '<div class="alert alert-danger">
                        Fichier trop volumineux (max 2 Mo)
                        </div>';

        }else{

            $message = '<div class="alert alert-danger">
                        Une erreur est survenue lors du téléchargement
                        </div>';
        }
    }
}





?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniVoix - Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <a href="../style/style_public/profil.css" rel="stylesheet">
</head>

<body style="font-family:'Candara'" class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">
        <a href="acceuil.php"><img alt="" class="navbar-brand fw-bold" src="../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link" href="specialistes.php">Spécialistes</a>
        <a class="nav-link" href="forum.php">Forum</a>
        <a class="nav-link" href="aides.php">Aides</a>
        <a class="nav-link" href="presentation.php">Handicaps</a>
        <?php
        $avatar=null;
        require_once("avatar.php");?>
        <li class="nav-item dropdown fs-5" >
            <a class="nav-link dropdown-toggle text-danger fw-bold" style="font-weight:bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img class="rounded-circle" alt="pdp" src="<?=$avatar?>" width="40px" height="40px"/>     <?=$_SESSION["prenom"]?> <?=$_SESSION["nom"]?></a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="profil.php">Profil</a></li>
                <li><a class="dropdown-item" href="deconnexion.php">Se deconnecter</a></li>
            </ul>
        </li>




    </div>
</nav>

<!-- CONTENT -->
<div class="container my-5">

    <?php if ($message) echo $message; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="card border border-danger border-3 shadow-sm">
            <div class="card-body p-5">
                <h2 class="fw-bold mb-4">Vos informations personnelles</h2>
                <div class="row g-5">
                    <!-- COLONNE GAUCHE -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nom :</label>
                            <input type="text" name="nom" class="form-control" value="<?=$resultat["nom"]?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Prénom :</label>
                            <input type="text" name="prenom" class="form-control" value="<?=$resultat["prenom"]?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">E-mail :</label>
                            <input type="email" name="email" class="form-control" value="<?=$resultat["email"]?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Age :</label>
                            <input type="number" name="age" class="form-control" value="<?=$resultat["age"]?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pseudo :</label>
                            <input type="text" name="pseudo" class="form-control" value="<?=$resultat["pseudo"]?>">
                        </div>
                    </div>

                    <!-- COLONNE CENTRE -->
                    <div class="col-md-5">
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <label class="form-label fw-semibold mb-0">Police pour Dyslexique :</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input custom-switch" type="checkbox" name="police_dyslexique" role="switch">
                                </div>
                            </div>
                            <h3>Handicaps :</h3>
                            <!-- TAG INPUT ROW -->
                            <div class="d-flex gap-2 align-items-start mb-1">
                                <div class="tag-input-box flex-grow-1" id="tagBox" onclick="document.getElementById('tagSearch').focus()">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#aaa" class="bi bi-search flex-shrink-0" viewBox="0 0 16 16">
                                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                    </svg>
                                    <input type="text" id="tagSearch" placeholder="Rechercher un trouble...">
                                </div>
                                <button type="button" class="btn-help" title="Sélectionnez un ou plusieurs troubles dans la liste" onclick="alert('Cliquez sur un trouble dans la liste pour l\'ajouter. Cliquez à nouveau pour le retirer.')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286m1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94"/>
                                    </svg>
                                </button>
                            </div>

                            <!-- DROPDOWN LIST -->
                            <div class="tag-dropdown" id="tagDropdown">
                                <div class="tag-empty" id="tagEmpty">Aucun résultat</div>
                            </div>

                            <!-- Hidden input pour stocker les handicaps sélectionnés -->
                            <input type="hidden" name="handicaps" id="handicapsInput" value="">
                        </div>
                    </div>

                    <!-- COLONNE DROITE - AVATAR -->
                    <div class="col-md-4 text-center">
                        <label class="form-label fw-semibold d-block mb-3">Avatar :</label>
                        <div class="mb-3">
                            <div class="avatar-preview" id="avatarPreview">
                                <?php if ($avatar != "../img/avatar/default.png") { ?>

                                    <img src="<?= $avatar ?>" alt="Avatar">

                                <?php } else { ?>

                                    <div class="text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-person text-muted mb-2" viewBox="0 0 16 16">
                                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4"/>
                                        </svg>
                                        <div class="text-muted">Avatar</div>
                                    </div>

                                <?php } ?>
                            </div>
                        </div>
                        <input type="file" name="file" id="fileInput" class="d-none" accept="image/jpeg,image/png,image/jpg,image/gif">
                        <button type="button" class="btn btn-outline-danger" onclick="document.getElementById('fileInput').click()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload me-2" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
                                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z"/>
                            </svg>
                            Choisir une image
                        </button>
                        <small class="d-block text-muted mt-2">Max 2 Mo (JPG, PNG, GIF)</small>
                    </div>
                </div>
                <!-- SWITCHES EN BAS -->
                <div class="row mt-4">
                    <div class="col-md-4 d-flex align-items-center justify-content-start gap-3">
                        <label class="form-label mb-0 fw-semibold">Deutéranopie :</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input custom-switch" type="checkbox" name="deuteranopie" role="switch">
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-start gap-3">
                        <label class="form-label mb-0 fw-semibold">Tritanopie :</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input custom-switch" type="checkbox" name="tritanopie" role="switch">
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-start gap-3">
                        <label class="form-label mb-0 fw-semibold">Protanopie :</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input custom-switch" type="checkbox" name="protanopie" role="switch">
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- BOUTON SAUVEGARDER -->
        <div class="text-center my-4">
            <button type="submit" class="btn btn-danger btn-lg px-5 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-circle me-2" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                </svg>
                Sauvegarder les changements
            </button>
        </div>
    </form>
</div>

<!-- FOOTER -->
<footer class="bg-danger text-white py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <small class="opacity-75">© 2026 – Luca Regi, Nassim Kharfouche, Prosper Fajnzyn – Tous droits réservés</small>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const options = [
        "TDAH",
        "Autisme",
        "Trouble du Spectre Autistique",
        "Maladie chronique (diabète, endométriose...)",
        "Dyslexie",
        "Dyscalculie",
        "Dyspraxie",
        "Troubles anxieux",
        "Dépression",
        "Haut Potentiel Intellectuel (HPI)",
        "Autre",
    ];

    const selected = new Set();
    const tagSearch   = document.getElementById('tagSearch');
    const tagBox      = document.getElementById('tagBox');
    const tagDropdown = document.getElementById('tagDropdown');
    const tagEmpty    = document.getElementById('tagEmpty');
    const handicapsInput = document.getElementById('handicapsInput');

    // Build list
    options.forEach(opt => {
        const div = document.createElement('div');
        div.className = 'tag-option';
        div.dataset.value = opt;
        div.innerHTML = `<span>${opt}</span><div class="tag-check"></div>`;
        div.addEventListener('click', () => toggle(opt, div));
        tagDropdown.insertBefore(div, tagEmpty);
    });

    function toggle(value, el) {
        if (selected.has(value)) {
            selected.delete(value);
            el.classList.remove('selected');
            tagBox.querySelector(`.tag[data-value="${CSS.escape(value)}"]`)?.remove();
        } else {
            selected.add(value);
            el.classList.add('selected');
            addTag(value);
        }
        updateHiddenInput();
        tagSearch.focus();
    }

    function addTag(value) {
        const tag = document.createElement('span');
        tag.className = 'tag';
        tag.dataset.value = value;
        tag.innerHTML = `${value}<button type="button" class="tag-remove" title="Retirer">×</button>`;
        tag.querySelector('.tag-remove').addEventListener('click', e => {
            e.stopPropagation();
            selected.delete(value);
            tag.remove();
            tagDropdown.querySelector(`.tag-option[data-value="${CSS.escape(value)}"]`)?.classList.remove('selected');
            updateHiddenInput();
        });
        tagBox.insertBefore(tag, tagSearch);
    }

    function updateHiddenInput() {
        handicapsInput.value = Array.from(selected).join(',');
    }

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

    tagSearch.addEventListener('keydown', e => {
        if (e.key === 'Backspace' && tagSearch.value === '' && selected.size > 0) {
            const last = [...selected].pop();
            selected.delete(last);
            tagBox.querySelector(`.tag[data-value="${CSS.escape(last)}"]`)?.remove();
            tagDropdown.querySelector(`.tag-option[data-value="${CSS.escape(last)}"]`)?.classList.remove('selected');
            updateHiddenInput();
        }
    });

    // Preview image avant upload
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
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const handicapsFromDB = <?= json_encode($handicap_utilisateur) ?>;

        // Charger les handicaps existants au démarrage
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
</script>

</body>
</html>