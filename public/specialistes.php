<?php
require_once "..\bdd\connexion.php";


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Uni'Voix - Spécialistes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="font-family: 'Candara'">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">

        <a href="acceuil.php"><img alt="" class="navbar-brand fw-bold" src="../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link" href="specialistes.php">Spécialistes</a>
        <a class="nav-link" href="#">Forum</a>
        <a class="nav-link" href="#">Aides</a>
        <a class="nav-link" href="presentation.php">Handicaps</a>
        <a class="navbar-brand fw-bold" href="profil.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 20 20" >
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
            </svg>     John Doe</a>

    </div>
</nav>
<!-- HERO -->
<section class="bg-white py-5 text-center">
    <div class="container">
        <h1 class="fw-bold mb-3">Les Spécialistes</h1>
        <p class="text-muted">
            Sur cette page, nous proposons une discussion avec des professionels de santé, des psychologues et des conseillers d'orientation prets a vous aider.        </p>
    </div>
</section>

<!-- test bouton filtre-->
<div class="container shadow-lg pb-2 bg-danger ">
    <div class="p-2">
<a href="#" class="btn btn-outline-dark text-white">Filtres ></a>
    </div>

<!-- Medecins -->
<section class="bg-univoix py-5 bg-light ">
    <div class="container">
        <div class="row g-4 text-center">

            <!-- Medecin 1 -->
            <div class="col-md-4">
                <div class="shadow pb-2">
                <h5 class="section-title">Medecin 1</h5>
                <img alt="Photo - Médecin 1" src="../img/univoix.png" style="max-width: 50%;height: auto" class="border border-danger rounded">
                <p>
                    Nom - Prenom - Spécialité
                </p>
                <a href="#" class="btn btn-danger">Prendre contact</a>
            </div>
            </div>

            <!-- Medecin 2 -->
            <div class="col-md-4">
                <div class="shadow pb-2">
                <h5 class="section-title">Medecin 2</h5>
                    <img alt="Photo - Médecin 2" src="../img/univoix.png" style="max-width: 50%;height: auto" class="border border-danger rounded">
                <p>
                    Nom - Prenom - Spécialité
                </p>
                <a href="#" class="btn btn-danger">Prendre contact</a>
            </div>
            </div>

            <!-- Medecin 3 -->
            <div class="col-md-4">
                <div class="shadow pb-2">
                <h5 class="section-title">Medecin 3</h5>
                <img alt="Photo - Médecin 3" src="../img/univoix.png" style="max-width: 50%;height: auto" class="border border-danger rounded">
                <p>
                    Nom - Prenom - Spécialité
                </p>
                <a href="#" class="btn btn-danger">Prendre contact</a>
            </div></div>

            <!-- Medecin 4 -->

            <div class="col-md-4">
                <div class="shadow pb-2">
                    <h5 class="section-title">Medecin 4</h5>
                    <img alt="Photo - Médecin 4" src="../img/univoix.png" style="max-width: 50%;height: auto" class="border border-danger rounded">
                    <p>
                        Nom - Prenom - Spécialité
                    </p>
                    <a href="#" class="btn btn-danger">Prendre contact</a>
                </div></div>

            <!-- Medecin 5 -->

            <div class="col-md-4">
                <div class="shadow pb-2">
                    <h5 class="section-title">Medecin 5</h5>
                    <img alt="Photo - Médecin 5" src="../img/univoix.png" style="max-width: 50%;height: auto" class="border border-danger rounded">
                    <p>
                        Nom - Prenom - Spécialité
                    </p>
                    <a href="#" class="btn btn-danger">Prendre contact</a>
                </div></div>

            <!-- Medecin 6 -->

            <div class="col-md-4">
                <div class="shadow pb-2">
                    <h5 class="section-title">Medecin 6</h5>
                    <img alt="Photo - Médecin 2" src="../img/univoix.png" style="max-width: 50%;height: auto" class="border border-danger rounded">
                    <p>
                        Nom - Prenom - Spécialité
                    </p>
                    <a href="#" class="btn btn-danger">Prendre contact</a>
                </div></div>
            <div class="col-md-4">
                <div class="shadow pb-2">
                    <h5 class="section-title">Medecin 7</h5>
                    <img alt="Photo - Médecin 2" src="../img/univoix.png" style="max-width: 50%;height: auto" class="border border-danger rounded">
                    <p>
                        Nom - Prenom - Spécialité
                    </p>
                    <a href="#" class="btn btn-danger">Prendre contact</a>
                </div></div>
        </div>
    </div>
</section>
</div>
<div class="pt-4"></div>
<!-- FOOTER -->
<footer class="py-3 text-center bg-danger text-white ">
    © 2026 — Luca Regi, Nassim Kharfouche, Prosper Fajnzyn — Tous droits réservés
</footer>

</body>
</html>