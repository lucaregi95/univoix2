<?php
$connexion=null;
session_start();
require_once "../../bdd/connexion.php";
$signale = $_POST["signale"];
$signalement = $_POST["signalement"];
$titre = $_POST["titre"];
$contenu = $_POST["contenu"];


$sql = "UPDATE inscrit SET importance_signalement=importance_signalement+1 WHERE id_inscrit = :signale";
$stmt = $connexion->prepare($sql);
$stmt->execute(array('signale' => $signale));

$sql2 = "DELETE FROM signalement WHERE id_signalement = :signalement";
$stmt2 = $connexion->prepare($sql2);
$stmt2->execute(array('signalement' => $signalement));

$sql3 = "DELETE FROM reponse WHERE ref_inscrit=:signale and contenu=:contenu";
$stmt3 = $connexion->prepare($sql3);
$stmt3->execute(array('signale' => $signale, 'contenu' => $contenu));




header("Location:signalements.php");

