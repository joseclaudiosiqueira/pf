$('#form_modal_configuracoes_cocomo_linguagem').on('hidden.bs.modal', function () {
    $('#addLinhaLinguagem').empty();
});

$('#form_modal_configuracoes_cocomo_linguagem').on('shown.bs.modal', function () {
    atualizaTabelaLinguagem();
});

$('#inserir-linguagem').on('click', function () {
    if (isFornecedor) {
        swal({
            title: "Alerta",
            text: "Voc&ecirc; est&aacute; logado como um Fornecedor, as altera&ccedil;&otilde;es ser&atilde;o descartadas.",
            type: "warning",
            html: true,
            confirmButtonText: "Ok, obrigado!"});
    }
    else {
        var icl = $('#config_id_cliente option:selected').val();
        inserirAlterarLinguagem('i', 0, icl);
    }
});

/**
 * 
 * @param {type} i1 - id
 * @param {type} i2 - descricao
 * @param {type} i3 - status
 * @param {type} i4 - baixa
 * @param {type} i5 - media
 * @param {type} i6 - alta
 * @param {type} i7 - sloc
 * @param {type} i8 - primeira ou ultima linha da tabela (inserir = 0, alterar = -1
 * @param {type} i9 - cor da linha
 * @param {type} i10 - fator_tecnologia
 * @param {type} i11 - is_ft
 */
function addLinhaLinguagem(i1, i2, i3, i4, i5, i6, i7, i8, i9, i10, i11) {
    var t = $('#addLinhaLinguagem').get(0); //tabela
    var r = t.insertRow(i8); //linha 0 ou -1, inicio ou fim da tabela
    i9 !== '' ? r.setAttribute('style', 'background-color:' + i9) : null;
    /*
     * coloca o id na TR para trocar o background
     */
    var c1 = r.insertCell(0); //descricao
    var c2 = r.insertCell(1); //alta
    var c3 = r.insertCell(2); //media
    var c4 = r.insertCell(3); //baixa
    var c5 = r.insertCell(4); //sloc
    var c6 = r.insertCell(5); //fator tecnologia
    var c7 = r.insertCell(6);//is_ft
    var c8 = r.insertCell(7); //status
    var c9 = r.insertCell(8); //acao

    var vChecked = i3 == 1 ? 'checked' : '';
    var vCheckedIsFT = i11 == 1 ? 'checked' : '';

    c1.innerHTML = '<input type="text" class="input_style" value="' + i2 + '" id="des-' + i1 + '">'; //descricao
    c2.innerHTML = '<input type="text" class="input_style mask-prod" value="' + Number(i4).toFixed(2) + '" id="bai-' + i1 + '" maxlength="5">';//baixa
    c3.innerHTML = '<input type="text" class="input_style mask-prod" value="' + Number(i5).toFixed(2) + '" id="med-' + i1 + '" maxlength="5">';//media
    c4.innerHTML = '<input type="text" class="input_style mask-prod" value="' + Number(i6).toFixed(2) + '" id="alt-' + i1 + '" maxlength="5">';//alta
    c5.innerHTML = '<input type="text" class="input_style mask-sloc" value="' + i7 + '" id="slo-' + i1 + '">'; //sloc
    c6.innerHTML = '<input type="text" class="input_style mask-prod" value="' + Number(i10).toFixed(2) + '" id="ft-' + i1 + '" maxlength="4">';
    c7.innerHTML = '<input onchange="alteraIsFT($(this).val(), $(this).prop(\'checked\'));" id="is-ft-' + i1 + '" value="' + i1 + '" type="checkbox" data-toggle="toggle" data-onstyle="success" data-style="slow" data-on="Sim" data-off="Não" data-width="100" class="datatoggle" ' + vCheckedIsFT + ' ' + (isFornecedor ? 'disabled' : '') + '>';
    c8.innerHTML = '<input onchange="alteraStatusLinguagem($(this).val(), $(this).prop(\'checked\'));" id="atv-' + i1 + '" value="' + i1 + '" type="checkbox" data-toggle="toggle" data-onstyle="success" data-style="slow" data-on="Ativo" data-off="Inativo" data-width="100" class="datatoggle" ' + vChecked + ' ' + (isFornecedor ? 'disabled' : '') + '>';
    c9.innerHTML = '<button type="button" class="btn btn-default" onclick="atualizaLinguagem($(this).val());" value="' + i1 + ' ' + (isFornecedor ? 'disabled' : '') + '">&nbsp;<i class="fa fa-refresh"></i>&nbsp;Atualizar</button>';
    /*
     * inicializacao manual dos datatoggles
     */
    $('.datatoggle').bootstrapToggle();
    $('.mask-prod').mask("#.##0.00", {reverse: true});
    $('.mask-sloc').mask("000");
}

function alteraStatusLinguagem(id, prop) {
    if (!isFornecedor) {
        iWait('w_linguagem_status', true);
        $.post('/pf/DIM.Gateway.php', {'i': id, 'p': prop ? 1 : 0, 'arq': 75, 'tch': 0, 'sub': 0, 'dlg': 1}, function (data) {
            iWait('w_linguagem_status', false);
        }, 'json');
    }
}

function alteraIsFT(id, prop) {
    if (!isFornecedor) {
        iWait('w_is_ft', true);
        $.post('/pf/DIM.Gateway.php', {'idl': id, 'prp': prop ? 1 : 0, 'arq': 94, 'tch': 0, 'sub': 0, 'dlg': 1}, function (data) {
            if (!(data.status)) {
                swal({
                    title: "Alerta",
                    text: "Esta linguagem est&aacute; sendo utilizada em contagens como Fator Tecnologia e n&atilde;o pode ser alterada. Crie uma V2 com a nova configura&ccedil;&atilde;o.",
                    type: "warning",
                    html: true,
                    confirmButtonText: "Ok, obrigado!"},
                function () {
                    $('#is-ft-' + id).bootstrapToggle('on');
                });
            }
            iWait('w_is_ft', false);
        }, 'json');
    }
}

function atualizaTabelaLinguagem() {
    $('#addLinhaLinguagem').empty();
    iWaitMenuContagem('w_calibracao_linguagem', true, 'fa fa-cogs');
    $.post('/pf/DIM.Gateway.php', {
        'arq': 82,
        'tch': 1,
        'sub': 0,
        'dlg': 1,
        'icl': $('#config_id_cliente option:selected').val()
    }, function (data) {
        for (x = 0; x < data.length; x++) {
            addLinhaLinguagem(
                    data[x].id,
                    data[x].descricao,
                    data[x].is_ativo,
                    data[x].baixa,
                    data[x].media,
                    data[x].alta,
                    data[x].sloc, -1,
                    '',
                    data[x].fator_tecnologia,
                    data[x].is_ft);
        }
        iWaitMenuContagem('w_calibracao_linguagem', false, 'fa fa-cogs');
    }, 'json');
}

function atualizaLinguagem(id) {
    var icl = $('#config_id_cliente option:selected').val();
    if (!isFornecedor) {
        inserirAlterarLinguagem('a', id, icl);
    }
}

