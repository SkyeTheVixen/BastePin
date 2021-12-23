<?php if($currentPage == "baste" || $currentPage == "account" || $currentPage == "editbaste"){$pathHead = "../res/";} else {$pathHead = "res/";}?>



<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadata -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $pathHead;?>favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $pathHead;?>favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $pathHead;?>favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo $pathHead;?>favicon/site.webmanifest">
    <link rel="mask-icon" href="<?php echo $pathHead;?>favicon/safari-pinned-tab.svg" color="#0b2033">
    <link rel="shortcut icon" href="<?php echo $pathHead;?>favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#0b2033">
    <meta name="msapplication-config" content="<?php echo $pathHead;?>favicon/browserconfig.xml">
    <meta name="theme-color" content="#0b2033">
    <title><?php echo($title); ?></title>
    <!-- End Metadata -->

    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo $pathHead;?>css/<?php echo($currentPage); ?>.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.3.1/build/styles/default.min.css">
    <?php if($currentPage == "baste"){?><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/styles/default.min.css"><?php }?>
    <!-- End Stylesheets -->

    <!-- Important Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/93e867abff.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.3.1/build/highlight.min.js"></script>
    <?php if($currentPage == "baste"){?><script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.3.1/highlight.min.js"></script><?php }?>
    <?php if($currentPage == "baste"){?><script>hljs.highlightAll();</script><?php }?>
    <script type="text/javascript" src='<?php echo $pathHead;?>js/<?php echo($currentPage); ?>.js'></script>

</head>