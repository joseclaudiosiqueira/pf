<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER ['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verifica se ja um login
 */
if (!$login->isUserLoggedIn()) {
    echo json_encode(array(
        'msg' => '[LOGIN].Acesso n&atilde;o autorizado!'
    ));
    die();
}
/*
 * este primeiro teste ja filtra se pode ou nao acessar as funcionalidades
 */
$isPermitido = isPermitido('enviar_validacao_externa');
$isPermitidoPlano = getConfigPlano('validacao_externa');
if (!$isPermitido || !$isPermitidoPlano) {
    echo json_encode(array(
        'msg' => '[PERMISSAO-PLANO].Acesso n&atilde;o autorizado!'
    ));
    die();
}
/*
 * captura do post
 */
$idContagem = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);
$userEmailExecutor = filter_input(INPUT_POST, 'e', FILTER_SANITIZE_EMAIL);
$acao = filter_input(INPUT_POST, 'a', FILTER_SANITIZE_STRING); // variavel que indica qual botao foi clicado (inserir ou alterar)
/*
 * verificacao geral de acesso
 */
$user = new Usuario ();
$fn = new Contagem ();
$ue = new UsersEmpresa ();
$cct = new ContagemConfigTarefas ();
/*
 * variaveis essenciais agora
 */
$idEmpresa = getIdEmpresa();
$idFornecedor = getIdFornecedor();
$idCliente = $fn->getIdCliente($idContagem) ['id_cliente'];
$tarefas = $cct->getConfigTarefas($idEmpresa, $idFornecedor, $idCliente);
/*
 * email do executor e do solicitante
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
$isGerenteConta = $user->isGerenteConta($userIdSolicitante);
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
if (($isGestor || $isGerenteConta || $isResponsavel || $isGerenteProjeto || (($isFornecedor && $isGestorFornecedor) || ($isFornecedor && $isGerenteProjetoFornecedor))) && verificaSessao()) {
    /*
     * instacia a classe tarefa e contagem historico antes
     */
    $tr = new Tarefa ();
    $ch = new ContagemHistorico ();
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
        // atualiza o processo de validacao externa e o validador
        $fn->setValidadorExterno($concluidoPorAlteracao);
        $fn->atualizaProcessoValidacaoExterna($idContagem, false);
        // atualiza o historico da contagem
        $tarefa = $ch->getProcessoAtual($idContagem, 3);
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
        $ch->finalizaProcesso(23);
    }
    /*
     * variaveis gerais
     */
    $concedidoEm = date('Y-m-d H:i:s');
    /*
     * instancia das classes
     * TODO: verificar isso pois na validacao externa requer um cliente
     */
    $ca = new ContagemAcesso ();
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
    $abrangencia = $fn->getAbrangencia($idContagem) ['id_abrangencia'];
    /*
     * ******************************
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
    // seta o validador externo
    $fn->setValidadorExterno($userEmailExecutor);
    // variaveis para a tarefa de validacao externa
    $prazoValidacao = '+' . $tarefas ['validacao_externa'] . ' days';
    $dataFim = date('Y-m-d H:i:s', strtotime($prazoValidacao));
    $tr->setIdContagem($idContagem);
    $tr->setIdTipo(2); // validacao externa
    $tr->setIdEmpresa(getIdEmpresa());
    $tr->setIdFornecedor(getIdFornecedor());
    $tr->setDescricao('VALIDACAO EXTERNA na contagem #ID: ' . str_pad($idContagem, 7, '0', STR_PAD_LEFT));
    $tr->setUserIdSolicitante($userIdSolicitante);
    $tr->setUserEmailSolicitante($userEmailSolicitante);
    $tr->setUserIdExecutor($userIdExecutor);
    $tr->setUserEmailExecutor($userEmailExecutor);
    $tr->setDataInicio(date('Y-m-d H:i:s'));
    $tr->setDataFim($dataFim);
    $tr->setDataConclusao(NULL);
    $tr->setConcluidoPor(NULL);
    $idTarefa = $tr->insere();
    // a contagem apenas cria uma tarefa de validacao externa
    $fn->atualizaProcessoValidacaoExterna($idContagem);
    // cria um novo processo dentro da trilha da contagem
    $ch->setIdProcesso(3); // no historico da contagem - Em validacao externas
    $ch->setIdContagem($idContagem);
    $ch->setDataInicio(date('Y-m-d H:i:s'));
    $ch->setDataFim(NULL);
    $ch->setAtualizadoPor($_SESSION ['user_email']);
    $ch->setIdTarefa($idTarefa);
    $ch->insere();
    // envia email informando sobre a solicitacao de validacao apenas em ambiente de producao
    if (PRODUCAO) {
        // abrangencia, idContagem, validadorExterno
        emailSolicitarValidacaoExterna($abrangencia, $idContagem, $userEmailExecutor, $objEmail);
    }
    // retorna para o script chamador
    echo json_encode(array(
        'msg' => 'A contagem foi enviada para valida&ccedil;&atilde;o externa.'
    ));
} else {
    // retorna com a mensagem de login
    echo json_encode(array(
        'msg' => '[PERFIL].Acesso n&atilde;o autorizado!'
    ));
}
