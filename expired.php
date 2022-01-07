<?php
    session_start();
    $title="Expired Baste | VDBP";
    $currentPage="expired";
    include("res/php/_connect.php");
    include("res/php/header.php");
    include("res/php/navbar.php");
    include("res/php/functions.inc.php");

    // If there is an error
    if(isset($_GET["er"])) {
        if($_GET["er"] == "insufperm") {
            echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'You did not have sufficient permission to do that', heightAuto: false });</script>"; 
        } else if($_GET["er"] == "nobastedel") {
            echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'There was no baste to delete', heightAuto: false });</script>"; 
        }
    }
?>
<!-- Main Page Content -->
<div class="container">  
    <!-- Page Title -->
    <div class="row mt-5">
        <div class="col-12 mt-5 align-items-center text-center">
            <h1 class="text-center">Baste Expired</h1>
            <h3 class="text-center">Unfortunately, this baste has expired</h3>
            <button class="btn btn-primary mt-5" onclick="window.location.href='index'">Go Home</button>
        </div>
    </div>
    <!-- End Page Title -->

</div>
<!-- End Main Page Content -->


<?php include("./res/php/footer.php"); ?>