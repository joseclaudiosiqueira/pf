<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER ['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verifica login
 */
if ($login->isUserLoggedIn() && verificaSessao()) {
    /*
     * classes
     */
    $usuario = new Usuario ();
    $cliente = new Cliente ();
    /*
     * POST
     */
    $escopo = filter_input(INPUT_POST, 'escopo', FILTER_SANITIZE_STRING);
    $idCliente = NULL !== filter_input(INPUT_POST, 'ic', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'ic', FILTER_SANITIZE_NUMBER_INT) : getIdCliente();
    /*
     * testa se eh um fornecedor
     */
    if (isFornecedor()) {
        $cliente->setId($idCliente);
        $idFornecedor = $cliente->getIdFornecedorByCliente() ['id_fornecedor'];
    } else {
        $idFornecedor = 0;
    }
    /*
     * variaveis
     */
    $idEmpresa = getIdEmpresa();
    $userEmail = getEmailUsuarioLogado();
    /*
     * consulta
     */
    $lista = array();
    $ret = $usuario->consultaValidador($idEmpresa, $idFornecedor, $userEmail, $escopo, $idCliente);
    /*
     * array
     */
    foreach ($ret as $linha) {
        $lista [] = array(
            'email_alternativo' => $linha ['email_alternativo'],
            'telefone_celular' => $linha ['telefone_celular'],
            'telefone_fixo' => $linha ['telefone_fixo'],
            'user_complete_name' => $linha ['user_complete_name'],
            'user_email' => $linha ['user_email'],
            'user_id' => $linha ['user_id'],
            'gravatar' => getGravatarImageUser(sha1($linha ['user_id']))
        );
    }
    /*
     * retorno
     */
    echo json_encode($lista);
} else {
    echo json_encode(array(
        'msg' => 'Acesso n&atilde;o autorizado!'
    ));
}