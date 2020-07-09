<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verificacao do status do login
 */
/*
 * arquivo contendo o include de qual linguagem devera ser utilizada
 * o padrao eh pt-BR ... o arquivo referenciado esta em /pf/lang/pt-BR.inc.php
 * o sistema busca automaticament a linguagem default
 */

function defineLinguagem(){
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    $file = '/home/storage/a/12/20/pfdimension1/public_html/pf/lang/' . $lang . '.inc.php';
    if(!(file_exists($file))){
        $file = $file = '/home/storage/a/12/20/pfdimension1/public_html/pf/lang/en.inc.php';
    }
    return $file;
}

function __() {

    global $pfMensagens;
    
    $numargs = func_num_args();
    $args = func_get_args();
    $msg = $args[0];
    
    if (@array_key_exists($msg, $pfMensagens)){
        $string_with_percents = $pfMensagens[$msg];
    }
    else{
        return "N/A (???)";
    }

    $sprintf_argument = "\$translated_string = sprintf(\$string_with_percents";

    for ($i = 1; $i < $numargs; $i++) {
        $sprintf_argument .= ",  @htmlentities(\$args[$i], ENT_QUOTES)";
    }

    $sprintf_argument .= ");";

    eval($sprintf_argument);

    return $translated_string;
}