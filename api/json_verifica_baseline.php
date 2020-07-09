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
    $idBaseline = NULL !== filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT) : 0;
    $c = new Contagem();
    $b = new Baseline();
    //pega o id da contagem de baseline
    $id = $c->getBaseline($idBaseline);
    //pega a sigla da baseline
    $ib = $b->getSigla($idBaseline);
    //junta os dois arrays
    $merge = array_merge($id ? $id : array('id' => 0), $ib);
    //retorna o array com a baseline
    echo json_encode($merge);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}