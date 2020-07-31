function consultaFuncaoDadosBaseline(i, b) {
    $.post("/pf/DIM.Gateway.php", {'i': i, 'b': b,
        'arq': 42,
        'tch': 1,
        'sub': -1,
        'dlg': 1},
    function (data) {
        var pfa = Number(data[0].pfa);
        var pfb = Number(data[0].pfb);
        //consulta a funcao na baseline
        $('#dados_id').val(acForms === 'al' ? data[0].id : 0);
        $('#dados_td').val(data[0].td);
        $('#dados_tr').val(data[0].tr);
        $('#dados_complexidade').val(data[0].complexidade);
        $('#dados_fonte').val(data[0].fonte);
        $('#dados_metodo').val(data[0].id_metodo);
        //verifica antes para nao alterar o pfa
        verificaMetodo('dados', $('#dados_metodo'), $('#dados_id_roteiro'), $('#dados_operacao'));
        //depois
        $('#dados_pfb').val(pfb.toFixed(4));
        //sob analise se coloca ou nao o ajustado neste momento
        //$('#dados_pfa').val(pfa.toFixed(4));
        $('#dados_impacto').val(0);
        $('#dados_observacoes').val(data[0].obs_funcao);
        $('#dados_observacoes_validacao').val(data[0].obs_validar);
        //descricao dos TD
        arrTR = data[0].descricaoTR;
        //limpa as descricoes
        jQuery("#dados_descricao_tr").tagsManager('empty');
        for (x = 0; x < arrTR.length; x++) {
            jQuery("#dados_descricao_tr").tagsManager('pushTag', arrTR[x]);
        }
        //descricao dos TR
        arrTD = data[0].descricaoTD;
        //limpa as descricoes
        jQuery("#dados_descricao_td").tagsManager('empty');
        for (x = 0; x < arrTD.length; x++) {
            jQuery("#dados_descricao_td").tagsManager('pushTag', arrTD[x]);
        }
        /*
         * preenche as informacoes data-content para os detalhes do item
         */
        detalheItem(data[0].selImpacto, 'dados');
        /*
         * habilita mudanca
         */
        if ($('#dados_operacao').val() === 'A' || $('#dados_operacao').val() === 'E') {
            $('#dados-is-mudanca').bootstrapToggle('enable').bootstrapToggle('off');
        }
        /*
         * coloca o disabled caso nao possa alterar
         */
        $('.tm-tag-remove').css({'visibility': (!isAutorizadoAlterar ? 'hidden' : 'visible')});
        /*
         * coloca o valor de formularios estendidos
         */
        $('#dados_fe').val(data[0].fe);

    }, 'json');
}
/**
 * api para as funcoes de dados
 * retornaFuncaoDados()
 * insereFuncaoDados() (banco) que chama insereLinhaDados() (tela/tabela)
 */
function retornaFuncaoDados(i, b, q, p, n) {
    //primeiro de tudo
    //muda a variavel acForms para alterar
    acForms = 'al';
    //muda a variavel fAtual
    fAtual = b;
    //TODO: verificar quando for contagem de Baseline se ha refencias da funcao
    //nao pode alterar direto na baseline
    $.post("/pf/DIM.Gateway.php", {'i': i, 'b': b,
        'arq': 42,
        'tch': 1,
        'sub': -1,
        'dlg': 1
    },
    function (data) {
        /*
         * verifica se pode alterar ou se foi uma operacao de INDICATIVA
         */
        if (data[0].operacao === 'N') {
            swal({
                title: "Informa&ccedil;&atilde;o",
                text: "Esta funcionalidade foi inserida de forma INDICATIVA, n&atilde;o &eacute; poss&iacute;vel alterar.",
                type: "info",
                html: true,
                confirmButtonText: "Entendi!"}
            );
        }
        else {
            $("#form_modal_funcao_dados").modal('toggle');
            /*
             * i = id da funcao
             * b = tabela ALI/AIE
             * q = atdAtual de linhas
             * p = Pontos de Funcao Ajustados PFa
             * n = id do botao btnEdit
             */
            if (b === 'ALI') {
                $('#cabecalho_funcao').val(title_ali_alt);
                $("#dados_h4-modal").html(title_ali_alt);
                $('#dados_tabela').val('ALI');
                $('#is-crud-atualizar-dependentes').bootstrapToggle(data[0].isCrud == 1 ? 'on' : 'off').bootstrapToggle(data[0].isCrud == 1 ? 'enable' : 'disable');
                //somente aqui habilita a combo dados_fe - formularios estendidos
                $('#dados_fe').val(data[0].fe).prop('disabled', false);
            }
            else {
                $('#cabecalho_funcao').val(title_aie_alt);
                $("#dados_h4-modal").html(title_aie_alt);
                $('#dados_tabela').val('AIE');
                //se nao for ALI desabilita do is-crud-atualizar-dependentes
                $('#is-crud-atualizar-dependentes').bootstrapToggle('off').bootstrapToggle('disable');
                //desabilita a combo dados_fe - formularios estendidos
                $('#dados_fe').val(0).prop('disabled', true);
            }
            /*
             * insere as outras informacoes
             */
            $('#dados_qtd_atual').val(q);
            $('#dados_id').val(i);
            $('#dados_id_roteiro').val(data[0].id_roteiro);
            /*
             * se for uma linha de baseline com roteiro id = 3 Dimension, tem que liberar a combo
             */
            idRoteiro = data[0].id_roteiro;
            idRoteiro == 3 ? $('#dados_id_roteiro').prop('disabled', false) : $('#dados_id_roteiro').prop('disabled', true);
            //segue vida
            $('#dados_operacao').val(data[0].operacao);
            $('#dados_metodo').val(data[0].id_metodo);
            $('#dados_entrega').val(data[0].entrega).mask('00').TouchSpin({
                min: 1,
                max: $('#entregas').val(),
                step: 1,
                boostat: 5,
                maxboostedstep: 10,
                postfix: ''
            }).prop('readonly', true);
            /*
             * muda o botao de selecao da operacao e do metodo e chama a combo dos impactos
             */
            verificaOperacao('dados', data[0].operacao, data[0].id_roteiro, data[0].selImpacto, b, acForms);
            verificaMetodo('dados', $('#dados_metodo'), $('#dados_id_roteiro'), $('#dados_operacao'));
            /*
             * nao pode converter funcao de testes em I, A ou E na alteracao
             */
            if (data[0].operacao === 'T') {
                $('#dados_op1').prop('disabled', true);
                $('#dados_op2').prop('disabled', true);
                $('#dados_op3').prop('disabled', true);
                $('#dados_me1').prop('disabled', true);
                $('#dados_me2').prop('disabled', true);
            }
            /*
             * verifica se eh uma baseline e desabilita os metodos Nesma e FP-Lite
             */
            if (abAtual == 3) {
                $('#dados_me1').prop('disabled', true);
                $('#dados_me2').prop('disabled', true);
            }
            //seta a variavel global de situacao da linha
            situacaoLinha = data[0].situacao;
            //insere o valor do Fator documentacao
            $('#dados_fd').val(data[0].fd);
            if (data[0].operacao !== 'I' && data[0].operacao !== 'T' && data[0].tipoImpacto === 'A') {
                $('#dados_fd').prop('disabled', false);
            }
            /*
             * TODO: (abAtual == 2 && data[0].operacao === 'I') ? data[0].idBaseline : 
             */
            $('#dados_funcao').val(data[0].funcao).prop('readonly', true);
            $('#dados_funcao_nome_anterior').val(data[0].funcao);
            $('#dados_td').val(data[0].td);
            $('#dados_tr').val(data[0].tr);
            $('#dados_complexidade').val(data[0].complexidade);
            $('#dados_fonte').val(data[0].fonte);
            /*
             * verifica se foi mudanca (retrabalho)
             */
            if (data[0].isMudanca == 1) {
                $('#dados-is-mudanca').bootstrapToggle('enable').bootstrapToggle('on');
                $('#dados-fase').val(data[0].faseMudanca);
                $('#dados-percentual-fase').val(data[0].percentualFase == 0 ? '' : data[0].percentualFase).prop('readonly', false);
            }
            else {
                if (data[0].operacao !== 'I' && data[0].operacao !== 'T') {
                    $('#dados-is-mudanca').bootstrapToggle('enable');
                    $('#dados-fase').val(0);
                    $('#dados-percentual-fase').val('').prop('readonly', true);
                }
                else {
                    $('#dados-is-mudanca').bootstrapToggle('off').bootstrapToggle('disable');
                    $('#dados-fase').val(0);
                    $('#dados-percentual-fase').val('').prop('readonly', true);
                }
            }

            var pfb = Number(data[0].pfb);
            $('#dados_pfb').val(pfb.toFixed(4));

            var pfa = Number(data[0].pfa);
            $('#dados_pfa').val(pfa.toFixed(4));

            $('#dados_observacoes').val(data[0].obs_funcao);
            $('#dados_observacoes_validacao').val(data[0].obs_validar);
            /*
             * descricao dos tipos de registros e tipos de dados
             */
            arrTR = data[0].descricaoTR;
            for (x = 0; x < arrTR.length; x++) {
                jQuery("#dados_descricao_tr").tagsManager('pushTag', arrTR[x]);
            }
            arrTD = data[0].descricaoTD;
            for (x = 0; x < arrTD.length; x++) {
                jQuery("#dados_descricao_td").tagsManager('pushTag', arrTD[x]);
            }
            /*
             * desabilita os botões inserir, inserir e fechar, e habilita o atualizar
             */
            $('#dados_btn_if').prop('disabled', true);
            $('#dados_btn_in').prop('disabled', true);
            $('#dados_btn_al').prop('disabled', !isAutorizadoAlterar);
            /*
             * atribui o valor id ao campo id-linha-descricao para capturar os valores para o ajax
             */
            $('#id-linha-descricao').val(i);
            /*
             * insere a quantidade de TDs dentro do span
             */
            $('#dados-badge-td').html(data[0].quantidadeTD);
            (Number(data[0].quantidadeTD) > 0 && $('#dados_metodo').val() == 3) ? $('#dados_td').val(data[0].quantidadeTD) : null;
            /*
             * altera o valor da descricao da funcao do td para dados
             */
            $('#descricao-funcao-td').val('dados');
            /*
             * habilita o botao para listar os itens de roteiro
             */
            $('#btn-listar-itens-dados').prop('disabled', !1);
            /*
             * preenche as informacoes data-content para os detalhes do item
             */
            detalheItem(data[0].selImpacto, 'dados');
            /*
             * seta o id_baseline da funcao
             */
            $('#dados_id_funcao_baseline').val(data[0].idBaseline);
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
                    autorizaAlteracaoCamposLinha(false, 'dados');
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
                    autorizaAlteracaoCamposLinha(false, 'dados');
                });
            }
            else {
                /*
                 * desabilita os botões inserir,inserir e fechar, e habilita o atualizar
                 */
                $('#dados_btn_if').prop('disabled', true);
                $('#dados_btn_in').prop('disabled', true);
                $('#dados_btn_al').prop('disabled', isAutorizadoAlterar ? false : true);
                if (isAutorizadoAlterar) {
                    $('#dados_funcao').prop('readonly', true).css({'background-color': '#ffffe5'});
                    $('#alterar-funcao-dados').prop('disabled', false);
                }
            }
            /*
             * coloca o disabled caso nao possa alterar
             */
            $('.tm-tag-remove').css({'visibility': (!isAutorizadoAlterar ? 'hidden' : 'visible')});
            /*
             * verifica se a acao eh de visualizacao e desabilita todos os campos
             */
            if (ac === 'vw' || ac === 'vi' || ac === 've' || ac === 'ai' || ac === 'ae') {
                autorizaAlteracaoCamposLinha(false, 'dados');
            }
            /*
             * em acao de al simplesmente desabilita o is-crud
             */
            $('#is-crud').bootstrapToggle(data[0].isCrud == 1 ? 'on' : 'off').bootstrapToggle('disable');
        }
    }, "json");
}

function insereFuncaoDados(b) {
    /**
     */
    //funcao validaFormFuncao(tabela) ../js/api.js
    var arrTR = jQuery("#dados_descricao_tr").tagsManager('tags'); //variavel que recebera as descricoes dos tipos de registros
    var arrTD = jQuery("#dados_descricao_td").tagsManager('tags');
    /*
     * testa a validade das informacoes no formulario
     */
    var retorno = validaFormFuncao('dados');
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
        var isCrud = $('#is-crud').prop('checked');
        var isCrudAtualizarDependentes = 0; //$('#is-crud-atualizar-dependentes').prop('checked');
        var isMudanca = $('#dados-is-mudanca').prop('checked') ? 1 : 0;
        var faseMudanca = $('#dados-fase').val();
        var percentualFase = $('#dados-percentual-fase').val();
        var operacao = $('#dados_operacao').val();
        var dadosFd = $('#dados_fd').val();
        var dadosTabela = $('#dados_tabela').val();
        var dadosFe = $('#dados_fe').val();

        $.post("/pf/DIM.Gateway.php", {
            'dados_operacao': $('#dados_operacao').val(),
            'dados_tabela': dadosTabela,
            'dados_metodo': $('#dados_metodo').val(),
            'dados_entrega': $('#dados_entrega').val(),
            'dados_id': idContagem,
            'dados_qtd_atual': $('#dados_qtd_atual').val(),
            'dados_id_roteiro': $('#dados_id_roteiro').val(),
            'dados_funcao': $('#dados_funcao').is('select') && (abAtual == 2 && (operacao === 'A' || operacao === 'E') || (dadosTabela.toLowerCase() === 'aie' && operacao === 'I')) ?
                    $('#dados_funcao').find('option:selected').text().split(' > ')[5] :
                    $('#dados_funcao').val(),
            'dados_td': $('#dados_td').val(),
            'dados_tr': $('#dados_tr').val(),
            'dados_complexidade': $('#dados_complexidade').val(),
            'dados_pfb': $('#dados_pfb').val(),
            'dados_impacto': $('#dados_impacto').val(),
            'dados_pfa': $('#dados_pfa').val(),
            'dados_observacoes': $('#dados_observacoes').val(),
            'dados_observacoes_validacao': $('#dados_observacoes_validacao').val(),
            'dados_fonte': $('#dados_fonte').val(),
            'dados_descricao_tr': arrTR,
            'dados_descricao_td': arrTD,
            'is_mudanca': isMudanca,
            'fase_mudanca': faseMudanca,
            'percentual_fase': percentualFase,
            'funcao_id_baseline': (abAtual == 2 && (operacao === 'A' || operacao === 'E')) ?
                    $('#dados_funcao').children(':selected').val() : 0,
            'dados_fd': dadosFd,
            'dados_fe': dadosFe,
            'abrangencia_atual': abAtual,
            'contagem_id_baseline': abAtual == 2 ? $('#contagem_id_baseline').children(':selected').val() : 0,
            'is_crud': isCrud ? 1 : 0,
            'is_crud_atualizar_dependentes': isCrudAtualizarDependentes ? 1 : 0,
            'arq': 26,
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
                        data[0].tr,
                        data[0].complexidade,
                        pfb.toFixed(4),
                        data[0].siglaFator,
                        pfa.toFixed(4),
                        data[0].obsFuncao,
                        data[0].situacao,
                        data[0].entrega,
                        0,
                        0, //comentarios qtd
                        false, //desenhar os graficos de entrega
                        isMudanca,
                        faseMudanca,
                        percentualFase,
                        dadosFd,
                        isCrud ? 1 : 0,
                        isCrudAtualizarDependentes ? 1 : 0,
                        dadosFe);
            }
            else {
                swal({
                    title: "Alerta",
                    text: _ERR_INSERCAO,
                    type: "error",
                    html: true,
                    confirmButtonText: "Entendi!"});
            }
            limpaCampos('dados');
            //atualiza as tabelas na pagina
            if (dadosTabela === 'ALI' && operacao === 'I' && isCrud) {
                zeraTabelaEstatisticas();
                isSalvarEstatisticas = false;
                listaFuncao(idContagem, 'ee', $('#addEE').get(0), 'transacao', 'id', 'ASC', true);
                listaFuncao(idContagem, 'ce', $('#addCE').get(0), 'transacao', 'id', 'ASC', true);
                isSalvarEstatisticas = true;
            }
        }, "json");

        return true;
    }
}

function insereFuncaoDadosIndicativa(b, f) {
    $.post("/pf/DIM.Gateway.php", {
        'dados_operacao': 'N',
        'dados_tabela': b,
        'dados_metodo': 1,
        'dados_entrega': 1,
        'dados_id': idContagem,
        'dados_qtd_atual': 1,
        'dados_id_roteiro': 3,
        'dados_funcao': f,
        'dados_td': 19,
        'dados_tr': 1,
        'dados_complexidade': 'Media',
        'dados_pfb': b === 'ALI' ? 35 : 15,
        'dados_impacto': '41;1;FI [100%] - PF.INSERCAO.AUTOMATICA;A', //critico isso por conta do banco e do roteiro
        'dados_pfa': b === 'ALI' ? 35 : 15,
        'dados_observacoes': 'Inserção automática para contagem Indicativa',
        'dados_observacoes_validacao': 'Inserção automática para contagem Indicativa',
        'dados_fonte': 'Método NESMA - Indicativa',
        'dados_descricao_tr': [],
        'dados_descricao_td': [],
        'is_mudanca': 0,
        'fase_mudanca': 0,
        'percentual_fase': 0,
        'funcao_id_baseline': 0,
        'dados_fd': 0,
        'dados_fe': 0,
        'abrangencia_atual': abAtual,
        'contagem_id_baseline': 0,
        'arq': 26,
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
                    data[0].tr,
                    data[0].complexidade,
                    pfb.toFixed(4),
                    data[0].siglaFator,
                    pfa.toFixed(4),
                    data[0].obsFuncao,
                    data[0].situacao,
                    data[0].entrega,
                    0,
                    0, //comentarios qtd
                    false, //desenhar os graficos de entrega
                    0,
                    '',
                    0,
                    0,
                    0);//dados fe
        }
        else {
            swal({
                title: "Alerta",
                text: _ERR_INSERCAO,
                type: "error",
                html: true,
                confirmButtonText: "Entendi!"});
        }
    }, "json");
    return '';
}

function alteraFuncaoDados(b) {
    var arrTR = jQuery("#dados_descricao_tr").tagsManager('tags'); //variavel que recebera as descricoes dos tipos de registros
    var arrTD = jQuery("#dados_descricao_td").tagsManager('tags'); //variavel que recebera as descricoes dos tipos de dados
    /*
     * testa a validade das informacoes no formulario
     */
    var retorno = validaFormFuncao('dados');
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
    }
    else {
        /*
         * mudancas
         */
        var isCrudAtualizarDependentes = $('#is-crud-atualizar-dependentes').prop('checked') ? 1 : 0;
        var isMudanca = $('#dados-is-mudanca').prop('checked') ? 1 : 0;
        var faseMudanca = $('#dados-fase').val();
        var percentualFase = $('#dados-percentual-fase').val();
        var dadosFd = $('#dados_fd').val();
        var isCrud = $('#is-crud').prop('checked') ? 1 : 0;
        var dadosFe = $('#dados_fe').val();
        /*
         * guarda a situacao atual da linha
         */
        var situacaoAtual = situacaoLinha == 3 ? 3 : (situacaoLinha == 4 ? 3 : (abAtual == 3 || abAtual == 4 ? 2 : 1));
        /*
         * envia as informacoes
         */
        $.post("/pf/DIM.Gateway.php", {
            'dados_operacao': $('#dados_operacao').val(),
            'dados_tabela': $('#dados_tabela').val(),
            'dados_metodo': $('#dados_metodo').val(),
            'dados_entrega': $('#dados_entrega').val(),
            'dados_id': $('#dados_id').val(),
            'dados_qtd_atual': $('#dados_qtd_atual').val(),
            'dados_id_roteiro': $('#dados_id_roteiro').val(),
            'dados_funcao': $('#dados_funcao').val(),
            'dados_td': $('#dados_td').val(),
            'dados_tr': $('#dados_tr').val(),
            'dados_complexidade': $('#dados_complexidade').val(),
            'dados_pfb': $('#dados_pfb').val(),
            'dados_impacto': $('#dados_impacto').val(),
            'dados_pfa': $('#dados_pfa').val(),
            'dados_observacoes': $('#dados_observacoes').val(),
            'dados_observacoes_validacao': $('#dados_observacoes_validacao').val(),
            'dados_fonte': $('#dados_fonte').val(),
            'dados_descricao_tr': arrTR,
            'dados_descricao_td': arrTD,
            'is_mudanca': isMudanca,
            'fase_mudanca': faseMudanca,
            'percentual_fase': percentualFase,
            'contagem_id_baseline': $('#contagem_id_baseline option:selected').val(),
            //TODO:verificar a transicao de estado de 4 para 3
            'situacao': situacaoAtual,
            'dados_fd': dadosFd,
            'dados_fe': dadosFe,
            'funcao_id_baseline': $('#dados_id_funcao_baseline').val(),
            'acao_forms': acForms,
            'abrangencia_atual': abAtual,
            'id_contagem': idContagem,
            'is_crud': isCrud,
            'is_crud_atualizar_dependentes': isCrudAtualizarDependentes,
            'dados_funcao_is_alterar_nome': $('#dados_funcao_is_alterar_nome').val(),
            'dados_funcao_nome_anterior': $('#dados_funcao_nome_anterior').val(),
            'arq': 5,
            'tch': 0,
            'sub': -1,
            'dlg': 1
        },
        function (data) {
            if (Number(data.id) > 0) {
                var pfan = Number(data.pfan);
                var pfbn = Number(data.pfbn);
                var qtdAtual = $('#dados_qtd_atual').val();
                var tabela = data.tabela;
                var pfa = Number(data.pfa);
                var pfb = Number(data.pfb);
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
                var y = '';
                if (data.operacao === 'A' || data.operacao === 'E') {
                    if (data.isMudanca == 1) {
                        c = '<br />Retrabalho: ' + data.faseMudanca + ' - ' + data.percentualFase + '%';
                    }
                }
                //verifica se tem fator de documentacao
                if (Number(dadosFd) > 0) {
                    t = (data.isMudanca ? '&nbsp;&nbsp;&nbsp;' : '<br />') + 'Fator Documentação: ' + parseFloat(dadosFd).toFixed(2);
                }
                if (Number(dadosFe) > 0) {
                    y = '<br />Formulário Estendido: ' + parseFloat(dadosFe).toFixed(2);
                }
                $("#siglaFator_" + tabela + "_" + qtdAtual).html(data.siglaFator + (data.isMudanca ? c : '') + t + y);
                $("#pfa_" + tabela + "_" + qtdAtual).html(pfa.toFixed(4));
                $("#pfa_" + tabela + "_" + qtdAtual).html(pfa.toFixed(4));
                $("#ent_" + tabela + "_" + qtdAtual + "_" + data.id).html(data.entrega);
                $("#obs_" + tabela + "_" + qtdAtual).html(obsFuncao);
                //obrigatoriamente muda para nao validada ou para em revisao se for o caso
                setSituacao(situacaoAtual, 'cell1_' + tabela + '_' + $('#dados_id').val());
                /*
                 * verifica se eh um crud e atualiza as tabelas EE e CE
                 */
                if (tabela === 'ALI' && Number(isCrud) == 1) {
                    zeraTabelaEstatisticas();
                    isSalvarEstatisticas = false;
                    listaFuncao(idContagem, 'ee', $('#addEE').get(0), 'transacao', 'id', 'ASC', true);
                    listaFuncao(idContagem, 'ce', $('#addCE').get(0), 'transacao', 'id', 'ASC', true);
                    isSalvarEstatisticas = true;
                }
                //estatisticas
                recalculaEstatisticas(pfa, pfb, tabela, 'alterar', pfan, pfbn, true, dadosFe);
                swal("Dimension", "O registro foi alterado com sucesso!", "success");
                $('#form_modal_funcao_dados').modal('toggle');
                limpaCampos('dados');
            }
            else {
                swal({
                    title: "Alerta",
                    text: data.msg,
                    type: "error",
                    html: true,
                    confirmButtonText: "Entendi!"}, function () {
                    $('#form_modal_funcao_dados').modal('toggle');
                    limpaCampos('dados');
                });
            }
        }, "json");
    }
}

/*
 * chama a funcao que atualiza o array com src item para pesquisa em tipos de registros
 * apenas para a baseline porque a consulta pode ser grande
 * PAB - Pesquisa nos arquivos da baseline
 */
$("#chk_pesq_baseline_tr").on("change", function () {
    atualizaItensTiposRegistros($(this), 'PAB');
});