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
    $tipo = isset($_POST['t']) ? $_POST['t'] : 1;
    $fa = new ProcessoGestao();
    $fa->setTable('processo_gestao');
    $ret = $fa->comboProcessoGestao($tipo);
    $res = array();
    $res[] = array(
        'id' => '0',
        'descricao' => '...'
    );
    foreach ($ret as $linha) {
        $res[] = array(
            'id' => $linha['id'],
            'descricao' => $linha['descricao']
        );
    }
    echo json_encode($res);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}