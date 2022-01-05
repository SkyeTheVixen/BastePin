<?php 
    session_start();
    $title="Premium | VDBP";
    $currentPage="premium";
    include("res/php/_authcheck.php");
    include("res/php/_connect.php");
    include("res/php/header.php");
    include("res/php/navbar.php");
    include("res/php/functions.inc.php");

    $user = GetUser($connect);
    if($user["IsPremium"]) {
        echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'You are already premium!', heightAuto: false }).then(function(){window.location.href='account';});</script>"; 
    }

    if(isset($_GET["er"])) {
        if($_GET["er"] == "insufperm") {
            echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'You did not have sufficient permission to do that', heightAuto: false });</script>"; 
        } else if($_GET["er"] == "nobastedel") {
            echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'There was no baste to delete', heightAuto: false });</script>"; 
        } else if($_GET["er"] == "cancel") {
            echo "<script>Swal.fire({ icon: 'warning', title: 'Payment cancelled.', text: 'You can always upgrade later', heightAuto: false });</script>"; 
        } else if($_GET["er"] == "invaltoken") {
            echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'The payment token was invalid', heightAuto: false });</script>"; 
        }
    }
?>
<!-- Main Page Content -->
<div class="container">

    <!-- Welcome Greeting -->
    <div class="row mb-5">
        <div class="col-12 mt-5 align-items-center text-center">
            <h1>Upgrade to Premium</h1>
        </div>
    </div>
    <!-- End Welcome Greeting -->

    <div class="row mt-5">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6 mb-1">
                <div class="card text-center border-dark h-100">
                    <div class="card-body">
                        <h5 class="card-title">Free</h5>
                        <p class="card-text">
                            <ul class="list-unstyled">
                                <li>- 10 Bastes</li>
                                <li>- No Password Protection</li>
                                <li>- Bastes Never Expire</li>
                                <li>- Public Bastes</li>
                                <li>- No Support</li>
                            </ul>
                        </p>
                    </div>
                    <div class="card-footer">
                        <h5 class="card-title">$0.00</h5>
                        <a href="account/" class="btn btn-secondary">Remain Free</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6 mb-1">
                <div class="card text-center border-dark h-100">
                    <div class="card-body">
                        <h5 class="card-title">Premium</h5>
                        <p class="card-text">
                            <ul class="list-unstyled">
                                <li>- Unlimited Bastes</li>
                                <li>- Password Protection</li>
                                <li>- Baste Expiration</li>
                                <li>- Private and Unlisted Bastes</li>
                                <li>- Priority Support</li>
                                <li>- Lifetime Support</li>
                            </ul>
                        </p>
                    </div>
                    <div class="card-footer">
                        <h5 class="card-title">$9.99</h5>
                        <form action="create-checkout-session.php" method="POST">
                            <button type="submit" class="btn btn-primary" id="checkout-button">Upgrade to premium</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Main Page Content -->


<?php include("./res/php/footer.php"); ?>