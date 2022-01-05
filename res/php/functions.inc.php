<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    if(file_exists("../vendor/autoload.php")){
        require '../vendor/autoload.php';
    }else if(file_exists("../../vendor/autoload.php")){
        require '../../vendor/autoload.php';
    }else if(file_exists("vendor/autoload.php")){
        require 'vendor/autoload.php';
    }else if(file_exists("./vendor/autoload.php")){
        require './vendor/autoload.php';
    }

    function GenerateID() {
        $IDData = $IDData ?? random_bytes(16);
        assert(strlen($IDData) == 16);
        $IDData[6] = chr(ord($IDData[6]) & 0x0f | 0x40);
        $IDData[8] = chr(ord($IDData[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($IDData), 4));
    }

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

    function sendMail($email, $userName,  $subject, $message, $altMessage){
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'mail.vixendev.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'no-reply@vixendev.com';
            $mail->Password   = $_ENV["MAIL_PASS"];
            $mail->Port       = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

            //Recipients
            $mail->setFrom('no-reply@vixendev.com', 'Vixendev');
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