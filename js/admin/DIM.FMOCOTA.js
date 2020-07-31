$('#fmctar-txt-captcha').on('keyup', function () {
    verificaCaptcha($(this), $('#fmctar-i-captcha'), false);
});
/*
 * desabilita a configuracao das tarefas, ja que eh um fornecedor
 */
$('#fmctar-link').on('click', function () {
    if (Number($('#config_id_cliente option:selected').val()) == 0) {
        swal({
            title: "Alerta",
            text: "Por favor selecione um Cliente",
            type: "warning",
            html: true,
            confirmButtonText: "Vou verificar, obrigado!"});
    }
    else {
        $.post('DIM.Gateway.php', {
            'arq': 100,
            'tch': 1,
            'sub': -1,
            'dlg': 0,
            'icl': $('#config_id_cliente option:selected').val()
        }, function (data) {
            $('#t_validacao_interna').val(data.validacao_interna);
            $('#t_validacao_externa').val(data.validacao_externa);
            $('#t_auditoria_interna').val(data.auditoria_interna);
            $('#t_auditoria_externa').val(data.auditoria_externa);
            $('#t_revisao_validacao_interna').val(data.revisao_validacao_interna);
            $('#t_revisao_validacao_externa').val(data.revisao_validacao_externa);
            $('#t_aponte_auditoria_interna').val(data.aponte_auditoria_interna);
            $('#t_aponte_auditoria_externa').val(data.aponte_auditoria_externa);
            $('#t_faturamento').val(data.faturamento);
            $('#form_modal_configuracoes_tarefas').modal('show');
            $('#fmctar-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
        }, 'json');
    }
});
/*
 * verifica se eh um fornecedor e taxa o link de configuracao das tarefas
 */
if (isFornecedor) {
    $('#btn-atualizar-configuracoes').prop('disabled', true);
    $('#div-configuracoes').html('ATEN&Ccedil;&Atilde;O: voc&ecirc; est&aacute; logado como um fornecedor, n&atilde;o &eacute; poss&iacute;vel alterar as configura&ccedil;&otilde;es de prazos, apenas visualiz&aacute;-las.');
}
else {
    $('#div-configuracoes').html('ATEN&Ccedil;&Atilde;O: os prazos estabelecidos nestas configura&ccedil;&otilde;es ser&atilde;o v&aacute;lidos tanto para voc&ecirc; quando para os seus Fornecedores.' +
            '<ul class="fa-ul">' +
            '<li><i class="fa fa-arrow-circle-right"></i>&nbsp;Valida&ccedil;&otilde;es (internas e externas)</li>' +
            '<li><i class="fa fa-arrow-circle-right"></i>&nbsp;Auditorias (internas e externas)</li>' +
            '<li><i class="fa fa-arrow-circle-right"></i>&nbsp;Demais atividades autom&aacute;ticas</li>' +
            '</ul>');
}

$('#t_validacao_interna').mask('00').TouchSpin({min: 1, max: 10, step: 1, boostat: 2, maxboostedstep: 5, postfix: ''}).prop('readonly', true);
$('#t_validacao_externa').mask('00').TouchSpin({min: 1, max: 20, step: 1, boostat: 2, maxboostedstep: 5, postfix: ''}).prop('readonly', true);
$('#t_auditoria_interna').mask('00').TouchSpin({min: 1, max: 20, step: 1, boostat: 2, maxboostedstep: 5, postfix: ''}).prop('readonly', true);
$('#t_auditoria_externa').mask('00').TouchSpin({min: 1, max: 60, step: 1, boostat: 2, maxboostedstep: 5, postfix: ''}).prop('readonly', true);
$('#t_revisao_validacao_interna').mask('00').TouchSpin({min: 1, max: 10, step: 1, boostat: 2, maxboostedstep: 5, postfix: ''}).prop('readonly', true);
$('#t_revisao_validacao_externa').mask('00').TouchSpin({min: 1, max: 10, step: 1, boostat: 2, maxboostedstep: 5, postfix: ''}).prop('readonly', true);
$('#t_aponte_auditoria_interna').mask('00').TouchSpin({min: 1, max: 30, step: 1, boostat: 2, maxboostedstep: 5, postfix: ''}).prop('readonly', true);
$('#t_aponte_auditoria_externa').mask('00').TouchSpin({min: 1, max: 30, step: 1, boostat: 2, maxboostedstep: 5, postfix: ''}).prop('readonly', true);
$('#t_faturamento').mask('00').TouchSpin({min: 1, max: 30, step: 1, boostat: 2, maxboostedstep: 5, postfix: ''}).prop('readonly', true);

$('#form_configuracoes_tarefas').on('submit', function () {
    /*
     * confere o captcha
     */
    if ($('#fmctar-txt-captcha').val().length < 4) {
        swal({
            title: "Alerta",
            text: "As letras da imagem est&atilde;o diferentes do que foi digitado.",
            type: "error",
            html: true,
            confirmButtonText: "Vou corrigir, obrigado!"});
    }
    else {
        $.post('/pf/DIM.Gateway.php', {
            't_validacao_interna': $('#t_validacao_interna').val(),
            't_validacao_externa': $('#t_validacao_externa').val(),
            't_auditoria_interna': $('#t_auditoria_interna').val(),
            't_auditoria_externa': $('#t_auditoria_externa').val(),
            't_revisao_validacao_interna': $('#t_revisao_validacao_interna').val(),
            't_revisao_validacao_externa': $('#t_revisao_validacao_externa').val(),
            't_aponte_auditoria_interna': $('#t_aponte_auditoria_interna').val(),
            't_aponte_auditoria_externa': $('#t_aponte_auditoria_externa').val(),
            't_faturamento': $('#t_faturamento').val(),
            'arq': 43, 'tch': 0, 'sub': 0, 'dlg': 1, 'icl': $('#config_id_cliente option:selected').val()
        }, function (data) {
            swal({
                title: "Informa&ccedil;&atilde;o",
                text: data.msg,
                type: "success",
                html: true,
                confirmButtonText: "Obrigado!"});
        }, 'json');
        $('#fmctar-i-captcha').removeClass('fa-check-circle').addClass('fa-dot-circle-o');
        $('#fmctar-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
        $('#fmctar-txt-captcha').val('');
    }
    return false;
});

