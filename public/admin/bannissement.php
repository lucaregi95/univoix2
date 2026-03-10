<?php
require_once "..\..\bdd\connexion.php";
session_start();
$id=$_POST['id'];
$sql = "SELECT nom,prenom,pseudo,email,importance_signalement,id_inscrit FROM inscrit WHERE id_inscrit = :id";
$query = $connexion->prepare($sql);
$query->execute(array('id' => $id));
$result = $query->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Uni'Voix - Bannir</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <a href="../../style/style_admin/bannissment.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>

        ul, li {
            list-style-type: none;
        }
        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            grid-template-rows: auto 1fr auto;
        }

    </style>
</head>

<body style="font-family: 'Candara'">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">

        <a href="acceuil_admin.php"><img alt="" class="navbar-brand fw-bold" src="../../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link fw-bold text-danger" href="inscrits.php">Inscrits</a>
        <a class="nav-link" href="signalements.php">Signalements</a>


        <?php if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])){?>
            <a class="navbar-brand fw-bold" href="connexion_admin.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 20 20" >

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
    <section class="bg-univoix py-5  bg-light">
        <div class="container">
            <a href="inscrits.php" class="btn btn-danger"><i><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
                    </svg></i> Retour</a>
            <div class="row g-4 text-center shadow-lg pb-3">
                <h2 style="font-weight: bold"> Voulez-vous vraiment bannir <?=$result["prenom"]?> <?=$result["nom"]?> ?</h2><br><br>
                <h4>Pseudo : <?=$result["pseudo"]?><br>Adresse E-mail : <?=$result["email"]?><br>Indice de Signalement : <?=$result["importance_signalement"]?></h4>
                <br><br><br>
                <form action="bannissement2.php" method="POST">
                    <button type="submit" class="btn btn-danger">Confirmer le bannissement</button>
                    <input type="hidden" value="<?=$id?>" name="id">
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