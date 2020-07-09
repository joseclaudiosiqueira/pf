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
     * INSTANCIA AS CLASSES
     */
    $fn = new BancoDados();
    $fn->setTable('banco_dados');
    $descricao = $_POST['d'];
    $isAtivo = '1';
    $tipo = 'S'; //S - Sugestao, N - Nativa do Dimension
    $status = '1';
    $email = $_SESSION['user_email'];
    $dataCadastro = date('Y-m-d H:i:s');
    /*
     * seta as variaveis da classe
     */
    $fn->setDescricao($descricao);
    $fn->setIsAtivo($isAtivo);
    $fn->setTipo($tipo);
    $fn->setStatus($status);
    $fn->setIdEmpresa(getIdEmpresa());
    $fn->setEmail($email);
    $fn->setDataCadastro($dataCadastro);
    /*
     * insere no banco e retorna um #ID
     */
    $id = $fn->insere();
    /*
     * converte o $ID em um array json
     */
    $ret[] = array(
        'id' => $id);
    /*
     * retorna com o json para a pagina chamadora
     */
    echo json_encode($ret);
} else {
    echo json_encode(array('id' => 0, 'msg' => 'Acesso n&atilde;o autorizado!'));
}
