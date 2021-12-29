$(document).ready(function () {
    $("#newBasteForm").submit(function (event) {
        event.preventDefault();
        var basteName = $("#basteName").val();
        var basteContents = $("#basteContents").val();
        var basteVisibility = $("#basteVisibility").val();
        var basteExpiresAt = $("#basteExpiresAt").val();
        var bastePasswordRequired = $("#bastePasswordRequired").val();
        var bastePassword = $("#bastePassword").val();
        var basteID = $("#BasteID").val();
        if (basteName === "" || basteContents === "" || basteID === "") {
            return Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Please ensure required fields are filled in',
                heightAuto: false
            });
        }
        $.ajax({
            type: "post",
            url: "../res/php/checkpremium.php",
            cache: false,
            success: function (dataResult) {
                var DataResult = JSON.parse(dataResult);
                if (DataResult.statusCode === 200) {
                    $.ajax({
                        type: "post",
                        url: "../res/php/edit.php",
                        data: {
                            basteName: basteName,
                            basteContents: basteContents,
                            basteVisibility: basteVisibility,
                            expiresAt: basteExpiresAt,
                            passwordRequired: bastePasswordRequired,
                            bastePassword: bastePassword,
                            basteID: basteID
                        },
                        cache: false,
                        success: function (dataResult) {
                            var DataResult = JSON.parse(dataResult);
                            if (DataResult.statusCode === 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Congratulations!',
                                    text: 'Baste Modified.',
                                    heightAuto: false
                                });
                                window.location.href = "../baste/" + basteID;
                            } else if (DataResult.statusCode === 201) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Please fill in all required fields.',
                                    heightAuto: false
                                });
                            } else if (DataResult.statusCode === 202) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    html: 'Something went wrong, you may not have permission to make this request.',
                                    heightAuto: false
                                });
                            }
                        }
                    });
                }
                if (DataResult.statusCode === 201) {
                    $.ajax({
                        type: "post",
                        url: "../res/php/edit.php",
                        data: {
                            basteName: basteName,
                            basteContents: basteContents,
                            basteVisibility: 2,
                            expiresAt: null,
                            passwordRequired: 0,
                            bastePassword: null,
                            basteID: basteID
                        },
                        cache: false,
                        success: function (dataResult) {
                            var DataResult = JSON.parse(dataResult);
                            if (DataResult.statusCode === 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Congratulations!',
                                    text: 'Baste Modified.',
                                    heightAuto: false
                                });
                                window.location.href = "../baste/" + basteID;
                            } else if (DataResult.statusCode === 201) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Please fill in all required fields.',
                                    heightAuto: false
                                });
                            } else if (DataResult.statusCode === 202) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    html: 'Something went wrong, you may not have permission to make this request.',
                                    heightAuto: false
                                });
                            }
                        }
                    });
                }
            }
        });
    });

    $("#bastePasswordRequired").change(function(){
        $.ajax({
            type: "post",
            url: "../res/php/checkpremium.php",
            cache: false,
            success: function (dataResult) {
                var DataResult = JSON.parse(dataResult);
                if (DataResult.statusCode === 200) {
                    if($("#bastePasswordRequired").prop("checked")){
                        $("#bastePassword").removeAttr("disabled");
                        $("#bastePassword").attr("required", true);
                    }
                    else{
                        $("#bastePassword").removeAttr("required");
                        $("#bastePassword").attr("disabled", true);
                    }
                } else if (DataResult.statusCode === 201) {
                    DisableAll();
                    Swal.fire({
                        icon: 'info',
                        title: 'Nice Try',
                        html: "Upgrade to <a href=\"premium\">premium</a> to enable this feature",
                        heightAuto: false
                    });
                } else if (DataResult.statusCode === 202) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'error',
                        heightAuto: false
                    });
                }
            }
        })

    });

    $("#basteExpiresCheck").change(function(){
        $.ajax({
            type: "post",
            url: "../res/php/checkpremium.php",
            cache: false,
            success: function (dataResult) {
                var DataResult = JSON.parse(dataResult);
                if (DataResult.statusCode === 200) {
                    if($("#basteExpiresCheck").prop("checked")){
                        $("#basteExpiresAt").attr("required", true);
                        $("#basteExpiresAt").removeAttr("disabled");
                    }
                    else{
                        $("#basteExpiresAt").attr("disabled", true);
                        $("#basteExpiresAt").removeAttr("required");
                    }
                } else if (DataResult.statusCode === 201) {
                    DisableAll();
                    Swal.fire({
                        icon: 'info',
                        title: 'Nice Try',
                        html: "Upgrade to <a href=\"premium\">premium</a> to enable this feature",
                        heightAuto: false
                    });
                } else if (DataResult.statusCode === 202) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'error',
                        heightAuto: false
                    });
                }
            }
        })

    });

    function DisableAll(){
        $("#bastePasswordRequired").prop('checked', false);
        $("#bastePasswordRequired").attr("disabled", true);
        $("#basteExpiresCheck").prop('checked', false);
        $("#basteExpiresCheck").attr("disabled", true);
        $("#bastePassword").attr("disabled", true);
        $("#bastePassword").removeAttr("required");
        $("#basteExpiresAt").attr("disabled", true);
        $("#basteExpiresAt").removeAttr("required");
    }

})