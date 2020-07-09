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
    /*
     * aqui tem um post idCliente, idEmpresa, idFornecedor
     */
    $id = filter_input(INPUT_POST, 'idc', FILTER_SANITIZE_NUMBER_INT);
    $config = new ContagemConfigTabInicio();
    $config->setId($id);
    echo json_encode($config->listaIdsConfiguracoesTabInicio());
} else {
    echo json_encode(array(
        'sucesso' => FALSE,
        'msg' => 'Acesso n&ATILDE;o autorizado!'
    ));
}