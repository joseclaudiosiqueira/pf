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
    $fn = new Usuario();
    $id = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);
    /*
     * verifica se a empresa adota o gerenciamento de projetos
     */
    if (getConfigContagem('is_gestao_projetos')) {
        echo json_encode($fn->getGerenteProjeto($id));
    } else {
        echo json_encode(array('user_email' => 'nao@aplicavel', 'complete_name' => 'Não aplicável'));
    }
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}