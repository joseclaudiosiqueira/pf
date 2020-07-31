//MODAL CONTRATO
var dataFormContrato;
//formata a mascara para os campos money
$('.money').mask("###0.00", {reverse: true});
//formulario de cadastro de contratos
$('#fmiacon-txt-captcha').on('keyup', function () {
    verificaCaptcha($(this), $('#fmiacon-i-captcha'), false);
});
if (empresaConfigPlano.id < 3) {
    $('#fmiacon-link').css({'text-decoration': 'line-through'});
}
//clique no link atualiza o captcha tambem
$("#fmiacon-link").on("click", function () {
    comboCliente('fmiacon', (isFornecedor ? idCliente : 0), '1', (isFornecedor ? idFornecedor : 0)); //apenas clientes ativos podem ter contratos cadastrados
    $('#fmiacon_id_cliente').prop('disabled', isFornecedor);
    if (isFornecedor)
        atualizaTabelaContratoCliente(idCliente);
    $('#fmiacon_btn_inserir').prop('disabled', false);
    $('#fmiacon_btn_novo').prop('disabled', true);
    $('#fmiacon_btn_atualizar').prop('disabled', true);
    /*
     * para todos dos forms a leitura da imagem do captcha eh feita no click para evitar desatualizacoes
     */
    $('#fmiacon-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
});

/*
 * para inserir um novo contrato
 */
$('#form_inserir_alterar_contrato').on('submit', function () {
    var acao = $('#fmiacon_acao').val();
    /*
     * confere o captcha
     */
    if ($('#fmiacon-txt-captcha').val().length < 4) {
        swal({
            title: "Alerta",
            text: "As letras da imagem est&atilde;o diferentres do que foi digitado.",
            type: "error",
            html: true,
            confirmButtonText: "Vou corrigir, obrigado!"});
    }
    else if (!($('#fmiacon_tipo').prop('checked')) && $('#tipo_id_contrato').val() == 0) {
        swal({
            title: "Alerta",
            text: "Voc&ecirc; selecionou &quot;Aditivo&quot; mas n&atilde;o informou o Contrato.",
            type: "error",
            html: true,
            confirmButtonText: "Vou corrigir, obrigado!"});
    }
    else {
        $.post('/pf/DIM.Gateway.php', variaveisFormContrato(acao), function (data) {
            if (data.id > 0) {
                swal({
                    title: "Informa&ccedil;&atilde;o",
                    text: data.msg,
                    type: "success",
                    html: true,
                    confirmButtonText: "Obrigado!"});
                if (dataFormContrato.acao === 'inserir') {
                    $('#fmiacon_btn_inserir').prop('disabled', true);
                    $('#fmiacon_btn_novo').prop('disabled', false);
                    $('#fmiacon_btn_atualizar').prop('disabled', false);
                    $('#fmiacon_id').val(data.id);
                    $('#fmiacon_acao').val('alterar');
                }
                $('#fmiacon-txt-captcha').val('');
                $('#fmiacon-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
                atualizaTabelaContratoCliente($('#fmiacon_id_cliente').val());
            }
            else {
                gravaLogAuditoria(emailLogado, userRole, 'inserir-alterar-contrato;' + ("000000000" + idEmpresa).slice(-9));
            }
        }, 'json');
    }
    return false;
});

//clique no botao para fechar a janela do cliente
$('#fechar_contrato').on('click', function () {
    limpaCamposContrato(true);
    return true;
});

//clique no botao para inserir um novo cliente
$('#fmiacon_btn_novo').on('click', function () {
    limpaCamposContrato(false);
    return true;
});

$('#fmiacon_id_cliente').on('change', function () {
    limpaCamposContrato(false);
    atualizaTabelaContratoCliente($(this).val());
});

$('#fmiacon_tipo').on('change', function () {
    if (!($(this).prop('checked'))) {
        if ($("#addContrato tr").length == 0) {
            swal({
                title: "Alerta",
                text: "Este cliente ainda n&atilde;o possui contrato(s). Portanto, o primeiro deve ser do tipo [ I ] - Inicial.",
                type: "error",
                html: true,
                confirmButtonText: "Obrigado!"});
            $('#fmiacon_tipo').bootstrapToggle('on');
        }
        else if ($("#addContrato tr").length == 1 && $('#fmiacon_acao').val() === 'alterar') { //verifica se ha apenas um contrato para o cliente e nao permite torna-lo A - Aditivo
            swal({
                title: "Alerta",
                text: "Este cliente possui apenas um contrato. Portanto, deve ser inicial.",
                type: "error",
                html: true,
                confirmButtonText: "Obrigado!"});
            $('#fmiacon_tipo').bootstrapToggle('on');
        }
        else {
            $('#tipo_id_contrato').empty().prop('disabled', false);
            comboContrato($('#fmiacon_id_cliente').val(), '01', 0, 0, 'tipo'); //somente os Iniciais
        }
    }
    else {
        $('#tipo_id_contrato').empty().prop('disabled', true);
    }
});

$('#tipo_id_contrato').on('change', function () {
    if ($(this).val() == $('#fmiacon_id').val()) {
        swal({
            title: "Aten&ccedil;&atilde;o",
            text: "O contrato principal n&atilde;o pode ser aditivo dele mesmo.",
            type: "error",
            html: true,
            confirmButtonText: "Obrigado, vou selecionar outro"}, function () {
            $('#tipo_id_contrato').val(0);
            return false;
        });
    }
});

$('#fmiacon_is_ativo').on('change', function () {
    if (!($(this).prop('checked'))) {
        if ($("#addContrato tr").length == 0) {
            swal({
                title: "Aten&ccedil;&atilde;o",
                text: "Este cliente ainda n&atilde;o possui contrato(s) e voc&ecirc; est&aacute; adicionando o primeiro como INATIVO.",
                type: "info",
                html: true,
                confirmButtonText: "Tem certeza?"});
            $('#fmiacon_tipo').bootstrapToggle('on');
        }
    }
});

/*
 * captura dos cliques nos botoes de dada inicial e data final
 */
var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
var fmiaconDataInicio = $('#fmiacon-data-inicio').datepicker({format: 'dd/mm/yyyy', onRender: function (date) {
    }}).on('changeDate', function (ev) {
    fmiaconDataInicio.hide();
    $('#fmiacon-data-fim').val('')[0].focus();
}).data('datepicker');

var fmiaconDataFim = $('#fmiacon-data-fim').datepicker({format: 'dd/mm/yyyy', onRender: function (date) {
        return date.valueOf() < fmiaconDataInicio.date.valueOf() ? 'disabled' : '';
    }}).on('changeDate', function (ev) {
    fmiaconDataFim.hide();
}).data('datepicker');

function atualizaTabelaContratoCliente(id) {
    if (id != 0) {
        iWait('w_fmiacon_id_cliente', true);
        $.post('/pf/DIM.Gateway.php', {'i': id, 't': 0, 'arq': 66, 'tch': 1, 'sub': 0, 'dlg': 1}, function (data) {
            $('#addContrato').empty();
            for (x = 0; x < data.length; x++) {
                addLinhaContrato(
                        data[x].id,
                        data[x].anoNumero,
                        data[x].uf,
                        data[x].dataInicio,
                        data[x].dataFim,
                        data[x].tipo,
                        data[x].isAtivo ? 'on' : 'off',
                        data[x].valorPF,
                        data[x].valorHpc,
                        data[x].valorHpa);
            }
            iWait('w_fmiacon_id_cliente', false);
            $('#fmiacon_tipo').bootstrapToggle('enable');
            $('#fmiacon_is_ativo').bootstrapToggle('enable');
        }, 'json');
    }
    else {
        $('#tipo_id_contrato').prop('disabled', true);
        $('#fmiacon_tipo').bootstrapToggle('on');
        $('#fmiacon_tipo').bootstrapToggle('disable');
        $('#fmiacon_is_ativo').bootstrapToggle('disable');
    }
}
/**
 * 
 * @param {type} i1
 * @param {type} i2
 * @param {type} i3
 * @param {type} i4
 * @param {type} i5
 * @param {type} i6
 * @param {type} i7
 * @param {type} i8
 * @param {type} i9 
 * @returns {undefined}
 */
function addLinhaContrato(i1, i2, i3, i4, i5, i6, i7, i8, i9, i10) {
    var t = $('#addContrato').get(0); //tabela
    var r = t.insertRow(-1); //linha

    var c1 = r.insertCell(0);
    var c2 = r.insertCell(1);
    var c3 = r.insertCell(2);
    var c4 = r.insertCell(3);
    var c5 = r.insertCell(4);
    var c6 = r.insertCell(5);
    var c7 = r.insertCell(6);
    var c8 = r.insertCell(7);

    var vChecked = i7 === 'on' ? 'checked' : '';

    c1.innerHTML = '<a href="#" onclick="exibeContratoAlteracao(' + i1 + ');">' + i2 + '</a>';
    c2.innerHTML = i4;
    c3.innerHTML = i5;
    c4.innerHTML = i6;
    c5.innerHTML = '<input onchange="alteraStatusContrato($(this).val(), $(this).prop(\'checked\'));" value="' + i1 + '" type="checkbox" data-toggle="toggle" data-width="80" data-onstyle="success" data-style="slow" data-on="Ativo" data-off="Inativo" class="datatoggle" ' + vChecked + '>';
    c6.innerHTML = i8;
    c7.innerHTML = i9;
    c8.innerHTML = i10;
    /*
     * inicializacao manual dos datatoggles
     */
    $('.datatoggle').bootstrapToggle();
}

/**
 * 
 * @param {type} t - limpar ou nao a tabela (caso seja os botoes fechar, limpa as tabelas
 * @returns {undefined}
 */
function limpaCamposContrato(t) {
    $('#fmiacon_acao').val('inserir');
    $('#fmiacon_id').val(''); //depois que inserir este campo armazena o id recem gerado para atualizacoes
    $('#fmiacon_ano').val('');
    $('#fmiacon_numero').val('');
    $('#fmiacon_uf').val(0);
    $('#fmiacon-data-inicio').val('');
    $('#fmiacon-data-fim').val('');
    $('#fmiacon_pf_contratado').val('');
    $('#fmiacon_valor_pf').val('');
    $('#fmiacon_valor_hpc').val('');
    $('#fmiacon_valor_hpa').val('');
    $('#fmiacon_tipo').bootstrapToggle('on');
    $('#fmiacon_is_ativo').bootstrapToggle('on');
    $('#tipo_id_contrato').empty().prop('disabled', true);
    $('#fmiacon-txt-captcha').val('');
    $('#fmiacon-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
    $('#fmiacon_btn_novo').prop('disabled', true);
    $('#fmiacon_btn_inserir').prop('disabled', false);
    $('#fmiacon_btn_atualizar').prop('disabled', true);//este botao fica habilitado logo apos o cadastro
    if (t) {
        $('#addContrato').empty();
    }
    $('#fmiacon-i-captcha').removeClass('fa-check-circle').addClass('fa-dot-circle-o');
    $('#fmiacon_is_ativo').bootstrapToggle('enable');
    dataFormContrato = {};
}

//cria o objeto dataFormCliente com as informacoes preenchidas no formulario
function variaveisFormContrato(acao) {
    dataFormContrato = {
        'acao': acao,
        'id': $('#fmiacon_id').val(),
        'ano': $('#fmiacon_ano').val(),
        'numero': $('#fmiacon_numero').val(),
        'uf': $('#fmiacon_uf').val(),
        'id_cliente': $('#fmiacon_id_cliente').val(),
        'is_ativo': $('#fmiacon_is_ativo').prop('checked') ? 1 : 0,
        'pf_contratado': $('#fmiacon_pf_contratado').val(),
        'valor_pf': $('#fmiacon_valor_pf').val(),
        'data_inicio': $('#fmiacon-data-inicio').val(),
        'data_fim': $('#fmiacon-data-fim').val(),
        'tipo': $('#fmiacon_tipo').prop('checked') ? 'I' : 'A',
        'id_primario': !($('#fmiacon_tipo').prop('checked')) ? $('#tipo_id_contrato').val() : 0,
        'valor_hpc': $('#fmiacon_valor_hpc').val(),
        'valor_hpa': $('#fmiacon_valor_hpa').val(),
        'arq': 45, 'tch': 0, 'sub': 0, 'dlg': 1};
    return dataFormContrato;
}

function exibeContratoAlteracao(id) {
    $.post('/pf/DIM.Gateway.php', {'i': id, 't': 1, 'arq': 66, 'tch': 1, 'sub': 0, 'dlg': 1}, function (data) {
        $('#fmiacon_acao').val('alterar');
        $('#fmiacon_id').val(id);
        $('#fmiacon_ano').val(data[0].ano);
        $('#fmiacon_numero').val(data[0].numero);
        $('#fmiacon_uf').val(data[0].uf);
        $('#fmiacon-data-inicio').val(data[0].dataInicio);
        $('#fmiacon-data-fim').val(data[0].dataFim);
        $('#fmiacon_pf_contratado').val(data[0].PFContratado);
        $('#fmiacon_valor_pf').val(data[0].valorPF);
        $('#fmiacon_valor_hpc').val(data[0].valorHpc);
        $('#fmiacon_valor_hpa').val(data[0].valorHpa);
        /*
         * verificar o tipo e habilitar o combo contrato caso seja aditivo (off)
         */
        $('#fmiacon_tipo').bootstrapToggle(data[0].tipo);
        if (data[0].tipo === 'off') {
            $('#tipo_id_contrato').empty().prop('disabled', false);
            comboContrato($('#fmiacon_id_cliente').val(), '01', data[0].idPrimario, 1);
        }
        $('#fmiacon_is_ativo').bootstrapToggle(data[0].isAtivo);
        $('#fmiacon_btn_novo').prop('disabled', false);
        $('#fmiacon_btn_inserir').prop('disabled', true);
        $('#fmiacon_btn_atualizar').prop('disabled', false);
        $('#fmiacon_is_ativo').bootstrapToggle('disable');
    }, 'json');
}

function alteraStatusContrato(id, prop) {
    iWait('w_contrato_status', true);
    /*
     * sincroniza os datatoggles em caso de clicar para alterar e clicar para inativar/ativar
     */
    if ($('#fmiacon_id').val() !== '' && $('#fmiacon_id').val() === id) {
        $('#fmiacon_is_ativo').bootstrapToggle('enable').bootstrapToggle(prop ? 'on' : 'off').bootstrapToggle('disable');
    }
    $.post('/pf/DIM.Gateway.php', {'i': id, 'p': prop ? 1 : 0,
        'arq': 34, 'tch': 0, 'sub': 0, 'dlg': 1}, function (data) {
        if (!(data.status)) {
            gravaLogAuditoria(emailLogado, userRole, 'alterar-status-contrato;' + ("000000000" + idEmpresa).slice(-9));
        }
        iWait('w_contrato_status', false);
    }, 'json');
}