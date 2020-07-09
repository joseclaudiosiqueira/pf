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
    if (NULL !== filter_input(INPUT_POST, 'fun', FILTER_SANITIZE_STRING)) {
        //variaveis
        $funcao = filter_input(INPUT_POST, 'fun', FILTER_SANITIZE_STRING);
        $id_contagem = filter_input(INPUT_POST, 'icn', FILTER_SANITIZE_NUMBER_INT);
        $tabela = strtolower(filter_input(INPUT_POST, 'tbl', FILTER_SANITIZE_STRING));
        $id_baseline = strtolower(filter_input(INPUT_POST, 'iba', FILTER_SANITIZE_NUMBER_INT));
        //classes
        $c = new Contagem();
        $c->setTable('contagem');
        //pega o id da contagem de baseline
        $id_contagem_baseline = $c->getBaseline($id_baseline)['id'];
        //tabela de referencia
        $fn = $tabela === 'ali' || $tabela === 'aie' ? new FuncaoDados() : new FuncaoTransacao();
        $fn->setTable($tabela);
        //consulta o id da funcao
        $id_funcao = $fn->getIdByDescricao($funcao, $id_contagem_baseline)['id'];
        $funcoes_baseline = $fn->consulta($id_funcao);
        //coleta eventuais funcoes inseridas em projeto ainda nao validadas
        $sql = "SELECT tbl.* FROM $tabela tbl, contagem con WHERE con.id = tbl.id_contagem AND con.id_baseline = :id AND funcao = '$funcao'";
        $funcoes_projeto = $fn->consulta($id_baseline, true, $sql);
        //junta os arrays
        $retorno = array_merge($funcoes_baseline ? $funcoes_baseline : array(), $funcoes_projeto ? $funcoes_projeto : array());
        //consulta a funcao
        echo json_encode($retorno);
    }
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}


    