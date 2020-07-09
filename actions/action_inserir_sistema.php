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
if ($login->isUserLoggedIn() && verificaSessao()) {
    $moduloSistema = new Sistema();
    $idEmpresa = getIdEmpresa();
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
    $isAtivo = filter_input(INPUT_POST, 'isAtivo', FILTER_SANITIZE_NUMBER_INT);
    $moduloSistema->setIdEmpresa($idEmpresa);
    $moduloSistema->setDescricao($descricao);
    $moduloSistema->setIsAtivo($isAtivo);
    echo json_encode(array(
        'id' => $moduloSistema->insere(),
        'msg' => 'Sistema inserido com sucesso'));
} else {
    echo json_encode(array(
        'id' => 0,
        'msg' => 'Acesso n&atilde;o autorizado!'));
}