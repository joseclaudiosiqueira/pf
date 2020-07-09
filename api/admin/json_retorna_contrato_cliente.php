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
    $fn = new Contrato();
    $fn->setTable('contrato');
    $arr = [];

    if ($tipo) {
        $linha = $fn->consulta($id);
        $arr[] = (array(
            'id' => $linha['id'],
            'numero' => $linha['numero'],
            'ano' => $linha['ano'],
            'uf' => $linha['uf'],
            'dataInicio' => date_format(date_create($linha['data_inicio']), 'd/m/Y'),
            'dataFim' => date_format(date_create($linha['data_fim']), 'd/m/Y'),
            'tipo' => $linha['tipo'] === 'I' ? 'on' : 'off',
            'isAtivo' => $linha['is_ativo'] == 1 ? 'on' : 'off',
            'PFContratado' => $linha['pf_contratado'],
            'valorPF' => number_format($linha['valor_pf'], 2, '.', ''),
            'valorHpc' => number_format($linha['valor_hpc'], 2, '.', ''),
            'valorHpa' => number_format($linha['valor_hpa'], 2, '.', ''),
            'idPrimario' => $fn->getIdPrimario($linha['id_primario'])['id']));
    } else {
        $ret = $fn->listaContrato($id);
        foreach ($ret as $linha) {
            $arr[] = (array(
                'id' => $linha['id'],
                'anoNumero' => $linha['numero'] . '/' . $linha['ano'] . '/' . strtoupper($linha['uf']),
                'dataInicio' => date_format(date_create($linha['data_inicio']), 'd/m/Y'),
                'dataFim' => date_format(date_create($linha['data_fim']), 'd/m/Y'),
                'tipo' => $linha['tipo'] === 'I' ? 'Inicial' : 'Aditivo ( ' . $fn->getIdPrimario($linha['id_primario'])['numero'] . ' )',
                'isAtivo' => $linha['is_ativo'] == 1 ? 'Ativo' : 'Inativo',
                'valorPF' => number_format($linha['valor_pf'], 2, ",", "."),
                'valorHpc' => number_format($linha['valor_hpc'], 2, ",", "."),
                'valorHpa' => number_format($linha['valor_hpa'], 2, ",", ".")));
        }
    }
    echo json_encode($arr);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}
