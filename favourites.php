<?php 
    //Header stuff
    session_start();
    $title="Favourite | VDBP";
    $currentPage="favourites";
    include("res/php/_connect.php");
    include("res/php/_authcheck.php");
    include("res/php/header.php");
    include("res/php/navbar.php");
    include("res/php/functions.inc.php");
    $mysqli = $connect;
    $mysqli -> autocommit(FALSE);

    // If there is an error
    if(isset($_GET["er"])) {
        if($_GET["er"] == "insufperm") {
            echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'You did not have sufficient permission to do that', heightAuto: false });</script>"; 
        } else if($_GET["er"] == "nobastedel") {
            echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'There was no baste to delete', heightAuto: false });</script>"; 
        }
    }

    $sql = "SELECT * FROM `tblBastes` WHERE  `tblBastes`.`Visibility` = 2 OR `tblBastes`.`UserID` = ? ORDER BY `tblBastes`.`CreatedAt` DESC";
    $stmt = $mysqli -> prepare($sql);
    $stmt->bind_param('s', $_SESSION["UserID"]);
    $stmt -> execute();
    $result = $stmt->get_result();
    $mysqli -> commit();
    $stmt -> close();
?>

<!-- Main Page Content -->
<div class="container">
    <div class="row mt-5">
        <h2 class="text-center">Favourite Bastes</h2>
        <div class="row">
            <?php 
                while($rows = $result -> fetch_array(MYSQLI_ASSOC)) {
                    $sql = "SELECT * FROM `tblFavourites` WHERE  `tblFavourites`.`BasteID` = ? AND `tblFavourites`.`UserID` = ?";
                    $stmt = $mysqli -> prepare($sql);
                    $stmt->bind_param('ss', $rows["BasteID"], $_SESSION["UserID"]);
                    $stmt -> execute();
                    $res = $stmt->get_result();
                    if($res -> num_rows > 0) {
            ?>
                <div class="col-12 col-md-6 col-lg-4 mb-1">
                    <div class="card">
                        <div class="card-body">
                            <?php $time = strtotime($rows["CreatedAt"]); ?>
                            <h5 class="card-title"><?php echo htmlspecialchars($rows['BasteName']); ?></h5>
                            <p class="card-text"><?php echo date("d M Y @ H:i", $time) ?></p>
                            <a href="baste/<?php echo $rows['BasteID']; ?>" class="btn btn-primary">View Baste</a>
                        </div>
                    </div>
                </div>
            <?php
                    }
                    $mysqli -> commit();
                    $stmt -> close();
            ?>

            <?php } ?>
        </div>
    </div>

</div>
<!-- End Main Page Content -->


<?php include("./res/php/footer.php"); ?>