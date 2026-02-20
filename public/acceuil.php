<?php
require_once "../bdd/connexion.php";


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Uni'Voix - Acceuil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="font-family: 'Candara'">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">

        <a href="acceuil.php"> <img alt="" class="navbar-brand fw-bold" src="../img/univoix2.png" style="max-width:50px;"></a>
        <a class="nav-link" href="specialistes.php">Spécialistes</a>
        <a class="nav-link" href="forum.php">Forum</a>
        <a class="nav-link" href="aides.php">Aides</a>
        <a class="nav-link" href="">Numéros</a>
        <a class="navbar-brand fw-bold" href="">Uni'voix</a>

    </div>
</nav>
<!-- HERO -->
<section class="bg-white py-5 text-center">
    <div class="container">
        <h1 class="fw-bold mb-3">Bienvenue chez Uni'Voix</h1>
        <p class="text-muted">
            Nous proposons une entraide pour les étudiants,
            afin de faire entendre sa voix et trouver sa voie.
        </p>
    </div>
</section>

<!-- 3 BLOCS -->
<section class="bg-univoix py-5">
    <div class="container">
        <div class="row g-4 text-center">

            <!-- FORUM -->
            <div class="col-md-4">
                <h5 class="section-title">LE FORUM</h5>
                <p>
                    Le forum est un endroit de partage et de soutien,
                    où les étudiants peuvent parler librement.
                </p>
                <a href="forum.php" class="btn btn-univoix">Accéder au forum</a>
            </div>

            <!-- SPECIALISTES -->
            <div class="col-md-4">
                <h5 class="section-title">LES SPÉCIALISTES</h5>
                <p>
                    Vous pouvez converser avec différents médecins,
                    conseillers d’orientation, psychologues…
                </p>
                <a href="specialistes.php" class="btn btn-univoix">Parler aux spécialistes</a>
            </div>

            <!-- AIDES -->
            <div class="col-md-4">
                <h5 class="section-title">LES AIDES</h5>
                <p>
                    Retrouvez les informations importantes à propos des
                    démarches d’aides et de subventions pour étudiants.
                </p>
                <a href="aides.php" class="btn btn-univoix">Consulter les aides</a>
            </div>

        </div>
    </div>
</section>

<!-- ACTUALITÉS -->
<section class="py-5">
    <div class="container">
        <h4 class="fw-bold mb-4">LES ACTUALITÉS by Uni'Voix :</h4>

        <div class="row align-items-center g-4">
            <div class="col-md-5">
                <div class="news-placeholder">
                    Image / visuel actu
                </div>
            </div>

            <div class="col-md-7">
                <p>
                    Rendez-vous le <strong>21/06 à partir de 18h</strong> pour assister à la rencontre Uni'Voix
                    organisée dans la salle des fêtes du Bourget !
                </p>
                <p class="mb-0">
                    Accès via la ligne 8…
                    <a href="#">Lire l’article complet</a>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="py-3 text-center">
    © 2026 — Luca Regi, Nassim Kharfouche, Prosper Fajnzyn — Tous droits réservés
</footer>

</body>
</html>