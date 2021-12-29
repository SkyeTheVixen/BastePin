<?php $title="New Password | VDBP"; ?>
<?php $currentPage="newpass"; ?>
<?php include_once("res/php/header.php"); ?>
<body>
    <!-- Main Page Content -->
    <div class="container-fluid h-100">
        <!-- Login Form -->
        <div class="row h-100 align-content-center justify-content-center">
            <div id="formcol" class="col-auto loginform align-items-center shadow">
                <div class="row pt-4">
                    <h1 class="text-center w-100">Enter New Password</h1>
                </div>
                <div class="row pb-4">
                    <form id="loginForm" method="POST" autocomplete="off">
                        <input type="hidden" id="token" value="<?php echo $_GET["token"]; ?>">
                        <div class="form-group pb-2">
                            <label for="InputPassword">Password</label>
                            <input type="password" name="txtPassword" class="form-control" id="InputPassword"
                                placeholder="P4s5w0Rd">
                        </div>
                        <div class="form-group pb-2">
                            <label for="InputPasswordConfirm">Password Confirm</label>
                            <input type="password" name="txtPasswordConfirm" class="form-control" id="InputPasswordConfirm"
                                placeholder="P4s5w0Rd">
                        </div>
                        <div class="form-group pt-2 text-center">
                            <button type="submit" id="loginBtn" class="btn btn-primary">Confirm Change</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Login Form -->
    </div>
    <!-- End Main Page Content -->

</body>

</html>