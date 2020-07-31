<?php

// consulta ao dashboard
$dashboardComplexidadeFuncoes = new DashboardComplexidadeFuncoes();
// varre as empresas
foreach ($empresas as $empresa) {
    $linha = $dashboardComplexidadeFuncoes->getComplexidade($empresa['id']);
    $arComplexidade = array(
        'data' => array(
            0,
            0,
            0,
            0
        ),
        'labels' => array(
            'Baixa',
            'Média',
            'Alta',
            'EF (d/t)'
        )
    );
    foreach ($linha as $row) {
        switch ($row['complexidade']) {
            case 'Baixa':
                $arComplexidade['data'][0] = (int) $row['qtd'];
                break;
            case 'Media':
                $arComplexidade['data'][1] = (int) $row['qtd'];
                break;
            case 'Alta':
                $arComplexidade['data'][2] = (int) $row['qtd'];
                break;
            case 'EFd':
            case 'EFt':
                $arComplexidade['data'][3] = (int) $row['qtd'];
                break;
        }
    }
    // Tranforma o array $dados em JSON
    $dados_json = json_encode($arComplexidade);
    // O parâmetro "a" indica que o arquivo será aberto para escrita
    // cada empresa em seu diretorio especifico
    // o primeiro sha1 e somente o id da empresa e o segundo sha1 tem o pad com zeros a equerda
    $fp = fopen(DIR_APP . 'dashboard' . DIRECTORY_SEPARATOR . sha1($empresa['id']) . DIRECTORY_SEPARATOR . sha1(str_pad($empresa['id'], 11, '0', STR_PAD_LEFT)) . '.complexidade.funcoes.json', 'wb+');
    // Escreve o conteúdo JSON no arquivo
    $escreve = fwrite($fp, $dados_json);
    // Fecha o arquivo
    fclose($fp);
}
// varre os fornecedores
foreach ($fornecedores as $fornecedor) {
    $linha = $dashboardComplexidadeFuncoes->getComplexidadeFornecedor($fornecedor['id_empresa'], $fornecedor['id']);
    $arComplexidade = array(
        'data' => array(
            0,
            0,
            0,
            0
        ),
        'labels' => array(
            'Baixa',
            'Média',
            'Alta',
            'EF (d/t)'
        )
    );
    foreach ($linha as $row) {
        switch ($row['complexidade']) {
            case 'Baixa':
                $arComplexidade['data'][0] = (int) $row['qtd'];
                break;
            case 'Media':
                $arComplexidade['data'][1] = (int) $row['qtd'];
                break;
            case 'Alta':
                $arComplexidade['data'][2] = (int) $row['qtd'];
                break;
            case 'EFd':
            case 'EFt':
                $arComplexidade['data'][3] = (int) $row['qtd'];
                break;
        }
    }
    // Tranforma o array $dados em JSON
    $dados_json = json_encode($arComplexidade);
    // O parâmetro "a" indica que o arquivo será aberto para escrita
    // cada empresa em seu diretorio especifico
    // o primeiro sha1 e somente o id da empresa e o segundo sha1 tem o pad com zeros a equerda
    $fp = fopen(DIR_APP
            . 'dashboard'
            . DIRECTORY_SEPARATOR
            . sha1($fornecedor['id_empresa'])
            . DIRECTORY_SEPARATOR
            . sha1($fornecedor['id'])
            . DIRECTORY_SEPARATOR
            . sha1($fornecedor['id']) . '.complexidade.funcoes.json', 'wb+');
    // Escreve o conteúdo JSON no arquivo
    $escreve = fwrite($fp, $dados_json);
    // Fecha o arquivo
    fclose($fp);
}