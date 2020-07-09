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
     * retorna os roteiros associados a empresa
     */
    $fn = new Roteiro();
    $fornecedor = new Fornecedor();
    $cliente = new Cliente();
    $fn->setTable('roteiro');
    $idEmpresa = getIdEmpresa();
    
    $id = \NULL !== filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT) : 0;
    $tipo = filter_input(INPUT_POST, 't', FILTER_SANITIZE_NUMBER_INT);
    
    $arrRoteiros = array();
    /*
     * retorna para a montagem da tabela com a comboFatorImpacto porque esta funcao retorna todos os registros
     * da tabela fator_impacto, com todas as colunas //nao criei outra funcao pra isso
     * 
     * tipo $tipo - indica se e uma lista ou consulta id_fator_impacto
     * 0 = lista
     * 1 = unico
     */

    if ($tipo) {
        $linha = $fn->consulta($id);
        $arrRoteiros[] = array(
            'id' => $linha['id'],
            'descricao' => html_entity_decode($linha['descricao'], ENT_QUOTES),
            'observacoes' => html_entity_decode($linha['observacoes'], ENT_QUOTES),
            'is_ativo' => ($linha['is_ativo']) ? 'on' : 'off',
            'id_empresa' => $linha['id_empresa'],
            'id_fornecedor' => $linha['id_fornecedor'],
            'id_cliente' => $linha['id_cliente'],
            'tipo' => ($linha['tipo']) ? 'on' : 'off',
            'is_exclusivo' => ($linha['id_cliente'] > 0 || $linha['id_fornecedor'] > 0) ? 'on' : 'off',
            'roteiros_utilizacao' => $fn->getRoteirosUtilizacao($linha['id'])
        );
    } else {
        $ret = $fn->listaRoteiros($idEmpresa);
        foreach ($ret as $linha) {
            $arrRoteiros[] = array(
                'id' => $linha['id'],
                'descricao' => '[ ' . html_entity_decode($linha['descricao'], ENT_QUOTES) . ' ] ' . (($linha['id_cliente'] > 0) ? ' &gt; (C) ' . $cliente->getSigla($linha['id_cliente']) : '') . (($linha['id_fornecedor'] > 0) ? ' &gt (F) ' . $fornecedor->getSigla($linha['id_fornecedor']) : ''),
                'observacoes' => html_entity_decode($linha['observacoes'], ENT_QUOTES),
                'is_ativo' => ($linha['is_ativo']) ? 'on' : 'off',
                'id_empresa' => $linha['id_empresa'],
                'id_fornecedor' => $linha['id_fornecedor'],
                'id_cliente' => $linha['id_cliente'],
                'tipo' => ($linha['tipo']) ? 'on' : 'off',
                'id_roteiro_importado' => $linha['id_roteiro_importado'],
                'descricao_roteiro_importado' => ($linha['id_roteiro_importado']) ? $fn->getDescricao($linha['id_roteiro_importado'], 'roteiro') : 'N/A'
            );
        }
    }

    echo json_encode($arrRoteiros);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}
