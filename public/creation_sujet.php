<?php
session_start();
require_once "../bdd/connexion.php";

if(isset($_POST['submit_btn'])){
    $titre     = $_POST['titre'];
    $contenu   = $_POST['contenu'];
    $categorie = $_POST['categorie'];
    $date      = date('Y-m-d');
    $ref_inscrit = $_SESSION['id'];

    if(empty($categorie)){
        $erreur = "Veuillez sélectionner au moins une catégorie";
    } else {
        // Insère le nouveau sujet en BDD
        $sql = "INSERT INTO sujet (titre, contenu, date_sujet, categorie_sujet, ref_inscrit) VALUES (:titre, :contenu, :date_sujet, :categorie_sujet, :ref_inscrit)";
        $query = $connexion->prepare($sql);
        $query->execute(array(
                "titre"           => $titre,
                "contenu"         => $contenu,
                "date_sujet"      => $date,
                "categorie_sujet" => $categorie,
                "ref_inscrit"     => $ref_inscrit
        ));
        header('Location: forum.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniVoix - Création d'un sujet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style/style_public/creation_sujet.css" rel="stylesheet">
    <?php
    $__daltonisme = isset($_SESSION['daltonisme']) ? $_SESSION['daltonisme'] : 'aucun';
    $__dyslexie   = isset($_SESSION['dyslexie'])   ? $_SESSION['dyslexie']   : false;

    $__palettes = [
            'aucun'        => ['p'=>'#dc3545','pd'=>'#b02a37','pl'=>'#f8d7da','rgb'=>'220,53,69', 'link'=>'#0d6efd','footer'=>'#dc3545'],
            'deuteranopie' => ['p'=>'#0055cc','pd'=>'#003d99','pl'=>'#cce0ff','rgb'=>'0,85,204',  'link'=>'#e07b00','footer'=>'#0055cc'],
            'tritanopie'   => ['p'=>'#cc3300','pd'=>'#992200','pl'=>'#ffe5dd','rgb'=>'204,51,0',  'link'=>'#007a33','footer'=>'#cc3300'],
            'protanopie'   => ['p'=>'#6600cc','pd'=>'#4d0099','pl'=>'#ead5ff','rgb'=>'102,0,204', 'link'=>'#007acc','footer'=>'#6600cc'],
    ];
    $__p = isset($__palettes[$__daltonisme]) ? $__palettes[$__daltonisme] : $__palettes['aucun'];
    if ($__daltonisme !== 'aucun' || $__dyslexie): ?>
        <style id="accessibilite-overrides">
            <?php if ($__daltonisme !== 'aucun'): ?>
            :root {
                --color-primary:           <?=$__p['p']?>;
                --color-primary-dark:      <?=$__p['pd']?>;
                --color-primary-light:     <?=$__p['pl']?>;
                --color-primary-shadow-15: rgba(<?=$__p['rgb']?>,.15);
                --color-primary-shadow-25: rgba(<?=$__p['rgb']?>,.25);
                --color-primary-shadow-35: rgba(<?=$__p['rgb']?>,.35);
            }
            .bg-danger, footer.bg-danger { background-color: <?=$__p['p']?> !important; }
            .text-danger { color: <?=$__p['p']?> !important; }
            .btn-danger  { background-color: <?=$__p['p']?> !important; border-color: <?=$__p['pd']?> !important; color: #fff !important; }
            .btn-danger:hover { background-color: <?=$__p['pd']?> !important; }
            a:not(.btn):not(.nav-link):not(.navbar-brand):not(.dropdown-item) { color: <?=$__p['link']?> !important; }
            <?php endif; ?>
            <?php if ($__dyslexie): ?>
            @font-face { font-family:'OpenDyslexic'; src:url('https://cdn.jsdelivr.net/npm/open-dyslexic@1.0.3/OpenDyslexic-Regular.otf') format('opentype'); font-weight:normal; }
            @font-face { font-family:'OpenDyslexic'; src:url('https://cdn.jsdelivr.net/npm/open-dyslexic@1.0.3/OpenDyslexic-Bold.otf') format('opentype'); font-weight:bold; }
            *, *::before, *::after { font-family: 'OpenDyslexic', Arial, sans-serif !important; }
            body { line-height:1.8 !important; letter-spacing:0.05em !important; word-spacing:0.15em !important; background-color:#fdfaf3 !important; }
            body,p,li,td,label { font-size:1.05rem !important; }
            <?php endif; ?>
        </style>
    <?php endif; ?>
</head>

<body style="font-family:'Candara'">

<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">
        <a href="acceuil.php"><img alt="" class="navbar-brand fw-bold" src="../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link" href="specialistes.php">Spécialistes</a>
        <a class="nav-link fw-bold text-danger" href="forum.php">Forum</a>
        <a class="nav-link" href="aides.php">Aides</a>
        <a class="nav-link" href="presentation.php">Handicaps</a>
        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){ ?>
            <a class="nav-link" href="admin/connexion_admin.php">Admin</a>
        <?php } ?>
        <?php
        $avatar = null;
        require_once "avatar.php"; ?>
        <li class="nav-item dropdown fs-5">
            <a class="nav-link dropdown-toggle" style="font-weight:bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="rounded-circle" alt="pdp" src="<?=$avatar?>" width="40px" height="40px"/>
                <?=$_SESSION["prenom"]?> <?=$_SESSION["nom"]?>
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="profil.php">Profil</a></li>
                <li><a class="dropdown-item" href="deconnexion.php">Se déconnecter</a></li>
            </ul>
        </li>
    </div>
</nav>

<div class="container my-5">
    <div class="card border border-danger border-3 shadow-sm">
        <div class="card-body p-5">
            <h2 class="fw-bold mb-4 text-center">Créer un nouveau sujet</h2>

            <?php if(isset($erreur)) { ?>
                <div class="alert alert-danger"><?= $erreur ?></div>
            <?php } ?>

            <form action="creation_sujet.php" method="post">
                <!-- Champ caché recevant les catégories sélectionnées en CSV via le JS -->
                <input type="hidden" name="categorie" id="categorieInput">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-4 gap-3">
                            <label class="form-label fw-semibold mb-0 text-nowrap">Titre du sujet :</label>
                            <input type="text" name="titre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Contenu du poste :</label>
                            <textarea name="contenu" class="form-control" rows="6" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold d-block text-center mb-3">Catégories du post</label>
                        <div class="d-flex gap-2 align-items-start mb-1">
                            <div class="tag-input-box flex-grow-1" id="tagBox" onclick="document.getElementById('tagSearch').focus()">
                                <input type="text" id="tagSearch" placeholder="Rechercher une catégorie...">
                            </div>
                        </div>
                        <div class="tag-dropdown" id="tagDropdown">
                            <div class="tag-empty" id="tagEmpty">Aucun résultat</div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" name="submit_btn" class="btn btn-danger btn-lg border border-dark px-5 py-2">Créer le post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<footer class="bg-danger text-white py-4 mt-5">
    <div class="container text-center">
        <small class="opacity-75">© 2026 – Luca Regi, Nassim Kharfouche, Prosper Fajnzyn – Tous droits réservés</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Liste fixe des catégories disponibles pour un sujet
    const options = ["Handicaps", "Isolement", "Ecole", "Aide", "Jeux", "Docs"];

    const selected      = new Set();
    const tagSearch     = document.getElementById('tagSearch');
    const tagBox        = document.getElementById('tagBox');
    const tagDropdown   = document.getElementById('tagDropdown');
    const tagEmpty      = document.getElementById('tagEmpty');
    const categorieInput = document.getElementById('categorieInput');

    // Génère dynamiquement les options de la liste de catégories
    options.forEach(opt => {
        const div = document.createElement('div');
        div.className     = 'tag-option';
        div.dataset.value = opt;
        div.innerHTML     = `<span>${opt}</span><div class="tag-check"></div>`;
        div.addEventListener('click', () => toggle(opt, div));
        tagDropdown.insertBefore(div, tagEmpty);
    });

    // Ajoute ou retire une catégorie du Set et met à jour le champ caché
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
        // [...selected].join(',') : convertit le Set en tableau puis en chaîne CSV
        categorieInput.value = [...selected].join(',');
        tagSearch.focus();
    }

    function addTag(value) {
        const tag = document.createElement('span');
        tag.className     = 'tag';
        tag.dataset.value = value;
        tag.innerHTML     = `${value}<button class="tag-remove" title="Retirer">×</button>`;
        tag.querySelector('.tag-remove').addEventListener('click', e => {
            e.stopPropagation();
            selected.delete(value);
            tag.remove();
            tagDropdown.querySelector(`.tag-option[data-value="${CSS.escape(value)}"]`)?.classList.remove('selected');
            categorieInput.value = [...selected].join(',');
        });
        tagBox.insertBefore(tag, tagSearch);
    }

    // Filtre les options selon la frappe de l'utilisateur
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

    // Supprime la dernière catégorie avec Backspace si le champ est vide
    tagSearch.addEventListener('keydown', e => {
        if (e.key === 'Backspace' && tagSearch.value === '' && selected.size > 0) {
            const last = [...selected].pop();
            selected.delete(last);
            tagBox.querySelector(`.tag[data-value="${CSS.escape(last)}"]`)?.remove();
            tagDropdown.querySelector(`.tag-option[data-value="${CSS.escape(last)}"]`)?.classList.remove('selected');
            categorieInput.value = [...selected].join(',');
        }
    });

    // Affiche le dropdown au focus et le ferme au clic extérieur
    tagSearch.addEventListener('focus', () => { tagDropdown.style.display = 'block'; });
    document.addEventListener('click', e => {
        if (!tagBox.contains(e.target) && !tagDropdown.contains(e.target)) {
            tagDropdown.style.display = 'none';
        }
    });
</script>
</body>
</html>