<?php
// Démarre la session pour accéder aux préférences d'accessibilité et aux données utilisateur
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniVoix - Aides</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style/style_public/aides.css" rel="stylesheet">
    <?php
    // Récupère les préférences d'accessibilité de la session (daltonisme et dyslexie)
    $__daltonisme = isset($_SESSION['daltonisme']) ? $_SESSION['daltonisme'] : 'aucun';
    $__dyslexie   = isset($_SESSION['dyslexie'])   ? $_SESSION['dyslexie']   : false;

    // Palettes de couleurs adaptées aux différents types de daltonisme
    // Chaque palette remplace le rouge Bootstrap (#dc3545) par une couleur perceptible par le type concerné
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

    // Sélectionne la palette du daltonisme actif, ou 'aucun' par défaut
    $__p = isset($__palettes[$__daltonisme]) ? $__palettes[$__daltonisme] : $__palettes['aucun'];

    // N'injecte le bloc <style> que si l'utilisateur a activé une option d'accessibilité
    if ($__daltonisme !== 'aucun' || $__dyslexie): ?>
        <style id="accessibilite-overrides">
            <?php if ($__daltonisme !== 'aucun'): ?>
            /* Surcharge les variables CSS Bootstrap avec les couleurs de la palette choisie */
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
            .btn-outline-danger:focus-visible {
                box-shadow: 0 0 0 0.25rem rgba(<?= $__p['danger_rgb'] ?>, 0.5) !important;
            }
            .form-control:focus,
            .form-select:focus {
                border-color: <?= $__p['danger'] ?> !important;
                box-shadow: 0 0 0 0.25rem rgba(<?= $__p['danger_rgb'] ?>, 0.25) !important;
            }
            .bg-danger.bg-opacity-10 {
                background-color: rgba(<?= $__p['danger_rgb'] ?>, 0.1) !important;
            }
            .form-check-input.custom-switch:checked {
                background-color: <?= $__p['switch_on'] ?> !important;
                border-color:     <?= $__p['switch_on'] ?> !important;
            }
            .tag                          { background: <?= $__p['tag_bg'] ?> !important; }
            .tag-option.selected          { color: <?= $__p['danger'] ?> !important; }
            .tag-option:hover              { background: rgba(<?= $__p['danger_rgb'] ?>, 0.06) !important; }
            .tag-option.selected .tag-check {
                background:   <?= $__p['tag_bg'] ?> !important;
                border-color: <?= $__p['tag_bg'] ?> !important;
            }
            .tag-input-box:focus-within {
                border-color: <?= $__p['danger'] ?> !important;
                box-shadow: 0 0 0 3px rgba(<?= $__p['danger_rgb'] ?>, 0.15) !important;
            }
            .btn-help:hover {
                border-color: <?= $__p['danger'] ?> !important;
                color:        <?= $__p['danger'] ?> !important;
            }
            <?php endif; ?>

            <?php if ($__dyslexie): ?>
            /* Charge la police OpenDyslexic depuis un CDN et l'applique à tous les éléments */
            @font-face {
                font-family: 'OpenDyslexic';
                src: url('https://cdn.jsdelivr.net/npm/open-dyslexic@1.0.3/OpenDyslexic-Regular.otf') format('opentype');
                font-weight: normal;
            }
            @font-face {
                font-family: 'OpenDyslexic';
                src: url('https://cdn.jsdelivr.net/npm/open-dyslexic@1.0.3/OpenDyslexic-Bold.otf') format('opentype');
                font-weight: bold;
            }
            *, *::before, *::after      { font-family: 'OpenDyslexic', Arial, sans-serif !important; }
            body                         { line-height: 1.8 !important; letter-spacing: 0.05em !important; word-spacing: 0.15em !important; background-color: #fdfaf3 !important; }
            p, li, td, th, label, span, div, a, input, textarea, select, button
            { line-height: 1.8 !important; letter-spacing: 0.04em !important; word-spacing: 0.12em !important; }
            body, p, li, td, label       { font-size: 1.05rem !important; }
            .card, .form-control, .tag-input-box, .tag-dropdown { background-color: #fdfaf3 !important; }
            p, li, td, div               { text-align: left !important; }
            <?php endif; ?>

        </style>
    <?php endif; ?>
    <?php
    // Deuxième bloc de palette pour les variables CSS personnalisées (--color-primary-*)
    // utilisées par les composants du site qui ne dépendent pas des variables Bootstrap
    if(session_status() === PHP_SESSION_NONE) session_start();
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
                --color-primary:           <?=$__p['p']?>;
                --color-primary-dark:      <?=$__p['pd']?>;
                --color-primary-light:     <?=$__p['pl']?>;
                --color-primary-shadow-15: rgba(<?=$__p['rgb']?>,.15);
                --color-primary-shadow-25: rgba(<?=$__p['rgb']?>,.25);
                --color-primary-shadow-35: rgba(<?=$__p['rgb']?>,.35);
            }
            .navbar                             { border-color: <?=$__p['p']?> !important; }
            .bg-danger, footer.bg-danger        { background-color: <?=$__p['p']?> !important; }
            .border-danger                      { border-color: <?=$__p['p']?> !important; }
            .text-danger                        { color: <?=$__p['p']?> !important; }
            .text-primary                       { color: <?=$__p['link']?> !important; }
            .btn-danger                         { background-color: <?=$__p['p']?> !important; border-color: <?=$__p['pd']?> !important; color: #fff !important; }
            .btn-danger:hover, .btn-danger:active { background-color: <?=$__p['pd']?> !important; border-color: <?=$__p['pd']?> !important; }
            .btn-outline-danger                 { border-color: <?=$__p['p']?> !important; color: <?=$__p['p']?> !important; }
            .btn-outline-danger:hover, .btn-outline-danger:active { background-color: <?=$__p['p']?> !important; color: #fff !important; }
            .alert-danger                       { background-color: <?=$__p['pl']?> !important; border-color: <?=$__p['p']?> !important; color: <?=$__p['pd']?> !important; }
            .card.border-danger                 { border-color: <?=$__p['p']?> !important; }
            .dropdown-item:active               { background-color: <?=$__p['p']?> !important; }
            /* Cible tous les liens sauf les boutons et éléments de navigation */
            a:not(.btn):not(.nav-link):not(.navbar-brand):not(.dropdown-item) { color: <?=$__p['link']?> !important; }
            <?php endif; ?>
            <?php if ($__dyslexie): ?>
            @font-face { font-family:'OpenDyslexic'; src:url('https://cdn.jsdelivr.net/npm/open-dyslexic@1.0.3/OpenDyslexic-Regular.otf') format('opentype'); font-weight:normal; }
            @font-face { font-family:'OpenDyslexic'; src:url('https://cdn.jsdelivr.net/npm/open-dyslexic@1.0.3/OpenDyslexic-Bold.otf') format('opentype'); font-weight:bold; }
            *, *::before, *::after              { font-family: 'OpenDyslexic', Arial, sans-serif !important; }
            body                                { line-height:1.8 !important; letter-spacing:0.05em !important; word-spacing:0.15em !important; background-color:#fdfaf3 !important; }
            p,li,td,th,label,span,div,a,input,textarea,select,button { line-height:1.8 !important; letter-spacing:0.04em !important; }
            body,p,li,td,label                  { font-size:1.05rem !important; }
            .card,.form-control,.tag-input-box,.tag-dropdown { background-color:#fdfaf3 !important; }
            p,li,td,div                         { text-align:left !important; }
            <?php endif; ?>
        </style>
    <?php endif; ?>
</head>

<body>

<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">
        <a href="acceuil.php"><img alt="" class="navbar-brand fw-bold" src="../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link" href="specialistes.php">Spécialistes</a>
        <a class="nav-link" href="forum.php">Forum</a>
        <a class="nav-link fw-bold text-danger" href="aides.php">Aides</a>
        <a class="nav-link" href="presentation.php">Handicaps</a>
        <?php if(isset($_SESSION['role'])){
            if ($_SESSION['role'] == 'admin'){
                ?>
                <a class="nav-link" href="admin/connexion_admin.php">Admin</a>
            <?php }} ?>

        <?php if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])){ ?>
            <a class="navbar-brand fw-bold" href="profil.php">Connexion</a>
        <?php }
        else{
            // Charge l'avatar de l'utilisateur connecté et affiche son menu déroulant
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

<div class="page-hero text-center">
    <h1 class="display-4 fw-bold mb-3">Les Aides</h1>
    <p class=" text-muted col-lg-8 mx-auto">Sur cette page, vous trouverez la liste des aides (financières, aides Handicap, Logement…) disponibles pour les étudiants.</p>
</div>

<!-- Contenu statique : liste des aides disponibles pour les étudiants -->
<div class="container pb-5" style="max-width: 820px;">

    <div class="aide-card">
        <h2>CROUS</h2>
        <p>
            Le CROUS accompagne les étudiants et les étudiantes dans leur vie quotidienne pendant leurs études supérieures. Leur mission est d'améliorer les conditions de vie et d'études : bourses, logement, restauration, accès aux services de la vie campus. Pour étudiants. Leur service s'adresse à tous les étudiants et les étudiantes de l'académie.
        </p>
        <a target="_blank" href="https://www.lescrous.fr/" class="btn-aide">Accéder au site du CROUS</a>
    </div>

    <div class="aide-card">
        <h2>Aide au Logement (APL)</h2>
        <p>
            Les aides personnalisées au logement (APL) sont des allocations versées par la CAF ou la MSA pour réduire le montant de votre loyer. Elles sont accessibles aux étudiants locataires sous conditions de ressources, que vous soyez en résidence universitaire ou en logement privé.
        </p>
        <a target="_blank" href="https://wwwd.caf.fr/wps/portal/caffr/aidesetdemarches/mesdemarches/faireunesimulation/lelogement#/preparation" class="btn-aide">Accéder au site de la CAF</a>
    </div>

    <div class="aide-card">
        <h2>Aide Handicap – MDPH</h2>
        <p>
            La MDPH (Maison Départementale des Personnes Handicapées) propose un accompagnement personnalisé et des aménagements pour les étudiants en situation de handicap : tiers-temps, aides humaines, matérielles ou financières. Renseignez-vous auprès de votre établissement pour activer vos droits.
        </p>
        <a target="_blank" href="https://www.monparcourshandicap.gouv.fr/" class="btn-aide">Accéder au site de la MDPH</a>
    </div>

    <div class="aide-card">
        <h2>Bourses sur Critères Sociaux</h2>
        <p>
            Les bourses sur critères sociaux sont attribuées par le CROUS selon vos ressources familiales et votre situation. Elles permettent de couvrir tout ou partie des frais de scolarité et de vie. La demande se fait chaque année via le Dossier Social Étudiant (DSE) sur messervices.etudiant.gouv.fr.
        </p>
        <a target="_blank" href="https://www.lescrous.fr/dse/" class="btn-aide">Faire ma demande de bourse</a>
    </div>

    <div class="aide-card">
        <h2>Aide d'Urgence</h2>
        <p>
            En cas de difficultés financières ponctuelles (perte d'emploi, accident, rupture familiale), le CROUS peut débloquer une aide d'urgence en quelques jours. Cette aide non remboursable est accessible à tout étudiant inscrit dans un établissement d'enseignement supérieur.
        </p>
        <a target="_blank" href="https://www.etudiant.gouv.fr/fr/solliciter-une-aide-d-urgence-361" class="btn-aide">Contacter le service social du CROUS</a>
    </div>

</div>

<footer class="py-4 mt-3">
    <div class="container text-center">
        <small class="opacity-75">© 2026 – Luca Regi, Nassim Kharfouche, Prosper Fajnzyn – Tous droits réservés</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>