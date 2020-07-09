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
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $ldapServer = filter_input(INPUT_POST, 'ldapserver', FILTER_SANITIZE_STRING);
    $ldapPort = filter_input(INPUT_POST, 'ldapport', FILTER_SANITIZE_NUMBER_INT);
    $ldapDomain = filter_input(INPUT_POST, 'domain', FILTER_SANITIZE_STRING);
}
