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
    if (NULL !== filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING)) {
        $tipo = filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING);
        /*
         * verifica informacoes de fornecedores
         */
        $fornecedor = new Fornecedor();
        $idFornecedor = isFornecedor() ? getIdFornecedor() : NULL;
        $isTurma = $fornecedor->getTipo($idFornecedor);
        /*
         * seleciona apenas os projetos adequados ao perfil
         */
        $fa = new Projeto();
        $ret = $fa->comboProjetoBaseline($tipo, $idFornecedor);
        $res = array();
        $res[] = array(
            'id' => '0',
            'descricao' => 'Selecione um projeto...',
        );
        foreach ($ret as $linha) {
            /*
             * verificar se eh uma turma ou um fornecedor normal
             */
            $tipoFornecedor = $fornecedor->getTipo($linha['id_fornecedor']);
            /*
             * pega todos que sao fornecedores e empresa sem inserir as turmas
             */
            if ($isTurma) {
                $res[] = array(
                    'id' => $linha['id'],
                    'descricao' => $linha['descricao']
                );
            } elseif (!$tipoFornecedor) {
                $res[] = array(
                    'id' => $linha['id'],
                    'descricao' => $linha['descricao']
                );
            }
        }
        echo json_encode($res);
    }
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}