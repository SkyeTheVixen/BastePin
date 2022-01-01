<?php
    //imports
    include_once("_connect.php");
    include_once("functions.inc.php");
    $mysqli = $connect;
    $mysqli->autocommit(false);


    $sql = "SELECT * FROM `tblPasswordResets` WHERE `tblPasswordResets`.`Token` = ? AND `tblPasswordResets`.`Expiry` > NOW())";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 0) {
        echo json_encode(array("statusCode" => 203));
        exit();
    }
    $mysqli->commit();


    if(!(isset($_POST["password"])) || !(isset($_POST["passwordConfirm"]))) {
        echo json_encode(array("statusCode" => 201));
        exit();
    }

    $password = $_POST["password"];
    $passwordConfirm = $_POST["passwordConfirm"];
    $token = $_POST["token"];

    if($password != $passwordConfirm) {
        echo json_encode(array("statusCode" => 202));
        exit();
    }
    $password = password_hash($password, 1, array('cost' => 10));

    $sql = "UPDATE `tblUsers` SET `Password` = ? WHERE `tblUsers`.`UserID` = (SELECT `tblPasswordResets`.`UserID` FROM `tblPasswordResets` WHERE `tblPasswordResets`.`Token` = ? AND `tblPasswordResets`.`Expiry` > NOW())";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $password, $token);
    $stmt->execute();
    $stmt->close();
    $sql = "DELETE FROM `tblPasswordResets` WHERE `tblPasswordResets`.`Token` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->close();
    $mysqli->commit();

    $sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`UserID` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();

    $fullName = $row["FirstName"] . " " . $row["LastName"];
    $subject = "Bastepin | Password has been Reset";
    $message = "Hello " . $fullName . ",<br><br>Your password has been reset.<br><br>If you did not request this, please contact us immediately.<br><br>Thank you,<br>Bastepin";
    $altMessage = "Hello " . $fullName . ",\n\nYour password has been reset.\n\nIf you did not request this, please contact us immediately.\n\nThank you,\nBastepin";
    sendMail($email, $fullName, $subject, $message, $altMessage);
    echo json_encode(array("statusCode" => 200));