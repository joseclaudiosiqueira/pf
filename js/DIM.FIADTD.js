/*
 * captura o hidden e o show do bs.modal
 */
$('#form-modal-inserir-alterar-listas').on('hidden.bs.modal', function () {
    limpaCamposLista($('#descricao-funcao-td').val());
});
/*
 * captura do submit do form
 */
$('#form-linha-lista').on('submit', function () {
    return false;
});

$('#btn-adicionar-linha-lista').on('click', function () {
    adicionaLinhaForm();
    return false;
});

$('#descricao-linha-lista').on('change', function () {
    adicionaLinhaForm();
    return false;
});

function adicionaLinhaForm() {
    var idPrimario = $('#id-linha-descricao').val(); //se nao for zero significa alteracao via id com ajax na tabela
    var idDescricao = $('#id-descricao-td').val(); //id da descricao do td vindo da tabela via ajax;
    var acao = $('#operacao-linha-lista').val();
    var funcao = $('#descricao-funcao-td').val(); //dados - transacao
    var descricao = $('#descricao-linha-lista').val();
    var tbl = $('#' + funcao + '_tabela').val(); //na insercao vira "funcao" novamente
    var tabela = tbl.toLowerCase();

    if (acao === 'alterar-em-memoria') {
        $('#descricao-linha-lista-' + $('#id-span-linha-lista').val()).html(descricao);
        arrLinhasAtuaisTD[arrLinhasAtuaisTD.indexOf($('#descricao-anterior').val())] = descricao;
    }
    else if (acao === 'alterar-em-ajax') {
        $('#descricao-linha-lista-' + $('#id-span-linha-lista').val()).html(descricao);
        $.post('/pf/DIM.Gateway.php', {
            'id': idDescricao, 'd': descricao, 'a': 'alterar', 't': tabela, 'arq': 21, 'tch': 0, 'sub': -1, 'dlg': 1}, function (data) {
        }, 'json');
    }
    else if (acao === 'inserir') {
        /*
         * verifica se exite um id e/ou insere na memoria ou diretamente no banco
         */
        if (idPrimario > 0) {
            $.post('/pf/DIM.Gateway.php', {
                'ip': idPrimario, 'd': descricao, 'a': acao, 't': tabela, 'arq': 21, 'tch': 0, 'sub': -1, 'dlg': 1}, function (data) {
                var id = ('000000' + data.id).slice(-6);
                addLinhaLista(id, descricao, funcao, false);
                var qtd = Number($('#' + funcao + '-badge-td').html());
                $('#' + funcao + '-badge-td').html(qtd + 1);
                if ($('#' + funcao + '_metodo').val() == 3) {//soma apenas se o metodo for detalhado
                    $('#' + funcao + '_td').val(qtd + 1);
                }
            }, 'json');
        }
        else {
            var id = ('000000' + Math.floor((Math.random() * 100000) + 1)).slice(-6);
            addLinhaLista(id, descricao, funcao, true);
        }
    }
    /*
     * zera tudo novamente
     */
    $('#descricao-linha-lista').val('').get(0).focus();
    $('#btn-adicionar-linha-lista').html('<i class="fa fa-plus-circle"></i>&nbsp;Adicionar');
    $('#operacao-linha-lista').val('inserir');
    $('#id-span-linha-lista').val('');
    $('#descricao-anterior').val('');
    return false;
}

$('#fechar-listas').on('click', function () {
    limpaCamposLista($('#descricao-funcao-td').val());
});
/*
 * verifica se ainda esta em memoria e joga o array novamente para a tabela
 */
$('#desc-td-dados').on('click', function () {
    var id = $('#id-linha-descricao').val();
    var funcao = $('#descricao-funcao-td').val(); //dados - transacao
    var tabela = $('#' + funcao + '_tabela').val(); //na insercao vira "funcao" novamente
    if (id == 0) {
        if (arrLinhasAtuaisTD.length > 0) {
            tVal = arrLinhasAtuaisTD.length;
            for (x = 0; x < tVal; x++) {
                var id = ('000000' + Math.floor((Math.random() * 100000) + 1)).slice(-6);
                addLinhaLista(id, arrLinhasAtuaisTD[x], 'dados', false); //false para nao somar nada
            }
        }
    }
    /*
     * get lista via ajax
     * passar t=0 para lista e t=1 para um individual
     */
    else {
        $.post('/pf/DIM.Gateway.php', {'i': id, 't': 0, 'f': tabela.toLowerCase(), 'arq': 33, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
            if (data.length > 0) {
                if (data[0].id == 0) {
                    swal({
                        title: "Alerta",
                        text: "Houve um erro na procura pelo #ID, favor refa&ccedil;a a opera&ccedil;&atilde;o",
                        type: "error",
                        html: true,
                        confirmButtonText: "Vou verificar, obrigado!"});
                }
                else {
                    for (x = 0; x < data.length; x++) {
                        var id = ('000000' + data[x].id).slice(-6);
                        addLinhaLista(id, data[x].descricao, 'dados', true);
                    }
                }
            }
        }, 'json');
    }
    $('#descricao-funcao-td').val('dados');
});

$('#desc-td-transacao').on('click', function () {
    var id = $('#id-linha-descricao').val();
    var funcao = $('#descricao-funcao-td').val(); //dados - transacao
    var tabela = $('#' + funcao + '_tabela').val(); //na insercao vira "funcao" novamente    
    if (id == 0) {
        if (arrLinhasAtuaisTD.length > 0) {
            tVal = arrLinhasAtuaisTD.length;
            for (x = 0; x < tVal; x++) {
                var id = ('000000' + Math.floor((Math.random() * 100000) + 1)).slice(-6);
                addLinhaLista(id, arrLinhasAtuaisTD[x], 'transacao', false);
            }
        }
    }
    /*
     * get lista via ajax
     * passar t=0 para lista e t=1 para um individual
     */
    else {
        $.post('/pf/DIM.Gateway.php', {'i': id, 't': 0, 'f': tabela.toLowerCase(), 'arq': 33, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
            if (data.length > 0) {
                for (x = 0; x < data.length; x++) {
                    var id = ('000000' + data[x].id).slice(-6);
                    addLinhaLista(id, data[x].descricao, 'transacao', true);
                }
            }
        }, 'json');
    }
    $('#descricao-funcao-td').val('transacao');
});
/**
 * @param {type} i1
 * @param {type} i2
 * @param {type} f - funcao (dados/transacao)
 * @param {type} b - boolean ... evita duplicacoes no array (true soma/ false nao soma
 * @returns {undefined}
 */
function addLinhaLista(i1, i2, f, b) {
    //TODO: precisa saber se eh transacao ou dados
    var t = $('#addLinhaLista').get(0); //tabela
    var r = t.insertRow(-1); //linha
    var i = $('#id-linha-descricao').val();
    var tp = '';

    r.className = 'fadeIn';

    var c1 = r.insertCell(0);
    var c2 = r.insertCell(1);
    var c3 = r.insertCell(2);
    /*
     * verifica se e uma alteracao ou ainda esta apenas na memoria
     */
    if (i == 0) {
        tp = 'm';
        c1.innerHTML = '#' + i1;
        c2.innerHTML = '<a href="#" onclick="exibeLinhaAlteracaoDescricao(\'' + i1 + '\', \'m\');"><span id="descricao-linha-lista-' + i1 + '">' + i2 + '</span></a>';
        /*
         * insere a descricao na linha em memoria
         */
        if (b) {
            arrLinhasAtuaisTD.push(i2);
            $('#' + f + '-badge-td').html(arrLinhasAtuaisTD.length);
            if ($('#' + f + '_metodo') == 3)//soma apenas se o metodo for detalhado
                $('#' + f + '_td').val(arrLinhasAtuaisTD.length);
        }
    }
    else {
        tp = 'a';
        c1.innerHTML = '<a href="#" onclick="exibeLinhaAlteracaoDescricao(\'' + i1 + '\', \'a\');">#' + i1 + '</a>';
        c2.innerHTML = '<span id="descricao-linha-lista-' + i1 + '">' + i2 + '</span>';
    }
    var btnExcluir = document.createElement('button');
    btnExcluir.type = 'button';
    btnExcluir.className = 'btn btn-default btn-block btn-xs';
    btnExcluir.innerHTML = '<i class="fa fa-trash"></i>';
    btnExcluir.setAttribute("onclick", "excluirLinhaLista('" + i1 + "', parentNode.parentNode.rowIndex, '" + i2 + "', '" + tp + "', '" + f + "');");
    btnExcluir.id = 'excluir_' + i1;
    btnExcluir.disabled = isAutorizadoAlterar ? false : true; //negativa do is autorizado porque o disabled tem que ser false
    c3.appendChild(btnExcluir);
}
/**
 * 
 * @param {Int}     i - id da linha de descricao (vinda do banco ou do array em memoria
 * @param {String}  n - node parentNode.Index
 * @param {Int}     d - descricao
 * @param {String)  tp - tipo - em memoria ou ajax
 * @param {String}  f - funcao - dados/transacao
 * @returns {Boolean}
 */
function excluirLinhaLista(i, n, d, tp, f) {
    var t = document.getElementById('addLinhaLista');
    t.deleteRow(n - 1);
    tp === 'm' ? arrLinhasAtuaisTD.splice(arrLinhasAtuaisTD.indexOf(d), 1) : $.post(
            '/pf/DIM.Gateway.php',
            {'id': parseInt(i), 'a': 'excluir', 'arq': 21, 'tch': 0, 'sub': -1, 'dlg': 1},
    function (data) {
    }, 'json');
    if (tp === 'm') {
        $('#' + f + '-badge-td').html(arrLinhasAtuaisTD.length);
        arrLinhasAtuaisTD.length == 0 ? $('#' + f + '_td').val(1) : $('#' + f + '_td').val(arrLinhasAtuaisTD.length);
    }
    else {
        $('#' + f + '-badge-td').html(parseInt($('#' + f + '-badge-td').html()) - 1);
        Number($('#' + f + '-badge-td').html()) == 0 ? $('#' + f + '_td').val(1) : $('#' + f + '_td').val(parseInt($('#' + f + '-badge-td').html()));
    }
    $('#descricao-linha-lista').val('').get(0).focus();
    return true;
}
/**
 * 
 * @param {type} i - id da linha para alteracao no span
 * @param {type} t - tipo - em memoria ou ajax
 * @returns {undefined}
 */
function exibeLinhaAlteracaoDescricao(i, t) {
    $('#descricao-linha-lista').val($('#descricao-linha-lista-' + i).html()).get(0).focus();
    $('#id-span-linha-lista').val(i);
    $('#id-descricao-td').val(parseInt(i));
    $('#btn-adicionar-linha-lista').html('<i class="fa fa-refresh"></i>&nbsp;Atualizar');
    t === 'm' ? $('#operacao-linha-lista').val('alterar-em-memoria') : $('#operacao-linha-lista').val('alterar-em-ajax');
    $('#descricao-anterior').val($('#descricao-linha-lista-' + i).html());
}
/**
 * 
 * @returns {Boolean}
 */
function limpaCamposLista(f) {
    /*
     * TODO: verificar a situacao de insercao ou alteracao
     * TODO: verificar a passagem de f = dados/transacao
     */
    $('#addLinhaLista').empty();
    $('#descricao-linha-lista').val('');
    $('#tipo-linha-lista').val('');
    if (Number($('#id-linha-descricao').val()) == 0) {
        $('#id-linha-descricao').val('0'); //id da linha que esta sendo inserida. Se for em memoria o valor eh zero
    }
    //TODO: aparentemente nao precisa limpar
    //$('#descricao-funcao-td').val('');
    $('#id-descricao-td').val('');
    return true;
}