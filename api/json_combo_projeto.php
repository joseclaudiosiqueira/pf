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
        $id = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);
        $tipo = filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING);
        $fa = new Projeto();
        $fa->setTable('projeto');
        $ret = $fa->comboProjeto($id, $tipo);
        $res = array();
        $res[] = array(
            'id' => '0',
            'descricao' => 'Selecione um projeto...',
        );
        foreach ($ret as $linha) {
            $res[] = array(
                'id' => $linha['id'],
                'descricao' => $linha['descricao'],
            );
        }
        echo json_encode($res);
    }
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}