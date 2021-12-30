$(document).ready(function(){

    $('#fav'+basteID).click(function(event){
        event.preventDefault();
        if($('#fav'+basteID).hasClass('far')){
            $.ajax({
                url: '../res/php/addfav.php',
                type: 'POST',
                data: {
                    basteID: basteID,
                    action: 'add'
                },
                success: function(data){
                    var dataResult = JSON.parse(data);
                    if(dataResult.statusCode == 200){
                        $('#fav'+basteID).removeClass('far');
                        $('#fav'+basteID).addClass('fas');
                    }
                }
            });
        }
        if($('#fav'+basteID).hasClass('fas')){
            $.ajax({
                url: '../res/php/addfav.php',
                type: 'POST',
                data: {
                    basteID: basteID,
                    action: 'remove'
                },
                success: function(data){
                    var dataResult = JSON.parse(data);
                    if(dataResult.statusCode == 200){
                        $('#fav'+basteID).removeClass('fas');
                        $('#fav'+basteID).addClass('far');
                    }
                }
            });
        }
    });
});