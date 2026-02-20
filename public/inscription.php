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
        echo "Les mots de passe ne correspondent pas";
    }else{
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

        header('Location: public/acceuil.php');
        exit();
    }
}
?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
<form action="inscription.php" method="post">
    <label>Votre nom :</label>
    <input name="nom" id="nom" type="text" required><br>

    <label>Votre prénom :</label>
    <input name="prenom" id="prenom" type="text" required><br>

    <label>Votre âge :</label>
    <input name="age" id="age" type="number" required><br>

    <label>Votre pseudo :</label>
    <input name="pseudo" id="pseudo" type="text" required><br>

    <label>Votre ville :</label>
    <input name="ville" id="ville" type="text" required><br>

    <label>Votre email :</label>
    <input name="email" id="email" type="email" required><br>

    <label>Votre mot de passe :</label>
    <input name="mot_de_passe" id="mot_de_passe" type="password" required><br>

    <label>Confirmation du mot de passe :</label>
    <input name="conf_mdp" id="conf_mdp" type="password" required><br>

    <input type="submit" name="submit_btn" value="S'inscrire">
</form>
</body>
</html>