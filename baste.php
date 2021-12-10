<?php session_start();?>
<?php $title="Baste | VDBP"; ?>
<?php $currentPage="baste"; ?>
<?php include("res/php/_connect.php"); ?>
<?php include("res/php/header.php"); ?>
<?php include("res/php/navbar.php"); ?>
<?php include("res/php/functions.inc.php"); ?>
<?php if(isset($_GET["BasteID"])) {$baste = getBaste($connect, $_GET["BasteID"]);}?>
<?php $sql = "SELECT * FROM `tblBastes` WHERE `tblBastes`.`Visibility` = 2 ORDER BY `tblBastes`.`CreatedAt` DESC LIMIT 6"; ?>
<?php $query = mysqli_query($connect, $sql); ?>

<!-- Main Page Content -->
<div class="container">

    <!-- If there is a baste -->
    <?php if(!($_GET["BasteID"] == "")) {?>
        <!-- Page Title -->
        <div class="row">
            <div class="col-12 mt-5 align-items-center">
                <h1 class="text-center"><?php echo $baste["BasteName"];?></h1>
            </div>
        </div>
        <!-- End Page Title -->

        <!-- Code Block -->
        <div class="row">
            <div class="col-12 mt-5 align-items-center">
                <pre><?php echo htmlspecialchars($baste["BasteContents"]);?></pre>
            </div>
        </div>
        <!-- End Code block -->

    <?php } ?>

    <!-- If there is not a baste -->
    <?php if ($_GET["BasteID"] == "") { ?>
        <div class="row mt-5">
            <h2 class="text-center">Recent Bastes</h2>
            <div class="row">
                <?php while($rows = mysqli_fetch_assoc($query)) { ?>
                    <div class="col-12 col-md-6 col-lg-4 mb-1">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $rows['BasteName']; ?></h5>
                                <p class="card-text"><?php echo $rows['CreatedAt']; ?></p>
                                <a href="<?php echo $rows['BasteID']; ?>" class="btn btn-primary">View Baste</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <br>

</div>
<!-- End Main Page Content -->


<?php include("./res/php/footer.php"); ?>