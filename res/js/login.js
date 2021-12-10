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
                        text: 'Your Account is Locked. Please contact support.',
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
            url: "../php/passReset.php",
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

    $(window).bind('resize', function() {
        if($(window).width() < 768 && $("#formcol").hasClass("w-35")){
            $("#formcol").addClass("w-100");
            $("#formcol").removeClass("w-35");
        }
        else if($(window).width() > 768 && $("#formcol").hasClass("w-100")){
            $("#formcol").addClass("w-35");
            $("#formcol").removeClass("w-100");
        }
    });
}).trigger('resize');