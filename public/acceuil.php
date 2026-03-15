<?php
require_once "..\bdd\connexion.php";
session_start();

function loadRss($url) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // ignore le certificat SSL
    $data = curl_exec($ch);
    curl_close($ch);

    return simplexml_load_string($data);
}

function getArticles() {
    $feeds = [
        "https://www.lemonde.fr/handicap/rss_full.xml",
        "https://www.lemonde.fr/universites/rss_full.xml",
        "https://www.lemonde.fr/orientation-scolaire/rss_full.xml",
    ];

    $articles = [];

    foreach ($feeds as $feed) {
        // Extraire le tag depuis l'URL
        preg_match('/lemonde\.fr\/([^\/]+)\/rss/', $feed, $matches);
        $tag = isset($matches[1]) ? $matches[1] : '';

        $rss = loadRss($feed);
        if ($rss) {
            foreach ($rss->channel->item as $item) {
                $articles[] = [
                    "title"       => (string)$item->title,
                    "link"        => (string)$item->link,
                    "description" => (string)$item->description,
                    "date"        => (string)$item->pubDate,
                    "category"    => $tag
                ];
            }
        }
    }

    // Tri par date décroissante (plus récent en premier)
    usort($articles, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    return $articles;
}


$articles = getArticles();
?>
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Uni'Voix - Acceuil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../style/style_public/acceuil.css" rel="stylesheet">
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
    <?php endif;
    ?>

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

<body style="font-family: 'Candara'">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">

        <a href="acceuil.php"><img alt="" class="navbar-brand fw-bold" src="../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link" href="specialistes.php">Spécialistes</a>
        <a class="nav-link" href="forum.php">Forum</a>

        <a class="nav-link" href="aides.php">Aides</a>
        <a class="nav-link" href="presentation.php">Handicaps</a>
        <?php if(isset($_SESSION['role'])){
            if ($_SESSION['role'] == 'admin'){
        ?>
            <a class="nav-link" href="admin/connexion_admin.php">Admin</a>
        <?php }} ?>

        <?php if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])){?>
        <a class="navbar-brand fw-bold" href="connexion.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 20 20" >

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
<!-- HERO -->
<div class="container">
<div class="border border-top-0 border-bottom-0 border-3 border-dark shadow-lg">
<section class="bg-white py-5 text-center">


        <h1 class="fw-bold mb-3">Bienvenue chez Uni'Voix</h1>
        <p class="text-muted">
            Nous proposons une entraide pour les étudiants,
            afin de faire entendre sa voix et trouver sa voie.
        </p>


</section>
</div>
</div>
<!-- 3 BLOCS -->
<section class="bg-univoix py-5 bg-danger shadow rounded-2">
    <div class="container">
        <div class="row text-center text-white">

            <!-- FORUM -->
            <div class="col-md-4 border border-1 border-right-0 border-light p-2">
                <h5 class="section-title">LE FORUM</h5>
                <p>
                    Le forum est un endroit de partage et de soutien,
                    où les étudiants peuvent parler librement.
                </p>
                <a href="forum.php" class="btn btn-outline-light btn-univoix">Accéder au forum</a>
            </div>

            <!-- SPECIALISTES -->
            <div class="col-md-4 border border-1 border-light p-2">
                <h5 class="section-title">LES SPÉCIALISTES</h5>
                <p>
                    Vous pouvez converser avec différents médecins,
                    conseillers d’orientation, psychologues…
                </p>
                <a href="specialistes.php" class="btn btn-outline-light btn-univoix">Parler aux spécialistes</a>
            </div>

            <!-- AIDES -->
            <div class="col-md-4 border border-1 border-light border-left-0 p-2">
                <h5 class="section-title">LES AIDES</h5>
                <p>
                    Retrouvez les informations importantes à propos des
                    démarches d’aides et de subventions pour étudiants.
                </p>
                <a href="aides.php" class="btn btn-outline-light btn-univoix">Consulter les aides</a>
            </div>

        </div>
    </div>
</section>

<!-- ACTUALITÉS -->

<div class="container">
    <div class="border border-top-0 border-bottom-0 border-3 border-dark shadow-lg">
<section class="py-5">
    <h4 class="fw-bold mb-4 mx-3">LES ACTUALITÉS by Uni'Voix :</h4>

    <div id="actualitesCarousel" class="carousel slide mx-3" data-bs-ride="carousel">
        <!-- Indicateurs -->


        <!-- Slides -->
        <div class="carousel-inner">
            <?php if (empty($articles)) { ?>
                <div class="carousel-item active">
                    <p class="text-muted text-center">Aucun article disponible pour le moment.</p>
                </div>
            <?php } ?>
            <?php foreach ($articles as $index => $article) {
                $titrePlaceholder1 = str_replace(' ', '+', htmlspecialchars($article['category']));
                $titrePlaceholder = str_replace('-', '+', $titrePlaceholder1);
                $titrePlaceholder = ucfirst($titrePlaceholder);
                ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <div class="row align-items-center g-4">
                        <div class="col-md-5">
                            <img src="https://placehold.co/600x350/cc0000/ffffff?text=<?= $titrePlaceholder ?>"
                                 class="d-block w-100 carousel-image"
                                 alt="<?= htmlspecialchars($article['title']) ?>">
                            
                        </div>
                        <div class="col-md-7">
                            <div class="news-content mx-3">
                                <h5 class="fw-bold"><?= htmlspecialchars($article['title']) ?></h5>
                                <p><?= htmlspecialchars($article['description']) ?></p>
                                <small class="text-muted"><?= htmlspecialchars($article['date']) ?></small>
                                <br><br>
                                <a href="<?= htmlspecialchars($article['link']) ?>" target="_blank" class="text-primary">
                                    Lire l'article complet
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <!-- Contrôles -->
        <button class="carousel-control-prev" type="button" data-bs-target="#actualitesCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#actualitesCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Suivant</span>
        </button>
    </div>

</section>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    window.onclick = function(e) {
        if (!e.target.matches('.dropbtn')) {
            var myDropdown = document.getElementById("myDropdown");
            if (myDropdown.classList.contains('show')) {
                myDropdown.classList.remove('show');
            }
        }
    }
</script>

<!-- FOOTER -->
<footer class="py-3 text-center bg-danger text-white">
    © 2026 — Luca Regi, Nassim Kharfouche, Prosper Fajnzyn — Tous droits réservés
</footer>

</body>
</html>