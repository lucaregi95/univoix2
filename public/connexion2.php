<?php

$connexion = null;
require_once('../bdd/connexion.php');

// Récupération des données du formulaire de connexion
$email = $_POST["email"];
$mdp   = $_POST["mdp"];
if(isset($_POST["page"])){
$page  = $_POST["page"];}

// Requête préparée : sélectionne l'utilisateur correspondant à l'email et au mot de passe
$sql2  = "SELECT id_inscrit,nom,prenom,mot_de_passe,email,role,daltonisme,dyslexie FROM inscrit WHERE email=:email AND mot_de_passe=:mdp";
$query = $connexion->prepare($sql2);
$query->execute(array(
        "email" => $email,
        "mdp"   => $mdp
));
$result = $query->fetch();

if (!$result) {
    // Aucun utilisateur trouvé : redirection avec message d'erreur
    header("Location: connexion.php?erreur=unknown");
} else {

    session_start();
    // Stockage des informations de l'utilisateur en session
    $_SESSION['id']     = $result["id_inscrit"];
    $_SESSION['nom']    = $result["nom"];
    $_SESSION['prenom'] = $result["prenom"];
    $_SESSION['email']  = $result["email"];
    $_SESSION['pseudo'] = $result["pseudo"];
    $_SESSION['role']   = $result["role"];

    // Si daltonisme non renseigné en BDD, on met 'aucun' par défaut
    $_SESSION['daltonisme'] = $result['daltonisme'] ? $result['daltonisme'] : 'aucun';
    // Convertit la valeur BDD (0 ou 1) en booléen PHP
    $_SESSION['dyslexie']   = (bool)$result['dyslexie'];

    // Redirection vers la page demandée avant la connexion
    if(isset($_POST['page'])){
        if ($_POST['page'] == 'f'){
            header("location:forum.php");
        } else if($_POST['page'] == 'p'){
            header("location:profil.php");
        } else if($_POST['page'] == 'sp'){
            header("location:specialistes.php");
        }
        else {
            header("location:acceuil.php");
        }
    } else {
        header("location:acceuil.php");
    }

    ?>
    <!DOCTYPE html>
    <html lang=fr>
    <head>
        <meta charset="UTF-8">
        <title>Connexion en Cours</title>
        <link href="../style/style_public/connexion2.css" rel="stylesheet">
    </head>
    <body>
    </body>
    </html>
<?php } ?>