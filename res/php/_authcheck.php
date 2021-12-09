<?php
    session_start();
    if (!isset($_SESSION['UserID']) && ($currentPage === "account" || $currentPage === "baste")) {
        header("Location: ../login");
    }
    else if (!isset($_SESSION['UserID'])){
        header("Location: login");
    }
?>