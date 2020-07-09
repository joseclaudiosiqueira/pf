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
    $emailLogado = filter_input(INPUT_POST, 'e', FILTER_SANITIZE_EMAIL);
    $userRole = filter_input(INPUT_POST, 'u', FILTER_SANITIZE_STRING);
    $acesso = filter_input(INPUT_POST, 'a', FILTER_SANITIZE_STRING);
    $fp = fopen(DIR_FILE . "logs" . DIRECTORY_SEPARATOR . "logs.csv", "a");
    $escreve = fwrite($fp, date('Y-m-d H:i:s') . ';' . str_pad(getIdEmpresa(), 9, 0, STR_PAD_LEFT) . ';' . str_pad(getIdFornecedor(), 9, 0, STR_PAD_LEFT) . ';' . $emailLogado . ';' . tirarAcentos($converter->decode($userRole)) . ';' . $acesso . "\n");
    fclose($fp);
} else {
    $fp = fopen(DIR_FILE . "logs" . DIRECTORY_SEPARATOR . "logs.csv", "a");
    $escreve = fwrite($fp, date('Y-m-d H:i:s') . ';' . '0' . ';' . '0' . ';' . 'Acesso nao logado' . ';' . 'N/A' . ';' . 'Acesso nao logado' . "\n");
    fclose($fp);
}