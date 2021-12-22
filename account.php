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
                <div class="col-8">
                    <h1><?php echo htmlspecialchars($user["FirstName"]." ".$user["LastName"]); ?></h1>
                </div>
                <div class="col-4">
                    <img src="https://proficon.stablenetwork.uk/api/identicon/<?php echo $user["UserID"];?>.svg" alt="Profile Icon" class="h-25"/>
                </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h5>Name: <?php echo htmlspecialchars($user["FirstName"]." ".$user["LastName"]);?></h5>
                <h5>Email: <?php echo htmlspecialchars($user["Email"]);?></h5>
                <h5>Can Baste?: <?php echo htmlspecialchars($user["CanBaste"]);?></h5>
                <h5>IsAdmin?: <?php echo htmlspecialchars($user["IsAdmin"]);?></h5>
                <h5>IsPremium?: <?php echo htmlspecialchars($user["IsPremium"]);?></h5>
                <h5>IsLocked?: <?php echo htmlspecialchars($user["IsLocked"]);?></h5>
                <h5>Baste Count: <?php echo htmlspecialchars($user["BasteCount"]);?>/<?php echo htmlspecialchars($user["MaximumBastes"]);?></h5>
                <?php var_dump($user);?>
        </div>
    </div>
</div>
<!-- End Main Page Content -->


<?php include("./res/php/footer.php"); ?>