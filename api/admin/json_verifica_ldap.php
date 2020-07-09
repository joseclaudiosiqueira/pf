<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verifica login e permissoes
 */
$isAdministrador = getVariavelSessao('isAdministrador');
if ($login->isUserLoggedIn() && verificaSessao() && $isAdministrador) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $ldapserver = filter_input(INPUT_POST, 'ldapserver', FILTER_SANITIZE_STRING);
    $ldapport = filter_input(INPUT_POST, 'ldapport', FILTER_SANITIZE_NUMBER_INT);
    $ldapdomain = filter_input(INPUT_POST, 'domain', FILTER_SANITIZE_STRING);
    echo json_encode(checkldapuser($username, $password, $ldapserver, $ldapport, $ldapdomain));
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}
