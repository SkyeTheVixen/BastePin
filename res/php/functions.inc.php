<?php

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

    function GetUser($connect){
        $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`UserID` = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, 's', $_SESSION["UserID"]);
        $stmt -> execute();
        $result = $stmt->get_result();
        if($result -> num_rows === 1){
            $User = $result->fetch_array(MYSQLI_ASSOC);
            return $User;
        }
    }

    function GetUserById($connect, $UserID){
        $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`UserID` = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, 's', $UserID);
        $stmt -> execute();
        $result = $stmt->get_result();
        if($result -> num_rows === 1){
            $User = $result->fetch_array(MYSQLI_ASSOC);
            return $User;
        }
    }

    function GetBaste($connect, $basteID){
        $sql = "SELECT * FROM `tblBastes` WHERE `tblBastes`.`BasteID` = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, 's', $basteID);
        $stmt -> execute();
        $result = $stmt->get_result();
        if($result -> num_rows === 1){
            $Baste = $result->fetch_array(MYSQLI_ASSOC);
            return $Baste;
        }
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
?>