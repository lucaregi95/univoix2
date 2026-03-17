<?php
session_start();
require_once("../bdd/connexion.php");

// Réservé aux admins
if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    header("location:connexion.php?page=f");
    exit();
}
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("location:acceuil.php");
    exit();
}

// Récupération des signalements avec les pseudos des deux parties
$sql = "SELECT 
            s.date,
            s.description,
            i1.pseudo AS signalant,
            i2.pseudo AS signale
        FROM signalement s
        INNER JOIN inscrit i1 ON i1.id_inscrit = s.ref_signalant
        INNER JOIN inscrit i2 ON i2.id_inscrit = s.ref_signale
        ORDER BY s.date DESC";

$query = $connexion->prepare($sql);
$query->execute();
$signalements = $query->fetchAll(PDO::FETCH_ASSOC);

$avatar = null;
require_once("avatar.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UniVoix - Signalements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        ul, li { list-style-type: none; }
    </style>
    <?php
    $__daltonisme = isset($_SESSION['daltonisme']) ? $_SESSION['daltonisme'] : 'aucun';
    $__dyslexie   = isset($_SESSION['dyslexie'])   ? $_SESSION['dyslexie']   : false;

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
            'p'                    => '#dc3545',
            'pd'                   => '#b02a37',
            'pl'                   => '#f8d7da',
            'rgb'                  => '220,53,69',
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
            'p'                    => '#0055cc',
            'pd'                   => '#003d99',
            'pl'                   => '#cce0ff',
            'rgb'                  => '0,85,204',
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
            'p'                    => '#cc3300',
            'pd'                   => '#992200',
            'pl'                   => '#ffe5dd',
            'rgb'                  => '204,51,0',
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
            'p'                    => '#6600cc',
            'pd'                   => '#4d0099',
            'pl'                   => '#ead5ff',
            'rgb'                  => '102,0,204',
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
                --color-primary:            <?= $__p['p'] ?>;
                --color-primary-dark:       <?= $__p['pd'] ?>;
                --color-primary-light:      <?= $__p['pl'] ?>;
                --color-primary-shadow-15:  rgba(<?= $__p['rgb'] ?>,.15);
                --color-primary-shadow-25:  rgba(<?= $__p['rgb'] ?>,.25);
                --color-primary-shadow-35:  rgba(<?= $__p['rgb'] ?>,.35);
            }
            .navbar                             { border-color: <?= $__p['p'] ?> !important; }
            .bg-danger, footer.bg-danger        { background-color: <?= $__p['p'] ?> !important; }
            .border-danger                      { border-color: <?= $__p['p'] ?> !important; }
            .text-danger                        { color: <?= $__p['p'] ?> !important; }
            .text-primary                       { color: <?= $__p['link'] ?> !important; }
            .btn-danger                         { background-color: <?= $__p['p'] ?> !important; border-color: <?= $__p['pd'] ?> !important; color: #fff !important; }
            .btn-danger:hover, .btn-danger:active { background-color: <?= $__p['pd'] ?> !important; border-color: <?= $__p['pd'] ?> !important; }
            .btn-danger:focus-visible           { box-shadow: 0 0 0 0.25rem rgba(<?= $__p['danger_rgb'] ?>, 0.5) !important; }
            .btn-outline-danger                 { border-color: <?= $__p['p'] ?> !important; color: <?= $__p['p'] ?> !important; }
            .btn-outline-danger:hover, .btn-outline-danger:active { background-color: <?= $__p['p'] ?> !important; color: #fff !important; }
            .btn-outline-danger:focus-visible   { box-shadow: 0 0 0 0.25rem rgba(<?= $__p['danger_rgb'] ?>, 0.5) !important; }
            .alert-danger                       { background-color: <?= $__p['pl'] ?> !important; border-color: <?= $__p['p'] ?> !important; color: <?= $__p['pd'] ?> !important; }
            .card.border-danger                 { border-color: <?= $__p['p'] ?> !important; }
            .dropdown-item:active               { background-color: <?= $__p['p'] ?> !important; }
            .form-control:focus, .form-select:focus { border-color: <?= $__p['danger'] ?> !important; box-shadow: 0 0 0 0.25rem rgba(<?= $__p['danger_rgb'] ?>, 0.25) !important; }
            .bg-danger.bg-opacity-10            { background-color: rgba(<?= $__p['danger_rgb'] ?>, 0.1) !important; }
            a:not(.btn):not(.nav-link):not(.navbar-brand):not(.dropdown-item) { color: <?= $__p['link'] ?> !important; }
            <?php endif; ?>
            <?php if ($__dyslexie): ?>
            @font-face { font-family:'OpenDyslexic'; src:url('https://cdn.jsdelivr.net/npm/open-dyslexic@1.0.3/OpenDyslexic-Regular.otf') format('opentype'); font-weight:normal; }
            @font-face { font-family:'OpenDyslexic'; src:url('https://cdn.jsdelivr.net/npm/open-dyslexic@1.0.3/OpenDyslexic-Bold.otf') format('opentype'); font-weight:bold; }
            *, *::before, *::after              { font-family: 'OpenDyslexic', Arial, sans-serif !important; }
            body                                { line-height:1.8 !important; letter-spacing:0.05em !important; word-spacing:0.15em !important; background-color:#fdfaf3 !important; }
            p,li,td,th,label,span,div,a,input,textarea,select,button { line-height:1.8 !important; letter-spacing:0.04em !important; word-spacing:0.12em !important; }
            body,p,li,td,label                  { font-size:1.05rem !important; }
            .card,.form-control                 { background-color:#fdfaf3 !important; }
            p,li,td,div                         { text-align:left !important; }
            <?php endif; ?>
        </style>
    <?php endif; ?>
</head>
<body class="bg-light" style="font-family:'Candara'">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">
        <a href="acceuil.php"><img alt="" class="navbar-brand fw-bold" src="../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link" href="specialistes.php">Spécialistes</a>
        <a class="nav-link" href="forum.php">Forum</a>
        <a class="nav-link" href="aides.php">Aides</a>
        <a class="nav-link" href="presentation.php">Handicaps</a>
        <a class="nav-link fw-bold text-danger" href="admin/connexion_admin.php">Admin</a>
        <li class="nav-item dropdown fs-5">
            <a class="nav-link dropdown-toggle" style="font-weight:bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="rounded-circle" alt="pdp" src="<?= $avatar ?>" width="40px" height="40px"/>
                &nbsp;<?= $_SESSION["prenom"] ?> <?= $_SESSION["nom"] ?>
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="profil.php">Profil</a></li>
                <li><a class="dropdown-item" href="deconnexion.php">Se déconnecter</a></li>
            </ul>
        </li>
    </div>
</nav>

<!-- HEADER -->
<header class="bg-white py-5 border-bottom">
    <div class="container text-center">
        <h1 class="display-5 fw-bold text-danger mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-flag me-2" viewBox="0 0 16 16">
                <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12 12 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A20 20 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a20 20 0 0 0 1.361-.519z"/>
            </svg>
            Signalements
        </h1>
        <p class="lead text-muted col-lg-8 mx-auto">
            Liste de tous les signalements effectués par les utilisateurs
        </p>
    </div>
</header>

<div class="container my-5">

    <!-- COMPTEUR -->
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="fw-bold mb-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-exclamation-triangle me-2 text-danger" viewBox="0 0 16 16">
                    <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.15.15 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.2.2 0 0 1-.054.06.1.1 0 0 1-.066.017H1.146a.1.1 0 0 1-.066-.017.2.2 0 0 1-.054-.06.18.18 0 0 1 .002-.183L7.884 2.073a.15.15 0 0 1 .054-.057m1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767z"/>
                    <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
                </svg>
                Signalements récents
                <span class="badge bg-danger ms-2"><?= count($signalements) ?> signalement<?= count($signalements) > 1 ? 's' : '' ?></span>
            </h5>
        </div>
    </div>

    <!-- TABLEAU -->
    <div class="card border-danger border-3 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-danger">
                <tr>
                    <th class="py-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person me-2" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4"/>
                        </svg>
                        Signalant
                    </th>
                    <th class="py-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-x me-2" viewBox="0 0 16 16">
                            <path d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m.256 7a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m-.646-4.854.646.647.646-.647a.5.5 0 0 1 .708.708l-.647.646.647.646a.5.5 0 0 1-.708.708l-.646-.647-.646.647a.5.5 0 0 1-.708-.708l.647-.646-.647-.646a.5.5 0 0 1 .708-.708"/>
                        </svg>
                        Signalé
                    </th>
                    <th class="py-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-left-text me-2" viewBox="0 0 16 16">
                            <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                            <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6m0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                        </svg>
                        Description
                    </th>
                    <th class="py-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar3 me-2" viewBox="0 0 16 16">
                            <path d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857z"/>
                            <path d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2m3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                        </svg>
                        Date
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php if(empty($signalements)){ ?>
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-inbox text-muted mb-3" viewBox="0 0 16 16">
                                <path d="M4.98 4a.5.5 0 0 0-.39.188L1.54 8H6a.5.5 0 0 1 .5.5 1.5 1.5 0 1 0 3 0A.5.5 0 0 1 10 8h4.46l-3.05-3.812A.5.5 0 0 0 11.02 4zm-1.17-.437A1.5 1.5 0 0 1 4.98 3h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1 .106.374l-.39 3.124A1.5 1.5 0 0 1 14.117 13H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .106-.374z"/>
                            </svg>
                            <p class="text-muted fw-semibold mb-0">Aucun signalement</p>
                            <small class="text-muted">Aucun utilisateur n'a été signalé pour le moment</small>
                        </td>
                    </tr>
                <?php } else { ?>
                    <?php foreach($signalements as $signalement){ ?>
                        <tr>
                            <td class="py-3">
                                    <span class="badge bg-light text-dark border">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-person-fill me-1" viewBox="0 0 16 16">
                                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                                        </svg>
                                        <?= htmlspecialchars($signalement['signalant']) ?>
                                    </span>
                            </td>
                            <td class="py-3">
                                    <span class="badge bg-danger rounded-pill px-3">
                                        <?= htmlspecialchars($signalement['signale']) ?>
                                    </span>
                            </td>
                            <td class="py-3 text-muted">
                                <?= htmlspecialchars($signalement['description']) ?>
                            </td>
                            <td class="py-3 text-muted">
                                <?= date('d/m/Y', strtotime($signalement['date'])) ?>
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