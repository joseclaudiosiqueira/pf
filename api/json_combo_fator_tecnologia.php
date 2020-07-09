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
    $idCliente = NULL !== filter_input(INPUT_POST, 'icl', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'icl', FILTER_SANITIZE_NUMBER_INT) : getIdCliente();
    $idEmpresa = getIdEmpresa();
    $fn = new Linguagem();
    $lista = $fn->comboFatorTecnologia($idCliente, $idEmpresa);
    echo json_encode($lista);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}