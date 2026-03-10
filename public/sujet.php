<?php
session_start();
require_once "../bdd/connexion.php";

if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])){
    header("location:connexion.php?page=f");
    exit();

}

$id_sujet = $_GET['id'];
$ref_inscrit = $_SESSION['id'];

$stmt = $connexion->prepare("
    SELECT sujet.*, inscrit.pseudo, inscrit.role
    FROM sujet
    INNER JOIN inscrit ON sujet.ref_inscrit = inscrit.id_inscrit
    WHERE sujet.id_sujet = :id
");
$stmt->execute(["id" => $id_sujet]);
$sujet = $stmt->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['submit_btn'])){
    $contenu = $_POST['contenu'];
    $date = date('Y-m-d');
    $sql = "INSERT INTO reponse (contenu, date_reponse, ref_inscrit, ref_sujet) 
            VALUES (:contenu, :date_reponse, :ref_inscrit, :ref_sujet)";
    $query = $connexion->prepare($sql);
    $query->execute([
        "contenu" => $contenu,
        "date_reponse" => $date,
        "ref_inscrit" => $ref_inscrit,
        "ref_sujet" => $id_sujet
    ]);
    header("Location: sujet.php?id=$id_sujet");
    exit();
}

// Récupérer les réponses
$stmt2 = $connexion->prepare("
    SELECT reponse.*, inscrit.pseudo, inscrit.extension
    FROM reponse
    INNER JOIN inscrit ON reponse.ref_inscrit = inscrit.id_inscrit
    WHERE reponse.ref_sujet = :id
    ORDER BY reponse.date_reponse ASC
");
$stmt2->execute(["id" => $id_sujet]);
$reponses = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniVoix - <?= htmlspecialchars($sujet['titre']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <a href="../style/style_public/sujet.css" rel="stylesheet">
</head>

<body style="font-family:'Candara'" class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">

        <a href="acceuil.php"><img alt="" class="navbar-brand fw-bold" src="../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link" href="specialistes.php">Spécialistes</a>
        <a class="nav-link fw-bold text-danger" href="forum.php">Forum</a>

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

<!-- CONTENT -->
<div class="container my-5">

    <!-- BOUTON RETOUR -->
    <a href="forum.php" class="btn btn-outline-danger mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
        </svg>
        Retour au forum
    </a>

    <!-- SUJET PRINCIPAL -->
    <div class="card border border-danger border-3 shadow-sm rounded-4 mb-5">
        <div class="card-body p-5">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <h3 class="fw-bold text-danger mb-0"><?= htmlspecialchars($sujet['titre']) ?></h3>
                <span class="badge bg-danger fs-6 px-3 py-2"><?= htmlspecialchars($sujet['categorie_sujet']) ?></span>
            </div>

            <div class="d-flex align-items-start gap-3 mb-4">
                <!-- Avatar auteur -->
                <div class="bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="min-width: 60px; height: 60px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person text-danger" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                    </svg>
                </div>
                <div>
                    <div class="fw-bold text-dark fs-5"><?= htmlspecialchars($sujet['pseudo']) ?> (<?= htmlspecialchars($sujet['role']) ?>)</div>
                    <small class="text-muted">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-clock me-1" viewBox="0 0 16 16">
                            <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
                        </svg>
                        Posté le <?= date('d/m/Y à H:i', strtotime($sujet['date_sujet'])) ?>
                    </small>
                </div>
            </div>

            <div class="bg-light rounded p-4 border">
                <p class="mb-0 fs-6" style="white-space: pre-wrap;"><?= htmlspecialchars($sujet['contenu']) ?></p>
            </div>
        </div>
    </div>

    <!-- SECTION REPONSES -->
    <div class="mb-4">
        <h4 class="fw-bold text-danger mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-chat-dots me-2" viewBox="0 0 16 16">
                <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2"/>
            </svg>
            <?= count($reponses) ?> réponse<?= count($reponses) > 1 ? 's' : '' ?>
        </h4>

        <?php if(empty($reponses)) { ?>
            <div class="alert alert-light border border-2 rounded-4 text-center py-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-chat-square-dots text-muted mb-3" viewBox="0 0 16 16">
                    <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                    <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg>
                <p class="text-muted mb-0 fw-semibold">Aucune réponse pour l'instant. Soyez le premier à répondre !</p>
            </div>
        <?php } ?>

        <?php foreach($reponses as $index => $reponse) { ?>
            <div class="card border border-2 shadow-sm rounded-4 mb-3">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <!-- Avatar répondeur -->
                        <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="min-width: 45px; height: 45px;">
                            <img class="rounded-circle" alt="pdp" src="../img/avatar/<?= htmlspecialchars($reponse['ref_inscrit']) ?>.png" width="40px" height="40px"/>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-bold text-dark"><?= htmlspecialchars($reponse['pseudo']) ?></div>
                                    <small class="text-muted">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-clock me-1" viewBox="0 0 16 16">
                                            <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
                                        </svg>
                                        <?= date('d/m/Y à H:i', strtotime($reponse['date_reponse'])) ?>
                                    </small>
                                </div>
                                <span class="badge bg-light text-dark border">#<?= $index + 1 ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="ms-5 ps-3">
                        <p class="mb-0" style="white-space: pre-wrap;"><?= htmlspecialchars($reponse['contenu']) ?></p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- FORMULAIRE REPONSE -->
    <div class="card border border-danger border-3 shadow-sm rounded-4">
        <div class="card-header bg-danger text-white py-3">
            <h5 class="mb-0 fw-bold">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square me-2" viewBox="0 0 16 16">
                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                </svg>
                Votre réponse
            </h5>
        </div>
        <div class="card-body p-4">
            <form action="sujet.php?id=<?= $id_sujet ?>" method="post">
                <div class="mb-3">
                    <textarea name="contenu" class="form-control border-2" rows="5" placeholder="Écrivez votre réponse..." required></textarea>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Soyez respectueux et bienveillant</small>
                    <button type="submit" name="submit_btn" class="btn btn-danger px-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send me-2" viewBox="0 0 16 16">
                            <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z"/>
                        </svg>
                        Envoyer la réponse
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- FOOTER -->
<footer class="bg-danger text-white py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <small class="opacity-75">
                    © 2026 – Luca Regi, Nassim Kharfouche, Prosper Fajnzyn – Tous droits réservés
                </small>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>