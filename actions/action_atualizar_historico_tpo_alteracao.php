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

    $id = \NULL !== \filter_input(\INPUT_POST, 'i', \FILTER_SANITIZE_STRING) ? filter_input(\INPUT_POST, 'i', \FILTER_SANITIZE_STRING) : 0;

    $contagem = new Contagem();
    $historico = new ContagemHistorico();
    $tr = new Tarefa();
    //pode ser um gestor alterando, mas o user_id se mantera com quem originou a contagem
    $userId = $contagem->getUserId($id)['user_id'];
    $dataInicio = date('Y-m-d H:i:s');
    /*
     * insere uma atividade de elaboracao (14)
     */
    $prazoValidacao = '+30 days';
    $dataFim = date('Y-m-d H:i:s', strtotime($prazoValidacao));
    $tr->setIdContagem($id);
    $tr->setIdTipo(14);
    $tr->setIdEmpresa(getIdEmpresa());
    $tr->setIdFornecedor(getIdFornecedor());
    $tr->setDescricao('ELABORAÇÃO DE CONTAGEM #ID: ' . str_pad($id, 7, '0', STR_PAD_LEFT));
    $tr->setUserIdExecutor(getUserIdDecoded());
    $tr->setUserEmailSolicitante(getEmailUsuarioLogado());
    $tr->setUserIdSolicitante(getUserIdDecoded());
    $tr->setUserEmailExecutor(getEmailUsuarioLogado());
    $tr->setDataInicio(date('Y-m-d H:i:s'));
    $tr->setDataFim($dataFim);
    $idTarefa = $tr->insere();
    /*
     * insere o historico da contagem com o processo inicial de elaboracao
     * 1 - Em elaboracao
     */
    $idProcesso = 1;
    $historico->setIdContagem($id);
    $historico->setIdProcesso($idProcesso);
    $historico->setDataInicio($dataInicio);
    $historico->setAtualizadoPor($_SESSION['user_email']);
    $historico->setIdTarefa($idTarefa);
    $historico->setTable('contagem_historico');
    //retira os validadores interno/externo
    $contagem->setTable('contagem');
    $contagem->excluiValidadores($id);
    //retorna
    echo json_encode($historico->insere());
} else {
    echo json_encode(array('id' => 0, 'msg' => 'Acesso &atilde;o autorizado!'));
}
