<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
$user_name = NULL !== filter_input(INPUT_POST, 'user-name', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'user-name', FILTER_SANITIZE_STRING) : '';
$user_password_old = NULL !== filter_input(INPUT_POST, 'user-password-old') ? filter_input(INPUT_POST, 'user-password-old') : '';
$user_password_new = NULL !== filter_input(INPUT_POST, 'user-password-new') ? filter_input(INPUT_POST, 'user-password-new') : '';
$user_password_repeat = NULL !== filter_input(INPUT_POST, 'user-password-repeat') ? filter_input(INPUT_POST, 'user-password-repeat') : '';
$ret = [];
if ($user_name !== '' && $user_password_old !== '' && $user_password_new !== '' && $user_password_repeat !== '') {
    if ($login->editUserPassword($user_name, $user_password_old, $user_password_new, $user_password_repeat)) {
        $ret[] = array('id' => 1, 'msg' => 'Sua solicita&ccedil;&atilde;o foi executada com sucesso. Por favor, fa&ccedil;a login novamente.');
    } else {
        $ret[] = array('id' => 0, 'msg' => 'N&atilde;o foi poss&iacute;vel processar sua solicita&ccedil;&atilde;o. Verifique seu nome de usu&aacute;rio e senha antiga e caso esteja tudo correto tente novamente, em &uacute;ltimo caso, por favor entre em contato com o <a href="mailto:suporte@pfdimension.com.br"><i class="fa fa-envelope"></i>&nbsp;suporte</a> do sistema.');
    }
} else {
    $ret[] = array('id' => 0, 'msg' => 'N&atilde;o foi poss&iacute;vel processar sua solicita&ccedil;&atilde;o, por favor entre em contato com o <a href="mailto:suporte@pfdimension.com.br"><i class="fa fa-envelope"></i>&nbsp;suporte</a> do sistema.');
}
echo json_encode($ret);

