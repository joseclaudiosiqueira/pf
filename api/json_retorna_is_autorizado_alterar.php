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
    if (NULL !== filter_input(INPUT_POST, 'id') && NULL !== filter_input(INPUT_POST, 'ac')) {
        $fn = new Contagem();
        $email = getEmailUsuarioLogado();
        $id = filter_input(INPUT_POST, 'id');
        $ac = filter_input(INPUT_POST, 'ac');
        $isAutorizadoAlterar = FALSE;
        $isAutorizadoValidarInternamente = FALSE;
        /*
         * al - alterar
         * vi - validar interna
         * ve - validar externa
         * ai - auditoria interna
         * ae - auditoria externa
         * vw - viewer (gerentes, diretores, viewers...)
         */
        switch ($ac) {
            case 'al':
                //$pass = $fn->isResponsavel($email, $id);
                $isAutorizadoAlterar = $fn->isResponsavel($email, $id);
                break;
            case 'vi':
                //$pass = $fn->isValidadorInterno($email, $id);
                $isAutorizadoValidarInternamente = $fn->isValidadorInterno($email, $id);
                break;
            case 've':
                //$pass = $fn->isValidadorExterno($email, $id);
                break;
            case 'ai':
                //$pass = $fn->isAuditorInterno($email, $id);
                break;
            case 'ae':
                //$pass = $fn->isAuditorExterno($email, $id);
                break;
            case 'vw':
                //$pass = true;
                break;
        }
        return json_encode(array(
            'isAutorizadoAlterar' => $isAutorizadoAlterar,
            'isAutorizadoValidarInternamente' => $isAutorizadoValidarInternamente));
    }
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}