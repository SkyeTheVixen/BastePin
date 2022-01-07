<?php
    $title="New Password | VDBP";
    $currentPage="newpass";
    include_once("res/php/header.php");
    include_once("res/php/_connect.php");
    if(!(isset($_GET["token"]))) {
        header("Location: login?er=notokensupplied");
        exit();
    }
    $sql = "SELECT * FROM `tblPasswordResets` WHERE `tblPasswordResets`.`Token` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $_GET["token"]);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 0) {
        header("Location: login?er=invalidtokensupplied");
        exit();
    }
    $sql = "SELECT * FROM `tblPasswordResets` WHERE `tblPasswordResets`.`Token` = ? AND `tblPasswordResets`.`Expiry` > NOW()";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $_GET["token"]);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 0) {
        header("Location: login?er=expiredtokensupplied");
        exit();
    }
    $mysqli->commit();
    $stmt->close();

?>
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