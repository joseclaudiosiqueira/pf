<?php

$dashboardBancoDados = new DashboardBancoDados();
/*
 * $empresas movido para o primeiro arquivo pois eh generico
 */
foreach ($empresas as $empresa) {
    // monta o array com as descricoes e quantidades
    $linha = $dashboardBancoDados->getSituacao($empresa['id']);
    $arData = array();
    $arLabel = array();
    $count = 0;
    foreach ($linha as $row) {
        $arLabel[] = $row['descricao'] . ' [ ' . $row['qtd'] . ' ] ';
        $arData[] = (int) $row['qtd'];
        $count ++;
        if ($count > 9) {
            break;
        }
    }
    // une os dois arrays
    $retorno = array(
        'data' => $arData,
        'labels' => $arLabel
    );
    // O parâmetro "a" indica que o arquivo será aberto para escrita
    $fp = fopen(DIR_APP . 'dashboard' . DIRECTORY_SEPARATOR . sha1($empresa['id']) . DIRECTORY_SEPARATOR . sha1(str_pad($empresa['id'], 11, '0', STR_PAD_LEFT)) . '.banco.dados.json', 'wb+');
    // Escreve o conteúdo JSON no arquivo
    $escreve = fwrite($fp, json_encode($retorno));
    // Fecha o arquivo
    fclose($fp);
}
/*
 * $fornecedores movido para o primeiro arquivo pois eh generico
 */
foreach ($fornecedores as $fornecedor){
    // monta o array com as descricoes e quantidades
    $linha = $dashboardBancoDados->getSituacaoFornecedor($fornecedor['id'], $fornecedor['id_empresa']);
    $arData = array();
    $arLabel = array();
    $count = 0;
    foreach ($linha as $row) {
        $arLabel[] = $row['descricao'] . ' [ ' . $row['qtd'] . ' ] ';
        $arData[] = (int) $row['qtd'];
        $count ++;
        if ($count > 9) {
            break;
        }
    }
    // une os dois arrays
    $retorno = array(
        'data' => $arData,
        'labels' => $arLabel
    );
    // O parâmetro "a" indica que o arquivo será aberto para escrita
    $fp = fopen(DIR_APP 
            . 'dashboard' 
            . DIRECTORY_SEPARATOR 
            . sha1($fornecedor['id_empresa']) 
            . DIRECTORY_SEPARATOR 
            . sha1($fornecedor['id'])
            . DIRECTORY_SEPARATOR
            . sha1($fornecedor['id']) 
            . '.banco.dados.json', 'wb+');
    // Escreve o conteúdo JSON no arquivo
    $escreve = fwrite($fp, json_encode($retorno));
    // Fecha o arquivo
    fclose($fp);    
}
