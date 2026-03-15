<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les handicaps invisibles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style/style_public/presentation2.css" rel="stylesheet">
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

<!-- NAVBAR -->
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

<!-- HEADER -->
<header class="bg-white py-5 border-bottom border-danger border-3">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Les handicaps invisibles</h1>
        <p class="lead text-muted col-lg-8 mx-auto">
            Des troubles souvent méconnus, mais bien réels, qui impactent profondément le quotidien.
        </p>
    </div>
</header>

<!-- CONTENT -->
<div class="container my-5">
    <div class="row g-4">

        <!-- DEPRESSION -->
        <div class="col-12">
            <div class="card border border-danger border-3 shadow-sm rounded-4 h-100 transition hover-shadow">
                <div class="card-body p-4 p-lg-5">
                    <h3 class="fw-bold text-danger mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-cloud-drizzle me-2" viewBox="0 0 16 16">
                            <path d="M4.158 12.025a.5.5 0 0 1 .316.633l-.5 1.5a.5.5 0 0 1-.948-.316l.5-1.5a.5.5 0 0 1 .632-.317m3 0a.5.5 0 0 1 .316.633l-1 3a.5.5 0 0 1-.948-.316l1-3a.5.5 0 0 1 .632-.317m3 0a.5.5 0 0 1 .316.633l-.5 1.5a.5.5 0 0 1-.948-.316l.5-1.5a.5.5 0 0 1 .632-.317m3 0a.5.5 0 0 1 .316.633l-1 3a.5.5 0 1 1-.948-.316l1-3a.5.5 0 0 1 .632-.317"/>
                            <path d="M13.405 4.027a5.001 5.001 0 0 0-9.499-1.004A3.5 3.5 0 1 0 3.5 10H13a3 3 0 0 0 .405-5.973M8.5 1a4 4 0 0 1 3.976 3.555.5.5 0 0 0 .5.445H13a2 2 0 0 1 0 4H3.5a2.5 2.5 0 1 1 .605-4.926.5.5 0 0 0 .596-.329A4 4 0 0 1 8.5 1"/>
                        </svg>
                        Dépression
                    </h3>
                    <p class="text-muted fs-6">
                        La dépression est caractérisée par une humeur dépressive persistante, une perte d'intérêt ou de plaisir pour les activités habituellement agréables (anhédonie), et une altération significative du fonctionnement quotidien.
                    </p>
                </div>
            </div>
        </div>

        <!-- Trouble anxieux -->
        <div class="col-12">
            <div class="card border border-danger border-3 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 p-lg-5">
                    <h3 class="fw-bold text-danger mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-exclamation-triangle me-2" viewBox="0 0 16 16">
                            <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
                            <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
                        </svg>
                        Troubles anxieux
                    </h3>
                    <p class="text-muted fs-6">
                        Les troubles anxieux sont des conditions psychiques caractérisées par une anxiété ou une peur excessive, persistante et déraisonnable face à des situations qui ne représentent pas un danger réel.
                    </p>
                </div>
            </div>
        </div>

        <!-- HPI -->
        <div class="col-12">
            <div class="card border border-danger border-3 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 p-lg-5">
                    <h3 class="fw-bold text-danger mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-lightbulb me-2" viewBox="0 0 16 16">
                            <path d="M2 6a6 6 0 1 1 10.174 4.31c-.203.196-.359.4-.453.619l-.762 1.769A.5.5 0 0 1 10.5 13a.5.5 0 0 1 0 1 .5.5 0 0 1 0 1l-.224.447a1 1 0 0 1-.894.553H6.618a1 1 0 0 1-.894-.553L5.5 15a.5.5 0 0 1 0-1 .5.5 0 0 1 0-1 .5.5 0 0 1-.46-.302l-.761-1.77a2 2 0 0 0-.453-.618A5.98 5.98 0 0 1 2 6m6-5a5 5 0 0 0-3.479 8.592c.263.254.514.564.676.941L5.83 12h4.342l.632-1.467c.162-.377.413-.687.676-.941A5 5 0 0 0 8 1"/>
                        </svg>
                        Haut Potentiel Intellectuel (HPI)
                    </h3>
                    <p class="text-muted fs-6">
                        Le Haut Potentiel Intellectuel (HPI) désigne une capacité cognitive supérieure à la moyenne, généralement définie par un quotient intellectuel (QI) égal ou supérieur à 130, soit deux écarts-types au-dessus de la moyenne.
                    </p>
                </div>
            </div>
        </div>

        <!-- TMS -->
        <div class="col-12">
            <div class="card border border-danger border-3 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 p-lg-5">
                    <h3 class="fw-bold text-danger mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-bandaid me-2" viewBox="0 0 16 16">
                            <path d="M14.121 1.879a3 3 0 0 0-4.242 0L8.733 3.025l4.261 4.26 1.127-1.165a3 3 0 0 0 0-4.242M12.293 8.3 8.027 4.03 1.025 11.03a3 3 0 1 0 4.243 4.243l7.025-7.025zm-4.06 1.06a.5.5 0 1 1-.707-.708.5.5 0 0 1 .707.708m.646-1.646a.5.5 0 1 1-.707-.708.5.5 0 0 1 .707.708m-2.293 2.293a.5.5 0 1 1-.707-.708.5.5 0 0 1 .707.708M5.232 6.586a.5.5 0 1 1-.707-.708.5.5 0 0 1 .707.708"/>
                        </svg>
                        Troubles Musculo-Squelettiques (TMS)
                    </h3>
                    <p class="text-muted fs-6">
                        Les Troubles Musculo-Squelettiques (TMS) désignent un ensemble de pathologies affectant les muscles, les tendons, les articulations, les nerfs, les ligaments, les bourses séreuses ou les cartilages, principalement liées à des contraintes physiques ou organisationnelles du travail.
                    </p>
                </div>
            </div>
        </div>

    </div>

    <!-- BOUTON SUIVANT -->
    <div class="d-flex justify-content-start mt-4">
        <a href="presentation.php" class="btn btn-danger btn-lg">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
            </svg>
            Précédent
        </a>
    </div>
</div>

<!-- FOOTER -->
<footer class="bg-danger text-white py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <p class="mb-2 fw-semibold">Univoix - Ensemble pour l'inclusion</p>
                <small class="opacity-75">
                    © 2026 – Luca Regi, Nassim Kharfouche, Prosper Fajnzyn – Tous droits réservés
                </small>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>