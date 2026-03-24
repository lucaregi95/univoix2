
<?php
$connexion=null;
session_start();
require_once "../../bdd/connexion.php";
$signale = $_POST["signale"];
$signalement = $_POST["signalement"];



$sql2 = "DELETE FROM signalement WHERE id_signalement = :signalement";
$stmt2 = $connexion->prepare($sql2);
$stmt2->execute(array('signalement' => $signalement));

header("Location:signalements.php");