<?php
require_once "../bdd/connexion.php";


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Uni'Voix - Creation Sujet</title>
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
<section class="bg-white py-5 text-center">
    <div class="container">
        <h1 class="fw-bold mb-3">Créer un nouveau sujet</h1>
    </div>
</section>
<div class="container d-flex justify-content-left">
        <form>
            <label>Titre du sujet :</label>
            <input type="text" name="titre" id="titre">

            <label>Description du post</label>
            <textarea name="contenu" id="contenu"></textarea>


        </form>
</div>