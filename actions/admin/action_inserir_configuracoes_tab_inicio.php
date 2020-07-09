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
$isGestorFornecedor = getVariavelSessao('isGestorFornecedor');
$isGerenteProjeto = getVariavelSessao('isGerenteProjeto');
$isGerenteProjetoFornecedor = getVariavelSessao('isGerenteProjetoFornecedor');
$isInstrutor = getVariavelSessao('isInstrutor');
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
    $idEmpresa = getIdEmpresa();
    $idFornecedor = filter_input(INPUT_POST, 'idf', FILTER_SANITIZE_NUMBER_INT);
    $idCliente = filter_input(INPUT_POST, 'idc', FILTER_SANITIZE_NUMBER_INT);
    $idContrato = filter_input(INPUT_POST, 'idr', FILTER_SANITIZE_NUMBER_INT);
    $idProjeto = filter_input(INPUT_POST, 'idj', FILTER_SANITIZE_NUMBER_INT);
    $idOrgao = filter_input(INPUT_POST, 'ido', FILTER_SANITIZE_NUMBER_INT);
    $ordemServico = filter_input(INPUT_POST, 'ors', FILTER_SANITIZE_SPECIAL_CHARS);
    $idLinguagem = filter_input(INPUT_POST, 'idl', FILTER_SANITIZE_NUMBER_INT);
    $idTipo = filter_input(INPUT_POST, 'idt', FILTER_SANITIZE_NUMBER_INT);
    $idEtapa = filter_input(INPUT_POST, 'ide', FILTER_SANITIZE_NUMBER_INT);
    $idBancoDados = filter_input(INPUT_POST, 'idb', FILTER_SANITIZE_NUMBER_INT);
    $idAreaAtuacao = filter_input(INPUT_POST, 'idi', FILTER_SANITIZE_NUMBER_INT); //id_industria
    $idProcesso = filter_input(INPUT_POST, 'idp', FILTER_SANITIZE_NUMBER_INT);
    $idProcessoGestao = filter_input(INPUT_POST, 'idg', FILTER_SANITIZE_NUMBER_INT);
    $proposito = filter_input(INPUT_POST, 'pro', FILTER_SANITIZE_SPECIAL_CHARS);
    $escopo = filter_input(INPUT_POST, 'esc', FILTER_SANITIZE_SPECIAL_CHARS);
    /*
     * insercao basica para inicio das configuracoes da tab inicio
     */
    $config = new ContagemConfigTabInicio();
    $config->setIdEmpresa($idEmpresa);
    $config->setIdFornecedor($idFornecedor);
    $config->setIdCliente($idCliente);
    $config->setIdContrato($idContrato);
    $config->setIdProjeto($idProjeto);
    $config->setIdOrgao($idOrgao);
    $config->setOrdemServico($ordemServico);
    $config->setIdLinguagem($idLinguagem);
    $config->setIdTipo($idTipo);
    $config->setIdEtapa($idEtapa);
    $config->setIdBancoDados($idBancoDados);
    $config->setIdAreaAtuacao($idAreaAtuacao); //id_industria
    $config->setIdProcesso($idProcesso);
    $config->setIdProcessoGestao($idProcessoGestao);
    $config->setProposito($proposito);
    $config->setEscopo($escopo);
    $config->insere();
    /*
     * retorna com sucesso apos as insercoes
     */
    echo json_encode(array('sucesso' => TRUE, 'msg' => 'A configuração foi inserida com sucesso'));
} else {
    echo json_encode(array('sucesso' => FALSE, 'msg' => 'Acesso não autorizado!'));
}