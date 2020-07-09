<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verificacao do status do login
 */
if ($login->isUserLoggedIn() && verificaSessao()) {
    $fn = new ClienteConfigProjetoAssinatura();
    $fn->setTable('cliente_config_projeto_assinatura');
    /*
     * atualiza o log
     */
    $fn->setLog();
    /*
     * captura as variaveis
     */
    $idProjeto = filter_input(INPUT_POST, 'assinatura_id_projeto', FILTER_SANITIZE_NUMBER_INT);
    $assinaturaNome1 = htmlspecialchars(filter_input(INPUT_POST, 'assinatura_nome_1', FILTER_SANITIZE_STRING));
    $assinaturaNome2 = htmlspecialchars(filter_input(INPUT_POST, 'assinatura_nome_2', FILTER_SANITIZE_STRING));
    $assinaturaNome3 = htmlspecialchars(filter_input(INPUT_POST, 'assinatura_nome_3', FILTER_SANITIZE_STRING));
    $assinaturaNome4 = htmlspecialchars(filter_input(INPUT_POST, 'assinatura_nome_4', FILTER_SANITIZE_STRING));
    $assinaturaNome5 = htmlspecialchars(filter_input(INPUT_POST, 'assinatura_nome_5', FILTER_SANITIZE_STRING));
    $assinaturaNome6 = htmlspecialchars(filter_input(INPUT_POST, 'assinatura_nome_6', FILTER_SANITIZE_STRING));
    $assinaturaCargo1 = htmlspecialchars(filter_input(INPUT_POST, 'assinatura_cargo_1', FILTER_SANITIZE_STRING));
    $assinaturaCargo2 = htmlspecialchars(filter_input(INPUT_POST, 'assinatura_cargo_2', FILTER_SANITIZE_STRING));
    $assinaturaCargo3 = htmlspecialchars(filter_input(INPUT_POST, 'assinatura_cargo_3', FILTER_SANITIZE_STRING));
    $assinaturaCargo4 = htmlspecialchars(filter_input(INPUT_POST, 'assinatura_cargo_4', FILTER_SANITIZE_STRING));
    $assinaturaCargo5 = htmlspecialchars(filter_input(INPUT_POST, 'assinatura_cargo_5', FILTER_SANITIZE_STRING));
    $assinaturaCargo6 = htmlspecialchars(filter_input(INPUT_POST, 'assinatura_cargo_6', FILTER_SANITIZE_STRING));
    $isAssinaturaRelatorio = filter_input(INPUT_POST, 'is_assinatura_relatorio', FILTER_SANITIZE_NUMBER_INT);
    /*
     * atribui
     */
    $fn->setIdProjeto($idProjeto);
    $fn->setAssinaturaNome1($assinaturaNome1);
    $fn->setAssinaturaNome2($assinaturaNome2);
    $fn->setAssinaturaNome3($assinaturaNome3);
    $fn->setAssinaturaNome4($assinaturaNome4);
    $fn->setAssinaturaNome5($assinaturaNome5);
    $fn->setAssinaturaNome6($assinaturaNome6);
    $fn->setAssinaturaCargo1($assinaturaCargo1);
    $fn->setAssinaturaCargo2($assinaturaCargo2);
    $fn->setAssinaturaCargo3($assinaturaCargo3);
    $fn->setAssinaturaCargo4($assinaturaCargo4);
    $fn->setAssinaturaCargo5($assinaturaCargo5);
    $fn->setAssinaturaCargo6($assinaturaCargo6);
    $fn->setIsAssinaturaRelatorio($isAssinaturaRelatorio);
    /*
     * atualiza
     */
    $atualiza = $fn->atualiza($idProjeto);
    /*
     * retorna
     */
    if ($atualiza) {
        echo json_encode(array('msg' => 'As configura&ccedil;&otilde;es das assinaturas para este projeto foram atualizadas com sucesso.'));
    } else {
        echo json_encode(array('msg' => 'Houve um erro durante a atualiza&ccedil;&atilde;o das informa&ccedil;&otilde;es, por favor tente novamente!'));
    }
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}



