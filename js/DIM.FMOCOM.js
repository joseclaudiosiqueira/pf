$('#form-comentarios').on('submit', function () {
    var comentario = CKEDITOR.instances.txtComentario.getData();
    if (comentario === '') {
        swal({
            title: "Alerta",
            text: "Insira algo no campo de coment&aacute;rio/observa&ccedil;&atilde;o.",
            type: "error",
            html: true,
            confirmButtonText: "Entendi!"});
    }
    else {
        var destinatario = $('#responsavel').val();
        var id = $('#comentario-id-funcao').val();
        var tabela = $('#comentario-tabela').val();
        $.post('/pf/DIM.Gateway.php', {
            'i': id,
            'c': comentario,
            'd': destinatario,
            't': tabela,
            'arq': 25, 'tch': 0, 'sub': -1, 'dlg': 1
        }, function (data) {
            var table = $('#addComentarios').get(0);
            var row = table.insertRow(0);
            var cell0 = row.insertCell(0);
            cell0.innerHTML = '<div class="row" style="margin:5px;">' +
                    '<div class="col-md-2"><center>' +
                    '<img id="img-comentario-' + data.id + '" class="img img-circle" witdh="80" height="80">' +
                    '</center></div>' +
                    '<div class="col-md-10">' +
                    '<div class="bubble-insercao"><small>' +
                    '<strong><a href="mailto:' + data.user_email + '"><i class="fa fa-envelope-o"></i>&nbsp;' +
                    (data.apelido === null ? data.short_name : data.apelido) +
                    '</a></strong><br />[ ' + data.short_name + ' - ' + (data.telefone_fixo === null ? '(00) 0000-0000' : data.telefone_fixo) + ' - ' +
                    formattedDate(new Date(), true, true) +
                    ' ]&nbsp;&nbsp;&nbsp;<a href="#" id="btn-lida-' + data.id +
                    '" onclick="return false;">' +
                    (Number(data.status) == 1 ?
                            '<i class="fa fa-check-circle"></i>&nbsp;Em: ' +
                            formattedDate(data.data_leitura, false, true) :
                            '<i class="fa fa-clock-o"></i>&nbsp;Aguardando leitura') + '</a>' +
                    '</small>' +
                    '</div>' +
                    '<div class="bubble-comentario">' +
                    comentario +
                    '</div>' +
                    '</div>' +
                    '</div>';
            CKEDITOR.instances['txtComentario'].setData('');
            /*
             * atualiza o span abaixo na lista com mais um comentario em lidos ou nao lidos
             */
            var linha = $('#comentario-linha').val();
            var qtdAtual = Number(data.status) == 1 ?
                    Number($('#lido-' + tabela.toUpperCase() + '-' + linha).html()) :
                    Number($('#nlido-' + tabela.toUpperCase() + '-' + linha).html());
            Number(data.status) == 1 ?
                    $('#lido-' + tabela.toUpperCase() + '-' + linha).html(++qtdAtual) :
                    $('#nlido-' + tabela.toUpperCase() + '-' + linha).html(++qtdAtual);
            /*
             * aqui consulta com quem esta logado
             */
            consultaGravatar(emailLogado, '#img-comentario-' + data.id);
        }, 'json');
    }

    return false;
});

$('#fechar-comentarios').on('click', function () {
    $('#addComentarios').empty();
    $('#comentario-id-funcao').val(0);
    $('#comentario-tabela').val('');
    $('#comentario-linha').val(0);
    CKEDITOR.instances['txtComentario'].setData('');
});

/**
 * 
 * @param {type} id - id da contagem??
 * @param {type} tbl - ALI, AIE, ...
 * @param {type} linha - ??
 * @param {type} isTodos - se vier da tela de lista contagens, exibe todos os comentarios
 * @returns {undefined}
 */
function retornaComentarios(id, tbl, linha, isTodos) {
    var table = $('#addComentarios').get(0);
    var row;
    $.post('/pf/DIM.Gateway.php', {'id': id, 'tbl': tbl,
        'arq': 31, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
        if (data.length > 0) {
            for (x = 0; x < data.length; x++) {
                row = table.insertRow(-1);
                var cell0 = row.insertCell(0);
                cell0.innerHTML = '<div class="row" style="margin:5px;">' +
                        '<div class="col-md-2"><center>' +
                        '<img id="img-comentario-' + data[x].id + '" class="img img-circle" witdh="80" height="80">' +
                        '</center></div>' +
                        '<div class="col-md-10">' +
                        '<div class="bubble-insercao"><small>' +
                        '<strong><a href="mailto:' + data[x].user_email + '"><i class="fa fa-envelope-o"></i>&nbsp;' +
                        (data[x].apelido === null ? data[x].short_name : data[x].apelido) +
                        '</a></strong><br />[ ' + data[x].short_name + ' - ' + (data[x].telefone_fixo === null ? '(00) 0000-0000' : data[x].telefone_fixo) + ' - ' +
                        formattedDate(data[x].data_insercao, true, true) +
                        ' ]&nbsp;&nbsp;&nbsp;<a href="#" id="btn-lida-' + data[x].id + '" onclick="' +
                        (data[x].status == 1 || emailLogado != data[x].destinatario ?
                                'return false;' : '') +
                        'marcarLida(' + data[x].id + ', ' + linha + ', \'' + tbl + '\');">' +
                        (data[x].status == 1 ?
                                '<i class="fa fa-check-circle"></i>&nbsp;Em: ' +
                                formattedDate(data[x].data_leitura, false, true) :
                                '<i class="fa fa-clock-o"></i>&nbsp;' +
                                (emailLogado == data[x].destinatario ?
                                        'Marcar como lido' :
                                        'Aguardando leitura')) + '</a>' +
                        '</small>' +
                        '</div>' +
                        '<div class="bubble-comentario">' +
                        data[x].comentario +
                        '</div>' +
                        '</div>' +
                        '</div>';
                consultaGravatar(data[x].user_email, '#img-comentario-' + data[x].id);
            }
        }
    }, 'json');
    $('#comentario-id-funcao').val(id);
    $('#comentario-tabela').val(tbl);
    $('#comentario-linha').val(linha);
}

function marcarLida(idComentario, idLinha, tabela) {
    $.post('/pf/DIM.Gateway.php', {'id': idComentario,
        'arq': 8, 'tch': 0, 'sub': -1, 'dlg': 1}, function (data) {
        if (data.status) {
            $('#btn-lida-' + idComentario).prop('disabled', true).html('<i class="fa fa-check-circle"></i>&nbsp;Em: ' + formattedDate(new Date(), false, true));
            /*
             * atualiza o span abaixo na lista com mais um comentario em lidos ou nao lidos
             */
            var lido = Number($('#lido-' + tabela.toUpperCase() + '-' + idLinha).html());
            var nlido = Number($('#nlido-' + tabela.toUpperCase() + '-' + idLinha).html());
            /*
             * decrementa os comentarios
             */
            $('#lido-' + tabela.toUpperCase() + '-' + idLinha).html(++lido);
            $('#nlido-' + tabela.toUpperCase() + '-' + idLinha).html(--nlido);
        }
    }, 'json');
}

function ocultarComentario(id) {
    $.post('/pf/DIM.Gateway.php', {'id': id, 'arq': 9, 'tch': 0, 'sub': -1, 'dlg': 1}, function (data) {
        if (data) {

        }
    }, 'json');
}
