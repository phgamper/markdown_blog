$(".img-resize").each(function(){
    var div = $(this);
    var items  = div.find("img");
    if( items.length  > 0 ){
        var img = items.first(); // get id of first image

        $.ajax({
            type: 'GET',
            url: '/image.php?src=' + img.data('src') + '&width=' + div.context.offsetWidth,
            data: 'html',
            success: function(data){
                img.attr('src', data);
            }
        });
    } else {
        // images not found
    }
});

