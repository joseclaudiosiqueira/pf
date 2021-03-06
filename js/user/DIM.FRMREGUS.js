$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    /*
     * para todos dos forms a leitura da imagem do captcha eh feita no click para evitar desatualizacoes
     */
    $('#fmiausu-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
});

$('#fmiausu-txt-captcha').on('keyup', function () {
    verificaCaptcha($(this), $('#fmiausu-i-captcha'), false);
});

$('#user-name').on('change', function () {
    if ($(this).val() !== '') {
        iWait('w-user-name', true);
        $.post('/pf/DIM.Gateway.php', {
            'tipo': 'name', 'info': $('#user-name').val(), 'hash': getVar('i'), 'arq': 80, 'tch': 1, 'sub': 4, 'dlg': 1
        }, function (data) {
            if (data[0].success) {
                $('#user-name').prop('readonly', true);
                $('#user-email').prop('disabled', false).get(0).focus();
            }
            else {
                swal({
                    title: "Alerta",
                    text: data[0].msg,
                    type: "error",
                    html: true,
                    confirmButtonText: "Vou verificar, obrigado!"},
                function () {
                    $('#user-name').val('').get(0).focus();
                });
            }
            iWait('w-user-name', false);
        }, 'json');
    }
});

$('#user-email').on('change', function () {
    if ($(this).val() !== '') {
        iWait('w-user-email', true);
        $.post('/pf/DIM.Gateway.php', {
            'tipo': 'email', 'info': $('#user-email').val(), 'hash': getVar('i'), 'arq': 80, 'tch': 1, 'sub': 4, 'dlg': 1
        }, function (data) {
            if (data[0].success) {
                $('#user-email').prop('readonly', true);
                $('#user-password-new').prop('disabled', false).get(0).focus();
                $('#user-password-repeat').prop('disabled', false);
            }
            else {
                swal({
                    title: "Alerta",
                    text: data[0].msg,
                    type: "error",
                    html: true,
                    confirmButtonText: "Vou verificar, obrigado!"});
            }
            iWait('w-user-email', false);
        }, 'json');
    }
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
                $('#fmiausu-txt-captcha').prop('disabled', false).get(0).focus();
                $('#btn-new-password').prop('disabled', false);
            }
        }
        else {
            $('#password-verify').html('<i class="fa fa-clock-o"></i>');
            $('#btn-new-password').prop('disabled', true);
            $('#fmiausu-txt-captcha').prop('disabled', true).val('');
            $('#btn-new-password').prop('disabled', true);
        }
    }
});

$('#user-password-new').on('keyup', function () {
    if ($(this).val() !== '') {
        if ($(this).val() === $('#user-password-repeat').val()) {
            $('#password-verify').html('<i class="fa fa-check"></i>');
            if (passwordComplexity > 34) {
                $('#fmiausu-txt-captcha').prop('disabled', false);
                $('#btn-new-password').prop('disabled', false);
            }
        }
        else {
            $('#password-verify').html('<i class="fa fa-clock-o"></i>');
            $('#btn-new-password').prop('disabled', true);
            $('#fmiausu-txt-captcha').prop('disabled', true).val('');
            $('#btn-new-password').prop('disabled', true);
        }
    }
});

$('#form-register-user').on('submit', function () {
    var id = $('#user_id').val();
    var pw = $('#user-password-new').val();
    var ac = $('#activation_hash').val();
    /*
     * confere o captcha
     */
    if ($('#fmiausu-txt-captcha').val().length < 4) {
        swal({
            title: "Alerta",
            text: "As letras da imagem est&atilde;o diferentres do que foi digitado.",
            type: "error",
            html: true,
            confirmButtonText: "Vou corrigir, obrigado!"});
        return false;
    }
    $.post('/pf/DIM.Gateway.php', {
        'user_id': id,
        'user_password': pw,
        'user_activation_hash': ac,
        'arq': 72, 'tch': 0, 'sub': 4, 'dlg': 1
    }, function (data) {
        if (data[0].success) {
            swal({
                title: "Informa&ccedil;&atilde;o",
                text: data[0].msg,
                type: "success",
                html: true,
                confirmButtonText: "Obrigado!"});
        }
        else {
            swal({
                title: "Alerta",
                text: data[0].msg,
                type: "error",
                html: true,
                confirmButtonText: "Vou verificar, obrigado!"});
        }
    }, 'json');
    limpaCampos();
    return false;
});

function limpaCampos() {
    $('#user-name').val('').prop('disabled', false).prop('readonly', false).get(0).focus();
    $('#user-email').val('').prop('readonly', false).prop('disabled', true);
    $('#user-password-new').val('').prop('disabled', true);
    $('#user-password-repeat').val('').prop('disabled', true);
    $('#btn-new-password').prop('disabled', true);
    $('#password-verify').html('<i class="fa fa-clock-o"></i>');
    $('#fmiausu-txt-captcha').prop('disabled', true).val('');
    /*
     * zera o progress bar e o password complexity
     */
    var progressBar = $('#complexity-bar');
    complexity = 0;
    progressBar.css({'width': complexity + '%'});
    $('#complexity').text(Math.round(complexity) + '%');
    passwordComplexity = Math.round(complexity);
}

