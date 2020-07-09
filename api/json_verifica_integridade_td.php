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
        /*
         * variaveis
         */
        $funcao = filter_input(INPUT_POST, 'fun', FILTER_SANITIZE_STRING);
        $id_contagem = filter_input(INPUT_POST, 'icn', FILTER_SANITIZE_NUMBER_INT);
        $tabela = strtolower(filter_input(INPUT_POST, 'tbl', FILTER_SANITIZE_STRING));
        $id_baseline = strtolower(filter_input(INPUT_POST, 'iba', FILTER_SANITIZE_NUMBER_INT));
        $tag = filter_input(INPUT_POST, 'tag', FILTER_SANITIZE_STRING);
        /*
         * classes
         */
        $c = new Contagem();
        /*
         * pega o id da contagem de baseline
         */
        $id_contagem_baseline = $c->getBaseline($id_baseline)['id'];
        /*
         * tabela de referencia
         */
        $fn = new FuncaoDados();
        /*
         * seta a tabela
         */
        $fn->setTable($tabela);
        /*
         * pega o id da funcao pelo nome
         */
        //TODO:!IMPORTANT: pegar o id da funcao e pesquisar suas referencias em outras baselines
        $id_funcao = $fn->getIdByDescricao($funcao, $id_contagem_baseline)['id'];
        //consulta as referencias
        $sql = "SELECT 'EE' tipo, ee.situacao, ee.id, ee.funcao, ee.fonte FROM ee ee WHERE ee.id_contagem = $id_contagem_baseline AND ((ee.descricao_ar LIKE '%ali.$funcao%' AND ee.descricao_td like '%ali.$funcao.$tag%') || (ee.descricao_ar LIKE '%aie.$funcao%' AND ee.descricao_td like '%aie.$funcao.$tag%')) AND is_ativo = 1 UNION "
                . "SELECT 'SE' tipo, se.situacao, se.id, se.funcao, se.fonte FROM se se WHERE se.id_contagem = $id_contagem_baseline AND ((se.descricao_ar LIKE '%ali.$funcao%' AND se.descricao_td like '%ali.$funcao.$tag%') || (se.descricao_ar LIKE '%aie.$funcao%' AND se.descricao_td like '%aie.$funcao.$tag%')) AND is_ativo = 1 UNION "
                . "SELECT 'CE' tipo, ce.situacao, ce.id, ce.funcao, ce.fonte FROM ce ce WHERE ce.id_contagem = $id_contagem_baseline AND ((ce.descricao_ar LIKE '%ali.$funcao%' AND ce.descricao_td like '%ali.$funcao.$tag%') || (ce.descricao_ar LIKE '%aie.$funcao%' AND ce.descricao_td like '%aie.$funcao.$tag%')) AND is_ativo = 1 UNION "
                . "SELECT 'AIE' tipo, aie.situacao, aie.id, aie.funcao, aie.fonte FROM aie aie, ali ali WHERE aie.id_relacionamento = ali.id AND ali.id = $id_funcao ORDER BY tipo ASC";
        echo json_encode($fn->consultaGenerica($sql));
    }
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}


    