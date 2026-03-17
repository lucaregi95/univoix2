<?php
// Démarre la session pour accéder aux préférences d'accessibilité et aux données utilisateur
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniVoix - Handicaps</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style/style_public/presentation.css" rel="stylesheet">
    <?php
    // Récupère les préférences d'accessibilité de la session
    $__daltonisme = isset($_SESSION['daltonisme']) ? $_SESSION['daltonisme'] : 'aucun';
    $__dyslexie   = isset($_SESSION['dyslexie'])   ? $_SESSION['dyslexie']   : false;

    // Palettes de couleurs adaptées aux différents types de daltonisme
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

    // Injecte le CSS d'accessibilité uniquement si une option est activée
    if ($__daltonisme !== 'aucun' || $__dyslexie): ?>
        <style id="accessibilite-overrides">
            <?php if ($__daltonisme !== 'aucun'): ?>
            /* Surcharge les variables Bootstrap avec la palette du daltonisme actif */
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
            <?php endif; ?>
            <?php if ($__dyslexie): ?>
            /* Charge la police OpenDyslexic et améliore l'espacement sur toute la page */
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
            <?php endif; ?>
        </style>
    <?php endif; ?>
    <?php
    // Deuxième bloc : variables CSS personnalisées (--color-primary-*) pour les composants du site
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
            /* Cible tous les liens sauf boutons et éléments de navigation */
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
        <a class="nav-link" href="forum.php">Forum</a>
        <a class="nav-link" href="aides.php">Aides</a>
        <a class="nav-link fw-bold text-danger" href="presentation.php">Handicaps</a>
        <?php if(isset($_SESSION['role'])){
            if ($_SESSION['role'] == 'admin'){
                ?>
                <a class="nav-link" href="admin/connexion_admin.php">Admin</a>
            <?php }} ?>

        <?php if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])){ ?>
            <a class="navbar-brand fw-bold" href="profil.php">Connexion</a>
        <?php }
        else{
            // Charge l'avatar de l'utilisateur connecté
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
        <?php } ?>
    </div>
</nav>

<header class="bg-white py-5 border-bottom border-danger border-3">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Les handicaps invisibles</h1>
        <p class="lead text-muted col-lg-8 mx-auto">
            Des troubles souvent méconnus, mais bien réels, qui impactent profondément le quotidien.
        </p>
    </div>
</header>

<!-- Contenu statique : présentation de 4 types de handicaps invisibles (page 1 sur 2) -->
<div class="container my-5">
    <div class="row g-4">

        <div class="col-12">
            <div class="card border border-danger border-3 shadow-sm rounded-4 h-100 transition hover-shadow">
                <div class="card-body p-4 p-lg-5">
                    <h3 class="fw-bold text-danger mb-3">TDAH</h3>
                    <p class="text-muted fs-6">
                        TDAH (Trouble du Déficit de l'Attention avec ou sans Hyperactivité) est un trouble du neurodéveloppement qui se manifeste par des difficultés persistantes à maintenir l'attention, une hyperactivité motrice et/ou une impulsivité inappropriée à l'âge de la personne.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border border-danger border-3 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 p-lg-5">
                    <h3 class="fw-bold text-danger mb-3">Autisme</h3>
                    <p class="text-muted fs-6">
                        Les troubles du spectre de l'autisme regroupent des profils variés, souvent invisibles, impactant la communication et les interactions sociales. Chaque personne autiste a des besoins et des forces uniques qui méritent d'être reconnues et respectées.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border border-danger border-3 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 p-lg-5">
                    <h3 class="fw-bold text-danger mb-3">Troubles chroniques</h3>
                    <p class="text-muted fs-6">
                        Douleurs, fatigue ou maladies de longue durée peuvent être invisibles, mais elles nécessitent compréhension et aménagements adaptés. Les personnes concernées font face quotidiennement à des défis que leur entourage ne peut pas toujours percevoir.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border border-danger border-3 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 p-lg-5">
                    <h3 class="fw-bold text-danger mb-3">Troubles Dys</h3>
                    <p class="text-muted fs-6">
                        Les troubles "dys" (dyslexie, dyspraxie, dyscalculie, dysorthographie) affectent l'apprentissage et le traitement de l'information. Ces troubles ne reflètent en aucun cas l'intelligence, mais nécessitent des adaptations pédagogiques et une approche bienveillante.
                    </p>
                </div>
            </div>
        </div>

    </div>

    <!-- Lien vers la deuxième page de présentation -->
    <div class="d-flex justify-content-end mt-4">
        <a href="presentation2.php" class="btn btn-danger btn-lg">Suivant</a>
    </div>
</div>

<footer class="bg-danger text-white py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <p class="mb-2 fw-semibold">Univoix - Ensemble pour l'inclusion</p>
                <small class="opacity-75">© 2026 – Luca Regi, Nassim Kharfouche, Prosper Fajnzyn – Tous droits réservés</small>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>