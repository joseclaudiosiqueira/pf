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
    $idEmpresa = filter_input(INPUT_POST, 'e', FILTER_SANITIZE_NUMBER_INT);
    $idFornecedor = filter_input(INPUT_POST, 'f', FILTER_SANITIZE_NUMBER_INT);
    $roleId = filter_input(INPUT_POST, 'r', FILTER_SANITIZE_NUMBER_INT);
    $roleTitle = filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING);
    $isValidarAdmGestor = filter_input(INPUT_POST, 'v', FILTER_SANITIZE_NUMBER_INT);
    /*
     * realiza as alteracoes na tabela users_empresa
     */
    $fn = new Usuario();
    $fn->setRoleId($roleId);
    $fn->setLog();
    $fn->alterarPerfilUsuario($idUser, $idEmpresa, $idFornecedor);

    $fn->setIsValidarAdmGestor($isValidarAdmGestor);
    $fn->alterarIsValidarAdmGestor($idUser, $idEmpresa, $idFornecedor);

    $ro = $fn->getRoleTitle($roleId);
    /*
     * realiza as operacoes na tabela historico do usuario
     */
    $uh = new UsuarioHistorico();
    $uh->setTable('usuario_historico');
    $uh->setLog();
    $uh->setUserId($idUser);
    $uh->setIdEmpresa($idEmpresa);
    $uh->setIdFornecedor($idFornecedor);
    $uh->setOperacao('perfil->' . $ro['Title']);
    $uh->insere();

    echo json_encode(array('status' => $fn->alterarPerfilUsuario($idUser, $idEmpresa, $idFornecedor), 'short_name' => $ro['short_name']));
} else {
    echo json_encode(array('id' => 0, 'msg' => 'Acesso n&atilde;o autorizado!'));
}