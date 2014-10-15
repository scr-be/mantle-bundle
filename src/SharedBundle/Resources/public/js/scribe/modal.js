/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @param el Element|string
 */
function registerNonAjaxModalDeleteTrigger(el) {

    $(el).click(function(e) {

        // stop event propagation
        e.preventDefault();

        // pass element data attributes to modal and show modal
        $('#modal-confirm-delete').data($(this).data()).modal('show');
    });

}

/**
 * @param el Element|string
 */
function registerAjaxModalDeleteTrigger(el) {

    jQuery(el).each(function(i, el) {

        el = jQuery(el);

        if (el.hasClass('ajax-bound')) {
            return true;
        }
        else {
            el.addClass('ajax-bound');
        }

        el.click(function(e) {

            // stop event propagation
            e.preventDefault();

            // pass element data attributes to modal and show modal
            $('#modal-confirm-ajax-delete').data($(this).data()).modal('show');

        });

    });

}

// once the document is read...go!
jQuery(document).ready(function() {

    /**
     *
     * @block: handle modal delete confirmation (non-ajax version)
     *
     */
    $(function () {

        $('#modal-confirm-delete').on('show.bs.modal', function () {

            // get our data variables and relevant elements ready
            var id             = $(this).data('id');
            var toDeleteWhat   = $(this).data("what");
            var toDeleteHref   = $(this).data("href");
            var spanWhat       = $(this).find('.modal-what');
            var removeBtn      = $(this).find('.btn-danger');
            var removeBtnInner = $(this).find('.modal-text');

            // set our delete link href and text, change modal header too
            removeBtn.attr('href', toDeleteHref);
            removeBtnInner.text('Delete "' + toDeleteWhat + '"');
            spanWhat.text(toDeleteWhat);
        });

        // register any elements matching selector as triggers for deletion modal
        registerNonAjaxModalDeleteTrigger('.confirm-delete');

    });

    /**
     *
     * @block: handle modal delete confirmation (ajax version)
     *
     */
    $(function () {

        $('#modal-confirm-ajax-delete').on('show.bs.modal', function (e) {

            // get out data variables and relevant element ready
            var id               = $(this).data('id');
            var toDeleteWhat     = $(this).data("what");
            var toDeleteHref     = $(this).data("href");
            var toDeleteSelector = $(this).data("selector");
            var spanWhat         = $(this).find('.modal-what');
            var originalDelBtn   = $(this).find('.btn-delete');
            var cancelBtn        = $(this).find('.btn-cancel');

            // make sure our cancel button is shown and change modal header
            cancelBtn.show();
            spanWhat.text(toDeleteWhat);

            // create new delete link
            var deleteLink       = $(
                '<a href="' + toDeleteHref + '" class="btn btn-danger btn-delete ajax modal-delete-link" data-remove="' +
                toDeleteSelector + '"><i class="fa fa-minus-circle"></i> <span class="modal-text">Delete "' +
                toDeleteWhat + '"</span></a>'
            );

            // replace deletion button with newly generated one
            originalDelBtn.replaceWith(deleteLink);

        });

        registerAjaxModalDeleteTrigger('.confirm-ajax-delete');

    });

});