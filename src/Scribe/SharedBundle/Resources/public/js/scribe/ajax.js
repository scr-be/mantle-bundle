/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @block: handle displaying a please wait
 *
 */
$(function () {

    /**
     * called when eldarion ajax request begins
     */
    $(document).on("eldarion-ajax:begin", function(e, el) {

        var target = $(el);

        // if ajax request is on a modal
        if (target.hasClass('modal-delete-link')) {

            // hide cancel button for ajax modal delete
            $('#modal-confirm-ajax-delete')
                .find('button.btn-cancel')
                .hide();

            // show spinner on deletion button
            btnTransformToSpinner(el);

        }
        // if ajax request is on a form
        else if (target.is('form')) {

            // change submit button to spinner
            btnTransformToSpinner(
                target.find('button.btn-ajax-update')
            );

        }

    });

    /**
     * called when an eldarion ajax request completes (both success and failure)
     */
    $(document).on("eldarion-ajax:complete", function (e, el) {

        var target = $(el);

        // if ajax request is on a modal
        if (target.hasClass('modal-delete-link')) {

            var modalAjax    = $('#modal-confirm-ajax-delete');

            // hide the modal
            modalAjax.modal('hide');

            // show cancel button for ajax modal delete
            modalAjax
                .find('button.btn-cancel')
                .show();

        }
        // if ajax request is on a form
        else if (target.is('form')) {

            // change button back from spinner
            btnTransformFromSpinner(
                target.find('button.btn-ajax-update')
            );

        }

    });

});