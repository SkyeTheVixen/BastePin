<?php

include_once("_connect.php");
$sql = "SELECT * FROM `tblUsers` WHERE `tblUsers`.`UserID` = ?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, 's', $_SESSION["userID"]);
$stmt -> execute();
$result = $stmt->get_result();
if($result -> num_rows === 1){
    $User = $result->fetch_array(MYSQLI_ASSOC);
    $premium = $User["IsPremium"];
    if ($premium == 1) { echo json_encode(array('statusCode' => 200));}
    else { echo json_encode(array('statusCode' => 201)); }
}
else{
    echo json_encode(array('statusCode' => 201));
}

?>