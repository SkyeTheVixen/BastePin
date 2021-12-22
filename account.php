<?php session_start();?>
<?php $title="Account | VDBP"; ?>
<?php $currentPage="account"; ?>
<?php include("res/php/_connect.php"); ?>
<?php include("res/php/_authcheck.php"); ?>
<?php include("res/php/header.php"); ?>
<?php include("res/php/navbar.php"); ?>
<?php include("res/php/functions.inc.php"); ?>
<?php $user = getUser($connect); ?>


<!-- Main Page Content -->
<div class="container">

    <!-- Welcome Greeting -->
    <div class="row">
        <div class="col-12 mt-5 align-items-center">
            <h1 class="text-center">Account</h1>
        </div>
    </div>
    <!-- End Welcome Greeting -->

    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-4">
                    <img src="https://proficon.stablenetwork.uk/api/identicon/<?php echo $user["UserID"];?>.svg" alt="Profile Icon" />
                </div>
                <div class="col-4">
                </div>
                <div class="col-4">
                </div>
        </div>
    </div>
</div>
<!-- End Main Page Content -->


<?php include("./res/php/footer.php"); ?>