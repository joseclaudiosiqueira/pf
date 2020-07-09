<?php

isset($maf) ? require_once($_SERVER['DOCUMENT_ROOT'] . (substr($_SERVER['DOCUMENT_ROOT'], -1) === '/' ? '' : '/') . 'pf/conf/conf.php') : NULL;
/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verificacao do status do login e do id
 */
$id = NULL !== filter_input(INPUT_GET, 'i', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_GET, 'i', FILTER_SANITIZE_NUMBER_INT) : (isset($idContagem) ? $idContagem : 0);
//verifica se esta logado e o id e valido
if ($login->isUserLoggedIn() && $id && verificaSessao()) {
    $nomePDF = isset($maf) ? 'contagem-' . str_pad($id, 11, '0', STR_PAD_LEFT) . '.pdf' : FALSE;
    //realiza todas as verificacoes antes de emitir qualquer relatorio
    //realiza todas as verificacoes antes de emitir qualquer relatorio
    $userId = getUserIdDecoded();
    //define as variaveis
    $user_email = getVariavelSessao('user_email');
    //pega o id do fornecedor
    $idFornecedor = getIdFornecedor();
    //pega o id da empresa
    $idEmpresa = getIdEmpresa();
    //instancia as classes
    $fn = new Contagem();
    $user = new Usuario();
    $ch = new ContagemHistorico();
    $cp = new ContagemProcesso();
    $ca = new ContagemAcesso();
    $ca->setUserEmail($user_email);
    //seta as tabelas
    //pega a abrangencia atual para SNAP e outras
    $idAbrangencia = $fn->getAbrangencia($id)['id_abrangencia'];
    //variavel $pass ... determina se a acao pode ser executada pelo solicitante
    $pass = false;
    //verifica se eh o responsavel pela contagem
    $isResponsavel = $fn->isResponsavel($user_email, $id);
    //verifica a privacidade da contagem
    $privacidade = $fn->getPrivacidade($id)['privacidade'];
    //verifica se pode visualizar contagens de fornecedor
    $isVisualizarContagemFornecedor = getConfigContagem('is_visualizar_contagem_fornecedor') ? true : false;
    //verifica se a contagem eh de um fornecedor
    $isContagemFornecedor = $fn->isContagemFornecedor($id);
    //verifica se eh um gestor
    $isGestor = getVariavelSessao('isGestor');
    //verifica se eh o gerente do projeto
    $isGerenteProjeto = $fn->isGerenteProjeto($user_email, $id);
    //verifica se existe autorizacao para o usuario visualizar a contagem
    $ca->setIdContagem($id);
    $isAutorizado = $ca->isAutorizado();
    //verifica se eh um gerente de conta
    $isGerenteConta = getVariavelSessao('isGerenteConta');
    //verifica se eh um perfil de diretor
    $isDiretor = getVariavelSessao('isDiretor');
    //visualizador
    $isViewer = getVariavelSessao('isViewer');
    //verifica se o perfil eh de analista de metricas e a contagem e publica e exibe
    $isPerfilAnalistaMetricas = getVariavelSessao('isAnalistaMetricas');
    //verifica se eh o validador interno da contagem
    $isValidadorInterno = $fn->isValidadorInterno($user_email, $id);
    //verifica se eh o validador externo da contagem
    $isValidadorExterno = $fn->isValidadorExterno($user_email, $id);
    //verifica se eh o auditor interno da contagem
    $isAuditorInterno = $fn->isAuditorInterno($user_email, $id);
    //verifica se eh o auditor externo da contagem
    $isAuditorExterno = $fn->isAuditorExterno($user_email, $id);
    //fiscal do contrato
    $isFiscalContrato = getVariavelSessao('isFiscalContratoCliente');
    //fiscal no nivel de empresa
    $isFiscalContratoEmpresa = getVariavelSessao('isFiscalContratoEmpresa');
    //fiscal contrato cliente
    $isFiscalContratoFornecedor = getVariavelSessao('isFiscalContratoFornecedor');
    //financeiro
    $isFinanceiro = getVariavelSessao('isFinanceiro');
    //instancia a clase cliente para verificar contagens de fornecedores e acesso do fiscal de contrato
    //o fiscal de contrato deve visualizar as contagens de fornecedores tambem
    $consultaContagem = $fn->getContagem($id, $idAbrangencia);
    //verifica se existe a contagem com o id passado
    $isContagemAutorizada = isset($consultaContagem['CNT_id']);
    //confere antes de prosseguir
    if ($isContagemAutorizada) {
        //verifica a abgrangencia e pesquisa fiscal de contrato (cliente)
        if ($consultaContagem['CNT_id_abrangencia'] != 3 && $consultaContagem['CNT_id_abrangencia'] != 4) {
            //para contagens de baseline isso nao existe, cliente, fornecedor, etc.
            //pega o id do cliente na tabela contagem e depois no users_empresa
            $idClienteContagem = $fn->getIdCliente($id)['id_cliente'];
            //para as coisas do fiscal de contrato nao ha como pegar o cliente e o fornecedor, porque nao existe
            $idClienteFiscalContrato = $user->getIdClienteFiscalContrato($userId);
            $cliente = new Cliente();
            $acessoFiscalContrato = $cliente->getAcessoFiscalContrato($consultaContagem['CNT_id_empresa'], $consultaContagem['CNT_id_fornecedor']);
        }
    }
    /*
     * verifica se eh um fornecedor
     */
    $isFornecedor = isFornecedor();
    $tipoFornecedor = 0;
    /*
     * verifica se e uma turma
     */
    if ($isFornecedor && $isContagemAutorizada) {
        $fornecedor = new Fornecedor();
        $tipoFornecedor = $fornecedor->getTipo(getIdFornecedor());
    }
    /*
     * continua com os testes
     */
    if ($isContagemAutorizada) {
        if ($isDiretor || $isGestor || $isGerenteConta || $isViewer || $isResponsavel || $isGerenteProjeto || $isFiscalContratoEmpresa) {
            $pass = true;
        } elseif ($isAuditorInterno || $isAuditorExterno || $isValidadorExterno || $isValidadorInterno || $isAutorizado) {
            $pass = true;
        } elseif (($isPerfilAnalistaMetricas && !$privacidade) || $isAutorizado) {
            if ($isContagemFornecedor && $isVisualizarContagemFornecedor || $isFiscalContratoFornecedor) {
                $pass = true;
            } elseif (!$isContagemFornecedor && !$privacidade) {
                $pass = true;
            } elseif ($isAutorizado) {
                $pass = true;
            }
        } elseif (($isFiscalContrato || $isFinanceiro) && $idClienteContagem == $idClienteFiscalContrato) {
            $pass = true;
        } elseif ($consultaContagem['CNT_id_fornecedor'] && $acessoFiscalContrato['id'] == $consultaContagem['CNT_id_cliente']) {
            $pass = true;
        }
    } else {
        $pass = false;
    }
    //verifica o acesso
    if ($pass) {
        require DIR_BASE . 'actions/relatorios/consulta_inicial.php';
        //verifica autorizacao para a empresa e para o fornecedor
        if ($idEmpresa != $consultaContagem['CNT_id_empresa']) {
            /*
             * pagina com o sumario da contagem
             */
            require DIR_BASE . 'actions/relatorios/nao_autorizado.php';
            exit;
        }
        if ($isFornecedor) {
            if ($idFornecedor != $consultaContagem['CNT_id_fornecedor']) {
                /*
                 * pagina com o sumario da contagem
                 */
                require DIR_BASE . 'actions/relatorios/nao_autorizado.php';
                exit;
            }
        }
        // create new PDF document
        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // seta os diretorios para as imagens
        $pdf->setDirLogomarca(DIR_BASE . 'vendor/cropper/producao/crop/img/' . (isFornecedor() ? 'img-forn/' : 'img-emp/'));
        $pdf->setDirLogomarcaCliente(DIR_BASE . 'vendor/cropper/producao/crop/img/img-cli/');
        // seta os isLogomarca*
        $pdf->setIsLogomarcaCliente(($idAbrangencia == 3 || $idAbrangencia == 4) ? false : $configRelatorio['is_logomarca_cliente']);
        $pdf->setIsLogomarcaEmpresa(($idAbrangencia == 3 || $idAbrangencia == 4) ? true : $configRelatorio['is_logomarca_empresa']);
        // seta o sha1 das logomarcas
        $pdf->setLogomarca(sha1(isFornecedor() ? getIdFornecedor() : getIdEmpresa()) . '.png');
        $pdf->setLogomarcaCliente(sha1(isFornecedor() ? getIdClienteFornecedor() : $consultaContagem['CNT_id_cliente']) . '.png');
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('');
        $pdf->SetTitle('Dimension - Metricas de Software');
        $pdf->SetSubject('');
        $pdf->SetKeywords('Metricas, Software, SNAP, APF, APT, Dimension, Pontos de Funcao, Pontos de Teste, Projetos');
        // cabecalho e rodape
        $pdf->setCabLinha1(html_entity_decode($configRelatorio['cab_linha_1']));
        $pdf->setCabLinha2(html_entity_decode($configRelatorio['cab_linha_2']));
        $pdf->setCabLinha3(html_entity_decode($configRelatorio['cab_linha_3']));
        $pdf->setCabAlinhamento(html_entity_decode($configRelatorio['cab_alinhamento']));
        $pdf->setRodLinha1(html_entity_decode($configRelatorio['rod_linha_1']));
        /*
         * set do background especifico para o processo
         * "1","Em elaboracao","Elaborada","1"
         * "2","Em validacao interna","Validada internamente","1"
         * "3","Em validacao externa","Validada externamente","1"
         * "4","Em auditoria interna","Auditada internamente","1"
         * "5","Em auditoria externa","Auditada externamente","1"
         * "6","Em revisao","Revisada","1"
         * "7","Faturada","Faturada","1"
         * "8","Em revisao<br />Validacao Interna","1"
         * "9","Em revisao<br />Validacao Externa","1"
         * 
         */
        $processo = $ch->getContagemProcesso($consultaContagem['CNT_id'], '1, 2, 6, 8');
        //testa o valor retornado pelo processo
        if ($tipoFornecedor) {
            $pdf->setBackgroundPlano('img/graduation-cap.gif');
        } elseif (($processo['id_processo'] == 1 ||
                $processo['id_processo'] == 2 ||
                $processo['id_processo'] == 6 ||
                $processo['id_processo'] == 8) && NULL === $processo['data_fim']) {
            $pdf->setBackgroundPlano('img/naovalidada.jpg');
        } elseif ($_SESSION['empresa_config_plano']['id'] == 1) {
            $pdf->setBackgroundPlano('img/planoestudante.jpg');
        } elseif ($_SESSION['empresa_config_plano']['id'] == 2) {
            $pdf->setBackgroundPlano('img/planodemo.jpg');
        } else {
            $pdf->setBackgroundPlano('img/blank.jpg');
        }
        // set margins
        //PDF_MARGIN_LEFT e PDF_MARGIN_RIGHT
        $pdf->SetMargins(8, PDF_MARGIN_TOP, 8);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        // ---------------------------------------------------------
        // set default font subsetting mode
        $pdf->setFontSubsetting(true);
        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('freesans', '', 8, '', true);
        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage('P');
        // set text shadow effect
        //$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
        // Set some content to print
        $html = '
        <table width="100%" border="0" cellpadding="5">
            <tr bgcolor="#f0f0f0"><td colspan="4" align="center" style="border-bottom: 1px solid #d0d0d0;"><strong>Informa&ccedil;&otilde;es contratuais</strong></td></tr>
            <tr>
                <td width="15%">Cliente:</td>
                <td width="50%"><strong>' . $consultaContagem['CLI_descricao'] . '</strong></td>
                <td width="14%">Entregas:</td>
                <td width="21%"><strong>' . $consultaContagem['CNT_entregas'] . '</strong></td>
            </tr>
            <tr>
                <td>Contrato:</td>
                <td><strong>' . $consultaContagem['CON_numero'] . '/' . $consultaContagem['CON_ano'] . '</strong></td>
                <td>Valor do PF:</td>
                <td><strong>R$ ' . (isPermitido('visualizar_valor_pf') ? number_format($consultaContagem['CON_valor_pf'], 2, ",", ".") : '-') . '</strong></td>                
            </tr>
            <tr>
                <td>Projeto:</td>
                <td><strong>' . $consultaContagem['PRJ_descricao'] . '</strong></td>
                <td>Demanda:</td>
                <td><strong>' . $consultaContagem['CNT_ordem_servico'] . '</strong></td>                    
            </tr>        
            <tr>
                <td>Respons&aacute;vel:</td>
                <td><strong>' . $usuario['user_complete_name'] . '</strong></td>
                <td>Cria&ccedil;&atilde;o:</td>
                <td><strong>' . date_format(date_create($consultaContagem['CNT_data_cadastro']), 'd/m/Y H:i:s') . '</strong></td>
            </tr>
        </table>
        
        <div width="100%" style="height:15px;">&nbsp;</div>
        <table width="100%" border="0" cellpadding="5">
            <tr bgcolor="#f0f0f0"><td colspan="2" align="center" style="border-bottom: 1px solid #d0d0d0;"><strong>Informa&ccedil;&otilde;es b&aacute;sicas da contagem</strong></td></tr>
            <tr>
                <td width="15%">Linguagem:</td>
                <td width="75%"><strong>'
                . $consultaContagem['LNG_descricao'] . ' - '
                . str_replace(array('baixa', 'media', 'alta'), array('Baixa', 'Média', 'Alta'), $estatisticas['escala_produtividade'])
                . ' Hh/PF => '
                . number_format(($estatisticas['escala_produtividade'] === 'baixa' ? $estatisticas['produtividade_baixa'] : ($estatisticas['escala_produtividade'] === 'media' ? $estatisticas['produtividade_media'] : $estatisticas['produtividade_alta'])), 2, ",", ".")
                . ' (B: ' . number_format($estatisticas['produtividade_baixa'], 2, ",", ".")
                . ' M: ' . number_format($estatisticas['produtividade_media'], 2, ",", ".")
                . ' A: ' . number_format($estatisticas['produtividade_alta'], 2, ",", ".") . ')'
                . '</strong></td></tr>
            <tr>
                <td>Tipo:</td>
                <td><strong>' . $consultaContagem['TPO_descricao'] . '</strong></td></tr>
            <tr>
                <td>Etapa:</td>
                <td><strong>' . $consultaContagem['ETP_descricao'] . '</strong></td></tr>
            <tr>
                <td>Processo:</td>
                <td><strong>' . $consultaContagem['PRD_descricao'] . '</strong></td></tr>
            <tr>
                <td>Gest&atilde;o:</td>
                <td><strong>' . $consultaContagem['PRG_descricao'] . '</strong></td></tr>
            <tr>
                <td>Segmento:</td>
                <td><strong>' . $consultaContagem['IND_descricao'] . '</strong></td></tr>
            <tr>
                <td>SGBD:</td>
                <td><strong>' . $consultaContagem['BDO_descricao'] . '</strong></td></tr>
            <tr>
                <td>Abrang&ecirc;ncia:</td>
                <td><strong>' . ucfirst($consultaContagem['ABR_descricao']) . '</strong></td></tr>
        </table>
        
        <div width="100%" style="height:15px;">&nbsp;</div>
        <table width="100%" border="0" cellpadding="5">
            <tr bgcolor="#f0f0f0"><td align="center" style="border-bottom: 1px solid #d0d0d0;"><strong>Prop&oacute;sito da Contagem</strong></td></tr>
            <tr><td height="150">' . $consultaContagem['CNT_proposito'] . '</td></tr>
        </table>
        
        <div width="100%" style="height:15px;">&nbsp;</div>
        <table width="100%" border="0" cellpadding="5">
            <tr bgcolor="#f0f0f0"><td align="center" style="border-bottom: 1px solid #d0d0d0;"><strong>Escopo da Contagem</strong></td></tr>
            <tr><td height="150">' . $consultaContagem['CNT_escopo'] . '</td></tr>        
        </table>';
        // Print text using writeHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        /*
         * so exibe qualquer outra pagina se tiver no minimo uma funcao de dados/transacao/outros
         */
        if (count($funcoes) > 0) {
            /*
             * pagina com o sumario da contagem
             */
            require DIR_BASE . 'actions/relatorios/_pagina_sumario.php';
            /*
             * pagina com a linhas de ALI, AIE, etc
             */
            require DIR_BASE . 'actions/relatorios/_pagina_linhas_contagem.php';
            /*
             * daqui pra frente apenas se for contagens projeto e livre
             */
            if ($consultaContagem['CNT_id_abrangencia'] != 3 && $consultaContagem['CNT_id_abrangencia'] != 4) {
                /*
                 * pagina com as estatisticas da contagem e o planejamento das fases
                 */
                $_SESSION['empresa_config_plano']['id'] == 3 ? require DIR_BASE . 'actions/relatorios/_pagina_estatisticas.php' : NULL;
                /*
                 * pagina com o resumo das entregas
                 */
                $_SESSION['empresa_config_plano']['id'] == 3 ? require DIR_BASE . 'actions/relatorios/_pagina_resumo_entregas.php' : NULL;
                /*
                 * pagina com as tabelas cocomo
                 */
                require DIR_BASE . 'actions/relatorios/_pagina_cocomo.php';
            }
        }
        /*
         * pagina com sobre validacoes e auditorias
         */
        require DIR_BASE . 'actions/relatorios/_pagina_validacao_auditoria.php';
        /*
         * pagina com o resumo das entregas
         */
        $assinaturas['is_assinatura_relatorio'] ?
                        require DIR_BASE . 'actions/relatorios/_pagina_assinaturas.php' : NULL;

        $pdf->Output(($nomePDF ? DIR_TEMP . '/' . $nomePDF : 'Relatorio.' . date('YmdHis') . '.pdf'), ($nomePDF ? 'F' : 'I'));
        /*
         * retorna para a pagina chamadora
         */
        return true;
    } else {
        /*
         * pagina acesso nao autorizado para os relatorios
         */
        require DIR_BASE . 'actions/relatorios/nao_autorizado.php';
        exit;
    }
} else {
    /*
     * pagina com o sumario da contagem
     */
    require DIR_BASE . 'actions/relatorios/nao_autorizado.php';
    exit;
}