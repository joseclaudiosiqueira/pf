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
if ($login->isUserLoggedIn() && verificaSessao()) {
    if (NULL !== filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT)) {
        //id da contagem
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        //estatisticas
        $estatisticas = new ContagemEstatisticas();
        $estatisticas->setIdContagem($id);
        //cocomo II.2000
        $estatisticasCocomo = new ContagemEstatisticasCocomo();
        $estatisticasCocomo->setIdContagem($id);
        //estatisticas
        $data_inicio = date_create_from_format('d/m/Y', trim(filter_input(INPUT_POST, 'previsao_inicio')));
        $data_termino = date_create_from_format('d/m/Y', trim(filter_input(INPUT_POST, 'previsao_termino')));
        $estatisticas->setPrevisaoInicio(date_format($data_inicio, 'Y-m-d'));
        $estatisticas->setPrevisaoTermino(date_format($data_termino, 'Y-m-d'));
        $estatisticas->setProdutividadeGlobal(str_replace(' hh/PF', '', filter_input(INPUT_POST, 'produtividade_global')));
        $estatisticas->setIsProdutividadeGlobal(filter_input(INPUT_POST, 'chk_produtividade_global'));
        $estatisticas->setHlt(filter_input(INPUT_POST, 'hlt'));
        $estatisticas->setIsFt(filter_input(INPUT_POST, 'isFt'));
        $estatisticas->setFt(filter_input(INPUT_POST, 'ft'));
        //eng
        $estatisticas->setPctEng(filter_input(INPUT_POST, 'pct-eng'));
        $estatisticas->setProdEng(filter_input(INPUT_POST, 'prod-eng'));
        $estatisticas->setProfEng(filter_input(INPUT_POST, 'prof-eng'));
        $estatisticas->setPerfEng(filter_input(INPUT_POST, 'perf-eng'));
        $estatisticas->setChkEng(filter_input(INPUT_POST, 'chk-eng'));
        $estatisticas->setIsFEng(filter_input(INPUT_POST, 'is-f-eng'));
        $estatisticas->setDescFEng(filter_input(INPUT_POST, 'desc-f-eng'));
        //des
        $estatisticas->setPctDes(filter_input(INPUT_POST, 'pct-des'));
        $estatisticas->setProdDes(filter_input(INPUT_POST, 'prod-des'));
        $estatisticas->setProfDes(filter_input(INPUT_POST, 'prof-des'));
        $estatisticas->setPerfDes(filter_input(INPUT_POST, 'perf-des'));
        $estatisticas->setChkDes(filter_input(INPUT_POST, 'chk-des'));
        $estatisticas->setIsFDes(filter_input(INPUT_POST, 'is-f-des'));
        $estatisticas->setDescFDes(filter_input(INPUT_POST, 'desc-f-des'));
        //imp
        $estatisticas->setPctImp(filter_input(INPUT_POST, 'pct-imp'));
        $estatisticas->setProdImp(filter_input(INPUT_POST, 'prod-imp'));
        $estatisticas->setProfImp(filter_input(INPUT_POST, 'prof-imp'));
        $estatisticas->setPerfImp(filter_input(INPUT_POST, 'perf-imp'));
        $estatisticas->setChkImp(filter_input(INPUT_POST, 'chk-imp'));
        $estatisticas->setIsFImp(filter_input(INPUT_POST, 'is-f-imp'));
        $estatisticas->setDescFImp(filter_input(INPUT_POST, 'desc-f-imp'));
        //tes
        $estatisticas->setPctTes(filter_input(INPUT_POST, 'pct-tes'));
        $estatisticas->setProdTes(filter_input(INPUT_POST, 'prod-tes'));
        $estatisticas->setProfTes(filter_input(INPUT_POST, 'prof-tes'));
        $estatisticas->setPerfTes(filter_input(INPUT_POST, 'perf-tes'));
        $estatisticas->setChkTes(filter_input(INPUT_POST, 'chk-tes'));
        $estatisticas->setIsFTes(filter_input(INPUT_POST, 'is-f-tes'));
        $estatisticas->setDescFTes(filter_input(INPUT_POST, 'desc-f-tes'));
        //hom
        $estatisticas->setPctHom(filter_input(INPUT_POST, 'pct-hom'));
        $estatisticas->setProdHom(filter_input(INPUT_POST, 'prod-hom'));
        $estatisticas->setProfHom(filter_input(INPUT_POST, 'prof-hom'));
        $estatisticas->setPerfHom(filter_input(INPUT_POST, 'perf-hom'));
        $estatisticas->setChkHom(filter_input(INPUT_POST, 'chk-hom'));
        $estatisticas->setIsFHom(filter_input(INPUT_POST, 'is-f-hom'));
        $estatisticas->setDescFHom(filter_input(INPUT_POST, 'desc-f-hom'));
        //impl
        $estatisticas->setPctImpl(filter_input(INPUT_POST, 'pct-impl'));
        $estatisticas->setProdImpl(filter_input(INPUT_POST, 'prod-impl'));
        $estatisticas->setProfImpl(filter_input(INPUT_POST, 'prof-impl'));
        $estatisticas->setPerfImpl(filter_input(INPUT_POST, 'perf-impl'));
        $estatisticas->setChkImpl(filter_input(INPUT_POST, 'chk-impl'));
        $estatisticas->setIsFImpl(filter_input(INPUT_POST, 'is-f-impl'));
        $estatisticas->setDescFImpl(filter_input(INPUT_POST, 'desc-f-impl'));
        //expoente
        $estatisticas->setExpoente(filter_input(INPUT_POST, 'expoente'));
        //prazos
        $estatisticas->setCalculado(filter_input(INPUT_POST, 'calculado'));
        $estatisticas->setTempoDesenvolvimento(filter_input(INPUT_POST, 'tempo-desenvolvimento'));
        $estatisticas->setRegiaoImpossivel(filter_input(INPUT_POST, 'regiao-impossivel'));
        $estatisticas->setMenorCusto(filter_input(INPUT_POST, 'menor-custo'));
        //previsoes
        $estatisticas->setPrevisaoFEng(filter_input(INPUT_POST, 'previsao-f-eng'));
        $estatisticas->setPrevisaoFDes(filter_input(INPUT_POST, 'previsao-f-des'));
        $estatisticas->setPrevisaoFImp(filter_input(INPUT_POST, 'previsao-f-imp'));
        $estatisticas->setPrevisaoFTes(filter_input(INPUT_POST, 'previsao-f-tes'));
        $estatisticas->setPrevisaoFHom(filter_input(INPUT_POST, 'previsao-f-hom'));
        $estatisticas->setPrevisaoFImpl(filter_input(INPUT_POST, 'previsao-f-impl'));
        //esforco
        $estatisticas->setEsforcoFEng(filter_input(INPUT_POST, 'esforco-f-eng'));
        $estatisticas->setEsforcoFDes(filter_input(INPUT_POST, 'esforco-f-des'));
        $estatisticas->setEsforcoFImp(filter_input(INPUT_POST, 'esforco-f-imp'));
        $estatisticas->setEsforcoFTes(filter_input(INPUT_POST, 'esforco-f-tes'));
        $estatisticas->setEsforcoFHom(filter_input(INPUT_POST, 'esforco-f-hom'));
        $estatisticas->setEsforcoFImpl(filter_input(INPUT_POST, 'esforco-f-impl'));
        //percentuais pfa
        $estatisticas->setPctPFAEng(filter_input(INPUT_POST, 'pct-pfa-eng'));
        $estatisticas->setPctPFADes(filter_input(INPUT_POST, 'pct-pfa-des'));
        $estatisticas->setPctPFAImp(filter_input(INPUT_POST, 'pct-pfa-imp'));
        $estatisticas->setPctPFATes(filter_input(INPUT_POST, 'pct-pfa-tes'));
        $estatisticas->setPctPFAHom(filter_input(INPUT_POST, 'pct-pfa-hom'));
        $estatisticas->setPctPFAImpl(filter_input(INPUT_POST, 'pct-pfa-impl'));
        //produtividade das linguagens
        $estatisticas->setIsProdutividadeLinguagem(filter_input(INPUT_POST, 'chk-produtividade-linguagem'));
        $estatisticas->setEscalaProdutividade(filter_input(INPUT_POST, 'escala-produtividade'));
        $estatisticas->setProdutividadeBaixa(filter_input(INPUT_POST, 'produtividade-baixa'));
        $estatisticas->setProdutividadeMedia(filter_input(INPUT_POST, 'produtividade-media'));
        $estatisticas->setProdutividadeAlta(filter_input(INPUT_POST, 'produtividade-alta'));
        //calculos iniciais
        $estatisticas->setHpc(filter_input(INPUT_POST, 'hpc'));
        $estatisticas->setHpa(filter_input(INPUT_POST, 'hpa'));
        $estatisticas->setValorHpc(filter_input(INPUT_POST, 'valor-hpc'));
        $estatisticas->setValorHpa(filter_input(INPUT_POST, 'valor-hpa'));
        $estatisticas->setCustoTotal(filter_input(INPUT_POST, 'custo-total'));
        $estatisticas->setValorPfaContrato(filter_input(INPUT_POST, 'valor-pfa-contrato'));
        //cronograma
        $estatisticas->setAumentoEsforco(filter_input(INPUT_POST, 'aumento-esforco'));
        $estatisticas->setFatorReducaoCronograma(filter_input(INPUT_POST, 'fator-reducao-cronograma'));
        $estatisticas->setTipoProjeto(filter_input(INPUT_POST, 'tipo-projeto'));
        $estatisticas->setEsforcoTotal(filter_input(INPUT_POST, 'esforco-total'));
        $estatisticas->setTamanhoPfa(filter_input(INPUT_POST, 'tamanho-pfa'));
        $estatisticas->setSpanProdutividadeMedia(filter_input(INPUT_POST, 'span-produtividade-media'));
        //cocomo II.2000
        /*
         * insere as estatisticas iniciais do cocomo
         */
        $estatisticasCocomo->setCOCOMO_A(filter_input(INPUT_POST, 'COCOMO_A'));
        $estatisticasCocomo->setCOCOMO_B(filter_input(INPUT_POST, 'COCOMO_B'));
        $estatisticasCocomo->setCOCOMO_C(filter_input(INPUT_POST, 'COCOMO_C'));
        $estatisticasCocomo->setCOCOMO_D(filter_input(INPUT_POST, 'COCOMO_D'));
        $estatisticasCocomo->setED_PERS(filter_input(INPUT_POST, 'ED_PERS'));
        $estatisticasCocomo->setED_RCPX(filter_input(INPUT_POST, 'ED_RCPX'));
        $estatisticasCocomo->setED_PDIF(filter_input(INPUT_POST, 'ED_PDIF'));
        $estatisticasCocomo->setED_PREX(filter_input(INPUT_POST, 'ED_PREX'));
        $estatisticasCocomo->setED_FCIL(filter_input(INPUT_POST, 'ED_FCIL'));
        $estatisticasCocomo->setED_RUSE(filter_input(INPUT_POST, 'ED_RUSE'));
        $estatisticasCocomo->setED_SCED(filter_input(INPUT_POST, 'ED_SCED'));
        $estatisticasCocomo->setPREC(filter_input(INPUT_POST, 'PREC'));
        $estatisticasCocomo->setFLEX(filter_input(INPUT_POST, 'FLEX'));
        $estatisticasCocomo->setRESL(filter_input(INPUT_POST, 'RESL'));
        $estatisticasCocomo->setTEAM(filter_input(INPUT_POST, 'TEAM'));
        $estatisticasCocomo->setPMAT(filter_input(INPUT_POST, 'PMAT'));
        $estatisticasCocomo->setRELY(filter_input(INPUT_POST, 'RELY'));
        $estatisticasCocomo->setDATA(filter_input(INPUT_POST, 'DATA'));
        $estatisticasCocomo->setCPLX_CN(filter_input(INPUT_POST, 'CPLX_CN'));
        $estatisticasCocomo->setCPLX_CO(filter_input(INPUT_POST, 'CPLX_CO'));
        $estatisticasCocomo->setCPLX_DO(filter_input(INPUT_POST, 'CPLX_DO'));
        $estatisticasCocomo->setCPLX_DM(filter_input(INPUT_POST, 'CPLX_DM'));
        $estatisticasCocomo->setCPLX_UI(filter_input(INPUT_POST, 'CPLX_UI'));
        $estatisticasCocomo->setCPLX(filter_input(INPUT_POST, 'CPLX'));
        $estatisticasCocomo->setRUSE(filter_input(INPUT_POST, 'RUSE'));
        $estatisticasCocomo->setDOCU(filter_input(INPUT_POST, 'DOCU'));
        $estatisticasCocomo->setTIME(filter_input(INPUT_POST, 'TIME'));
        $estatisticasCocomo->setSTOR(filter_input(INPUT_POST, 'STOR'));
        $estatisticasCocomo->setPVOL(filter_input(INPUT_POST, 'PVOL'));
        $estatisticasCocomo->setACAP(filter_input(INPUT_POST, 'ACAP'));
        $estatisticasCocomo->setPCAP(filter_input(INPUT_POST, 'PCAP'));
        $estatisticasCocomo->setPCON(filter_input(INPUT_POST, 'PCON'));
        $estatisticasCocomo->setAPEX(filter_input(INPUT_POST, 'APEX'));
        $estatisticasCocomo->setPLEX(filter_input(INPUT_POST, 'PLEX'));
        $estatisticasCocomo->setLTEX(filter_input(INPUT_POST, 'LTEX'));
        $estatisticasCocomo->setTOOL(filter_input(INPUT_POST, 'TOOL'));
        $estatisticasCocomo->setSITE(filter_input(INPUT_POST, 'SITE'));
        $estatisticasCocomo->setSCED(filter_input(INPUT_POST, 'SCED'));
        $estatisticasCocomo->setEsforco(filter_input(INPUT_POST, 'esforco'));
        $estatisticasCocomo->setCronograma(filter_input(INPUT_POST, 'cronograma'));
        $estatisticasCocomo->setCusto(filter_input(INPUT_POST, 'custo'));
        $estatisticasCocomo->setCusto_pessoa(filter_input(INPUT_POST, 'custo_pessoa'));
        $estatisticasCocomo->setSloc(filter_input(INPUT_POST, 'sloc'));
        $estatisticasCocomo->setTipo_calculo(filter_input(INPUT_POST, 'tipo_calculo'));
        //autaliza estatisticas
        $atualiza = $estatisticas->atualiza($id) && $estatisticasCocomo->atualiza($id);
        echo json_encode(array('sucesso' => $atualiza));
    } else {
        echo json_encode(array('sucesso' => true, 'msg' => 'A contagem ainda n&atilde;o foi salva ou n&atilde;o possui um #ID associado'));
    }
} else {
    echo json_encode(array('sucesso' => false, 'msg' => 'Acesso n&atilde;o autorizado!'));
}