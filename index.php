<?php $title="Home | VDBP"; ?>
<?php $currentPage="index"; ?>
<?php include("./res/php/header.php"); ?>


<body>
    <!-- Navigation bar -->
    <nav class="navbar navbar-dark navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="index">
                <img src="res/img/vdLogoFull.png" alt="VD Training Logo" width="30" height="24"
                    class="d-inline-block align-text-top">
                BastePin
            </a>
            <button class="navbar-toggler " type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse w-100" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link link-light active" aria-current="page" href="index"><i
                                class="fas fa-home"></i>
                            Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-light" href="courses"><i class="fas fa-graduation-cap"></i>Courses</a>
                    </li>
                    <li class="nav-item">
                        <a href="account/" class="nav-link link-light"><i class="far fa-id-badge"></i> My Account</a>
                    </li>
                    <li class="nav-item right" id="logoutBtn">
                        <a href="php/logout" class="nav-link link-light"><i class="fas fa-door-open"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navigation bar -->

    <!-- Main Page Content -->
    <div class="container">

        <!-- Welcome Greeting -->
        <div class="row">
            <div class="col-12 mt-5 align-items-center">
                <h1 class="text-center"><?php echo getGreeting(); ?>, <?php echo getUser()["FirstName"];?></h1>
            </div>
        </div>
        <!-- End Welcome Greeting -->

        <br>

        <button type="button" class="btn btn-primary btn-lg btn-block" id="button">
            <i class="fas fa-paper-airplane">Send Test Email
        </button>

    </div>
    <!-- End Main Page Content -->

    <?php include("./php/_footer.php"); ?>
</body>

</html>