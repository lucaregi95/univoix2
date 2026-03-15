<?php

require_once "../bdd/connexion.php";

if(isset($_POST["submit_btn"])){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = $_POST['age'];
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    $role = "user";
    $importance_signalement = 0;
    $ville = $_POST['ville'];
    $compteur=0;
    $sql3 = "SELECT email,pseudo FROM inscrit";
    $query3 = $connexion->prepare($sql3);
    $query3->execute();
    $resutl3 = $query3->fetchAll();
    foreach ($resutl3 as $row3) {
        if ($row3['email'] == $email) {
            $compteur = 1;
        }
        if ($row3['pseudo'] == $pseudo) {
            $compteur = 2;
        }
    }
    if ($_POST['mot_de_passe']!=$_POST['conf_mdp']) {
        $erreur_mdp = "Les mots de passe ne correspondent pas";
    }else if($compteur==1){
        $erreur_mdp = "L'adresse e-mail est deja utilisée";
    }else if($compteur==2){
        $erreur_mdp = "Le pseudo est deja utilisé";
    }
    else{
        $sql = "INSERT INTO inscrit (nom, prenom, age, pseudo, email, ville, mot_de_passe, role, importance_signalement) VALUES (:nom, :prenom, :age, :pseudo, :email, :ville, :mot_de_passe, :role, :importance_signalement)";
        $query = $connexion->prepare($sql);
        $query->execute(array(
                "nom" => $nom,
                "prenom" => $prenom,
                "age" => $age,
                "pseudo" => $pseudo,
                "email" => $email,
                "mot_de_passe" => $mot_de_passe,
                "role" => $role,
                "importance_signalement" => $importance_signalement,
                "ville" => $ville
        ));

        $id_inscrit = $connexion->lastInsertId(); // lastInsertId = récuperer l'id pour la mettre dans la bdd

        $handicaps = json_decode($_POST['handicaps'], true); //  json_decode = Récuperer une chaine encode et la convertir en valeur / le true c'est quand la valeur retourné comme le tableau asso
        if(!empty($handicaps)){
            $sql2 = "INSERT INTO inscrithandicap (ref_inscrit, ref_handicap) VALUES (:ref_inscrit, :ref_handicap)";
            $query2 = $connexion->prepare($sql2);
            foreach($handicaps as $id_handicap){
                $query2->execute(array(
                        "ref_inscrit" => $id_inscrit,
                        "ref_handicap" => $id_handicap
                ));
            }
        }
        header('Location: connexion.php');
        exit();
    }
}

$handicaps_list = $connexion->query("SELECT id_handicap, nom FROM handicap ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UniVoix - Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style/style_public/inscription.css" rel="stylesheet">
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

    <?php endif;  ?>

    <?php if ($__dyslexie): ?>

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
    <?php endif;  ?>

    </style>
    <?php endif; ?>
    <?php

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
<body class="bg-light" style="font-family:'Candara'">

<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">
        <a href="acceuil.php"><img alt="" class="navbar-brand fw-bold" src="../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link" href="specialistes.php">Spécialistes</a>
        <a class="nav-link" href="forum.php">Forum</a>
        <a class="nav-link" href="aides.php">Aides</a>
        <a class="nav-link" href="presentation.php">Handicaps</a>
        <a class="navbar-brand fw-bold" href="profil.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 20 20">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
            </svg> Connexion
        </a>
    </div>
</nav>

<div class="container my-5">
    <div class="card shadow">
        <div class="card-body">
            <h2 class="text-center mb-4">Inscription</h2>

            <?php if(isset($erreur_mdp)) { ?>
                <div class="alert alert-danger"><?= $erreur_mdp ?></div>
            <?php } ?>

            <form action="inscription.php" method="post">
                <input type="hidden" name="handicaps" id="handicapsInput">
                <div class="row">
                    <!-- Colonne gauche -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Votre nom :</label>
                            <input name="nom" id="nom" type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Votre prénom :</label>
                            <input name="prenom" id="prenom" type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Votre âge :</label>
                            <input name="age" id="age" type="number" min="1" max="120" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Votre ville :</label>
                            <input name="ville" id="ville" type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Votre e-mail :</label>
                            <input name="email" id="email" type="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Votre pseudo :</label>
                            <input name="pseudo" id="pseudo" type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Votre mot de passe :</label>
                            <input name="mot_de_passe" id="mot_de_passe" type="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirmation du mot de passe :</label>
                            <input name="conf_mdp" id="conf_mdp" type="password" class="form-control">
                        </div>
                    </div>

                    <!-- Colonne droite -->
                    <div class="col-md-6">
                        <label class="form-label">Handicaps</label>

                        <div class="d-flex gap-2 align-items-start mb-1">
                            <div class="tag-input-box flex-grow-1" id="tagBox" onclick="document.getElementById('tagSearch').focus()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="#aaa" class="bi bi-search flex-shrink-0" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                </svg>
                                <input type="text" id="tagSearch" placeholder="Rechercher un trouble...">
                            </div>
                            <button type="button" class="btn-help" title="Sélectionnez un ou plusieurs troubles dans la liste" onclick="alert('Cliquez sur un trouble dans la liste pour l\'ajouter. Cliquez à nouveau pour le retirer.')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                    <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286m1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94"/>
                                </svg>
                            </button>
                        </div>

                        <!-- DROPDOWN LIST -->
                        <div class="tag-dropdown" id="tagDropdown">
                            <div class="tag-empty" id="tagEmpty">Aucun résultat</div>
                        </div>
                    </div>
                </div>

                <!-- Bouton -->
                <div class="text-center mt-4">
                    <button type="submit" name="submit_btn" value="S'inscrire" class="btn btn-danger">Valider l'inscription !</button>
                </div>
            </form>
        </div>


    </div>
</div>
<footer class="py-3 text-center bg-danger text-white">
    © 2026 — Luca Regi, Nassim Kharfouche, Prosper Fajnzyn — Tous droits réservés
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const troubles = <?= json_encode($handicaps_list) ?>;
    const selected = new Set();
    const tagSearch      = document.getElementById('tagSearch');
    const tagBox         = document.getElementById('tagBox');
    const tagDropdown    = document.getElementById('tagDropdown');
    const tagEmpty       = document.getElementById('tagEmpty');
    const handicapsInput = document.getElementById('handicapsInput');

    troubles.forEach(t => {
        const div = document.createElement('div');
        div.className = 'tag-option';
        div.dataset.value = t.id_handicap;
        div.dataset.label = t.nom;
        div.innerHTML = `<span>${t.nom}</span><div class="tag-check"></div>`;
        div.addEventListener('click', () => toggle(t.id_handicap, t.nom, div));
        tagDropdown.insertBefore(div, tagEmpty);
    });

    function toggle(id, label, el) {
        if (selected.has(id)) {
            selected.delete(id);
            el.classList.remove('selected');
            tagBox.querySelector(`.tag[data-value="${id}"]`)?.remove();
        } else {
            selected.add(id);
            el.classList.add('selected');
            addTag(id, label);
        }
        handicapsInput.value = JSON.stringify([...selected]);
        tagSearch.focus();
    }

    function addTag(id, label) {
        const tag = document.createElement('span');
        tag.className = 'tag';
        tag.dataset.value = id;
        tag.innerHTML = `${label}<button class="tag-remove" title="Retirer">×</button>`;
        tag.querySelector('.tag-remove').addEventListener('click', e => {
            e.stopPropagation();
            selected.delete(id);
            tag.remove();
            tagDropdown.querySelector(`.tag-option[data-value="${id}"]`)?.classList.remove('selected');
            handicapsInput.value = JSON.stringify([...selected]);
        });
        tagBox.insertBefore(tag, tagSearch);
    }

    tagSearch.addEventListener('input', () => {
        const q = tagSearch.value.toLowerCase().trim();
        let visible = 0;
        tagDropdown.querySelectorAll('.tag-option').forEach(item => {
            const match = item.dataset.label.toLowerCase().includes(q);
            item.classList.toggle('hidden', !match);
            if (match) visible++;
        });
        tagEmpty.style.display = visible === 0 ? 'block' : 'none';
    });

    tagSearch.addEventListener('keydown', e => {
        if (e.key === 'Backspace' && tagSearch.value === '' && selected.size > 0) {
            const last = [...selected].pop();
            selected.delete(last);
            tagBox.querySelector(`.tag[data-value="${last}"]`)?.remove();
            tagDropdown.querySelector(`.tag-option[data-value="${last}"]`)?.classList.remove('selected');
            handicapsInput.value = JSON.stringify([...selected]);
        }
    });

    tagSearch.addEventListener('focus', () => { tagDropdown.style.display = 'block'; });
    document.addEventListener('click', e => {
        if (!tagBox.contains(e.target) && !tagDropdown.contains(e.target)) {
            tagDropdown.style.display = 'none';
        }
    });
</script>
</body>
</html>