jQuery(document).ready(function() {

    handleFooter();
    setTimeout(handleFooter, 200);
    $(window).resize(handleFooter);
    
    $('body').bind('shown.bs.tab', function(){
        handleFooter();
    });

    $('body').bind('scribe.footer.handle', function(){
        handleFooter();
    });

    $('.wizard').bind('fuelux:changed', function(){
        handleFooter();
    });

    $(document).bind('scribe.footer.handle', function(){
        handleFooter();
    });

    function handleFooter() {
        if ($('#scr-footer').outerHeight() < $(window).height()) {
            $('#scr-wrapper').css({
                'margin-bottom': $('#scr-footer').outerHeight(),
                'position': 'relative',
                'background-color': '#fff',
                'z-index': 10,
                'overflow': 'hidden'
            });

            if ($('#scr-wrapper').height() < $(window).height()) {
                $('#scr-wrapper').css({
                    'padding-bottom': $(window).height() - $('#scr-wrapper').height() - 50
                });
            } else {
                $('#scr-wrapper').css({
                    'padding-bottom': '40px'
                });
            }

            $('#scr-footer').css({
                'position': 'fixed',
                'left': 0,
                'right': 0,
                'bottom': 0,
                'z-index': 1
            });
        } else {
            $('#scr-wrapper').css({
                'margin-bottom': '0px',
                'padding-bottom': '40px',
                'position': 'relative',
                'background-color': '#fff',
                'z-index': 10
            });

            $('#scr-footer').css({
                'position': 'relative',
                'left': null,
                'right': null,
                'bottom': null,
                'z-index': 1
            });
        }
    };

});