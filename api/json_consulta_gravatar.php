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
$ret = new Registration();
$user = filter_input(INPUT_POST, 'user_name');
if (!filter_var($user, FILTER_VALIDATE_EMAIL)) {
    $arr_user_id = $ret->verificaNomeUsuario($user);
} else {
    $arr_user_id = $ret->verificaEmailUsuario($user, 0);
}
if (isset($arr_user_id[0]['existe']) || isset($arr_user_id[0]['existe_email'])) {
    $id = isset($arr_user_id[0]['user_id']) ? $arr_user_id[0]['user_id'] : 0;
    $url = getGravatarImageUser(sha1($id));
    $img[] = ['existe' => true, 'img' => $url];
} else {
    $img[] = ['existe' => false];
}
echo json_encode($img);
