<?php
    //Imports
    session_start();
    include_once('_connect.php');
    include_once('functions.inc.php');
    $mysqli = $connect;
    $mysqli->autocommit(false);

    //If user is not logged in, return to login page
    if(!isset($_SESSION['UserID']))
    {
        header("Location: ../login");
        exit;
    }

    //If title, contents or visibility are not set, error out
    if(!isset($_POST['basteName']) || !isset($_POST['basteContents']) || !isset($_POST['basteVisibility']))
    {
        echo json_encode(array('statusCode' => 201));
        exit;
    }

    //Get the Data needed to perform the SQL update
    $basteID = $_POST['basteID'];
    $basteName = $_POST['basteName'];
    $basteContents = $_POST['basteContents'];
    $basteVisibility = $_POST['basteVisibility'];
    $basteExpiresAt = $_POST['expiresAt'];
    $bastePasswordRequired = $_POST['passwordRequired'];
    $userID = $_SESSION['UserID'];
    $bastePassword = $_POST['bastePassword'];

    //Generate the Template SQL Data
    $tblBastesSql = "UPDATE `tblBastes` SET `BasteName`=?,`BasteContents`=?,`Visibility`=?,`ExpiresAt`=?,`PasswordRequired`=?,`Password`=? WHERE `tblBastes`.`BasteID` = ? AND `tblBastes`.`UserID` = ?;";
    $user = GetUser($connect, $userID);

    if($user['IsPremium'] == 1){
        $basteExpiresAt = ($basteExpiresAt == "")? NULL : date("Y-m-d H:i:s", strtotime($basteExpiresAt));
        $bastePassword = ($bastePassword == "") ? NULL : password_hash($bastePassword, 1, array('cost' => 10));
        $bastePasswordRequired = ($bastePassword == "") ? 0 : 1;
    }
    else{
        $basteExpiresAt = null;
        $bastePasswordRequired = 0;
        $bastePassword = null;
    }

    //Perform the SQL
    $stmt1 = $mysqli->prepare($tblBastesSql);
    $stmt1->bind_param('ssssssss', $basteName, $basteContents, $basteVisibility, $basteExpiresAt, $bastePasswordRequired, $bastePassword, $basteID, $userID);
    if($stmt1->execute()){
        $mysqli->commit();
        $stmt1->close();
        echo json_encode(array('statusCode' => 200));
    }
    else{
        $mysqli->rollback();
        $stmt1->close();
        echo json_encode(array('statusCode' => 202));
    }
    $mysqli->close();

?>