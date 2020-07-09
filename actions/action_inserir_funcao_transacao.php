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
    $fn = new FuncaoTransacao();
    $table = \strtolower(\filter_input(\INPUT_POST, 'transacao_tabela'));
    $fn->setTable($table);
    $fn->setLog();
    //instancia a baseline
    $c = new Contagem();
    $c->setTable('contagem');
    //verifica a abrangencia atual e se for PROJETO insere a funcao na contagem de baseline e de projeto
    $abrangenciaAtual = filter_input(INPUT_POST, 'abrangencia_atual', FILTER_SANITIZE_STRING);
    //#ID da baseline, nao confundir com o #ID da contagem de PF da baseline
    $contagemIdBaseline = filter_input(INPUT_POST, 'contagem_id_baseline', FILTER_SANITIZE_NUMBER_INT);
    /*
     * insere um registro na tabela de transacao e retorna com o #ID da contagem
     */
    $idContagem = filter_input(INPUT_POST, 'transacao_id');
    $idRoteiro = filter_input(INPUT_POST, 'transacao_id_roteiro');
    $operacao = filter_input(INPUT_POST, 'transacao_operacao', FILTER_SANITIZE_STRING); //inclusao, exclusao, alteracao ou testes
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
    $obsFuncao = '[' . date('d/m/Y : H:i:s') . '] ' . filter_input(INPUT_POST, 'transacao_observacoes', FILTER_SANITIZE_SPECIAL_CHARS);
    $obsValidar = filter_input(INPUT_POST, 'transacao_observacoes_validacao', FILTER_SANITIZE_SPECIAL_CHARS);
    $idMetodo = filter_input(INPUT_POST, 'transacao_metodo');
    $entrega = filter_input(INPUT_POST, 'transacao_entrega');
    $fonte = filter_input(INPUT_POST, 'transacao_fonte', FILTER_SANITIZE_SPECIAL_CHARS);
    $isMudanca = filter_input(INPUT_POST, 'is_mudanca', FILTER_SANITIZE_NUMBER_INT);
    $faseMudanca = filter_input(INPUT_POST, 'fase_mudanca', FILTER_SANITIZE_STRING);
    $percentualFase = filter_input(INPUT_POST, 'percentual_fase', FILTER_SANITIZE_NUMBER_INT);
    $idRelacionamento = filter_input(INPUT_POST, 'funcao_id_baseline', FILTER_SANITIZE_NUMBER_INT);
    $fd = filter_input(INPUT_POST, 'transacao_fd');
    $inseridoPor = $_SESSION['user_email'];
    $dataCadastro = date('Y-m-d H:i:s');
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
    //parametros para a classe e insere normalmente
    $fn->setIdRoteiro($idRoteiro);
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
    $fn->setFonte($fonte);
    $fn->setInseridoPor($inseridoPor);
    $fn->setDataCadastro($dataCadastro);
    $fn->setIsMudanca($isMudanca);
    $fn->setFaseMudanca($faseMudanca);
    $fn->setPercentualFase($percentualFase);
    $fn->setFd($fd);
    $fn->setIdRelacionamento($idRelacionamento);
    $fn->setIdFatorTecnologia($idFatorTecnologia);
    $fn->setValorFatorTecnologia($valorFatorTecnologia);
    //verifica as coisas de baseline, seta outros parametros e insere na baseline
    if ($abrangenciaAtual == 2) {
        //funcoes apenas para testes nao vao para a baseline, ficam apenas na contagem do projeto que a inseriu
        if ($operacao !== 'T') {
            //altera a observacao
            $obsFuncaoBaseline = '[' . date('d/m/Y : H:i:s') . '] LINHA INSERIDA pela Contagem de Projeto ID#' . str_pad($idContagem, 6, "0", STR_PAD_LEFT) . "\n" . $obsFuncao;
            //seta os parametros da classe
            $idContagemBaseline = $c->getBaseline($contagemIdBaseline)['id'];
            $fn->setIdContagem($idContagemBaseline);
            $fn->setIdBaseline(0);
            $fn->setObsFuncao($obsFuncaoBaseline);
            //id na tabela que acabou de ser inserida ali, eie, ee...
            $idAtualBaseline = $fn->insere();
            //id da funcao associada a baseline que acabou de ser inserido
            $fn->setIdBaseline($idAtualBaseline);
        } else {
            $fn->setIdBaseline(0);
            $idAtualBaseline = 0;
        }
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
    //autorizacao para quem insere alterar e para validacao
    $email = $_SESSION['user_email'];
    $isAutorizadoAlterar = true;
    $isAutorizadoValidarInternamente = $fn->isValidadorInterno($email, $id);
    $situacao = $abrangenciaAtual == 3 || $abrangenciaAtual == 4 ? 2 : 0; //inserida recentemente
    $ret[] = array(
        'id' => $idGerador,
        'tabela' => $tabela,
        'operacao' => $operacao,
        'funcao' => $funcao,
        'td' => $td,
        'ar' => $ar,
        'complexidade' => $complexidade,
        'pfb' => $pfb,
        'siglaFator' => $sigla . '/' . number_format($fator, 3),
        'pfa' => $pfa,
        'obsFuncao' => $obsFuncao,
        'situacao' => $situacao,
        'isAutorizadoAlterar' => $isAutorizadoAlterar,
        'isAutorizadoValidarInternamente' => $isAutorizadoValidarInternamente,
        'entrega' => $entrega,
        'isMudanca' => $isMudanca,
        'faseMudanca' => $faseMudanca,
        'percentualFase' => $percentualFase);
    /*
     * retorna com o json para a pagina chamadora
     */
    echo json_encode($ret);
} else {
    echo json_encode(array('id' => 0, 'msg' => 'Acesso n&atilde;o autorizado!'));
}
