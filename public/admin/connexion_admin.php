<?php
$bdd = null;
require_once('../../bdd/connexion.php');
session_start();
if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    header("location:../connexion.php");
    exit();
}

$nom    = null;
$prenom = null;
$email  = null;

// Conserve l'email saisi si la connexion a échoué, pour le re-remplir dans le formulaire
if(isset($_POST['email'])){
    $email = $_POST['email'];
}

$erreur     = null;
$inscription = null;

// Affiche un message d'erreur si la connexion a échoué (paramètre GET 'erreur' envoyé par connexion_admin2.php)
if(isset($_GET['erreur'])){
    if ($_GET['erreur'] == 'unknown'){
        $erreur = "Identifiants inexistants ou incorrects";
    }
}


?>
<!DOCTYPE html>
<html lang=fr>
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="../../style/style_admin/connexion_admin.css" rel="stylesheet">
    <?php
    $__daltonisme = isset($_SESSION['daltonisme']) ? $_SESSION['daltonisme'] : 'aucun';
    $__dyslexie   = isset($_SESSION['dyslexie'])   ? $_SESSION['dyslexie']   : false;

    $__palettes = [
            'aucun'        => ['p'=>'#dc3545','pd'=>'#b02a37','pl'=>'#f8d7da','rgb'=>'220,53,69', 'link'=>'#0d6efd','footer'=>'#dc3545'],
            'deuteranopie' => ['p'=>'#0055cc','pd'=>'#003d99','pl'=>'#cce0ff','rgb'=>'0,85,204',  'link'=>'#e07b00','footer'=>'#0055cc'],
            'tritanopie'   => ['p'=>'#cc3300','pd'=>'#992200','pl'=>'#ffe5dd','rgb'=>'204,51,0',  'link'=>'#007a33','footer'=>'#cc3300'],
            'protanopie'   => ['p'=>'#6600cc','pd'=>'#4d0099','pl'=>'#ead5ff','rgb'=>'102,0,204', 'link'=>'#007acc','footer'=>'#6600cc'],
    ];
    $__p = isset($__palettes[$__daltonisme]) ? $__palettes[$__daltonisme] : $__palettes['aucun'];
    if ($__daltonisme !== 'aucun' || $__dyslexie): ?>
        <style id="accessibilite-overrides">
            <?php if ($__daltonisme !== 'aucun'): ?>
            :root {
                --bs-danger:               <?= $__p['p'] ?>;
                --bs-danger-rgb:           <?= $__p['rgb'] ?>;
                --bs-link-color:           <?= $__p['link'] ?>;
            }
            .btn-danger { background-color: <?= $__p['p'] ?> !important; border-color: <?= $__p['pd'] ?> !important; }
            .btn-danger:hover { background-color: <?= $__p['pd'] ?> !important; }
            <?php endif; ?>
            <?php if ($__dyslexie): ?>
            @font-face { font-family:'OpenDyslexic'; src:url('https://cdn.jsdelivr.net/npm/open-dyslexic@1.0.3/OpenDyslexic-Regular.otf') format('opentype'); font-weight:normal; }
            *, *::before, *::after { font-family: 'OpenDyslexic', Arial, sans-serif !important; }
            body { line-height:1.8 !important; letter-spacing:0.05em !important; background-color:#fdfaf3 !important; }
            body,p,li,td,label { font-size:1.05rem !important; }
            <?php endif; ?>
        </style>
    <?php endif; ?>
</head>

<body class="bg-light" style="font-family:'Candara'">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">
        <a href="../acceuil.php"><img alt="" class="navbar-brand fw-bold" src="../../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link" href="../specialistes.php">Spécialistes</a>
        <a class="nav-link" href="../forum.php">Forum</a>
        <a class="nav-link" href="../aides.php">Aides</a>
        <a class="nav-link" href="../presentation.php">Handicaps</a>
        <a class="navbar-brand fw-bold text-danger" href="../profil.php">Connexion</a>
    </div>
</nav>

<div class="container mt-3 mb-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-5 fw-bold text-dark">Connectez-vous à votre compte Uni'Voix Administrateur</h1>
    </div>
    <div class="card border-0 shadow-lg">
        <div class="card-body p-0">
            <div class="table-responsive">
                <!-- Le formulaire envoie les données vers connexion_admin2.php pour vérification -->
                <form class="container mt-3" method="POST" action="connexion_admin2.php">
                    <label for="email">Adresse e-mail :</label><br>
                    <!-- value="<?=$email?>" : conserve l'email saisi en cas d'erreur de connexion -->
                    <input type="email" id="email" name="email" value="<?=$email?>" autocomplete="off" required><br><br>

                    <label for="mdp">Mot de Passe :</label><br>
                    <input type="password" id="mdp" name="mdp" autocomplete="off" required><br>

                    <?php if (isset($page)) { ?>
                        <input type="hidden" value="<?=$page?>" name="page">
                    <?php } ?>

                    <!-- Affiche le message d'erreur s'il y en a un (ex: identifiants incorrects) -->
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