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
    $itens = new FatorImpacto();
    $itens->setTable('fator_impacto');
    $idRoteiro = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);
    $like = filter_input(INPUT_POST, 'l', FILTER_SANITIZE_STRING);
    echo json_encode($itens->listaFatorImpacto($idRoteiro, $like));
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}