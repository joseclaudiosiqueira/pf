function consultaFuncaoTransacaoBaseline(i, b) {
    $.post("/pf/DIM.Gateway.php", {'i': i, 'b': b,
        'arq': 44,
        'tch': 1,
        'sub': -1,
        'dlg': 1},
    function (data) {
        var pfa = Number(data[0].pfa);
        var pfb = Number(data[0].pfb);
        //insere as outras informacoes
        $('#transacao_id').val(ac == 'al' ? data[0].id : 0);
        $('#transacao_td').val(data[0].td);
        $('#transacao_ar').val(data[0].ar);
        $('#transacao_complexidade').val(data[0].complexidade);
        $('#transacao_fonte').val(data[0].fonte);
        $('#transacao_metodo').val(data[0].id_metodo);
        $('#id_fator_tecnologia').val(data[0].idFatorTecnologia);
        $('#valor_fator_tecnologia').html(parseFloat(data[0].valorFatorTecnologia).toFixed(3));
        //verifica antes para nao alterar o pfa
        verificaMetodo('transacao', $('#transacao_metodo'), $('#transacao_id_roteiro'), $('#transacao_operacao'));
        //depois
        $('#transacao_pfb').val(pfb.toFixed(4));
        //sob analise se coloca ou nao o ajustado neste momento
        //$('#transacao_pfa').val(pfa.toFixed(4));
        $('#transacao_impacto').val(0);
        $('#transacao_observacoes').val(data[0].obs_funcao);
        $('#transacao_observacoes_validacao').val(data[0].obs_validar);
        //descricao dos arquivos referenciados
        arrAR = data[0].descricaoAR;
        //limpa as descricoes
        jQuery("#transacao_descricao_ar").tagsManager('empty');
        for (x = 0; x < arrAR.length; x++) {
            jQuery("#transacao_descricao_ar").tagsManager('pushTag', arrAR[x]);
        }
        //descricao dos TD
        arrTD = data[0].descricaoTD;
        //limpa as descricoes
        jQuery("#transacao_descricao_td").tagsManager('empty');
        for (x = 0; x < arrTD.length; x++) {
            jQuery("#transacao_descricao_td").tagsManager('pushTag', arrTD[x]);
        }
        /*
         * preenche as informacoes data-content para os detalhes do item
         */
        detalheItem(data[0].selImpacto, 'transacao');
        /*
         * habilita mudanca
         */
        if ($('#transacao_operacao').val() === 'A' || $('#transacao_operacao').val() === 'E') {
            $('#transacao-is-mudanca').bootstrapToggle('enable').bootstrapToggle('off');
        }
        /*
         * coloca o disabled caso nao possa alterar
         */
        $('.tm-tag-remove').css({'visibility': (!isAutorizadoAlterar ? 'hidden' : 'visible')});

    }, 'json');
}
/**
 * api para as funcoes de transacao
 * retornaFuncaoTrancacao()
 * insereFuncaoTrancacao() (banco) que chama insereLinhaTrancacao() (tela/tabela)
 * 
 */
function retornaFuncaoTransacao(i, b, q, p, n) {
    //primeiro de tudo
    //muda a variavel acForms para alterar
    acForms = 'al';
    //muda a variavel fAtual
    fAtual = b;
    //TODO: verificar quando for contagem de Baseline se ha refencias da funcao
    //nao pode alterar direto na baseline    
    $.post("/pf/DIM.Gateway.php", {'i': i, 'b': b,
        'arq': 44,
        'tch': 1,
        'sub': -1,
        'dlg': 1},
    function (data) {
        $("#form_modal_funcao_transacao").modal('toggle');
        /*
         * i = id da funcao
         * b = tabela EE/SE/CE
         * q = atdAtual de linhas
         * p = Pontos de Funcao Ajustados PFa
         * n = id do botao btnEdit
         */
        if (b === 'EE') {
            $('#cabecalho_funcao').val(title_ee_alt);
            $("#transacao_h4-modal").html(title_ee_alt);
            $('#transacao_tabela').val('EE');
        }
        else if (b === 'SE') {
            $('#cabecalho_funcao').val(title_se_alt);
            $("#transacao_h4-modal").html(title_se_alt);
            $("#transacao_tabela").val("SE");
        }
        else if (b === 'CE') {
            $('#cabecalho_funcao').val(title_ce_alt);
            $("#transacao_h4-modal").html(title_ce_alt);
            $('#transacao_tabela').val('CE');
        }
        /*
         * insere as outras informacoes
         */
        $('#transacao_qtd_atual').val(q);
        $('#transacao_id').val(i);
        $('#transacao_id_roteiro').val(data[0].id_roteiro);
        /*
         * se for uma linha de baseline com roteiro id = 3 Dimension, tem que liberar a combo
         */
        idRoteiro = data[0].id_roteiro;
        idRoteiro == 3 ? $('#transacao_id_roteiro').prop('disabled', false) : $('#transacao_id_roteiro').prop('disabled', true);
        //segue vida
        $('#transacao_operacao').val(data[0].operacao);
        $('#transacao_metodo').val(data[0].id_metodo);
        $('#transacao_entrega').val(data[0].entrega).mask('00').TouchSpin({
            min: 1,
            max: $('#entregas').val(),
            step: 1,
            boostat: 5,
            maxboostedstep: 10,
            postfix: ''
        }).prop('readonly', true);
        /*
         * muda o botao de selecao da operacao e do metodo
         */
        verificaOperacao('transacao', data[0].operacao, data[0].id_roteiro, data[0].selImpacto, b, acForms);
        verificaMetodo('transacao', $('#transacao_metodo'), $('#transacao_id_roteiro'), $('#transacao_operacao'));
        /*
         * nao pode converter funcao de testes em I, A ou E na alteracao
         */
        if (data[0].operacao === 'T') {
            $('#transacao_op1').prop('disabled', true);
            $('#transacao_op2').prop('disabled', true);
            $('#transacao_op3').prop('disabled', true);
            $('#transacao_me1').prop('disabled', true);
            $('#transacao_me2').prop('disabled', true);
        }
        /*
         * verifica se eh uma baseline e desabilita os metodos Nesma e FP-Lite
         */
        if (abAtual == 3) {
            $('#transacao_me1').prop('disabled', true);
            $('#transacao_me2').prop('disabled', true);
        }
        //seta a variavel global de situacao da linha
        situacaoLinha = data[0].situacao;
        //insere o valor do Fator documentacao
        $('#transacao_fd').val(data[0].fd);
        if (data[0].operacao !== 'I' && data[0].operacao !== 'T' && data[0].tipoImpacto === 'A') {
            $('#transacao_fd').prop('disabled', false);
        }
        $('#transacao_funcao').val(data[0].funcao).prop('readonly', data[0].operacao === 'T' ? true : false);
        $('#transacao_td').val(data[0].td);
        $('#transacao_ar').val(data[0].ar);
        $('#transacao_complexidade').val(data[0].complexidade);
        var pfb = Number(data[0].pfb);
        $('#transacao_pfb').val(pfb.toFixed(4));
        var pfa = Number(data[0].pfa);
        $('#transacao_pfa').val(pfa.toFixed(4));
        $('#transacao_observacoes').val(data[0].obs_funcao);
        $('#transacao_observacoes_validacao').val(data[0].obs_validar);
        $('#transacao_entrega').val(data[0].entrega);
        $('#id_fator_tecnologia').val(data[0].idFatorTecnologia);
        $('#valor_fator_tecnologia').html(parseFloat(data[0].valorFatorTecnologia).toFixed(3));
        /*
         * descricao dos tipos de registros nas tags
         */
        arrAR = data[0].descricaoAR;
        for (x = 0; x < arrAR.length; x++) {
            jQuery("#transacao_descricao_ar").tagsManager('pushTag', arrAR[x]);
        }

        arrTD = data[0].descricaoTD;
        for (x = 0; x < arrTD.length; x++) {
            jQuery("#transacao_descricao_td").tagsManager('pushTag', arrTD[x]);
        }

        $('#transacao_fonte').val(data[0].fonte);
        /*
         * verifica se foi mudanca (retrabalho)
         */
        if (data[0].isMudanca == 1) {
            $('#transacao-is-mudanca').bootstrapToggle('enable').bootstrapToggle('on');
            $('#transacao-fase').val(data[0].faseMudanca);
            $('#transacao-percentual-fase').val(data[0].percentualFase == 0 ? '' : data[0].percentualFase).prop('readonly', false);
        }
        else {
            if (data[0].operacao !== 'I' && data[0].operacao !== 'T') {
                $('#transacao-is-mudanca').bootstrapToggle('enable');
                $('#transacao-fase').val(0);
                $('#transacao-percentual-fase').val('').prop('readonly', true);
            }
            else {
                $('#transacao-is-mudanca').bootstrapToggle('off').bootstrapToggle('disable');
                $('#transacao-fase').val(0);
                $('#transacao-percentual-fase').val('').prop('readonly', true);
            }
        }
        /*
         * verifica se a acao e validar/auditar/ver e desabilita o toggle de mudanca
         */
        if (ac === 'vi' || ac === 've' || ac === 'ai' || ac === 'ae' || ac === 'vw') {
            $('#transacao-is-mudanca').bootstrapToggle(!isAutorizadoAlterar ? 'disable' : 'enable');
            $('#transacao-fase').prop('disabled', !isAutorizadoAlterar).css({'background-color': 'white'});
            $('#transacao-percentual-fase').prop('readonly', !isAutorizadoAlterar);
        }
        /*
         * atribui o valor id ao campo id-linha-descricao para capturar os valores para o ajax
         */
        $('#id-linha-descricao').val(i);
        /*
         * insere a quantidade de TDs dentro do span
         */
        $('#transacao-badge-td').html(data[0].quantidadeTD);
        (Number(data[0].quantidadeTD) > 0 && $('#transacao_metodo').val() == 3) ? $('#transacao_td').val(data[0].quantidadeTD) : null;
        /*
         * altera o valor da descricao da funcao do td para dados
         */
        $('#descricao-funcao-td').val('transacao');
        /*
         * habilita o botao para listar os itens de roteiro
         */
        $('#btn-listar-itens-transacao').prop('disabled', !1);
        /*
         * preenche as informacoes data-content para os detalhes do item
         */
        detalheItem(data[0].selImpacto, 'transacao');
        /*
         * seta o id_baseline da funcao
         */
        $('#transacao_id_funcao_baseline').val(data[0].idBaseline);
        /*
         * verifica se eh uma funcao que foi incluida na baseline por esta contagem
         * se estiver validada na baseline nao permite mais alterar por aqui
         * tem que fazer uma contagem para retrabalho ou algo do tipo
         * esta funcao nao proibe a alteracao diretamente na baseline
         */
        if (Number(data[0].idBaseline) > 0 && data[0].operacao === 'I' && Number(data[0].situacao) == 2 && !(
                ac === 'vw' || ac === 'vi' || ac === 've' || ac === 'ai' || ac === 'ae' || ac === 're')) {//funcao pertence a uma baseline
            swal({
                title: "Alerta",
                text: "A fun&ccedil;&atilde;o foi inserida nesta contagem, entretanto j&aacute; foi validada na Baseline. " +
                        "Desta forma n&atilde;o &eacute; poss&iacute;vel realizar as altera&ccedil;&otilde;es aqui. Caso seja uma altera&ccedil;&atilde;o " +
                        "solicitada por um outro projeto ou por este mesmo, inclua um novo item como A - Altera&ccedil;&atilde;o ou E - Exclus&atilde;o.",
                type: "error",
                html: true,
                confirmButtonText: "Entendi!"}, function () {
                autorizaAlteracaoCamposLinha(false, 'transacao');
            });
        }
        //e uma funcao incluida por uma contagem e nao pode ser alterada na baseline
        else if ((abAtual == 3 || abAtual == 4) && acForms === 'al' && data[0].idGerador > 0) {
            swal({
                title: "Alerta",
                text: "Esta fun&ccedil;&atilde;o foi inserida pela contagem<br />#ID: <strong>" + ("000000" + data[0].idContagem).slice(-6) + "</strong>. " +
                        "Desta forma n&atilde;o &eacute; poss&iacute;vel realizar as altera&ccedil;&otilde;es aqui.",
                type: "error",
                html: true,
                confirmButtonText: "Entendi!"}, function () {
                autorizaAlteracaoCamposLinha(false, 'transacao');
            });
        }
        else {
            /*
             * desabilita os botões inserir,inserir e fechar, e habilita o atualizar
             */
            $('#transacao_btn_if').prop('disabled', true);
            $('#transacao_btn_in').prop('disabled', true);
            $('#transacao_btn_al').prop('disabled', isAutorizadoAlterar ? false : true);
        }
        /*
         * coloca o disabled caso nao possa alterar
         */
        $('.tm-tag-remove').css({'visibility': (!isAutorizadoAlterar ? 'hidden' : 'visible')});
        /*
         * verifica se a acao eh de visualizacao e desabilita todos os campos
         */
        if (ac === 'vw' || ac === 'vi' || ac === 've' || ac === 'ai' || ac === 'ae') {
            autorizaAlteracaoCamposLinha(false, 'transacao');
        }
    }, "json");
}

/**
 * 
 * @param {type} b - botao que foi clicado - [insere e continua] ou [insere e fecha]
 * @returns {Boolean}
 */
function insereFuncaoTransacao(b) {
    /*
     * variavel que recebera os nomes dos arquivos referenciados
     */
    var arrAR = jQuery("#transacao_descricao_ar").tagsManager('tags');
    var arrTD = jQuery("#transacao_descricao_td").tagsManager('tags');
    /*
     * testa a validade das informacoes no formulario
     */
    var retorno = validaFormFuncao('transacao');
    /*
     * verifica se pode prosseguir
     */
    if (!retorno.sucesso) {
        swal({
            title: "Alerta",
            text: retorno.msg,
            type: "error",
            html: true,
            confirmButtonText: "Entendi!"},
            function () {
                return false;
            });
            return false;
    }
    else {
        /*
         * mudancas
         */
        var isMudanca = $('#transacao-is-mudanca').prop('checked') ? 1 : 0;
        var faseMudanca = $('#transacao-fase').val();
        var percentualFase = $('#transacao-percentual-fase').val();
        var operacao = $('#transacao_operacao').val();
        var transacaoFd = $('#transacao_fd').val();
        var id_fator_tecnologia = $('#id_fator_tecnologia option:selected').val();
        var valor_fator_tecnologia = ($('#id_fator_tecnologia option:selected').text()).split('-')[0];

        $.post("/pf/DIM.Gateway.php", {
            'transacao_operacao': $('#transacao_operacao').val(),
            'transacao_tabela': $('#transacao_tabela').val(),
            'transacao_metodo': $('#transacao_metodo').val(),
            'transacao_entrega': $('#transacao_entrega').val(),
            'transacao_id': idContagem,
            'transacao_qtd_atual': $('#transacao_qtd_atual').val(),
            'transacao_id_roteiro': $('#transacao_id_roteiro').val(),
            'transacao_funcao': (abAtual == 2 && (operacao === 'A' || operacao === 'E' || operacao === 'T')) ?
                    $('#transacao_funcao').find('option:selected').text().split(' > ')[5] :
                    $('#transacao_funcao').val(),
            'transacao_td': $('#transacao_td').val(),
            'transacao_ar': $('#transacao_ar').val(),
            'transacao_complexidade': $('#transacao_complexidade').val(),
            'transacao_pfb': $('#transacao_pfb').val(),
            'transacao_impacto': $('#transacao_impacto').val(),
            'transacao_pfa': $('#transacao_pfa').val(),
            'transacao_observacoes': $('#transacao_observacoes').val(),
            'transacao_observacoes_validacao': $('#transacao_observacoes_validacao').val(),
            'transacao_fonte': $('#transacao_fonte').val(),
            'transacao_descricao_td': arrTD,
            'transacao_descricao_ar': arrAR,
            'is_mudanca': isMudanca,
            'fase_mudanca': faseMudanca,
            'percentual_fase': percentualFase,
            'funcao_id_baseline': (abAtual == 2 && (operacao === 'A' || operacao === 'E' || operacao === 'T')) ?
                    $('#transacao_funcao').children(':selected').val() : 0,
            'transacao_fd': transacaoFd,
            'abrangencia_atual': abAtual,
            'contagem_id_baseline': abAtual == 2 ? $('#contagem_id_baseline').children(':selected').val() : 0,
            'id_fator_tecnologia': id_fator_tecnologia,
            'valor_fator_tecnologia': valor_fator_tecnologia,
            'arq': 28,
            'tch': 0,
            'sub': -1,
            'dlg': 1
        },
        function (data) {
            if (Number(data[0].id) > 0) {
                var table = document.getElementById('add' + data[0].tabela);
                var row = table.insertRow(-1);
                var pfb = Number(data[0].pfb);
                var pfa = Number(data[0].pfa);
                /*
                 * insere os valores de retorno na tabela Add+table
                 */
                insereLinha(
                        data[0].id,
                        data[0].tabela,
                        row,
                        data[0].operacao,
                        data[0].funcao,
                        data[0].td,
                        data[0].ar,
                        data[0].complexidade,
                        pfb.toFixed(4),
                        data[0].siglaFator,
                        pfa.toFixed(4),
                        data[0].obsFuncao,
                        data[0].situacao,
                        data[0].entrega,
                        0,
                        0, //comentarios qtd
                        false, //desenha os graficos
                        isMudanca,
                        faseMudanca,
                        percentualFase,
                        transacaoFd,
                        0,
                        0);
            }
            else {
                swal({
                    title: "Alerta",
                    text: _ERR_INSERCAO,
                    type: "error",
                    html: true,
                    confirmButtonText: "Entendi!"},
                function () {
                    return false;
                });
            }
        }, "json");
        limpaCampos('transacao');
        return true;
    }
}

function alteraFuncaoTransacao(b) {
    /*
     * testa a validade das informacoes no formulario
     */
    var retorno = validaFormFuncao('transacao');
    /*
     * guarda a situacao atual da linha
     */
    var situacaoAtual = situacaoLinha == 3 ? 3 : (situacaoLinha == 4 ? 3 : (abAtual == 3 || abAtual == 4 ? 2 : 1));
    /*
     * verifica se pode prosseguir
     */
    if (!retorno.sucesso) {
        swal({
            title: "Alerta",
            text: retorno.msg,
            type: "error",
            html: true,
            confirmButtonText: "Entendi!"});
        return false;
    }
    else {
        /*
         * mudancas
         */
        var isMudanca = $('#transacao-is-mudanca').prop('checked') ? 1 : 0;
        var faseMudanca = $('#transacao-fase').val();
        var percentualFase = $('#transacao-percentual-fase').val();
        var transacaoFd = $('#transacao_fd').val();
        var id_fator_tecnologia = $('#id_fator_tecnologia option:selected').val();
        var valor_fator_tecnologia = $('#valor_fator_tecnologia').html();

        var arrAR = jQuery("#transacao_descricao_ar").tagsManager('tags'); //variavel que recebera os nomes dos arquivos referenciados
        var arrTD = jQuery("#transacao_descricao_td").tagsManager('tags');

        $.post("/pf/DIM.Gateway.php", {
            'transacao_operacao': $('#transacao_operacao').val(),
            'transacao_tabela': $('#transacao_tabela').val(),
            'transacao_metodo': $('#transacao_metodo').val(),
            'transacao_entrega': $('#transacao_entrega').val(),
            'transacao_id': $('#transacao_id').val(),
            'transacao_qtd_atual': $('#transacao_qtd_atual').val(),
            'transacao_id_roteiro': $('#transacao_id_roteiro').val(),
            'transacao_funcao': $('#transacao_funcao').val(),
            'transacao_td': $('#transacao_td').val(),
            'transacao_ar': $('#transacao_ar').val(),
            'transacao_complexidade': $('#transacao_complexidade').val(),
            'transacao_pfb': $('#transacao_pfb').val(),
            'transacao_impacto': $('#transacao_impacto').val(),
            'transacao_pfa': $('#transacao_pfa').val(),
            'transacao_observacoes': $('#transacao_observacoes').val(),
            'transacao_observacoes_validacao': $('#transacao_observacoes_validacao').val(),
            'transacao_fonte': $('#transacao_fonte').val(),
            'transacao_descricao_ar': arrAR,
            'transacao_descricao_td': arrTD,
            'is_mudanca': isMudanca,
            'fase_mudanca': faseMudanca,
            'percentual_fase': percentualFase,
            'contagem_id_baseline': $('#contagem_id_baseline option:selected').val(),
            'situacao': situacaoAtual,
            'transacao_fd': transacaoFd,
            'funcao_id_baseline': $('#transacao_id_funcao_baseline').val(),
            'acao_forms': acForms,
            'abrangencia_atual': abAtual,
            'id_contagem': idContagem,
            'id_fator_tecnologia': id_fator_tecnologia,
            'valor_fator_tecnologia':valor_fator_tecnologia,
            'arq': 7,
            'tch': 0,
            'sub': -1,
            'dlg': 1
        },
        function (data) {
            if (Number(data.id) > 0) {
                var qtdAtual = $('#transacao_qtd_atual').val();
                var tabela = data.tabela;
                var pfa = Number(data.pfa);
                var pfb = Number(data.pfb);
                var pfan = Number(data.pfan);
                var pfbn = Number(data.pfbn);
                var obsFuncao = data.obsFuncao;
                /*
                 * verifica a operacao para escrever o label
                 */
                var oper = divOperacao(data.operacao);
                $("#oper_" + tabela + "_" + qtdAtual).html(oper);
                $("#funcao_" + tabela + "_" + qtdAtual).html(data.funcao);
                $("#td_" + tabela + "_" + qtdAtual).html(data.td);
                $("#tr_" + tabela + "_" + qtdAtual).html(data.tr);
                $("#complexidade_" + tabela + "_" + qtdAtual).html(data.complexidade);
                $("#pfb_" + tabela + "_" + qtdAtual).html(pfb.toFixed(4));
                /*
                 * verifica se eh uma alteracao ou exclusao e define o processo de mudanca
                 */
                var c = '';
                var t = '';
                if (data.operacao === 'A' || data.operacao === 'E') {
                    if (data.isMudanca == 1) {
                        c = '<small><br />Retrabalho: ' + data.faseMudanca + ' - ' + data.percentualFase + '%</small>';
                    }
                }
                //verifica se tem fator de documentacao
                if (Number(transacaoFd) > 0) {
                    t = (data.isMudanca ? '&nbsp;&nbsp;&nbsp;' : '<br />') + '<small>FD: ' + parseFloat(transacaoFd).toFixed(2) + '</small>';
                }

                $("#siglaFator_" + tabela + "_" + qtdAtual).html(data.siglaFator + (data.isMudanca ? c : '') + t);
                $("#pfa_" + tabela + "_" + qtdAtual).html(pfa.toFixed(4));
                $("#ent_" + tabela + "_" + qtdAtual + "_" + data.id).html(data.entrega);
                $("#obs_" + tabela + "_" + qtdAtual).html(obsFuncao);
                //obrigatoriamente muda para nao validada
                setSituacao(situacaoAtual, 'cell1_' + tabela + '_' + $('#transacao_id').val());
                //estatisticas
                recalculaEstatisticas(pfa, pfb, tabela, 'alterar', pfan, pfbn, true);
                //finaliza a operacao com sucesso
                swal("Dimension", "O registro foi alterado com sucesso!", "success");
                $('#form_modal_funcao_transacao').modal('toggle');
                limpaCampos('transacao');
            }
            else {
                swal({
                    title: "Alerta",
                    text: data.msg,
                    type: "error",
                    html: true,
                    confirmButtonText: "Entendi!"}, function () {
                    $('#form_modal_funcao_transacao').modal('toggle');
                    limpaCampos('transacao');
                });
            }
        }, "json");
    }
}

/*
 * chama a funcao que atualiza o array com src item para pesquisa em arquivos referenciados
 * PAT - Pesquisa nos arquivos atuais da contagem
 * PAB - Pesquisa nos arquivos da baseline
 * PAP - Pesquisa nos arquivos dos projetos do cliente atual
 * PAV - Pesquisa nos arquivos de contagens avulsas do cliente atual
 */
$("#chk_pesq_atual").on("change", function () {
    atualizaItensArquivosReferenciados($(this), 'PAT');
});
$("#chk_pesq_baseline").on("change", function () {
    atualizaItensArquivosReferenciados($(this), 'PAB');
});
$("#chk_pesq_projeto").on("change", function () {
    atualizaItensArquivosReferenciados($(this), 'PAP');
});
$("#chk_pesq_avulsa").on("change", function () {
    atualizaItensArquivosReferenciados($(this), 'PAV');
});