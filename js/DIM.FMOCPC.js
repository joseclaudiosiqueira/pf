function salvarAnaliseFiscalContrato() {
    tipoComparacao = compararContagens ? 0 : 1;
    var analise = CKEDITOR.instances.analiseFiscalContrato.getData();
    $.post('/pf/DIM.Gateway.php', {
        'arq': 80,
        'tch': 0,
        'sub': -1,
        'dlg': 0,
        'analise': analise,
        'tipo': tipoComparacao,
        'contagemID1': comparaID1,
        'contagemID2': comparaID2
    }, function (data) {
        swal({
            title: "Informa&ccedil;&atilde;o",
            text: data.msg,
            type: data.sucesso ? "success" : "warning",
            html: true,
            confirmButtonText: "Ok, obrigado!"});
    }, 'json');
}