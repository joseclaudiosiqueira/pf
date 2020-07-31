$(document).ready(function () {
    $(function () {
        $('[data-toggle="popover"]').popover({html: true});//, container: 'body'
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip({html: true});
    });

    //atualizacao central dos valores de mensalidade e valor contagem
    $('#valor-contagem-form-login-1').html('R$ 79<sup>,90</sup>');
    $('#valor-plano-flexivel').html('R$ 299<sup>,90</sup>');
    $('#valor-mensalidade-1').html('R$ 299<sup>,90</sup>');
    $('#valor-plano-empresarial').html('<h1 style="display:inline;">Consulte-nos</h1>');
    //R$ 79</h1>,90 (por contagem)
});

function verifica_usuario(v){
    if (v !== '') {
        var sel = $("#id_empresa");
        sel.empty();
        $.post('/pf/DIM.Gateway.php', {
            'user_name': v, 
            'arq': 21, 
            'tch': 1, 
            'sub': -1, 
            'dlg': 0}, function (data) {
            if (data.length >= 1) {
                if (data[0].existe) {
                    if (data.length > 1) {
                        sel.append('<option value="0">Selecione uma empresa</option>');
                        for (var i = 0; i < data.length; i++) {
                            sel.append('<option value="' + data[i].id + '">' + data[i].sigla + '</option>');
                        }
                        $('#login').prop('disabled', true);
                    }
                    else {
                        for (var i = 0; i < data.length; i++) {
                            sel.append('<option value="' + data[i].id + '">' + data[i].sigla + '</option>');
                        }
                        $('#login').prop('disabled', false);
                    }
                }
                else {
                    sel.append('<option value="0">Usu&aacute;rio n&atilde;o encontrado/inativo</option>');
                    $('#login').prop('disabled', true);
                    $('#user_password').val('');
                    $('#user_name').val('');
                    $('#user_name').get(0).focus();
                    consultaGravatar(v, $('#gravatar'));                    
                }
            }
        }, 'json');
        /**
         * Param1 - email ou user_name
         * Param2 - imagem que recebera o avatar
         */
        consultaGravatar(v, $('#gravatar'));
        $('#user_password').get(0).focus();
        return true;
    }
    else {
        $('#id_empresa').empty().append($('<option>', {value: 0, text: 'Digite um login válido...'}));
        $('#user_password').val('');
        $('#user_name').get(0).focus();
        $('#login').prop('disabled', true);
        consultaGravatar(v, $('#gravatar'));
    }    
}

$('#user_name').on('change', function () {
    verifica_usuario($(this).val());
});

$('#user_name').on('keyup', function () {
    var tam = $(this).val();
    if (tam.length < 8) {
        $('#login').prop('disabled', true);
    }
});

$('#id_empresa').on('change', function () {
    if ($(this).val() === '0') {
        $('#login').prop('disabled', true);
    }
    else {
        $('#login').prop('disabled', false);
    }
});

$('#form-login').on('submit', function () {
    if ($('#id_empresa').val() == 0) {
        swal({
            title: "Alerta",
            text: "Algumas informa&ccedil;&otilde;es necess&aacute;rias para o login n&atilde;o foram fornecidas est&atilde;o incorretas. Por favor verifique: Login (usu&aacute;rio), Senha e/ou Empresa na qual voc&ecirc; quer logar.",
            type: "error",
            html: true,
            confirmButtonText: "Obrigado, vou verificar!"});
        return false;
    }
    else {
        $.post('/pf/index.php', {
            'user_name': $('#user_name').val(),
            'user_password': $('#user_password').val(),
            'id_empresa': $('#id_empresa').val(),
            'url': $('#url').val()}, function (data) {
            if (data.p !== '') {
                self.location.href = data.p;
            }
            else if (data.e === 'e') {
                swal({
                    title: "Alerta",
                    text: "N&atilde;o foi poss&iacute;vel logar. Verifique as informa&ccedil;&otilde;es",
                    type: "error",
                    html: true,
                    confirmButtonText: "Obrigado, vou verificar!"});
            }
        }, 'json');
        return false;
    }
    /*self.location.href = 'index.php';
     <?php
     //necessario pois retorna a mensagem de falha de login
     $var = isset($login->errors[0]) ? $login->errors[0] : 0;
     if ($var) {
     ?>
     swal({
     title: "Alerta",
     text: "<?= $var; ?>",
     type: "error",
     html: true,
     confirmButtonText: "Obrigado, vou corrigir!"});
     <?php
     $var = 0;
     $login->errors[0] = '';
     }
     ?>    */
});

$('.button-contato').on('click', function () {
    $('#contato-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
});

$('.button-refresh-login').on('click', function () {
    verifica_usuario($('#user_name').val());
});


