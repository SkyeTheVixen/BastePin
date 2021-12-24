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
        header("Location: ../index?er=bastedelsuc");
    }

?>  