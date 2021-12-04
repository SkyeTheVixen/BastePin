<?php $title="Home | VDBP"; ?>
<?php $currentPage="index"; ?>
<?php include("res/php/_connect.php"); ?>
<?php include("res/php/header.php"); ?>
<?php include("res/php/navbar.php"); ?>
<?php include("res/php/functions.inc.php"); ?>
<?php $User = GetUser($connect); ?>
<?php $sql = "SELECT * FROM `tblBastes` WHERE `tblBastes`.`Visibility` = 2 ORDER BY `tblBastes`.`CreatedAt` DESC LIMIT 6"; ?>
<?php $query = mysqli_query($connect, $sql); ?>


<!-- Main Page Content -->
<div class="container">

    <!-- Welcome Greeting -->
    <div class="row mb-5">
        <div class="col-12 mt-5 align-items-center">
            <h1 class="text-center"><?php echo getGreeting(); ?>, <?php echo $User["FirstName"];?> <?php echo $User["LastName"];?></h1>
        </div>
        <h2><?php echo $_SESSION["UserID"]; ?></h2>
    </div>
    <!-- End Welcome Greeting -->

    <div class="row mt-5">
        <h2 class="text-center">Recent Bastes</h2>
        <div class="row">
            <?php while($rows = mysqli_fetch_assoc($query)) { ?>
                <div class="col-12 col-md-6 col-lg-4 mb-1">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $rows['BasteName']; ?></h5>
                            <p class="card-text"><?php echo $rows['CreatedAt']; ?></p>
                            <a href="baste/<?php echo $rows['BasteID']; ?>" class="btn btn-primary">View Baste</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

</div>
<!-- End Main Page Content -->


<?php include("./res/php/footer.php"); ?>