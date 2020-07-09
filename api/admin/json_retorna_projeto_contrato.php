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
    /*
     * retorna os contratos associados ao cliente
     */
    $id = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);
    $tipo = filter_input(INPUT_POST, 't', FILTER_SANITIZE_NUMBER_INT); //0 = Lista, 1 = unico
    $fn = new Projeto();
    $fn->setTable('projeto');
    $arr = [];
    if ($tipo) {
        $linha = $fn->consulta($id);
        $arr[] = (array(
            'id' => $linha['id'],
            'isAtivo' => $linha['is_ativo'] == 1 ? 'on' : 'off',
            'dataInicio' => date_format(date_create($linha['data_inicio']), 'd/m/Y'),
            'dataFim' => date_format(date_create($linha['data_fim']), 'd/m/Y'),
            'descricao' => html_entity_decode($linha['descricao'], ENT_QUOTES),
            'idGerenteProjeto' => $linha['id_gerente_projeto']
        ));
    } else {
        $ret = $fn->listaProjeto($id);
        foreach ($ret as $linha) {
            $arr[] = (array(
                'id' => $linha['id'],
                'isAtivo' => $linha['is_ativo'] == 1 ? 'on' : 'off',
                'dataInicio' => date_format(date_create($linha['data_inicio']), 'd/m/Y'),
                'dataFim' => date_format(date_create($linha['data_fim']), 'd/m/Y'),
                'descricao' => html_entity_decode($linha['descricao'], ENT_QUOTES),
                'idGerenteProjeto' => $linha['id_gerente_projeto']
            ));
        }
    }
    echo json_encode($arr);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}

