$('#form_modal_configuracoes_banco_dados').on('hidden.bs.modal', function () {
    $('#addLinhaBancoDados').empty();
});
/*
 * para todos dos forms a leitura da imagem do captcha eh feita no click para evitar desatualizacoes
 */
$('#link-inserir-banco-dados').on('click', function () {
    if (Number($('#config_id_cliente option:selected').val()) == 0) {
        swal({
            title: "Alerta",
            text: "Por favor selecione um Cliente",
            type: "warning",
            html: true,
            confirmButtonText: "Vou verificar, obrigado!"});
    }
    else {
        $('#form_modal_configuracoes_banco_dados').modal('show');
        atualizaTabelaBancoDados();
    }
});

$('#inserir-banco-dados').on('click', function () {
    var icl = $('#config_id_cliente option:selected').val();
    if (isFornecedor) {
        swal({
            title: "Alerta",
            text: "Voc&ecirc; est&aacute; logado como um Fornecedor, as altera&ccedil;&otilde;es ser&atilde;o descartadas.",
            type: "warning",
            html: true,
            confirmButtonText: "Ok, obrigado!"});
    }
    else {
        inserirAlterarBancoDados('i', 0, icl);
    }
});

/**
 * 
 * @param {type} i1 - id
 * @param {type} i2 - descricao
 * @param {type} i3 - status
 * @param {type} i4 - primeira ou ultima linha da tabela (inserir = 0, alterar = -1
 * @param {type} i5 - cor da linha
 */
function addLinhaBancoDados(i1, i2, i3, i4, i5) {
    var t = $('#addLinhaBancoDados').get(0); //tabela
    var r = t.insertRow(i4); //linha
    i5 !== '' ? r.setAttribute('style', 'background-color:' + i5) : null;
    /*
     * coloca o id na TR para trocar o background
     */
    var c1 = r.insertCell(0); //descricao
    var c2 = r.insertCell(1); //isAtivo
    var c3 = r.insertCell(2); //atualizar

    var vChecked = i3 == 1 ? 'checked' : '';

    c1.innerHTML = '<input type="text" class="input_style" value="' + i2 + '" id="des-' + i1 + '">'; //descricao
    c2.innerHTML = '<input onchange="alteraStatusBancoDados($(this).val(), $(this).prop(\'checked\'));" id="atv-' + i1 + '" value="' + i1 + '" type="checkbox" data-toggle="toggle" data-onstyle="success" data-style="slow" data-on="Ativo" data-off="Inativo" data-width="100" data-height="36" class="datatoggle" ' + vChecked + ' ' + (isFornecedor ? 'disabled' : '') + '>';
    c3.innerHTML = '<button type="button" class="btn btn-default" onclick="atualizaLinguagem($(this).val());" value="' + i1 + ' ' + (isFornecedor ? 'disabled' : '') + '">&nbsp;<i class="fa fa-refresh"></i>&nbsp;Atualizar</button>';
    /*
     * inicializacao manual dos datatoggles
     */
    $('.datatoggle').bootstrapToggle();
}

function alteraStatusBancoDados(id, prop) {
    if (!isFornecedor) {
        iWait('w_banco_dados_status', true);
        $.post('/pf/DIM.Gateway.php', {
            'i': id,
            'p': prop ? 1 : 0,
            'arq': 88, //action
            'tch': 0,
            'sub': 0,
            'dlg': 1}, function (data) {
            iWait('w_banco_dados_status', false);
        }, 'json');
    }
}

function atualizaTabelaBancoDados() {
    $('#addLinhaBancoDados').empty();
    iWaitMenuContagem('w_calibracao_banco_dados', true, 'fa fa-database');
    $.post('/pf/DIM.Gateway.php', {
        'arq': 95,
        'tch': 1, //api
        'sub': 0,
        'dlg': 1,
        'icl': $('#config_id_cliente option:selected').val()
    }, function (data) {
        for (x = 0; x < data.length; x++) {
            addLinhaBancoDados(
                    data[x].id,
                    data[x].descricao,
                    data[x].is_ativo, -1, '');
        }
        iWaitMenuContagem('w_calibracao_banco_dados', false, 'fa fa-database');
    }, 'json');
}

function atualizaBancoDados(id) {
    var icl = $('#config_id_cliente option:selected').val();
    if (!isFornecedor) {
        inserirAlterarBancoDados('a', id, icl);
    }
}

