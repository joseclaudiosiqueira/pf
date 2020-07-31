function consultaFuncaoOutrosBaseline(i, b) {
    $.post("/pf/DIM.Gateway.php", {'i': i, 'b': b,
        'arq': 43,
        'tch': 1,
        'sub': -1,
        'dlg': 1
    },
    function (data) {
        var pfa = Number(data[0].pfa);
        $('#outros_id').val(ac == 'al' ? data[0].id : 0);
        $('#outros_entrega').val(data[0].entrega).mask('00').TouchSpin({
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
        //verificaOperacao('outros', data[0].operacao, data[0].id_roteiro, data[0].selImpacto, b, ac);

        $('#outros_qtd').val(data[0].qtd);
        $('#outros_fonte').val(data[0].fonte);
        $('#outros_pfa').val(pfa.toFixed(4));
        $('#outros_impacto').val(data[0].selImpacto);
        $('#outros_observacoes').val(data[0].obs_funcao);
        $('#outros_observacoes_validacao').val(data[0].obs_validar);
        /*
         * preenche as informacoes data-content para os detalhes do item
         */
        detalheItem(data[0].selImpacto, 'outros');

    }, 'json');
}
/**
 * api para as funcoes de outras(os)
 * retornaFuncaoOutros()
 * insereFuncaoOutros() (banco) que chama insereLinhaOutros() (tela/tabela)
 * 
 */
function retornaFuncaoOutros(i, b, q, p, n) {
    //primeiro de tudo
    //muda a variavel acForms para alterar
    acForms = 'al';
    //muda a variavel fAtual
    fAtual = b;
    //TODO: verificar quando for contagem de Baseline se ha refencias da funcao
    //nao pode alterar direto na baseline
    $.post("/pf/DIM.Gateway.php", {'i': i, 'b': b,
        'arq': 43,
        'tch': 1,
        'sub': -1,
        'dlg': 1},
    function (data) {
        $("#form_modal_funcao_outros").modal('toggle');
        /*
         * i = id da funcao
         * b = tabela OU
         * q = atdAtual de linhas
         * p = Pontos de Funcao Ajustados PFa
         * n = id do botao btnEdit
         */
        $('#cabecalho_funcao').val(title_ou_alt);
        $("#outros_h4-modal").html(title_ou_alt);
        $('#outros_tabela').val('OU');
        /*
         * insere as outras informacoes
         */
        $('#outros_qtd_atual').val(q);
        $('#outros_id').val(i);
        $('#outros_id_roteiro').val(data[0].id_roteiro);
        $('#outros_operacao').val(data[0].operacao);
        $('#outros_entrega').val(data[0].entrega).mask('00').TouchSpin({
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
        verificaOperacao('outros', data[0].operacao, data[0].id_roteiro, data[0].selImpacto, b, ac);
        //seta a variavel global de situacao da linha
        situacaoLinha = data[0].situacao;

        $('#outros_funcao').val(data[0].funcao);
        //(abAtual == 2 && data[0].operacao === 'I') ? data[0].idBaseline : data[0].funcao);
        $('#outros_qtd').val(data[0].qtd);
        $('#outros_fonte').val(data[0].fonte);

        var pfa = Number(data[0].pfa);
        $('#outros_pfa').val(pfa.toFixed(4));

        $('#outros_observacoes').val(data[0].obs_funcao);
        $('#outros_observacoes_validacao').val(data[0].obs_validar);

        /*
         * habilita o botao para listar os itens de roteiro
         */
        $('#btn-listar-itens-outros').prop('disabled', !1);
        /*
         * preenche as informacoes data-content para os detalhes do item
         */
        detalheItem(data[0].selImpacto, 'outros');
        /*
         * seta o id_baseline da funcao
         */
        $('#outros_id_funcao_baseline').val(data[0].idBaseline);
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
                autorizaAlteracaoCamposLinha(false, 'outros');
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
                autorizaAlteracaoCamposLinha(false, 'outros');
            });
        }
        else {
            /*
             * desabilita os botões inserir,inserir e fechar, e habilita o atualizar
             */
            $('#outros_btn_if').prop('disabled', true);
            $('#outros_btn_in').prop('disabled', true);
            $('#outros_btn_al').prop('disabled', isAutorizadoAlterar ? false : true);
        }
        /*
         * verifica se a acao eh de visualizacao e desabilita todos os campos
         */
        if (ac === 'vw' || ac === 'vi' || ac === 've' || ac === 'ai' || ac === 'ae') {
            autorizaAlteracaoCamposLinha(false, 'outros');
        }

    }, "json");
}

function insereFuncaoOutros(b) {
    //b - botao que foi clicado - insere e continua ou insere e fecha
    //funcao validaFormFuncao(tabela) ../js/api.js
    /*
     * testa a validade das informacoes no formulario
     */
    var retorno = validaFormFuncao('outros');
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
    //operacao
    var operacao = $('#outros_operacao').val();
    //post
    $.post("/pf/DIM.Gateway.php", {
        'outros_operacao': $('#outros_operacao').val(),
        'outros_tabela': $('#outros_tabela').val(),
        'outros_entrega': $('#outros_entrega').val(),
        'outros_id': idContagem,
        'outros_qtd_atual': $('#outros_qtd_atual').val(),
        'outros_id_roteiro': $('#outros_id_roteiro').val(),
        'outros_funcao': (abAtual == 2 && (operacao === 'A' || operacao === 'E')) ? $('#outros_funcao').children(':selected').text() : $('#outros_funcao').val(),
        'outros_qtd': $('#outros_qtd').val(),
        'outros_impacto': $('#outros_impacto').val(),
        'outros_pfa': $('#outros_pfa').val(),
        'outros_observacoes': $('#outros_observacoes').val(),
        'outros_observacoes_validacao': $('#outros_observacoes_validacao').val(),
        'outros_fonte': $('#outros_fonte').val(),
        'funcao_id_baseline': (abAtual == 2 && (operacao === 'A' || operacao === 'E')) ? $('#outros_funcao').children(':selected').val() : 0,
        'abrangencia_atual': abAtual,
        'contagem_id_baseline': abAtual == 2 ? $('#contagem_id_baseline').children(':selected').val() : 0,
        'arq': 27,
        'tch': 0,
        'sub': -1,
        'dlg': 1
    },
    function (data) {
        if (Number(data[0].id) > 0) {
            var table = document.getElementById('add' + data[0].tabela);
            var row = table.insertRow(-1);
            var pfa = Number(data[0].pfa);
            /*
             * insere os valores de retorno na tabela Add+table
             * TODO: passar os valores de validacao da linha
             */
            insereLinhaOutros(
                    data[0].id,
                    data[0].tabela,
                    row,
                    data[0].operacao,
                    data[0].funcao,
                    data[0].qtd,
                    data[0].siglaFator,
                    pfa.toFixed(4),
                    data[0].obsFuncao,
                    data[0].situacao,
                    data[0].entrega,
                    0,
                    0, //comentarios
                    true);//desenhar os graficos de entrega
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
    limpaCampos('outros');
    return true;
}

function alteraFuncaoOutros(b) {
    /*
     * testa a validade das informacoes no formulario
     */
    var retorno = validaFormFuncao('outros');
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
        $.post("/pf/DIM.Gateway.php", {
            'outros_operacao': $('#outros_operacao').val(),
            'outros_tabela': $('#outros_tabela').val(),
            'outros_entrega': $('#outros_entrega').val(),
            'outros_id': $('#outros_id').val(),
            'outros_qtd_atual': $('#outros_qtd_atual').val(),
            'outros_id_roteiro': $('#outros_id_roteiro').val(),
            //verificar
            //'outros_funcao': (abAtual == 2 && $('#outros_operacao').val() === 'I') ? $('#outros_funcao').val() : $('#outros_funcao').children(':selected').text(),
            'outros_funcao': $('#outros_funcao').val(),
            'outros_qtd': $('#outros_qtd').val(),
            'outros_impacto': $('#outros_impacto').val(),
            'outros_pfa': $('#outros_pfa').val(),
            'outros_observacoes': $('#outros_observacoes').val(),
            'outros_observacoes_validacao': $('#outros_observacoes_validacao').val(),
            'outros_fonte': $('#outros_fonte').val(),
            'contagem_id_baseline': $('#contagem_id_baseline option:selected').val(),
            'situacao': situacaoAtual,
            'funcao_id_baseline': $('#outros_id_funcao_baseline').val(),
            'acao_forms': acForms,
            'abrangencia_atual': abAtual,
            'id_contagem': idContagem,
            'arq': 6,
            'tch': 0,
            'sub': -1,
            'dlg': 1
        },
        function (data) {
            if (Number(data.id) > 0) {
                var pfAnterior = Number(data.pfAnterior);
                var qtdAtual = $('#outros_qtd_atual').val();
                var tabela = data.tabela;
                var pfa = Number(data.pfa);
                var obsFuncao = data.obsFuncao;
                /*
                 * verifica a operacao para escrever o label
                 */
                var oper = divOperacao(data.operacao);
                $("#oper_" + tabela + "_" + qtdAtual).html(oper);
                $("#funcao_" + tabela + "_" + qtdAtual).html(data.funcao);
                $("#qtd_" + tabela + "_" + qtdAtual).html(data.qtd);
                $("#pfa_" + tabela + "_" + qtdAtual).html(pfa.toFixed(4));
                $("#siglaFator_" + tabela + "_" + qtdAtual).html(data.siglaFator);
                $("#ent_" + tabela + "_" + qtdAtual).html(data.entrega);
                $("#obs_" + tabela + "_" + qtdAtual).html(obsFuncao);
                //obrigatoriamente muda para nao validada
                setSituacao(situacaoAtual, 'cell1_' + tabela + '_' + $('#outros_id').val());
                recalculaEstatisticas(pfa.toFixed(4), 0, 'OU', 'alterar', pfAnterior, 0, true);
                //finaliza a operacao com sucesso
                swal("Dimension", "O registro foi alterado com sucesso!", "success");
                $('#form_modal_funcao_outros').modal('toggle');
                limpaCampos('outros');
            }
            else {
                swal({
                    title: "Alerta",
                    text: data.msg,
                    type: "error",
                    html: true,
                    confirmButtonText: "Entendi!"}, function () {
                    $('#form_modal_funcao_outros').modal('toggle');
                    limpaCampos('outros');
                });
            }
        }, "json");
    }
}