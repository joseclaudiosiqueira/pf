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
    $tp = filter_input(INPUT_POST, 'tp');
    $fa = new Fornecedor();
    $ret = $fa->comboFornecedor($idEmpresa, $tipo, $tp);
    $res = array();
    if (count($ret) < 1) {
        $res[] = array(
            'id' => '0',
            'nome' => ($tp ? 'N&atilde;o h&aacute; turmas' : 'N&atilde;o h&aacute; fornecedores'),
            'sigla' => '',
            'is_ativo' => ''
        );
        //(isFornecedor() ? 'N&atilde;o permitido...' : ($tp ? 'N&atilde;o h&aacute; turmas cadastradas' : 'N&atilde;o h&aacute; fornecedores cadastrados'))
    } else {
        $res[] = array(
            'id' => '0',
            'nome' => ($tp ? 'Turma...' : 'Fornecedor...'),
            'sigla' => '',
            'is_ativo' => ''
        );
        //(isFornecedor() ? 'N&atilde;o permitido...' : ($tp ? (getConfigContagem('is_visualizar_contagem_turma') ? 'Selecione uma turma' : 'N&atilde;o permitido...' ) : 'Selecione um Fornecedor'))
        foreach ($ret as $linha) {
            $res[] = array(
                'id' => $linha['id'],
                'nome' => $linha['nome'],
                'sigla' => $linha['sigla'],
                'is_ativo' => $linha['is_ativo']
            );
        }
    }
    echo json_encode($res);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}