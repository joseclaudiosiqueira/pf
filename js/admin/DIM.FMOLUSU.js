/*
 * para todos dos forms a leitura da imagem do captcha eh feita no click para evitar desatualizacoes
 */
$('#lnus').on('click', function () {
    $('#title-lista-usuarios').html('&nbsp;&nbsp;Lista perfis de usu&aacute;rios cadastrados para sua Empresa, Fornecedor e/ou Cliente');
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
                    data[x].id_cliente,
                    data[x].user_active,
                    data[x].tipo,
                    data[x].avatar);
        }
    }, 'json');
});
/*
 * para todos dos forms a leitura da imagem do captcha eh feita no click para evitar desatualizacoes
 */
$('#lnal').on('click', function () {
    $('#title-lista-usuarios').html('&nbsp;&nbsp;Lista perfis de alunos cadastrados em suas turmas de treinamento');
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
                    data[x].id_cliente,
                    data[x].user_active,
                    data[x].tipo,
                    data[x].avatar);
        }
    }, 'json');
});
/*
 * clique nos botoes de acao
 */
$('#fechar_lista').on('click', function () {
    limpaCamposPerfil();
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
 * @param {type} i14 - user_active
 * @param {type} i15 - tipo (Fornecedor / Turma)
 * @param {type} i16 - avatar
 * @returns {undefined}
 */
function addLinhaPerfil(i1, i2, i3, i4, i5, i6, i7, i8, i9, i10, i11, i12, i13, i14, i15, i16) {
    var t = $('#addListaUsuario').get(0); //tabela
    var r = t.insertRow(-1); //linha

    var c1 = r.insertCell(0);
    var c2 = r.insertCell(1);
    var c3 = r.insertCell(2);
    var c4 = r.insertCell(3);
    var c5 = r.insertCell(4);
    var c6 = r.insertCell(5);
    var c7 = r.insertCell(6);
    var c8 = r.insertCell(7);

    var vChecked = i5 == 1 ? 'checked' : '';
    /*
     * verificar aqui pois o usuario ADM e Instrutor podem se desabilitar
     */
    var vDisabled = ((i7 === emailLogado || empresaConfigPlano.id < 3) && i15 != 1) ? 'disabled' : '';

    var sEmail = i7.split('@');
    /*
     * verifica se eh o usuario logado que nao pode alterar o proprio perfil ou se eh um plano demo/estudante
     */
    c1.innerHTML = (i7 === emailLogado || empresaConfigPlano.id < 3) ? 
    '<img src="' + i16 + '" class="img-circle" width="48" height="48" />' : '<span id="l' + ('000000' + i8).slice(-6) + '"><a href="#" id="click_' + ('000000' + i8).slice(-6) + '" onclick="exibePerfilAlteracao(' + i9 + ', ' + i8 + ', ' + i3 + ', ' + i4 + ', \'' + i11 + '\', \'' + i10 + '\', \'' + i6 + '\', \'' + i12 + '\');"><img src="' + i16 + '" class="img-circle" width="48" height="48" /></a></span>';
    c2.innerHTML = '<span id="is_v_' + ('000000' + i8).slice(-6) + '">' + (1 == i12 ? '<font style="color:#000;"><i class="fa fa-check-circle-o fa-lg"></i>&nbsp;</font>' : '<font style="color:#d0d0d0;"><i class="fa fa-minus-circle fa-lg"></i>&nbsp;</font>') + '</span>' + i6;
    c3.innerHTML = '<a href="mailto:' + i7 + '">' + sEmail[0] + '@</a>';
    c4.innerHTML = i4 == 0 ? '<span class="label label-info"> E </span>&nbsp;' + i1 : (i15 == 0 ? '<span class="label label-default"> F </span>&nbsp;' + i2 : '<span class="label label-warning"> T </span>&nbsp;' + i2);
    c5.innerHTML = '<span id="u' + ('000000' + i8).slice(-6) + '">' + i10 + '</span>';
    c6.innerHTML = i13 == 0 ? '-' : i13;
    /*
     * esta alteracao de status eh apenas com referencia a poder logar ou nao, nao quer dizer que o usuario fique inativo
     * caso pertenca a mais de uma empresa/fornecedor/turma
     */
    c7.innerHTML = '<input onchange="alteraStatusUsuario($(this).val(), $(this).prop(\'checked\'), ' + i3 + ', ' + i4 + ');" value="' + i8 + '" type="checkbox" data-toggle="toggle" data-width="100" data-height="36" data-onstyle="success" data-style="slow" data-on="Ativo" data-off="Inativo" class="datatoggle" ' + vChecked + ' ' + vDisabled + '>';
    c8.innerHTML = i14 == 0 ? '<div class="label-round label-default">Inativo</label>' : '<div class="label-round label-success">Ativo</div>';
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
/*
 * limpa os campos do formulario
 */
function limpaCamposPerfil() {
    $('#addListaUsuario').empty();
}