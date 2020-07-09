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
    $tbl = \NULL !== \filter_input(\INPUT_POST, 'tbl', \FILTER_SANITIZE_STRING) ? filter_input(\INPUT_POST, 'tbl', \FILTER_SANITIZE_STRING) : 0;
    $idContagem = \NULL !== \filter_input(\INPUT_POST, 'idc', FILTER_SANITIZE_NUMBER_INT) ? \filter_input(\INPUT_POST, 'idc', FILTER_SANITIZE_NUMBER_INT) : 0;
    $ret = array();
    if ($tbl && $idContagem) {
        switch ($t) {
            case 'ali':
            case 'aie': $fn = new FuncaoDados();
                break;
            case 'ee':
            case 'se':
            case 'ce': $fn = new FuncaoTransacao();
                break;
            case 'ou': $fn = new FuncaoOutros();
                break;
        }
        $fn->setTable($tbl);
        $funcao = filter_input(INPUT_POST, 'fun', FILTER_SANITIZE_STRING);
        $relacionamentos = $fn->consultaRelacionamentos($funcao);
        /*
         * situacao
         * 0 - inserida
         * 1 - nao validada
         * 2 - validada
         * 3 - revisao
         */
        echo json_encode($relacionamentos);
    }
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}