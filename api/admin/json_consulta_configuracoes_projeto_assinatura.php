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
    $fn = new ClienteConfigProjetoAssinatura();
    $fn->setTable('cliente_config_projeto_assinatura');
    $id = filter_input(INPUT_POST, 'i');
    echo json_encode($fn->getConfig($id));
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}