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
    <link rel="stylesheet" href="../style/specialistes.css">
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
        <h1 class="fw-bold mb-3">Les Spécialistes</h1>
        <p class="text-muted">
            Sur cette page, nous proposons des professionels de santé prets a vous aider.        </p>
    </div>
</section>

<!-- test bouton filtre-->



<div class="dropdown">
    <div class="dropdown-btn"onclick="toggleDropdown()">
        <button type="button" class="btn btn-danger">Filtres ></button>

    </div>

    <div class="dropdown-content" id="dropdown">
        <label><input type="checkbox" value="psychologues">Psychologues</label>
        <label><input type="checkbox" value="conseillers-d-orientation">Conseillers d'orientation</label>
        <label><input type="checkbox" value="medecins">Médecins</label>
    </div>
</div>

<script>
    function toggleDropdown() {
        document.getElementById("dropdown").style.display =
            document.getElementById("dropdown").style.display === "block"
                ? "none"
                : "block";
    }
</script>



<!-- Medecins -->
<section class="bg-univoix py-5">
    <div class="container">
        <div class="row g-4 text-center">

            <!-- Medecin 1 -->
            <div class="col-md-4">
                <h5 class="section-title">Medecin 1</h5>
                <p>
                    Nom - Prenom - Spécialité
                </p>
                <a href="" class="btn btn-univoix">Prendre contact</a>
            </div>

            <!-- Medecin 2 -->
            <div class="col-md-4">
                <h5 class="section-title">Medecin 2</h5>
                <p>
                    Nom - Prenom - Spécialité
                </p>
                <a href="" class="btn btn-univoix">Prendre contact</a>
            </div>

            <!-- Medecin 3 -->
            <div class="col-md-4">
                <h5 class="section-title">Medecin 3</h5>
                <p>
                    Nom - Prenom - Spécialité
                </p>
                <a href="" class="btn btn-univoix">Prendre contact</a>
            </div>

            <!-- Medecin 4 -->

            <div class="col-md-4">
                <h5 class="section-title">Medecin 4</h5>
                <p>
                    Nom - Prenom - Spécialité
                </p>
                <a href="" class="btn btn-univoix">Prendre contact</a>
            </div>

            <!-- Medecin 5 -->

            <div class="col-md-4">
                <h5 class="section-title">Medecin 5</h5>
                <p>
                    Nom - Prenom - Spécialité
                </p>
                <a href="" class="btn btn-univoix">Prendre contact</a>
            </div>

            <!-- Medecin 6 -->

            <div class="col-md-4">
                <h5 class="section-title">Medecin 6</h5>
                <p>
                    Nom - Prenom - Spécialité
                </p>
                <a href="" class="btn btn-univoix">Prendre contact</a>
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