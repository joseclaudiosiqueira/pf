$('#cocomo-link-escala').on('click', function () {
    if (Number($('#config_id_cliente option:selected').val()) == 0) {
        swal({
            title: "Alerta",
            text: "Por favor selecione um Cliente",
            type: "warning",
            html: true,
            confirmButtonText: "Vou verificar, obrigado!"});
    }
    else {
        $.post('DIM.Gateway.php', {
            'arq': 101,
            'tch': 1,
            'sub': -1,
            'dlg': 0,
            'icl': $('#config_id_cliente option:selected').val()
        }, function (data) {
            $('#COCOMO-A').val(Number(data.COCOMO_A).toFixed(2));
            $('#COCOMO-B').val(Number(data.COCOMO_B).toFixed(2));
            $('#COCOMO-C').val(Number(data.COCOMO_C).toFixed(2));
            $('#COCOMO-D').val(Number(data.COCOMO_D).toFixed(2));
            $('#DEF-PREC').val(data.DEF_PREC);
            $('#DEF-FLEX').val(data.DEF_FLEX);
            $('#DEF-RESL').val(data.DEF_RESL);
            $('#DEF-TEAM').val(data.DEF_TEAM);
            $('#DEF-PMAT').val(data.DEF_PMAT);
            //PREC
            $('#PREC-VL').val(Number(data.PREC_VL).toFixed(2));
            $('#PREC-LO').val(Number(data.PREC_LO).toFixed(2));
            $('#PREC-NO').val(Number(data.PREC_NO).toFixed(2));
            $('#PREC-HI').val(Number(data.PREC_HI).toFixed(2));
            $('#PREC-VH').val(Number(data.PREC_VH).toFixed(2));
            //FLEX
            $('#FLEX-VL').val(Number(data.FLEX_VL).toFixed(2));
            $('#FLEX-LO').val(Number(data.FLEX_LO).toFixed(2));
            $('#FLEX-NO').val(Number(data.FLEX_NO).toFixed(2));
            $('#FLEX-HI').val(Number(data.FLEX_HI).toFixed(2));
            $('#FLEX-VH').val(Number(data.FLEX_VH).toFixed(2));
            //RESL
            $('#RESL-VL').val(Number(data.RESL_VL).toFixed(2));
            $('#RESL-LO').val(Number(data.RESL_LO).toFixed(2));
            $('#RESL-NO').val(Number(data.RESL_NO).toFixed(2));
            $('#RESL-HI').val(Number(data.RESL_HI).toFixed(2));
            $('#RESL-VH').val(Number(data.RESL_EH).toFixed(2));
            //TEAM
            $('#TEAM-VL').val(Number(data.TEAM_VL).toFixed(2));
            $('#TEAM-LO').val(Number(data.TEAM_LO).toFixed(2));
            $('#TEAM-NO').val(Number(data.TEAM_NO).toFixed(2));
            $('#TEAM-HI').val(Number(data.TEAM_HI).toFixed(2));
            $('#TEAM-VH').val(Number(data.TEAM_VH).toFixed(2));
            //PMAT
            $('#PMAT-VL').val(Number(data.PMAT_VL).toFixed(2));
            $('#PMAT-LO').val(Number(data.PMAT_LO).toFixed(2));
            $('#PMAT-NO').val(Number(data.PMAT_NO).toFixed(2));
            $('#PMAT-HI').val(Number(data.PMAT_HI).toFixed(2));
            $('#PMAT-VH').val(Number(data.PMAT_VH).toFixed(2));
            //exibe o form
            $('#form_modal_configuracoes_cocomo_escala').modal('show');
            somaFases();
        }, 'json');
    }
});

$('#cocomo-link-projeto-inicial').on('click', function () {
    if (Number($('#config_id_cliente option:selected').val()) == 0) {
        swal({
            title: "Alerta",
            text: "Por favor selecione um Cliente",
            type: "warning",
            html: true,
            confirmButtonText: "Vou verificar, obrigado!"});
    }
    else {
        $.post('DIM.Gateway.php', {
            'arq': 101,
            'tch': 1,
            'sub': -1,
            'dlg': 0,
            'icl': $('#config_id_cliente option:selected').val()
        }, function (data) {
            $('#DEF-ED-PERS').val(data.DEF_ED_PERS);
            $('#DEF-ED-RCPX').val(data.DEF_ED_RCPX);
            $('#DEF-ED-PDIF').val(data.DEF_ED_PDIF);
            $('#DEF-ED-PREX').val(data.DEF_ED_PREX);
            $('#DEF-ED-FCIL').val(data.DEF_ED_FCIL);
            $('#DEF-ED-RUSE').val(data.DEF_ED_RUSE);
            $('#DEF-ED-PMAT').val(data.DEF_ED_PMAT);
            //PERS
            $('#ED-PERS-XL').val(Number(data.ED_PERS_XL).toFixed(2));
            $('#ED-PERS-VL').val(Number(data.ED_PERS_VL).toFixed(2));
            $('#ED-PERS-LO').val(Number(data.ED_PERS_LO).toFixed(2));
            $('#ED-PERS-NO').val(Number(data.ED_PERS_NO).toFixed(2));
            $('#ED-PERS-HI').val(Number(data.ED_PERS_HI).toFixed(2));
            $('#ED-PERS-VH').val(Number(data.ED_PERS_VH).toFixed(2));
            $('#ED-PERS-EH').val(Number(data.ED_PERS_EH).toFixed(2));
            //RCPX
            $('#ED-RCPX-XL').val(Number(data.ED_RCPX_XL).toFixed(2));
            $('#ED-RCPX-VL').val(Number(data.ED_RCPX_VL).toFixed(2));
            $('#ED-RCPX-LO').val(Number(data.ED_RCPX_LO).toFixed(2));
            $('#ED-RCPX-NO').val(Number(data.ED_RCPX_NO).toFixed(2));
            $('#ED-RCPX-HI').val(Number(data.ED_RCPX_HI).toFixed(2));
            $('#ED-RCPX-VH').val(Number(data.ED_RCPX_VH).toFixed(2));
            $('#ED-RCPX-EH').val(Number(data.ED_RCPX_EH).toFixed(2));
            //PDIF     
            $('#ED-PDIF-LO').val(Number(data.ED_PDIF_LO).toFixed(2));
            $('#ED-PDIF-NO').val(Number(data.ED_PDIF_NO).toFixed(2));
            $('#ED-PDIF-HI').val(Number(data.ED_PDIF_HI).toFixed(2));
            $('#ED-PDIF-VH').val(Number(data.ED_PDIF_VH).toFixed(2));
            $('#ED-PDIF-EH').val(Number(data.ED_PDIF_EH).toFixed(2));
            //PREX     
            $('#ED-PREX-XL').val(Number(data.ED_PREX_XL).toFixed(2));
            $('#ED-PREX-VL').val(Number(data.ED_PREX_VL).toFixed(2));
            $('#ED-PREX-LO').val(Number(data.ED_PREX_LO).toFixed(2));
            $('#ED-PREX-NO').val(Number(data.ED_PREX_NO).toFixed(2));
            $('#ED-PREX-HI').val(Number(data.ED_PREX_HI).toFixed(2));
            $('#ED-PREX-VH').val(Number(data.ED_PREX_VH).toFixed(2));
            $('#ED-PREX-EH').val(Number(data.ED_PREX_EH).toFixed(2));
            //FCIL     
            $('#ED-FCIL-XL').val(Number(data.ED_FCIL_XL).toFixed(2));
            $('#ED-FCIL-VL').val(Number(data.ED_FCIL_VL).toFixed(2));
            $('#ED-FCIL-LO').val(Number(data.ED_FCIL_LO).toFixed(2));
            $('#ED-FCIL-NO').val(Number(data.ED_FCIL_NO).toFixed(2));
            $('#ED-FCIL-HI').val(Number(data.ED_FCIL_HI).toFixed(2));
            $('#ED-FCIL-VH').val(Number(data.ED_FCIL_VH).toFixed(2));
            $('#ED-FCIL-EH').val(Number(data.ED_FCIL_EH).toFixed(2));
            //RUSE     
            $('#ED-RUSE-LO').val(Number(data.ED_RUSE_LO).toFixed(2));
            $('#ED-RUSE-NO').val(Number(data.ED_RUSE_NO).toFixed(2));
            $('#ED-RUSE-HI').val(Number(data.ED_RUSE_HI).toFixed(2));
            $('#ED-RUSE-VH').val(Number(data.ED_RUSE_VH).toFixed(2));
            $('#ED-RUSE-EH').val(Number(data.ED_RUSE_EH).toFixed(2));
            //SCED     
            $('#ED-SCED-VL').val(Number(data.ED_SCED_VL).toFixed(2));
            $('#ED-SCED-LO').val(Number(data.ED_SCED_LO).toFixed(2));
            $('#ED-SCED-NO').val(Number(data.ED_SCED_NO).toFixed(2));
            $('#ED-SCED-HI').val(Number(data.ED_SCED_HI).toFixed(2));
            $('#ED-SCED-VH').val(Number(data.ED_SCED_VH).toFixed(2));
            $('#form_modal_configuracoes_cocomo_projeto_inicial').modal('show');
        }, 'json');
    }
});

$('#cocomo-link-pos-arquitetura').on('click', function () {
    if (Number($('#config_id_cliente option:selected').val()) == 0) {
        swal({
            title: "Alerta",
            text: "Por favor selecione um Cliente",
            type: "warning",
            html: true,
            confirmButtonText: "Vou verificar, obrigado!"});
    }
    else {
        $.post('DIM.Gateway.php', {
            'arq': 101,
            'tch': 1,
            'sub': -1,
            'dlg': 0,
            'icl': $('#config_id_cliente option:selected').val()
        }, function (data) {
            $('#DEF-CPLX-CN').val(data.DEF_CPLX_CN);
            $('#DEF-CPLX-CO').val(data.DEF_CPLX_CO);
            $('#DEF-CPLX-DO').val(data.DEF_CPLX_DO);
            $('#DEF-CPLX-DM').val(data.DEF_CPLX_DM);
            $('#DEF-CPLX-UI').val(data.DEF_CPLX_UI);
            $('#DEF-RELY').val(data.DEF_RELY);
            $('#DEF-DATA').val(data.DEF_DATA);
            $('#DEF-RUSE').val(data.DEF_RUSE);
            $('#DEF-DOCU').val(data.DEF_DOCU);
            $('#DEF-TIME').val(data.DEF_TIME);
            $('#DEF-STOR').val(data.DEF_STOR);
            $('#DEF-PVOL').val(data.DEF_PVOL);
            $('#DEF-ACAP').val(data.DEF_ACAP);
            $('#DEF-PCAP').val(data.DEF_PCAP);
            $('#DEF-PCON').val(data.DEF_PCON);
            $('#DEF-APEX').val(data.DEF_APEX);
            $('#DEF-PLEX').val(data.DEF_PLEX);
            $('#DEF-LTEX').val(data.DEF_LTEX);
            $('#DEF-TOOL').val(data.DEF_TOOL);
            $('#DEF-SITE').val(data.DEF_SITE);
            $('#DEF-SCED').val(data.DEF_SCED);
            $('#CPLX-CN-VL').val(Number(data.CPLX_CN_VL).toFixed(2)); //'0.73',
            $('#CPLX-CN-LO').val(Number(data.CPLX_CN_LO).toFixed(2)); //'0.87',
            $('#CPLX-CN-NO').val(Number(data.CPLX_CN_NO).toFixed(2)); //'1',
            $('#CPLX-CN-HI').val(Number(data.CPLX_CN_HI).toFixed(2)); //'1.17',
            $('#CPLX-CN-VH').val(Number(data.CPLX_CN_VH).toFixed(2)); //'1.34',
            $('#CPLX-CN-EH').val(Number(data.CPLX_CN_EH).toFixed(2)); //'1.74',
            $('#CPLX-CO-VL').val(Number(data.CPLX_CO_VL).toFixed(2)); //'0.73',
            $('#CPLX-CO-LO').val(Number(data.CPLX_CO_LO).toFixed(2)); //'0.87',
            $('#CPLX-CO-NO').val(Number(data.CPLX_CO_NO).toFixed(2)); //'1',
            $('#CPLX-CO-HI').val(Number(data.CPLX_CO_HI).toFixed(2)); //'1.17',
            $('#CPLX-CO-VH').val(Number(data.CPLX_CO_VH).toFixed(2)); //'1.34',
            $('#CPLX-CO-EH').val(Number(data.CPLX_CO_EH).toFixed(2)); //'1.74',
            $('#CPLX-DO-VL').val(Number(data.CPLX_DO_VL).toFixed(2)); //'0.73',
            $('#CPLX-DO-LO').val(Number(data.CPLX_DO_LO).toFixed(2)); //'0.87',
            $('#CPLX-DO-NO').val(Number(data.CPLX_DO_NO).toFixed(2)); //'1',
            $('#CPLX-DO-HI').val(Number(data.CPLX_DO_HI).toFixed(2)); //'1.17',
            $('#CPLX-DO-VH').val(Number(data.CPLX_DO_VH).toFixed(2)); //'1.34',
            $('#CPLX-DO-EH').val(Number(data.CPLX_DO_EH).toFixed(2)); //'1.74',
            $('#CPLX-DM-VL').val(Number(data.CPLX_DM_VL).toFixed(2)); //'0.73',
            $('#CPLX-DM-LO').val(Number(data.CPLX_DM_LO).toFixed(2)); //'0.87',
            $('#CPLX-DM-NO').val(Number(data.CPLX_DM_NO).toFixed(2)); //'1',
            $('#CPLX-DM-HI').val(Number(data.CPLX_DM_HI).toFixed(2)); //'1.17',
            $('#CPLX-DM-VH').val(Number(data.CPLX_DM_VH).toFixed(2)); //'1.34',
            $('#CPLX-DM-EH').val(Number(data.CPLX_DM_EH).toFixed(2)); //'1.74',
            $('#CPLX-UI-VL').val(Number(data.CPLX_UI_VL).toFixed(2)); //'0.73',
            $('#CPLX-UI-LO').val(Number(data.CPLX_UI_LO).toFixed(2)); //'0.87',
            $('#CPLX-UI-NO').val(Number(data.CPLX_UI_NO).toFixed(2)); //'1',
            $('#CPLX-UI-HI').val(Number(data.CPLX_UI_HI).toFixed(2)); //'1.17',
            $('#CPLX-UI-VH').val(Number(data.CPLX_UI_VH).toFixed(2)); //'1.34',
            $('#CPLX-UI-EH').val(Number(data.CPLX_UI_EH).toFixed(2)); //'1.74',
            $('#RELY-VL').val(Number(data.RELY_VL).toFixed(2)); //'0.82',
            $('#RELY-LO').val(Number(data.RELY_LO).toFixed(2)); //'0.92',
            $('#RELY-NO').val(Number(data.RELY_NO).toFixed(2)); //'1',
            $('#RELY-HI').val(Number(data.RELY_HI).toFixed(2)); //'1.1',
            $('#RELY-VH').val(Number(data.RELY_VH).toFixed(2)); //'1.26',
            $('#DATA-LO').val(Number(data.DATA_LO).toFixed(2)); //'0.9',
            $('#DATA-NO').val(Number(data.DATA_NO).toFixed(2)); //'1',
            $('#DATA-HI').val(Number(data.DATA_HI).toFixed(2)); //'1.14',
            $('#DATA-VH').val(Number(data.DATA_VH).toFixed(2)); //'1.28',                
            $('#RUSE-LO').val(Number(data.RUSE_LO).toFixed(2)); //'0.95',
            $('#RUSE-NO').val(Number(data.RUSE_NO).toFixed(2)); //'1',
            $('#RUSE-HI').val(Number(data.RUSE_HI).toFixed(2)); //'1.07',
            $('#RUSE-VH').val(Number(data.RUSE_VH).toFixed(2)); //'1.15',
            $('#RUSE-EH').val(Number(data.RUSE_EH).toFixed(2)); //'1.24',
            $('#DOCU-VL').val(Number(data.DOCU_VL).toFixed(2)); //'0.81',
            $('#DOCU-LO').val(Number(data.DOCU_LO).toFixed(2)); //'0.91',
            $('#DOCU-NO').val(Number(data.DOCU_NO).toFixed(2)); //'1',
            $('#DOCU-HI').val(Number(data.DOCU_HI).toFixed(2)); //'1.11',
            $('#DOCU-VH').val(Number(data.DOCU_VH).toFixed(2)); //'1.23',
            $('#TIME-NO').val(Number(data.TIME_NO).toFixed(2)); //'1',
            $('#TIME-HI').val(Number(data.TIME_HI).toFixed(2)); //'1.11',
            $('#TIME-VH').val(Number(data.TIME_VH).toFixed(2)); //'1.29',
            $('#TIME-EH').val(Number(data.TIME_EH).toFixed(2)); //'1.63',
            $('#STOR-NO').val(Number(data.STOR_NO).toFixed(2)); //'1',
            $('#STOR-HI').val(Number(data.STOR_HI).toFixed(2)); //'1.05',
            $('#STOR-VH').val(Number(data.STOR_VH).toFixed(2)); //'1.17',
            $('#STOR-EH').val(Number(data.STOR_EH).toFixed(2)); //'1.46',
            $('#PVOL-LO').val(Number(data.PVOL_LO).toFixed(2)); //'0.87',
            $('#PVOL-NO').val(Number(data.PVOL_NO).toFixed(2)); //'1',
            $('#PVOL-HI').val(Number(data.PVOL_HI).toFixed(2)); //'1.15',
            $('#PVOL-VH').val(Number(data.PVOL_VH).toFixed(2)); //'1.3',
            $('#ACAP-VL').val(Number(data.ACAP_VL).toFixed(2)); //'1.42',
            $('#ACAP-LO').val(Number(data.ACAP_LO).toFixed(2)); //'1.19',
            $('#ACAP-NO').val(Number(data.ACAP_NO).toFixed(2)); //'1',
            $('#ACAP-HI').val(Number(data.ACAP_HI).toFixed(2)); //'0.85',
            $('#ACAP-VH').val(Number(data.ACAP_VH).toFixed(2)); //'0.71',
            $('#PCAP-VL').val(Number(data.PCAP_VL).toFixed(2)); //'1.34',
            $('#PCAP-LO').val(Number(data.PCAP_LO).toFixed(2)); //'1.15',
            $('#PCAP-NO').val(Number(data.PCAP_NO).toFixed(2)); //'1',
            $('#PCAP-HI').val(Number(data.PCAP_HI).toFixed(2)); //'0.88',
            $('#PCAP-VH').val(Number(data.PCAP_VH).toFixed(2)); //'0.76',
            $('#PCON-VL').val(Number(data.PCON_VL).toFixed(2)); //'1.29',
            $('#PCON-LO').val(Number(data.PCON_LO).toFixed(2)); //'1.12',
            $('#PCON-NO').val(Number(data.PCON_NO).toFixed(2)); //'1',
            $('#PCON-HI').val(Number(data.PCON_HI).toFixed(2)); //'0.9',
            $('#PCON-VH').val(Number(data.PCON_VH).toFixed(2)); //'0.81',
            $('#APEX-VL').val(Number(data.APEX_VL).toFixed(2)); //'1.22',
            $('#APEX-LO').val(Number(data.APEX_LO).toFixed(2)); //'1.1',
            $('#APEX-NO').val(Number(data.APEX_NO).toFixed(2)); //'1',
            $('#APEX-HI').val(Number(data.APEX_HI).toFixed(2)); //'0.88',
            $('#APEX-VH').val(Number(data.APEX_VH).toFixed(2)); //'0.81',
            $('#PLEX-VL').val(Number(data.PLEX_VL).toFixed(2)); //'1.19',
            $('#PLEX-LO').val(Number(data.PLEX_LO).toFixed(2)); //'1.09',
            $('#PLEX-NO').val(Number(data.PLEX_NO).toFixed(2)); //'1',
            $('#PLEX-HI').val(Number(data.PLEX_HI).toFixed(2)); //'0.91',
            $('#PLEX-VH').val(Number(data.PLEX_VH).toFixed(2)); //'0.85',
            $('#LTEX-VL').val(Number(data.LTEX_VL).toFixed(2)); //'1.2',
            $('#LTEX-LO').val(Number(data.LTEX_LO).toFixed(2)); //'1.09',
            $('#LTEX-NO').val(Number(data.LTEX_NO).toFixed(2)); //'1',
            $('#LTEX-HI').val(Number(data.LTEX_HI).toFixed(2)); //'0.91',
            $('#LTEX-VH').val(Number(data.LTEX_VH).toFixed(2)); //'0.84',
            $('#TOOL-VL').val(Number(data.TOOL_VL).toFixed(2)); //'1.17',
            $('#TOOL-LO').val(Number(data.TOOL_LO).toFixed(2)); //'1.09',
            $('#TOOL-NO').val(Number(data.TOOL_NO).toFixed(2)); //'1',
            $('#TOOL-HI').val(Number(data.TOOL_HI).toFixed(2)); //'0.9',
            $('#TOOL-VH').val(Number(data.TOOL_VH).toFixed(2)); //'0.78',
            $('#SITE-VL').val(Number(data.SITE_VL).toFixed(2)); //'1.22',
            $('#SITE-LO').val(Number(data.SITE_LO).toFixed(2)); //'1.09',
            $('#SITE-NO').val(Number(data.SITE_NO).toFixed(2)); //'1',
            $('#SITE-HI').val(Number(data.SITE_HI).toFixed(2)); //'0.93',
            $('#SITE-VH').val(Number(data.SITE_VH).toFixed(2)); //'0.86',
            $('#SITE-EH').val(Number(data.SITE_EH).toFixed(2)); //'0.8',
            $('#SCED-VL').val(Number(data.SCED_VL).toFixed(2)); //'1.43',
            $('#SCED-LO').val(Number(data.SCED_LO).toFixed(2)); //'1.14',
            $('#SCED-NO').val(Number(data.SCED_NO).toFixed(2)); //'1',
            $('#SCED-HI').val(Number(data.SCED_HI).toFixed(2)); //'1',
            $('#SCED-VH').val(Number(data.SCED_VH).toFixed(2)); //'1',            
            $('#form_modal_configuracoes_cocomo_pos_arquitetura').modal('show');
        }, 'json');
    }
});

$('#cocomo-link-fases').on('click', function () {
    if (Number($('#config_id_cliente option:selected').val()) == 0) {
        swal({
            title: "Alerta",
            text: "Por favor selecione um Cliente",
            type: "warning",
            html: true,
            confirmButtonText: "Vou verificar, obrigado!"});
    }
    else {
        $.post('DIM.Gateway.php', {
            'arq': 101,
            'tch': 1,
            'sub': -1,
            'dlg': 0,
            'icl': $('#config_id_cliente option:selected').val()
        }, function (data) {
            $('#rup-inc-sc').val(Number(data.rup_inc_sc).toFixed(2));
            $('#rup-ela-sc').val(Number(data.rup_ela_sc).toFixed(2));
            $('#rup-con-sc').val(Number(data.rup_con_sc).toFixed(2));
            $('#rup-tra-sc').val(Number(data.rup_tra_sc).toFixed(2));
            $('#rup-inc-ef').val(Number(data.rup_inc_ef).toFixed(2));
            $('#rup-ela-ef').val(Number(data.rup_ela_ef).toFixed(2));
            $('#rup-con-ef').val(Number(data.rup_con_ef).toFixed(2));
            $('#rup-tra-ef').val(Number(data.rup_tra_ef).toFixed(2));
            $('#coc-inc-sc').val(Number(data.coc_inc_sc).toFixed(2));
            $('#coc-ela-sc').val(Number(data.coc_ela_sc).toFixed(2));
            $('#coc-con-sc').val(Number(data.coc_con_sc).toFixed(2));
            $('#coc-tra-sc').val(Number(data.coc_tra_sc).toFixed(2));
            $('#coc-inc-ef').val(Number(data.coc_inc_ef).toFixed(2));
            $('#coc-ela-ef').val(Number(data.coc_ela_ef).toFixed(2));
            $('#coc-con-ef').val(Number(data.coc_con_ef).toFixed(2));
            $('#coc-tra-ef').val(Number(data.coc_tra_ef).toFixed(2));
            $('#man-inc').val(Number(data.man_inc).toFixed(2));
            $('#man-ela').val(Number(data.man_ela).toFixed(2));
            $('#man-con').val(Number(data.man_con).toFixed(2));
            $('#man-tra').val(Number(data.man_tra).toFixed(2));
            $('#env-inc').val(Number(data.env_inc).toFixed(2));
            $('#env-ela').val(Number(data.env_ela).toFixed(2));
            $('#env-con').val(Number(data.env_con).toFixed(2));
            $('#env-tra').val(Number(data.env_tra).toFixed(2));
            $('#req-inc').val(Number(data.req_inc).toFixed(2));
            $('#req-ela').val(Number(data.req_ela).toFixed(2));
            $('#req-con').val(Number(data.req_con).toFixed(2));
            $('#req-tra').val(Number(data.req_tra).toFixed(2));
            $('#des-inc').val(Number(data.des_inc).toFixed(2));
            $('#des-ela').val(Number(data.des_ela).toFixed(2));
            $('#des-con').val(Number(data.des_con).toFixed(2));
            $('#des-tra').val(Number(data.des_tra).toFixed(2));
            $('#imp-inc').val(Number(data.imp_inc).toFixed(2));
            $('#imp-ela').val(Number(data.imp_ela).toFixed(2));
            $('#imp-con').val(Number(data.imp_con).toFixed(2));
            $('#imp-tra').val(Number(data.imp_tra).toFixed(2));
            $('#ass-inc').val(Number(data.ass_inc).toFixed(2));
            $('#ass-ela').val(Number(data.ass_ela).toFixed(2));
            $('#ass-con').val(Number(data.ass_con).toFixed(2));
            $('#ass-tra').val(Number(data.ass_tra).toFixed(2));
            $('#dep-inc').val(Number(data.dep_inc).toFixed(2));
            $('#dep-ela').val(Number(data.dep_ela).toFixed(2));
            $('#dep-con').val(Number(data.dep_con).toFixed(2));
            $('#dep-tra').val(Number(data.dep_tra).toFixed(2));
            somaFases();
            $('#form_modal_configuracoes_cocomo_fases').modal('show');
        }, 'json');
    }
});

$('#cocomo-link-linguagem').on('click', function () {
    if (Number($('#config_id_cliente option:selected').val()) == 0) {
        swal({
            title: "Alerta",
            text: "Por favor selecione um Cliente",
            type: "warning",
            html: true,
            confirmButtonText: "Vou verificar, obrigado!"});
    }
    else {
        $('#form_modal_configuracoes_cocomo_linguagem').modal('show');
    }
});
/*
 * para os spins do cocomo ii.2000
 */
$("input[name='touch-cocomo']").on('change', function () {
    if (isFornecedor) {
        swal({
            title: "Alerta",
            text: "Voc&ecirc; est&aacute; logado como um Fornecedor, as altera&ccedil;&otilde;es ser&atilde;o descartadas.",
            type: "warning",
            html: true,
            confirmButtonText: "Ok, obrigado!"});
    }
    else {
        idc = $(this).get(0).id;
        vlu = $(this).val();
        $.post('DIM.Gateway.php', {
            'arq': 76,
            'tch': 0,
            'sub': 0,
            'dlg': 1,
            'idc': idc,
            'vlu': vlu,
            'icl': $('#config_id_cliente option:selected').val()
        }, function (data) {
            somaFases();
        }, 'json');
        $(this).val(Number($(this).val()).toFixed(2));
    }
}).TouchSpin({
    verticalbuttons: true,
    step: 0.01,
    decimals: 2,
    forcestepdivisibility: 'none',
    verticalupclass: 'glyphicon glyphicon-plus',
    verticaldownclass: 'glyphicon glyphicon-minus'
});

$("input[name='touch-cocomo']").attr('maxlength', '5').mask("#.##0.00", {reverse: true});

/*
 * para os selects default
 */
/*
 * para os spins do cocomo ii.2000
 */
$("select[name='sel-cocomo']").on('change', function () {
    if (isFornecedor) {
        swal({
            title: "Alerta",
            text: "Voc&ecirc; est&aacute; logado como um Fornecedor, as altera&ccedil;&otilde;es ser&atilde;o descartadas.",
            type: "warning",
            html: true,
            confirmButtonText: "Ok, obrigado!"});
    }
    else {
        idc = $(this).get(0).id;
        vlu = $(this).val();
        $.post('DIM.Gateway.php', {
            'arq': 76,
            'tch': 0,
            'sub': 0,
            'dlg': 1,
            'idc': idc,
            'vlu': vlu,
            'icl': $('#config_id_cliente option:selected').val()
        }, function (data) {

        }, 'json');
    }
});

function somaFases() {
    var rup_sc = Number($('#rup-inc-sc').val()) +
            Number($('#rup-ela-sc').val()) +
            Number($('#rup-con-sc').val()) +
            Number($('#rup-tra-sc').val());
    $('#total-rup-sc').val(Number(rup_sc).toFixed(2));

    var rup_ef = Number($('#rup-inc-ef').val()) +
            Number($('#rup-ela-ef').val()) +
            Number($('#rup-con-ef').val()) +
            Number($('#rup-tra-ef').val());
    $('#total-rup-ef').val(Number(rup_ef).toFixed(2));

    var coc_sc = Number($('#coc-inc-sc').val()) +
            Number($('#coc-ela-sc').val()) +
            Number($('#coc-con-sc').val()) +
            Number($('#coc-tra-sc').val());
    $('#total-coc-sc').val(Number(coc_sc).toFixed(2));

    var coc_ef = Number($('#coc-inc-ef').val()) +
            Number($('#coc-ela-ef').val()) +
            Number($('#coc-con-ef').val()) +
            Number($('#coc-tra-ef').val());
    $('#total-coc-ef').val(Number(coc_ef).toFixed(2));

    var tot_inc = Number($('#man-inc').val()) +
            Number($('#env-inc').val()) +
            Number($('#req-inc').val()) +
            Number($('#des-inc').val()) +
            Number($('#imp-inc').val()) +
            Number($('#ass-inc').val()) +
            Number($('#dep-inc').val());
    $('#total-inc').val(Number(tot_inc).toFixed(2));

    var tot_ela = Number($('#man-ela').val()) +
            Number($('#env-ela').val()) +
            Number($('#req-ela').val()) +
            Number($('#des-ela').val()) +
            Number($('#imp-ela').val()) +
            Number($('#ass-ela').val()) +
            Number($('#dep-ela').val());
    $('#total-ela').val(Number(tot_ela).toFixed(2));

    var tot_con = Number($('#man-con').val()) +
            Number($('#env-con').val()) +
            Number($('#req-con').val()) +
            Number($('#des-con').val()) +
            Number($('#imp-con').val()) +
            Number($('#ass-con').val()) +
            Number($('#dep-con').val());
    $('#total-con').val(Number(tot_con).toFixed(2));

    var tot_tra = Number($('#man-tra').val()) +
            Number($('#env-tra').val()) +
            Number($('#req-tra').val()) +
            Number($('#des-tra').val()) +
            Number($('#imp-tra').val()) +
            Number($('#ass-tra').val()) +
            Number($('#dep-tra').val());
    $('#total-tra').val(Number(tot_tra).toFixed(2));

}