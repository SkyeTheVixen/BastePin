<?php

    $db_host = "localhost";
    $db_user = "WS255237_bastepin";
    $db_pass = "o~gh0T97";
    $db_name = "WS255237_bastepin";

    $connect = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    if(!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>