jQuery(document).ready(function() {

    var scr_foot_tooltip_options = {
        placement: 'top',
        container: 'body'
    };
    $('.scr-foot-tooltip').tooltip(scr_foot_tooltip_options);

    var scr_navbar_tooltip_options = {
        placement: 'right',
        container: 'body',
        trigger: 'hover'
    };
    $('.scr-navbar-tooltip').tooltip(scr_navbar_tooltip_options);

    var scr_navbar_brand_tooltip_options = {
        placement: 'left',
        container: 'body'
    };
    $('.scr-navbar-brand-tooltip').tooltip(scr_navbar_brand_tooltip_options);

    $('.table-tooltip').tooltip({'placement': 'right'});
    $('.tooltipie').tooltip({'placement': 'right'});
    $('.toc-top').tooltip({'placement': 'left'});

    $('.navbar-tooltip').tooltip({
        placement: 'bottom',
        container: 'body'
    });

    $('.btn-tooltip').tooltip({
        placement: 'top',
        container: 'body',
        delay: 0
    });

    $('.btn-list-tooltip').tooltip({
        placement: 'right',
        container: 'body',
        delay: 0
    });

    $('.btn-list-left-tooltip').tooltip({
        placement: 'left',
        container: 'body',
        delay: 0
    });

});