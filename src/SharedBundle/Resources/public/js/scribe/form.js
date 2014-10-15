jQuery(document).ready(function() {

    $(':checkbox').each(function(){
        var self = $(this),
            label = self.prev(),
            label_text = label.text();
        self.iCheck({
            checkboxClass: 'icheckbox_line-blue',
            radioClass: 'iradio_line-blue',
            insert: '<div class="icheck_line-icon"></div> <span class="icheck_label">'+label_text+"</span>"
        });
    });

    $('.iCheck-helper').each(function(i, e) {
        handle_checkbox_click(e);
        $(e).click(function(e){
            handle_checkbox_click(e.target);
        });
    });

    function handle_checkbox_click(t) {
        var label           = $(t).parent().find('.icheck_label');
        var outer           = $(t).parent();
        var p               = $(t).parent().parent().parent();
        var label_checked   = p.find('.icheck_label_option_checked');
        var label_unchecked = p.find('.icheck_label_option_unchecked');
        
        label_checked.css('display', 'none');
        label_unchecked.css('display', 'none');
        
        var label_checked_text = 'Enabled';
        var label_unchecked_text = 'Disabled';
        
        if (label_checked.length) {
            label_checked_text = label_checked.text();
        }
        if (label_unchecked.length) {
            label_unchecked_text = label_unchecked.text();
        }
        if (outer.hasClass('checked')) {
            label.text(label_checked_text);
        } else {
            label.text(label_unchecked_text);
        }
    }

});