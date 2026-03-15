<?php
$bdd = null;
require_once('../bdd/connexion.php');

$nom=null;
$prenom=null;
$email=null;
if(isset($_POST['email'])){
    $email=$_POST['email'];
}
$erreur=null;
$inscription=null;
if(isset($_GET['erreur'])){
    if ($_GET['erreur']=='unknown'){
        $erreur="Identifiants inexistants ou incorrects";
    }

}

if(isset($_GET['page'])){
    $page=$_GET['page'];

}
$inscription="Pas de compte ? Inscrivez-vous";
?>
<!DOCTYPE html>

<html lang=fr>
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="../style/style_public/connexion.css" rel="stylesheet">
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



    form-check-input.custom-switch:checked {
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

<body class="bg-light" style="font-family:'Candara'">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">
        <a href="acceuil.php"><img alt="" class="navbar-brand fw-bold" src="../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link" href="specialistes.php">Spécialistes</a>
        <a class="nav-link" href="forum.php">Forum</a>
        <a class="nav-link" href="aides.php">Aides</a>
        <a class="nav-link" href="presentation.php">Handicaps</a>
        <a class="navbar-brand fw-bold text-danger" href="profil.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 20 20">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
            </svg> Connexion
        </a>
    </div>
</nav>
<div class="container mt-3 mb-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-5 fw-bold text-dark"><i class="bi bi-book-fill text-success"></i>Connectez-vous à votre compte Uni'Voix</h1>
    </div>

    <div class="card border-0 shadow-lg">
        <div class="card-body p-0">
            <div class="table-responsive">
                <form class="container mt-3" method="POST" action="connexion2.php">
                    <label for="email">Adresse e-mail :</label><br>
                    <input type="email" id="email" name="email" value="<?=$email?>" autocomplete="off" required><br><br>

                    <label for="mdp">Mot de Passe :</label><br>
                    <input type="password" id="mdp" name="mdp" autocomplete="off" required><br>

                    <?php if (isset($page)) {?>
                    <input type="hidden" value="<?=$page?>" name="page">
                    <?php } ?>
                    <h6 class="text-danger pt-3 pb-3"><?=$erreur?></h6>

                    <button type="submit" class="btn btn-danger">Connectez-vous !</button><br><br>
                </form>
                <div class="mb-3">
                    <a class="container" href="inscription.php"><?=$inscription?></a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

