<?php

$id=$_SESSION["id"];



$avatar = $avatar."../img/avatar/".$id.".png";


if(!file_exists($avatar)){
    $avatar = $avatar."../img/avatar/".$id.".jpeg";

}

if(!file_exists($avatar)){
    $avatar = $avatar."../img/avatar/".$id.".jpg";

}

if(!file_exists($avatar)){
    $avatar = $avatar."../img/avatar/".$id.".gif";

}

if(!file_exists($avatar)){
    $avatar = $avatar."../img/avatar/default.png";

}
?>
<html>
    <head>
        <a href="../style/style_public/avatar.css" rel="stylesheet">
    </head>
</html>
