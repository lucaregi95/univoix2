<?php
$connexion = null;
require_once('../../bdd/connexion.php');
session_start();

// Redirige si l'admin n'est pas connecté
if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    header("location:../connexion.php");
    exit();
}

// Si aucune recherche n'est soumise, '%' seul correspond à tout (retourne tous les inscrits)
// Sinon, encadre la valeur avec '%' pour une recherche partielle (LIKE)
if(!isset($_POST["recherche"])){
    $recherche = '%';
} else {
    $recherche = '%' . $_POST["recherche"] . '%';
}

// Recherche dans nom, prénom, pseudo et rôle
// "role != 'admin'" : exclut les administrateurs de la liste
// "mot_de_passe NOT LIKE 'banni%'" : exclut les utilisateurs bannis (leur mot de passe commence par "banni")
$sql = "SELECT nom,prenom,pseudo,email,role,importance_signalement,id_inscrit FROM inscrit WHERE (nom LIKE :recherche OR prenom LIKE :recherche OR pseudo LIKE :recherche OR role LIKE :recherche) AND role != 'admin' AND mot_de_passe NOT LIKE 'banni%' ORDER BY nom,prenom";
$query = $connexion->prepare($sql);
$query->execute(array('recherche' => $recherche));
$result = $query->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Uni'Voix - Inscrits</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../style/style_admin/inscrits.css" rel="stylesheet">
    <?php
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
            .bg-danger, footer.bg-danger { background-color: <?=$__p['p']?> !important; }
            .text-danger { color: <?=$__p['p']?> !important; }
            .btn-danger  { background-color: <?=$__p['p']?> !important; border-color: <?=$__p['pd']?> !important; color: #fff !important; }
            .btn-danger:hover { background-color: <?=$__p['pd']?> !important; }
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

<body style="font-family: 'Candara'">

<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">
        <a href="acceuil_admin.php"><img alt="" class="navbar-brand fw-bold" src="../../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link fw-bold text-danger" href="inscrits.php">Inscrits</a>
        <a class="nav-link" href="signalements.php">Signalements</a>
        <a class="nav-link" href="articles.php">Articles</a>
        <a class="nav-link" href="forum_admin.php">Forum</a>
        <?php if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])){ ?>
            <a class="navbar-brand fw-bold" href="connexion_admin.php">Connexion</a>
        <?php } else {
            $avatar = "../";
            require_once "../avatar.php"; ?>
            <li class="nav-item dropdown fs-5">
                <a class="nav-link dropdown-toggle" style="font-weight:bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="rounded-circle" alt="pdp" src="<?=$avatar?>" width="40px" height="40px"/>
                    <?=$_SESSION["prenom"]?> <?=$_SESSION["nom"]?> (admin)
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="../deconnexion.php">Se déconnecter</a></li>
                </ul>
            </li>
        <?php } ?>
    </div>
</nav>

<section class="bg-univoix py-5 bg-light">
    <div class="container">
        <div class="row g-4 text-center shadow-lg">
            <h2>Listes des inscrits</h2>
            <table class="table table-sm">
                <!-- Formulaire de recherche : soumet en POST sur la même page -->
                <form action="inscrits.php" method="POST">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label for="recherche" class="form-label" style="font-weight: bold">Rechercher un inscrit :</label><br>
                                <input name="recherche" id="recherche" type="text" placeholder="Tapez un nom, un prenom...">
                                <button class="btn btn-outline-danger btn-univoix">Rechercher</button>
                            </div>
                        </div>
                    </div>
                </form>
                <tr class="table-group-divider">
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Pseudo</th>
                    <th>Adresse e-mail</th>
                    <th>Rôle</th>
                    <th>Indice de Signalement</th>
                </tr>
                <?php foreach ($result as $resultat) { ?>
                    <tr>
                        <td><?=$resultat['nom']?></td>
                        <td><?=$resultat['prenom']?></td>
                        <td><?=$resultat['pseudo']?></td>
                        <td><?=$resultat['email']?></td>
                        <td><?=$resultat['role']?></td>
                        <td><?=$resultat['importance_signalement']?></td>
                        <td class="text-center">
                            <!-- Bouton "Gérer" : envoie l'ID de l'inscrit vers modification.php -->
                            <form method="POST" action="modification.php">
                                <button type="submit" class="btn btn-sm btn-outline-dark" title="Modifier">Gérer</button>
                                <input type="hidden" value="<?=$resultat['id_inscrit']?>" name="id">
                            </form>
                        </td>
                        <td>
                            <!-- Bouton "Bannir" : envoie l'ID vers bannissement.php pour confirmation -->
                            <form method="POST" action="bannissement.php">
                                <button class="btn btn-sm btn-outline-danger" title="Supprimer">Bannir</button>
                                <input type="hidden" value="<?=$resultat['id_inscrit']?>" name="id">
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</section>

<footer class="py-3 text-center bg-danger text-white site-footer">
    © 2026 — Luca Regi, Nassim Kharfouche, Prosper Fajnzyn — Tous droits réservés
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Affiche/masque le menu déroulant personnalisé
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Ferme le dropdown si l'utilisateur clique en dehors du bouton
    window.onclick = function(e) {
        if (!e.target.matches('.dropbtn')) {
            var myDropdown = document.getElementById("myDropdown");
            if (myDropdown.classList.contains('show')) {
                myDropdown.classList.remove('show');
            }
        }
    }
</script>
</body>
</html>