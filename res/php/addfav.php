<?php

    session_start();
    include_once("_connect.php");
    $mysqli = $connect;
    $mysqli -> autocommit(FALSE);
    if (!isset($_SESSION['UserID'])){
        header("Location: ../../login");
    }

    $action = $_POST['action'];
    $basteID = $_POST['basteID'];

    if($action == "add"){
        $sql = "INSERT INTO `tblFavourites` (`UserID`, `BasteID`) VALUES (?, ?)";
        $stmt = $mysqli -> prepare($sql);
        $stmt->bind_param('ss', $_SESSION['UserID'], $basteID);
        $stmt->execute();
        $mysqli -> commit();
        $stmt->close();
        echo json_encode(array("statusCode" => 200));
    }
    else{
        $sql = "DELETE FROM `tblFavourites` WHERE `UserID` = ? AND `BasteID` = ?";
        $stmt = $mysqli -> prepare($sql);
        $stmt->bind_param('ss', $_SESSION['UserID'], $basteID);
        $stmt->execute();
        $mysqli -> commit();
        $stmt->close();
        echo json_encode(array("statusCode" => 200));
    }
    $mysqli -> close();


?>