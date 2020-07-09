<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
$isAdministrador = getVariavelSessao('isAdministrador');
$isGestor = getVariavelSessao('isGestor');
$isInstrutor = getVariavelSessao('isInstrutor');
$isGestorFornecedor = getVariavelSessao('isGestorFornecedor');
$isGerenteProjeto = getVariavelSessao('isGerenteProjeto');
$isGerenteProjetoFornecedor = getVariavelSessao('isGerenteProjetoFornecedor');
/*
 * verificacao do status do login
 */
if ($login->isUserLoggedIn() &&
        verificaSessao() &&
        ($isAdministrador ||
        $isGestor ||
        $isGestorFornecedor ||
        $isGerenteProjeto ||
        $isGerenteProjetoFornecedor ||
        $isInstrutor)) {
    /*
     * variaveis $_POST
     */
    $id = filter_input(INPUT_POST, 'idc', FILTER_SANITIZE_NUMBER_INT);
    /*
     * insercao basica para inicio das configuracoes da tab inicio
     */
    $config = new ContagemConfigTabInicio();
    $config->exclui($id);
    /*
     * retorna com sucesso apos as insercoes
     */
    echo json_encode(array('sucesso' => TRUE, 'msg' => 'A configuração foi excluida com sucesso'));
} else {
    echo json_encode(array('sucesso' => FALSE, 'msg' => 'Acesso não autorizado!'));
}