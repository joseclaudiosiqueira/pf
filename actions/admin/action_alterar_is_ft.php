<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verificacao do status do login e permissao
 */
$isGestor = getVariavelSessao('isGestor');
$isAdministrador = getVariavelSessao('isAdministrador');
/*
 * passa pela validacao
 */
if ($login->isUserLoggedIn() && ($isGestor || $isAdministrador) && verificaSessao()) {
    /*
     * retorna os fatores de impacto do roteiro selecionado
     */
    $id = filter_input(INPUT_POST, 'idl', FILTER_SANITIZE_NUMBER_INT);
    $isAtivo = filter_input(INPUT_POST, 'prp', FILTER_SANITIZE_NUMBER_INT);
    $fn = new Linguagem();
    $fn->setId($id);
    $fn->setIsFT($isAtivo);
    echo json_encode(array('status' => $fn->alterarIsFT()));
} else {
    echo json_encode(array('status' => FALSE));
}
