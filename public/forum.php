<?php
require_once "../bdd/connexion.php";
session_start();
if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])){
    header("location:connexion.php?page=f");
    exit();

}
$sujets = $connexion->query("
    SELECT sujet.id_sujet, sujet.titre, sujet.date_sujet, sujet.categorie_sujet, inscrit.pseudo
    FROM sujet
    INNER JOIN inscrit ON sujet.ref_inscrit = inscrit.id_inscrit
    ORDER BY sujet.date_sujet ASC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UniVoix - Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light" style="font-family:'Candara'">

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
            </svg> John Doe
        </a>
    </div>
</nav>

<div class="container my-5">

    <h1 class="text-center fw-bold mb-2">LE FORUM</h1>
    <p class="text-center text-muted mb-4">Sur cette page, vous pouvez échanger avec d'autres utilisateurs sur divers sujets</p>

    <!-- BARRE FILTRES + TITRE + BOUTON -->
    <div class="d-flex align-items-center mb-3 gap-2">
        <button class="btn btn-danger">Filtres ▶</button>
        <h5 class="flex-grow-1 text-center fw-bold mb-0">Les derniers sujets</h5>
        <a href="creation_sujet.php" class="btn btn-danger">Créer un sujet</a>
    </div>

    <!-- TABLEAU -->
    <div class="card border border-danger border-2">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-danger">
            <tr>
                <th>Sujet</th>
                <th>Date de post ©</th>
                <th>Pseudo ©</th>
                <th>Catégorie ©</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($sujets as $sujet){ ?>
                <tr style="cursor:pointer;" onclick="window.location='sujet.php?id=<?= $sujet['id_sujet'] ?>'">
                    <td><?= htmlspecialchars($sujet['titre']) ?></td>
                    <td><?= date('d/m/y', strtotime($sujet['date_sujet'])) ?></td>
                    <td><?= htmlspecialchars($sujet['pseudo']) ?></td>
                    <td><?= htmlspecialchars($sujet['categorie_sujet']) ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<footer class="bg-danger text-white py-4 mt-5">
    <div class="container text-center">
        <small class="opacity-75">© 2026 – Luca Regi, Nassim Kharfouche, Prosper Fajnzyn – Tous droits réservés</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>