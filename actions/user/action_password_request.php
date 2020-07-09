<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * require do conf
 */
require_once $_SERVER['DOCUMENT_ROOT'] . (substr($_SERVER['DOCUMENT_ROOT'], -1) === '/' ? '' : '/') . 'pf/conf/conf.php';

$user_name = NULL !== filter_input(INPUT_POST, 'user-name', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'user-name', FILTER_SANITIZE_STRING) : '';
$user_email = NULL !== filter_input(INPUT_POST, 'user-email', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'user-email', FILTER_SANITIZE_STRING) : '';

$ret = [];

if ($user_name !== '' && filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
    if ($login->setPasswordResetDatabaseTokenAndSendMail($user_name, $user_email)) {
        $ret[] = array('id' => 1, 'msg' => 'Sua solicita&ccedil;&atilde;o foi executada com sucesso. Por favor, verifique sua caixa de entrada ou em span, caso seu email n&atilde;o esteja apto a receber mensagens de @pfdimension.com.br, e siga as instru&ccedil;&otilde;es.');
    } else {
        $ret[] = array('id' => 0, 'msg' => 'BD::N&atilde;o foi poss&iacute;vel processar sua solicita&ccedil;&atilde;o, por favor entre em contato com o <a href="mailto:suporte@pfdimension.com.br"><i class="fa fa-envelope"></i>&nbsp;suporte</a> do sistema.');
    }
} else {
    $ret[] = array('id' => 0, 'msg' => 'MSG::N&atilde;o foi poss&iacute;vel processar sua solicita&ccedil;&atilde;o, por favor entre em contato com o <a href="mailto:suporte@pfdimension.com.br"><i class="fa fa-envelope"></i>&nbsp;suporte</a> do sistema.');
}

echo json_encode($ret);

