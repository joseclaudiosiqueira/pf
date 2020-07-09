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
if ($login->isUserLoggedIn() && verificaSessao()) {
    $id = \NULL !== filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT) : 0;
    $fn = isFornecedor() ? new ContagemFornecedorConfig() : new ContagemConfig();
    $re = $fn->getConfig($id);
    echo json_encode($re);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}