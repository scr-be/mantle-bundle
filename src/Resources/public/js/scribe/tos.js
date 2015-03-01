/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// once the document is read...go!
jQuery(document).ready(function() {

    $('#scribe-tos-modal').modal({
        backdrop: 'static',
        keyboard: false
    })

    $('#scribe-tos-modal').modal('show');

    $('#scribe-tos-modal-decline').click(function (e) {
        $(this).html('Please wait <i class="fa fa-fw fa-spin fa-circle-o-notch"></i>');
        $.ajax({
            url: $(this).data('href')
        })
        .done(function (data) {
            window.location.href = '/';
        });
    });

    $('#scribe-tos-modal-accept').click(function (e) {
        $(this).html('Please wait <i class="fa fa-fw fa-spin fa-circle-o-notch"></i>');
        $.ajax({
            url: $(this).data('href')
        })
        .done(function (data) {
            $('#scribe-tos-modal').modal('hide');
        });
    });

});