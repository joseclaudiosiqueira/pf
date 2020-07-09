<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verifica login e se pode alterar a contagem
 */
$idContagem = filter_input(INPUT_POST, 'ic', FILTER_SANITIZE_NUMBER_INT);
/*
 * verifica responsabilidades
 */
$contagem = new Contagem();
$isResponsavel = $contagem->isResponsavel(getEmailUsuarioLogado(), $idContagem);
$isGestor = getVariavelSessao('isGestor');
/*
 * TODO: susbstituir pelo metodo isGerenteProjeto da contagem
 * agora nao da porque senao da erro
 */
$isGerenteProjeto = $contagem->isGerenteProjeto(getEmailUsuarioLogado(), $idContagem);
/*
 * testa antes de passar
 */
if ($login->isUserLoggedIn() && verificaSessao() && ($isResponsavel || $isGestor || $isGerenteProjeto) && $idContagem) {
    $cp = filter_input(INPUT_POST, 'cp', FILTER_SANITIZE_STRING);
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $vl = filter_input(INPUT_POST, 'vl', FILTER_SANITIZE_STRING);
    $tb = filter_input(INPUT_POST, 'tb', FILTER_SANITIZE_STRING);
    $resposta = array();
    /*
     * atualiza diretamente na tabela
     */
    $sql = "UPDATE " . $tb . " SET $cp = '$vl' WHERE id = $id";
    $stm = DB::prepare($sql);
    /*
     * retorna true ou false
     */
    $resposta[] = array('sucesso' => $stm->execute());
    echo json_encode($resposta);
} else {
    echo json_encode(array('sucesso' => false, 'msg' => 'Acesso n&atilde;o autorizado!'));
}



