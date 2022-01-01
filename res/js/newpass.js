$(document).ready(function () {
    $("#loginForm").submit(function (event) {
        event.preventDefault();
        var password = $("#InputPassword").val();
        var passwordConfirm = $("#InputPasswordConfirm").val();
        var token = $("#token").val();
        if (password === "" || passwordConfirm === "") {
            return Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please ensure both fields are filled in',
                heightAuto: false
            });
        }
        $.ajax({
            type: "post",
            url: "res/php/newpass.php",
            data: {
                password: password,
                passwordConfirm: passwordConfirm,
                token: token
            },
            cache: false,
            success: function (dataResult) {
                var DataResult = JSON.parse(dataResult);
                if (DataResult.statusCode === 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Password changed successfully',
                        heightAuto: false
                    }).then(function () {
                        window.location.href = "login";
                    });
                } else if (DataResult.statusCode === 201) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please ensure both fields are filled in',
                        heightAuto: false
                    });
                } else if (DataResult.statusCode === 202) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please ensure your new passwords match',
                        heightAuto: false
                    });
                } else if (DataResult.statusCode === 202) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Your token is expired. please request a new one',
                        heightAuto: false
                    });
                }
            }
        });
    })
});