<?php

    //Imports
    session_start();
    include_once('_connect.php');
    include_once('functions.inc.php');

    //If user is not logged in, return to login page
    if(!isset($_SESSION['UserID']))
    {
        header("Location: ../../login");
        exit;
    }


    //If title, contents or visibility are not set, error out
    if(!isset($_POST['commentValue']))
    {
        echo json_encode(array('statusCode' => 201));
        exit;
    }

    $commentValue = $_POST['commentValue'];
    $basteID = $_POST['basteID'];
    $userID = $_SESSION['UserID'];
    $commentID = GenerateID();

    
    $mysqli->autocommit(false);
    $tblCommentsSql = "INSERT INTO `tblComments`(`CommentID`, `CommentValue`, `BasteID`, `UserID`) VALUES (?,?,?,?);";
    $stmt = $mysqli->prepare($tblCommentsSql);
    $stmt->bind_param("ssss", $commentID, $commentValue, $basteID, $userID);
    $stmt->execute();
    $stmt->close();
    $mysqli->commit();
    echo json_encode(array('statusCode' => 200));

?>