<?php
$dashboardContagemEtapa = new DashboardContagemEtapa();
// varre as empresas
foreach ($empresas as $empresa) {
    // monta o array com as descricoes e quantidades
    $linha = $dashboardContagemEtapa->getSituacao($empresa['id']);
    $arData = array();
    $arLabel = array();
    foreach ($linha as $row) {
        $arLabel[] = $row['descricao'] . ' [ ' . $row['qtd'] . ' ] ';
        $arData[] = (int) $row['qtd'];
    }
    // une os dois arrays
    $retorno = array(
        'data' => $arData,
        'labels' => $arLabel
    );
    // O parâmetro "a" indica que o arquivo será aberto para escrita
    $fp = fopen(DIR_APP . 'dashboard' . DIRECTORY_SEPARATOR . sha1($empresa['id']) . DIRECTORY_SEPARATOR . sha1(str_pad($empresa['id'], 11, '0', STR_PAD_LEFT)) . '.contagem.etapa.json', 'wb+');
    // Escreve o conteúdo JSON no arquivo
    $escreve = fwrite($fp, json_encode($retorno));
    // Fecha o arquivo
    fclose($fp);
}
// varre os fornecedores
foreach ($fornecedores as $fornecedor) {
    // monta o array com as descricoes e quantidades
    $linha = $dashboardContagemEtapa->getSituacaoFornecedor($fornecedor['id_empresa'], $fornecedor['id']);
    $arData = array();
    $arLabel = array();
    foreach ($linha as $row) {
        $arLabel[] = $row['descricao'] . ' [ ' . $row['qtd'] . ' ] ';
        $arData[] = (int) $row['qtd'];
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
            . '.contagem.etapa.json', 'wb+');
    // Escreve o conteúdo JSON no arquivo
    $escreve = fwrite($fp, json_encode($retorno));
    // Fecha o arquivo
    fclose($fp);
}