<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
$user_name = NULL !== filter_input(INPUT_POST, 'user-name', FILTER_SANITIZE_STRING) ? $converter->decode(filter_input(INPUT_POST, 'user-name', FILTER_SANITIZE_STRING)) : '';
$user_password_reset_hash = NULL !== filter_input(INPUT_POST, 'user-password-reset-hash') ? filter_input(INPUT_POST, 'user-password-reset-hash') : '';
$user_password_new = NULL !== filter_input(INPUT_POST, 'user-password-new') ? filter_input(INPUT_POST, 'user-password-new') : '';
$user_password_repeat = NULL !== filter_input(INPUT_POST, 'user-password-repeat') ? filter_input(INPUT_POST, 'user-password-repeat') : '';
$ret = [];
if ($user_name !== '' && $user_password_reset_hash !== '' && $user_password_new !== '' && $user_password_repeat !== '') {
    if($login->editNewPassword(trim($user_name), $user_password_reset_hash, $user_password_new, $user_password_repeat)){
        $ret[] = array('id' => 1, 'msg' => 'Sua senha foi alterada com sucesso, fa&ccedil;a o login novamente.');
    }
    else{
        $ret[] = array('id' => 0, 'msg' => 'O sistema detectou que houve uma altera&ccedil;&atilde;o recente na sua senha ou este link n&atilde;o &eacute; mais v&aacute;lido.'
            . ' Por favor, se n&atilde;o souber qual foi a senha gerada ou n&atilde;o possui o email com as instru&ccedil;&otilde;es, solicite novamente o email.');
    }
} else {
    $ret[] = array('id' => 0, 'msg' => 'N&atilde;o foi poss&iacute;vel alterar suas informa&ccedil;&otilde;es, por favor tente novamente.');
}
echo json_encode($ret);
