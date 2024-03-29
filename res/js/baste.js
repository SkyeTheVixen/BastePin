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
                        $('#favCount').text(parseInt($('#favCount').text()) + 1);

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
                        $('#favCount').text(parseInt($('#favCount').text()) - 1);
                    }
                }
            });
        }
    });

    $('#fav').mouseenter(function(){
        if($('#favouriteIcon').hasClass('far')){
            $('#fav').attr('title', 'Add to favourites');
        }
        else if($('#favouriteIcon').hasClass('fas')){
            $('#fav').attr('title', 'Remove from favourites');
        }
    });

    $('#fav').mouseleave(function(){
        $('#fav').removeAttr('title');
    });

    $('#commentForm').submit(function(event){
        event.preventDefault();
        $.ajax({
            url: '../res/php/addcomment.php',
            type: 'POST',
            data: {
                basteID: $('#fav').attr("data-basteid"),
                commentValue: $('#comment').val()
            },
            success: function(data){
                var dataResult = JSON.parse(data);
                if(dataResult.statusCode == 200){
                    Swal.fire({
                        title: 'Comment added',
                        icon: 'success',
                        heightAuto: false
                    }).then(function(){
                        location.reload();
                    });
                } else if(dataResult.statusCode == 201){
                    Swal.fire({
                        title: 'Oops...',
                        icon: 'error',
                        text: 'Something went wrong! Please ensure all fields are filled out',
                        heightAuto: false 
                    }).then(function(){
                        location.reload();
                    });
                }
            }
        });
    });

    $('#showcommsbut').click(function(event){
        event.preventDefault();
        $('#CommentsModal').modal('toggle');
    });

    $('#copybut').click(function(event){
        event.preventDefault();
        var copyText = $('#basteContents').text();
        navigator.clipboard.writeText(copyText).then(function() {
            $('#copyicon').removeClass('fa-clipboard');
            $('#copyicon').addClass('fa-clipboard-check');
            $('#copybut').addClass('text-success');
                setTimeout(function(){
                    $('#copyicon').removeClass('fa-clipboard-check');
                    $('#copyicon').addClass('fa-clipboard');
                    $('#copybut').removeClass('text-success');
                }, 1500);
        });
    });

    $('#dismisscommsbut').click(function(event){
        event.preventDefault();
        $('#CommentsModal').modal('toggle');
    });
});