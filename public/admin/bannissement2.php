<?php

require_once "..\..\bdd\connexion.php";
session_start();
$id = $_POST['id'];
$nombre= rand(1000000000000, 9000000000000);
$mdp="banni".$nombre;
$sql = "UPDATE inscrit SET mot_de_passe = :mdp WHERE id_inscrit = :id";
$query = $connexion->prepare($sql);
$query->execute(array('id' => $id, 'mdp' => $mdp));
header("Location:inscrits.php");
?>
<html>
    <head>
        <link href="../../style/style_admin/bannissement2.css" rel="stylesheet">

    </head>
</html>
