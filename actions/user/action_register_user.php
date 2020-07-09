<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
$fn = new Registration();
$user_id = NULL !== filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_STRING) : 0;
$user_password = NULL !== filter_input(INPUT_POST, 'user_password', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'user_password', FILTER_SANITIZE_STRING) : '';
$user_activation_hash = NULL !== filter_input(INPUT_POST, 'user_activation_hash', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'user_activation_hash', FILTER_SANITIZE_STRING) : '';
$ret = [];
if($user_id !== '' && $user_password !== '' && $user_activation_hash !== ''){
    //UTILIZAR A FUNCAO verifyNewUser ou trocar a funcao para registerNewUser
    if($fn->verifyNewUser($user_id, $user_password, $user_activation_hash)){
        $ret[] = array('success'=>true, 'msg'=>'Sua solicita&ccedil;&atilde;o foi executada com sucesso, seu login est&aacute; ativo.');
    }
    else{
        $ret[] = array('success'=>false, 'msg'=>'N&atilde;o foi poss&iacute;vel processar sua solicita&ccedil;&atilde;o. Verifique seu nome de usu&aacute;rio e senha antiga e caso esteja tudo correto tente novamente, em &uacute;ltimo caso, por favor entre em contato com o <a href="mailto:suporte@pfdimension.com.br"><i class="fa fa-envelope"></i>&nbsp;suporte</a> do sistema.');
    }
}
else{
    $ret[] = array('success'=>false, 'msg'=>'N&atilde;o foi poss&iacute;vel processar sua solicita&ccedil;&atilde;o, por favor entre em contato com o <a href="mailto:suporte@pfdimension.com.br"><i class="fa fa-envelope"></i>&nbsp;suporte</a> do sistema.');
}
echo json_encode($ret);
