<!-- Header stuff -->
<?php 
    session_start();
    $title="Baste | VDBP";
    $currentPage="baste";
    include("res/php/_connect.php");
    include("res/php/header.php");
    include("res/php/navbar.php");
    include("res/php/functions.inc.php");
    $mysqli = $connect;
?>
<!-- If there is an error -->
<?php
    if(isset($_GET["er"])) {
        if($_GET["er"] == "insufperm") {
            echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'You did not have sufficient permission to do that', heightAuto: false });</script>"; 
        } else if($_GET["er"] == "nobastedel") {
            echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'There was no baste to delete', heightAuto: false });</script>"; 
        }
    }
?>
<?php 
    if(isset($_GET["BasteID"])) {
        $basteID = $mysqli -> real_escape_string($_GET["BasteID"]);
        $baste = getBaste($connect, $basteID);
        if($baste["ExpiresAt"] < date("Y-m-d H:i:s") && $baste["ExpiresAt"] != "0000-00-00 00:00:00" && $baste["ExpiresAt"] != "" && $baste["ExpiresAt"] != NULL) {
            echo "<script>window.location.href=\"../expired\"</script>";
        }
    }
?>
<?php
    $mysqli -> autocommit(FALSE);
    $sql = "SELECT * FROM `tblBastes` WHERE ((`tblBastes`.`ExpiresAt` > NOW()) OR (`tblBastes`.`ExpiresAt` = NULL)) ORDER BY `tblBastes`.`CreatedAt` DESC";
    $stmt = $mysqli -> prepare($sql);
    mysqli_stmt_bind_param($stmt, 's', $_SESSION["UserID"]);
    $stmt -> execute();
    $result = $stmt->get_result();
    $mysqli -> commit();
    $stmt -> close();
?>

<!-- Main Page Content -->
<div class="container">

    <!-- If there is a baste -->
    <?php if(!($_GET["BasteID"] == "")) {?>
        <?php
            if($baste["Visibility"] == 0 && $baste["UserID"] != $_SESSION["UserID"]) {
                echo "<script> window.location.href='../index?er=insufperm'</script>";
            }
            $BasteCreatedBy = GetUserById($connect, $baste["UserID"]);
            $BasteCreatedBy = $BasteCreatedBy["FirstName"] . " " . $BasteCreatedBy["LastName"];
            switch($baste["Visibility"]){
                case 0:
                    $visibility = "Private";
                    break;
                case 1:
                    $visibility = "Unlisted";
                    break;
                case 2:
                    $visibility = "Public";
                    break;
            }
            $basteSize = byteConvert(mb_strlen($baste["BasteContents"]));
        ?>
        <!-- Page Title -->
        <div class="row">
            <div class="col-12 mt-5 align-items-center">
                <h1 class="text-center"><?php echo htmlspecialchars($baste["BasteName"]);?></h1>
            </div>
        </div>
        <!-- End Page Title -->

        <!-- Code Block and details -->
        <div class="row">
            <div class="row">
                <?php if($baste["UserID"] == $_SESSION["UserID"]){ ?>
                <div class="col-12 align-items-right text-right">
                    <a href="../editbaste/<?php echo $basteID; ?>"><i class="fas fa-pen"></i></a>
                    <a href="../deletebaste/<?php echo $basteID; ?>"><i class="fas fa-trash"></i></a>
                </div>
                <?php } ?>
            </div>
            <div class="row">
            <div class="col-12 col-sm-6 mt-5 align-items-center">
                <pre><code><?php echo htmlspecialchars($baste["BasteContents"]);?></pre></code>
            </div>
            <div class="col-12 col-sm-6 mt-5 align-items-center">
                <h4>Details</h4>
                <div class="row">
                    <div class="col-12">
                        <p><strong>Author:</strong> <a href="../profile/<?php echo $baste["UserID"]?>"><?php echo htmlspecialchars($BasteCreatedBy);?></a></p>
                    </div>
                    <div class="col-12">
                        <p><strong>Visibility:</strong> <?php echo htmlspecialchars($visibility);?></p>
                    </div>
                    <div class="col-12">
                        <p><strong>Created:</strong> <?php echo htmlspecialchars($baste["CreatedAt"]);?></p>
                    </div>
                    <div class="col-12">
                        <p><strong>Last Edited At:</strong> <?php echo htmlspecialchars($baste["UpdatedAt"]);?></p>
                    </div>
                    <div class="col-12">
                        <p><strong>Size:</strong> <?php echo htmlspecialchars($basteSize);?></p>
                    </div>
                </div>
            </div>
            </div>
            
        </div>
        <!-- End Code block and details -->

        <!-- Spacing -->
        <div class="row my-3"></div>
        <!-- End Spacing -->

        <!-- Comments and other bastes -->
        <div class="row">
            <div class="col-12 col-sm-6">
                <h3>Comments</h3>
            </div>
            <div class="col-12 col-sm-6">
                <h3>Other Bastes</h3>
                <div class="row">
                    <?php 
                        $mysqli -> autocommit(FALSE);
                        $sql = "SELECT * FROM `tblBastes` WHERE `tblBastes`.`Visibility` = 2 OR `tblBastes`.`UserID` = ? ORDER BY `tblBastes`.`CreatedAt` DESC LIMIT 3";
                        $stmt = $mysqli -> prepare($sql);
                        mysqli_stmt_bind_param($stmt, 's', $_SESSION["UserID"]);
                        $stmt -> execute();
                        $result = $stmt->get_result();
                        $mysqli -> commit();
                        $stmt -> close();
                        while($rows = $result -> fetch_array(MYSQLI_ASSOC)) { 
                    ?>
                        <div class="col-12 col-md-6 col-lg-4 mb-1">
                            <div class="card">
                                <div class="card-body">
                                    <?php $time = strtotime($rows["CreatedAt"]); ?>
                                    <h5 class="card-title"><?php echo htmlspecialchars($rows['BasteName']); ?></h5>
                                    <p class="card-text"><?php echo date("d M Y @ H:i", $time) ?></p>
                                    <a href="<?php echo $rows['BasteID']; ?>" class="btn btn-primary">View Baste</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- End Comments and other bastes -->

    <?php } ?>



    <!-- If there is not a baste -->
    <?php if ($_GET["BasteID"] == "") { ?>
        <div class="row mt-5">
            <h2 class="text-center">All Bastes</h2>
            <div class="row">
                <?php while($rows = $result -> fetch_array(MYSQLI_ASSOC)) { ?>
                    <div class="col-12 col-md-6 col-lg-4 mb-1">
                        <div class="card">
                            <div class="card-body">
                                <?php $time = strtotime($rows["CreatedAt"]); ?>
                                <h5 class="card-title"><?php echo htmlspecialchars($rows['BasteName']); ?></h5>
                                <p class="card-text"><?php echo date("d M Y @ H:i", $time) ?></p>
                                <a href="<?php echo $rows['BasteID']; ?>" class="btn btn-primary">View Baste</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>

</div>
<!-- End Main Page Content -->


<?php include("./res/php/footer.php"); ?>