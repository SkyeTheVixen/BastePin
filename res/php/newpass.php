<?php

    include_once("_connect.php");
    include_once("functions.inc.php");
    $mysqli = $connect;

    if(!(isset($_POST["password"])) || !(isset($_POST["passwordConfirm"]))) {
        echo json_encode(array("statusCode" => 201));
        exit();
    }

    $password = $mysqli -> real_escape_string($_POST["password"]);
    $passwordConfirm = $mysqli -> real_escape_string($_POST["passwordConfirm"]);
    $token = $mysqli -> real_escape_string($_POST["token"]);

    if($password != $passwordConfirm) {
        echo json_encode(array("statusCode" => 202));
        exit();
    }

    $sql = "UPDATE `tblUsers` SET `Password` = ? WHERE `tblUsers`.`UserID` = (SELECT `tblPasswordResets`.`UserID` FROM `tblPasswordResets` WHERE `tblPasswordResets`.`Token` = ? AND `tblPasswordResets`.`Expiry` > NOW())";