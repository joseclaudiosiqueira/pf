//clique no botao fechar limpa todos os campos
$('#btn-cancelar-baseline').on('click', function () {
    limpaCamposBaseline(false);
});
//masked input
$('.money').mask("###0.00", {reverse: true});
//recepcao do click no link que ativa a janela
$('#link-gerenciar-baseline').on('click', function () {
    comboCliente('baseline', 0, '01', idFornecedor);
    limpaCamposBaseline(true);
});

$('#baseline_id_cliente').on('change', function () {
    if (Number($(this).val()) !== 0) {
        var tabela = $('#addBaseline').empty().get(0);
        var icl = $('#baseline_id_cliente option:selected').val();
        $.post('/pf/DIM.Gateway.php', {
            'arq': 30,
            'tch': 1,
            'sub': -1,
            'dlg': 1,
            'icl': icl}, function (data) {
            if (data.length > 0) {
                for (x = 0; x < data.length; x++) {
                    insereLinhaBaseline(tabela, data[x].id, data[x].sigla, data[x].descricao, data[x].resumo, data[x].valor_pf, data[x].valor_hpa, data[x].valor_hpc, data[x].is_ativo);
                }
            }
        }, 'json');
    }
    else {
        limpaCamposBaseline(true);
    }
});

$('#btn-salvar-baseline').on('click', function () {
    if ($('#baseline-txt-captcha').val().length < 4) {
        swal({
            title: "Alerta",
            text: "As letras da imagem est&atilde;o diferentes do que foi digitado, ou n&atilde;o est&atilde;o completas.",
            type: "error",
            html: true,
            confirmButtonText: "Vou corrigir, obrigado!"});
        return false;
    }
    else if (Number($('#baseline_id_cliente option:selected').val()) === 0) {
        swal({
            title: "Alerta",
            text: "Por favor, selecione um Cliente para a Baseline.",
            type: "error",
            html: true,
            confirmButtonText: "Entendi, obrigado!"});
        return false;
    }
    else if ($('#baseline-sigla').val() === '') {
        swal({
            title: "Alerta",
            text: "Por favor, preencha a sigla da Baseline.",
            type: "error",
            html: true,
            confirmButtonText: "Entendi, obrigado!"});
        return false;
    }
    else if ($('#baseline-descricao').val() === '') {
        swal({
            title: "Alerta",
            text: "Por favor, preencha a descri&ccedil;&atilde;o da Baseline.",
            type: "error",
            html: true,
            confirmButtonText: "Entendi, obrigado!"});
        return false;
    }
    else if ($('#baseline-resumo').val() === '') {
        swal({
            title: "Alerta",
            text: "Por favor, preencha um resumo sobre a Baseline.",
            type: "error",
            html: true,
            confirmButtonText: "Entendi, obrigado!"});
        return false;
    }
    else if ($('#baseline-valor-pf').val() === '') {
        swal({
            title: "Alerta",
            text: "Por favor, para efeitos estat&iacute;sticos, preencha um valor para os Pontos de Fun&ccedil;&atilde;o.",
            type: "error",
            html: true,
            confirmButtonText: "Entendi, obrigado!"});
        return false;
    }
    else if ($('#baseline-valor-hpc').val() === '') {
        swal({
            title: "Alerta",
            text: "Por favor, para efeitos estat&iacute;sticos, preencha um valor para valor das Horas de Consultor.",
            type: "error",
            html: true,
            confirmButtonText: "Entendi, obrigado!"});
        return false;
    }    
    else if ($('#baseline-valor-hpc').val() === '') {
        swal({
            title: "Alerta",
            text: "Por favor, para efeitos estat&iacute;sticos, preencha um valor para valor das Horas de Analista.",
            type: "error",
            html: true,
            confirmButtonText: "Entendi, obrigado!"});
        return false;
    }        
    //variaveis
    var icl = $('#baseline_id_cliente option:selected').val();
    var sigla = $('#baseline-sigla').val();
    var descricao = $('#baseline-descricao').val();
    var resumo = $('#baseline-resumo').val();
    var pf = $('#baseline-valor-pf').val();
    var hpa = $('#baseline-valor-hpa').val();
    var hpc = $('#baseline-valor-hpc').val();    
    var isAtivo = $('#baseline-is-ativo').prop('checked') ? 1 : 0;
    //envia formulario
    $.post('/pf/DIM.Gateway.php', {
        'icl': icl,
        'sigla': sigla,
        'descricao': descricao,
        'resumo': resumo,
        'valorPf': pf,
        'valorHpa': hpa,
        'valorHpc': hpc,
        'isAtivo': isAtivo,
        'arq': 24,
        'tch': 0,
        'sub': -1,
        'dlg': 1
    }, function (data) {
        if (data.id > 0) {
            swal({
                title: "Informa&ccedil;&atilde;o",
                text: "A Baseline foi inserida com sucesso.",
                type: "success",
                html: true,
                confirmButtonText: "Obrigado!"});
            var tabela = $('#addBaseline').get(0);
            insereLinhaBaseline(tabela, data.id, sigla, descricao, resumo, pf, hpa, hpc, isAtivo);
        }
        else {
            swal({
                title: "Alerta",
                text: "Houve um erro durante a inser&ccedil;&atilde;o da Baseline, por favor entre em contato com o Administrador do sistema.",
                type: "error",
                html: true,
                confirmButtonText: "Ok, vou verificar!"});
        }
    }, 'json');
    //limpa os campos
    limpaCamposBaseline(false);
});

$('#btn-atualizar-baseline').on('click', function () {
    if ($('#baseline-txt-captcha').val().length < 4) {
        swal({
            title: "Alerta",
            text: "As letras da imagem est&atilde;o diferentes do que foi digitado ou n&atilde;o est&atilde;o completas.",
            type: "error",
            html: true,
            confirmButtonText: "Vou corrigir, obrigado!"});
        return false;
    }
    var id = $('#baseline-id').val();
    var sigla = $('#baseline-sigla').val();
    var descricao = $('#baseline-descricao').val();
    var resumo = $('#baseline-resumo').val();
    var pf = $('#baseline-valor-pf').val();
    var hpa = $('#baseline-valor-hpa').val();
    var hpc = $('#baseline-valor-hpc').val();
    var isAtivo = $('#baseline-is-ativo').prop('checked') ? 1 : 0;
    //atualizar a baseline no banco de dados
    $.post('/pf/DIM.Gateway.php', {
        'id': id,
        'sigla': sigla,
        'descricao': descricao,
        'resumo': resumo,
        'valorPf': pf,
        'valorHpa': hpa,
        'valorHpc': hpc,
        'isAtivo': isAtivo,
        'arq': 10,
        'tch': 0,
        'sub': -1,
        'dlg': 1}, function () {
        swal({
            title: "Informa&ccedil;&atilde;o",
            text: "A Baseline foi atualizada com sucesso.",
            type: "success",
            html: true,
            confirmButtonText: "Obrigado!"});
        //atualiza as informacoes na tabela
        var vChecked = isAtivo == 1 ? 'checked' : '';
        $('#sigla_' + id).html(sigla);
        $('#descricao_' + id).html(descricao);
        $('#resumo_' + id).html(resumo);
        $('#pf_' + id).html(parseFloat(pf).toFixed(2));
        $('#hpa_' + id).html(parseFloat(hpa).toFixed(2));
        $('#hpc_' + id).html(parseFloat(hpc).toFixed(2));
        $('#status_' + id).html('<input id="chk-status-' + id + '" onchange="alteraStatusBaseline($(this).val(), $(this).prop(\'checked\'));" value="' + id + '" type="checkbox" data-toggle="toggle" data-size="mini" data-width="60" data-onstyle="success" data-offstyle="warning" data-style="slow" data-on="Ativa" data-off="Inativa" class="datatoggle" ' + vChecked + '>');
        /*
         * inicializacao manual dos datatoggles
         */
        $('.datatoggle').bootstrapToggle();
        /*
         * limpa os campos
         */
        limpaCamposBaseline(false);
    }, 'json');
});

//verificacao online do captcha
$('#baseline-txt-captcha').on('keyup', function () {
    verificaCaptcha($(this), $('#baseline-i-captcha'), false);
});

/**
 * 
 * @param {object} t - tabela
 * @param {int} id
 * @param {string} descricao
 * @param {string} resumo
 * @param {int} isAtivo
 * @returns {boolean}
 */
function insereLinhaBaseline(t, id, sigla, descricao, resumo, pf, hpa, hpc, isAtivo) {
    var r = t.insertRow(-1);
    var cell0 = r.insertCell(0);
    var cell1 = r.insertCell(1);//sigla
    var cell2 = r.insertCell(2);//descricao
    var cell3 = r.insertCell(3);//resumo
    var cell4 = r.insertCell(4);//valor pf
    var cell5 = r.insertCell(5);//valor hpa
    var cell6 = r.insertCell(6);//valor hpc
    var cell7 = r.insertCell(7);//is-ativo

    var vChecked = isAtivo == 1 ? 'checked' : '';

    cell1.id = 'sigla_' + id;
    cell2.id = 'descricao_' + id;
    cell3.id = 'resumo_' + id;
    cell4.id = 'pf_' + id;
    cell5.id = 'hpa_' + id;
    cell6.id = 'hpc_' + id;
    cell7.id = 'status_' + id;

    cell0.innerHTML = '<a href="#" onclick="exibeBaselineAlteracao(' + id + ', ' + isAtivo + ');">#' + ("000000" + id).slice(-6) + '</a>';
    cell1.innerHTML = sigla;
    cell2.innerHTML = descricao;
    cell3.innerHTML = resumo;
    cell4.innerHTML = parseFloat(pf).toFixed(2);
    cell5.innerHTML = parseFloat(hpa).toFixed(2);
    cell6.innerHTML = parseFloat(hpc).toFixed(2);
    cell7.innerHTML = '<input id="chk-status-' + id + '" onchange="alteraStatusBaseline($(this).val(), $(this).prop(\'checked\'));" value="' + id + '" type="checkbox" data-toggle="toggle" data-width="90" data-onstyle="success" data-offstyle="warning" data-style="slow" data-on="Ativa" data-off="Inativa" class="datatoggle" ' + vChecked + '>';
    /*
     * inicializacao manual dos datatoggles
     */
    $('.datatoggle').bootstrapToggle();
}

function exibeBaselineAlteracao(id, isAtivo) {
    $('#baseline-sigla').val($('#sigla_' + id).html());
    $('#baseline-descricao').val($('#descricao_' + id).html());
    $('#baseline-resumo').val($('#resumo_' + id).html());
    $('#baseline-valor-pf').val($('#pf_' + id).html());
    $('#baseline-valor-hpa').val($('#hpa_' + id).html());
    $('#baseline-valor-hpc').val($('#hpc_' + id).html());
    $('#btn-salvar-baseline').prop('disabled', true);
    $('#btn-atualizar-baseline').prop('disabled', false);
    $('#btn-cancelar-baseline').prop('disabled', false);
    $('#baseline-is-ativo').bootstrapToggle(isAtivo ? 'on' : 'off');
    $('#baseline-id').val(id);
}
//botoes que fecham a tela
//clique no botao para fechar a janela do cliente
$('#fechar-baseline').on('click', function () {
    limpaCamposBaseline(true);
});

//clique no botao para inserir uma nova baseline
$('#btn-nova-baseline').on('click', function () {
    $('#btn-salvar-baseline').prop('disabled', false);
    limpaCamposBaseline(false);
});

/**
 * 
 * @param {boolean} b - true, limpa a tabela
 * @returns {boolean}
 */
function limpaCamposBaseline(b) {
    var id = $('#baseline-id').val();
    $('#baseline-sigla').val('');
    $('#baseline-descricao').val('');
    $('#baseline-resumo').val('');
    $('#baseline-valor-pf').val('');
    $('#baseline-valor-hpa').val('');
    $('#baseline-valor-hpc').val('');
    //botoes
    $('#btn-salvar-baseline').prop('disabled', false);
    $('#btn-atualizar-baseline').prop('disabled', true);
    $('#btn-cancelar-baseline').prop('disabled', true);
    //habilita antes
    $('#chk-status-' + id).bootstrapToggle('enable');
    //zera depois
    $('#baseline-id').val(0);
    $('#baseline-is-ativo').bootstrapToggle('enable').bootstrapToggle('on');
    $('#baseline-txt-captcha').val('');
    //atualiza o captcha
    refreshCaptcha($('#baseline-img-captcha'), $('#baseline-txt-captcha'));
    //limpa a tabela tambem
    b ? $('#addBaseline').empty() : NULL;
    return true;
}

function alteraStatusBaseline(id, prop) {
    iWait('w_baseline_status', true);
    /*
     * sincroniza os datatoggles em caso de clicar para alterar e clicar para inativar/ativar
     */
    if (Number($('#baseline-id').val()) !== 0 && $('#baseline-id').val() === id) {
        $('#baseline-is-ativo').bootstrapToggle('enable').bootstrapToggle(prop ? 'on' : 'off').bootstrapToggle('disable');
    }
    $.post('/pf/DIM.Gateway.php', {'i': id, 'p': prop ? 1 : 0,
        'arq': 74, 'tch': 0, 'sub': -1, 'dlg': 1}, function (data) {
        if (!(data.status)) {
            gravaLogAuditoria(emailLogado, userRole, 'alterar-status-baseline;' + ("000000000" + idEmpresa).slice(-9));
        }
        iWait('w_baseline_status', false);
    }, 'json');
}
