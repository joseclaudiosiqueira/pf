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
 * instancia das classes
 */
/*
 * verificacao geral de acesso
 */
$user = new Usuario ();
$fn = new Contagem ();
$ue = new UsersEmpresa ();
$cct = new ContagemConfigTarefas ();
/*
 * captura do post
 */
$idContagem = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);
$userEmailExecutor = filter_input(INPUT_POST, 'e', FILTER_SANITIZE_EMAIL);
$acao = filter_input(INPUT_POST, 'a', FILTER_SANITIZE_STRING); // variavel que indica qual botao foi clicado (inserir ou alterar)
/*
 * variaveis essenciais agora
 */
$idEmpresa = getIdEmpresa();
$idFornecedor = getIdFornecedor();
$idCliente = $fn->getIdCliente($idContagem) ['id_cliente'];
$tarefas = $cct->getConfigTarefas($idEmpresa, $idFornecedor, $idCliente);
/*
 * verificacao geral de acesso
 */
$userEmailSolicitante = getEmailUsuarioLogado();
$userIdSolicitante = getUserIdDecoded();
$userIdExecutor = $ue->getUserId($userEmailExecutor, getIdEmpresa());
/*
 * seta o id do perfil, obrigatorio
 */
$roleId = getVariavelSessao('role_id');
$user->setRoleId($roleId);
/*
 * associados a um perfil
 */
$isGestor = $user->isGestor($userIdSolicitante);
$isGestorFornecedor = 0;
$isFornecedor = isFornecedor();
$tipoFornecedor = getTipoFornecedor();
/*
 * verifica coisas do fornecedor
 */
if ($isFornecedor && !$tipoFornecedor) {
    $isGestorFornecedor = $user->isGestorFornecedor($userId, $idFornecedor);
    $isGerenteProjetoFornecedor = $user->isGerenteProjetoFornecedor($userId, $idFornecedor);
}
/*
 * associados a contagem
 */
$isResponsavel = $fn->isResponsavel($userEmailSolicitante, $idContagem);
$isGerenteProjeto = $fn->isGerenteProjeto($userEmailSolicitante, $idContagem);
/*
 * verifica e passa
 */
if (($isGestor || $isResponsavel || $isGerenteProjeto || (($isFornecedor && $isGestorFornecedor) || ($isFornecedor && $isGerenteProjetoFornecedor))) && verificaSessao()) {
    /*
     * variaveis gerais
     */
    $dataConclusao = date('Y-m-d H:i:s');
    /*
     * instancia as classes
     */
    $tr = new Tarefa();
    $ch = new ContagemHistorico();
    /*
     * verifica se a contagem ja esta em validacao
     */
    $processoAtual = $ch->getProcessoAtual($idContagem, 2);
    /*
     * faz as verificacoes de acordo com o processo atual
     */
    /*
     * instancia estas classes para verificar se existe uma tarefa anterior apenas validacao externa e acao = 'al'
     */
    if ($acao === 'al') {
        /*
         * para atualizar o processo anterior
         */
        $ch->setIsAtualizandoProcesso(true);
        /*
         * verificar se eh uma alteracao de executor e baixar a tarefa anterior
         * usuario logado no momento sera o concluinte das atividades
         */
        $concluidoPorAlteracao = getEmailUsuarioLogado();
        $finalizadoPorAlteracao = getEmailUsuarioLogado();
        $dataFimAlteracao = date('Y-m-d H:i:s');
        $dataConclusaoAlteracao = date('Y-m-d H:i:s');
        // atualiza o processo de validacao interna e o validador
        $fn->setValidadorInterno($concluidoPorAlteracao);
        $fn->atualizaProcessoValidacaoInterna($idContagem, false);
        // atualiza o historico da contagem
        $tarefa = $ch->getProcessoAtual($idContagem, 2);
        $idTarefa = $tarefa ['id_tarefa'];
        // id para finalizar o historico da contagem
        $idHistorico = $tarefa ['id'];
        // atualizar a tarefa de validacao da contagem
        $tr->setDataConclusao($dataConclusaoAlteracao);
        $tr->setConcluidoPor($concluidoPorAlteracao);
        $tr->conclui($idTarefa);
        // atualiza o processo de validacao externa da contagem
        $ch->setDataFim($dataFimAlteracao);
        $ch->setFinalizadoPor($finalizadoPorAlteracao);
        $ch->setId($idHistorico);
        $ch->finalizaProcesso(24);
    }
    /*
     * variavel de retorno
     */
    $msg = '';
    /*
     * pega a abrangencia para passar no link
     */
    $abrangencia = $fn->getAbrangencia($idContagem)['id_abrangencia'];
    /*
     * seta o validador interno
     */
    $fn->setValidadorInterno($userEmailExecutor);
    /*
     * variaveis para a tarefa de validacao interna
     */
    $prazoValidacao = '+' . $_SESSION['contagem_config_tarefas']['validacao_interna'] . ' days';
    $dataFim = date('Y-m-d H:i:s', strtotime($prazoValidacao));
    $tr->setIdContagem($idContagem);
    $tr->setIdTipo(1); //validacao interna
    $tr->setIdEmpresa(getIdEmpresa());
    $tr->setIdFornecedor(getIdFornecedor());
    $tr->setDescricao('VALIDACAO INTERNA na contagem #ID: ' . str_pad($idContagem, 7, '0', STR_PAD_LEFT));
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
     * a contagem apenas cria uma tarefa de validacao externa
     */
    $fn->atualizaProcessoValidacaoInterna($idContagem, false);
    /*     * *****************************
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
    $ch->setIdProcesso(2);
    $ch->setIdContagem($idContagem);
    $ch->setDataInicio(date('Y-m-d H:i:s'));
    $ch->setDataFim($dataFim);
    $ch->setAtualizadoPor(getEmailUsuarioLogado());
    $ch->setFinalizadoPor(NULL);
    $ch->setIdTarefa($idTarefa);
    $ch->setIsInserirFinalizado(false);
    $ch->insere();
    /*
     * baixa a tarefa de elaboracao da contagem
     */
    $tarefa = $ch->getProcessoAtual($idContagem, 1);
    $idBaixa = $tarefa['id_tarefa'];
    /*
     * atualizar a tarefa de elaboracao da contagem
     */
    $tr->setDataConclusao($dataConclusao);
    $tr->setConcluidoPor(getEmailUsuarioLogado());
    $tr->conclui($idBaixa);
    /*
     * baixa o historico da atividade de elaboracao da contagem
     */
    $ch->setIdContagem($idContagem);
    $ch->setDataFim(date('Y-m-d H:i:s'));
    $ch->setFinalizadoPor(getEmailUsuarioLogado());
    $ch->setIdProcesso(1);
    $ch->finalizaTarefaElaboracao();
    /*
     * envia email informando sobre a solicitacao de validacao apenas em ambiente de producao
     */
    if (PRODUCAO) {
        /*
         * abrangencia, idContagem, validadorExterno
         */
        emailSolicitarValidacaoInterna($abrangencia, $idContagem, $userEmailExecutor, $objEmail);
    }
    /*
     * retorna para o script chamador
     */
    echo json_encode(array('msg' => 'A contagem foi enviada para valida&ccedil;&atilde;o interna.'));
} else {
    /*
     * sem acesso!
     */
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}    