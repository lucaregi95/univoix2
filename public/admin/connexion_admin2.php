<?php

$connexion = null;
require_once('../../bdd/connexion.php');



$email = $_POST["email"];
$mdp   = $_POST["mdp"];
$page  = $_POST["page"];

// Vérifie que l'email et le mot de passe correspondent à un inscrit avec le rôle "admin"
// La condition "role='admin'" empêche un utilisateur ordinaire de se connecter au panel admin
$sql2 = "SELECT id_inscrit,nom,prenom,mot_de_passe,email,role FROM inscrit WHERE email=:email AND mot_de_passe=:mdp AND role='admin'";
$query = $connexion->prepare($sql2);
$query->execute(array(
        "email" => $email,
        "mdp"   => $mdp
));
$result = $query->fetch();

if (!$result) {
    // Aucun admin trouvé : redirige avec un paramètre d'erreur dans l'URL
    header("Location: connexion_admin.php?erreur=unknown");
} else {
    // Détruit la session existante avant d'en créer une nouvelle (évite les conflits de session)
    session_destroy();
    session_start();

    // Stocke les informations de l'admin en session
    $_SESSION['id']     = $result["id_inscrit"];
    $_SESSION['nom']    = $result["nom"];
    $_SESSION['prenom'] = $result["prenom"];
    $_SESSION['email']  = $result["email"];
    $_SESSION['pseudo'] = $result["pseudo"];
    $_SESSION['role']   = $result["role"];

    header("location:acceuil_admin.php");
}
?>
<!DOCTYPE html>
<html lang=fr>
<head>
    <meta charset="UTF-8">
    <title>Connexion en Cours</title>
    <link href="../../style/style_admin/connexion_admin2.css" rel="stylesheet">
</head>
<body>
</body>
</html>