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
    /*
     * instancia as classes ContagemAbrangencia, ContagemHistorico e Contagem
     */
    $historico = new ContagemHistorico();
    $estatisticas = new ContagemEstatisticas();
    $estatisticasCocomo = new ContagemEstatisticasCocomo();
    $contagem = new Contagem();
    $contagem->setLog();
    $tr = new Tarefa();
    $baselineEstimativa = new ContagemBaselineEstimativa();
    /*
     * variaveis do $_POST
     */
    $id = NULL !== filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT) : 0;
    $acao = NULL !== filter_input(INPUT_POST, 'acao') ? filter_input(INPUT_POST, 'acao') : 0;
    $idAbrangencia = NULL !== filter_input(INPUT_POST, 'id_abrangencia', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'id_abrangencia', FILTER_SANITIZE_NUMBER_INT) : 0;
    $userId = getUserIdDecoded();
    $idEmpresa = getIdEmpresa();
    $idLinguagem = filter_input(INPUT_POST, 'id_linguagem', FILTER_SANITIZE_NUMBER_INT);
    $idTipoContagem = filter_input(INPUT_POST, 'id_tipo_contagem', FILTER_SANITIZE_NUMBER_INT);
    $idEtapa = filter_input(INPUT_POST, 'id_etapa', FILTER_SANITIZE_NUMBER_INT);
    $idProcesso = filter_input(INPUT_POST, 'id_processo', FILTER_SANITIZE_NUMBER_INT);
    $idProcessoGestao = filter_input(INPUT_POST, 'id_processo_gestao', FILTER_SANITIZE_NUMBER_INT);
    $idBancoDados = filter_input(INPUT_POST, 'id_banco_dados', FILTER_SANITIZE_NUMBER_INT);
    $idIndustria = filter_input(INPUT_POST, 'id_industria', FILTER_SANITIZE_NUMBER_INT);
    $idOrgao = filter_input(INPUT_POST, 'id_orgao', FILTER_SANITIZE_NUMBER_INT);
    $idBaseline = filter_input(INPUT_POST, 'id_baseline', FILTER_SANITIZE_NUMBER_INT);
    $idContagemBaselineInserida = 0;
    $dataCadastro = date('Y-m-d H:i:s');
    $entregas = filter_input(INPUT_POST, 'entregas', FILTER_SANITIZE_NUMBER_INT);
    $responsavel = getEmailUsuarioLogado();
    $gerenteProjeto = filter_input(INPUT_POST, 'gerente_projeto', FILTER_SANITIZE_STRING);
    $idCliente = filter_input(INPUT_POST, 'id_cliente', FILTER_SANITIZE_NUMBER_INT);
    $emailBloqueio = getEmailUsuarioLogado();
    $dataBloqueio = date('Y-m-d H:i:s');
    $isBloqueada = 1;
    $ordemServico = filter_input(INPUT_POST, 'ordem_servico', FILTER_SANITIZE_SPECIAL_CHARS);
    $proposito = filter_input(INPUT_POST, 'proposito', FILTER_SANITIZE_SPECIAL_CHARS);
    $escopo = filter_input(INPUT_POST, 'escopo', FILTER_SANITIZE_SPECIAL_CHARS);
    $idFornecedor = getIdFornecedor();
    $idContrato = filter_input(INPUT_POST, 'id_contrato', FILTER_SANITIZE_NUMBER_INT);
    $idProjeto = filter_input(INPUT_POST, 'id_projeto', FILTER_SANITIZE_NUMBER_INT);
    $privacidade = filter_input(INPUT_POST, 'privacidade', FILTER_SANITIZE_NUMBER_INT);
    $isContagemAuditoria = NULL !== filter_input(INPUT_POST, 'is_contagem_auditoria', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'is_contagem_auditoria', FILTER_SANITIZE_NUMBER_INT) : 0;
    $idRoteiro = filter_input(INPUT_POST, 'id_roteiro', FILTER_SANITIZE_NUMBER_INT);

    $contagem->setUserId($userId);
    $contagem->setIdEmpresa($idEmpresa);
    $contagem->setIdCliente($idCliente); //necessario setar para identificacao nas listagens
    $contagem->setIdLinguagem($idLinguagem);
    $contagem->setIdTipoContagem($idTipoContagem);
    $contagem->setIdEtapa($idEtapa);
    $contagem->setIdProcesso($idProcesso); //processo de desenvolvimento
    $contagem->setIdProcessoGestao($idProcessoGestao); //processo de gestao do desenvolvimento
    $contagem->setIdBancoDados($idBancoDados);
    $contagem->setIdIndustria($idIndustria);
    $contagem->setIdOrgao($idOrgao);
    $contagem->setIdBaseline($idBaseline);
    $contagem->setDataCadastro($dataCadastro);
    $contagem->setEntregas($entregas);
    $contagem->setResponsavel($responsavel);
    $contagem->setGerenteProjeto($gerenteProjeto);
    $contagem->setIsBloqueada($isBloqueada);
    $contagem->setEmailBloqueio($emailBloqueio);
    $contagem->setDataBloqueio($dataBloqueio);
    $contagem->setIsContagemAuditoria($isContagemAuditoria);
    $contagem->setIdRoteiro($idRoteiro);
    /*
     * faz estes sets duas vezes para o caso de estar atualizando a contagem
     */
    $contagem->setIdAbrangencia($idAbrangencia);
    $contagem->setOrdemServico($ordemServico);
    $contagem->setProposito($proposito);
    $contagem->setEscopo($escopo);
    $contagem->setIdFornecedor($idFornecedor);
    $contagem->setIdContrato($idContrato);
    $contagem->setIdProjeto($idProjeto);
    $contagem->setPrivacidade($privacidade);
    $contagem->setIdEtapa($idEtapa);
    /*
     * seta o valor do cliente na sessao
     */
    setIdCliente($idCliente);
    /*
     * pesquisa em BASELINE para ver se ja ha uma contagem de Baseline
     * caso contrario ira criar a BASELINE e a CONTAGEM normal de projeto
     */
    $idContagemBaseline = $contagem->getBaseline($idBaseline)['id'];
    /*
     * inserir uma contagem
     */
    if ($acao === 'in') {
        /*
         * insere as informacoes basicas da contagem e se nao houver, insere uma contagem de baseline
         */
        if (!$idContagemBaseline && $idAbrangencia == 2) {
            $contagem->setIdAbrangencia(3);
            $contagem->setOrdemServico('OS-BASELINE');
            $contagem->setProposito('[' . date('d/m/Y : H:i:s') . '] INSERIDO AUTOMATICAMENTE PELO SISTEMA, CONTAGEM DE BASELINE');
            $contagem->setEscopo('[' . date('d/m/Y : H:i:s') . '] INSERIDO AUTOMATICAMENTE PELO SISTEMA, CONTAGEM DE BASELINE');
            $contagem->setIdFornecedor(0);
            $contagem->setIdContrato(0);
            $contagem->setIdProjeto(0);
            $contagem->setIdOrgao(0);
            $contagem->setPrivacidade(0);
            $contagem->setIdEtapa(1); //sempre detalhada
            /*
             * atribui a contagem de baseline inserida, tem que vir antes
             */
            $idContagemBaselineInserida = $contagem->insere();
        }
        /*
         * reatribui os valores de contagem depois da insercao da baseline
         */
        $contagem->setIdAbrangencia($idAbrangencia);
        $contagem->setOrdemServico($ordemServico);
        $contagem->setProposito($proposito);
        $contagem->setEscopo($escopo);
        $contagem->setIdFornecedor($idFornecedor);
        $contagem->setIdContrato($idContrato);
        $contagem->setIdProjeto($idProjeto);
        $contagem->setIdOrgao($idOrgao);
        $contagem->setPrivacidade($privacidade);
        $contagem->setIdEtapa($idEtapa);
        /*
         * insere a contagem
         */
        $fn = $contagem->insere();
        /*
         * seta o id da contagem na sessao para os arquivos anexos
         */
        setIdContagem($fn);
        /*
         * seta o historico da insercao, novo metodo de acompanhamento dos processos
         */
        $dataInicio = date('Y-m-d H:i:s');
        $prazoElaboracao = '+30 days';
        $dataFim = date('Y-m-d H:i:s', strtotime($prazoElaboracao));
        $tr->setIdEmpresa(getIdEmpresa());
        $tr->setIdFornecedor(getIdFornecedor());
        $tr->setUserEmailSolicitante(getEmailUsuarioLogado());
        $tr->setUserIdSolicitante(getUserIdDecoded());
        $tr->setUserEmailExecutor(getEmailUsuarioLogado());
        $tr->setUserIdExecutor(getUserIdDecoded());
        $tr->setDataInicio(date('Y-m-d H:i:s'));
        $tr->setDataFim($dataFim);
        /*
         * mais um ponto de verificacao para a abrangencia
         */
        if (!$idContagemBaseline && $idAbrangencia == 2) {
            /*
             * 3 - BASELINE, 4 - LICITACAO E TODAS AS OUTRAS
             * forca para abrangencia = 3
             */
            $idAbrangenciaForceps = 3;
            $descricao = ($idAbrangenciaForceps == 3 || $idAbrangenciaForceps == 4) ? 'ELABORACAO DE CONTAGEM DE ' . ($idAbrangenciaForceps == 3 ? 'BASELINE' : 'LICITACAO') . '#ID: ' . str_pad($idContagemBaselineInserida, 7, '0', STR_PAD_LEFT) : 'ELABORACAO DE CONTAGEM #ID: ' . str_pad($idContagemBaselineInserida, 7, '0', STR_PAD_LEFT);
            /*
             * 20 - ELABORACAO DE CONTAGEM DE BASELINE //21 - ELABORACAO DE CONTAGEM DE LICITACAO //14 - TODAS AS OUTRAS
             */
            $tr->setIdTipo(($idAbrangenciaForceps == 3 || $idAbrangenciaForceps == 4) ? ($idAbrangenciaForceps == 3 ? 20 : 21) : 14);
            /*
             * seta o id da contagem
             */
            $tr->setIdContagem($idContagemBaselineInserida);
            /*
             * seta a nova descricao
             */
            $tr->setDescricao($descricao);
            /*
             * insere uma tarefa para a baseline cadastrada
             */
            $idTarefa = $tr->insere();
        }
        /*
         * seta o id contagem novamente
         */
        $tr->setIdContagem($fn);
        /*
         * 20 - ELABORACAO DE CONTAGEM DE BASELINE //21 - ELABORACAO DE CONTAGEM DE LICITACAO //14 - TODAS AS OUTRAS
         */
        $tr->setIdTipo(($idAbrangencia == 3 || $idAbrangencia == 4) ? ($idAbrangencia == 3 ? 20 : 21) : 14);
        /*
         * 3 - BASELINE, 4 - LICITACAO E TODAS AS OUTRAS
         */
        $descricao = ($idAbrangencia == 3 || $idAbrangencia == 4) ? 'ELABORACAO DE CONTAGEM DE ' . ($idAbrangencia == 3 ? 'BASELINE' : 'LICITACAO') . '#ID: ' . str_pad($fn, 7, '0', STR_PAD_LEFT) : 'ELABORACAO DE CONTAGEM #ID: ' . str_pad($fn, 7, '0', STR_PAD_LEFT);
        $tr->setDescricao($descricao);
        /*
         * insere a tarefa da contagem
         */
        $idTarefa = $tr->insere();
        /*
         * historico da contagem
         */
        $historico->setDataInicio($dataInicio);
        $historico->setAtualizadoPor(getEmailUsuarioLogado());
        $historico->setIdTarefa($idTarefa);
        /*
         * mais um ponto de verificacao para a abrangencia
         */
        if (!$idContagemBaseline && $idAbrangencia == 2) {
            /*
             * insere o historico da contagem com o processo inicial de elaboracao
             * 1 - Em elaboracao
             * 18 - Contagem de Baseline
             * 19 - Contagem de Licitacao
             */
            $idAbrangenciaForceps = 3;
            $idProcesso = ($idAbrangenciaForceps == 3 || $idAbrangenciaForceps == 4) ? ($idAbrangenciaForceps == 3 ? 18 : 19) : 1;
            $historico->setIdProcesso($idProcesso);
            /*
             * seta o id para o historico
             */
            $historico->setIdContagem($idContagemBaselineInserida);
            /*
             * insere o historico na baseline
             */
            $idHistorico = $historico->insere();
        }
        $historico->setIdContagem($fn);
        $idProcesso = ($idAbrangencia == 3 || $idAbrangencia == 4) ? ($idAbrangencia == 3 ? 18 : 19) : 1;
        $historico->setIdProcesso($idProcesso);
        $idHistorico = $historico->insere();
        /*
         * separa as contagens de Baseline e Licitacao e baixa todas as atividades
         */
        if ($idAbrangencia == 3 || $idAbrangencia == 4) {
            
        }
        /*
         * apenas para as estatisticas
         */
        if ($idAbrangencia != 5) {
            /*
             * insere as estatisticas iniciais da contagem
             */
            $estatisticas->setLog();
            $data_inicio = date_create_from_format('j/m/Y', filter_input(INPUT_POST, 'previsao_inicio'));
            $estatisticas->setPrevisaoInicio(date_format($data_inicio, 'Y-m-d'));
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
            //calculos iniciais
            $estatisticas->setHpc(filter_input(INPUT_POST, 'hpc'));
            $estatisticas->setHpa(filter_input(INPUT_POST, 'hpa'));
            $estatisticas->setValorHpc(filter_input(INPUT_POST, 'valor-hpc'));
            $estatisticas->setValorHpa(filter_input(INPUT_POST, 'valor-hpa'));
            $estatisticas->setCustoTotal(is_int(filter_input(INPUT_POST, 'custo-total')) ? filter_input(INPUT_POST, 'custo-total') : 0);
            $estatisticas->setValorPfaContrato(filter_input(INPUT_POST, 'valor-pfa-contrato'));
            //cronograma
            $estatisticas->setAumentoEsforco(filter_input(INPUT_POST, 'aumento-esforco'));
            $estatisticas->setFatorReducaoCronograma(filter_input(INPUT_POST, 'fator-reducao-cronograma'));
            $estatisticas->setTipoProjeto(filter_input(INPUT_POST, 'tipo-projeto'));
            $estatisticas->setEsforcoTotal(filter_input(INPUT_POST, 'esforco-total'));
            $estatisticas->setTamanhoPfa(filter_input(INPUT_POST, 'tamanho-pfa'));
            $estatisticas->setSpanProdutividadeMedia(filter_input(INPUT_POST, 'span-produtividade-media'));
            //insere
            if (!$idContagemBaseline && $idAbrangencia == 2) {
                $estatisticas->setIdContagem($idContagemBaselineInserida);
                $estatisticas->insere();
            }
            $estatisticas->setIdContagem($fn);
            $estatisticas->insere();
            /*
             * insere as estatisticas iniciais do cocomo
             */
            $estatisticasCocomo->setCOCOMO_A(getConfigCocomo('COCOMO_A'));
            $estatisticasCocomo->setCOCOMO_B(getConfigCocomo('COCOMO_B'));
            $estatisticasCocomo->setCOCOMO_C(getConfigCocomo('COCOMO_C'));
            $estatisticasCocomo->setCOCOMO_D(getConfigCocomo('COCOMO_D'));
            $estatisticasCocomo->setED_PERS(getConfigCocomo('DEF_ED_PERS'));
            $estatisticasCocomo->setED_RCPX(getConfigCocomo('DEF_ED_RCPX'));
            $estatisticasCocomo->setED_PDIF(getConfigCocomo('DEF_ED_PDIF'));
            $estatisticasCocomo->setED_PREX(getConfigCocomo('DEF_ED_PREX'));
            $estatisticasCocomo->setED_FCIL(getConfigCocomo('DEF_ED_FCIL'));
            $estatisticasCocomo->setED_RUSE(getConfigCocomo('DEF_ED_RUSE'));
            $estatisticasCocomo->setED_SCED(getConfigCocomo('DEF_ED_SCED'));
            $estatisticasCocomo->setPREC(getConfigCocomo('DEF_PREC'));
            $estatisticasCocomo->setFLEX(getConfigCocomo('DEF_FLEX'));
            $estatisticasCocomo->setRESL(getConfigCocomo('DEF_RESL'));
            $estatisticasCocomo->setTEAM(getConfigCocomo('DEF_TEAM'));
            $estatisticasCocomo->setPMAT(getConfigCocomo('DEF_PMAT'));
            $estatisticasCocomo->setRELY(getConfigCocomo('DEF_RELY'));
            $estatisticasCocomo->setDATA(getConfigCocomo('DEF_DATA'));
            $estatisticasCocomo->setCPLX_CN(getConfigCocomo('DEF_CPLX_CN'));
            $estatisticasCocomo->setCPLX_CO(getConfigCocomo('DEF_CPLX_CO'));
            $estatisticasCocomo->setCPLX_DO(getConfigCocomo('DEF_CPLX_DO'));
            $estatisticasCocomo->setCPLX_DM(getConfigCocomo('DEF_CPLX_DM'));
            $estatisticasCocomo->setCPLX_UI(getConfigCocomo('DEF_CPLX_UI'));
            $estatisticasCocomo->setCPLX(getConfigCocomo('DEF_CPLX'));
            $estatisticasCocomo->setRUSE(getConfigCocomo('DEF_RUSE'));
            $estatisticasCocomo->setDOCU(getConfigCocomo('DEF_DOCU'));
            $estatisticasCocomo->setTIME(getConfigCocomo('DEF_TIME'));
            $estatisticasCocomo->setSTOR(getConfigCocomo('DEF_STOR'));
            $estatisticasCocomo->setPVOL(getConfigCocomo('DEF_PVOL'));
            $estatisticasCocomo->setACAP(getConfigCocomo('DEF_ACAP'));
            $estatisticasCocomo->setPCAP(getConfigCocomo('DEF_PCAP'));
            $estatisticasCocomo->setPCON(getConfigCocomo('DEF_PCON'));
            $estatisticasCocomo->setAPEX(getConfigCocomo('DEF_APEX'));
            $estatisticasCocomo->setPLEX(getConfigCocomo('DEF_PLEX'));
            $estatisticasCocomo->setLTEX(getConfigCocomo('DEF_LTEX'));
            $estatisticasCocomo->setTOOL(getConfigCocomo('DEF_TOOL'));
            $estatisticasCocomo->setSITE(getConfigCocomo('DEF_SITE'));
            $estatisticasCocomo->setSCED(getConfigCocomo('DEF_SCED'));
            $estatisticasCocomo->setPREC_VL(getConfigCocomo('PREC_VL'));
            $estatisticasCocomo->setPREC_LO(getConfigCocomo('PREC_LO'));
            $estatisticasCocomo->setPREC_NO(getConfigCocomo('PREC_NO'));
            $estatisticasCocomo->setPREC_HI(getConfigCocomo('PREC_HI'));
            $estatisticasCocomo->setPREC_VH(getConfigCocomo('PREC_VH'));
            $estatisticasCocomo->setPREC_EH(getConfigCocomo('PREC_EH'));
            $estatisticasCocomo->setFLEX_VL(getConfigCocomo('FLEX_VL'));
            $estatisticasCocomo->setFLEX_LO(getConfigCocomo('FLEX_LO'));
            $estatisticasCocomo->setFLEX_NO(getConfigCocomo('FLEX_NO'));
            $estatisticasCocomo->setFLEX_HI(getConfigCocomo('FLEX_HI'));
            $estatisticasCocomo->setFLEX_VH(getConfigCocomo('FLEX_VH'));
            $estatisticasCocomo->setFLEX_EH(getConfigCocomo('FLEX_EH'));
            $estatisticasCocomo->setRESL_VL(getConfigCocomo('RESL_VL'));
            $estatisticasCocomo->setRESL_LO(getConfigCocomo('RESL_LO'));
            $estatisticasCocomo->setRESL_NO(getConfigCocomo('RESL_NO'));
            $estatisticasCocomo->setRESL_HI(getConfigCocomo('RESL_HI'));
            $estatisticasCocomo->setRESL_VH(getConfigCocomo('RESL_VH'));
            $estatisticasCocomo->setRESL_EH(getConfigCocomo('RESL_EH'));
            $estatisticasCocomo->setTEAM_VL(getConfigCocomo('TEAM_VL'));
            $estatisticasCocomo->setTEAM_LO(getConfigCocomo('TEAM_LO'));
            $estatisticasCocomo->setTEAM_NO(getConfigCocomo('TEAM_NO'));
            $estatisticasCocomo->setTEAM_HI(getConfigCocomo('TEAM_HI'));
            $estatisticasCocomo->setTEAM_VH(getConfigCocomo('TEAM_VH'));
            $estatisticasCocomo->setTEAM_EH(getConfigCocomo('TEAM_EH'));
            $estatisticasCocomo->setPMAT_VL(getConfigCocomo('PMAT_VL'));
            $estatisticasCocomo->setPMAT_LO(getConfigCocomo('PMAT_LO'));
            $estatisticasCocomo->setPMAT_NO(getConfigCocomo('PMAT_NO'));
            $estatisticasCocomo->setPMAT_HI(getConfigCocomo('PMAT_HI'));
            $estatisticasCocomo->setPMAT_VH(getConfigCocomo('PMAT_VH'));
            $estatisticasCocomo->setPMAT_EH(getConfigCocomo('PMAT_EH'));
            $estatisticasCocomo->setRELY_VL(getConfigCocomo('RELY_VL'));
            $estatisticasCocomo->setRELY_LO(getConfigCocomo('RELY_LO'));
            $estatisticasCocomo->setRELY_NO(getConfigCocomo('RELY_NO'));
            $estatisticasCocomo->setRELY_HI(getConfigCocomo('RELY_HI'));
            $estatisticasCocomo->setRELY_VH(getConfigCocomo('RELY_VH'));
            $estatisticasCocomo->setDATA_LO(getConfigCocomo('DATA_LO'));
            $estatisticasCocomo->setDATA_NO(getConfigCocomo('DATA_NO'));
            $estatisticasCocomo->setDATA_HI(getConfigCocomo('DATA_HI'));
            $estatisticasCocomo->setDATA_VH(getConfigCocomo('DATA_VH'));
            $estatisticasCocomo->setCPLX_CN_VL(getConfigCocomo('CPLX_CN_VL'));
            $estatisticasCocomo->setCPLX_CN_LO(getConfigCocomo('CPLX_CN_LO'));
            $estatisticasCocomo->setCPLX_CN_NO(getConfigCocomo('CPLX_CN_NO'));
            $estatisticasCocomo->setCPLX_CN_HI(getConfigCocomo('CPLX_CN_HI'));
            $estatisticasCocomo->setCPLX_CN_VH(getConfigCocomo('CPLX_CN_VH'));
            $estatisticasCocomo->setCPLX_CN_EH(getConfigCocomo('CPLX_CN_EH'));
            $estatisticasCocomo->setCPLX_CO_VL(getConfigCocomo('CPLX_CO_VL'));
            $estatisticasCocomo->setCPLX_CO_LO(getConfigCocomo('CPLX_CO_LO'));
            $estatisticasCocomo->setCPLX_CO_NO(getConfigCocomo('CPLX_CO_NO'));
            $estatisticasCocomo->setCPLX_CO_HI(getConfigCocomo('CPLX_CO_HI'));
            $estatisticasCocomo->setCPLX_CO_VH(getConfigCocomo('CPLX_CO_VH'));
            $estatisticasCocomo->setCPLX_CO_EH(getConfigCocomo('CPLX_CO_EH'));
            $estatisticasCocomo->setCPLX_DO_VL(getConfigCocomo('CPLX_DO_VL'));
            $estatisticasCocomo->setCPLX_DO_LO(getConfigCocomo('CPLX_DO_LO'));
            $estatisticasCocomo->setCPLX_DO_NO(getConfigCocomo('CPLX_DO_NO'));
            $estatisticasCocomo->setCPLX_DO_HI(getConfigCocomo('CPLX_DO_HI'));
            $estatisticasCocomo->setCPLX_DO_VH(getConfigCocomo('CPLX_DO_VH'));
            $estatisticasCocomo->setCPLX_DO_EH(getConfigCocomo('CPLX_DO_EH'));
            $estatisticasCocomo->setCPLX_DM_VL(getConfigCocomo('CPLX_DM_VL'));
            $estatisticasCocomo->setCPLX_DM_LO(getConfigCocomo('CPLX_DM_LO'));
            $estatisticasCocomo->setCPLX_DM_NO(getConfigCocomo('CPLX_DM_NO'));
            $estatisticasCocomo->setCPLX_DM_HI(getConfigCocomo('CPLX_DM_HI'));
            $estatisticasCocomo->setCPLX_DM_VH(getConfigCocomo('CPLX_DM_VH'));
            $estatisticasCocomo->setCPLX_DM_EH(getConfigCocomo('CPLX_DM_EH'));
            $estatisticasCocomo->setCPLX_UI_VL(getConfigCocomo('CPLX_UI_VL'));
            $estatisticasCocomo->setCPLX_UI_LO(getConfigCocomo('CPLX_UI_LO'));
            $estatisticasCocomo->setCPLX_UI_NO(getConfigCocomo('CPLX_UI_NO'));
            $estatisticasCocomo->setCPLX_UI_HI(getConfigCocomo('CPLX_UI_HI'));
            $estatisticasCocomo->setCPLX_UI_VH(getConfigCocomo('CPLX_UI_VH'));
            $estatisticasCocomo->setCPLX_UI_EH(getConfigCocomo('CPLX_UI_EH'));
            $estatisticasCocomo->setCPLX_VL(getConfigCocomo('CPLX_VL'));
            $estatisticasCocomo->setCPLX_LO(getConfigCocomo('CPLX_LO'));
            $estatisticasCocomo->setCPLX_NO(getConfigCocomo('CPLX_NO'));
            $estatisticasCocomo->setCPLX_HI(getConfigCocomo('CPLX_HI'));
            $estatisticasCocomo->setCPLX_VH(getConfigCocomo('CPLX_VH'));
            $estatisticasCocomo->setCPLX_EH(getConfigCocomo('CPLX_EH'));
            $estatisticasCocomo->setRUSE_LO(getConfigCocomo('RUSE_LO'));
            $estatisticasCocomo->setRUSE_NO(getConfigCocomo('RUSE_NO'));
            $estatisticasCocomo->setRUSE_HI(getConfigCocomo('RUSE_HI'));
            $estatisticasCocomo->setRUSE_VH(getConfigCocomo('RUSE_VH'));
            $estatisticasCocomo->setRUSE_EH(getConfigCocomo('RUSE_EH'));
            $estatisticasCocomo->setDOCU_VL(getConfigCocomo('DOCU_VL'));
            $estatisticasCocomo->setDOCU_LO(getConfigCocomo('DOCU_LO'));
            $estatisticasCocomo->setDOCU_NO(getConfigCocomo('DOCU_NO'));
            $estatisticasCocomo->setDOCU_HI(getConfigCocomo('DOCU_HI'));
            $estatisticasCocomo->setDOCU_VH(getConfigCocomo('DOCU_VH'));
            $estatisticasCocomo->setTIME_NO(getConfigCocomo('TIME_NO'));
            $estatisticasCocomo->setTIME_HI(getConfigCocomo('TIME_HI'));
            $estatisticasCocomo->setTIME_VH(getConfigCocomo('TIME_VH'));
            $estatisticasCocomo->setTIME_EH(getConfigCocomo('TIME_EH'));
            $estatisticasCocomo->setSTOR_NO(getConfigCocomo('STOR_NO'));
            $estatisticasCocomo->setSTOR_HI(getConfigCocomo('STOR_HI'));
            $estatisticasCocomo->setSTOR_VH(getConfigCocomo('STOR_VH'));
            $estatisticasCocomo->setSTOR_EH(getConfigCocomo('STOR_EH'));
            $estatisticasCocomo->setPVOL_LO(getConfigCocomo('PVOL_LO'));
            $estatisticasCocomo->setPVOL_NO(getConfigCocomo('PVOL_NO'));
            $estatisticasCocomo->setPVOL_HI(getConfigCocomo('PVOL_HI'));
            $estatisticasCocomo->setPVOL_VH(getConfigCocomo('PVOL_VH'));
            $estatisticasCocomo->setACAP_VL(getConfigCocomo('ACAP_VL'));
            $estatisticasCocomo->setACAP_LO(getConfigCocomo('ACAP_LO'));
            $estatisticasCocomo->setACAP_NO(getConfigCocomo('ACAP_NO'));
            $estatisticasCocomo->setACAP_HI(getConfigCocomo('ACAP_HI'));
            $estatisticasCocomo->setACAP_VH(getConfigCocomo('ACAP_VH'));
            $estatisticasCocomo->setPCAP_VL(getConfigCocomo('PCAP_VL'));
            $estatisticasCocomo->setPCAP_LO(getConfigCocomo('PCAP_LO'));
            $estatisticasCocomo->setPCAP_NO(getConfigCocomo('PCAP_NO'));
            $estatisticasCocomo->setPCAP_HI(getConfigCocomo('PCAP_HI'));
            $estatisticasCocomo->setPCAP_VH(getConfigCocomo('PCAP_VH'));
            $estatisticasCocomo->setPCON_VL(getConfigCocomo('PCON_VL'));
            $estatisticasCocomo->setPCON_LO(getConfigCocomo('PCON_LO'));
            $estatisticasCocomo->setPCON_NO(getConfigCocomo('PCON_NO'));
            $estatisticasCocomo->setPCON_HI(getConfigCocomo('PCON_HI'));
            $estatisticasCocomo->setPCON_VH(getConfigCocomo('PCON_VH'));
            $estatisticasCocomo->setAPEX_VL(getConfigCocomo('APEX_VL'));
            $estatisticasCocomo->setAPEX_LO(getConfigCocomo('APEX_LO'));
            $estatisticasCocomo->setAPEX_NO(getConfigCocomo('APEX_NO'));
            $estatisticasCocomo->setAPEX_HI(getConfigCocomo('APEX_HI'));
            $estatisticasCocomo->setAPEX_VH(getConfigCocomo('APEX_VH'));
            $estatisticasCocomo->setPLEX_VL(getConfigCocomo('PLEX_VL'));
            $estatisticasCocomo->setPLEX_LO(getConfigCocomo('PLEX_LO'));
            $estatisticasCocomo->setPLEX_NO(getConfigCocomo('PLEX_NO'));
            $estatisticasCocomo->setPLEX_HI(getConfigCocomo('PLEX_HI'));
            $estatisticasCocomo->setPLEX_VH(getConfigCocomo('PLEX_VH'));
            $estatisticasCocomo->setLTEX_VL(getConfigCocomo('LTEX_VL'));
            $estatisticasCocomo->setLTEX_LO(getConfigCocomo('LTEX_LO'));
            $estatisticasCocomo->setLTEX_NO(getConfigCocomo('LTEX_NO'));
            $estatisticasCocomo->setLTEX_HI(getConfigCocomo('LTEX_HI'));
            $estatisticasCocomo->setLTEX_VH(getConfigCocomo('LTEX_VH'));
            $estatisticasCocomo->setTOOL_VL(getConfigCocomo('TOOL_VL'));
            $estatisticasCocomo->setTOOL_LO(getConfigCocomo('TOOL_LO'));
            $estatisticasCocomo->setTOOL_NO(getConfigCocomo('TOOL_NO'));
            $estatisticasCocomo->setTOOL_HI(getConfigCocomo('TOOL_HI'));
            $estatisticasCocomo->setTOOL_VH(getConfigCocomo('TOOL_VH'));
            $estatisticasCocomo->setSITE_VL(getConfigCocomo('SITE_VL'));
            $estatisticasCocomo->setSITE_LO(getConfigCocomo('SITE_LO'));
            $estatisticasCocomo->setSITE_NO(getConfigCocomo('SITE_NO'));
            $estatisticasCocomo->setSITE_HI(getConfigCocomo('SITE_HI'));
            $estatisticasCocomo->setSITE_VH(getConfigCocomo('SITE_VH'));
            $estatisticasCocomo->setSITE_EH(getConfigCocomo('SITE_EH'));
            $estatisticasCocomo->setSCED_VL(getConfigCocomo('SCED_VL'));
            $estatisticasCocomo->setSCED_LO(getConfigCocomo('SCED_LO'));
            $estatisticasCocomo->setSCED_NO(getConfigCocomo('SCED_NO'));
            $estatisticasCocomo->setSCED_HI(getConfigCocomo('SCED_HI'));
            $estatisticasCocomo->setSCED_VH(getConfigCocomo('SCED_VH'));
            $estatisticasCocomo->setED_PERS_XL(getConfigCocomo('ED_PERS_XL'));
            $estatisticasCocomo->setED_PERS_VL(getConfigCocomo('ED_PERS_VL'));
            $estatisticasCocomo->setED_PERS_LO(getConfigCocomo('ED_PERS_LO'));
            $estatisticasCocomo->setED_PERS_NO(getConfigCocomo('ED_PERS_NO'));
            $estatisticasCocomo->setED_PERS_HI(getConfigCocomo('ED_PERS_HI'));
            $estatisticasCocomo->setED_PERS_VH(getConfigCocomo('ED_PERS_VH'));
            $estatisticasCocomo->setED_PERS_EH(getConfigCocomo('ED_PERS_EH'));
            $estatisticasCocomo->setED_RCPX_XL(getConfigCocomo('ED_RCPX_XL'));
            $estatisticasCocomo->setED_RCPX_VL(getConfigCocomo('ED_RCPX_VL'));
            $estatisticasCocomo->setED_RCPX_LO(getConfigCocomo('ED_RCPX_LO'));
            $estatisticasCocomo->setED_RCPX_NO(getConfigCocomo('ED_RCPX_NO'));
            $estatisticasCocomo->setED_RCPX_HI(getConfigCocomo('ED_RCPX_HI'));
            $estatisticasCocomo->setED_RCPX_VH(getConfigCocomo('ED_RCPX_VH'));
            $estatisticasCocomo->setED_RCPX_EH(getConfigCocomo('ED_RCPX_EH'));
            $estatisticasCocomo->setED_PDIF_LO(getConfigCocomo('ED_PDIF_LO'));
            $estatisticasCocomo->setED_PDIF_NO(getConfigCocomo('ED_PDIF_NO'));
            $estatisticasCocomo->setED_PDIF_HI(getConfigCocomo('ED_PDIF_HI'));
            $estatisticasCocomo->setED_PDIF_VH(getConfigCocomo('ED_PDIF_VH'));
            $estatisticasCocomo->setED_PDIF_EH(getConfigCocomo('ED_PDIF_EH'));
            $estatisticasCocomo->setED_PREX_XL(getConfigCocomo('ED_PREX_XL'));
            $estatisticasCocomo->setED_PREX_VL(getConfigCocomo('ED_PREX_VL'));
            $estatisticasCocomo->setED_PREX_LO(getConfigCocomo('ED_PREX_LO'));
            $estatisticasCocomo->setED_PREX_NO(getConfigCocomo('ED_PREX_NO'));
            $estatisticasCocomo->setED_PREX_HI(getConfigCocomo('ED_PREX_HI'));
            $estatisticasCocomo->setED_PREX_VH(getConfigCocomo('ED_PREX_VH'));
            $estatisticasCocomo->setED_PREX_EH(getConfigCocomo('ED_PREX_EH'));
            $estatisticasCocomo->setED_FCIL_XL(getConfigCocomo('ED_FCIL_XL'));
            $estatisticasCocomo->setED_FCIL_VL(getConfigCocomo('ED_FCIL_VL'));
            $estatisticasCocomo->setED_FCIL_LO(getConfigCocomo('ED_FCIL_LO'));
            $estatisticasCocomo->setED_FCIL_NO(getConfigCocomo('ED_FCIL_NO'));
            $estatisticasCocomo->setED_FCIL_HI(getConfigCocomo('ED_FCIL_HI'));
            $estatisticasCocomo->setED_FCIL_VH(getConfigCocomo('ED_FCIL_VH'));
            $estatisticasCocomo->setED_FCIL_EH(getConfigCocomo('ED_FCIL_EH'));
            $estatisticasCocomo->setED_RUSE_LO(getConfigCocomo('ED_RUSE_LO'));
            $estatisticasCocomo->setED_RUSE_NO(getConfigCocomo('ED_RUSE_NO'));
            $estatisticasCocomo->setED_RUSE_HI(getConfigCocomo('ED_RUSE_HI'));
            $estatisticasCocomo->setED_RUSE_VH(getConfigCocomo('ED_RUSE_VH'));
            $estatisticasCocomo->setED_RUSE_EH(getConfigCocomo('ED_RUSE_EH'));
            $estatisticasCocomo->setED_SCED_VL(getConfigCocomo('ED_SCED_VL'));
            $estatisticasCocomo->setED_SCED_LO(getConfigCocomo('ED_SCED_LO'));
            $estatisticasCocomo->setED_SCED_NO(getConfigCocomo('ED_SCED_NO'));
            $estatisticasCocomo->setED_SCED_HI(getConfigCocomo('ED_SCED_HI'));
            $estatisticasCocomo->setED_SCED_VH(getConfigCocomo('ED_SCED_VH'));
            $estatisticasCocomo->setEsforco(0);
            $estatisticasCocomo->setCronograma(0);
            $estatisticasCocomo->setCusto(0);
            $estatisticasCocomo->setCusto_pessoa(0);
            $estatisticasCocomo->setSloc(0);
            $estatisticasCocomo->setTipo_calculo(0);
            $estatisticasCocomo->setRup_inc_ef(getConfigCocomo('rup_inc_ef'));
            $estatisticasCocomo->setRup_inc_sc(getConfigCocomo('rup_inc_sc'));
            $estatisticasCocomo->setRup_ela_ef(getConfigCocomo('rup_ela_ef'));
            $estatisticasCocomo->setRup_ela_sc(getConfigCocomo('rup_ela_sc'));
            $estatisticasCocomo->setRup_con_ef(getConfigCocomo('rup_con_ef'));
            $estatisticasCocomo->setRup_con_sc(getConfigCocomo('rup_con_sc'));
            $estatisticasCocomo->setRup_tra_ef(getConfigCocomo('rup_tra_ef'));
            $estatisticasCocomo->setRup_tra_sc(getConfigCocomo('rup_tra_sc'));
            $estatisticasCocomo->setCoc_inc_ef(getConfigCocomo('coc_inc_ef'));
            $estatisticasCocomo->setCoc_inc_sc(getConfigCocomo('coc_inc_sc'));
            $estatisticasCocomo->setCoc_ela_ef(getConfigCocomo('coc_ela_ef'));
            $estatisticasCocomo->setCoc_ela_sc(getConfigCocomo('coc_ela_sc'));
            $estatisticasCocomo->setCoc_con_ef(getConfigCocomo('coc_con_ef'));
            $estatisticasCocomo->setCoc_con_sc(getConfigCocomo('coc_con_sc'));
            $estatisticasCocomo->setCoc_tra_ef(getConfigCocomo('coc_tra_ef'));
            $estatisticasCocomo->setCoc_tra_sc(getConfigCocomo('coc_tra_sc'));
            $estatisticasCocomo->setMan_inc(getConfigCocomo('man_inc'));
            $estatisticasCocomo->setMan_ela(getConfigCocomo('man_ela'));
            $estatisticasCocomo->setMan_con(getConfigCocomo('man_con'));
            $estatisticasCocomo->setMan_tra(getConfigCocomo('man_tra'));
            $estatisticasCocomo->setEnv_inc(getConfigCocomo('env_inc'));
            $estatisticasCocomo->setEnv_ela(getConfigCocomo('env_ela'));
            $estatisticasCocomo->setEnv_con(getConfigCocomo('env_con'));
            $estatisticasCocomo->setEnv_tra(getConfigCocomo('env_tra'));
            $estatisticasCocomo->setReq_inc(getConfigCocomo('req_inc'));
            $estatisticasCocomo->setReq_ela(getConfigCocomo('req_ela'));
            $estatisticasCocomo->setReq_con(getConfigCocomo('req_con'));
            $estatisticasCocomo->setReq_tra(getConfigCocomo('req_tra'));
            $estatisticasCocomo->setDes_inc(getConfigCocomo('des_inc'));
            $estatisticasCocomo->setDes_ela(getConfigCocomo('des_ela'));
            $estatisticasCocomo->setDes_con(getConfigCocomo('des_con'));
            $estatisticasCocomo->setDes_tra(getConfigCocomo('des_tra'));
            $estatisticasCocomo->setImp_inc(getConfigCocomo('imp_inc'));
            $estatisticasCocomo->setImp_ela(getConfigCocomo('imp_ela'));
            $estatisticasCocomo->setImp_con(getConfigCocomo('imp_con'));
            $estatisticasCocomo->setImp_tra(getConfigCocomo('imp_tra'));
            $estatisticasCocomo->setAss_inc(getConfigCocomo('ass_inc'));
            $estatisticasCocomo->setAss_ela(getConfigCocomo('ass_ela'));
            $estatisticasCocomo->setAss_con(getConfigCocomo('ass_con'));
            $estatisticasCocomo->setAss_tra(getConfigCocomo('ass_tra'));
            $estatisticasCocomo->setDep_inc(getConfigCocomo('dep_inc'));
            $estatisticasCocomo->setDep_ela(getConfigCocomo('dep_ela'));
            $estatisticasCocomo->setDep_con(getConfigCocomo('dep_con'));
            $estatisticasCocomo->setDep_tra(getConfigCocomo('dep_tra'));
            //insere
            if (!$idContagemBaseline && $idAbrangencia == 2) {
                $estatisticasCocomo->setIdContagem($idContagemBaselineInserida);
                $estatisticasCocomo->insere();
            }
            $estatisticasCocomo->setIdContagem($fn);
            $estatisticasCocomo->insere();
        }
        /*
         * retorna para a pagina de insercao
         */
        if ($fn) {
            $ret[] = array(
                'acao' => $acao,
                'id' => $fn,
                'idPad' => str_pad($fn, 6, '0', STR_PAD_LEFT),
                'idContagemBaselineInserida' => $idContagemBaselineInserida ? $idContagemBaselineInserida : 0, //devera pegar o id da contagem de baseline
                'btnSalvar' => '<i class="fa fa-edit fa-lg"></i> Atualizar informa&ccedil&otilde;es'
            );
        } else {
            //TODO: ??        
        }
        /*
         * cria o diretorio de arquivos da contagem, mesmo que nao tenha nenhum
         */
        mkdir(DIR_FILE . str_pad(getIdEmpresa(), 11, '0', STR_PAD_LEFT) . DIRECTORY_SEPARATOR . str_pad($fn, 11, '0', STR_PAD_LEFT), 0777, TRUE);
        /*
         * cria o thumbnail
         */
        mkdir(DIR_FILE . str_pad(getIdEmpresa(), 11, '0', STR_PAD_LEFT) . DIRECTORY_SEPARATOR . str_pad($fn, 11, '0', STR_PAD_LEFT) . DIRECTORY_SEPARATOR . 'thumbnail', 0777, TRUE);
        /*
         * insere o marco de estivativa logo aqui para depois fazer somente as atualizacoes
         * $baselineEstimativa->setIdContagem($fn);
         * $baselineEstimativa->insere();
         * TODO: verificar este ponto pois nesta versao insere toda vez que atualizar
         */
    } elseif ($acao === 'al' || $acao === 're') {
        /*
         * atualiza as informacoes basicas da contagem
         */
        $fn = $contagem->atualiza($id);
        if ($fn) {
            //retorna
            $ret[] = array(
                'acao' => $acao,
                'id' => $fn,
                'idPad' => str_pad($fn, 6, '0', STR_PAD_LEFT)
            );
        }
    }

    echo json_encode($ret);
} else {
    echo json_encode(array('acao' => NULL, 'id' => 0, 'idPad' => 0, 'msg' => 'Acesso n&atilde;o autorizado!'));
}