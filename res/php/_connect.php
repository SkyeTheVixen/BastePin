<?php

    if(file_exists("../vendor/autoload.php")){
        require '../vendor/autoload.php';
    }else if(file_exists("../../vendor/autoload.php")){
        require '../../vendor/autoload.php';
    }else if(file_exists("vendor/autoload.php")){
        require 'vendor/autoload.php';
    }else if(file_exists("./vendor/autoload.php")){
        require './vendor/autoload.php';
    }
    $dotenv = Dotenv\Dotenv::createImmutable("../../");
    $dotenv->load();

    //Connection Information
    $db_host = "localhost";
    $db_user = "WS255237_bastepin";
    $db_pass = $_ENV["DB_PASS"];
    $db_name = "WS255237_bastepin";

    //Connect to Maria Server
    $connect = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    if(!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>