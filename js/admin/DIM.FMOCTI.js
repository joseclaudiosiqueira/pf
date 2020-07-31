/*
 * ATENCAO: esta neste formulario mas serve tanto para configuracao administrativa quanto para leitura na tab_inicio
 */
$('.fmocti-link').on('click', function () {
    var idCliente = Number($('#contagem_id_cliente option:selected').val());
    if (idCliente > 0) {
        //na tela de cadastro de contagens retira tudo e deixa apenas a selecao
        $('#col-tabela-2').remove();
        $('#fmocti-modal').removeClass('modal-lg');
        $('#fmocti-footer').remove();
        $('#col-tabela-1').removeClass('col-md-7').addClass('col-md-12');
        //verifica se ha um cliente selecionado
        if (ac !== 'in' || abAtual == 3 || abAtual == 4) {
            swal({title: "Alerta",
                text: 'Para inserir uma configuração inicial de cadastro de contagens é necessário que seja selecionado o Cliente, ação não pode ser de alteração e a contagem não pode ser Baseline ou Licitação.',
                type: "warning",
                html: true
            });
            return false;
        }
        else {
            $('#form_modal_configuracoes_tab_inicio').modal('show');
            atualizaTabelaConfiguracoes(idCliente);
        }
    }
    else {
        if (isFornecedor) {
            comboCliente('fmocti', idCliente, '0', idFornecedor);
            comboLinguagem('01', 0, $('#fmocti_id_linguagem'), idCliente);
            comboBancoDados('01', 0, $('#fmocti_id_banco_dados'), idCliente);
        } else {
            comboCliente('fmocti', 0, '0', 0);
        }
        comboTipoContagem('01', 0, $('#fmocti_id_tipo_contagem'));
        comboEtapa('01', 0, $('#id_etapa'));
        comboProcesso('01', 0, $('#fmocti_id_processo'));
        comboEtapa('01', 0, $('#fmocti_id_etapa'));
        comboIndustria('01', 0, $('#fmocti_id_industria'));
        comboProcessoGestao('01', 0, $('#fmocti_id_processo_gestao'));
        //exibe e chama a funcao sem nada de parametro idCliente = 0
        $('#form_modal_configuracoes_tab_inicio').modal('show');
        atualizaTabelaConfiguracoes(0);
    }
});
/*
 * captura as mudancas nos combos
 */
$("#fmocti_id_cliente").on("change", function () {
    sel = $("#fmo_id_contrato");
    sel.empty().append('<option value="0">...</option>');
    sel = $("#fmocti_id_projeto");
    sel.empty().append('<option value="0">...</option>');
    if ($(this).val() > 0) {
        comboContrato($(this).val(), '01', 0, 0, 'fmocti');
        comboOrgao('01', 0, $(this).val(), $('#fmocti_id_orgao'));
        comboLinguagem('01', 0, $('#fmocti_id_linguagem'), $(this).val());
        comboBancoDados('01', 0, $('#fmocti_id_banco_dados'), $(this).val());

    }
});

$("#fmocti_id_contrato").on("change", function () {
    sel = $("#fmocti_id_projeto");
    sel.empty().append('<option value="0">...</option>');
    if ($(this).val() > 0) {
        comboProjeto($(this).val(), '01', 0, 'fmocti');
    }
});
/*
 * adiciona uma linha sem muitas conferencias
 */
$('#btn-adicionar-configuracao-tab-inicio').on('click', function () {
    var idCliente = $('#fmocti_id_cliente option:selected').val();
    var idContrato = $('#fmocti_id_contrato option:selected').val();
    var idProjeto = $('#fmocti_id_projeto option:selected').val();
    var idOrgao = $('#fmocti_id_orgao option:selected').val();
    var ordemServico = $('#fmocti_ordem_servico').val();
    var idLinguagem = $('#fmocti_id_linguagem option:selected').val();
    var idBancoDados = $('#fmocti_id_banco_dados option:selected').val();
    var idTipo = $('#fmocti_id_tipo_contagem option:selected').val();
    var idEtapa = $('#fmocti_id_etapa option:selected').val();
    var idIndustria = $('#fmocti_id_industria option:selected').val();
    var idProcesso = $('#fmocti_id_processo option:selected').val();
    var idProcessoGestao = $('#fmocti_id_processo_gestao option:selected').val();
    var proposito = $('#fmocti_proposito').val();
    var escopo = $('#fmocti_escopo').val();
    if (idCliente == 0 ||
            idContrato == 0 ||
            idProjeto == 0 ||
            idOrgao == 0 ||
            idLinguagem == 0 ||
            idBancoDados == 0 ||
            idTipo == 0 ||
            idEtapa == 0 ||
            idIndustria == 0 ||
            idProcesso == 0 ||
            idProcessoGestao == 0) {
        swal({title: "Alerta",
            text: 'Para inserir uma configuração inicial de cadastro de contagens, todos os campos são <strong>obrigatórios</strong>',
            type: "error",
            html: true
        });
    }
    else {
        $.post('/pf/DIM.Gateway.php', {
            'idf': isFornecedor ? idFornecedor : 0,
            'idc': idCliente,
            'idr': idContrato,
            'idj': idProjeto,
            'ido': idOrgao,
            'ors': ordemServico,
            'idl': idLinguagem,
            'idb': idBancoDados,
            'idt': idTipo,
            'ide': idEtapa,
            'idi': idIndustria,
            'idp': idProcesso,
            'idg': idProcessoGestao,
            'pro': proposito,
            'esc': escopo,
            'arq': 91,
            'tch': 0,
            'sub': 0,
            'dlg': 0
        }, function (data) {
            if (data.sucesso) {
                swal({title: "Informação",
                    text: data.msg,
                    type: "success",
                    html: true
                });
                atualizaTabelaConfiguracoes(0);
            }
            else {
                swal({title: "Alerta",
                    text: data.msg,
                    type: "error",
                    html: true
                });
            }
        }, 'json');
    }
});

function atualizaTabelaConfiguracoes(idc) {
    $.post('/pf/DIM.Gateway.php', {
        'idc': idc,
        'arq': 96,
        'tch': 1,
        'sub': 0,
        'dlg': 1}, function (data) {
        var tabela = $('#addConfiguracoesTabInicio').empty().get(0);
        var row;
        for (x = 0; x < data.length; x++) {
            row = tabela.insertRow(-1);
            var cell0 = row.insertCell(0);//imagens
            var cell1 = row.insertCell(1);//descricoes
            var cell2 = row.insertCell(2);//acoes
            //propriedades das celulas 1 e 2
            if ($('#contagem_id_cliente').length > 0) {
                cell0.setAttribute('width', '45%');
                cell1.setAttribute('width', '45%');
                cell2.setAttribute('width', '10%');
            }
            else {
                cell0.setAttribute('width', '35%');
                cell1.setAttribute('width', '55%');
                cell2.setAttribute('width', '10%');
            }
            //adiciona nas celulas
            cell0.setAttribute('align', 'center');
            cell0.innerHTML = data[x].linguagem +
                    '&nbsp;<i class="fa fa-plus-circle fa-lg"></i>&nbsp;' +
                    data[x].bancoDados +
                    '&nbsp;<i class="fa fa-plus-circle fa-lg"></i>&nbsp;' +
                    data[x].gestao;
            cell1.innerHTML = '[<strong>Cliente</strong>: ' + data[x].cliente + '] ' +
                    '[<strong>Contrato</strong>: ' + data[x].contrato + '] ' +
                    '[<strong>Projeto</strong>: ' + data[x].projeto + '] ' +
                    '[<strong>Órgão</strong>: ' + data[x].orgao + '] ' +
                    '[<strong>Banco de Dados</strong>: ' + data[x].bancoDadosDescricao + '] ' +
                    '[<strong>Ordem de Serviço</strong>: ' + data[x].ordemServico + '] ' +
                    '[<strong>Tipo de contagem</strong>: ' + data[x].tipo + '] ' +
                    '[<strong>Etapa</strong>: ' + data[x].etapa + '] ' +
                    '[<strong>Área de atuação</strong>: ' + data[x].atuacao + '] ' +
                    '[<strong>Processo</strong>: ' + data[x].processo + ']';
            cell2.innerHTML = $('#contagem_id_cliente').length > 0 ?
                    '<button type="button" class="btn btn-success btn-block" onclick="alteraIdsTabInicio(' + data[x].id + ');"><i class="fa fa-check-circle"></i>&nbsp;Utilizar</button>' :
                    '<button type="button" class="btn btn-warning btn-block" onclick="excluirLinhaConfiguracao(' + data[x].id + ');"><i class="fa fa-trash"></i>&nbsp;Excluir</button>';
        }
    }, 'json');
}

function excluirLinhaConfiguracao(i) {
    swal({
        title: "Tem certeza?",
        text: "Ap&oacute;s a exclus&atilde;o da linha as informa&ccedil;&otilde;es n&atilde;o poder&atilde;o ser recuperadas",
        type: "warning",
        html: true,
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sim",
        closeOnConfirm: true
    }, function () {
        $.post('/pf/DIM.Gateway.php', {
            'idc': i,
            'arq': 92,
            'tch': 0,
            'sub': 0,
            'dlg': 0
        }, function (data) {
            if (data.sucesso) {
                atualizaTabelaConfiguracoes(0);
                return true;
            }
        }, 'json');
    });
}

function alteraIdsTabInicio(i) {
    $.post('/pf/DIM.Gateway.php', {
        'idc': i,
        'arq': 97,
        'tch': 1,
        'sub': 0,
        'dlg': 0
    }, function (data) {
        //verificacao se eh uma contagem de auditoria com a flag especial
        //precisa selecionar todos os contratos da organizacao pai
        $("#contagem_id_contrato option[value='" + data.id_contrato + "']").attr("selected", "selected");
        /*
         * Pegar os valores HPC e HPA sempre que alterar o contrato
         */
        getValorHora(data.id_contrato); //_tab_estatisticas.js
        //verifica se eh auditoria e coloca todos os contratos do cliente
        if (Number(isContagemAuditoria) == 1) {
            comboProjeto(data.id_contrato, '01', data.id_projeto, 'contagem', 1);
        }
        else {
            comboProjeto(data.id_contrato, '01', data.id_projeto, 'contagem');
        }
        //coloca o gerente de qualquer forma
        getGerenteProjeto(data.id_projeto);
        $("#id-orgao").val(data.id_orgao).change();
        $('#ordem_servico').val(data.ordem_servico);
        $("#id_linguagem").val(data.id_linguagem).change();
        $("#id_tipo_contagem").val(data.id_tipo).change();
        $("#id_banco_dados").val(data.id_banco_dados).change();
        $("#id_industria").val(data.id_area_atuacao).change();
        $("#id_processo").val(data.id_processo).change();
        $("#id_processo_gestao").val(data.id_processo_gestao).change();
        $("#id_etapa").val(data.id_etapa).change();
        idEtapa = data.id_etapa;
        //verifica se a etapa eh tres - indicativa e desabilita outros botoes
        if (data.id_etapa == 3) {
            $('#li-ee').addClass('disabled');
            $('#li-se').addClass('disabled');
            $('#li-ce').addClass('disabled');
            $('#li-ou').addClass('disabled');
            $('#btn-pesquisar-ali').prop('disabled', true);
            $('#btn-pesquisar-aie').prop('disabled', true);
            $('#btn_adicionar_ali').prop('disabled', true);
            $('#btn_adicionar_aie').prop('disabled', true);
        }
        else {
            $('#li-ee').removeClass('disabled');
            $('#li-se').removeClass('disabled');
            $('#li-ce').removeClass('disabled');
            $('#li-ou').removeClass('disabled');
            $('#btn-pesquisar-ali').prop('disabled', false);
            $('#btn-pesquisar-aie').prop('disabled', false);
            $('#btn_adicionar_ali').prop('disabled', false);
            $('#btn_adicionar_aie').prop('disabled', false);
        }
        $('#proposito').val(data.proposito);
        $('#escopo').val(data.escopo);
    }, 'json');
    //oculta a janela
    $('#form_modal_configuracoes_tab_inicio').modal('hide');
}