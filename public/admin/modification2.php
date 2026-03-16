<?php
require_once("../../bdd/connexion.php");
$role=$_POST["role2"];
$id=$_POST["id"];
if(isset($_POST["specialite"])){
    $specialite=$_POST["specialite"];
    $sql = "UPDATE inscrit SET role=:role, specialite=:specialite WHERE id_inscrit = :id";
    $query = $connexion->prepare($sql);
    $query->execute(array('id' => $id, 'role' => $role, 'specialite' => $specialite));
    header("Location:inscrits.php");
}



