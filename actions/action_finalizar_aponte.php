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
    //instancia a contagem para atualiza a lista de tarefas pendentes
    $tr = new Tarefa();
    $idAponte = filter_input(INPUT_POST, 'ida', FILTER_SANITIZE_NUMBER_INT);
    $idTarefa = filter_input(INPUT_POST, 'idt', FILTER_SANITIZE_NUMBER_INT);
    $idContagem = filter_input(INPUT_POST, 'idc', FILTER_SANITIZE_NUMBER_INT);
    $resolvidoPor = $_SESSION['user_email'];
    $observacoes = filter_input(INPUT_POST, 'r');
    //instancia apontes
    $ap = new ContagemApontes();
    $ap->setId($idAponte);
    $aponte = $ap->getAponte($id);
    //atualizar a tarefa de validacao da contagem
    $tr->setDataConclusao(date('Y-m-d H:i:s'));
    $tr->setConcluidoPor(getEmailUsuarioLogado());
    $tr->conclui($idTarefa);
    //atualiza o aponte
    $ap->setResolvidoPor($resolvidoPor);
    $ap->setStatus(1);
    $ap->setDataResolucao(date('Y-m-d H:i:s'));
    $ap->setObservacoes($observacoes);
    $ap->atualizaStatus();
    /*
     * pega o tipo de aponte
     */
    $tipo = $aponte['tipo'];
    $solicitante = $aponte['inserido_por'];
    /*
     * envia email informando sobre a conclusão do aponte de validacao/auditoria
     * apenas em ambiente de producao
     */
    if (PRODUCAO) {
        emailFinalizarAponte($idContagem, $userEmailSolicitante, $tipo, $objEmail);
    }
    echo json_encode(
            array(
                'sucesso' => true,
                'id_tarefa' => (isset($idTarefa) ? $idTarefa : 0),
                'qtd' => $tr->getQuantidadeTarefasPendentes()['qtd']));
} else {
    echo json_encode(array('sucesso' => false, 'id_tarefa' => 0, 'msg' => 'Acesso n&atilde;o autorizado!'));
}
