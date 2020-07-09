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
    $cliente = new Cliente ();
    /*
     * POST
     */
    $tipo = filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING); // ativos e inativos
    $funcionalidade = filter_input(INPUT_POST, 'e', FILTER_SANITIZE_STRING); // contagem ou geral
    $idCliente = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT); // se for contagem vem o id direto
    $idEmpresa = getIdEmpresa(); // generico, independente do fornecedor ou empresa
    /*
     * testa se vem de uma contagem
     */
    if ($funcionalidade === 'contagem') {
        $cliente->setId($idCliente);
        $idFornecedor = $cliente->getIdFornecedorByCliente() ['id_fornecedor'];
    } else {
        $idFornecedor = getIdFornecedor();
    }
    /*
     * retorno
     */
    $ret = $cliente->comboCliente($idEmpresa, $idFornecedor, $tipo, ($idCliente ? $idCliente : NULL));
    $res = array();
    if (count($ret) < 1) {
        $res [] = array(
            'id' => '0',
            'nome' => 'N&atilde;o h&aacute; clientes ativos',
            'sigla' => '',
            'descricao' => 'N&atilde;o h&aacute; clientes ativos'
        );
    } else {
        $res [] = array(
            'id' => '0',
            'nome' => 'Selecione um Cliente',
            'sigla' => '',
            'descricao' => 'Selecione um Cliente'
        );
        foreach ($ret as $linha) {
            $res [] = array(
                'id' => $linha ['id'],
                'nome' => $linha ['nome'],
                'sigla' => $linha ['sigla'],
                'descricao' => $linha ['descricao']
            );
        }
    }
    echo json_encode($res);
} else {
    echo json_encode(array(
        'msg' => 'Acesso n&atilde;o autorizado!'
    ));
}