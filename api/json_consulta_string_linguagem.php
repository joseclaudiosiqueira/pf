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
    $res[] = array(
        'msg' => __(filter_input(INPUT_POST, 's'))
    );
    echo json_encode($res);
} else {
    echo json_encode(array('msg' => 'N/A (???)'));
}