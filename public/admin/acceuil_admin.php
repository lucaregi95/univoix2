<?php
require_once "..\..\bdd\connexion.php";
session_start();

// Redirige vers la connexion publique si l'admin n'est pas connecté
if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    header("location:../connexion.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Uni'Voix - Accueil Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../../style/style_admin/acceuil_admin.css" rel="stylesheet">
    <?php
    $__daltonisme = isset($_SESSION['daltonisme']) ? $_SESSION['daltonisme'] : 'aucun';
    $__dyslexie   = isset($_SESSION['dyslexie'])   ? $_SESSION['dyslexie']   : false;

    // Palettes de couleurs selon le type de daltonisme de l'admin connecté
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
            .navbar { border-color: <?=$__p['p']?> !important; }
            .bg-danger, footer.bg-danger { background-color: <?=$__p['p']?> !important; }
            .text-danger { color: <?=$__p['p']?> !important; }
            .btn-danger { background-color: <?=$__p['p']?> !important; border-color: <?=$__p['pd']?> !important; color: #fff !important; }
            .btn-danger:hover, .btn-danger:active { background-color: <?=$__p['pd']?> !important; }
            .btn-outline-danger { border-color: <?=$__p['p']?> !important; color: <?=$__p['p']?> !important; }
            .btn-outline-danger:hover { background-color: <?=$__p['p']?> !important; color: #fff !important; }
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

<body style="font-family: 'Candara'">

<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">
        <a href="acceuil_admin.php"><img alt="" class="navbar-brand fw-bold" src="../../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link" href="inscrits.php">Inscrits</a>
        <a class="nav-link" href="signalements.php">Signalements</a>
        <a class="nav-link" href="articles.php">Articles</a>
        <a class="nav-link" href="forum_admin.php">Forum</a>
        <?php if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])){ ?>
            <a class="navbar-brand fw-bold" href="profil.php">Connexion</a>
        <?php } else {
            // Préfixe "../" car avatar.php est dans le dossier public, un niveau au-dessus de admin/
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
            <h1 class="fw-bold mb-3">Bienvenue dans votre espace d'administration Uni'Voix</h1>
            <p class="text-muted">Accédez à tout l'espace administrateur pour gérer les inscrits, les articles etc...</p>
        </section>
    </div>
</div>

<main class="site-content">
    <section class="bg-univoix py-5 bg-danger shadow rounded-2">
        <div class="container">
            <div class="row text-center text-white">
                <div class="col-md-3 border border-1 border-right-0 border-light p-2">
                    <h5 class="section-title">LES INSCRITS</h5>
                    <p>Accédez à la liste des inscrits afin de les gérer, les modérer...</p>
                    <a href="inscrits.php" class="btn btn-outline-light btn-univoix">Accéder à la liste des inscrits</a>
                </div>
                <div class="col-md-3 border border-1 border-light border-left-0 p-2">
                    <h5 class="section-title">LES ARTICLES</h5>
                    <p>Retrouvez les articles à ajouter ou à supprimer du site</p>
                    <a href="articles.php" class="btn btn-outline-light btn-univoix">Consulter les articles</a>
                </div>
                <div class="col-md-3 border border-1 border-light p-2">
                    <h5 class="section-title">LES SIGNALEMENTS</h5>
                    <p>Regardez les différents signalements faits par la communauté Uni'Voix et modérez le site</p>
                    <a href="specialistes.php" class="btn btn-outline-light btn-univoix">Consulter les signalements</a>
                </div>
                <div class="col-md-3 border border-1 border-light p-2">
                    <h5 class="section-title">LE FORUM</h5>
                    <p>Gérez les sujets a supprimer du forum</p>
                    <a href="forum_admin.php" class="btn btn-outline-light btn-univoix">Consulter le forum</a>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Affiche/masque le menu déroulant personnalisé
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Ferme le dropdown si l'utilisateur clique en dehors du bouton
    window.onclick = function(e) {
        if (!e.target.matches('.dropbtn')) {
            var myDropdown = document.getElementById("myDropdown");
            if (myDropdown.classList.contains('show')) {
                myDropdown.classList.remove('show');
            }
        }
    }
</script>
<br>
<footer class="py-3 text-center bg-danger text-white site-footer">
    © 2026 — Luca Regi, Nassim Kharfouche, Prosper Fajnzyn — Tous droits réservés
</footer>

</body>
</html>