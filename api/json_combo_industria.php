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
    $fn = new Industria();
    $fn->setTable('industria');
    $tipo = NULL !== filter_input(INPUT_POST, 't') ? filter_input(INPUT_POST, 't') : 1;
    $ret = $fn->comboIndustria($tipo);
    $res = array();
    foreach ($ret as $linha) {
        $res[] = array(
            'id' => $linha['id'],
            'descricao' => $linha['descricao'],
            'status' => $linha['is_ativo']
        );
    }
    echo json_encode($res);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}