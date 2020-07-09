<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verifica login
 */
if ($login->isUserLoggedIn() && verificaSessao()) {
    $fn = new Linguagem();
    $fn->setTable('contagem_config_linguagem');
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $ret = $fn->verificaProdutividade($id); //verifica o Fator Tecnologia tambem
    $res = array();
    $res[] = array(
        'produtividadeMedia' => $ret['media'],
        'produtividadeBaixa' => $ret['baixa'],
        'produtividadeAlta' => $ret['alta'],
        'variacao' => ''
        . 'Baixa: ' . $ret['baixa'] . ', '
        . 'Média: ' . $ret['media'] . ', '
        . 'Alta: ' . $ret['alta'] . ' - FT: ' . number_format($ret['fator_tecnologia'], 2, ',', '.'),
        'sloc' => $ret['sloc'],
        'ft' => $ret['fator_tecnologia']
    );
    echo json_encode($res);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}