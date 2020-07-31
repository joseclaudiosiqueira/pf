<?php

$dashboardContagemSituacao = new DashboardContagemSituacao();
// varre as empresas
foreach ($empresas as $empresa) {
    $linha = $dashboardContagemSituacao->getProcesso($empresa['id']);
    // array com os processos no padrao RGraph
    $arProcesso = array(
        'data' => array(
            0,
            0,
            0,
            0,
            0,
            0,
            0,
            0
        ),
        'labels' => array(
            'Em elaboração',
            'Em validação interna',
            'Em validação externa',
            'Em auditoria interna',
            'Em auditoria externa',
            'Em faturamento',
            'Em revisão val. interna',
            'Em revisão val. externa'
        )
    );
    foreach ($linha as $row) {
        switch ($row['id']) {
            case 1:
                $arProcesso['data'][0] = (int) $row['qtd'];
                break;
            case 2:
                $arProcesso['data'][1] = (int) $row['qtd'];
                break;
            case 3:
                $arProcesso['data'][2] = (int) $row['qtd'];
                break;
            case 4:
                $arProcesso['data'][3] = (int) $row['qtd'];
                break;
            case 5:
                $arProcesso['data'][4] = (int) $row['qtd'];
                break;
            case 7:
                $arProcesso['data'][5] = (int) $row['qtd'];
                break;
            case 8:
                $arProcesso['data'][6] = (int) $row['qtd'];
                break;
            case 9:
                $arProcesso['data'][7] = (int) $row['qtd'];
                break;
        }
    }
    // O parâmetro "a" indica que o arquivo será aberto para escrita
    $fp = fopen(DIR_APP . 'dashboard' . DIRECTORY_SEPARATOR . sha1($empresa['id']) . DIRECTORY_SEPARATOR . sha1(str_pad($empresa['id'], 11, '0', STR_PAD_LEFT)) . '.contagem.situacao.json', 'wb+');
    // Escreve o conteúdo JSON no arquivo
    $escreve = fwrite($fp, json_encode($arProcesso));
    // Fecha o arquivo
    fclose($fp);
}
// varre os fornecedores
foreach ($fornecedores as $fornecedor) {
    $linha = $dashboardContagemSituacao->getProcessoFornecedor($fornecedor['id_empresa'], $fornecedor['id']);
    // array com os processos no padrao RGraph
    $arProcesso = array(
        'data' => array(
            0,
            0,
            0,
            0,
            0,
            0,
            0,
            0
        ),
        'labels' => array(
            'Em elaboração',
            'Em validação interna',
            'Em validação externa',
            'Em auditoria interna',
            'Em auditoria externa',
            'Em faturamento',
            'Em revisão val. interna',
            'Em revisão val. externa'
        )
    );
    foreach ($linha as $row) {
        switch ($row['id']) {
            case 1:
                $arProcesso['data'][0] = (int) $row['qtd'];
                break;
            case 2:
                $arProcesso['data'][1] = (int) $row['qtd'];
                break;
            case 3:
                $arProcesso['data'][2] = (int) $row['qtd'];
                break;
            case 4:
                $arProcesso['data'][3] = (int) $row['qtd'];
                break;
            case 5:
                $arProcesso['data'][4] = (int) $row['qtd'];
                break;
            case 7:
                $arProcesso['data'][5] = (int) $row['qtd'];
                break;
            case 8:
                $arProcesso['data'][6] = (int) $row['qtd'];
                break;
            case 9:
                $arProcesso['data'][7] = (int) $row['qtd'];
                break;
        }
    }
    // O parâmetro "a" indica que o arquivo será aberto para escrita
    $fp = fopen(DIR_APP
            . 'dashboard'
            . DIRECTORY_SEPARATOR
            . sha1($fornecedor['id_empresa'])
            . DIRECTORY_SEPARATOR
            . sha1($fornecedor['id'])
            . DIRECTORY_SEPARATOR
            . sha1($fornecedor['id']) . '.contagem.situacao.json', 'wb+');
    // Escreve o conteúdo JSON no arquivo
    $escreve = fwrite($fp, json_encode($arProcesso));
    // Fecha o arquivo
    fclose($fp);
}
