<?php session_start();?>
<?php $title="Baste | VDBP"; ?>
<?php $currentPage="baste"; ?>
<?php include("res/php/_connect.php"); ?>
<?php include("res/php/header.php"); ?>
<?php include("res/php/navbar.php"); ?>
<?php include("res/php/functions.inc.php"); ?>
<?php if(isset($_GET["BasteID"])) {$baste = getBaste($connect, $_GET["BasteID"]);}?>
<?php $sql = "SELECT * FROM `tblBastes` WHERE `tblBastes`.`Visibility` = 2 ORDER BY `tblBastes`.`CreatedAt` DESC"; ?>
<?php $query = mysqli_query($connect, $sql); ?>

<!-- Main Page Content -->
<div class="container">

    <!-- If there is a baste -->
    <?php if(!($_GET["BasteID"] == "")) {?>
        <?php
            $BasteCreatedBy = GetUserById($connect, $baste["UserID"]);
            $BasteCreatedBy = $BasteCreatedBy["FirstName"] . " " . $BasteCreatedBy["LastName"];
            switch($baste["visibility"]){
                case 0:
                    $visibility = "Public";
                    break;
                case 1:
                    $visibility = "Friends";
                    break;
                case 2:
                    $visibility = "Only Me";
                    break;
            }
            $basteSize = byteConvert(sizeof($baste["BasteContents"]));
        ?>
        <!-- Page Title -->
        <div class="row">
            <div class="col-12 mt-5 align-items-center">
                <h1 class="text-center"><?php echo $baste["BasteName"];?></h1>
            </div>
        </div>
        <!-- End Page Title -->

        <!-- Code Block -->
        <div class="row">
            <div class="col-12 col-sm-6 mt-5 align-items-center">
                <pre><code><?php echo htmlspecialchars($baste["BasteContents"]);?></pre></code>
            </div>
            <div class="col-12 col-sm-6 mt-5 align-items-center">
                <h4>Details</h4>
                <div class="row">
                    <div class="col-12">
                        <p><strong>Author:</strong> <?php echo $BasteCreatedBy;?></p>
                    </div>
                    <div class="col-12">
                        <p><strong>Visibility:</strong> <?php echo $visibility;?></p>
                    </div>
                    <div class="col-12">
                        <p><strong>Created:</strong> <?php echo $baste["CreatedAt"];?></p>
                    </div>
                    <div class="col-12">
                        <p><strong>Last Edited At:</strong> <?php echo $baste["UpdatedAt"];?></p>
                    </div>
                    <div class="col-12">
                        <p><strong>Size:</strong> <?php echo $basteSize;?></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Code block -->

    <?php } ?>

    <!-- If there is not a baste -->
    <?php if ($_GET["BasteID"] == "") { ?>
        <div class="row mt-5">
            <h2 class="text-center">All Bastes</h2>
            <div class="row">
                <?php while($rows = mysqli_fetch_assoc($query)) { ?>
                    <div class="col-12 col-md-6 col-lg-4 mb-1">
                        <div class="card">
                            <div class="card-body">
                                <?php $time = strtotime($rows["CreatedAt"]); ?>
                                <h5 class="card-title"><?php echo $rows['BasteName']; ?></h5>
                                <p class="card-text"><?php echo date("d M Y @ H:i", $time) ?></p>
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