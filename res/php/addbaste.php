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
$basteName = $_POST['basteName'];
$basteContents = $_POST['basteContents'];
$basteVisibility = $_POST['basteVisibility'];
$basteExpiresAt = $_POST['expiresAt'];
$userID = $_SESSION['UserID'];
$bastePassword = $_POST['bastePassword'];


//Generate the Template SQL Data
$tblUsersSql = "UPDATE `tblUsers` SET `BasteCount` = `BasteCount` + 1 WHERE `UserID` = ?;";
$tblBastesSql = "INSERT INTO `tblBastes`(`BasteID`, `BasteName`, `BasteContents`, `Visibility`, `ExpiresAt`, `PasswordRequired`, `Password`, `UserID`) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";


$user = GetUser($connect, $userID);
if($user["BasteCount"] < $user["MaximumBastes"] || $user["MaximumBastes"] == null)
{
    //Perform the SQL
    $stmt1 = mysqli_prepare($connect, $tblBastesSql);
    mysqli_stmt_bind_param($stmt1, 'sssssss', $basteID, $basteName, $basteContents, $basteVisibility, $basteExpiresAt, $bastePasswordRequired, $bastePassword, $userID);
    $stmt1->execute();
    $stmt1->close();

    $stmt2 = mysqli_prepare($connect, $tblUsersSql);
    mysqli_stmt_bind_param($stmt2, 's', $userID);
    $stmt2->execute();
    $stmt2->close();

    echo json_encode(array('statusCode' => 200));
} else {
    echo json_encode(array('statusCode' => 202));
}

?>