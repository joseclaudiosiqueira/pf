//modal das configuracoes do sistema
$('#ldap-txt-captcha').on('keyup', function () {
    verificaCaptcha($(this), $('#ldap-i-captcha'), false);
});

$('ldaptipo').on('change', function () {
    if ($(this).val() == 1) {
        $('#username').prop('disabled', false);
        $('#password').prop('disabled', false);
        $('#ldapserver').prop('disabled', false);
        $('#ldapport').prop('disabled', false);
        $('#ldapdomain').prop('disabled', false);
    }
    else {
        $('#username').prop('disabled', true).val('');
        $('#password').prop('disabled', true).val('');
        $('#ldapserver').prop('disabled', true).val('');
        $('#ldapport').prop('disabled', true).val('389');
        $('#ldapdomain').prop('disabled', true).val('');
    }
});

$('#ldap-link').on('click', function () {
    $.post('/pf/DIM.Gateway.php', {'i': idEmpresa, 
        'arq': 65, 'tch': 1, 'sub': 0, 'dlg': 1}, function (data) {
        if (data.tipo_instalacao == 1) {
            $('#ldapserver').val(data.ldapserver);
            $('#ldapport').val(data.ldapport);
            $('#ldapdomain').val(data.domain);
            $('#ldaptipo').val(data.tipo_autenticacao);
        }
        else {
            $('#ldaptipo').prop('disabled', true);
            $('#ldap_btn_al').prop('disabled', true);
            $('#ldap_btn_ts').prop('disabled', true);
        }
    }, 'json');
    /*
     * le o captcha somente no clique do formulario
     */
    $('#ldap-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
});

$('#ldap_btn_ts').on('click', function () {
    /*
     * confere o captcha
     */
    if ($('#ldap-txt-captcha').val().length < 4) {
        swal({
            title: "Alerta",
            text: "As letras da imagem est&atilde;o diferentres do que foi digitado.",
            type: "error",
            html: true,
            confirmButtonText: "Vou corrigir, obrigado!"});
    }
    else {
        $.post('/pf/DIM.Gateway.php', {
            'username': $('#username').val(),
            'password': $('#password').val(),
            'ldapserver': $('#ldapserver').val(),
            'ldapport': $('#ldapport').val(),
            'domain': $('#ldapdomain').val(),
            'j': 'json.verificaldap',
            'su': 'admin'
        }, function (data) {
            $('#span-retorno-ldap').html('<pre><code>' + dump(data) + '</code></pre>');
        }, 'json');
    }
});
