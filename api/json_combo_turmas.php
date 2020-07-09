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
    $idEmpresa = getIdEmpresa();
    $tipo = filter_input(INPUT_POST, 't');
    //$fa = new Turma(); TODO: verificar
    $fa->setTable('turma');
    $ret = $fa->comboTurma($idEmpresa, $tipo);
    $res = array();
    if (count($ret) < 1) {
        $res[] = array(
            'id' => '0',
            'nome' => 'N&atilde;o h&aacute; turmas ativas',
            'sigla' => ''
        );
    } else {
        $res[] = array(
            'id' => '0',
            'nome' => 'Turma...',
            'sigla' => ''
        );
        foreach ($ret as $linha) {
            $res[] = array(
                'id' => $linha['id'],
                'nome' => $linha['nome'],
                'sigla' => $linha['sigla']
            );
        }
    }
    echo json_encode($res);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}