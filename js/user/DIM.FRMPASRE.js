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
        'user-password-reset-hash': $('#user-password-reset-hash').val(),
        'user-password-new': $('#user-password-new').val(),
        'user-password-repeat': $('#user-password-repeat').val(),
        'arq': 71, 'tch': 0, 'sub': 4, 'dlg': 1
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
    return false;
});

$('#form-password-request').on('submit', function () {
    if ($('#user-email').val() == 0) {
        swal({
            title: "Alerta",
            text: 'Verifique as informa&ccedil;&otilde;es, detectamos que o email n&atilde;o est&aacute; selecionado e/ou n&atilde;o &eacute; v&aacute;lido.',
            type: "error",
            html: true,
            confirmButtonText: "Vou verificar, obrigado!"});
    }
    else {
        $.post('/pf/DIM.Gateway.php', {
            'user-name': $('#user-name').val(),
            'user-email': $('#user-email').val(),
            'arq': 70, 'tch': 0, 'sub': 4, 'dlg': 1
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
                    confirmButtonText: "Obrigado!"}, function () {
                    $('#user-email').empty().append($('<option>', {value: 0, text: 'Aguardando...'})).prop('disabled', true);
                    $('#user-name').val('').get(0).focus();
                });
            }
        }, 'json');
    }
    return false;
});

$('#user-name').on('change', function () {
    if ($(this).val().length < 2 && $(this).val() != '') {
        swal({
            title: "Alerta",
            text: "ID &Uacute;nico de usu&aacute;rio e/ou CPF inv&aacute;lidos.",
            type: "error",
            html: true,
            confirmButtonText: "Vou verificar, obrigado!"},
        function () {
            $('#user-name').val('').get(0).focus();
        });
    }
    else {
        $.post('/pf/DIM.Gateway.php', {'u': $('#user-name').val(), 'arq': 78, 'tch': 1, 'sub': 4, 'dlg': 1}, function (data) {
            if (data.length > 0) {
                $('#user-email').empty();
                for (x = 0; x < data.length; x++) {
                    $('#user-email').append($('<option>', {value: data[x].user_email, text: data[x].user_email}));
                }
                $('#user-email').prop('disabled', false);
            }
            else {
                swal({
                    title: "Alerta",
                    text: "ID &Uacute;nico de usu&aacute;rio e/ou CPF inv&aacute;lidos.",
                    type: "error",
                    html: true,
                    confirmButtonText: "Vou verificar, obrigado!"},
                function () {
                    $('#user-email').empty().append($('<option>', {value: 0, text: 'Aguardando...'})).prop('disabled', true);
                    $('#user-name').val('').get(0).focus();
                });
            }
        }, 'json');
    }
});