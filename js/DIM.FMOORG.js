//clique no botao fechar limpa todos os campos
$('#btn-cancelar-orgao').on('click', function () {
    limpaCamposOrgao();
});
//recepcao do click no link que ativa a janela
$('.link-gerenciar-orgao').on('click', function () {
    atualizaTabelaCombo(0);
    //monta a combo de Clientes
    comboCliente('orgao', 0, '01', 0);
    //captcha
    $('#orgao-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
    //limpa os campos do formulario apenas na entrada
    limpaCamposOrgao();
});
//mudando o combo cliente tem que buscar a arvore do cliente
$('#orgao_id_cliente').on('change', function () {
    atualizaTabelaCombo($(this).val());
});

//criada uma funcao que pode ser chamada de outras formas
function atualizaTabelaCombo(icl) {
    var tabela = $('#addOrgao').empty().get(0);
    //limpa a combo com os orgaos sempre que passar aqui
    $("#orgao-superior").empty();
    //prepara a combo
    var sel = $("#orgao-superior");
    $.post('/pf/DIM.Gateway.php', {'arq': 93, 'icl': icl, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
        if (data.length > 0) {
            //envia as linhas para a tabela
            for (x = 0; x < data.length; x++) {
                insereLinhaOrgao(
                        tabela,
                        data[x].id,
                        data[x].descricao,
                        data[x].is_ativo,
                        data[x].is_editavel);
                //monta a combo sem ter que realizar novo .json
                sel.append('<option value="' + data[x].id + '" ' + selected + (data[x].is_ativo == 0 ? ' disabled' : '') + '>' + data[x].descricao + '</option>');
            }
        }
    }, 'json');
}

$('#btn-salvar-orgao').on('click', function () {
    if ($('#orgao-txt-captcha').val().length < 4) {
        swal({
            title: "Alerta",
            text: "As letras da imagem est&atilde;o diferentes do que foi digitado, ou n&atilde;o est&atilde;o completas.",
            type: "error",
            html: true,
            confirmButtonText: "Vou corrigir, obrigado!"});
        return false;
    }
    else if ($('#orgao-sigla').val() === '') {
        swal({
            title: "Alerta",
            text: "Por favor, preencha a sigla do &Oacute;rg&atilde;o.",
            type: "error",
            html: true,
            confirmButtonText: "Entendi, obrigado!"});
        return false;
    }
    else if ($('#orgao-descricao').val() === '') {
        swal({
            title: "Alerta",
            text: "Por favor, preencha a descri&ccedil;&atilde;o do &Oacute;rg&atilde;o.",
            type: "error",
            html: true,
            confirmButtonText: "Entendi, obrigado!"});
        return false;
    }
    else if ($('#orgao-superior').val() == 0 || !$('#orgao-superior').val()) {
        swal({
            title: "Alerta",
            text: "Por favor, selecione o &Oacute;rg&atilde;o superior.",
            type: "error",
            html: true,
            confirmButtonText: "Entendi, obrigado!"});
        return false;
    }
    //variaveis
    var sigla = $('#orgao-sigla').val();
    var descricao = $('#orgao-descricao').val();
    var isAtivo = $('#orgao-is-ativo').prop('checked') ? 1 : 0;
    var isEditavel = 1;
    var idSuperior = $('#orgao-superior').val();
    var idCliente = $('#orgao_id_cliente').val();
    //envia formulario
    $.post('/pf/DIM.Gateway.php', {
        'sigla': sigla,
        'descricao': descricao,
        'isAtivo': isAtivo,
        'idSuperior': idSuperior,
        'isEditavel': isEditavel,
        'idCliente': idCliente,
        'arq': 85,
        'tch': 0,
        'sub': -1,
        'dlg': 1
    }, function (data) {
        if (data.id > 0) {
            swal({
                title: "Informa&ccedil;&atilde;o",
                text: "O &Oacute;rg&atilde;o foi inserido com sucesso.",
                type: "success",
                html: true,
                confirmButtonText: "Obrigado!"});
            atualizaTabelaCombo($('#orgao_id_cliente').val());
        }
        else {
            swal({
                title: "Alerta",
                text: "Houve um erro durante a inser&ccedil;&atilde;o do &Oacute;rg&atilde;o, por favor entre em contato com o Administrador do sistema.",
                type: "error",
                html: true,
                confirmButtonText: "Ok, vou verificar!"});
        }
        //limpa os campos
        limpaCamposOrgao();
    }, 'json');
});

$('#btn-atualizar-orgao').on('click', function () {
    if ($('#orgao-txt-captcha').val().length < 4) {
        swal({
            title: "Alerta",
            text: "As letras da imagem est&atilde;o diferentes do que foi digitado ou n&atilde;o est&atilde;o completas.",
            type: "error",
            html: true,
            confirmButtonText: "Vou corrigir, obrigado!"});
        return false;
    }
    var id = $('#orgao-id').val();
    var sigla = $('#orgao-sigla').val();
    var descricao = $('#orgao-descricao').val();
    var isAtivo = $('#orgao-is-ativo').prop('checked') ? 1 : 0;
    //atualizar a baseline no banco de dados
    $.post('/pf/DIM.Gateway.php', {
        'id': id,
        'sigla': sigla,
        'descricao': descricao,
        'isAtivo': isAtivo,
        'arq': 84,
        'tch': 0,
        'sub': -1,
        'dlg': 1}, function () {
        swal({
            title: "Informa&ccedil;&atilde;o",
            text: "O &Oacute;rg&atilde;o foi atualizado com sucesso.",
            type: "success",
            html: true,
            confirmButtonText: "Obrigado!"});
        //atualiza as informacoes na tabela
        var vChecked = isAtivo == 1 ? 'checked' : '';

        $('#descricao_' + id).html(sigla + '.' + descricao);
        $('#status_' + id).html('<input id="chk-status-' + id + '" onchange="alteraStatusOrgao($(this).val(), $(this).prop(\'checked\'));" value="' + id + '" type="checkbox" data-toggle="toggle" data-width="60" data-onstyle="success" data-offstyle="warning" data-style="slow" data-on="Ativo" data-off="Inativo" data-height="22" class="datatoggle" ' + vChecked + '>');
        /*
         * inicializacao manual dos datatoggles
         */
        $('.datatoggle').bootstrapToggle();
        /*
         * limpa os campos
         */
        limpaCamposOrgao();
    }, 'json');
});

//verificacao online do captcha
$('#orgao-txt-captcha').on('keyup', function () {
    verificaCaptcha($(this), $('#orgao-i-captcha'), false);
});

/**
 * 
 * @param {object} t - tabela
 * @param {int} id
 * @param {string} descricao
 * @param {int} isAtivo
 * @param {int} isEditavel
 * @returns {boolean}
 */
function insereLinhaOrgao(t, id, descricao, isAtivo, isEditavel) {
    var r = t.insertRow(-1);
    var cell0 = r.insertCell(0);
    var cell1 = r.insertCell(1);//sigla.descricao
    var cell2 = r.insertCell(2);//is-ativo

    var vChecked = isAtivo == 1 ? 'checked' : '';
    var vIsEditavel = isEditavel == 1 ? '' : 'disabled';

    cell1.id = 'descricao_' + id;
    cell2.id = 'status_' + id;

    cell0.innerHTML = '<a href="#" onclick="swal(\'Neste momento não é possivel alterar um órgão, apenas desativar\'); return false;' + (isEditavel == 1 ? 'exibeOrgaoAlteracao(' + id + ', ' + isAtivo + ');' : 'return false;') + '">#' + ("000000" + id).slice(-6) + '</a>';
    cell1.innerHTML = descricao;
    cell2.innerHTML = '<input id="chk-status-' + id + '" onchange="' + (isEditavel == 1 ? 'alteraStatusOrgao($(this).val(), $(this).prop(\'checked\'));' : 'return false;') + '" value="' + id + '" type="checkbox" data-toggle="toggle" data-width="80" data-onstyle="success" data-offstyle="warning" data-style="slow" data-on="Ativo" data-off="Inativo" class="datatoggle" ' + vChecked + ' ' + vIsEditavel + '>';
    /*
     * inicializacao manual dos datatoggles
     */
    $('.datatoggle').bootstrapToggle();
}

function exibeOrgaoAlteracao(id, isAtivo) {
    $('#orgao-sigla').val($('#sigla_' + id).html());
    $('#orgao-descricao').val($('#descricao_' + id).html());
    $('#btn-salvar-orgao').prop('disabled', true);
    $('#btn-atualizar-orgao').prop('disabled', false);
    $('#btn-cancelar-orgao').prop('disabled', false);
    $('#orgao-is-ativo').bootstrapToggle(isAtivo ? 'on' : 'off');
    $('#orgao-id').val(id);
}
//botoes que fecham a tela
//clique no botao para fechar a janela do cliente
$('#fechar-orgao').on('click', function () {
    limpaCamposOrgao();
});

//clique no botao fechar limpa todos os campos
$('#btn-cancelar-orgao').on('click', function () {
    limpaCamposOrgao();
});

//clique no botao para inserir uma nova baseline
$('#btn-novo-orgao').on('click', function () {
    $('#btn-salvar-orgao').prop('disabled', false);
    limpaCamposOrgao();
});

function limpaCamposOrgao() {
    var id = $('#orgao-id').val();
    $('#orgao-sigla').val('');
    $('#orgao-descricao').val('');
    $('#orgao-superior').val(0);
    //botoes
    $('#btn-salvar-orgao').prop('disabled', false);
    $('#btn-atualizar-orgao').prop('disabled', true);
    $('#btn-cancelar-orgao').prop('disabled', true);
    //habilita antes
    $('#chk-status-' + id).bootstrapToggle('enable');
    //zera depois
    $('#orgao-id').val(0);
    $('#orgao-is-ativo').bootstrapToggle('enable').bootstrapToggle('on');
    $('#orgao-txt-captcha').val('');
    $('#orgao-superior').empty();
}

function alteraStatusOrgao(id, prop) {
    iWait('w_orgao_status', true);
    /*
     * sincroniza os datatoggles em caso de clicar para alterar e clicar para inativar/ativar
     */
    if ($('#orgao-id').val() != 0 && $('#orgao-id').val() === id) {
        $('#orgao-is-ativo').bootstrapToggle('enable').bootstrapToggle(prop ? 'on' : 'off').bootstrapToggle('disable');
    }
    $.post('/pf/DIM.Gateway.php', {'i': id, 'p': prop ? 1 : 0,
        'arq': 86, 'tch': 0, 'sub': -1, 'dlg': 1}, function (data) {
        if (!(data.status)) {
            gravaLogAuditoria(emailLogado, userRole, 'alterar-status-orgao;' + ("000000000" + idEmpresa).slice(-9));
        }
        iWait('w_orgao_status', false);
    }, 'json');
    //seta a opcao no select
    setSelectedFromValue('orgao-superior', id);
    console.log(id);
    //desabilita o item no select e vice versa
    if (prop) {
        $('#orgao-superior').find('option:selected').css('color', '#000').prop('disabled', false);
    }
    else {
        $('#orgao-superior').find('option:selected').css('color', '#f0f0f0').prop('disabled', true);
    }
    //tira a selecao em todo caso
    setNoneSelected('orgao-superior');
}