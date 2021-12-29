<!-- Header stuff -->
<?php 
    session_start();
    $title="Home | VDBP";
    $currentPage="index";
    include("res/php/_authcheck.php");
    include("res/php/_connect.php");
    include("res/php/header.php");
    include("res/php/navbar.php");
    include("res/php/functions.inc.php");
    $mysqli = $connect;
    $User = GetUser($connect);
?>

<!-- Get all bastes -->
<?php
    $mysqli -> autocommit(FALSE);
    $sql = "SELECT * FROM `tblBastes` WHERE `tblBastes`.`Visibility` = 2 OR `tblBastes`.`UserID` = ? AND (`tblBastes`.`ExpiresAt` > date('Y-m-d H:i:s') OR `tblBastes`.`ExpiresAt` = '0000-00-00 00:00:00' OR `tblBastes`.`ExpiresAt` = '' OR `tblBastes`.`ExpiresAt` = NULL) ORDER BY `tblBastes`.`CreatedAt` DESC";
    $stmt = $mysqli -> prepare($sql);
    $stmt -> bind_param('s', $_SESSION["UserID"]);
    $stmt -> execute();
    $result = $stmt->get_result();
    $mysqli -> commit();
    $stmt -> close();
?>

<!-- If there is an error -->
<?php
    if(isset($_GET["er"])) {
        if($_GET["er"] == "insufperm") {
            echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'You did not have sufficient permission to do that', heightAuto: false });</script>"; 
        } else if($_GET["er"] == "nobastedel") {
            echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'There was no baste to delete', heightAuto: false });</script>"; 
        }else if($_GET["er"] == "bastedelsuc") {
            echo "<script>Swal.fire({ icon: 'success', title: 'Deleted!', text: 'Baste has been deleted!', heightAuto: false });</script>"; 
        }
    }
?>

<!-- Main Page Content -->
<div class="container">

    <!-- Welcome Greeting -->
    <div class="row mb-5">
        <div class="col-12 mt-5 align-items-center">
            <h1 class="text-center"><?php echo getGreeting(); ?>, <?php echo htmlspecialchars($User["FirstName"]);?> <?php echo htmlspecialchars($User["LastName"]);?></h1>
        </div>
    </div>
    <!-- End Welcome Greeting -->

    <div class="row mt-5">
        <h2 class="text-center">Recent Public Bastes</h2>
        <div class="row mb-3">
            <?php while($rows = $result -> fetch_array(MYSQLI_ASSOC)) { ?>
                <div class="col-12 col-md-6 col-lg-4 mb-1">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($rows['BasteName']); ?></h5>
                            <p class="card-text"><?php echo $rows['CreatedAt']; ?></p>
                            <div class="col-4">
                                <a href="baste/<?php echo $rows['BasteID']; ?>" class="btn btn-primary">View Baste</a>
                            </div>
                            <div class="col-4">
                                <p></p>
                            </div>
                            <div class="col-4"></div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="row mt-5">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" width=100% height=385 src="https://www.youtube-nocookie.com/embed/5GJWxDKyk3A?controls=0" alloq="encrypted-media;" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-6 col-sm-12">
                <!-- Sidebar -->
            </div>
        </div>
    </div>

</div>
<!-- End Main Page Content -->


<?php include("./res/php/footer.php"); ?>