$('#btn-listar-itens-dados').on('click', function () {
    listarItens($('#dados_id_roteiro').val(), 'ALI;AIE');
});

$('#btn-listar-itens-transacao').on('click', function () {
    listarItens($('#transacao_id_roteiro').val(), 'EE;SE;CE');
});

$('#btn-listar-itens-outros').on('click', function () {
    listarItens($('#outros_id_roteiro').val(), 'OU');
});

/*
 * VERIFICAR NA VERSAO 2.0
$('#btn-dados-detalhe-fator').on('click', function () {
    Number($('#dados_impacto').val()) != 0 ? detalheItem(($('#dados_impacto').val()).split(';'), 'dados') : null;
});

$('#btn-transacao-detalhe-fator').on('click', function () {
    Number($('#transacao_impacto').val()) != 0 ? detalheItem(($('#transacao_impacto').val()).split(';'), 'transacao') : null;
});

$('#btn-outros-detalhe-fator').on('click', function () {
    Number($('#outros_impacto').val()) != 0 ? detalheItem(($('#outros_impacto').val()).split(';'), 'outros') : null;
});
*/
detalheItem(($('#outros_impacto').val()).split(';'), 'outros')

function listarItens(idRoteiro, aplica) {
    $.post('/pf/DIM.Gateway.php', {'i': idRoteiro, 'l': aplica, 'arq': 35, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
        var tabela = $('#addItemLista').empty().get(0);
        var row;
        for (x = 0; x < data.length; x++) {
            row = tabela.insertRow(-1);
            var cell0 = row.insertCell(0);
            var cell1 = row.insertCell(1);
            var cell2 = row.insertCell(2);
            var cell3 = row.insertCell(3);
            var cell4 = row.insertCell(4);
            var cell5 = row.insertCell(5);

            cell0.innerHTML = data[x].sigla;
            cell1.innerHTML = data[x].descricao;
            cell2.innerHTML = Number(data[x].fator).toFixed(3);
            cell3.innerHTML = data[x].fonte;
            cell4.innerHTML = (data[x].operacao).replace(/;/g, ' ');
            cell5.innerHTML = (data[x].aplica).replace(/;/g, ' ');
        }
    }, 'json');
}