<?php
    session_start();
    include_once("_connect.php");
    $mysqli->autocommit(false);

    $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`UserID` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $_SESSION["UserID"]);
    $stmt -> execute();
    $result = $stmt->get_result();
    if($result -> num_rows === 1){
        $User = $result->fetch_array(MYSQLI_ASSOC);
        $mysqli->commit();
        $stmt->close();
        $premium = $User["IsPremium"];
        if ($premium == 1) { echo json_encode(array('statusCode' => 200));}
        else { echo json_encode(array('statusCode' => 201)); }
    }
    else{
        echo json_encode(array('statusCode' => 202));
    }
    $mysqli -> close();
?>