<?php
/*
 * insere o conf
 */
require_once $_SERVER['DOCUMENT_ROOT'] . (substr($_SERVER['DOCUMENT_ROOT'], -1) === '/' ? '' : '/') . 'pf/conf/conf.php';
/*
 * processa o login do usuario e variaveis GET/POST
 */
if ((isset($_POST['arq']) || isset($_GET['arq'])) && //qual arquivo esta sendo pedido 
        (isset($_POST['tch']) || isset($_GET['tch'])) && //tipo de chamada (form, api ...)
        (isset($_POST['sub']) || isset($_GET['sub'])) && //subdiretorio
        (isset($_POST['dlg']) || isset($_GET['dlg']))) { //com ou sem login
    /*
     * armazena o nome do subdiretorio
     */
    $file = '';
    /*
     * pega os POSTs/GETs e coloca nas variaveis
     */
    $uri = "http" . (isset($_SERVER['HTTPS']) ? (($_SERVER['HTTPS'] === "on") ? "s" : "") : "") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $arq = isset($_POST['arq']) ? filter_input(INPUT_POST, 'arq', FILTER_SANITIZE_NUMBER_INT) : (isset($_GET['arq']) ? filter_input(INPUT_GET, 'arq', FILTER_SANITIZE_NUMBER_INT) : 1024);
    $tch = isset($_POST['tch']) ? filter_input(INPUT_POST, 'tch', FILTER_SANITIZE_NUMBER_INT) : (isset($_GET['tch']) ? filter_input(INPUT_GET, 'tch', FILTER_SANITIZE_NUMBER_INT) : 1024);
    $sub = isset($_POST['sub']) ? filter_input(INPUT_POST, 'sub', FILTER_SANITIZE_STRING) : (isset($_GET['sub']) ? filter_input(INPUT_GET, 'sub', FILTER_SANITIZE_STRING) : 1024);
    $dlg = isset($_POST['dlg']) ? filter_input(INPUT_POST, 'dlg', FILTER_SANITIZE_STRING) : (isset($_GET['dlg']) ? filter_input(INPUT_GET, 'dlg', FILTER_SANITIZE_STRING) : 1024);
    /*
     * verifica o tipo de chamada para obter o nome do diretorio e do arquivo
     */
    if (isset($arrTipoChamada[$tch])) {
        switch ($tch) {
            case 0:
                $file = isset($arrActions[$arq]) ? $arrActions[$arq] : 'INV';
                break;
            case 1:
                $file = isset($arrApi[$arq]) ? $arrApi[$arq] : 'INV';
                break;
            case 2:
                $file = isset($arrFormulario[$arq]) ? $arrFormulario[$arq] : 'INV';
                break;
            case 3:
                $file = isset($arrRelatorios[$arq]) ? $arrRelatorios[$arq] : 'INV';
                break;
        }
    }
    /*
     * monta a url de chamada ao arquivo
     */
    $url = DIR_BASE . (isset($arrTipoChamada[$tch]) ? $arrTipoChamada[$tch] : 'INV' ) . '/'
            . (isset($arrSubdiretorio[$sub]) ? $arrSubdiretorio[$sub] . '/' : '')
            . str_replace('.', '_', $file)
            . '.php';
    /*
     * verifica se a chamada e valida
     */
    if (file_exists($url)) {
        require $url;
    } else {
        if ($tch === 2 | $tch === 3 || $tch === 4) {
            require 'nao_autorizado.php';
        } else {
            echo json_encode(array('sucesso' => FALSE, 'msg' => 'DIM.Gateway - Acesso não autorizado!'));
        }
    }
} else {
    require 'nao_autorizado.php';
}