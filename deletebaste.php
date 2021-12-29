<?php 
    include_once("res/php/_connect.php");
    include_once("res/php/_authcheck.php");
    include_once("res/php/functions.inc.php");
    $referrer = $_SERVER['HTTP_REFERER'] ?? "index.php";
    if(!isset($_GET["BasteID"])) {
        echo json_encode(array("statusCode" => 202));
    }

    $user = GetUser($connect);
    $baste = GetBaste($connect, $_GET["BasteID"]);

    if($baste["UserID"] != $user["UserID"] && $user["IsAdmin"] != "1") {
        echo json_encode(array("statusCode" => 201));

    }
    else{
        $mysqli = $connect;
        $mysqli -> autocommit(FALSE);
        $sql = "DELETE FROM `tblBastes` WHERE `tblBastes`.`BasteID` = ?";
        $stmt = $mysqli -> prepare($sql);
        mysqli_stmt_bind_param($stmt, 's', $_GET["BasteID"]);
        $stmt -> execute();
        $mysqli -> commit();
        $stmt -> close();

        $mysqli -> autocommit(FALSE);
        $tblUsersSql = "UPDATE `tblUsers` SET `BasteCount` = `BasteCount` - 1 WHERE `UserID` = ?;";
        $stmt2 = $mysqli->prepare($tblUsersSql);
        $stmt2->bind_param('s', $user["UserID"]);
        $stmt2->execute();
        $mysqli->commit();
        $stmt2->close();
        $mysqli->close();
        header("Location: ../index?er=bastedelsuc");
    }

?>  