<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verifica login
 */
if ($login->isUserLoggedIn() && verificaSessao()) {
    $c = new Contagem();
    $c->setTable('contagem');
    $idBaseline = NULL !== filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT) ?
            filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT) : 0;
    $tabela = NULL !== filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING) ?
            strtolower(filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING)) : 0;
    $idContagemBaseline = filter_input(INPUT_POST, 'i1', FILTER_SANITIZE_NUMBER_INT) ?
            strtolower(filter_input(INPUT_POST, 'i1', FILTER_SANITIZE_NUMBER_INT)) : 0;
    $idContagemAtual = NULL !== filter_input(INPUT_POST,'ic', FILTER_SANITIZE_NUMBER_INT) ? 
            filter_input(INPUT_POST,'ic', FILTER_SANITIZE_NUMBER_INT) : 0;
    //pesquisa
    $funcoes = $c->getFuncaoBaseLine($tabela, $idBaseline, $idContagemBaseline, $idContagemAtual);
    //retorna
    echo json_encode($funcoes);
} else {
    json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}
