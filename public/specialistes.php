<?php
require_once "..\bdd\connexion.php";
session_start();

// Récupère le filtre de spécialité depuis l'URL (GET)
if (isset($_GET['categorie'])) { $categorie = $_GET['categorie']; } else { $categorie = ''; }

// Récupère tous les inscrits ayant le rôle "specialiste"
// Si un filtre de spécialité est actif, l'applique dynamiquement
$sql3 = "SELECT id_inscrit, nom, prenom, email, specialite FROM inscrit WHERE role='specialiste'";
$params = [];
if ($categorie !== '') {
    $sql3 .= " AND specialite = :categorie";
    $params['categorie'] = $categorie;
}
$query3 = $connexion->prepare($sql3);
$query3->execute($params);
$result = $query3->fetchAll();

// Récupère la liste des spécialités distinctes pour le filtre (PDO::FETCH_COLUMN = tableau simple)
$queryCategories = $connexion->prepare("SELECT DISTINCT specialite FROM inscrit WHERE role='specialiste' ORDER BY specialite");
$queryCategories->execute();
$categories = $queryCategories->fetchAll(PDO::FETCH_COLUMN);

$daltonisme_session = isset($_SESSION['daltonisme']) ? $_SESSION['daltonisme'] : 'aucun';
$dyslexie_session   = isset($_SESSION['dyslexie'])   ? $_SESSION['dyslexie']   : false;
$palettes = [
        'aucun'        => ['danger'=>'#dc3545','danger_rgb'=>'220,53,69','danger_dark'=>'#58151c','danger_bg_subtle'=>'#f8d7da','danger_border_subtle'=>'#f1aeb5','link'=>'#0d6efd','link_rgb'=>'13,110,253'],
        'deuteranopie' => ['danger'=>'#0055cc','danger_rgb'=>'0,85,204', 'danger_dark'=>'#002a66','danger_bg_subtle'=>'#cce0ff','danger_border_subtle'=>'#99c1ff','link'=>'#e07b00','link_rgb'=>'224,123,0'],
        'tritanopie'   => ['danger'=>'#cc3300','danger_rgb'=>'204,51,0', 'danger_dark'=>'#661a00','danger_bg_subtle'=>'#ffe5dd','danger_border_subtle'=>'#ffbba8','link'=>'#007a33','link_rgb'=>'0,122,51'],
        'protanopie'   => ['danger'=>'#6600cc','danger_rgb'=>'102,0,204','danger_dark'=>'#330066','danger_bg_subtle'=>'#ead5ff','danger_border_subtle'=>'#cc99ff','link'=>'#007acc','link_rgb'=>'0,122,204'],
];
$p = isset($palettes[$daltonisme_session]) ? $palettes[$daltonisme_session] : $palettes['aucun'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Uni'Voix - Spécialistes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style/style_public/specialistes.css" rel="stylesheet">
    <?php if ($daltonisme_session !== 'aucun' || $dyslexie_session): ?>
        <style id="accessibilite-overrides">
            <?php if ($daltonisme_session !== 'aucun'): ?>
            :root {
                --bs-danger:               <?= $p['danger'] ?>;
                --bs-danger-rgb:           <?= $p['danger_rgb'] ?>;
                --bs-danger-text-emphasis: <?= $p['danger_dark'] ?>;
                --bs-danger-bg-subtle:     <?= $p['danger_bg_subtle'] ?>;
                --bs-danger-border-subtle: <?= $p['danger_border_subtle'] ?>;
                --bs-link-color:           <?= $p['link'] ?>;
                --bs-link-color-rgb:       <?= $p['link_rgb'] ?>;
                --bs-link-hover-color:     <?= $p['danger'] ?>;
            }
            .btn-danger:hover,.btn-danger:active,.btn-danger:focus-visible{background-color:<?= $p['danger_dark'] ?> !important;border-color:<?= $p['danger_dark'] ?> !important;}
            .btn-outline-danger:hover,.btn-outline-danger:active{background-color:<?= $p['danger'] ?> !important;color:#fff !important;}
            .form-control:focus,.form-select:focus{border-color:<?= $p['danger'] ?> !important;box-shadow:0 0 0 .25rem rgba(<?= $p['danger_rgb'] ?>,.25) !important;}
            <?php endif; ?>
            <?php if ($dyslexie_session): ?>
            @font-face{font-family:'OpenDyslexic';src:url('https://cdn.jsdelivr.net/npm/open-dyslexic@1.0.3/OpenDyslexic-Regular.otf') format('opentype');font-weight:normal;}
            @font-face{font-family:'OpenDyslexic';src:url('https://cdn.jsdelivr.net/npm/open-dyslexic@1.0.3/OpenDyslexic-Bold.otf') format('opentype');font-weight:bold;}
            *,*::before,*::after{font-family:'OpenDyslexic',Arial,sans-serif !important;}
            body{line-height:1.8 !important;letter-spacing:.05em !important;word-spacing:.15em !important;background-color:#fdfaf3 !important;}
            body,p,li,td,label{font-size:1.05rem !important;}
            .card,.form-control{background-color:#fdfaf3 !important;}
            <?php endif; ?>
        </style>
    <?php endif; ?>
</head>
<body style="font-family:'Candara'" class="bg-light">

<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">
        <a href="acceuil.php"><img alt="" class="navbar-brand fw-bold" src="../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link fw-bold text-danger" href="specialistes.php">Spécialistes</a>
        <a class="nav-link" href="forum.php">Forum</a>
        <a class="nav-link" href="aides.php">Aides</a>
        <a class="nav-link" href="presentation.php">Handicaps</a>
        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){ ?>
            <a class="nav-link" href="admin/connexion_admin.php">Admin</a>
        <?php } ?>
        <?php if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])){ ?>
            <a class="navbar-brand fw-bold" href="connexion.php">Connexion</a>
        <?php } else {
            $avatar = null;
            require_once "avatar.php"; ?>
            <li class="nav-item dropdown fs-5">
                <a class="nav-link dropdown-toggle" style="font-weight:bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="rounded-circle" alt="pdp" src="<?=$avatar?>" width="40px" height="40px"/>
                    <?=$_SESSION["prenom"]?> <?=$_SESSION["nom"]?>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="profil.php">Profil</a></li>
                    <li><a class="dropdown-item" href="deconnexion.php">Se déconnecter</a></li>
                </ul>
            </li>
        <?php } ?>
    </div>
</nav>

<div class="container my-5">
    <h2 class="fw-bold mb-4">Nos Spécialistes</h2>

    <!-- Filtre par spécialité en GET -->
    <form method="GET" action="specialistes.php" class="mb-4 d-flex gap-2 align-items-center">
        <select name="categorie" class="form-select w-auto">
            <option value="">Toutes les spécialités</option>
            <?php foreach($categories as $cat): ?>
                <!-- Marque l'option correspondant au filtre actif -->
                <option value="<?= htmlspecialchars($cat) ?>" <?= $categorie === $cat ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-danger">Filtrer</button>
        <a href="specialistes.php" class="btn btn-outline-secondary">Réinitialiser</a>
    </form>

    <div class="row g-4">
        <?php foreach($result as $specialiste): ?>
            <?php
            // Résolution de l'avatar du spécialiste : cherche dans plusieurs formats successifs
            $av2 = null;
            $sid = $specialiste['id_inscrit'];
            $av  = "../img/avatar/".$sid.".png";
            if(!file_exists($av)){ $av = $av2; $av = $av."../img/avatar/".$sid.".jpeg"; }
            if(!file_exists($av)){ $av = $av2; $av = $av."../img/avatar/".$sid.".jpg"; }
            if(!file_exists($av)){ $av = $av2; $av = $av."../img/avatar/".$sid.".gif"; }
            if(!file_exists($av)){ $av = $av2; $av = $av."../img/avatar/default.png"; }
            ?>
            <div class="col-md-4">
                <div class="card border border-danger border-2 shadow-sm rounded-4 h-100">
                    <div class="card-body text-center p-4">
                        <img class="rounded-circle mb-3 border border-danger border-2"
                             src="<?= $av ?>" alt="Avatar" width="80px" height="80px">
                        <h5 class="fw-bold"><?= htmlspecialchars($specialiste['prenom']) ?> <?= htmlspecialchars($specialiste['nom']) ?></h5>
                        <span class="badge bg-danger mb-2"><?= htmlspecialchars($specialiste['specialite']) ?></span>
                        <p class="text-muted small"><?= htmlspecialchars($specialiste['email']) ?></p>
                        <a href="mailto:<?= htmlspecialchars($specialiste['email']) ?>" class="btn btn-outline-danger btn-sm">
                            Contacter
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if(empty($result)): ?>
            <p class="text-muted text-center py-5">Aucun spécialiste disponible pour cette spécialité.</p>
        <?php endif; ?>
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