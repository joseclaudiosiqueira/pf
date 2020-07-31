/*
 * variaveis de topo
 */
var dataFormRoteiro;
var fmiar_idCliente = 0;
var fmiar_idFornecedor = 0;
var fmiar_exclusivo_isCliente = false;
var fmiar_exclusivo_isFornecedor = false;

$('#fmiar-txt-captcha').on('keyup', function () {
    verificaCaptcha($(this), $('#fmiar-i-captcha'), false);
});
/*
 * limita os caracteres das observacoes
 */
$("#fmiar_observacoes").charCount({
    allowed: 2000,
    warning: 100
});
/*
 * para todos dos forms a leitura da imagem do captcha eh feita no click para
 * evitar desatualizacoes
 */
$('#href_modal_roteiro').on(
        'click',
        function () {
            atualizaTabelaRoteiro();
            $('#fmiar-img-captcha').attr('src',
                    '/pf/vendor/huge/tools/showCaptcha.php');
        });
/*
 * verifica a transicao de roteiro exclusivo ou nao
 */
$('#fmiar_is_exclusivo').on(
        'change',
        function () {
            if ($(this).prop('checked')) {
                $('#chk_roteiro_exclusivo_1').prop('disabled', false).prop(
                        'checked', false);
                $('#chk_roteiro_exclusivo_2').prop('disabled', false).prop(
                        'checked', false);
                $('#fmiar_is_compartilhado').bootstrapToggle('off')
                        .bootstrapToggle('disable');
            } else {
                $('#chk_roteiro_exclusivo_1').prop('disabled', true).prop(
                        'checked', false);
                $('#chk_roteiro_exclusivo_2').prop('disabled', true).prop(
                        'checked', false);
                $('#fmiar_is_compartilhado').bootstrapToggle('enable');
                $('#generico_id_cliente').empty().prop('disabled', true);
                $('#generico_id_fornecedor').empty().prop('disabled', true);
            }
        });

$('#chk_roteiro_exclusivo_1').on('click', function () {
    $('#generico_id_fornecedor').empty().prop('disabled', true);
    $('#generico_id_cliente').prop('disabled', false);
    comboCliente('generico', 0, 0, 0);
});
$('#chk_roteiro_exclusivo_2').on('click', function () {
    $('#generico_id_cliente').empty().prop('disabled', true);
    $('#generico_id_fornecedor').prop('disabled', false);
    comboFornecedores('generico', 0, 0, 0, true);
});
/*
 * verifica se existe uma sigla e informa ao usuario
 */
$('#fmiar_descricao').on('change',
        function () {
            iWait('w_fmiar_descricao', true);
            $.post('/pf/DIM.Gateway.php',
                    {
                        'd': $(this).val(),
                        'arq': 67,
                        'tch': 1,
                        'sub': 0,
                        'dlg': 1
                    },
            function (data) {
                if (data.length > 0) {
                    swal({
                        title: "Informa&ccedil;&atilde;o",
                        text: "J&aacute; existe(m) algum(s) roteiro(s) com esta sigla.",
                        type: "info",
                        html: true,
                        confirmButtonText: "Obrigado pela dica!"
                    });
                }
                iWait('w_fmiar_descricao', false);
            }, 'json');
        });
/*
 * clique no botao de inserir novo
 */
$('#fmiar_btn_novo').on('click', function () {
    limpaCamposRoteiro();
});
$('#fechar_roteiro').on('click', function () {
    limpaCamposRoteiro();
});
/*
 * para inserir um novo roteiro
 */
$('#form_inserir_alterar_roteiro').on(
        'submit',
        function () {
            /*
             * atribui as variaveis ao post do formulario
             */
            if (variaveisFormRoteiro($('#fmiar_acao').val())) {
                $.post('/pf/DIM.Gateway.php', dataFormRoteiro, function (data) {
                    if (data.id > 0) {
                        swal({
                            title: "Informa&ccedil;&atilde;o",
                            text: data.msg,
                            type: "success",
                            html: true,
                            confirmButtonText: "Obrigado!"
                        });
                        if (dataFormRoteiro.acao === 'inserir') {
                            $('#fmiar_btn_inserir').prop('disabled', true);
                            $('#fmiar_btn_novo').prop('disabled', false);
                            $('#fmiar_btn_atualizar').prop('disabled', false);
                            $('#fmiar_id').val(data.id);
                            $('#fmiar_acao').val('alterar');
                        }
                        fmiar_exclusivo_isCliente = false;
                        fmiar_exclusivo_isFornecedor = false;
                        $('#fmiar-img-captcha').attr('src',
                                '/pf/vendor/huge/tools/showCaptcha.php');
                        $('#fmiar-txt-captcha').val('');
                        atualizaTabelaRoteiro();
                    }
                }, 'json');
            }
            return false;
        });
/*
 * atualiza a tabela com os roteiros associados a empresa
 */
function atualizaTabelaRoteiro() {
    iWait('w_id_roteiro', false);
    $.post('/pf/DIM.Gateway.php', {
        'i': idEmpresa,
        't': 0,
        'arq': 64,
        'tch': 1,
        'sub': 0,
        'dlg': 1
    }, function (data) {
        $('#addRoteiro').empty();
        for (x = 0; x < data.length; x++) {
            addLinhaRoteiro(data[x].id, data[x].descricao, data[x].observacoes,
                    data[x].is_ativo, data[x].tipo,
                    data[x].descricao_roteiro_importado, data[x].id_empresa,
                    data[x].id_fornecedor, data[x].id_cliente);
        }
        iWait('w_id_roteiro', false);
        $('#fmiar_is_ativo').bootstrapToggle('enable');
        $('#fmiar_tipo').bootstrapToggle('enable'); // publico ou privado
    }, 'json');
}
/**
 * 
 * @param {type} i1 - id
 * @param {type} i2 - descricao
 * @param {type} i3 - observacoes
 * @param {type} i4 - is_ativo
 * @param {type} i5 - tipo
 * @param {type} i6 - descricao_roteiro_importado
 * @param {type} i7 - id_empresa
 * @param {type} i8 - id_fornecedor
 * @param {type} i9 - id_cliente
 * @returns {undefined}
 */
function addLinhaRoteiro(i1, i2, i3, i4, i5, i6, i7, i8, i9) {
    var t = $('#addRoteiro').get(0); // tabela
    var r = t.insertRow(-1); // linha
    var c1 = r.insertCell(0); // id + descricao
    var c2 = r.insertCell(1); // observacoes
    var c3 = r.insertCell(2); // is_ativo
    var c4 = r.insertCell(3); // tipo
    // por enquanto sem importacao de roteiros
    // var c5 = r.insertCell(4); //descricao_roteiro_importado
    var vChecked = i4 === 'on' ? 'checked' : '';
    var tChecked = i5 === 'on' ? 'checked' : '';
    var eDisable = (i7 == 0 && idEmpresa != 1) ? 'disabled' : ''; // id_empresa ...se for zero nao pode alterar nada
    // verifica se o id eh #3 - Roteiro Dimension e nao deixa desativar
    var rDisable = (i1 == 3) ? 'disabled' : '';
    var tDisable = ((i8 > 0 || i9 > 0) || (i7 == 0 && idEmpresa != 1)) ? 'disabled' : ''; // verifica se e exclusivo ou nao e desabilita

    c1.setAttribute("nowrap", "nowrap");
    c1.innerHTML = (i7 == 0 && idEmpresa != 1) ? i2 : '<a href="#" onclick="exibeRoteiroAlteracao(' + i1 + ');">' + i2 + '</a>';
    c2.innerHTML = i3;
    c3.innerHTML = '<input onchange="alteraStatusRoteiro($(this).val(), $(this).prop(\'checked\'));" value="'
            + i1
            + '" type="checkbox" data-toggle="toggle" data-width="80" data-height="36" data-onstyle="success" data-style="slow" data-on="Ativo" data-off="Inativo" class="datatoggle" '
            + vChecked + ' ' + eDisable + ' ' + rDisable + '>';
    c4.innerHTML = '<input onchange="alteraTipoRoteiro($(this).val(), $(this).prop(\'checked\'));" value="'
            + i1
            + '" type="checkbox" data-toggle="toggle" data-width="80" data-height="36" data-onstyle="warning" data-style="slow" data-on="P&uacute;blico" data-off="Privado" class="datatoggle" '
            + tChecked + ' ' + tDisable + '>';
    // por enquanto sem essa historia de roteiros importados.
    // c5.innerHTML = '<center>' + i6 + '</center>';
    /*
     * inicializacao manual dos datatoggles
     */
    $('.datatoggle').bootstrapToggle();
}

function alteraStatusRoteiro(id, prop) {
    iWait('w_roteiro_status', true);
    /*
     * sincroniza os datatoggles em caso de clicar para alterar e clicar para
     * inativar/ativar
     */
    if ($('#fmiar_id').val() !== '' && $('#fmiar_id').val() === id) {
        $('#fmiar_is_ativo').bootstrapToggle('enable').bootstrapToggle(
                prop ? 'on' : 'off').bootstrapToggle('disable');
    }
    $.post('/pf/DIM.Gateway.php', {
        'i': id,
        'p': prop ? 1 : 0,
        'arq': 36,
        'tch': 0,
        'sub': 0,
        'dlg': 1
    }, function (data) {
        iWait('w_roteiro_status', false);
    }, 'json');
}

function alteraTipoRoteiro(id, prop) {
    iWait('w_roteiro_tipo', true);
    /*
     * sincroniza os datatoggles em caso de clicar para alterar e clicar para
     * inativar/ativar
     */
    if ($('#fmiar_id').val() !== '' && $('#fmiar_id').val() === id) {
        $('#fmiar_tipo').bootstrapToggle('enable').bootstrapToggle(
                prop ? 'on' : 'off').bootstrapToggle('disable');
    }
    $.post('/pf/DIM.Gateway.php', {
        'i': id,
        't': prop ? 1 : 0,
        'arq': 37,
        'tch': 0,
        'sub': 0,
        'dlg': 1
    }, function (data) {
        iWait('w_roteiro_tipo', false);
    }, 'json');
}

/*
 * cria o objeto dataFormRoteiro com as informacoes preenchidas no formulario
 */
function variaveisFormRoteiro(acao) {
    /*
     * confere o captcha
     */
    if ($('#fmiar-txt-captcha').val().length < 4) {
        swal({
            title: "Alerta",
            text: "As letras da imagem est&atilde;o diferentres do que foi digitado.",
            type: "error",
            html: true,
            confirmButtonText: "Vou corrigir, obrigado!"
        });
        return false;
    }
    if ($('#fmiar_is_exclusivo').prop('checked')) {
        if ($('#chk_roteiro_exclusivo_1').prop('checked')
                && $('#generico_id_cliente').val() == 0) {
            swal({
                title: "Alerta",
                text: "Voc&ecirc; selecionou roteiro exclusivo mas n&atilde;o selecionou um Cliente.",
                type: "error",
                html: true,
                confirmButtonText: "Vou verificar, obrigado!"
            });
            return false;
        } else {
            fmiar_exclusivo_isCliente = true;
            fmiar_idCliente = $('#generico_id_cliente').val();
        }
        /*
         * verifica fornecedor
         */
        if ($('#chk_roteiro_exclusivo_2').prop('checked')
                && $('#generico_id_fornecedor').val() == 0) {
            swal({
                title: "Alerta",
                text: "Voc&ecirc; selecionou roteiro exclusivo mas n&atilde;o selecionou um Fornecedor.",
                type: "error",
                html: true,
                confirmButtonText: "Vou verificar, obrigado!"
            });
            return false;
        } else {
            fmiar_exclusivo_isFornecedor = true;
            fmiar_idFornecedor = $('#generico_id_fornecedor').val();
        }
    }
    /*
     * atribui as variaveis
     */
    dataFormRoteiro = {
        'acao': acao,
        'id': $('#fmiar_id').val(),
        'descricao': $('#fmiar_descricao').val(),
        'observacoes': $('#fmiar_observacoes').val(),
        'is_exclusivo': $('#fmiar_is_exclusivo').prop('checked') ? 1 : 0,
        'id_cliente': fmiar_exclusivo_isCliente ? fmiar_idCliente : 0,
        'id_fornecedor': fmiar_exclusivo_isFornecedor ? fmiar_idFornecedor : 0,
        'is_ativo': $('#fmiar_is_ativo').prop('checked') ? 1 : 0,
        'is_compartilhado': $('#fmiar_is_compartilhado').prop('checked') ? 1
                : 0,
        'id_roteiro_importado': 0,
        'arq': 49,
        'tch': 0,
        'sub': 0,
        'dlg': 1
    };
    return true;
}
/*
 * exibe um roteiro para alteracao
 */
function exibeRoteiroAlteracao(id) {
    /*
     * ver roteiro exclusivo cliente e fornecedor nas combos
     */
    $.post('/pf/DIM.Gateway.php',
            {
                'i': id,
                't': 1,
                'arq': 64,
                'tch': 1,
                'sub': 0,
                'dlg': 1
            },
    function (data) {
        $('#fmiar_acao').val('alterar');
        $('#fmiar_id').val(id);
        /*
         * campos no formulario
         */
        $('#fmiar_descricao').val(data[0].descricao);
        $('#fmiar_observacoes').val(data[0].observacoes);
        $('#fmiar_is_exclusivo').bootstrapToggle(
                data[0].is_exclusivo);
        /*
         * deixa o processo de pesquisa nas combos cliente e
         * fornecedor e depois desabilita tudo se houver algum
         * roteiro sendo utilizado
         */
        if (data[0].roteiros_utilizacao) {
            $('#fmiar_is_exclusivo').bootstrapToggle('disable');
            $('#generico_id_cliente').prop('disabled', true);
            $('#generico_id_fornecedor').prop('disabled', true);
            $('#chk_roteiro_exclusivo_1')
                    .prop('disabled', true);
            $('#chk_roteiro_exclusivo_2')
                    .prop('disabled', true);
        } else {
            if (data[0].is_exclusivo === 'on') {
                /*
                 * habilita o check de exclusivo
                 * cliente/fornecedor
                 */
                $('#fmiar_is_exclusivo').bootstrapToggle(data[0].is_exclusivo);
                if (data[0].id_cliente > 0) {
                    comboCliente('generico', data[0].id_cliente, 0, 0);
                    $('#generico_id_cliente').prop('disabled', false);
                    $('#generico_id_fornecedor').prop('disabled', true).empty();
                    $('#chk_roteiro_exclusivo_1').prop('checked', true);
                } else if (data[0].id_fornecedor > 0) {
                    comboFornecedores('generico', data[0].id_fornecedor, 0, true);
                    $('#generico_id_fornecedor').prop('disabled', false);
                    $('#generico_id_cliente').prop('disabled', true).empty();
                    $('#chk_roteiro_exclusivo_2').prop('checked', true);
                }
            }
        }
        $('#fmiar_is_ativo').bootstrapToggle(data[0].is_ativo);
        //verifica id == 3 e desabilita
        (id == 3) ? $('#fmiar_is_ativo').bootstrapToggle('disable') : $('#fmiar_is_ativo').bootstrapToggle('enable');
        $('#fmiar_is_compartilhado').bootstrapToggle(data[0].tipo);
        /*
         * acao nos botoes
         */
        $('#fmiar_btn_novo').prop('disabled', false);
        $('#fmiar_btn_inserir').prop('disabled', true);
        $('#fmiar_btn_atualizar').prop('disabled', false);
    }, 'json');
}
/*
 * limpa os campos do formulario
 */
function limpaCamposRoteiro() {
    $('#fmiar_descricao').val('').get(0).focus();
    $('#fmiar_observacoes').val('');
    $('#fmiar_is_exclusivo').bootstrapToggle('enable').bootstrapToggle('off');
    $('#fmiar_is_ativo').bootstrapToggle('on').bootstrapToggle('enable');
    $('#fmiar_is_compartilhado').bootstrapToggle('enable').bootstrapToggle(
            'off');
    /*
     * acao nos botoes
     */
    $('#fmiar_btn_novo').prop('disabled', false);
    $('#fmiar_btn_inserir').prop('disabled', false);
    $('#fmiar_btn_atualizar').prop('disabled', true);
    /*
     * variaveis do formulario
     */
    $('#fmiar_id').val(0);
    $('#fmiar_acao').val('inserir');
    /*
     * variaveis de topo
     */
    dataFormRoteiro = [];
    fmiar_idCliente = 0;
    fmiar_idFornecedor = 0;
    fmiar_exclusivo_isCliente = false;
    fmiar_exclusivo_isFornecedor = false;
    /*
     * atualiza captcha
     */
    $('#fmiar-img-captcha')
            .attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
    /*
     * foco
     */
    $('#fmiar-txt-captcha').val('');
}
/*
 * funcao para habilitar ou desabilitar os botoes
 */
function habilitaDesabilitaBotoes() {
    /*
     * acao nos botoes TODO:
     */
    $('#fmiar_btn_novo').prop('disabled', false);
    $('#fmiar_btn_inserir').prop('disabled', true);
    $('#fmiar_btn_atualizar').prop('disabled', false);
}
