<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verificacao do status do login
 */
require_once 'CRUD.php';

class ContagemEstatisticasCocomo extends CRUD {

    public function __construct() {
        $this->setTable('contagem_estatisticas_cocomo');
        $this->setLog();
    }

    public function insere() {
        $stm = DB::prepare("INSERT INTO $this->table ("
                        . "id_contagem,"
                        . "COCOMO_A,"
                        . "COCOMO_B,"
                        . "COCOMO_C,"
                        . "COCOMO_D,"
                        . "ED_PERS,"
                        . "ED_RCPX,"
                        . "ED_PDIF,"
                        . "ED_PREX,"
                        . "ED_FCIL,"
                        . "ED_RUSE,"
                        . "ED_SCED,"
                        . "PREC,"
                        . "FLEX,"
                        . "RESL,"
                        . "TEAM,"
                        . "PMAT,"
                        . "RELY,"
                        . "DATA,"
                        . "CPLX_CN,"
                        . "CPLX_CO,"
                        . "CPLX_DO,"
                        . "CPLX_DM,"
                        . "CPLX_UI,"
                        . "CPLX,"
                        . "RUSE,"
                        . "DOCU,"
                        . "TIME,"
                        . "STOR,"
                        . "PVOL,"
                        . "ACAP,"
                        . "PCAP,"
                        . "PCON,"
                        . "APEX,"
                        . "PLEX,"
                        . "LTEX,"
                        . "TOOL,"
                        . "SITE,"
                        . "SCED,"
                        . "PREC_VL,"
                        . "PREC_LO,"
                        . "PREC_NO,"
                        . "PREC_HI,"
                        . "PREC_VH,"
                        . "PREC_EH,"
                        . "FLEX_VL,"
                        . "FLEX_LO,"
                        . "FLEX_NO,"
                        . "FLEX_HI,"
                        . "FLEX_VH,"
                        . "FLEX_EH,"
                        . "RESL_VL,"
                        . "RESL_LO,"
                        . "RESL_NO,"
                        . "RESL_HI,"
                        . "RESL_VH,"
                        . "RESL_EH,"
                        . "TEAM_VL,"
                        . "TEAM_LO,"
                        . "TEAM_NO,"
                        . "TEAM_HI,"
                        . "TEAM_VH,"
                        . "TEAM_EH,"
                        . "PMAT_VL,"
                        . "PMAT_LO,"
                        . "PMAT_NO,"
                        . "PMAT_HI,"
                        . "PMAT_VH,"
                        . "PMAT_EH,"
                        . "RELY_VL,"
                        . "RELY_LO,"
                        . "RELY_NO,"
                        . "RELY_HI,"
                        . "RELY_VH,"
                        . "DATA_LO,"
                        . "DATA_NO,"
                        . "DATA_HI,"
                        . "DATA_VH,"
                        . "CPLX_CN_VL,"
                        . "CPLX_CN_LO,"
                        . "CPLX_CN_NO,"
                        . "CPLX_CN_HI,"
                        . "CPLX_CN_VH,"
                        . "CPLX_CN_EH,"
                        . "CPLX_CO_VL,"
                        . "CPLX_CO_LO,"
                        . "CPLX_CO_NO,"
                        . "CPLX_CO_HI,"
                        . "CPLX_CO_VH,"
                        . "CPLX_CO_EH,"
                        . "CPLX_DO_VL,"
                        . "CPLX_DO_LO,"
                        . "CPLX_DO_NO,"
                        . "CPLX_DO_HI,"
                        . "CPLX_DO_VH,"
                        . "CPLX_DO_EH,"
                        . "CPLX_DM_VL,"
                        . "CPLX_DM_LO,"
                        . "CPLX_DM_NO,"
                        . "CPLX_DM_HI,"
                        . "CPLX_DM_VH,"
                        . "CPLX_DM_EH,"
                        . "CPLX_UI_VL,"
                        . "CPLX_UI_LO,"
                        . "CPLX_UI_NO,"
                        . "CPLX_UI_HI,"
                        . "CPLX_UI_VH,"
                        . "CPLX_UI_EH,"
                        . "CPLX_VL,"
                        . "CPLX_LO,"
                        . "CPLX_NO,"
                        . "CPLX_HI,"
                        . "CPLX_VH,"
                        . "CPLX_EH,"
                        . "RUSE_LO,"
                        . "RUSE_NO,"
                        . "RUSE_HI,"
                        . "RUSE_VH,"
                        . "RUSE_EH,"
                        . "DOCU_VL,"
                        . "DOCU_LO,"
                        . "DOCU_NO,"
                        . "DOCU_HI,"
                        . "DOCU_VH,"
                        . "TIME_NO,"
                        . "TIME_HI,"
                        . "TIME_VH,"
                        . "TIME_EH,"
                        . "STOR_NO,"
                        . "STOR_HI,"
                        . "STOR_VH,"
                        . "STOR_EH,"
                        . "PVOL_LO,"
                        . "PVOL_NO,"
                        . "PVOL_HI,"
                        . "PVOL_VH,"
                        . "ACAP_VL,"
                        . "ACAP_LO,"
                        . "ACAP_NO,"
                        . "ACAP_HI,"
                        . "ACAP_VH,"
                        . "PCAP_VL,"
                        . "PCAP_LO,"
                        . "PCAP_NO,"
                        . "PCAP_HI,"
                        . "PCAP_VH,"
                        . "PCON_VL,"
                        . "PCON_LO,"
                        . "PCON_NO,"
                        . "PCON_HI,"
                        . "PCON_VH,"
                        . "APEX_VL,"
                        . "APEX_LO,"
                        . "APEX_NO,"
                        . "APEX_HI,"
                        . "APEX_VH,"
                        . "PLEX_VL,"
                        . "PLEX_LO,"
                        . "PLEX_NO,"
                        . "PLEX_HI,"
                        . "PLEX_VH,"
                        . "LTEX_VL,"
                        . "LTEX_LO,"
                        . "LTEX_NO,"
                        . "LTEX_HI,"
                        . "LTEX_VH,"
                        . "TOOL_VL,"
                        . "TOOL_LO,"
                        . "TOOL_NO,"
                        . "TOOL_HI,"
                        . "TOOL_VH,"
                        . "SITE_VL,"
                        . "SITE_LO,"
                        . "SITE_NO,"
                        . "SITE_HI,"
                        . "SITE_VH,"
                        . "SITE_EH,"
                        . "SCED_VL,"
                        . "SCED_LO,"
                        . "SCED_NO,"
                        . "SCED_HI,"
                        . "SCED_VH,"
                        . "ED_PERS_XL,"
                        . "ED_PERS_VL,"
                        . "ED_PERS_LO,"
                        . "ED_PERS_NO,"
                        . "ED_PERS_HI,"
                        . "ED_PERS_VH,"
                        . "ED_PERS_EH,"
                        . "ED_RCPX_XL,"
                        . "ED_RCPX_VL,"
                        . "ED_RCPX_LO,"
                        . "ED_RCPX_NO,"
                        . "ED_RCPX_HI,"
                        . "ED_RCPX_VH,"
                        . "ED_RCPX_EH,"
                        . "ED_PDIF_LO,"
                        . "ED_PDIF_NO,"
                        . "ED_PDIF_HI,"
                        . "ED_PDIF_VH,"
                        . "ED_PDIF_EH,"
                        . "ED_PREX_XL,"
                        . "ED_PREX_VL,"
                        . "ED_PREX_LO,"
                        . "ED_PREX_NO,"
                        . "ED_PREX_HI,"
                        . "ED_PREX_VH,"
                        . "ED_PREX_EH,"
                        . "ED_FCIL_XL,"
                        . "ED_FCIL_VL,"
                        . "ED_FCIL_LO,"
                        . "ED_FCIL_NO,"
                        . "ED_FCIL_HI,"
                        . "ED_FCIL_VH,"
                        . "ED_FCIL_EH,"
                        . "ED_RUSE_LO,"
                        . "ED_RUSE_NO,"
                        . "ED_RUSE_HI,"
                        . "ED_RUSE_VH,"
                        . "ED_RUSE_EH,"
                        . "ED_SCED_VL,"
                        . "ED_SCED_LO,"
                        . "ED_SCED_NO,"
                        . "ED_SCED_HI,"
                        . "ED_SCED_VH,"
                        . "esforco,"
                        . "cronograma,"
                        . "custo,"
                        . "custo_pessoa,"
                        . "sloc,"
                        . "tipo_calculo,"
                        . "rup_inc_ef,"
                        . "rup_inc_sc,"
                        . "rup_ela_ef,"
                        . "rup_ela_sc,"
                        . "rup_con_ef,"
                        . "rup_con_sc,"
                        . "rup_tra_ef,"
                        . "rup_tra_sc,"
                        . "coc_inc_ef,"
                        . "coc_inc_sc,"
                        . "coc_ela_ef,"
                        . "coc_ela_sc,"
                        . "coc_con_ef,"
                        . "coc_con_sc,"
                        . "coc_tra_ef,"
                        . "coc_tra_sc,"
                        . "man_inc,"
                        . "man_ela,"
                        . "man_con,"
                        . "man_tra,"
                        . "env_inc,"
                        . "env_ela,"
                        . "env_con,"
                        . "env_tra,"
                        . "req_inc,"
                        . "req_ela,"
                        . "req_con,"
                        . "req_tra,"
                        . "des_inc,"
                        . "des_ela,"
                        . "des_con,"
                        . "des_tra,"
                        . "imp_inc,"
                        . "imp_ela,"
                        . "imp_con,"
                        . "imp_tra,"
                        . "ass_inc,"
                        . "ass_ela,"
                        . "ass_con,"
                        . "ass_tra,"
                        . "dep_inc,"
                        . "dep_ela,"
                        . "dep_con,"
                        . "dep_tra"
                        . ") VALUES ("
                        . ":idContagem,"
                        . ":COCOMO_A,"
                        . ":COCOMO_B,"
                        . ":COCOMO_C,"
                        . ":COCOMO_D,"
                        . ":ED_PERS,"
                        . ":ED_RCPX,"
                        . ":ED_PDIF,"
                        . ":ED_PREX,"
                        . ":ED_FCIL,"
                        . ":ED_RUSE,"
                        . ":ED_SCED,"
                        . ":PREC,"
                        . ":FLEX,"
                        . ":RESL,"
                        . ":TEAM,"
                        . ":PMAT,"
                        . ":RELY,"
                        . ":DATA,"
                        . ":CPLX_CN,"
                        . ":CPLX_CO,"
                        . ":CPLX_DO,"
                        . ":CPLX_DM,"
                        . ":CPLX_UI,"
                        . ":CPLX,"
                        . ":RUSE,"
                        . ":DOCU,"
                        . ":TIME,"
                        . ":STOR,"
                        . ":PVOL,"
                        . ":ACAP,"
                        . ":PCAP,"
                        . ":PCON,"
                        . ":APEX,"
                        . ":PLEX,"
                        . ":LTEX,"
                        . ":TOOL,"
                        . ":SITE,"
                        . ":SCED,"
                        . ":PREC_VL,"
                        . ":PREC_LO,"
                        . ":PREC_NO,"
                        . ":PREC_HI,"
                        . ":PREC_VH,"
                        . ":PREC_EH,"
                        . ":FLEX_VL,"
                        . ":FLEX_LO,"
                        . ":FLEX_NO,"
                        . ":FLEX_HI,"
                        . ":FLEX_VH,"
                        . ":FLEX_EH,"
                        . ":RESL_VL,"
                        . ":RESL_LO,"
                        . ":RESL_NO,"
                        . ":RESL_HI,"
                        . ":RESL_VH,"
                        . ":RESL_EH,"
                        . ":TEAM_VL,"
                        . ":TEAM_LO,"
                        . ":TEAM_NO,"
                        . ":TEAM_HI,"
                        . ":TEAM_VH,"
                        . ":TEAM_EH,"
                        . ":PMAT_VL,"
                        . ":PMAT_LO,"
                        . ":PMAT_NO,"
                        . ":PMAT_HI,"
                        . ":PMAT_VH,"
                        . ":PMAT_EH,"
                        . ":RELY_VL,"
                        . ":RELY_LO,"
                        . ":RELY_NO,"
                        . ":RELY_HI,"
                        . ":RELY_VH,"
                        . ":DATA_LO,"
                        . ":DATA_NO,"
                        . ":DATA_HI,"
                        . ":DATA_VH,"
                        . ":CPLX_CN_VL,"
                        . ":CPLX_CN_LO,"
                        . ":CPLX_CN_NO,"
                        . ":CPLX_CN_HI,"
                        . ":CPLX_CN_VH,"
                        . ":CPLX_CN_EH,"
                        . ":CPLX_CO_VL,"
                        . ":CPLX_CO_LO,"
                        . ":CPLX_CO_NO,"
                        . ":CPLX_CO_HI,"
                        . ":CPLX_CO_VH,"
                        . ":CPLX_CO_EH,"
                        . ":CPLX_DO_VL,"
                        . ":CPLX_DO_LO,"
                        . ":CPLX_DO_NO,"
                        . ":CPLX_DO_HI,"
                        . ":CPLX_DO_VH,"
                        . ":CPLX_DO_EH,"
                        . ":CPLX_DM_VL,"
                        . ":CPLX_DM_LO,"
                        . ":CPLX_DM_NO,"
                        . ":CPLX_DM_HI,"
                        . ":CPLX_DM_VH,"
                        . ":CPLX_DM_EH,"
                        . ":CPLX_UI_VL,"
                        . ":CPLX_UI_LO,"
                        . ":CPLX_UI_NO,"
                        . ":CPLX_UI_HI,"
                        . ":CPLX_UI_VH,"
                        . ":CPLX_UI_EH,"
                        . ":CPLX_VL,"
                        . ":CPLX_LO,"
                        . ":CPLX_NO,"
                        . ":CPLX_HI,"
                        . ":CPLX_VH,"
                        . ":CPLX_EH,"
                        . ":RUSE_LO,"
                        . ":RUSE_NO,"
                        . ":RUSE_HI,"
                        . ":RUSE_VH,"
                        . ":RUSE_EH,"
                        . ":DOCU_VL,"
                        . ":DOCU_LO,"
                        . ":DOCU_NO,"
                        . ":DOCU_HI,"
                        . ":DOCU_VH,"
                        . ":TIME_NO,"
                        . ":TIME_HI,"
                        . ":TIME_VH,"
                        . ":TIME_EH,"
                        . ":STOR_NO,"
                        . ":STOR_HI,"
                        . ":STOR_VH,"
                        . ":STOR_EH,"
                        . ":PVOL_LO,"
                        . ":PVOL_NO,"
                        . ":PVOL_HI,"
                        . ":PVOL_VH,"
                        . ":ACAP_VL,"
                        . ":ACAP_LO,"
                        . ":ACAP_NO,"
                        . ":ACAP_HI,"
                        . ":ACAP_VH,"
                        . ":PCAP_VL,"
                        . ":PCAP_LO,"
                        . ":PCAP_NO,"
                        . ":PCAP_HI,"
                        . ":PCAP_VH,"
                        . ":PCON_VL,"
                        . ":PCON_LO,"
                        . ":PCON_NO,"
                        . ":PCON_HI,"
                        . ":PCON_VH,"
                        . ":APEX_VL,"
                        . ":APEX_LO,"
                        . ":APEX_NO,"
                        . ":APEX_HI,"
                        . ":APEX_VH,"
                        . ":PLEX_VL,"
                        . ":PLEX_LO,"
                        . ":PLEX_NO,"
                        . ":PLEX_HI,"
                        . ":PLEX_VH,"
                        . ":LTEX_VL,"
                        . ":LTEX_LO,"
                        . ":LTEX_NO,"
                        . ":LTEX_HI,"
                        . ":LTEX_VH,"
                        . ":TOOL_VL,"
                        . ":TOOL_LO,"
                        . ":TOOL_NO,"
                        . ":TOOL_HI,"
                        . ":TOOL_VH,"
                        . ":SITE_VL,"
                        . ":SITE_LO,"
                        . ":SITE_NO,"
                        . ":SITE_HI,"
                        . ":SITE_VH,"
                        . ":SITE_EH,"
                        . ":SCED_VL,"
                        . ":SCED_LO,"
                        . ":SCED_NO,"
                        . ":SCED_HI,"
                        . ":SCED_VH,"
                        . ":ED_PERS_XL,"
                        . ":ED_PERS_VL,"
                        . ":ED_PERS_LO,"
                        . ":ED_PERS_NO,"
                        . ":ED_PERS_HI,"
                        . ":ED_PERS_VH,"
                        . ":ED_PERS_EH,"
                        . ":ED_RCPX_XL,"
                        . ":ED_RCPX_VL,"
                        . ":ED_RCPX_LO,"
                        . ":ED_RCPX_NO,"
                        . ":ED_RCPX_HI,"
                        . ":ED_RCPX_VH,"
                        . ":ED_RCPX_EH,"
                        . ":ED_PDIF_LO,"
                        . ":ED_PDIF_NO,"
                        . ":ED_PDIF_HI,"
                        . ":ED_PDIF_VH,"
                        . ":ED_PDIF_EH,"
                        . ":ED_PREX_XL,"
                        . ":ED_PREX_VL,"
                        . ":ED_PREX_LO,"
                        . ":ED_PREX_NO,"
                        . ":ED_PREX_HI,"
                        . ":ED_PREX_VH,"
                        . ":ED_PREX_EH,"
                        . ":ED_FCIL_XL,"
                        . ":ED_FCIL_VL,"
                        . ":ED_FCIL_LO,"
                        . ":ED_FCIL_NO,"
                        . ":ED_FCIL_HI,"
                        . ":ED_FCIL_VH,"
                        . ":ED_FCIL_EH,"
                        . ":ED_RUSE_LO,"
                        . ":ED_RUSE_NO,"
                        . ":ED_RUSE_HI,"
                        . ":ED_RUSE_VH,"
                        . ":ED_RUSE_EH,"
                        . ":ED_SCED_VL,"
                        . ":ED_SCED_LO,"
                        . ":ED_SCED_NO,"
                        . ":ED_SCED_HI,"
                        . ":ED_SCED_VH,"
                        . ":esforco,"
                        . ":cronograma,"
                        . ":custo,"
                        . ":custo_pessoa,"
                        . ":sloc,"
                        . ":tipo_calculo,"
                        . ":rup_inc_ef,"
                        . ":rup_inc_sc,"
                        . ":rup_ela_ef,"
                        . ":rup_ela_sc,"
                        . ":rup_con_ef,"
                        . ":rup_con_sc,"
                        . ":rup_tra_ef,"
                        . ":rup_tra_sc,"
                        . ":coc_inc_ef,"
                        . ":coc_inc_sc,"
                        . ":coc_ela_ef,"
                        . ":coc_ela_sc,"
                        . ":coc_con_ef,"
                        . ":coc_con_sc,"
                        . ":coc_tra_ef,"
                        . ":coc_tra_sc,"
                        . ":man_inc,"
                        . ":man_ela,"
                        . ":man_con,"
                        . ":man_tra,"
                        . ":env_inc,"
                        . ":env_ela,"
                        . ":env_con,"
                        . ":env_tra,"
                        . ":req_inc,"
                        . ":req_ela,"
                        . ":req_con,"
                        . ":req_tra,"
                        . ":des_inc,"
                        . ":des_ela,"
                        . ":des_con,"
                        . ":des_tra,"
                        . ":imp_inc,"
                        . ":imp_ela,"
                        . ":imp_con,"
                        . ":imp_tra,"
                        . ":ass_inc,"
                        . ":ass_ela,"
                        . ":ass_con,"
                        . ":ass_tra,"
                        . ":dep_inc,"
                        . ":dep_ela,"
                        . ":dep_con,"
                        . ":dep_tra"
                        . ")");
        $stm->bindParam(':idContagem', $this->idContagem, PDO::PARAM_INT);
        $stm->bindParam(':COCOMO_A', $this->COCOMO_A);
        $stm->bindParam(':COCOMO_B', $this->COCOMO_B);
        $stm->bindParam(':COCOMO_C', $this->COCOMO_C);
        $stm->bindParam(':COCOMO_D', $this->COCOMO_D);
        $stm->bindParam(':ED_PERS', $this->ED_PERS);
        $stm->bindParam(':ED_RCPX', $this->ED_RCPX);
        $stm->bindParam(':ED_PDIF', $this->ED_PDIF);
        $stm->bindParam(':ED_PREX', $this->ED_PREX);
        $stm->bindParam(':ED_FCIL', $this->ED_FCIL);
        $stm->bindParam(':ED_RUSE', $this->ED_RUSE);
        $stm->bindParam(':ED_SCED', $this->ED_SCED);
        $stm->bindParam(':PREC', $this->PREC);
        $stm->bindParam(':FLEX', $this->FLEX);
        $stm->bindParam(':RESL', $this->RESL);
        $stm->bindParam(':TEAM', $this->TEAM);
        $stm->bindParam(':PMAT', $this->PMAT);
        $stm->bindParam(':RELY', $this->RELY);
        $stm->bindParam(':DATA', $this->DATA);
        $stm->bindParam(':CPLX_CN', $this->CPLX_CN);
        $stm->bindParam(':CPLX_CO', $this->CPLX_CO);
        $stm->bindParam(':CPLX_DO', $this->CPLX_DO);
        $stm->bindParam(':CPLX_DM', $this->CPLX_DM);
        $stm->bindParam(':CPLX_UI', $this->CPLX_UI);
        $stm->bindParam(':CPLX', $this->CPLX);
        $stm->bindParam(':RUSE', $this->RUSE);
        $stm->bindParam(':DOCU', $this->DOCU);
        $stm->bindParam(':TIME', $this->TIME);
        $stm->bindParam(':STOR', $this->STOR);
        $stm->bindParam(':PVOL', $this->PVOL);
        $stm->bindParam(':ACAP', $this->ACAP);
        $stm->bindParam(':PCAP', $this->PCAP);
        $stm->bindParam(':PCON', $this->PCON);
        $stm->bindParam(':APEX', $this->APEX);
        $stm->bindParam(':PLEX', $this->PLEX);
        $stm->bindParam(':LTEX', $this->LTEX);
        $stm->bindParam(':TOOL', $this->TOOL);
        $stm->bindParam(':SITE', $this->SITE);
        $stm->bindParam(':SCED', $this->SCED);
        $stm->bindParam(':PREC_VL', $this->PREC_VL);
        $stm->bindParam(':PREC_LO', $this->PREC_LO);
        $stm->bindParam(':PREC_NO', $this->PREC_NO);
        $stm->bindParam(':PREC_HI', $this->PREC_HI);
        $stm->bindParam(':PREC_VH', $this->PREC_VH);
        $stm->bindParam(':PREC_EH', $this->PREC_EH);
        $stm->bindParam(':FLEX_VL', $this->FLEX_VL);
        $stm->bindParam(':FLEX_LO', $this->FLEX_LO);
        $stm->bindParam(':FLEX_NO', $this->FLEX_NO);
        $stm->bindParam(':FLEX_HI', $this->FLEX_HI);
        $stm->bindParam(':FLEX_VH', $this->FLEX_VH);
        $stm->bindParam(':FLEX_EH', $this->FLEX_EH);
        $stm->bindParam(':RESL_VL', $this->RESL_VL);
        $stm->bindParam(':RESL_LO', $this->RESL_LO);
        $stm->bindParam(':RESL_NO', $this->RESL_NO);
        $stm->bindParam(':RESL_HI', $this->RESL_HI);
        $stm->bindParam(':RESL_VH', $this->RESL_VH);
        $stm->bindParam(':RESL_EH', $this->RESL_EH);
        $stm->bindParam(':TEAM_VL', $this->TEAM_VL);
        $stm->bindParam(':TEAM_LO', $this->TEAM_LO);
        $stm->bindParam(':TEAM_NO', $this->TEAM_NO);
        $stm->bindParam(':TEAM_HI', $this->TEAM_HI);
        $stm->bindParam(':TEAM_VH', $this->TEAM_VH);
        $stm->bindParam(':TEAM_EH', $this->TEAM_EH);
        $stm->bindParam(':PMAT_VL', $this->PMAT_VL);
        $stm->bindParam(':PMAT_LO', $this->PMAT_LO);
        $stm->bindParam(':PMAT_NO', $this->PMAT_NO);
        $stm->bindParam(':PMAT_HI', $this->PMAT_HI);
        $stm->bindParam(':PMAT_VH', $this->PMAT_VH);
        $stm->bindParam(':PMAT_EH', $this->PMAT_EH);
        $stm->bindParam(':RELY_VL', $this->RELY_VL);
        $stm->bindParam(':RELY_LO', $this->RELY_LO);
        $stm->bindParam(':RELY_NO', $this->RELY_NO);
        $stm->bindParam(':RELY_HI', $this->RELY_HI);
        $stm->bindParam(':RELY_VH', $this->RELY_VH);
        $stm->bindParam(':DATA_LO', $this->DATA_LO);
        $stm->bindParam(':DATA_NO', $this->DATA_NO);
        $stm->bindParam(':DATA_HI', $this->DATA_HI);
        $stm->bindParam(':DATA_VH', $this->DATA_VH);
        $stm->bindParam(':CPLX_CN_VL', $this->CPLX_CN_VL);
        $stm->bindParam(':CPLX_CN_LO', $this->CPLX_CN_LO);
        $stm->bindParam(':CPLX_CN_NO', $this->CPLX_CN_NO);
        $stm->bindParam(':CPLX_CN_HI', $this->CPLX_CN_HI);
        $stm->bindParam(':CPLX_CN_VH', $this->CPLX_CN_VH);
        $stm->bindParam(':CPLX_CN_EH', $this->CPLX_CN_EH);
        $stm->bindParam(':CPLX_CO_VL', $this->CPLX_CO_VL);
        $stm->bindParam(':CPLX_CO_LO', $this->CPLX_CO_LO);
        $stm->bindParam(':CPLX_CO_NO', $this->CPLX_CO_NO);
        $stm->bindParam(':CPLX_CO_HI', $this->CPLX_CO_HI);
        $stm->bindParam(':CPLX_CO_VH', $this->CPLX_CO_VH);
        $stm->bindParam(':CPLX_CO_EH', $this->CPLX_CO_EH);
        $stm->bindParam(':CPLX_DO_VL', $this->CPLX_DO_VL);
        $stm->bindParam(':CPLX_DO_LO', $this->CPLX_DO_LO);
        $stm->bindParam(':CPLX_DO_NO', $this->CPLX_DO_NO);
        $stm->bindParam(':CPLX_DO_HI', $this->CPLX_DO_HI);
        $stm->bindParam(':CPLX_DO_VH', $this->CPLX_DO_VH);
        $stm->bindParam(':CPLX_DO_EH', $this->CPLX_DO_EH);
        $stm->bindParam(':CPLX_DM_VL', $this->CPLX_DM_VL);
        $stm->bindParam(':CPLX_DM_LO', $this->CPLX_DM_LO);
        $stm->bindParam(':CPLX_DM_NO', $this->CPLX_DM_NO);
        $stm->bindParam(':CPLX_DM_HI', $this->CPLX_DM_HI);
        $stm->bindParam(':CPLX_DM_VH', $this->CPLX_DM_VH);
        $stm->bindParam(':CPLX_DM_EH', $this->CPLX_DM_EH);
        $stm->bindParam(':CPLX_UI_VL', $this->CPLX_UI_VL);
        $stm->bindParam(':CPLX_UI_LO', $this->CPLX_UI_LO);
        $stm->bindParam(':CPLX_UI_NO', $this->CPLX_UI_NO);
        $stm->bindParam(':CPLX_UI_HI', $this->CPLX_UI_HI);
        $stm->bindParam(':CPLX_UI_VH', $this->CPLX_UI_VH);
        $stm->bindParam(':CPLX_UI_EH', $this->CPLX_UI_EH);
        $stm->bindParam(':CPLX_VL', $this->CPLX_VL);
        $stm->bindParam(':CPLX_LO', $this->CPLX_LO);
        $stm->bindParam(':CPLX_NO', $this->CPLX_NO);
        $stm->bindParam(':CPLX_HI', $this->CPLX_HI);
        $stm->bindParam(':CPLX_VH', $this->CPLX_VH);
        $stm->bindParam(':CPLX_EH', $this->CPLX_EH);
        $stm->bindParam(':RUSE_LO', $this->RUSE_LO);
        $stm->bindParam(':RUSE_NO', $this->RUSE_NO);
        $stm->bindParam(':RUSE_HI', $this->RUSE_HI);
        $stm->bindParam(':RUSE_VH', $this->RUSE_VH);
        $stm->bindParam(':RUSE_EH', $this->RUSE_EH);
        $stm->bindParam(':DOCU_VL', $this->DOCU_VL);
        $stm->bindParam(':DOCU_LO', $this->DOCU_LO);
        $stm->bindParam(':DOCU_NO', $this->DOCU_NO);
        $stm->bindParam(':DOCU_HI', $this->DOCU_HI);
        $stm->bindParam(':DOCU_VH', $this->DOCU_VH);
        $stm->bindParam(':TIME_NO', $this->TIME_NO);
        $stm->bindParam(':TIME_HI', $this->TIME_HI);
        $stm->bindParam(':TIME_VH', $this->TIME_VH);
        $stm->bindParam(':TIME_EH', $this->TIME_EH);
        $stm->bindParam(':STOR_NO', $this->STOR_NO);
        $stm->bindParam(':STOR_HI', $this->STOR_HI);
        $stm->bindParam(':STOR_VH', $this->STOR_VH);
        $stm->bindParam(':STOR_EH', $this->STOR_EH);
        $stm->bindParam(':PVOL_LO', $this->PVOL_LO);
        $stm->bindParam(':PVOL_NO', $this->PVOL_NO);
        $stm->bindParam(':PVOL_HI', $this->PVOL_HI);
        $stm->bindParam(':PVOL_VH', $this->PVOL_VH);
        $stm->bindParam(':ACAP_VL', $this->ACAP_VL);
        $stm->bindParam(':ACAP_LO', $this->ACAP_LO);
        $stm->bindParam(':ACAP_NO', $this->ACAP_NO);
        $stm->bindParam(':ACAP_HI', $this->ACAP_HI);
        $stm->bindParam(':ACAP_VH', $this->ACAP_VH);
        $stm->bindParam(':PCAP_VL', $this->PCAP_VL);
        $stm->bindParam(':PCAP_LO', $this->PCAP_LO);
        $stm->bindParam(':PCAP_NO', $this->PCAP_NO);
        $stm->bindParam(':PCAP_HI', $this->PCAP_HI);
        $stm->bindParam(':PCAP_VH', $this->PCAP_VH);
        $stm->bindParam(':PCON_VL', $this->PCON_VL);
        $stm->bindParam(':PCON_LO', $this->PCON_LO);
        $stm->bindParam(':PCON_NO', $this->PCON_NO);
        $stm->bindParam(':PCON_HI', $this->PCON_HI);
        $stm->bindParam(':PCON_VH', $this->PCON_VH);
        $stm->bindParam(':APEX_VL', $this->APEX_VL);
        $stm->bindParam(':APEX_LO', $this->APEX_LO);
        $stm->bindParam(':APEX_NO', $this->APEX_NO);
        $stm->bindParam(':APEX_HI', $this->APEX_HI);
        $stm->bindParam(':APEX_VH', $this->APEX_VH);
        $stm->bindParam(':PLEX_VL', $this->PLEX_VL);
        $stm->bindParam(':PLEX_LO', $this->PLEX_LO);
        $stm->bindParam(':PLEX_NO', $this->PLEX_NO);
        $stm->bindParam(':PLEX_HI', $this->PLEX_HI);
        $stm->bindParam(':PLEX_VH', $this->PLEX_VH);
        $stm->bindParam(':LTEX_VL', $this->LTEX_VL);
        $stm->bindParam(':LTEX_LO', $this->LTEX_LO);
        $stm->bindParam(':LTEX_NO', $this->LTEX_NO);
        $stm->bindParam(':LTEX_HI', $this->LTEX_HI);
        $stm->bindParam(':LTEX_VH', $this->LTEX_VH);
        $stm->bindParam(':TOOL_VL', $this->TOOL_VL);
        $stm->bindParam(':TOOL_LO', $this->TOOL_LO);
        $stm->bindParam(':TOOL_NO', $this->TOOL_NO);
        $stm->bindParam(':TOOL_HI', $this->TOOL_HI);
        $stm->bindParam(':TOOL_VH', $this->TOOL_VH);
        $stm->bindParam(':SITE_VL', $this->SITE_VL);
        $stm->bindParam(':SITE_LO', $this->SITE_LO);
        $stm->bindParam(':SITE_NO', $this->SITE_NO);
        $stm->bindParam(':SITE_HI', $this->SITE_HI);
        $stm->bindParam(':SITE_VH', $this->SITE_VH);
        $stm->bindParam(':SITE_EH', $this->SITE_EH);
        $stm->bindParam(':SCED_VL', $this->SCED_VL);
        $stm->bindParam(':SCED_LO', $this->SCED_LO);
        $stm->bindParam(':SCED_NO', $this->SCED_NO);
        $stm->bindParam(':SCED_HI', $this->SCED_HI);
        $stm->bindParam(':SCED_VH', $this->SCED_VH);
        $stm->bindParam(':ED_PERS_XL', $this->ED_PERS_XL);
        $stm->bindParam(':ED_PERS_VL', $this->ED_PERS_VL);
        $stm->bindParam(':ED_PERS_LO', $this->ED_PERS_LO);
        $stm->bindParam(':ED_PERS_NO', $this->ED_PERS_NO);
        $stm->bindParam(':ED_PERS_HI', $this->ED_PERS_HI);
        $stm->bindParam(':ED_PERS_VH', $this->ED_PERS_VH);
        $stm->bindParam(':ED_PERS_EH', $this->ED_PERS_EH);
        $stm->bindParam(':ED_RCPX_XL', $this->ED_RCPX_XL);
        $stm->bindParam(':ED_RCPX_VL', $this->ED_RCPX_VL);
        $stm->bindParam(':ED_RCPX_LO', $this->ED_RCPX_LO);
        $stm->bindParam(':ED_RCPX_NO', $this->ED_RCPX_NO);
        $stm->bindParam(':ED_RCPX_HI', $this->ED_RCPX_HI);
        $stm->bindParam(':ED_RCPX_VH', $this->ED_RCPX_VH);
        $stm->bindParam(':ED_RCPX_EH', $this->ED_RCPX_EH);
        $stm->bindParam(':ED_PDIF_LO', $this->ED_PDIF_LO);
        $stm->bindParam(':ED_PDIF_NO', $this->ED_PDIF_NO);
        $stm->bindParam(':ED_PDIF_HI', $this->ED_PDIF_HI);
        $stm->bindParam(':ED_PDIF_VH', $this->ED_PDIF_VH);
        $stm->bindParam(':ED_PDIF_EH', $this->ED_PDIF_EH);
        $stm->bindParam(':ED_PREX_XL', $this->ED_PREX_XL);
        $stm->bindParam(':ED_PREX_VL', $this->ED_PREX_VL);
        $stm->bindParam(':ED_PREX_LO', $this->ED_PREX_LO);
        $stm->bindParam(':ED_PREX_NO', $this->ED_PREX_NO);
        $stm->bindParam(':ED_PREX_HI', $this->ED_PREX_HI);
        $stm->bindParam(':ED_PREX_VH', $this->ED_PREX_VH);
        $stm->bindParam(':ED_PREX_EH', $this->ED_PREX_EH);
        $stm->bindParam(':ED_FCIL_XL', $this->ED_FCIL_XL);
        $stm->bindParam(':ED_FCIL_VL', $this->ED_FCIL_VL);
        $stm->bindParam(':ED_FCIL_LO', $this->ED_FCIL_LO);
        $stm->bindParam(':ED_FCIL_NO', $this->ED_FCIL_NO);
        $stm->bindParam(':ED_FCIL_HI', $this->ED_FCIL_HI);
        $stm->bindParam(':ED_FCIL_VH', $this->ED_FCIL_VH);
        $stm->bindParam(':ED_FCIL_EH', $this->ED_FCIL_EH);
        $stm->bindParam(':ED_RUSE_LO', $this->ED_RUSE_LO);
        $stm->bindParam(':ED_RUSE_NO', $this->ED_RUSE_NO);
        $stm->bindParam(':ED_RUSE_HI', $this->ED_RUSE_HI);
        $stm->bindParam(':ED_RUSE_VH', $this->ED_RUSE_VH);
        $stm->bindParam(':ED_RUSE_EH', $this->ED_RUSE_EH);
        $stm->bindParam(':ED_SCED_VL', $this->ED_SCED_VL);
        $stm->bindParam(':ED_SCED_LO', $this->ED_SCED_LO);
        $stm->bindParam(':ED_SCED_NO', $this->ED_SCED_NO);
        $stm->bindParam(':ED_SCED_HI', $this->ED_SCED_HI);
        $stm->bindParam(':ED_SCED_VH', $this->ED_SCED_VH);
        $stm->bindParam(':esforco', $this->esforco);
        $stm->bindParam(':cronograma', $this->cronograma);
        $stm->bindParam(':custo', $this->custo);
        $stm->bindParam(':custo_pessoa', $this->custo_pessoa);
        $stm->bindParam(':sloc', $this->sloc);
        $stm->bindParam(':tipo_calculo', $this->tipo_calculo);
        $stm->bindParam(':rup_inc_ef', $this->rup_inc_ef);
        $stm->bindParam(':rup_inc_sc', $this->rup_inc_sc);
        $stm->bindParam(':rup_ela_ef', $this->rup_ela_ef);
        $stm->bindParam(':rup_ela_sc', $this->rup_ela_sc);
        $stm->bindParam(':rup_con_ef', $this->rup_con_ef);
        $stm->bindParam(':rup_con_sc', $this->rup_con_sc);
        $stm->bindParam(':rup_tra_ef', $this->rup_tra_ef);
        $stm->bindParam(':rup_tra_sc', $this->rup_tra_sc);
        $stm->bindParam(':coc_inc_ef', $this->coc_inc_ef);
        $stm->bindParam(':coc_inc_sc', $this->coc_inc_sc);
        $stm->bindParam(':coc_ela_ef', $this->coc_ela_ef);
        $stm->bindParam(':coc_ela_sc', $this->coc_ela_sc);
        $stm->bindParam(':coc_con_ef', $this->coc_con_ef);
        $stm->bindParam(':coc_con_sc', $this->coc_con_sc);
        $stm->bindParam(':coc_tra_ef', $this->coc_tra_ef);
        $stm->bindParam(':coc_tra_sc', $this->coc_tra_sc);
        $stm->bindParam(':man_inc', $this->man_inc);
        $stm->bindParam(':man_ela', $this->man_ela);
        $stm->bindParam(':man_con', $this->man_con);
        $stm->bindParam(':man_tra', $this->man_tra);
        $stm->bindParam(':env_inc', $this->env_inc);
        $stm->bindParam(':env_ela', $this->env_ela);
        $stm->bindParam(':env_con', $this->env_con);
        $stm->bindParam(':env_tra', $this->env_tra);
        $stm->bindParam(':req_inc', $this->req_inc);
        $stm->bindParam(':req_ela', $this->req_ela);
        $stm->bindParam(':req_con', $this->req_con);
        $stm->bindParam(':req_tra', $this->req_tra);
        $stm->bindParam(':des_inc', $this->des_inc);
        $stm->bindParam(':des_ela', $this->des_ela);
        $stm->bindParam(':des_con', $this->des_con);
        $stm->bindParam(':des_tra', $this->des_tra);
        $stm->bindParam(':imp_inc', $this->imp_inc);
        $stm->bindParam(':imp_ela', $this->imp_ela);
        $stm->bindParam(':imp_con', $this->imp_con);
        $stm->bindParam(':imp_tra', $this->imp_tra);
        $stm->bindParam(':ass_inc', $this->ass_inc);
        $stm->bindParam(':ass_ela', $this->ass_ela);
        $stm->bindParam(':ass_con', $this->ass_con);
        $stm->bindParam(':ass_tra', $this->ass_tra);
        $stm->bindParam(':dep_inc', $this->dep_inc);
        $stm->bindParam(':dep_ela', $this->dep_ela);
        $stm->bindParam(':dep_con', $this->dep_con);
        $stm->bindParam(':dep_tra', $this->dep_tra);
        return $stm->execute();
    }

    public function atualiza($id) {
        $stm = DB::prepare("UPDATE $this->table SET "
                        . "COCOMO_A = :COCOMO_A,"
                        . "COCOMO_B = :COCOMO_B,"
                        . "COCOMO_C = :COCOMO_C,"
                        . "COCOMO_D = :COCOMO_D,"
                        . "ED_PERS = :ED_PERS,"
                        . "ED_RCPX = :ED_RCPX,"
                        . "ED_PDIF = :ED_PDIF,"
                        . "ED_PREX = :ED_PREX,"
                        . "ED_FCIL = :ED_FCIL,"
                        . "ED_RUSE = :ED_RUSE,"
                        . "ED_SCED = :ED_SCED,"
                        . "PREC = :PREC,"
                        . "FLEX = :FLEX,"
                        . "RESL = :RESL,"
                        . "TEAM = :TEAM,"
                        . "PMAT = :PMAT,"
                        . "RELY = :RELY,"
                        . "DATA = :DATA,"
                        . "CPLX_CN = :CPLX_CN,"
                        . "CPLX_CO = :CPLX_CO,"
                        . "CPLX_DO = :CPLX_DO,"
                        . "CPLX_DM = :CPLX_DM,"
                        . "CPLX_UI = :CPLX_UI,"
                        . "CPLX = :CPLX,"
                        . "RUSE = :RUSE,"
                        . "DOCU = :DOCU,"
                        . "TIME = :TIME,"
                        . "STOR = :STOR,"
                        . "PVOL = :PVOL,"
                        . "ACAP = :ACAP,"
                        . "PCAP = :PCAP,"
                        . "PCON = :PCON,"
                        . "APEX = :APEX,"
                        . "PLEX = :PLEX,"
                        . "LTEX = :LTEX,"
                        . "TOOL = :TOOL,"
                        . "SITE = :SITE,"
                        . "SCED = :SCED,"
                        . "esforco = :esforco,"
                        . "cronograma = :cronograma,"
                        . "custo = :custo,"
                        . "custo_pessoa = :custo_pessoa,"
                        . "sloc = :sloc,"
                        . "tipo_calculo = :tipo_calculo"
                        . " WHERE id_contagem = :id");
        $stm->bindParam(':id', $this->idContagem, PDO::PARAM_INT);
        $stm->bindParam(':COCOMO_A', $this->COCOMO_A);
        $stm->bindParam(':COCOMO_B', $this->COCOMO_B);
        $stm->bindParam(':COCOMO_C', $this->COCOMO_C);
        $stm->bindParam(':COCOMO_D', $this->COCOMO_D);
        $stm->bindParam(':ED_PERS', $this->ED_PERS);
        $stm->bindParam(':ED_RCPX', $this->ED_RCPX);
        $stm->bindParam(':ED_PDIF', $this->ED_PDIF);
        $stm->bindParam(':ED_PREX', $this->ED_PREX);
        $stm->bindParam(':ED_FCIL', $this->ED_FCIL);
        $stm->bindParam(':ED_RUSE', $this->ED_RUSE);
        $stm->bindParam(':ED_SCED', $this->ED_SCED);
        $stm->bindParam(':PREC', $this->PREC);
        $stm->bindParam(':FLEX', $this->FLEX);
        $stm->bindParam(':RESL', $this->RESL);
        $stm->bindParam(':TEAM', $this->TEAM);
        $stm->bindParam(':PMAT', $this->PMAT);
        $stm->bindParam(':RELY', $this->RELY);
        $stm->bindParam(':DATA', $this->DATA);
        $stm->bindParam(':CPLX_CN', $this->CPLX_CN);
        $stm->bindParam(':CPLX_CO', $this->CPLX_CO);
        $stm->bindParam(':CPLX_DO', $this->CPLX_DO);
        $stm->bindParam(':CPLX_DM', $this->CPLX_DM);
        $stm->bindParam(':CPLX_UI', $this->CPLX_UI);
        $stm->bindParam(':CPLX', $this->CPLX);
        $stm->bindParam(':RUSE', $this->RUSE);
        $stm->bindParam(':DOCU', $this->DOCU);
        $stm->bindParam(':TIME', $this->TIME);
        $stm->bindParam(':STOR', $this->STOR);
        $stm->bindParam(':PVOL', $this->PVOL);
        $stm->bindParam(':ACAP', $this->ACAP);
        $stm->bindParam(':PCAP', $this->PCAP);
        $stm->bindParam(':PCON', $this->PCON);
        $stm->bindParam(':APEX', $this->APEX);
        $stm->bindParam(':PLEX', $this->PLEX);
        $stm->bindParam(':LTEX', $this->LTEX);
        $stm->bindParam(':TOOL', $this->TOOL);
        $stm->bindParam(':SITE', $this->SITE);
        $stm->bindParam(':SCED', $this->SCED);
        $stm->bindParam(':esforco', $this->esforco);
        $stm->bindParam(':cronograma', $this->cronograma);
        $stm->bindParam(':custo', $this->custo);
        $stm->bindParam(':custo_pessoa', $this->custo_pessoa);
        $stm->bindParam(':sloc', $this->sloc);
        $stm->bindParam(':tipo_calculo', $this->tipo_calculo);
        return $stm->execute();
    }

    /*
     * neste caso a funcao atualiza eh para a atualizacao das estatisticas e nao de uma variavel
     *
      public function atualiza($id) {
      $stm = DB::prepare("UPDATE $this->table SET $this->variavel = '$this->valor' WHERE id_contagem = :id");
      $stm->bindParam(':id', $this->idContagem, PDO::PARAM_INT);
      return $stm->execute();
      }
     * 
     */

    public function getconfig() {
        $sql = "SELECT * FROM $this->table WHERE id_contagem = :idContagem";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idContagem', $this->idContagem, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    private $idContagem;
    private $COCOMO_A;
    private $COCOMO_B;
    private $COCOMO_C;
    private $COCOMO_D;
    private $ED_PERS;
    private $ED_RCPX;
    private $ED_PDIF;
    private $ED_PREX;
    private $ED_FCIL;
    private $ED_RUSE;
    private $ED_SCED;
    private $PREC;
    private $FLEX;
    private $RESL;
    private $TEAM;
    private $PMAT;
    private $RELY;
    private $DATA;
    private $CPLX_CN;
    private $CPLX_CO;
    private $CPLX_DO;
    private $CPLX_DM;
    private $CPLX_UI;
    private $CPLX;
    private $RUSE;
    private $DOCU;
    private $TIME;
    private $STOR;
    private $PVOL;
    private $ACAP;
    private $PCAP;
    private $PCON;
    private $APEX;
    private $PLEX;
    private $LTEX;
    private $TOOL;
    private $SITE;
    private $SCED;
    private $PREC_VL;
    private $PREC_LO;
    private $PREC_NO;
    private $PREC_HI;
    private $PREC_VH;
    private $PREC_EH;
    private $FLEX_VL;
    private $FLEX_LO;
    private $FLEX_NO;
    private $FLEX_HI;
    private $FLEX_VH;
    private $FLEX_EH;
    private $RESL_VL;
    private $RESL_LO;
    private $RESL_NO;
    private $RESL_HI;
    private $RESL_VH;
    private $RESL_EH;
    private $TEAM_VL;
    private $TEAM_LO;
    private $TEAM_NO;
    private $TEAM_HI;
    private $TEAM_VH;
    private $TEAM_EH;
    private $PMAT_VL;
    private $PMAT_LO;
    private $PMAT_NO;
    private $PMAT_HI;
    private $PMAT_VH;
    private $PMAT_EH;
    private $RELY_VL;
    private $RELY_LO;
    private $RELY_NO;
    private $RELY_HI;
    private $RELY_VH;
    private $DATA_LO;
    private $DATA_NO;
    private $DATA_HI;
    private $DATA_VH;
    private $CPLX_CN_VL;
    private $CPLX_CN_LO;
    private $CPLX_CN_NO;
    private $CPLX_CN_HI;
    private $CPLX_CN_VH;
    private $CPLX_CN_EH;
    private $CPLX_CO_VL;
    private $CPLX_CO_LO;
    private $CPLX_CO_NO;
    private $CPLX_CO_HI;
    private $CPLX_CO_VH;
    private $CPLX_CO_EH;
    private $CPLX_DO_VL;
    private $CPLX_DO_LO;
    private $CPLX_DO_NO;
    private $CPLX_DO_HI;
    private $CPLX_DO_VH;
    private $CPLX_DO_EH;
    private $CPLX_DM_VL;
    private $CPLX_DM_LO;
    private $CPLX_DM_NO;
    private $CPLX_DM_HI;
    private $CPLX_DM_VH;
    private $CPLX_DM_EH;
    private $CPLX_UI_VL;
    private $CPLX_UI_LO;
    private $CPLX_UI_NO;
    private $CPLX_UI_HI;
    private $CPLX_UI_VH;
    private $CPLX_UI_EH;
    private $CPLX_VL;
    private $CPLX_LO;
    private $CPLX_NO;
    private $CPLX_HI;
    private $CPLX_VH;
    private $CPLX_EH;
    private $RUSE_LO;
    private $RUSE_NO;
    private $RUSE_HI;
    private $RUSE_VH;
    private $RUSE_EH;
    private $DOCU_VL;
    private $DOCU_LO;
    private $DOCU_NO;
    private $DOCU_HI;
    private $DOCU_VH;
    private $TIME_NO;
    private $TIME_HI;
    private $TIME_VH;
    private $TIME_EH;
    private $STOR_NO;
    private $STOR_HI;
    private $STOR_VH;
    private $STOR_EH;
    private $PVOL_LO;
    private $PVOL_NO;
    private $PVOL_HI;
    private $PVOL_VH;
    private $ACAP_VL;
    private $ACAP_LO;
    private $ACAP_NO;
    private $ACAP_HI;
    private $ACAP_VH;
    private $PCAP_VL;
    private $PCAP_LO;
    private $PCAP_NO;
    private $PCAP_HI;
    private $PCAP_VH;
    private $PCON_VL;
    private $PCON_LO;
    private $PCON_NO;
    private $PCON_HI;
    private $PCON_VH;
    private $APEX_VL;
    private $APEX_LO;
    private $APEX_NO;
    private $APEX_HI;
    private $APEX_VH;
    private $PLEX_VL;
    private $PLEX_LO;
    private $PLEX_NO;
    private $PLEX_HI;
    private $PLEX_VH;
    private $LTEX_VL;
    private $LTEX_LO;
    private $LTEX_NO;
    private $LTEX_HI;
    private $LTEX_VH;
    private $TOOL_VL;
    private $TOOL_LO;
    private $TOOL_NO;
    private $TOOL_HI;
    private $TOOL_VH;
    private $SITE_VL;
    private $SITE_LO;
    private $SITE_NO;
    private $SITE_HI;
    private $SITE_VH;
    private $SITE_EH;
    private $SCED_VL;
    private $SCED_LO;
    private $SCED_NO;
    private $SCED_HI;
    private $SCED_VH;
    private $ED_PERS_XL;
    private $ED_PERS_VL;
    private $ED_PERS_LO;
    private $ED_PERS_NO;
    private $ED_PERS_HI;
    private $ED_PERS_VH;
    private $ED_PERS_EH;
    private $ED_RCPX_XL;
    private $ED_RCPX_VL;
    private $ED_RCPX_LO;
    private $ED_RCPX_NO;
    private $ED_RCPX_HI;
    private $ED_RCPX_VH;
    private $ED_RCPX_EH;
    private $ED_PDIF_LO;
    private $ED_PDIF_NO;
    private $ED_PDIF_HI;
    private $ED_PDIF_VH;
    private $ED_PDIF_EH;
    private $ED_PREX_XL;
    private $ED_PREX_VL;
    private $ED_PREX_LO;
    private $ED_PREX_NO;
    private $ED_PREX_HI;
    private $ED_PREX_VH;
    private $ED_PREX_EH;
    private $ED_FCIL_XL;
    private $ED_FCIL_VL;
    private $ED_FCIL_LO;
    private $ED_FCIL_NO;
    private $ED_FCIL_HI;
    private $ED_FCIL_VH;
    private $ED_FCIL_EH;
    private $ED_RUSE_LO;
    private $ED_RUSE_NO;
    private $ED_RUSE_HI;
    private $ED_RUSE_VH;
    private $ED_RUSE_EH;
    private $ED_SCED_VL;
    private $ED_SCED_LO;
    private $ED_SCED_NO;
    private $ED_SCED_HI;
    private $ED_SCED_VH;
    private $esforco;
    private $cronograma;
    private $custo;
    private $custo_pessoa;
    private $sloc;
    private $tipo_calculo;
    private $rup_inc_ef;
    private $rup_inc_sc;
    private $rup_ela_ef;
    private $rup_ela_sc;
    private $rup_con_ef;
    private $rup_con_sc;
    private $rup_tra_ef;
    private $rup_tra_sc;
    private $coc_inc_ef;
    private $coc_inc_sc;
    private $coc_ela_ef;
    private $coc_ela_sc;
    private $coc_con_ef;
    private $coc_con_sc;
    private $coc_tra_ef;
    private $coc_tra_sc;
    private $man_inc;
    private $man_ela;
    private $man_con;
    private $man_tra;
    private $env_inc;
    private $env_ela;
    private $env_con;
    private $env_tra;
    private $req_inc;
    private $req_ela;
    private $req_con;
    private $req_tra;
    private $des_inc;
    private $des_ela;
    private $des_con;
    private $des_tra;
    private $imp_inc;
    private $imp_ela;
    private $imp_con;
    private $imp_tra;
    private $ass_inc;
    private $ass_ela;
    private $ass_con;
    private $ass_tra;
    private $dep_inc;
    private $dep_ela;
    private $dep_con;
    private $dep_tra;
    private $variavel;
    private $valor;

    function setCOCOMO_A($COCOMO_A) {
        $this->COCOMO_A = $COCOMO_A;
    }

    function setCOCOMO_B($COCOMO_B) {
        $this->COCOMO_B = $COCOMO_B;
    }

    function setCOCOMO_C($COCOMO_C) {
        $this->COCOMO_C = $COCOMO_C;
    }

    function setCOCOMO_D($COCOMO_D) {
        $this->COCOMO_D = $COCOMO_D;
    }

    function setED_PERS($ED_PERS) {
        $this->ED_PERS = $ED_PERS;
    }

    function setED_RCPX($ED_RCPX) {
        $this->ED_RCPX = $ED_RCPX;
    }

    function setED_PDIF($ED_PDIF) {
        $this->ED_PDIF = $ED_PDIF;
    }

    function setED_PREX($ED_PREX) {
        $this->ED_PREX = $ED_PREX;
    }

    function setED_FCIL($ED_FCIL) {
        $this->ED_FCIL = $ED_FCIL;
    }

    function setED_RUSE($ED_RUSE) {
        $this->ED_RUSE = $ED_RUSE;
    }

    function setED_SCED($ED_SCED) {
        $this->ED_SCED = $ED_SCED;
    }

    function setPREC($PREC) {
        $this->PREC = $PREC;
    }

    function setFLEX($FLEX) {
        $this->FLEX = $FLEX;
    }

    function setRESL($RESL) {
        $this->RESL = $RESL;
    }

    function setTEAM($TEAM) {
        $this->TEAM = $TEAM;
    }

    function setPMAT($PMAT) {
        $this->PMAT = $PMAT;
    }

    function setRELY($RELY) {
        $this->RELY = $RELY;
    }

    function setDATA($DATA) {
        $this->DATA = $DATA;
    }

    function setCPLX_CN($CPLX_CN) {
        $this->CPLX_CN = $CPLX_CN;
    }

    function setCPLX_CO($CPLX_CO) {
        $this->CPLX_CO = $CPLX_CO;
    }

    function setCPLX_DO($CPLX_DO) {
        $this->CPLX_DO = $CPLX_DO;
    }

    function setCPLX_DM($CPLX_DM) {
        $this->CPLX_DM = $CPLX_DM;
    }

    function setCPLX_UI($CPLX_UI) {
        $this->CPLX_UI = $CPLX_UI;
    }

    function setCPLX($CPLX) {
        $this->CPLX = $CPLX;
    }

    function setRUSE($RUSE) {
        $this->RUSE = $RUSE;
    }

    function setDOCU($DOCU) {
        $this->DOCU = $DOCU;
    }

    function setTIME($TIME) {
        $this->TIME = $TIME;
    }

    function setSTOR($STOR) {
        $this->STOR = $STOR;
    }

    function setPVOL($PVOL) {
        $this->PVOL = $PVOL;
    }

    function setACAP($ACAP) {
        $this->ACAP = $ACAP;
    }

    function setPCAP($PCAP) {
        $this->PCAP = $PCAP;
    }

    function setPCON($PCON) {
        $this->PCON = $PCON;
    }

    function setAPEX($APEX) {
        $this->APEX = $APEX;
    }

    function setPLEX($PLEX) {
        $this->PLEX = $PLEX;
    }

    function setLTEX($LTEX) {
        $this->LTEX = $LTEX;
    }

    function setTOOL($TOOL) {
        $this->TOOL = $TOOL;
    }

    function setSITE($SITE) {
        $this->SITE = $SITE;
    }

    function setSCED($SCED) {
        $this->SCED = $SCED;
    }

    function setPREC_VL($PREC_VL) {
        $this->PREC_VL = $PREC_VL;
    }

    function setPREC_LO($PREC_LO) {
        $this->PREC_LO = $PREC_LO;
    }

    function setPREC_NO($PREC_NO) {
        $this->PREC_NO = $PREC_NO;
    }

    function setPREC_HI($PREC_HI) {
        $this->PREC_HI = $PREC_HI;
    }

    function setPREC_VH($PREC_VH) {
        $this->PREC_VH = $PREC_VH;
    }

    function setPREC_EH($PREC_EH) {
        $this->PREC_EH = $PREC_EH;
    }

    function setFLEX_VL($FLEX_VL) {
        $this->FLEX_VL = $FLEX_VL;
    }

    function setFLEX_LO($FLEX_LO) {
        $this->FLEX_LO = $FLEX_LO;
    }

    function setFLEX_NO($FLEX_NO) {
        $this->FLEX_NO = $FLEX_NO;
    }

    function setFLEX_HI($FLEX_HI) {
        $this->FLEX_HI = $FLEX_HI;
    }

    function setFLEX_VH($FLEX_VH) {
        $this->FLEX_VH = $FLEX_VH;
    }

    function setFLEX_EH($FLEX_EH) {
        $this->FLEX_EH = $FLEX_EH;
    }

    function setRESL_VL($RESL_VL) {
        $this->RESL_VL = $RESL_VL;
    }

    function setRESL_LO($RESL_LO) {
        $this->RESL_LO = $RESL_LO;
    }

    function setRESL_NO($RESL_NO) {
        $this->RESL_NO = $RESL_NO;
    }

    function setRESL_HI($RESL_HI) {
        $this->RESL_HI = $RESL_HI;
    }

    function setRESL_VH($RESL_VH) {
        $this->RESL_VH = $RESL_VH;
    }

    function setRESL_EH($RESL_EH) {
        $this->RESL_EH = $RESL_EH;
    }

    function setTEAM_VL($TEAM_VL) {
        $this->TEAM_VL = $TEAM_VL;
    }

    function setTEAM_LO($TEAM_LO) {
        $this->TEAM_LO = $TEAM_LO;
    }

    function setTEAM_NO($TEAM_NO) {
        $this->TEAM_NO = $TEAM_NO;
    }

    function setTEAM_HI($TEAM_HI) {
        $this->TEAM_HI = $TEAM_HI;
    }

    function setTEAM_VH($TEAM_VH) {
        $this->TEAM_VH = $TEAM_VH;
    }

    function setTEAM_EH($TEAM_EH) {
        $this->TEAM_EH = $TEAM_EH;
    }

    function setPMAT_VL($PMAT_VL) {
        $this->PMAT_VL = $PMAT_VL;
    }

    function setPMAT_LO($PMAT_LO) {
        $this->PMAT_LO = $PMAT_LO;
    }

    function setPMAT_NO($PMAT_NO) {
        $this->PMAT_NO = $PMAT_NO;
    }

    function setPMAT_HI($PMAT_HI) {
        $this->PMAT_HI = $PMAT_HI;
    }

    function setPMAT_VH($PMAT_VH) {
        $this->PMAT_VH = $PMAT_VH;
    }

    function setPMAT_EH($PMAT_EH) {
        $this->PMAT_EH = $PMAT_EH;
    }

    function setRELY_VL($RELY_VL) {
        $this->RELY_VL = $RELY_VL;
    }

    function setRELY_LO($RELY_LO) {
        $this->RELY_LO = $RELY_LO;
    }

    function setRELY_NO($RELY_NO) {
        $this->RELY_NO = $RELY_NO;
    }

    function setRELY_HI($RELY_HI) {
        $this->RELY_HI = $RELY_HI;
    }

    function setRELY_VH($RELY_VH) {
        $this->RELY_VH = $RELY_VH;
    }

    function setDATA_LO($DATA_LO) {
        $this->DATA_LO = $DATA_LO;
    }

    function setDATA_NO($DATA_NO) {
        $this->DATA_NO = $DATA_NO;
    }

    function setDATA_HI($DATA_HI) {
        $this->DATA_HI = $DATA_HI;
    }

    function setDATA_VH($DATA_VH) {
        $this->DATA_VH = $DATA_VH;
    }

    function setCPLX_CN_VL($CPLX_CN_VL) {
        $this->CPLX_CN_VL = $CPLX_CN_VL;
    }

    function setCPLX_CN_LO($CPLX_CN_LO) {
        $this->CPLX_CN_LO = $CPLX_CN_LO;
    }

    function setCPLX_CN_NO($CPLX_CN_NO) {
        $this->CPLX_CN_NO = $CPLX_CN_NO;
    }

    function setCPLX_CN_HI($CPLX_CN_HI) {
        $this->CPLX_CN_HI = $CPLX_CN_HI;
    }

    function setCPLX_CN_VH($CPLX_CN_VH) {
        $this->CPLX_CN_VH = $CPLX_CN_VH;
    }

    function setCPLX_CN_EH($CPLX_CN_EH) {
        $this->CPLX_CN_EH = $CPLX_CN_EH;
    }

    function setCPLX_CO_VL($CPLX_CO_VL) {
        $this->CPLX_CO_VL = $CPLX_CO_VL;
    }

    function setCPLX_CO_LO($CPLX_CO_LO) {
        $this->CPLX_CO_LO = $CPLX_CO_LO;
    }

    function setCPLX_CO_NO($CPLX_CO_NO) {
        $this->CPLX_CO_NO = $CPLX_CO_NO;
    }

    function setCPLX_CO_HI($CPLX_CO_HI) {
        $this->CPLX_CO_HI = $CPLX_CO_HI;
    }

    function setCPLX_CO_VH($CPLX_CO_VH) {
        $this->CPLX_CO_VH = $CPLX_CO_VH;
    }

    function setCPLX_CO_EH($CPLX_CO_EH) {
        $this->CPLX_CO_EH = $CPLX_CO_EH;
    }

    function setCPLX_DO_VL($CPLX_DO_VL) {
        $this->CPLX_DO_VL = $CPLX_DO_VL;
    }

    function setCPLX_DO_LO($CPLX_DO_LO) {
        $this->CPLX_DO_LO = $CPLX_DO_LO;
    }

    function setCPLX_DO_NO($CPLX_DO_NO) {
        $this->CPLX_DO_NO = $CPLX_DO_NO;
    }

    function setCPLX_DO_HI($CPLX_DO_HI) {
        $this->CPLX_DO_HI = $CPLX_DO_HI;
    }

    function setCPLX_DO_VH($CPLX_DO_VH) {
        $this->CPLX_DO_VH = $CPLX_DO_VH;
    }

    function setCPLX_DO_EH($CPLX_DO_EH) {
        $this->CPLX_DO_EH = $CPLX_DO_EH;
    }

    function setCPLX_DM_VL($CPLX_DM_VL) {
        $this->CPLX_DM_VL = $CPLX_DM_VL;
    }

    function setCPLX_DM_LO($CPLX_DM_LO) {
        $this->CPLX_DM_LO = $CPLX_DM_LO;
    }

    function setCPLX_DM_NO($CPLX_DM_NO) {
        $this->CPLX_DM_NO = $CPLX_DM_NO;
    }

    function setCPLX_DM_HI($CPLX_DM_HI) {
        $this->CPLX_DM_HI = $CPLX_DM_HI;
    }

    function setCPLX_DM_VH($CPLX_DM_VH) {
        $this->CPLX_DM_VH = $CPLX_DM_VH;
    }

    function setCPLX_DM_EH($CPLX_DM_EH) {
        $this->CPLX_DM_EH = $CPLX_DM_EH;
    }

    function setCPLX_UI_VL($CPLX_UI_VL) {
        $this->CPLX_UI_VL = $CPLX_UI_VL;
    }

    function setCPLX_UI_LO($CPLX_UI_LO) {
        $this->CPLX_UI_LO = $CPLX_UI_LO;
    }

    function setCPLX_UI_NO($CPLX_UI_NO) {
        $this->CPLX_UI_NO = $CPLX_UI_NO;
    }

    function setCPLX_UI_HI($CPLX_UI_HI) {
        $this->CPLX_UI_HI = $CPLX_UI_HI;
    }

    function setCPLX_UI_VH($CPLX_UI_VH) {
        $this->CPLX_UI_VH = $CPLX_UI_VH;
    }

    function setCPLX_UI_EH($CPLX_UI_EH) {
        $this->CPLX_UI_EH = $CPLX_UI_EH;
    }

    function setCPLX_VL($CPLX_VL) {
        $this->CPLX_VL = $CPLX_VL;
    }

    function setCPLX_LO($CPLX_LO) {
        $this->CPLX_LO = $CPLX_LO;
    }

    function setCPLX_NO($CPLX_NO) {
        $this->CPLX_NO = $CPLX_NO;
    }

    function setCPLX_HI($CPLX_HI) {
        $this->CPLX_HI = $CPLX_HI;
    }

    function setCPLX_VH($CPLX_VH) {
        $this->CPLX_VH = $CPLX_VH;
    }

    function setCPLX_EH($CPLX_EH) {
        $this->CPLX_EH = $CPLX_EH;
    }

    function setRUSE_LO($RUSE_LO) {
        $this->RUSE_LO = $RUSE_LO;
    }

    function setRUSE_NO($RUSE_NO) {
        $this->RUSE_NO = $RUSE_NO;
    }

    function setRUSE_HI($RUSE_HI) {
        $this->RUSE_HI = $RUSE_HI;
    }

    function setRUSE_VH($RUSE_VH) {
        $this->RUSE_VH = $RUSE_VH;
    }

    function setRUSE_EH($RUSE_EH) {
        $this->RUSE_EH = $RUSE_EH;
    }

    function setDOCU_VL($DOCU_VL) {
        $this->DOCU_VL = $DOCU_VL;
    }

    function setDOCU_LO($DOCU_LO) {
        $this->DOCU_LO = $DOCU_LO;
    }

    function setDOCU_NO($DOCU_NO) {
        $this->DOCU_NO = $DOCU_NO;
    }

    function setDOCU_HI($DOCU_HI) {
        $this->DOCU_HI = $DOCU_HI;
    }

    function setDOCU_VH($DOCU_VH) {
        $this->DOCU_VH = $DOCU_VH;
    }

    function setTIME_NO($TIME_NO) {
        $this->TIME_NO = $TIME_NO;
    }

    function setTIME_HI($TIME_HI) {
        $this->TIME_HI = $TIME_HI;
    }

    function setTIME_VH($TIME_VH) {
        $this->TIME_VH = $TIME_VH;
    }

    function setTIME_EH($TIME_EH) {
        $this->TIME_EH = $TIME_EH;
    }

    function setSTOR_NO($STOR_NO) {
        $this->STOR_NO = $STOR_NO;
    }

    function setSTOR_HI($STOR_HI) {
        $this->STOR_HI = $STOR_HI;
    }

    function setSTOR_VH($STOR_VH) {
        $this->STOR_VH = $STOR_VH;
    }

    function setSTOR_EH($STOR_EH) {
        $this->STOR_EH = $STOR_EH;
    }

    function setPVOL_LO($PVOL_LO) {
        $this->PVOL_LO = $PVOL_LO;
    }

    function setPVOL_NO($PVOL_NO) {
        $this->PVOL_NO = $PVOL_NO;
    }

    function setPVOL_HI($PVOL_HI) {
        $this->PVOL_HI = $PVOL_HI;
    }

    function setPVOL_VH($PVOL_VH) {
        $this->PVOL_VH = $PVOL_VH;
    }

    function setACAP_VL($ACAP_VL) {
        $this->ACAP_VL = $ACAP_VL;
    }

    function setACAP_LO($ACAP_LO) {
        $this->ACAP_LO = $ACAP_LO;
    }

    function setACAP_NO($ACAP_NO) {
        $this->ACAP_NO = $ACAP_NO;
    }

    function setACAP_HI($ACAP_HI) {
        $this->ACAP_HI = $ACAP_HI;
    }

    function setACAP_VH($ACAP_VH) {
        $this->ACAP_VH = $ACAP_VH;
    }

    function setPCAP_VL($PCAP_VL) {
        $this->PCAP_VL = $PCAP_VL;
    }

    function setPCAP_LO($PCAP_LO) {
        $this->PCAP_LO = $PCAP_LO;
    }

    function setPCAP_NO($PCAP_NO) {
        $this->PCAP_NO = $PCAP_NO;
    }

    function setPCAP_HI($PCAP_HI) {
        $this->PCAP_HI = $PCAP_HI;
    }

    function setPCAP_VH($PCAP_VH) {
        $this->PCAP_VH = $PCAP_VH;
    }

    function setPCON_VL($PCON_VL) {
        $this->PCON_VL = $PCON_VL;
    }

    function setPCON_LO($PCON_LO) {
        $this->PCON_LO = $PCON_LO;
    }

    function setPCON_NO($PCON_NO) {
        $this->PCON_NO = $PCON_NO;
    }

    function setPCON_HI($PCON_HI) {
        $this->PCON_HI = $PCON_HI;
    }

    function setPCON_VH($PCON_VH) {
        $this->PCON_VH = $PCON_VH;
    }

    function setAPEX_VL($APEX_VL) {
        $this->APEX_VL = $APEX_VL;
    }

    function setAPEX_LO($APEX_LO) {
        $this->APEX_LO = $APEX_LO;
    }

    function setAPEX_NO($APEX_NO) {
        $this->APEX_NO = $APEX_NO;
    }

    function setAPEX_HI($APEX_HI) {
        $this->APEX_HI = $APEX_HI;
    }

    function setAPEX_VH($APEX_VH) {
        $this->APEX_VH = $APEX_VH;
    }

    function setPLEX_VL($PLEX_VL) {
        $this->PLEX_VL = $PLEX_VL;
    }

    function setPLEX_LO($PLEX_LO) {
        $this->PLEX_LO = $PLEX_LO;
    }

    function setPLEX_NO($PLEX_NO) {
        $this->PLEX_NO = $PLEX_NO;
    }

    function setPLEX_HI($PLEX_HI) {
        $this->PLEX_HI = $PLEX_HI;
    }

    function setPLEX_VH($PLEX_VH) {
        $this->PLEX_VH = $PLEX_VH;
    }

    function setLTEX_VL($LTEX_VL) {
        $this->LTEX_VL = $LTEX_VL;
    }

    function setLTEX_LO($LTEX_LO) {
        $this->LTEX_LO = $LTEX_LO;
    }

    function setLTEX_NO($LTEX_NO) {
        $this->LTEX_NO = $LTEX_NO;
    }

    function setLTEX_HI($LTEX_HI) {
        $this->LTEX_HI = $LTEX_HI;
    }

    function setLTEX_VH($LTEX_VH) {
        $this->LTEX_VH = $LTEX_VH;
    }

    function setTOOL_VL($TOOL_VL) {
        $this->TOOL_VL = $TOOL_VL;
    }

    function setTOOL_LO($TOOL_LO) {
        $this->TOOL_LO = $TOOL_LO;
    }

    function setTOOL_NO($TOOL_NO) {
        $this->TOOL_NO = $TOOL_NO;
    }

    function setTOOL_HI($TOOL_HI) {
        $this->TOOL_HI = $TOOL_HI;
    }

    function setTOOL_VH($TOOL_VH) {
        $this->TOOL_VH = $TOOL_VH;
    }

    function setSITE_VL($SITE_VL) {
        $this->SITE_VL = $SITE_VL;
    }

    function setSITE_LO($SITE_LO) {
        $this->SITE_LO = $SITE_LO;
    }

    function setSITE_NO($SITE_NO) {
        $this->SITE_NO = $SITE_NO;
    }

    function setSITE_HI($SITE_HI) {
        $this->SITE_HI = $SITE_HI;
    }

    function setSITE_VH($SITE_VH) {
        $this->SITE_VH = $SITE_VH;
    }

    function setSITE_EH($SITE_EH) {
        $this->SITE_EH = $SITE_EH;
    }

    function setSCED_VL($SCED_VL) {
        $this->SCED_VL = $SCED_VL;
    }

    function setSCED_LO($SCED_LO) {
        $this->SCED_LO = $SCED_LO;
    }

    function setSCED_NO($SCED_NO) {
        $this->SCED_NO = $SCED_NO;
    }

    function setSCED_HI($SCED_HI) {
        $this->SCED_HI = $SCED_HI;
    }

    function setSCED_VH($SCED_VH) {
        $this->SCED_VH = $SCED_VH;
    }

    function setED_PERS_XL($ED_PERS_XL) {
        $this->ED_PERS_XL = $ED_PERS_XL;
    }

    function setED_PERS_VL($ED_PERS_VL) {
        $this->ED_PERS_VL = $ED_PERS_VL;
    }

    function setED_PERS_LO($ED_PERS_LO) {
        $this->ED_PERS_LO = $ED_PERS_LO;
    }

    function setED_PERS_NO($ED_PERS_NO) {
        $this->ED_PERS_NO = $ED_PERS_NO;
    }

    function setED_PERS_HI($ED_PERS_HI) {
        $this->ED_PERS_HI = $ED_PERS_HI;
    }

    function setED_PERS_VH($ED_PERS_VH) {
        $this->ED_PERS_VH = $ED_PERS_VH;
    }

    function setED_PERS_EH($ED_PERS_EH) {
        $this->ED_PERS_EH = $ED_PERS_EH;
    }

    function setED_RCPX_XL($ED_RCPX_XL) {
        $this->ED_RCPX_XL = $ED_RCPX_XL;
    }

    function setED_RCPX_VL($ED_RCPX_VL) {
        $this->ED_RCPX_VL = $ED_RCPX_VL;
    }

    function setED_RCPX_LO($ED_RCPX_LO) {
        $this->ED_RCPX_LO = $ED_RCPX_LO;
    }

    function setED_RCPX_NO($ED_RCPX_NO) {
        $this->ED_RCPX_NO = $ED_RCPX_NO;
    }

    function setED_RCPX_HI($ED_RCPX_HI) {
        $this->ED_RCPX_HI = $ED_RCPX_HI;
    }

    function setED_RCPX_VH($ED_RCPX_VH) {
        $this->ED_RCPX_VH = $ED_RCPX_VH;
    }

    function setED_RCPX_EH($ED_RCPX_EH) {
        $this->ED_RCPX_EH = $ED_RCPX_EH;
    }

    function setED_PDIF_LO($ED_PDIF_LO) {
        $this->ED_PDIF_LO = $ED_PDIF_LO;
    }

    function setED_PDIF_NO($ED_PDIF_NO) {
        $this->ED_PDIF_NO = $ED_PDIF_NO;
    }

    function setED_PDIF_HI($ED_PDIF_HI) {
        $this->ED_PDIF_HI = $ED_PDIF_HI;
    }

    function setED_PDIF_VH($ED_PDIF_VH) {
        $this->ED_PDIF_VH = $ED_PDIF_VH;
    }

    function setED_PDIF_EH($ED_PDIF_EH) {
        $this->ED_PDIF_EH = $ED_PDIF_EH;
    }

    function setED_PREX_XL($ED_PREX_XL) {
        $this->ED_PREX_XL = $ED_PREX_XL;
    }

    function setED_PREX_VL($ED_PREX_VL) {
        $this->ED_PREX_VL = $ED_PREX_VL;
    }

    function setED_PREX_LO($ED_PREX_LO) {
        $this->ED_PREX_LO = $ED_PREX_LO;
    }

    function setED_PREX_NO($ED_PREX_NO) {
        $this->ED_PREX_NO = $ED_PREX_NO;
    }

    function setED_PREX_HI($ED_PREX_HI) {
        $this->ED_PREX_HI = $ED_PREX_HI;
    }

    function setED_PREX_VH($ED_PREX_VH) {
        $this->ED_PREX_VH = $ED_PREX_VH;
    }

    function setED_PREX_EH($ED_PREX_EH) {
        $this->ED_PREX_EH = $ED_PREX_EH;
    }

    function setED_FCIL_XL($ED_FCIL_XL) {
        $this->ED_FCIL_XL = $ED_FCIL_XL;
    }

    function setED_FCIL_VL($ED_FCIL_VL) {
        $this->ED_FCIL_VL = $ED_FCIL_VL;
    }

    function setED_FCIL_LO($ED_FCIL_LO) {
        $this->ED_FCIL_LO = $ED_FCIL_LO;
    }

    function setED_FCIL_NO($ED_FCIL_NO) {
        $this->ED_FCIL_NO = $ED_FCIL_NO;
    }

    function setED_FCIL_HI($ED_FCIL_HI) {
        $this->ED_FCIL_HI = $ED_FCIL_HI;
    }

    function setED_FCIL_VH($ED_FCIL_VH) {
        $this->ED_FCIL_VH = $ED_FCIL_VH;
    }

    function setED_FCIL_EH($ED_FCIL_EH) {
        $this->ED_FCIL_EH = $ED_FCIL_EH;
    }

    function setED_RUSE_LO($ED_RUSE_LO) {
        $this->ED_RUSE_LO = $ED_RUSE_LO;
    }

    function setED_RUSE_NO($ED_RUSE_NO) {
        $this->ED_RUSE_NO = $ED_RUSE_NO;
    }

    function setED_RUSE_HI($ED_RUSE_HI) {
        $this->ED_RUSE_HI = $ED_RUSE_HI;
    }

    function setED_RUSE_VH($ED_RUSE_VH) {
        $this->ED_RUSE_VH = $ED_RUSE_VH;
    }

    function setED_RUSE_EH($ED_RUSE_EH) {
        $this->ED_RUSE_EH = $ED_RUSE_EH;
    }

    function setED_SCED_VL($ED_SCED_VL) {
        $this->ED_SCED_VL = $ED_SCED_VL;
    }

    function setED_SCED_LO($ED_SCED_LO) {
        $this->ED_SCED_LO = $ED_SCED_LO;
    }

    function setED_SCED_NO($ED_SCED_NO) {
        $this->ED_SCED_NO = $ED_SCED_NO;
    }

    function setED_SCED_HI($ED_SCED_HI) {
        $this->ED_SCED_HI = $ED_SCED_HI;
    }

    function setED_SCED_VH($ED_SCED_VH) {
        $this->ED_SCED_VH = $ED_SCED_VH;
    }

    function setEsforco($esforco) {
        $this->esforco = $esforco;
    }

    function setCronograma($cronograma) {
        $this->cronograma = $cronograma;
    }

    function setCusto($custo) {
        $this->custo = $custo;
    }

    function setCusto_pessoa($custo_pessoa) {
        $this->custo_pessoa = $custo_pessoa;
    }

    function setSloc($sloc) {
        $this->sloc = $sloc;
    }

    function setTipo_calculo($tipo_calculo) {
        $this->tipo_calculo = $tipo_calculo;
    }

    function setIdContagem($idContagem) {
        $this->idContagem = $idContagem;
    }

    function setRup_inc_ef($rup_inc_ef) {
        $this->rup_inc_ef = $rup_inc_ef;
    }

    function setRup_inc_sc($rup_inc_sc) {
        $this->rup_inc_sc = $rup_inc_sc;
    }

    function setRup_ela_ef($rup_ela_ef) {
        $this->rup_ela_ef = $rup_ela_ef;
    }

    function setRup_ela_sc($rup_ela_sc) {
        $this->rup_ela_sc = $rup_ela_sc;
    }

    function setRup_con_ef($rup_con_ef) {
        $this->rup_con_ef = $rup_con_ef;
    }

    function setRup_con_sc($rup_con_sc) {
        $this->rup_con_sc = $rup_con_sc;
    }

    function setRup_tra_ef($rup_tra_ef) {
        $this->rup_tra_ef = $rup_tra_ef;
    }

    function setRup_tra_sc($rup_tra_sc) {
        $this->rup_tra_sc = $rup_tra_sc;
    }

    function setCoc_inc_ef($coc_inc_ef) {
        $this->coc_inc_ef = $coc_inc_ef;
    }

    function setCoc_inc_sc($coc_inc_sc) {
        $this->coc_inc_sc = $coc_inc_sc;
    }

    function setCoc_ela_ef($coc_ela_ef) {
        $this->coc_ela_ef = $coc_ela_ef;
    }

    function setCoc_ela_sc($coc_ela_sc) {
        $this->coc_ela_sc = $coc_ela_sc;
    }

    function setCoc_con_ef($coc_con_ef) {
        $this->coc_con_ef = $coc_con_ef;
    }

    function setCoc_con_sc($coc_con_sc) {
        $this->coc_con_sc = $coc_con_sc;
    }

    function setCoc_tra_ef($coc_tra_ef) {
        $this->coc_tra_ef = $coc_tra_ef;
    }

    function setCoc_tra_sc($coc_tra_sc) {
        $this->coc_tra_sc = $coc_tra_sc;
    }

    function setMan_inc($man_inc) {
        $this->man_inc = $man_inc;
    }

    function setMan_ela($man_ela) {
        $this->man_ela = $man_ela;
    }

    function setMan_con($man_con) {
        $this->man_con = $man_con;
    }

    function setMan_tra($man_tra) {
        $this->man_tra = $man_tra;
    }

    function setEnv_inc($env_inc) {
        $this->env_inc = $env_inc;
    }

    function setEnv_ela($env_ela) {
        $this->env_ela = $env_ela;
    }

    function setEnv_con($env_con) {
        $this->env_con = $env_con;
    }

    function setEnv_tra($env_tra) {
        $this->env_tra = $env_tra;
    }

    function setReq_inc($req_inc) {
        $this->req_inc = $req_inc;
    }

    function setReq_ela($req_ela) {
        $this->req_ela = $req_ela;
    }

    function setReq_con($req_con) {
        $this->req_con = $req_con;
    }

    function setReq_tra($req_tra) {
        $this->req_tra = $req_tra;
    }

    function setDes_inc($des_inc) {
        $this->des_inc = $des_inc;
    }

    function setDes_ela($des_ela) {
        $this->des_ela = $des_ela;
    }

    function setDes_con($des_con) {
        $this->des_con = $des_con;
    }

    function setDes_tra($des_tra) {
        $this->des_tra = $des_tra;
    }

    function setImp_inc($imp_inc) {
        $this->imp_inc = $imp_inc;
    }

    function setImp_ela($imp_ela) {
        $this->imp_ela = $imp_ela;
    }

    function setImp_con($imp_con) {
        $this->imp_con = $imp_con;
    }

    function setImp_tra($imp_tra) {
        $this->imp_tra = $imp_tra;
    }

    function setAss_inc($ass_inc) {
        $this->ass_inc = $ass_inc;
    }

    function setAss_ela($ass_ela) {
        $this->ass_ela = $ass_ela;
    }

    function setAss_con($ass_con) {
        $this->ass_con = $ass_con;
    }

    function setAss_tra($ass_tra) {
        $this->ass_tra = $ass_tra;
    }

    function setDep_inc($dep_inc) {
        $this->dep_inc = $dep_inc;
    }

    function setDep_ela($dep_ela) {
        $this->dep_ela = $dep_ela;
    }

    function setDep_con($dep_con) {
        $this->dep_con = $dep_con;
    }

    function setDep_tra($dep_tra) {
        $this->dep_tra = $dep_tra;
    }

    function setVariavel($variavel) {
        $this->variavel = $variavel;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

}
