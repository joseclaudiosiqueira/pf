<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER ['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verifica login
 */
if ($login->isUserLoggedIn() && verificaSessao()) {
    $comentario = new Comentario ();
    $idExterno = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $tabela = filter_input(INPUT_POST, 'tbl', FILTER_SANITIZE_STRING);
    $idEmpresa = getIdEmpresa();
    $idFornecedor = getIdFornecedor();
    $idCliente = 0;
    /*
     * seta as variaveis da classe
     */
    $comentario->setIdExterno($idExterno);
    $comentario->setTabela($tabela);
    $comentario->setIdEmpresa($idEmpresa);
    $comentario->setIdFornecedor($idFornecedor);
    $comentario->setIdCliente($idCliente);
    /*
     * retorna
     */
    echo json_encode($comentario->listaComentarios());
} else {
    echo json_encode(array(
        'msg' => 'Acesso n&atilde;o autorizado!'
    ));
}