<?php $title="Home | VDBP"; ?>
<?php $currentPage="index"; ?>
<?php include("res/php/_connect.php"); ?>
<?php include("res/php/header.php"); ?>
<?php include("res/php/navbar.php"); ?>
<?php include("res/php/functions.inc.php"); ?>

<!-- Main Page Content -->
<div class="container">

    <!-- Welcome Greeting -->
    <div class="row mb-5">
        <div class="col-12 mt-5 align-items-center">
            <h1>Upgrade to Premium</h1>
        </div>
    </div>
    <!-- End Welcome Greeting -->

    <div class="row mt-5">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6 mb-1">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Free</h5>
                        <p class="card-text"><ul>
                            <li>10 Bastes</li>
                            <li>No Password Protection</li>
                            <li>Bastes Never Expire</li>
                            <li>Public Bastes</li>
                            <li>No Support</li>
                        </ul></p>
                        <a href="" class="btn btn-secondary">Continue on Free</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6 mb-1">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Premium</h5>
                        <p class="card-text"><ul>
                            <li>Unlimited Bastes</li>
                            <li>Password Protection</li>
                            <li>Baste Expiration</li>
                            <li>Private and Unlisted Bastes</li>
                            <li>Priority Support</li>
                        </ul></p>
                        <a href="" class="btn btn-primary">Upgrade to premium</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Page Content -->


    <?php include("./res/php/footer.php"); ?>