jQuery(document).ready(function() {

    function setTabFocus() {
        $('.tabs-affix-js a').each(function(i, item) {
            var content_id = $(item).attr('href');
            var content_el = $(content_id);
            var content_top = content_el.offset().top;
            var docview_top = $(window).scrollTop();
            if(content_top <= docview_top+100) {
                $('.tabs-affix a').each(function(i, item) {
                    $(item).parent().removeClass('active');
                });
                $(item).parent().addClass('active');
            }
        });
    };

    setTabFocus();

    $(window).scroll(function() {
        setTabFocus();
    });

});