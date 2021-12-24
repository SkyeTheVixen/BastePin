$(document).ready(function () {
    $("#loginForm").submit(function (event) {
        event.preventDefault();
        var email = $("#InputEmail").val();
        var password = $("#InputPassword").val();
        if (email === "" || password === "") {
            return Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'You may have entered invalid credentials. Please try again',
                heightAuto: false
            });
        }
        $.ajax({
            type: "post",
            url: "res/php/auth.php",
            data: {
                txtUser: email,
                txtPassword: password
            },
            cache: false,
            success: function (dataResult) {
                var DataResult = JSON.parse(dataResult);
                if (DataResult.statusCode === 200) {
                    console.log(dataResult);
                    location.href = "index";

                } else if (DataResult.statusCode === 201) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Your credentials were invalid.',
                        heightAuto: false
                    });
                } else if (DataResult.statusCode === 202) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'No user account was found with this email address',
                        heightAuto: false
                    });
                } else if (DataResult.statusCode === 203) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Please enter your email address And/Or Password',
                        heightAuto: false
                    });
                } else if (DataResult.statusCode === 204) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        html: 'Your Account is Locked. Please <a href="mailto:webmaster@vixendev.com">contact support</a>.',
                        heightAuto: false
                    });
                } else if (DataResult.statusCode === 205) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: 'You\'ve been IP blocked for 5 minutes due to multiple incorrect login attempts. Please <a href="mailto:webmaster@vixendev.com">contact support</a>.',
                        heightAuto: false
                    });
                }
            }
        });
    })

    $("#signupForm").submit(function (event) {
        event.preventDefault();
        var Email = $("#signupInputEmail").val();
        var Password = $("#signupInputPassword").val();
        var PasswordConfirm = $("#signupInputPasswordConfirm").val();
        var FirstName = $("#signupInputFirstName").val();
        var LastName = $("#signupInputLastName").val();
        if (Email === "" || Password === "" || PasswordConfirm === "" || FirstName === "" || LastName === "") {
            if(Email === ""){
                $("#signupInputEmail").addClass("border border-danger");
            }
            if(Password === ""){
                $("#signupInputPassword").addClass("border border-danger");
            }
            if(PasswordConfirm === ""){
                $("#signupInputPasswordConfirm").addClass("border border-danger");
            }
            if(FirstName === ""){
                $("#signupInputFirstName").addClass("border border-danger");
            }
            if(LastName === ""){
                $("#signupInputLastName").addClass("border border-danger");
            }
            return Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please ensure all fields are filled in',
                heightAuto: false
            });
        }
        else if(Password !== PasswordConfirm){
            $("#signupInputPassword").focus();
            return Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please Ensure Your passwords match',
                heightAuto: false
            });
        }
        $.ajax({
            type: "post",
            url: "res/php/signup.php",
            data: {
                FirstName: FirstName,
                LastName: LastName,
                Email: Email,
                Password: Password,
                PasswordConfirm: PasswordConfirm
            },
            cache: false,
            success: function (dataResult) {
                var DataResult = JSON.parse(dataResult);
                if (DataResult.statusCode === 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Congrats!',
                        text: 'We\'ve sent you an email with a link to confirm your account, please check your spam if it does not arrive. If you havent received it after 5 minutes, please contact support with your name and email address and we will endeavour to sort it for you.',
                        heightAuto: false
                    });
                } else if (DataResult.statusCode === 201) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'You are missing values.',
                        heightAuto: false
                    });
                } else if (DataResult.statusCode === 202) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Your passwords do not match',
                        heightAuto: false
                    });
                } else if (DataResult.statusCode === 203) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'This email address is already in use',
                        heightAuto: false
                    });
                }
            }
        });
    })

    $("#passResetForm").submit(function (event) {
        event.preventDefault();
        var email = $("#emailInputReset").val();
        if (email === "") {
            return Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please enter your email address'
            });
        }
        $.ajax({
            type: "post",
            url: "../php/passreset.php",
            data: {
                email: email
            },
            cache: false,
            success: function (dataResult) {
                var DataResult = JSON.parse(dataResult);
                if (DataResult.statusCode === 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Password reset link has been sent to your email address'
                    });
                }  else if (DataResult.statusCode === 201) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong, try again.'
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown, jqXHR);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong! Please try again'
                });
            }
        });
    });
})