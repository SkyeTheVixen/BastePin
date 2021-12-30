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
<div class="row mb-5"></div>
<div class="row mb-5"></div>
<footer class="py-3 mt-3 bg-dark" style="bottom: 0;">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
        <li class="nav-item">
            <a href="<?php echo $pageredirect;?>index" class="nav-link text-light px-2 text-muted">Home</a>
        </li>
        <li class="nav-item">
            <a href="<?php echo $pageredirect;?>newbaste" class="nav-link px-2 text-muted">New Baste</a>
        </li>
        <li class="nav-item">
            <a href="<?php echo $pageredirect;?>baste/" class="nav-link px-2 text-muted">View Bastes</a>
        </li>
        <li class="nav-item">
            <a href="<?php echo $pageredirect;?>account/" class="nav-link px-2 text-muted">My Account</a>
        </li>
    </ul>
    <p class="text-center text-muted pb-3">© 2021 Vixendev</p>
</footer>
</body>


</html>