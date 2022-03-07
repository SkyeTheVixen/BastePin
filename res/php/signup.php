<?php
    $dotenv = require("autoload.php");
    $dotenv->load();
    include_once("_connect.php");
    include("functions.inc.php");
    $mysqli -> autocommit(false);


    $captcha = $_POST['token'];
    $secretKey = $_ENV["GRECAPTCHA_SECRET"];
    $reCAPTCHA = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha)));
    if ($reCAPTCHA->score <= 0.5){
        echo json_encode(array("statusCode" => 204));
        return;
    }

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
        $FirstName = ucfirst(strtolower($_POST["FirstName"]));
        $LastName = ucfirst(strtolower($_POST["LastName"]));
        $Email = $_POST["Email"];
        $Password = password_hash($Password, 1, array('cost' => 10));
        
        //Check if any records already exist
        $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`Email` = ?";
        $stmt = $mysqli ->prepare($sql);
        $stmt -> bind_param('s', $Email);
        $stmt -> execute();
        $result = $stmt->get_result();
        $mysqli->commit();
        $stmt->close();
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
        $message = "https://bastepin.vixendev.com/activate.php?activationCode=" . $UserID;
        $altMessage = "https://bastepin.vixendev.com/activate.php?activationCode=" . $UserID;
        sendMail($Email, $fullName, $subject, $message, $altMessage);
        echo json_encode(array("statusCode" => 200));

        $mysqli->close();
    }

?>