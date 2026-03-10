<?php

$id=$_SESSION["id"];


$avatar2=$avatar;
$avatar = $avatar."../img/avatar/".$id.".png";


if(!file_exists($avatar)){
    $avatar=$avatar2;
    $avatar = $avatar."../img/avatar/".$id.".jpeg";

}

if(!file_exists($avatar)){
    $avatar=$avatar2;
    $avatar = $avatar."../img/avatar/".$id.".jpg";

}

if(!file_exists($avatar)){
    $avatar=$avatar2;
    $avatar = $avatar."../img/avatar/".$id.".gif";

}

if(!file_exists($avatar)){
    $avatar=$avatar2;
    $avatar = $avatar."../img/avatar/default.png";

}
?>
<html>
    <head>
        <link href="../style/style_public/avatar.css" rel="stylesheet">
    </head>
</html>
