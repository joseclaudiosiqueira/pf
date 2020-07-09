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
    $contagem_config = isFornecedor() ? new ContagemFornecedorConfig() : new ContagemConfig();
    if (isFornecedor()) {
        $contagem_config->setIdFornecedor($idFornecedor);
        $contagem_config->setIdCliente($idCliente);
    } else {
        $contagem_config->setIdEmpresa($idEmpresa);
        $contagem_config->setIdCliente($idCliente);
    }
    /*
     * ATENCAO ... este metodo puxa todas as configuracoes de uma soh vez
     * tanto em contagem_config quanto em contagem_config_empresa
     * isso foi feito para evitar duas chamadas json
     */
    echo json_encode($contagem_config->getConfig());
} else {
    echo json_encode(array('msg' => 'Acesso não autorizado!'));
}