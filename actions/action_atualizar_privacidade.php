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
    /*
     * classes para autorizacao e contagem
     */
    $fn = new Contagem();
    $usuario = new Usuario();
    $userId = getUserIdDecoded();
    $userEmail = getEmailUsuarioLogado();
    $idFornecedor = getIdFornecedor();
    /*
     * variaveis do post
     */
    $privacidade = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_NUMBER_INT);
    $id = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);
    /*
     * verifica as regras
     * 1. se for um fornecedor nao pode alterar a privacidade, sempre publica
     * 2. $isReponsavel, $isGestor
     */
    $isResponsavel = $fn->isResponsavel($userEmail, $id);
    $isGestor = $usuario->isGestor($userId);
    /*
     * seta a privacidade caso autorizado
     */
    if (!(isFornecedor()) && ($isGestor || $isResponsavel)) {
        $fn->setPrivacidade($privacidade);
        echo json_encode(array('msg' => $fn->atualizaPrivacidade($id)));
    } else {
        echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado'));
    }
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado'));
}