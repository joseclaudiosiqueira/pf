<?php

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
$id = NULL !== filter_input(INPUT_GET, 'i', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_GET, 'i', FILTER_SANITIZE_NUMBER_INT) : FALSE;
//verifica se esta logado e o id e valido
if ($login->isUserLoggedIn() && $id && verificaSessao()) {
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
    $isVisualizarContagemFornecedor = $_SESSION['contagem_config']['is_visualizar_contagem_fornecedor'] ? true : false;
    //verifica se a contagem eh de um fornecedor
    $isContagemFornecedor = $fn->isContagemFornecedor($id);
    //verifica se eh um gestor
    $isGestor = getVariavelSessao('isGestor');
    //verifica se eh o gerente do projeto
    $isGerenteProjeto = getVariavelSessao('isGerenteProjeto');
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
    $isValidadorInterno = getVariavelSessao('isValidadorInterno');
    //verifica se eh o validador externo da contagem
    $isValidadorExterno = getVariavelSessao('isValidadorExterno');
    //verifica se eh o auditor interno da contagem
    $isAuditorInterno = getVariavelSessao('isAuditorInterno');
    //verifica se eh o auditor externo da contagem
    $isAuditorExterno = getVariavelSessao('isAuditorExterno');
    //fiscal do contrato
    $isFiscalContrato = getVariavelSessao('isFiscalContrato');
    //fiscal no nivel de empresa
    $isFiscalContratoEmpresa = getVariavelSessao('isFiscalContratoEmpresa');
    //fiscal de contrato de um fornecedor
    $isFiscalContratoFornecedor = getVariavelSessao('isFiscalContratoFornecedor');
    //financeiro
    $isFinanceiro = getVariavelSessao('isFinanceiro');
    //instancia a clase cliente para verificar contagens de fornecedores e acesso do fiscal de contrato
    //o fiscal de contrato deve visualizar as contagens de fornecedores tambem
    $consultaContagem = $fn->getContagem($id, $idAbrangencia);
    if ($idAbrangencia != 3 && $idAbrangencia != 4) {
        //para contagens de baseline isso nao existe, cliente, fornecedor, etc.
        //pega o id do cliente na tabela contagem e depois no users_empresa
        $idClienteContagem = $fn->getIdCliente($id)['id_cliente'];
        //para as coisas do fiscal de contrato nao ha como pegar o cliente e o fornecedor, porque nao existe
        $idClienteFiscalContrato = $user->getIdClienteFiscalContrato($userId);
        $cliente = new Cliente();
        $acessoFiscalContrato = $cliente->getAcessoFiscalContrato($consultaContagem['CNT_id_empresa'], $consultaContagem['CNT_id_fornecedor']);
    }
    /*
     * verifica se eh um fornecedor
     */
    $isFornecedor = isFornecedor();
    $tipoFornecedor = 0;
    /*
     * verifica se e uma turma
     */
    if ($isFornecedor) {
        $fornecedor = new Fornecedor();
        $tipoFornecedor = $fornecedor->getTipo(getIdFornecedor());
    }
    if (!$tipoFornecedor) {
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
        include(DIR_BASE . 'actions/relatorios/consulta_inicial.php');
        //verifica autorizacao para a empresa e para o fornecedor
        if ($idEmpresa != $consultaContagem['CNT_id_empresa']) {
            /*
             * pagina com o sumario da contagem
             */
            include(DIR_BASE . 'actions/relatorios/nao_autorizado.php');
            exit;
        }
        if ($isFornecedor) {
            if ($idFornecedor != $consultaContagem['CNT_id_fornecedor']) {
                /*
                 * pagina com o sumario da contagem
                 */
                include(DIR_BASE . 'actions/relatorios/nao_autorizado.php');
                exit;
            }
        }
        /*
         * neste modelo verifica se eh popup (dois monitores e coloca o formulario na primeira contagem
         */
        if (isset($_GET['dm'])) {
            $contagemAnalise = new ContagemAnaliseFiscal();
            $idContagem1 = filter_input(INPUT_GET, 'i', FILTER_SANITIZE_NUMBER_INT);
            $idContagem2 = filter_input(INPUT_GET, 'i2', FILTER_SANITIZE_NUMBER_INT);
            $isAnaliseExistente = $contagemAnalise->getContagemAnaliseFiscal($idContagem1, $idContagem2);
        }
        $html = '';
        /*
         * pega o gravatar do usuario
         */
        $userGravatar = getGravatarImageUser(sha1($consultaContagem['CNT_user_id']));
        $html .= '
            <center>
                <img src="' . $userGravatar . '" class="img-circle" width="120" height="120" /><br />
                        <strong>' . $usuario['user_complete_name'] . '</strong>, criada em: 
                        <strong>' . date_format(date_create($consultaContagem['CNT_data_cadastro']), 'd/m/Y H:i:s') . '</strong><br />
                        Demandante: <strong>' . $consultaContagem['ORG_sigla'] . ' - ' . $consultaContagem['ORG_descricao'] . '</strong>
            </center>
            <br />
                <table width="100%" border="0" cellpadding="5">
                    <tr bgcolor="#f0f0f0"><td colspan="4" align="center" style="border-bottom: 1px solid #d0d0d0;"><strong>Informa&ccedil;&otilde;es contratuais</strong></td></tr>
                    <tr>
                        <td width="15%">Cliente:</td>
                        <td width="50%"><strong>' . $consultaContagem['CLI_descricao'] . '</strong></td>
                        <td width="12%">Entregas:</td>
                        <td width="23%"><strong>' . $consultaContagem['CNT_entregas'] . '</strong></td>
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
                </table>

                <div width="100%" style="height:15px;">&nbsp;</div>
                <table width="100%" border="0" cellpadding="5">
                    <tr bgcolor="#f0f0f0"><td colspan="2" align="center" style="border-bottom: 1px solid #d0d0d0;"><strong>Informa&ccedil;&otilde;es b&aacute;sicas da contagem</strong></td></tr>
                    <tr>
                        <td width="15%">Linguagem:</td>
                        <td width="85%"><strong>'
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
                        <td><strong>' . ucfirst($consultaContagem['ABR_chave']) . '</strong></td></tr>
                </table>';

        $html .=!(isset($_GET['cp'])) ?
                '<div width="100%" style="height:15px;">&nbsp;</div>
                <table width="100%" border="0" cellpadding="5">
                    <tr bgcolor="#f0f0f0"><td align="center" style="border-bottom: 1px solid #d0d0d0;"><strong>Prop&oacute;sito da Contagem</strong></td></tr>
                    <tr><td height="140" valign="top">' . $consultaContagem['CNT_proposito'] . '</td></tr>
                </table>

                <div width="100%" style="height:15px;">&nbsp;</div>
                <table width="100%" border="0" cellpadding="5">
                    <tr bgcolor="#f0f0f0"><td align="center" style="border-bottom: 1px solid #d0d0d0;"><strong>Escopo da Contagem</strong></td></tr>
                    <tr><td height="140" valign="top">' . $consultaContagem['CNT_escopo'] . '</td></tr>        
                </table>' : '';
        echo $html;
        /*
         * so exibe qualquer outra pagina se tiver no minimo uma funcao de dados/transacao/outros
         */
        if (count($funcoes) > 0) {
            /*
             * pagina com o sumario da contagem
             */
            include(DIR_BASE . 'actions/relatorios/_pagina_sumario.php');
            /*
             * pagina com as estatisticas da contagem e o planejamento das fases
             */
            $_SESSION['empresa_config_plano']['id'] == 3 ? include(DIR_BASE . 'actions/relatorios/_pagina_estatisticas.php') : NULL;
            /*
             * pagina com a linhas de ALI, AIE, etc
             */
            include(DIR_BASE . 'actions/relatorios/_pagina_linhas_contagem.php');
            /*
             * pagina com o resumo das entregas
             */
            $_SESSION['empresa_config_plano']['id'] == 3 && !(isset($_GET['cp'])) ? include(DIR_BASE . 'actions/relatorios/_pagina_resumo_entregas.php') : NULL;
            /*
             * pagina com as tabelas cocomo
             */
            !(isset($_GET['cp'])) ? include(DIR_BASE . 'actions/relatorios/_pagina_cocomo.php') : NULL;
        }
        /*
         * pagina com sobre validacoes e auditorias
         */
        !(isset($_GET['cp'])) ? include(DIR_BASE . 'actions/relatorios/_pagina_validacao_auditoria.php') : NULL;
        /*
         * verifica se esta validando e se o parametro eh dois monitores
         */
        if ($isFiscalContrato || $isFiscalContratoEmpresa || $isFiscalContratoFornecedor) {
            if (isset($_GET['dm'])) {
                include(DIR_BASE . 'forms/form_inserir_analise_fiscal_contrato.php');
            }
        }
    } else {
        /*
         * pagina acesso nao autorizado para os relatorios
         */
        include(DIR_BASE . 'actions/relatorios/nao_autorizado.php');
    }
} else {
    /*
     * pagina com o sumario da contagem
     */
    include(DIR_BASE . 'actions/relatorios/nao_autorizado.php');
}