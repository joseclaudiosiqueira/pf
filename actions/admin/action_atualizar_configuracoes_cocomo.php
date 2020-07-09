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
$idFornecedor = getIdFornecedor();
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
    $fn = new ContagemConfigCocomo();
    /*
     * coleta as variaveis
     */
    $idc = NULL !== filter_input(INPUT_POST, 'idc', FILTER_SANITIZE_STRING) ? str_replace('-', '_', filter_input(INPUT_POST, 'idc', FILTER_SANITIZE_STRING)) : 'INV';
    $valor = NULL !== filter_input(INPUT_POST, 'vlu') ? filter_input(INPUT_POST, 'vlu') : 0;
    if ($idc !== 'INV' && $valor) {
        $fn->setVariavel($idc);
        $fn->setValor($valor);
        $fn->setIdEmpresa(getIdEmpresa());
        $fn->setIdCliente($idCliente);
        /*
         * atualiza
         */
        $atualiza = $fn->atualiza(NULL);
        /*
         * retorna
         */
        if ($atualiza) {
            echo json_encode(array('msg' => 'Valor atualizado!'));
        } else {
            echo json_encode(array('msg' => 'Houve um erro durante a atualiza&ccedil;&atilde;o das informa&ccedil;&otilde;es, por favor tente novamente!'));
        }
    } else {
        echo json_encode(array('msg' => 'Houve um erro durante a atualiza&ccedil;&atilde;o das informa&ccedil;&otilde;es, por favor tente novamente!'));
    }
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}



