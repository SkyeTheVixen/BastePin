$(document).ready(function(){

    $('#fav').click(function(event){
        event.preventDefault();
        if($('#fav').hasClass('far')){
            $.ajax({
                url: '../res/php/addfav.php',
                type: 'POST',
                data: {
                    basteID: $('#fav').attr("data-basteID"),
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
        else if($('#fav').hasClass('fas')){
            $.ajax({
                url: '../res/php/addfav.php',
                type: 'POST',
                data: {
                    basteID: $('#fav').attr("data-basteID"),
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