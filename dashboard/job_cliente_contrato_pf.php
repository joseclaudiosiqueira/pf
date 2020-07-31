<?php

$dashboardClienteContratoPF = new DashboardClienteContratoPF();
// varre as empresas
foreach ($empresas as $empresa) {
    // monta o array com as descricoes e quantidades
    $linha = $dashboardClienteContratoPF->getSituacao($empresa['id']);
    $arData = array();
    $arData2 = array();
    $arLabel = array();
    $count = 0;
    foreach ($linha as $row) {
        $arLabel[] = $row['numero'] . ' [ ' . $row['ano'] . ' ]' . "\n\r" . $row['sigla'];
        $arData[] = $row['pf_contratado'];
        $arData2[] = number_format($row['qtd'], 2);
        $count ++;
        /*
         * lista apenas os nove maiores!
         */
        if ($count > 9) {
            break;
        }
    }
    // une os dois arrays
    $retorno = array(
        'data' => $arData,
        'labels' => $arLabel,
        'data2' => $arData2
    );
    // O parâmetro "a" indica que o arquivo será aberto para escrita
    $fp = fopen(DIR_APP . 'dashboard' . DIRECTORY_SEPARATOR . sha1($empresa['id']) . DIRECTORY_SEPARATOR . sha1(str_pad($empresa['id'], 11, '0', STR_PAD_LEFT)) . '.contrato.pf.json', 'wb+');
    // Escreve o conteúdo JSON no arquivo
    $escreve = fwrite($fp, json_encode($retorno));
    // Fecha o arquivo
    fclose($fp);
}
//varre os fornecedores
foreach ($fornecedores as $fornecedor) {
    // monta o array com as descricoes e quantidades
    $linha = $dashboardClienteContratoPF->getSituacaoFornecedor($fornecedor['id_empresa'], $fornecedor['id']);
    $arData = array();
    $arData2 = array();
    $arLabel = array();
    $count = 0;
    foreach ($linha as $row) {
        $arLabel[] = $row['numero'] . ' [ ' . $row['ano'] . ' ]' . "\n\r" . $row['sigla'];
        $arData[] = $row['pf_contratado'];
        $arData2[] = number_format($row['qtd'], 2);
        $count ++;
        /*
         * lista apenas os nove maiores!
         */
        if ($count > 9) {
            break;
        }
    }
    // une os dois arrays
    $retorno = array(
        'data' => $arData,
        'labels' => $arLabel,
        'data2' => $arData2
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
            . '.contrato.pf.json', 'wb+');
    // Escreve o conteúdo JSON no arquivo
    $escreve = fwrite($fp, json_encode($retorno));
    // Fecha o arquivo
    fclose($fp);
}