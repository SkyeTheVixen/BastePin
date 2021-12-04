$(document).ready(function () {
    $("#newBasteForm").submit(function (event) {
        event.preventDefault();
        var basteName = $("#basteName").val();
        var basteContents = $("#basteContents").val();
        var basteVisibility = $("#basteVisibility").val();
        var basteExpiresAt = $("#basteExpiresAt").val();
        var bastePasswordRequired = $("#bastePasswordRequired").val();
        var bastePassword = $("#bastePassword").val();
        if (basteName === "" || basteContents === "") {
            return Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Please ensure required fields are filled in',
                heightAuto: false
            });
        }
        $.ajax({
            type: "post",
            url: "res/php/addbaste.php",
            data: {
                basteTitle: basteTitle,
                basteContents: basteContents,
                basteVisibility: basteVisibility,
                expiresAt: basteExpiresAt,
                passwordRequired: bastePasswordRequired,
                bastePassword: bastePassword,
            },
            cache: false,
            success: function (dataResult) {
                var DataResult = JSON.parse(dataResult);
                if (DataResult.statusCode === 200) {
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
    });

    $("#bastePasswordRequired").click(function(){
        console.log("event fired")
        $.ajax({
            type: "post",
            url: "res/php/checkpremium.php",
            cache: false,
            success: function (dataResult) {
                var DataResult = JSON.parse(dataResult);
                if (DataResult.premiumStatus === 1) {
                    if(this.checked){
                        $("#bastePassword").prop("disabled", false)
                    }
                    else{
                        $("#bastePassword").prop("disabled", true)
                    }
                } else if (DataResult.premiumStatus === 0) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Nice Try',
                        text: 'Upgrade to <a href="premium">premium</a> to enable this feature',
                        heightAuto: false
                    });
                }
            }
        })

    });
})