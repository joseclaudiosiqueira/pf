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
    $cliente = new Cliente ();
    $idEmpresa = getIdEmpresa();
    $idFornecedor = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);
    $cliente->setIdFornecedor($idFornecedor);
    $cliente->setIdEmpresa($idEmpresa);
    echo json_encode($cliente->getIdClienteFornecedorEmpresa());
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}