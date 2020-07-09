<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verifica se ja um login
 */
if (!$login->isUserLoggedIn()) {
    echo json_encode(array('msg' => '[LOGIN].Acesso n&atilde;o autorizado!'));
    die();
}
/*
 * este primeiro teste ja filtra se pode ou nao acessar as funcionalidades
 */
$isPermitido = isPermitido('finalizar_contagem');
if (!$isPermitido) {
    echo json_encode(array('msg' => '[PERMISSAO-PLANO].Acesso n&atilde;o autorizado!'));
    die();
}
/*
 * captura do post
 */
$idContagem = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);
/*
 * instancia a classe cliente para pegar o email da caixa postal do fiscal de contrato
 */
$cliente = new Cliente();
$user = new Usuario();
$fn = new Contagem();
$ue = new UsersEmpresa();
$cct = new ContagemConfigTarefas();
/*
 * variaveis essenciais agora
 */
$idEmpresa = getIdEmpresa();
$idFornecedor = getIdFornecedor();
$idCliente = $fn->getIdCliente($idContagem)['id_cliente'];
$tarefas = $cct->getConfigTarefas($idEmpresa, $idFornecedor, $idCliente);
/*
 * seta o id do perfil, obrigatorio
 */
$roleId = getVariavelSessao('role_id');
$user->setRoleId($roleId);
/*
 * coleta os emails
 */
$userEmailExecutorConsulta = $cliente->getEmailFiscalContrato($idContagem)['email2'];
$userEmailExecutor = $userEmailExecutorConsulta ? $userEmailExecutorConsulta : 'email.fiscal.contrato@nao.cadastrado';
/*
 * verificacao geral de acesso
 */
$userEmailSolicitante = getEmailUsuarioLogado();
$userIdSolicitante = getUserIdDecoded();
$userId = $userIdSolicitante;
//neste caso nao tem um executor especifico
$userIdExecutor = 0; //$ue->getUserId($userEmailExecutor, getIdEmpresa());
/*
 * associados a um perfil
 */
$isGestor = $user->isGestor($userIdSolicitante);
$isGerenteConta = $user->isGerenteConta($userIdSolicitante);
$isFinanceiro = $user->isFinanceiro($userIdSolicitante);
$isFiscalContrato = $user->isFiscalContrato($userIdSolicitante);
/*
 * verifica se eh um fornecedor
 */
$isFornecedor = isFornecedor();
$tipoFornecedor = 0;
$isGestorFornecedor = 0;
$isGerenteContaFornecedor = 0;
$isGerenteProjetoFornecedor = 0;
$idFornecedor = 0; //default
/*
 * verifica o tipo de fornecedor e envia apenas para o tipo = 0
 */
if ($isFornecedor) {
    $fornecedor = new Fornecedor();
    $idFornecedor = getIdFornecedor(); //retorna da sessao
    $tipoFornecedor = $fornecedor->getTipo($idFornecedor);
    if (!($tipoFornecedor)) {//0 = fornecedor / 1 - turma
        /*
         * ser for um gestor de um fornecedor, gerente de conta, gestor e gerente de projeto tambem envia para faturamento
         */
        $isGestorFornecedor = $user->isGestorFornecedor($userId, $idFornecedor);
        $isGerenteContaFornecedor = $user->isGerenteContaFornecedor($userId, $idFornecedor);
        $isGerenteProjetoFornecedor = $user->isGerenteProjetoFornecedor($userId, $idFornecedor);
    }
}
/*
 * verifica se a contagem pode estar em faturamento
 */
$idProcesso = $fn->getContagemProcesso($idContagem, '7');
/*
 * retorna
 */
if ($idProcesso == 7) {
    echo json_encode(array('msg' => '[PROCESSO].A contagem j&aacute; est&aacute; em processo de faturamento!'));
    die();
}
/*
 * verifica e passa
 */
if (($isGestor || $isGerenteConta || $isFinanceiro || $isFiscalContrato || ($isFornecedor && $isGestorFornecedor) || ($isFornecedor && $isGerenteProjetoFornecedor) || ($isFornecedor && $isGerenteContaFornecedor)) && verificaSessao()) {
    /*
     * variaveis gerais
     */
    $concedidoEm = date('Y-m-d H:i:s');
    /*
     * instancia das classes
     */
    $ch = new ContagemHistorico();
    $tr = new Tarefa();
    $ca = new ContagemAcesso();
    /*
     * tabela de concessao de autorizacoes
     */
    $ca->setIdContagem($idContagem);
    $ca->setUserEmail($userEmailExecutor);
    $ca->setConcedidoEm($concedidoEm);
    $ca->setConcedidoPor($userEmailSolicitante);
    /*
     * insere o executor na tabela de autorizacao
     */
    $ca->insere();
    /*
     * neste ponto caso a selecao na configuracao seja para atualizar as baselines
     * na classe Contagem - atualiza por aqui porque eh o mais logico, na contagem
     * executar apenas em projetos (Abrangencia = 2)
     */
    $contagemConfig = new ContagemConfig();
    $configuracoes = $contagemConfig->getEtapaAtualizarBaseline($idContagem);
    $abrangencia = $configuracoes['abrangencia'];
    $etapaAtualizarBaseline = $configuracoes['etapa_atualizar_baseline'];
    //DEBUG_MODE
    DEBUG_MODE ? error_log ( 'Abrangencia: ' . $abrangencia ) : NULL;
    DEBUG_MODE ? error_log ( 'Processo: ' . $etapaAtualizarBaseline ) : NULL;
    /*
     * verifica os processos e atualiza a baseline
     */
    ($abrangencia == 2 && $etapaAtualizarBaseline == 7) ? $fn->atualizarBaseline ( $idContagem ) : NULL;
    /*     
     * * ******************************
     * 
     * 1 - Em elaboracao
     * 2 - Em validacao interna
     * 3 - Em validacao externa
     * 4 - Em auditoria interna
     * 5 - Em auditoria externa
     * 6 - Em revisao
     * 7 - Faturada
     * 8 - Em revisao (validacao interna)
     * 9 - Em revisao (validacao externa)
     * 10- Validacao interna automatica
     * 
     * *******************************
     */
    //variaveis para a tarefa de validacao externa
    
    $prazoValidacao = '+' . $tarefas['faturamento'] . ' days';
    $dataFim = date('Y-m-d H:i:s', strtotime($prazoValidacao));
    $tr->setIdContagem($idContagem);
    $tr->setIdTipo(24); //faturamento
    $tr->setIdEmpresa(getIdEmpresa());
    $tr->setIdFornecedor(getIdFornecedor());
    $tr->setDescricao('FATURAMENTO da contagem #ID: ' . str_pad($idContagem, 7, '0', STR_PAD_LEFT));
    $tr->setUserIdSolicitante($userIdSolicitante);
    $tr->setUserEmailSolicitante($userEmailSolicitante);
    $tr->setUserIdExecutor($userIdExecutor);
    $tr->setUserEmailExecutor($userEmailExecutor);
    $tr->setDataInicio(date('Y-m-d H:i:s'));
    $tr->setDataFim($dataFim);
    $tr->setDataConclusao(NULL);
    $tr->setConcluidoPor(NULL);
    $idTarefa = $tr->insere();
    //a contagem apenas cria uma tarefa de faturamento
    //$fn->atualizaProcessoFaturamento($idContagem);
    //cria um novo processo dentro da trilha da contagem
    $ch->setIdProcesso(7); //no historico da contagem - faturamento
    $ch->setIdContagem($idContagem);
    $ch->setDataInicio(date('Y-m-d H:i:s'));
    $ch->setDataFim(NULL);
    $ch->setAtualizadoPor($_SESSION['user_email']);
    $ch->setIdTarefa($idTarefa);
    $ch->insere();
    //envia email informando sobre o faturamento apenas em ambiente de producao
    if (PRODUCAO) {
        //abrangencia, idContagem, $userEmailExecutor (fiscal ou grupo)
        emailSolicitarFaturamento($idContagem, $userEmailExecutor, $objEmail);
    }
    //retorna para o script chamador
    echo json_encode(array('idTarefa' => $idTarefa, 'msg' => 'A contagem foi enviada para faturamento.'));
} else {
    //retorna com a mensagem de login
    echo json_encode(array('idTarefa' => 0, 'msg' => '[PERFIL].Acesso n&atilde;o autorizado!'));
}