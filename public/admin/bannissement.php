<?php
require_once "..\..\bdd\connexion.php";
session_start();

// Récupère l'ID de l'inscrit à bannir depuis le formulaire de la page inscrits.php
$id_inscrit = $_POST['id'];

// Récupère les informations de l'inscrit pour les afficher sur la page de confirmation
$sql = "SELECT nom,prenom,pseudo,email,importance_signalement,id_inscrit FROM inscrit WHERE id_inscrit = :id";
$query = $connexion->prepare($sql);
$query->execute(array('id' => $id_inscrit));
$result = $query->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Uni'Voix - Bannir</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../style/style_admin/bannissment.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="font-family: 'Candara'">

<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">
        <a href="acceuil_admin.php"><img alt="" class="navbar-brand fw-bold" src="../../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link fw-bold text-danger" href="inscrits.php">Inscrits</a>
        <a class="nav-link" href="signalements.php">Signalements</a>
        <?php if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])){ ?>
            <a class="navbar-brand fw-bold" href="connexion_admin.php">Connexion</a>
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

<section class="bg-univoix py-5 bg-light">
    <div class="container">
        <a href="inscrits.php" class="btn btn-danger">Retour</a>
        <div class="row g-4 text-center shadow-lg pb-3">
            <!-- Affiche les informations de l'utilisateur ciblé pour permettre à l'admin de confirmer -->
            <h2 style="font-weight: bold"> Voulez-vous vraiment bannir <?=$result["prenom"]?> <?=$result["nom"]?> ?</h2>
            <h4>Pseudo : <?=$result["pseudo"]?><br>Adresse E-mail : <?=$result["email"]?><br>Indice de Signalement : <?=$result["importance_signalement"]?></h4>
            <form action="bannissement2.php" method="POST">
                <button type="submit" class="btn btn-danger">Confirmer le bannissement</button>
                <!-- Transmet l'ID de l'inscrit à bannir vers bannissement2.php -->
                <input type="hidden" value="<?=$id_inscrit?>" name="id">
            </form>
        </div>
    </div>
</section>

<footer class="py-3 text-center bg-danger text-white site-footer">
    © 2026 — Luca Regi, Nassim Kharfouche, Prosper Fajnzyn — Tous droits réservés
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>