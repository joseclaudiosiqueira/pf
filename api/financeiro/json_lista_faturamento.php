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
if ($login->isUserLoggedIn()) {
    $faturamento = new Faturamento();
    $faturamento->setTable('faturamento');
    $idEmpresa = getIdEmpresa();
    echo json_encode($faturamento->getListaFaturamento($idEmpresa));
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}

