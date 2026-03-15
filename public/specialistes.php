<?php
require_once "..\bdd\connexion.php";
session_start();

if (isset($_GET['categorie'])) { $categorie = $_GET['categorie']; } else { $categorie = ''; }

$sql3 = "SELECT id_inscrit, nom, prenom, specialite FROM inscrit WHERE role='specialiste'";
$params = [];
if ($categorie !== '') { $sql3 .= " AND specialite = :categorie"; $params['categorie'] = $categorie; }
$query3 = $connexion->prepare($sql3);
$query3->execute($params);
$result = $query3->fetchAll();

$queryCategories = $connexion->prepare("SELECT DISTINCT specialite FROM inscrit WHERE role='specialiste' ORDER BY specialite");
$queryCategories->execute();
$categories = $queryCategories->fetchAll(PDO::FETCH_COLUMN);

$daltonisme_session = isset($_SESSION['daltonisme']) ? $_SESSION['daltonisme'] : 'aucun';
$dyslexie_session   = isset($_SESSION['dyslexie'])   ? $_SESSION['dyslexie']   : false;
$palettes = [
        'aucun'        => ['danger'=>'#dc3545','danger_rgb'=>'220,53,69', 'danger_dark'=>'#58151c','danger_bg_subtle'=>'#f8d7da','danger_border_subtle'=>'#f1aeb5','link'=>'#0d6efd','link_rgb'=>'13,110,253'],
        'deuteranopie' => ['danger'=>'#0055cc','danger_rgb'=>'0,85,204',  'danger_dark'=>'#002a66','danger_bg_subtle'=>'#cce0ff','danger_border_subtle'=>'#99c1ff','link'=>'#e07b00','link_rgb'=>'224,123,0'],
        'tritanopie'   => ['danger'=>'#cc3300','danger_rgb'=>'204,51,0',  'danger_dark'=>'#661a00','danger_bg_subtle'=>'#ffe5dd','danger_border_subtle'=>'#ffbba8','link'=>'#007a33','link_rgb'=>'0,122,51'],
        'protanopie'   => ['danger'=>'#6600cc','danger_rgb'=>'102,0,204', 'danger_dark'=>'#330066','danger_bg_subtle'=>'#ead5ff','danger_border_subtle'=>'#cc99ff','link'=>'#007acc','link_rgb'=>'0,122,204'],
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
            .btn-outline-danger:hover,.btn-outline-danger:active{background-color:<?= $p['danger'] ?> !important;border-color:<?= $p['danger'] ?> !important;color:#fff !important;}
            .form-control:focus,.form-select:focus{border-color:<?= $p['danger'] ?> !important;box-shadow:0 0 0 .25rem rgba(<?= $p['danger_rgb'] ?>,.25) !important;}
            <?php endif; ?>
            <?php if ($dyslexie_session): ?>
            @font-face{font-family:'OpenDyslexic';src:url('https://cdn.jsdelivr.net/npm/open-dyslexic@1.0.3/OpenDyslexic-Regular.otf') format('opentype');font-weight:normal;}
            @font-face{font-family:'OpenDyslexic';src:url('https://cdn.jsdelivr.net/npm/open-dyslexic@1.0.3/OpenDyslexic-Bold.otf') format('opentype');font-weight:bold;}
            *,*::before,*::after{font-family:'OpenDyslexic',Arial,sans-serif !important;}
            body{line-height:1.8 !important;letter-spacing:.05em !important;word-spacing:.15em !important;background-color:#fdfaf3 !important;}
            p,li,td,th,label,span,div,a,input,textarea,select,button{line-height:1.8 !important;letter-spacing:.04em !important;word-spacing:.12em !important;}
            body,p,li,td,label{font-size:1.05rem !important;}
            .card,.form-control{background-color:#fdfaf3 !important;}
            p,li,td,div{text-align:left !important;}
            <?php endif; ?>
        </style>
    <?php endif; ?>
</head>
<body style="font-family: 'Candara'">
<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">
        <a href="acceuil.php"><img alt="" class="navbar-brand fw-bold" src="../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link text-danger fw-bold" href="specialistes.php">Spécialistes</a>
        <a class="nav-link" href="forum.php">Forum</a>
        <a class="nav-link" href="aides.php">Aides</a>
        <a class="nav-link" href="presentation.php">Handicaps</a>
        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
            <a class="nav-link" href="admin/connexion_admin.php">Admin</a>
        <?php endif; ?>
        <?php if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])): ?>
            <a class="navbar-brand fw-bold" href="profil.php"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 20 20"><path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/><path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/></svg> Connexion</a>
        <?php else:
            $avatar = null;
            require_once "avatar.php"; ?>
            <li class="nav-item dropdown fs-5">
                <a class="nav-link dropdown-toggle" style="font-weight:bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><img class="rounded-circle" alt="pdp" src="<?=$avatar?>" width="40px" height="40px"/> &nbsp;<?=$_SESSION["prenom"]?> <?=$_SESSION["nom"]?></a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="profil.php">Profil</a></li>
                    <li><a class="dropdown-item" href="deconnexion.php">Se deconnecter</a></li>
                </ul>
            </li>
        <?php endif; ?>
    </div>
</nav>
<section class="bg-white py-5 text-center">
    <div class="container">
        <h1 class="fw-bold mb-3">Les Spécialistes</h1>
        <p class="text-muted">Sur cette page, nous proposons une discussion avec des professionels de santé, des psychologues et des conseillers d'orientation prets a vous aider.</p>
    </div>
</section>
<div class="container shadow-lg pb-2 bg-danger">
    <div class="p-2">
        <button class="btn btn-outline-dark text-white" type="button" data-bs-toggle="collapse" data-bs-target="#filtresCollapse">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-funnel me-2" viewBox="0 0 16 16"><path d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5zm1 .5v1.308l4.372 4.858A.5.5 0 0 1 7 8.5v5.306l2-.666V8.5a.5.5 0 0 1 .128-.334L13.5 3.308V2z"/></svg>
            Filtres
        </button>
    </div>
    <div class="collapse mb-4" id="filtresCollapse">
        <div class="card border-danger border-2 shadow-sm rounded-4">
            <div class="card-header bg-danger text-white">
                <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-sliders me-2" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M9.05 3a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0V3zM4.5 7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M2.05 8a2.5 2.5 0 0 1 4.9 0H16v1H6.95a2.5 2.5 0 0 1-4.9 0H0V8zm9.45 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m-2.45 1a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0v-1z"/></svg>Filtrer les spécialistes</h6>
            </div>
            <div class="card-body p-4">
                <form method="GET" action="specialistes.php" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tags me-2" viewBox="0 0 16 16"><path d="M3 2v4.586l7 7L14.586 9l-7-7zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586z"/><path d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1z"/></svg>Spécialités</label>
                        <select name="categorie" class="form-select form-select-lg">
                            <option value="">Toutes les spécialités</option>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?= htmlspecialchars($cat) ?>" <?= $categorie === $cat ? 'selected' : '' ?>><?= htmlspecialchars($cat) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12 d-flex gap-2 justify-content-end">
                        <a href="specialistes.php" class="btn btn-outline-secondary btn-lg"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise me-2" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2z"/><path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466"/></svg>Réinitialiser</a>
                        <button type="submit" class="btn btn-danger btn-lg px-4"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle me-2" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/><path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/></svg>Appliquer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <section class="bg-univoix py-5 bg-light">
        <div class="container">
            <div class="row g-4 text-center">
                <?php $compteur = 1;
                foreach ($result as $resultat): ?>
                    <div class="col-md-4">
                        <div class="shadow pb-2">
                            <h5 class="section-title">Specialiste <?= $compteur ?></h5>
                            <?php
                            $avatar_spec = "../img/avatar/".$resultat["id_inscrit"].".png";
                            if(!file_exists($avatar_spec)) $avatar_spec = "../img/avatar/".$resultat["id_inscrit"].".jpeg";
                            if(!file_exists($avatar_spec)) $avatar_spec = "../img/avatar/".$resultat["id_inscrit"].".jpg";
                            if(!file_exists($avatar_spec)) $avatar_spec = "../img/avatar/".$resultat["id_inscrit"].".gif";
                            if(!file_exists($avatar_spec)) $avatar_spec = "../img/avatar/default.png";
                            ?>
                            <img alt="Photo - Specialiste ID <?= $resultat["id_inscrit"] ?>" src="<?= $avatar_spec ?>" style="width:150px;height:150px;" class="border border-danger rounded">
                            <p><?= $resultat["nom"] ?> <?= $resultat["prenom"] ?> - <?= $resultat["specialite"] ?></p>
                            <a href="#" class="btn btn-danger">Prendre contact</a>
                        </div>
                    </div>
                    <?php $compteur++; endforeach; ?>
            </div>
        </div>
    </section>
</div>
<div class="pt-4"></div>
<footer class="py-3 text-center bg-danger text-white">
    © 2026 — Luca Regi, Nassim Kharfouche, Prosper Fajnzyn — Tous droits réservés
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>