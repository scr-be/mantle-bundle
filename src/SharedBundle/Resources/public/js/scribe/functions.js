/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * capitalization prototype
 *
 * @param type string
 * @returns string
 */
String.prototype.capitalize = function(type) {

    // nothing is capitalized to begin with
    var capitalized = '';

    // split string on spaces
    var array = this.split(' ');

    // list of items not to capitalize for title case
    var doNotCapitalize = ["a", "an", "and", "as", "at", "but", "by", "etc", "for", "in", "into", "is", "nor", "of", "off", "on", "onto", "or", "so", "the", "to", "unto", "via"];

    // if type = all, capitalize first letter of each word
    if (type === 'all') {

        $.each(array, function(index, value) {

            capitalized += value.charAt(0).toUpperCase() + value.slice(1);

            if (array.length != (index+1)) {
                capitalized += ' '; // add a space if not end of array
            }
        });

        return capitalized;
    }
    // if type = title, capitalize first letter of each word so long as it is not
    // an article, coordinate conjunction, preposition (etc) unless it is the first word
    // -> traditionally left uppercase if over 4 or 5 letters
    // -> I'm only doing the common ones, add more in the doNotCapitalize array
    else if (type === 'title') {

        $.each(array, function(index, value) {

            // only capitalize if first word or not in doNotCapitalize array
            if (index === 0 || $.inArray(value, doNotCapitalize) === -1) {
                capitalized += value.charAt(0).toUpperCase() + value.slice(1);
            }
            else {
                capitalized += value;
            }

            if (array.length != (index+1)) {
                capitalized += ' '; // add a space if not end of array
            }
        });

        return capitalized;
    }
    // else just capitalize first letter of first word
    else {

        return this.charAt(0).toUpperCase() + this.slice(1);
    }
};

/**
 * display a message to the user
 *
 * @param message string
 * @param type    string
 */
function showUserMessage(message, type) {

    // call messenger plugin to display message
    Messenger().post({
        'type'   : type,
        'message': message
    });

}

/**
 * display a success message to the user
 *
 * @param message String
 */
function showUserSuccessMessage(message) {

    // call helper method to display message
    showUserMessage(message, 'success');

}

/**
 * display an info message to the user
 *
 * @param message String
 */
function showUserInfoMessage(message) {

    // call helper method to display message
    showUserMessage(message, 'info');

}

/**
 * display an error message to the user
 *
 * @param message String
 */
function showUserErrorMessage(message) {

    // call helper method to display message
    showUserMessage(message, 'error');

}

/**
 * checks that the passed object has the passed property defined and not null
 *
 * @param object   Object
 * @param property String
 * @returns bool
 */
function objectPropertyIsDefinedAndNotNull(object, property) {

    // passed object argument must be an object
    if (typeof object !== 'object') {
        return false;
    }

    // passed property must be a string
    if (typeof property !== 'string') {
        return false;
    }

    // if passed object doesnt have prop, or prop is undefined, or prop is null, return false
    if (!property in object || typeof object[property] === 'undefined' || object[property] === null) {
        return false;
    }

    // the passed object/property meets requirements
    return true;
}

/**
 * simple wrapper for "http redirect"-like behaviour
 *
 * @param url String
 */
function doUrlRedirectHTTP(url) {

    // otherwise, perform the http redirect
    window.location.replace(url);

}

/**
 * simple wrapper for "link-click"-like behaviour
 *
 * @param url String
 */
function doUrlRedirectClick(url) {

    // otherwise, perform the http redirect
    window.location.href = url;

}

/**
 * simple wrapper for url redirect behaviour
 *
 * @param url String
 */
function doRedirect(url) {

    // prefer http-like redirect over link-click-like behaviour
    doUrlRedirectHTTP(url);

}

/**
 * round number to specified precision
 *
 * @param number    Number
 * @param precision Number
 *
 * @returns Number
 */
function roundNumber(number, precision) {

    // otherwise, perform calculation
    return +(Math.round(number + "e+" + precision) + "e-" + precision);

}

/**
 * convert bytes to size object
 *
 * @param   bytes
 *
 * @returns Object
 */
function convertBytesToHuman(bytes) {

    // create new object to store size information
    var size = new Object();
    size.bytes = bytes;

    // if bytes is less than a kb...
    if (bytes < 1024) {
        size.size = bytes;
        size.type = 'B';
    }
    // if bytes is less than a mb...
    else if ((bytes/1024) < 1024) {
        size.size = bytes/1024;
        size.type = 'KB';
    }
    // if bytes is less than a gb...
    else if ((bytes/1024/1024) < 1024) {
        size.size = bytes/1024/1024;
        size.type = 'MB';
    }
    // if bytes is less than a tb...
    else if ((bytes/1024/1024/1024) < 1024) {
        size.size = bytes/1024/1024/1024;
        size.type = 'GB';
    }
    // otherwise display as tb...
    else {
        size.size = bytes/1024/1024/1024/1024;
        size.type = 'TB';
    }

    // create routed version of size, precision of 2 decimals
    size.rounded = roundNumber(size.size, 2);

    // return size object
    return size;

}

/**
 * change element content to "please wait" spinner and save original html
 *
 * @param el String|Element
 */
function btnTransformToSpinner(el) {

    $(el).attr('data-spinner-original-html', $(el).html());
    $(el).html('Please wait <i class="fa fa-circle-o-notch fa-spin"></i>');

}

/**
 * change element html back to original
 *
 * @param el String|Element
 */
function btnTransformFromSpinner(el) {

    $(el).html($(el).attr('data-spinner-original-html'));

}