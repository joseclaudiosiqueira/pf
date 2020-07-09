<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verifica a permissao de acesso ao formulario
 */
$permissao = (getPermissao('form_gerenciar_orgao') && !isFornecedor()) ? TRUE : FALSE;
/*
 * verificacao do status do login
 */
if ($login->isUserLoggedIn() && $permissao && verificaSessao()) {
    /*
     * pega as variaveis do post
     */
    $id = NULL !== filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT) ? intval(filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT)) : 0;
    $isAtivo = NULL !== filter_input(INPUT_POST, 'p', FILTER_SANITIZE_NUMBER_INT) ? intval(filter_input(INPUT_POST, 'p', FILTER_SANITIZE_NUMBER_INT)) : 0;
    /*
     * valida as variaveis
     */
    if (!is_int($isAtivo) || !is_int($id) || $isAtivo > 1) {
        echo json_encode(array('status' => FALSE, 'msg' => 'Acesso n&atilde;o autorizado!'));
    } else {
        /*
         * com base no id verifica se o usuario atual tem acesso para atualizacao do status
         */
        $fn = new Orgao();
        $fn->setIsAtivo($isAtivo);
        $fn->setLog();
        /*
         * retorna com a autorizacao
         */
        echo json_encode(array('status' => $fn->alterarStatusOrgao($id)));
    }
} else {
    echo json_encode(array('status' => FALSE, 'msg' => 'Acesso n&atilde;o autorizado!'));
}
