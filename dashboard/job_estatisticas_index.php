<?php

$dashboardValorContratoPF = new DashboardValorContratoPF();
// monta o array com as descricoes e quantidades
$valorContratoPF = $dashboardValorContratoPF->getValorContratoPF();
//percorrer e formar o array
$estadosBrasileiros = array(
    'AC' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'AL' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'AM' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'AP' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'BA' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'CE' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'DF' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'ES' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'GO' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'MA' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'MG' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'MS' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'MT' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'PA' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'PB' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'PE' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'PI' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'PR' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'RJ' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'RN' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'RO' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'RS' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'RR' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'SC' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'SE' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'SP' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)),
    'TO' => array('MIN' => 0.00, 'MAX' => 0.00, 'MED' => 0.00, 'QTD' => 0, array('LNG1' => '', 'QTD1' => 0.00, 'LNG2' => '', 'QTD2' => 0.00, 'LNG3' => '', 'QTD3' => 0.00, 'LNG4' => '', 'QTD4' => 0.00, 'LNG5' => '', 'QTD5' => 0)));

//tem que percorrer o array UF
foreach ($valorContratoPF as $linha) {
    $estadosBrasileiros[$linha['UF']]['MIN'] = number_format($linha['MIN'], 2, '.', '');
    $estadosBrasileiros[$linha['UF']]['MAX'] = number_format($linha['MAX'], 2, '.', '');
    $estadosBrasileiros[$linha['UF']]['MED'] = number_format($linha['AVG'], 2, '.', '');
    $estadosBrasileiros[$linha['UF']]['QTD'] = $linha['QTD'];
}
// O parâmetro "a" indica que o arquivo será aberto para escrita
$fp = fopen(DIR_APP . 'dashboard' . DIRECTORY_SEPARATOR . 'index' . DIRECTORY_SEPARATOR . 'valor.contrato.pf.json', 'wb+');
// Escreve o conteúdo JSON no arquivo
$escreve = fwrite($fp, json_encode($estadosBrasileiros));
// Fecha o arquivo
fclose($fp);
/*
SELECT
UPPER(ctr.uf), UPPER(bd.descricao), UPPER(lng.descricao), count(*) QTD
FROM
contagem cnt,
 contagem_config_banco_dados bd,
 contrato ctr,
 contagem_config_linguagem lng
WHERE
cnt.id_banco_dados = bd.id AND
cnt.id_contrato = ctr.id AND
cnt.id_linguagem = lng.id AND
cnt.id_abrangencia IN (1, 2, 7, 9, 10) AND
cnt.is_excluida = 0 AND
cnt.is_contagem_auditoria = 0
GROUP BY
bd.descricao, ctr.uf
ORDER BY
ctr.uf, bd.descricao, lng.descricao, qtd ASC
*/