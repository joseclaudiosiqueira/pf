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
    /*
     * instancia da classe Contagem
     */
    $c = new Contagem();
    $c->setTable('contagem');
    //id da baseline selecionada na combobox
    $idBaseline = NULL !== filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT) : 0;
    //id da contagem atual
    $idContagem = NULL !== filter_input(INPUT_POST, 'ic', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'ic', FILTER_SANITIZE_NUMBER_INT) : 0;
    //id da baseline da contagem de projeto
    $idBaselineContagem = NULL !== filter_input(INPUT_POST, 'b', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'b', FILTER_SANITIZE_STRING) : 0;
    //tabela a ser pesquisada
    $tabela = NULL !== filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING) ? strtolower(filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING)) : 0;
    //abrangencia da contagem atual
    $abAtual = NULL !== filter_input(INPUT_POST, 'ab', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'ab', FILTER_SANITIZE_NUMBER_INT) : 0;
    //pesquisa as funcoes
    $funcoes = $c->getFuncaoBaselineLivre($tabela, $idBaseline, $idContagem, $idBaselineContagem, $abAtual);
    /*
     * retorna o json
     */
    echo json_encode($funcoes);
} else {
    json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}
