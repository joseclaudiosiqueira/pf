<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * instancia as classes
 */
$fn = new Contagem();
$us = new Usuario();
/*
 * informacoes para autorizacao
 */
$userId = getUserIdDecoded();
$idFornecedor = getIdFornecedor();
$isGestor = getVariavelSessao('isGestor');
$isGestorFornecedor = getVariavelSessao('isGestorFornecedor');
$isGerenteConta = getVariavelSessao('isGerenteConta');
$isGerenteContaFornecedor = getVariavelSessao('isGerenteContaFornecedor');
/*
 * verificacao do status do login
 */
if ($login->isUserLoggedIn() && verificaSessao() && ($isGestor || $isGestorFornecedor || $isGerenteConta || $isGerenteContaFornecedor)) {
    /*
     * seta as variaveis de faturamento para a Contagem()
     */
    $arquivo = 'FATURAMENTO-' . $_POST['maf'];
    $arrFaturar = $_POST['fat'];
    $isFaturada = 1;
    $userIdFaturador = getUserIdDecoded();
    $userEmailFaturador = getEmailUsuarioLogado();
    $dataFaturada = date('Y-m-d H:i:s');
    for ($x = 0; $x < count($arrFaturar); $x++) {
        $idContagem = $arrFaturar[$x];
        $fn->setIsFaturada($isFaturada);
        $fn->setUserIdFaturador($userIdFaturador);
        $fn->setUserEmailFaturador($userEmailFaturador);
        $fn->setDataFaturada($dataFaturada);
        $fn->setIdContagem($idContagem);
        $fn->faturar();
    }
    /*
     * retorna com a atualizacao do faturamento
     */
    echo json_encode(array('sucesso' => TRUE));
} else {
    echo json_encode(array('sucesso' => FALSE));
}
