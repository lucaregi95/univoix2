<?php
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

    // Tri par date décroissante (plus récent en premier)
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
    <title>Uni'Voix - Acceuil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../../style/style_admin/acceuil_admin.css" rel="stylesheet">
</head>

<body style="font-family: 'Candara'">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">

        <a href="acceuil_admin.php"><img alt="" class="navbar-brand fw-bold" src="../../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link" href="inscrits.php">Inscrits</a>
        <a class="nav-link" href="signalements.php">Signalements</a>
        <a class="nav-link" href="articles.php">Articles</a>


        <?php if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])){?>
            <a class="navbar-brand fw-bold" href="profil.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 20 20" >

                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                </svg>     Connexion</a>


        <?php }
        else{
            $avatar="../";
            require_once "../avatar.php";?>
            <li class="nav-item dropdown fs-5" >
                <a class="nav-link dropdown-toggle" style="font-weight:bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img class="rounded-circle" alt="pdp" src="<?=$avatar?>" width="40px" height="40px"/>     <?=$_SESSION["prenom"]?> <?=$_SESSION["nom"]?> (admin)</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="../deconnexion.php">Se deconnecter</a></li>
                </ul>
            </li>


        <?php } ?>
    </div>
</nav>
<div class="container">
    <div class="border border-top-0 border-bottom-0 border-3 border-dark shadow-lg">
        <section class="bg-white py-5 text-center">


            <h1 class="fw-bold mb-3">Bienvenue dans votre espace d'administration des articles</h1>
            <p class="text-muted">
                Consultez les articles et ajoutez ceux que vous souhaitez à votre site.
            </p>


        </section>

<h1 class="container bg-danger text-white border border-dark">Articles récents</h1>





            <?php foreach ($articles as $article) { ?>
                <div class="container pb-3 shadow border" style="max-width: 820px;">
                    <br>
                    <div class="col-12">
                        <div class="pt-2">
                            <div class="card border border-danger border-3 shadow-sm rounded-4 h-100 transition hover-shadow">

                                <div class="card-body p-4 p-lg-5">
                                    <div class="aide-card">
                                        <h2><a href="<?php echo $article["link"]; ?>" target="_blank"><?php echo $article["title"]; ?></a></h2>
                                        <p><?php echo $article["description"]; ?></p>
                                        <small><?php echo $article["date"]; ?></small><br><br>
                                        <form class="bg-danger border border-dark justify-content-md">
                                            <button class="btn btn-danger">Ajouter au site</button>
                                            <button class="btn btn-danger">Supprimer de la liste</button>
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
</div>

</body>
</html>

