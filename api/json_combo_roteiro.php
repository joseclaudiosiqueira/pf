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
    $fn = new Roteiro();
    /*
     * verifica o tipo (1 = ativo, 0 = inativo)
     */
    $tipo = NULL !== filter_input(INPUT_POST, 't') ? filter_input(INPUT_POST, 't') : 1;
    $exibirTodos = NULL !== filter_input(INPUT_POST, 'e') ? filter_input(INPUT_POST, 'e') : 0;
    $idEmpresa = getIdEmpresa();
    $idFornecedor = isFornecedor() ? getIdFornecedor() : 0;
    $idCliente = (int) getConfigContagem('id_cliente') > 0 ? getConfigContagem('id_cliente') : 0;
    $res = array();
    if ($exibirTodos) {
        $res = $fn->comboRoteiroTodos($tipo, $idEmpresa);
    } else {
        $res = $fn->comboRoteiro($tipo, $idEmpresa, $idFornecedor, $idCliente);
    }
    echo json_encode($res);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}