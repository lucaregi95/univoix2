<?php
session_start();

// Charge un flux RSS via cURL et le retourne en objet SimpleXML
function loadRss($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    // Retourne le résultat au lieu de l'afficher directement
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
        $rss = loadRss($feed);
        if ($rss) {
            foreach ($rss->channel->item as $item) {
                $articles[] = [
                        "title"       => (string)$item->title,
                        "link"        => (string)$item->link,
                        "description" => (string)$item->description,
                        "date"        => (string)$item->pubDate
                ];
            }
        }
    }

    // strtotime convertit les dates textuelles en timestamp pour les comparer
    usort($articles, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    return $articles;
}

$articles = getArticles();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Uni'Voix - Articles Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../style/style_admin/acceuil_admin.css" rel="stylesheet">
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
                --color-primary:      <?=$__p['p']?>;
                --color-primary-dark: <?=$__p['pd']?>;
            }
            .bg-danger { background-color: <?=$__p['p']?> !important; }
            .btn-danger { background-color: <?=$__p['p']?> !important; border-color: <?=$__p['pd']?> !important; }
            .btn-danger:hover { background-color: <?=$__p['pd']?> !important; }
            <?php endif; ?>
            <?php if ($__dyslexie): ?>
            @font-face { font-family:'OpenDyslexic'; src:url('https://cdn.jsdelivr.net/npm/open-dyslexic@1.0.3/OpenDyslexic-Regular.otf') format('opentype'); font-weight:normal; }
            *, *::before, *::after { font-family: 'OpenDyslexic', Arial, sans-serif !important; }
            body { line-height:1.8 !important; letter-spacing:0.05em !important; background-color:#fdfaf3 !important; }
            body,p,li,td,label { font-size:1.05rem !important; }
            <?php endif; ?>
        </style>
    <?php endif; ?>
</head>

<body style="font-family: 'Candara'">

<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">
        <a href="acceuil_admin.php"><img alt="" class="navbar-brand fw-bold" src="../../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link" href="inscrits.php">Inscrits</a>
        <a class="nav-link" href="signalements.php">Signalements</a>
        <a class="nav-link fw-bold text-danger" href="articles.php">Articles</a>
        <a class="nav-link" href="forum_admin.php">Forum</a>
        <?php if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])){ ?>
            <a class="navbar-brand fw-bold" href="profil.php">Connexion</a>
        <?php } else {
            $avatar = "../";
            require_once "../avatar.php"; ?>
            <li class="nav-item dropdown fs-5">
                <a class="nav-link dropdown-toggle" style="font-weight:bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="rounded-circle" alt="pdp" src="<?=$avatar?>" width="40px" height="40px"/>
                    <?=$_SESSION["prenom"]?> <?=$_SESSION["nom"]?> (admin)
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="../deconnexion.php">Se déconnecter</a></li>
                </ul>
            </li>
        <?php } ?>
    </div>
</nav>

<div class="container">
    <div class="border border-top-0 border-bottom-0 border-3 border-dark shadow-lg">
        <section class="bg-white py-5 text-center">
            <h1 class="fw-bold mb-3">Bienvenue dans votre espace d'administration des articles</h1>
            <p class="text-muted">Consultez les articles et ajoutez ceux que vous souhaitez à votre site.</p>
        </section>

        <h1 class="container bg-danger text-white border border-dark">Articles récents</h1>

        <?php foreach ($articles as $article) { ?>
            <div class="container pb-3 shadow border" style="max-width: 820px;">
                <br>
                <div class="col-12">
                    <div class="pt-2">
                        <div class="card border border-danger border-3 shadow-sm rounded-4 h-100">
                            <div class="card-body p-4 p-lg-5">
                                <div class="aide-card">
                                    <h2><a href="<?php echo $article["link"]; ?>" target="_blank"><?php echo $article["title"]; ?></a></h2>
                                    <p><?php echo $article["description"]; ?></p>
                                    <small><?php echo $article["date"]; ?></small><br><br>
                                    <!-- Formulaire pour ajouter l'article au site via articles2.php -->
                                    <form class="bg-danger border border-dark justify-content-md" method="post" action="articles2.php">
                                        <button class="btn btn-danger">Ajouter au site</button>
                                        <input type="hidden" value="<?php $article["description"] ?>">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>