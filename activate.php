<?php
    session_start();
    include_once("res/php/_connect.php");
    include_once("res/php/functions.inc.php");
    $mysqli = $connect;

    if(isset($_GET["activationCode"])){
        $activationCode = mysqli_real_escape_string($connect, $_GET["activationCode"]);
        $user = GetUserByID($connect, $activationCode);
        if($user["IsLocked"] == 0){
            header("Location: login?er=prevActivation");
            exit();
        }
        else{
            $sql = "UPDATE `tblUsers` SET `IsLocked` = 0, `CanBaste` = 1, `MaximumBastes` = 10 WHERE `UserID` = ?";
            $stmt = $mysqli -> prepare($sql);
            $stmt -> bind_param('s', $activationCode);
            $stmt -> execute();
            $stmt -> close();
            header("Location: login?er=activationSuccess");
            exit();
        }
    }
    else{
        header("Location: login?er=noactivcode");
    }

?>