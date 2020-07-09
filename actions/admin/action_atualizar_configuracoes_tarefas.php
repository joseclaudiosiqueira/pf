<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
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
if ($login->isUserLoggedIn() && verificaSessao() && $idCliente && $validaCliente) {
    $fn = new ContagemConfigTarefas();
    $idEmpresa = getIdEmpresa();
    $idFornecedor = getIdFornecedor();
    $validacaoInterna = filter_input(INPUT_POST, 't_validacao_interna', FILTER_SANITIZE_NUMBER_INT);
    $validacaoExterna = filter_input(INPUT_POST, 't_validacao_externa', FILTER_SANITIZE_NUMBER_INT);
    $auditoriaInterna = filter_input(INPUT_POST, 't_auditoria_interna', FILTER_SANITIZE_NUMBER_INT);
    $auditoriaExterna = filter_input(INPUT_POST, 't_auditoria_externa', FILTER_SANITIZE_NUMBER_INT);
    $revisaoValidacaoInterna = filter_input(INPUT_POST, 't_revisao_validacao_interna', FILTER_SANITIZE_NUMBER_INT);
    $revisaoValidacaoExterna = filter_input(INPUT_POST, 't_revisao_validacao_externa', FILTER_SANITIZE_NUMBER_INT);
    $aponteAuditoriaInterna = filter_input(INPUT_POST, 't_aponte_auditoria_interna', FILTER_SANITIZE_NUMBER_INT);
    $aponteAuditoriaExterna = filter_input(INPUT_POST, 't_aponte_auditoria_externa', FILTER_SANITIZE_NUMBER_INT);
    $faturamento = filter_input(INPUT_POST, 't_faturamento', FILTER_SANITIZE_NUMBER_INT);
    /*
     * atribui
     */
    $fn->setValidacaoInterna($validacaoInterna);
    $fn->setValidacaoExterna($validacaoExterna);
    $fn->setAuditoriaInterna($auditoriaInterna);
    $fn->setAuditoriaExterna($auditoriaExterna);
    $fn->setRevisaoValidacaoInterna($revisaoValidacaoInterna);
    $fn->setRevisaoValidacaoExterna($revisaoValidacaoExterna);
    $fn->setRevisaoValidacaoExterna($revisaoValidacaoExterna);
    $fn->setAponteAuditoriaInterna($aponteAuditoriaInterna);
    $fn->setAponteAuditoriaExterna($aponteAuditoriaExterna);
    $fn->setFaturamento($faturamento);
    $fn->setIdEmpresa($idEmpresa);
    $fn->setIdFornecedor($idFornecedor);
    $fn->setIdCliente($idCliente);
    /*
     * atualiza
     */
    $atualiza = $fn->atualiza(getIdEmpresa());
    /*
     * retorna
     */
    if ($atualiza) {
        echo json_encode(array('msg' => 'As altera&ccedil;&otilde;es foram feitas com sucesso.&nbsp;<br /><strong>OBSERVA&Ccedil;&Atilde;O:</strong> Algumas altera&ccedil;&otilde;es necessitam que os usu&aacute;rios fa&ccedil;am login novamente para surtir efeito!'));
    } else {
        echo json_encode(array('msg' => 'Houve um erro durante a atualiza&ccedil;&atilde;o das informa&ccedil;&otilde;es, por favor tente novamente!'));
    }
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}



