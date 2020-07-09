<?php

require_once $_SERVER['DOCUMENT_ROOT'] . (substr($_SERVER['DOCUMENT_ROOT'], -1) === '/' ? '' : '/') . 'pf/conf/conf.php';
/*
 * verificacao padrao de login
 */
if ($login->isUserLoggedIn() && $id && verificaSessao()) {
    if (isset($_GET['l'])) {
        $isGestor = getVariavelSessao('isGestor');
        $isGestorFornecedor = getVariavelSessao('isGestorFornecedor');
        $isGerenteConta = getVariavelSessao('isGerenteConta');
        $isGerenteContaFornecedor = getVariavelSessao('isGerenteContaFornecedor');
        $isFornecedor = isFornecedor();
        if ($isGestor || $isGerenteConta || ($isFornecedor && ($isGestorFornecedor || $isGerenteContaFornecedor))) {
            $isVideo = FALSE;
            //TODO: verificar criptografia
            //$arq = $converter->decode($_GET['l']);
            $arq = $_GET['l'];
            //retorna com o arquivo
            downloadFile($arq, $isVideo);
        } else {
            require_once DIR_APP . 'nao_autorizado.php';
        }
    } else {
        //pega a url
        $get = NULL !== filter_input(INPUT_GET, 'a', FILTER_SANITIZE_STRING) ? filter_input(INPUT_GET, 'a', FILTER_SANITIZE_STRING) : '';
        //verifica se esta solicitanto um video
        $isVideo = isset($_GET['v']) ? TRUE : FALSE;
        //pega o caminho do arquivo
        $file = explode('/', $get);
        //separa os diretorios
        if (!$isVideo) {
            //TODO: verificar criptografia
            //$dir = $converter->decode($file[0]);
            //$con = $converter->decode($file[1]);
            $dir = $file[0];
            $con = $file[1];
        } else {
            //TODO: verificar criptografia
            //$fil = $converter->decode($file[0]);
            $fil = $file[0];
        }
        //verifica se esta pedindo uma imagem do thumbnail
        if (isset($file[3])) {
            $arq = ($isVideo ? DIR_VIDEO : DIR_FILE) . $dir . '/' . $con . '/' . $file[2] . '/' . $file[3];
        } else {
            $arq = $isVideo ? DIR_VIDEO . $fil : ($login->isUserLoggedIn() && verificaSessao() ? DIR_FILE . $dir . '/' . $con . '/' . $file[2] : '');
        }
        //retorna com o arquivo
        downloadFile($arq, $isVideo);
    }
} else {
    $urlAtual = $converter->encode(getURL());
    header("Location: /pf/index.php?url=$urlAtual");
}
