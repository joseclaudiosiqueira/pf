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
    $fn = new Contagem();
    $fn->setTable('contagem');
    echo json_encode($fn->verificaEntregas(filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT)));
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}