<?php

session_start();

$_SESSION = [];

session_destroy();

header("Location: acceuil.php");
exit;
?>
<html>
<head>
    <a href="../style/style_public/deconnexion.css" rel="stylesheet">

</head>
</html>