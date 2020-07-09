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

    $idContagem = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);
    $userEmailSolicitante = filter_input(INPUT_POST, 'r', FILTER_SANITIZE_EMAIL);
    $userEmailExecutor = filter_input(INPUT_POST, 'v', FILTER_SANITIZE_EMAIL);
    $abrangencia = filter_input(INPUT_POST, 'a', FILTER_SANITIZE_NUMBER_INT);
    $idProcesso = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_NUMBER_INT);

    $concluidoPor = getEmailUsuarioLogado();
    $finalizadoPor = getEmailUsuarioLogado();
    $dataFim = date('Y-m-d H:i:s');
    $dataConclusao = date('Y-m-d H:i:s');

    $ue = new UsersEmpresa();
    $userIdExecutor = $ue->getUserId($userEmailExecutor, getIdEmpresa());
    $fn = new Contagem();
    $ch = new ContagemHistorico();
    $ch->setIsAtualizandoProcesso(true);

    $tr = new Tarefa();
    $idTarefa = 0;

    $qtd = $fn->verificaFuncoesFinalizarRevisao($idContagem, getEmailUsuarioLogado());

    if ($qtd < 1) {
        //atualiza o historico da contagem
        $tarefa = $ch->getProcessoAtual($idContagem, $idProcesso);
        $idTarefa = $tarefa['id_tarefa'];
        //id para finalizar o historico da contagem
        $idHistorico = $tarefa['id'];
        //atualizar a tarefa de validacao da contagem
        $tr->setDataConclusao($dataConclusao);
        $tr->setConcluidoPor($concluidoPor);
        $tr->conclui($idTarefa);
        //atualiza o processo de revisao da contagem
        $ch->setDataFim($dataFim);
        $ch->setFinalizadoPor($finalizadoPor);
        $ch->setId($idHistorico);
        $ch->finalizaProcesso();
        /*
         * cria uma tarefa automatica de validacao da contagem
         * id_tipo
         * 1 - VALIDACAO INTERNA
         * 2 - VALIDACAO EXTERNA
         * 3 - AUDITORIA INTERNA
         * 4 - AUDITORIA EXTERNA
         * 5 - REVISAO
         */
        $prazoRevisao = '+' .
                ($idProcesso == 8 ? $_SESSION['contagem_config_tarefas']['validacao_interna'] :
                        $_SESSION['contagem_config_tarefas']['validacao_externa']) . ' days';
        $dataFim = date('Y-m-d H:i:s', strtotime($prazoRevisao));
        $tr->setIdContagem($idContagem);
        $tr->setIdTipo(($idProcesso == 8 ? 1 : 2)); //validacao interna/externa
        $tr->setIdEmpresa(getIdEmpresa());
        $tr->setIdFornecedor(getIdFornecedor());
        $tr->setDescricao('VALIDA&Ccedil;&Atilde;O ' . ($idProcesso == 8 ? 'INTERNA' : 'EXTERNA') . ' na contagem #ID: ' . str_pad($idContagem, 7, '0', STR_PAD_LEFT));
        $tr->setUserEmailSolicitante(getEmailUsuarioLogado());
        $tr->setUserIdSolicitante(getUserIdDecoded());
        $tr->setUserEmailExecutor($userEmailExecutor);
        $tr->setUserIdExecutor($userIdExecutor);
        $tr->setDataInicio(date('Y-m-d H:i:s'));
        $tr->setDataFim($dataFim);
        $tr->setDataConclusao(NULL);
        $tr->setConcluidoPor(NULL);
        $idTarefa = $tr->insere();
        /*
         * cria um novo processo dentro da trilha da contagem
         */
        $ch->setIsInserirFinalizado(false);
        $ch->setIdProcesso($idProcesso == 8 ? 2 : 3); //insere um processo de validacao na contagem
        $ch->setIdContagem($idContagem);
        $ch->setDataInicio(date('Y-m-d H:i:s'));
        $ch->setAtualizadoPor($_SESSION['user_email']);
        $ch->setFinalizadoPor(NULL);
        $ch->setDataFim(NULL);
        $ch->setIdTarefa($idTarefa);
        $ch->insere();
        /*
         * envia email informando sobre a solicitacao de revisao
         * apenas em ambiente de producao
         */
        if (PRODUCAO) {
            $idProcesso == 8 ?
                            emailSolicitarValidacaoInterna($abrangencia, $idContagem, $userEmailExecutor, $objEmail) :
                            emailSolicitarValidacaoExterna($abrangencia, $idContagem, $userEmailExecutor, $objEmail);
        }
    }
    echo json_encode(array('sucesso' => ($qtd < 1 ? true : false), 'id_tarefa' => isset($idTarefa) ? $idTarefa : 0));
} else {
    json_encode(array('sucesso' => false, 'id_tarefa' => 0, 'msg' => 'Acesso n&atilde;o autorizado!'));
}