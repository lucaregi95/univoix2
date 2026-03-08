
<?php
require_once "..\..\bdd\connexion.php";
session_start();
if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    header("location:../connexion.php");
    exit();
}

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
    <style>
        ul, li {
            list-style-type: none;
        }
        body {
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .site-content {
            flex: 1;
        }
    </style>
</head>

<body style="font-family: 'Candara'">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">

        <a href="acceuil_admin.php"><img alt="" class="navbar-brand fw-bold" src="../../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link" href="inscrits.php">Inscrits</a>
        <a class="nav-link" href="signalements.php">Signalements</a>


        <?php if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])){?>
        <a class="navbar-brand fw-bold" href="profil.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 20 20" >

                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
            </svg>     Connexion</a>


        <?php }
        else{ ?>
            <li class="nav-item dropdown fs-5" >
                <a class="nav-link dropdown-toggle" style="font-weight:bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img class="rounded-circle" alt="pdp" src="../../img/avatar/<?=$_SESSION["id"]?>.jpg" width="40px" height="40px"/>     <?=$_SESSION["prenom"]?> <?=$_SESSION["nom"]?> (admin) </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="../deconnexion.php">Se deconnecter</a></li>
                </ul>
            </li>


        <?php } ?>
    </div>
</nav>
<!-- HERO -->
<div class="container">
<div class="border border-top-0 border-bottom-0 border-3 border-dark shadow-lg">
<section class="bg-white py-5 text-center">


        <h1 class="fw-bold mb-3">Bienvenue dans votre espace d'administration Uni'Voix</h1>
        <p class="text-muted">
            Accedez à tout l'espace administrateur pour gerer les inscrits, les articles etc...
        </p>


</section>
</div>
</div>
<!-- 3 BLOCS -->
<main class="site-content">
<section class="bg-univoix py-5 bg-danger shadow rounded-2">
    <div class="container">
        <div class="row text-center text-white">

            <!-- FORUM -->
            <div class="col-md-4 border border-1 border-right-0 border-light p-2">
                <h5 class="section-title">LES INSCRITS</h5>
                <p>
                    Accedez à la liste des inscrits afin de les gerer, les moderer...
                </p>
                <a href="inscrits.php" class="btn btn-outline-light btn-univoix">Accéder à la liste des inscrits</a>
            </div>

            <!-- SPECIALISTES -->
            <div class="col-md-4 border border-1 border-light p-2">
                <h5 class="section-title">LES SIGNALEMENTS</h5>
                <p>
                    Regardez les differents signalements faits par la communauté Uni'Voix et moderez le site
                </p>
                <a href="specialistes.php" class="btn btn-outline-light btn-univoix">Consulter les signalements</a>
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
    <div class="container">
        <div class="border border-top-0 border-bottom-0 border-3 border-dark shadow-lg">
            <section class="bg-white py-5 text-center">
            </section>
        </div>
    </div>
</main>

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
<footer class="py-3 text-center bg-danger text-white site-footer">
    © 2026 — Luca Regi, Nassim Kharfouche, Prosper Fajnzyn — Tous droits réservés
</footer>

</body>
</html>
