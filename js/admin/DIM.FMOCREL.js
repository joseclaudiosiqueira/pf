//le o combo clientes
$('#href-modal-relatorios').on('click', function () {
    comboCliente('relatorio', (isFornecedor ? idCliente : 0), '01', (isFornecedor ? idFornecedor : 0));
    if (isFornecedor) {
        $('#relatorio_id_cliente').prop('disabled', true);
        $.post('/pf/DIM.Gateway.php', {'i': idCliente, 
            'arq': 62, 'tch': 1, 'sub': 0, 'dlg': 1}, function (data) {
            /*
             * insere os valores atuais nos campos do formulario
             */
            $('#txt-cab-linha-1').val(data.cab_linha_1);
            $('#txt-cab-linha-2').val(data.cab_linha_2);
            $('#txt-cab-linha-3').val(data.cab_linha_3);
            $('#cab-linha-1').html(data.cab_linha_1);
            $('#cab-linha-2').html(data.cab_linha_2);
            $('#cab-linha-3').html(data.cab_linha_3);
            $('#cab-alinhamento').css('text-align', data.cab_alinhamento);

            data.is_logomarca_empresa == 1 ? $('#is-logomarca-empresa').prop('checked', true) : $('#is-logomarca-empresa').prop('checked', false);
            data.is_logomarca_empresa == 1 ? $('#img-is-logomarca-empresa').css('visibility', 'visible').attr('src', '/pf/vendor/cropper/producao/crop/img/img-forn/' + sha1(idFornecedor) + '.png?' + new Date().getTime()) : $('#img-is-logomarca-empresa').css('visibility', 'hidden');

            data.is_logomarca_cliente == 1 ? $('#is-logomarca-cliente').prop('checked', true) : $('#is-logomarca-cliente').prop('checked', false);
            data.is_logomarca_cliente == 1 ? $('#img-is-logomarca-cliente').css('visibility', 'visible').attr('src', '/pf/vendor/cropper/producao/crop/img/img-cli/' + data.logomarca + '.png?' + new Date().getTime()) : $('#img-is-logomarca-cliente').css('visibility', 'hidden');

            $('#txt-alinhamento').val(data.cab_alinhamento);
            $('#txt-rod-linha-1').val(data.rod_linha_1);
            $('#rod-linha-1').html(data.rod_linha_1 + ' - página x de y - Emitido em xx/xx/xxx às xx:xx:xx por fulano@companhia.com');
        }, 'json');
        $('#btn-atualizar-relatorios').prop('disabled', false);
        comboContrato(idCliente, 1, 0, 0, 'assinatura');
        //habilita a combo dos contratos na tela de assinaturas dos relatorios
        $('#assinatura_id_contrato').prop('disabled', false);
        habilitaCamposRelatorio(false);
        //limpa e habilita os campos na tela de assinaturas
        limpaCamposAssinatura();
        habilitaCamposAssinatura(true);
        $('#assinatura_id_contrato').val(0);
    }
});
$('#txt-cab-linha-1').on('keyup', function () {
    $('#cab-linha-1').html($(this).val());
});
$('#txt-cab-linha-2').on('keyup', function () {
    $('#cab-linha-2').html($(this).val());
});
$('#txt-cab-linha-3').on('keyup', function () {
    $('#cab-linha-3').html($(this).val());
});
$('#txt-rod-linha-1').on('keyup', function () {
    $('#rod-linha-1').html($(this).val() + ' - página x de y - Emitido em xx/xx/xxx às xx:xx:xx por fulano@companhia.com');
});
$('#btn-left').on('click', function () {
    $('#cab-alinhamento').css({'text-align': 'left'});
    $('#txt-cab-alinhamento').val('left');
});
$('#btn-center').on('click', function () {
    $('#cab-alinhamento').css({'text-align': 'center'});
    $('#txt-cab-alinhamento').val('center');
});
$('#btn-right').on('click', function () {
    $('#cab-alinhamento').css({'text-align': 'right'});
    $('#txt-cab-alinhamento').val('right');
});
$('#is-logomarca-cliente').on('change', function () {
    $(this).prop('checked') ? $('#img-is-logomarca-cliente')
            .css('visibility', 'visible')
            .attr('src', ('/pf/vendor/cropper/producao/crop/img/img-cli/' +
                    (isFornecedor ? sha1(idCliente) : sha1($('#relatorio_id_cliente').val()))
                    + '.png?' + new Date().getTime())) : $('#img-is-logomarca-cliente').css('visibility', 'hidden');
});
$('#is-logomarca-empresa').on('change', function () {
    $(this).prop('checked') ? $('#img-is-logomarca-empresa')
            .css('visibility', 'visible')
            .attr('src', ('/pf/vendor/cropper/producao/crop/img/' +
                    (isFornecedor ? 'img-forn/' + sha1(idFornecedor) : 'img-emp/' + sha1(idEmpresa))
                    + '.png?' + new Date().getTime())) : $('#img-is-logomarca-empresa').css('visibility', 'hidden');
});
/*
 * evento de SUBMIT do formulario de configuracao
 */
$('#form-config-relatorios').on('submit', function () {
    if ($('#relatorio_id_cliente').val() == 0) {
        swal({
            title: "Alerta",
            text: "Voc&ecirc; deve selecionar um <strong>cliente</strong> para efetivar a atualiza&ccedil;&atilde;o.",
            type: "error",
            html: true,
            confirmButtonText: "Entendi, obrigado!"});
    }
    else {
        $.post('/pf/DIM.Gateway.php', {
            'relatorio_id_cliente': $('#relatorio_id_cliente').val(),
            'txt-cab-linha-1': $('#txt-cab-linha-1').val(),
            'txt-cab-linha-2': $('#txt-cab-linha-2').val(),
            'txt-cab-linha-3': $('#txt-cab-linha-3').val(),
            'txt-rod-linha-1': $('#txt-rod-linha-1').val(),
            'is-logomarca-empresa': $('#is-logomarca-empresa').prop('checked') ? 1 : 0,
            'is-logomarca-cliente': $('#is-logomarca-cliente').prop('checked') ? 1 : 0,
            'txt-cab-alinhamento': $('#txt-cab-alinhamento').val(),
            'arq': 38, 'tch': 0, 'sub': 0, 'dlg': 1
        }, function (data) {
            swal({
                title: "Informa&ccedil;&atilde;o",
                text: data.msg,
                type: "success",
                html: true,
                confirmButtonText: "Obrigado!"});
        }, 'json');
    }
    return false;
});

$('#btn-atualizar-assinatura').on('click', function () {
    if ($('#assinatura_id_projeto').val() == 0) {
        swal({
            title: "Alerta",
            text: "Voc&ecirc; deve selecionar um <strong>projeto</strong> para efetivar a atualiza&ccedil;&atilde;o.",
            type: "error",
            html: true,
            confirmButtonText: "Entendi, obrigado!"});
    }
    else {
        /*
         * executa a rotina para atualizacao das assinaturas
         */
        $.post('/pf/DIM.Gateway.php', {
            'assinatura_id_projeto': $('#assinatura_id_projeto').val(),
            'assinatura_nome_1': $('#assinatura_nome_1').val(),
            'assinatura_nome_2': $('#assinatura_nome_2').val(),
            'assinatura_nome_3': $('#assinatura_nome_3').val(),
            'assinatura_nome_4': $('#assinatura_nome_4').val(),
            'assinatura_nome_5': $('#assinatura_nome_5').val(),
            'assinatura_nome_6': $('#assinatura_nome_6').val(),
            'assinatura_cargo_1': $('#assinatura_cargo_1').val(),
            'assinatura_cargo_2': $('#assinatura_cargo_2').val(),
            'assinatura_cargo_3': $('#assinatura_cargo_3').val(),
            'assinatura_cargo_4': $('#assinatura_cargo_4').val(),
            'assinatura_cargo_5': $('#assinatura_cargo_5').val(),
            'assinatura_cargo_6': $('#assinatura_cargo_6').val(),
            'is_assinatura_relatorio': $('#is-assinatura-relatorio').prop('checked') ? 1 : 0,
            'arq': 42, 'tch': 0, 'sub': 0, 'dlg': 1            
        }, function (data) {
            swal({
                title: "Informa&ccedil;&atilde;o",
                text: data.msg,
                type: "success",
                html: true,
                confirmButtonText: "Obrigado!"});
        }, 'json');
    }
});
/*
 * evento change na combobox do cliente
 */
$('#relatorio_id_cliente').on('change', function () {
    if ($(this).val() > 0) {
        $.post('/pf/DIM.Gateway.php', {'i': $(this).val(), 
            'arq': 62, 'tch': 1, 'sub': 0, 'dlg': 1}, function (data) {
            /*
             * insere os valores atuais nos campos do formulario
             */
            $('#txt-cab-linha-1').val(data.cab_linha_1);
            $('#txt-cab-linha-2').val(data.cab_linha_2);
            $('#txt-cab-linha-3').val(data.cab_linha_3);
            $('#cab-linha-1').html(data.cab_linha_1);
            $('#cab-linha-2').html(data.cab_linha_2);
            $('#cab-linha-3').html(data.cab_linha_3);
            $('#cab-alinhamento').css('text-align', data.cab_alinhamento);

            data.is_logomarca_empresa == 1 ? $('#is-logomarca-empresa').prop('checked', true) : $('#is-logomarca-empresa').prop('checked', false);
            data.is_logomarca_empresa == 1 ? $('#img-is-logomarca-empresa').css('visibility', 'visible').attr('src', '/pf/vendor/cropper/producao/crop/img/' + (isFornecedor ? 'img-forn' : 'img-emp') + '/' + sha1(isFornecedor ? idFornecedor : idEmpresa) + '.png?' + new Date().getTime()) : $('#img-is-logomarca-empresa').css('visibility', 'hidden');

            data.is_logomarca_cliente == 1 ? $('#is-logomarca-cliente').prop('checked', true) : $('#is-logomarca-cliente').prop('checked', false);
            data.is_logomarca_cliente == 1 ? $('#img-is-logomarca-cliente').css('visibility', 'visible').attr('src', '/pf/vendor/cropper/producao/crop/img/' + (isFornecedor ? 'img-emp/' + sha1(idEmpresa) : 'img-cli/' + data.logomarca) + '.png?' + new Date().getTime()) : $('#img-is-logomarca-cliente').css('visibility', 'hidden');

            $('#txt-alinhamento').val(data.cab_alinhamento);
            $('#txt-rod-linha-1').val(data.rod_linha_1);
            $('#rod-linha-1').html(data.rod_linha_1 + ' - página x de y - Emitido em xx/xx/xxx às xx:xx:xx por fulano@companhia.com');
        }, 'json');
        $('#btn-atualizar-relatorios').prop('disabled', false);
        comboContrato($(this).val(), 1, 0, 0, 'assinatura');
        //habilita a combo dos contratos na tela de assinaturas dos relatorios
        $('#assinatura_id_contrato').prop('disabled', false);
        habilitaCamposRelatorio(false);
        //limpa e habilita os campos na tela de assinaturas
        limpaCamposAssinatura();
        habilitaCamposAssinatura(true);
        $('#assinatura_id_contrato').val(0);
    }
    else {
        limpaCamposRelatorio();
        habilitaCamposRelatorio(true); //boolean para .prop('disabled', [true/false])
        limpaCamposAssinatura();
        habilitaCamposAssinatura(true);
        $('#btn-atualizar-assinatura').prop('disabled', true);
        $('#btn-atualizar-relatorios').prop('disabled', true);
        $('#assinatura_id_contrato').empty().prop('disabled', true).append('<option value="0">Aguardando um cliente...');
    }
    $('#assinatura_id_projeto').empty().prop('disabled', true).append('<option value="0">Aguardando um contrato...');
});
//dispara o evento de alteracao do id do contrato na tab assinaturas
$('#assinatura_id_contrato').on('change', function () {
    if (Number($(this).val()) > 0) {
        comboProjeto($(this).val(), 1, 0, 'assinatura');
        $('#assinatura_id_projeto').prop('disabled', false);
    }
    else {
        $('#assinatura_id_projeto').empty().prop('disabled', true).append('<option value="0">Aguardando um contrato...</option>');
        $('#btn-atualizar-assinatura').prop('disabled', true);
        limpaCamposAssinatura();
    }
});
/*
 * evento change na combobox do projeto 
 */
$('#assinatura_id_projeto').on('change', function () {
    if (Number($(this).val()) > 0) {
        $.post('/pf/DIM.Gateway.php', {'i': $(this).val(), 
            'arq': 61, 'tch': 1, 'sub': 0, 'dlg': 1}, function (data) {
            /*
             * insere os valores atuais nos campos do formulario
             * atencao para a nomenclatura ... que vem diretamente das colunas do banco de dados
             */
            $('#assinatura_nome_1').val(data.assinatura_nome_1);
            $('#assinatura_nome_2').val(data.assinatura_nome_2);
            $('#assinatura_nome_3').val(data.assinatura_nome_3);
            $('#assinatura_nome_4').val(data.assinatura_nome_4);
            $('#assinatura_nome_5').val(data.assinatura_nome_5);
            $('#assinatura_nome_6').val(data.assinatura_nome_6);
            $('#assinatura_cargo_1').val(data.assinatura_cargo_1);
            $('#assinatura_cargo_2').val(data.assinatura_cargo_2);
            $('#assinatura_cargo_3').val(data.assinatura_cargo_3);
            $('#assinatura_cargo_4').val(data.assinatura_cargo_4);
            $('#assinatura_cargo_5').val(data.assinatura_cargo_5);
            $('#assinatura_cargo_6').val(data.assinatura_cargo_6);
            $('#is-assinatura-relatorio').prop('checked', Number(data.is_assinatura_relatorio) == 1 ? true : false);
        }, 'json');
        $('#btn-atualizar-assinatura').prop('disabled', false);
        habilitaCamposAssinatura(false);
    }
    else {
        $('#btn-atualizar-assinatura').prop('disabled', true);
        habilitaCamposAssinatura(true); //boolean para .prop('disabled', [true/false])
        limpaCamposAssinatura();
    }
});

$('#is-assinatura-relatorio').on('change', function () {
    var i = Number($('#assinatura_id_projeto').val());
    if ($(this).prop('checked')) {
        if (i > 0) {
            $.post('/pf/DIM.Gateway.php', {'i': i, 
                'arq': 61, 'tch': 1, 'sub': 0, 'dlg': 1}, function (data) {
                /*
                 * insere os valores atuais nos campos do formulario
                 * atencao para a nomenclatura ... que vem diretamente das colunas do banco de dados
                 */
                $('#assinatura_nome_1').val(data.assinatura_nome_1);
                $('#assinatura_nome_2').val(data.assinatura_nome_2);
                $('#assinatura_nome_3').val(data.assinatura_nome_3);
                $('#assinatura_nome_4').val(data.assinatura_nome_4);
                $('#assinatura_nome_5').val(data.assinatura_nome_5);
                $('#assinatura_nome_6').val(data.assinatura_nome_6);
                $('#assinatura_cargo_1').val(data.assinatura_cargo_1);
                $('#assinatura_cargo_2').val(data.assinatura_cargo_2);
                $('#assinatura_cargo_3').val(data.assinatura_cargo_3);
                $('#assinatura_cargo_4').val(data.assinatura_cargo_4);
                $('#assinatura_cargo_5').val(data.assinatura_cargo_5);
                $('#assinatura_cargo_6').val(data.assinatura_cargo_6);
            }, 'json');
            habilitaCamposAssinatura(false);
        }
        else {
            habilitaCamposAssinatura(true);
            limpaCamposAssinatura();
        }
    }
    else {
        limpaCamposAssinatura();
    }
});
//$('#assinatura_id_projeto').empty().append('<option value="0">Aguardando um contrato...</option>');

/*
 * eventos de fechamento da janela
 */
$('#btn-fechar-relatorios').on('click', function () {
    limpaCamposRelatorio(false);
});

$('#btn-fechar-assinatura').on('click', function () {
    limpaCamposRelatorio();
    limpaCamposAssinatura();

});

$('#fechar_relatorios').on('click', function () {
    limpaCamposRelatorio();
    limpaCamposAssinatura();
});
/**
 * 
 * @param {type} a - para limpar os campos da assinatura
 * @returns {undefined}
 */
function limpaCamposRelatorio() {
    /*
     * na aba - APF - Relatorio
     */
    $('#txt-cab-linha-1').val('');
    $('#txt-cab-linha-2').val('');
    $('#txt-cab-linha-3').val('');
    $('#cab-linha-1').html('');
    $('#cab-linha-2').html('');
    $('#cab-linha-3').html('');
    $('#cab-alinhamento').css('text-align', 'center');
    $('#is-logomarca-empresa').prop('checked', false);
    $('#is-logomarca-cliente').prop('checked', false);
    $('#img-is-logomarca-empresa').css('visibility', 'visible').attr('src', '/pf/img/empty_logo_empresa.pt_BR.jpg');
    $('#img-is-logomarca-cliente').css('visibility', 'visible').attr('src', '/pf/img/empty_logo_cliente.pt_BR.jpg');
    $('#txt-alinhamento').val('center');
    $('#txt-rod-linha-1').val('');
    $('#rod-linha-1').html('página x de y - Emitido em xx/xx/xxx às xx:xx:xx por fulano@companhia.com');
}
/**
 * 
 * @param {boolean} b - booleano habilita = false, desabilita = true
 * @returns {undefined}
 */
function habilitaCamposRelatorio(b) {
    $('#btn-left').prop('disabled', b);
    $('#btn-center').prop('disabled', b);
    $('#btn-right').prop('disabled', b);
    $('#txt-cab-linha-1').prop('disabled', b);
    $('#txt-cab-linha-2').prop('disabled', b);
    $('#txt-cab-linha-3').prop('disabled', b);
    $('#is-logomarca-empresa').prop('disabled', b);
    $('#is-logomarca-cliente').prop('disabled', b);
    b ? $('#img-is-logomarca-empresa').css('visibility', 'hidden') : $('#img-is-logomarca-empresa').css('visibility', 'visible');
    b ? $('#img-is-logomarca-cliente').css('visibility', 'hidden') : $('#img-is-logomarca-cliente').css('visibility', 'visible');
    $('#txt-rod-linha-1').prop('disabled', b);
}

function limpaCamposAssinatura() {
    /*
     * na aba - APF - Assinaturas
     */
    $('#assinatura_nome_1').val('');
    $('#assinatura_nome_2').val('');
    $('#assinatura_nome_3').val('');
    $('#assinatura_nome_4').val('');
    $('#assinatura_nome_5').val('');
    $('#assinatura_nome_6').val('');
    $('#assinatura_cargo_1').val('');
    $('#assinatura_cargo_2').val('');
    $('#assinatura_cargo_3').val('');
    $('#assinatura_cargo_4').val('');
    $('#assinatura_cargo_5').val('');
    $('#assinatura_cargo_6').val('');
    $('#is-assinatura-relatorio').prop('checked', false);
}

function habilitaCamposAssinatura(b) {
    /*
     * habilita/desabilita os campos das assinaturas
     */
    $('#assinatura_nome_1').prop('disabled', b);
    $('#assinatura_nome_2').prop('disabled', b);
    $('#assinatura_nome_3').prop('disabled', b);
    $('#assinatura_nome_4').prop('disabled', b);
    $('#assinatura_nome_5').prop('disabled', b);
    $('#assinatura_nome_6').prop('disabled', b);
    $('#assinatura_cargo_1').prop('disabled', b);
    $('#assinatura_cargo_2').prop('disabled', b);
    $('#assinatura_cargo_3').prop('disabled', b);
    $('#assinatura_cargo_4').prop('disabled', b);
    $('#assinatura_cargo_5').prop('disabled', b);
    $('#assinatura_cargo_6').prop('disabled', b);
    $('#is-assinatura-relatorio').prop('disabled', b);
}