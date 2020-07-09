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
if ($login->isUserLoggedIn()) {
    /*
     * retorna os fatores de impacto do roteiro selecionado
     */
    $idUser = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);
    $isAtivo = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_NUMBER_INT);
    $idEmpresa = filter_input(INPUT_POST, 'e', FILTER_SANITIZE_NUMBER_INT);
    $idFornecedor = filter_input(INPUT_POST, 'f', FILTER_SANITIZE_NUMBER_INT);
    /*
     * realiza as alteracoes na tabela users_empresa
     */
    $fn = new Usuario();
    $fn->setIsAtivo($isAtivo);
    $fn->setLog();
    
    $fn->setTable('users_empresa');
    /*
     * realiza as operacoes na tabela historico do usuario
     */
    $uh = new UsuarioHistorico();
    $uh->setTable('usuario_historico');
    $uh->setLog();
    $uh->setUserId($idUser);
    $uh->setIdEmpresa($idEmpresa);
    $uh->setIdFornecedor($idFornecedor);
    $uh->setOperacao($isAtivo ? 'ativar' : 'inativar');
    $uh->insere();

    echo json_encode(array('status' => $fn->alterarStatusUsuario($idUser, $idEmpresa, $idFornecedor)));
} else {
    echo json_encode(array('status' => false));
}