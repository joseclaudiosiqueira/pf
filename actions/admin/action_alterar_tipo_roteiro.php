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
     * retorna os fatores de impacto do roteiro selecionado
     */
    $id = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);
    $tipo = filter_input(INPUT_POST, 't', FILTER_SANITIZE_NUMBER_INT);

    $fn = new Roteiro();

    $fn->setTipo($tipo);
    $fn->setLog();

    $fn->setTable('roteiro');

    echo json_encode(array('status' => $fn->alterarTipoRoteiro($id, $tipo)));
} else {
    echo json_encode(array('status' => false));
}
