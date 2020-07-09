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
    $t = \NULL !== \filter_input(\INPUT_POST, 't', \FILTER_SANITIZE_STRING) ? filter_input(\INPUT_POST, 't', \FILTER_SANITIZE_STRING) : 0;
    $ret = array();
    if ($t) {
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
        $fn->setTable($t);
        $id = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);
        /*
         * situacao
         * 0 - inserida
         * 1 - nao validada
         * 2 - validada
         * 3 - revisao
         */
        echo json_encode($fn->isValidadaInternamente($id));
    }
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}