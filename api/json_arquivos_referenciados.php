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
    $co = new Contagem();
    $co->setTable('contagem');
    $fn = new FuncaoTransacao();
    $id = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);
    $isTags = isset($_POST['tags']) ? 1 : 0;
    $tags = NULL !== filter_input(INPUT_POST, 'tags', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'tags', FILTER_SANITIZE_STRING) : 0;
    $idBaseline = $co->getBaseline($id)['id'];
    /*
     * retorna o json verificando se eh para pesquisar funcoes ou para pesquisar tipos de dados
     */
    echo $isTags ?
            json_encode($fn->getTipoDados($idBaseline, $tags)) :
            json_encode($fn->getArquivosReferenciados($idBaseline));
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}
