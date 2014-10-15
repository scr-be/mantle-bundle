jQuery(document).ready(function() {

	$('.alert-close').bind('click', function() {
        $(this).parent().fadeOut(100);
    });

	function createAutoClosingAlert(selector, delay) {
	   var alert = $(selector).alert();
	   window.setTimeout(function() { alert.alert('close') }, delay);
	}

	createAutoClosingAlert(".alert", 20000);

});