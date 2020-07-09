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
    if (NULL !== filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT)) {
        $idCliente = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);
        $tipo = filter_input(INPUT_POST, 't', FILTER_SANITIZE_NUMBER_INT);
        $isContagemAuditoria = NULL !== filter_input(INPUT_POST, 'a', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'a', FILTER_SANITIZE_NUMBER_INT) : 0;
        $fa = new Contrato();
        $ret = $fa->comboContrato($idCliente, $tipo, $isContagemAuditoria);
        echo json_encode($ret);
    }
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}	