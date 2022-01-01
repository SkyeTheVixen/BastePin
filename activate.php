<?php
    session_start();
    include_once("res/php/_connect.php");
    include_once("res/php/functions.inc.php");
    $mysqli = $connect;
    $mysqli -> autocommit(FALSE);

    if(isset($_GET["activationCode"])){
        $activationCode = $_GET["activationCode"];
        $user = GetUserByID($mysqli, $activationCode);
        var_dump($user);
        if($user == false){
            header("Location: login?er=prevActivation");
            exit();
        }
        if($user["IsLocked"] == 0){
            header("Location: login?er=prevActivation");
            exit();
        }
        else{
            $sql = "UPDATE `tblUsers` SET `IsLocked` = 0, `CanBaste` = 1, `MaximumBastes` = 10 WHERE `UserID` = ?";
            $stmt = $mysqli -> prepare($sql);
            $stmt -> bind_param('s', $activationCode);
            $stmt -> execute();
            $mysqli -> commit();
            $stmt -> close();
            $User = GetUserByID($mysqli, $activationCode);
            $fullName = $User["FirstName"] . " " . $User["LastName"];
            $subject = "Bastepin | Welcome";
            $message = "Thank you for activating your account $fullName, you can now use Bastepin to save code!";
            $message = "Thank you for activating your account $fullName, you can now use Bastepin to save code!";
            sendMail($User["Email"], $fullName, $subject, $message, $altMessage);
            header("Location: login?er=activationSuccess");
            exit();
        }
    }
    else{
        header("Location: login?er=noactivcode");
    }

?>