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
     * instancia da classe Projeto
     */
    $fn = new Roteiro();
    $fn->setTable('roteiro');
    $fn->setLog();
    /*
     * atribui a acao INSERIR/ALTERAR a variavel acao
     */
    $acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);
    /*
     * pega o id do roteiro mesmo que seja vazio
     */
    $idRoteiro = NULL !== filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT) : 0;
    $idEmpresa = getIdEmpresa();

    $fn->setIdRoteiro($idRoteiro);
    $fn->setDescricao(filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS));
    $fn->setObservacoes(filter_input(INPUT_POST, 'observacoes', FILTER_SANITIZE_SPECIAL_CHARS));
    $fn->setIsAtivo(filter_input(INPUT_POST, 'is_ativo', FILTER_SANITIZE_NUMBER_INT));
    $fn->setIdEmpresa($idEmpresa);
    $fn->setIdFornecedor(filter_input(INPUT_POST, 'id_fornecedor', FILTER_SANITIZE_NUMBER_INT));
    $fn->setIdCliente(filter_input(INPUT_POST, 'id_cliente', FILTER_SANITIZE_NUMBER_INT));
    $fn->setTipo(filter_input(INPUT_POST, 'is_compartilhado', FILTER_SANITIZE_NUMBER_INT));
    $fn->setIdRoteiroImportado(filter_input(INPUT_POST, 'id_roteiro_importado', FILTER_SANITIZE_NUMBER_INT));
    /*
     * executa a acao solicitada pelo usuario e retorna o .JSON
     */
    switch ($acao) {
        case 'inserir':
            $insere = $fn->insere();
            echo json_encode(array('msg' => 'O roteiro foi inserido com sucesso', 'id' => $insere));
            break;
        case 'alterar':
            $atualiza = $fn->atualiza($idRoteiro);
            echo json_encode(array('msg' => 'O roteiro foi atualizado com sucesso', 'id' => $atualiza));
            break;
    }
} else {
    echo json_encode(array('id' => 0, 'msg' => 'Acesso n&atilde;o autorizado!'));
}