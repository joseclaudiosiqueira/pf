$('#fmccon-txt-captcha').on('keyup', function () {
    verificaCaptcha($(this), $('#fmccon-i-captcha'), false);
});
/*
 * para todos dos forms a leitura da imagem do captcha eh feita no click para evitar desatualizacoes
 */
$('#fmccon-link').on('click', function () {
    if (Number($('#config_id_cliente option:selected').val()) === 0) {
        swal({
            title: "Alerta",
            text: "Por favor selecione um Cliente",
            type: "warning",
            html: true,
            confirmButtonText: "Vou verificar, obrigado!"});
    }
    else {
        $.post('DIM.Gateway.php', {
            'arq': 99,
            'tch': 1,
            'sub': -1,
            'dlg': 0,
            'icl': $('#config_id_cliente option:selected').val()
        }, function (data) {
            $('#quantidade_maxima_entregas').val(data.quantidade_maxima_entregas);
            $('#is_processo_validacao').bootstrapToggle(Number(data.is_processo_validacao) === 1 ? 'on' : 'off');
            $('#is_visualizar_roteiros_publicos').bootstrapToggle(Number(data.is_visualizar_roteiros_publicos) === 1 ? 'on' : 'off');
            $('#is_validar_adm_gestor').bootstrapToggle(Number(data.is_validar_adm_gestor) === 1 ? 'on' : 'off');
            $('#is_produtividade_global').bootstrapToggle(Number(data.is_produtividade_global) === 1 ? 'on' : 'off');
            $('#produtividade_global').val(Number(data.produtividade_global).toFixed(2)).prop('disabled', Number(data.is_produtividade_global) === 1 ? true : false);
            $('#is_visualizar_contagem_turma').bootstrapToggle(Number(data.is_visualizar_contagem_turma) === 1 ? 'on' : 'off');
            $('#prod-f-eng').val(Number(data.prod_f_eng).toFixed(2)).prop(Number(data.is_produtividade_global) === 1 ? 'disabled' : 'enabled');
            $('#prod-f-des').val(Number(data.prod_f_des).toFixed(2)).prop(Number(data.is_produtividade_global) === 1 ? 'disabled' : 'enabled');
            $('#prod-f-imp').val(Number(data.prod_f_imp).toFixed(2)).prop(Number(data.is_produtividade_global) === 1 ? 'disabled' : 'enabled');
            $('#prod-f-tes').val(Number(data.prod_f_tes).toFixed(2)).prop(Number(data.is_produtividade_global) === 1 ? 'disabled' : 'enabled');
            $('#prod-f-hom').val(Number(data.prod_f_hom).toFixed(2)).prop(Number(data.is_produtividade_global) === 1 ? 'disabled' : 'enabled');
            $('#prod-f-impl').val(Number(data.prod_f_impl).toFixed(2)).prop(Number(data.is_produtividade_global) === 1 ? 'disabled' : 'enabled');
            $('#pct-f-eng').val(data.pct_f_eng);
            $('#pct-f-des').val(data.pct_f_des);
            $('#pct-f-imp').val(data.pct_f_imp);
            $('#pct-f-tes').val(data.pct_f_tes);
            $('#pct-f-hom').val(data.pct_f_hom);
            $('#pct-f-impl').val(data.pct_f_impl);
            $('#is-f-eng').prop('checked', Number(data.is_f_eng) === 1 ? true : false);
            $('#is-f-des').prop('checked', Number(data.is_f_des) === 1 ? true : false);
            $('#is-f-imp').prop('checked', Number(data.is_f_imp) === 1 ? true : false);
            $('#is-f-tes').prop('checked', Number(data.is_f_tes) === 1 ? true : false);
            $('#is-f-hom').prop('checked', Number(data.is_f_hom) === 1 ? true : false);
            $('#is-f-impl').prop('checked', Number(data.is_f_impl) === 1 ? true : false);
            //div que oculta a fase
            $('#div-eng').css({'visibility': Number(data.is_f_eng) === 1 ? 'hidden' : 'visible'});
            $('#div-des').css({'visibility': Number(data.is_f_des) === 1 ? 'hidden' : 'visible'});
            $('#div-imp').css({'visibility': Number(data.is_f_imp) === 1 ? 'hidden' : 'visible'});
            $('#div-tes').css({'visibility': Number(data.is_f_tes) === 1 ? 'hidden' : 'visible'});
            $('#div-hom').css({'visibility': Number(data.is_f_hom) === 1 ? 'hidden' : 'visible'});
            $('#div-impl').css({'visibility': Number(data.is_f_impl) === 1 ? 'hidden' : 'visible'});
            $('#desc-f-eng').val(data.desc_f_eng);
            $('#desc-f-des').val(data.desc_f_des);
            $('#desc-f-imp').val(data.desc_f_imp);
            $('#desc-f-tes').val(data.desc_f_tes);
            $('#desc-f-hom').val(data.desc_f_hom);
            $('#desc-f-impl').val(data.desc_f_impl);
            $('#horas_liquidas_trabalhadas').val(Number(data.horas_liquidas_trabalhadas).toFixed(2));
            $('#is-visualizar-todas-fiscal-contrato').bootstrapToggle(Number(data.is_visualizar_todas_fiscal_contrato) === 1 ? 'on' : 'off');
            $('#is_gestao_projetos').bootstrapToggle('off');
            $('#is_visualizar_contagem_fornecedor').bootstrapToggle(Number(data.is_visualizar_contagem_fornecedor) === 1 ? 'on' : 'off');
            $('#is_alterar_produtividade_global').bootstrapToggle(Number(data.is_alterar_produtividade_global) === 1 ? 'on' : 'off');
            $('#custo-cocomo').val(0);
            $('#is_excluir_crud_independente').bootstrapToggle(Number(data.is_excluir_crud_dependente) === 1 ? 'on' : 'off');
            $('#id_fator_tecnologia_padrao').val(data.id_fator_tecnologia_padrao !== '0' ? data.id_fator_tecnologia_padrao : $("#id_fator_tecnologia_padrao option:first").attr('selected', 'selected'));
            $('#is_ft_padrao').bootstrapToggle(Number(data.is_ft_padrao) === 1 ? 'on' : 'off');
            $('#etapa-atualizar-baseline').val(data.etapa_atualizar_baseline);
            /*
             * atualiza o captcha
             */
            $('#fmccon-img-captcha').attr('src', '/pf/vendor/huge/tools/showCaptcha.php');
            /*
             * exibe o formulario com os valores atualizados
             */
            $('#form_modal_configuracoes_contagem').modal('show');
            /*
             * atualiza a variavel contagemConfig baseada no idCliente atual
             */
            contagemConfig = data;
            /*
             * soma logo no inicio para verificar
             */
            somaFasesRUP();
            /*
             * preenche a combo fator tecnologia
             */
            comboFatorTecnologia(data.id_fator_tecnologia_padrao, $('#id_fator_tecnologia_padrao'), $('#config_id_cliente option:selected').val());
        }, 'json');
    }
});

$('#custo-cocomo').mask('000000', {reverse: true}).TouchSpin({
    min: 1,
    max: 100000,
    step: 100,
    boostat: 500,
    maxboostedstep: 10,
    prefix: 'R$'
}).prop('readonly', true);

$('#quantidade_maxima_entregas').on('change', function () {
    if (Number($(this).val().length) === 1) {
        if ($(this).val() < 1 || $(this).val() > 5) {
            $(this).val('').get(0).focus();
            $('#alerta_entregas').css({visibility: 'visible'});
        }
    } else {
        if ($(this).val() > 99) {
            $(this).val('').get(0).focus();
            $('#alerta_entregas').css({visibility: 'visible'});
        } else {
            $('#alerta_entregas').css({visibility: 'hidden'});
        }

    }
}).on('blur', function () {
    if ($(this).val() === '') {
        $('#alerta_entregas').css({visibility: 'visible'});
        $(this).val(1);
    } else {
        $('#alerta_entregas').css({visibility: 'hidden'});
    }
}).mask('00').TouchSpin({
    min: 1,
    max: 99,
    step: 1,
    boostat: 5,
    maxboostedstep: 10,
    postfix: ''
}).prop('readonly', true);
/*
 * produtividades
 */
$('.spinhpf').on('change', function () {
    if ($(this).val() > 18.5) {
        $('#msg_produtividade').html('BAIXA');
        $('#alerta_produtividade').css({visibility: 'visible'});
    } else if ($(this).val() < 6 && $(this).val() > 0) {
        $('#msg_produtividade').html('ALTA');
        $('#alerta_produtividade').css({visibility: 'visible'});
    } else {
        if (Number($(this).val()) === 0) {
            $('#msg_produtividade').html('ZERADA/EM BRANCO');
            $('#alerta_produtividade').css({visibility: 'visible'});
            $(this).val('').get(0).focus();
        } else {
            $('#alerta_produtividade').css({visibility: 'hidden'});
        }
    }
}).on('blur', function () {
    if ($(this).val() === '') {
        $('#msg_produtividade').html('ZERADA/EM BRANCO');
        $('#alerta_produtividade').css({visibility: 'visible'});
        $(this).val('').get(0).focus();
    } else {
        $('#alerta_produtividade').css({visibility: 'hidden'});
    }
}).mask('##.##00.00').prop('readonly', true).TouchSpin({
    min: 1,
    max: 100,
    step: 0.25,
    decimals: 2,
    boostat: 5,
    maxboostedstep: 10,
    postfix: 'h/PF'
}).prop('readonly', true);
/*
 * change para a produtividade global
 */
$('#produtividade_global').on('change', function () {
    if ($('#is_produtividade_global').prop('checked')) {
        $('#prod-f-eng').val($(this).val());
        $('#prod-f-des').val($(this).val());
        $('#prod-f-imp').val($(this).val());
        $('#prod-f-tes').val($(this).val());
        $('#prod-f-hom').val($(this).val());
        $('#prod-f-impl').val($(this).val());
    }
});

$('#is_produtividade_global').on('change', function () {
    if ($(this).prop('checked')) {
        $('#produtividade_global').prop('disabled', false);
        $('#prod-f-eng').prop('disabled', true).val(parseFloat($('#produtividade_global').val()).toFixed(2));
        $('#prod-f-des').prop('disabled', true).val(parseFloat($('#produtividade_global').val()).toFixed(2));
        $('#prod-f-imp').prop('disabled', true).val(parseFloat($('#produtividade_global').val()).toFixed(2));
        $('#prod-f-tes').prop('disabled', true).val(parseFloat($('#produtividade_global').val()).toFixed(2));
        $('#prod-f-hom').prop('disabled', true).val(parseFloat($('#produtividade_global').val()).toFixed(2));
        $('#prod-f-impl').prop('disabled', true).val(parseFloat($('#produtividade_global').val()).toFixed(2));
    } else {
        $('#produtividade_global').val(parseFloat(contagemConfig['produtividade_global']).toFixed(2)).prop('disabled', true);
        $('#prod-f-eng').val(parseFloat(contagemConfig['prod_f_eng']).toFixed(2)).prop('disabled', false);
        $('#is-f-des').prop('checked') ? $('#prod-f-des').val(parseFloat(contagemConfig['prod_f_des']).toFixed(2)).prop('disabled', false) : null;
        $('#is-f-imp').prop('checked') ? $('#prod-f-imp').val(parseFloat(contagemConfig['prod_f_imp']).toFixed(2)).prop('disabled', false) : null;
        $('#is-f-tes').prop('checked') ? $('#prod-f-tes').val(parseFloat(contagemConfig['prod_f_tes']).toFixed(2)).prop('disabled', false) : null;
        $('#is-f-hom').prop('checked') ? $('#prod-f-hom').val(parseFloat(contagemConfig['prod_f_hom']).toFixed(2)).prop('disabled', false) : null;
        $('#is-f-impl').prop('checked') ? $('#prod-f-impl').val(parseFloat(contagemConfig['prod_f_impl']).toFixed(2)).prop('disabled', false) : null;
    }
});

$('#horas_liquidas_trabalhadas').on('change', function () {
    if (Number($(this).val()) === 0) {
        $('#alerta_hlt').html('As Horas L&iacute;quidas de Trabalho - HLT n&atilde;o podem ser 0 (zero).');
        $(this).val('').get(0).focus();
        $('#alerta_hlt').css({visibility: 'visible'});
    } else if ($(this).val() > 8) {
        $('#alerta_hlt').html('&Eacute; recomend&aacute;vel que voc&ecirc; limite sua jornada de trabalho a 8 (oito) horas di&aacute;rias.');
        $('#alerta_hlt').css({visibility: 'visible'});
    } else if ($(this).val() < 6) {
        $('#alerta_hlt').html('As Horas L&iacute;quidas de Trabalho - HLT est&atilde;o muito baixas, geralmente ficam entre 7.25h/dia e 8h/dia.');
        $('#alerta_hlt').css({visibility: 'visible'});
    } else {
        $('#alerta_hlt').css({visibility: 'hidden'});
    }
}).mask('#.##0.00').TouchSpin({
    min: 1,
    max: 12,
    step: .25,
    decimals: 2,
    boostat: 5,
    maxboostedstep: 10,
    postfix: 'HLT'
}).prop('readonly', true);
;

$('.spinpct').on('change', function () {
    if (Number($(this).val()) === 0) {
        $('#alerta_distribuicao').css({visibility: 'visible'});
        $(this).val('').get(0).focus();
    } else if ($(this).val() > 97) {
        $('#alerta_distribuicao').css({visibility: 'visible'});
        $(this).val('').get(0).focus();
    }
    somaFasesRUP();
}).mask('00').prop('readonly', true).TouchSpin({
    min: 1,
    max: 97,
    step: 1,
    boostat: 5,
    maxboostedstep: 10,
    postfix: '%'
});
/*
 * checks das fases
 */
$('#is-f-des').on('change', function () {
    if ($(this).prop('checked')) {
        $('#div-des').css('visibility', 'hidden');
        $('#pct-f-des').prop('disabled', false);
    } else {
        $('#div-des').css('visibility', 'visible');
        $('#pct-f-des').prop('disabled', true).val(contagemConfig['pct_f_des']);
    }
    somaFasesRUP();
});

$('#is-f-imp').on('change', function () {
    if ($(this).prop('checked')) {
        $('#div-imp').css('visibility', 'hidden');
        $('#pct-f-imp').prop('disabled', false);
    } else {
        $('#div-imp').css('visibility', 'visible');
        $('#pct-f-imp').prop('disabled', true).val(contagemConfig['pct_f_imp']);
    }

    somaFasesRUP();
});

$('#is-f-tes').on('change', function () {
    if ($(this).prop('checked')) {
        $('#div-tes').css('visibility', 'hidden');
        $('#pct-f-tes').prop('disabled', false);
    } else {
        $('#div-tes').css('visibility', 'visible');
        $('#pct-f-tes').prop('disabled', true).val(contagemConfig['pct_f_tes']);
    }
    somaFasesRUP();
});

$('#is-f-hom').on('change', function () {
    if ($(this).prop('checked')) {
        $('#div-hom').css('visibility', 'hidden');
        $('#pct-f-hom').prop('disabled', false);
    } else {
        $('#div-hom').css('visibility', 'visible');
        $('#pct-f-hom').prop('disabled', true).val(contagemConfig['pct_f_hom']);
    }
    somaFasesRUP();
});

$('#is-f-impl').on('change', function () {
    if ($(this).prop('checked')) {
        $('#div-impl').css('visibility', 'hidden');
        $('#pct-f-impl').prop('disabled', false);
    } else {
        $('#div-impl').css('visibility', 'visible');
        $('#pct-f-impl').prop('disabled', true).val(contagemConfig['pct_f_impl']);
    }
    somaFasesRUP();
});

function somaFasesRUP() {
    var fEng = Number($('#pct-f-eng').val());
    var fDes = Number($('#pct-f-des').val());
    var fImp = $('#is-f-imp').prop('checked') ? Number($('#pct-f-imp').val()) : 0;
    var fTes = $('#is-f-tes').prop('checked') ? Number($('#pct-f-tes').val()) : 0;
    var fHom = $('#is-f-hom').prop('checked') ? Number($('#pct-f-hom').val()) : 0;
    var fImpl = $('#is-f-impl').prop('checked') ? Number($('#pct-f-impl').val()) : 0;
    var total = Number(fEng + fDes + fImp + fTes + fHom + fImpl);
    if (Number(total) !== 100) {
        $('#alerta_distribuicao').css({visibility: 'visible'});
        $('#sistema_total_fases').css({backgroundColor: '#ffffcc'});
        $('#sistema_total_fases').val(total);
        return false;
    } else {
        $('#alerta_distribuicao').css({visibility: 'hidden'});
        $('#sistema_total_fases').css({backgroundColor: '#f0f0f0'});
        $('#sistema_total_fases').val(total);
        return true;
    }
}

$('#form_configuracoes_contagem').on('submit', function () {
    /*
     * confere o captcha
     */
    if ($('#fmccon-txt-captcha').val().length < 4) {
        swal({
            title: "Alerta",
            text: "As letras da imagem est&atilde;o diferentes do que foi digitado.",
            type: "error",
            html: true,
            confirmButtonText: "Vou corrigir, obrigado!"});
    } else {
        if (somaFasesRUP()) {
            $.post('/pf/DIM.Gateway.php', {
                'quantidade_maxima_entregas': $('#quantidade_maxima_entregas').val(),
                'is_processo_validacao': $('#is_processo_validacao').prop('checked') ? 1 : 0,
                'is_visualizar_roteiros_publicos': $('#is_visualizar_roteiros_publicos').prop('checked') ? 1 : 0,
                'is_validar_adm_gestor': $('#is_validar_adm_gestor').prop('checked') ? 1 : 0,
                'is_visualizar_sugestao_linguagem': 0, //$('#is_visualizar_sugestao_linguagem').prop('checked') ? 1 : 0,
                'is_produtividade_global': $('#is_produtividade_global').prop('checked') ? 1 : 0,
                'produtividade_global': $('#produtividade_global').val(),
                'is_visualizar_contagem_turma': $('#is_visualizar_contagem_turma').prop('checked') ? 1 : 0,
                'prod-f-eng': $('#prod-f-eng').val(),
                'prod-f-des': $('#prod-f-des').val(),
                'prod-f-imp': $('#prod-f-imp').val(),
                'prod-f-tes': $('#prod-f-tes').val(),
                'prod-f-hom': $('#prod-f-hom').val(),
                'prod-f-impl': $('#prod-f-impl').val(),
                'pct-f-eng': $('#pct-f-eng').val(),
                'pct-f-des': $('#pct-f-des').val(),
                'pct-f-imp': $('#pct-f-imp').val(),
                'pct-f-tes': $('#pct-f-tes').val(),
                'pct-f-hom': $('#pct-f-hom').val(),
                'pct-f-impl': $('#pct-f-impl').val(),
                'is-f-eng': $('#is-f-eng').prop('checked') ? 1 : 0,
                'is-f-des': $('#is-f-des').prop('checked') ? 1 : 0,
                'is-f-imp': $('#is-f-imp').prop('checked') ? 1 : 0,
                'is-f-tes': $('#is-f-tes').prop('checked') ? 1 : 0,
                'is-f-hom': $('#is-f-hom').prop('checked') ? 1 : 0,
                'is-f-impl': $('#is-f-impl').prop('checked') ? 1 : 0,
                'desc-f-eng': $('#desc-f-eng').val(),
                'desc-f-des': $('#desc-f-des').val(),
                'desc-f-imp': $('#desc-f-imp').val(),
                'desc-f-tes': $('#desc-f-tes').val(),
                'desc-f-hom': $('#desc-f-hom').val(),
                'desc-f-impl': $('#desc-f-impl').val(),
                'horas_liquidas_trabalhadas': $('#horas_liquidas_trabalhadas').val(),
                'is-visualizar-todas-fiscal-contrato': $('#is-visualizar-todas-fiscal-contrato').prop('checked') ? 1 : 0,
                'is_gestao_projetos': $('#is_gestao_projetos').prop('checked') ? 1 : 0,
                'is_visualizar_contagem_fornecedor': $('#is_visualizar_contagem_fornecedor').prop('checked') ? 1 : 0,
                'is_alterar_produtividade_global': $('#is_alterar_produtividade_global').prop('checked') ? 1 : 0,
                'custo-cocomo': $('#custo-cocomo').val(),
                'is_excluir_crud_independente': $('#is_excluir_crud_independente').prop('checked') ? 1 : 0,
                'id_fator_tecnologia_padrao': $('#id_fator_tecnologia_padrao option:selected').val(),
                'is_ft_padrao': $('#is_ft_padrao').prop('checked') ? 1 : 0,
                'etapa-atualizar-baseline' : $('#etapa-atualizar-baseline option:selected').val(), 
                'arq': 39, 'tch': 0, 'sub': 0, 'dlg': 1,
                'icl': $('#config_id_cliente option:selected').val()
            }, function (data) {
                swal({
                    title: "Informa&ccedil;&atilde;o",
                    text: data.msg,
                    type: "success",
                    html: true,
                    confirmButtonText: "Obrigado!"});
            }, 'json');
            $('#fmccon-i-captcha').removeClass('fa-check-circle').addClass('fa-dot-circle-o');
        } else {
            swal({
                title: "Alerta",
                text: "A distribui&ccedil;&atilde;o percentual nas fases deve somar 100%.",
                type: "error",
                html: true,
                confirmButtonText: "Vou corrigir, obrigado!"});
        }
    }
    return false;
});

