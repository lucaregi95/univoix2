<?php
require_once "..\bdd\connexion.php";
session_start();


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
    <a href="../style/style_public/acceuil.css" rel="stylesheet">

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
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#actualitesCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#actualitesCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#actualitesCarousel" data-bs-slide-to="2"></button>
        </div>

        <!-- Slides -->
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <div class="row align-items-center g-4">
                    <div class="col-md-5">
                        <img src="https://placehold.co/600x350/4a90e2/ffffff?text=Rencontre+21/06"
                             class="d-block w-100 carousel-image"
                             alt="Rencontre Uni'Voix">
                    </div>
                    <div class="col-md-7">
                        <div class="news-content">
                            <p>
                                Rendez-vous le <strong>21/06 à partir de 18h</strong> pour assister à la rencontre Uni'Voix
                                organisée dans la salle des fêtes du Bourget !
                            </p>
                            <p class="mb-0">
                                Accès via la ligne 8…
                                <a href="#" class="text-primary">Lire l'article complet</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <div class="row align-items-center g-4">
                    <div class="col-md-5">
                        <img src="../img/univoix.png"
                             class="d-block w-100 carousel-image"
                             alt="Atelier débat">
                    </div>
                    <div class="col-md-7">
                        <div class="news-content">
                            <p>
                                <strong>Nouvel atelier débat</strong> organisé chaque jeudi à 19h30 !
                                Venez partager vos idées et échanger sur des sujets d'actualité.
                            </p>
                            <p class="mb-0">
                                Inscription gratuite, places limitées…
                                <a href="#" class="text-primary">Lire l'article complet</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item">
                <div class="row align-items-center g-4">
                    <div class="col-md-5">
                        <img src="https://placehold.co/600x350/27ae60/ffffff?text=Projet+Etudiant"
                             class="d-block w-100 carousel-image"
                             alt="Projet étudiant">
                    </div>
                    <div class="col-md-7">
                        <div class="news-content">
                            <p>
                                <strong>Appel à projets 2026 :</strong> Soumettez vos initiatives étudiantes
                                avant le 15 mars pour bénéficier d'un accompagnement personnalisé.
                            </p>
                            <p class="mb-0">
                                Budget disponible, coaching inclus…
                                <a href="#" class="text-primary">Lire l'article complet</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
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