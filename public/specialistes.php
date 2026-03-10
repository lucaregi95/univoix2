<?php
require_once "..\bdd\connexion.php";

$sql3 = "SELECT id_inscrit,nom,prenom,specialite FROM inscrit WHERE role='specialiste'";
$query3 = $connexion->prepare($sql3);
$query3->execute();
$result = $query3->fetchAll();

session_start();



?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Uni'Voix - Spécialistes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style/style_public/specialistes.css" rel="stylesheet">
</head>

<body style="font-family: 'Candara'">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">

        <a href="acceuil.php"><img alt="" class="navbar-brand fw-bold" src="../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link text-danger fw-bold" href="specialistes.php">Spécialistes</a>
        <a class="nav-link" href="forum.php">Forum</a>

        <a class="nav-link" href="aides.php">Aides</a>
        <a class="nav-link" href="presentation.php">Handicaps</a>
        <?php if(isset($_SESSION['role'])){
            if ($_SESSION['role'] == 'admin'){
                ?>
                <a class="nav-link" href="admin/connexion_admin.php">Admin</a>
            <?php }} ?>

        <?php if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])){?>
            <a class="navbar-brand fw-bold" href="profil.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 20 20" >

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
            <?php $compteur=1;

            foreach ($result as $resultat) {?>


            <div class="col-md-4">
                <div class="shadow pb-2">
                <h5 class="section-title">Specialiste <?=$compteur?></h5>
                    <?php
                    $avatar2=null;
                    $id=$resultat["id_inscrit"];
                    $avatar = "../img/avatar/".$id.".png";


                    if(!file_exists($avatar)) {
                    $avatar=$avatar2;
                    $avatar = $avatar."../img/avatar/".$id.".jpeg";

                    }

                    if(!file_exists($avatar)){
                    $avatar=$avatar2;
                    $avatar = $avatar."../img/avatar/".$id.".jpg";

                    }

                    if(!file_exists($avatar)){
                    $avatar=$avatar2;
                    $avatar = $avatar."../img/avatar/".$id.".gif";

                    }

                    if(!file_exists($avatar)){
                    $avatar=$avatar2;
                    $avatar = $avatar."../img/avatar/default.png";

                    }

                    ?>
                    <img alt="Photo - Specialiste ID <?=$resultat["id_inscrit"]?>" src="<?=$avatar?>" style="width: 150px;height: 150px;" class="border border-danger rounded">
                <p>
                    <?=$resultat["nom"]?> <?=$resultat["prenom"]?> - <?=$resultat["specialite"]?>
                </p>
                <a href="#" class="btn btn-danger">Prendre contact</a>
            </div>
            </div>
            <?php $compteur++;}?>

        </div>
    </div>
</section>
</div>
<div class="pt-4"></div>
<!-- FOOTER -->
<footer class="py-3 text-center bg-danger text-white ">
    © 2026 — Luca Regi, Nassim Kharfouche, Prosper Fajnzyn — Tous droits réservés
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>