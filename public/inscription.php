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