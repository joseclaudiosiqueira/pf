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
    $id = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);
    $table = filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING);
    switch ($table) {
        case 'ALI':
        case 'AIE': $fn = new FuncaoDados();
            break;
        case 'EE':
        case 'SE':
        case 'CE': $fn = new FuncaoTransacao();
            break;
        case 'OU': $fn = new FuncaoOutros();
            break;
    }
    $fn->setTable($table);
    $idGerador = $fn->retornaIdGerador($id);
    echo json_encode($idGerador);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}