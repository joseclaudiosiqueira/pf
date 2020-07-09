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
        $id_contagem = filter_input(INPUT_POST, 'idc', FILTER_SANITIZE_NUMBER_INT);
        $id_baseline = strtolower(filter_input(INPUT_POST, 'idb', FILTER_SANITIZE_NUMBER_INT));
        $idEmpresa = getIdEmpresa();
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
         * vai pelo like no ali.<funcao>
         * primeiro para uma contagem normal e depois se for baseline/projeto
         */
        $sql = "SELECT 'EE' tipo, con.responsavel, "
                . "CASE con.id_abrangencia "
                . " WHEN 1 THEN 'LIVRE' "
                . " WHEN 2 THEN 'PROJETO' "
                . " WHEN 3 THEN 'BASELINE' "
                . " WHEN 4 THEN 'LICITACAO' "
                . " WHEN 5 THEN 'SNAP' "
                . " WHEN 6 THEN 'PONTOS DE TESTE' "
                . " WHEN 7 THEN 'INDICATIVA' "
                . " WHEN 9 THEN 'ELEMENTOS FUNCIONAIS' "
                . "END AS abrangencia, "
                . "ee.situacao, ee.id, ee.funcao, ee.fonte FROM ee ee, contagem con "
                . "WHERE ee.descricao_ar LIKE '%ali.$funcao%' AND "
                . "ee.is_ativo = 1 AND "
                . "ee.id_contagem = con.id AND "
                . "con.id_empresa = $idEmpresa UNION "
                . "SELECT 'SE' tipo, con.responsavel, "
                . "CASE con.id_abrangencia "
                . " WHEN 1 THEN 'LIVRE' "
                . " WHEN 2 THEN 'PROJETO' "
                . " WHEN 3 THEN 'BASELINE' "
                . " WHEN 4 THEN 'LICITACAO' "
                . " WHEN 5 THEN 'SNAP' "
                . " WHEN 6 THEN 'PONTOS DE TESTE' "
                . " WHEN 7 THEN 'INDICATIVA' "
                . " WHEN 9 THEN 'ELEMENTOS FUNCIONAIS' "
                . "END AS abrangencia, "
                . "se.situacao, se.id, se.funcao, se.fonte FROM se se, contagem con "
                . "WHERE se.descricao_ar LIKE '%ali.$funcao%' AND "
                . "se.is_ativo = 1 AND "
                . "se.id_contagem = con.id AND "
                . "con.id_empresa = $idEmpresa UNION "
                . "SELECT 'CE' tipo, con.responsavel, "
                . "CASE con.id_abrangencia "
                . " WHEN 1 THEN 'LIVRE' "
                . " WHEN 2 THEN 'PROJETO' "
                . " WHEN 3 THEN 'BASELINE' "
                . " WHEN 4 THEN 'LICITACAO' "
                . " WHEN 5 THEN 'SNAP' "
                . " WHEN 6 THEN 'PONTOS DE TESTE' "
                . " WHEN 7 THEN 'INDICATIVA' "
                . " WHEN 9 THEN 'ELEMENTOS FUNCIONAIS' "
                . "END AS abrangencia, "
                . "ce.situacao, ce.id, ce.funcao, ce.fonte FROM ce ce, contagem con "
                . "WHERE ce.descricao_ar LIKE '%ali.$funcao%' AND "
                . "ce.is_ativo = 1 AND "
                . "ce.id_contagem = con.id AND "
                . "con.id_empresa = $idEmpresa";
        echo json_encode($fn->consultaGenerica($sql));
    }
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}