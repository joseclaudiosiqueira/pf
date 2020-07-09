<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verifica se o usuario tem em suas atribuicoes o finalizar_contagem
 */
$isPermitido = isPermitido('finalizar_contagem');
/*
 * captura do post
 */
$idContagem = NULL !== filter_input(INPUT_POST, 'idc', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'idc', FILTER_SANITIZE_NUMBER_INT) : 0;
/*
 * verificacao do status do login
 */
if ($login->isUserLoggedIn() && verificaSessao() && $idContagem && $isPermitido) {
    $contagem = new Contagem();
    $finalizar = $contagem->finalizarContagem($idContagem);
    /*
     * na finalizacao da contagem a atualizacao das baselines e obrigatoria
     */
    $atualizarBaseline = $contagem->atualizarBaseline ( $idContagem );
    /*
     * retorna com a mensagem de finalizacao
     */
    echo json_encode(array('sucesso' => $finalizar && $atualizarBaseline, 'msg' => 'Contagem finalizada com sucesso e enviada para faturamento'));
} else {
    echo json_encode(array('sucesso' => TRUE, 'msg' => 'Acesso n&atilde;o autorizado!'));
}
