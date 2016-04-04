function enqueue(qname, div) {
    $(document).queue(qname, function() {
        var items  = div.find("img");
        if( items.length  > 0 ){
            var img = items.first(); // get id of first image

            $.ajax({
                type: 'GET',
                url: '/image.php?src=' + img.data('src') + '&width=' + div.context.offsetWidth,
                data: 'html',
                success: function(data){
                    img.attr('src', data);
                    $(document).dequeue(qname);
                }
            });
        } else {
            // images not found
            $(document).dequeue(qname);
        }
    });
}

$(document).ready(function() {
    var queue = 'queue';
    $(".img-resize").each(function(){
        enqueue(queue, $(this));
    });
    $(document).dequeue(queue);
})

