<?php
    session_start();
    if (!isset($_SESSION['UserID']) && ($currentPage === "account" || $currentPage === "baste" || $currentPage === "profile" || $currentPage === "editbaste")) {
        header("Location: ../login");
    }
    else if (!isset($_SESSION['UserID'])){
        header("Location: login");
    }
?>