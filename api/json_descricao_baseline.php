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
    $idb = NULL !== filter_input(INPUT_POST, 'idb', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'idb', FILTER_SANITIZE_NUMBER_INT) : 0;
    $bas = new Baseline();
    $bas->setTable('baseline');
    $des = $bas->getSigla($idb); //descricao
    echo json_encode($des);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}