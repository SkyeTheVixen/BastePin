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
    $password = password_hash($password, 1, array('cost' => 10));

    $mysqli->autocommit(false);
    $sql = "UPDATE `tblUsers` SET `Password` = ? WHERE `tblUsers`.`UserID` = (SELECT `tblPasswordResets`.`UserID` FROM `tblPasswordResets` WHERE `tblPasswordResets`.`Token` = ? AND `tblPasswordResets`.`Expiry` > NOW())";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $password, $token);
    $stmt->execute();
    $stmt->close();
    $sql = "DELETE FROM `tblPasswordResets` WHERE `tblPasswordResets`.`Token` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->close();
    $mysqli->commit();
    $mysqli->close();
    echo json_encode(array("statusCode" => 200));