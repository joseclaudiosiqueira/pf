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
     * instancia da classe Contrato
     */
    $fn = new FatorImpacto();
    $fn->setTable('fator_impacto');
    $fn->setLog();
    /*
     * atribui a acao INSERIR/ALTERAR a variavel acao
     */
    $acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);
    /*
     * pega o id do contrato mesmo que seja vazio
     */
    $id = NULL !== filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT) : 0;
    /*
     * seta os atributos da classe
     */
    $fn->setIsAtivo(filter_input(INPUT_POST, 'is_ativo'));
    $fn->setDescricao(filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS));
    $fn->setFator(filter_input(INPUT_POST, 'fator'));
    $fn->setFonte(filter_input(INPUT_POST, 'fonte', FILTER_SANITIZE_SPECIAL_CHARS));
    $fn->setIdRoteiro(filter_input(INPUT_POST, 'id_roteiro', FILTER_SANITIZE_NUMBER_INT));
    $fn->setOperacao(filter_input(INPUT_POST, 'operacao', FILTER_SANITIZE_STRING));
    $fn->setOperador(filter_input(INPUT_POST, 'operador', FILTER_SANITIZE_NUMBER_INT));
    $fn->setSigla(filter_input(INPUT_POST, 'sigla', FILTER_SANITIZE_SPECIAL_CHARS));
    $fn->setTipo(filter_input(INPUT_POST, 'tipo'));
    $fn->setAplica(filter_input(INPUT_POST, 'aplica'));

    /*
     * executa a acao solicitada pelo usuario e retorna o .JSON
     */
    switch ($acao) {
        case 'inserir': echo json_encode($fn->insere());
            break;
        case 'alterar': echo json_encode($fn->atualiza($id));
            break;
    }
} else {
    echo json_encode(array('id' => 0, 'msg' => 'Acesso n&atilde;o autorizado!'));
}