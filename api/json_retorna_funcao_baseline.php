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
    $idBaseline = NULL !== filter_input(INPUT_POST, 'idBaseline', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'idBaseline', FILTER_SANITIZE_NUMBER_INT) : 0;
    $tabela = NULL !== filter_input(INPUT_POST, 'tabela', FILTER_SANITIZE_STRING) ? strtolower(filter_input(INPUT_POST, 'tabela', FILTER_SANITIZE_STRING)) : 0;
    $idContagemBaseline = $c->getBaseline($idBaseline)['id'];
    $idContagem = NULL !== filter_input(INPUT_POST, 'idContagem', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'idContagem', FILTER_SANITIZE_NUMBER_INT) : 0;
    $abAtual = NULL !== filter_input(INPUT_POST, 'abAtual', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'abAtual', FILTER_SANITIZE_NUMBER_INT) : 0;
    if ($idBaseline && $tabela && $idContagemBaseline) {
        if ($tabela === 'aie') {
            //muda o NULL na pesquisa da funcao para o idBaseline
            $funcoes = $c->getFuncaoBaselineProjeto($tabela, $idBaseline, $idContagem, $idContagemBaseline, $abAtual);
        } else {
            $funcoes = $c->getFuncaoBaseLine($tabela, $idBaseline, $idContagemBaseline, $idContagem);
        }
        //retorna
        echo json_encode($funcoes);
    } else {
        echo json_encode("");
    }
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}