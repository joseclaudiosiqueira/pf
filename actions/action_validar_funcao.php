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
if ($login->isUserLoggedIn() && verificaSessao()) {
    $t = NULL !== filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING) : 0;
    $a = NULL !== filter_input(INPUT_POST, 'a', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'a', FILTER_SANITIZE_STRING) : 0;
    $r = NULL !== filter_input(INPUT_POST, 'r', FILTER_SANITIZE_EMAIL) ? filter_input(INPUT_POST, 'r', FILTER_SANITIZE_EMAIL) : 0;
    $i = NULL !== filter_input(INPUT_POST, 'ic', FILTER_SANITIZE_NUMBER_INT) ?filter_input(INPUT_POST, 'ic', FILTER_SANITIZE_NUMBER_INT) : 0;
    $ret = array();

    if ($t && $a && $r && $i) {
        switch ($t) {
            case 'ali':
            case 'aie': $fn = new FuncaoDados();
                break;
            case 'ee':
            case 'se':
            case 'ce': $fn = new FuncaoTransacao();
                break;
            case 'ou': $fn = new FuncaoOutros();
                break;
        }
        $fn->setTable($t);
        $linhas = '';
        if (NULL !== filter_input(INPUT_POST, 'l')) {//parametro l => linhas que vem pra validacao, pode ser mais de uma
            for ($x = 0; $x < count($_POST['l']); $x++) {
                $linhas .= $_POST['l'][$x] . ',';
            }
            $linhas = substr($linhas, 0, strlen($linhas) - 1);
        }
        $linhas = explode(',', $linhas); //converte em um array para evitar erros com as virgulas
        $fn->setTable($t);
        $atu = ($a === 'validar') ? $fn->validarFuncao($linhas) : ($a === 'nvalidar' ? $fn->nValidarFuncao($linhas) : $fn->revisarFuncao($linhas, $r, $i));
        if ($atu) {
            $ret[] = array('msg' => 'sucesso', 'acao' => $a);
        } else {
            $ret[] = array('msg' => 'erro', 'acao' => $a);
        }
    }
    echo json_encode($ret);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!', 'acao' => NULL));
}
