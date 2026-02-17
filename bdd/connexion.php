<?php
try {
    $connexion = new PDO('mysql:host=localhost;dbname=//a changer;charset=utf8', '//a changer;charset=utf8','//a changer');
} catch (PDOException $e) {
    echo ("Erreur :".$e->getMessage());
}