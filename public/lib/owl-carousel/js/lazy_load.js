$(document).ready(function() {

    $("#carousel").owlCarousel({
        items : 1,
        lazyLoad : true,
        navigation : false,
        autoHeight : true,
        singleItem : true,
        responsive : true,
        pagination : false
    });

});


$('#carousel-modal').on('shown.bs.modal', function(e) {
    var index = $(e.relatedTarget).data('index');
    $('#carousel').trigger('owl.jumpTo', index);
});

/*
$('.owl-jumpTo').click(function(){
    var index = parseInt($(this).attr('index'), 10);
    $('#carousel').trigger('owl.jumpTo', index);
});
*/
