$(document).ready(function() {
    if ($('#btn-group-content')) {
        $('#btn-group-content').hide();
        $('#btn-group-content').css('overflow', 'hidden');
        $('#btn-group-content').css('white-space', 'nowrap');
        $('#btn-group-content').css('text-wrap', 'none');
        $('#btn-group-toggle-close').hide();
        $('.btn-group-actions').css('opacity', 100);
        $('#btn-group-content').css('opacity', 0);
        $('#btn-group-toggle-open').click(function() {
            $('#btn-group-toggle-open').hide();
            $('#btn-group-toggle-close').show();
            $('#btn-group-content').animate({ height: 'show', 'opacity': 100 }, 150);
        });
        $('#btn-group-toggle-close').click(function() {
            $('#btn-group-toggle-close').hide();
            $('#btn-group-toggle-open').show();
            $('#btn-group-content').animate({ height: 'hide', 'opacity': 0 }, 150);
        });
    }
});