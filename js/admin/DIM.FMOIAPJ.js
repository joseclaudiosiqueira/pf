//MODAL PROJETO
if (empresaConfigPlano.id < 3) {
    $('#fmiapro-link').css({'text-decoration': 'line-through'});
}
/*
 * para todos dos forms a leitura da imagem do captcha eh feita no click para evitar desatualizacoes
 */
$("#fmiapro-link").on("click", function () {
    /*
     * para insercao de um gerente para os projetos
     */
    comboGerenteProjeto(0);

    var sel = $("#prj_id_gerente_projeto").get(0);
    if (sel.length == 0) {
        $(sel).prop('disabled', true);
    }
    //captcha
    $('#fmiapro-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
    //cliente
    comboCliente('prj', (isFornecedor ? idCliente : 0), 0, (isFornecedor ? idFornecedor : 0)); //apenas contratos ativos podem ter projetos cadastrados
    $('#prj_id_cliente').prop('disabled', isFornecedor);
    if (isFornecedor) {
        comboContrato(idCliente, '0', 0, 0, 'prj');
        $('#prj_id_contrato').prop('disabled', false);
    }
});
/*
 * captura dos cliques nos botoes de dada inicial e data final
 */
var nowTemp = new Date();
var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
//permite datas anteriores - passado
var checkin = $('#prj_data_inicio').datepicker({format: 'dd/mm/yyyy', onRender: function (date) {
    }}).on('changeDate', function (ev) {
    checkin.hide();
    $('#prj_data_fim').val('')[0].focus();
}).data('datepicker');
//permite apenas datas maiores que a data inicial
var checkout = $('#prj_data_fim').datepicker({format: 'dd/mm/yyyy', onRender: function (date) {
        return date.valueOf() < checkin.date.valueOf() ? 'disabled' : '';
    }}).on('changeDate', function (ev) {
    checkout.hide();
}).data('datepicker');
//variaveis de topo
var dataFormProjeto;
//formulario de cadastro de contratos
$('#fmiapro-txt-captcha').on('keyup', function () {
    verificaCaptcha($(this), $('#fmiapro-i-captcha'), false);
});

$('#prj_id_cliente').on('change', function () {
    if ($(this).val() > 0) {
        $('#prj_id_contrato').prop('disabled', false);
        comboContrato($(this).val(), '0', 0, 0, 'prj'); //apenas contratos ativos podem ter projetos cadastrados
    }
    else {
        limpaCamposProjeto(true);
    }
});

$('#prj_id_contrato').on('change', function () {
    if ($(this).val() > 0) {
        $('#prj_id_contrato').prop('disabled', false)
        $('#prj_btn_inserir').prop('disabled', false);
        $('#prj_btn_novo').prop('disabled', true);
        $('#prj_btn_atualizar').prop('disabled', true);
    }
    else {
        $('#addProjeto').empty();
        limpaCamposProjeto(false);
    }
});

/*
 * para inserir um novo contrato
 */
$('#form_inserir_alterar_projeto').on('submit', function () {
    /*
     * atribui as variaveis
     */
    dataPost = variaveisFormProjeto($('#prj_acao').val());
    /*
     * confere o captcha
     */
    if ($('#fmiapro-txt-captcha').val().length < 4) {
        swal({
            title: "Alerta",
            text: "As letras da imagem est&atilde;o diferentres do que foi digitado.",
            type: "error",
            html: true,
            confirmButtonText: "Vou corrigir, obrigado!"});
    }
    else if ($('#prj_id_contrato').val() == null || $('#prj_id_contrato').val() == 0) {
        swal({
            title: "Alerta",
            text: "Voc&ecirc; deve selecionar um contrato ou ter no m&iacute;nimo um ativo. Entre em contato com o administrador do sistema.",
            type: "error",
            html: true,
            confirmButtonText: "Vou verificar, obrigado!"});
    }
    else if (!($('#prj_id_gerente_projeto').prop('disabled')) && $('#prj_id_gerente_projeto').val() < 1) {
        swal({
            title: "Alerta",
            text: "Voc&ecirc; deve inserir um gerente para o projeto.",
            type: "error",
            html: true,
            confirmButtonText: "Vou verificar, obrigado!"});
    }
    else {
        $.post('/pf/DIM.Gateway.php', dataPost, function (data) {
            if (data.id > 0) {
                swal({
                    title: "Informa&ccedil;&atilde;o",
                    text: data.msg,
                    type: "success",
                    html: true,
                    confirmButtonText: "Obrigado!"});
                if (dataPost.acao === 'inserir') {
                    $('#prj_btn_inserir').prop('disabled', true);
                    $('#prj_btn_novo').prop('disabled', false);
                    $('#prj_btn_atualizar').prop('disabled', false);
                    $('#prj_id').val(data.id);
                    $('#prj_acao').val('alterar');
                }
                $('#prj_img_captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
                $('#prj_captcha').val('');
                atualizaTabelaProjetoContrato($('#prj_id_contrato').val());
            }
        }, 'json');
    }
    return false;
});

//clique no botao para fechar a janela do cliente
$('#fechar_projeto').on('click', function () {
    limpaCamposProjeto(true);
    return true;
});

//clique no botao fechar limpa todos os campos
$('#prj_btn_fechar').on('click', function () {
    limpaCamposProjeto(true);
    return true;
});

//clique no botao para inserir um novo cliente
$('#prj_btn_novo').on('click', function () {
    limpaCamposProjeto(false);
    return true;
});

$('#prj_id_contrato').on('change', function () {
    limpaCamposProjeto(false);
    atualizaTabelaProjetoContrato($(this).val());
});

function atualizaTabelaProjetoContrato(id) {
    if (id != 0) {
        iWait('w_id_contrato', true);
        $.post('/pf/DIM.Gateway.php', {'i': id, 't': 0, 'arq': 70, 'tch': 1, 'sub': 0, 'dlg': 1}, function (data) {
            $('#addProjeto').empty();
            for (x = 0; x < data.length; x++) {
                addLinhaProjeto(
                        data[x].id,
                        data[x].isAtivo,
                        data[x].dataInicio,
                        data[x].dataFim,
                        data[x].descricao);
            }
            iWait('w_id_projeto', false);
            $('#prj_is_ativo').bootstrapToggle('enable');
        }, 'json');
    }
}
/**
 * 
 * @param {type} i1
 * @param {type} i2
 * @param {type} i3
 * @param {type} i4
 * @param {type} i5
 * @returns {undefined}
 */
function addLinhaProjeto(i1, i2, i3, i4, i5) {
    var t = $('#addProjeto').get(0); //tabela
    var r = t.insertRow(-1); //linha
    var c1 = r.insertCell(0); //id + descricao
    var c2 = r.insertCell(1); //isAtivo
    var c3 = r.insertCell(2); //dataInicio
    var c4 = r.insertCell(3); //dataFim
    var vChecked = i2 === 'on' ? 'checked' : '';

    c1.innerHTML = '<a href="#" onclick="exibeProjetoAlteracao(' + i1 + ');">' + i5 + '</a>';
    c2.innerHTML = i3;
    c3.innerHTML = i4;
    c4.innerHTML = '<input onchange="alteraStatusProjeto($(this).val(), $(this).prop(\'checked\'));" value="' + i1 + '" type="checkbox" data-toggle="toggle" data-width="80" data-onstyle="success" data-style="slow" data-on="Ativo" data-off="Inativo" class="datatoggle" ' + vChecked + '>';
    /*
     * inicializacao manual dos datatoggles
     */
    $('.datatoggle').bootstrapToggle();
}

/**
 * 
 * @param {type} t - limpar ou nao a tabela (caso seja os botoes fechar, limpa as tabelas)
 * @returns {undefined}
 */
function limpaCamposProjeto(t) {
    $('#prj_acao').val('inserir');
    $('#prj_id').val(''); //depois que inserir este campo armazena o id recem gerado para atualizacoes
    $('#prj_descricao').val('');
    $('#prj_data_inicio').val('');
    $('#prj_data_fim').val('');
    $('#prj_is_ativo').bootstrapToggle('on');
    $('#prj_btn_novo').prop('disabled', true);
    $('#prj_btn_inserir').prop('disabled', false);
    $('#prj_btn_atualizar').prop('disabled', true);//este botao fica habilitado logo apos o cadastro
    $('#prj_id_gerente_projeto').val(0);
    if (t) {
        $('#prj_captcha').val('');
        $('#fmiapro-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
        $('#fmiapro-i-captcha').removeClass('fa-check-circle').addClass('fa-dot-circle-o');
        $('#addProjeto').empty();
        $('#prj_id_contrato').empty().prop('disabled', true);
        $('#prj_id_cliente').val(0);
    }
    dataFormProjeto = {};
}

//cria o objeto dataFormCliente com as informacoes preenchidas no formulario
function variaveisFormProjeto(acao) {
    dataFormProjeto = {
        'acao': acao,
        'id_contrato': $('#prj_id_contrato').val(),
        'id': $('#prj_id').val(),
        'descricao': $('#prj_descricao').val(),
        'is_ativo': $('#prj_is_ativo').prop('checked') ? 1 : 0,
        'data_inicio': $('#prj_data_inicio').val(),
        'data_fim': $('#prj_data_fim').val(),
        'id_gerente_projeto': $('#prj_id_gerente_projeto').prop('disabled') ? 0 : $('#prj_id_gerente_projeto').val(),
        'arq': 48, 'tch': 0, 'sub': 0, 'dlg': 1};
    return dataFormProjeto;
}

function exibeProjetoAlteracao(id) {
    $.post('/pf/DIM.Gateway.php', {'i': id, 't': 1, 'arq': 70, 'tch': 1, 'sub': 0, 'dlg': 1}, function (data) {
        $('#prj_acao').val('alterar');
        $('#prj_id').val(id);
        $('#prj_descricao').val(data[0].descricao);
        $('#prj_data_inicio').val(data[0].dataInicio);
        $('#prj_data_fim').val(data[0].dataFim);
        $('#prj_is_ativo').bootstrapToggle(data[0].isAtivo);
        $('#prj_btn_novo').prop('disabled', false);
        $('#prj_btn_inserir').prop('disabled', true);
        $('#prj_btn_atualizar').prop('disabled', false);
        $('#prj_id_gerente_projeto').val(data[0].idGerenteProjeto);
    }, 'json');
}

function alteraStatusProjeto(id, prop) {
    iWait('w_projeto_status', true);
    /*
     * sincroniza os datatoggles em caso de clicar para alterar e clicar para inativar/ativar
     */
    if ($('#prj_id').val() !== '' && $('#prj_id').val() === id) {
        $('#prj_is_ativo').bootstrapToggle('enable').bootstrapToggle(prop ? 'on' : 'off').bootstrapToggle('disable');
    }
    $.post('/pf/DIM.Gateway.php', {'i': id, 'p': prop ? 1 : 0,
        'arq': 73, 'tch': 0, 'sub': 0, 'dlg': 1}, function (data) {
        if (!(data.status)) {
            gravaLogAuditoria(emailLogado, userRole, 'alterar-status-projeto;' + ("000000000" + idEmpresa).slice(-9));
        }
        iWait('w_projeto_status', false);
    }, 'json');
}