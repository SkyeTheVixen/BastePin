<?php

    include_once("_connect.php");
    include_once("functions.inc.php");
    $mysqli = $connect;

    if(!(isset($_POST["email"]))) {
        echo json_encode(array("statusCode" => 201));
        exit();
    }
    $email = $mysqli -> real_escape_string($_POST["email"]);
    $token = GenerateID();
    $mysqli -> autocommit(false);
    $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`Email` = ?";
    $stmt = $mysqli -> prepare($sql);
    $stmt -> bind_param('s', $email);
    $stmt -> execute();
    $mysqli -> commit();
    $result = $stmt->get_result();
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $UserID = $row["UserID"];
    $sql = "INSERT INTO `tblPasswordResets`(`UserID`, `Token`, `Expiry`) VALUES (?,?,(now() + INTERVAL 30 MINUTE))";
    $mysqli -> autocommit(false);
    $stmt = $mysqli -> prepare($sql);
    $stmt -> bind_param('ss', $UserID, $token);
    $stmt -> execute();
    $mysqli -> commit();
    $stmt -> close();
    
    $fullName = $row["FirstName"] . " " . $row["LastName"];
    $subject = "Bastepin | Password Reset";
    $message = "https://skytest.xyz/Bastepin/newpass.php?token=" . $token;
    $altMessage = "https://skytest.xyz/Bastepin/newpass.php?token=" . $token;
    sendMail($Email, $fullName, $subject, $message, $altMessage);
    echo json_encode(array("statusCode" => 200));
    $mysqli -> close();

?>