<?php
require_once "..\..\bdd\connexion.php";
session_start();

if (!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    header("location:../connexion.php");
    exit();
}

$titre       = $_POST["titre"];
$lien        = $_POST["lien"];
$description = $_POST["description"];
$date        = $_POST["date"];
$category     = $_POST["category"];

$sql = "INSERT INTO article (titre, lien, description, `date`, category) 
        VALUES (:titre, :lien, :description, :date, :category)";

$query = $connexion->prepare($sql);
$query->execute([
    'titre'       => $titre,
    'lien'        => $lien,
    'description' => $description,
    'date'        => $date,
    'category'    => $category
]);

header("Location:articles.php");
exit();
