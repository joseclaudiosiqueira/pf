<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verifica se ja um login
 */
if (!$login->isUserLoggedIn()) {
    echo json_encode(array('msg' => '[LOGIN].Acesso n&atilde;o autorizado!'));
    die();
}
/*
 * este primeiro teste ja filtra se pode ou nao acessar as funcionalidades
 */
$isPermitido = isPermitido('inserir_alterar_analise_fiscal_contrato');

if (!$isPermitido) {
    echo json_encode(array('msg' => '[PERMISSAO (1)].Acesso n&atilde;o autorizado!'));
    die();
}
/*
 * instancia das classes
 */
$user = new Usuario();
$fn = new Contagem();
$fa = new ContagemAnaliseFiscal();
/*
 * captura do post
 */
$idContagem1 = filter_input(INPUT_POST, 'contagemID1', FILTER_SANITIZE_NUMBER_INT);
$idContagem2 = NULL !== filter_input(INPUT_POST, 'contagemID2', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'contagemID2', FILTER_SANITIZE_NUMBER_INT) : 0;
$userEmail = getEmailUsuarioLogado();
$userId = getUserIdDecoded();
$idFornecedor = getIdFornecedor();
/*
 * associados a um perfil
 */
$isFiscalContrato = getVariavelSessao('isFiscalContrato');
$isFiscalContratoEmpresa = getVariavelSessao('isFiscalContratoEmpresa');
$isFiscalContratoFornecedor = getVariavelSessao('isFiscalContratoFornecedor');
/*
 * verifica e passa
 */
if (($isFiscalContrato || $isFiscalContratoEmpresa || $isFiscalContratoFornecedor) && verificaSessao()) {
    /*
     * seta as variaveis vindas do post
     */
    $analise = filter_input(INPUT_POST, 'analise', FILTER_SANITIZE_SPECIAL_CHARS);
    $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_NUMBER_INT);
    /*
     * verifica se existe uma analise anterior e atualiza apenas
     */
    $isAnaliseExistente = $fa->isContagemAnaliseFiscal($idContagem1, $idContagem2, $tipo);
    /*
     * se existir seta as variaveis na classe
     */
    if ($isAnaliseExistente['qtd'] > 0) {
        $fa->setIdContagem1($idContagem1);
        $fa->setIdContagem2($idContagem2);
        $fa->setAnalise($analise);
    } else {
        /*
         * seta as variaveis da analise
         */
        $fa->setAnalise($analise);
        $fa->setIdContagem1($idContagem1);
        $fa->setIdContagem2($idContagem2);
        $fa->setDataInsercao(date('Y-m-d "H:i:s'));
        $fa->setTipo($tipo);
        $fa->setUserId($userId);
    }
    /*
     * insere a análise
     */
    $isAnaliseExistente['qtd'] > 0 ? $fa->atualiza($idContagem1, $idContagem2) : $fa->insere();
    /*
     * retorna ao script chamador
     */
    echo json_encode(array('sucesso' => true, 'msg' => 'Análise de aferição foi ' . ($isAnaliseExistente['qtd'] ? 'atualizada' : 'inserida') . ' com sucesso!'));
} else {
    echo json_encode(array('sucesso' => false, 'msg' => '[PERFIL].Acesso n&atilde;o autorizado!'));
}