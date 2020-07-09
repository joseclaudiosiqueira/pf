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
    /*
     * INSTANCIA AS CLASSES
     */
    $fn = new Baseline();
    $sigla = filter_input(INPUT_POST, 'sigla', FILTER_SANITIZE_SPECIAL_CHARS);
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
    $resumo = filter_input(INPUT_POST, 'resumo', FILTER_SANITIZE_SPECIAL_CHARS);
    $valorPf = filter_input(INPUT_POST, 'valorPf');
    $valorHpc = filter_input(INPUT_POST, 'valorHpc');
    $valorHpa = filter_input(INPUT_POST, 'valorHpa');
    $isAtivo = filter_input(INPUT_POST, 'isAtivo', FILTER_SANITIZE_NUMBER_INT);
    $idEmpresa = getIdEmpresa();
    $idCliente = filter_input(INPUT_POST, 'icl', FILTER_SANITIZE_NUMBER_INT);
    /*
     * seta as variaveis da classe
     */
    $fn->setIdEmpresa($idEmpresa);
    $fn->setIdCliente($idCliente);
    $fn->setSigla($sigla);
    $fn->setDescricao($descricao);
    $fn->setResumo($resumo);
    $fn->setValorPf($valorPf);
    $fn->setValorHpa($valorHpa);
    $fn->setValorHpc($valorHpc);
    $fn->setIsAtivo($isAtivo);
    /*
     * insere no banco e retorna um #ID
     */
    $id = $fn->insere();
    /*
     * cria o diretorio para os dashboards
     */
    $dir_baseline = DIR_APP . "dashboard" . DIRECTORY_SEPARATOR . sha1($idEmpresa) . DIRECTORY_SEPARATOR . sha1($id);
    mkdir($dir_baseline, 0777, TRUE);
    /*
     * retorna com o json para a pagina chamadora
     */
    echo json_encode(array(
        'id' => $id
    ));
} else {
    echo json_encode(array(
        'id' => 0,
        'msg' => 'Acesso n&atilde;o autorizado!'
    ));
}