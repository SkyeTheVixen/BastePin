<?php
    include_once("_connect.php");
    include_once("functions.inc.php");
    $mysqli = $connect;
    $mysqli->autocommit(false);

    if(!(isset($_POST["FirstName"]) || isset($_POST["LastName"]) || isset($_POST["Email"]) || isset($_POST["Password"]) || isset($_POST["PasswordConfirm"]))) {
        echo json_encode(array("statusCode" => 201));
        exit();
    }
    else{
        $Password = $_POST["Password"];
        $PasswordConfirm = $_POST["PasswordConfirm"];
        if($Password != $PasswordConfirm){
            echo json_encode(array("statusCode" => 202));
            exit();
        }
        $UserID = GenerateID();
        $FirstName = $_POST["FirstName"];
        $LastName = $_POST["LastName"];
        $Email = $_POST["Email"];
        $Password = password_hash($Password, 1, array('cost' => 10));
        
        //Check if any records already exist
        $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`Email` = ?";
        $stmt = $mysqli ->prepare($sql);
        $stmt -> bind_param('s', $email);
        $stmt -> execute();
        $result = $stmt->get_result();
        $mysqli->commit();
        $stmt->close();
        echo $result->num_rows;
        //If the email exists in the db, then error out
        if($result -> num_rows > 0){
            echo json_encode(array("statusCode" => 203));
            exit();
        }
        $sql = "INSERT INTO `tblUsers` (`UserID`, `FirstName`, `LastName`, `Email`, `Password`, CanBaste, IsAdmin, IsPremium, IsLocked, BasteCount, MaximumBastes) VALUES (?, ?, ?, ?, ?, 0, 0, 0, 1, 0, 0)";
        $mysqli -> autocommit(false);
        $stmt = $mysqli -> prepare($sql);
        $stmt -> bind_param('sssss', $UserID, $FirstName, $LastName, $Email, $Password);
        $stmt -> execute();
        $mysqli -> commit();
        $stmt -> close();

        $sql = "INSERT INTO `tblProfile` (`UserID`) VALUES (?)";
        $stmt = $mysqli -> prepare($sql);
        $stmt -> bind_param('s', $UserID);
        $stmt -> execute();
        $mysqli -> commit();
        $stmt -> close();

        $fullName = $FirstName . " " . $LastName;
        $subject = "Bastepin | Confirm Your Email Address";
        $message = "https://skytest.xyz/Bastepin/activate.php?activationCode=" . $UserID;
        $altMessage = "https://skytest.xyz/Bastepin/activate.php?activationCode=" . $UserID;
        sendMail($Email, $fullName, $subject, $message, $altMessage);
        echo json_encode(array("statusCode" => 200));

        $mysqli->close();
    }

?>