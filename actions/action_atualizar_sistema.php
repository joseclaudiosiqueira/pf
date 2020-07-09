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
    $moduloSistema = new Sistema();
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
    $isAtivo = filter_input(INPUT_POST, 'isAtivo', FILTER_SANITIZE_NUMBER_INT);
    /*
     * seta as variaveis da classe
     */
    $moduloSistema->setId($id);
    $moduloSistema->setDescricao($descricao);
    $moduloSistema->setIsAtivo($isAtivo);
    /*
     * insere no banco e retorna um #ID
     */
    $retorno = $moduloSistema->atualiza($id);
    /*
     * retorna com o json para a pagina chamadora
     */
    echo json_encode(array(
        'id' => $id,
        'msg' => 'Sistema atualizado com sucesso!'));
} else {
    echo json_encode(array(
        'id' => 0,
        'msg' => 'Acesso n&atilde;o autorizado'));
}
