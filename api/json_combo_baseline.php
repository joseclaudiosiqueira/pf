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
    $t = filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING);
    $i = NULL !== filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT) : NULL;
    $a = NULL !== filter_input(INPUT_POST, 'a', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'a', FILTER_SANITIZE_NUMBER_INT) : 0;
    $isDashboad = NULL !== filter_input(INPUT_POST, 'isDashboard', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'isDashboard', FILTER_SANITIZE_NUMBER_INT) : 0;
    $idCliente = filter_input(INPUT_POST, 'icl', FILTER_SANITIZE_NUMBER_INT);

    $fa = new Baseline();
    $fa->setIdEmpresa(getIdEmpresa());
    $fa->setIdCliente($idCliente);

    echo json_encode($fa->comboBaseline($t, $i, $a, $isDashboad)); // $a = abAtual -> se for projeto, mostra tambem a baseline do projeto
} else {
    echo json_encode(array(
        'msg' => 'Acesso n&atilde;o autorizado!'
    ));
}