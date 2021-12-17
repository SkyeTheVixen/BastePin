<?php
    //Set up PHP File
    session_start();
    include_once("_connect.php");
    $mysqli = $connect;

    //Create ID string based off IP And remote Address
    $id = "{$_SERVER['SERVER_NAME']}~login:{$_SERVER['REMOTE_ADDR']}";

    //SQL Query
    $mysqli -> autocommit(false);
    $sql = "SELECT * FROM `tblBFA` WHERE `ID` = ?";
    $stmt = $mysqli -> prepare($sql);
    $stmt -> bind_param('s', $id);
    $stmt -> execute();
    $result = $stmt->get_result();
    $mysqli -> commit();

    if($result -> num_rows === 1){
        $row = $result -> fetch_array(MYSQLI_ASSOC);
        $stmt->close();
        //If user IP has been blocked
        if ($row["Blocked"] == 1) {
            header("HTTP/1.1 429 Too Many Requests");
            echo json_encode(array("statusCode" => 205));
            exit();
        }
        else if($row["Tries"] >= 3){
            $mysqli -> autocommit(false);
            $sql = "UPDATE `tblBFA` SET `Tries` = 0, `Blocked` = 1 WHERE `ID` = ?";
            $stmt = $mysqli -> prepare($sql);
            $stmt -> bind_param('s', $id);
            $stmt -> execute();
            $mysqli -> commit();
            $stmt -> close();
        }
    }

    //Check the inputs are filled out
    if(isset($_POST["txtUser"]) && isset($_POST["txtPassword"])){
        //Get data POSTED
        $email = mysqli_real_escape_string($connect, $_POST["txtUser"]);
        $password = mysqli_real_escape_string($connect, $_POST["txtPassword"]);
        
        //Check email matches format
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo json_encode(array("statusCode" => 202));
        }
        
        //SQL Query
        $mysqli -> autocommit(false);
        $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`Email` = ?";
        $stmt = $mysqli ->prepare($sql);
        $stmt -> bind_param('s', $email);
        $stmt -> execute();
        $result = $stmt->get_result();
        $mysqli->commit();
        
        //If the email exists in the db, then proceed as normal
        if($result -> num_rows === 1){
            $User = $result->fetch_array(MYSQLI_ASSOC);
            $stmt -> close();
            //If password matches
            if(password_verify($password, $User["Password"], ))
            {
                //Check if user account is locked
                if($User["IsLocked"] == 1){
                    //Return locked
                    echo json_encode(array("statusCode" => 204));
                }
                else{
                    //Return success
                    $_SESSION["UserID"] = $User["UserID"];
                    echo json_encode(array("UserID" => $User["UserID"], "statusCode" => 200));
                }
            }
            else{
                //Return invalid credentials
                $mysqli -> autocommit(false);
                $sql = "INSERT INTO `tblBFA` (`ID`, `Tries`) VALUES(?, 1) ON DUPLICATE KEY UPDATE `Tries` = `Tries` + 1";
                $stmt = $mysqli -> prepare($sql);
                $stmt -> bind_param('s', $id);
                $stmt -> execute();
                $mysqli -> commit();
                $stmt -> close();
                echo json_encode(array("statusCode" => 201));
            }
        }
        else{
            //Return invalid credentials
            echo json_encode(array("statusCode" => 202));
        }
    }
    else{
        echo json_encode(array("statusCode" => 203));
    }


    $mysqli -> close();

?>