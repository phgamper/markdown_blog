$(document).ready(function() {

    //Sort random function
    function random(owlSelector){
        owlSelector.children().sort(function(){
            return Math.round(Math.random()) - 0.5;
        }).each(function(){
            $(this).appendTo(owlSelector);
        });
    }

    $("#owl-random-order").owlCarousel({
        items:3,
        lazyLoad:true,
        autoPlay:3000,
        autoWidth:true,
        loop:true,
        margin:10,
        navigation:false,
        navigationText: [
            '<i class="fa fa-chevron-left"></i>',
            '<i class="fa fa-chevron-right"></i>'
        ],
        pagination:false,
        beforeInit : function(elem){
            //Parameter elem pointing to $("#owl-demo")
            random(elem);
        }

    });

});
