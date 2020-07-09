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
    $id = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);
    $permissions = $rbac->getAllPermissions($id);
    $arr = array();
    foreach ($permissions as $r) {
        $arr[] = array('ID' => $r['ID'], 'Description' => $r['Description'], '_Title' => str_replace('_', ' ', $r['Title']));
    }
    echo json_encode($arr);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}