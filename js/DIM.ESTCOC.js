$('#tipo-calculo').on('change', function () {
    isSalvarEstatisticas ? calculaCocomo() : null;
});
$('.rd-cocomo').on('click', function () {
    isSalvarEstatisticas ? calculaCocomo() : null;
});
/*
 * para os spins do cocomo ii.2000
 */
$("input[name='touch-cocomo']").on('change', function () {
    isSalvarEstatisticas ? calculaCocomo() : null;
}).TouchSpin({
    verticalbuttons: true,
    step: 0.01,
    decimals: 2,
    forcestepdivisibility: 'none',
    verticalupclass: 'glyphicon glyphicon-plus',
    verticaldownclass: 'glyphicon glyphicon-minus'
});
/*
 * restaurando os valores originais das variaveis
 */
$('.or-cocomo').on('click', function () {
    $('#' + ($(this).get(0).id).substring(3)).val($(this).attr('value'));
    isSalvarEstatisticas ? calculaCocomo() : null;
    return false;
});

function calculaCocomo() {
    //calcula para cocomo
    var coc_a = Number($('#COCOMO-A').val());
    var coc_b = Number($('#COCOMO-B').val());
    var coc_c = Number($('#COCOMO-C').val());
    var coc_d = Number($('#COCOMO-D').val());
    var slocConversao = Number($('#coc-sloc-conversao').html());
    var pfb = Number($('#totPfb').html());
    var sloc = Number(slocConversao * pfb) / 1000;
    var tamanho_pfa = $('#tamanho-pfa').html();
    /*
     * metodo de calculo do R$/PM do Dimension
     */
    var pfbTotal = getTotalFuncoes('pfb');
    var produtividade = getProdutividadeMedia();
    var hlt = Number($("#hlt").html());
    var diasMes = 21;
    var meses = [(pfbTotal.total * produtividade) / hlt] / diasMes;
    var custoTotal = getCustoTotal();
    var custoPessoa = +(custoTotal / meses) || 0;
    $('#coc-custo-pessoa').html(custoPessoa.toFixed(2));
    /*
     * continua com o processamento normal
     */
    var tipoCalculo = $('#tipo-calculo').prop('checked') ? true : false;
    $('#coc-ufp').html(pfb.toFixed(0));
    $('#coc-lng').html($('#id_linguagem option:selected').text() + ' -&gt; ' + Number(sloc * 1000));
    var prec = Number($('input:radio[name=PREC]:checked').val());
    var flex = Number($('input:radio[name=FLEX]:checked').val());
    var resl = Number($('input:radio[name=RESL]:checked').val());
    var team = Number($('input:radio[name=TEAM]:checked').val());
    var pmat = Number($('input:radio[name=PMAT]:checked').val());
    var rely = Number($('input:radio[name=RELY]:checked').val());
    var data = Number($('input:radio[name=DATA]:checked').val());
    var cplx = Number(0);
    /*
     * para calcular o cplx
     */
    var vlr_cplx = Number(0); //dividendo
    var cplx_str;
    $("input:radio[data=CPLX]").each(function () {
        var id_cplx = $(this).get(0).id;
        if ($(this).prop('checked')) {
            if (id_cplx.indexOf('VL') > -1) {
                vlr_cplx = Number(vlr_cplx) + Number(1);
            }
            if (id_cplx.indexOf('LO') > -1) {
                vlr_cplx = Number(vlr_cplx) + Number(2);
            }
            if (id_cplx.indexOf('NO') > -1) {
                vlr_cplx = Number(vlr_cplx) + Number(3);
            }
            if (id_cplx.indexOf('HI') > -1) {
                vlr_cplx = Number(vlr_cplx) + Number(4);
            }
            if (id_cplx.indexOf('VH') > -1) {
                vlr_cplx = Number(vlr_cplx) + Number(5);
            }
            if (id_cplx.indexOf('EH') > -1) {
                vlr_cplx = Number(vlr_cplx) + Number(6);
            }
        }
    });
    cplx = Number(vlr_cplx) / Number(6);
    //marca na tabela
    if (cplx <= 1.525) {//VL
        destacaCPLX($('#CPLX-VL'));
        cplx = 0.73;
        cplx_str = 'CPLX-VL';
    }
    else if (cplx > 1.525 && cplx < 2.22) {//LO
        destacaCPLX($('#CPLX-LO'));
        cplx = 0.87;
        cplx_str = 'CPLX-LO';
    }
    else if (cplx > 2.22 && cplx < 2.915) {//NO
        destacaCPLX($('#CPLX-NO'));
        cplx = 1;
        cplx_str = 'CPLX-NO';
    }
    else if (cplx > 2.915 && cplx < 3.61) {//HI
        destacaCPLX($('#CPLX-HI'));
        cplx = 1.17;
        cplx_str = 'CPLX-HI';
    }
    else if (cplx > 3.61 && cplx < 4.305) {//VH
        destacaCPLX($('#CPLX-VH'));
        cplx = 1.34;
        cplx_str = 'CPLX-VH';
    }
    else if (cplx > 4.305) {
        destacaCPLX($('#CPLX-EH'));
        cplx = 1.74;
        cplx_str = 'CPLX-EH';
    }
    $('#CPLX').val(cplx_str);
    /*
     * continua com as outras variaveis
     */
    var ruse = Number($('input:radio[name=RUSE]:checked').val());
    var docu = Number($('input:radio[name=DOCU]:checked').val());
    var time = Number($('input:radio[name=TIME]:checked').val());
    var stor = Number($('input:radio[name=STOR]:checked').val());
    var pvol = Number($('input:radio[name=PVOL]:checked').val());
    var acap = Number($('input:radio[name=ACAP]:checked').val());
    var pcap = Number($('input:radio[name=PCAP]:checked').val());
    var pcon = Number($('input:radio[name=PCON]:checked').val());
    var apex = Number($('input:radio[name=APEX]:checked').val());
    var plex = Number($('input:radio[name=PLEX]:checked').val());
    var ltex = Number($('input:radio[name=LTEX]:checked').val());
    var tool = Number($('input:radio[name=TOOL]:checked').val());
    var site = Number($('input:radio[name=SITE]:checked').val());
    var sced = Number($('input:radio[name=SCED]:checked').val());
    //early design
    var ed_pers = Number($('input:radio[name=ED-PERS]:checked').val());
    var ed_rcpx = Number($('input:radio[name=ED-RCPX]:checked').val());
    var ed_pdif = Number($('input:radio[name=ED-PDIF]:checked').val());
    var ed_prex = Number($('input:radio[name=ED-PREX]:checked').val());
    var ed_fcil = Number($('input:radio[name=ED-FCIL]:checked').val());
    var ed_ruse = Number($('input:radio[name=ED-RUSE]:checked').val());
    var ed_sced = Number($('input:radio[name=ED-SCED]:checked').val());
    //expoente
    var e = Number(coc_b) + 0.01 * (
            Number(prec) +
            Number(flex) +
            Number(resl) +
            Number(team) +
            Number(pmat));
    var em_pa = Number(rely) * //Post Architecture
            Number(data) *
            Number(cplx) *
            Number(ruse) *
            Number(docu) *
            Number(time) *
            Number(stor) *
            Number(pvol) *
            Number(acap) *
            Number(pcap) *
            Number(pcon) *
            Number(apex) *
            Number(plex) *
            Number(ltex) *
            Number(tool) *
            Number(site) *
            Number(sced);
    var em_ed = Number(ed_pers) *
            Number(ed_rcpx) *
            Number(ed_pdif) *
            Number(ed_prex) *
            Number(ed_fcil) *
            Number(ed_ruse) *
            Number(ed_sced);
    var pm = tipoCalculo ?
            Number(coc_a) * Math.pow(Number(sloc), Number(e)) * Number(em_pa) :
            Number(coc_a) * Math.pow(Number(sloc), Number(e)) * Number(em_ed);
    var f = Number(coc_d) + 0.2 * (Number(e) - Number(coc_b));
    var tdev = (coc_c * Math.pow(Number(pm), Number(f)));
    var coc_custo = Number(pm * custoPessoa);
    /*
     * escreve nos spams
     */
    $('#coc-esforco').html(Number(pm).toFixed(2));
    $('#coc-cronograma').html(Number(tdev).toFixed(2));
    $('#coc-custo').html(Number(coc_custo).toFixed(2));
    $('#coc-sloc').html(sloc * 1000);
    //cocGrafico(pm, tdev);
    //rup
    var rup_inc_ef = contagemEstatisticasCocomo.rup_inc_ef * pm / 100;
    var rup_ela_ef = contagemEstatisticasCocomo.rup_ela_ef * pm / 100;
    var rup_con_ef = contagemEstatisticasCocomo.rup_con_ef * pm / 100;
    var rup_tra_ef = contagemEstatisticasCocomo.rup_tra_ef * pm / 100;
    var rup_inc_sc = contagemEstatisticasCocomo.rup_inc_sc * tdev / 100;
    var rup_ela_sc = contagemEstatisticasCocomo.rup_ela_sc * tdev / 100;
    var rup_con_sc = contagemEstatisticasCocomo.rup_con_sc * tdev / 100;
    var rup_tra_sc = contagemEstatisticasCocomo.rup_tra_sc * tdev / 100;
    var coc_inc_ef = contagemEstatisticasCocomo.coc_inc_ef * pm / 100;
    var coc_ela_ef = contagemEstatisticasCocomo.coc_ela_ef * pm / 100;
    var coc_con_ef = contagemEstatisticasCocomo.coc_con_ef * pm / 100;
    var coc_tra_ef = contagemEstatisticasCocomo.coc_tra_ef * pm / 100;
    var coc_inc_sc = contagemEstatisticasCocomo.coc_inc_sc * tdev / 100;
    var coc_ela_sc = contagemEstatisticasCocomo.coc_ela_sc * tdev / 100;
    var coc_con_sc = contagemEstatisticasCocomo.coc_con_sc * tdev / 100;
    var coc_tra_sc = contagemEstatisticasCocomo.coc_tra_sc * tdev / 100;
    var rup_inc_av = rup_inc_ef / rup_inc_sc;
    var rup_ela_av = rup_ela_ef / rup_ela_sc;
    var rup_con_av = rup_con_ef / rup_con_sc;
    var rup_tra_av = rup_tra_ef / rup_tra_sc;
    var coc_inc_av = coc_inc_ef / coc_inc_sc;
    var coc_ela_av = coc_ela_ef / coc_ela_sc;
    var coc_con_av = coc_con_ef / coc_con_sc;
    var coc_tra_av = coc_tra_ef / coc_tra_sc;
    $('#rup-inc-ef').html(rup_inc_ef.toFixed(2));
    $('#rup-inc-sc').html(rup_inc_sc.toFixed(2));
    $('#rup-ela-ef').html(rup_ela_ef.toFixed(2));
    $('#rup-ela-sc').html(rup_ela_sc.toFixed(2));
    $('#rup-con-ef').html(rup_con_ef.toFixed(2));
    $('#rup-con-sc').html(rup_con_sc.toFixed(2));
    $('#rup-tra-ef').html(rup_tra_ef.toFixed(2));
    $('#rup-tra-sc').html(rup_tra_sc.toFixed(2));
    $('#rup-inc-co').html(Number(custoPessoa * rup_inc_ef).toFixed(2));
    $('#rup-ela-co').html(Number(custoPessoa * rup_ela_ef).toFixed(2));
    $('#rup-con-co').html(Number(custoPessoa * rup_con_ef).toFixed(2));
    $('#rup-tra-co').html(Number(custoPessoa * rup_tra_ef).toFixed(2));
    $('#rup-inc-av').html(Number(rup_inc_av).toFixed(2));
    $('#rup-ela-av').html(Number(rup_ela_av).toFixed(2));
    $('#rup-con-av').html(Number(rup_con_av).toFixed(2));
    $('#rup-tra-av').html(Number(rup_tra_av).toFixed(2));
    //cocomo II.2000
    $('#coc-inc-ef').html(coc_inc_ef.toFixed(2));
    $('#coc-inc-sc').html(coc_inc_sc.toFixed(2));
    $('#coc-ela-ef').html(coc_ela_ef.toFixed(2));
    $('#coc-ela-sc').html(coc_ela_sc.toFixed(2));
    $('#coc-con-ef').html(coc_con_ef.toFixed(2));
    $('#coc-con-sc').html(coc_con_sc.toFixed(2));
    $('#coc-tra-ef').html(coc_tra_ef.toFixed(2));
    $('#coc-tra-sc').html(coc_tra_sc.toFixed(2));
    $('#coc-inc-co').html(Number(custoPessoa * coc_inc_ef).toFixed(2));
    $('#coc-ela-co').html(Number(custoPessoa * coc_ela_ef).toFixed(2));
    $('#coc-con-co').html(Number(custoPessoa * coc_con_ef).toFixed(2));
    $('#coc-tra-co').html(Number(custoPessoa * coc_tra_ef).toFixed(2));
    $('#coc-inc-av').html(Number(coc_inc_av).toFixed(2));
    $('#coc-ela-av').html(Number(coc_ela_av).toFixed(2));
    $('#coc-con-av').html(Number(coc_con_av).toFixed(2));
    $('#coc-tra-av').html(Number(coc_tra_av).toFixed(2));
    //rup
    var rup_man_inc = contagemEstatisticasCocomo.man_inc / 100 * rup_inc_ef;
    var rup_man_ela = contagemEstatisticasCocomo.man_ela / 100 * rup_ela_ef;
    var rup_man_con = contagemEstatisticasCocomo.man_con / 100 * rup_con_ef;
    var rup_man_tra = contagemEstatisticasCocomo.man_tra / 100 * rup_tra_ef;
    var rup_env_inc = contagemEstatisticasCocomo.env_inc / 100 * rup_inc_ef;
    var rup_env_ela = contagemEstatisticasCocomo.env_ela / 100 * rup_ela_ef;
    var rup_env_con = contagemEstatisticasCocomo.env_con / 100 * rup_con_ef;
    var rup_env_tra = contagemEstatisticasCocomo.env_tra / 100 * rup_tra_ef;
    var rup_req_inc = contagemEstatisticasCocomo.req_inc / 100 * rup_inc_ef;
    var rup_req_ela = contagemEstatisticasCocomo.req_ela / 100 * rup_ela_ef;
    var rup_req_con = contagemEstatisticasCocomo.req_con / 100 * rup_con_ef;
    var rup_req_tra = contagemEstatisticasCocomo.req_tra / 100 * rup_tra_ef;
    var rup_des_inc = contagemEstatisticasCocomo.des_inc / 100 * rup_inc_ef;
    var rup_des_ela = contagemEstatisticasCocomo.des_ela / 100 * rup_ela_ef;
    var rup_des_con = contagemEstatisticasCocomo.des_con / 100 * rup_con_ef;
    var rup_des_tra = contagemEstatisticasCocomo.des_tra / 100 * rup_tra_ef;
    var rup_imp_inc = contagemEstatisticasCocomo.imp_inc / 100 * rup_inc_ef;
    var rup_imp_ela = contagemEstatisticasCocomo.imp_ela / 100 * rup_ela_ef;
    var rup_imp_con = contagemEstatisticasCocomo.imp_con / 100 * rup_con_ef;
    var rup_imp_tra = contagemEstatisticasCocomo.imp_tra / 100 * rup_tra_ef;
    var rup_ass_inc = contagemEstatisticasCocomo.ass_inc / 100 * rup_inc_ef;
    var rup_ass_ela = contagemEstatisticasCocomo.ass_ela / 100 * rup_ela_ef;
    var rup_ass_con = contagemEstatisticasCocomo.ass_con / 100 * rup_con_ef;
    var rup_ass_tra = contagemEstatisticasCocomo.ass_tra / 100 * rup_tra_ef;
    var rup_dep_inc = contagemEstatisticasCocomo.dep_inc / 100 * rup_inc_ef;
    var rup_dep_ela = contagemEstatisticasCocomo.dep_ela / 100 * rup_ela_ef;
    var rup_dep_con = contagemEstatisticasCocomo.dep_con / 100 * rup_con_ef;
    var rup_dep_tra = contagemEstatisticasCocomo.dep_tra / 100 * rup_tra_ef;
    $('#rup-man-inc').html(rup_man_inc.toFixed(2));
    $('#rup-man-ela').html(rup_man_ela.toFixed(2));
    $('#rup-man-con').html(rup_man_con.toFixed(2));
    $('#rup-man-tra').html(rup_man_tra.toFixed(2));
    $('#rup-env-inc').html(rup_env_inc.toFixed(2));
    $('#rup-env-ela').html(rup_env_ela.toFixed(2));
    $('#rup-env-con').html(rup_env_con.toFixed(2));
    $('#rup-env-tra').html(rup_env_tra.toFixed(2));
    $('#rup-req-inc').html(rup_req_inc.toFixed(2));
    $('#rup-req-ela').html(rup_req_ela.toFixed(2));
    $('#rup-req-con').html(rup_req_con.toFixed(2));
    $('#rup-req-tra').html(rup_req_tra.toFixed(2));
    $('#rup-des-inc').html(rup_des_inc.toFixed(2));
    $('#rup-des-ela').html(rup_des_ela.toFixed(2));
    $('#rup-des-con').html(rup_des_con.toFixed(2));
    $('#rup-des-tra').html(rup_des_tra.toFixed(2));
    $('#rup-imp-inc').html(rup_imp_inc.toFixed(2));
    $('#rup-imp-ela').html(rup_imp_ela.toFixed(2));
    $('#rup-imp-con').html(rup_imp_con.toFixed(2));
    $('#rup-imp-tra').html(rup_imp_tra.toFixed(2));
    $('#rup-ass-inc').html(rup_ass_inc.toFixed(2));
    $('#rup-ass-ela').html(rup_ass_ela.toFixed(2));
    $('#rup-ass-con').html(rup_ass_con.toFixed(2));
    $('#rup-ass-tra').html(rup_ass_tra.toFixed(2));
    $('#rup-dep-inc').html(rup_dep_inc.toFixed(2));
    $('#rup-dep-ela').html(rup_dep_ela.toFixed(2));
    $('#rup-dep-con').html(rup_dep_con.toFixed(2));
    $('#rup-dep-tra').html(rup_dep_tra.toFixed(2));
    //cocomo
    var coc_man_inc = contagemEstatisticasCocomo.man_inc / 100 * coc_inc_ef;
    var coc_man_ela = contagemEstatisticasCocomo.man_ela / 100 * coc_ela_ef;
    var coc_man_con = contagemEstatisticasCocomo.man_con / 100 * coc_con_ef;
    var coc_man_tra = contagemEstatisticasCocomo.man_tra / 100 * coc_tra_ef;
    var coc_env_inc = contagemEstatisticasCocomo.env_inc / 100 * coc_inc_ef;
    var coc_env_ela = contagemEstatisticasCocomo.env_ela / 100 * coc_ela_ef;
    var coc_env_con = contagemEstatisticasCocomo.env_con / 100 * coc_con_ef;
    var coc_env_tra = contagemEstatisticasCocomo.env_tra / 100 * coc_tra_ef;
    var coc_req_inc = contagemEstatisticasCocomo.req_inc / 100 * coc_inc_ef;
    var coc_req_ela = contagemEstatisticasCocomo.req_ela / 100 * coc_ela_ef;
    var coc_req_con = contagemEstatisticasCocomo.req_con / 100 * coc_con_ef;
    var coc_req_tra = contagemEstatisticasCocomo.req_tra / 100 * coc_tra_ef;
    var coc_des_inc = contagemEstatisticasCocomo.des_inc / 100 * coc_inc_ef;
    var coc_des_ela = contagemEstatisticasCocomo.des_ela / 100 * coc_ela_ef;
    var coc_des_con = contagemEstatisticasCocomo.des_con / 100 * coc_con_ef;
    var coc_des_tra = contagemEstatisticasCocomo.des_tra / 100 * coc_tra_ef;
    var coc_imp_inc = contagemEstatisticasCocomo.imp_inc / 100 * coc_inc_ef;
    var coc_imp_ela = contagemEstatisticasCocomo.imp_ela / 100 * coc_ela_ef;
    var coc_imp_con = contagemEstatisticasCocomo.imp_con / 100 * coc_con_ef;
    var coc_imp_tra = contagemEstatisticasCocomo.imp_tra / 100 * coc_tra_ef;
    var coc_ass_inc = contagemEstatisticasCocomo.ass_inc / 100 * coc_inc_ef;
    var coc_ass_ela = contagemEstatisticasCocomo.ass_ela / 100 * coc_ela_ef;
    var coc_ass_con = contagemEstatisticasCocomo.ass_con / 100 * coc_con_ef;
    var coc_ass_tra = contagemEstatisticasCocomo.ass_tra / 100 * coc_tra_ef;
    var coc_dep_inc = contagemEstatisticasCocomo.dep_inc / 100 * coc_inc_ef;
    var coc_dep_ela = contagemEstatisticasCocomo.dep_ela / 100 * coc_ela_ef;
    var coc_dep_con = contagemEstatisticasCocomo.dep_con / 100 * coc_con_ef;
    var coc_dep_tra = contagemEstatisticasCocomo.dep_tra / 100 * coc_tra_ef;
    $('#coc-man-inc').html(coc_man_inc.toFixed(2));
    $('#coc-man-ela').html(coc_man_ela.toFixed(2));
    $('#coc-man-con').html(coc_man_con.toFixed(2));
    $('#coc-man-tra').html(coc_man_tra.toFixed(2));
    $('#coc-env-inc').html(coc_env_inc.toFixed(2));
    $('#coc-env-ela').html(coc_env_ela.toFixed(2));
    $('#coc-env-con').html(coc_env_con.toFixed(2));
    $('#coc-env-tra').html(coc_env_tra.toFixed(2));
    $('#coc-req-inc').html(coc_req_inc.toFixed(2));
    $('#coc-req-ela').html(coc_req_ela.toFixed(2));
    $('#coc-req-con').html(coc_req_con.toFixed(2));
    $('#coc-req-tra').html(coc_req_tra.toFixed(2));
    $('#coc-des-inc').html(coc_des_inc.toFixed(2));
    $('#coc-des-ela').html(coc_des_ela.toFixed(2));
    $('#coc-des-con').html(coc_des_con.toFixed(2));
    $('#coc-des-tra').html(coc_des_tra.toFixed(2));
    $('#coc-imp-inc').html(coc_imp_inc.toFixed(2));
    $('#coc-imp-ela').html(coc_imp_ela.toFixed(2));
    $('#coc-imp-con').html(coc_imp_con.toFixed(2));
    $('#coc-imp-tra').html(coc_imp_tra.toFixed(2));
    $('#coc-ass-inc').html(coc_ass_inc.toFixed(2));
    $('#coc-ass-ela').html(coc_ass_ela.toFixed(2));
    $('#coc-ass-con').html(coc_ass_con.toFixed(2));
    $('#coc-ass-tra').html(coc_ass_tra.toFixed(2));
    $('#coc-dep-inc').html(coc_dep_inc.toFixed(2));
    $('#coc-dep-ela').html(coc_dep_ela.toFixed(2));
    $('#coc-dep-con').html(coc_dep_con.toFixed(2));
    $('#coc-dep-tra').html(coc_dep_tra.toFixed(2));
    /*
     * calcula com o Fator Tecnologia e salva as estatisticas (delegada para a funcao)
     */
    montaTabelaFatorTecnologia(tamanho_pfa);
}

function destacaCPLX(c) {
    var id = $(c).get(0).id;
    var cplx = id.substring(id.length - 2);
    $('#CPLX-VL').html('');
    $('#CPLX-LO').html('');
    $('#CPLX-NO').html('');
    $('#CPLX-HI').html('');
    $('#CPLX-VH').html('');
    $('#CPLX-EH').html('');
    switch (cplx) {
        case 'VL':
            $('#CPLX-VL').html('<div class="label label-info">Muito baixo</div>');
            break;
        case 'LO':
            $('#CPLX-LO').html('<div class="label label-info">Baixo</div>');
            break;
        case 'NO':
            $('#CPLX-NO').html('<div class="label label-info">Nominal</div>');
            break;
        case 'HI':
            $('#CPLX-HI').html('<div class="label label-info">Alto</div>');
            break;
        case 'VH':
            $('#CPLX-VH').html('<div class="label label-info">Muito alto</div>');
            break;
        case 'EH':
            $('#CPLX-EH').html('<div class="label label-info">Alt&iacute;ssimo</div>');
            break;
    }
}

/*
 * funcoes para os graficos nas estatisticas
 */
function cocGrafico(pm, tdev) {
    var data = [1, 2, 3, 4, 5, 6, 7, 8, 9];
    var arrTdev = new Array();
    for (x = 0; x <= Math.ceil(tdev); x++) {
        arrTdev[x] = x;
    }
    var grfVariacaoPfb = new RGraph.Bar({
        id: 'coc-chart',
        data: data,
        options: {
            gutter: {left: 50},
            labels: {self: arrTdev},
            strokestyle: 'rgba(0,0,0,0)',
            colors: ['rgba(255,102,0,.4)'],
            textSize: 10
        }
    }).grow().on('beforedraw', function (obj) {
        RGraph.clear(obj.canvas, 'white');
    });
}

