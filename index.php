<?php $title="Home | VDBP"; ?>
<?php $currentPage="index"; ?>
<?php include_once("res/php/_connect.php"); ?>
<?php include_once("res/php/header.php"); ?>
<?php include_once("res/php/navbar.php"); ?>
<?php include_once("res/php/functions.inc.php"); ?>
<?php $User = GetUser(); ?>

<!-- Main Page Content -->
<div class="container">

    <!-- Welcome Greeting -->
    <div class="row">
        <div class="col-12 mt-5 align-items-center">
            <h1 class="text-center"><?php echo getGreeting(); ?>, <?php echo $User["FirstName"] . " ". $User["LastName"];?></h1>
        </div>
    </div>
    <!-- End Welcome Greeting -->

    <div class="row">
        <h2 class="text-center">Recent Bastes</h2>
        <div class="row">
            <?php
                $visibility = 2;
                $sql = "SELECT * FROM `tblBastes` WHERE `tblBastes`.`Visibility` = ? ORDER BY `tblBastes`.`CreatedAt` DESC LIMIT 5";
                $stmt = mysqli_prepare($connect, $sql);
                mysqli_stmt_bind_param($stmt, 'i', $visibility);
                $stmt -> execute();
                $result = $stmt->get_result();
                while ($baste = $result->fetch_array(MYSQLI_ASSOC)) {
                    echo '<div class="col-12 col-md-6 col-lg-4"> <div class="card"> <div class="card-body"> <h5 class="card-title">' . $baste["BasteName"] . '</h5> <p class="card-text">' . $baste["CreatedAt"] . '</p> <a href="baste.php?id=' . $baste["BasteID"] . '" class="btn btn-primary">View Baste</a> </div> </div> </div>';
                }
                $stmt -> close();
            ?>
        </div>
    </div>

</div>
<!-- End Main Page Content -->


<?php include("./res/php/footer.php"); ?>