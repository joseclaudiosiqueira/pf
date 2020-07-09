<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verifica login
 */
$idContagem = NULL !== filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT) : 0;
/*
 * 
 */
$contagem = new Contagem();
$tarefa = new Tarefa();
$idEmpresa = getIdEmpresa();
$email = getEmailUsuarioLogado();
$isFornecedor = isFornecedor();
$isResponsavel = $contagem->isResponsavel($email, $idContagem ? $idContagem : 0);
$contagemProcesso = $contagem->getContagemProcesso($idContagem, '1, 2, 3, 6, 7, 8, 9, 10, 18, 19, 20, 21');
$pass = ($isResponsavel || getVariavelSessao('isGestor') || ($isFornecedor && getVariavelSessao('isGestorFornecedor')));
/*
 * confere login e valida o id da contagem
 */
if ($login->isUserLoggedIn() && $idContagem && verificaSessao() && $pass) {
    /*
     * verifica se a contagem esta em processo de elaboracao
     */
    if ($contagemProcesso['id_processo'] == 1 && NULL === $contagemProcesso['data_fim']) {
        /*
         * log de auditoria
         */
        $contagem->gravaLog($idContagem);
        /*
         * marca como excluida
         */
        $contagem->setIsExcluida($idContagem);
        /*
         * baixa a tarefa de elaboracao da contagem
         */
        $tarefa->setIdContagem($idContagem);
        $tarefa->setIdTipo(14);
        $tarefa->setIdEmpresa($idEmpresa);
        $tarefa->setDataConclusao(date('Y-m-d H:i:s'));
        $tarefa->setConcluidoPor(getEmailUsuarioLogado());
        $idTarefa = $tarefa->getIdTarefaElaboracao()['id'];
        $tarefa->conclui($idTarefa);
        /*
         * retorna ao script chamador
         */
        echo json_encode(array(
            'sucesso' => TRUE,
            'msg' => 'A contagem foi exclu&iacute;da com sucesso!',
            'qtd' => $tarefa->getQuantidadeTarefasPendentes()['qtd']));
    } else {
        echo json_encode(array('sucesso' => FALSE, 'msg' => 'Esta contagem não está no processo de elaboração!'));
    }
} else {
    echo json_encode(array('sucesso' => FALSE, 'msg' => 'Acesso n&atilde;o autorizado!'));
}

