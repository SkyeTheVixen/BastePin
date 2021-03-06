<?php $title="Login | VDBP"; ?>
<?php $currentPage="login"; ?>
<?php include_once("res/php/header.php"); ?>

<body>
    <?php
    if(isset($_GET["er"])) {
        if($_GET["er"] == "noactivcode") {
            echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Something went wrong with the activation link. Please try again.', heightAuto: false });</script>";
        } else if($_GET["er"] == "invalidactivcode") {
            echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'That activation code was invalid', heightAuto: false });</script>";
        } else if ($_GET["er"] == "prevActivation") {
            echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'You have already activated your account. Please login.', heightAuto: false });</script>";
        } else if ($_GET["er"] == "activationSuccess") {
            echo "<script>Swal.fire({ icon: 'success', title: 'Congrats!', text: 'Your Account has been activated! Please log in', heightAuto: false });</script>"; 
        } else if ($_GET["er"] == "notokensupplied") {
            echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'No token was supplied, please request one', heightAuto: false });</script>"; 
        } else if ($_GET["er"] == "expiredtokensupplied") {
            echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Your token has expired, please request a new one', heightAuto: false });</script>"; 
        } else if ($_GET["er"] == "invalidtokensupplied") {
            echo "<script>Swal.fire({ icon: 'warning', title: 'Oops...', text: 'Your token was invalid, please request a new one', heightAuto: false });</script>"; 
        }
    }
?>
    <!-- Main Page Content -->
    <div class="container-fluid h-100">
        <!-- Login Form -->
        <div class="row h-100 align-content-center justify-content-center">
            <div id="formcol" class="col-auto loginform align-items-center shadow">
                <div class="row pt-4">
                    <h1 class="text-center w-100">Login to VD BastePin</h1>
                </div>
                <div class="row pb-4">
                    <form id="loginForm" method="POST" autocomplete="off">
                        <div class="form-group py-2">
                            <label for="InputEmail">Email address</label>
                            <input type="email" autocomplete="username" class="form-control" id="InputEmail" aria-describedby="emailHelp"
                                placeholder="joe@somedomain.com" name="txtUser">
                        </div>
                        <div class="form-group pb-2">
                            <label for="InputPassword">Password</label>
                            <input type="password" autocomplete="current-password" name="txtPassword" class="form-control" id="InputPassword"
                                placeholder="P4s5w0Rd">
                        </div>

                        <div class="form-group pt-2 text-center">
                            <button type="submit" id="loginBtn" class="btn btn-primary">Login</button>
                            <button type="button" id="forgotBtn" data-bs-toggle="modal"
                                data-bs-target="#forgotPassModal" class="btn btn-secondary">Forgot Password?</button>
                            <button type="button" id="signUpBtn" data-bs-toggle="modal" data-bs-target="#signUpModal"
                                class="btn btn-secondary">Sign Up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Login Form -->

        <!-- Modals -->

        <!-- <div class="modal fade" id="forgotPassModal" tabindex="-1" aria-labelledby="forgotUserModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Forgot Password</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label for="emailInput" class="form-label">Email address</label>
                                    <input type="email" required class="form-control" id="emailInput">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="addUserBtn">Send reset Link</button>
                        </div>
                    </div>
                </div>
            </div> -->

        <!-- Password Reset Modal -->
        <div class="modal fade" id="forgotPassModal" tabindex="-1" aria-labelledby="addUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Forgot Password?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="passResetForm">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="emailInputReset" class="form-label">Email address</label>
                                <input type="email" required class="form-control" id="emailInputReset">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="sendLinkBtn">Send Link</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- End Password Reset Modal -->


        <!-- Sign Up Modal -->
        <div class="modal fade" id="signUpModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sign Up</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="signupForm">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="signupInputFirstName" class="form-label">First Name</label>
                                <input type="text" required class="form-control" id="signupInputFirstName">
                                <label for="signupInputLastName" class="form-label">Last Name</label>
                                <input type="text" required class="form-control" id="signupInputLastName">
                                <label for="signupInputEmail" class="form-label">Email address</label>
                                <input type="email" required autocomplete="username" class="form-control" id="signupInputEmail">
                                <label for="signupInputPassword" class="form-label">Password</label>
                                <input type="password" required autocomplete="new-password" class="form-control" id="signupInputPassword">
                                <label for="signupInputPassword"  class="form-label">Password Confirm</label>
                                <input type="password" required autocomplete="new-password" class="form-control" id="signupInputPasswordConfirm">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="joinBtn">Join</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- End Password Reset Modal -->

        <!-- End Modals -->
    </div>
    <!-- End Main Page Content -->

    <script src="https://www.google.com/recaptcha/api.js?render=6LdvS8AeAAAAAN5SGsRA9MdxgpPCpeGh1zwPL2VG"></script>
    
</body>

</html>