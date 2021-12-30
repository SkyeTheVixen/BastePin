$(document).ready(function(){

    $('#fav').click(function(event){
        event.preventDefault();
        if($('#favouriteIcon').hasClass('far')){
            $.ajax({
                url: '../res/php/addfav.php',
                type: 'POST',
                data: {
                    basteID: $('#fav').attr("data-basteid"),
                    action: 'add'
                },
                success: function(data){
                    var dataResult = JSON.parse(data);
                    if(dataResult.statusCode == 200){
                        $('#favouriteIcon').removeClass('far');
                        $('#favouriteIcon').addClass('fas');
                    }
                }
            });
        }
        else if($('#favouriteIcon').hasClass('fas')){
            $.ajax({
                url: '../res/php/addfav.php',
                type: 'POST',
                data: {
                    basteID: $('#fav').attr("data-basteid"),
                    action: 'remove'
                },
                success: function(data){
                    var dataResult = JSON.parse(data);
                    if(dataResult.statusCode == 200){
                        $('#favouriteIcon').removeClass('fas');
                        $('#favouriteIcon').addClass('far');
                    }
                }
            });
        }
    });
});