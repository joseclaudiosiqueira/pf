<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER ['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verifica login
 */
if ($login->isUserLoggedIn() && verificaSessao()) {
    $orgao = new Orgao ();
    $orgao->setIdEmpresa(getIdEmpresa());
    /*
     * por enquanto sem utilizacao estes parametros
     * $t = filter_input ( INPUT_POST, 't', FILTER_SANITIZE_STRING );
     * $i = NULL !== filter_input ( INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT ) ? filter_input ( INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT ) : NULL;
     * $c = NULL !== filter_input ( INPUT_POST, 'icl', FILTER_SANITIZE_NUMBER_INT ) ? filter_input ( INPUT_POST, 'icl', FILTER_SANITIZE_NUMBER_INT ) : 0;
     */
    /*
     * unica variavel necessaria neste momento
     */
    $idCliente = NULL !== filter_input(INPUT_POST, 'icl', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'icl', FILTER_SANITIZE_NUMBER_INT) : 0;
    /*
     * se for um fornecedor tem que pegar o idcliente que a empresa gerou
     */
    if (isFornecedor()) {
        $idEmpresa = getIdEmpresa();
        $cliente = new Cliente ();
        $idCliente = $cliente->getIdClienteEmpresa($idEmpresa) ['id'];
    }
    /*
     * retorna
     */
    echo json_encode($orgao->getTree('identada', $idCliente));
} else {
    /*
     * retorna
     */
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'
    ));
}