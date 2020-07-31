//variavel de topo
var dataFormCliente;
//formulario de cadastro de clientes
$('#fmiacli-txt-captcha').on('keyup', function () {
    verificaCaptcha($(this), $('#fmiacli-i-captcha'), false);
});
if (empresaConfigPlano.id < 3) {
    $('#cli-inserir').css({'text-decoration': 'line-through'});
}
/*
 * para todos dos forms a leitura da imagem do captcha eh feita no click para evitar desatualizacoes
 */
$('#cli-inserir').on('click', function () {
    if (!isFornecedor) {
        $('#fmiacli-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
    }
});
$('#fmiacli_btn_alterar').on('click', function () {
    if (!isFornecedor) {
        $('#fmiacli-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
    }
});

/*
 * para inserir um novo cliente
 */
$('#form_inserir_alterar_cliente').on('submit', function () {
    var acao = $('#fmiacli_acao').val();
    /*
     * confere o captcha
     */
    if ($('#fmiacli-txt-captcha').val().length < 4) {
        swal({
            title: "Alerta",
            text: "As letras da imagem est&atilde;o diferentes do que foi digitado.",
            type: "error",
            html: true,
            confirmButtonText: "Vou corrigir, obrigado!"});
    }
    else {
        $.post('/pf/DIM.Gateway.php', variaveisFormCliente(acao), function (data) {
            if (data.id > 0) {
                swal({
                    title: "Informa&ccedil;&atilde;o",
                    text: data.msg,
                    type: "success",
                    html: true,
                    confirmButtonText: "Obrigado!"});
                if (dataFormCliente.acao === 'inserir') {
                    $('#fmiacli_id').val(data.id);
                    $('#fmiacli_btn_inserir').prop('disabled', true);
                    $('#fmiacli_btn_novo').prop('disabled', false);
                    $('#fmiacli_btn_atualizar').prop('disabled', false);
                    $('#avatar-frame-cli').contents().find('#avatar_id').val(data.id);
                    //atualiza a combo dos clientes
                    comboCliente('combo_alterar', 0, '01', (isFornecedor ? idFornecedor : 0));
                }
                else if (dataFormCliente.acao === 'alterar') {
                    comboCliente('combo_alterar', data.id, '01', (isFornecedor ? idFornecedor : 0));
                    $('#fmiacli_span_descricao').html(data.descricao);
                    $('#fmiacli_span_nome').html(data.nome);
                    $('#fmiacli_span_email').html('<a href="mailto:' + data.email + '">' + data.email + '</a>');
                    $('#fmiacli_span_telefone').html(data.telefone);
                    $('#fmiacli_is_ativo').prop('checked') ? $('#div-txt-cliente').html('Atualmente o cliente est&aacute; <kbd>ativo</kbd>') : $('#div-txt-cliente').html('Atualmente o cliente est&aacute; <kbd>inativo</kbd>');
                }
            }
            $('#fmiacli-i-captcha').removeClass('fa-check-circle').addClass('fa-dot-circle-o');
            $('#fmiacli-txt-captcha').val('');
            $('#fmiacli-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
        }, 'json');
    }
    return false;
});

//clique no botao para fechar a janela do cliente
$('#fechar_cliente').on('click', function () {
    limpaCamposCliente();
    return true;
});

//clique no botao para inserir um novo cliente
$('#fmiacli_btn_novo').on('click', function () {
    limpaCamposCliente();
    return true;
});

//combo dos clientes para alteracao
$('#combo_alterar_id_cliente').on('change', function () {
    if ($('#combo_alterar_id_cliente').val() > 0) {
        $.post('/pf/DIM.Gateway.php', {'i': $(this).val(), 'arq': 59, 'tch': 1, 'sub': 0, 'dlg': 1}, function (data) {
            $('#fmiacli_info').css({visibility: 'visible'});
            if (data.logomarca !== null)
                $('#fmiacli_span_logomarca').html('<img src="/pf/vendor/cropper/producao/crop/img/img-cli/' + data.logomarca + '.png?' + new Date().getTime() + '" class="img-thumbnail" width="150" height="150">');
            else
                $('#fmiacli_span_logomarca').html('<img src="/pf/img/blank_logo.pt_BR.jpg" class="img-thumbnail img-responsive" width="150" height="150">');
            $('#fmiacli_span_descricao').html(data.descricao);
            $('#fmiacli_span_nome').html(data.nome);
            $('#fmiacli_span_email').html('<a href="mailto:' + data.email + '">' + data.email + '</a>');
            $('#fmiacli_span_telefone').html(data.telefone);
            data.is_ativo == 1 ? $('#div-txt-cliente').html('Atualmente o cliente est&aacute; <kbd>ativo</kbd>') : $('#div-txt-cliente').html('Atualmente o cliente est&aacute; <kbd>inativo</kbd>');
        }, 'json');
        $('#fmiacli_btn_alterar').prop('disabled', empresaConfigPlano['id'] == 3 ? false : true);
    }
    else {
        $('#fmiacli_info').css({visibility: 'hidden'});
        $('#fmiacli_span_logomarca').html('<img src="/pf/img/blank_logo.pt_BR.jpg" class="img-thumbnail img-responsive" width="150" height="150">');
        $('#fmiacli_span_nome').html('--');
        $('#fmiacli_span_email').html('--');
        $('#fmiacli_span_telefone').html('--');
        $('#fmiacli_btn_alterar').prop('disabled', true);
        $('#div-txt-cliente').html('');
    }
});

/*
 * clique no botao btn_alterar_cliente
 */
$('#fmiacli_btn_alterar').on('click', function () {
    var i = $('#combo_alterar_id_cliente').val();
    if (i > 0) {
        $('#fmiacli_acao').val('alterar');
        $.post('/pf/DIM.Gateway.php', {'i': i, 'arq': 59, 'tch': 1, 'sub': 0, 'dlg': 1}, function (data) {
            $('#fmiacli_id').val(data.id);
            $('#fmiacli_descricao').val(data.descricao);
            $('#fmiacli_is_ativo').bootstrapToggle(data.is_ativo == 1 ? 'on' : 'off');
            $('#fmiacli_sigla').val(data.sigla);
            $('#fmiacli_nome').val(data.nome);
            $('#fmiacli_email').val(data.email);
            $('#fmiacli_nome2').val(data.nome2);
            $('#fmiacli_email2').val(data.email2);
            $('#fmiacli_telefone').val(data.telefone);
            $('#fmiacli_telefone2').val(data.telefone2);
            $('#fmiacli_ramal').val(data.ramal == 0 ? '' : data.ramal);
            $('#fmiacli_ramal2').val(data.ramal2 == 0 ? '' : data.ramal2);
            $('#fmiacli_uf').val(data.uf);
            $('#fmiacli_btn_novo').prop('disabled', true);
            $('#fmiacli_btn_inserir').prop('disabled', true);
            $('#fmiacli_btn_atualizar').prop('disabled', false);//este botao fica habilitado logo apos o cadastro
            $('#avatar-frame-cli').contents().find('#avatar_id').val(data.id);
            if (data.logomarca !== null)
                $('#avatar-frame-cli').contents().find('#avatar_img').attr('src', '/pf/vendor/cropper/producao/crop/img/img-cli/' + data.logomarca + '.png?' + new Date().getTime());
            else
                $('#avatar-frame-cli').contents().find('#avatar_img').attr('src', '/pf/img/blank_logo.pt_BR.jpg');
        }, 'json');
    }
});

/*
 * limpa os campos do formulario
 */
function limpaCamposCliente() {
    $('#fmiacli_id').val('');
    $('#fmiacli_acao').val('inserir');
    $('#fmiacli_descricao').val('');
    $('#fmiacli_is_ativo').bootstrapToggle('on');
    $('#fmiacli_sigla').val('');
    $('#fmiacli_nome').val('');
    $('#fmiacli_email').val('');
    $('#fmiacli_nome2').val('');
    $('#fmiacli_email2').val('');
    $('#fmiacli_telefone').val('');
    $('#fmiacli_telefone2').val('');
    $('#fmiacli_ramal').val('');
    $('#fmiacli_ramal2').val('');
    $('#fmiacli_uf').val(0);
    $('#fmiacli_btn_novo').prop('disabled', true);
    $('#fmiacli_btn_inserir').prop('disabled', false);
    $('#fmiacli_btn_atualizar').prop('disabled', true);//este botao fica habilitado logo apos o cadastro
    $('#avatar-frame-cli').attr('src', '/pf/vendor/cropper/producao/crop/index.php?t=cli');
    $('#fmiacli-i-captcha').removeClass('fa-check-circle').addClass('fa-dot-circle-o');
    $('#fmiacli-txt-captcha').val('');
    dataFormCliente = {};
}

/*
 * desabilita a insercao de clientes quando for um fornecedor
 */
$('#fmiacli-link').on('click', function () {
    if (isFornecedor) {
        return false;
    }
    else {
        $(this).attr({'data-toggle': 'modal', 'data-target': '#form_modal_inserir_cliente'});
    }
});

/*
 * cria o objeto dataFormCliente com as informacoes preenchidas no formulario
 */
function variaveisFormCliente(acao) {
    dataFormCliente = {
        'acao': acao,
        'id': $('#fmiacli_id').val(),
        'id_empresa': idEmpresa,
        'is_ativo': $('#fmiacli_is_ativo').prop('checked') ? 1 : 0,
        'descricao': $('#fmiacli_descricao').val(),
        'sigla': $('#fmiacli_sigla').val(),
        'nome': $('#fmiacli_nome').val(),
        'email': $('#fmiacli_email').val(),
        'nome2': $('#fmiacli_nome2').val(),
        'email2': $('#fmiacli_email2').val(),
        'telefone': $('#fmiacli_telefone').val(),
        'telefone2': $('#fmiacli_telefone2').val(),
        'ramal': $('#fmiacli_ramal').val(),
        'ramal2': $('#fmiacli_ramal2').val(),
        'uf': $('#fmiacli_uf').val(),
        'captcha': $('#fmiacli_captcha').val(),
        'arq': 44, 'tch': 0, 'sub': 0, 'dlg': 1};
    return dataFormCliente;
}