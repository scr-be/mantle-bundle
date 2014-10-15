!function ($) {

    $(function () {

        var $window = $(window)
        var $body   = $(document.body)

        $('.src-toc > ul > li:first').addClass('active');

        $body.scrollspy({
          target: '.src-toc',
          offset: 100
        })

        $window.on('load', function () {
          $body.scrollspy('refresh')
        })

        $('.src-toc [href=#]').click(function (e) {
          e.preventDefault()
        })

    });

}(jQuery)