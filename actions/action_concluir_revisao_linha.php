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

    $table = filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING);
    $id = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);

    switch ($table) {
        case 'ALI':
        case 'AIE': $fn = new FuncaoDados();
            break;
        case 'SE':
        case 'CE':
        case 'EE': $fn = new FuncaoTransacao();
            break;
        case 'OU': $fn = new FuncaoOutros();
            break;
    }

    $fn->setTable(strtolower($table));

    $ret = array('sucesso' => $fn->concluirRevisaoLinha($id));

    echo json_encode($ret);
} else {
    echo json_encode(array('sucesso' => false, 'msg' => 'Acesso n&atilde;o autorizado!'));
}
