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
    $fa = new Comentario();
    $fa->setTable('comentarios');
    $fa->setLog();
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    /*
     * envia email avisando sobre a leitura do comentario
     */
    echo json_encode(array('status' => $fa->atualizaStatus($id)));
} else {
    echo json_encode(array('status' => false));
}
