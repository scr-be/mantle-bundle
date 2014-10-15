jQuery(document).ready(function() {

    handleNavbarOverflow();
    $(window).resize(handleNavbarOverflow);

    function handleNavbarOverflow() {
        var search_width = $( "#form-search-input" ).outerWidth();
        var navbar_width = $( ".scr-navbar-main" ).outerWidth();
        var brand_width  = parseInt($( ".scr-navbar-main" ).css('left'));
        var navbox_width = $( "#scr-navbar .container" ).innerWidth();

        var navbar_items = $( ".scr-navbar-main li" );

        if (navbar_width + search_width + brand_width > navbox_width) {

            $('.navbar-overflow').css({'display': 'block'});

            for (var i = navbar_items.length; i >= 0; i--) {

                if (!$(navbar_items[i]).hasClass('navbar-overflow')) {
                    $(navbar_items[i]).css({'display': 'none'});
                    $('.navbar-overflow ul').prepend($(navbar_items[i]).clone().css({'display': 'block'}));
                }

                var navbar_width = $( ".scr-navbar-main" ).outerWidth();

                if (navbar_width + search_width + brand_width + 40 <= navbox_width) {
                    break;
                }
            }

        } else {

            for (var i = 0; i <= navbar_items.length; i++) {

                $(navbar_items[i]).css({'display': 'block'});

            }

            $('.navbar-overflow ul li').remove();
            $('.navbar-overflow').css({'display': 'none'});

            var navbar_width = $( ".scr-navbar-main" ).outerWidth();
            if (navbar_width + search_width + brand_width > navbox_width) {
                handleNavbarOverflow();
            }

        }
    }

});