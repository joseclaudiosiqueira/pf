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
    $fn = new BancoDados();
    $cliente = new Cliente();
    $idEmpresa = getIdEmpresa();
    $idClienteEmpresa = $cliente->getIdClienteEmpresa($idEmpresa)['id'];
    $tipo = NULL !== filter_input(INPUT_POST, 't') ? filter_input(INPUT_POST, 't') : 1;
    $idCliente = filter_input(INPUT_POST, 'icl', FILTER_SANITIZE_NUMBER_INT);
    $ret = $fn->comboBancoDados($tipo, isFornecedor() ? $idClienteEmpresa : $idCliente);
    $res = array();
    foreach ($ret as $linha) {
        $res[] = array(
            'id' => $linha['id'],
            'descricao' => $linha['descricao'],
            'tipo' => $linha['tipo'],
            'status' => $linha['status'],
            'ie' => $linha['id_empresa']
        );
    }
    echo json_encode($res);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}