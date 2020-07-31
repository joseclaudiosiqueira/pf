/*
 * botoes do tab_finalizar
 */
$("#chk_is_processo_validacao_1").on("click", function () {
    $('#is_processo_validacao').val(1);
    if ($('#email-validador').val() !== '') {
        $('#btn-validar-contagem').prop('disabled', true);
    }
    else {
        $('#btn-selecionar-validador').prop('disabled', false);
        $('#btn-validar-contagem').prop('disabled', true);
    }
});

$("#chk_is_processo_validacao_2").on("click", function () {
    /*
     * limpa se alguma coisa estiver selecionada
     */
    limpaValidador();
    $('#is_processo_validacao').val(0);
    $('#btn-selecionar-validador').prop('disabled', true);
    $('#btn-enviar-validacao').prop('disabled', true);
    $('#btn-validar-contagem').prop('disabled', false);
});

$("#btn-validar-contagem").on("click", function () {
    //validar automaticamente - processo = 10
    atualizaProcessoValidacao(10, idContagem, emailLogado, true);
});

$('#btn-enviar-validacao').on('click', function () {
    //inserido um validador - processo = 2
    atualizaProcessoValidacao(2, idContagem, $('#email-validador').val(), true);
});

$('#btn-selecionar-validador').on('click', function () {
    var escopo = 'vi';
    if ($('#id').val() === '-' || (
            getQtdAtual('ALI') === 1 &&
            getQtdAtual('AIE') === 1 &&
            getQtdAtual('EE') === 1 &&
            getQtdAtual('SE') === 1 &&
            getQtdAtual('CE') === 1 &&
            getQtdAtual('OU') === 1)) {
        swal({
            title: "Alerta",
            text: "Antes de selecionar um Validador voc&ecirc; deve inserir as informa&ccedil;&otilde;es b&aacute;sicas da contagem e ao menos uma fun&ccedil;&atilde;o de DADOS e/ou TRANSA&Ccedil;&Atilde;O.",
            type: "error",
            html: true,
            confirmButtonText: "Entendi, obrigado!"});
        $(this).attr('data-toggle', '');
    }
    else {
        $(this).attr('data-toggle', 'modal');
        var respContagem = $('#responsavel').val();
        $.post('/pf/DIM.Gateway.php', {'escopo': escopo, 'arq': 38, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
            $('#addValidador').empty();
            for (x = 0; x < data.length; x++) {
                if (data[x].user_email !== respContagem) {
                    adicionarLinhasValidador(data[x]);
                }
            }
        }, 'json');
    }
});

$('#privacidade').on('change', function () {//na tab finalizar para o formulario de contagens
    if (isAtualizarPrivacidade) {
        $.post('/pf/DIM.Gateway.php', {
            'i': $('#id').val(), 'p': $(this).prop('checked') ? 1 : 0, 'arq': 13, 'tch': 0, 'sub': -1, 'dlg': 1},
        function (data) {
            if (data.msg) {
                $("#span-privacidade").animate({opacity: 0}, function () {
                    $(this).html("Privacidade definida com sucesso!")
                            .animate({opacity: 1}).animate({opacity: 0}, 3000);
                });
            }
        }, 'json');
    }
});
