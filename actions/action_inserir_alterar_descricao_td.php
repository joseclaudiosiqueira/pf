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
     * instancia da classe Cliente e a classe ClienteConfigRelatorio
     */
    $fn = new ContagemDescricaoTD();
    $fn->setLog();

    $fn->setTable('contagem_descricao_td');
    /*
     * atribui a acao INSERIR/ALTERAR a variavel acao
     */
    $acao = NULL !== filter_input(INPUT_POST, 'a', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'a', FILTER_SANITIZE_STRING) : 'inserir';
    /*
     * pega o id mesmo que seja vazio
     */
    $id = NULL !== filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT) : 0;
    $idPrimario = NULL !== filter_input(INPUT_POST, 'ip', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'ip', FILTER_SANITIZE_NUMBER_INT) : 0;
    $idDescricao = NULL !== filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT) : 0;
    $descricao = NULL !== filter_input(INPUT_POST, 'd', FILTER_SANITIZE_SPECIAL_CHARS) ? filter_input(INPUT_POST, 'd', FILTER_SANITIZE_SPECIAL_CHARS) : '';
    $funcao = NULL !== filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING) : '-';
    /*
     * seta os atributos da classe
     */
    $fn->setIdPrimario($idPrimario);
    $fn->setFuncao($funcao);
    $fn->setDescricao($descricao);
    /*
     * executa a acao solicitada pelo usuario e retorna o .JSON
     */
    switch ($acao) {
        case 'inserir':
            $id = $fn->insere();
            echo json_encode(array('id' => $id));
            break;
        case 'alterar':
            echo json_encode($fn->atualiza($idDescricao));
            break;
        case 'excluir':
            echo json_encode($fn->exclui($idDescricao));
            break;
    }
} else {
    echo json_encode(array('id' => 0, 'msg' => 'Acesso n&atilde;o autorizado!'));
}


