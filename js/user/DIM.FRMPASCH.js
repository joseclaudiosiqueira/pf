$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

(function ($) {
    $('#user-password-new').complexify({}, function (valid, complexity) {
        var progressBar = $('#complexity-bar');
        progressBar.toggleClass('progress-bar-success', valid);
        progressBar.toggleClass('progress-bar-danger', !valid);
        progressBar.css({'width': complexity + '%'});
        $('#complexity').text(Math.round(complexity) + '%');
        passwordComplexity = Math.round(complexity);
    });
})(jQuery);

$('#user-password-repeat').on('keyup', function () {
    if ($(this).val() !== '') {
        if ($(this).val() === $('#user-password-new').val()) {
            $('#password-verify').html('<i class="fa fa-check"></i>');
            if (passwordComplexity > 34) {
                $('#btn-new-password').prop('disabled', false);
            }
        }
        else {
            $('#password-verify').html('<i class="fa fa-clock-o"></i>');
            $('#btn-new-password').prop('disabled', true);
        }
    }
});
$('#user-password-new').on('keyup', function () {
    if ($(this).val() !== '') {
        if ($(this).val() === $('#user-password-repeat').val()) {
            $('#password-verify').html('<i class="fa fa-check"></i>');
            if (passwordComplexity > 34) {
                $('#btn-new-password').prop('disabled', false);
            }
        }
        else {
            $('#password-verify').html('<i class="fa fa-clock-o"></i>');
            $('#btn-new-password').prop('disabled', true);
        }
    }
});

$('#form-password-change').on('submit', function () {
    $.post('/pf/DIM.Gateway.php', {
        'user-name': $('#user-name').val(),
        'user-password-old': $('#user-password-old').val(),
        'user-password-new': $('#user-password-new').val(),
        'user-password-repeat': $('#user-password-repeat').val(),
        'arq': 69, 'tch': 0, 'sub': 4, 'dlg': 1
    }, function (data) {
        if (data[0].id == 0) {
            swal({
                title: "Alerta",
                text: data[0].msg,
                type: "error",
                html: true,
                confirmButtonText: "Vou verificar, obrigado!"});
        }
        else {
            swal({
                title: "Informa&ccedil;&atilde;o",
                text: data[0].msg,
                type: "success",
                html: true,
                confirmButtonText: "Obrigado!"});
        }
    }, 'json');
    limpaCampos();
    return false;
});

function limpaCampos() {
    $('#user-name').val('');
    $('#user-password-old').val('');
    $('#user-password-new').val('');
    $('#user-password-repeat').val('');
    $('#btn-new-password').prop('disabled', true);
}

