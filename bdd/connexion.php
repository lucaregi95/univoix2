<?php
try {
    $connexion = new PDO('mysql:host=localhost;dbname=univoix;charset=utf8', 'root','');
} catch (PDOException $e) {
    echo ("Erreur :".$e->getMessage());
}

