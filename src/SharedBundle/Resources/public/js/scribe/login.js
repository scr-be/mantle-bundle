jQuery(document).ready(function() {
    $('#scr-login-overlay').click(function(e){
        e.preventDefault();
        $('#modal-login').modal('show');
    });
    $('#form-signin-cancel').click(function(e){
        e.preventDefault();
        $('#modal-login').modal('hide');
    });
    $('#form-signin-go').click(function(e){
        $('#form-signin-go').html('Please wait <span class="fa fa-circle-o-notch fa-spin">');
    });
    $('#modal-login').on('shown.bs.modal', function (e) {
        if ($('#form-signin-username').val().length > 0) {
            $('#form-signin-password').focus();
        } else {
            $('#form-signin-username').focus();
        }
    })
});