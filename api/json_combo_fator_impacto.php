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
    if (NULL !== filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT)) {
        $idRoteiro = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);
        $aplica = filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING);
        $operacao = filter_input(INPUT_POST, 'o', FILTER_SANITIZE_STRING);
        $tipo = NULL !== filter_input(INPUT_POST, 'tp', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'tp', FILTER_SANITIZE_STRING) : 0;
        $fa = new FatorImpacto();
        $ret = $fa->comboFatorImpacto($idRoteiro, $aplica, $operacao, $tipo);
        $res = array();
        $res[] = array(
            'id' => '0',
            'descricao' => 'Selecione um fator de impacto',
            'sigla' => 'Selecione um fator de impacto',
            'fator' => 0
        );
        foreach ($ret as $linha) {
            $res[] = array(
                'id' => $linha['id'] . ';' . $linha['fator'] . ';' . $linha['sigla'] . ';' . $linha['tipo'] . ';' . $linha['operador'],
                'descricao' => $linha['descricao'],
                'sigla' => $linha['sigla'],
                'fator' => $linha['fator']
            );
        }
    } else {
        $res[] = array(
            'id' => '0;0;ERRO - ID n&atilde;o definido!;0;0',
            'descricao' => 'Favor entrar em contato com o administrador',
            'sigla' => 'ERRO - ID n&atilde;o definido!',
            'fator' => 'ERRO - ID n&atilde;o definido!'
        );
    }
    echo json_encode($res);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}