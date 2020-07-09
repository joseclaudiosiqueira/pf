<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verifica o perfil
 */
$isAdministrador = getVariavelSessao('isAdministrador');
$isInstrutor = getVariavelSessao('isInstrutor');
/*
 * verificacao do status do login
 */
if ($login->isUserLoggedIn() && verificaSessao() && ($isAdministrador || $isInstrutor)) {
    /*
     * instanciacao das classes
     */
    $fn = new Registration();
    /*
     * insere no banco e retorna um #ID
     */
    $user_name = filter_input(\INPUT_POST, 'user_name', FILTER_SANITIZE_STRING);
    $user_email = filter_input(\INPUT_POST, 'user_email', FILTER_SANITIZE_EMAIL);
    $role_id = filter_input(\INPUT_POST, 'role_id', FILTER_SANITIZE_NUMBER_INT);
    $complete_name = filter_input(\INPUT_POST, 'user_complete_name', FILTER_SANITIZE_STRING);
    $id_fornecedor = filter_input(\INPUT_POST, 'user_id_fornecedor', FILTER_SANITIZE_NUMBER_INT);
    $id_cliente = filter_input(\INPUT_POST, 'user_id_cliente', FILTER_SANITIZE_NUMBER_INT);
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
    $is_id_existente = filter_input(\INPUT_POST, 'is_id_existente', FILTER_SANITIZE_NUMBER_INT);
    $is_validar_adm_gestor = filter_input(\INPUT_POST, 'is_validar_adm_gestor', FILTER_SANITIZE_NUMBER_INT);
    $opcao_identificador = filter_input(\INPUT_POST, 'opcao_identificador', FILTER_SANITIZE_NUMBER_INT);
    $user_active = filter_input(\INPUT_POST, 'user_active', FILTER_SANITIZE_NUMBER_INT);
    $user_activation_hash = filter_input(\INPUT_POST, 'user_activation_hash', FILTER_SANITIZE_STRING);
    $id_empresa = getUserName() === '41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265' ?
            filter_input(\INPUT_POST, '41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265', FILTER_SANITIZE_NUMBER_INT) : getIdEmpresa();
    $isInserirContagemAuditoria = filter_input(\INPUT_POST, 'user_is_inserir_contagem_auditoria', FILTER_SANITIZE_NUMBER_INT);
    $id = $fn->registerNewUser(
            $user_name, $user_email, $id_empresa, $complete_name, $id_fornecedor, $id_cliente, $role_id, $is_id_existente, $user_id, $is_validar_adm_gestor, $opcao_identificador, $user_active, $user_activation_hash, $isInserirContagemAuditoria);
    /*
     * converte o $ID em um array json
     */
    if (isset($id[0]['msg']) && $id[0]['msg'] === 'sucesso') {
        $ret[] = array(
            'msg' => 'sucesso',
            'is_id_existente' => $is_id_existente,
            'id' => $id[0]['user_id'],
            'user_name' => $id[0]['user_name'],
            'link' => $id[0]['link'],
            'is_fornecedor' => $id_fornecedor ? TRUE : FALSE);
    } else {
        $ret[] = array(
            'msg' => 'erro', 'id' => $id);
    }
    /*
     * retorna com o json para a pagina chamadora
     */
    echo json_encode($ret);
} else {
    echo json_encode(array(array('id' => 0, 'msg' => 'Acesso n&atilde;o autorizado')));
}
