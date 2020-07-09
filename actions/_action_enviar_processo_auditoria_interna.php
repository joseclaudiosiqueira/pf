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
$isPermitido = isPermitido('enviar_auditoria_interna');
$isPermitidoPlano = getConfigPlano('auditoria_interna');
if (!$isPermitido || !$isPermitidoPlano) {
    echo json_encode(array('msg' => '[PERMISSAO-PLANO].Acesso n&atilde;o autorizado!'));
    die();
}
/*
 * captura do post
 */
$idContagem = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);
/*
 * instancia das classes
 */
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
 * email do resposavel
 */
$userEmailExecutor = filter_input(INPUT_POST, 'e', FILTER_SANITIZE_EMAIL);
$userIdExecutor = $ue->getUserId($userEmailExecutor, getIdEmpresa());
/*
 * verificacao geral de acesso
 */
$userEmailSolicitante = getEmailUsuarioLogado();
$userIdSolicitante = getUserIdDecoded();
/*
 * associados a um perfil
 */
$isGestor = $user->isGestor($userIdSolicitante);
/*
 * associados a contagem
 */
$isResponsavel = $fn->isResponsavel($userEmailSolicitante, $idContagem);
$isGerenteProjeto = $fn->isGerenteProjeto($userEmailSolicitante, $idContagem);
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
 * verifica e passa
 */
if (($isGestor || $isResponsavel || $isGerenteProjeto || ($isFornecedor && $isGestorFornecedor) || ($isFornecedor && $isGerenteProjetoFornecedor) || ($isFornecedor && $isGerenteContaFornecedor)) && verificaSessao()) {
    /*
     * variaveis automaticas
     */
    $concedidoEm = date('Y-m-d H:i:s');
    /*
     * instancia as classes
     */
    $ch = new ContagemHistorico();
    $tr = new Tarefa();
    $ca = new ContagemAcesso();
    $co = new Contagem();
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
     * variavel de retorno
     */
    $msg = '';
    /*
     * pega a abrangencia para passar no link
     */
    $abrangencia = $fn->getAbrangencia($idContagem)['id_abrangencia'];
    /*     * ******************************
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
    /*
     * set a auditor interno
     */
    $fn->setAuditorInterno($userEmailExecutor);
    /*
     * variaveis para a tarefa de auditoria interna
     */
    $prazoValidacao = '+' . $tarefas['auditoria_interna'] . ' days';
    $dataFim = date('Y-m-d H:i:s', strtotime($prazoValidacao));
    $tr->setIdContagem($idContagem);
    $tr->setIdTipo(3); //auditoria interna (3)
    $tr->setIdEmpresa(getIdEmpresa());
    $tr->setIdFornecedor(getIdFornecedor());
    $tr->setDescricao('AUDITORIA INTERNA na contagem #ID: ' . str_pad($idContagem, 7, '0', STR_PAD_LEFT));
    $tr->setUserIdSolicitante($userIdSolicitante);
    $tr->setUserEmailSolicitante($userEmailSolicitante);
    $tr->setUserIdExecutor($userIdExecutor);
    $tr->setUserEmailExecutor($userEmailExecutor);
    $tr->setDataInicio(date('Y-m-d H:i:s'));
    $tr->setDataFim($dataFim);
    $tr->setDataConclusao(NULL);
    $tr->setConcluidoPor(NULL);
    $idTarefa = $tr->insere();
    /*
     * a contagem apenas cria uma tarefa de auditoria interna, processo independente
     */
    $fn->atualizaProcessoAuditoriaInterna($idContagem);
    /*
     * cria um novo processo dentro da trilha da contagem
     */
    $ch->setIdProcesso(4);
    $ch->setIdContagem($idContagem);
    $ch->setDataInicio(date('Y-m-d H:i:s'));
    $ch->setDataFim(NULL);
    $ch->setAtualizadoPor($_SESSION['user_email']);
    $ch->setIdTarefa($idTarefa);
    $ch->insere();
    /*
     * envia email informando sobre a solicitacao de validacao
     * apenas em ambiente de producao
     */
    if (PRODUCAO) {
        //abrangencia, idContagem, auditorInterno e o objeto email
        emailSolicitarAuditoriaInterna($abrangencia, $idContagem, $userEmailExecutor, $objEmail);
    }
    /*
     * retorna para o script chamador
     */
    echo json_encode(array('msg' => 'A contagem foi enviada para auditoria interna.'));
} else {
    echo json_encode(array('msg' => '[PERFIL].Acesso n&atilde;o autorizado!'));
}