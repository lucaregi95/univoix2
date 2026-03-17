<?php
require_once("../../bdd/connexion.php");
session_start();
if(!isset($_SESSION['nom']) || !isset($_SESSION['prenom'])) {
    header("location:../connexion.php");
    exit();
}
$role=$_POST["role2"];
$id=$_POST["id"];
if(isset($_POST["specialite"])){
    $specialite=$_POST["specialite"];
    $sql = "UPDATE inscrit SET role=:role, specialite=:specialite WHERE id_inscrit = :id";
    $query = $connexion->prepare($sql);
    $query->execute(array('id' => $id, 'role' => $role, 'specialite' => $specialite));
    header("Location:inscrits.php");
}
if ($role=="admin") {
    $sql = "UPDATE inscrit SET role=:role WHERE id_inscrit = :id";
    $query = $connexion->prepare($sql);
    $query->execute(array('id' => $id, 'role' => $role));
    header("Location:inscrits.php");
}
if ($role=="user") {
    $sql = "UPDATE inscrit SET role=:role, specialite=null WHERE id_inscrit = :id";
    $query = $connexion->prepare($sql);
    $query->execute(array('id' => $id, 'role' => $role));
    header("Location:inscrits.php");
}




