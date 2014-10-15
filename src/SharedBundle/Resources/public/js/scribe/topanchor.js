jQuery(document).ready(function() {

    if($(window).scrollTop() < 70) {
        $('#to-top').hide();
    }

    $(window).on('scroll', function(e) {
        if($(window).scrollTop() > 70) {
            $('#to-top').fadeIn();
        } else {
            $('#to-top').fadeOut();
        }
    });

});