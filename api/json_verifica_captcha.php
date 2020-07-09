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
$arrCaptcha = [];
$input = \filter_input(\INPUT_POST, 'c', \FILTER_SANITIZE_STRING);
if ($input === sha1(strtolower($_SESSION['captcha']))) {
    $arrCaptcha[] = array('confere' => true);
} else {
    $arrCaptcha[] = array('confere' => false);
}
echo json_encode($arrCaptcha);