$('#form-aponte').on('submit', function () {
    var aponte = CKEDITOR.instances.txtAponte.getData();
    if (aponte === '') {
        swal({
            title: "Alerta",
            text: "Insira algo no campo de apontes de valida&ccedil;&atilde;o e/ou auditoria.",
            type: "error",
            html: true,
            confirmButtonText: "Entendi!"});
    }
    else {
        $.post('/pf/DIM.Gateway.php', {
            'i': idContagem,
            't': ac, //ve, ai e ae
            'a': aponte, //descricao
            'd': $('#responsavel').val(),
            'arq': 22, 'tch': 0, 'sub': -1, 'dlg': 1
        }, function (data) {
            var table = $('#addApontes').get(0);
            var row = table.insertRow(0);
            var cell0 = row.insertCell(0);
            cell0.innerHTML = '<div class="row" style="margin: 5px;">' +
                    '<div class="col-md-2" style="text-align: center;">' +
                    '   <img id="img-aponte-' + data.id + '" class="img img-circle" witdh="80" height="80">' +
                    '</div>' +
                    '<div class="col-md-10">' +
                    '   <div class="bubble-insercao">' +
                    '       <strong>' + data.apelido + '</strong><br />[ ' + data.short_name + ' - ' +
                    formattedDate(new Date(), true, true) +
                    ' ]&nbsp;&nbsp;&nbsp;<a href="#" id="btn-resolvido-' + data.id + '" onclick="' + (data.status == 0 || emailLogado != data.destinatario ? 'return false;' : '') + 'marcarResolvido(' + data.id + ');">' + (data.status == 1 ? '<i class="fa fa-check-circle"></i>&nbsp;' + formattedDate(data.data_resolucao, true, true) : '<i class="fa fa-clock-o"></i>&nbsp;' + (emailLogado == data.destinatario ? 'Resolvido' : 'Aguardando resposta...')) + '</a>' +
                    '</div>' +
                    '<div class="bubble-comentario">' +
                    aponte +
                    '</div>' +
                    '</div>' +
                    '</div>';
            CKEDITOR.instances['txtAponte'].setData('');
            /*
             * tambem consulta por id unico de usuario logado
             */
            consultaGravatar(emailLogado, '#img-aponte-' + data.id);
        }, 'json');
    }

    return false;
});

$('#fechar-apontes').on('click', function () {
    $('#addApontes').empty();
    CKEDITOR.instances['txtAponte'].setData('');
});

//cliques nos botoes de resposta na tela de tarefas pendentes
function finalizarAponte(ida, idt, idc) {
    var resposta = CKEDITOR.instances['aponte-' + ida].getData();
    if (resposta === '') {
        swal({
            title: "Alerta",
            text: "Redija um texto para a resposta ao aponte de Valida&ccedil;&atilde;o ou Auditoria.",
            type: "error",
            html: true,
            confirmButtonText: "Entendi!"});
    }
    else {
        $.post('/pf/DIM.Gateway.php', {
            'ida': ida,
            'idt': idt,
            'r': resposta,
            'idc': idc,
            'arq': 17,
            'tch': 0,
            'sub': -1,
            'dlg': 1}, function (data) {
            if (data.sucesso) {
                swal({
                    title: "Informa&ccedil;&atilde;o",
                    text: "O aponte foi finalizado com sucesso.",
                    type: "success",
                    html: true,
                    confirmButtonText: "Ok, obrigado!"});
                $('#aponte' + ida).html('<div style="padding: 10px; border:1px dotted #d0d0d0; border-radius: 5px; margin-bottom: 5px;">' +
                        resposta +
                        '</div>');
                $('#navbar-listar-tarefas-pendentes').html(data.qtd);
            }
            else {
                swal({
                    title: "Alerta",
                    text: "N&atilde;o foi poss&iacute;vel atualizar o aponte, favor tentar novamente.",
                    type: "error",
                    html: true,
                    confirmButtonText: "Entendi!"});
            }
        }, 'json');
    }
}

function retornaApontes(id) {
    var table = $('#addApontes').get(0);
    var row;
    $.post('/pf/DIM.Gateway.php', {'id': id, 'email': emailLogado,
        'arq': 29, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
        if (data.length > 0) {
            for (x = 0; x < data.length; x++) {
                row = table.insertRow(-1);
                var cell0 = row.insertCell(0);
                cell0.innerHTML = '<div class="row" style="margin: 5px;">' +
                        '<div class="col-md-2" style="text-align: center;">' +
                        '   <img id="img-aponte-' + data[x].id + '" class="img img-circle" witdh="80" height="80">' +
                        '</div>' +
                        '<div class="col-md-10">' +
                        '<div class="bubble-insercao">' +
                        '<strong>' + data[x].apelido + '</strong><br />[ ' + data[x].short_name + ' - ' +
                        formattedDate(data[x].data_insercao, true, true) +
                        ' ]&nbsp;&nbsp;&nbsp;<a href="#" id="btn-resolvido-' + data[x].id + '" onclick="' + (data[x].status == 0 || emailLogado != data.destinatario ? 'return false;' : '') + 'marcarResolvido(' + data[x].id + ');">' + (data[x].status == 1 ? '<i class="fa fa-check-circle"></i>&nbsp;' + formattedDate(data[x].data_resolucao, true, true) : '<i class="fa fa-clock-o"></i>&nbsp;' + (emailLogado == data[x].destinatario ? 'Resolvido' : 'Aguardando resposta...')) + '</a>' +
                        '</div>' +
                        '<div class="bubble-comentario">' +
                        data[x].aponte +
                        (data[x].status == 1 ? '<br />' +
                                '<div class="row">' +
                                '   <div class="col-md-2">' +
                                '       <img id="img-resolvido-' + data[x].id + '" class="img img-circle" witdh="64" height="64">' +
                                '   </div>' +
                                '<div class="col-md-10">' +
                                formattedDate(data[x].data_resolucao, true, true) +
                                ' - <a href="mailto:' + data[x].resolvido_por + '">' + data[x].resolvido_por + '</a><br />' +
                                data[x].observacoes +
                                '</div></div>' : '') +
                        '</div>' +
                        '</div>' +
                        '</div>';
                //data[x].email -> quem gravou o comentario
                consultaGravatar(data[x].user_email, '#img-aponte-' + data[x].id);
                data[x].status == 1 ? consultaGravatar(data[x].resolvido_por, '#img-resolvido-' + data[x].id) : null;
            }
        }
    }, 'json');
}