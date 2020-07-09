<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verificacao do status do login
 */
if ($login->isUserLoggedIn() && verificaSessao() && getPermissao('form_gerenciar_orgao')) {
    /*
     * INSTANCIA AS CLASSES
     */
    $fn = new Orgao();
    $sigla = filter_input(INPUT_POST, 'sigla', FILTER_SANITIZE_SPECIAL_CHARS);
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
    $isAtivo = filter_input(INPUT_POST, 'isAtivo', FILTER_SANITIZE_NUMBER_INT);
    $idSuperior = filter_input(INPUT_POST, 'idSuperior', FILTER_SANITIZE_NUMBER_INT);
    $idEmpresa = getIdEmpresa();
    $idCliente = filter_input(INPUT_POST, 'idCliente', FILTER_SANITIZE_NUMBER_INT);
    /*
     * seta as variaveis da classe
     */
    $fn->setLog();
    $fn->setIdEmpresa($idEmpresa);
    $fn->setIdCliente($idCliente);
    $fn->setSigla($sigla);
    $fn->setDescricao($descricao);
    $fn->setIsAtivo($isAtivo);
    $fn->setIsEditavel(1);
    $fn->setSuperior(NULL);
    $fn->setUserId(0);
    /*
     * insere no banco e retorna um #ID
     */
    $ret = $fn->addOrgaoSubordinado($idSuperior);
    /*
     * retorna com o json para a pagina chamadora
     */
    echo json_encode(array('id' => $ret));
} else {
    echo json_encode(array('id' => 0, 'msg' => 'Acesso n&atilde;o autorizado!'));
}