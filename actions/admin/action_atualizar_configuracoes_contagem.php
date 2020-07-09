<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
$isAdministrador = getVariavelSessao('isAdministrador');
$isAdministradorFornecedor = getVariavelSessao('isAdministradorFornecedor');
$isGestor = getVariavelSessao('isGestor');
$isGestorFornecedor = getVariavelSessao('isGestorFornecedor');
/*
 * verifica o id do cliente
 */
$idCliente = NULL !== filter_input(INPUT_POST, 'icl', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'icl', FILTER_SANITIZE_NUMBER_INT) : 0;
/*
 * verifica se o cliente pertence a empresa/fornecedor
 */
$idEmpresa = getIdEmpresa();
$idFornecedor = getIdFornecedor();
$validaCliente = FALSE;
if ($idCliente) {
    $cliente = new Cliente();
    $cliente->setId($idCliente);
    $cliente->setIdEmpresa($idEmpresa);
    $cliente->setIdFornecedor($idFornecedor);
    $validaCliente = $cliente->validaIDCliente();
}
/*
 * verifica login
 */
if ($login->isUserLoggedIn() && verificaSessao() && $idCliente && $validaCliente && ($isGestor || $isGestorFornecedor || $isAdministrador || $isAdministradorFornecedor)) {
    /*
     * em separado fica melhor
     */
    if (isFornecedor()) {
        $fn = new ContagemFornecedorConfig();
        $fn->setIdFornecedor(getIdFornecedor());
        $fn->setIdCliente($idCliente);
    } else {
        $fn = new ContagemConfig();
        $fn->setIdEmpresa(getIdEmpresa());
        $fn->setIdCliente($idCliente);
        /*
         * so atualiza empresa se for Empresa
         */
        $contagem_config_empresa = new ContagemConfigEmpresa();
        $contagem_config_empresa->setIdEmpresa($idEmpresa);
        $contagem_config_empresa->setIdFornecedor($idFornecedor);
    }

    $prodFEng = filter_input(INPUT_POST, 'prod-f-eng');
    $prodFDes = filter_input(INPUT_POST, 'prod-f-des');
    $prodFImp = filter_input(INPUT_POST, 'prod-f-imp');
    $prodFTes = filter_input(INPUT_POST, 'prod-f-tes');
    $prodFHom = filter_input(INPUT_POST, 'prod-f-hom');
    $prodFImpl = filter_input(INPUT_POST, 'prod-f-impl');
    $pctFEng = filter_input(INPUT_POST, 'pct-f-eng');
    $pctFDes = filter_input(INPUT_POST, 'pct-f-des');
    $pctFImp = filter_input(INPUT_POST, 'pct-f-imp');
    $pctFTes = filter_input(INPUT_POST, 'pct-f-tes');
    $pctFHom = filter_input(INPUT_POST, 'pct-f-hom');
    $pctFImpl = filter_input(INPUT_POST, 'pct-f-impl');
    $isFEng = filter_input(INPUT_POST, 'is-f-eng', FILTER_SANITIZE_NUMBER_INT);
    $isFDes = filter_input(INPUT_POST, 'is-f-des', FILTER_SANITIZE_NUMBER_INT);
    $isFImp = filter_input(INPUT_POST, 'is-f-imp', FILTER_SANITIZE_NUMBER_INT);
    $isFTes = filter_input(INPUT_POST, 'is-f-tes', FILTER_SANITIZE_NUMBER_INT);
    $isFHom = filter_input(INPUT_POST, 'is-f-hom', FILTER_SANITIZE_NUMBER_INT);
    $isFImpl = filter_input(INPUT_POST, 'is-f-impl', FILTER_SANITIZE_NUMBER_INT);
    $descFEng = filter_input(INPUT_POST, 'desc-f-eng', FILTER_SANITIZE_SPECIAL_CHARS);
    $descFDes = filter_input(INPUT_POST, 'desc-f-des', FILTER_SANITIZE_SPECIAL_CHARS);
    $descFImp = filter_input(INPUT_POST, 'desc-f-imp', FILTER_SANITIZE_SPECIAL_CHARS);
    $descFTes = filter_input(INPUT_POST, 'desc-f-tes', FILTER_SANITIZE_SPECIAL_CHARS);
    $descFHom = filter_input(INPUT_POST, 'desc-f-hom', FILTER_SANITIZE_SPECIAL_CHARS);
    $descFImpl = filter_input(INPUT_POST, 'desc-f-impl', FILTER_SANITIZE_SPECIAL_CHARS);
    $custoCocomo = 3500; //filter_input(INPUT_POST, 'custo-cocomo'); TODO: verificar o que eh esse custo_cocomo
    /*
     * para as configuracoes da classe Empresa
     */
    $quantidadeMaximaEntregas = filter_input(INPUT_POST, 'quantidade_maxima_entregas', FILTER_SANITIZE_NUMBER_INT);
    $isProcessoValidacao = filter_input(INPUT_POST, 'is_processo_validacao', FILTER_SANITIZE_NUMBER_INT);
    $isVisualizarRoteirosPublicos = filter_input(INPUT_POST, 'is_visualizar_roteiros_publicos', FILTER_SANITIZE_NUMBER_INT);
    $isValidarAdmGestor = filter_input(INPUT_POST, 'is_validar_adm_gestor', FILTER_SANITIZE_NUMBER_INT);
    $isVisualizarSugestaoLinguagem = filter_input(INPUT_POST, 'is_visualizar_sugestao_linguagem', FILTER_SANITIZE_NUMBER_INT);
    $isProdutividadeGlobal = filter_input(INPUT_POST, 'is_produtividade_global', FILTER_SANITIZE_NUMBER_INT);
    $produtividadeGlobal = filter_input(INPUT_POST, 'produtividade_global');
    $isAlterarProdutividadeGlobal = filter_input(INPUT_POST, 'is_alterar_produtividade_global', FILTER_SANITIZE_NUMBER_INT);
    $isVisualizarContagemTurma = filter_input(INPUT_POST, 'is_visualizar_contagem_turma', FILTER_SANITIZE_NUMBER_INT);
    $horasLiquidasTrabalhadas = filter_input(INPUT_POST, 'horas_liquidas_trabalhadas');
    $isVisualizarTodasFiscalContrato = filter_input(INPUT_POST, 'is-visualizar-todas-fiscal-contrato', FILTER_SANITIZE_NUMBER_INT);
    $isGestaoProjetos = filter_input(INPUT_POST, 'is_gestao_projetos', FILTER_SANITIZE_NUMBER_INT);
    $isVisualizarContagemFornecedor = filter_input(INPUT_POST, 'is_visualizar_contagem_fornecedor', FILTER_SANITIZE_NUMBER_INT);
    $isExcluirCRUDIndependente = filter_input(INPUT_POST, 'is_excluir_crud_independente', FILTER_SANITIZE_NUMBER_INT);
    $idFatorTecnologiaPadrao = filter_input(INPUT_POST, 'id_fator_tecnologia_padrao', FILTER_SANITIZE_NUMBER_INT);
    $isFTPadrao = filter_input(INPUT_POST, 'is_ft_padrao', FILTER_SANITIZE_NUMBER_INT);
    $etapaAtualizarBaseline = filter_input(INPUT_POST, 'etapa-atualizar-baseline', FILTER_SANITIZE_NUMBER_INT);
    /*
     * apenas para nao fornecedores
     */
    if (!(isFornecedor())) {
        $contagem_config_empresa->setQuantidadeMaximaEntregas($quantidadeMaximaEntregas);
        $contagem_config_empresa->setIsProcessoValidacao($isProcessoValidacao);
        $contagem_config_empresa->setIsVisualizarRoteirosPublicos($isVisualizarRoteirosPublicos);
        $contagem_config_empresa->setIsValidarAdmGestor($isValidarAdmGestor);
        $contagem_config_empresa->setIsVisualizarSugestaoLinguagem($isVisualizarSugestaoLinguagem);
        $contagem_config_empresa->setIsProdutividadeGlobal($isProdutividadeGlobal);
        $contagem_config_empresa->setProdutividadeGlobal($produtividadeGlobal);
        $contagem_config_empresa->setIsAlterarProdutividadeGlobal($isAlterarProdutividadeGlobal);
        $contagem_config_empresa->setHorasLiquidasTrabalhadas($horasLiquidasTrabalhadas);
        $contagem_config_empresa->setIsVisualizarTodasFiscalContrato($isVisualizarTodasFiscalContrato);
        $contagem_config_empresa->setIsGestaoProjetos($isGestaoProjetos);
        $contagem_config_empresa->setIsVisualizarContagemFornecedor($isVisualizarContagemFornecedor);
        $contagem_config_empresa->setIsVisualizarContagemTurma($isVisualizarContagemTurma);
        $contagem_config_empresa->setIsExcluirCRUDIndependente($isExcluirCRUDIndependente);
        $contagem_config_empresa->atualiza();
    }

    $fn->setProdFEng($prodFEng);
    $fn->setProdFDes($prodFDes);
    $fn->setProdFImp($prodFImp);
    $fn->setProdFTes($prodFTes);
    $fn->setProdFHom($prodFHom);
    $fn->setProdFImpl($prodFImpl);
    $fn->setPctFEng($pctFEng);
    $fn->setPctFDes($pctFDes);
    $fn->setPctFImp($pctFImp);
    $fn->setPctFTes($pctFTes);
    $fn->setPctFHom($pctFHom);
    $fn->setPctFImpl($pctFImpl);
    $fn->setIsFEng($isFEng);
    $fn->setIsFDes($isFDes);
    $fn->setIsFImp($isFImp);
    $fn->setIsFTes($isFTes);
    $fn->setIsFHom($isFHom);
    $fn->setIsFImpl($isFImpl);
    $fn->setDescFEng($descFEng);
    $fn->setDescFDes($descFDes);
    $fn->setDescFImp($descFImp);
    $fn->setDescFTes($descFTes);
    $fn->setDescFHom($descFHom);
    $fn->setDescFImpl($descFImpl);
    $fn->setCustoCocomo($custoCocomo);
    $fn->setIdFatorTecnologiaPadrao($idFatorTecnologiaPadrao);
    $fn->setIsFTPadrao($isFTPadrao);
    $fn->setEtapaAtualizarBaseline($etapaAtualizarBaseline);
    /*
     * atualiza as variaveis na sessao do usuario atual
     * versao 2.0
     */
    $atualiza = $fn->atualiza();
    /*
     * retorna
     */
    if ($atualiza) {
        echo json_encode(array('msg' => 'As altera&ccedil;&otilde;es foram feitas com sucesso.&nbsp;<br /><strong>OBSERVA&Ccedil;&Atilde;O:</strong> Algumas altera&ccedil;&otilde;es necessitam que os usu&aacute;rios fa&ccedil;am login novamente para surtir efeito!'));
    } else {
        echo json_encode(array('msg' => 'Houve um erro durante a atualiza&ccedil;&atilde;o das informa&ccedil;&otilde;es, por favor tente novamente!'));
    }
} else {
    echo json_encode(array('msg' => 'ARQACTION.0000039 - Acesso n&atilde;o permitido!'));
}