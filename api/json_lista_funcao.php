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
     * i = id_contagem, f = funcao (dados/transacao), t = tabela (ali, aie, etc);
     */
    $funcao = filter_input(INPUT_POST, 'f');
    $tabela = filter_input(INPUT_POST, 't');
    $id = filter_input(INPUT_POST, 'i');
    $ordem = filter_input(INPUT_POST, 'o');
    $tipo = filter_input(INPUT_POST, 'tpo');
    $res = array();
    $email = getEmailUsuarioLogado();
    switch ($funcao) {
        case 'dados':
            $fn = new FuncaoDados();
            $fn->setTable($tabela);
            $ret = $fn->listaFuncao($id, $tabela, $ordem, $tipo);
            foreach ($ret as $linha) {
                $res[] = array(
                    'id' => $linha['id'],
                    'tabela' => $tabela,
                    'operacao' => $linha['operacao'],
                    'funcao' => html_entity_decode($linha['funcao'], ENT_QUOTES),
                    'td' => $linha['td'],
                    'tr' => $linha['tr'],
                    'complexidade' => $linha['complexidade'],
                    'pfb' => number_format($linha['pfb'], 3),
                    'siglaFator' => $fn->siglaFator('fator_impacto', $linha['impacto']),
                    'pfa' => number_format($linha['pfa'], 3),
                    'obsFuncao' => html_entity_decode($linha['obs_funcao'], ENT_QUOTES),
                    'situacao' => $linha['situacao'],
                    'entrega' => $linha['entrega'],
                    'lido' => $linha['lido'],
                    'nLido' => $linha['nLido'],
                    'isMudanca' => $linha['is_mudanca'] ? true : false,
                    'faseMudanca' => $linha['fase_mudanca'],
                    'percentualFase' => $linha['percentual_fase'],
                    'fd' => $linha['fd'],
                    'fe' => $linha['fe'],
                    'isCrud' => isset($linha['is_crud']) ? $linha['is_crud'] : 0);
            }
            break;
        case 'transacao':
            $fn = new FuncaoTransacao();
            $fn->setTable($tabela);
            $ret = $fn->listaFuncao($id, $tabela, $ordem, $tipo);
            $situacao = $fn->isValidadaInternamente($id);
            foreach ($ret as $linha) {
                $res[] = array(
                    'id' => $linha['id'],
                    'tabela' => $tabela,
                    'operacao' => $linha['operacao'],
                    'funcao' => html_entity_decode($linha['funcao'], ENT_QUOTES),
                    'td' => $linha['td'],
                    'ar' => $linha['ar'],
                    'complexidade' => $linha['complexidade'],
                    'pfb' => number_format($linha['pfb'], 3),
                    'siglaFator' => $fn->siglaFator('fator_impacto', $linha['impacto']),
                    'pfa' => number_format($linha['pfa'], 3),
                    'obsFuncao' => html_entity_decode($linha['obs_funcao'], ENT_QUOTES),
                    'situacao' => $linha['situacao'],
                    'entrega' => $linha['entrega'],
                    'lido' => $linha['lido'],
                    'nLido' => $linha['nLido'],
                    'isMudanca' => $linha['is_mudanca'] ? true : false,
                    'faseMudanca' => $linha['fase_mudanca'],
                    'percentualFase' => $linha['percentual_fase'],
                    'fd' => $linha['fd'],
                    'isCrud' => isset($linha['is_crud']) ? $linha['is_crud'] : 0);
            }
            break;
        case 'outros':
            $fn = new FuncaoOutros();
            $fn->setTable($tabela);
            $ret = $fn->listaFuncao($id, $tabela);
            $situacao = $fn->isValidadaInternamente($id);
            foreach ($ret as $linha) {
                $res[] = array(
                    'id' => $linha['id'],
                    'tabela' => $tabela,
                    'operacao' => $linha['operacao'],
                    'funcao' => html_entity_decode($linha['funcao'], ENT_QUOTES),
                    'qtd' => $linha['qtd'],
                    'siglaFator' => $fn->siglaFator('fator_impacto', $linha['impacto']),
                    'pfa' => number_format($linha['pfa'], 3),
                    'obsFuncao' => html_entity_decode($linha['obs_funcao'], ENT_QUOTES),
                    'situacao' => $linha['situacao'],
                    'entrega' => $linha['entrega'],
                    'lido' => $linha['lido'],
                    'nLido' => $linha['nLido']);
            }
            break;
    }
    echo json_encode($res);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}