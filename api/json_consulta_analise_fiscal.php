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
    /*
     * variaveis
     */
    $userId = getUserIdDecoded();
    $idFornecedor = getIdFornecedor();
    /*
     * classes
     */
    $usuario = new Usuario();
    $analiseFiscal = new ContagemAnaliseFiscal();
    /*
     * perfis autorizados
     */
    $isFiscalContrato = getVariavelSessao('isFiscalContratoCliente');
    $isFiscalContratoEmpresa = getVariavelSessao('isFiscalContratoEmpresa');
    $isFiscalContratoFornecedor = getVariavelSessao('isFiscalContratoFornecedor');
    /*
     * verifica se o perfil logado pode acessar a analise
     */
    if ($isFiscalContrato || $isFiscalContratoEmpresa || $isFiscalContratoFornecedor) {
        $idContagem1 = filter_input(INPUT_POST, 'idContagem1', FILTER_SANITIZE_NUMBER_INT);
        $idContagem2 = filter_input(INPUT_POST, 'idContagem2', FILTER_SANITIZE_NUMBER_INT);
        $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_NUMBER_INT);
        $isAnaliseExistente = $analiseFiscal->isContagemAnaliseFiscal($idContagem1, $idContagem2, $tipo);
        /*
         * retorna com a analise existente
         */
        echo $isAnaliseExistente['qtd'] > 0 ?
                json_encode(array('analise' => html_entity_decode($isAnaliseExistente['analise']))) :
                json_encode(array('analise' => ''));
    } else {
        echo json_encode(array('sucesso' => FALSE, 'msg' => 'Acesso n&atilde;o autorizado.'));
    }
} else {
    echo json_encode(array('sucesso' => FALSE, 'msg' => 'Acesso n&atilde;o autorizado.'));
}

