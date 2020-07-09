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
    $idSistema = filter_input(INPUT_POST, 'idSistema', FILTER_SANITIZE_NUMBER_INT);
    $moduloSistema = new ModuloSistema();
    $moduloSistema->setId($idSistema);
    $comboModuloSistema = $moduloSistema->comboModuloSistema();
    $resposta = array();
    $resposta[] = array(
        'id' => '0',
        'descricao' => '...',
    );
    foreach ($retorno as $linha) {
        $resposta[] = array(
            'id' => $linha['id'],
            'descricao' => $linha['descricao']
        );
    }
    echo json_encode($resposta);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}