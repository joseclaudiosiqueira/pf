<?php

$dashboardContagemMes = new DashboardContagemMes();
// varre as empresas
foreach ($empresas as $empresa) {
    $linha = $dashboardContagemMes->getContagens($empresa['id']);
    // armazena antes para pegar o maior valor
    $data = array(
        (int) $linha['JAN'],
        (int) $linha['FEV'],
        (int) $linha['MAR'],
        (int) $linha['ABR'],
        (int) $linha['MAI'],
        (int) $linha['JUN'],
        (int) $linha['JUL'],
        (int) $linha['AGO'],
        (int) $linha['SET'],
        (int) $linha['OUT'],
        (int) $linha['NOV'],
        (int) $linha['DEZ']
    );
    // array json no padrao rgraph
    $meses = array(
        'data' => $data,
        'labels' => array(
            'JAN',
            'FEV',
            'MAR',
            'ABR',
            'MAI',
            'JUN',
            'JUL',
            'AGO',
            'SET',
            'OUT',
            'NOV',
            'DEZ'
        ),
        'max' => (int) max($data) + (max($data) * 15 / 100)
    );
    // Tranforma o array $dados em JSON
    $dados_json = json_encode($meses);
    // O parâmetro "a" indica que o arquivo será aberto para escrita
    $fp = fopen(DIR_APP . 'dashboard' . DIRECTORY_SEPARATOR . sha1($empresa['id']) . DIRECTORY_SEPARATOR . sha1(str_pad($empresa['id'], 11, '0', STR_PAD_LEFT)) . '.' . date('Y') . '.contagens.mes.json', 'wb+');
    // Escreve o conteúdo JSON no arquivo
    $escreve = fwrite($fp, $dados_json);
    // Fecha o arquivo
    fclose($fp);
}
// varre os fornecedores
foreach ($fornecedores as $fornecedor) {
    $linha = $dashboardContagemMes->getContagensFornecedor($fornecedor['id_empresa'], $fornecedor['id']);
    // armazena antes para pegar o maior valor
    $data = array(
        (int) $linha['JAN'],
        (int) $linha['FEV'],
        (int) $linha['MAR'],
        (int) $linha['ABR'],
        (int) $linha['MAI'],
        (int) $linha['JUN'],
        (int) $linha['JUL'],
        (int) $linha['AGO'],
        (int) $linha['SET'],
        (int) $linha['OUT'],
        (int) $linha['NOV'],
        (int) $linha['DEZ']
    );
    // array json no padrao rgraph
    $meses = array(
        'data' => $data,
        'labels' => array(
            'JAN',
            'FEV',
            'MAR',
            'ABR',
            'MAI',
            'JUN',
            'JUL',
            'AGO',
            'SET',
            'OUT',
            'NOV',
            'DEZ'
        ),
        'max' => (int) max($data) + (max($data) * 15 / 100)
    );
    // Tranforma o array $dados em JSON
    $dados_json = json_encode($meses);
    // O parâmetro "a" indica que o arquivo será aberto para escrita
    $fp = fopen(DIR_APP
            . 'dashboard'
            . DIRECTORY_SEPARATOR
            . sha1($fornecedor['id_empresa'])
            . DIRECTORY_SEPARATOR
            . sha1($fornecedor['id'])
            . DIRECTORY_SEPARATOR
            . sha1($fornecedor['id'])
            . '.' . date('Y') . '.contagens.mes.json', 'wb+');
    // Escreve o conteúdo JSON no arquivo
    $escreve = fwrite($fp, $dados_json);
    // Fecha o arquivo
    fclose($fp);
}
