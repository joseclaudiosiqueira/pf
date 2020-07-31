<?php

$dashboardContagemPFMes = new DashboardContagemPFMes();
// varre as empresas
foreach ($empresas as $empresa) {
    $linha = $dashboardContagemPFMes->getContagens($empresa['id']);
    // armazena antes para pegar o maior valor
    $data_pfa = array(
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0
    );
    $data_pfb = array(
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0
    );
    // varre as linhas e soma
    foreach ($linha as $row) {
        $data_pfa[0] += $row['PFA_JAN'];
        $data_pfa[1] += $row['PFA_FEV'];
        $data_pfa[2] += $row['PFA_MAR'];
        $data_pfa[3] += $row['PFA_ABR'];
        $data_pfa[4] += $row['PFA_MAI'];
        $data_pfa[5] += $row['PFA_JUN'];
        $data_pfa[6] += $row['PFA_JUL'];
        $data_pfa[7] += $row['PFA_AGO'];
        $data_pfa[8] += $row['PFA_SET'];
        $data_pfa[9] += $row['PFA_OUT'];
        $data_pfa[10] += $row['PFA_NOV'];
        $data_pfa[11] += $row['PFA_DEZ'];
        // pfb
        $data_pfb[0] += $row['PFB_JAN'];
        $data_pfb[1] += $row['PFB_FEV'];
        $data_pfb[2] += $row['PFB_MAR'];
        $data_pfb[3] += $row['PFB_ABR'];
        $data_pfb[4] += $row['PFB_MAI'];
        $data_pfb[5] += $row['PFB_JUN'];
        $data_pfb[6] += $row['PFB_JUL'];
        $data_pfb[7] += $row['PFB_AGO'];
        $data_pfb[8] += $row['PFB_SET'];
        $data_pfb[9] += $row['PFB_OUT'];
        $data_pfb[10] += $row['PFB_NOV'];
        $data_pfb[11] += $row['PFB_DEZ'];
    }
    $int_pfa = array_map(function ($value) {
        return (int) $value;
    }, $data_pfa);
    $int_pfb = array_map(function ($value) {
        return (int) $value;
    }, $data_pfb);
    // array json no padrao rgraph
    $meses = array(
        'data_pfa' => $int_pfa,
        'data_pfb' => $int_pfb,
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
        'max' => (int) max($data_pfb) + (max($data_pfb) * 15 / 100)
    );
    // Tranforma o array $dados em JSON
    $dados_json = json_encode($meses);
    // O parâmetro "a" indica que o arquivo será aberto para escrita
    $fp = fopen(DIR_APP . 'dashboard' . DIRECTORY_SEPARATOR . sha1($empresa['id']) . DIRECTORY_SEPARATOR . sha1(str_pad($empresa['id'], 11, '0', STR_PAD_LEFT)) . '.' . date('Y') . '.contagens.pf.mes.json', 'wb+');
    // Escreve o conteúdo JSON no arquivo
    $escreve = fwrite($fp, $dados_json);
    // Fecha o arquivo
    fclose($fp);
}
// varre os fornecedores
foreach ($fornecedores as $fornecedor) {
    $linha = $dashboardContagemPFMes->getContagensFornecedor($fornecedor['id_empresa'], $fornecedor['id']);
    // armazena antes para pegar o maior valor
    $data_pfa = array(
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0
    );
    $data_pfb = array(
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0
    );
    // varre as linhas e soma
    foreach ($linha as $row) {
        $data_pfa[0] += $row['PFA_JAN'];
        $data_pfa[1] += $row['PFA_FEV'];
        $data_pfa[2] += $row['PFA_MAR'];
        $data_pfa[3] += $row['PFA_ABR'];
        $data_pfa[4] += $row['PFA_MAI'];
        $data_pfa[5] += $row['PFA_JUN'];
        $data_pfa[6] += $row['PFA_JUL'];
        $data_pfa[7] += $row['PFA_AGO'];
        $data_pfa[8] += $row['PFA_SET'];
        $data_pfa[9] += $row['PFA_OUT'];
        $data_pfa[10] += $row['PFA_NOV'];
        $data_pfa[11] += $row['PFA_DEZ'];
        // pfb
        $data_pfb[0] += $row['PFB_JAN'];
        $data_pfb[1] += $row['PFB_FEV'];
        $data_pfb[2] += $row['PFB_MAR'];
        $data_pfb[3] += $row['PFB_ABR'];
        $data_pfb[4] += $row['PFB_MAI'];
        $data_pfb[5] += $row['PFB_JUN'];
        $data_pfb[6] += $row['PFB_JUL'];
        $data_pfb[7] += $row['PFB_AGO'];
        $data_pfb[8] += $row['PFB_SET'];
        $data_pfb[9] += $row['PFB_OUT'];
        $data_pfb[10] += $row['PFB_NOV'];
        $data_pfb[11] += $row['PFB_DEZ'];
    }
    $int_pfa = array_map(function ($value) {
        return (int) $value;
    }, $data_pfa);
    $int_pfb = array_map(function ($value) {
        return (int) $value;
    }, $data_pfb);
    // array json no padrao rgraph
    $meses = array(
        'data_pfa' => $int_pfa,
        'data_pfb' => $int_pfb,
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
        'max' => (int) max($data_pfb) + (max($data_pfb) * 15 / 100)
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
            . sha1($fornecedor['id']) . '.' . date('Y') . '.contagens.pf.mes.json', 'wb+');
    // Escreve o conteúdo JSON no arquivo
    $escreve = fwrite($fp, $dados_json);
    // Fecha o arquivo
    fclose($fp);
}

