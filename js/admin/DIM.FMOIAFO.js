/*
 * planos demo e estudante não inserem fornecedores
 */
if (empresaConfigPlano.id < 3) {
    $('#fmiafor-link').css({'text-decoration': 'line-through'});
}
/*
 * modal das configuracoes do fornecedor
 */
$('#fmiafor-txt-captcha').on('keyup', function () {
    verificaCaptcha($(this), $('#fmiafor-i-captcha'), false);
});
/*
 * para todos dos forms a leitura da imagem do captcha eh feita no click para evitar desatualizacoes
 */
$('.turma-fornecedor-link').on('click', function () {
    alteraHeaderTurmaFornecedor();
});
/*
 * no caso do fornecedor tem que pegar a acao do clique no botao alterar
 */
$('#forn-btn-alterar').on('click', function () {
    formulario = 'forn';
    alteraHeaderTurmaFornecedor();
});
/*
 * no caso do fornecedor tem que pegar a acao do clique no botao alterar
 */
$('#turma-btn-alterar').on('click', function () {
    formulario = 'turma';
    alteraHeaderTurmaFornecedor();
});
/*
 * clique no botao btn_alterar_fornecedor apenas quando o usuario esta em modo FORNECEDOR
 * em outro modo devera ser o change da comboBox.
 */
$('#link_alterar_configuracoes_fornecedor').on('click', function () {
    $('#fmiafor-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
    exibeInformacoesFornecedor(0);
});

$('#form_inserir_alterar_fornecedor').on('submit', function () {
    /*
     * confere o captcha
     */
    if ($('#fmiafor-txt-captcha').val().length < 4) {
        swal({
            title: "Alerta",
            text: "As letras da imagem est&atilde;o diferentres do que foi digitado.",
            type: "error",
            html: true,
            confirmButtonText: "Vou corrigir, obrigado!"});
    }
    else {
        $.post('/pf/DIM.Gateway.php', {
            'forn-id': $('#forn-id').val(),
            'forn-acao': $('#forn-acao').val(),
            'forn-sigla': $('#forn-sigla').val(),
            'forn-nome': $('#forn-nome').val(),
            'forn-preposto-nome': $('#forn-preposto-nome').val(),
            'forn-preposto-email': $('#forn-preposto-email').val(),
            'forn-preposto-email-alternativo': $('#forn-preposto-email-alternativo').val(),
            'forn-preposto-telefone': $('#forn-preposto-telefone').val(),
            'forn-preposto-ramal': $('#forn-preposto-ramal').val(),
            'forn-preposto-telefone-celular': $('#forn-preposto-telefone-celular').val(),
            'forn-is-ativo': $('#forn-is-ativo').prop('checked') ? 1 : 0,
            'forn-tipo': activeTab === '#fornecedores' ? 0 : 1,
            'arq': 47, 'tch': 0, 'sub': 0, 'dlg': 1
        }, function (data) {
            swal({
                title: "Informa&ccedil;&atilde;o",
                text: data.msg,
                type: "success",
                html: true,
                confirmButtonText: "Obrigado!"});
            if ($('#forn-acao').val() === 'inserir') {
                $('#forn-id').val(data.id);
                $('#forn-btn-inserir').prop('disabled', true);
                $('#forn-btn-novo').prop('disabled', false);
                $('#forn-btn-atualizar').prop('disabled', false);
                $('#avatar-frame-forn').contents().find('#avatar_id').val(data.id);
                /*
                 * atualiza a combo dos fornecedores
                 */
                comboFornecedores('combo_alterar', 0, '01', (activeTab === '#fornecedores' ? 0 : 1), true);
            }
            else if ($('#forn-acao').val() === 'alterar') {
                if (!isFornecedor) {
                    comboFornecedores('combo_alterar', data.id, '01', (activeTab === '#fornecedores' ? 0 : 1), true);
                    $('#' + formulario + '-span-nome').html($('#forn-sigla').val() + ' - ' + $('#forn-nome').val());
                    $('#' + formulario + '-span-preposto-nome').html($('#forn-preposto-nome').val());
                    $('#' + formulario + '-span-preposto-email').html('<a href="mailto:' + $('#forn-preposto-email').val() + '">' + $('#forn-preposto-email').val() + '</a>');
                    $('#' + formulario + '-span-preposto-telefone').html($('#forn-preposto-telefone').val() + ($('#forn-preposto-ramal').val() !== '' ? ' - ' + $('#forn-preposto-ramal').val() : ''));
                }
            }
            $('#div-txt-' + (formulario === 'forn' ? 'fornecedor' : 'turma')).html(
                    'Atualmente est' + (formulario === 'forn' ? 'e' : 'a') + (formulario === 'forn' ? ' fornecedor' : ' turma') +
                    ' est&aacute;' + ($('#forn-is-ativo').prop('checked') ? ' <kbd>ativ' + (formulario === 'forn' ? 'o</kbd>' : 'a</kbd>') : ' <kbd>inativ' + (formulario === 'forn' ? 'o</kbd>' : 'a</kbd>')));
            $('#fmiafor-txt-captcha').val('');
            $('#fmiafor-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
        }, 'json');
    }
    return false;
});

/*
 * clique no botao para fechar a janela do fornecedor
 */
$('#forn-fechar').on('click', function () {
    limpaCamposFornecedor();
    return true;
});

/*
 * clique no botao para inserir um novo fornecedor
 */
$('#forn-btn-novo').on('click', function () {
    limpaCamposFornecedor();
    return true;
});

/*
 * clique na combo alterar_id_fornecedor / id_turma
 */
$('.combo-turma-fornecedor').on('change', function () {
    if ($(this).val() > 0) {
        $.post('/pf/DIM.Gateway.php', {'i': $(this).val(), 'arq': 22, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
            $('#' + formulario + '-info').css({visibility: 'visible'});
            if (data.logomarca !== '')
                $('#' + formulario + '-span-logomarca').html('<img src="/pf/vendor/cropper/producao/crop/img/img-forn/' + data.logomarca + '.png?' + new Date().getTime() + '" class="img-thumbnail" width="150" height="150">');
            else
                $('#' + formulario + '-span-logomarca').html('<img src="/pf/img/blank_logo.pt_BR.jpg?' + new Date().getTime() + '" class="img-thumbnail img-responsive" width="150" height="150">');
            $('#' + formulario + '-span-nome').html(data.sigla + ' - ' + data.nome);
            $('#' + formulario + '-span-preposto-nome').html(data.preposto_nome);
            $('#' + formulario + '-span-preposto-email').html('<a href="mailto:' + data.preposto_email + '">' + data.preposto_email + '</a>');
            $('#' + formulario + '-span-preposto-telefone').html(data.preposto_telefone);
            $('#div-txt-' + (formulario === 'forn' ? 'fornecedor' : 'turma')).html(
                    'Atualmente est' + (formulario === 'forn' ? 'e' : 'a') + (formulario === 'forn' ? ' fornecedor' : ' turma') +
                    ' est&aacute;' + (data.is_ativo == 1 ? ' <kbd>ativ' + (formulario === 'forn' ? 'o</kbd>' : 'a</kbd>') : ' <kbd>inativ' + (formulario === 'forn' ? 'o</kbd>' : 'a</kbd>')));

        }, 'json');
        $('#' + (formulario === 'forn' ? 'forn' : 'turma') + '-btn-alterar').prop('disabled', false);
    }
    else {
        $('#' + formulario + '-info').css({visibility: 'hidden'});
        $('#' + formulario + '-span-logomarca').html('<img src="/pf/img/blank_logo.pt_BR.jpg" class="img-thumbnail img-responsive" width="150" height="150">');
        $('#' + formulario + '-span-nome').html('--');
        $('#' + formulario + '-span-preposto-email').html('--');
        $('#' + formulario + '-span-preposto-telefone').html('--');
        $('#' + formulario + '-btn-alterar').prop('disabled', true);
    }
});
/*
 * captura o clique no botao alterar
 */
$('.btn-alterar-turma-fornecedor').on('click', function () {
    if ($('#combo_alterar_id_' + (activeTab === '#fornecedores' ? 'fornecedor' : 'turma')).val() > 0) {
        $('#forn-acao').val('alterar');
        $('#fmiafor-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
        exibeInformacoesFornecedor($('#combo_alterar_id_' + (activeTab === '#fornecedores' ? 'fornecedor' : 'turma')).val());
    }
});
/*
 * funcao generica para exibir as informacoes do fornecedor
 * id do fornecedor - passa sempre e confere no json_consulta...
 */
function exibeInformacoesFornecedor(i) {
    /*
     * variavel que recebe o id do fornecedor
     */
    var id = i === 0 ? idFornecedor : i;
    /*
     * insere as mascaras para os telefones incluindo os que tem nove digitos
     */
    var phoneWithNineDigits = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
            nineDigitsOptions = {
                onKeyPress: function (val, e, field, options) {
                    field.mask(phoneWithNineDigits.apply({}, arguments), options);
                }
            };
    $.post('/pf/DIM.Gateway.php', {
        'i': id, 
        'arq': 22, 
        'tch': 1, 
        'sub': -1, 
        'dlg': 1}, function (data) {
        var sigla = (data.sigla).replace('(TURMA) ','');
        $('#forn-sigla').val(sigla);
        $('#forn-nome').val(data.nome);
        $('#forn-preposto-nome').val(data.preposto_nome);
        $('#forn-preposto-email').val(data.preposto_email);
        $('#forn-preposto-email-alternativo').val(data.preposto_email_alternativo);
        $('#forn-preposto-telefone').val(data.preposto_telefone).mask(phoneWithNineDigits, nineDigitsOptions);
        $('#forn-preposto-ramal').val(data.preposto_ramal);
        $('#forn-preposto-telefone-celular').val(data.preposto_telefone_celular).mask(phoneWithNineDigits, nineDigitsOptions);
        $('#forn-btn-novo').prop('disabled', true);
        $('#forn-btn-inserir').prop('disabled', true);
        $('#forn-btn-atualizar').prop('disabled', false);
        $('#forn-id').val(data.id);
        $('#forn-is-ativo').bootstrapToggle(data.is_ativo == 1 ? 'on' : 'off');
        $('#avatar-frame-forn').contents().find('#avatar_id').val(data.id);
        if (data.logomarca !== '')
            $('#avatar-frame-forn').contents().find('#avatar_img').attr('src', '/pf/vendor/cropper/producao/crop/img/img-forn/' + data.logomarca + '.png?' + new Date().getTime());
        else
            $('#avatar-frame-forn').contents().find('#avatar_img').attr('src', '/pf/img/blank_logo.pt_BR.jpg?' + new Date().getTime());
    }, 'json');
}

/*
 * limpa os campos do formulario
 */
function limpaCamposFornecedor() {
    $('#forn-id').val('');
    $('#forn-acao').val('inserir');
    $('#forn-sigla').val('');
    $('#forn-nome').val('');
    $('#forn-is-ativo').bootstrapToggle('on');
    $('#forn-sigla').val('');
    $('#forn-nome').val('');
    $('#forn-preposto-nome').val('');
    $('#forn-preposto-email').val('');
    $('#forn-preposto-email-alternativo').val('');
    $('#forn-preposto-telefone').val('');
    $('#forn-preposto-ramal').val('');
    $('#forn-preposto-telefone-celular').val('');
    $('#fmiafor-txt-captcha').val('');
    $('#forn-btn-novo').prop('disabled', isInst ? false : true);//isInst = eh uminstrutor?
    $('#forn-btn-inserir').prop('disabled', isFornecedor && !isInst ? true : false);
    $('#forn-btn-atualizar').prop('disabled', isFornecedor && !isInst ? false : true);
    $('#avatar-frame-forn').attr('src', '/pf/vendor/cropper/producao/crop/index.php?t=forn');
}

function alteraHeaderTurmaFornecedor() {
    if (empresaConfigPlano.id < 3 && isInst) {
        return false;
    }
    /*
     * faz as alteracoes nos labels e titulos
     */
    if (formulario === 'forn') {
        $('#i-forn-titulo').removeClass('fa fa-building-o').removeClass('fa fa-graduation-cap').addClass('fa fa-building-o');
        $('#span-forn-titulo').html('Fornecedores');
        $('#h4-forn-titulo').html('Informa&ccedil;&otilde;es do Fornecedor');
        $("label[for='forn-sigla']").html('Sigla');
        $("label[for='forn-nome']").html('Nome do Fornecedor');
        $("label[for='forn-preposto-nome']").html('Preposto (nome)');
        $("label[for='forn-preposto-email']").html('Preposto (email)');
        $("label[for='forn-preposto-email-alternativo']").html('Preposto (email alternativo)');
        $('#kbd-titulo').html('Fornecedores');
    }
    else {
        $('#i-forn-titulo').removeClass('fa fa-building-o').removeClass('fa fa-graduation-cap').addClass('fa fa-graduation-cap');
        $('#span-forn-titulo').html('Turmas e treinamentos');
        $('#h4-forn-titulo').html('Informa&ccedil;&otilde;es da Turma');
        $("label[for='forn-sigla']").html('C&oacute;digo da turma');
        $("label[for='forn-nome']").html('Descri&ccedil;&atilde;o da turma');
        $("label[for='forn-preposto-nome']").html('Instrutor');
        $("label[for='forn-preposto-email']").html('Email do Instrutor');
        $("label[for='forn-preposto-email-alternativo']").html('Email do Instrutor (alternativo)');
        $('#kbd-titulo').html('Turmas de treinamento');
    }
    /*
     * clique no link deixa o botao atualizar e inserir novo desabilitados
     */
    $('#forn-btn-atualizar').prop('disabled', true);
    $('#forn-btn-novo').prop('disabled', true);
    /*
     * continua com o processamento normal
     */
    $('#fmiafor-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
}