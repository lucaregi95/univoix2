<?php
require_once "../bdd/connexion.php";
session_start();

// Redirige vers la connexion si l'utilisateur n'est pas connecté
if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    header("location:connexion.php?page=f");
    exit();
}

// Récupère les filtres depuis l'URL (GET)
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

// "WHERE 1=1" est une astuce pour pouvoir ajouter des "AND" dynamiquement sans condition initiale
// La sous-requête COUNT(*) compte les réponses de chaque sujet directement dans la requête principale
$sql = " SELECT sujet.id_sujet, sujet.titre, sujet.date_sujet, sujet.categorie_sujet, inscrit.pseudo,(SELECT COUNT(*) FROM reponse WHERE reponse.ref_sujet = sujet.id_sujet) as nb_reponses FROM sujet INNER JOIN inscrit ON sujet.ref_inscrit = inscrit.id_inscrit WHERE 1=1 ";

// Tableau des paramètres PDO, construit dynamiquement selon les filtres actifs
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

// PDO::FETCH_COLUMN retourne un tableau simple (une seule colonne) au lieu d'un tableau associatif
$categories = $connexion->query("SELECT DISTINCT categorie_sujet FROM sujet ORDER BY categorie_sujet")->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UniVoix - Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style/style_public/forum.css" rel="stylesheet">
    <?php
    $__daltonisme = isset($_SESSION['daltonisme']) ? $_SESSION['daltonisme'] : 'aucun';
    $__dyslexie   = isset($_SESSION['dyslexie'])   ? $_SESSION['dyslexie']   : false;

    // Palettes de couleurs adaptées aux différents types de daltonisme
    $__palettes = [
            'aucun' => [
                    'danger'               => '#dc3545',
                    'danger_rgb'           => '220,53,69',
                    'danger_text_emphasis' => '#58151c',
                    'danger_bg_subtle'     => '#f8d7da',
                    'danger_border_subtle' => '#f1aeb5',
                    'link'                 => '#0d6efd',
                    'link_rgb'             => '13,110,253',
                    'tag_bg'               => '#dc3545',
                    'switch_on'            => '#dc3545',
            ],
            'deuteranopie' => [
                    'danger'               => '#0055cc',
                    'danger_rgb'           => '0,85,204',
                    'danger_text_emphasis' => '#002a66',
                    'danger_bg_subtle'     => '#cce0ff',
                    'danger_border_subtle' => '#99c1ff',
                    'link'                 => '#e07b00',
                    'link_rgb'             => '224,123,0',
                    'tag_bg'               => '#0055cc',
                    'switch_on'            => '#0055cc',
            ],
            'tritanopie' => [
                    'danger'               => '#cc3300',
                    'danger_rgb'           => '204,51,0',
                    'danger_text_emphasis' => '#661a00',
                    'danger_bg_subtle'     => '#ffe5dd',
                    'danger_border_subtle' => '#ffbba8',
                    'link'                 => '#007a33',
                    'link_rgb'             => '0,122,51',
                    'tag_bg'               => '#cc3300',
                    'switch_on'            => '#cc3300',
            ],
            'protanopie' => [
                    'danger'               => '#6600cc',
                    'danger_rgb'           => '102,0,204',
                    'danger_text_emphasis' => '#330066',
                    'danger_bg_subtle'     => '#ead5ff',
                    'danger_border_subtle' => '#cc99ff',
                    'link'                 => '#007acc',
                    'link_rgb'             => '0,122,204',
                    'tag_bg'               => '#6600cc',
                    'switch_on'            => '#6600cc',
            ],
    ];
    $__p = isset($__palettes[$__daltonisme]) ? $__palettes[$__daltonisme] : $__palettes['aucun'];
    if ($__daltonisme !== 'aucun' || $__dyslexie): ?>
        <style id="accessibilite-overrides">
            <?php if ($__daltonisme !== 'aucun'): ?>
            :root {
                --bs-danger:                <?= $__p['danger'] ?>;
                --bs-danger-rgb:            <?= $__p['danger_rgb'] ?>;
                --bs-danger-text-emphasis:  <?= $__p['danger_text_emphasis'] ?>;
                --bs-danger-bg-subtle:      <?= $__p['danger_bg_subtle'] ?>;
                --bs-danger-border-subtle:  <?= $__p['danger_border_subtle'] ?>;
                --bs-link-color:            <?= $__p['link'] ?>;
                --bs-link-color-rgb:        <?= $__p['link_rgb'] ?>;
                --bs-link-hover-color:      <?= $__p['danger'] ?>;
            }
            .btn-danger:hover,
            .btn-danger:active,
            .btn-danger:focus-visible {
                background-color: <?= $__p['danger_text_emphasis'] ?> !important;
                border-color:     <?= $__p['danger_text_emphasis'] ?> !important;
            }
            .btn-danger:focus-visible {
                box-shadow: 0 0 0 0.25rem rgba(<?= $__p['danger_rgb'] ?>, 0.5) !important;
            }
            .btn-outline-danger:hover,
            .btn-outline-danger:active {
                background-color: <?= $__p['danger'] ?> !important;
                border-color:     <?= $__p['danger'] ?> !important;
                color: #fff !important;
            }
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
<body>

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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Forum</h2>
        <a href="creation_sujet.php" class="btn btn-danger px-4">Créer un sujet</a>
    </div>

    <!-- Formulaire de filtre : action vide = soumet sur la même page en GET -->
    <div class="card border-danger border-3 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form method="GET" action="">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search me-2" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                            </svg>
                            Recherche
                        </label>
                        <!-- value conserve la recherche saisie après soumission du formulaire -->
                        <input type="text" name="recherche" class="form-control form-control-lg" placeholder="Titre ou contenu..." value="<?= htmlspecialchars($recherche) ?>">
                    </div>
                    <div class="col-md-4">
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
                                <!-- Marque l'option "selected" si elle correspond au filtre actif -->
                                <option value="<?= htmlspecialchars($cat) ?>" <?= $categorie === $cat ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat) ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-12 d-flex gap-2 justify-content-end">
                        <a href="forum.php" class="btn btn-outline-secondary btn-lg">Réinitialiser</a>
                        <button type="submit" class="btn btn-danger btn-lg px-4">Appliquer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-danger border-3 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-danger">
                <tr>
                    <th class="py-3">Sujet</th>
                    <th class="py-3">Date</th>
                    <th class="py-3">Auteur</th>
                    <th class="py-3">Catégorie</th>
                    <th class="text-center py-3">Réponses</th>
                </tr>
                </thead>
                <tbody>
                <?php if(empty($sujets)){ ?>
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <p class="text-muted fw-semibold mb-0">Aucun sujet trouvé</p>
                            <small class="text-muted">Essayez de modifier vos filtres ou créez un nouveau sujet</small>
                        </td>
                    </tr>
                <?php } else { ?>
                    <?php foreach($sujets as $sujet){ ?>
                        <!-- onclick sur la ligne entière : redirige vers la page du sujet -->
                        <tr class="cursor-pointer" onclick="window.location='sujet.php?id=<?= $sujet['id_sujet'] ?>'" style="cursor:pointer;">
                            <td class="py-3">
                                <span class="fw-semibold"><?= htmlspecialchars($sujet['titre']) ?></span>
                            </td>
                            <!-- strtotime convertit la date SQL en timestamp, date() la formate en français -->
                            <td class="py-3 text-muted"><?= date('d/m/Y', strtotime($sujet['date_sujet'])) ?></td>
                            <td class="py-3">
                                <span class="badge bg-light text-dark border">
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

<footer class="bg-danger text-white py-4 mt-5">
    <div class="container text-center">
        <small class="opacity-75">© 2026 – Luca Regi, Nassim Kharfouche, Prosper Fajnzyn – Tous droits réservés</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>