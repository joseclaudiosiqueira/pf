<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verifica login
 */
if ($login->isUserLoggedIn() && verificaSessao()) {
    if (NULL !== filter_input(INPUT_POST, 'id') && NULL !== filter_input(INPUT_POST, 'ac')) {
        // pega a abrangencia atual para SNAP e outras
        $idAbrangencia = filter_input(INPUT_POST, 'ab', FILTER_SANITIZE_NUMBER_INT);
        // verifica se eh um fornecedor
        $isFornecedor = isFornecedor();
        // pega o id do fornecedor
        $idFornecedor = getIdFornecedor();
        // pega o id da empresa
        $idEmpresa = getIdEmpresa();
        // define as variaveis
        $user_email = getEmailUsuarioLogado();
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $ac = filter_input(INPUT_POST, 'ac', FILTER_SANITIZE_STRING);
        // instancia as classes
        $fn = new Contagem();
        $user = new Usuario();
        $ch = new ContagemHistorico();
        $cp = new ContagemProcesso();
        $ca = new ContagemAcesso();
        $ca->setUserEmail($user_email);
        // seta as tabelas
        // variavel $pass ... determina se a acao pode ser executada pelo solicitante
        $pass = 0;
        $isAutorizadoAlterar = 0;
        $isAutorizadoValidarInternamente = 0;
        $isAutorizadoRevisar = 0;
        // verifica se eh o responsavel pela contagem
        $isResponsavel = $fn->isResponsavel($user_email, $id);
        // verifica a privacidade da contagem
        $privacidade = $fn->getPrivacidade($id)['privacidade'];
        // verifica se pode visualizar contagens de fornecedor
        $isVisualizarContagemFornecedor = getConfigContagem('is_visualizar_contagem_fornecedor') ? 1 : 0;
        // verifica se a contagem eh de um fornecedor
        $isContagemFornecedor = $fn->isContagemFornecedor($id);
        // verifica se eh um gestor
        $isGestor = getVariavelSessao('isGestor');
        // instrutor
        $isInstrutor = getVariavelSessao('isInstrutor');
        // fiscal do contrato nivel cliente
        $isFiscalContrato = getVariavelSessao('isFiscalContratoCliente');
        // fiscal contrato nivel fornecedor
        $isFiscalContratoFornecedor = getVariavelSessao('isFiscalContratoFornecedor');
        // fiscal contrato nivel empresa
        $isFiscalContratoEmpresa = getVariavelSessao('isFiscalContratoEmpresa');
        // verifica se eh o gerente do projeto
        $isGerenteProjeto = $fn->isGerenteProjeto($user_email, $id);
        // verifica se existe autorizacao para o usuario visualizar a contagem
        $ca->setIdContagem($id);
        $isAutorizado = $ca->isAutorizado();
        // verifica se eh um gerente de conta
        $isGerenteConta = getVariavelSessao('isGerenteConta');
        // verifica se eh um perfil de diretor
        $isDiretor = getVariavelSessao('isDiretor');
        // visualizador
        $isViewer = getVariavelSessao('isViewer');
        // verifica se o perfil eh de analista de metricas e a contagem e publica e exibe
        $isPerfilAnalistaMetricas = getVariavelSessao('isAnalistaMetricas');
        // verifica se eh o validador interno da contagem
        $isValidadorInterno = $fn->isValidadorInterno($user_email, $id);
        // verifica se eh o validador externo da contagem
        $isValidadorExterno = $fn->isValidadorExterno($user_email, $id);
        // verifica se eh o auditor interno da contagem
        $isAuditorInterno = $fn->isAuditorInterno($user_email, $id);
        // verifica se eh o auditor externo da contagem
        $isAuditorExterno = $fn->isAuditorExterno($user_email, $id);
        /*
         * verifica se e uma turma
         */
        if ($isFornecedor) {
            $fornecedor = new Fornecedor();
            $tipoFornecedor = $fornecedor->getTipo($idFornecedor); // 0 - Fornecedor, 1 - Turma
            $isGestorFornecedor = getVariavelSessao('isGestorFornecedor');
            $isGerenteContaFornecedor = getVariavelSessao('isGerenteContaFornecedor');
            $isGerenteProjetoFornecedor = getVariavelSessao('isGerenteProjetoFornecedor');
            $isPerfilAnalistaMetricasFornecedor = getVariavelSessao('isAnalistaMetricasFornecedor');
        }
        /*
         * al - alterar
         * vi - validar interna
         * ve - validar externa
         * ai - auditoria interna
         * ae - auditoria externa
         * vw - viewer (gerentes, diretores, viewers...)
         * re - revisar
         */
        switch ($ac) {
            case 'al':
                $isAutorizadoAlterar = $isResponsavel || $isGestor || ($isFornecedor && $isGestorFornecedor) ? 1 : 0;
                $pass = $isAutorizadoAlterar;
                break;
            case 'vi':
                $isAutorizadoValidarInternamente = $isValidadorInterno || $isGestor || ($isFornecedor && $isGestorFornecedor) ? 1 : 0;
                $pass = $isAutorizadoValidarInternamente;
                break;
            case 've':
                $pass = $isValidadorExterno;
                break;
            case 'ai':
                $pass = $isAuditorInterno;
                break;
            case 'ae':
                $pass = $isAuditorExterno;
                break;
            case 'vw':
                if ($isDiretor || $isGestor || ($isFornecedor && ($isGestorFornecedor || $isGerenteContaFornecedor || $isGerenteProjetoFornecedor || $isFiscalContratoFornecedor || ($tipoFornecedor && $isInstrutor))) || $isGerenteConta || $isViewer || $isResponsavel || $isGerenteProjeto || $isFiscalContrato || $isFiscalContratoEmpresa || ($isPerfilAnalistaMetricas && ! $privacidade)) { // 0-publica, 1-privada
                    $pass = 1;
                } elseif ($isAuditorInterno || $isAuditorExterno || $isValidadorExterno || $isValidadorInterno || $isAutorizado) {
                    $pass = 1;
                } elseif ($isContagemFornecedor && $isPerfilAnalistaMetricasFornecedor && $tipoFornecedor) {
                    $pass = 1;
                } elseif ($isContagemFornecedor && $isPerfilAnalistaMetricasFornecedor && ! $tipoFornecedor) {
                    $pass = 1;
                } elseif ($isContagemFornecedor && $isPerfilAnalistaMetricas && $isVisualizarContagemFornecedor) {
                    $pass = 1;
                }
                break;
            case 're':
                $isAutorizadoAlterar = $isResponsavel || $isGestor ? 1 : 0;
                $isAutorizadoRevisar = $isAutorizadoAlterar;
                $pass = $isAutorizadoRevisar;
                break;
        }
        // define os arrays antes
        $retAPF = array();
        $retSNAP = array();
        /**
         * passa $isSql = true para alterar a consulta padrao no CRUD
         * passa $sql que eh a consulta juntando contagem e contagem estatistica
         */
        if ($pass) {
            if ($idAbrangencia != 5) {
                $sql = "SELECT " . "c.*, ce.*, cc.* " . "FROM contagem c, contagem_estatisticas ce, contagem_estatisticas_cocomo cc " . "WHERE " . "c.id = ce.id_contagem AND " . "c.id = cc.id_contagem AND " . "c.id = :id AND " . "is_excluida = 0";
                $linha = $fn->consulta($id, true, $sql);
                if (NULL !== $linha['id'] && $idEmpresa == $linha['id_empresa']) {
                    if ($isFornecedor) {
                        if ($idFornecedor != $linha['id_fornecedor']) {
                            echo pInv(); // invalido
                            exit();
                        }
                    }
                    $contagemIdProcesso = $cp->getContagemProcesso($id, '1,2,3,4,5,6,7,8,9,10,11')['id_processo'];
                    $retAPF[] = array(
                        'idEmpresa' => $linha['id_empresa'],
                        'idFornecedor' => $linha['id_fornecedor'],
                        'idCliente' => $linha['id_cliente'],
                        'idContrato' => $linha['id_contrato'],
                        'idProjeto' => $linha['id_projeto'],
                        'idLinguagem' => $linha['id_linguagem'],
                        'idTipoContagem' => $linha['id_tipo_contagem'],
                        'idEtapa' => $linha['id_etapa'],
                        'idProcesso' => $linha['id_processo'],
                        'idProcessoGestao' => $linha['id_processo_gestao'],
                        'proposito' => html_entity_decode($linha['proposito'], ENT_QUOTES),
                        'escopo' => html_entity_decode($linha['escopo'], ENT_QUOTES),
                        'entregas' => $linha['entregas'],
                        'ordemServico' => html_entity_decode($linha['ordem_servico'], ENT_QUOTES),
                        'id' => $linha['id'],
                        'idAbrangencia' => $linha['id_abrangencia'],
                        'idBancoDados' => $linha['id_banco_dados'],
                        'idIndustria' => $linha['id_industria'],
                        'gerenteProjeto' => $user->getGerenteProjeto($linha['id_projeto'])['user_email'],
                        'idBaseline' => $linha['id_baseline'],
                        'idOrgao' => $linha['id_orgao'],
                        'nomeGerenteProjeto' => $user->getGerenteProjeto($linha['id_projeto'])['complete_name'],
                        'dataCadastro' => $fn->getDataCadastro($id),
                        'responsavel' => $linha['responsavel'],
                        'validadorInterno' => NULL !== $linha['validador_interno'] ? $linha['validador_interno'] : '',
                        'validadorExterno' => NULL !== $linha['validador_externo'] ? $linha['validador_externo'] : '',
                        'auditorInterno' => NULL !== $linha['auditor_interno'] ? $linha['auditor_interno'] : '',
                        'auditorExterno' => NULL !== $linha['auditor_externo'] ? $linha['auditor_externo'] : '',
                        'contagemIdProcesso' => $contagemIdProcesso,
                        'isAutorizadoAlterar' => $isAutorizadoAlterar,
                        'isAutorizadoRevisar' => $isAutorizadoRevisar,
                        'isAutorizadoValidarInternamente' => $isAutorizadoValidarInternamente,
                        'isValidadaInternamente' => $ch->isValidadaInternamente($id),
                        'isProcessoValidacaoInterna' => $ch->isProcessoValidacaoInterna($id),
                        'isProcessoValidacaoExterna' => $ch->isProcessoValidacaoExterna($id),
                        'isContagemAuditoria' => $linha['is_contagem_auditoria'],
                        'privacidade' => $linha['privacidade'],
                        'previsaoInicio' => date_format(date_create($linha['previsao_inicio']), 'd/m/Y'),
                        'previsaoTermino' => date_format(date_create($linha['previsao_termino']), 'd/m/Y'),
                        'produtividadeGlobal' => number_format($linha['produtividade_global'], 2, ".", ""),
                        'chkProdutividadeGlobal' => $linha['chk_produtividade_global'],
                        'hlt' => number_format($linha['hlt'], 2, ".", ""),
                        'isFt' => $linha['is_ft'],
                        'ft' => $linha['ft'],
                        'pctEng' => $linha['pct_eng'],
                        'prodEng' => number_format($linha['prod_eng'], 2, ".", ""),
                        'profEng' => $linha['prof_eng'],
                        'perfEng' => explode(',', $linha['perf_eng']),
                        'chkEng' => $linha['chk_eng'] ? true : false,
                        'pctDes' => $linha['pct_des'],
                        'prodDes' => number_format($linha['prod_des'], 2, ".", ""),
                        'profDes' => $linha['prof_des'],
                        'perfDes' => explode(',', $linha['perf_des']),
                        'chkDes' => $linha['chk_des'] ? true : false,
                        'pctImp' => $linha['pct_imp'],
                        'prodImp' => number_format($linha['prod_imp'], 2, ".", ""),
                        'profImp' => $linha['prof_imp'],
                        'perfImp' => explode(',', $linha['perf_imp']),
                        'chkImp' => $linha['chk_imp'] ? true : false,
                        'pctTes' => $linha['pct_tes'],
                        'prodTes' => number_format($linha['prod_tes'], 2, ".", ""),
                        'profTes' => $linha['prof_tes'],
                        'perfTes' => explode(',', $linha['perf_tes']),
                        'chkTes' => $linha['chk_tes'] ? true : false,
                        'pctHom' => $linha['pct_hom'],
                        'prodHom' => number_format($linha['prod_hom'], 2, ".", ""),
                        'profHom' => $linha['prof_hom'],
                        'perfHom' => explode(',', $linha['perf_hom']),
                        'chkHom' => $linha['chk_hom'] ? true : false,
                        'pctImpl' => $linha['pct_impl'],
                        'prodImpl' => number_format($linha['prod_impl'], 2, ".", ""),
                        'profImpl' => $linha['prof_impl'],
                        'perfImpl' => explode(',', $linha['perf_impl']),
                        'chkImpl' => $linha['chk_impl'] ? true : false,
                        'descFEng' => $linha['desc_f_eng'],
                        'descFDes' => $linha['desc_f_des'],
                        'descFImp' => $linha['desc_f_imp'],
                        'descFTes' => $linha['desc_f_tes'],
                        'descFHom' => $linha['desc_f_hom'],
                        'descFImpl' => $linha['desc_f_impl'],
                        'expoente' => number_format($linha['expoente'], 2, ".", ""),
                        'calculado' => number_format($linha['calculado'], 3, ".", ""),
                        'tempoDesenvolvimento' => number_format($linha['tempo_desenvolvimento'], 3, ".", ""),
                        'regiaoImpossivel' => number_format($linha['regiao_impossivel'], 3, ".", ""),
                        'menorCusto' => number_format($linha['menor_custo'], 3, ".", ""),
                        'isProdutividadeLinguagem' => $linha['chk_produtividade_linguagem'],
                        'escalaProdutividade' => $linha['escala_produtividade'],
                        'produtividadeBaixa' => number_format($linha['produtividade_baixa'], 2, ".", ""),
                        'produtividadeMedia' => number_format($linha['produtividade_media'], 2, ".", ""),
                        'produtividadeAlta' => number_format($linha['produtividade_alta'], 2, ".", ""),
                        'hpc' => $linha['hpc'],
                        'hpa' => $linha['hpa'],
                        'aumentoEsforco' => number_format($linha['aumento_esforco'], 2, ".", ""),
                        'fatorReducaoCronograma' => number_format($linha['fator_reducao_cronograma'], 2, ".", ""),
                        'tipoProjeto' => $linha['tipo_projeto'],
                        'esforcoTotal' => number_format($linha['esforco_total'], 3, ".", ""),
                        'tamanhoPfa' => number_format($linha['tamanho_pfa'], 3, ".", ""),
                        'spanProdutividadeMedia' => number_format($linha['span_produtividade_media'], 2, ".", ""),
                        'valorHpc' => number_format($linha['valor_hpc'], 2, ".", ""),
                        'valorHpa' => number_format($linha['valor_hpa'], 2, ".", ""),
                        'custoTotal' => number_format($linha['custo_total'], 2, ".", ""),
                        'valorPfaContrato' => number_format($linha['valor_pfa_contrato'], 2, ".", ""),
                        'COCOMO_A' => $linha['COCOMO_A'],
                        'COCOMO_B' => $linha['COCOMO_B'],
                        'COCOMO_C' => $linha['COCOMO_C'],
                        'COCOMO_D' => $linha['COCOMO_D'],
                        'ED_PERS' => $linha['ED_PERS'], // 'ED_PERS_NO',
                        'ED_RCPX' => $linha['ED_RCPX'], // 'ED_RCPX_NO',
                        'ED_PDIF' => $linha['ED_PDIF'], // 'ED_PDIF_NO',
                        'ED_PREX' => $linha['ED_PREX'], // 'ED_PREX_NO',
                        'ED_FCIL' => $linha['ED_FCIL'], // 'ED_FCIL_NO',
                        'ED_RUSE' => $linha['ED_RUSE'], // 'ED_RUSE_NO',
                        'ED_SCED' => $linha['ED_SCED'], // 'ED_SCED_NO',
                        'PREC' => $linha['PREC'], // 'PREC_NO',
                        'FLEX' => $linha['FLEX'], // 'FLEX_NO',
                        'RESL' => $linha['RESL'], // 'RESL_NO',
                        'TEAM' => $linha['TEAM'], // 'TEAM_NO',
                        'PMAT' => $linha['PMAT'], // 'PMAT_NO',
                        'RELY' => $linha['RELY'], // 'RELY_NO',
                        'DATA' => $linha['DATA'], // 'DATA_NO',
                        'CPLX_CN' => $linha['CPLX_CN'], // 'CPLX_CN_NO',
                        'CPLX_CO' => $linha['CPLX_CO'], // 'CPLX_CO_NO',
                        'CPLX_DO' => $linha['CPLX_DO'], // 'CPLX_DO_NO',
                        'CPLX_DM' => $linha['CPLX_DM'], // 'CPLX_DM_NO',
                        'CPLX_UI' => $linha['CPLX_UI'], // 'CPLX_UI_NO',
                        'CPLX' => $linha['CPLX'], // 'CPLX_NO,
                        'RUSE' => $linha['RUSE'], // 'RUSE_NO',
                        'DOCU' => $linha['DOCU'], // 'DOCU_NO',
                        'TIME' => $linha['TIME'], // 'TIME_NO',
                        'STOR' => $linha['STOR'], // 'STOR_NO',
                        'PVOL' => $linha['PVOL'], // 'PVOL_NO',
                        'ACAP' => $linha['ACAP'], // 'ACAP_NO',
                        'PCAP' => $linha['PCAP'], // 'PCAP_NO',
                        'PCON' => $linha['PCON'], // 'PCON_NO',
                        'APEX' => $linha['APEX'], // 'APEX_NO',
                        'PLEX' => $linha['PLEX'], // 'PLEX_NO',
                        'LTEX' => $linha['LTEX'], // 'LTEX_NO',
                        'TOOL' => $linha['TOOL'], // 'TOOL_NO',
                        'SITE' => $linha['SITE'], // 'SITE_NO',
                        'SCED' => $linha['SCED'], // 'SCED_NO',
                        'PREC_VL' => $linha['PREC_VL'], // '6.2',
                        'PREC_LO' => $linha['PREC_LO'], // '4.96',
                        'PREC_NO' => $linha['PREC_NO'], // '3.72',
                        'PREC_HI' => $linha['PREC_HI'], // '2.48',
                        'PREC_VH' => $linha['PREC_VH'], // '1.24',
                        'PREC_EH' => $linha['PREC_EH'], // '0',
                        'FLEX_VL' => $linha['FLEX_VL'], // '5.07',
                        'FLEX_LO' => $linha['FLEX_LO'], // '4.05',
                        'FLEX_NO' => $linha['FLEX_NO'], // '3.04',
                        'FLEX_HI' => $linha['FLEX_HI'], // '2.03',
                        'FLEX_VH' => $linha['FLEX_VH'], // '1.01',
                        'FLEX_EH' => $linha['FLEX_EH'], // '0',
                        'RESL_VL' => $linha['RESL_VL'], // '7.07',
                        'RESL_LO' => $linha['RESL_LO'], // '5.65',
                        'RESL_NO' => $linha['RESL_NO'], // '4.24',
                        'RESL_HI' => $linha['RESL_HI'], // '2.83',
                        'RESL_VH' => $linha['RESL_VH'], // '1.41',
                        'RESL_EH' => $linha['RESL_EH'], // '0',
                        'TEAM_VL' => $linha['TEAM_VL'], // '5.48',
                        'TEAM_LO' => $linha['TEAM_LO'], // '4.38',
                        'TEAM_NO' => $linha['TEAM_NO'], // '3.29',
                        'TEAM_HI' => $linha['TEAM_HI'], // '2.19',
                        'TEAM_VH' => $linha['TEAM_VH'], // '1.1',
                        'TEAM_EH' => $linha['TEAM_EH'], // '0',
                        'PMAT_VL' => $linha['PMAT_VL'], // '7.8',
                        'PMAT_LO' => $linha['PMAT_LO'], // '6.24',
                        'PMAT_NO' => $linha['PMAT_NO'], // '4.68',
                        'PMAT_HI' => $linha['PMAT_HI'], // '3.12',
                        'PMAT_VH' => $linha['PMAT_VH'], // '1.56',
                        'PMAT_EH' => $linha['PMAT_EH'], // '0',
                        'RELY_VL' => $linha['RELY_VL'], // '0.82',
                        'RELY_LO' => $linha['RELY_LO'], // '0.92',
                        'RELY_NO' => $linha['RELY_NO'], // '1',
                        'RELY_HI' => $linha['RELY_HI'], // '1.1',
                        'RELY_VH' => $linha['RELY_VH'], // '1.26',
                        'DATA_LO' => $linha['DATA_LO'], // '0.9',
                        'DATA_NO' => $linha['DATA_NO'], // '1',
                        'DATA_HI' => $linha['DATA_HI'], // '1.14',
                        'DATA_VH' => $linha['DATA_VH'], // '1.28',
                        'CPLX_CN_VL' => $linha['CPLX_CN_VL'], // '0.73',
                        'CPLX_CN_LO' => $linha['CPLX_CN_LO'], // '0.87',
                        'CPLX_CN_NO' => $linha['CPLX_CN_NO'], // '1',
                        'CPLX_CN_HI' => $linha['CPLX_CN_HI'], // '1.17',
                        'CPLX_CN_VH' => $linha['CPLX_CN_VH'], // '1.34',
                        'CPLX_CN_EH' => $linha['CPLX_CN_EH'], // '1.74',
                        'CPLX_CO_VL' => $linha['CPLX_CO_VL'], // '0.73',
                        'CPLX_CO_LO' => $linha['CPLX_CO_LO'], // '0.87',
                        'CPLX_CO_NO' => $linha['CPLX_CO_NO'], // '1',
                        'CPLX_CO_HI' => $linha['CPLX_CO_HI'], // '1.17',
                        'CPLX_CO_VH' => $linha['CPLX_CO_VH'], // '1.34',
                        'CPLX_CO_EH' => $linha['CPLX_CO_EH'], // '1.74',
                        'CPLX_DO_VL' => $linha['CPLX_DO_VL'], // '0.73',
                        'CPLX_DO_LO' => $linha['CPLX_DO_LO'], // '0.87',
                        'CPLX_DO_NO' => $linha['CPLX_DO_NO'], // '1',
                        'CPLX_DO_HI' => $linha['CPLX_DO_HI'], // '1.17',
                        'CPLX_DO_VH' => $linha['CPLX_DO_VH'], // '1.34',
                        'CPLX_DO_EH' => $linha['CPLX_DO_EH'], // '1.74',
                        'CPLX_DM_VL' => $linha['CPLX_DM_VL'], // '0.73',
                        'CPLX_DM_LO' => $linha['CPLX_DM_LO'], // '0.87',
                        'CPLX_DM_NO' => $linha['CPLX_DM_NO'], // '1',
                        'CPLX_DM_HI' => $linha['CPLX_DM_HI'], // '1.17',
                        'CPLX_DM_VH' => $linha['CPLX_DM_VH'], // '1.34',
                        'CPLX_DM_EH' => $linha['CPLX_DM_EH'], // '1.74',
                        'CPLX_UI_VL' => $linha['CPLX_UI_VL'], // '0.73',
                        'CPLX_UI_LO' => $linha['CPLX_UI_LO'], // '0.87',
                        'CPLX_UI_NO' => $linha['CPLX_UI_NO'], // '1',
                        'CPLX_UI_HI' => $linha['CPLX_UI_HI'], // '1.17',
                        'CPLX_UI_VH' => $linha['CPLX_UI_VH'], // '1.34',
                        'CPLX_UI_EH' => $linha['CPLX_UI_EH'], // '1.74',
                        'CPLX_VL' => $linha['CPLX_VL'], // '',
                        'CPLX_LO' => $linha['CPLX_LO'], // '',
                        'CPLX_NO' => $linha['CPLX_NO'], // '',
                        'CPLX_HI' => $linha['CPLX_HI'], // '',
                        'CPLX_VH' => $linha['CPLX_VH'], // '',
                        'CPLX_EH' => $linha['CPLX_EH'], // '',
                        'RUSE_LO' => $linha['RUSE_LO'], // '0.95',
                        'RUSE_NO' => $linha['RUSE_NO'], // '1',
                        'RUSE_HI' => $linha['RUSE_HI'], // '1.07',
                        'RUSE_VH' => $linha['RUSE_VH'], // '1.15',
                        'RUSE_EH' => $linha['RUSE_EH'], // '1.24',
                        'DOCU_VL' => $linha['DOCU_VL'], // '0.81',
                        'DOCU_LO' => $linha['DOCU_LO'], // '0.91',
                        'DOCU_NO' => $linha['DOCU_NO'], // '1',
                        'DOCU_HI' => $linha['DOCU_HI'], // '1.11',
                        'DOCU_VH' => $linha['DOCU_VH'], // '1.23',
                        'TIME_NO' => $linha['TIME_NO'], // '1',
                        'TIME_HI' => $linha['TIME_HI'], // '1.11',
                        'TIME_VH' => $linha['TIME_VH'], // '1.29',
                        'TIME_EH' => $linha['TIME_EH'], // '1.63',
                        'STOR_NO' => $linha['STOR_NO'], // '1',
                        'STOR_HI' => $linha['STOR_HI'], // '1.05',
                        'STOR_VH' => $linha['STOR_VH'], // '1.17',
                        'STOR_EH' => $linha['STOR_EH'], // '1.46',
                        'PVOL_LO' => $linha['PVOL_LO'], // '0.87',
                        'PVOL_NO' => $linha['PVOL_NO'], // '1',
                        'PVOL_HI' => $linha['PVOL_HI'], // '1.15',
                        'PVOL_VH' => $linha['PVOL_VH'], // '1.3',
                        'ACAP_VL' => $linha['ACAP_VL'], // '1.42',
                        'ACAP_LO' => $linha['ACAP_LO'], // '1.19',
                        'ACAP_NO' => $linha['ACAP_NO'], // '1',
                        'ACAP_HI' => $linha['ACAP_HI'], // '0.85',
                        'ACAP_VH' => $linha['ACAP_VH'], // '0.71',
                        'PCAP_VL' => $linha['PCAP_VL'], // '1.34',
                        'PCAP_LO' => $linha['PCAP_LO'], // '1.15',
                        'PCAP_NO' => $linha['PCAP_NO'], // '1',
                        'PCAP_HI' => $linha['PCAP_HI'], // '0.88',
                        'PCAP_VH' => $linha['PCAP_VH'], // '0.76',
                        'PCON_VL' => $linha['PCON_VL'], // '1.29',
                        'PCON_LO' => $linha['PCON_LO'], // '1.12',
                        'PCON_NO' => $linha['PCON_NO'], // '1',
                        'PCON_HI' => $linha['PCON_HI'], // '0.9',
                        'PCON_VH' => $linha['PCON_VH'], // '0.81',
                        'APEX_VL' => $linha['APEX_VL'], // '1.22',
                        'APEX_LO' => $linha['APEX_LO'], // '1.1',
                        'APEX_NO' => $linha['APEX_NO'], // '1',
                        'APEX_HI' => $linha['APEX_HI'], // '0.88',
                        'APEX_VH' => $linha['APEX_VH'], // '0.81',
                        'PLEX_VL' => $linha['PLEX_VL'], // '1.19',
                        'PLEX_LO' => $linha['PLEX_LO'], // '1.09',
                        'PLEX_NO' => $linha['PLEX_NO'], // '1',
                        'PLEX_HI' => $linha['PLEX_HI'], // '0.91',
                        'PLEX_VH' => $linha['PLEX_VH'], // '0.85',
                        'LTEX_VL' => $linha['LTEX_VL'], // '1.2',
                        'LTEX_LO' => $linha['LTEX_LO'], // '1.09',
                        'LTEX_NO' => $linha['LTEX_NO'], // '1',
                        'LTEX_HI' => $linha['LTEX_HI'], // '0.91',
                        'LTEX_VH' => $linha['LTEX_VH'], // '0.84',
                        'TOOL_VL' => $linha['TOOL_VL'], // '1.17',
                        'TOOL_LO' => $linha['TOOL_LO'], // '1.09',
                        'TOOL_NO' => $linha['TOOL_NO'], // '1',
                        'TOOL_HI' => $linha['TOOL_HI'], // '0.9',
                        'TOOL_VH' => $linha['TOOL_VH'], // '0.78',
                        'SITE_VL' => $linha['SITE_VL'], // '1.22',
                        'SITE_LO' => $linha['SITE_LO'], // '1.09',
                        'SITE_NO' => $linha['SITE_NO'], // '1',
                        'SITE_HI' => $linha['SITE_HI'], // '0.93',
                        'SITE_VH' => $linha['SITE_VH'], // '0.86',
                        'SITE_EH' => $linha['SITE_EH'], // '0.8',
                        'SCED_VL' => $linha['SCED_VL'], // '1.43',
                        'SCED_LO' => $linha['SCED_LO'], // '1.14',
                        'SCED_NO' => $linha['SCED_NO'], // '1',
                        'SCED_HI' => $linha['SCED_HI'], // '1',
                        'SCED_VH' => $linha['SCED_VH'], // '1',
                        'ED_PERS_XL' => $linha['ED_PERS_XL'], // '2.12',
                        'ED_PERS_VL' => $linha['ED_PERS_VL'], // '1.62',
                        'ED_PERS_LO' => $linha['ED_PERS_LO'], // '1.26',
                        'ED_PERS_NO' => $linha['ED_PERS_NO'], // '1',
                        'ED_PERS_HI' => $linha['ED_PERS_HI'], // '0.83',
                        'ED_PERS_VH' => $linha['ED_PERS_VH'], // '0.63',
                        'ED_PERS_EH' => $linha['ED_PERS_EH'], // '0.5',
                        'ED_RCPX_XL' => $linha['ED_RCPX_XL'], // '0.49',
                        'ED_RCPX_VL' => $linha['ED_RCPX_VL'], // '0.6',
                        'ED_RCPX_LO' => $linha['ED_RCPX_LO'], // '0.83',
                        'ED_RCPX_NO' => $linha['ED_RCPX_NO'], // '1',
                        'ED_RCPX_HI' => $linha['ED_RCPX_HI'], // '1.33',
                        'ED_RCPX_VH' => $linha['ED_RCPX_VH'], // '1.91',
                        'ED_RCPX_EH' => $linha['ED_RCPX_EH'], // '2.72',
                        'ED_PDIF_LO' => $linha['ED_PDIF_LO'], // '0.87',
                        'ED_PDIF_NO' => $linha['ED_PDIF_NO'], // '1',
                        'ED_PDIF_HI' => $linha['ED_PDIF_HI'], // '1.29',
                        'ED_PDIF_VH' => $linha['ED_PDIF_VH'], // '1.81',
                        'ED_PDIF_EH' => $linha['ED_PDIF_EH'], // '2.61',
                        'ED_PREX_XL' => $linha['ED_PREX_XL'], // '1.59',
                        'ED_PREX_VL' => $linha['ED_PREX_VL'], // '1.33',
                        'ED_PREX_LO' => $linha['ED_PREX_LO'], // '1.12',
                        'ED_PREX_NO' => $linha['ED_PREX_NO'], // '1',
                        'ED_PREX_HI' => $linha['ED_PREX_HI'], // '0.87',
                        'ED_PREX_VH' => $linha['ED_PREX_VH'], // '0.74',
                        'ED_PREX_EH' => $linha['ED_PREX_EH'], // '0.62',
                        'ED_FCIL_XL' => $linha['ED_FCIL_XL'], // '1.43',
                        'ED_FCIL_VL' => $linha['ED_FCIL_VL'], // '1.3',
                        'ED_FCIL_LO' => $linha['ED_FCIL_LO'], // '1.1',
                        'ED_FCIL_NO' => $linha['ED_FCIL_NO'], // '1',
                        'ED_FCIL_HI' => $linha['ED_FCIL_HI'], // '0.87',
                        'ED_FCIL_VH' => $linha['ED_FCIL_VH'], // '0.73',
                        'ED_FCIL_EH' => $linha['ED_FCIL_EH'], // '0.62',
                        'ED_RUSE_LO' => $linha['ED_RUSE_LO'], // '0.95',
                        'ED_RUSE_NO' => $linha['ED_RUSE_NO'], // '1',
                        'ED_RUSE_HI' => $linha['ED_RUSE_HI'], // '1.07',
                        'ED_RUSE_VH' => $linha['ED_RUSE_VH'], // '1.15',
                        'ED_RUSE_EH' => $linha['ED_RUSE_EH'], // '1.24',
                        'ED_SCED_VL' => $linha['ED_SCED_VL'], // '1.43',
                        'ED_SCED_LO' => $linha['ED_SCED_LO'], // '1.14',
                        'ED_SCED_NO' => $linha['ED_SCED_NO'], // '1',
                        'ED_SCED_HI' => $linha['ED_SCED_HI'], // '1',
                        'ED_SCED_VH' => $linha['ED_SCED_VH'], // '1',
                        'coc_esforco' => $linha['esforco'], // '0',
                        'coc_cronograma' => $linha['cronograma'], // '0',
                        'coc_custo' => $linha['custo'], // '0',
                        'coc_custo_pessoa' => $linha['custo_pessoa'], // '0',
                        'coc_sloc' => $linha['sloc'], // '0',
                        'coc_tipo_calculo' => $linha['tipo_calculo']
                    );
                } else {
                    echo pInv();
                    exit();
                }
            } else {
                $sql = "SELECT c.* FROM contagem c WHERE c.id = :id AND is_excluida = 0";
                $linha = $fn->consulta($id, true, $sql);
                if (NULL !== $linha['id'] && $idEmpresa == $linha['id_empresa']) {
                    if ($isFornecedor) {
                        if ($idFornecedor != $linha['id_fornecedor']) {
                            echo pInv();
                            exit();
                        }
                    }
                    $contagemIdProcesso = $cp->getContagemProcesso($id, '1,2,3,4,5,6,7,8,9,10,11')['id_processo'];
                    $retSNAP[] = array(
                        'idEmpresa' => $linha['id_empresa'],
                        'idFornecedor' => $linha['id_fornecedor'],
                        'idCliente' => $linha['id_cliente'],
                        'idContrato' => $linha['id_contrato'],
                        'idProjeto' => $linha['id_projeto'],
                        'idLinguagem' => $linha['id_linguagem'],
                        'idTipoContagem' => $linha['id_tipo_contagem'],
                        'idEtapa' => $linha['id_etapa'],
                        'idProcesso' => $linha['id_processo'],
                        'idProcessoGestao' => $linha['id_processo_gestao'],
                        'proposito' => html_entity_decode($linha['proposito'], ENT_QUOTES),
                        'escopo' => html_entity_decode($linha['escopo'], ENT_QUOTES),
                        'entregas' => $linha['entregas'],
                        'ordemServico' => html_entity_decode($linha['ordem_servico'], ENT_QUOTES),
                        'id' => $linha['id'],
                        'idAbrangencia' => $linha['id_abrangencia'],
                        'idBancoDados' => $linha['id_banco_dados'],
                        'idIndustria' => $linha['id_industria'],
                        'gerenteProjeto' => $user->getGerenteProjeto($linha['id_projeto'])['user_email'],
                        'idBaseline' => $linha['id_baseline'],
                        'idOrgao' => $linha['id_orgao'],
                        'nomeGerenteProjeto' => $user->getGerenteProjeto($linha['id_projeto'])['complete_name'],
                        'dataCadastro' => $fn->getDataCadastro($id),
                        'responsavel' => $linha['responsavel'],
                        'validadorInterno' => NULL !== $linha['validador_interno'] ? $linha['validador_interno'] : '',
                        'validadorExterno' => NULL !== $linha['validador_externo'] ? $linha['validador_externo'] : '',
                        'auditorInterno' => NULL !== $linha['auditor_interno'] ? $linha['auditor_interno'] : '',
                        'auditorExterno' => NULL !== $linha['auditor_externo'] ? $linha['auditor_externo'] : '',
                        'contagemIdProcesso' => $contagemIdProcesso,
                        'isAutorizadoAlterar' => $isAutorizadoAlterar,
                        'isAutorizadoRevisar' => $isAutorizadoRevisar,
                        'isAutorizadoValidarInternamente' => $isAutorizadoValidarInternamente,
                        'isValidadaInternamente' => $ch->isValidadaInternamente($id),
                        'privacidade' => $linha['privacidade']
                    );
                } else {
                    echo pInv();
                    exit();
                }
            }
        } else {
            echo pInv();
            exit();
        }
        /*
         * set o id da contagem para o fileUpload
         */
        setIdContagem($id);
        /*
         * seta o id cliente para a selecao dos roteiros
         */
        setIdCliente($linha['id_cliente']);
        /*
         * retorna os dados da contagem
         */
        echo json_encode($idAbrangencia == 5 ? $retSNAP : $retAPF);
        exit();
    } else {
        echo pInv();
        exit();
    }
} else {
    echo json_encode(array(
        'msg' => 'Acesso n&atilde;o autorizado!'
    ));
}
