<?php

// consulta ao dashboard
$dashboardSituacaoFuncoes = new DashboardSituacaoFuncoes();
// varre as empresas
foreach ($empresas as $empresa) {
    $situacao = $dashboardSituacaoFuncoes->getSituacao($empresa['id']);
    $arSituacao = array(
        'data' => array(
            0,
            0,
        //0,
        //0
        ),
        'labels' => array(
            'Não validado',
            //'Validado',
            'Em revisão',
        //'Revisado'
        )
    );
    foreach ($situacao as $linha) {
        $arSituacao['data'][0] += $linha['naovalidado'];
        //$arSituacao['data'][1] += $linha['validado'];
        $arSituacao['data'][1] += $linha['emrevisao'];
        //$arSituacao['data'][3] += $linha['revisado'];
    }
    $arSituacao['labels'][0] = $arSituacao['labels'][0] . ' [ ' . $arSituacao['data'][0] . ' ] ';
    //$arSituacao['labels'][1] = $arSituacao['labels'][1] . ' [ ' . $arSituacao['data'][1] . ' ] ';
    $arSituacao['labels'][1] = $arSituacao['labels'][1] . ' [ ' . $arSituacao['data'][1] . ' ] ';
    //$arSituacao['labels'][3] = $arSituacao['labels'][3] . ' [ ' . $arSituacao['data'][3] . ' ] ';
    // Escreve o conteúdo JSON no arquivo
    $fp0 = fopen(DIR_APP . 'dashboard' . DIRECTORY_SEPARATOR . sha1($empresa['id']) . DIRECTORY_SEPARATOR . sha1(str_pad($empresa['id'], 11, '0', STR_PAD_LEFT)) . '.situacao.funcoes.json', 'wb+');
    $escreve0 = fwrite($fp0, json_encode($situacao));
    // Escreve o conteudo consolidado no arquivo
    $fp1 = fopen(DIR_APP . 'dashboard' . DIRECTORY_SEPARATOR . sha1($empresa['id']) . DIRECTORY_SEPARATOR . sha1(str_pad($empresa['id'], 11, '0', STR_PAD_LEFT)) . '.situacao.funcoes.consolidado.json', 'wb+');
    $escreve1 = fwrite($fp1, json_encode($arSituacao));
    // Fecha o arquivo
    fclose($fp0);
    fclose($fp1);
}
// varre os fornecedores
foreach ($fornecedores as $fornecedor) {
    $situacao = $dashboardSituacaoFuncoes->getSituacaoFornecedor($fornecedor['id_empresa'], $fornecedor['id']);
    $arSituacao = array(
        'data' => array(
            0,
            0,
        //0,
        //0
        ),
        'labels' => array(
            'Não validado',
            //'Validado',
            'Em revisão',
        //'Revisado'
        )
    );
    foreach ($situacao as $linha) {
        $arSituacao['data'][0] += $linha['naovalidado'];
        //$arSituacao['data'][1] += $linha['validado'];
        $arSituacao['data'][1] += $linha['emrevisao'];
        //$arSituacao['data'][3] += $linha['revisado'];
    }
    $arSituacao['labels'][0] = $arSituacao['labels'][0] . ' [ ' . $arSituacao['data'][0] . ' ] ';
    //$arSituacao['labels'][1] = $arSituacao['labels'][1] . ' [ ' . $arSituacao['data'][1] . ' ] ';
    $arSituacao['labels'][1] = $arSituacao['labels'][1] . ' [ ' . $arSituacao['data'][1] . ' ] ';
    //$arSituacao['labels'][3] = $arSituacao['labels'][3] . ' [ ' . $arSituacao['data'][3] . ' ] ';
    // Escreve o conteúdo JSON no arquivo
    $fp0 = fopen(DIR_APP
            . 'dashboard'
            . DIRECTORY_SEPARATOR
            . sha1($fornecedor['id_empresa'])
            . DIRECTORY_SEPARATOR
            . sha1($fornecedor['id'])
            . DIRECTORY_SEPARATOR
            . sha1($fornecedor['id']) . '.situacao.funcoes.json', 'wb+');
    $escreve0 = fwrite($fp0, json_encode($situacao));
    // Escreve o conteudo consolidado no arquivo
    $fp1 = fopen(DIR_APP
            . 'dashboard'
            . DIRECTORY_SEPARATOR
            . sha1($fornecedor['id_empresa'])
            . DIRECTORY_SEPARATOR
            . sha1($fornecedor['id'])
            . DIRECTORY_SEPARATOR
            . sha1($fornecedor['id']) . '.situacao.funcoes.consolidado.json', 'wb+');
    $escreve1 = fwrite($fp1, json_encode($arSituacao));
    // Fecha o arquivo
    fclose($fp0);
    fclose($fp1);
}