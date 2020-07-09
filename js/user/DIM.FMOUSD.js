$('#form_user_detail').on('submit', function () {
    $.post('/pf/DIM.Gateway.php', {
        'user_id': userId,
        'cpf': $('#u_cpf').val(),
        'data_nascimento': $('#u_data_nascimento').val(),
        'email_alternativo': $('#u_email_alternativo').val(),
        'apelido': $('#u_apelido').val(),
        'telefone_fixo': $('#u_telefone_fixo').val(),
        'telefone_celular': $('#u_telefone_celular').val(),
        'especialidades': jQuery("#u_especialidades").tagsManager('tags'),
        'uf': $('#u_uf').val(),
        'certificacao': $('#u_certificacao').val(),
        'arq': 67, 'tch': 0, 'sub': 4, 'dlg': 1
    }, function () {
        swal({
            title: "Informa&ccedil;&atilde;o",
            text: "As informa&ccedil;&otilde;es complementares sobre o seu perfil foram atualizadas com sucesso.",
            type: "success",
            html: true,
            confirmButtonText: "OK, obrigado!"});
    }, 'json');
    return false;
});

$('#u_btn_fechar').on('click', function () {
    $('#u_cpf').val('');
    $('#u_data_nascimento').val('');
    $('#u_email_alternativo').val('');
    $('#u_apelido').val('');
    $('#u_telefone_fixo').val('');
    $('#u_telefone_celular').val('');
    $('#u_uf').val('--');
    $('#u_especialidades').tagsManager('empty');
    $('#u_certificacao').val('');
});

function detailLink() {
    /*
     * pega as informacoes do usuario
     */
    $.post('/pf/DIM.Gateway.php', {'i': userId, 'arq': 79, 'tch': 1, 'sub': 4, 'dlg': 1}, function (data) {
        $('#u_cpf').val(data.cpf);
        $('#u_data_nascimento').val(data.data_nascimento);
        $('#u_email_alternativo').val(data.email_alternativo);
        $('#u_apelido').val(data.apelido);
        $('#u_telefone_fixo').val(data.telefone_fixo);
        $('#u_telefone_celular').val(data.telefone_celular);
        especialidades = data.especialidades;
        for (x = 0; x < especialidades.length; x++) {
            jQuery("#u_especialidades").tagsManager('pushTag', especialidades[x]);
        }
        $('#u_uf').val(data.uf);
        $('#avatar-frame-user').contents().find('#avatar_img').attr('src', avatarUser);
        $('#u_certificacao').val(data.certificacao);
    }, 'json');
}
/*
 * formatacao dos telefones para um digito a mais
 */
var SPMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
}, spOptions = {onKeyPress: function (val, e, field, options) {
        field.mask(SPMaskBehavior.apply({}, arguments), options);
    }};

$('.sp_celphones').mask(SPMaskBehavior, spOptions);

jQuery('#u_especialidades').tagsManager({
    blinkBGColor_1: '#FFFF9C',
    blinkBGColor_2: '#CDE69C'
});