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
    $idCliente = filter_input(INPUT_POST, 'icl', FILTER_SANITIZE_NUMBER_INT);
    $fa = new Baseline();
    $fa->setIdEmpresa(getIdEmpresa());
    $fa->setIdCliente($idCliente);
    echo json_encode($fa->listaBaseline());
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}