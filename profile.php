<?php 
    session_start();
    $title="Profile | VDBP";
    $currentPage="profile";
    include("res/php/_connect.php");
    include("res/php/_authcheck.php");
    include("res/php/header.php");
    include("res/php/navbar.php");
    include("res/php/functions.inc.php");
    $mysqli -> autocommit(FALSE);
    $userID = $_GET["UserID"];
    $user = getProfileById($mysqli, $userID);

    // If there is an error
    if(isset($_GET["er"])) {
        if($_GET["er"] == "insufperm") {
            echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'You did not have sufficient permission to do that', heightAuto: false });</script>"; 
        } else if($_GET["er"] == "nobastedel") {
            echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'There was no baste to delete', heightAuto: false });</script>"; 
        }
    } 

    $mysqli -> autocommit(FALSE);
    $sql = "SELECT * FROM `tblBastes` WHERE  `tblBastes`.`Visibility` = 2 AND `tblBastes`.`UserID` = ? ORDER BY `tblBastes`.`CreatedAt` DESC";
    $stmt = $mysqli -> prepare($sql);
    $stmt -> bind_param('s', $userID);
    $stmt -> execute();
    $result = $stmt->get_result();
    $mysqli -> commit();
    $stmt -> close();
?>

<!-- Main Page Content -->
<div class="container">
    <div class="row my-3">
        <div class="col-12">
            <div class="row h-25">
                <div class="col-8">
                    <h1><?php echo htmlspecialchars($user["FirstName"]." ".$user["LastName"]); ?></h1>
                </div>
                <div class="col-4">
                    <img src="https://proficon.stablenetwork.uk/api/identicon/<?php echo $user["UserID"];?>.svg"
                        alt="Profile Icon" class="h-50" />
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h5>Name: <?= htmlspecialchars($user["FirstName"]." ".$user["LastName"]);?></h5>
                    <h5>Bastes: <?= htmlspecialchars($user["BasteCount"]);?></h5>
                    <?= $user["Company"] != NULL ? "<h5>Company: " . htmlspecialchars($user["Company"]) . "</h5>": "";?>
                    <?= $user["Website"] != NULL ? "<h5>Website: <a href='" . htmlspecialchars($user["Website"]) . "'>".htmlspecialchars($user["Website"]) . "</a></h5>": "";?>
                    <?= $user["Location"] != NULL ? "<h5>Location: " . htmlspecialchars($user["Location"]) . "</h5>": "";?>
                    <?= $user["Github"] != NULL ? "<h5>Github: <a href='https://github.com/" . htmlspecialchars($user["Github"]) . "'>".htmlspecialchars($user["Github"]) . "</a></h5>": "";?>
                    <?= $user["Twitter"] != NULL ? "<h5>Twitter: @<a href='https://twitter.com/" . htmlspecialchars($user["Twitter"]) . "'>".htmlspecialchars($user["Twitter"]) . "</a></h5>": "";?>
                </div>
            </div>
            <div class="row mt-5">
                <h2 class="text-center">Users Bastes</h2>
                <div class="row">
                    <?php while($rows = $result -> fetch_array(MYSQLI_ASSOC)) { ?>
                    <div class="col-12 col-md-6 col-lg-4 mb-1">
                        <div class="card">
                            <div class="card-body">
                                <?php $time = strtotime($rows["CreatedAt"]); ?>
                                <h5 class="card-title"><?php echo htmlspecialchars($rows['BasteName']); ?></h5>
                                <p class="card-text"><?php echo date("d M Y @ H:i", $time) ?></p>
                                <a href="../baste/<?php echo $rows['BasteID']; ?>" class="btn btn-primary">View Baste</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- End Main Page Content -->
    </div>
</div>

<?php include("./res/php/footer.php"); ?>