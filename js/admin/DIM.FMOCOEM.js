//modal das configuracoes do sistema
$('.money').mask("###0.00", {reverse: true});

if (empresaConfigPlano.id < 3) {
    $('#ldap-link').css({'text-decoration': 'line-through'});
}
//configuracoes de uma empresa
$('#fmcemp-txt-captcha').on('keyup', function () {
    verificaCaptcha($(this), $('#fmcemp-i-captcha'), false);
});

//insercao de uma nova empresa
$('#fmcempinc-txt-captcha').on('keyup', function () {
    verificaCaptcha($(this), $('#fmcempinc-i-captcha'), false);
});

//clique no link
$('#fmcemp-link').on('click', function () {
    $.post('/pf/DIM.Gateway.php', {
        'i': idEmpresa,
        'arq': 60, 
        'tch': 1, 
        'sub': 0, 
        'dlg': 1}, function (data) {
        $('#email_administrador_1').val(data.email_administrador_1);
        $('#email_administrador_2').val(data.email_administrador_2);
        $('#telefone_administrador_1').val(data.telefone_administrador_1);
        $('#telefone_administrador_2').val(data.telefone_administrador_2);
        $('#avatar-frame-emp').contents().find('#avatar_id').val(data.id_empresa);
        if (data.logomarca !== null)
            $('#avatar-frame-emp').contents().find('#avatar_img').attr('src', '/pf/vendor/cropper/producao/crop/img/img-emp/' + data.logomarca + '.png?' + new Date().getTime());
        else
            $('#avatar-frame-emp').contents().find('#avatar_img').attr('src', '/pf/img/blank_logo.pt_BR.jpg');
    }, 'json');
    /*
     * le o captcha somente no clique do formulario
     */
    $('#fmcemp-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
});

$('#fmcempinc-link').on('click', function () {
    $('#fmcempinc-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
});

$('#form_configuracoes').on('submit', function () {
    /*
     * confere o captcha
     */
    if ($('#fmcemp-txt-captcha').val().length < 4) {
        swal({
            title: "Alerta",
            text: "As letras da imagem est&atilde;o diferentres do que foi digitado.",
            type: "error",
            html: true,
            confirmButtonText: "Vou corrigir, obrigado!"});
    }
    else {
        $.post('/pf/DIM.Gateway.php', {
            'email_administrador_1': $('#email_administrador_1').val(),
            'email_administrador_2': $('#email_administrador_2').val(),
            'telefone_administrador_1': $('#telefone_administrador_1').val(),
            'telefone_administrador_2': $('#telefone_administrador_2').val(),
            'arq': 40, 'tch': 0, 'sub': 0, 'dlg': 1
        }, function (data) {
            swal({
                title: "Informa&ccedil;&atilde;o",
                text: data.msg,
                type: "success",
                html: true,
                confirmButtonText: "Obrigado!"});
        }, 'json');
    }
    $('#fmcemp-i-captcha').removeClass('fa-check-circle').addClass('fa-dot-circle-o');
    $('#fmcemp-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
    $('#fmcemp-txt-captcha').val('');
    return false;
});

$('#form_inserir_empresa').on('submit', function () {
    /*
     * confere o captcha
     */
    if ($('#fmcempinc-txt-captcha').val().length < 4) {
        swal({
            title: "Alerta",
            text: "As letras da imagem est&atilde;o diferentres do que foi digitado.",
            type: "error",
            html: true,
            confirmButtonText: "Vou corrigir, obrigado!"});
    }
    else {
        $.post('/pf/DIM.Gateway.php', {
            'bairro': $('#bairro').val(),
            'cep': $('#cep').val(),
            'cidade': $('#cidade').val(),
            'cnpj': $('#cnpj').val(),
            'email': $('#email').val(),
            'email2': $('#email2').val(),
            'nome': $('#nome').val(),
            'nome2': $('#nome2').val(),
            'telefone': $('#telefone').val(),
            'telefone2': $('#telefone2').val(),
            'ramal': $('#ramal').val(),
            'ramal2': $('#ramal2').val(),
            'tipoLogradouro': $('#tipoLogradouro').val(),
            'uf': $('#uf').val(),
            'idPlano': $('#idPlano').val(),
            'mensalidade': $('#mensalidade').val(),
            'valorContagem': $('#valorContagem').val(),
            'isFaturavel': $('#isFaturavel').prop('checked') ? 1 : 0,
            'sigla': $('#sigla').val(),
            'nomeFantasia': $('#nomeFantasia').val(),
            'logradouro': $('#logradouro').val(),
            'indicadoPor': $('#indicadoPor').val() === '' ? 'administrador@pfdimension.com.br' : $('#indicadoPor').val(),
            'tipoFaturamento': $('#tipoFaturamento').prop('checked') ? 0 : 1,
            'arq': 50, 'tch': 0, 'sub': 0, 'dlg': 1
        }, function (data) {
            swal({
                title: "Informa&ccedil;&atilde;o",
                text: data.msg,
                type: "success",
                html: true,
                confirmButtonText: "Obrigado!"});
        }, 'json');
    }
    $('#fmcempinc-i-captcha').removeClass('fa-check-circle').addClass('fa-dot-circle-o');
    $('#fmcempinc-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
    $('#fmcempinc-txt-captcha').val('');
    limpaCamposInserirEmpresa();
    return false;
});

function limpaCamposInserirEmpresa() {
    $('#bairro').val('');
    $('#cep').val('');
    $('#cidade').val('');
    $('#cnpj').val('');
    $('#email').val('');
    $('#email2').val('');
    $('#nome').val('');
    $('#nome2').val('');
    $('#telefone').val('');
    $('#telefone2').val('');
    $('#ramal').val('');
    $('#ramal2').val('');
    $('#tipoLogradouro').val('');
    $('#uf').val(0);
    $('#idPlano').val(0);
    $('#mensalidade').val('');
    $('#valorContagem').val('');
    $('#isFaturavel').bootstrapToggle('on');
    $('#sigla').val('');
    $('#nomeFantasia').val('');
    $('#logradouro').val('');
    $('#indicadoPor').val('');
    $('#tipoFaturamento').bootstrapToggle('on');
}
