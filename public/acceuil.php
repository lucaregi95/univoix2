<?php
require_once "..\bdd\connexion.php";
session_start();

// Charge un flux RSS depuis une URL via cURL et le retourne en objet SimpleXML
function loadRss($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    // Retourne le contenu au lieu de l'afficher directement
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($ch);
    curl_close($ch);
    // Convertit la chaîne XML en objet PHP navigable
    return simplexml_load_string($data);
}

// Récupère et fusionne les articles de plusieurs flux RSS du Monde
function getArticles() {
    $feeds = [
            "https://www.lemonde.fr/handicap/rss_full.xml",
            "https://www.lemonde.fr/universites/rss_full.xml",
            "https://www.lemonde.fr/orientation-scolaire/rss_full.xml",
    ];

    $articles = [];

    foreach ($feeds as $feed) {
        // Extrait le nom de la rubrique depuis l'URL (ex: "handicap", "universites")
        preg_match('/lemonde\.fr\/([^\/]+)\/rss/', $feed, $matches);
        $tag = isset($matches[1]) ? $matches[1] : '';

        $rss = loadRss($feed);
        if ($rss) {
            // Parcourt chaque article du flux et le stocke dans $articles
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

    // strtotime convertit les dates textuelles en timestamp pour pouvoir les comparer
    // La soustraction donne un résultat négatif/positif utilisé par usort pour trier du plus récent au plus ancien
    usort($articles, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    return $articles;
}

$articles = getArticles();


$sql = "SELECT * FROM article";
$query = $connexion->prepare($sql);
$query->execute();
$resultats = $query->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Uni'Voix - Acceuil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../style/style_public/acceuil.css" rel="stylesheet">
    <?php
    // Récupère les préférences d'accessibilité depuis la session (défaut si absent)
    $daltonisme = isset($_SESSION['daltonisme']) ? $_SESSION['daltonisme'] : 'aucun';
    $dyslexie   = isset($_SESSION['dyslexie']) ? $_SESSION['dyslexie']   : false;

    // Palettes de couleurs alternatives selon le type de daltonisme
    // Chaque type remplace le rouge Bootstrap (#dc3545) par une couleur perceptible
    $palettes = [
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

    // Sélectionne la palette correspondant au daltonisme de l'utilisateur, 'aucun' par défaut
    $p = isset($palettes[$daltonisme]) ? $palettes[$daltonisme] : $palettes['aucun'];

    // Injecte un bloc <style> uniquement si l'utilisateur a une préférence d'accessibilité
    if ($daltonisme !== 'aucun' || $dyslexie): ?>
        <style id="accessibilite-overrides">
            <?php if ($daltonisme !== 'aucun'): ?>
            /* Surcharge les variables CSS Bootstrap avec les couleurs de la palette choisie */
            :root {
                --bs-danger:                <?= $p['danger'] ?>;
                --bs-danger-rgb:            <?= $p['danger_rgb'] ?>;
                --bs-danger-text-emphasis:  <?= $p['danger_text_emphasis'] ?>;
                --bs-danger-bg-subtle:      <?= $p['danger_bg_subtle'] ?>;
                --bs-danger-border-subtle:  <?= $p['danger_border_subtle'] ?>;
                --bs-link-color:            <?= $p['link'] ?>;
                --bs-link-color-rgb:        <?= $p['link_rgb'] ?>;
                --bs-link-hover-color:      <?= $p['danger'] ?>;
            }

            .btn-danger:hover,
            .btn-danger:active,
            .btn-danger:focus-visible {
                background-color: <?= $p['danger_text_emphasis'] ?> !important;
                border-color:     <?= $p['danger_text_emphasis'] ?> !important;
            }
            .btn-danger:focus-visible {
                box-shadow: 0 0 0 0.25rem rgba(<?= $p['danger_rgb'] ?>, 0.5) !important;
            }

            .btn-outline-danger:hover,
            .btn-outline-danger:active {
                background-color: <?= $p['danger'] ?> !important;
                border-color:     <?= $p['danger'] ?> !important;
                color: #fff !important;
            }
            .btn-outline-danger:focus-visible {
                box-shadow: 0 0 0 0.25rem rgba(<?= $p['danger_rgb'] ?>, 0.5) !important;
            }

            .form-control:focus,
            .form-select:focus {
                border-color: <?= $p['danger'] ?> !important;
                box-shadow: 0 0 0 0.25rem rgba(<?= $p['danger_rgb'] ?>, 0.25) !important;
            }

            .bg-danger.bg-opacity-10 {
                background-color: rgba(<?= $p['danger_rgb'] ?>, 0.1) !important;
            }

            .form-check-input.custom-switch:checked {
                background-color: <?= $p['switch_on'] ?> !important;
                border-color:     <?= $p['switch_on'] ?> !important;
            }

            .tag                          { background: <?= $p['tag_bg'] ?> !important; }
            .tag-option.selected          { color: <?= $p['danger'] ?> !important; }
            .tag-option:hover              { background: rgba(<?= $p['danger_rgb'] ?>, 0.06) !important; }
            .tag-option.selected .tag-check {
                background:   <?= $p['tag_bg'] ?> !important;
                border-color: <?= $p['tag_bg'] ?> !important;
            }
            .tag-input-box:focus-within {
                border-color: <?= $p['danger'] ?> !important;
                box-shadow: 0 0 0 3px rgba(<?= $p['danger_rgb'] ?>, 0.15) !important;
            }
            .btn-help:hover {
                border-color: <?= $p['danger'] ?> !important;
                color:        <?= $p['danger'] ?> !important;
            }
            <?php endif; ?>

            <?php if ($dyslexie): ?>
            /* @font-face : importe la police OpenDyslexic depuis un CDN et l'applique à toute la page */
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
            /* Applique la police dyslexique et améliore l'espacement sur tous les éléments */
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

    // Deuxième bloc de palette : variables CSS personnalisées (--color-primary-*)
    // pour les composants du site qui n'utilisent pas les variables Bootstrap
    if(session_status() === PHP_SESSION_NONE) session_start();
    $daltonisme = isset($_SESSION['daltonisme']) ? $_SESSION['daltonisme'] : 'aucun';
    $dyslexie   = isset($_SESSION['dyslexie'])   ? $_SESSION['dyslexie']   : false;
    $palettes = [
            'aucun'        => ['p'=>'#dc3545','pd'=>'#b02a37','pl'=>'#f8d7da','rgb'=>'220,53,69', 'link'=>'#0d6efd','footer'=>'#dc3545'],
            'deuteranopie' => ['p'=>'#0055cc','pd'=>'#003d99','pl'=>'#cce0ff','rgb'=>'0,85,204',  'link'=>'#e07b00','footer'=>'#0055cc'],
            'tritanopie'   => ['p'=>'#cc3300','pd'=>'#992200','pl'=>'#ffe5dd','rgb'=>'204,51,0',  'link'=>'#007a33','footer'=>'#cc3300'],
            'protanopie'   => ['p'=>'#6600cc','pd'=>'#4d0099','pl'=>'#ead5ff','rgb'=>'102,0,204', 'link'=>'#007acc','footer'=>'#6600cc'],
    ];
    $p = isset($palettes[$daltonisme]) ? $palettes[$daltonisme] : $palettes['aucun'];
    if ($daltonisme !== 'aucun' || $dyslexie): ?>
        <style id="accessibilite-overrides">
            <?php if ($daltonisme !== 'aucun'): ?>

            :root {
                --color-primary:           <?=$p['p']?>;
                --color-primary-dark:      <?=$p['pd']?>;
                --color-primary-light:     <?=$p['pl']?>;
                --color-primary-shadow-15: rgba(<?=$p['rgb']?>,.15);
                --color-primary-shadow-25: rgba(<?=$p['rgb']?>,.25);
                --color-primary-shadow-35: rgba(<?=$p['rgb']?>,.35);
            }

            .navbar                             { border-color: <?=$p['p']?> !important; }
            .bg-danger, footer.bg-danger        { background-color: <?=$p['p']?> !important; }
            .border-danger                      { border-color: <?=$p['p']?> !important; }
            .text-danger                        { color: <?=$p['p']?> !important; }
            .text-primary                       { color: <?=$p['link']?> !important; }
            .btn-danger                         { background-color: <?=$p['p']?> !important; border-color: <?=$p['pd']?> !important; color: #fff !important; }
            .btn-danger:hover, .btn-danger:active { background-color: <?=$p['pd']?> !important; border-color: <?=$p['pd']?> !important; }
            .btn-outline-danger                 { border-color: <?=$p['p']?> !important; color: <?=$p['p']?> !important; }
            .btn-outline-danger:hover, .btn-outline-danger:active { background-color: <?=$p['p']?> !important; color: #fff !important; }
            .alert-danger                       { background-color: <?=$p['pl']?> !important; border-color: <?=$p['p']?> !important; color: <?=$p['pd']?> !important; }
            .card.border-danger                 { border-color: <?=$p['p']?> !important; }
            .dropdown-item:active               { background-color: <?=$p['p']?> !important; }
            /* Cible tous les liens sauf les boutons, nav-links, brand et items de dropdown */
            a:not(.btn):not(.nav-link):not(.navbar-brand):not(.dropdown-item) { color: <?=$p['link']?> !important; }
            <?php endif; ?>
            <?php if ($dyslexie): ?>
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
            // Utilisateur connecté : charge l'avatar et affiche son nom dans un menu déroulant
            $avatar=null;
            require_once "avatar.php";?>
            <li class="nav-item dropdown fs-5" >
                <a class="nav-link dropdown-toggle" style="font-weight:bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img class="rounded-circle" alt="pdp" src="<?=$avatar?>" width="40px" height="40px"/>     <?=$_SESSION["prenom"]?> <?=$_SESSION["nom"]?></a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="profil.php">Profil</a></li>
                    <li><a class="dropdown-item" href="deconnexion.php">Se déconnecter</a></li>
                </ul>
            </li>
        <?php } ?>
    </div>
</nav>

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

<section class="bg-univoix py-5 bg-danger shadow rounded-2">
    <div class="container">
        <div class="row text-center text-white">
            <div class="col-md-4 border border-1 border-right-0 border-light p-2">
                <h5 class="section-title">LE FORUM</h5>
                <p>
                    Le forum est un endroit de partage et de soutien,
                    où les étudiants peuvent parler librement.
                </p>
                <a href="forum.php" class="btn btn-outline-light btn-univoix">Accéder au forum</a>
            </div>
            <div class="col-md-4 border border-1 border-light p-2">
                <h5 class="section-title">LES SPÉCIALISTES</h5>
                <p>
                    Vous pouvez converser avec différents médecins,
                    conseillers d'orientation, psychologues…
                </p>
                <a href="specialistes.php" class="btn btn-outline-light btn-univoix">Parler aux spécialistes</a>
            </div>
            <div class="col-md-4 border border-1 border-light border-left-0 p-2">
                <h5 class="section-title">LES AIDES</h5>
                <p>
                    Retrouvez les informations importantes à propos des
                    démarches d'aides et de subventions pour étudiants.
                </p>
                <a href="aides.php" class="btn btn-outline-light btn-univoix">Consulter les aides</a>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <div class="border border-top-0 border-bottom-0 border-3 border-dark shadow-lg">
        <section class="py-5">
            <h4 class="fw-bold mb-4 mx-3">LES ACTUALITÉS by Uni'Voix :</h4>

            <div id="actualitesCarousel" class="carousel slide mx-3" data-bs-ride="carousel" data-bs-interval="10000">
                <div class="carousel-inner">
                    <?php if (empty($articles)) { ?>
                        <div class="carousel-item active">
                            <p class="text-muted text-center">Aucun article disponible pour le moment.</p>
                        </div>
                    <?php } ?>
                    <?php foreach ($articles as $index => $article) {
                        // Formate la catégorie pour l'URL de l'image placeholder (espaces et tirets → "+", première lettre en maj)
                        $titrePlaceholder1 = str_replace(' ', '+', htmlspecialchars($article['category']));
                        $titrePlaceholder = str_replace('-', '+', $titrePlaceholder1);
                        $titrePlaceholder = ucfirst($titrePlaceholder);
                        ?>
                        <!-- Le premier article reçoit la classe "active" pour que le carousel démarre dessus -->
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <div class="row align-items-center g-4">
                                <div class="col-md-5">
                                    <img src="https://placehold.co/600x350/dc3545/ffffff?text=<?= $titrePlaceholder ?>"
                                         class="d-block w-100 carousel-image"
                                         alt="<?= htmlspecialchars($article['title']) ?>">
                                </div>
                                <div class="col-md-7">
                                    <div class="news-content mx-3">
                                        <!-- htmlspecialchars protège contre les injections XSS dans les données RSS -->
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

                <button class="carousel-control-prev" type="button" data-bs-target="#actualitesCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Précédent</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#actualitesCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Suivant</span>
                </button>
            </div><br><br><br>
            <div class="mx-auto text-center">
                <button type="button" class="btn btn-danger position-relative"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapseExample">
                    Plus d'informations condensées
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="position-absolute top-100 start-50 translate-middle mt-1 bi bi-caret-down-fill" fill="#dc3545" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                    </svg>
                </button><br><br>
                <div class="collapse" id="collapseExample">
                    <div class="container">
                        <div class="shadow-lg">
                            <section class="py-5">
                                <h4 class="fw-bold mb-4 mx-3">L'actualité Condensée :</h4>
                                <div id="actualitesCarousel2" class="carousel slide mx-3" data-bs-ride="carousel" data-bs-interval="10000">
                                    <div class="carousel-inner">
                                        <?php if (empty($resultats)) { ?>
                                            <div class="carousel-item active">
                                                <p class="text-muted text-center">Aucun article disponible pour le moment.</p>
                                            </div>
                                        <?php } ?>
                                        <?php foreach ($resultats as $index => $resultat) {
                                            $titrePlaceholder1 = str_replace(' ', '+', htmlspecialchars($resultat['category']));
                                            $titrePlaceholder = str_replace('-', '+', $titrePlaceholder1);
                                            $titrePlaceholder = ucfirst($titrePlaceholder);
                                            ?>
                                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                                <div class="row align-items-center g-4">
                                                    <div class="col-md-5">
                                                        <img src="https://placehold.co/600x350/dc3545/ffffff?text=<?= $titrePlaceholder ?>"
                                                             class="d-block w-100 carousel-image"
                                                             alt="<?= htmlspecialchars($resultat['titre']) ?>">
                                                    </div>
                                                    <div class="col-md-7">
                                                        <div class="news-content mx-3">
                                                            <h5 class="fw-bold"><?= htmlspecialchars($resultat['titre']) ?></h5>
                                                            <p><?= htmlspecialchars($resultat['description']) ?></p>
                                                            <small class="text-muted"><?= htmlspecialchars($resultat['date']) ?></small>
                                                            <br><br>
                                                            <a href="<?= htmlspecialchars($resultat['lien']) ?>" target="_blank" class="text-primary">
                                                                Lire l'article complet
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#actualitesCarousel2" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Précédent</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#actualitesCarousel2" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Suivant</span>
                                    </button>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Affiche ou masque le menu déroulant personnalisé
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Ferme le dropdown si l'utilisateur clique en dehors du bouton qui l'ouvre
    window.onclick = function(e) {
        if (!e.target.matches('.dropbtn')) {
            var myDropdown = document.getElementById("myDropdown");
            if (myDropdown.classList.contains('show')) {
                myDropdown.classList.remove('show');
            }
        }
    }
</script>

<footer class="py-3 text-center bg-danger text-white">
    © 2026 — Luca Regi, Nassim Kharfouche, Prosper Fajnzyn — Tous droits réservés
</footer>

</body>
</html>