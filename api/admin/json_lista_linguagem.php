<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verifica o id do cliente
 */
$idCliente = NULL !== filter_input(INPUT_POST, 'icl', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'icl', FILTER_SANITIZE_NUMBER_INT) : 0;
/*
 * verifica se o cliente pertence a empresa/fornecedor
 */
$idEmpresa = getIdEmpresa();
$validaCliente = FALSE;
if ($idCliente) {
    $cliente = new Cliente();
    $cliente->setId($idCliente);
    $cliente->setIdEmpresa($idEmpresa);
    $cliente->setIdFornecedor($idFornecedor);
    $validaCliente = $cliente->validaIDCliente();
}
/*
 * verifica login
 */
if ($login->isUserLoggedIn() && verificaSessao() && $idCliente && $validaCliente) {
    //TODO:verificar se ha a necessidade de criacao de configuracoes especiais ou converte o id_cliente_fornecedor em id_cliente_empresa
    //caso seja um fornecedor
    $linguagem = new Linguagem();
    $idEmpresa = getIdEmpresa();
    if (isFornecedor()) {
        $idCliente = $cliente->getIdClienteEmpresa($idEmpresa)['id'];
        $lista = $linguagem->lista($idEmpresa, $idCliente);
    } else {
        $lista = $linguagem->lista($idEmpresa, $idCliente);
    }
    echo json_encode($lista);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}

