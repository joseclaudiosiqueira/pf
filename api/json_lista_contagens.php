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
    $re1 = array();
    $res = array(
        'draw' => 1,
        'recordsTotal' => 0,
        'recordsFiltered' => 0
    );
    $arrLabels = array(
        1 => 'label-processo-1',
        2 => 'label-processo-2',
        3 => 'label-processo-3',
        6 => 'label-processo-6',
        7 => 'label-processo-7',
        9 => 'label-processo-9',
        8 => 'label-processo-8',
        10 => 'label-processo-10',
        18 => 'label-processo-18',
        19 => 'label-processo-19',
        20 => 'label-processo-20',
        21 => 'label-processo-21'
    );
    // verifica se tem um id para pesquisar apenas uma contagem
    if ((isset($_GET['p']) || isset($_POST['p'])) && (isset($_GET['v']) || isset($_POST['v']))) {
        // verifica os parametros especiais l = licitacoes e b = baselines
        $abrangencia = '';
        if (isset($_GET['b']) || isset($_POST['b'])) {
            $abrangencia = 'baseline';
        } else if (isset($_GET['l']) || isset($_POST['l'])) {
            $abrangencia = 'licitacao';
        }
        // variaveis do usuario logado
        $userId = getUserIdDecoded();
        $email = getEmailUsuarioLogado();
        // outros parametros
        $p = isset($_GET['p']) ? $_GET['p'] : $_POST['p']; // parametro
        $v = isset($_GET['v']) ? $_GET['v'] : $_POST['v']; // valor
        $fau = isset($_GET['fau']) || isset($_POST['fau']) ? true : false; // contagens faturamento autorizado
        $fat = isset($_GET['fat']) || isset($_POST['fat']) ? true : false; // contagens faturadas
        $minhas = isset($_GET['m']) || isset($_POST['m']) ? true : false; // minhas contagens
        $acessos = isset($_GET['a']) || isset($_POST['a']) ? true : false; // minhas contagens
        $idFornecedor = getIdFornecedor();
        $idEmpresa = getIdEmpresa();
        $roteiro = new Roteiro();
        // $ana = isset($_GET['ana']) || isset($_POST['ana']) ? true : false; //minhas analises ... fiscal contrato
        // define a classe contagem
        $fa = new Contagem();
        // define a abrangencia para selecionar a privacidade
        $ca = new ContagemAcesso();
        $ca->setUserEmail($email);
        // instancia um fornecedor para verificar o tipo
        $fornecedor = new Fornecedor();
        // instancia a baseline
        $ba = new Baseline();
        // verifica se eh um gestor
        $usuario = new Usuario();
        $isGestor = getVariavelSessao('isGestor');
        $isGestorFornecedor = getVariavelSessao('isGestorFornecedor');
        $isInstrutor = getVariavelSessao('isInstrutor');
        $isFiscalContratoCliente = getVariavelSessao('isFiscalContratoCliente');
        $isFiscalContratoFornecedor = getVariavelSessao('isFiscalContratoFornecedor');
        $idClienteFiscalContrato = $isFiscalContratoCliente ? $usuario->getIdClienteFiscalContrato($userId) : 0;
        // verifica se eh um fiscal contrato nivel empresa, ou seja, nao esta no cliente nem no fornecedor
        $isFiscalContratoEmpresa = getVariavelSessao('isFiscalContratoEmpresa');
        // verifica se eh um fiscal de contrato
        $isFiscalContrato = ($isFiscalContratoCliente || $isFiscalContratoEmpresa || $isFiscalContratoFornecedor) ? TRUE : FALSE;
        // reavalia a variavel $ana
        // $ana = $isFiscalContrato ? true : false;
        // verifica se eh um gerente de conta
        $isGerenteConta = getVariavelSessao('isGerenteConta');
        // verifica se eh um perfil de diretor
        $isDiretor = getVariavelSessao('isDiretor');
        // visualizador
        $isViewer = getVariavelSessao('isViewer');
        // verifica se o perfil eh de analista de metricas e a contagem e publica e exibe
        $isPerfilAnalistaMetricas = getVariavelSessao('isAnalistaMetricas');
        //verifica se o fiscal visualiza todas as contagens
        $isFiscalVisualizarTodasContagens = getConfigContagem('is_visualizar_todas_fiscal_contrato');
        // verifica o perfil de analista de metricas do fornecedor
        $isPerfilAnalistaMetricasFornecedor = getVariavelSessao('isAnalistaMetricasFornecedor');
        // verifica se os Analistas de Metricas podem visualizar contagens de fornecedores
        $isVisualizarContagemFornecedor = (getConfigContagem('is_visualizar_contagem_fornecedor') || $isInstrutor || $isFiscalContrato) ? TRUE : FALSE;
        // financeiro
        $isFinanceiro = getVariavelSessao('isFinanceiro');
        // lista as contagens
        $ret = $fa->listaContagem($idEmpresa, $idFornecedor, $p, $v, NULL, NULL, $isGestor, $isGerenteConta, $isDiretor, $isVisualizarContagemFornecedor, $abrangencia, $isInstrutor, $isFiscalContrato, $fau, $fat, $minhas, $acessos);
        // echo json_encode(array('p' => $p, 'v' => $v));
        // die();
        // debug
        // echo $ret; die();
        // $col_responsavel = '';
        // monta o array inicial
        $re1 = array();
        $res = array(
            'draw' => 1,
            'recordsTotal' => count($ret),
            'recordsFiltered' => count($ret)
        );
        // passa pelas contagens da listagem
        foreach ($ret as $linha) {
            // estabelece se eh uma contagem de auditoria
            $isContagemAuditoria = $linha['is_contagem_auditoria'];
            // pega o processo e data em que a contagem esta
            $contagemProcesso = $fa->getContagemProcesso($linha['id'], '1, 2, 3, 6, 7, 8, 9, 10, 18, 19, 20, 21');
            // coloca a data fim do processo
            $dataFim = $contagemProcesso['data_fim'] ? TRUE : FALSE;
            // pega o validador em caso de estar ainda em validacao interna
            $validadorInterno = (($contagemProcesso['id_processo'] == 2 || $contagemProcesso['id_processo'] == 10) && NULL === $contagemProcesso['data_fim']) ? $linha['validador_interno'] : false;
            $validadorExterno = ($contagemProcesso['id_processo'] == 3 && NULL === $contagemProcesso['data_fim']) ? $linha['validador_externo'] : false;
            $validador = $validadorInterno ? $linha['validador_interno'] : ($validadorExterno ? $linha['validador_externo'] : '');
            // obtem a descricao do processo atual
            $descricaoProcesso = '<center><div class="label-round ' . (NULL === $contagemProcesso['data_fim'] ? $arrLabels[$contagemProcesso['id_processo']] : 'label-processo-7a') . '">' . (NULL === $contagemProcesso['data_fim'] ? $contagemProcesso['descricao_em_andamento'] : ($contagemProcesso['id_processo'] == 7 && !$linha['is_faturada'] ? '<i class="fa fa-flag-checkered"></i>&nbsp;' : ($linha['is_faturada'] ? '<i class="fa fa-check-square-o"></i>&nbsp;' : '')) . ($linha['is_faturada'] ? 'Faturada' : $contagemProcesso['descricao_concluido']) . '</div><br />' . date_format(date_create($contagemProcesso['data_fim']), 'd/m/Y H:i:s')) . '</div>';
            // $nome = explode('@', $linha['responsavel']);
            // pega a privacidade de depois junto com o tipo
            $lock = '<span id="priv-'
                    . $linha['id_primario'] . '">'
                    . ($linha['privacidade'] ? '<i class="fa fa-ban fa-lg"></i>&nbsp;&nbsp;' : '<i class="fa fa-circle-thin fa-lg"></i>&nbsp;&nbsp;')
                    . '</span>'
                    . ($isContagemAuditoria ? '<i class="fa fa-bullseye fa-lg"></i>&nbsp;&nbsp;' : '');
            // verifica se eh uma contagem do tipo auditoria e marca para o fiscal
            // a variavel isFiscalContrato engloba os tres perfis de fiscal de contrato
            // pode exibir pra todo mundo?
            //if (($isFiscalContrato) && $isContagemAuditoria) {
            $labelContagemAuditoria = '';
            //} else {
            //    $labelContagemAuditoria = '';
            //}
            // se a abrangencia for baseline consulta pra ver funcionalidades pendentes de validacao, baseline nao consolidada
            $isBaselineNaoConsolidada = $abrangencia === 'baseline' ? $fa->isBaselineNaoConsolidada($linha['id']) : false;
            $siglaBaseline = $linha['descricao'] === 'Projeto' || $abrangencia === 'baseline' ? $ba->getSigla($linha['id_baseline']) : '';
            // verifica o tipo para poder exibir os totalizadores
            switch ($linha['tipo']) {
                case 'APF':
                case 'EF':
                    // $pfDados = $fa->totalPFADados($linha['id']);
                    // $pfTransacao = $fa->totalPFATransacao($linha['id']);
                    // $pfOutros = $fa->totalPFAOutros($linha['id']);
                    // $qtdPFA = number_format(($pfDados['pfa'] + $pfTransacao['pfa'] + $pfOutros['pfa']), 3, ',', '.');
                    $qtdPFA = number_format($linha['tamanho_pfa'], 3, ',', '.');
                    $qtd = '<strong>'
                            . $linha['tipo']
                            . '</strong> - PFa: <strong>'
                            . $qtdPFA . '</strong>'
                            . '<br />'
                            . ($isBaselineNaoConsolidada ? '<font style="color: red;"><i class="fa fa-circle fa-lg"></i></font>&nbsp;&nbsp;' : '')
                            . $lock
                            . ucfirst($linha['descricao']
                                    . $labelContagemAuditoria);
                    break;
                case 'SNAP':
                    $qtd = '<strong>' . $linha['tipo'] . '</strong>';
                    break;
                case 'APT':
                    break;
            }
            //verifica a descricao do roteiro
            $descricaoRoteiro = $roteiro->getDescricao($linha['id_roteiro'])['descricao'];
            // pega pelo id_primario, o que pode gerar versoes sem alterar o programa
            $id = '<div style="text-align: center;">'
                    . '<a href="#" '
                    . 'onclick="verificaAutorizacao(' . $linha['id_primario'] . ', $(this)); return false;">'
                    . '<strong>' . str_pad($linha['id_primario'], 7, '0', STR_PAD_LEFT) . '</strong></a><br />'
                    . date_format(date_create($linha['data_cadastro']), 'd/m/Y') . '<br / >'
                    . $descricaoRoteiro
                    . '</div>';
            // verifica se eh o responsavel pela contagem
            $isResponsavel = $fa->isResponsavel($email, $linha['id']);
            // verifica se eh o validador interno da contagem
            $isValidadorInterno = $fa->isValidadorInterno($email, $linha['id']);
            // verifica se eh o validador externo da contagem
            $isValidadorExterno = $fa->isValidadorExterno($email, $linha['id']);
            // verifica se eh o auditor interno da contagem
            $isAuditorInterno = $fa->isAuditorInterno($email, $linha['id']);
            // verifica se eh o auditor interno da contagem
            $isAuditorExterno = $fa->isAuditorExterno($email, $linha['id']);
            // verifica se eh o auditor interno da contagem
            $isGerenteProjeto = $fa->isGerenteProjeto($email, $linha['id']);
            // verifica se existe autorizacao para o usuario visualizar a contagem
            $ca->setIdContagem($linha['id']);
            $isAutorizado = $ca->isAutorizado();
            // coloca a contagem como de um fornecedor
            $isContagemFornecedor = (int) $linha['id_fornecedor'] > 0 ? 1 : 0;
            // coloca o tipo de fornecedor
            $isTipoFornecedorTurma = (int) $fornecedor->getTipo($linha['id_fornecedor']) > 0 ? TRUE : FALSE;
            // para cada linha verifica a privacidade exibe apenas as publicas ou privadas
            // em que o usuario tenha acesso para as demais somente publicas e com atribuicao
            if (($isDiretor || $isGestor || $isGerenteConta || $isViewer || $isResponsavel || $isGerenteProjeto || $isInstrutor || $isFiscalContratoEmpresa || $isGestorFornecedor || ($linha['id_cliente'] == $idClienteFiscalContrato && $isFiscalContratoCliente) || ($isContagemFornecedor && $linha['id_fornecedor'] == $idFornecedor && $isFiscalContratoFornecedor))) { // && $contagemProcesso['id_processo'] != 7
                // se for o responsavel vai direto
                if ($isResponsavel) {
                    $re1[] = array(
                        'lock' => $lock . '(1)',
                        'col1' => '<div style="text-align: center;"><a href="mailto:' . $linha['responsavel'] . '"><img src="' . getGravatarImageUser(sha1($linha['user_id'])) . '" class="img-circle" width="56" height="56"></a></div>',
                        'col2' => $id,
                        'col3' => ($linha['id_fornecedor']) ? $fa->getSiglaFornecedor($linha['id_fornecedor']) : '',
                        'col4' => '<div class="' . ($contagemProcesso['id_processo'] == 7 && $dataFim && !$linha['is_faturada'] ? (isFornecedor() ? 'fauF' : 'fauE') : 'efa') . '">' . $descricaoProcesso . (($validadorInterno || $validadorExterno) ? '<br /><a href="mailto:' . $validador . '">' . $validador . '</a>' : '') . '</center></div>',
                        'col5' => $qtd,
                        'col6' => $abrangencia === 'baseline' ? $linha['cliente'] : $linha['cliente'] . '<br />' . $linha['contrato'] . ' - ' . $linha['ordem_servico'],
                        'col7' => $linha['projeto'] . ($linha['descricao'] === 'Projeto' ? '<br />Baseline: ' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : ($linha['id_abrangencia'] == 3 ? '<br />' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : '')),
                        'col8' => '',
                        'ordem_servico' => $linha['ordem_servico'],
                        'id_processo' => $contagemProcesso['id_processo'],
                        'data_fim' => $contagemProcesso['data_fim'],
                        'validador_interno' => $linha['validador_interno'],
                        'validador_externo' => $linha['validador_externo']
                    );
                } // a contagem eh de um fornecedor
                elseif ($isContagemFornecedor) {
                    /*
                     * eh um fornecedor logado, e de uma turma ou posso visualizar contagens de turma
                     */
                    if ((isFornecedor() && $isTipoFornecedorTurma) || getConfigContagem('is_visualizar_contagem_turma')) {
                        $re1[] = array(
                            'lock' => $lock . '(1)',
                            'col1' => '<div style="text-align: center;"><a href="mailto:' . $linha['responsavel'] . '"><img src="' . getGravatarImageUser(sha1($linha['user_id'])) . '" class="img-circle" width="56" height="56"></a></div>',
                            'col2' => $id,
                            'col3' => ($linha['id_fornecedor']) ? $fa->getSiglaFornecedor($linha['id_fornecedor']) : '',
                            'col4' => '<div class="' . ($contagemProcesso['id_processo'] == 7 && $dataFim && !$linha['is_faturada'] ? 'fauF' : 'efa') . '">' . $descricaoProcesso . (($validadorInterno || $validadorExterno) ? '<br /><a href="mailto:' . $validador . '">' . $validador . '</a>' : '') . '</center></div>',
                            'col5' => $qtd,
                            'col6' => $abrangencia === 'baseline' ? $linha['cliente'] : $linha['cliente'] . '<br />' . $linha['contrato'] . ' - ' . $linha['ordem_servico'],
                            'col7' => $linha['projeto'] . ($linha['descricao'] === 'Projeto' ? '<br />Baseline: ' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : ($linha['id_abrangencia'] == 3 ? '<br />' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : '')),
                            'col8' => '',
                            'ordem_servico' => $linha['ordem_servico'],
                            'id_processo' => $contagemProcesso['id_processo'],
                            'data_fim' => $contagemProcesso['data_fim'],
                            'validador_interno' => $linha['validador_interno'],
                            'validador_externo' => $linha['validador_externo']
                        );
                        /*
                         * a contagem e de um fornecedor, pode visualizar as contagens de fornecedores
                         * ou eh um gestor que visualiza contagens que nao sao de turmas de treinamento
                         * TODO: ver configuracao para gerentes de conta
                         */
                    } elseif (isFornecedor() && getConfigContagem('is_visualizar_contagem_fornecedor') || (($isGestor || $isGestorFornecedor || $isFiscalContratoFornecedor) && !$isTipoFornecedorTurma)) {
                        $re1[] = array(
                            'col1' => '<div style="text-align: center;"><a href="mailto:' . $linha['responsavel'] . '"><img src="' . getGravatarImageUser(sha1($linha['user_id'])) . '" class="img-circle" width="56" height="56"></a></div>',
                            'col2' => $id,
                            'col3' => ($linha['id_fornecedor']) ? $fa->getSiglaFornecedor($linha['id_fornecedor']) : '',
                            'col4' => '<div class="' . ($contagemProcesso['id_processo'] == 7 && $dataFim && !$linha['is_faturada'] ? 'fauF' : 'efa') . '">' .
                            // . $descricaoProcesso
                            (($contagemProcesso['id_processo'] == 7 && !$dataFim && ($isFiscalContratoEmpresa || ($isContagemFornecedor && $linha['id_fornecedor'] == $idFornecedor && $isFiscalContratoFornecedor))) ? '<center><a class="label-round label-link btn-faturar" onclick="finalizarFaturamentoFiscal(' . $linha['id'] . ');"><i class="fa fa-check-circle"></i>&nbsp;Autorizar faturamento</a>' : $descricaoProcesso) . (($validadorInterno || $validadorExterno) ? '<br /><a href="mailto:' . $validador . '">' . $validador . '</a>' : '') . '</center></div>',
                            'col5' => $qtd,
                            'col6' => $abrangencia === 'baseline' ? $linha['cliente'] : $linha['cliente'] . '<br />' . $linha['contrato'] . ' - ' . $linha['ordem_servico'],
                            'col7' => $linha['projeto'] . ($linha['descricao'] === 'Projeto' ? '<br />Baseline: ' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : ($linha['id_abrangencia'] == 3 ? '<br />' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : '')),
                            'col8' => '',
                            'lock' => $lock,
                            'ordem_servico' => $linha['ordem_servico'],
                            'id_processo' => $contagemProcesso['id_processo'],
                            'data_fim' => $contagemProcesso['data_fim'],
                            'validador_interno' => $linha['validador_interno'],
                            'validador_externo' => $linha['validador_externo']
                        );
                    } else if (isFornecedor() && getConfigContagem('is_visualizar_contagem_fornecedor') || ($isFiscalContratoEmpresa && $isFiscalVisualizarTodasContagens)) {
                        $re1[] = array(
                            'col1' => '<div style="text-align: center;"><a href="mailto:' . $linha['responsavel'] . '"><img src="' . getGravatarImageUser(sha1($linha['user_id'])) . '" class="img-circle" width="56" height="56"></a></div>',
                            'col2' => $id,
                            'col3' => ($linha['id_fornecedor']) ? $fa->getSiglaFornecedor($linha['id_fornecedor']) : '',
                            'col4' => '<div class="' . ($contagemProcesso['id_processo'] == 7 && $dataFim && !$linha['is_faturada'] ? 'fauF' : 'efa') . '">' .
                            // . $descricaoProcesso
                            (($contagemProcesso['id_processo'] == 7 && !$dataFim && ($isFiscalContratoEmpresa || ($isContagemFornecedor && $linha['id_fornecedor'] == $idFornecedor && $isFiscalContratoFornecedor))) ? '<center><a class="label-round label-link btn-faturar" onclick="finalizarFaturamentoFiscal(' . $linha['id'] . ');"><i class="fa fa-check-circle"></i>&nbsp;Autorizar faturamento</a>' : $descricaoProcesso) . (($validadorInterno || $validadorExterno) ? '<br /><a href="mailto:' . $validador . '">' . $validador . '</a>' : '') . '</center></div>',
                            'col5' => $qtd,
                            'col6' => $abrangencia === 'baseline' ? $linha['cliente'] : $linha['cliente'] . '<br />' . $linha['contrato'] . ' - ' . $linha['ordem_servico'],
                            'col7' => $linha['projeto'] . ($linha['descricao'] === 'Projeto' ? '<br />Baseline: ' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : ($linha['id_abrangencia'] == 3 ? '<br />' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : '')),
                            'col8' => '',
                            'lock' => $lock,
                            'ordem_servico' => $linha['ordem_servico'],
                            'id_processo' => $contagemProcesso['id_processo'],
                            'data_fim' => $contagemProcesso['data_fim'],
                            'validador_interno' => $linha['validador_interno'],
                            'validador_externo' => $linha['validador_externo']
                        );
                    }
                } else {
                    // TODO: verificar todas as possibilidades de listagem das contagens por conta destes parametros finais
                    if ($isFiscalContrato) {
                        if (getConfigContagem('is_visualizar_todas_fiscal_contrato')) {
                            $re1[] = array(
                                'col1' => '<div style="text-align: center;"><a href="mailto:' . $linha['responsavel'] . '"><img src="' . getGravatarImageUser(sha1($linha['user_id'])) . '" class="img-circle" width="56" height="56"></a></div>',
                                'col2' => $id,
                                'col3' => ($linha['id_fornecedor']) ? $fa->getSiglaFornecedor($linha['id_fornecedor']) : '',
                                'col4' => '<div class="' . ($contagemProcesso['id_processo'] == 7 && $dataFim && !$linha['is_faturada'] ? 'fauE' : 'efa') . '">' .
                                // . $descricaoProcesso
                                (($contagemProcesso['id_processo'] == 7 && !$dataFim && $isFiscalContrato) ? '<center><a class="label-round label-link btn-faturar" onclick="finalizarFaturamentoFiscal(' . $linha['id'] . ');"><i class="fa fa-check-circle"></i>&nbsp;Autorizar faturamento</a>' : $descricaoProcesso) . (($validadorInterno || $validadorExterno) ? '<br /><a href="mailto:' . $validador . '">' . $validador . '</a>' : '') . '</center></div>',
                                'col5' => $qtd,
                                'col6' => $abrangencia === 'baseline' ? $linha['cliente'] : $linha['cliente'] . '<br />' . $linha['contrato'] . ' - ' . $linha['ordem_servico'],
                                'col7' => $linha['projeto'] . ($linha['descricao'] === 'Projeto' ? '<br />Baseline: ' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : ($linha['id_abrangencia'] == 3 ? '<br />' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : '')),
                                'col8' => '',
                                'lock' => $lock . '(3)',
                                'ordem_servico' => $linha['ordem_servico'],
                                'id_processo' => $contagemProcesso['id_processo'],
                                'data_fim' => $contagemProcesso['data_fim'],
                                'validador_interno' => $linha['validador_interno'],
                                'validador_externo' => $linha['validador_externo']
                            );
                        } else {
                            /*
                             * caso o fiscal do contrato nao veja todas as contagens, precisa ver as que estao marcadas para faturamento
                             */
                            if ($contagemProcesso['id_processo'] == 7) {
                                $re1[] = array(
                                    'col1' => '<div style="text-align: center;"><a href="mailto:' . $linha['responsavel'] . '"><img src="' . getGravatarImageUser(sha1($linha['user_id'])) . '" class="img-circle" width="56" height="56"></a></div>',
                                    'col2' => $id,
                                    'col3' => ($linha['id_fornecedor']) ? $fa->getSiglaFornecedor($linha['id_fornecedor']) : '',
                                    'col4' => '<div class="' . ($contagemProcesso['id_processo'] == 7 && $dataFim && !$linha['is_faturada'] ? 'fauE' : 'efa') . '">' .
                                    // . $descricaoProcesso
                                    (($contagemProcesso['id_processo'] == 7 && !$dataFim && $isFiscalContrato) ? '<center><a class="label-round label-link btn-faturar" onclick="finalizarFaturamentoFiscal(' . $linha['id'] . ');"><i class="fa fa-check-circle"></i>&nbsp;Autorizar faturamento</a>' : $descricaoProcesso) . (($validadorInterno || $validadorExterno) ? '<br /><a href="mailto:' . $validador . '">' . $validador . '</a>' : '') . '</center></div>',
                                    'col5' => $qtd,
                                    'col6' => $abrangencia === 'baseline' ? $linha['cliente'] : $linha['cliente'] . '<br />' . $linha['contrato'] . ' - ' . $linha['ordem_servico'],
                                    'col7' => $linha['projeto'] . ($linha['descricao'] === 'Projeto' ? '<br />Baseline: ' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : ($linha['id_abrangencia'] == 3 ? '<br />' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : '')),
                                    'col8' => '',
                                    'lock' => $lock . '(3)',
                                    'ordem_servico' => $linha['ordem_servico'],
                                    'id_processo' => $contagemProcesso['id_processo'],
                                    'data_fim' => $contagemProcesso['data_fim'],
                                    'validador_interno' => $linha['validador_interno'],
                                    'validador_externo' => $linha['validador_externo']
                                );
                            }
                        }
                    } else {
                        $re1[] = array(
                            'col1' => '<div style="text-align: center;"><a href="mailto:' . $linha['responsavel'] . '"><img src="' . getGravatarImageUser(sha1($linha['user_id'])) . '" class="img-circle" width="56" height="56"></a></div>',
                            'col2' => $id,
                            'col3' => ($linha['id_fornecedor']) ? $fa->getSiglaFornecedor($linha['id_fornecedor']) : '',
                            'col4' => '<div class="' . ($contagemProcesso['id_processo'] == 7 && $dataFim && !$linha['is_faturada'] ? 'fauE' : 'efa') . '">' .
                            // . $descricaoProcesso
                            (($contagemProcesso['id_processo'] == 7 && !$dataFim && $isFiscalContratoEmpresa) ? '<center><a class="label-round label-link btn-faturar" onclick="finalizarFaturamentoFiscal(' . $linha['id'] . ');"><i class="fa fa-check-circle"></i>&nbsp;Autorizar faturamento</a>' : $descricaoProcesso) . (($validadorInterno || $validadorExterno) ? '<br /><a href="mailto:' . $validador . '">' . $validador . '</a>' : '') . '</center></div>',
                            'col5' => $qtd,
                            'col6' => $abrangencia === 'baseline' ? $linha['cliente'] : $linha['cliente'] . '<br />' . $linha['contrato'] . ' - ' . $linha['ordem_servico'],
                            'col7' => $linha['projeto'] . ($linha['descricao'] === 'Projeto' ? '<br />Baseline: ' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : ($linha['id_abrangencia'] == 3 ? '<br />' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : '')),
                            'col8' => '',
                            'lock' => $lock . '(3)',
                            'ordem_servico' => $linha['ordem_servico'],
                            'id_processo' => $contagemProcesso['id_processo'],
                            'data_fim' => $contagemProcesso['data_fim'],
                            'validador_interno' => $linha['validador_interno'],
                            'validador_externo' => $linha['validador_externo']
                        );
                    }
                }
                // nao eh o responsavel mas a contagem e publica e nao esta por atribuicao
                // auditor interno/externo e validador interno/externo
            } elseif (($isAuditorInterno || $isAuditorExterno || $isValidadorExterno || $isValidadorInterno) && $contagemProcesso['id_processo'] != 7) {
                $re1[] = array(
                    'col1' => '<div style="text-align: center;"><a href="mailto:' . $linha['responsavel'] . '"><img src="' . getGravatarImageUser(sha1($linha['user_id'])) . '" class="img-circle" width="56" height="56"></a></div>',
                    'col2' => $id,
                    'col3' => ($linha['id_fornecedor']) ? $fa->getSiglaFornecedor($linha['id_fornecedor']) : '',
                    'col4' => '<div class="' . ($contagemProcesso['id_processo'] == 7 && $dataFim && !$linha['is_faturada'] ? 'fau' : 'efa') . '">' . $descricaoProcesso . (($validadorInterno || $validadorExterno) ? '<br /><a href="mailto:' . $validador . '">' . $validador . '</a>' : '') . '</center></div>',
                    'col5' => $qtd,
                    'col6' => $abrangencia === 'baseline' ? $linha['cliente'] : $linha['cliente'] . '<br />' . $linha['contrato'] . ' - ' . $linha['ordem_servico'],
                    'col7' => $linha['projeto'] . ($linha['descricao'] === 'Projeto' ? '<br />Baseline: ' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : ($linha['id_abrangencia'] == 3 ? '<br />' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : '')),
                    'col8' => '',
                    'lock' => $lock . '(4) ' . 'ai' . $isAuditorInterno . 'ae' . $isAuditorExterno . 've' . $isValidadorExterno . 'vi' . $isValidadorInterno . 'au' . $isAutorizado,
                    'ordem_servico' => $linha['ordem_servico'],
                    'id_processo' => $contagemProcesso['id_processo'],
                    'data_fim' => $contagemProcesso['data_fim'],
                    'validador_interno' => $linha['validador_interno'],
                    'validador_externo' => $linha['validador_externo']
                );
                // exibe as contagens para os analistas de metricas
                // apenas contagens publicas
                // oculta contagens de faturamento para os analistas de metricas?
                // TODO: criar configuracao para isso?
                // && $contagemProcesso['id_processo'] != 7
            } elseif (($isPerfilAnalistaMetricas || $isPerfilAnalistaMetricasFornecedor) && !((int) $linha['privacidade'])) {
                if (!$isTipoFornecedorTurma) {
                    $re1[] = array(
                        'col1' => '<div style="text-align: center;"><a href="mailto:' . $linha['responsavel'] . '"><img src="' . getGravatarImageUser(sha1($linha['user_id'])) . '" class="img-circle" width="56" height="56"></a></div>',
                        'col2' => $id,
                        'col3' => ($linha['id_fornecedor']) ? $fa->getSiglaFornecedor($linha['id_fornecedor']) : '',
                        'col4' => '<div class="' . ($contagemProcesso['id_processo'] == 7 && $dataFim && !$linha['is_faturada'] ? 'fau' : 'efa') . '">' . $descricaoProcesso . (($validadorInterno || $validadorExterno) ? '<br /><a href="mailto:' . $validador . '">' . $validador . '</a>' : '') . '</center></div>',
                        'col5' => $qtd,
                        'col6' => $abrangencia === 'baseline' ? $linha['cliente'] : $linha['cliente'] . '<br />' . $linha['contrato'] . ' - ' . $linha['ordem_servico'],
                        'col7' => $linha['projeto'] . ($linha['descricao'] === 'Projeto' ? '<br />Baseline: ' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : ($linha['id_abrangencia'] == 3 ? '<br />' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : '')),
                        'col8' => '',
                        'lock' => $lock . '(5)',
                        'ordem_servico' => $linha['ordem_servico'],
                        'id_processo' => $contagemProcesso['id_processo'],
                        'data_fim' => $contagemProcesso['data_fim'],
                        'validador_interno' => $linha['validador_interno'],
                        'validador_externo' => $linha['validador_externo']
                    );
                    /*
                     * para listar contagens de turmas
                     * 0 - Fornecedor
                     * 1 - Turma
                     */
                } else if (isFornecedor() && $isTipoFornecedorTurma && $linha['id_fornecedor'] === getIdFornecedor()) {
                    $re1[] = array(
                        'col1' => '<div style="text-align: center;"><a href="mailto:' . $linha['responsavel'] . '"><img src="' . getGravatarImageUser(sha1($linha['user_id'])) . '" class="img-circle" width="56" height="56"></a></div>',
                        'col2' => $id,
                        'col3' => ($linha['id_fornecedor']) ? $fa->getSiglaFornecedor($linha['id_fornecedor']) : '',
                        'col4' => '<div class="' . ($contagemProcesso['id_processo'] == 7 && $dataFim && !$linha['is_faturada'] ? 'fau' : 'efa') . '">' . $descricaoProcesso . (($validadorInterno || $validadorExterno) ? '<br /><a href="mailto:' . $validador . '">' . $validador . '</a>' : '') . '</center></div>',
                        'col5' => $qtd,
                        'col6' => $abrangencia === 'baseline' ? $linha['cliente'] : $linha['cliente'] . '<br />' . $linha['contrato'] . ' - ' . $linha['ordem_servico'],
                        'col7' => $linha['projeto'] . ($linha['descricao'] === 'Projeto' ? '<br />Baseline: ' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : ($linha['id_abrangencia'] == 3 ? '<br />' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : '')),
                        'col8' => '',
                        'lock' => $lock . '(6)',
                        'ordem_servico' => $linha['ordem_servico'],
                        'id_processo' => $contagemProcesso['id_processo'],
                        'data_fim' => $contagemProcesso['data_fim'],
                        'validador_interno' => $linha['validador_interno'],
                        'validador_externo' => $linha['validador_externo']
                    );
                }
                // caso o usuario esteja autorizado ve a contagem normalmente, independente de ser publica ou privada
            } elseif ($isAutorizado) {
                $re1[] = array(
                    'col1' => '<div style="text-align: center;"><a href="mailto:' . $linha['responsavel'] . '"><img src="' . getGravatarImageUser(sha1($linha['user_id'])) . '" class="img-circle" width="56" height="56"></a></div>',
                    'col2' => $id,
                    'col3' => ($linha['id_fornecedor']) ? $fa->getSiglaFornecedor($linha['id_fornecedor']) : '',
                    'col4' => '<div class="' . ($contagemProcesso['id_processo'] == 7 && $dataFim && !$linha['is_faturada'] ? 'fau' : 'efa') . '">' . $descricaoProcesso . (($validadorInterno || $validadorExterno) ? '<br /><a href="mailto:' . $validador . '">' . $validador . '</a>' : '') . '</center></div>',
                    'col5' => $qtd,
                    'col6' => $abrangencia === 'baseline' ? $linha['cliente'] : $linha['cliente'] . '<br />' . $linha['contrato'] . ' - ' . $linha['ordem_servico'],
                    'col7' => $linha['projeto'] . ($linha['descricao'] === 'Projeto' ? '<br />Baseline: ' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : ($linha['id_abrangencia'] == 3 ? '<br />' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : '')),
                    'col8' => '',
                    'lock' => $lock,
                    'ordem_servico' => $linha['ordem_servico'],
                    'id_processo' => $contagemProcesso['id_processo'],
                    'data_fim' => $contagemProcesso['data_fim'],
                    'validador_interno' => $linha['validador_interno'],
                    'validador_externo' => $linha['validador_externo']
                );
                // aqui os fornecedores terão acesso as suas contagens
                // verificar quando o fiscal estiver logado no fornecedor
            } elseif (isFornecedor() && $linha['id_fornecedor'] == getIdFornecedor() && !$isFiscalContratoFornecedor) {
                $re1[] = array(
                    'col1' => '<div style="text-align: center;"><a href="mailto:' . $linha['responsavel'] . '"><img src="' . getGravatarImageUser(sha1($linha['user_id'])) . '" class="img-circle" width="56" height="56"></a></div>',
                    'col2' => $id,
                    'col3' => ($linha['id_fornecedor']) ? $fa->getSiglaFornecedor($linha['id_fornecedor']) : '',
                    'col4' => '<div class="' . ($contagemProcesso['id_processo'] == 7 && $dataFim && !$linha['is_faturada'] ? 'fauF' : 'efa') . '">' . $descricaoProcesso . (($validadorInterno || $validadorExterno) ? '<br /><a href="mailto:' . $validador . '">' . $validador . '</a>' : '') . '</center></div>',
                    'col5' => $qtd,
                    'col6' => $abrangencia === 'baseline' ? $linha['cliente'] : $linha['cliente'] . '<br />' . $linha['contrato'] . ' - ' . $linha['ordem_servico'],
                    'col7' => $linha['projeto'] . ($linha['descricao'] === 'Projeto' ? '<br />Baseline: ' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : ($linha['id_abrangencia'] == 3 ? '<br />' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : '')),
                    'col8' => '',
                    'lock' => $lock,
                    'ordem_servico' => $linha['ordem_servico'],
                    'id_processo' => $contagemProcesso['id_processo'],
                    'data_fim' => $contagemProcesso['data_fim'],
                    'validador_interno' => $linha['validador_interno'],
                    'validador_externo' => $linha['validador_externo']
                );
                // fiscalizacao do contrato para contagens em faturamento no caso de fornecedores e o fiscal
                // ser de um fornecedor
            } elseif (isFornecedor() && $linha['id_fornecedor'] == getIdFornecedor() && $isFiscalContratoFornecedor && getConfigContagem('is_visualizar_todas_fiscal_contrato')) {
                $re1[] = array(
                    'lock' => $lock,
                    'col1' => '<div style="text-align: center;"><a href="mailto:' . $linha['responsavel'] . '"><img src="' . getGravatarImageUser(sha1($linha['user_id'])) . '" class="img-circle" width="56" height="56"></a></div>',
                    'col2' => $id,
                    'col3' => ($linha['id_fornecedor']) ? $fa->getSiglaFornecedor($linha['id_fornecedor']) : '',
                    'col4' => '<div class="' . ($contagemProcesso['id_processo'] == 7 && $dataFim && !$linha['is_faturada'] ? 'fauF' : 'efa') . '">' . ($contagemProcesso['id_processo'] == 7 && $isFiscalContrato ? '<center><a class="label-round label-link btn-faturar" onclick="finalizarFaturamentoFiscal(' . $linha['id'] . ');"><i class="fa fa-check-circle"></i>&nbsp;Autorizar faturamento</a>' : $descricaoProcesso) . (($validadorInterno || $validadorExterno) ? '<br /><a href="mailto:' . $validador . '">' . $validador . '</a>' : '') . '</center></div>',
                    'col6' => $qtd,
                    'col6' => $abrangencia === 'baseline' ? $linha['cliente'] : $linha['cliente'] . '<br />' . $linha['contrato'] . ' - ' . $linha['ordem_servico'],
                    'col7' => $linha['projeto'] . ($linha['descricao'] === 'Projeto' ? '<br />Baseline: ' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : ($linha['id_abrangencia'] == 3 ? '<br />' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : '')),
                    'col8' => '',
                    'ordem_servico' => $linha['ordem_servico'],
                    'id_processo' => $contagemProcesso['id_processo'],
                    'data_fim' => $contagemProcesso['data_fim'],
                    'validador_interno' => $linha['validador_interno'],
                    'validador_externo' => $linha['validador_externo']
                );
                // fiscalizacao do contrato para contagens em faturamento
            } elseif (($isFiscalContrato || $isFinanceiro || $isGestor || $isGerenteConta || $isGerenteProjeto) && $contagemProcesso['id_processo'] == 7) {
                if ($linha['id_cliente'] == $idClienteFiscalContrato || ($linha['id_fornecedor'] && $linha['id_cliente'] == $idClienteFiscalContrato) || ($isGestor || $isGerenteConta || $isGerenteProjeto)) {
                    $re1[] = array(
                        'col1' => '<div style="text-align: center;"><a href="mailto:' . $linha['responsavel'] . '"><img src="' . getGravatarImageUser(sha1($linha['user_id'])) . '" class="img-circle" width="56" height="56"></a></div>',
                        'col2' => $id,
                        'col3' => ($linha['id_fornecedor']) ? $fa->getSiglaFornecedor($linha['id_fornecedor']) : '',
                        'col4' => '<div class="' . ($contagemProcesso['id_processo'] == 7 && $dataFim && !$linha['is_faturada'] ? ($isContagemFornecedor ? 'fauF' : 'fauE') : 'efa') . '">' .
                        // . $descricaoProcesso
                        ($contagemProcesso['id_processo'] == 7 && $isFiscalContrato && !$dataFim ? '<center><a class="label-round label-link btn-faturar" onclick="finalizarFaturamentoFiscal(' . $linha['id'] . ');"><i class="fa fa-check-circle"></i>&nbsp;Autorizar faturamento</a>' : $descricaoProcesso) . (($validadorInterno || $validadorExterno) ? '<br /><a href="mailto:' . $validador . '">' . $validador . '</a>' : '') . '</center></div>',
                        'col5' => $qtd,
                        'col6' => $abrangencia === 'baseline' ? $linha['cliente'] : $linha['cliente'] . '<br />' . $linha['contrato'] . ' - ' . $linha['ordem_servico'],
                        'col7' => $linha['projeto'] . ($linha['descricao'] === 'Projeto' ? '<br />Baseline: ' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : ($linha['id_abrangencia'] == 3 ? '<br />' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : '')),
                        'col8' => '',
                        'lock' => $lock,
                        'ordem_servico' => $linha['ordem_servico'],
                        'id_processo' => $contagemProcesso['id_processo'],
                        'data_fim' => $contagemProcesso['data_fim'],
                        'validador_interno' => $linha['validador_interno'],
                        'validador_externo' => $linha['validador_externo']
                    );
                }
                // fiscalizacao do contrato com autorizacao para ver todas as contagens
            } elseif (($isFiscalContrato || $isFinanceiro) && $contagemProcesso['id_processo'] != 7 && (getConfigContagem('is_visualizar_todas_fiscal_contrato') || $isGestor || $isGerenteConta || $isGerenteProjeto)) {
                if ($linha['id_cliente'] == $idClienteFiscalContrato || ($linha['id_fornecedor'] && $linha['id_cliente'] == $idClienteFiscalContrato)) {
                    $re1[] = array(
                        'col1' => '<div style="text-align: center;"><a href="mailto:' . $linha['responsavel'] . '"><img src="' . getGravatarImageUser(sha1($linha['user_id'])) . '" class="img-circle" width="56" height="56"></a></div>',
                        'col2' => $id,
                        'col3' => ($linha['id_fornecedor']) ? $fa->getSiglaFornecedor($linha['id_fornecedor']) : '',
                        'col4' => '<div class="' . ($contagemProcesso['id_processo'] == 7 && $dataFim && !$linha['is_faturada'] ? ($isContagemFornecedor ? 'fauF' : 'fauE') : 'efa') . '">' .
                        // . $descricaoProcesso
                        ($contagemProcesso['id_processo'] == 7 && $isFiscalContrato && !$dataFim ? '<center><a class="label-round label-link btn-faturar" onclick="finalizarFaturamentoFiscal(' . $linha['id'] . ')"><i class="fa fa-check-circle"></i>&nbsp;Autorizar faturamento</a>' : $descricaoProcesso) . (($validadorInterno || $validadorExterno) ? '<br /><a href="mailto:' . $validador . '">' . $validador . '</a>' : '') . '</center></div>',
                        'col5' => $qtd,
                        'col6' => $abrangencia === 'baseline' ? $linha['cliente'] : $linha['cliente'] . '<br />' . $linha['contrato'] . ' - ' . $linha['ordem_servico'],
                        'col7' => $linha['projeto'] . ($linha['descricao'] === 'Projeto' ? '<br />Baseline: ' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : ($linha['id_abrangencia'] == 3 ? '<br />' . $siglaBaseline['sigla'] . ' - ' . $siglaBaseline['descricao'] : '')),
                        'col8' => '',
                        'lock' => $lock,
                        'ordem_servico' => $linha['ordem_servico'],
                        'id_processo' => $contagemProcesso['id_processo'],
                        'data_fim' => $contagemProcesso['data_fim'],
                        'validador_interno' => $linha['validador_interno'],
                        'validador_externo' => $linha['validador_externo']
                    );
                }
            }
        }
    } else {
        $re1[] = array(
            'lock' => '',
            'col1' => '',
            'col2' => '',
            'col3' => '',
            'col4' => '',
            'col5' => '',
            'col6' => '',
            'col7' => '',
            'col8' => '',
            'ordem_servico' => '',
            'id_processo' => '',
            'data_fim' => '',
            'validador_interno' => '',
            'validador_externo' => ''
        );
    }
    $res['data'] = $re1;
    echo json_encode($res);
} else {
    echo json_encode(array(
        'msg' => 'Acesso n&atilde;o autorizado!'
    ));
}