<?php
global $date, $description;
session_start();
require_once "../bdd/connexion.php";

// Redirige si non connecté
if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])){
    header("location:connexion.php?page=f");
    exit();
}

$id_sujet    = $_GET['id'];
$ref_inscrit = $_SESSION['id'];

// Récupère le sujet avec les infos de son auteur (pseudo et rôle)
$stmt = $connexion->prepare(" SELECT sujet.*, inscrit.pseudo, inscrit.role FROM sujet INNER JOIN inscrit ON sujet.ref_inscrit = inscrit.id_inscrit WHERE sujet.id_sujet = :id");
$stmt->execute(["id" => $id_sujet]);
$sujet = $stmt->fetch(PDO::FETCH_ASSOC);

// Traitement de la soumission d'une réponse
if(isset($_POST['submit_btn'])){
    $contenu = $_POST['contenu'];
    $date    = date('Y-m-d');
    $sql = "INSERT INTO reponse (contenu, date_reponse, ref_inscrit, ref_sujet)  VALUES (:contenu, :date_reponse, :ref_inscrit, :ref_sujet)";
    $query = $connexion->prepare($sql);
    $query->execute([
        "contenu"      => $contenu,
        "date_reponse" => $date,
        "ref_inscrit"  => $ref_inscrit,
        "ref_sujet"    => $id_sujet
    ]);
    // Redirige vers la même page pour éviter la re-soumission du formulaire (pattern PRG)
    header("Location: sujet.php?id=$id_sujet");
    exit();
}

// Récupère toutes les réponses du sujet triées du plus ancien au plus récent
$stmt2 = $connexion->prepare(" SELECT reponse.*, inscrit.pseudo FROM reponse INNER JOIN inscrit ON reponse.ref_inscrit = inscrit.id_inscrit WHERE reponse.ref_sujet = :id ORDER BY reponse.date_reponse ASC");
$stmt2->execute(["id" => $id_sujet]);
$reponses = $stmt2->fetchAll(PDO::FETCH_ASSOC);


if(isset($_POST['ref_signale']) && isset($_POST['contenu'])) {
    $sqlSignalement = "INSERT INTO signalement (ref_signalant, ref_signale, contenu, date, titre) VALUES (:ref_signalant, :ref_signale, :contenu, CURDATE(), :titre)";
    $querySignalement = $connexion->prepare($sqlSignalement);
    $querySignalement->execute([
        'ref_signalant' => $_SESSION['id'],
        'ref_signale' => $_POST['ref_signale'],
        'contenu' => $_POST['contenu'],
        'titre' => $_POST['titre']
    ]);
    header("Location: sujet.php?id=$id_sujet");
    exit;
}




?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniVoix - <?= htmlspecialchars($sujet['titre']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style/style_public/sujet.css" rel="stylesheet">
    <?php
    $__daltonisme = isset($_SESSION['daltonisme']) ? $_SESSION['daltonisme'] : 'aucun';
    $__dyslexie   = isset($_SESSION['dyslexie'])   ? $_SESSION['dyslexie']   : false;

    // Palettes de couleurs adaptées selon le type de daltonisme
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
                --color-primary:           <?=$__p['p']?>;
                --color-primary-dark:      <?=$__p['pd']?>;
                --color-primary-light:     <?=$__p['pl']?>;
                --color-primary-shadow-15: rgba(<?=$__p['rgb']?>,.15);
                --color-primary-shadow-25: rgba(<?=$__p['rgb']?>,.25);
                --color-primary-shadow-35: rgba(<?=$__p['rgb']?>,.35);
            }
            .navbar { border-color: <?=$__p['p']?> !important; }
            .bg-danger, footer.bg-danger { background-color: <?=$__p['p']?> !important; }
            .border-danger { border-color: <?=$__p['p']?> !important; }
            .text-danger { color: <?=$__p['p']?> !important; }
            .btn-danger { background-color: <?=$__p['p']?> !important; border-color: <?=$__p['pd']?> !important; color: #fff !important; }
            .btn-danger:hover, .btn-danger:active { background-color: <?=$__p['pd']?> !important; }
            a:not(.btn):not(.nav-link):not(.navbar-brand):not(.dropdown-item) { color: <?=$__p['link']?> !important; }
            <?php endif; ?>
            <?php if ($__dyslexie): ?>
            @font-face { font-family:'OpenDyslexic'; src:url('https://cdn.jsdelivr.net/npm/open-dyslexic@1.0.3/OpenDyslexic-Regular.otf') format('opentype'); font-weight:normal; }
            @font-face { font-family:'OpenDyslexic'; src:url('https://cdn.jsdelivr.net/npm/open-dyslexic@1.0.3/OpenDyslexic-Bold.otf') format('opentype'); font-weight:bold; }
            *, *::before, *::after { font-family: 'OpenDyslexic', Arial, sans-serif !important; }
            body { line-height:1.8 !important; letter-spacing:0.05em !important; word-spacing:0.15em !important; background-color:#fdfaf3 !important; }
            body,p,li,td,label { font-size:1.05rem !important; }
            <?php endif; ?>
        </style>
    <?php endif; ?>
</head>

<body style="font-family:'Candara'" class="bg-light">

<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">
        <a href="acceuil.php"><img alt="" class="navbar-brand fw-bold" src="../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link" href="specialistes.php">Spécialistes</a>
        <a class="nav-link fw-bold text-danger" href="forum.php">Forum</a>
        <a class="nav-link" href="aides.php">Aides</a>
        <a class="nav-link" href="presentation.php">Handicaps</a>
        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){ ?>
            <a class="nav-link" href="admin/connexion_admin.php">Admin</a>
        <?php } ?>
        <?php
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
    </div>
</nav>

<div class="container my-5">

    <a href="forum.php" class="btn btn-outline-danger mb-4">Retour au forum</a>

    <!-- SUJET PRINCIPAL -->
    <div class="card border border-danger border-3 shadow-sm rounded-4 mb-5">
        <div class="card-body p-5">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <h3 class="fw-bold text-danger mb-0"><?= htmlspecialchars($sujet['titre']) ?></h3>
                <span class="badge bg-danger fs-6 px-3 py-2"><?= htmlspecialchars($sujet['categorie_sujet']) ?></span>
            </div>

            <div class="d-flex align-items-start gap-3 mb-4">
                <!-- Avatar de l'auteur : cherche dans plusieurs formats, tombe sur default.png si aucun n'existe -->
                <div class="bg-danger bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="min-width: 60px; height: 60px;">
                    <?php
                    $avatar2 = null;
                    $id      = htmlspecialchars($sujet['ref_inscrit']);
                    $avatar  = "../img/avatar/".$id.".png";

                    if(!file_exists($avatar)){
                        $avatar = $avatar2;
                        $avatar = $avatar."../img/avatar/".$id.".jpeg";
                    }
                    if(!file_exists($avatar)){
                        $avatar = $avatar2;
                        $avatar = $avatar."../img/avatar/".$id.".jpg";
                    }
                    if(!file_exists($avatar)){
                        $avatar = $avatar2;
                        $avatar = $avatar."../img/avatar/".$id.".gif";
                    }
                    if(!file_exists($avatar)){
                        $avatar = $avatar2;
                        $avatar = $avatar."../img/avatar/default.png";
                    }
                    ?>
                    <img class="rounded-circle" alt="pdp" src="<?=$avatar?>" width="40px" height="40px"/>
                </div>
                <div>
                    <div class="fw-bold text-dark fs-5"><?= htmlspecialchars($sujet['pseudo']) ?> (<?= htmlspecialchars($sujet['role']) ?>)</div>
                    <small class="text-muted">
                        <!-- strtotime convertit la date SQL en timestamp, date() la formate lisiblement -->
                        Posté le <?= date('d/m/Y à H:i', strtotime($sujet['date_sujet'])) ?>
                    </small>
                </div>
            </div>

            <div class="bg-light rounded p-4 border">
                <!-- white-space: pre-wrap préserve les sauts de ligne du contenu saisi -->
                <p class="mb-0 fs-6" style="white-space: pre-wrap;"><?= htmlspecialchars($sujet['contenu']) ?></p>
            </div>
            <!-- button signaler -->
            <div class="d-flex justify-content-end mt-3">
                <!-- Trouver la meme page avec l'id sujet -->
                <form method= "post" action="sujet.php?id=<?=$id_sujet?>" >
                    <input type="hidden" name="ref_signale" value = "<?=$sujet["ref_inscrit"]?>">
                    <input type="hidden" name="contenu" value = "<?=$sujet["contenu"]?>">
                    <input type="hidden" name="titre" value = "<?=$sujet["titre"]?>">
                    <button type="submit" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalSignalement" data-type="sujet" data-id=" ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </svg>
                        Signaler
                    </button>

                </form>

            </div>
        </div>
    </div>

    <!-- SECTION RÉPONSES -->
    <div class="mb-4">
        <h4 class="fw-bold text-danger mb-4">
            <!-- Pluralisation dynamique du mot "réponse" -->
            <?= count($reponses) ?> réponse<?= count($reponses) > 1 ? 's' : '' ?>
        </h4>

        <?php if(empty($reponses)) { ?>
            <div class="alert alert-light border border-2 rounded-4 text-center py-4">
                <p class="text-muted mb-0 fw-semibold">Aucune réponse pour l'instant. Soyez le premier à répondre !</p>
            </div>
        <?php } ?>

        <?php foreach($reponses as $index => $reponse) { ?>
            <div class="card border border-2 shadow-sm rounded-4 mb-3">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <!-- Avatar du répondeur : même logique de cascade de formats que pour l'auteur -->
                        <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="min-width: 45px; height: 45px;">
                            <?php
                            $avatar2 = null;
                            $id      = htmlspecialchars($reponse['ref_inscrit']);
                            $avatar  = "../img/avatar/".$id.".png";

                            if(!file_exists($avatar)){
                                $avatar = $avatar2;
                                $avatar = $avatar."../img/avatar/".$id.".jpeg";
                            }
                            if(!file_exists($avatar)){
                                $avatar = $avatar2;
                                $avatar = $avatar."../img/avatar/".$id.".jpg";
                            }
                            if(!file_exists($avatar)){
                                $avatar = $avatar2;
                                $avatar = $avatar."../img/avatar/".$id.".gif";
                            }
                            if(!file_exists($avatar)){
                                $avatar = $avatar2;
                                $avatar = $avatar."../img/avatar/default.png";
                            }
                            ?>
                            <img class="rounded-circle" alt="pdp" src="<?=$avatar?>" width="40px" height="40px"/>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-bold text-dark"><?= htmlspecialchars($reponse['pseudo']) ?></div>
                                    <small class="text-muted">
                                        <?= date('d/m/Y à H:i', strtotime($reponse['date_reponse'])) ?>
                                    </small>
                                </div>
                                <!-- Numéro de la réponse dans le fil (commence à 1) -->
                                <span class="badge bg-light text-dark border">#<?= $index + 1 ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="ms-5 ps-3">
                        <p class="mb-0" style="white-space: pre-wrap;"><?= htmlspecialchars($reponse['contenu']) ?></p>
                    </div>
                    <!-- button signaler pour les messages -->
                    <div class="d-flex justify-content-end mt-3">
                        <form method= "post" action="sujet.php?id=<?=$id_sujet?>" >
                            <input type="hidden" name="ref_signale" value = "<?=$reponse["ref_inscrit"]?>">
                            <input type="hidden" name="contenu" value = "<?=$reponse["contenu"]?>">
                            <input type="hidden" name="titre" value ="<?=$sujet["titre"]?>">
                            <button type="submit" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalSignalement" data-type="sujet" data-id=" ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="me-1" viewBox="0 0 16 16">
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                </svg>
                                Signaler
                            </button>

                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <!-- FORMULAIRE DE RÉPONSE -->
    <div class="card border border-danger border-3 shadow-sm rounded-4">
        <div class="card-header bg-danger text-white py-3">
            <h5 class="mb-0 fw-bold">Votre réponse</h5>
        </div>
        <div class="card-body p-4">
            <!-- L'id du sujet est passé en GET dans l'action pour rediriger après soumission -->
            <form action="sujet.php?id=<?= $id_sujet ?>" method="post">
                <div class="mb-3">
                    <textarea name="contenu" class="form-control border-2" rows="5" placeholder="Écrivez votre réponse..." required></textarea>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Soyez respectueux et bienveillant</small>
                    <button type="submit" name="submit_btn" class="btn btn-danger px-4">Envoyer la réponse</button>
                </div>
            </form>
        </div>
    </div>

</div>

<footer class="footer-wrap">
    <div class="footer-top">
        <div class="footer-col">
            <h4>Nous contacter</h4>

            <a href="https://mail.google.com/mail/?view=cm&to=univoix@gmail.com&su=Prise de contact"
               target="_blank">univoix@gmail.com</a>
        </div>
        <div class="footer-col">
            <h4>Soutien & écoute</h4>
            <div class="urgence-item"><span class="urgence-num">3114</span><span class="urgence-label">Prévention suicide (24h/24)</span></div>
            <div class="urgence-item"><span class="urgence-num">3977</span><span class="urgence-label">Maltraitance personnes âgées / handicap</span></div>
            <div class="urgence-item"><span class="urgence-num">0800 235 236</span><span class="urgence-label">Fil santé jeunes (gratuit)</span></div>
        </div>
        <div class="footer-col">
            <h4>Aide aux personnes vulnérables</h4>
            <div class="urgence-item"><span class="urgence-num">119</span><span class="urgence-label">Enfance en danger</span></div>
            <div class="urgence-item"><span class="urgence-num">114</span><span class="urgence-label">Urgence sourdes / malentendantes</span></div>
            <div class="urgence-item"><span class="urgence-num">0800 360 360</span><span class="urgence-label">Info handicap — aidants familiaux</span></div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2026 — Luca Regi, Nassim Kharfouche, Prosper Fajnzyn — Tous droits réservés</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

