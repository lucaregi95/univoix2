<?php

session_start();

$_SESSION = [];

session_destroy();

header("Location: acceuil.php");
exit;
?>
<html>
<head>
    <link href="../style/style_public/deconnexion.css" rel="stylesheet">

</head>
</html>