<?php
//Imports
session_start();
include_once('_connect.php');
include_once('functions.inc.php');


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
$basteID = GenerateID();
$basteName = mysqli_real_escape_string($connect, $_POST['basteName']);
$basteContents = mysqli_real_escape_string($connect, $_POST['basteContents']);
$basteVisibility = mysqli_real_escape_string($connect, $_POST['basteVisibility']);
$basteExpiresAt = mysqli_real_escape_string($connect, $_POST['expiresAt']);
$bastePasswordRequired = mysqli_real_escape_string($connect, $_POST['passwordRequired']);
$userID = $_SESSION['UserID'];
$bastePassword = mysqli_real_escape_string($connect, $_POST['bastePassword']);


//Generate the Template SQL Data
$tblUsersSql = "UPDATE `tblUsers` SET `BasteCount` = `BasteCount` + 1 WHERE `UserID` = ?;";
$tblBastesSql = "INSERT INTO `tblBastes`(`BasteID`, `BasteName`, `BasteContents`, `Visibility`, `ExpiresAt`, `PasswordRequired`, `Password`, `UserID`) VALUES (?,?,?,?,?,?,?,?);";


$user = GetUser($connect, $userID);

if($user['IsPremium'] == 1){
    if($basteExpiresAt != ""){
        $basteExpiresAt = date("Y-m-d H:i:s", strtotime($basteExpiresAt));
    }
    else{
        $basteExpiresAt = null;
    }
    if($bastePasswordRequired == "true"){
        $bastePassword = password_hash($bastePassword, 1, array('cost' => 10));
    }
    else{
        $bastePassword = null;
    }
}
else{
    $basteExpiresAt = null;
    $bastePasswordRequired = 0;
    $bastePassword = null;
}

if($user["CanBaste"] == 0)
{
    echo json_encode(array('statusCode' => 203));
    exit;
}
else if($user["BasteCount"] < $user["MaximumBastes"] || $user["MaximumBastes"] == null)
{
    //Perform the SQL
    $mysqli = $connect;
    $mysqli->autocommit(false);
    $stmt1 = $mysqli->prepare($tblBastesSql);
    $stmt1->prepare('ssssssss', $basteID, $basteName, $basteContents, $basteVisibility, $basteExpiresAt, $bastePasswordRequired, $bastePassword, $userID);
    $stmt1->execute();
    $mysqli->commit();
    $stmt1->close();

    $stmt2 = $mysqli->prepare($tblUsersSql);
    $stmt2->bind_param('s', $userID);
    $stmt2->execute();
    $mysqli->commit();
    $stmt2->close();

    echo json_encode(array('statusCode' => 200));
} else {
    echo json_encode(array('statusCode' => 202));
}

?>