$('.link-atribuicoes').on('click', function () {
    comboRoles(0, 'atribuicao_id', 'w_atribuicao');
});

$('#fechar_perfil_ap').on('click', function () {
    $('#addAtribuicao').empty();
});

$('#atribuicao_id').on('change', function () {
    if ($(this).val() != 0) {
        iWait('w_atribuicao', true)
        $.post('/pf/DIM.Gateway.php', {'i': $(this).val(), 'arq': 47, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
            $('#addAtribuicao').empty();
            if (data.length == 0) {
                swal({
                    title: "Alerta",
                    text: "N&atilde;o h&aacute; permiss&otilde;es associadas a este grupo/perfil.",
                    type: "error",
                    html: true,
                    confirmButtonText: "Entendi, obrigado!"});
                $('#atribuicao_id').val(0);
            } else {
                for (x = 0; x < data.length; x++) {
                    addLinhaAtribuicao(data[x].ID, data[x].Description, data[x]._Title);
                }
            }
            iWait('w_atribuicao', false);
        }, 'json');
    }
    else {
        $('#addAtribuicao').empty();
    }
});
/**
 * 
 * @param Int i id da permission
 * @param String d descricao da permission
 * @param String ti titulo da permission
 * @returns null
 */
function addLinhaAtribuicao(i, d, ti) {
    var t = $('#addAtribuicao').get(0);
    var r = t.insertRow(-1);
    var c1 = r.insertCell(0);
    var c2 = r.insertCell(1);
    c1.setAttribute('align', 'center');
    c1.innerHTML = '<input type="checkbox" name="id_permission" id="id_permission_' + i + '" class="css-checkbox" value="' + i + '" checked disabled /><label for="id_permission_' + i + '" class="css-label-check">&nbsp;</label>';
    c2.innerHTML = '<strong>' + ti + '</strong>&nbsp;' + d;
}