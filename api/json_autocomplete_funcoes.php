<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
$tipo = filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING);
/*
 * verifica login
 */
if ($login->isUserLoggedIn() && verificaSessao() && $tipo) {
    switch ($tipo) {
        case 'ali':
        case 'aie':
            $fn = new FuncaoDados();
            break;
        case 'ee':
        case 'se':
        case 'ce':
            $fn = new FuncaoTransacao();
            break;
    }
    echo json_encode($fn->getArquivos($tipo, getIdEmpresa()));
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}