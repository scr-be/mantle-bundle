jQuery(document).ready(function() {

    $('body').bind('keyup', '/', function(){
        $('#form-search-input').focus();
    });

    $(function() {
        $( ".scr-navbar-search .tt-query" ).focus(function() {
            var scr_navbar_search_width_expand = ($('.container').innerWidth() / 2) - 35 - $( "#form-search-input" ).outerWidth();
            var scr_navbar_search_input_start  = 240;
            var scr_navbar_search_input_end    = scr_navbar_search_input_start + scr_navbar_search_width_expand;
            $('.scr-navbar-search').animate({ 'margin-right': ($('.container').innerWidth() / 4)}, 300);
            $(this).animate({ width: scr_navbar_search_input_end, opacity: 1 }, 300);
            $('.scr-navbar-search .tt-hint').animate({ width: scr_navbar_search_input_end, opacity: 1 }, 300);
            $('.scr-navbar-search .tt-dropdown-menu').animate({ width: scr_navbar_search_input_end, opacity: 1 }, 300);
            $('.scr-navbar-main').hide( 300 );
        });
        $( ".scr-navbar-search .tt-query" ).blur(function() {
            var scr_navbar_search_width_expand = ($('.container').innerWidth() / 2) - 35 - $( "#form-search-input" ).outerWidth();
            var scr_navbar_search_input_start  = 240;
            var scr_navbar_search_input_end    = scr_navbar_search_input_start + scr_navbar_search_width_expand;
            $('.scr-navbar-search').animate({ 'margin-right': 0}, 600);
            $(this).animate({ width: scr_navbar_search_input_start, opacity: 0.75 }, 600);
            $('.scr-navbar-search .tt-hint').animate({ width: scr_navbar_search_input_start, opacity: 0.75 }, 600);
            $('.scr-navbar-search .tt-dropdown-menu').animate({ opacity: 0 }, 600);
            $('.scr-navbar-main').show( 300 );
        });
    });
});