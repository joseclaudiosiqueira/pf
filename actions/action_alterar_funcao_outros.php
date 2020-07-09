<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verifica se ha um login
 */
if (!$login->isUserLoggedIn()) {
    echo json_encode(array('id' => 0, 'msg' => 'Acesso n&atilde;o autorizado!'));
    die();
}
/*
 * captura o post de idcontagem primeiro
 */
$idContagem = filter_input(INPUT_POST, 'id_contagem', FILTER_SANITIZE_NUMBER_INT);
$id = filter_input(INPUT_POST, 'outros_id', FILTER_SANITIZE_NUMBER_INT);
/*
 * gestor e/ou responsavel
 */
$contagem = new Contagem();
$contagem->setTable('contagem');
$user = new Usuario();
$userId = getUserIdDecoded();
$email = getEmailUsuarioLogado();
/*
 * ira validar se o id da funcao alterada pertence a empresa/fornecedor
 */
$idEmpresa = getIdEmpresa();
$idFornecedor = getIdFornecedor();
$isPermitido = $contagem->isPermitido($idEmpresa, $idFornecedor, $idContagem);
if (!$isPermitido) {
    echo json_encode(array('id' => 0, 'msg' => 'Acesso n&atilde;o autorizado!'));
    die();
}
/*
 * verifica se eh o responsavel ou um gestor
 */
$isResponsavel = $contagem->isResponsavel($email, $idContagem);
$isGestor = $user->isGestor($userId);
/*
 * verificacao do status do login
 */
if (($isResponsavel || $isGestor) && verificaSessao()) {
    /*
     * INSTANCIA AS CLASSES
     */
    $fn = new FuncaoOutros();
    $fn->setTable(strtolower(filter_input(INPUT_POST, 'outros_tabela', FILTER_SANITIZE_STRING)));
    $fn->setLog();
    /*
     * atualiza um registro na tabela ali/aie
     */
    $abrangenciaAtual = filter_input(INPUT_POST, 'abrangencia_atual', FILTER_SANITIZE_STRING);
    $operacao = filter_input(INPUT_POST, 'outros_operacao', FILTER_SANITIZE_STRING); //inclusao, exclusao ou alteracao
    $tabela = filter_input(INPUT_POST, 'outros_tabela', FILTER_SANITIZE_STRING); //tabela ali ou aie, ou
    $funcao = filter_input(INPUT_POST, 'outros_funcao', FILTER_SANITIZE_SPECIAL_CHARS);
    $qtd = filter_input(INPUT_POST, 'outros_qtd');
    $impactoTemp = explode(';', filter_input(INPUT_POST, 'outros_impacto', FILTER_SANITIZE_STRING));
    $sigla = $impactoTemp[2];
    $impacto = $impactoTemp[0];
    $fator = $impactoTemp[1];
    $entrega = filter_input(INPUT_POST, 'outros_entrega');
    $pfa = filter_input(INPUT_POST, 'outros_pfa');
    $obsFuncao = filter_input(INPUT_POST, 'outros_observacoes', FILTER_SANITIZE_SPECIAL_CHARS);
    $obsValidar = filter_input(INPUT_POST, 'outros_observacoes_validacao', FILTER_SANITIZE_SPECIAL_CHARS);
    $idRoteiro = filter_input(INPUT_POST, 'outros_id_roteiro');
    $fonte = filter_input(INPUT_POST, 'outros_fonte', FILTER_SANITIZE_SPECIAL_CHARS);
    $idBaseline = filter_input(INPUT_POST, 'contagem_id_baseline', FILTER_SANITIZE_NUMBER_INT);
    $situacao = filter_input(INPUT_POST, 'situacao', FILTER_SANITIZE_NUMBER_INT);
    $idFuncaoBaseline = filter_input(INPUT_POST, 'funcao_id_baseline', FILTER_SANITIZE_NUMBER_INT);
    $acaoForms = filter_input(INPUT_POST, 'acao_forms', FILTER_SANITIZE_STRING);

    $fn->setOperacao($operacao);
    $fn->setFuncao($funcao);
    $fn->setQtd($qtd);
    $fn->setImpacto($impacto);
    $fn->setEntrega($entrega);
    $fn->setPfa($pfa);
    $fn->setObsFuncao($obsFuncao);
    $fn->setObsValidar($obsValidar);
    $fn->setIdRoteiro($idRoteiro);
    $fn->setFonte($fonte);
    $fn->setIdBaseline($idFuncaoBaseline);
    $fn->setSituacao($situacao);

    $pfan = $fn->consultaPFN($id);
    $atualizaFuncaoOutros = $fn->atualiza($id);
    /*
     * verifica se a operacao eh de inclusao, a contagem eh de projeto e a acao no form eh alterar
     * tem que neste momento alterar a funcao inserida e a funcao na baseline
     * $operacao === 'I' && 
     * basta que o AC Forms seja AL para que atualize tudo
     */
    if ($abrangenciaAtual == 2 && $acaoForms === 'al') {
        //altera a observacao
        $obsFuncaoBaseline = 'INSERIDA pela Contagem de Projeto ID#' . str_pad($idContagem, 6, "0", STR_PAD_LEFT) . "\n" . $obsFuncao;
        //seta os parametros da classe
        $fn->setObsFuncao($obsFuncaoBaseline);
        //seta o id para zero porque eh a funcao baseline
        $fn->setIdBaseline(0);
        //atualiza a funcao baseline
        $atualizaBaseline = $fn->atualiza($idFuncaoBaseline);
    }
    /*
     * converte o $ID em um array json
     */
    $ret = array(
        'id' => $id,
        'tabela' => $tabela,
        'operacao' => $operacao,
        'funcao' => $funcao,
        'qtd' => $qtd,
        'siglaFator' => $sigla . '/' . number_format($fator, 3),
        'pfa' => str_replace(',', '.', $pfa),
        'obsFuncao' => $obsFuncao,
        'pfAnterior' => str_replace(',', '.', $pfan['pfa']),
        'situacao' => $situacao,
        'entrega' => $entrega
    );
    /*
     * retorna com o json para a pagina chamadora
     */
    echo json_encode($ret);
} else {
    echo json_encode(array('id' => 0, 'msg' => 'Acesso n&atilde;o autorizado'));
}
