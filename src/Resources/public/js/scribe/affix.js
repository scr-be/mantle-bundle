jQuery(document).ready(function() {

    handleAffix = function() {
        topOffset = 0;
        if ($('.scr-page-header').length > 0) {
            topOffset = $('.scr-page-header').outerHeight();
        } else if ($('.jumbotron').length > 0) {
            topOffset = $('.jumbotron').outerHeight();
        } else if ($('.scr-header-affix-handler').length > 0) {
            topOffset = $('.scr-header-affix-handler').outerHeight();
        }
        $('.sidebar-affix').affix({
            offset: {
                top: topOffset,
                bottom: function () {
                    return this.bottom = parseInt($('#scr-wrapper').css('margin-bottom')) + 40
                }
            }
        })
    }

    handleAffixTabs = function() {
        $('.tabs-affix').affix({
            offset: {
                top: topOffset,
                bottom: function () {
                    return (this.bottom = parseInt($('#scr-wrapper').css('margin-bottom')) + 40)
                }
            }
        })
    }

    setTimeout(handleAffix, 20);
    setTimeout(handleAffixTabs, 20);

    $(window).resize(handleAffix);
    $(window).resize(handleAffixTabs);

});