/*
 * variavel que armazena o id anterior acionado no clique da alteracao
 */
var previousId = 0;
/*
 * modal do fator de impacto
 */
$("#href_modal_fator_impacto").on("click", function () {
    comboRoteiro('item_roteiro', '01', 0, 1);
});

$("#fatores_todos").on("click", function () {
    selecionaFatoresTodos($(this).prop('checked'));
});
$("#tipo_acao_todos").on("click", function () {
    selecionaTipoAcaoTodos($(this).prop('checked'));
});
//clique no botao para fechar a janela do cliente
$('#fechar_item_roteiro').on('click', function () {
    limpaCamposFatorImpacto(true);
    return true;
});

//clique no botao para inserir um novo cliente
$('#fti_btn_novo').on('click', function () {
    limpaCamposFatorImpacto(false);
    return true;
});

$('#item_roteiro_id_roteiro').on('change', function () {
    limpaCamposFatorImpacto(false);
    atualizaTabelaFatorImpacto($(this).val(), 0, 0);
});

$('#item_roteiro_tipo').on('change', function () {
    if (!($(this).prop('checked'))) {
        $('#item_roteiro_operador').bootstrapToggle('enable').bootstrapToggle('on');
    }
    else {
        $('#item_roteiro_operador').bootstrapToggle('on').bootstrapToggle('disable');
    }
});
/*
 * envio e validacao do formulario
 */
$('#form_inserir_alterar_item').on('submit', function () {
    var aplicaAli = '';
    var aplicaAie = '';
    var aplicaEe = '';
    var aplicaSe = '';
    var aplicaCe = '';
    var aplicaOu = '';
    var aplicaTodos = '';
    var aplicaAcaoTodos = '';
    var tipoAcaoI = '';
    var tipoAcaoE = '';
    var tipoAcaoA = '';
    var tipoAcaoT = '';
    /*
     * variaveis e itens
     */
    if ($('#fatores_todos').prop('checked')) {
        aplicaTodos = 'ALI;AIE;EE;SE;CE;OU;';
    }
    else {
        aplicaAli = $('#item_roteiro_funcao1').prop('checked') ? 'ALI;' : '';
        aplicaAie = $('#item_roteiro_funcao2').prop('checked') ? 'AIE;' : '';
        aplicaEe = $('#item_roteiro_funcao3').prop('checked') ? 'EE;' : '';
        aplicaSe = $('#item_roteiro_funcao4').prop('checked') ? 'SE;' : '';
        aplicaCe = $('#item_roteiro_funcao5').prop('checked') ? 'CE;' : '';
        aplicaOu = $('#item_roteiro_funcao6').prop('checked') ? 'OU;' : '';
        aplicaAlguns = aplicaAli + '' + aplicaAie + '' + aplicaEe + '' + aplicaSe + '' + aplicaCe + '' + aplicaOu;
    }
    /*
     * verifica se nao houve selecao de opcoes e atribui automaticamente
     */
    if (aplicaTodos === '' && aplicaAli === '' && aplicaAie === '' && aplicaEe === '' && aplicaSe === '' && aplicaCe === '' && aplicaOu === '') {
        $('#fatores_todos').prop('checked', true);
        $('#item_roteiro_funcao1').prop('checked', true);
        $('#item_roteiro_funcao2').prop('checked', true);
        $('#item_roteiro_funcao3').prop('checked', true);
        $('#item_roteiro_funcao4').prop('checked', true);
        $('#item_roteiro_funcao5').prop('checked', true);
        $('#item_roteiro_funcao6').prop('checked', true);
        aplicaTodos = 'ALI;AIE;EE;SE;CE;OU;';
    }
    /*
     * variaveis acoes
     */
    if ($('#tipo_acao_todos').prop('checked')) {
        aplicaAcaoTodos = 'I;A;E;T;';
    }
    else {
        tipoAcaoI = $('#tipo_acao_1').prop('checked') ? 'I;' : '';
        tipoAcaoA = $('#tipo_acao_2').prop('checked') ? 'A;' : '';
        tipoAcaoE = $('#tipo_acao_3').prop('checked') ? 'E;' : '';
        tipoAcaoT = $('#tipo_acao_4').prop('checked') ? 'T;' : '';
        aplicaAcaoAlguns = tipoAcaoI + '' + tipoAcaoA + '' + tipoAcaoE + '' + tipoAcaoT;
    }
    /*
     * verifica se nao houve selecao e aplica a todos
     */
    if (aplicaAcaoTodos === '' && tipoAcaoI === '' && tipoAcaoA === '' && tipoAcaoE === '' && tipoAcaoT === '') {
        $('#tipo_acao_todos').prop('checked', true);
        $('#tipo_acao_1').prop('checked', true);
        $('#tipo_acao_2').prop('checked', true);
        $('#tipo_acao_3').prop('checked', true);
        $('#tipo_acao_4').prop('checked', true);
        aplicaAcaoTodos = 'I;A;E;T;';
    }
    /*
     * verifica a selecao do roteiro
     */
    if ($('#item_roteiro_id_roteiro').val() < 1) {
        swal({
            title: "Alerta",
            text: "Por favor selecione um roteiro para adicionar este item",
            type: "error",
            html: true,
            confirmButtonText: "Vou verificar, obrigado!"});
    }
    else {
        $.post('/pf/DIM.Gateway.php', {
            'id': $('#fti_id').val(),
            'acao': $('#fti_acao').val(),
            'is_ativo': $('#item_roteiro_is_ativo').prop('checked') ? 1 : 0,
            'descricao': $('#item_roteiro_descricao').val(),
            'fator': $('#item_roteiro_fator').val(),
            'fonte': $('#item_roteiro_fonte').val(),
            'id_roteiro': $('#item_roteiro_id_roteiro').val(),
            'operacao': $('#tipo_acao_todos').prop('checked') ? aplicaAcaoTodos : aplicaAcaoAlguns, //I,A,E...etc
            'operador': $('#item_roteiro_operador').prop('checked') ? 0 : 1,
            'sigla': $('#item_roteiro_sigla').val(),
            'tipo': $('#item_roteiro_tipo').prop('checked') ? 'A' : 'F',
            'aplica': $('#fatores_todos').prop('checked') ? aplicaTodos : aplicaAlguns, //ALI, AIE, EE...etc
            'arq': 46,
            'tch': 0,
            'sub': 0,
            'dlg': 1
        }, function (data) {
            /*
             * verifica se o usuario nao selecionou nenhuma aplicacao/operacao e aplica a todos
             */
            if (data.id > 0) {
                swal({
                    title: "Informa&ccedil;&atilde;o",
                    text: data.msg,
                    type: "success",
                    html: true,
                    confirmButtonText: "Obrigado!"});
                if ($('#fti_acao').val() === 'inserir') {
                    addLinhaFatorImpacto(
                            data.id,
                            $('#item_roteiro_is_ativo').prop('checked') ? 'on' : 'off',
                            $('#item_roteiro_descricao').val(),
                            $('#item_roteiro_fator').val(),
                            $('#item_roteiro_fonte').val(),
                            $('#tipo_acao_todos').prop('checked') ? aplicaAcaoTodos : aplicaAcaoAlguns,
                            $('#item_roteiro_sigla').val(),
                            $('#item_roteiro_tipo').prop('checked') ? 'A' : 'F',
                            $('#fatores_todos').prop('checked') ? aplicaTodos : aplicaAlguns,
                            idEmpresa,
                            $('#item_roteiro_operador').prop('checked') ? ' (M)' : ' (D)');
                    previousId = data.id;
                    $('#tr_' + previousId).animate({opacity: '.5'}, 1000);
                    $('#fti_acao').val('alterar');
                    $('#fti_id').val(data.id);
                    $('#fti_btn_inserir').prop('disabled', true);
                    $('#fti_btn_novo').prop('disabled', false);
                    $('#fti_btn_atualizar').prop('disabled', false);
                }
                else if ($('#fti_acao').val() === 'alterar') {
                    $('#tr_' + data.id).animate({opacity: '1.0'}, 1000);
                    $('#sigla_' + data.id).html($('#item_roteiro_sigla').val());
                    $('#descricao_' + data.id).html($('#item_roteiro_descricao').val());
                    $('#fonte_' + data.id).html($('#item_roteiro_fonte').val());
                    $('#operacao_' + data.id).html(
                            $('#tipo_acao_todos').prop('checked') ?
                            aplicaAcaoTodos.replace(/;/g, '-').substring(0, (aplicaAcaoTodos.length - 1)) :
                            aplicaAcaoAlguns.replace(/;/g, '-').substring(0, (aplicaAcaoAlguns.length - 1))
                            );
                    $('#aplica_' + data.id).html(
                            $('#fatores_todos').prop('checked') ?
                            aplicaTodos.replace(/;/g, '-').substring(0, (aplicaTodos.length - 1)) :
                            aplicaAlguns.replace(/;/g, '-').substring(0, (aplicaAlguns.length - 1)));
                    $('#tipo_' + data.id).html($('#item_roteiro_tipo').prop('checked') ? 'A' : 'F' + ($('#item_roteiro_operador').prop('checked') ? ' (M)' : ' (D)'));
                    limpaCamposFatorImpacto(false);
                }
            }
        }, 'json');
    }
    return false;
});
/**
 * 
 * @param {type} i1 - id
 * @param {type} i2 - status
 * @param {type} i3 - descricao
 * @param {type} i4 - ajuste
 * @param {type} i5 - fonte
 * @param {type} i6 - operacao
 * @param {type} i7 - sigla
 * @param {type} i8 - tipo
 * @param {type} i9 - aplicavel
 * @param {type} i10 - idEmpresa
 * @returns {undefined}
 */
function addLinhaFatorImpacto(i1, i2, i3, i4, i5, i6, i7, i8, i9, i10, i11) {
    var t = $('#addFatorImpacto').get(0); //tabela
    var r = t.insertRow(-1); //linha
    var a = (i10 == 0 && idEmpresa != 1) ? false : true;
    /*
     * coloca o id na TR para trocar o background
     */
    r.id = "tr_" + i1;

    var c1 = r.insertCell(0); //
    var c2 = r.insertCell(1);
    var c3 = r.insertCell(2);
    var c4 = r.insertCell(3);
    var c5 = r.insertCell(4);
    var c6 = r.insertCell(5);
    var c7 = r.insertCell(6);

    var vChecked = i2 === 'on' ? 'checked' : '';
    var vDisable = a ? '' : 'disabled';

    c1.innerHTML = a ? '<a href="#" onclick="limpaCamposFatorImpacto(false); exibeFatorImpactoAlteracao(' + i1 + ');">' + '<span id="sigla_' + i1 + '">' + i7 + '</span>' + '</a> - ' + '<span id="descricao_' + i1 + '">' + i3 + '</span>' : i7 + ' - ' + i3; //sigla - descricao
    c2.innerHTML = '<span id="fonte_' + i1 + '">' + i5 + '</span>'; //fonte
    c3.innerHTML = i4; //ajuste
    c4.innerHTML = '<input onchange="alteraStatusFatorImpacto($(this).val(), $(this).prop(\'checked\'));" value="' + i1 + '" type="checkbox" data-toggle="toggle" data-onstyle="success" data-style="slow" data-on="Ativo" data-off="Inativo" class="datatoggle" ' + vChecked + ' ' + vDisable + '>';
    c5.innerHTML = '<span id="operacao_' + i1 + '">' + i6.replace(/;/g, '-').substring(0, (i6.length - 1)) + '<span>'; //operacao - fazer strip para exibir corretamente
    c6.innerHTML = '<span id="aplica_' + i1 + '">' + i9.replace(/;/g, '-').substring(0, (i9.length - 1)) + '</span>'; //aplicavel - fazer strip para exibir corretamente
    c7.innerHTML = '<span id="tipo_' + i1 + '">' + i8 + (i11 == 0 ? ' (M)' : ' (D)') + '</span>'; //tipo
    /*
     * inicializacao manual dos datatoggles
     */
    $('.datatoggle').bootstrapToggle();
}

function exibeFatorImpactoAlteracao(id) {
    $.post('/pf/DIM.Gateway.php', {'i': id, 'ti': 0, 'tc': 1, 'arq': 68, 'tch': 1, 'sub': 0, 'dlg': 1}, function (data) {
        $('#item_roteiro_sigla').val(data[0].sigla);
        $('#item_roteiro_fator').val(data[0].fator).prop('disabled', true);
        $('#item_roteiro_descricao').val(data[0].descricao);
        $('#item_roteiro_fonte').val(data[0].fonte);
        /*
         * verifica quais aplicabilidades foram selecionadas
         */
        arrFatoresTodos = data[0].aplica.split(';');
        if (arrFatoresTodos.length == 7) {
            /*
             * todos os fatores
             */
            $('#fatores_todos').prop('checked', true);
            selecionaFatoresTodos(true);
        }
        else {
            /*
             * um a um dos fatores
             */
            $('#fatores_todos').prop('checked', false);
            for (x = 0; x < arrFatoresTodos.length; x++) {
                switch (arrFatoresTodos[x]) {
                    case 'ALI':
                        $('#item_roteiro_funcao1').prop('checked', true);
                        break;
                    case 'AIE':
                        $('#item_roteiro_funcao2').prop('checked', true);
                        break;
                    case 'EE':
                        $('#item_roteiro_funcao3').prop('checked', true);
                        break;
                    case 'SE':
                        $('#item_roteiro_funcao4').prop('checked', true);
                        break;
                    case 'CE':
                        $('#item_roteiro_funcao5').prop('checked', true);
                        break;
                    case 'OU':
                        $('#item_roteiro_funcao6').prop('checked', true);
                        break;
                }
            }
        }
        /*
         * verifica quais tipos de operacao foram selecionadas
         */
        arrAplicaAcaoTodos = data[0].operacao.split(';');
        if (arrAplicaAcaoTodos.length == 5) {
            /*
             * todas as acoes
             */
            $('#tipo_acao_todos').prop('checked', true);
            selecionaTipoAcaoTodos(true);
        }
        else {
            /*
             * uma a uma das ações
             */
            $('#tipo_acao_todos').prop('checked', false);
            for (x = 0; x < arrAplicaAcaoTodos.length; x++) {
                switch (arrAplicaAcaoTodos[x]) {
                    case 'I':
                        $('#tipo_acao_1').prop('checked', true);
                        break;
                    case 'A':
                        $('#tipo_acao_2').prop('checked', true);
                        break;
                    case 'E':
                        $('#tipo_acao_3').prop('checked', true);
                        break;
                    case 'T':
                        $('#tipo_acao_4').prop('checked', true);
                        break;
                }
            }
        }

        $('#item_roteiro_tipo').bootstrapToggle(data[0].tipo === 'A' ? 'on' : 'off');
        $('#item_roteiro_operador').bootstrapToggle(data[0].operador == 0 ? 'on' : 'off');
        $('#item_roteiro_is_ativo').bootstrapToggle(data[0].isAtivo).bootstrapToggle('disable');
        $('#fti_id').val(id);
        $('#fti_acao').val('alterar');
        $('#fti_btn_novo').prop('disabled', false);
        $('#fti_btn_inserir').prop('disabled', true);
        $('#fti_btn_atualizar').prop('disabled', false);
        /*
         * muda o estilo da linha e verifica se ja havia uma linha selecionada
         */
        if (previousId == 0) {
            $('#tr_' + id).animate({opacity: '.5'}, 1000);
            previousId = id;
        }
        else {
            $('#tr_' + previousId).animate({opacity: '1.0'}, 1000);
            $('#tr_' + id).animate({opacity: '.5'}, 1000);
            previousId = id;
        }
    }, 'json');
}

function alteraStatusFatorImpacto(id, prop) {
    iWait('w_fator_impacto_status', true);
    /*
     * sincroniza os datatoggles em caso de clicar para alterar e clicar para inativar/ativar
     */
    if ($('#fti_id').val() !== '' && $('#fti_id').val() === id) {
        $('#item_roteiro_is_ativo').bootstrapToggle('enable').bootstrapToggle(prop ? 'on' : 'off').bootstrapToggle('disable');
    }
    $.post('/pf/DIM.Gateway.php', {'i': id, 'p': prop ? 1 : 0, 'arq': 35, 'tch': 0, 'sub': 0, 'dlg': 1}, function (data) {
        iWait('w_fator_impacto_status', false);
    }, 'json');
}

/**
 * 
 * @param {type} t - limpar ou nao a tabela (caso seja os botoes fechar, limpa as tabelas
 * @returns {undefined}
 */
function limpaCamposFatorImpacto(t) {
    $('#fti_acao').val('inserir');
    $('#fti_id').val(''); //depois que inserir este campo armazena o id recem gerado para atualizacoes
    $('#item_roteiro_sigla').val('');
    $('#item_roteiro_fator').val('').prop('disabled', false);
    $('#item_roteiro_descricao').val('');
    $('#item_roteiro_fonte').val('');
    $('#fatores_todos').prop('checked', false);
    $('#item_roteiro_funcao1').prop('checked', false);
    $('#item_roteiro_funcao2').prop('checked', false);
    $('#item_roteiro_funcao3').prop('checked', false);
    $('#item_roteiro_funcao4').prop('checked', false);
    $('#item_roteiro_funcao5').prop('checked', false);
    $('#item_roteiro_funcao6').prop('checked', false);
    $('#tipo_acao_todos').prop('checked', false);
    $('#tipo_acao_1').prop('checked', false);
    $('#tipo_acao_2').prop('checked', false);
    $('#tipo_acao_3').prop('checked', false);
    $('#tipo_acao_4').prop('checked', false);
    $('#item_roteiro_tipo').bootstrapToggle('on');
    $('#item_roteiro_operador').bootstrapToggle('on').bootstrapToggle('disable');
    $('#item_roteiro_is_ativo').bootstrapToggle('on').bootstrapToggle('enable');
    $('#fti_btn_novo').prop('disabled', true);
    $('#fti_btn_inserir').prop('disabled', false);
    $('#fti_btn_atualizar').prop('disabled', true);
    /*
     * limpa a tabela apenas em casos especificos para evitar pesquisa na rede (json)
     */
    if (t) {
        $('#addFatorImpacto').empty();
    }
    /*
     * verifica se ha uma linha selecionada para alteracao
     */
    if (previousId > 0) {
        $('#tr_' + previousId).animate({opacity: '1.0'}, 1000);
        previousId = 0;
    }
    arrAplicaAcaoTodos = [];
    arrFatoresTodos = [];
}

/*
 * funcao para selecionar todos os fatores (aplica)
 */
function selecionaFatoresTodos(b) {
    for (x = 1; x <= 6; x++) {
        $("#item_roteiro_funcao" + x).prop("checked", b);
    }
}

/*
 * funcao para selecionar todos os tipos de acao I, A e E
 */
function selecionaTipoAcaoTodos(b) {
    for (x = 1; x <= 4; x++) {
        $("#tipo_acao_" + x).prop("checked", b);
    }
}

/*
 * funcao para atualizar a tabela com os fatores de impacto
 */
function atualizaTabelaFatorImpacto(id) {
    if (id > 0) {
        //var idEmpresa;
        iWait('w_item_roteiro_id_roteiro', true);
        $.post('/pf/DIM.Gateway.php', {'i': id, 'tc': 0, 't': '01', 'arq': 68, 'tch': 1, 'sub': 0, 'dlg': 1}, function (data) {
            $('#addFatorImpacto').empty();
            for (x = 0; x < data.length; x++) {
                addLinhaFatorImpacto(
                        data[x].id,
                        data[x].isAtivo,
                        data[x].descricao,
                        data[x].fator,
                        data[x].fonte,
                        data[x].operacao,
                        data[x].sigla,
                        data[x].tipo,
                        data[x].aplica,
                        data[x].idEmpresa,
                        data[x].operador//i11
                        );
                //idEmpresa = data[x].idEmpresa;
            }
            //TODO: rever pois esta atrelado a um id no banco, ver como pegar o id da empesa apenas para estes casos
            $('#fti_btn_inserir').prop('disabled', (Number(id) == 1 || Number(id) == 2 || Number(id) == 3) ? true : false);
            iWait('w_item_roteiro_id_roteiro', false);
        }, 'json');
    }
    else {
        $('#addFatorImpacto').empty();
    }
}

function verificaFatoresTodos(b) {
    if (!b) {
        $('#fatores_todos').prop('checked', false);
    }
    else if (
            $('#item_roteiro_funcao1').prop('checked') &&
            $('#item_roteiro_funcao2').prop('checked') &&
            $('#item_roteiro_funcao3').prop('checked') &&
            $('#item_roteiro_funcao4').prop('checked') &&
            $('#item_roteiro_funcao5').prop('checked') &&
            $('#item_roteiro_funcao6').prop('checked')) {
        $('#fatores_todos').prop('checked', true);
    }
}

function verificaAcaoTodos(b) {
    if (!b) {
        $('#tipo_acao_todos').prop('checked', false);
    }
    else if (
            $('#tipo_acao_1').prop('checked') &&
            $('#tipo_acao_2').prop('checked') &&
            $('#tipo_acao_3').prop('checked') &&
            $('#tipo_acao_4').prop('checked')) {
        $('#tipo_acao_todos').prop('checked', true);
    }
}
