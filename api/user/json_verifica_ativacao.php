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
$fn = new Registration();
$ar = [];
$tipo = (NULL !== filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRING)) ? filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRING) : '';
if ($tipo == 'email') {
    $info = (NULL !== filter_input(INPUT_POST, 'info', FILTER_VALIDATE_EMAIL)) ? filter_input(INPUT_POST, 'info', FILTER_VALIDATE_EMAIL) : '';
} else {
    $info = (NULL !== filter_input(INPUT_POST, 'info', FILTER_SANITIZE_STRING)) ? filter_input(INPUT_POST, 'info', FILTER_SANITIZE_STRING) : '';
}
$hash = (NULL !== filter_input(INPUT_POST, 'hash', FILTER_SANITIZE_STRING)) ? filter_input(INPUT_POST, 'hash', FILTER_SANITIZE_STRING) : '';

if($tipo === '' || $info === '' || $hash === ''){
    $ar = array('successo'=>false, 'msg'=>'Par&acirc;metros inv&aacute;lidos.');
}
else{
    $ar = $fn->verificaNomeEmailAtivacao($tipo, $info, $hash);
}

echo json_encode($ar);

