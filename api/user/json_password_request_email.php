<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}

$user_name = NULL !== filter_input(INPUT_POST, 'u', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'u', FILTER_SANITIZE_STRING) : '';

if ($user_name) {
    $ret = $login->getEmailFromUniqueId($user_name);
} else {
    $ret = array('sucesso' => false, 'msg' => 'Acesso n&atilde;o autorizado!');
}

echo json_encode($ret);
