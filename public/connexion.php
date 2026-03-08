<?php
$bdd = null;
require_once('../bdd/connexion.php');

$nom=null;
$prenom=null;
$email=null;
if(isset($_POST['email'])){
    $email=$_POST['email'];
}
$erreur=null;
$inscription=null;
if(isset($_GET['erreur'])){
    if ($_GET['erreur']=='unknown'){
        $erreur="Identifiants inexistants ou incorrects";
    }

}

if(isset($_GET['page'])){
    $page=$_GET['page'];

}
$inscription="Pas de compte ? Inscrivez-vous";
?>
<!DOCTYPE html>

<html lang=fr>
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="bg-light" style="font-family:'Candara'">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">
        <a href="acceuil.php"><img alt="" class="navbar-brand fw-bold" src="../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link" href="specialistes.php">Spécialistes</a>
        <a class="nav-link fw-bold text-danger" href="forum.php">Forum</a>
        <a class="nav-link" href="aides.php">Aides</a>
        <a class="nav-link" href="presentation.php">Handicaps</a>
        <a class="navbar-brand fw-bold" href="profil.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 20 20">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
            </svg> Connexion
        </a>
    </div>
</nav>
<div class="container mt-3 mb-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-5 fw-bold text-dark"><i class="bi bi-book-fill text-success"></i>Connectez-vous à votre compte Uni'Voix</h1>
    </div>

    <div class="card border-0 shadow-lg">
        <div class="card-body p-0">
            <div class="table-responsive">
                <form class="container mt-3" method="POST" action="connexion2.php">
                    <label for="email">Adresse e-mail :</label><br>
                    <input type="email" id="email" name="email" value="<?=$email?>" autocomplete="off" required><br><br>

                    <label for="mdp">Mot de Passe :</label><br>
                    <input type="password" id="mdp" name="mdp" autocomplete="off" required><br>

                    <?php if (isset($page)) {?>
                    <input type="hidden" value="<?=$page?>" name="page">
                    <?php } ?>
                    <h6 class="text-danger pt-3 pb-3"><?=$erreur?></h6>

                    <button type="submit" class="btn btn-danger">Connectez-vous !</button><br><br>
                </form>
                <div class="mb-3">
                    <a class="container" href="inscription.php"><?=$inscription?></a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

