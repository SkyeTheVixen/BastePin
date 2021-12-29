<?php
//Imports
session_start();
include_once('_connect.php');
include_once('functions.inc.php');
$mysqli = $connect;


//If user is not logged in, return to login page
if(!isset($_SESSION['UserID']))
{
    header("Location: ../login");
    exit;
}


//Get the Data needed to perform the SQL update
$basteID = GenerateID();
$userID = $_SESSION['UserID'];
$basteName = $mysqli->real_escape_string($_POST['basteName']);
$basteContents = $_POST['basteContents'];
$basteVisibility = $mysqli->real_escape_string($_POST['basteVisibility']);
$basteExpiresAt = $mysqli->real_escape_string($_POST['expiresAt']);
$bastePasswordRequired = $mysqli->real_escape_string($_POST['passwordRequired']);
$bastePassword = $mysqli->real_escape_string($_POST['bastePassword']) ;


//If title, contents or visibility are not set, error out
if(!isset($_POST['basteName']) || !isset($_POST['basteContents']) || !isset($_POST['basteVisibility']))
{
    echo json_encode(array('statusCode' => 201));
    exit;
}


//Generate the Template SQL Data
$tblUsersSql = "UPDATE `tblUsers` SET `BasteCount` = `BasteCount` + 1 WHERE `UserID` = ?;";
$tblBastesSql = "INSERT INTO `tblBastes`(`BasteID`, `BasteName`, `BasteContents`, `Visibility`, `ExpiresAt`, `PasswordRequired`, `Password`, `UserID`) VALUES (?,?,?,?,?,?,?,?);";

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

if($user["CanBaste"] == 0)
{
    echo json_encode(array('statusCode' => 203));
    exit;
}
else if($user["BasteCount"] < $user["MaximumBastes"] || $user["MaximumBastes"] == null)
{
    //Perform the SQL
    $mysqli->autocommit(false);
    $stmt1 = $mysqli->prepare($tblBastesSql);
    $stmt1->bind_param('ssssssss', $basteID, $basteName, $basteContents, $basteVisibility, $basteExpiresAt, $bastePasswordRequired, $bastePassword, $userID);
    $stmt1->execute();
    $mysqli->commit();
    $stmt1->close();
    
    $mysqli->autocommit(false);
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