<?php
$connexion = null;
require_once('../../bdd/connexion.php');
session_start();
if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    header("location:../connexion.php");
    exit();
}

if(!isset($_POST["recherche"])){
    $recherche='%';
}else{
    $recherche='%'.$_POST["recherche"].'%';
}
$sql = "SELECT nom,prenom,pseudo,email,role,importance_signalement,id_inscrit FROM inscrit WHERE (nom LIKE :recherche OR prenom LIKE :recherche OR pseudo LIKE :recherche OR role LIKE :recherche) AND role != 'admin' AND mot_de_passe NOT LIKE 'banni%' ORDER BY nom,prenom";
$query = $connexion->prepare($sql);
$query->execute(array('recherche' => $recherche));
$result = $query->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Uni'Voix - Inscrits</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <a href="../../style/style_admin/inscrits.css" rel="stylesheet">

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
<section class="bg-univoix py-5 bg-light ">
    <div class="container">
        <div class="row g-4 text-center shadow-lg">
<h2>Listes des inscrits</h2>
            <table class="table table-sm">
            <form action="inscrits.php" method="POST">
                <div class="row">
                    <!-- Colonne gauche -->
                    <div class="col-md-4">
                <div class="mb-2">
                <label for="recherche" class="form-label" style="font-weight: bold">Rechercher un inscrit :</label><br>
                <input name="recherche" id="recherche" type="text" placeholder="Tapez un nom, un prenom...">
                    <button class="btn btn-outline-danger btn-univoix">Rechercher</button>
                </div></div></div>
            </form>
                <tr class="table-group-divider">
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Pseudo</th>
                    <th>Adresse e-mail</th>
                    <th>Rôle</th>
                    <th>Indice de Signalement</th>
                </tr>
                <?php foreach ($result as $resultat) {
                    ?>
                    <tr>
                        <td><?=$resultat['nom']?></td>
                        <td><?=$resultat['prenom']?></td>
                        <td><?=$resultat['pseudo']?></td>
                        <td><?=$resultat['email']?></td>
                        <td><?=$resultat['role']?></td>
                        <td><?=$resultat['importance_signalement']?></td>
                        <td class="text-center">

                            <form method="POST" action="modification.php">
                                    <button type="submit" class="btn btn-sm btn-outline-dark" title="Modifier">
                                        Gérer
                                    </button>
                                    <input type="hidden" value="<?=$resultat['id_inscrit']?>" name="id" >
                            </form></td><td>
                                <form method="POST" action="bannissement.php">
                                    <button  class="btn btn-sm btn-outline-danger" title="Supprimer">
                                        Bannir
                                    </button>
                                    <input type="hidden" value="<?=$resultat['id_inscrit']?>" name="id" >
                                </form>

                        </td>

                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</section>
<footer class="py-3 text-center bg-danger text-white site-footer">
    © 2026 — Luca Regi, Nassim Kharfouche, Prosper Fajnzyn — Tous droits réservés
</footer>
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
</body>
</html>