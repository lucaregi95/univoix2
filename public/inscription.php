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
    $importance_signalement = 1;
    $ville = $_POST['ville'];

    if ($_POST['mot_de_passe']!==$_POST['conf_mdp']) {
        $erreur_mdp = "Les mots de passe ne correspondent pas";
    }else{
        $sql = "INSERT INTO inscrit (nom, prenom, age, pseudo, mail, ville, mot_de_passe, role, importance_signalement) VALUES (:nom, :prenom, :age, :pseudo, :email, :ville, :mot_de_passe, :role, :importance_signalement)";
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

        $id_inscrit = $connexion->lastInsertId();

        $handicaps = json_decode($_POST['handicaps'], true);
        if(!empty($handicaps)){
            $sql2 = "INSERT INTO InscritHandicaps (ref_inscrit, ref_handicaps) VALUES (:ref_inscrit, :ref_handicaps)";
            $query2 = $connexion->prepare($sql2);
            foreach($handicaps as $id_handicap){
                $query2->execute(array(
                    "ref_inscrit" => $id_inscrit,
                    "ref_handicaps" => $id_handicap
                ));
            }
        }

        header('Location: public/acceuil.php');
        exit();
    }
}

$handicaps_list = $connexion->query("SELECT id_handicap, nom FROM Handicaps ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UniVoix - Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .form-check-input.custom-switch { width: 3rem; height: 1.5rem; background-color: #d3d3d3 !important; border-color: #d3d3d3 !important; }
        .form-check-input.custom-switch:checked { background-color: #dc3545 !important; border-color: #dc3545 !important; }
        .tag-input-box { border: 1px solid #dee2e6; border-radius: 6px; padding: 5px 8px; display: flex; flex-wrap: wrap; gap: 5px; align-items: center; cursor: text; background: #fff; min-height: 38px; transition: border-color .2s, box-shadow .2s; }
        .tag-input-box:focus-within { border-color: #dc3545; box-shadow: 0 0 0 3px rgba(220,53,69,.15); }
        .tag { display: inline-flex; align-items: center; gap: 4px; background: #dc3545; color: #fff; border-radius: 5px; padding: 2px 8px; font-size: 0.78rem; font-weight: 500; animation: tagIn .15s ease; white-space: nowrap; }
        @keyframes tagIn { from { opacity:0; transform:scale(.85); } to { opacity:1; transform:scale(1); } }
        .tag-remove { cursor: pointer; font-size: 1rem; line-height: 1; border: none; background: none; color: #fff; padding: 0; opacity: .8; }
        .tag-remove:hover { opacity: 1; }
        .tag-input-box input { border: none; outline: none; font-size: 0.875rem; flex: 1; min-width: 60px; background: transparent; color: #333; }
        .tag-dropdown { border: 1px solid #dee2e6; border-radius: 6px; margin-top: 4px; overflow: hidden; max-height: 160px; overflow-y: auto; scrollbar-width: thin; scrollbar-color: #ccc transparent; }
        .tag-dropdown::-webkit-scrollbar { width: 5px; }
        .tag-dropdown::-webkit-scrollbar-thumb { background: #ccc; border-radius: 99px; }
        .tag-option { padding: 8px 12px; font-size: 0.875rem; cursor: pointer; display: flex; align-items: center; justify-content: space-between; color: #444; transition: background .12s; user-select: none; }
        .tag-option:hover { background: #fff5f5; }
        .tag-option.selected { background: #fdf0f0; color: #dc3545; font-weight: 500; }
        .tag-option.hidden { display: none; }
        .tag-check { width: 17px; height: 17px; border-radius: 4px; border: 1.5px solid #ccc; display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: all .15s; }
        .tag-option.selected .tag-check { background: #dc3545; border-color: #dc3545; }
        .tag-option.selected .tag-check::after { content: ''; width: 4px; height: 8px; border: 2px solid #fff; border-top: none; border-left: none; transform: rotate(45deg) translateY(-1px); display: block; }
        .tag-empty { padding: 10px 12px; font-size: .85rem; color: #aaa; text-align: center; display: none; }
        .btn-help { border: 1px solid #dee2e6; background: #fff; border-radius: 6px; width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; color: #888; flex-shrink: 0; cursor: pointer; transition: all .2s; }
        .btn-help:hover { border-color: #dc3545; color: #dc3545; }
    </style>
</head>
<body class="bg-light">

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
            </svg> John Doe
        </a>
    </div>
</nav>

<div class="container my-5">
    <div class="card shadow">
        <div class="card-body">
            <h2 class="text-center mb-4">Inscription</h2>

            <?php if(isset($erreur_mdp)): ?>
                <div class="alert alert-danger"><?= $erreur_mdp ?></div>
            <?php endif; ?>

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

        <!-- Footer -->
        <div class="card-footer bg-danger text-white text-center">
            © 2026 – Luca Regl, Nassim Kharouche, Prosper Folayn – Tous droits réservés
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Troubles chargés depuis la BDD via PHP
    const troubles = <?= json_encode($handicaps_list) ?>;

    const tagBox         = document.getElementById('tagBox');
    const tagSearch      = document.getElementById('tagSearch');
    const tagDropdown    = document.getElementById('tagDropdown');
    const tagEmpty       = document.getElementById('tagEmpty');
    const handicapsInput = document.getElementById('handicapsInput');

    let selected = new Set();

    troubles.forEach(t => {
        const div = document.createElement('div');
        div.className = 'tag-option';
        div.dataset.value = t.id_handicap;
        div.dataset.label = t.nom;
        div.innerHTML = `<span>${t.nom}</span><span class="tag-check"></span>`;
        div.addEventListener('click', () => toggleTag(t.id_handicap, t.nom, div));
        tagDropdown.appendChild(div);
    });

    function toggleTag(id, label, optionEl) {
        if (selected.has(id)) {
            selected.delete(id);
            optionEl.classList.remove('selected');
            const pill = tagBox.querySelector(`.tag[data-value="${id}"]`);
            if (pill) pill.remove();
        } else {
            selected.add(id);
            optionEl.classList.add('selected');
            const pill = document.createElement('span');
            pill.className = 'tag';
            pill.dataset.value = id;
            pill.innerHTML = `${label} <button class="tag-remove" type="button">×</button>`;
            pill.querySelector('.tag-remove').addEventListener('click', e => {
                e.stopPropagation();
                toggleTag(id, label, optionEl);
            });
            tagBox.insertBefore(pill, tagSearch);
        }
        handicapsInput.value = JSON.stringify([...selected]);
    }

    tagSearch.addEventListener('input', () => {
        const q = tagSearch.value.toLowerCase();
        let anyVisible = false;
        tagDropdown.querySelectorAll('.tag-option').forEach(opt => {
            const match = opt.dataset.label.toLowerCase().includes(q);
            opt.classList.toggle('hidden', !match);
            if (match) anyVisible = true;
        });
        tagEmpty.style.display = anyVisible ? 'none' : 'block';
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