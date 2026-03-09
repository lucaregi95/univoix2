<?php
require_once "../bdd/connexion.php";
session_start();
if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    header("location:connexion.php?page=f");
    exit();
}
if (isset($_GET['categorie'])) {
    $categorie = $_GET['categorie'];
} else {
    $categorie = '';
}
if (isset($_GET['recherche'])) {
    $recherche = $_GET['recherche'];
} else {
    $recherche = '';
}

$sql = " SELECT sujet.id_sujet, sujet.titre, sujet.date_sujet, sujet.categorie_sujet, inscrit.pseudo,(SELECT COUNT(*) FROM reponse WHERE reponse.ref_sujet = sujet.id_sujet) as nb_reponses FROM sujet INNER JOIN inscrit ON sujet.ref_inscrit = inscrit.id_inscrit WHERE 1=1 ";

$tableau = [];

if ($categorie != '') {
    $sql = $sql . " AND sujet.categorie_sujet LIKE :categorie";
    $tableau['categorie'] = '%' . $categorie . '%';
}

if ($recherche != '') {
    $sql = $sql . " AND (sujet.titre LIKE :recherche OR sujet.contenu LIKE :recherche)";
    $tableau['recherche'] = '%' . $recherche . '%';
}

$sql = $sql . " ORDER BY sujet.date_sujet DESC";

$req = $connexion->prepare($sql);
$req->execute($tableau);
$sujets = $req->fetchAll(PDO::FETCH_ASSOC);

$categories = $connexion->query("SELECT DISTINCT categorie_sujet FROM sujet ORDER BY categorie_sujet")->fetchAll(PDO::FETCH_COLUMN);


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UniVoix - Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style> ul, li {
           list-style-type: none;
           }
    </style>
</head>
<body class="bg-light" style="font-family:'Candara'">

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

<!-- HEADER -->
<header class="bg-white py-5 border-bottom">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-danger mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-chat-dots me-2" viewBox="0 0 16 16">
                <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125"/>
            </svg>
            Le Forum
        </h1>
        <p class="lead text-muted col-lg-8 mx-auto">
            Partagez vos expériences, posez vos questions et échangez avec la communauté UniVoix
        </p>
    </div>
</header>

<div class="container my-5">

    <!-- BARRE ACTIONS -->
    <div class="row mb-4 g-3 align-items-center">
        <div class="col-md-3">
            <button class="btn btn-outline-danger w-100" type="button" data-bs-toggle="collapse" data-bs-target="#filtresCollapse">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel me-2" viewBox="0 0 16 16">
                    <path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/>
                </svg>
                Filtres
            </button>
        </div>
        <div class="col-md-6 text-center">
            <h5 class="fw-bold mb-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-clock-history me-2 text-danger" viewBox="0 0 16 16">
                    <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022zm2.004.45a7 7 0 0 0-.985-.299l.219-.976q.576.129 1.126.342zm1.37.71a7 7 0 0 0-.439-.27l.493-.87a8 8 0 0 1 .979.654l-.615.789a7 7 0 0 0-.418-.302zm1.834 1.79a7 7 0 0 0-.653-.796l.724-.69q.406.429.747.91zm.744 1.352a7 7 0 0 0-.214-.468l.893-.45a8 8 0 0 1 .45 1.088l-.95.313a7 7 0 0 0-.179-.483m.53 2.507a7 7 0 0 0-.1-1.025l.985-.17q.1.58.116 1.17zm-.131 1.538q.05-.254.081-.51l.993.123a8 8 0 0 1-.23 1.155l-.964-.267q.069-.247.12-.501m-.952 2.379q.276-.436.486-.908l.914.405q-.24.54-.555 1.038zm-.964 1.205q.183-.183.35-.378l.758.653a8 8 0 0 1-.401.432z"/>
                    <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0z"/>
                    <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5"/>
                </svg>
                Sujets récents
                <?php if($categorie != '' || $recherche != ''){ ?>
                    <span class="badge bg-danger ms-2"><?= count($sujets) ?> résultat<?= count($sujets) > 1 ? 's' : '' ?></span>
                <?php } ?>
            </h5>
        </div>
        <div class="col-md-3">
            <a href="creation_sujet.php" class="btn btn-danger w-100">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle me-2" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
                Créer un sujet
            </a>
        </div>
    </div>

    <!-- PANNEAU FILTRES -->
    <div class="collapse mb-4" id="filtresCollapse">
        <div class="card border-danger border-2 shadow-sm rounded-4">
            <div class="card-header bg-danger text-white">
                <h6 class="mb-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-sliders me-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M11.5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M9.05 3a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0V3zM4.5 7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M2.05 8a2.5 2.5 0 0 1 4.9 0H16v1H6.95a2.5 2.5 0 0 1-4.9 0H0V8zm9.45 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m-2.45 1a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0v-1z"/>
                    </svg>
                    Filtrer les sujets
                </h6>
            </div>
            <div class="card-body p-4">
                <form method="GET" action="forum.php" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search me-2" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                            </svg>
                            Rechercher
                        </label>
                        <input type="text" name="recherche" class="form-control form-control-lg" placeholder="Mots-clés dans le titre ou le contenu..." value="<?= htmlspecialchars($recherche) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tags me-2" viewBox="0 0 16 16">
                                <path d="M3 2v4.586l7 7L14.586 9l-7-7zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586z"/>
                                <path d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1z"/>
                            </svg>
                            Catégorie
                        </label>
                        <select name="categorie" class="form-select form-select-lg">
                            <option value="">Toutes les catégories</option>
                            <?php foreach($categories as $cat){ ?>
                                <option value="<?= htmlspecialchars($cat) ?>" <?= $categorie === $cat ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat) ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-12 d-flex gap-2 justify-content-end">
                        <a href="forum.php" class="btn btn-outline-secondary btn-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise me-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2z"/>
                                <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466"/>
                            </svg>
                            Réinitialiser
                        </a>
                        <button type="submit" class="btn btn-danger btn-lg px-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle me-2" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                            </svg>
                            Appliquer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- TABLEAU DES SUJETS -->
    <div class="card border-danger border-3 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-danger">
                <tr>
                    <th class="py-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-square-text me-2" viewBox="0 0 16 16">
                            <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                            <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6m0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                        </svg>
                        Sujet
                    </th>
                    <th class="py-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar3 me-2" viewBox="0 0 16 16">
                            <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857z"/>
                            <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                        </svg>
                        Date
                    </th>
                    <th class="py-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person me-2" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664"/>
                        </svg>
                        Auteur
                    </th>
                    <th class="py-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark me-2" viewBox="0 0 16 16">
                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                        </svg>
                        Catégorie
                    </th>
                    <th class="text-center py-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-dots me-2" viewBox="0 0 16 16">
                            <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                            <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                        </svg>
                        Réponses
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php if(empty($sujets)){ ?>
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-inbox text-muted mb-3" viewBox="0 0 16 16">
                                <path d="M4.98 4a.5.5 0 0 0-.39.188L1.54 8H6a.5.5 0 0 1 .5.5 1.5 1.5 0 1 0 3 0A.5.5 0 0 1 10 8h4.46l-3.05-3.812A.5.5 0 0 0 11.02 4zm-1.17-.437A1.5 1.5 0 0 1 4.98 3h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1 .106.374l-.39 3.124A1.5 1.5 0 0 1 14.117 13H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .106-.374z"/>
                            </svg>
                            <p class="text-muted fw-semibold mb-0">Aucun sujet trouvé</p>
                            <small class="text-muted">Essayez de modifier vos filtres ou créez un nouveau sujet</small>
                        </td>
                    </tr>
                <?php } else { ?>
                    <?php foreach($sujets as $sujet){ ?>
                        <tr class="cursor-pointer" onclick="window.location='sujet.php?id=<?= $sujet['id_sujet'] ?>'" style="cursor:pointer;">
                            <td class="py-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chat-square-text text-danger" viewBox="0 0 16 16">
                                            <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                            <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6m0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                                        </svg>
                                    </div>
                                    <span class="fw-semibold"><?= htmlspecialchars($sujet['titre']) ?></span>
                                </div>
                            </td>
                            <td class="py-3 text-muted"><?= date('d/m/Y', strtotime($sujet['date_sujet'])) ?></td>
                            <td class="py-3">
                                <span class="badge bg-light text-dark border">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-person-fill me-1" viewBox="0 0 16 16">
                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                                    </svg>
                                    <?= htmlspecialchars($sujet['pseudo']) ?>
                                </span>
                            </td>
                            <td class="py-3">
                                <span class="badge bg-danger rounded-pill px-3"><?= htmlspecialchars($sujet['categorie_sujet']) ?></span>
                            </td>
                            <td class="text-center py-3">
                                <span class="badge bg-danger rounded-pill fs-6 px-3"><?= $sujet['nb_reponses'] ?></span>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- FOOTER -->
<footer class="bg-danger text-white py-4 mt-5">
    <div class="container text-center">
        <small class="opacity-75">© 2026 – Luca Regi, Nassim Kharfouche, Prosper Fajnzyn – Tous droits réservés</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>