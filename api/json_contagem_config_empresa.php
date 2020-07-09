<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
$idEmpresa = getIdEmpresa();
$idFornecedor = getIdFornecedor();
$isAdministrador = getVariavelSessao('isAdministrador');
$isGestor = getVariavelSessao('isGestor');
$isGestorFornecedor = getVariavelSessao('isGestorFornecedor');
/*
 * verifica login
 */
if ($login->isUserLoggedIn() && verificaSessao() && ($isAdministrador || $isGestor || $isGestorFornecedor)) {
    $contagem_config = new ContagemConfigEmpresa();
    $contagem_config->setIdEmpresa($idEmpresa);
    $contagem_config->setIdFornecedor($idFornecedor);
    echo json_encode($contagem_config->getConfig());
} else {
    echo json_encode(array('msg' => 'Acesso não autorizado!'));
}