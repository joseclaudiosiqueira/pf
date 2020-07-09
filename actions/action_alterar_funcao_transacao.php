<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * captura o post de idcontagem primeiro
 */
$idContagem = filter_input(INPUT_POST, 'id_contagem', FILTER_SANITIZE_NUMBER_INT);
$id = filter_input(INPUT_POST, 'transacao_id', FILTER_SANITIZE_NUMBER_INT);
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
    $fn = new FuncaoTransacao();
    $fn->setTable(strtolower(filter_input(INPUT_POST, 'transacao_tabela', FILTER_SANITIZE_STRING)));
    $fn->setLog();
    /*
     * atualiza um registro na tabela ee, ce, se
     */
    $abrangenciaAtual = filter_input(INPUT_POST, 'abrangencia_atual', FILTER_SANITIZE_STRING);
    $operacao = filter_input(INPUT_POST, 'transacao_operacao', FILTER_SANITIZE_STRING); //inclusao, exclusao ou alteracao
    $tabela = filter_input(INPUT_POST, 'transacao_tabela', FILTER_SANITIZE_STRING); //tabela ali ou aie
    $funcao = filter_input(INPUT_POST, 'transacao_funcao', FILTER_SANITIZE_SPECIAL_CHARS);
    $td = filter_input(INPUT_POST, 'transacao_td');
    $ar = filter_input(INPUT_POST, 'transacao_ar');
    $pfb = filter_input(INPUT_POST, 'transacao_pfb');
    $complexidade = filter_input(INPUT_POST, 'transacao_complexidade', FILTER_SANITIZE_STRING);
    $impactoTemp = explode(';', filter_input(INPUT_POST, 'transacao_impacto', FILTER_SANITIZE_STRING));
    $sigla = $impactoTemp[2];
    $impacto = $impactoTemp[0];
    $fator = $impactoTemp[1];
    $pfa = filter_input(INPUT_POST, 'transacao_pfa');
    $obsFuncao = filter_input(INPUT_POST, 'transacao_observacoes', FILTER_SANITIZE_SPECIAL_CHARS);
    $obsValidar = filter_input(INPUT_POST, 'transacao_observacoes_validacao', FILTER_SANITIZE_SPECIAL_CHARS);
    $idMetodo = filter_input(INPUT_POST, 'transacao_metodo');
    $entrega = filter_input(INPUT_POST, 'transacao_entrega');
    $idRoteiro = filter_input(INPUT_POST, 'transacao_id_roteiro');
    $fonte = filter_input(INPUT_POST, 'transacao_fonte', FILTER_SANITIZE_SPECIAL_CHARS);
    $isMudanca = filter_input(INPUT_POST, 'is_mudanca', FILTER_SANITIZE_NUMBER_INT);
    $faseMudanca = filter_input(INPUT_POST, 'fase_mudanca', FILTER_SANITIZE_STRING);
    $percentualFase = filter_input(INPUT_POST, 'percentual_fase', FILTER_SANITIZE_NUMBER_INT);
    $idBaseline = filter_input(INPUT_POST, 'contagem_id_baseline', FILTER_SANITIZE_NUMBER_INT);
    $situacao = filter_input(INPUT_POST, 'situacao', FILTER_SANITIZE_NUMBER_INT);
    $idFuncaoBaseline = filter_input(INPUT_POST, 'funcao_id_baseline', FILTER_SANITIZE_NUMBER_INT);
    $acaoForms = filter_input(INPUT_POST, 'acao_forms', FILTER_SANITIZE_STRING);
    $fd = filter_input(INPUT_POST, 'transacao_fd');
    $dataValidacaoInterna = NULL;
    $idFatorTecnologia = filter_input(INPUT_POST, 'id_fator_tecnologia', FILTER_SANITIZE_NUMBER_INT);
    $valorFatorTecnologia = filter_input(INPUT_POST, 'valor_fator_tecnologia');
    /*
     * loop para adicionar os nomes
     */
    $descricaoAR = '';
    $nome_unico = '';
    $nome_original = '';
    if (\NULL !== \filter_input(\INPUT_POST, 'transacao_descricao_ar')) {
        for ($x = 0; $x < count($_POST['transacao_descricao_ar']); $x++) {
            $nome_unico = explode('-', $_POST['transacao_descricao_ar'][$x]);
            if (isset($nome_unico[1])) {
                if (trim($nome_unico[0]) === 'ALI' || trim($nome_unico[0]) === 'AIE') {
                    for ($x = 1; $x < count($nome_unico); $x++) {
                        $nome_original .= $nome_unico[$x] . '-';
                    }
                    $nome_original = substr($nome_original, 0, strlen($nome_original) - 1);
                    $descricaoAR .= $nome_original . ',';
                } else {
                    $descricaoAR .= $_POST['transacao_descricao_ar'][$x] . ',';
                }
            } else {
                $descricaoAR .= $_POST['transacao_descricao_ar'][$x] . ',';
            }
        }
        $descricaoAR = substr($descricaoAR, 0, strlen($descricaoAR) - 1);
    }

    $descricaoTD = '';
    $nome_unico = '';
    $nome_original = '';
    if (\NULL !== \filter_input(\INPUT_POST, 'transacao_descricao_td')) {
        for ($x = 0; $x < count($_POST['transacao_descricao_td']); $x++) {
            $nome_unico = explode('-', $_POST['transacao_descricao_td'][$x]);
            if (isset($nome_unico[1])) {
                if (trim($nome_unico[0]) === 'ALI' || trim($nome_unico[0]) === 'AIE') {
                    for ($x = 1; $x < count($nome_unico); $x++) {
                        $nome_original .= $nome_unico[$x] . '-';
                    }
                    $nome_original = substr($nome_original, 0, strlen($nome_original) - 1);
                    $descricaoTD .= $nome_original . ',';
                } else {
                    $descricaoTD .= $_POST['transacao_descricao_td'][$x] . ',';
                }
            } else {
                $descricaoTD .= $_POST['transacao_descricao_td'][$x] . ',';
            }
        }
        $descricaoTD = substr($descricaoTD, 0, strlen($descricaoTD) - 1);
    }

    $fn->setOperacao($operacao);
    $fn->setFuncao($funcao);
    $fn->setTd($td);
    $fn->setAr($ar);
    $fn->setPfb($pfb);
    $fn->setComplexidade($complexidade);
    $fn->setImpacto($impacto);
    $fn->setPfa($pfa);
    $fn->setObsFuncao($obsFuncao);
    $fn->setObsValidar($obsValidar);
    $fn->setIdMetodo($idMetodo);
    $fn->setEntrega($entrega);
    $fn->setDescricaoAR($descricaoAR);
    $fn->setDescricaoTD($descricaoTD);
    $fn->setIdRoteiro($idRoteiro);
    $fn->setFonte($fonte);
    $fn->setIsMudanca($isMudanca);
    $fn->setFaseMudanca($faseMudanca);
    $fn->setPercentualFase($percentualFase);
    $fn->setIdBaseline($idFuncaoBaseline);
    $fn->setSituacao($situacao);
    $fn->setFd($fd);
    $fn->setDataValidacaoInterna($dataValidacaoInterna);
    $fn->setIdFatorTecnologia($idFatorTecnologia);
    $fn->setValorFatorTecnologia($valorFatorTecnologia);

    $pfan = $fn->consultaPFN($id);
    $atualizaFuncaotransacao = $fn->atualiza($id);
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
        'td' => $td,
        'ar' => $ar,
        'complexidade' => $complexidade,
        'pfb' => str_replace(',', '.', $pfb),
        'siglaFator' => $sigla . '/' . number_format($fator, 3),
        'pfa' => str_replace(',', '.', $pfa),
        'obsFuncao' => $obsFuncao,
        'pfan' => str_replace(',', '.', $pfan['pfa']),
        'pfbn' => str_replace(',', '.', $pfan['pfb']),
        'situacao' => $situacao,
        'entrega' => $entrega,
        'isMudanca' => $isMudanca,
        'faseMudanca' => $faseMudanca,
        'percentualFase' => $percentualFase
    );
    /*
     * retorna com o json para a pagina chamadora
     */
    echo json_encode($ret);
} else {
    echo json_encode(array('id' => 0, 'msg' => 'Acesso n&atilde;o autorizado!'));
}
