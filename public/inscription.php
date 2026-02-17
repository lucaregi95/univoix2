<?php

require_once "..\bdd\connexion.php";

if(isset($_POST["S'inscrire"])){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $pseudo = $_POST['pseudo'];
    $mdp = $_POST['mdp'];
    $conf_mdp= $_POST['conf_mdp'];
    $role = "inscrit";
    $imp_sign = "1";
    $age = $_POST['age'];
    $ville = $_POST['ville'];


    $sql ="INSERT INTO etudiants (nom, prenom, age, pseudo,role, importance_signalement,mail,ville, mdp) VALUES (:nom, :prenom, :age, :pseudo,:role, :importance_signalement,:email,:ville, :mdp)";
    $query = $connexion->prepare($sql);
    $query->execute(array(
            'nom' => $nom,
        'prenom' => $prenom,
        'age' => $age,
        'pseudo' => $pseudo,
        'role' => $role,
        'importance_signalement' => $imp_sign,
        'email' => $email,
        'ville' => $ville,
        'mdp' => $mdp
    ));
}
?>

<!DOCTYPE html>
<form action="acceuil.php" method="post"><br>
    <label>Votre nom :</label>
    <input name="nom" id="nom" type="text"><br>
    <label>Votre prénom :</label>
    <input name="prenom" id="prenom" type="text"><br>
    <label>Votre age :</label>
    <input name="age" id="age" type="number"><br>
    <label>Votre pseudo :</label>
    <input name="pseudo" id="pseudo" type="text"><br>
    <label>Votre email :</label>
    <input name="email" id="email" type="email"><br>
    <label>Votre mot de passe :</label>
    <input name="mdp" id="mdp" type="password"><br>
    <label>Confirmation du mot de passe :</label>
    <input name="conf_mdp" id="conf_mdp" type="password"><br>
    <input type="submit" value="S'inscrire">
</form>