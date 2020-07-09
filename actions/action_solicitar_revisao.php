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
    $userEmailExecutor = filter_input(INPUT_POST, 'r', FILTER_SANITIZE_EMAIL);
    $acao = filter_input(INPUT_POST, 'a', FILTER_SANITIZE_STRING);
    $concluidoPor = getEmailUsuarioLogado();
    $finalizadoPor = getEmailUsuarioLogado();
    $userEmailSolicitante = getEmailUsuarioLogado();
    $userIdSolicitante = getUserIdDecoded();
    $dataFim = date('Y-m-d H:i:s');
    $dataConclusao = date('Y-m-d H:i:s');
    /*
     * classes
     */
    $fn = new Contagem();
    $ch = new ContagemHistorico();
    $ue = new UsersEmpresa();
    $userIdExecutor = $ue->getUserId($userEmailExecutor, getIdEmpresa());
    $ch->setIsAtualizandoProcesso(true);
    $tr = new Tarefa();
    $idTarefa = 0;
    /*
     * o fornecedor sera sempre o fornecedor da contagem no caso de validacoes externas de fornecedores
     */
    $idFornecedor = $fn->getIdFornecedor($idContagem)['id_fornecedor'];
    /*
     * verifica se pode solicitar revisao
     */
    $qtd = $fn->verificaFuncoesRevisao($idContagem, getEmailUsuarioLogado());
    /*
     * envia para revisao
     */
    if ($qtd > 0) {
        /*
         * pega a abrangencia para passar no link
         */
        $abrangencia = $fn->getAbrangencia($idContagem)['id_abrangencia'];
        /*
         * pega o id processo dependendo da acao
         */
        $idProcesso = $acao === 'vi' ? 2 : 3;
        /*
         * atualiza o historico da contagem
         */
        $tarefa = $ch->getProcessoAtual($idContagem, $idProcesso);
        $idTarefa = $tarefa['id_tarefa'];
        /*
         * id para finalizar o historico da contagem
         */
        $idHistorico = $tarefa['id'];
        /*
         * atualizar a tarefa de validacao da contagem
         */
        $tr->setDataConclusao($dataConclusao);
        $tr->setConcluidoPor($concluidoPor);
        $tr->conclui($idTarefa);
        /*
         * atualiza o processo de validacao interna da contagem
         */
        $ch->setDataFim($dataFim);
        $ch->setFinalizadoPor($finalizadoPor);
        $ch->setId($idHistorico);
        $ch->finalizaProcesso($idProcesso == 2 ? 12 : 13);
        /*
         * cria uma tarefa automatica de revisao da contagem
          id	descricao	is_ativo
          1	VALIDAÇÃO INTERNA	1
          2	VALIDAÇÃO EXTERNA	1
          3	AUDITORIA INTERNA	1
          4	AUDITORIA EXTERNA	1
          5	REVISÃO	1
          6	EDIÇÃO COMPARTILHADA	1
          7	APONTE AUDITORIA INTERNA	1
          8	APONTE AUDITORIA EXTERNA	1
          9	APONTE VALIDACAO INTERNA	1
          10 APONTE VALIDACAO EXTERNA	1
         * 11 revisao vi
         * 12 revisao ve
         * 13 vi automatica
         * 14 elaboracao de contagem
         */
        $prazoRevisao = '+' .
                ($acao === 'vi' ? $_SESSION['contagem_config_tarefas']['revisao_validacao_interna'] :
                        $_SESSION['contagem_config_tarefas']['revisao_validacao_externa']) . ' days';
        $dataFim = date('Y-m-d H:i:s', strtotime($prazoRevisao));
        $tr->setIdContagem($idContagem);
        $tr->setIdTipo(($acao === 'vi' ? 11 : 12)); //validacao interna/externa
        $tr->setIdEmpresa(getIdEmpresa());
        $tr->setIdFornecedor($idFornecedor);
        $tr->setDescricao('REVIS&Atilde;O [VALIDA&Ccedil;&Atilde;O ' . ($acao === 'vi' ? 'INTERNA' : 'EXTERNA') . '] na contagem #ID: ' . str_pad($idContagem, 7, '0', STR_PAD_LEFT));
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
         * cria um novo processo dentro da trilha da contagem
         */
        $ch->setIsInserirFinalizado(false);
        $ch->setIdProcesso($acao === 'vi' ? 8 : 9); //insere um processo de revisao na contagem
        $ch->setIdContagem($idContagem);
        $ch->setDataInicio(date('Y-m-d H:i:s'));
        $ch->setDataFim($dataFim);
        $ch->setAtualizadoPor(getEmailUsuarioLogado());
        $ch->setIdTarefa($idTarefa);
        $ch->insere();
        /*
         * envia email informando sobre a solicitacao de revisao apenas em ambiente de producao
         * 
         */
        if (PRODUCAO) {
            emailSolicitarRevisaoContagem($abrangencia, $idContagem, $userEmailExecutor, $acao, $objEmail);
        }
    }
    //retorna ao script chamador
    echo json_encode(array('sucesso' => ($qtd > 0 ? true : false), 'id_tarefa' => isset($idTarefa) ? $idTarefa : 0));
} else {
    //retorna com erro de sessao
    echo json_encode(array('sucesso' => false, 'id_tarefa' => 0, 'msg' => 'Acesso n&atilde;o autorizado!'));
}