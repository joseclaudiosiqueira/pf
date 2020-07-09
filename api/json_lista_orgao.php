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
if ($login->isUserLoggedIn() && verificaSessao() && getPermissao('form_gerenciar_orgao')) {
    $fa = new Orgao();
    $fa->setIdEmpresa(getIdEmpresa());
    //verifica se veio um idcliente
    $idCliente = NULL !== filter_input(INPUT_POST, 'icl', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'icl', FILTER_SANITIZE_NUMBER_INT) : 0;
    //lista da empresa ou do cliente
    echo json_encode($fa->getTree('identada', $idCliente));
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}