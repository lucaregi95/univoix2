<?php
require_once "..\..\bdd\connexion.php";
session_start();

if (!isset($_SESSION['nom']) || !isset($_SESSION['prenom']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("location:../connexion.php");
    exit();
}

if (isset($_POST['supprimer']) && isset($_POST['id_sujet'])) {
    $id_sujet = (int)$_POST['id_sujet'];
    $sqlDelRep = "DELETE FROM reponse WHERE ref_sujet = :id";
    $qDelRep = $connexion->prepare($sqlDelRep);
    $qDelRep->execute(['id' => $id_sujet]);
    $sqlDel = "DELETE FROM sujet WHERE id_sujet = :id";
    $qDel = $connexion->prepare($sqlDel);
    $qDel->execute(['id' => $id_sujet]);
    header("location:forum_admin.php?supprime=1");
    exit();
}

if (isset($_GET['recherche'])) { $recherche = $_GET['recherche']; } else { $recherche = ''; }
if (isset($_GET['categorie'])) { $categorie = $_GET['categorie']; } else { $categorie = ''; }

$sql = "SELECT sujet.id_sujet, sujet.titre, sujet.date_sujet, sujet.categorie_sujet, inscrit.pseudo,
        (SELECT COUNT(*) FROM reponse WHERE reponse.ref_sujet = sujet.id_sujet) as nb_reponses
        FROM sujet INNER JOIN inscrit ON sujet.ref_inscrit = inscrit.id_inscrit WHERE 1=1";
$params = [];
if ($recherche !== '') { $sql .= " AND (sujet.titre LIKE :recherche OR inscrit.pseudo LIKE :recherche)"; $params['recherche'] = '%'.$recherche.'%'; }
if ($categorie !== '') { $sql .= " AND sujet.categorie_sujet = :categorie"; $params['categorie'] = $categorie; }
$sql .= " ORDER BY sujet.date_sujet DESC";
$req = $connexion->prepare($sql);
$req->execute($params);
$sujets = $req->fetchAll(PDO::FETCH_ASSOC);

$qCat = $connexion->prepare("SELECT DISTINCT categorie_sujet FROM sujet ORDER BY categorie_sujet");
$qCat->execute();
$categories = $qCat->fetchAll(PDO::FETCH_COLUMN);

$daltonisme_session = isset($_SESSION['daltonisme']) ? $_SESSION['daltonisme'] : 'aucun';
$dyslexie_session   = isset($_SESSION['dyslexie'])   ? $_SESSION['dyslexie']   : false;
$palettes = [
    'aucun'        => ['danger'=>'#dc3545','danger_rgb'=>'220,53,69','danger_dark'=>'#58151c','danger_bg_subtle'=>'#f8d7da','danger_border_subtle'=>'#f1aeb5','link'=>'#0d6efd','link_rgb'=>'13,110,253','tag_bg'=>'#dc3545','switch_on'=>'#dc3545'],
    'deuteranopie' => ['danger'=>'#0055cc','danger_rgb'=>'0,85,204', 'danger_dark'=>'#002a66','danger_bg_subtle'=>'#cce0ff','danger_border_subtle'=>'#99c1ff','link'=>'#e07b00','link_rgb'=>'224,123,0', 'tag_bg'=>'#0055cc','switch_on'=>'#0055cc'],
    'tritanopie'   => ['danger'=>'#cc3300','danger_rgb'=>'204,51,0', 'danger_dark'=>'#661a00','danger_bg_subtle'=>'#ffe5dd','danger_border_subtle'=>'#ffbba8','link'=>'#007a33','link_rgb'=>'0,122,51',  'tag_bg'=>'#cc3300','switch_on'=>'#cc3300'],
    'protanopie'   => ['danger'=>'#6600cc','danger_rgb'=>'102,0,204','danger_dark'=>'#330066','danger_bg_subtle'=>'#ead5ff','danger_border_subtle'=>'#cc99ff','link'=>'#007acc','link_rgb'=>'0,122,204', 'tag_bg'=>'#6600cc','switch_on'=>'#6600cc'],
];
$p = isset($palettes[$daltonisme_session]) ? $palettes[$daltonisme_session] : $palettes['aucun'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Uni'Voix - Gestion du forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../style/style_admin/forum_admin.css" rel="stylesheet">
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
    p,li,td,div{text-align:left !important;}
    <?php endif; ?>
    </style>
    <?php endif; ?>
</head>
<body style="font-family:'Candara'">

<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">
        <a href="acceuil_admin.php"><img alt="" class="navbar-brand fw-bold" src="../../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link" href="inscrits.php">Inscrits</a>
        <a class="nav-link" href="signalements.php">Signalements</a>
        <a class="nav-link" href="articles.php">Articles</a>
        <a class="nav-link fw-bold text-danger" href="forum_admin.php">Forum</a>
        <?php
        $avatar = "../";
        require_once "../avatar.php"; ?>
        <li class="nav-item dropdown fs-5">
            <a class="nav-link dropdown-toggle" style="font-weight:bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="rounded-circle" alt="pdp" src="<?= $avatar ?>" width="40px" height="40px"/> &nbsp;<?= $_SESSION["prenom"] ?> <?= $_SESSION["nom"] ?> (admin)
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="../deconnexion.php">Se deconnecter</a></li>
            </ul>
        </li>
    </div>
</nav>

<div class="container my-5">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-bold mb-0">Gestion du forum</h2>
        <span class="badge bg-danger fs-6"><?= count($sujets) ?> sujet<?= count($sujets) > 1 ? 's' : '' ?></span>
    </div>

    <?php if (isset($_GET['supprime'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Le sujet a été supprimé avec succès.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="card border-danger border-2 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-danger text-white">
            <h6 class="mb-0">Filtrer les sujets</h6>
        </div>
        <div class="card-body p-4">
            <form method="GET" action="forum_admin.php" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Rechercher</label>
                    <input type="text" name="recherche" class="form-control" placeholder="Titre, pseudo..." value="<?= htmlspecialchars($recherche) ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Catégorie</label>
                    <select name="categorie" class="form-select">
                        <option value="">Toutes les catégories</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat) ?>" <?= $categorie === $cat ? 'selected' : '' ?>><?= htmlspecialchars($cat) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-danger w-100">Rechercher</button>
                    <a href="forum_admin.php" class="btn btn-outline-secondary w-100">Reinitialiser</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-danger border-2 shadow-sm rounded-4">
        <div class="card-header bg-danger text-white">
            <h6 class="mb-0">Liste des sujets</h6>
        </div>
        <div class="card-body p-0">
            <?php if (empty($sujets)): ?>
            <p class="text-muted text-center py-5">Aucun sujet trouvé.</p>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Titre</th>
                            <th>Auteur</th>
                            <th>Catégorie</th>
                            <th>Date</th>
                            <th class="text-center">Réponses</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sujets as $sujet): ?>
                        <tr>
                            <td class="text-muted small"><?= $sujet['id_sujet'] ?></td>
                            <td class="fw-semibold"><?= htmlspecialchars($sujet['titre']) ?></td>
                            <td><?= htmlspecialchars($sujet['pseudo']) ?></td>
                            <td><span class="badge bg-danger"><?= htmlspecialchars($sujet['categorie_sujet']) ?></span></td>
                            <td class="text-muted small"><?= date('d/m/Y', strtotime($sujet['date_sujet'])) ?></td>
                            <td class="text-center"><?= $sujet['nb_reponses'] ?></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalSupprimer"
                                    data-id="<?= $sujet['id_sujet'] ?>"
                                    data-titre="<?= htmlspecialchars($sujet['titre'], ENT_QUOTES) ?>">
                                    Supprimer
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalSupprimer" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-danger border-2">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer le sujet :</p>
                <p class="fw-bold" id="modalTitreSujet"></p>
                <p class="text-muted small">Cette action supprimera également toutes les réponses associées et est irréversible.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                <form method="POST" action="forum_admin.php">
                    <input type="hidden" name="id_sujet" id="modalIdSujet">
                    <button type="submit" name="supprimer" class="btn btn-danger">Confirmer la suppression</button>
                </form>
            </div>
        </div>
    </div>
</div>

<footer class="py-3 text-center bg-danger text-white mt-5">
    © 2026 — Luca Regi, Nassim Kharfouche, Prosper Fajnzyn — Tous droits réservés
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const modalSupprimer = document.getElementById('modalSupprimer');
    modalSupprimer.addEventListener('show.bs.modal', function(e) {
        const btn = e.relatedTarget;
        document.getElementById('modalIdSujet').value    = btn.dataset.id;
        document.getElementById('modalTitreSujet').textContent = btn.dataset.titre;
    });
</script>

</body>
</html>