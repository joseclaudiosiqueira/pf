<?php

$dashboardMetodoFuncoes = new DashboardMetodoFuncoes();
// varre as empresas
foreach ($empresas as $empresa) {
    $linha = $dashboardMetodoFuncoes->getMetodo($empresa['id']);
    $arMetodo = array(
        'data' => array(
            0,
            0,
            0
        ),
        'labels' => array(
            'NESMA',
            'FP-Lite',
            'Detalhada'
        )
    );
    foreach ($linha as $row) {
        switch ($row['id_metodo']) {
            case 1:
                $arMetodo['data'][0] += (int) $row['qtd'];
                break;
            case 2:
                $arMetodo['data'][1] += (int) $row['qtd'];
                break;
            case 3:
                $arMetodo['data'][2] += (int) $row['qtd'];
                break;
        }
    }
    // Tranforma o array $dados em JSON
    $dados_json = json_encode($arMetodo);
    // O parâmetro "a" indica que o arquivo será aberto para escrita
    $fp = fopen(DIR_APP . 'dashboard' . DIRECTORY_SEPARATOR . sha1($empresa['id']) . DIRECTORY_SEPARATOR . sha1(str_pad($empresa['id'], 11, '0', STR_PAD_LEFT)) . '.metodo.funcoes.json', 'wb+');
    // Escreve o conteúdo JSON no arquivo
    $escreve = fwrite($fp, $dados_json);
    // Fecha o arquivo
    fclose($fp);
}
// varre os fornecedores
foreach ($fornecedores as $fornecedor) {
    $linha = $dashboardMetodoFuncoes->getMetodoFornecedor($fornecedor['id_empresa'], $fornecedor['id']);
    $arMetodo = array(
        'data' => array(
            0,
            0,
            0
        ),
        'labels' => array(
            'NESMA',
            'FP-Lite',
            'Detalhada'
        )
    );
    foreach ($linha as $row) {
        switch ($row['id_metodo']) {
            case 1:
                $arMetodo['data'][0] += (int) $row['qtd'];
                break;
            case 2:
                $arMetodo['data'][1] += (int) $row['qtd'];
                break;
            case 3:
                $arMetodo['data'][2] += (int) $row['qtd'];
                break;
        }
    }
    // Tranforma o array $dados em JSON
    $dados_json = json_encode($arMetodo);
    // O parâmetro "a" indica que o arquivo será aberto para escrita
    $fp = fopen(DIR_APP
            . 'dashboard'
            . DIRECTORY_SEPARATOR
            . sha1($fornecedor['id_empresa'])
            . DIRECTORY_SEPARATOR
            . sha1($fornecedor['id'])
            . DIRECTORY_SEPARATOR
            . sha1($fornecedor['id']) . '.metodo.funcoes.json', 'wb+');
    // Escreve o conteúdo JSON no arquivo
    $escreve = fwrite($fp, $dados_json);
    // Fecha o arquivo
    fclose($fp);
}
