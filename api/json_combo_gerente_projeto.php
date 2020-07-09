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
    $fn = new Usuario();
    $ret = $fn->comboGerenteProjeto(getIdEmpresa());
    $res = array();
    $res[] = array(
        'user_id' => '0',
        'complete_name' => 'Selecione um gerente',
    );
    foreach ($ret as $linha) {
        $res[] = array(
            'user_id' => $linha['user_id'],
            'user_complete_name' => $linha['complete_name'],
        );
    }
    echo json_encode($res);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}