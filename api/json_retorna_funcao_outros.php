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
    if (NULL !== filter_input(INPUT_POST, 'i')) {
        //tabela de referencia
        $table = strtolower(filter_input(INPUT_POST, 'b', FILTER_SANITIZE_STRING));
        $fn = new FuncaoOutros();
        $aj = new FatorImpacto();
        $cn = new Contagem();
        $cn->setTable($table);
        $fn->setTable($table);
        $id = filter_input(INPUT_POST, 'i');
        $linha = $fn->consulta($id);
        $ret = array();
        $valorImpacto = $aj->consultaFatorImpacto($linha['impacto']);
        $selectImpacto = $valorImpacto['id'] . ';' . $valorImpacto['fator'] . ';' . $valorImpacto['sigla'] . ';' . $valorImpacto['tipo'] . ';' . $valorImpacto['operador']; //VALOR PARA A CAIXA DE SELECAO ID,AJUSTE,SIGLA
        $idContagem = 0; //para baseline e licitacao
        //pega o ID da contagem original que gerou a linha, no caso de baseline e licitacao
        if ($linha['id_gerador'] > 0) {
            $idContagem = $cn->getIdByFuncao($linha['id_gerador'])['id_contagem'];
            ;
        }
        $ret[] = array(
            'id' => $linha['id'],
            'id_roteiro' => $linha['id_roteiro'],
            'operacao' => $linha['operacao'],
            'funcao' => html_entity_decode($linha['funcao'], ENT_QUOTES),
            'qtd' => $linha['qtd'],
            'pfa' => $linha['pfa'],
            'impacto' => $linha['impacto'],
            'selImpacto' => $selectImpacto, //valor para a caixa de selecao ID;Impacto;Sigla
            'obs_funcao' => html_entity_decode($linha['obs_funcao'], ENT_QUOTES),
            'obs_validar' => html_entity_decode($linha['obs_validar'], ENT_QUOTES),
            'fonte' => html_entity_decode($linha['fonte'], ENT_QUOTES),
            'situacao' => $linha['situacao'], //$fn->isValidadaInternamente($id) ? '2' : '1',
            'entrega' => $linha['entrega'],
            'idBaseline' => $linha['id_baseline'],
            'idGerador' => $linha['id_gerador'],
            'idContagem' => $idContagem
        );
        echo json_encode($ret);
    }
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}