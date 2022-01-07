<?php
    //Imports
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    $dotenv = require("autoload.php");
    $dotenv->load();


    //Function to generate a UUIDv4
    function GenerateID() {
        $IDData = $IDData ?? random_bytes(16);
        assert(strlen($IDData) == 16);
        $IDData[6] = chr(ord($IDData[6]) & 0x0f | 0x40);
        $IDData[8] = chr(ord($IDData[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($IDData), 4));
    }


    //Function to generate a greeting based on the time of day
    function getGreeting(){
        $hour = date("H");
        if($hour >= 0 && $hour < 12){
            return "Good Morning";
        }else if($hour >= 12 && $hour < 18){
            return "Good Afternoon";
        }else if($hour >= 18 && $hour < 24){
            return "Good Evening";
        }
    }


    //Function to Get the Logged in users' basic details from the database
    function GetUser($mysqli){
        $mysqli -> autocommit(false);
        $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`UserID` = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('s', $_SESSION["UserID"]);
        $stmt -> execute();
        $result = $stmt->get_result();
        if($result -> num_rows === 1){
            $User = $result->fetch_array(MYSQLI_ASSOC);
            $mysqli->commit();
            $stmt->close();
            return $User;
        }
    }


    //Function to get a users' basic details by UUID
    function GetUserById($mysqli, $UserID){
        $mysqli -> autocommit(false);
        $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`UserID` = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('s', $UserID);
        $stmt -> execute();
        $result = $stmt->get_result();
        if($result -> num_rows === 1){
            $User = $result->fetch_array(MYSQLI_ASSOC);
            $mysqli->commit();
            $stmt->close();
            return $User;
        }
        $mysqli -> rollback();
        $stmt->close();
        return false;
    }


    //Function to Get the Logged in users' Profile from the database
    function GetProfile($mysqli){
        $mysqli -> autocommit(false);
        $sql = "SELECT `tblUsers`.`UserID`, `tblUsers`.`FirstName`, `tblUsers`.`LastName`, `tblUsers`.`Email`, `tblUsers`.`CanBaste`, `tblUsers`.`IsAdmin`, `tblUsers`.`IsPremium`, `tblUsers`.`IsLocked`, `tblUsers`.`BasteCount`, `tblUsers`.`MaximumBastes`, `tblProfile`.`Company`, `tblProfile`.`Location`, `tblProfile`.`Website`, `tblProfile`.`Twitter`, `tblProfile`.`Github` FROM `tblUsers` INNER JOIN `tblProfile` ON `tblUsers`.`UserID` = `tblProfile`.`UserID` WHERE `tblUsers`.`UserID` = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('s', $_SESSION["UserID"]);
        $stmt -> execute();
        $result = $stmt->get_result();
        if($result -> num_rows === 1){
            $User = $result->fetch_array(MYSQLI_ASSOC);
            $mysqli->commit();
            $stmt->close();
            return $User;
        }
        $mysqli -> rollback();
        $stmt->close();
        return false;
    }


    //Function to get a users' profile from the database by UUID
    function GetProfileByID($mysqli, $UserID){
        $mysqli -> autocommit(false);
        $sql = "SELECT `tblUsers`.`UserID`, `tblUsers`.`FirstName`, `tblUsers`.`LastName`, `tblUsers`.`Email`, `tblUsers`.`CanBaste`, `tblUsers`.`IsAdmin`, `tblUsers`.`IsPremium`, `tblUsers`.`IsLocked`, `tblUsers`.`BasteCount`, `tblUsers`.`MaximumBastes`, `tblProfile`.`Company`, `tblProfile`.`Location`, `tblProfile`.`Website`, `tblProfile`.`Twitter`, `tblProfile`.`Github` FROM `tblUsers` INNER JOIN `tblProfile` ON `tblUsers`.`UserID` = `tblProfile`.`UserID` WHERE `tblUsers`.`UserID` = ?";
        $stmt  = $mysqli->prepare($sql);
        $stmt -> bind_param('s', $UserID);
        $stmt -> execute();
        $result = $stmt->get_result();
        if($result -> num_rows === 1){
            $User = $result->fetch_array(MYSQLI_ASSOC);
            $mysqli -> commit();
            $stmt->close();
            return $User;
        }
        $mysqli -> rollback();
        $stmt->close();
        return false;
    }


    //Function to send an email to a user
    function sendMail($email, $userName,  $subject, $message, $altMessage){
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = $_ENV["MAIL_HOST"];
            $mail->SMTPAuth   = $_ENV["MAIL_SMTP_AUTH"];
            $mail->Username   = $_ENV["MAIL_USERNAME"];
            $mail->Password   = $_ENV["MAIL_PASS"];
            $mail->Port       = $_ENV["MAIL_PORT"];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

            //Recipients
            $mail->setFrom($_ENV["MAIL_USERNAME"], $_ENV["MAIL_FRIENDLY_NAME"]);
            $mail->addAddress($email, $userName);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = $altMessage;

            $mail->send();
        } catch (Exception $e) {
            file_put_contents("errorlog.txt", "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }


    //Function to get a baste from the database by basteID
    function GetBaste($mysqli, $basteID){
        $mysqli->autocommit(false);
        $sql = "SELECT * FROM `tblBastes` WHERE `tblBastes`.`BasteID` = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('s', $basteID);
        $stmt -> execute();
        $result = $stmt->get_result();
        if($result -> num_rows === 1){
            $Baste = $result->fetch_array(MYSQLI_ASSOC);
            $mysqli->commit();
            $stmt->close();
            return $Baste;
        }
        $mysqli -> rollback();
        $stmt->close();
        return false;
    }


    //Function to fetch all comments on a baste by basteID
    function fetchComments($mysqli, $basteID)
    {
        $mysqli->autocommit(false);
        $sql = "SELECT * FROM `tblComments` WHERE `tblComments`.`BasteID` = ? ORDER BY `tblComments`.`CreatedAt` DESC";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('s', $basteID);
        $stmt -> execute();
        $result = $stmt->get_result();
        if($result -> num_rows > 0){
            $Comments = $result->fetch_all(MYSQLI_ASSOC);
            $mysqli->commit();
            $stmt->close();
            return $Comments;
        }
        $mysqli -> rollback();
        $stmt->close();
        return false;
    }


    //Function to get a file size in human readable format
    function byteConvert($size, $unit="")
    {
        if((!$unit && $size >= 1<<30) || $unit == "GB")
            return number_format($size/(1<<30),2)."GB";
        if((!$unit && $size >= 1<<20) || $unit == "MB")
            return number_format($size/(1<<20),2)."MB";
        if((!$unit && $size >= 1<<10) || $unit == "KB")
            return number_format($size/(1<<10),2)."KB";
        return number_format($size)." bytes";
    }


    //Function to convert a time string to a 'time ago' string
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
?>