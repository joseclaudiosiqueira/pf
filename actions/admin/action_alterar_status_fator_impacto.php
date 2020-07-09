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
$user = new Usuario();
$userId = getUserIdDecoded();
$isGestor = $user->isGestor($userId);
$isAdministrador = $user->isAdministrador($userId);
/*
 * passa pela validacao
 */
if ($login->isUserLoggedIn() && ($isGestor || $isAdministrador) && verificaSessao()) {
    /*
     * retorna os fatores de impacto do roteiro selecionado
     */
    $id = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);
    $isAtivo = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_NUMBER_INT);
    $fn = new FatorImpacto();
    $fn->setIsAtivo($isAtivo);
    $fn->setLog();
    $fn->setTable('fator_impacto');
    echo json_encode(array('status' => $fn->alterarSatusFatorImpacto($id, $isAtivo)));
} else {
    echo json_encode(array('status' => false));
}
