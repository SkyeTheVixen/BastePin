<?php
    session_start();
    include_once("res/php/_connect.php");
    include_once("res/php/functions.inc.php");
    $mysqli = $connect;

    if(!(isset($_POST["FirstName"]) || isset($_POST["LastName"]) || isset($_POST["Email"]) || isset($_POST["Password"]) || isset($_POST["PasswordConfirm"]))) {
        echo json_encode(array("statusCode" => 201));
        exit();
    }
    else{
        $Password = mysqli_real_escape_string($connect, $_POST["Password"]);
        $PasswordConfirm = mysqli_real_escape_string($connect, $_POST["PasswordConfirm"]);
        if($Password != $PasswordConfirm){
            echo json_encode(array("statusCode" => 202));
            exit();
        }
        $UserID = GenerateID();
        $FirstName = mysqli_real_escape_string($connect, $_POST["FirstName"]);
        $LastName = mysqli_real_escape_string($connect, $_POST["LastName"]);
        $Email = mysqli_real_escape_string($connect, $_POST["Email"]);

        $sql = "INSERT INTO `tblUsers` (`UserID`, `FirstName`, `LastName`, `Email`, `Password`, CanBaste, IsAdmin, IsPremium, IsLocked, BasteCount, MaximumBastes) VALUES (?, ?, ?, ?, ?, 0, 0, 0, 1, 0, 0)";
        $mysqli -> autocommit(false);
        $stmt = $mysqli -> prepare($sql);
        $stmt -> bind_param('sssss', $UserID, $FirstName, $LastName, $Email, $Password);
        $stmt -> execute();
        $mysqli -> commit();
        $stmt -> close();
        $fullName = $FirstName . " " . $LastName;
        $subject = "Bastepin | Confirm Your Email Address";
        $message = "https://skytest.xyz/Bastepin/activate.php?activationCode=" . $UserID;
        $altMessage = "https://skytest.xyz/Bastepin/activate.php?activationCode=" . $UserID;
        sendMail($Email, $fullName, $subject, $message, $altMessage);
        echo json_encode(array("statusCode" => 200));

    }

?>