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
    $fa = new ContagemApontes();
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $email = NULL !== filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) ? filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL) : NULL;
    $ret = $fa->listaApontes($id, $email);
    echo json_encode($ret);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}