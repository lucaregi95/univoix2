<?php
require_once "..\..\bdd\connexion.php";
session_start();
if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    header("location:../connexion.php");
    exit();
}

// Récupère l'ID de l'inscrit à modifier depuis le formulaire inscrits.php
$id_inscrit = $_POST['id'];

// Récupère les informations actuelles de l'inscrit à afficher
$sql = "SELECT nom,prenom,pseudo,email,importance_signalement,role,id_inscrit FROM inscrit WHERE id_inscrit = :id";
$query = $connexion->prepare($sql);
$query->execute(array('id' => $id_inscrit));
$result = $query->fetch();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Uni'Voix - Modification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../../style/style_admin/modification.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="font-family: 'Candara'">

<nav class="navbar navbar-expand-sm navbar-light bg-light border border-danger border-3">
    <div class="container d-flex justify-content-evenly align-items-center">
        <a href="acceuil_admin.php"><img alt="" class="navbar-brand fw-bold" src="../../img/univoix.png" style="max-width:50px;"></a>
        <a class="nav-link" href="inscrits.php">Inscrits</a>
        <a class="nav-link" href="signalements.php">Signalements</a>
        <?php if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])){ ?>
            <a class="navbar-brand fw-bold" href="profil.php">Connexion</a>
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
        <a href="inscrits.php" class="btn btn-danger">Retour</a>
        <div class="row g-4 text-center shadow-lg pb-3">
            <h2 style="font-weight: bold">Modification de <?=$result["prenom"]?> <?=$result["nom"]?> :</h2>
            <h4>Pseudo : <?=$result["pseudo"]?><br>Adresse E-mail : <?=$result["email"]?><br>Indice de Signalement : <?=$result["importance_signalement"]?><br>Role : <?=$result["role"]?> </h4>

            <div class="d-flex flex-column align-items-center gap-3">

                <?php if(isset($_POST["role"])){
                    // Si l'admin a choisi "specialiste", affiche un champ supplémentaire pour la spécialité
                    if($_POST["role"] == "specialiste"){ ?>
                        <div>
                            <form method="post" action="modification2.php">
                                <div class="card card-body" style="min-width: 300px">
                                    <div class="pb-3">
                                        <label class="form-label" for="role">Role : </label>
                                        <input type="text" value="Specialiste" name="role" id="role" disabled><br><br>
                                        <label class="form-label" for="specialite">Specialité : </label>
                                        <input type="text" placeholder="Psychologue, Diabétologue..." id="specialite" name="specialite"><br><br>
                                        <?php
                                        // Résolution de l'avatar de l'inscrit pour affichage
                                        $avatar2 = "../";
                                        $id      = $id_inscrit;
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
                                        <label class="form-label" for="avatar">Avatar :</label><br>
                                        <img alt="Photo du spécialiste" class="border border-danger border-2" src="<?=$avatar?>" style="max-width: 300px;max-height: 300px">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col">
                                        <button type="submit" class="btn btn-danger">Confirmer</button>
                                    </div>
                                    <div class="col">
                                        <!-- formaction remplace l'action du formulaire pour ce seul bouton -->
                                        <button formaction="modification.php" class="btn btn-danger">Annuler</button>
                                    </div>
                                </div>
                                <!-- Transmet l'ID et le rôle choisi vers modification2.php -->
                                <input type="hidden" value="<?=$id_inscrit?>" name="id">
                                <?php if (isset($_POST["role"])){ ?>
                                    <input type="hidden" value="<?=$_POST["role"]?>" name="role2">
                                <?php } ?>
                            </form>
                        </div>

                    <?php }else if($_POST["role"] == "admin"){?>

                    <div>
                        <form method="post" action="modification2.php">
                            <div class="card card-body" style="min-width: 300px">
                                <div class="pb-3">
                                    <label class="form-label" for="role">Role :</label>
                                    <input type="text" value="Admin" name="role" id="role" disabled><br><br>
                                    <?php
                                    // Résolution de l'avatar de l'inscrit pour affichage
                                    $avatar2 = "../";
                                    $id      = $id_inscrit;
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
                                    <label class="form-label" for="avatar">Avatar :</label><br>
                                    <img alt="Photo du spécialiste" class="border border-danger border-2" src="<?=$avatar?>" style="max-width: 300px;max-height: 300px">
                                </div>
                            </div>
                            <h4 class="fw-bold">Etes-vous surs de passer <?=$result["prenom"]?> <?=$result["nom"]?> en tant qu'administrateur ?</h4>
                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="btn btn-danger">Confirmer</button>
                                </div>
                                <div class="col">
                                    <!-- formaction remplace l'action du formulaire pour ce seul bouton -->
                                    <button formaction="modification.php" class="btn btn-danger">Annuler</button>
                                </div>
                            </div>
                            <!-- Transmet l'ID et le rôle choisi vers modification2.php -->
                            <input type="hidden" value="<?=$id_inscrit?>" name="id">
                            <?php if (isset($_POST["role"])){ ?>
                                <input type="hidden" value="<?=$_POST["role"]?>" name="role2">
                            <?php } ?>
                        </form>
                    </div>

                    <?php }else if($_POST["role"] == "user"){?>
                        <div>
                            <form method="post" action="modification2.php">
                                <div class="card card-body" style="min-width: 300px">
                                    <div class="pb-3">
                                        <label class="form-label" for="role">Role :</label>
                                        <input type="text" value="Admin" name="role" id="role" disabled><br><br>
                                        <?php
                                        // Résolution de l'avatar de l'inscrit pour affichage
                                        $avatar2 = "../";
                                        $id      = $id_inscrit;
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
                                        <label class="form-label" for="avatar">Avatar :</label><br>
                                        <img alt="Photo du spécialiste" class="border border-danger border-2" src="<?=$avatar?>" style="max-width: 300px;max-height: 300px">
                                    </div>
                                </div>
                                <h4 class="fw-bold">Etes-vous surs de rétrograder <?=$result["prenom"]?> <?=$result["nom"]?> en tant qu'utilisateur ?</h4>
                                <div class="row">
                                    <div class="col">
                                        <button type="submit" class="btn btn-danger">Confirmer</button>
                                    </div>
                                    <div class="col">
                                        <!-- formaction remplace l'action du formulaire pour ce seul bouton -->
                                        <button formaction="modification.php" class="btn btn-danger">Annuler</button>
                                    </div>
                                </div>
                                <!-- Transmet l'ID et le rôle choisi vers modification2.php -->
                                <input type="hidden" value="<?=$id_inscrit?>" name="id">
                                <?php if (isset($_POST["role"])){ ?>
                                    <input type="hidden" value="<?=$_POST["role"]?>" name="role2">
                                <?php } ?>
                            </form>
                        </div>




                    <?php }} else { ?>
                    <!-- Si aucun rôle n'a encore été choisi : affiche le bouton "Promouvoir" avec un champ de saisie libre -->
                    <div>
                        <button class="btn btn-danger" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false">
                            Promouvoir
                        </button>
                        <div class="collapse mt-2" id="collapseExample">
                            <div class="card card-body" style="min-width: 300px">
                                <form method="post" action="modification.php">
                                    <div class="pb-3">
                                        <!-- L'admin saisit le nouveau rôle (user, admin, specialiste...) -->
                                        <input type="text" placeholder="user, admin, specialiste..." name="role">
                                        <input type="hidden" value="<?=$id_inscrit?>" name="id">
                                    </div>
                                    <button type="submit" class="btn btn-danger">Valider</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
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

<footer class="py-3 text-center bg-danger text-white site-footer">
    © 2026 — Luca Regi, Nassim Kharfouche, Prosper Fajnzyn — Tous droits réservés
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>