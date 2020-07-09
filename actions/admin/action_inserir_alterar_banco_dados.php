<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verifica o id do cliente
 */
$idCliente = NULL !== filter_input(INPUT_POST, 'icl', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'icl', FILTER_SANITIZE_NUMBER_INT) : 0;
/*
 * verifica se o cliente pertence a empresa/fornecedor
 */
$idEmpresa = getIdEmpresa();
$validaCliente = FALSE;
if ($idCliente) {
    $cliente = new Cliente();
    $cliente->setId($idCliente);
    $cliente->setIdEmpresa($idEmpresa);
    $cliente->setIdFornecedor($idFornecedor);
    $validaCliente = $cliente->validaIDCliente();
}
/*
 * verificacao do status do login e permissao
 */
$isGestor = getVariavelSessao('isGestor');
$isAdministrador = getVariavelSessao('isAdministrador');
/*
 * passa pela validacao
 */
if ($login->isUserLoggedIn() && ($isGestor || $isAdministrador) && verificaSessao() && $idCliente && $validaCliente) {
    $fn = new BancoDados();
    $descricao = filter_input(INPUT_POST, 'd', FILTER_SANITIZE_STRING);
    $isAtivo = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);
    $acao = filter_input(INPUT_POST, 'ac', FILTER_SANITIZE_STRING);
    $idBancoDados = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $tipo = 'N'; //S - Sugestao, N - Nativa do Dimension
    $status = '1';
    $idEmpresa = getIdEmpresa();
    $email = getEmailUsuarioLogado();
    $dataCadastro = date('Y-m-d H:i:s');
    /*
     * seta as variaveis da classe
     */
    $fn->setDescricao($descricao);
    $fn->setIsAtivo($isAtivo);
    $fn->setTipo($tipo);
    $fn->setStatus($status);
    $fn->setEmail($email);
    $fn->setIdEmpresa($idEmpresa);
    $fn->setIdCliente($idCliente);
    $fn->setDataCadastro($dataCadastro);
    /*
     * insere ou atualiza no banco e retorna um #ID
     */
    $id = $acao === 'i' ? $fn->insere() : $fn->atualiza($idBancoDados);
    /*
     * converte o $ID em um array json
     */
    $ret[] = array(
        'id' => $id, 'sucesso' => TRUE);
    /*
     * retorna com o json para a pagina chamadora
     */
    echo json_encode($ret);
} else {
    echo json_encode(array('id' => 0, 'msg' => 'Acesso n&atilde;o autorizado!'));
}
