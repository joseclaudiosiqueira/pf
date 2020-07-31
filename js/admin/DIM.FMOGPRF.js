$('#perfil-txt-captcha').on('keyup', function () {
    verificaCaptcha($(this), $('#perfil-i-captcha'), false);
});
/*
 * para todos dos forms a leitura da imagem do captcha eh feita no click para evitar desatualizacoes
 */
$('#link_modal_gerenciar_perfis').on('click', function () {
    $('#title-gerenciar-perfis').html('&nbsp;&nbsp;Gerenciamento de perfis de usu&aacute;rios');
    $.post('/pf/DIM.Gateway.php', {
        'arq': 77, 'tch': 1, 'sub': 4, 'dlg': 1}, function (data) {
        for (x = 0; x < data.length; x++) {
            addLinhaPerfil(
                    data[x].eSigla,
                    data[x].fSigla,
                    data[x].id_empresa,
                    data[x].id_fornecedor,
                    data[x].is_ativo,
                    data[x].user_complete_name,
                    data[x].user_email,
                    data[x].user_id,
                    data[x].RoleId,
                    data[x].short_name,
                    data[x].Title,
                    data[x].is_validar_adm_gestor,
                    data[x].id_cliente);
        }
    }, 'json');
    $('#perfil-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
});

/*
 * para todos dos forms a leitura da imagem do captcha eh feita no click para evitar desatualizacoes
 */
$('#link_modal_gerenciar_perfis_alunos').on('click', function () {
    $('#title-gerenciar-perfis').html('&nbsp;&nbsp;Gerenciamento de perfis de alunos');
    $.post('/pf/DIM.Gateway.php', {'tipo': 1, 
        'arq': 77, 'tch': 1, 'sub': 4, 'dlg': 1}, function (data) {
        for (x = 0; x < data.length; x++) {
            addLinhaPerfil(
                    data[x].eSigla,
                    data[x].fSigla,
                    data[x].id_empresa,
                    data[x].id_fornecedor,
                    data[x].is_ativo,
                    data[x].user_complete_name,
                    data[x].user_email,
                    data[x].user_id,
                    data[x].RoleId,
                    data[x].short_name,
                    data[x].Title,
                    data[x].is_validar_adm_gestor,
                    data[x].id_cliente);
        }
    }, 'json');
    $('#perfil-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
});
/*
 * clique nos botoes de acao
 */
$('#perfil_btn_cancelar').on('click', function () {
    limpaCamposPerfil(false);
});
$('#fechar_perfil').on('click', function () {
    limpaCamposPerfil(true);
});
/*
 * confere se o grupo/perfil selecionado tem atribuicoes
 */
$('#select_role_id').on('change', function () {
    if ($(this).val() != 0) {
        iWait('w_perfil_grupo', true)
        $.post('/pf/DIM.Gateway.php', {'i': $(this).val(), 'arq': 47, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
            if (data.length == 0) {
                swal({
                    title: "Alerta",
                    text: "N&atilde;o h&aacute; permiss&otilde;es associadas a este grupo/perfil.",
                    type: "error",
                    html: true,
                    confirmButtonText: "Entendi, obrigado!"});
                $('#select_role_id').val(0);
                $('#perfil_btn_atualizar').prop('disabled', true);
                $('#chk_is_validar_adm_gestor_perfil').prop('disabled', true).prop('checked', false);
            }
            iWait('w_perfil_grupo', false);
        }, 'json');
    }
    /*
     * verifica se nao eh o mesmo role id e soh habilita atualizar quando nao for
     */
    if (Number($('#user_role_id').val()) != Number($(this).val()) && $(this).val() != 0) {
        $('#perfil_btn_atualizar').prop('disabled', false);
    }
    else {
        $('#perfil_btn_atualizar').prop('disabled', true);
    }
    /*
     * para o check de is_validar_adm_gestor
     */
    if ($('#select_role_id').val() == 1 || $('#select_role_id').val() == 7) {
        $('#chk_is_validar_adm_gestor_perfil').prop('disabled', false);
    }
    else {
        $('#chk_is_validar_adm_gestor_perfil').prop('disabled', true).prop('checked', false);
    }
});
/*
 * mudanca no is_validar_adm_gestor_perfil
 */
$("#chk_is_validar_adm_gestor_perfil").on('change', function () {
    $('#perfil_btn_atualizar').prop('disabled', !1);
});
/*
 * submit para alteracao do perfil
 */
$('#form_gerenciar_perfis').on('submit', function () {
    var i = $('#user_id_user').val();
    var e = $('#user_id_empresa').val();
    var f = $('#user_id_fornecedor_perfil').val();
    var r = $('#select_role_id').val();
    var t = $('#user_role_title').val();
    var v = $('#chk_is_validar_adm_gestor_perfil').prop('checked') ? 1 : 0;
    var n = $('#span_user_name').html().replace('&nbsp;', '').replace('(', '').replace(')', '');
    var s = $('#user_short_name').val();
    var title, mensagem, type, confirmText;
    /*
     * confere o captcha
     */
    if ($('#perfil-txt-captcha').val().length < 4) {
        swal({
            title: "Alerta",
            text: "As letras da imagem est&atilde;o diferentres do que foi digitado.",
            type: "error",
            html: true,
            confirmButtonText: "Vou corrigir, obrigado!"});
        return false;
    }
    if (r == 0) {
        swal({
            title: "Alerta",
            text: "Voc&ecirc; precisa associar o usu&aacute;rio a um perfil.",
            type: "error",
            html: true,
            confirmButtonText: "Entendi, obrigado!"});
        return false;
    }
    $.post('/pf/DIM.Gateway.php', {'i': i, 'e': e, 'f': f, 'r': r, 't': t, 'v': v, 'j': 'action.alterar.perfil.usuario', 'su': 'user'}, function (data) {
        if (data.status) {
            title = "Informa&ccedil;&atilde;o";
            mensagem = "O perfil do usu&aacute;rio foi alterado com sucesso.";
            type = "info";
            confirmText = "Obrigado!";
            alteraSpanRoleTitle(i, data.short_name);
            alteraSpanIsValidar(i, v);
            alteraClickExibirPerfil(r, i, e, f, t, s, n, v);
        }
        else {
            title = "Alerta";
            mensagem = "O sistema n&atilde;o conseguiu alterar o perfil do usu&aacute;rio. Favor entrar em contato com o administrador.";
            type = "error";
            confirmText = "Vou verificar, obrigado!";
        }
        swal({
            title: title,
            text: mensagem,
            type: type,
            html: true,
            confirmButtonText: confirmText});
    }, 'json');
    limpaCamposPerfil(false);
    return false;
});
/**
 * 
 * @param {type} i1 - eSigla
 * @param {type} i2 - fSigla
 * @param {type} i3 - id_empresa
 * @param {type} i4 - id_fornecedor
 * @param {type} i5 - is_ativo
 * @param {type} i6 - user_complete_name
 * @param {type} i7 - user_email
 * @param {type} i8 - user_id
 * @param {type} i9 - RoleId
 * @param {type} i10 - short_name (Roles)
 * @param {type} i11 - role title
 * @param {type} i12 - is_validar_adm_gestor
 * @param {type} i13 - id_cliente
 * @returns {undefined}
 */
function addLinhaPerfil(i1, i2, i3, i4, i5, i6, i7, i8, i9, i10, i11, i12, i13) {
    var t = $('#addUsuario').get(0); //tabela
    var r = t.insertRow(-1); //linha

    var c1 = r.insertCell(0);
    var c2 = r.insertCell(1);
    var c3 = r.insertCell(2);
    var c4 = r.insertCell(3);
    var c5 = r.insertCell(4);
    var c6 = r.insertCell(5);
    var c7 = r.insertCell(6);

    var vChecked = i5 == 1 ? 'checked' : '';
    var vDisabled = (i7 === emailLogado || empresaConfigPlano.id < 3) ? 'disabled' : '';

    var sEmail = i7.split('@');

    /*
     * verifica se eh o usuario logado que nao pode alterar o proprio perfil ou se eh um plano demo/estudante
     */
    c1.innerHTML = (i7 === emailLogado || empresaConfigPlano.id < 3) ? '#' + ('000000' + i8).slice(-6) : '<span id="l' + ('000000' + i8).slice(-6) + '"><a href="#" id="click_' + ('000000' + i8).slice(-6) + '" onclick="exibePerfilAlteracao(' + i9 + ', ' + i8 + ', ' + i3 + ', ' + i4 + ', \'' + i11 + '\', \'' + i10 + '\', \'' + i6 + '\', \'' + i12 + '\');">#' + ('000000' + i8).slice(-6) + '</a></span>';
    c2.innerHTML = '<span id="is_v_' + ('000000' + i8).slice(-6) + '">' + (1 == i12 ? '<font style="color:#000;"><i class="fa fa-check-circle-o fa-lg"></i>&nbsp;</font>' : '<font style="color:#d0d0d0;"><i class="fa fa-minus-circle fa-lg"></i>&nbsp;</font>') + '</span>' + i6;
    c3.innerHTML = '<a href="mailto:' + i7 + '">' + sEmail[0] + '@</a>';
    c4.innerHTML = i4 == 0 ? '<span class="label label-info"> E </span>&nbsp;' + i1 : '<span class="label label-default"> F </span>&nbsp;' + i2;
    c5.innerHTML = '<span id="u' + ('000000' + i8).slice(-6) + '">' + i10 + '</span>';
    c6.innerHTML = i13 == 0 ? '-' : i13;
    c7.innerHTML = '<input onchange="alteraStatusUsuario($(this).val(), $(this).prop(\'checked\'), ' + i3 + ', ' + i4 + ');" value="' + i8 + '" type="checkbox" data-toggle="toggle" data-size="mini" data-width="70" data-onstyle="success" data-style="slow" data-on="Ativo" data-off="Inativo" class="datatoggle" ' + vChecked + ' ' + vDisabled + '>';
    /*
     * inicializacao manual dos datatoggles
     */
    $('.datatoggle').bootstrapToggle();
}

/**
 * 
 * @param {type} i - id do usuario
 * @param {type} p - prop (1 ativo, 0 inativo)
 * @param {type} e - id da empresa
 * @param {type} f - id do fornecedor
 * @returns {undefined}
 */
function alteraStatusUsuario(i, p, e, f) {
    iWait('w_usuario_status', true);
    $.post('/pf/DIM.Gateway.php', {'i': i, 'p': p ? 1 : 0, 'e': e, 'f': f, 
        'arq': 66, 'tch': 0, 'sub': 4, 'dlg': 1}, function () {
        iWait('w_usuario_status', false);
    }, 'json');
}
/**
 * 
 * @param {type} r - id da role do usuario
 * @param {type} i - id do usuario
 * @param {type} e - id da empresa
 * @param {type} f - id do fornecedor
 * @param {type} t - role title
 * @param {type} s - short name
 * @param {type} n - nome do usuario
 * @param {type} v - is_validar_adm_gestor
 * @returns {undefined}
 */
function exibePerfilAlteracao(r, i, e, f, t, s, n, v) {
    if ($('#select_role_id').prop('disabled')) {
        comboRoles(r, 'select_role_id', 'w_perfil_grupo');
    }
    else {
        $('#select_role_id option[value=' + r + ']').prop('selected', !0);
    }
    $('#select_role_id').prop('disabled', !1);
    $('#user_id_user').val(i);
    $('#user_id_empresa').val(e);
    $('#user_id_fornecedor_perfil').val(f);
    $('#user_role_title').val(t);
    $('#user_short_name').val(s);
    $('#user_role_id').val(r);
    $('#perfil-txt-captcha').val('');
    $('#span_user_name').html('&nbsp;(<strong>' + n + '</strong>)');
    $('#perfil_btn_cancelar').prop('disabled', !1);
    $("#chk_is_validar_adm_gestor_perfil").prop('checked', 1 == v ? !0 : !1).prop('disabled', 1 == r || 7 == r ? !1 : !0);
    /*
     * precisa atualizar a tabela passando os novos valores
     * TODO: colocar um id no span de exibicao do link e colocar os novos parametros na funcao
     */
}
/*
 * limpa os campos do formulario
 */
function limpaCamposPerfil(b) {
    /*
     * atualiza captcha
     */
    $('#perfil-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
    b ? $('#addUsuario').empty() : '';
    b ? $('#perfil_role_id').empty : '';
    $('#select_role_id').prop('disabled', true);
    $('#select_role_id option[value=0]').prop('selected', true);
    $('#user_id_user').val('');
    $('#user_id_empresa').val('');
    $('#user_id_fornecedor_perfil').val('');
    $('#user_role_title').val('');
    $('#user_short_name').val('');
    $('#user_role_id').val('');
    $('#perfil_btn_atualizar').prop('disabled', true);
    $('#perfil_btn_cancelar').prop('disabled', true);
    $('#span_user_name').html('');
    $('#perfil-txt-captcha').val('');
    $('#chk_is_validar_adm_gestor_perfil').prop('checked', false).prop('disabled', true);
}
/**
 * 
 * @param {type} i - id do usuario que eh o id do span u000000
 * @param {type} s - short_name
 * @returns {undefined}
 */
function alteraSpanRoleTitle(i, s) {
    var u = ('000000' + i).slice(-6);
    $('#u' + u).html(s);
}

function alteraSpanIsValidar(i, v) {
    var u = ('000000' + i).slice(-6);
    $('#is_v_' + u).html(v ?
            '<font style="color:#000;"><i class="fa fa-check-circle-o fa-lg"></i>&nbsp;</font>' :
            '<font style="color:#d0d0d0;"><i class="fa fa-minus-circle fa-lg"></i>&nbsp;</font>');
}

function alteraClickExibirPerfil(r, i, e, f, t, s, n, v) {
    var u = ('000000' + i).slice(-6);
    $('#click_' + u).attr('onclick', 'exibePerfilAlteracao(' + r + ', ' + i + ', ' + e + ', ' + f + ', \'' + t + '\', \'' + s + '\', \'' + n + '\', \'' + v + '\')');
}