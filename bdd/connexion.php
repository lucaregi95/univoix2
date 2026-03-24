<?php
try {
    $connexion = new PDO('mysql:host=localhost;dbname=univoix;charset=utf8', 'univoix_admin','kg953iEPPn&DoHuE');
} catch (PDOException $e) {
    echo ("Erreur :".$e->getMessage());
}

