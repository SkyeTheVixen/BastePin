<?php

    //Require the autoload script
    require("autoload.php");
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    //Connect to Maria Server
    $connect = mysqli_connect($_ENV["DB_HOST"], $_ENV["DB_USER"], $_ENV["DB_PASS"], $_ENV["DB_NAME"]);
    if(!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>