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
    $fn = new EmpresaConfig();
    $fn->setTable('empresa_config');
    $idEmpresa = getIdEmpresa();
    echo json_encode($fn->retornaLDAP($idEmpresa));
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}