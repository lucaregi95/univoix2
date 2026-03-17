<?php
$id_article = $_POST["id_article"];

session_start();
require_once "..\..\bdd\connexion.php";
if (!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    header("location:../connexion.php");
    exit();
}

$sql = "DELETE FROM article WHERE id_article=:id_article";
$query = $connexion->prepare($sql);
$query->execute(array('id_article' => $id_article));
header("Location:mesarticles.php");
