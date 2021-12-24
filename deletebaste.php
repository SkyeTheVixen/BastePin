<?php 
    include_once("res/php/_connect.php");
    include_once("res/php/_authcheck.php");
    include_once("res/php/functions.inc.php");
    $referrer = $_SERVER['HTTP_REFERER'];
    if(!isset($_GET["BasteID"])) {
        header("Location: $referrer?er=nobastedel");
    }

    $user = GetUser($connect);
    $baste = GetBaste($connect, $_GET["BasteID"]);

    if($baste["UserID"] != $user["UserID"] || $user["IsAdmin"] != "1") {
        header("Location: $referrer?er=insufperm");
    }

?>  