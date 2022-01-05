<?php

    include("res/php/_connect.php");
    $mysqli = $connect;
    $mysqli->autocommit(false);
    if(!isset($_SESSION["paymenttoken"]) || !isset($_GET["token"]))
    {
        header("Location: premium.php?er=invaltoken");
        exit();
    }
    if($_SESSION["paymenttoken"] != $_GET["token"])
    {
        header("Location: premium.php?er=invaltoken");
        exit();
    }

    $sql = "UPDATE `tblUsers` SET `IsPremium` = '1', `MaximumBastes` = Null WHERE `UserID` = ?;";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $_SESSION["UserID"]);
    $stmt->execute();
    $stmt->close();
    $mysqli->commit();
?>