jQuery(document).ready(function() {

    $(function () {
        $('.scr-datetimepicker').datetimepicker();
    });

    $(function() {
        $("span[data-popup] a").on('click', function(e) {
            window.open($(this)[0].href);
            // Prevent the link from actually being followed
            e.preventDefault();
        });
    });

    $('a[href]').smoothScroll({offset: -95});

    $('.btn-pleasewait').click(function(e){
        $(this).html('Please wait <i class="fa fa-fw fa-spin fa-circle-o-notch"></i>');
    });

});