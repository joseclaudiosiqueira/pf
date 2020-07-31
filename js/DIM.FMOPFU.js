var btnClicado;
/*
 * desabilita os botoes de pesquisa exceto nos AIES
 */
if (abAtual == 3 || abAtual == 4) {
    $('#btn-pesquisar-ali').prop('disabled', true);
    $('#btn-pesquisar-ee').prop('disabled', true);
    $('#btn-pesquisar-se').prop('disabled', true);
    $('#btn-pesquisar-ce').prop('disabled', true);
}
/*
 * para a pesquisar em alis que vao viar aies deve ser feito pela combo
 */
function changeSelectAIEBaseline(s) {
    if ($(s).val() == 0) {
        $('#addPesquisaFuncoes').empty();
    } else {
        // botao clicado
        // valor da baseline a ser pesquisada
        // id da contagem atual
        pesquisarFuncoes($('#btn-pesquisar-aie'), $(s).val(), idContagem);
        // verifica se esta na mesma baseline da contagem de projeto
        var idBaselineProjeto = $('#contagem_id_baseline').children(':selected').val();
        var idBaselineSelecionada = $(s).children(':selected').val();
        var botaoClicado = $('#btn-pesquisar-aie').val()
        if (abAtual == 2 && idBaselineProjeto == idBaselineSelecionada && botaoClicado === 'aie') {
            $('#opi').prop('disabled', true);
            $('#opa').prop('disabled', false);
            $('#ope').prop('disabled', false);
        } else if (botaoClicado === 'aie') {
            $('#opi').prop('disabled', false);
            $('#opa').prop('disabled', true);
            $('#ope').prop('disabled', true);
        }
    }
}
/*
 * change no id da baseline para contagens livres
 */
$('#id-baseline-pesquisa-livre').on('change', function () {
    var baseline = $(this).children(':selected').val();
    $('#addPesquisaFuncoesLivre').empty();
    pesquisarFuncoes(btnClicado, baseline, idContagem);
});
/*
 * botoes de pesquisa de funcoes
 */
$('.btn-pesquisar-funcoes').on('click',
        function () {
            btnClicado = $(this);
            abAtual == 1 ? $('#form-modal-pesquisar-funcoes-livre')
                    .modal('show') : $('#form-modal-pesquisar-funcoes')
                    .modal('show');
            /*
             * este script ira disponibilizar duas telas uma para
             * contagem de projeto e outra para contagem livre
             */
            if (abAtual == 1) {
                var tabela = $(this).val();
                $('#div-pesquisa-funcao')
                        .html(
                                'Selecione ao lado uma Baseline e logo ap&oacute;s selecione os itens que far&atilde;o parte desta Contagem Livre. '
                                + 'Voc&ecirc; pode selecionar um ou mais itens, logo ap&oacute;s clique no bot&atilde;o correspondente &agrave; opera&ccedil;&atilde;o que deseja realizar. '
                                + 'Caso n&atilde;o haja itens &eacute; porque o sistema n&atilde;o permite duplicidades, verifique se o mesmo j&aacute; est&aacute; na sua contagem.');
                comboBaseline(0, 0, $('#id-baseline-pesquisa-livre'), 0);
            } else {
                var tabela = $(this).val();
                var baseline = $('#contagem_id_baseline').children(
                        ':selected').val();
                /*
                 * verifica a abrangencia da contagem e desabilita A -
                 * Alterar e E -Excluir 3 - Baseline 4 - Licitacao
                 */
                if (abAtual == 3 || abAtual == 4) {
                    $('#ope').prop('disabled', true);
                    $('#opa').prop('disabled', true);
                } else if (abAtual == 2) {
                    if (tabela === 'aie') {
                        $('#opa').prop('disabled', true);
                        // uma contagem de projeto pode excluir um aie da baseline, mas o evento sera disparado pela selecao da baseline de pesquisa
                        $('#ope').prop('disabled', true);
                    } else {
                        $('#opi').prop('disabled', true);
                    }
                }
                /*
                 * verifica a tabela e prosseque
                 */
                if (Number(baseline) < 1) {
                    swal({
                        title: "Alerta",
                        text: "Para pesquisar este tipo de função [ "
                                + tabela.toUpperCase()
                                + " ] é necessário que seja uma contagem tipo: <strong>Projeto</strong> e que uma baseline esteja selecionada.",
                        type: "error",
                        html: true
                    });
                } else {
                    if ($(this).val() !== 'aie') {
                        /*
                         * fazer coisas para alterar a combobox
                         */
                        $('#div-pesquisa-aie')
                                .html(
                                        '<center><strong>Selecione os itens que far&atilde;o parte desta Contagem de Projeto. '
                                        + 'Voc&ecirc; pode selecionar um ou mais itens, logo ap&oacute;s clique no bot&atilde;o correspondente &agrave; opera&ccedil;&atilde;o que deseja realizar. '
                                        + 'Caso n&atilde;o haja itens &eacute; porque o sistema n&atilde;o permite duplicidades, verifique se o mesmo j&aacute; est&aacute; na sua contagem.</strong></center>');
                        /*
                         * pesquisa direto as funcoes
                         */
                        pesquisarFuncoes($(this), baseline, idContagem);
                    } else {
                        $('#div-pesquisa-aie')
                                .html(
                                        '<label for="id-baseline-pesquisa">Para pesquisar ALIs e inserir como AIEs nesta baseline, selecione a qual baseline os ALIs se referem</label>'
                                        + '<select id="id-baseline-pesquisa" class="form-control input_style" onchange="changeSelectAIEBaseline($(this));"></select>');
                        comboBaselineAIE('ali', baseline, abAtual);// ALIs
                        // serao AIEs aqui, tem que passar a abrangencia (2-projeto e 3-baseline
                    }
                }
            }
        });

$('#form-modal-pesquisar-funcoes').on('hide.bs.modal', function (e) {
    $('#addPesquisaFuncoes').empty();
    $('#opi').prop('disabled', false);
    $('#opa').prop('disabled', false);
    $('#ope').prop('disabled', false);
    funcoesItems = [];
});

$('#form-modal-pesquisar-funcoes-livre').on('hide.bs.modal', function (e) {
    $('#addPesquisaFuncoesLivre').empty();
    $('#opi').prop('disabled', false);
    $('#opa').prop('disabled', false);
    $('#ope').prop('disabled', false);
    funcoesItems = [];
});

$('.btn-adicionar-funcoes').on(
        'click',
        function () {
            var operacao = $(this).val();
            if (funcoesItems.length < 1) {
                swal({
                    title: "Alerta",
                    text: "Voc&ecirc; precisa selecionar ao menos uma fun&ccedil;&atilde;o de Dados/Transa&ccedil;&atilde;o.",
                    type: "warning",
                    html: true,
                    confirmButtonText: "Entendi, obrigado!"
                });
            } else {
                /*
                 * no caso de abAtual = 1 (livre) os ids sao iguais
                 */
                $.post(
                        '/pf/DIM.Gateway.php',
                        {
                            'fi': funcoesItems,
                            'abAtual': abAtual,
                            'idContagem': idContagem,
                            'idBaseline': abAtual == 1 ? $(
                                    '#id-baseline-pesquisa-livre')
                                    .children(':selected')
                                    .val()
                                    : $('#id-baseline-pesquisa')
                                    .children(
                                            ':selected')
                                    .val(),
                            'idBaselineContagem': abAtual == 1 ? $(
                                    '#id-baseline-pesquisa-livre')
                                    .children(':selected')
                                    .val()
                                    : $('#contagem_id_baseline')
                                    .children(
                                            ':selected')
                                    .val(),
                            'operacao': operacao,
                            'arq': 30,
                            'tch': 0,
                            'sub': -1,
                            'dlg': 1
                        },
                function (data) {
                    if (data.status) {
                        /*
                         * faz o select das novas
                         * funcionalidades
                         */
                        tabela = data.tabela;
                        listaFuncao(
                                idContagem,
                                tabela,
                                $('#add'
                                        + tabela
                                        .toUpperCase())[0],
                                data.funcao, 'id',
                                'ASC');
                        /*
                         * alerta sobre o sucesso da
                         * operacao
                         */
                        swal({
                            title: "Informa&ccedil;&atilde;o",
                            text: "As funcionalidades selecionadas foram inseridas com sucesso nesta contagem.",
                            type: "success",
                            html: true,
                            confirmButtonText: "Ok, obrigado!"
                        });
                    } else {
                        swal({
                            title: "Alerta",
                            text: "Houve um erro durante a inser&ccedil;&atilde;o das funcionalidades na contagem, por favor procure por um Gestor.",
                            type: "error",
                            html: true,
                            confirmButtonText: "Obrigado, vou verificar!"
                        });
                    }
                    /*
                     * fecha o formulario de toda forma
                     */
                    abAtual == 1 ? $(
                            '#form-modal-pesquisar-funcoes-livre')
                            .modal('hide')
                            : $(
                                    '#form-modal-pesquisar-funcoes')
                            .modal('hide');
                }, 'json');
            }
        });
/**
 * 
 * @param {type}
 *            b - botao que foi clicado
 * @param {type}
 *            i - id da baseline a ser pesquisada
 * @param {type}
 *            ic - id contagem atual
 * @returns {undefined}
 */
function pesquisarFuncoes(b, i, ic) {
    // como a funcao recebe um botao, a variavel t armazena o valor ali, aie, etc...
    // ali->aie, quando for uma contagem de baseline
    var t = $(b).val() === 'aie' && abAtual == 3 ? 'ali-aie' : $(b).val();
    // id da baseline da contagem atual, para saber se vai pesquisar ALI ou AIE para o projeto
    var ib = abAtual == 1 ? i : $('#contagem_id_baseline').children(':selected').val();
    // json para carregar as funcoes de baseline
    $.post('/pf/DIM.Gateway.php',
            {
                't': t, // tabela
                'i': i, // id_baseline
                'b': ib, // id_baseline desta contagem
                'ic': ic, // id_contagem atual
                'ab': abAtual, // abrangencia da contagem atual
                // (projeto ou baseline)
                'arq': abAtual == 1 ? 88 : (abAtual == 3 ? 75 : 76), // no diretorio /api/pesquisa 75=Baseline, 76=Projeto
                'tch': 1,
                'sub': 5,
                'dlg': 1
            },
    function (data) {
        if (data.length > 0) {
            // TODO: ver se eh necessario isso
            // $('#form-modal-pesquisar-funcoes').modal('show');
            // verifica se eh projeto, AIE e as baselines sao iguais habilita os botoes excluir e alterar
            var divAdd = $(
                    abAtual == 1 ? '#addPesquisaFuncoesLivre'
                    : '#addPesquisaFuncoes').get(0);
            var rInput;
            var rLabel;
            /*
             * criando os rows
             */
            divRowFuncao = document.createElement('div');
            divRowFuncao.className = 'row well well-sm';
            divRowFuncao.style.paddingLeft = '40px';
            divRowFuncao.style.lineHeight = '38px';
            /*
             * criando os cols
             */
            divColFuncao = document.createElement('div');
            divColTD = document.createElement('div');
            divColTR = document.createElement('div');
            divColPfb = document.createElement('div');
            divColOperacao = document.createElement('div');
            divColDataCadastro = document.createElement('div');
            divColAtualizadoPor = document.createElement('div');
            /*
             * dimensionando os cols
             */
            divColFuncao.className = 'col-md-3';
            divColTD.className = 'col-md-1';
            divColTR.className = 'col-md-1';
            divColPfb.className = 'col-md-1';
            divColOperacao.className = 'col-md-1';
            divColDataCadastro.className = 'col-md-1';
            divColAtualizadoPor.className = 'col-md-4';
            /*
             * inserindo os textos
             */
            divColFuncao.innerHTML = 'Função';
            divColTD.innerHTML = 'TD';
            divColTR.innerHTML = t === 'ali-aie' || t === 'ali' ? 'TR'
                    : 'AR';
            divColPfb.innerHTML = 'PFb';
            divColOperacao.innerHTML = 'Oper.';
            divColDataCadastro.innerHTML = 'Cadastro';
            divColAtualizadoPor.innerHTML = 'Atualizado por';
            /*
             * adiciona nas divs
             */
            divRowFuncao.appendChild(divColFuncao);
            divRowFuncao.appendChild(divColTD);
            divRowFuncao.appendChild(divColTR);
            divRowFuncao.appendChild(divColPfb);
            divRowFuncao.appendChild(divColOperacao);
            divRowFuncao.appendChild(divColDataCadastro);
            divRowFuncao.appendChild(divColAtualizadoPor);
            divAdd.appendChild(divRowFuncao);
            for (x = 0; x < data.length; x++) {
                /*
                 * criando os rows
                 */
                divRowFuncao = document.createElement('div');
                divRowFuncao.className = 'row';
                divRowFuncao.style.paddingLeft = '40px';
                divRowFuncao.style.lineHeight = '38px';
                /*
                 * criando os cols
                 */
                divColFuncao = document.createElement('div');
                divColTD = document.createElement('div');
                divColTR = document.createElement('div');
                divColPfb = document.createElement('div');
                divColOperacao = document.createElement('div');
                divColDataCadastro = document
                        .createElement('div');
                divColAtualizadoPor = document
                        .createElement('div');
                /*
                 * dimensionando os cols
                 */
                divColFuncao.className = 'col-md-3';
                divColTD.className = 'col-md-1';
                divColTR.className = 'col-md-1';
                divColPfb.className = 'col-md-1';
                divColOperacao.className = 'col-md-1';
                divColDataCadastro.className = 'col-md-1';
                divColAtualizadoPor.className = 'col-md-4';
                /*
                 * adiciona nas divs
                 */
                divRowFuncao.appendChild(divColFuncao);
                divRowFuncao.appendChild(divColTD);
                divRowFuncao.appendChild(divColTR);
                divRowFuncao.appendChild(divColPfb);
                divRowFuncao.appendChild(divColOperacao);
                divRowFuncao.appendChild(divColDataCadastro);
                divRowFuncao.appendChild(divColAtualizadoPor);
                divAdd.appendChild(divRowFuncao);
                /*
                 * cria os inputs
                 */
                rInput = document.createElement('input');
                rInput.setAttribute('onclick',
                        'insereIdBaseline($(this));');
                rInput.setAttribute('type', 'checkbox');
                rInput.className = 'css-checkbox';
                rInput.id = (b === 'aie' ? b : $(b).val())
                        + '-'
                        + ("000000000" + data[x].id).slice(-9);
                rLabel = document.createElement('label');
                rLabel.className = 'css-label-check';
                rLabel.setAttribute('for', (b === 'aie' ? b
                        : $(b).val())
                        + '-'
                        + ("000000000" + data[x].id).slice(-9));
                rLabel.innerHTML = ("000000000" + data[x].id)
                        .slice(-9)
                        + ' - ' + data[x].funcao;
                divColFuncao.appendChild(rInput);
                divColFuncao.appendChild(rLabel);
                /*
                 * adiciona o restante das informacoes
                 */
                divColPfb.innerHTML = '<strong>PFb</strong>: '
                        + parseFloat(data[x].pfb).toFixed(3);
                divColTD.innerHTML = '<strong>TD</strong>: '
                        + ("0000" + data[x].td).slice(-4);
                divColTR.innerHTML = '<strong>'
                        + (t === 'ali-aie' || t === 'ali' ? 'TR'
                                : 'AR') + '</strong>: '
                        + ("0000" + data[x].tr).slice(-4);
                divColOperacao.innerHTML = divOperacao(data[x].operacao);
                divColDataCadastro.innerHTML = formattedDate(
                        data[x].data_cadastro, false, false);
                divColAtualizadoPor.innerHTML = data[x].atualizado_por;
            }
        } else {
            if (i > 0) {
                swal({
                    title: "Alerta",
                    text: "N&atilde;o h&aacute; "
                            + (b === 'aie' ? arrFuncoes['ali']
                                    + " cadastrados(as) em outras Baselines, "
                                    : arrFuncoes[$(b).val()]
                                    + " cadastrados(as) nesta Baseline, ")
                            + "ou se h&aacute;, ainda n&atilde;o est&atilde;o validados(as). Verifique se a funcionalidade que voc&ecirc; est&aacute; pesquisando j&aacute; est&aacute; inclu&iacute;da na Contagem, evitando duplicidades.",
                    type: "warning",
                    html: true,
                    confirmButtonText: "Entendi, obrigado!"
                });
            }
        }
    }, 'json');
}

/**
 * 
 * @param {type}
 *            c - checkbox clicado
 * @returns {undefined}
 */
function insereIdBaseline(c) {
    /*
     * pesquisa, insere ou exclui
     */
    $(c).prop('checked') ? funcoesItems.push($(c).get(0).id) : funcoesItems
            .splice(funcoesItems.indexOf($(c).get(0).id), 1);
}