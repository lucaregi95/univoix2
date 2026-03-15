<?php
session_start();
require_once "../bdd/connexion.php";

if(isset($_POST['submit_btn'])){
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];
    $categorie = $_POST['categorie'];
    $date = date('Y-m-d');
    $ref_inscrit = $_SESSION['id'];

    if(empty($categorie)){
        $erreur = "Veuillez sélectionner au moins une catégorie";
    } else {
        $sql = "INSERT INTO sujet (titre, contenu, date_sujet, categorie_sujet, ref_inscrit) VALUES (:titre, :contenu, :date_sujet, :categorie_sujet, :ref_inscrit)";
        $query = $connexion->prepare($sql);
        $query->execute(array(
                "titre" => $titre,
                "contenu" => $contenu,
                "date_sujet" => $date,
                "categorie_sujet" => $categorie,
                "ref_inscrit" => $ref_inscrit
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
        'aucun' => [
            'danger'               => '#dc3545',
            'danger_rgb'           => '220,53,69',
            'danger_text_emphasis' => '#58151c',
            'danger_bg_subtle'     => '#f8d7da',
            'danger_border_subtle' => '#f1aeb5',
            'link'                 => '#0d6efd',
            'link_rgb'             => '13,110,253',
            'tag_bg'               => '#dc3545',
            'switch_on'            => '#dc3545',
        ],
        'deuteranopie' => [
            'danger'               => '#0055cc',
            'danger_rgb'           => '0,85,204',
            'danger_text_emphasis' => '#002a66',
            'danger_bg_subtle'     => '#cce0ff',
            'danger_border_subtle' => '#99c1ff',
            'link'                 => '#e07b00',
            'link_rgb'             => '224,123,0',
            'tag_bg'               => '#0055cc',
            'switch_on'            => '#0055cc',
        ],
        'tritanopie' => [
            'danger'               => '#cc3300',
            'danger_rgb'           => '204,51,0',
            'danger_text_emphasis' => '#661a00',
            'danger_bg_subtle'     => '#ffe5dd',
            'danger_border_subtle' => '#ffbba8',
            'link'                 => '#007a33',
            'link_rgb'             => '0,122,51',
            'tag_bg'               => '#cc3300',
            'switch_on'            => '#cc3300',
        ],
        'protanopie' => [
            'danger'               => '#6600cc',
            'danger_rgb'           => '102,0,204',
            'danger_text_emphasis' => '#330066',
            'danger_bg_subtle'     => '#ead5ff',
            'danger_border_subtle' => '#cc99ff',
            'link'                 => '#007acc',
            'link_rgb'             => '0,122,204',
            'tag_bg'               => '#6600cc',
            'switch_on'            => '#6600cc',
        ],
    ];
    $__p = isset($__palettes[$__daltonisme]) ? $__palettes[$__daltonisme] : $__palettes['aucun'];
    if ($__daltonisme !== 'aucun' || $__dyslexie): ?>
    <style id="accessibilite-overrides">
    <?php if ($__daltonisme !== 'aucun'): ?>

    :root {
        --bs-danger:                <?= $__p['danger'] ?>;
        --bs-danger-rgb:            <?= $__p['danger_rgb'] ?>;
        --bs-danger-text-emphasis:  <?= $__p['danger_text_emphasis'] ?>;
        --bs-danger-bg-subtle:      <?= $__p['danger_bg_subtle'] ?>;
        --bs-danger-border-subtle:  <?= $__p['danger_border_subtle'] ?>;
        --bs-link-color:            <?= $__p['link'] ?>;
        --bs-link-color-rgb:        <?= $__p['link_rgb'] ?>;
        --bs-link-hover-color:      <?= $__p['danger'] ?>;
    }




    .btn-danger:hover,
    .btn-danger:active,
    .btn-danger:focus-visible {
        background-color: <?= $__p['danger_text_emphasis'] ?> !important;
        border-color:     <?= $__p['danger_text_emphasis'] ?> !important;
    }
    .btn-danger:focus-visible {
        box-shadow: 0 0 0 0.25rem rgba(<?= $__p['danger_rgb'] ?>, 0.5) !important;
    }


    .btn-outline-danger:hover,
    .btn-outline-danger:active {
        background-color: <?= $__p['danger'] ?> !important;
        border-color:     <?= $__p['danger'] ?> !important;
        color: #fff !important;
    }
    .btn-outline-danger:focus-visible {
        box-shadow: 0 0 0 0.25rem rgba(<?= $__p['danger_rgb'] ?>, 0.5) !important;
    }


    .form-control:focus,
    .form-select:focus {
        border-color: <?= $__p['danger'] ?> !important;
        box-shadow: 0 0 0 0.25rem rgba(<?= $__p['danger_rgb'] ?>, 0.25) !important;
    }


    .bg-danger.bg-opacity-10 {
        background-color: rgba(<?= $__p['danger_rgb'] ?>, 0.1) !important;
    }



    .form-check-input.custom-switch:checked {
        background-color: <?= $__p['switch_on'] ?> !important;
        border-color:     <?= $__p['switch_on'] ?> !important;
    }


    .tag                          { background: <?= $__p['tag_bg'] ?> !important; }
    .tag-option.selected          { color: <?= $__p['danger'] ?> !important; }
    .tag-option:hover              { background: rgba(<?= $__p['danger_rgb'] ?>, 0.06) !important; }
    .tag-option.selected .tag-check {
        background:   <?= $__p['tag_bg'] ?> !important;
        border-color: <?= $__p['tag_bg'] ?> !important;
    }
    .tag-input-box:focus-within {
        border-color: <?= $__p['danger'] ?> !important;
        box-shadow: 0 0 0 3px rgba(<?= $__p['danger_rgb'] ?>, 0.15) !important;
    }
    .btn-help:hover {
        border-color: <?= $__p['danger'] ?> !important;
        color:        <?= $__p['danger'] ?> !important;
    }

    <?php endif;  ?>

    <?php if ($__dyslexie): ?>
    @font-face {
        font-family: 'OpenDyslexic';
        src: url('https://cdn.jsdelivr.net/npm/open-dyslexic@1.0.3/OpenDyslexic-Regular.otf') format('opentype');
        font-weight: normal;
    }
    @font-face {
        font-family: 'OpenDyslexic';
        src: url('https://cdn.jsdelivr.net/npm/open-dyslexic@1.0.3/OpenDyslexic-Bold.otf') format('opentype');
        font-weight: bold;
    }
    *, *::before, *::after      { font-family: 'OpenDyslexic', Arial, sans-serif !important; }
    body                         { line-height: 1.8 !important; letter-spacing: 0.05em !important; word-spacing: 0.15em !important; background-color: #fdfaf3 !important; }
    p, li, td, th, label, span, div, a, input, textarea, select, button
                                 { line-height: 1.8 !important; letter-spacing: 0.04em !important; word-spacing: 0.12em !important; }
    body, p, li, td, label       { font-size: 1.05rem !important; }
    .card, .form-control, .tag-input-box, .tag-dropdown { background-color: #fdfaf3 !important; }
    p, li, td, div               { text-align: left !important; }
    <?php endif;  ?>

    </style>
    <?php endif; ?>
    <?php
    if(session_status() === PHP_SESSION_NONE) session_start();
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
    .navbar                             { border-color: <?=$__p['p']?> !important; }
    .bg-danger, footer.bg-danger        { background-color: <?=$__p['p']?> !important; }
    .border-danger                      { border-color: <?=$__p['p']?> !important; }
    .text-danger                        { color: <?=$__p['p']?> !important; }
    .text-primary                       { color: <?=$__p['link']?> !important; }
    .btn-danger                         { background-color: <?=$__p['p']?> !important; border-color: <?=$__p['pd']?> !important; color: #fff !important; }
    .btn-danger:hover, .btn-danger:active { background-color: <?=$__p['pd']?> !important; border-color: <?=$__p['pd']?> !important; }
    .btn-outline-danger                 { border-color: <?=$__p['p']?> !important; color: <?=$__p['p']?> !important; }
    .btn-outline-danger:hover, .btn-outline-danger:active { background-color: <?=$__p['p']?> !important; color: #fff !important; }
    .alert-danger                       { background-color: <?=$__p['pl']?> !important; border-color: <?=$__p['p']?> !important; color: <?=$__p['pd']?> !important; }
    .card.border-danger                 { border-color: <?=$__p['p']?> !important; }
    .dropdown-item:active               { background-color: <?=$__p['p']?> !important; }
    a:not(.btn):not(.nav-link):not(.navbar-brand):not(.dropdown-item) { color: <?=$__p['link']?> !important; }
    <?php endif; ?>
    <?php if ($__dyslexie): ?>
    @font-face { font-family:'OpenDyslexic'; src:url('https://cdn.jsdelivr.net/npm/open-dyslexic@1.0.3/OpenDyslexic-Regular.otf') format('opentype'); font-weight:normal; }
    @font-face { font-family:'OpenDyslexic'; src:url('https://cdn.jsdelivr.net/npm/open-dyslexic@1.0.3/OpenDyslexic-Bold.otf') format('opentype'); font-weight:bold; }
    *, *::before, *::after              { font-family: 'OpenDyslexic', Arial, sans-serif !important; }
    body                                { line-height:1.8 !important; letter-spacing:0.05em !important; word-spacing:0.15em !important; background-color:#fdfaf3 !important; }
    p,li,td,th,label,span,div,a,input,textarea,select,button { line-height:1.8 !important; letter-spacing:0.04em !important; }
    body,p,li,td,label                  { font-size:1.05rem !important; }
    .card,.form-control,.tag-input-box,.tag-dropdown { background-color:#fdfaf3 !important; }
    p,li,td,div                         { text-align:left !important; }
    <?php endif; ?>
    </style>
    <?php endif; ?>

</head>

<body style="font-family:'Candara'" class="bg-light">

<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">
        <a href="acceuil.php"><img alt="" class="navbar-brand fw-bold" src="../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link" href="specialistes.php">Spécialistes</a>
        <a class="nav-link fw-bold text-danger" href="forum.php">Forum</a>
        <a class="nav-link" href="aides.php">Aides</a>
        <a class="nav-link" href="presentation.php">Handicaps</a>
        <?php if(isset($_SESSION['role'])){
            if ($_SESSION['role'] == 'admin'){
                ?>
                <a class="nav-link" href="admin/connexion_admin.php">Admin</a>
            <?php }} ?>

        <?php if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])){?>
            <a class="navbar-brand fw-bold" href="profil.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 20 20" >

                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                </svg>     Connexion</a>


        <?php }
        else{
            $avatar=null;
            require_once "avatar.php";?>
            <li class="nav-item dropdown fs-5" >
                <a class="nav-link dropdown-toggle" style="font-weight:bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img class="rounded-circle" alt="pdp" src="<?=$avatar?>" width="40px" height="40px"/>     <?=$_SESSION["prenom"]?> <?=$_SESSION["nom"]?></a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="profil.php">Profil</a></li>
                    <li><a class="dropdown-item" href="deconnexion.php">Se deconnecter</a></li>
                </ul>
            </li>


        <?php } ?>
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
                <input type="hidden" name="categorie" id="categorieInput">
                <div class="row g-4">

                    <!-- COLONNE GAUCHE -->
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

                    <!-- COLONNE DROITE -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold d-block text-center mb-3">Catégories du post</label>

                        <div class="d-flex gap-2 align-items-start mb-1">
                            <div class="tag-input-box flex-grow-1" id="tagBox" onclick="document.getElementById('tagSearch').focus()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#aaa" class="bi bi-search flex-shrink-0" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                </svg>
                                <input type="text" id="tagSearch" placeholder="Rechercher une catégorie...">
                            </div>
                            <button type="button" class="btn-help" title="Sélectionnez une ou plusieurs catégories" onclick="alert('Cliquez sur une catégorie dans la liste pour l\'ajouter. Cliquez à nouveau pour la retirer.')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                    <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286m1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94"/>
                                </svg>
                            </button>
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
    const options = [
        "Handicaps",
        "Isolement",
        "Ecole",
        "Aide",
        "Jeux",
        "Docs",
    ];

    const selected = new Set();
    const tagSearch      = document.getElementById('tagSearch');
    const tagBox         = document.getElementById('tagBox');
    const tagDropdown    = document.getElementById('tagDropdown');
    const tagEmpty       = document.getElementById('tagEmpty');
    const categorieInput = document.getElementById('categorieInput');

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
        categorieInput.value = [...selected].join(',');
        tagSearch.focus();
    }

    function addTag(value) {
        const tag = document.createElement('span');
        tag.className = 'tag';
        tag.dataset.value = value;
        tag.innerHTML = `${value}<button class="tag-remove" title="Retirer">×</button>`;
        tag.querySelector('.tag-remove').addEventListener('click', e => {
            e.stopPropagation();
            selected.delete(value);
            tag.remove();
            tagDropdown.querySelector(`.tag-option[data-value="${CSS.escape(value)}"]`)?.classList.remove('selected');
            categorieInput.value = [...selected].join(',');
        });
        tagBox.insertBefore(tag, tagSearch);
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
            categorieInput.value = [...selected].join(',');
        }
    });

    tagSearch.addEventListener('focus', () => { tagDropdown.style.display = 'block'; });
    document.addEventListener('click', e => {
        if (!tagBox.contains(e.target) && !tagDropdown.contains(e.target)) {
            tagDropdown.style.display = 'none';
        }
    });
</script>
</body>
</html>