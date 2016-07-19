
$('a.toggle-swipe').click(function() {
    var i = $(this).data('index');
    var items = [ ];
    $('span.img-swipe').each(function () {
        items.push({
            src: $(this).data('src'),
            w: $(this).data('width'),
            h: $(this).data('height')
        });
    });

    var pswpElement = document.querySelectorAll('.pswp')[0];
    // build items array
    // define options (if needed)
    var options = {
        // history & focus options are disabled on CodePen        
        history: false,
        focus: false,
        index: i,
        showAnimationDuration: 0,
        hideAnimationDuration: 0,
        bgOpacity: 0.7,
        shareButtons: [
            {id:'download', label:'Download image', url:'{{raw_image_url}}', download:true}
        ]
    };
    var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
    gallery.init();
});