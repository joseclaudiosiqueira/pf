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
$idFornecedor = getIdFornecedor();
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
    $fn = new Linguagem();
    $descricao = filter_input(INPUT_POST, 'd', FILTER_SANITIZE_STRING);
    $baixa = filter_input(INPUT_POST, 'b');
    $media = filter_input(INPUT_POST, 'm');
    $alta = filter_input(INPUT_POST, 'a');
    $sloc = filter_input(INPUT_POST, 's', FILTER_SANITIZE_NUMBER_INT);
    $isAtivo = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);
    $fatorTecnologia = filter_input(INPUT_POST, 'f');
    $isFT = filter_input(INPUT_POST, 't');
    $acao = filter_input(INPUT_POST, 'ac', FILTER_SANITIZE_STRING);
    $idLinguagem = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $tipo = 'N'; //S - Sugestao, N - Nativa do Dimension
    $status = '1';
    $idEmpresa = getIdEmpresa();
    $email = $_SESSION['user_email'];
    $dataCadastro = date('Y-m-d H:i:s');
    /*
     * seta as variaveis da classe
     */
    $fn->setDescricao($descricao);
    $fn->setBaixa($baixa);
    $fn->setMedia($media);
    $fn->setAlta($alta);
    $fn->setIsAtivo($isAtivo);
    $fn->setTipo($tipo);
    $fn->setSloc($sloc);
    $fn->setStatus($status);
    $fn->setFatorTecnologia($fatorTecnologia);
    $fn->setIsFT($isFT);
    $fn->setIdEmpresa($idEmpresa);
    $fn->setIdCliente($idCliente);
    $fn->setEmail($email);
    $fn->setDataCadastro($dataCadastro);
    $fn->setLog();
    /*
     * insere ou atualiza no banco e retorna um #ID
     */
    $id = $acao === 'i' ? $fn->insere() : $fn->atualiza($idLinguagem);
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
