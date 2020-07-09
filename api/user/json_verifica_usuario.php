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
if ($login->isUserLoggedIn()) {
    $fn = new Registration();
    $acao = \filter_input(\INPUT_POST, 'a', \FILTER_SANITIZE_STRING);
    $user = \filter_input(INPUT_POST, 'u', \FILTER_SANITIZE_STRING);
    $opcao = \filter_input(INPUT_POST, 'o', \FILTER_SANITIZE_STRING);
    $tipo = NULL !== \filter_input(INPUT_POST, 'n', \FILTER_SANITIZE_STRING) ? \filter_input(INPUT_POST, 'n', \FILTER_SANITIZE_STRING) : 'old';
    $userId = NULL !== \filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT) ? \filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT) : 0;
    $arr = array();
    switch ($acao) {
        /*
         * nome
         */
        case 'n':
            /*
             * VERSAO 2.0 com validacao de CPF por alternativa
             */
            if ($opcao) {
                /*
                 * conferir pelo nome do usuario
                 */
                if (!preg_match('/^[a-z._\d]{2,64}$/i', $user)) {
                    $arr[] = array('erro' => 'O ID &uacute;nico do usu&aacute;rio &eacute; inv&aacute;lido.<br />Utilize letras de aA-zZ, n&uacute;meros de 0-9, ponto . ou underline _. Ex.: fulano.de.tal, fulano.tal, fulano_tal');
                } else {
                    $arr = $fn->verificaNomeUsuarioEmpresa($user);
                }
            } else {
                /*
                 * conferir pelo cpf
                 */
                if (!preg_match("/^[0-9]{11}$/", $user) || !(validaCPF($user))) {
                    $arr[] = array('erro' => 'O CPF do usu&aacute;rio &eacute; inv&aacute;lido.');
                } else {
                    $arr = $fn->verificaNomeUsuarioEmpresa($user);
                }
            }
            break;
        /*
         * email
         */
        case 'e': $arr = $fn->verificaEmailUsuario($user, $userId, getIdEmpresa(), isFornecedor() ? getIdFornecedor() : 0);
            break;
    }
    echo json_encode($arr);
} else {
    echo json_encode(array('sucesso' => false, 'msg' => 'Acesso n&atilde;o autorizado!'));
}
