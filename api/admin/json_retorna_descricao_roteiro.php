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
if ($login->isUserLoggedIn()) {
    /*
     * retorna os fatores de impacto do roteiro selecionado
     */
    $descricao = filter_input(INPUT_POST, 'd', FILTER_SANITIZE_STRING);

    $fn = new Roteiro();
    $fn->setTable('roteiro');

    echo json_encode($fn->getDescricaoRoteiro($descricao));
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}
