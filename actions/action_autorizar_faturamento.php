<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER ['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
$fn = new Contagem ();
$ch = new ContagemHistorico ();
$tr = new Tarefa ();
$us = new Usuario ();
/*
 * informacoes para autorizacao
 */
$isFiscalContrato = getVariavelSessao('isFiscalContratoCliente'); // nivel cliente
$isFiscalContratoFornecedor = getVariavelSessao('isFiscalContratoFornecedor'); // nivel fornecedor
$isFiscalContratoEmpresa = getVariavelSessao('isFiscalContratoEmpresa'); // nivel empresa
/*
 * pega o id da contagem que tera a autorizacao do faturamento
 */
$idContagem = NULL !== filter_input(INPUT_POST, 'idc', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'idc', FILTER_SANITIZE_NUMBER_INT) : 0;
/*
 * finalizada e pronta para faturamento
 */
$idProcesso = 7;
/*
 * verifica se ainda tem uma tarefa
 */
$idTarefa = $ch->getProcessoAtual($idContagem, $idProcesso);
/*
 * verificacao do status do login
 */
if ($login->isUserLoggedIn() && verificaSessao() && $idContagem && ($idTarefa ['id_tarefa']) && ($isFiscalContrato || $isFiscalContratoFornecedor || $isFiscalContratoEmpresa)) {
    /*
     * seta as variaveis para conclusao da tarefa
     */
    $concluidoPor = getEmailUsuarioLogado();
    $finalizadoPor = getEmailUsuarioLogado();
    $dataFim = date('Y-m-d H:i:s');
    $dataConclusao = date('Y-m-d H:i:s');
    $userEmailAutorizadorFaturamento = getEmailUsuarioLogado();
    $userIdAutorizadorFaturamento = getUserIdDecoded();
    $dataAutorizadaFaturamento = date('Y-m-d H:i:s');
    $isAutorizadaFaturamento = 1;
    /*
     * processo de atualizacao do historico
     */
    $ch->setIsAtualizandoProcesso(true);
    /*
     * pega o email do solicitante para retornar com a autorizacao
     */
    $tr->setIdTarefa($idTarefa ['id_tarefa']);
    $userEmailSolicitante = $tr->getUserEmailSolicitante();
    /*
     * id para finalizar o historico da contagem
     */
    $idHistorico = $idTarefa ['id'];
    /*
     * atualizar a tarefa de validacao da contagem
     */
    $tr->setDataConclusao($dataConclusao);
    $tr->setConcluidoPor($concluidoPor);
    $tr->conclui($idTarefa ['id_tarefa']);
    /*
     * atualiza o processo de revisao da contagem
     */
    $ch->setDataFim($dataFim);
    $ch->setFinalizadoPor($finalizadoPor);
    $ch->setId($idHistorico);
    $ch->finalizaProcesso();
    /*
     * atualiza a contagem nos historicos de faturamento
     */
    $fn->setIdContagem($idContagem);
    $fn->setUserEmailAutorizadorFaturamento($userEmailAutorizadorFaturamento);
    $fn->setUserIdAutorizadorFaturamento($userIdAutorizadorFaturamento);
    $fn->setDataAutorizadaFaturamento($dataAutorizadaFaturamento);
    $fn->setIsAutorizadaFaturamento($isAutorizadaFaturamento);
    $fn->autorizarFaturamento();
    /*
     * envia email informando sobre a autorizacao de faturamento da contagem
     */
    if (PRODUCAO) {
        emailAvisoAutorizacaoFaturamento($idContagem, $userEmailSolicitante, $objEmail);
    }
    /*
     * retorna informando sobre a autorizacao
     */
    echo json_encode(array(
        'sucesso' => true,
        'id_tarefa' => $idTarefa ['id_tarefa'],
        'msg' => 'A autoriza&ccedil;&atilde;o para faturamento foi executada com sucesso.'
    ));
} else {
    echo json_encode(array(
        'sucesso' => false,
        'id_tarefa' => 0,
        'msg' => 'Acesso n&atilde;o autorizado!'
    ));
}
