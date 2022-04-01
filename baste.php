<?php
    //Header section
    session_start();
    $title="Baste | VDBP";
    $currentPage="baste";
    include("res/php/_connect.php");
    include("res/php/header.php");
    include("res/php/navbar.php");
    include("res/php/functions.inc.php");
    $mysqli -> autocommit(FALSE);

    //If there is an error
    if(isset($_GET["er"])) {
        if($_GET["er"] == "insufperm") {
            echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'You did not have sufficient permission to do that', heightAuto: false });</script>"; 
        } else if($_GET["er"] == "nobastedel") {
            echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'There was no baste to delete', heightAuto: false });</script>"; 
        }
    }

    //If there is a baste ID, fetch it and check if its expired
    if(isset($_GET["BasteID"]) && $_GET["BasteID"] != "") {
        $basteID = $_GET["BasteID"];
        $baste = getBaste($mysqli, $basteID);

        //If no baste is found
        if($baste == null){
            echo "<script>window.location.href='index?er=nobastefound'</script>";
        }

        //If the baste is private and the user is not the author
        if($baste["Visibility"] == 0 && $baste["UserID"] != $_SESSION["UserID"]) {
            echo "<script> window.location.href='../index?er=insufperm'</script>";
        }

        //If the baste is expired
        if($baste["ExpiresAt"] < date("Y-m-d H:i:s") && $baste["ExpiresAt"] != "0000-00-00 00:00:00" && $baste["ExpiresAt"] != "" && $baste["ExpiresAt"] != NULL) {
            echo "<script>window.location.href=\"../expired\"</script>";
        }

        //Fetch User Favourite for this baste
        $sql = "SELECT * FROM `tblFavourites` WHERE  `tblFavourites`.`BasteID` = ? AND `tblFavourites`.`UserID` = ?";
        $stmt = $mysqli -> prepare($sql);
        $stmt->bind_param('ss', $basteID, $_SESSION["UserID"]);
        $stmt -> execute();
        $favres = $stmt->get_result();
        $mysqli -> commit();
        $stmt -> close();

        //Comments
        $comments = fetchComments($mysqli, $basteID);
    }
    else{
        $sql = "SELECT * FROM `tblBastes` WHERE  `tblBastes`.`Visibility` = 2 OR `tblBastes`.`UserID` = ? ORDER BY `tblBastes`.`CreatedAt` DESC";
        $stmt = $mysqli -> prepare($sql);
        $stmt->bind_param('s', $_SESSION["UserID"]);
        $stmt -> execute();
        $result = $stmt->get_result();
        $mysqli -> commit();
        $stmt -> close();
    }
?>

<!-- Main Page Content -->
<div class="container">

    <!-- If there is a baste -->
    <?php if(!($_GET["BasteID"] == "")) {
        $BasteCreatedBy = GetUserById($mysqli, $baste["UserID"]);
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
            <?php $datetimenow = time()-86400;?>
            <h1 class="text-center"><?php echo htmlspecialchars($baste["BasteName"]);?>
                <?php if(strtotime($baste["CreatedAt"]) > $datetimenow){?><span
                    class="badge badge-secondary">New</span><?php } ?></h1>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Code Block and details -->
    <div class="row">
        <div class="row">
            <div class="col-12 align-items-right text-right">
                <div class="row">
                    <div class="col-1">
                        <p>Tools</p>
                    </div>
                    <div class="col-1">
                        <a id="fav" href="#" data-basteid="<?php echo $basteID;?>">
                            <h4><i id="favouriteIcon"
                                    <?php if($favres->num_rows > 0){echo "class='fas fa-star'";} else {echo "class='far fa-star'";} ?>></i>
                            </h4>
                        </a>
                    </div>
                    <div class="col-1">
                        <a href="#" id="copybut">
                            <h4><i id="copyicon" class="fas fa-clipboard"></i></h4>
                        </a>
                    </div>
                    <div class="col-1">
                        <?php if($baste["UserID"] == $_SESSION["UserID"]){ ?>
                        <a href="../editbaste/<?php echo $basteID; ?>">
                            <h4><i class="fas fa-pen"></i></h4>
                        </a>
                        <?php } ?>
                    </div>
                    <div class="col-1">
                        <?php if($baste["UserID"] == $_SESSION["UserID"]){ ?>
                        <a href="..res/php/deletebaste/<?php echo $basteID; ?>">
                            <h4><i class="fas fa-trash"></i></h4>
                        </a>
                        <?php } ?>
                    </div>
                    <div class="col-7"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-6 mt-5 align-items-center">
                <pre><code id="basteContents"><?php echo htmlspecialchars($baste["BasteContents"]);?></pre></code>
            </div>
            <div class="col-12 col-sm-6 mt-5 align-items-center">
                <h4>Details</h4>
                <div class="row">
                    <div class="col-12">
                        <p><strong>Author:</strong> <a
                                href="../profile/<?php echo $baste["UserID"]?>"><?php echo htmlspecialchars($BasteCreatedBy);?></a>
                        </p>
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
        <!-- Comments -->
        <div class="col-12 col-sm-6">
            <?php 
                if(!$comments === false){
                    if(count($comments) <= 3){
                        echo "<h3>Comments</h3>";
                        $maxCounter = count($comments);
                    }
                    else{
                        $maxCounter = 3;
                        echo "<h3>Comments <button type='button' id='showcommsbut' data-toggle='modal' data-target='#CommentsModal' class='btn btn-primary'>View All</button></h3>";
                    }
                    for($i = 0; $i < $maxCounter; $i++){
            ?>
            <div class="row py-1">
                <div class="card">
                    <div class="card-body">
                        <?php $time = time_elapsed_string($comments[$i]["CreatedAt"]); $user = GetUserById($mysqli, $comments[$i]["UserID"]); ?>
                        <p class="card-text">
                            <strong><?php echo htmlspecialchars($user["FirstName"] . " " . $user["LastName"]);?></strong>
                            <?php echo ": " . $comments[$i]["CommentValue"]; echo "<br>" . $time ?></p>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php } else { ?>
            <h3>Comments</h3>
            <form id="commentForm">
                <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea class="form-control" id="comment" rows="2"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Comment</button>
            </form>
            <?php } ?>
        </div>

        <!-- Other Bastes -->
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

    <?php if(!$comments === false){?>
    <!-- Comments Modal -->
    <div class="modal fade" id="CommentsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">All Comments</h5>
                    <button type="button" class="close" data-dismiss="modal" id="dismisscommsbut" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php for($i = 0; $i < count($comments); $i++) { ?>
                    <div class="row py-1">
                        <div class="card">
                            <div class="card-body">
                                <?php $time = time_elapsed_string($comments[$i]["CreatedAt"]); $user = GetUserById($mysqli, $comments[$i]["UserID"]); ?>
                                <p class="card-text">
                                    <strong><?php echo htmlspecialchars($user["FirstName"] . " " . $user["LastName"]);?></strong>
                                    <?php echo ": " . $comments[$i]["CommentValue"]; echo "<br>" . $time ?></p>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- End Comments Modal -->
    <?php } ?>
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
                        <a href="../baste/<?php echo $rows['BasteID']; ?>" class="btn btn-primary">View Baste</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <?php } ?>




</div>




<!-- End Main Page Content -->



<?php include("res/php/footer.php"); ?>