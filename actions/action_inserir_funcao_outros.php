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
    $fn = new FuncaoOutros();
    $setTable = $fn->setTable(\strtolower(\filter_input(\INPUT_POST, 'outros_tabela')));
    $fn->setLog();
    //instancia a baseline
    $c = new Contagem();
    $c->setTable('contagem');
    /*
     * verifica a abrangencia atual e se for PROJETO insere a funcao na contagem de baseline e de projeto
     */
    $abrangenciaAtual = filter_input(INPUT_POST, 'abrangencia_atual', FILTER_SANITIZE_STRING);
    $contagemIdBaseline = filter_input(INPUT_POST, 'contagem_id_baseline', FILTER_SANITIZE_NUMBER_INT);
    /*
     * insere um registro na tabela contagem e retorna com o #ID da contagem
     */
    $idContagem = filter_input(INPUT_POST, 'outros_id');
    $idRoteiro = filter_input(INPUT_POST, 'outros_id_roteiro');
    $operacao = filter_input(INPUT_POST, 'outros_operacao', FILTER_SANITIZE_STRING); //inclusao, exclusao ou alteracao
    $tabela = filter_input(INPUT_POST, 'outros_tabela', FILTER_SANITIZE_STRING); //tabela ali ou aie
    $funcao = filter_input(INPUT_POST, 'outros_funcao', FILTER_SANITIZE_SPECIAL_CHARS);
    $qtd = filter_input(INPUT_POST, 'outros_qtd');
    $impactoTemp = explode(';', filter_input(INPUT_POST, 'outros_impacto', FILTER_SANITIZE_STRING));
    $sigla = $impactoTemp[2];
    $impacto = $impactoTemp[0];
    $fator = $impactoTemp[1];
    $fonte = filter_input(INPUT_POST, 'outros_fonte', FILTER_SANITIZE_SPECIAL_CHARS);
    $pfa = filter_input(INPUT_POST, 'outros_pfa');
    $obsFuncao = '[' . date('d/m/Y : H:i:s') . '] ' . filter_input(INPUT_POST, 'outros_observacoes', FILTER_SANITIZE_SPECIAL_CHARS);
    $obsValidar = filter_input(INPUT_POST, 'outros_observacoes_validacao', FILTER_SANITIZE_SPECIAL_CHARS);
    $entrega = filter_input(INPUT_POST, 'outros_entrega');
    $inseridoPor = $_SESSION['user_email'];
    $dataCadastro = date('Y-m-d H:i:s');
    $funcaoIdBaseline = filter_input(INPUT_POST, 'funcao_id_baseline', FILTER_SANITIZE_NUMBER_INT);
    //verifica se eh projeto e pega o contagem_id_baseline antes
    if ($abrangenciaAtual == 2) {
        $idContagemBaseline = $c->getBaseline($contagemIdBaseline)['id'];
        $fn->setIdContagem($idContagemBaseline);
    } else {
        $fn->setIdContagem($idContagem);
    }
    $fn->setIdRoteiro($idRoteiro);
    $fn->setOperacao($operacao);
    $fn->setFuncao($funcao);
    $fn->setQtd($qtd);
    $fn->setImpacto($impacto);
    $fn->setEntrega($entrega);
    $fn->setPfa($pfa);
    $fn->setObsFuncao($obsFuncao);
    $fn->setObsValidar($obsValidar);
    $fn->setFonte($fonte);
    $fn->setInseridoPor($inseridoPor);
    $fn->setDataCadastro($dataCadastro);
    //verifica as coisas de baseline, seta outros parametros e insere na baseline
    if ($abrangenciaAtual == 2) {
        //altera a observacao
        $obsFuncaoBaseline = '[' . date('d/m/Y : H:i:s') . '] INSERIDA pela Contagem de Projeto ID#' . str_pad($idContagem, 6, "0", STR_PAD_LEFT) . "\n" . $obsFuncao;
        //seta os parametros da classe
        $idContagemBaseline = $c->getBaseline($contagemIdBaseline)['id'];
        $fn->setIdContagem($idContagemBaseline);
        $fn->setIdBaseline(0);
        $fn->setObsFuncao($obsFuncaoBaseline);
        //id na tabela que acabou de ser inserida ali, eie, ee...
        $idAtualBaseline = $fn->insere();
        //id da funcao associada a baseline que acabou de ser inserido
        $fn->setIdBaseline($idAtualBaseline);
        //seta o id para a contagem normal
        $fn->setIdContagem($idContagem);
        $fn->setObsFuncao($obsFuncao);
        //insere no banco e retorna um #ID
        $idGerador = $fn->insere();
        //como foi inserido na baseline por uma contagem de projeto
        //o sistema insere um id_gerador para que a baseline nao possa excluir esta funcao
        $fn->atualizaIdGerador($idGerador, $idAtualBaseline);
    } else {
        //seta o id para a contagem normal
        $fn->setIdContagem($idContagem);
        //id da funcao associada a baseline que acabou de ser inserido
        $fn->setIdBaseline(0);
        $fn->setObsFuncao($obsFuncao);
        //insere no banco e retorna um #ID
        $idGerador = $fn->insere();
        //atualiza a situacao em cada linha para baseline ou licitacao
        $abrangenciaAtual == 3 || $abrangenciaAtual == 4 ? $fn->atualizaSituacao($idGerador, 2) : NULL;
    }
    /*
     * autorizacao para quem insere alterar e para validacao
     */
    $email = $_SESSION['user_email'];
    $isAutorizadoAlterar = true;
    $isAutorizadoValidarInternamente = $fn->isValidadorInterno($email, $id);
    $situacao = $abrangenciaAtual == 3 || $abrangenciaAtual == 4 ? 2 : 0; //inserida recentemente
    /*
     * converte o $ID em um array json
     */
    $ret[] = array(
        'id' => $idGerador,
        'tabela' => $tabela,
        'operacao' => $operacao,
        'funcao' => $funcao,
        'qtd' => $qtd,
        'siglaFator' => $sigla . '/' . number_format($fator, 3),
        'pfa' => $pfa,
        'obsFuncao' => $obsFuncao,
        'situacao' => $situacao,
        'isAutorizadoAlterar' => $isAutorizadoAlterar,
        'isAutorizadoValidarInternamente' => $isAutorizadoValidarInternamente,
        'entrega' => $entrega);
    /*
     * retorna com o json para a pagina chamadora
     */
    echo json_encode($ret);
} else {
    echo json_encode(array('id' => 0, 'msg' => 'Acesso n&atilde;o autorizado!'));
}
