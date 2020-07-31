//formata a mascara para os campos money
$('.money').mask("#.##0.00", {reverse: true});
// Fator de Tecnologia
$('#chk-ft').on('change', function () {
    $('#span-is-ft').html($(this).prop('checked') ? '<br /><strong>FT: ' + Number($('#span-ft').html()).toFixed(2) + '</strong>' : '');
    calculaFases(true);
});
// DATA DE INICIO NAS ESTATISTICAS
var clickDate = $("#previsao_inicio").datepicker({
    format: 'dd/mm/yyyy'}).on('changeDate', function (ev) {
    verificaDataInicio(new Date($("#previsao_inicio").val().replace(/(\d{2})[-/](\d{2})[-/](\d+)/, "$2/$1/$3")));
    clickDate.hide();
}).data('datepicker');

// TESTANDO COM O SELECTIZE
var perfEng = config_isEng ? $('#perf-eng').selectize({
    plugins: ['remove_button'],
    delimiter: ',',
    persist: false,
    create: function (input) {
        return {value: input, text: input};
    },
    onItemAdd: function (value, item) {
        isSalvarEstatisticas ? qtdProfFases('eng', this.items.length) : null;
    },
    onItemRemove: function (value) {
        isSalvarEstatisticas ? qtdProfFases('eng', this.items.length) : null;
    }
}) : null;

var perfDes = config_isDes ? $('#perf-des').selectize({
    plugins: ['remove_button'],
    delimiter: ',',
    persist: false,
    create: function (input) {
        return {value: input, text: input};
    },
    onItemAdd: function (value, item) {
        isSalvarEstatisticas ? qtdProfFases('des', this.items.length) : null;
    },
    onItemRemove: function (value) {
        isSalvarEstatisticas ? qtdProfFases('des', this.items.length) : null;
    }
}) : null;

var perfImp = config_isImp ? $('#perf-imp').selectize({
    plugins: ['remove_button'],
    delimiter: ',',
    persist: false,
    create: function (input) {
        return {value: input, text: input};
    },
    onItemAdd: function (value, item) {
        isSalvarEstatisticas ? qtdProfFases('imp', this.items.length) : null;
    },
    onItemRemove: function (value) {
        isSalvarEstatisticas ? qtdProfFases('imp', this.items.length) : null;
    }
}) : null;

var perfTes = config_isTes ? $('#perf-tes').selectize({
    plugins: ['remove_button'],
    delimiter: ',',
    persist: false,
    create: function (input) {
        return {value: input, text: input};
    },
    onItemAdd: function (value, item) {
        isSalvarEstatisticas ? qtdProfFases('tes', this.items.length) : null;
    },
    onItemRemove: function (value) {
        isSalvarEstatisticas ? qtdProfFases('tes', this.items.length) : null;
    }
}) : null;

var perfHom = config_isHom ? $('#perf-hom').selectize({
    plugins: ['remove_button'],
    delimiter: ',',
    persist: false,
    create: function (input) {
        return {value: input, text: input};
    },
    onItemAdd: function (value, item) {
        isSalvarEstatisticas ? qtdProfFases('hom', this.items.length) : null;
    },
    onItemRemove: function (value) {
        isSalvarEstatisticas ? qtdProfFases('hom', this.items.length) : null;
    }
}) : null;

var perfImpl = config_isImpl ? $('#perf-impl').selectize({
    plugins: ['remove_button'],
    delimiter: ',',
    persist: false,
    create: function (input) {
        return {value: input, text: input};
    },
    onItemAdd: function (value, item) {
        isSalvarEstatisticas ? qtdProfFases('impl', this.items.length) : null;
    },
    onItemRemove: function (value) {
        isSalvarEstatisticas ? qtdProfFases('impl', this.items.length) : null;
    }
}) : null;

pEng = config_isEng ? Number($("#prof-des").val()) : 0;
pDes = config_isDes ? Number($("#prof-des").val()) : 0;
pImp = config_isImp ? Number($("#prof-imp").val()) : 0;
pTes = config_isTes ? Number($("#prof-tes").val()) : 0;
pHom = config_isHom ? Number($("#prof-hom").val()) : 0;
pImpl = config_isImpl ? Number($("#prof-impl").val()) : 0;
/*
 * transicoes na tab estatisticas desabilitando a quantidade de profissionais
 * para calculo automatico TODO: ver para equipes grandes
 */
var selectizeEng = config_isEng ? perfEng[0].selectize : false;
var selectizeDes = config_isDes ? perfDes[0].selectize : false;
var selectizeImp = config_isImp ? perfImp[0].selectize : false;
var selectizeTes = config_isTes ? perfTes[0].selectize : false;
var selectizeHom = config_isHom ? perfHom[0].selectize : false;
var selectizeImpl = config_isImpl ? perfImpl[0].selectize : false;

if (isEng) {
    selectizeEng.enable();
} else {
    if (selectizeEng) {
        selectizeEng.clearOptions();
        selectizeEng.disable();
    }
}
if (isDes) {
    selectizeDes.enable();
} else {
    if (selectizeDes) {
        selectizeDes.clearOptions();
        selectizeDes.disable();
    }
}
if (isImp) {
    selectizeImp.enable();
} else {
    if (selectizeImp) {
        selectizeImp.clearOptions();
        selectizeImp.disable();
    }
}
if (isTes) {
    selectizeTes.enable();
} else {
    if (selectizeTes) {
        selectizeTes.clearOptions();
        selectizeTes.disable();
    }
}
if (isHom) {
    selectizeHom.enable();
} else {
    if (selectizeHom) {
        selectizeHom.clearOptions();
        selectizeHom.disable();
    }
}
if (isImpl) {
    selectizeImpl.enable();
} else {
    if (selectizeImpl) {
        selectizeImpl.clearOptions();
        selectizeImpl.disable();
    }
}

$("#chk-eng").on("change", function () {
    isEng = $(this).prop("checked");
    pEng = pEng == 0 ? 1 : isEng ? pEng : 0;
    $("#prod-eng").prop("readonly", isEng ? (!isGlobal && !isLinguagem) ? false : true : true);
    $("#prof-eng").val(pEng).prop("readonly", !isEng);
    isEng ? selectizeEng.enable() : (selectizeEng.clearOptions(), selectizeEng.disable());
    isSalvarEstatisticas ? calculaFases(true) : null;
});

$("#chk-des").on("change", function () {
    isDes = $(this).prop("checked");
    pDes = pDes == 0 ? 1 : isDes ? pDes : 0;
    $("#prod-des").prop("readonly", isDes ? (!isGlobal && !isLinguagem) ? false : true : true);
    $("#prof-des").val(pDes).prop("readonly", !isDes);
    isDes ? selectizeDes.enable() : (selectizeDes.clearOptions(), selectizeDes.disable());
    isSalvarEstatisticas ? calculaFases(true) : null;
});

$("#chk-imp").on("change", function () {
    isImp = $(this).prop("checked");
    pImp = pImp == 0 ? 1 : isImp ? pImp : 0;
    $("#prod-imp").prop("readonly", isImp ? (!isGlobal && !isLinguagem) ? false : true : true);
    $("#prof-imp").val(pImp).prop("readonly", !isImp);
    isImp ? selectizeImp.enable() : (selectizeImp.clearOptions(), selectizeImp.disable());
    isSalvarEstatisticas ? calculaFases(true) : null;
});

$("#chk-tes").on("change", function () {
    isTes = $(this).prop("checked");
    pTes = pTes == 0 ? 1 : isTes ? pTes : 0;
    $("#prod-tes").prop("readonly", isTes ? (!isGlobal && !isLinguagem) ? false : true : true);
    $("#prof-tes").val(pTes).prop("readonly", !isTes);
    isTes ? selectizeTes.enable() : (selectizeTes.clearOptions(), selectizeTes.disable());
    isSalvarEstatisticas ? calculaFases(true) : null;
});
$("#chk-hom").on("change", function () {
    isHom = $(this).prop("checked");
    pHom = pHom == 0 ? 1 : isHom ? pHom : 0;
    $("#prod-hom").prop("readonly", isHom ? (!isGlobal && !isLinguagem) ? false : true : true);
    $("#prof-hom").val(pHom).prop("readonly", !isHom);
    isHom ? selectizeHom.enable() : (selectizeHom.clearOptions(), selectizeHom.disable());
    isSalvarEstatisticas ? calculaFases(true) : null;
});
$("#chk-impl").on("change", function () {
    isImpl = $(this).prop("checked");
    pImpl = pImpl == 0 ? 1 : isImpl ? pImpl : 0;
    $("#prod-impl").prop("readonly", isImpl ? (!isGlobal && !isLinguagem) ? false : true : true);
    $("#prof-impl").val(pImpl).prop("readonly", !isImpl);
    isImpl ? selectizeImpl.enable() : (selectizeImpl.clearOptions(), selectizeImpl.disable());
    isSalvarEstatisticas ? calculaFases(true) : null;
});

$("#chk_produtividade_global").on("change", function () {
    if (isSalvarEstatisticas) {
        if ($(this).prop("checked")) {
            $('#chk-produtividade-linguagem').bootstrapToggle('disable');
            $('.escala').prop('disabled', true);
            isGlobal = true;
            config_isProdutividadeGlobal = true;
            config_isEng ? $("#prod-eng").val(parseFloat(contagemConfig.produtividade_global).toFixed(2)).prop("readonly", true) : null;
            config_isDes ? $("#prod-des").val(parseFloat(contagemConfig.produtividade_global).toFixed(2)).prop("readonly", true) : null;
            config_isImp ? $("#prod-imp").val(parseFloat(contagemConfig.produtividade_global).toFixed(2)).prop("readonly", true) : null;
            config_isTes ? $("#prod-tes").val(parseFloat(contagemConfig.produtividade_global).toFixed(2)).prop("readonly", true) : null;
            config_isHom ? $("#prod-hom").val(parseFloat(contagemConfig.produtividade_global).toFixed(2)).prop("readonly", true) : null;
            config_isImpl ? $("#prod-impl").val(parseFloat(contagemConfig.produtividade_global).toFixed(2)).prop("readonly", true) : null;
        }
        else {
            $('#chk-produtividade-linguagem').bootstrapToggle('enable');
            // onde eh utilizada esta variavel meu filho?
            isGlobal = false;
            config_isProdutividadeGlobal = false;
            if (ac === 'al') {
                config_isEng ? $("#prod-eng").val(parseFloat(contagemEstatisticas['prod_eng']).toFixed(2)).prop("readonly", isEng ? false : true) : null;
                config_isDes ? $("#prod-des").val(parseFloat(contagemEstatisticas['prod_des']).toFixed(2)).prop("readonly", isDes ? false : true) : null;
                config_isImp ? $("#prod-imp").val(parseFloat(contagemEstatisticas['prod_imp']).toFixed(2)).prop("readonly", isImp ? false : true) : null;
                config_isTes ? $("#prod-tes").val(parseFloat(contagemEstatisticas['prod_tes']).toFixed(2)).prop("readonly", isTes ? false : true) : null;
                config_isHom ? $("#prod-hom").val(parseFloat(contagemEstatisticas['prod_hom']).toFixed(2)).prop("readonly", isHom ? false : true) : null;
                config_isImpl ? $("#prod-impl").val(parseFloat(contagemEstatisticas['prod_impl']).toFixed(2)).prop("readonly", isImpl ? false : true) : null;
            }
            else {
                config_isEng ? $("#prod-eng").val(parseFloat(contagemConfig.prod_f_eng).toFixed(2)).prop("readonly", isEng ? false : true) : null;
                config_isDes ? $("#prod-des").val(parseFloat(contagemConfig.prod_f_des).toFixed(2)).prop("readonly", isDes ? false : true) : null;
                config_isImp ? $("#prod-imp").val(parseFloat(contagemConfig.prod_f_imp).toFixed(2)).prop("readonly", isImp ? false : true) : null;
                config_isTes ? $("#prod-tes").val(parseFloat(contagemConfig.prod_f_tes).toFixed(2)).prop("readonly", isTes ? false : true) : null;
                config_isHom ? $("#prod-hom").val(parseFloat(contagemConfig.prod_f_hom).toFixed(2)).prop("readonly", isHom ? false : true) : null;
                config_isImpl ? $("#prod-impl").val(parseFloat(contagemConfig.prod_f_impl).toFixed(2)).prop("readonly", isImpl ? false : true) : null;
            }
        }
        // passou aqui salva
        calculaFases(false);
    }
});
/*
 * on off da produtividade da linguagem
 */
$('#chk-produtividade-linguagem').on('change', function () {
    if (isSalvarEstatisticas) {
        if ($(this).prop('checked')) {
            $('#chk_produtividade_global').bootstrapToggle('disable');
            $('.escala').prop('disabled', false);
            alteraEscalaProdutividade($('#escala-produtividade').val());
            isLinguagem = true;
            config_isProdutividadeLinguagem = true;
            config_produtividadeLinguagem = parseFloat($('#produtividade-media').val()).toFixed(2);
            config_isEng ? $("#prod-eng").val(parseFloat($('#produtividade-media').val()).toFixed(2)).prop("readonly", true) : null;
            config_isDes ? $("#prod-des").val(parseFloat($('#produtividade-media').val()).toFixed(2)).prop("readonly", true) : null;
            config_isImp ? $("#prod-imp").val(parseFloat($('#produtividade-media').val()).toFixed(2)).prop("readonly", true) : null;
            config_isTes ? $("#prod-tes").val(parseFloat($('#produtividade-media').val()).toFixed(2)).prop("readonly", true) : null;
            config_isHom ? $("#prod-hom").val(parseFloat($('#produtividade-media').val()).toFixed(2)).prop("readonly", true) : null;
            config_isImpl ? $("#prod-impl").val(parseFloat($('#produtividade-media').val()).toFixed(2)).prop("readonly", true) : null;
        }
        else {
            $('.escala').prop('disabled', true);
            $('#chk_produtividade_global').bootstrapToggle('enable');
            $('#escala-produtividade').val('media');
            alteraEscalaProdutividade('media');
            isLinguagem = false;
            config_isProdutividadeLinguagem = false;
            if (ac === 'al') {
                config_isEng ? $("#prod-eng").val(parseFloat(contagemEstatisticas['prod_eng']).toFixed(2)).prop("readonly", isEng ? false : true) : null;
                config_isDes ? $("#prod-des").val(parseFloat(contagemEstatisticas['prod_des']).toFixed(2)).prop("readonly", isDes ? false : true) : null;
                config_isImp ? $("#prod-imp").val(parseFloat(contagemEstatisticas['prod_imp']).toFixed(2)).prop("readonly", isImp ? false : true) : null;
                config_isTes ? $("#prod-tes").val(parseFloat(contagemEstatisticas['prod_tes']).toFixed(2)).prop("readonly", isTes ? false : true) : null;
                config_isHom ? $("#prod-hom").val(parseFloat(contagemEstatisticas['prod_hom']).toFixed(2)).prop("readonly", isHom ? false : true) : null;
                config_isImpl ? $("#prod-impl").val(parseFloat(contagemEstatisticas['prod_impl']).toFixed(2)).prop("readonly", isImpl ? false : true) : null;
            }
            else {
                config_isEng ? $("#prod-eng").val(parseFloat(contagemConfig.prod_f_eng).toFixed(2)).prop("readonly", isEng ? false : true) : null;
                config_isDes ? $("#prod-des").val(parseFloat(contagemConfig.prod_f_des).toFixed(2)).prop("readonly", isDes ? false : true) : null;
                config_isImp ? $("#prod-imp").val(parseFloat(contagemConfig.prod_f_imp).toFixed(2)).prop("readonly", isImp ? false : true) : null;
                config_isTes ? $("#prod-tes").val(parseFloat(contagemConfig.prod_f_tes).toFixed(2)).prop("readonly", isTes ? false : true) : null;
                config_isHom ? $("#prod-hom").val(parseFloat(contagemConfig.prod_f_hom).toFixed(2)).prop("readonly", isHom ? false : true) : null;
                config_isImpl ? $("#prod-impl").val(parseFloat(contagemConfig.prod_f_impl).toFixed(2)).prop("readonly", isImpl ? false : true) : null;
            }
        }
        // entrou aqui recalcula
        calculaFases(false);
    }
});
/*
 * calculos na escala de produtividade
 */
$('.escala').on('click', function () {
    var escala = '';
    switch ($(this).attr('id')) {
        case 'escala-baixa':
            $('#escala-produtividade').val('baixa');
            escala = '-baixa';
            alteraEscalaProdutividade('baixa');
            break;
        case 'escala-media':
            $('#escala-produtividade').val('media');
            escala = '-media';
            alteraEscalaProdutividade('media');
            break;
        case 'escala-alta':
            $('#escala-produtividade').val('alta');
            escala = '-alta';
            alteraEscalaProdutividade('alta');
            break;
    }
    if (isSalvarEstatisticas) {
        config_isEng ? $("#prod-eng").val(parseFloat($('#produtividade' + escala).val()).toFixed(2)).prop("readonly", true) : null;
        config_isDes ? $("#prod-des").val(parseFloat($('#produtividade' + escala).val()).toFixed(2)).prop("readonly", true) : null;
        config_isImp ? $("#prod-imp").val(parseFloat($('#produtividade' + escala).val()).toFixed(2)).prop("readonly", true) : null;
        config_isTes ? $("#prod-tes").val(parseFloat($('#produtividade' + escala).val()).toFixed(2)).prop("readonly", true) : null;
        config_isHom ? $("#prod-hom").val(parseFloat($('#produtividade' + escala).val()).toFixed(2)).prop("readonly", true) : null;
        config_isImpl ? $("#prod-impl").val(parseFloat($('#produtividade' + escala).val()).toFixed(2)).prop("readonly", true) : null;
        // recalcula
        calculaFases(true);
    }
});

$("#prod-eng").on("change", function () {
    if (Number($(this).val()) == 0 || $(this).val() == '')
        $(this).val(contagemConfig.produtividade_global);
    $(this).val(parseFloat($(this).val()).toFixed(2));
    isSalvarEstatisticas ? calculaFases(false) : null;
}).mask("#.##0.00", {reverse: true});

$("#prod-des").on("change", function () {
    if (Number($(this).val()) == 0 || $(this).val() == '')
        $(this).val(contagemConfig.produtividade_global);
    $(this).val(parseFloat($(this).val()).toFixed(2));
    isSalvarEstatisticas ? calculaFases(false) : null;
}).mask("#.##0.00", {reverse: true});

$("#prod-imp").on("change", function () {
    if (Number($(this).val()) == 0 || $(this).val() == '')
        $(this).val(contagemConfig.produtividade_global);
    $(this).val(parseFloat($(this).val()).toFixed(2));
    isSalvarEstatisticas ? calculaFases(false) : null;
}).mask("#.##0.00", {reverse: true});

$("#prod-tes").on("change", function () {
    if (Number($(this).val()) == 0 || $(this).val() == '')
        $(this).val(contagemConfig.produtividade_global);
    $(this).val(parseFloat($(this).val()).toFixed(2));
    isSalvarEstatisticas ? calculaFases(false) : null;
}).mask("#.##0.00", {reverse: true});

$("#prod-hom").on("change", function () {
    if (Number($(this).val()) == 0 || $(this).val() == '')
        $(this).val(contagemConfig.produtividade_global);
    $(this).val(parseFloat($(this).val()).toFixed(2));
    isSalvarEstatisticas ? calculaFases(false) : null;
}).mask("#.##0.00", {reverse: true});

$("#prod-impl").on("change", function () {
    if (Number($(this).val()) == 0 || $(this).val() == '')
        $(this).val(contagemConfig.produtividade_global);
    $(this).val(parseFloat($(this).val()).toFixed(2));
    isSalvarEstatisticas ? calculaFases(false) : null;
}).mask("#.##0.00", {reverse: true});

$('#prof-eng').on('change', function () {
    if (Number($(this).val()) == 0 || $(this).val() == '')
        $(this).val(1);
    isSalvarEstatisticas ? calculaFases(false) : null;
}).mask('00');

$('#prof-des').on('change', function () {
    if (Number($(this).val()) == 0 || $(this).val() == '')
        $(this).val(1);
    isSalvarEstatisticas ? calculaFases(false) : null;
}).mask('00');

$('#prof-imp').on('change', function () {
    if (Number($(this).val()) == 0 || $(this).val() == '')
        $(this).val(1);
    isSalvarEstatisticas ? calculaFases(false) : null;
}).mask('00');

$('#prof-tes').on('change', function () {
    if (Number($(this).val()) == 0 || $(this).val() == '')
        $(this).val(1);
    isSalvarEstatisticas ? calculaFases(false) : null;
}).mask('00');

$('#prof-hom').on('change', function () {
    if (Number($(this).val()) == 0 || $(this).val() == '')
        $(this).val(1);
    isSalvarEstatisticas ? calculaFases(false) : null;
}).mask('00');

$('#prof-impl').on('change', function () {
    if (Number($(this).val()) == 0 || $(this).val() == '')
        $(this).val(1);
    isSalvarEstatisticas ? calculaFases(false) : null;
}).mask('00');

// funcionalidades referentes a esforco, prazo e custo
$('.btn-horas').on('change', function () {
    isSalvarEstatisticas ? calculaFases(true) : null;
});
//
$('.btn-projeto').on('click', function () {
    var tipo = Number($(this).val());
    switch (tipo) {
        case 1:
            config_aumentoEsforco = parseFloat(1).toFixed(2);
            config_fatorReducaoCronograma = parseFloat(1).toFixed(2);
            $('#span-tipo-projeto').html('Projeto Padr&atilde;o => 1,00');
            break;
        case 2:
            config_aumentoEsforco = parseFloat(1.2).toFixed(2);
            config_fatorReducaoCronograma = parseFloat(0.9).toFixed(2);
            $('#span-tipo-projeto').html('Projeto Urgente => 1,20');
            break;
        case 3:
            config_aumentoEsforco = parseFloat(1.5).toFixed(2);
            config_fatorReducaoCronograma = parseFloat(0.8).toFixed(2);
            $('#span-tipo-projeto').html('Projeto Cr&iacute;tico => 1,50');
            break;
        case 4:
            config_aumentoEsforco = parseFloat(1.7).toFixed(2);
            config_fatorReducaoCronograma = parseFloat(0.75).toFixed(2);
            $('#span-tipo-projeto').html('Projeto Alta Criticidade => 1,70');
            break;
    }
    $('#tipo-projeto').val(tipo);
    // salva caso seja necessario
    isSalvarEstatisticas ? calculaFases(true) : null;
});

$('#chk-solicitacao-servico-critica').on('change', function () {
    if (isSalvarEstatisticas) {
        if (($(this).prop('checked'))) {
            config_aumentoEsforco = parseFloat(1.35).toFixed(2);
            config_fatorReducaoCronograma = parseFloat(0.85).toFixed(2);
            $('#span-tipo-projeto').html('Solicita&ccedil;&atilde;o de Servi&ccedil;o Cr&iacute;tica => 1,35');
            // $('#solicitacao-servico-reducao-cronograma').prop('disabled',
            // false).val(15).css({'background': '#ffffff'});
            $('#tipo-projeto').val(5);
        } else {
            config_aumentoEsforco = parseFloat(1).toFixed(2);
            config_fatorReducaoCronograma = parseFloat(1).toFixed(2);
            $('#span-tipo-projeto').html('Projeto Padr&atilde;o => 1,00');
            // $('#solicitacao-servico-reducao-cronograma').val(0).prop('disabled',
            // true).css({'background': '#f0f0f0'});
            $('#tipo-projeto').val(1);
        }
        // habilita ou desabilita os botoes de tipo de projeto
        $('.btn-projeto').prop('disabled', $(this).prop('checked'));
        // salva caso seja necessario
        calculaFases(true);
    }
});

// TODO: versao 2
$('#solicitacao-servico-reducao-cronograma').on('change', function () {
    // alerta para possivel estouro no cronograma
    Number($(this).val() > 25) ? $(this).css({'background': '#ffcc66'}) : $(this).css({'background': '#ffffff'});
    // recalcula o fator de ajuste e o custo
    var fatorReducao = Number($(this).val());
    switch (fatorReducao) {
        case 20:
            break;
        case 25:
            break;
        case 30:
            break;
        case 35:
            break;
        case 40:
            break;
        case 45:
            break;
        case 50:
            break;
    }
    isSalvarEstatisticas ? calculaFases(true) : null;
});
/*
 * botoes de relatorio
 */
$('#btn-pdf').on('click', function () {
    window.open('/pf/DIM.Gateway.php?arq=62&tch=0&sub=3&dlg=1&i=' + idContagem);
});

$('#btn-html').on('click', function () {
    window.open('/pf/DIM.Gateway.php?arq=61&tch=0&sub=3&dlg=1&i=' + idContagem + '&p=html');
});

function escreveTamanhoProdutividade() {
    var pfaTotal = getPfaFasesSelecionadas();
    $('#tamanho-pfa').html(Number(pfaTotal * config_aumentoEsforco).toFixed(4));
    // pega a produtividade media ou a linguagem/produtividade global
    var produtividadeMedia = getProdutividadeMedia();
    var produtividade = config_isProdutividadeGlobal ?
            parseFloat(config_produtividadeGlobal).toFixed(2) :
            (config_isProdutividadeLinguagem ? parseFloat(config_produtividadeLinguagem).toFixed(2) : parseFloat(produtividadeMedia).toFixed(2));
    $('#span-produtividade-media').html(produtividade);
}
/*
 * funcao que retorna apenas os pfa das fases selecionadas
 */
function getPfaFasesSelecionadas() {
    var pfaEng = isEng ? Number($('#pct-pfa-eng').html()) : 0;
    var pfaDes = isDes ? Number($('#pct-pfa-des').html()) : 0;
    var pfaImp = isImp ? Number($('#pct-pfa-imp').html()) : 0;
    var pfaTes = isTes ? Number($('#pct-pfa-tes').html()) : 0;
    var pfaHom = isHom ? Number($('#pct-pfa-hom').html()) : 0;
    var pfaImpl = isImpl ? Number($('#pct-pfa-impl').html()) : 0;
    var pfaFasesSelecionadas = parseFloat(pfaEng + pfaDes + pfaImp + pfaTes + pfaHom + pfaImpl).toFixed(4);
    // retorna a produtividade
    return pfaFasesSelecionadas;
}
/*
 * funcao que retorna o numero de dias uteis do projeto
 */
function getDuracaoProjeto() {
    var diasEng = isEng ? Number($('#esforco-f-eng').html().split("<br>")[1].split(" ")[0]) : 0;
    var diasDes = isDes ? Number($('#esforco-f-des').html().split("<br>")[1].split(" ")[0]) : 0;
    var diasImp = isImp ? Number($('#esforco-f-imp').html().split("<br>")[1].split(" ")[0]) : 0;
    var diasTes = isTes ? Number($('#esforco-f-tes').html().split("<br>")[1].split(" ")[0]) : 0;
    var diasHom = isHom ? Number($('#esforco-f-hom').html().split("<br>")[1].split(" ")[0]) : 0;
    var diasImpl = isImpl ? Number($('#esforco-f-impl').html().split("<br>")[1].split(" ")[0]) : 0;
    var diasFasesSelecionadas = parseFloat(diasEng + diasDes + diasImp + diasTes + diasHom + diasImpl).toFixed(4);
    // retorna a produtividade
    return diasFasesSelecionadas;
}
/*
 * funcao que retorna a produtividade media das fases selecionadas
 */
function getProdutividadeMedia() {
    // produtividades das fases
    var divide = 0;
    var prodEng = isEng ? Number($('#prod-eng').val()) : 0;
    var prodDes = isDes ? Number($('#prod-des').val()) : 0;
    var prodImp = isImp ? Number($('#prod-imp').val()) : 0;
    var prodTes = isTes ? Number($('#prod-tes').val()) : 0;
    var prodHom = isHom ? Number($('#prod-hom').val()) : 0;
    var prodImpl = isImpl ? Number($('#prod-impl').val()) : 0;
    // soma para obter a produtividade media
    divide += isEng ? 1 : 0;
    divide += isDes ? 1 : 0;
    divide += isImp ? 1 : 0;
    divide += isTes ? 1 : 0;
    divide += isHom ? 1 : 0;
    divide += isImpl ? 1 : 0;
    divide = divide == 0 ? 1 : divide;
    // produtividade media das fases
    var produtividadeMedia = parseFloat((prodEng + prodDes + prodImp + prodTes + prodHom + prodImpl) / divide).toFixed(4);
    // retorna a produtividade
    return produtividadeMedia;
}
/*
 * funcao que retorna a data da ultima fase selecionada (final do projeto)
 */
function getDataFinal() {
    return isImpl ? $('#p_impl_data_fim').html() :
            isHom ? $('#p_hom_data_fim').html() :
            isTes ? $('#p_tes_data_fim').html() :
            isImp ? $('#p_imp_data_fim').html() :
            isDes ? $('#p_des_data_fim').html() :
            isEng ? $('#p_eng_data_fim').html() : '';
}
/*
 * pega o valor da hora de consultoria nos contratos
 */
function getValorHora(i) {
    $.post('/pf/DIM.Gateway.php', {'i': i, 'arq': 49, 'tch': 1, 'sub': -1, 'dlg': 1}, function (data) {
        $('#valor-hpc').val(parseFloat(data.valor_hpc).toFixed(2));
        $('#valor-hpa').val(parseFloat(data.valor_hpa).toFixed(2));
        $('#valor-pfa-contrato').val(parseFloat(data.valor_pf).toFixed(2));
    }, 'json');
}
/*
 * funcao que inicia os calculos das estatisticas
 */
function getEsforcoTotal() {
    var produtividadeMedia = getProdutividadeMedia();
    // demais variaveis
    var totPfa = getPfaFasesSelecionadas();
    var produtividade = config_isProdutividadeGlobal ?
            parseFloat(config_produtividadeGlobal) :
            (config_isProdutividadeLinguagem ? parseFloat(config_produtividadeLinguagem) : parseFloat(produtividadeMedia));
    var hpc = Number($('#hpc').val());
    var hpa = Number($('#hpa').val());
    var esforcoTotal = parseFloat((totPfa * produtividade + hpc + hpa) * config_aumentoEsforco).toFixed(4);
    // retorna o valor do esforco total
    return esforcoTotal;
}

function getCustoTotal() {
    var totPfa = getPfaFasesSelecionadas();
    var hpc = Number($('#hpc').val());
    var hpa = Number($('#hpa').val());
    var valorHpc = Number($('#valor-hpc').val());
    var valorHpa = Number($('#valor-hpa').val());
    var custoHoras = (hpc * valorHpc) + (hpa * valorHpa);
    var custoTotal = +(custoHoras + (totPfa * Number($('#valor-pfa-contrato').val()))) || 0;
    return parseFloat(custoTotal * config_aumentoEsforco).toFixed(2);
}

function verificaDataInicio(data) {
    var dNum = Number(data.getDay());
    var dia;
    dtNova = new Date(data);
    if (dNum == 0 || dNum == 6) {
        if (dNum == 6) {
            dia = 's&aacute;bado';
            dtNova = dtNova.setDate(data.getDate() + 2);
        }
        if (dNum == 0) {
            dia = 'domingo';
            dtNova = dtNova.setDate(data.getDate() + 1);
        }

        swal({
            title: "Informa&ccedil;&atilde;o",
            text: "A data inicial informada &eacute; um <strong>" + dia + "</strong>, o sistema iniciar&aacute; os c&aacute;lculos no primeiro dia &uacute;til subsequente!",
            type: "info",
            html: true,
            confirmButtonText: "Entendi, obrigado!"},
        function () {
            $("#previsao_inicio").val(formattedDate(dtNova, false, false));
            calculaFases(false);
        });
    }
    else {
        calculaFases(false);
    }
}
/*
 * funcoes para os graficos nas estatisticas
 */
function graficoVariacao() {
    var dataPfa = [Number(getSpanPfa('ALI', true)), Number(getSpanPfa('AIE', true)), Number(getSpanPfa('EE', true)), Number(getSpanPfa('SE', true)), Number(getSpanPfa('CE', true)), Number(getSpanPfa('OU', true))];
    var dataPfb = [Number(getSpanPfb('ALI', true)), Number(getSpanPfb('AIE', true)), Number(getSpanPfb('EE', true)), Number(getSpanPfb('SE', true)), Number(getSpanPfb('CE', true)), Number(getSpanPfa('OU', true))];
    var ctx = document.getElementById('chart_variacao');
    var mixedChart = new Chart(ctx, {
        type: 'bar',
        data: {
            datasets: [
                {
                    data: dataPfa,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                },
                {
                    label: 'Executado',
                    data: dataPfb,
                    type: 'line'
                }],
            labels: ['ALI', 'AIE', 'EE', 'SE', 'CE']
        },
        options: {
            legend: {
                display: false
            }
        }
    });
}
/* em breve
 function graficoComplexidade() {
 objALI = new getComplexidade('ALI');
 objAIE = new getComplexidade('AIE');
 objEE = new getComplexidade('EE');
 objSE = new getComplexidade('SE');
 objCE = new getComplexidade('CE');
 }
 
 function graficoOperacao() {
 objALI = new getOperacao('ALI');
 objAIE = new getOperacao('AIE');
 objEE = new getOperacao('EE');
 objSE = new getOperacao('SE');
 objCE = new getOperacao('CE');
 objOU = new getOperacao('OU');
 }
 */

/**
 * 
 * @param {type} q quantidade de entregas
 * @param {type} p pfa de cada entrega
 * @returns {undefined}
 */
function graficoEntregas(q, p) {
    var ctx = document.getElementById('chart_entregas');
    var myPieChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: q,
            datasets: [{
                    data: p,
                    backgroundColor: ['rgba(54, 162, 235, 0.2)'],
                    borderColor: ['rgba(54, 162, 235, 1)']
                }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
            }
        }
    });

}

/*
 * funcao simples que escreve a string Inicio e Fim na tabela
 */
function escreveInicioFim(i, f, fa) {
    return '<strong>In&iacute;cio</strong>: <span id="p_' + fa + '_data_inicio">' + formattedDate(new Date(i), false, false) +
            '</span><br><strong>Fim</strong>: <span id="p_' + fa + '_data_fim">' + formattedDate(new Date(f), false, false) + '</span>';
}

function resetaDatas() {
    $("#previsao-f-eng").html('');
    $("#previsao-f-des").html('');
    $("#previsao-f-imp").html('');
    $("#previsao-f-tes").html('');
    $("#previsao-f-hom").html('');
    $("#previsao-f-impl").html('');
    $("#esforco-f-eng").html('');
    $("#esforco-f-des").html('');
    $("#esforco-f-imp").html('');
    $("#esforco-f-tes").html('');
    $("#esforco-f-hom").html('');
    $("#esforco-f-impl").html('');
}

/**
 * 
 * @param {type}
 *            i data inicial
 * @param {type}
 *            f data final sem os finais de semana (sequencial)
 * @returns {unresolved} data final incluindo os finais de semana
 */
function getWeekend(i, f) {
    for (d = i; d < f; d += aDay) {
        dia = new Date(d).getDay();
        if (dia == 0 || dia == 6) {
            f += aDay;
        }
    }
    f -= aDay;
    return f;
}
/**
 * 
 * @param {type}
 *            qtdHoras - quantidade de horas da fase
 * @param {type}
 *            hlt - horas liquidas trabalhadas
 * @param {type}
 *            pFase - profissionais da fase
 * @returns {undefined}
 */
function escreveEsforcoDuracao(horas, duracao) {
    return Number(horas * config_aumentoEsforco).toFixed(4) + ' hora(s)<br />' +
            Number(duracao * config_fatorReducaoCronograma).toFixed(4) + ' dia(s)';
}

/**
 * @param {type}
 *            f - fase (iniciacao, elaboracao, construcao, transicao)
 * @param {type}
 *            v - valor
 * @returns {undefined}
 */
function qtdProfFases(f, v) {
    $('#prof-' + f).val((v == 0) ? 1 : v);
    // nao calcula pelos profissionais
    isSalvarEstatisticas ? calculaFases(false) : null;
}

function calculaFases(isGrafico) {
    // reseta as datas antes dos calculos para evitar inconsistencias
    resetaDatas();
    // variaveis globais (a produtividade global esta no inc_meta.php)
    var dtInicio = getTimeStamp($("#previsao_inicio").val()); // data de
    // inicio do
    // projeto
    var hlt = Number($("#hlt").html()); // horas trabalhadas liquidas
    var ft = 1; // $('#chk-ft').prop('checked') ? Number($('#span-ft').html()) :
    // 1;
    // objeto que retorna o total das funcoes mais o total geral -
    // pfaTotal.ali... pfaTotal.total
    var pfaTotal = new getTotalFuncoes('pfa');
    var is100 = Number(pfaTotal.total) >= 100 ? true : false;
    // percentuais das fases
    var pctEng = config_isEng ? Number($("#pct-eng").html()) / 100 : 0;
    var pctDes = config_isDes ? Number($("#pct-des").html()) / 100 : 0;
    var pctImp = config_isImp ? Number($("#pct-imp").html()) / 100 : 0;
    var pctTes = config_isTes ? Number($("#pct-tes").html()) / 100 : 0;
    var pctHom = config_isHom ? Number($("#pct-hom").html()) / 100 : 0;
    var pctImpl = config_isImpl ? Number($("#pct-impl").html()) / 100 : 0;
    // produtividade de cada fase
    var prodEng = config_isEng ? $("#prod-eng").val() : 0;
    var prodDes = config_isDes ? $("#prod-des").val() : 0;
    var prodImp = config_isImp ? $("#prod-imp").val() : 0;
    var prodTes = config_isTes ? $("#prod-tes").val() : 0;
    var prodHom = config_isHom ? $("#prod-hom").val() : 0;
    var prodImpl = config_isImpl ? $("#prod-impl").val() : 0;
    // percentual de cada fase em relacao ao Ponto de Funcao ajustado - PFa
    var pfaEng = config_isEng ? Number(pfaTotal.total * pctEng * ft) : 0;
    var pfaDes = config_isDes ? Number(pfaTotal.total * pctDes * ft) : 0;
    var pfaImp = config_isImp ? Number(pfaTotal.total * pctImp * ft) : 0;
    var pfaTes = config_isTes ? Number(pfaTotal.total * pctTes * ft) : 0;
    var pfaHom = config_isHom ? Number(pfaTotal.total * pctHom * ft) : 0;
    var pfaImpl = config_isImpl ? Number(pfaTotal.total * pctImpl * ft) : 0;
    // escreve o html dos percentuais
    config_isEng ? $("#pct-pfa-eng").html(pfaEng.toFixed(4)) : 0;
    config_isDes ? $("#pct-pfa-des").html(pfaDes.toFixed(4)) : 0;
    config_isImp ? $("#pct-pfa-imp").html(pfaImp.toFixed(4)) : 0;
    config_isTes ? $("#pct-pfa-tes").html(pfaTes.toFixed(4)) : 0;
    config_isHom ? $("#pct-pfa-hom").html(pfaHom.toFixed(4)) : 0;
    config_isImpl ? $("#pct-pfa-impl").html(pfaImpl.toFixed(4)) : 0;
    // horas de cada fase
    var hrEng = config_isEng ? Number((pfaEng * prodEng)).toFixed(4) : 0;
    var hrDes = config_isDes ? Number((pfaDes * prodDes)).toFixed(4) : 0;
    var hrImp = config_isImp ? Number((pfaImp * prodImp)).toFixed(4) : 0;
    var hrTes = config_isTes ? Number((pfaTes * prodTes)).toFixed(4) : 0;
    var hrHom = config_isHom ? Number((pfaHom * prodHom)).toFixed(4) : 0;
    var hrImpl = config_isImpl ? Number((pfaImpl * prodImpl)).toFixed(4) : 0;
    // profissionais em cada fase
    var profEng = 1;// isEng ? Number($("#prof-eng").val()) : 0;
    var profDes = 1;// isDes ? Number($("#prof-des").val()) : 0;
    var profImp = 1;// isTes ? Number($("#prof-imp").val()) : 0;
    var profTes = 1;// isImp ? Number($("#prof-tes").val()) : 0;
    var profHom = 1;// isTes ? Number($("#prof-hom").val()) : 0;
    var profImpl = 1;// isImpl ? Number($("#prof-impl").val()) : 0;
    // cadeia de verificacao de quem esta selecionado
    if (isEng) {
        var duracaoEng = Number((pfaEng * prodEng) / hlt / (is100 ? profEng : 1)).toFixed(4); // com
        // decimais
        var duracaoIntEng = Math.ceil(duracaoEng) * aDay * Number(config_fatorReducaoCronograma);
        var dataFimEng = dtInicio + duracaoIntEng; // sem os finais de semana
        var dataFinalEng = getWeekend(dtInicio, dataFimEng); // com os finais
        // de semana
        // escreve nos spams
        $("#previsao-f-eng").html(escreveInicioFim(dtInicio, dataFinalEng, 'eng'));
        $("#esforco-f-eng").html(escreveEsforcoDuracao(hrEng, duracaoEng));
        if (isDes) {
            var duracaoDes = Number((pfaDes * prodDes) / hlt / (is100 ? profDes : 1)).toFixed(4);
            var duracaoIntDes = Math.ceil(duracaoDes) * aDay * Number(config_fatorReducaoCronograma);
            var dataFimDes = dataFinalEng + aDay + duracaoIntDes;
            var dataInicioDes = dataFinalEng + aDay;
            if (new Date(dataInicioDes).getDay() == 6)
                dataInicioDes += 2 * aDay;
            var dataFinalDes = getWeekend(dataFinalEng, dataFimDes);
            // escreve os spams
            $("#previsao-f-des").html(escreveInicioFim(dataInicioDes, dataFinalDes, 'des'));
            $("#esforco-f-des").html(escreveEsforcoDuracao(hrDes, duracaoDes));
            if (isImp) {
                var duracaoImp = Number((pfaImp * prodImp) / hlt / (is100 ? profImp : 1)).toFixed(4);
                var duracaoIntImp = Math.ceil(duracaoImp) * aDay * Number(config_fatorReducaoCronograma);
                var dataFimImp = dataFinalDes + aDay + duracaoIntImp;
                var dataInicioImp = dataFinalDes + aDay;
                if (new Date(dataInicioImp).getDay() == 6)
                    dataInicioImp += 2 * aDay;
                var dataFinalImp = getWeekend(dataFinalDes, dataFimImp);
                // escreve os spams
                $("#previsao-f-imp").html(escreveInicioFim(dataInicioImp, dataFinalImp, 'imp'));
                $("#esforco-f-imp").html(escreveEsforcoDuracao(hrImp, duracaoImp));
                if (isTes) {
                    var duracaoTes = Number((pfaTes * prodTes) / hlt / (is100 ? profTes : 1)).toFixed(4);
                    var duracaoIntTes = Math.ceil(duracaoTes) * aDay * Number(config_fatorReducaoCronograma);
                    var dataFimTes = dataFinalImp + aDay + duracaoIntTes;
                    var dataInicioTes = dataFinalImp + aDay;
                    if (new Date(dataInicioTes).getDay() == 6)
                        dataInicioTes += 2 * aDay;
                    var dataFinalTes = getWeekend(dataFinalImp, dataFimTes);
                    // escreve os spams
                    $("#previsao-f-tes").html(escreveInicioFim(dataInicioTes, dataFinalTes, 'tes'));
                    $("#esforco-f-tes").html(escreveEsforcoDuracao(hrTes, duracaoTes));
                    if (isHom) {
                        var duracaoHom = Number((pfaHom * prodHom) / hlt / (is100 ? profHom : 1)).toFixed(4);
                        var duracaoIntHom = Math.ceil(duracaoHom) * aDay * Number(config_fatorReducaoCronograma);
                        var dataFimHom = dataFinalTes + aDay + duracaoIntHom;
                        var dataInicioHom = dataFinalTes + aDay;
                        if (new Date(dataInicioHom).getDay() == 6)
                            dataInicioHom += 2 * aDay;
                        var dataFinalHom = getWeekend(dataFinalTes, dataFimHom);
                        // escreve os spams
                        $("#previsao-f-hom").html(escreveInicioFim(dataInicioHom, dataFinalHom, 'hom'));
                        $("#esforco-f-hom").html(escreveEsforcoDuracao(hrHom, duracaoHom));
                        if (isImpl) {
                            var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                            var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                            var dataFimImpl = dataFinalHom + aDay + duracaoIntImpl;
                            var dataInicioImpl = dataFinalHom + aDay;
                            if (new Date(dataInicioImpl).getDay() == 6)
                                dataInicioImpl += 2 * aDay;
                            var dataFinalImpl = getWeekend(dataFinalHom, dataFimImpl);
                            // escreve os spams
                            $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                            $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
                        }
                    }
                    else if (isImpl) {
                        var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                        var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                        var dataFimImpl = dataFinalTes + aDay + duracaoIntImpl;
                        var dataInicioImpl = dataFinalTes + aDay;
                        if (new Date(dataInicioImpl).getDay() == 6)
                            dataInicioImpl += 2 * aDay;
                        var dataFinalImpl = getWeekend(dataFinalTes, dataFimImpl);
                        // escreve os spams
                        $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                        $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
                    }
                }
                else if (isHom) {
                    var duracaoHom = Number((pfaHom * prodHom) / hlt / (is100 ? profHom : 1)).toFixed(4);
                    var duracaoIntHom = Math.ceil(duracaoHom) * aDay * Number(config_fatorReducaoCronograma);
                    var dataFimHom = dataFinalImp + aDay + duracaoIntHom;
                    var dataInicioHom = dataFinalImp + aDay;
                    if (new Date(dataInicioHom).getDay() == 6)
                        dataInicioHom += 2 * aDay;
                    var dataFinalHom = getWeekend(dataFinalImp, dataFimHom);
                    // escreve os spams
                    $("#previsao-f-hom").html(escreveInicioFim(dataInicioHom, dataFinalHom, 'hom'));
                    $("#esforco-f-hom").html(escreveEsforcoDuracao(hrHom, duracaoHom));
                    if (isImpl) {
                        var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                        var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                        var dataFimImpl = dataFinalHom + aDay + duracaoIntImpl;
                        var dataInicioImpl = dataFinalHom + aDay;
                        if (new Date(dataInicioImpl).getDay() == 6)
                            dataInicioImpl += 2 * aDay;
                        var dataFinalImpl = getWeekend(dataFinalHom, dataFimImpl);
                        // escreve os spams
                        $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                        $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
                    }
                }
                else if (isImpl) {
                    var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                    var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                    var dataFimImpl = dataFinalImp + aDay + duracaoIntImpl;
                    var dataInicioImpl = dataFinalImp + aDay;
                    if (new Date(dataInicioImpl).getDay() == 6)
                        dataInicioImpl += 2 * aDay;
                    var dataFinalImpl = getWeekend(dataFinalImp, dataFimImpl);
                    // escreve os spams
                    $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                    $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
                }
            }
            else if (isTes) {
                var duracaoTes = Number((pfaTes * prodTes) / hlt / (is100 ? profTes : 1)).toFixed(4);
                var duracaoIntTes = Math.ceil(duracaoTes) * aDay * Number(config_fatorReducaoCronograma);
                var dataFimTes = dataFinalDes + aDay + duracaoIntTes;
                var dataInicioTes = dataFinalDes + aDay;
                if (new Date(dataInicioTes).getDay() == 6)
                    dataInicioTes += 2 * aDay;
                var dataFinalTes = getWeekend(dataFinalDes, dataFimTes);
                // escreve os spams
                $("#previsao-f-tes").html(escreveInicioFim(dataInicioTes, dataFinalTes, 'tes'));
                $("#esforco-f-tes").html(escreveEsforcoDuracao(hrTes, duracaoTes));
                if (isHom) {
                    var duracaoHom = Number((pfaHom * prodHom) / hlt / (is100 ? profHom : 1)).toFixed(4);
                    var duracaoIntHom = Math.ceil(duracaoHom) * aDay * Number(config_fatorReducaoCronograma);
                    var dataFimHom = dataFinalTes + aDay + duracaoIntHom;
                    var dataInicioHom = dataFinalTes + aDay;
                    if (new Date(dataInicioHom).getDay() == 6)
                        dataInicioHom += 2 * aDay;
                    var dataFinalHom = getWeekend(dataFinalTes, dataFimHom);
                    // escreve os spams
                    $("#previsao-f-hom").html(escreveInicioFim(dataInicioHom, dataFinalHom, 'hom'));
                    $("#esforco-f-hom").html(escreveEsforcoDuracao(hrHom, duracaoHom));
                    if (isImpl) {
                        var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                        var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                        var dataFimImpl = dataFinalHom + aDay + duracaoIntImpl;
                        var dataInicioImpl = dataFinalHom + aDay;
                        if (new Date(dataInicioImpl).getDay() == 6)
                            dataInicioImpl += 2 * aDay;
                        var dataFinalImpl = getWeekend(dataFinalHom, dataFimImpl);
                        // escreve os spams
                        $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                        $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
                    }
                }
                else if (isImpl) {
                    var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                    var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                    var dataFimImpl = dataFinalTes + aDay + duracaoIntImpl;
                    var dataInicioImpl = dataFinalTes + aDay;
                    if (new Date(dataInicioImpl).getDay() == 6)
                        dataInicioImpl += 2 * aDay;
                    var dataFinalImpl = getWeekend(dataFinalTes, dataFimImpl);
                    // escreve os spams
                    $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                    $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
                }
            }
            else if (isHom) {
                var duracaoHom = Number((pfaHom * prodHom) / hlt / (is100 ? profHom : 1)).toFixed(4);
                var duracaoIntHom = Math.ceil(duracaoHom) * aDay * Number(config_fatorReducaoCronograma);
                var dataFimHom = dataFinalDes + aDay + duracaoIntHom;
                var dataInicioHom = dataFinalDes + aDay;
                if (new Date(dataInicioHom).getDay() == 6)
                    dataInicioHom += 2 * aDay;
                var dataFinalHom = getWeekend(dataFinalDes, dataFimHom);
                // escreve os spams
                $("#previsao-f-hom").html(escreveInicioFim(dataInicioHom, dataFinalHom, 'hom'));
                $("#esforco-f-hom").html(escreveEsforcoDuracao(hrHom, duracaoHom));
                if (isImpl) {
                    var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                    var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                    var dataFimImpl = dataFinalHom + aDay + duracaoIntImpl;
                    var dataInicioImpl = dataFinalHom + aDay;
                    if (new Date(dataInicioImpl).getDay() == 6)
                        dataInicioImpl += 2 * aDay;
                    var dataFinalImpl = getWeekend(dataFinalHom, dataFimImpl);
                    // escreve os spams
                    $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                    $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
                }
            }
            else if (isImpl) {
                var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                var dataFimImpl = dataFinalDes + aDay + duracaoIntImpl;
                var dataInicioImpl = dataFinalDes + aDay;
                if (new Date(dataInicioImpl).getDay() == 6)
                    dataInicioImpl += 2 * aDay;
                var dataFinalImpl = getWeekend(dataFinalDes, dataFimImpl);
                // escreve os spams
                $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
            }
        }
        else if (isImp) {
            var duracaoImp = Number((pfaImp * prodImp) / hlt / (is100 ? profImp : 1)).toFixed(4);
            var duracaoIntImp = Math.ceil(duracaoImp) * aDay * Number(config_fatorReducaoCronograma);
            var dataFimImp = dataFinalEng + aDay + duracaoIntImp;
            var dataInicioImp = dataFinalEng + aDay;
            if (new Date(dataInicioImp).getDay() == 6)
                dataInicioImp += 2 * aDay;
            var dataFinalImp = getWeekend(dataFinalEng, dataFimImp);
            // escreve os spams
            $("#previsao-f-imp").html(escreveInicioFim(dataInicioImp, dataFinalImp, 'imp'));
            $("#esforco-f-imp").html(escreveEsforcoDuracao(hrImp, duracaoImp));
            if (isTes) {
                var duracaoTes = Number((pfaTes * prodTes) / hlt / (is100 ? profTes : 1)).toFixed(4);
                var duracaoIntTes = Math.ceil(duracaoTes) * aDay * Number(config_fatorReducaoCronograma);
                var dataFimTes = dataFinalImp + aDay + duracaoIntTes;
                var dataInicioTes = dataFinalImp + aDay;
                if (new Date(dataInicioTes).getDay() == 6)
                    dataInicioTes += 2 * aDay;
                var dataFinalTes = getWeekend(dataFinalImp, dataFimTes);
                // escreve os spams
                $("#previsao-f-tes").html(escreveInicioFim(dataInicioTes, dataFinalTes, 'tes'));
                $("#esforco-f-tes").html(escreveEsforcoDuracao(hrTes, duracaoTes));
                if (isHom) {
                    var duracaoHom = Number((pfaHom * prodHom) / hlt / (is100 ? profHom : 1)).toFixed(4);
                    var duracaoIntHom = Math.ceil(duracaoHom) * aDay * Number(config_fatorReducaoCronograma);
                    var dataFimHom = dataFinalTes + aDay + duracaoIntHom;
                    var dataInicioHom = dataFinalTes + aDay;
                    if (new Date(dataInicioHom).getDay() == 6)
                        dataInicioHom += 2 * aDay;
                    var dataFinalHom = getWeekend(dataFinalTes, dataFimHom);
                    // escreve os spams
                    $("#previsao-f-hom").html(escreveInicioFim(dataInicioHom, dataFinalHom, 'hom'));
                    $("#esforco-f-hom").html(escreveEsforcoDuracao(hrHom, duracaoHom));
                    if (isImpl) {
                        var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                        var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                        var dataFimImpl = dataFinalHom + aDay + duracaoIntImpl;
                        var dataInicioImpl = dataFinalHom + aDay;
                        if (new Date(dataInicioImpl).getDay() == 6)
                            dataInicioImpl += 2 * aDay;
                        var dataFinalImpl = getWeekend(dataFinalHom, dataFimImpl);
                        // escreve os spams
                        $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                        $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
                    }
                }
                else if (isImpl) {
                    var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                    var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                    var dataFimImpl = dataFinalTes + aDay + duracaoIntImpl;
                    var dataInicioImpl = dataFinalTes + aDay;
                    if (new Date(dataInicioImpl).getDay() == 6)
                        dataInicioImpl += 2 * aDay;
                    var dataFinalImpl = getWeekend(dataFinalTes, dataFimImpl);
                    // escreve os spams
                    $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                    $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
                }
            }
            else if (isHom) {
                var duracaoHom = Number((pfaHom * prodHom) / hlt / (is100 ? profHom : 1)).toFixed(4);
                var duracaoIntHom = Math.ceil(duracaoHom) * aDay * Number(config_fatorReducaoCronograma);
                var dataFimHom = dataFinalImp + aDay + duracaoIntHom;
                var dataInicioHom = dataFinalImp + aDay;
                if (new Date(dataInicioHom).getDay() == 6)
                    dataInicioHom += 2 * aDay;
                var dataFinalHom = getWeekend(dataFinalImp, dataFimHom);
                // escreve os spams
                $("#previsao-f-hom").html(escreveInicioFim(dataInicioHom, dataFinalHom, 'hom'));
                $("#esforco-f-hom").html(escreveEsforcoDuracao(hrHom, duracaoHom));
                if (isImpl) {
                    var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                    var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                    var dataFimImpl = dataFinalHom + aDay + duracaoIntImpl;
                    var dataInicioImpl = dataFinalHom + aDay;
                    if (new Date(dataInicioImpl).getDay() == 6)
                        dataInicioImpl += 2 * aDay;
                    var dataFinalImpl = getWeekend(dataFinalHom, dataFimImpl);
                    // escreve os spams
                    $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                    $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
                }
            }
            else if (isImpl) {
                var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                var dataFimImpl = dataFinalImp + aDay + duracaoIntImpl;
                var dataInicioImpl = dataFinalImp + aDay;
                if (new Date(dataInicioImpl).getDay() == 6)
                    dataInicioImpl += 2 * aDay;
                var dataFinalImpl = getWeekend(dataFinalImp, dataFimImpl);
                // escreve os spams
                $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
            }
        }
        else if (isTes) {
            var duracaoTes = Number((pfaTes * prodTes) / hlt / (is100 ? profTes : 1)).toFixed(4);
            var duracaoIntTes = Math.ceil(duracaoTes) * aDay * Number(config_fatorReducaoCronograma);
            var dataFimTes = dataFinalEng + aDay + duracaoIntTes;
            var dataInicioTes = dataFinalEng + aDay;
            if (new Date(dataInicioTes).getDay() == 6)
                dataInicioTes += 2 * aDay;
            var dataFinalTes = getWeekend(dataFinalEng, dataFimTes);
            // escreve os spams
            $("#previsao-f-tes").html(escreveInicioFim(dataInicioTes, dataFinalTes, 'tes'));
            $("#esforco-f-tes").html(escreveEsforcoDuracao(hrTes, duracaoTes));
            if (isHom) {
                var duracaoHom = Number((pfaHom * prodHom) / hlt / (is100 ? profHom : 1)).toFixed(4);
                var duracaoIntHom = Math.ceil(duracaoHom) * aDay * Number(config_fatorReducaoCronograma);
                var dataFimHom = dataFinalTes + aDay + duracaoIntHom;
                var dataInicioHom = dataFinalTes + aDay;
                if (new Date(dataInicioHom).getDay() == 6)
                    dataInicioHom += 2 * aDay;
                var dataFinalHom = getWeekend(dataFinalTes, dataFimHom);
                // escreve os spams
                $("#previsao-f-hom").html(escreveInicioFim(dataInicioHom, dataFinalHom, 'hom'));
                $("#esforco-f-hom").html(escreveEsforcoDuracao(hrHom, duracaoHom));
                if (isImpl) {
                    var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                    var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                    var dataFimImpl = dataFinalHom + aDay + duracaoIntImpl;
                    var dataInicioImpl = dataFinalHom + aDay;
                    if (new Date(dataInicioImpl).getDay() == 6)
                        dataInicioImpl += 2 * aDay;
                    var dataFinalImpl = getWeekend(dataFinalHom, dataFimImpl);
                    // escreve os spams
                    $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                    $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
                }
            }
            else if (isImpl) {
                var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                var dataFimImpl = dataFinalTes + aDay + duracaoIntImpl;
                var dataInicioImpl = dataFinalTes + aDay;
                if (new Date(dataInicioImpl).getDay() == 6)
                    dataInicioImpl += 2 * aDay;
                var dataFinalImpl = getWeekend(dataFinalTes, dataFimImpl);
                // escreve os spams
                $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
            }
        }
        else if (isHom) {
            var duracaoHom = Number((pfaHom * prodHom) / hlt / (is100 ? profHom : 1)).toFixed(4);
            var duracaoIntHom = Math.ceil(duracaoHom) * aDay * Number(config_fatorReducaoCronograma);
            var dataFimHom = dataFinalEng + aDay + duracaoIntHom;
            var dataInicioHom = dataFinalEng + aDay;
            if (new Date(dataInicioHom).getDay() == 6)
                dataInicioHom += 2 * aDay;
            var dataFinalHom = getWeekend(dataFinalEng, dataFimHom);
            // escreve os spams
            $("#previsao-f-hom").html(escreveInicioFim(dataInicioHom, dataFinalHom, 'hom'));
            $("#esforco-f-hom").html(escreveEsforcoDuracao(hrHom, duracaoHom));
            if (isImpl) {
                var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                var dataFimImpl = dataFinalHom + aDay + duracaoIntImpl;
                var dataInicioImpl = dataFinalHom + aDay;
                if (new Date(dataInicioImpl).getDay() == 6)
                    dataInicioImpl += 2 * aDay;
                var dataFinalImpl = getWeekend(dataFinalHom, dataFimImpl);
                var hrImpl = Number((pfaImpl * prodImpl)).toFixed(4);
                // escreve os spams
                $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
            }
        }
        else if (isImpl) {
            var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
            var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
            var dataFimImpl = dataFinalEng + aDay + duracaoIntImpl;
            var dataInicioImpl = dataFinalEng + aDay;
            if (new Date(dataInicioImpl).getDay() == 6)
                dataInicioImpl += 2 * aDay;
            var dataFinalImpl = getWeekend(dataFinalEng, dataFimImpl);
            // escreve os spams
            $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
            $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
        }
    }
    else if (isDes) {
        var duracaoDes = Number((pfaDes * prodDes) / hlt / (is100 ? profDes : 1)).toFixed(4);
        var duracaoIntDes = Math.ceil(duracaoDes) * aDay * Number(config_fatorReducaoCronograma);
        var dataFimDes = dtInicio + duracaoIntDes;
        var dataInicioDes = dtInicio;
        if (new Date(dataInicioDes).getDay() == 6)
            dataInicioDes += 2 * aDay;
        var dataFinalDes = getWeekend(dtInicio, dataFimDes);
        // escreve os spams
        $("#previsao-f-des").html(escreveInicioFim(dataInicioDes, dataFinalDes, 'des'));
        $("#esforco-f-des").html(escreveEsforcoDuracao(hrDes, duracaoDes));
        if (isImp) {
            var duracaoImp = Number((pfaImp * prodImp) / hlt / (is100 ? profImp : 1)).toFixed(4);
            var duracaoIntImp = Math.ceil(duracaoImp) * aDay * Number(config_fatorReducaoCronograma);
            var dataFimImp = dataFinalDes + aDay + duracaoIntImp;
            var dataInicioImp = dataFinalDes + aDay;
            if (new Date(dataInicioImp).getDay() == 6)
                dataInicioImp += 2 * aDay;
            var dataFinalImp = getWeekend(dataFinalDes, dataFimImp);
            // escreve os spams
            $("#previsao-f-imp").html(escreveInicioFim(dataInicioImp, dataFinalImp, 'imp'));
            $("#esforco-f-imp").html(escreveEsforcoDuracao(hrImp, duracaoImp));
            if (isTes) {
                var duracaoTes = Number((pfaTes * prodTes) / hlt / (is100 ? profTes : 1)).toFixed(4);
                var duracaoIntTes = Math.ceil(duracaoTes) * aDay * Number(config_fatorReducaoCronograma);
                var dataFimTes = dataFinalImp + aDay + duracaoIntTes;
                var dataInicioTes = dataFinalImp + aDay;
                if (new Date(dataInicioTes).getDay() == 6)
                    dataInicioTes += 2 * aDay;
                var dataFinalTes = getWeekend(dataFinalImp, dataFimTes);
                // escreve os spams
                $("#previsao-f-tes").html(escreveInicioFim(dataInicioTes, dataFinalTes, 'tes'));
                $("#esforco-f-tes").html(escreveEsforcoDuracao(hrTes, duracaoTes));
                if (isHom) {
                    var duracaoHom = Number((pfaHom * prodHom) / hlt / (is100 ? profHom : 1)).toFixed(4);
                    var duracaoIntHom = Math.ceil(duracaoHom) * aDay * Number(config_fatorReducaoCronograma);
                    var dataFimHom = dataFinalTes + aDay + duracaoIntHom;
                    var dataInicioHom = dataFinalTes + aDay;
                    if (new Date(dataInicioHom).getDay() == 6)
                        dataInicioHom += 2 * aDay;
                    var dataFinalHom = getWeekend(dataFinalTes, dataFimHom);
                    // escreve os spams
                    $("#previsao-f-hom").html(escreveInicioFim(dataInicioHom, dataFinalHom, 'hom'));
                    $("#esforco-f-hom").html(escreveEsforcoDuracao(hrHom, duracaoHom));
                    if (isImpl) {
                        var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                        var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                        var dataFimImpl = dataFinalHom + aDay + duracaoIntImpl;
                        var dataInicioImpl = dataFinalHom + aDay;
                        if (new Date(dataInicioImpl).getDay() == 6)
                            dataInicioImpl += 2 * aDay;
                        var dataFinalImpl = getWeekend(dataFinalHom, dataFimImpl);
                        // escreve os spams
                        $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                        $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
                    }
                }
                else if (isImpl) {
                    var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                    var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                    var dataFimImpl = dataFinalTes + aDay + duracaoIntImpl;
                    var dataInicioImpl = dataFinalTes + aDay;
                    if (new Date(dataInicioImpl).getDay() == 6)
                        dataInicioImpl += 2 * aDay;
                    var dataFinalImpl = getWeekend(dataFinalTes, dataFimImpl);
                    // escreve os spams
                    $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                    $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
                }
            }
            else if (isHom) {
                var duracaoHom = Number((pfaHom * prodHom) / hlt / (is100 ? profHom : 1)).toFixed(4);
                var duracaoIntHom = Math.ceil(duracaoHom) * aDay * Number(config_fatorReducaoCronograma);
                var dataFimHom = dataFinalImp + aDay + duracaoIntHom;
                var dataInicioHom = dataFinalImp + aDay;
                if (new Date(dataInicioHom).getDay() == 6)
                    dataInicioHom += 2 * aDay;
                var dataFinalHom = getWeekend(dataFinalImp, dataFimHom);
                // escreve os spams
                $("#previsao-f-hom").html(escreveInicioFim(dataInicioHom, dataFinalHom, 'hom'));
                $("#esforco-f-hom").html(escreveEsforcoDuracao(hrHom, duracaoHom));
                if (isImpl) {
                    var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                    var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                    var dataFimImpl = dataFinalHom + aDay + duracaoIntImpl;
                    var dataInicioImpl = dataFinalHom + aDay;
                    if (new Date(dataInicioImpl).getDay() == 6)
                        dataInicioImpl += 2 * aDay;
                    var dataFinalImpl = getWeekend(dataFinalHom, dataFimImpl);
                    // escreve os spams
                    $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                    $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
                }
            }
            else if (isImpl) {
                var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                var dataFimImpl = dataFinalImp + aDay + duracaoIntImpl;
                var dataInicioImpl = dataFinalImp + aDay;
                if (new Date(dataInicioImpl).getDay() == 6)
                    dataInicioImpl += 2 * aDay;
                var dataFinalImpl = getWeekend(dataFinalImp, dataFimImpl);
                // escreve os spams
                $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
            }
        }
        else if (isTes) {
            var duracaoTes = Number((pfaTes * prodTes) / hlt / (is100 ? profTes : 1)).toFixed(4);
            var duracaoIntTes = Math.ceil(duracaoTes) * aDay * Number(config_fatorReducaoCronograma);
            var dataFimTes = dataFinalDes + aDay + duracaoIntTes;
            var dataInicioTes = dataFinalDes + aDay;
            if (new Date(dataInicioTes).getDay() == 6)
                dataInicioTes += 2 * aDay;
            var dataFinalTes = getWeekend(dataFinalDes, dataFimTes);
            // escreve os spams
            $("#previsao-f-tes").html(escreveInicioFim(dataInicioTes, dataFinalTes, 'tes'));
            $("#esforco-f-tes").html(escreveEsforcoDuracao(hrTes, duracaoTes));
            if (isHom) {
                var duracaoHom = Number((pfaHom * prodHom) / hlt / (is100 ? profHom : 1)).toFixed(4);
                var duracaoIntHom = Math.ceil(duracaoHom) * aDay * Number(config_fatorReducaoCronograma);
                var dataFimHom = dataFinalTes + aDay + duracaoIntHom;
                var dataInicioHom = dataFinalTes + aDay;
                if (new Date(dataInicioHom).getDay() == 6)
                    dataInicioHom += 2 * aDay;
                var dataFinalHom = getWeekend(dataFinalTes, dataFimHom);
                // escreve os spams
                $("#previsao-f-hom").html(escreveInicioFim(dataInicioHom, dataFinalHom, 'hom'));
                $("#esforco-f-hom").html(escreveEsforcoDuracao(hrHom, duracaoHom));
                if (isImpl) {
                    var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                    var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                    var dataFimImpl = dataFinalHom + aDay + duracaoIntImpl;
                    var dataInicioImpl = dataFinalHom + aDay;
                    if (new Date(dataInicioImpl).getDay() == 6)
                        dataInicioImpl += 2 * aDay;
                    var dataFinalImpl = getWeekend(dataFinalHom, dataFimImpl);
                    // escreve os spams
                    $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                    $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
                }
            }
            else if (isImpl) {
                var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                var dataFimImpl = dataFinalTes + aDay + duracaoIntImpl;
                var dataInicioImpl = dataFinalTes + aDay;
                if (new Date(dataInicioImpl).getDay() == 6)
                    dataInicioImpl += 2 * aDay;
                var dataFinalImpl = getWeekend(dataFinalTes, dataFimImpl);
                // escreve os spams
                $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
            }
        }
        else if (isHom) {
            var duracaoHom = Number((pfaHom * prodHom) / hlt / (is100 ? profHom : 1)).toFixed(4);
            var duracaoIntHom = Math.ceil(duracaoHom) * aDay * Number(config_fatorReducaoCronograma);
            var dataFimHom = dataFinalDes + aDay + duracaoIntHom;
            var dataInicioHom = dataFinalDes + aDay;
            if (new Date(dataInicioHom).getDay() == 6)
                dataInicioHom += 2 * aDay;
            var dataFinalHom = getWeekend(dataFinalDes, dataFimHom);
            // escreve os spams
            $("#previsao-f-hom").html(escreveInicioFim(dataInicioHom, dataFinalHom, 'hom'));
            $("#esforco-f-hom").html(escreveEsforcoDuracao(hrHom, duracaoHom));
            if (isImpl) {
                var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                var dataFimImpl = dataFinalHom + aDay + duracaoIntImpl;
                var dataInicioImpl = dataFinalHom + aDay;
                if (new Date(dataInicioImpl).getDay() == 6)
                    dataInicioImpl += 2 * aDay;
                var dataFinalImpl = getWeekend(dataFinalHom, dataFimImpl);
                // escreve os spams
                $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
            }
        }
        else if (isImpl) {
            var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
            var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
            var dataFimImpl = dataFinalDes + aDay + duracaoIntImpl;
            var dataInicioImpl = dataFinalDes + aDay;
            if (new Date(dataInicioImpl).getDay() == 6)
                dataInicioImpl += 2 * aDay;
            var dataFinalImpl = getWeekend(dataFinalDes, dataFimImpl);
            // escreve os spams
            $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
            $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
        }
    }
    else if (isImp) {
        var duracaoImp = Number((pfaImp * prodImp) / hlt / (is100 ? profImp : 1)).toFixed(4);
        var duracaoIntImp = Math.ceil(duracaoImp) * aDay * Number(config_fatorReducaoCronograma);
        var dataFimImp = dtInicio + duracaoIntImp;
        var dataInicioImp = dtInicio;
        if (new Date(dataInicioImp).getDay() == 6)
            dataInicioImp += 2 * aDay;
        var dataFinalImp = getWeekend(dtInicio, dataFimImp);
        // escreve os spams
        $("#previsao-f-imp").html(escreveInicioFim(dataInicioImp, dataFinalImp, 'imp'));
        $("#esforco-f-imp").html(escreveEsforcoDuracao(hrImp, duracaoImp));
        if (isTes) {
            var duracaoTes = Number((pfaTes * prodTes) / hlt / (is100 ? profTes : 1)).toFixed(4);
            var duracaoIntTes = Math.ceil(duracaoTes) * aDay * Number(config_fatorReducaoCronograma);
            var dataFimTes = dataFinalImp + aDay + duracaoIntTes;
            var dataInicioTes = dataFinalImp + aDay;
            if (new Date(dataInicioTes).getDay() == 6)
                dataInicioTes += 2 * aDay;
            var dataFinalTes = getWeekend(dataFinalImp, dataFimTes);
            // escreve os spams
            $("#previsao-f-tes").html(escreveInicioFim(dataInicioTes, dataFinalTes, 'tes'));
            $("#esforco-f-tes").html(escreveEsforcoDuracao(hrTes, duracaoTes));
            if (isHom) {
                var duracaoHom = Number((pfaHom * prodHom) / hlt / (is100 ? profHom : 1)).toFixed(4);
                var duracaoIntHom = Math.ceil(duracaoHom) * aDay * Number(config_fatorReducaoCronograma);
                var dataFimHom = dataFinalTes + aDay + duracaoIntHom;
                var dataInicioHom = dataFinalTes + aDay;
                if (new Date(dataInicioHom).getDay() == 6)
                    dataInicioHom += 2 * aDay;
                var dataFinalHom = getWeekend(dataFinalTes, dataFimHom);
                // escreve os spams
                $("#previsao-f-hom").html(escreveInicioFim(dataInicioHom, dataFinalHom, 'hom'));
                $("#esforco-f-hom").html(escreveEsforcoDuracao(hrHom, duracaoHom));
                if (isImpl) {
                    var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                    var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                    var dataFimImpl = dataFinalHom + aDay + duracaoIntImpl;
                    var dataInicioImpl = dataFinalHom + aDay;
                    if (new Date(dataInicioImpl).getDay() == 6)
                        dataInicioImpl += 2 * aDay;
                    var dataFinalImpl = getWeekend(dataFinalHom, dataFimImpl);
                    // escreve os spams
                    $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                    $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
                }
            }
            else if (isImpl) {
                var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                var dataFimImpl = dataFinalTes + aDay + duracaoIntImpl;
                var dataInicioImpl = dataFinalTes + aDay;
                if (new Date(dataInicioImpl).getDay() == 6)
                    dataInicioImpl += 2 * aDay;
                var dataFinalImpl = getWeekend(dataFinalTes, dataFimImpl);
                // escreve os spams
                $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
            }
        }
        else if (isHom) {
            var duracaoHom = Number((pfaHom * prodHom) / hlt / (is100 ? profHom : 1)).toFixed(4);
            var duracaoIntHom = Math.ceil(duracaoHom) * aDay * Number(config_fatorReducaoCronograma);
            var dataFimHom = dataFinalImp + aDay + duracaoIntHom;
            var dataInicioHom = dataFinalImp + aDay;
            if (new Date(dataInicioHom).getDay() == 6)
                dataInicioHom += 2 * aDay;
            var dataFinalHom = getWeekend(dataFinalImp, dataFimHom);
            // escreve os spams
            $("#previsao-f-hom").html(escreveInicioFim(dataInicioHom, dataFinalHom, 'hom'));
            $("#esforco-f-hom").html(escreveEsforcoDuracao(hrHom, duracaoHom));
            if (isImpl) {
                var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                var dataFimImpl = dataFinalHom + aDay + duracaoIntImpl;
                var dataInicioImpl = dataFinalHom + aDay;
                if (new Date(dataInicioImpl).getDay() == 6)
                    dataInicioImpl += 2 * aDay;
                var dataFinalImpl = getWeekend(dataFinalHom, dataFimImpl);
                // escreve os spams
                $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
            }
        }
        else if (isImpl) {
            var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
            var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
            var dataFimImpl = dataFinalImp + aDay + duracaoIntImpl;
            var dataInicioImpl = dataFinalImp + aDay;
            if (new Date(dataInicioImpl).getDay() == 6)
                dataInicioImpl += 2 * aDay;
            var dataFinalImpl = getWeekend(dataFinalImp, dataFimImpl);
            // escreve os spams
            $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
            $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
        }
    }
    else if (isTes) {
        var duracaoTes = Number((pfaTes * prodTes) / hlt / (is100 ? profTes : 1)).toFixed(4);
        var duracaoIntTes = Math.ceil(duracaoTes) * aDay * Number(config_fatorReducaoCronograma);
        var dataFimTes = dtInicio + duracaoIntTes;
        var dataInicioTes = dtInicio;
        if (new Date(dataInicioTes).getDay() == 6)
            dataInicioTes += 2 * aDay;
        var dataFinalTes = getWeekend(dtInicio, dataFimTes);
        // escreve os spams
        $("#previsao-f-tes").html(escreveInicioFim(dataInicioTes, dataFinalTes, 'tes'));
        $("#esforco-f-tes").html(escreveEsforcoDuracao(hrTes, duracaoTes));
        if (isHom) {
            var duracaoHom = Number((pfaHom * prodHom) / hlt / (is100 ? profHom : 1)).toFixed(4);
            var duracaoIntHom = Math.ceil(duracaoHom) * aDay * Number(config_fatorReducaoCronograma);
            var dataFimHom = dataFinalTes + aDay + duracaoIntHom;
            var dataInicioHom = dataFinalTes + aDay;
            if (new Date(dataInicioHom).getDay() == 6)
                dataInicioHom += 2 * aDay;
            var dataFinalHom = getWeekend(dataFinalTes, dataFimHom);
            // escreve os spams
            $("#previsao-f-hom").html(escreveInicioFim(dataInicioHom, dataFinalHom, 'hom'));
            $("#esforco-f-hom").html(escreveEsforcoDuracao(hrHom, duracaoHom));
            if (isImpl) {
                var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
                var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
                var dataFimImpl = dataFinalHom + aDay + duracaoIntImpl;
                var dataInicioImpl = dataFinalHom + aDay;
                if (new Date(dataInicioImpl).getDay() == 6)
                    dataInicioImpl += 2 * aDay;
                var dataFinalImpl = getWeekend(dataFinalHom, dataFimImpl);
                // escreve os spams
                $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
                $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
            }
        }
        else if (isImpl) {
            var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
            var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
            var dataFimImpl = dataFinalTes + aDay + duracaoIntImpl;
            var dataInicioImpl = dataFinalTes + aDay;
            if (new Date(dataInicioImpl).getDay() == 6)
                dataInicioImpl += 2 * aDay;
            var dataFinalImpl = getWeekend(dataFinalTes, dataFimImpl);
            // escreve os spams
            $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
            $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
        }
    }
    else if (isHom) {
        var duracaoHom = Number((pfaHom * prodHom) / hlt / (is100 ? profHom : 1)).toFixed(4);
        var duracaoIntHom = Math.ceil(duracaoHom) * aDay * Number(config_fatorReducaoCronograma);
        var dataFimHom = dtInicio + duracaoIntHom;
        var dataInicioHom = dtInicio;
        if (new Date(dataInicioHom).getDay() == 6)
            dataInicioHom += 2 * aDay;
        var dataFinalHom = getWeekend(dtInicio, dataFimHom);
        // escreve os spams
        $("#previsao-f-hom").html(escreveInicioFim(dataInicioHom, dataFinalHom, 'hom'));
        $("#esforco-f-hom").html(escreveEsforcoDuracao(hrHom, duracaoHom));
        if (isImpl) {
            var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
            var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
            var dataFimImpl = dataFinalHom + aDay + duracaoIntImpl;
            var dataInicioImpl = dataFinalHom + aDay;
            if (new Date(dataInicioImpl).getDay() == 6)
                dataInicioImpl += 2 * aDay;
            var dataFinalImpl = getWeekend(dataFinalHom, dataFimImpl);
            // escreve os spams
            $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
            $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
        }
    }
    else if (isImpl) {
        var duracaoImpl = Number((pfaImpl * prodImpl) / hlt / (is100 ? profImpl : 1)).toFixed(4);
        var duracaoIntImpl = Math.ceil(duracaoImpl) * aDay * Number(config_fatorReducaoCronograma);
        var dataFimImpl = dtInicio + duracaoIntImpl;
        var dataInicioImpl = dtInicio;
        if (new Date(dataInicioImpl).getDay() == 6)
            dataInicioImpl += 2 * aDay;
        var dataFinalImpl = getWeekend(dtInicio, dataFimImpl);
        // escreve os spams
        $("#previsao-f-impl").html(escreveInicioFim(dataInicioImpl, dataFinalImpl, 'impl'));
        $("#esforco-f-impl").html(escreveEsforcoDuracao(hrImpl, duracaoImpl));
    }
    // calcula prazo
    calculaPrazo(isGrafico);
}

function calculaPrazo(isGrafico) {
    var item = $("input[type=radio][name=expoente]:checked");
    var t = item.length > 0 ? item.val() : Number('0.32').toFixed(2);
    var V = getBaseCalculo();// api
    // TODO: sombrear tabela
    var Td = Number(Math.pow(V, t)).toFixed(2);
    $('#calculado').html(V.toLocaleString());
    $('#tempo-desenvolvimento').html(Td.toLocaleString());
    $('#regiao-impossivel').html(Number(Td * .75).toFixed(2).toLocaleString());
    $('#menor-custo').html(Number(2 * Td).toFixed(2).toLocaleString());
    // recalcula o esforco total da contagem
    calculaEsforco(isGrafico);
}

function calculaEsforco(isGrafico) {
    var esforcoTotal = getEsforcoTotal();
    var duracaoProjeto = getDuracaoProjeto();
    var custoTotal = getCustoTotal();
    var cReplace = custoTotal.replace('.', ',');
    var cExtenso = cReplace.extenso(true);
    $('#esforco-total').val(esforcoTotal);
    $('#span-esforco-total').html(esforcoTotal);
    $('#duracao-projeto').html(duracaoProjeto);
    // escreve nos spans tamanho-pfa e produtividade-media
    escreveTamanhoProdutividade();
    // escreve o custo total
    $('#custo-total').html(parseFloat(custoTotal).toFixed(2) + '<br><small>' + cExtenso.capitalizeFirstLetter() + '</small>');
    // escreve a data final
    $('#data-final-projeto').html(getDataFinal());
    $('#div_previsao_termino').html(getDataFinal());
    // TODO: grafico de entregas
    // passa isGrafico por todas as funcoes e somente calcula aqui
    isGrafico ? calculaDistribuicaoEntregas() : null;
    // salva as estatisticas passando cocomo ou sisp
    // delegado para o calcula cocomo
    // salvarEstatisticas();
    calculaCocomo();
}

function calculaDistribuicaoEntregas() {
    var qtdEntregas = Number($('#entregas').val());
    var hlt = Number($('#hlt').html());
    var arrEntregas = [];
    var desEntregas = [];
    var maxALI = qtdALI + 1;
    var maxAIE = qtdAIE + 1;
    var maxEE = qtdEE + 1;
    var maxSE = qtdSE + 1;
    var maxCE = qtdCE + 1;
    var maxOU = qtdOU + 1;
    for (x = 0; x <= qtdEntregas; x++) {
        arrEntregas[x] = 0;
        desEntregas[x] = '';
    }
    var entrega;
    var this_row;
    var pfa;
    var pfm; // pontos de funcao no ponteiro da matriz
    var des; // descricao da funcao da entrega x
    // monta a tabela com as estatisticas das entregas
    $('#tblEntregas').empty();
    var table = document.getElementById('tblEntregas');
    var row;
    var ft = $('#chk-ft').prop('checked') ? Number($('#span-ft').html()) : 1;
    var totPfa = Number(parseFloat($('#tamanho-pfa').html()).toFixed(4));
    var lblEntregas = '';
    var arrLabelsEntregas;
    /*
     * verifica quais fases estao selecionadas
     */
    var percentualTotalFases = Number(0);
    isEng ? percentualTotalFases += Number($('#pct-eng').html()) : 0;
    isDes ? percentualTotalFases += Number($('#pct-des').html()) : 0;
    isImp ? percentualTotalFases += Number($('#pct-imp').html()) : 0;
    isTes ? percentualTotalFases += Number($('#pct-tes').html()) : 0;
    isHom ? percentualTotalFases += Number($('#pct-hom').html()) : 0;
    isImpl ? percentualTotalFases += Number($('#pct-impl').html()) : 0;
    percentualTotalFases = percentualTotalFases / 100;
    /*
     * percorer as tabelas ALI, AIE, EE, etc... TODO: ver a questao do 2000
     * inserido no codigo ... segundo ponto
     */
    for (x = 1; x <= qtdEntregas; x++) {
        $("#addALI tr:lt(" + maxALI + ")").each(function () {
            this_row = $(this);
            entrega = Number($.trim(this_row.find('td:eq(9)').text()));
            if (x == entrega) {
                pfa = Number($.trim(this_row.find('td:eq(8)').text())) * percentualTotalFases;
                des = $.trim(this_row.find('td:eq(2)').text());
                pfm = Number(+arrEntregas[x] || 0);
                arrEntregas[x] = (Number(parseFloat(pfm).toFixed(4)) + Number(parseFloat(pfa).toFixed(4)));
                desEntregas[x] = desEntregas[x] + 'ALI - ' + des + ', ';
            }
        });
        $("#addAIE tr:lt(" + maxAIE + ")").each(function () {
            this_row = $(this);
            entrega = Number($.trim(this_row.find('td:eq(9)').text()));
            if (x == entrega) {
                pfa = Number($.trim(this_row.find('td:eq(8)').text())) * percentualTotalFases;
                des = $.trim(this_row.find('td:eq(2)').text());
                pfm = Number(+arrEntregas[x] || 0);
                arrEntregas[x] = (Number(parseFloat(pfm).toFixed(4)) + Number(parseFloat(pfa).toFixed(4)));
                desEntregas[x] = desEntregas[x] + 'AIE - ' + des + ', ';
            }
        });
        $("#addEE tr:lt(" + maxEE + ")").each(function () {
            this_row = $(this);
            entrega = Number($.trim(this_row.find('td:eq(9)').text()));
            if (x == entrega) {
                pfa = Number($.trim(this_row.find('td:eq(8)').text())) * percentualTotalFases;
                des = $.trim(this_row.find('td:eq(2)').text());
                pfm = Number(+arrEntregas[x] || 0);
                arrEntregas[x] = (Number(parseFloat(pfm).toFixed(4)) + Number(parseFloat(pfa).toFixed(4)));
                desEntregas[x] = desEntregas[x] + 'EE - ' + des + ', ';
            }
        });
        $("#addSE tr:lt(" + maxSE + ")").each(function () {
            this_row = $(this);
            entrega = Number($.trim(this_row.find('td:eq(9)').text()));
            if (x == entrega) {
                pfa = Number($.trim(this_row.find('td:eq(8)').text())) * percentualTotalFases;
                des = $.trim(this_row.find('td:eq(2)').text());
                pfm = Number(+arrEntregas[x] || 0);
                arrEntregas[x] = (Number(parseFloat(pfm).toFixed(4)) + Number(parseFloat(pfa).toFixed(4)));
                desEntregas[x] = desEntregas[x] + 'SE - ' + des + ', ';
            }
        });
        $("#addCE tr:lt(" + maxCE + ")").each(function () {
            this_row = $(this);
            entrega = Number($.trim(this_row.find('td:eq(9)').text()));
            if (x == entrega) {
                pfa = Number($.trim(this_row.find('td:eq(8)').text())) * percentualTotalFases;
                des = $.trim(this_row.find('td:eq(2)').text());
                pfm = Number(+arrEntregas[x] || 0);
                arrEntregas[x] = (Number(parseFloat(pfm).toFixed(4)) + Number(parseFloat(pfa).toFixed(4)));
                desEntregas[x] = desEntregas[x] + 'CE - ' + des + ', ';
            }
        });
        $("#addOU tr:lt(" + maxOU + ")").each(function () {
            this_row = $(this);
            entrega = Number($.trim(this_row.find('td:eq(6)').text()));
            if (x == entrega) {
                pfa = Number($.trim(this_row.find('td:eq(4)').text())) * percentualTotalFases;
                des = $.trim(this_row.find('td:eq(2)').text());
                pfm = Number(+arrEntregas[x] || 0);
                arrEntregas[x] = (Number(parseFloat(pfm).toFixed(4)) + Number(parseFloat(pfa).toFixed(4)));
                desEntregas[x] = desEntregas[x] + 'OU - ' + des + ', ';
            }
        });
    }
    var produtividadeMedia = getProdutividadeMedia();
    var custoTotal = getCustoTotal();
    // loop para montar a tabela
    for (x = 1; x <= qtdEntregas; x++) {
        row = table.insertRow(-1);
        row.className = 'fadeIn';
        // calcula o esforco e a duracao da fase
        var esforco = +(Number(arrEntregas[x] * produtividadeMedia).toFixed(4)) || 0;
        var esforcoOriginal = +(Number(arrEntregas[x] * produtividadeMedia).toFixed(4)) || 0;
        var duracao = esforco > 0 ? Number((esforcoOriginal / hlt)).toFixed(4) : 0;
        var pctTotal = (+(Number((arrEntregas[x] * config_aumentoEsforco) / (totPfa)) * 100).toFixed(4) || 0);
        var desembolso = Number(pctTotal / 100 * custoTotal).toFixed(2);
        var cell1 = row.insertCell(0); // entrega
        var cell2 = row.insertCell(1); // funcoes
        var cell3 = row.insertCell(2); // pfa original como se tivesse todas as
        // fases
        var cell4 = row.insertCell(3); // percentual sobre o total
        var cell5 = row.insertCell(4); // esforco para cada conjunto de
        // entregas/sprints
        var cell6 = row.insertCell(5); // duracao da fase em dias
        var cell7 = row.insertCell(6); // previsao de desembolso para cada
        // entrega
        // escreve os textos
        cell1.innerHTML = '#' + ("0000" + x).slice(-4);
        lblEntregas += '#' + ("0000" + x).slice(-4) + ',';
        cell2.innerHTML = desEntregas[x].substring(0, desEntregas[x].length - 2);
        cell3.innerHTML = Number((arrEntregas[x]) * config_aumentoEsforco * ft).toFixed(4);
        cell4.innerHTML = parseFloat(pctTotal * ft).toFixed(4) + "%";
        cell5.innerHTML = parseFloat(esforco * config_aumentoEsforco * ft).toFixed(4) + ' h';
        cell6.innerHTML = parseFloat(duracao * config_fatorReducaoCronograma * ft).toFixed(4) + ' d';
        cell7.innerHTML = 'R$ ' + parseFloat(desembolso * ft).toFixed(2);
    }
    arrLabelsEntregas = (lblEntregas.substring(0, lblEntregas.length - 1)).split(',');
    /*
     * retira o ultimo elemento que esta em branco
     */
    arrEntregas.shift();
    /*
     * passando para o grafico a quantidade de entregas e os pfa de cada entrega
     */
    graficoEntregas(arrLabelsEntregas, arrEntregas);
}

function salvarEstatisticas() {
    if (ac === 'al' || ac === 'in' || ac === 're') {
        iWaitEstatisticas('wait-estatisticas', true, 'fa fa-pie-chart fa-lg');
        var item = $("input[type=radio][name=expoente]:checked");
        var expoente = item.length > 0 ? item.val() : Number('0.32').toFixed(2);
        var ft = $('#chk-ft').prop('checked') ? Number($('#span-ft').html()) : 1;
        var tamanho_pfa = $('#tamanho-pfa').html(); // $('#total-pf-local').html();
        if (isSalvarEstatisticas) {
            $.post("/pf/DIM.Gateway.php", {
                'arq': 11,
                'tch': 0,
                'sub': -1,
                'dlg': 1,
                'id': idContagem,
                // estatisticas
                'previsao_inicio': $('#previsao_inicio').val(),
                'previsao_termino': $('#div_previsao_termino').html(),
                'produtividade_global': produtividadeGlobal,
                'chk_produtividade_global': $('#chk_produtividade_global').prop('checked') ? 1 : 0,
                'hlt': $('#hlt').html(),
                'isFt': $('#chk-ft').prop('checked') ? 1 : 0,
                'ft': $('#span-ft').html(),
                // eng
                'pct-eng': config_isEng ? $('#pct-eng').html() : 0,
                'prod-eng': config_isEng ? $('#prod-eng').val() : 0,
                'prof-eng': config_isEng ? $('#prof-eng').val() : 0,
                'perf-eng': config_isEng ? selectizeEng.getValue() : '',
                'chk-eng': config_isEng ? ($('#chk-eng').prop('checked') ? 1 : 0) : 0,
                'is-f-eng': config_isEng ? 1 : 0,
                'desc-f-eng': config_isEng ? $('#desc-f-eng').html() : '',
                // des
                'pct-des': config_isDes ? $('#pct-des').html() : 0,
                'prod-des': config_isDes ? $('#prod-des').val() : 0,
                'prof-des': config_isDes ? $('#prof-des').val() : 0,
                'perf-des': config_isDes ? selectizeDes.getValue() : '',
                'chk-des': config_isDes ? ($('#chk-des').prop('checked') ? 1 : 0) : 0,
                'is-f-des': config_isDes ? 1 : 0,
                'desc-f-des': config_isDes ? $('#desc-f-des').html() : '',
                // imp
                'pct-imp': config_isImp ? $('#pct-imp').html() : 0,
                'prod-imp': config_isImp ? $('#prod-imp').val() : 0,
                'prof-imp': config_isImp ? $('#prof-imp').val() : 0,
                'perf-imp': config_isImp ? selectizeImp.getValue() : '',
                'chk-imp': config_isImp ? ($('#chk-imp').prop('checked') ? 1 : 0) : 0,
                'is-f-imp': config_isImp ? 1 : 0,
                'desc-f-imp': config_isImp ? $('#desc-f-imp').html() : '',
                // tes
                'pct-tes': config_isTes ? $('#pct-tes').html() : 0,
                'prod-tes': config_isTes ? $('#prod-tes').val() : 0,
                'prof-tes': config_isTes ? $('#prof-tes').val() : 0,
                'perf-tes': config_isTes ? selectizeTes.getValue() : '',
                'chk-tes': config_isTes ? ($('#chk-tes').prop('checked') ? 1 : 0) : 0,
                'is-f-tes': config_isTes ? 1 : 0,
                'desc-f-tes': config_isTes ? $('#desc-f-tes').html() : '',
                // hom
                'pct-hom': config_isHom ? $('#pct-hom').html() : 0,
                'prod-hom': config_isHom ? $('#prod-hom').val() : 0,
                'prof-hom': config_isHom ? $('#prof-hom').val() : 0,
                'perf-hom': config_isHom ? selectizeHom.getValue() : '',
                'chk-hom': config_isHom ? ($('#chk-hom').prop('checked') ? 1 : 0) : 0,
                'is-f-hom': config_isHom ? 1 : 0,
                'desc-f-hom': config_isHom ? $('#desc-f-hom').html() : '',
                // impl
                'pct-impl': config_isImpl ? $('#pct-impl').html() : 0,
                'prod-impl': config_isImpl ? $('#prod-impl').val() : 0,
                'prof-impl': config_isImpl ? $('#prof-impl').val() : 0,
                'perf-impl': config_isImpl ? selectizeImpl.getValue() : '',
                'chk-impl': config_isImpl ? ($('#chk-impl').prop('checked') ? 1 : 0) : 0,
                'is-f-impl': config_isImpl ? 1 : 0,
                'desc-f-impl': config_isImpl ? $('#desc-f-impl').html() : '',
                // demais informacoes
                'expoente': expoente,
                'calculado': ($('#calculado').html()).length > 0 ? $('#calculado').html() : 0,
                'tempo-desenvolvimento': ($('#tempo-desenvolvimento').html()).length > 0 ? $('#tempo-desenvolvimento').html() : 0,
                'regiao-impossivel': ($('#regiao-impossivel').html()).length > 0 ? $('#regiao-impossivel').html() : 0,
                'menor-custo': ($('#menor-custo').html()).length > 0 ? $('#menor-custo').html() : 0,
                // previsoes e prazos
                'previsao-f-eng': config_isEng ? $('#previsao-f-eng').html() : '',
                'previsao-f-des': config_isDes ? $('#previsao-f-des').html() : '',
                'previsao-f-imp': config_isImp ? $('#previsao-f-imp').html() : '',
                'previsao-f-tes': config_isTes ? $('#previsao-f-tes').html() : '',
                'previsao-f-hom': config_isHom ? $('#previsao-f-hom').html() : '',
                'previsao-f-impl': config_isImpl ? $('#previsao-f-impl').html() : '',
                'esforco-f-eng': config_isEng ? $('#esforco-f-eng').html() : '',
                'esforco-f-des': config_isDes ? $('#esforco-f-des').html() : '',
                'esforco-f-imp': config_isImp ? $('#esforco-f-imp').html() : '',
                'esforco-f-tes': config_isTes ? $('#esforco-f-tes').html() : '',
                'esforco-f-hom': config_isHom ? $('#esforco-f-hom').html() : '',
                'esforco-f-impl': config_isImpl ? $('#esforco-f-impl').html() : '',
                // pfa de cada fase
                'pct-pfa-eng': config_isEng ? $('#pct-pfa-eng').html() : 0,
                'pct-pfa-des': config_isDes ? $('#pct-pfa-des').html() : 0,
                'pct-pfa-imp': config_isImp ? $('#pct-pfa-imp').html() : 0,
                'pct-pfa-tes': config_isTes ? $('#pct-pfa-tes').html() : 0,
                'pct-pfa-hom': config_isHom ? $('#pct-pfa-hom').html() : 0,
                'pct-pfa-impl': config_isImpl ? $('#pct-pfa-impl').html() : 0,
                'chk-produtividade-linguagem': $('#chk-produtividade-linguagem').prop('checked') ? 1 : 0,
                'escala-produtividade': $('#escala-produtividade').val(),
                'produtividade-baixa': $('#produtividade-baixa').val(),
                'produtividade-media': $('#produtividade-media').val(),
                'produtividade-alta': $('#produtividade-alta').val(),
                // calculos iniciais
                // calculos iniciais
                'hpc': Number($('#hpc').val()),
                'hpa': Number($('#hpa').val()),
                'valor-hpc': Number($('#valor-hpc').val()),
                'valor-hpa': Number($('#valor-hpa').val()),
                'custo-total': getCustoTotal(),
                'valor-pfa-contrato': Number($('#valor-pfa-contrato').val()),
                // cronograma
                'aumento-esforco': config_aumentoEsforco,
                'fator-reducao-cronograma': config_fatorReducaoCronograma,
                'tipo-projeto': $('#tipo-projeto').val(),
                'esforco-total': $('#esforco-total').val(),
                'tamanho-pfa': tamanho_pfa,
                'span-produtividade-media': $('#span-produtividade-media').html(),
                // cocomo II.2000
                'COCOMO_A': $('#COCOMO-A').val(),
                'COCOMO_B': $('#COCOMO-B').val(),
                'COCOMO_C': $('#COCOMO-C').val(),
                'COCOMO_D': $('#COCOMO-D').val(),
                'COCOMO_E': $('#COCOMO-E').val(),
                'ED_PERS': $('input:radio[name=ED-PERS]:checked').get(0).id, // 'ED-PERS-NO',
                'ED_RCPX': $('input:radio[name=ED-RCPX]:checked').get(0).id, // 'ED-RCPX-NO',
                'ED_PDIF': $('input:radio[name=ED-PDIF]:checked').get(0).id, // 'ED-PDIF-NO',
                'ED_PREX': $('input:radio[name=ED-PREX]:checked').get(0).id, // 'ED-PREX-NO',
                'ED_FCIL': $('input:radio[name=ED-FCIL]:checked').get(0).id, // 'ED-FCIL-NO',
                'ED_RUSE': $('input:radio[name=ED-RUSE]:checked').get(0).id, // 'ED-RUSE-NO',
                'ED_SCED': $('input:radio[name=ED-SCED]:checked').get(0).id, // 'ED-SCED-NO',
                'PREC': $('input:radio[name=PREC]:checked').get(0).id, // 'PREC-NO',
                'FLEX': $('input:radio[name=FLEX]:checked').get(0).id, // 'FLEX-NO',
                'RESL': $('input:radio[name=RESL]:checked').get(0).id, // 'RESL-NO',
                'TEAM': $('input:radio[name=TEAM]:checked').get(0).id, // 'TEAM-NO',
                'PMAT': $('input:radio[name=PMAT]:checked').get(0).id, // 'PMAT-NO',
                'RELY': $('input:radio[name=RELY]:checked').get(0).id, // 'RELY-NO',
                'DATA': $('input:radio[name=DATA]:checked').get(0).id, // 'DATA-NO',
                'CPLX_CN': $('input:radio[name=CPLX-CN]:checked').get(0).id, // 'CPLX-CN-NO',
                'CPLX_CO': $('input:radio[name=CPLX-CO]:checked').get(0).id, // 'CPLX-CO-NO',
                'CPLX_DO': $('input:radio[name=CPLX-DO]:checked').get(0).id, // 'CPLX-DO-NO',
                'CPLX_DM': $('input:radio[name=CPLX-DM]:checked').get(0).id, // 'CPLX-DM-NO',
                'CPLX_UI': $('input:radio[name=CPLX-UI]:checked').get(0).id, // 'CPLX-UI-NO',
                'CPLX': $('#CPLX').val(),
                'RUSE': $('input:radio[name=RUSE]:checked').get(0).id, // 'RUSE-NO',
                'DOCU': $('input:radio[name=DOCU]:checked').get(0).id, // 'DOCU-NO',
                'TIME': $('input:radio[name=TIME]:checked').get(0).id, // 'TIME-NO',
                'STOR': $('input:radio[name=STOR]:checked').get(0).id, // 'STOR-NO',
                'PVOL': $('input:radio[name=PVOL]:checked').get(0).id, // 'PVOL-NO',
                'ACAP': $('input:radio[name=ACAP]:checked').get(0).id, // 'ACAP-NO',
                'PCAP': $('input:radio[name=PCAP]:checked').get(0).id, // 'PCAP-NO',
                'PCON': $('input:radio[name=PCON]:checked').get(0).id, // 'PCON-NO',
                'APEX': $('input:radio[name=APEX]:checked').get(0).id, // 'APEX-NO',
                'PLEX': $('input:radio[name=PLEX]:checked').get(0).id, // 'PLEX-NO',
                'LTEX': $('input:radio[name=LTEX]:checked').get(0).id, // 'LTEX-NO',
                'TOOL': $('input:radio[name=TOOL]:checked').get(0).id, // 'TOOL-NO',
                'SITE': $('input:radio[name=SITE]:checked').get(0).id, // 'SITE-NO',
                'SCED': $('input:radio[name=SCED]:checked').get(0).id, // 'SCED-NO',
                'esforco': $('#coc-esforco').html(), // '0',
                'cronograma': $('#coc-cronograma').html(), // '0',
                'custo': $('#coc-custo').html(), // '0',
                'custo_pessoa': $('#coc-custo-pessoa').html(), // '0',
                'sloc': $('#coc-sloc').html(), // '0',
                'tipo_calculo': $('#tipo-calculo').prop('checked') ? 1 : 0 // '0',
            },
            function (data) {
                if (!data.sucesso) {
                    swal({
                        title: "Alerta",
                        text: "N&atilde;o foi poss&iacute;vel atualizar as estat&iacute;sticas, por favor tente novamente.",
                        type: "error",
                        html: true,
                        confirmButtonText: "Entendi, obrigado!"});
                }
                iWaitEstatisticas('wait-estatisticas', false, 'fa fa-pie-chart fa-lg');
            }, "json");
        }
    }
    // destaca a linha em projetos menores que 100PFa
    destacaLinhaMenor100();
}

function montaTabelaFatorTecnologia(tamanho_pfa) {
    $.post('/pf/DIM.Gateway.php', {
        'arq': 104,
        'tch': 1,
        'sub': -1,
        'dlg': 1,
        'idc': idContagem}, function (data) {
        /*
         * monta a tabela com o fator tecnologia
         */
        var tabela_fator_tecnologia = document.getElementById('tabela_fator_tecnologia');
        var total_pf_fator_tecnologia = 0;
        var isFT = $('#chk-ft').prop('checked') ? true : false;
        var tamanho_pfa_ft = getSomaPFAFatorTecnologia();// dim.apidim.js
        $('#tabela_fator_tecnologia').empty();
        /*
         * verifica todas as tecnologias envolvidas
         */
        for (y = 0; y < data.fator_tecnologia.length; y++) {
            var tot = data.percentual_de_cada[y] * (isFT ? data.fator_tecnologia[y].fator_tecnologia : 1) * tamanho_pfa_ft;
            var row = tabela_fator_tecnologia.insertRow(-1);
            var cell0 = row.insertCell(0);
            var cell1 = row.insertCell(1);
            var cell2 = row.insertCell(2);
            var cell3 = row.insertCell(3);
            var cell4 = row.insertCell(4);
            /*
             * alinha ao centro apenas quantidade
             */
            cell0.setAttribute('align', 'center');
            cell2.setAttribute('align', 'right');
            cell3.setAttribute('align', 'right');
            cell4.setAttribute('align', 'right');
            /*
             * insere os valores
             */
            cell0.innerHTML = data.fator_tecnologia[y].quantidade;
            cell1.innerHTML = data.fator_tecnologia[y].descricao;
            cell2.innerHTML = parseFloat(data.fator_tecnologia[y].fator_tecnologia).toFixed(4);
            cell3.innerHTML = parseFloat(data.percentual_de_cada[y] * 100).toFixed(4) + '%';
            cell4.innerHTML = parseFloat(tot).toFixed(4);
            /*
             * incrementa ao PF
             */
            total_pf_fator_tecnologia += tot;
        }
        /*
         * atualiza o valor total de PF
         */
        $('#total-pf-local').html(parseFloat(total_pf_fator_tecnologia).toFixed(4));
        /*
         * salva as estatisticas
         */
        isSalvarEstatisticas ? salvarEstatisticas() : null;
    }, 'json');
}

function destacaLinhaMenor100() {
    var v = getBaseCalculo();
    var l;
    if (v < 11) {
        l = 'pf0';
    }
    else if (v >= 11 && v < 21) {
        l = 'pf1';
    }
    else if (v >= 21 && v < 31) {
        l = 'pf2';
    }
    else if (v >= 31 && v < 41) {
        l = 'pf3';
    }
    else if (v >= 41 && v < 51) {
        l = 'pf4';
    }
    else if (v >= 51 && v < 61) {
        l = 'pf5';
    }
    else if (v >= 61 && v < 71) {
        l = 'pf6';
    }
    else if (v >= 71 && v < 86) {
        l = 'pf7';
    }
    else if (v >= 86 && v < 100) {
        l = 'pf8';
    }
    // remove as classes de todas as linhas
    for (x = 0; x <= 8; x++) {
        $('#pf' + x).removeClass('linha-destaque-menor-100');
    }
    // colore diferente a linha que alcancou <100
    $('#' + l).addClass('linha-destaque-menor-100');
}