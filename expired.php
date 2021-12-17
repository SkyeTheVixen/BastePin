<?php session_start();?>
<?php $title="Expired Baste | VDBP"; ?>
<?php $currentPage="expired"; ?>
<?php include("res/php/_connect.php"); ?>
<?php include("res/php/header.php"); ?>
<?php include("res/php/navbar.php"); ?>
<?php include("res/php/functions.inc.php"); ?>

<!-- Main Page Content -->
<div class="container">  
    <!-- Page Title -->
    <div class="row mt-5">
        <div class="col-12 mt-5 align-items-center">
            <h1 class="text-center">Baste Expired</h1>
            <h3 class="text-center">Unfortunately, this baste has expired</h3>
            <button class="btn btn-primary mt-5" onclick="window.location.href='index.php'">Go Back</button>
        </div>
    </div>
    <!-- End Page Title -->

</div>
<!-- End Main Page Content -->


<?php include("./res/php/footer.php"); ?>