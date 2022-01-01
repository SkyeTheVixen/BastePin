<?php

    include_once("_connect.php");
    include_once("functions.inc.php");
    $mysqli = $connect;
    $mysqli -> autocommit(false);

    if(!(isset($_POST["email"]))) {
        echo json_encode(array("statusCode" => 201));
        exit();
    }

    $email = $_POST["email"];
    $token = GenerateID();
    $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`Email` = ?";
    $stmt = $mysqli -> prepare($sql);
    $stmt -> bind_param('s', $email);
    $stmt -> execute();
    $mysqli -> commit();
    $result = $stmt->get_result();
    if($result->num_rows == 0) {
        echo json_encode(array("statusCode" => 202));
        exit();
    }
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $UserID = $row["UserID"];
    $sql = "INSERT INTO `tblPasswordResets`(`UserID`, `Token`, `Expiry`) VALUES (?,?,(now() + INTERVAL 30 MINUTE)) ON DUPLICATE KEY UPDATE `Token` = ?, `Expiry` = (now() + INTERVAL 30 MINUTE)";
    $stmt = $mysqli -> prepare($sql);
    $stmt -> bind_param('ss', $UserID, $token);
    $stmt -> execute();
    $mysqli -> commit();
    $stmt -> close();
    
    $fullName = $row["FirstName"] . " " . $row["LastName"];
    $subject = "Bastepin | Password Reset";
    $message = "https://skytest.xyz/Bastepin/newpass.php?token=" . $token;
    $altMessage = "https://skytest.xyz/Bastepin/newpass.php?token=" . $token;
    sendMail($email, $fullName, $subject, $message, $altMessage);
    echo json_encode(array("statusCode" => 200));
    $mysqli -> close();

?>