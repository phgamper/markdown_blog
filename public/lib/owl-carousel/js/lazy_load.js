$(document).ready(function() {

    $("#carousel").owlCarousel({
        items : 1,
        lazyLoad : true,
        navigation : true,
        navigationText: [
            '<i class="fa fa-chevron-left"></i>',
            '<i class="fa fa-chevron-right"></i>'
        ],
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
