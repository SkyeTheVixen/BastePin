<?php 
    if($currentPage == "baste" || $currentPage == "profile" || $currentPage == "account"){
        $pathHead = "../res/";
        $pageredirect = "../";
    } 
    else {
        $pathHead = "res/";
        $pageredirect = "";
    }
?>

<body style="min-height: 100%;">
    <!-- Navigation bar -->
    <nav class="navbar navbar-dark navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="index">
                <img src="<?php echo $pathHead;?>img/vdLogoFull.png" alt="VD Training Logo" width="30" height="24"
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
                        <a href="<?php echo $pageredirect;?>index" <?php if($currentPage=="index"){ echo "class=\"nav-link link-light active\" aria-current=\"page\""; } else { echo "class=\"nav-link link-light\""; } ?>><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo $pageredirect;?>newbaste" <?php if($currentPage=="newbaste"){ echo "class=\"nav-link link-light active\" aria-current=\"page\""; } else { echo "class=\"nav-link link-light\""; } ?>><i class="fas fa-pencil-alt"></i> New Baste</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo $pageredirect;?>baste/" <?php if($currentPage=="baste"){ echo "class=\"nav-link link-light active\" aria-current=\"page\""; } else { echo "class=\"nav-link link-light\""; } ?>><i class="fas fa-eye"></i> View Bastes</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo $pageredirect;?>account/" <?php if($currentPage=="account"){ echo "class=\"nav-link link-light active\" aria-current=\"page\""; } else { echo "class=\"nav-link link-light\""; } ?>><i class="far fa-id-badge"></i> My Account</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo $pageredirect;?>favourites" <?php if($currentPage=="favourites"){ echo "class=\"nav-link link-light active\" aria-current=\"page\""; } else { echo "class=\"nav-link link-light\""; } ?>><i class="far fa-star"></i> Favourites</a>
                    </li>
                    <li class="nav-item right" id="logoutBtn">
                        <a href="<?php echo $pathHead;?>php/logout" class="nav-link link-light"><i class="fas fa-door-open"></i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navigation bar -->