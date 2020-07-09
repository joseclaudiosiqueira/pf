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
     * retorna os fatores de impacto do roteiro selecionado
     */
    $id = \NULL !== filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT) : 0;
    $tipoConsulta = \NULL !== filter_input(INPUT_POST, 'tc', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'tc', FILTER_SANITIZE_NUMBER_INT) : 0;
    $tipo = \NULL !== filter_input(INPUT_POST, 't', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 't', FILTER_SANITIZE_NUMBER_INT) : 0;
    $fn = new FatorImpacto();
    $fr = new Roteiro();
    /*
     * verifica o id da empresa na tabela roteiro, se for zero, desabilita a alteracao dos itens
     */
    $idEmpresa = $fr->getIdEmpresa($id);
    /*
     * variaveis do json
     */
    $aplica = 0;
    $operacao = 0;
    $arr = [];
    /*
     * retorna para a montagem da tabela com a comboFatorImpacto porque esta funcao retorna todos os registros
     * da tabela fator_impacto, com todas as colunas //nao criei outra funcao pra isso
     * 
     * tipo $tipoConsulta - indica se e uma lista ou consulta id_fator_impacto
     * 0 = lista
     * 1 = unico
     * 
     */
    if ($tipoConsulta) {
        $linha = $fn->consulta($id);
        $arr[] = (array(
            'id' => $linha['id'],
            'isAtivo' => $linha['is_ativo'] ? 'on' : 'off',
            'descricao' => html_entity_decode($linha['descricao'], ENT_QUOTES),
            'fator' => number_format($linha['fator'], 3),
            'fonte' => html_entity_decode($linha['fonte'], ENT_QUOTES),
            'operacao' => $linha['operacao'],
            'operador' => $linha['operador'],
            'sigla' => html_entity_decode($linha['sigla'], ENT_QUOTES),
            'tipo' => $linha['tipo'],
            'aplica' => $linha['aplica'],
            'idEmpresa' => $idEmpresa
        ));
    } else {
        $ret = $fn->comboFatorImpacto($id, $aplica, $operacao, $tipo);
        foreach ($ret as $linha) {
            $arr[] = (array(
                'id' => $linha['id'],
                'isAtivo' => $linha['is_ativo'] ? 'on' : 'off',
                'descricao' => html_entity_decode($linha['descricao'], ENT_QUOTES),
                'fator' => number_format($linha['fator'], 3),
                'fonte' => html_entity_decode($linha['fonte'], ENT_QUOTES),
                'operacao' => $linha['operacao'],
                'operador' => $linha['operador'],
                'sigla' => html_entity_decode($linha['sigla'], ENT_QUOTES),
                'tipo' => $linha['tipo'],
                'aplica' => $linha['aplica'],
                'idEmpresa' => $idEmpresa
            ));
        }
    }

    echo json_encode($arr);
} else {
    $arr[] = (array(
        'id' => null,
        'isAtivo' => 'off',
        'descricao' => 'Acesso não autorizado',
        'fator' => null,
        'fonte' => null,
        'operacao' => null,
        'operador' => null,
        'sigla' => null,
        'tipo' => null,
        'aplica' => null,
        'idEmpresa' => null
    ));
    echo json_encode($arr);
}
