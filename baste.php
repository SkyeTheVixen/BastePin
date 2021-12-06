<?php session_start();?>
<?php $title="Baste | VDBP"; ?>
<?php $currentPage="baste"; ?>
<?php include("../res/php/_connect.php"); ?>
<?php include("../res/php/header.php"); ?>
<?php include("../res/php/navbar.php"); ?>
<?php include("../res/php/functions.inc.php"); ?>
<?php if(isset($_GET["BasteID"])) {$baste = getBaste($connect, $_GET["BasteID"]);} else {header("location: ../index");}?>


<!-- Main Page Content -->
<div class="container">

    <!-- Welcome Greeting -->
    <div class="row">
        <div class="col-12 mt-5 align-items-center">
            <h1 class="text-center"><?php echo $baste["BasteName"];?></h1>
        </div>
    </div>
    <!-- End Welcome Greeting -->

    <br>

</div>
<!-- End Main Page Content -->


<?php include("./res/php/footer.php"); ?>