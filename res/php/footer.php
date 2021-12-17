<?php if($currentPage == "baste" || $currentPage == "account"){$pathHead = "../res/";} else {$pathHead = "res/";}?>
<?php if($currentPage == "baste" || $currentPage == "account"){$pageredirect = "../";} else {$pageredirect = "";}?>

</body>
<footer class="py-3 ">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
        <li class="nav-item">
            <a href="<?php echo $pageredirect;?>index" class="nav-link px-2 text-muted">Home</a>
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
    <p class="text-center text-muted">© 2021 Vixendev</p>
</footer>

</html>