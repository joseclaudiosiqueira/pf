function adicionarLinhasValidador(data) {
    var t = $('#addValidador').get(0);
    var r = t.insertRow(-1);

    var cell0 = r.insertCell(0);
    var cell1 = r.insertCell(1);
    var cell2 = r.insertCell(2);
    //var cell3 = r.insertCell(3);

    cell0.innerHTML = '<img src="' + data.gravatar + '" id="img-' + data.user_id + '" onclick="selecionaValidador(\'' + data.user_email + '\',\'' + data.user_complete_name + '\', this);" class="img-circle img-responsive" style="width:80px; height:80px; cursor:default; cursor:pointer;">';
    cell1.innerHTML = '<font style="font-family:arial; font-size:16px; font-weight:bold; text-shadow: 1px 0px #fff;">' + data.user_complete_name + '</font><br />' +
            '<font style="color: #999"><i class="fa fa-phone-square"></i>&nbsp;' +
            (data.telefone_celular !== null ? data.telefone_celular : '-') + '<br />' +
            '<i class="fa fa-phone"></i>&nbsp;' + (data.telefone_fixo !== null ? data.telefone_fixo : '-') + '</font>';
    cell2.innerHTML = '<font style="font-size:9px; color:#999; text-shadow: 1px 0px #fff;">Principal<br /></font><a href="mailto:' + data.user_email + '">' + data.user_email + '</a><br />' +
            '<font style="font-size:9px; color:#999; text-shadow: 1px 0px #fff;">Alternativo<br /></font>' + (data.email_alternativo !== null ? '<a href="mailto:' + data.email_alternativo + '">' + data.email_alternativo + '</a>' : '-');
    //cell3.innerHTML = 'Valida&ccedil;&otilde;es Pendentes: 3, Contagens validadas: 16<br />Tempo M&eacute;dio de Valida&ccedil;&atilde;o: <br />VALIDA&Ccedil;&Atilde;O - Maior 1.600PF (3d 4h 16m 45s), Menor: 40PF (0d 2h 23m 24s)';
    //atualiza o gravatar
    //consultaGravatar(data.user_email, '#img-' + data.user_id);
}

function selecionaValidador(email, nome, e) {
    $(e).attr('data-dismiss', 'modal');
    $('#validador-selecionado').html('Voc&ecirc; selecionou: <u><strong>' + nome + '</strong></u> como validador desta contagem.');
    $('#email-validador').val(email);
    $('#btn-enviar-validacao').prop('disabled', false);
    $('#btn-selecionar-validador').prop('disabled', true);
    consultaGravatar(email, '#img-validador');
    $('#div-validador').css('visibility', 'visible');
}

function limpaValidador() {
    $('#validador-selecionado').html('');
    $('#email-validador').val('');
    $('#btn-enviar-validacao').prop('disabled', true);
    $('#btn-selecionar-validador').prop('disabled', false);
    $('#img-validador').attr('src', '/pf/img/user.jpg');
    $('#div-validador').css('visibility', 'hidden');
}