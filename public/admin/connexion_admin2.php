<?php

$connexion = null;
require_once('../../bdd/connexion.php');


$email=$_POST["email"];
$mdp=$_POST["mdp"];
$page=$_POST["page"];

$sql2="SELECT id_inscrit,nom,prenom,mot_de_passe,email,role FROM inscrit WHERE email=:email AND mot_de_passe=:mdp AND role='admin'";
$query = $connexion->prepare($sql2);

$query->execute(array(
    "email"=>$email,
    "mdp"=>$mdp
));
$result = $query->fetch();

if (!$result) {
    header("Location: connexion_admin.php?erreur=unknown");
}
else{
    session_destroy();

    session_start();
    $_SESSION['id']=$result["id_inscrit"];
    $_SESSION['nom'] = $result["nom"];
    $_SESSION['prenom'] = $result["prenom"];
    $_SESSION['email'] = $result["email"];
    $_SESSION['pseudo'] = $result["pseudo"];
    $_SESSION['role'] = $result["role"];
    header("location:acceuil_admin.php");
    }

    ?>
    <!DOCTYPE html>

    <html lang=fr>
    <head>
        <meta charset="UTF-8">
        <title>Connexion en Cours</title>
    </head>
    <body>
    </body>
    </html>


