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
$isPermitido = isPermitido('enviar_auditoria_externa');
$isPermitidoPlano = getConfigPlano('auditoria_externa');
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
 * email do responsavel
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
$isGerenteConta = $user->isGerenteConta($userIdSolicitante);
/*
 * associados a contagem
 */
$isGerenteProjeto = $fn->isGerenteProjeto($userEmailSolicitante, $idContagem);
/*
 * verifica e passa
 */
if (($isGestor || $isGerenteProjeto || $isGerenteConta) && verificaSessao()) {
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
     * set a auditor externo
     */
    $fn->setAuditorExterno($userEmailExecutor);
    /*
     * variaveis para a tarefa de auditoria externa
     */
    $prazoValidacao = '+' . $tarefas['auditoria_externa'] . ' days';
    $dataFim = date('Y-m-d H:i:s', strtotime($prazoValidacao));
    $tr->setIdContagem($idContagem);
    $tr->setIdTipo(4); //auditoria externa (4)
    $tr->setIdEmpresa(getIdEmpresa());
    $tr->setIdFornecedor(getIdFornecedor());
    $tr->setDescricao('AUDITORIA EXTERNA na contagem #ID: ' . str_pad($idContagem, 7, '0', STR_PAD_LEFT));
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
     * a contagem apenas cria uma tarefa de auditoria externa, processo independente
     */
    $fn->atualizaProcessoAuditoriaExterna($idContagem);
    /*
     * cria um novo processo dentro da trilha da contagem
     */
    $ch->setIdProcesso(5);
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
        //abrangencia, idContagem, auditorExterno e o objeto email
        emailSolicitarAuditoriaExterna($abrangencia, $idContagem, $userEmailExecutor, $userEmailSolicitante, $objEmail);
    }
    /*
     * retorna para o script chamador
     */
    echo json_encode(array('msg' => 'A contagem foi enviada para auditoria externa.'));
    die();
} else {
    echo json_encode(array('msg' => '[PERFIL].Acesso n&atilde;o autorizado!'));
    die();
}