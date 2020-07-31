<?php

include $_SERVER['DOCUMENT_ROOT'] . (substr($_SERVER['DOCUMENT_ROOT'], -1) === '/' ? '' : '/') . 'pf/conf/conf.php';
/*
 * provided by route Dimension - Jose Claudio
 */
if (NULL !== filter_input(INPUT_GET, 'logout')) {
    $login->redirectAction(1); //logout
} else if (!empty($_SESSION['user_name']) && $_SESSION['user_logged_in']) {
    $login->redirectAction(2); //login with an existing session
} else if (isset($_COOKIE['rememberme'])) {
    $login->redirectAction(3); //login with a cookie
} else if (NULL !== filter_input(INPUT_POST, 'user_name') && NULL !== filter_input(INPUT_POST, 'user_password') && NULL !== filter_input(INPUT_POST, 'id_empresa')) {
    /*
     * pega o id_empresa e decodifica
     */
    $id_empresa = $converter->decode(filter_input(INPUT_POST, 'id_empresa', FILTER_SANITIZE_STRING));
    $associacao = explode(';', $id_empresa);
    //nao sera mais utilizado por motivos de seguranca
    //$login->setUserRememberme(filter_input(INPUT_POST, 'user_rememberme'));
    $login->setUserName(filter_input(INPUT_POST, 'user_name', FILTER_SANITIZE_STRING));
    $login->setUserPassword(filter_input(INPUT_POST, 'user_password', FILTER_SANITIZE_STRING));
    $login->setIdEmpresa($associacao[0]);
    $login->setIdFornecedor($associacao[1]);
    $login->setUser_role_id($associacao[3]);
    $login->setUser_id($associacao[4]);
    $login->redirectAction(4); //login with a post data
}
/*
 * redireciona
 */
if ($login->isUserLoggedIn()) {
    /*
     * pega o perfil do usuario para redirecionar
     * apenas os perfis Administrador e Fiscal de Contrato
     */
    $roleId = getVariavelSessao('role_id'); // pegar na sessao // $user = new Usuario(); $user->getUserRoleId(getUserIdDecoded());
    $url = $converter->decode(filter_input(INPUT_POST, 'url', FILTER_SANITIZE_STRING));
    //verificar quando o sujeito estiver logado ... para nao impossibilitar o download
    if ($roleId == 1) {
        $loc = NULL !== filter_input(INPUT_POST, 'url', FILTER_SANITIZE_STRING) ?
        $url :
        '/pf/DIM.Gateway.php?arq=4&tch=2&sub=0&dlg=1';
    } elseif ($roleId == 16) {
        $loc = NULL !== filter_input(INPUT_POST, 'url', FILTER_SANITIZE_STRING) ?
        $url :
        '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1';
    } else {
        $loc = NULL !== filter_input(INPUT_POST, 'url', FILTER_SANITIZE_STRING) ?
        $url :
        '/pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1';
    }
    if (NULL === filter_input(INPUT_POST, 'user_name')) {
        header("Location: $loc");
    } else {
        echo json_encode(array('p' => $loc, 'e' => ''));
    }
} else if (getVariavelSessao('errors') && getVariavelSessao('errors') !== '') {
    echo json_encode(array('e' => 'e', 'p' => ''));
} else {
    $url = NULL !== filter_input(INPUT_GET, 'url', FILTER_SANITIZE_STRING) ? filter_input(INPUT_GET, 'url', FILTER_SANITIZE_STRING) : NULL;
    include DIR_BASE . 'forms/form_login.php';
}
