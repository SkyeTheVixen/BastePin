<?php session_start();?>
<?php $title="Account | VDBP"; ?>
<?php $currentPage="account"; ?>
<?php include("res/php/_connect.php"); ?>
<?php include("res/php/_authcheck.php"); ?>
<?php include("res/php/header.php"); ?>
<?php include("res/php/navbar.php"); ?>
<?php include("res/php/functions.inc.php"); ?>
<?php $user = getProfile($connect); ?>


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
            <div class="row h-25">
                <div class="col-8">
                    <h1><?php echo htmlspecialchars($user["FirstName"]." ".$user["LastName"]); ?></h1>
                </div>
                <div class="col-4">
                    <img src="https://proficon.stablenetwork.uk/api/identicon/<?php echo $user["UserID"];?>.svg" alt="Profile Icon" class="h-50"/>
                </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h5>Name: <?php echo htmlspecialchars($user["FirstName"]." ".$user["LastName"]);?></h5>
                <h5>Email: <?php echo htmlspecialchars($user["Email"]);?></h5>
                <h5>Premium status: <?php echo htmlspecialchars($user["IsPremium"]) ? 'Premium': 'Free';?></h5>
                <h5>Baste Count: <?php echo htmlspecialchars($user["BasteCount"]);?> / <?php echo htmlspecialchars($user["MaximumBastes"])?:'Infinity';?></h5>
                <h5>Company: <?php echo htmlspecialchars($user["Company"]);?></h5>
                <h5>Website: <?php echo htmlspecialchars($user["Website"]);?></h5>
                <h5>Location: <?php echo htmlspecialchars($user["Location"]);?></h5>
                <h5>Github: <a href="https://github.com/<?php echo htmlspecialchars($user["Github"]);?>"><?php echo htmlspecialchars($user["Github"]);?></a></h5>
                <h5>Twitter: @<a href="https://twitter.com/<?php echo htmlspecialchars($user["Twitter"]);?>"><?php echo htmlspecialchars($user["Twitter"]);?></a></h5>
                <div class="row mt-3">
                    <div class="col-12">
                        <a href="<?php echo $pageredirect; ?>editaccount" class="btn btn-primary">Edit Profile</a>
                        <?php if($user["IsPremium"] == 0) {?>
                            <a href="<?php echo $pageredirect; ?>premium" class="btn btn-primary">Upgrade to premium?</a>
                        <?php } ?>
                    </div>
                </div>
        </div>
    </div>
</div>
<!-- End Main Page Content -->


<?php include("./res/php/footer.php"); ?>