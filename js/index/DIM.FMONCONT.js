$('#cep').on('keyup', function () {
    if ($(this).attr('maxlength') == $(this).val().length) {
        iWait('wait-cep', true);
        $.get('http://api.postmon.com.br/v1/cep/' + $('#cep').val(), function (data) {
            $('#bairro').val(data.bairro);
            $('#cidade').val(data.cidade);
            $('#txt-estado').val(data.estado);
            $('#logradouro').val(data.logradouro);
            $('#complemento').get(0).focus();
            iWait('wait-cep', false);
        }, 'json')
                .error(function (jqXHR, textStatus, errorThrown) {
                    swal({
                        title: "Alerta",
                        text: "Este CEP n&atilde;o foi encontrado.",
                        type: "error",
                        html: true,
                        confirmButtonText: "Obrigado, vou verificar!"});
                    $('#cep').val('');
                    $('#bairro').val('');
                    $('#cidade').val('');
                    $('#txt-estado').val('');
                    $('#logradouro').val('');
                    $('#complemento').val('');
                    $('#numero').val('');
                    iWait('wait-cep', false);
                    $('#cep').get(0).focus();
                    return false;
                });
    }
    else if ($(this).val() === '') {
        $('#bairro').val('');
        $('#cidade').val('');
        $('#txt-estado').val('');
        $('#logradouro').val('');
        $('#complemento').val('');
        $('#numero').val('');
    }
});

$('#pesquisa-cep').on('click', function () {
    if ($('#cep').val() !== '') {
        iWait('wait-cep', true);
        $.get('http://api.postmon.com.br/v1/cep/' + $('#cep').val(), function (data) {
            $('#bairro').val(data.bairro);
            $('#cidade').val(data.cidade);
            $('#txt-estado').val(data.estado);
            $('#logradouro').val(data.logradouro);
            iWait('wait-cep', false);
        }, 'json')
                .error(function (jqXHR, textStatus, errorThrown) {
                    swal({
                        title: "Alerta",
                        text: "Este CEP n&atilde;o foi encontrado.",
                        type: "error",
                        html: true,
                        confirmButtonText: "Obrigado, vou verificar!"});
                    $('#cep').val('');
                    $('#bairro').val('');
                    $('#cidade').val('');
                    $('#txt-estado').val('');
                    $('#logradouro').val('');
                    iWait('wait-cep', false);
                });
    }
    else {
        swal({
            title: "Alerta",
            text: "Por favor, preencha o CEP (apenas n&uacute;meros).",
            type: "error",
            html: true,
            confirmButtonText: "Obrigado, vou verificar!"},
        function () {
            $('#cep').get(0).focus();
        });
    }
});

/*
 * arrays com os tipos de pessoas / planos
 */
var tp = ['#pf', '#pj', '#es'];
var pl = ['#de', '#co', '#em'];

$('#pf').on('click', function () {
    $('#tipo').val('pf');
    $(pl[0]).prop('disabled', false);
    //$(pl[1]).prop('disabled', false);
    $(pl[2]).prop('disabled', false);
    $('#div-estudante').collapse('hide');
    $('#cnpj-cpf').mask('000.000.000-00').attr('maxlength', '14').prop('disabled', false).get(0).focus();
    setClassSelected(tp, $(this));
});

$('#pj').on('click', function () {
    $('#tipo').val('pj');
    $(pl[0]).prop('disabled', false);
    //$(pl[1]).prop('disabled', false);
    $(pl[2]).prop('disabled', false);
    $('#div-estudante').collapse('hide');
    $('#cnpj-cpf').mask('00.000.000/0000-00').attr('maxlength', '19').prop('disabled', false).get(0).focus();
    setClassSelected(tp, $(this));
});

$('#es').on('click', function () {
    $('#tipo').val('es');
    $('#plano').val('es');
    $(pl[0]).prop('disabled', true);
    //$(pl[1]).prop('disabled', true);
    $(pl[2]).prop('disabled', true);
    $('#cnpj-cpf').mask('000.000.000-00').attr('maxlength', '14').prop('disabled', false).get(0).focus();
    setClassSelected(tp, $(this));
    setClassSelected(pl, null);
});

$('#de').on('click', function () {
    if ($('#tipo').val() == '') {
        swal({
            title: "Alerta",
            text: "Selecione um tipo Pessoa F&iacute;sica, Jur&iacute;dica ou Estudante.",
            type: "error",
            html: true,
            confirmButtonText: "Obrigado, vou verificar!"});
        return false;
    }
    $('#plano').val('de');
    $('#cnpj-cpf').get(0).focus();
    setClassSelected(pl, $(this));

});

$('#co').on('click', function () {
    if ($('#tipo').val() == '') {
        swal({
            title: "Alerta",
            text: "Selecione um tipo Pessoa F&iacute;sica, Jur&iacute;dica ou Estudante.",
            type: "error",
            html: true,
            confirmButtonText: "Obrigado, vou verificar!"});
        return false;
    }
    $('#plano').val('co');
    $('#cnpj-cpf').get(0).focus();
    setClassSelected(pl, $(this));

});

$('#em').on('click', function () {
    if ($('#tipo').val() == '') {
        swal({
            title: "Alerta",
            text: "Selecione um tipo Pessoa F&iacute;sica, Jur&iacute;dica ou Estudante.",
            type: "error",
            html: true,
            confirmButtonText: "Obrigado, vou verificar!"});
        return false;
    }
    $('#plano').val('em');
    $('#cnpj-cpf').get(0).focus();
    setClassSelected(pl, $(this));

});

function setClassSelected(i, d) {
    for (x = 0; x < i.length; x++) {
        $(i[x]).removeClass('btn-info');
    }
    d !== null ? $(d).addClass('btn-info') : null;
}

$('#form-nova-conta').on('submit', function () {
    var arrPost = {
        tipo: $('#tipo').val(),
        plano: $('#plano').val(),
        ufEstudante: $('#uf-estudante').val(),
        instituicaoEnsino: $('#instituicao-ensino').val(),
        cnpjCpf: $('#cnpj-cpf').val(),
        nomeEmpresa: $('#nome-empresa').val(),
        sigla: $('#sigla').val(),
        cep: $('#cep').val(),
        bairro: $('#bairro').val(),
        cidade: $('#cidade').val(),
        txtEstado: $('#txt-estado').val(),
        logradouro: $('#logradouro').val(),
        complemento: $('#complemento').val(),
        numero: $('#numero').val(),
        contatoNome: $('#contato-nome').val(),
        contatoEmail: $('#contato-email').val(),
        contatoTelefoneFixo: $('#contato-telefone-fixo').val(),
        contatoRamal: $('#contato-ramal').val(),
        contatoTelefoneCelular: $('#contato-telefone-celular').val(),
        observacoes: $('#observacoes').val(),
        'arq': 51,
        'tch': 0,
        'sub': 2,
        'dlg': 1
    };
    //nao havera mais contato financeiro
    //contatoNome1: $('#contato-nome-1').val(),
    //contatoEmail1: $('#contato-email-1').val(),
    //contatoTelefoneFixo1: $('#contato-telefone-fixo-1').val(),
    //contatoRamal1: $('#contato-ramal-1').val(),
    //contatoTelefoneCelular1: $('#contato-telefone-celular-1').val(),
    //evita duplo post
    $('#btn-criar-conta').prop('disabled', true);
    $('#i-btn-criar-conta').removeClass('fa-user-plus').addClass('fa-refresh').addClass('fa-spin');
    //envia as informacoes apenas por email
    $.post('/pf/DIM.Gateway.php', arrPost, function (data) {
        if (data) {
            //TODO: limpar os campos
            $('#btn-criar-conta').prop('disabled', false);
            $('#i-btn-criar-conta').removeClass('fa-refresh').removeClass('fa-spin').addClass('fa-user-plus');
            swal({
                title: "Informa&ccedil;&atilde;o",
                text: "Sua solicita&ccedil;&atilde;o foi enviada com sucesso (uma c&oacute;pia desta mensagem foi enviada para o seu email).<br /><br />Em at&eacute; 24 horas entraremos em contato e sua conta ser&aacute; criada.",
                type: "success",
                html: true,
                confirmButtonText: "Obrigado, vou aguardar!"}, function () {
                //limpa os campos
                $('#tipo').val('');
                $('#plano').val('');
                $('#uf-estudante').val('');
                $('#instituicao-ensino').val('');
                $('#cnpj-cpf').val('');
                $('#nome-empresa').val('');
                $('#sigla').val('');
                $('#cep').val('');
                $('#bairro').val('');
                $('#cidade').val('');
                $('#txt-estado').val('');
                $('#logradouro').val('');
                $('#complemento').val('');
                $('#numero').val('');
                $('#contato-nome').val('');
                $('#contato-email').val('');
                $('#contato-telefone-fixo').val('');
                $('#contato-ramal').val('');
                $('#contato-telefone-celular').val('');
                //nao havera mais contato financeiro
                //$('#contato-nome-1').val('');
                //$('#contato-email-1').val('');
                //$('#contato-telefone-fixo-1').val('');
                //$('#contato-ramal-1').val('');
                //$('#contato-telefone-celular-1').val('');
                setClassSelected(pl, null);
                setClassSelected(tp, null);
                //habilita todos os botoes
                $(pl[0]).prop('disabled', false);
                //$(pl[1]).prop('disabled', false);
                $(pl[2]).prop('disabled', false);
                $(tp[0]).prop('disabled', false);
                $(tp[1]).prop('disabled', false);
                $(tp[2]).prop('disabled', false);
                $('#div-estudante').collapse('hide');
            });
        }
    }, 'json');
    //retorna
    return false;
});
/*
 * formatacao dos telefones para um digito a mais
 */
var SPMaskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
}, spOptions = {onKeyPress: function (val, e, field, options) {
        field.mask(SPMaskBehavior.apply({}, arguments), options);
    }};

$('.sp_celphones').mask(SPMaskBehavior, spOptions);