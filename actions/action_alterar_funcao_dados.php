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
    echo json_encode(array('id' => 0, 'msg' => 'LOGIN.Acesso n&atilde;o autorizado!'));
    die();
}
/*
 * captura o post de idcontagem primeiro
 */
$idContagem = NULL !== filter_input(INPUT_POST, 'id_contagem', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'id_contagem', FILTER_SANITIZE_NUMBER_INT) : 0;
$id = NULL !== filter_input(INPUT_POST, 'dados_id', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'dados_id', FILTER_SANITIZE_NUMBER_INT) : 0;
/*
 * gestor e/ou responsavel
 */
$contagem = new Contagem();
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
    echo json_encode(array('id' => 0, 'msg' => 'EMPRESA/FORNECEDOR.Acesso n&atilde;o autorizado!'));
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
    $table = filter_input(INPUT_POST, 'dados_tabela', FILTER_SANITIZE_STRING);
    $fn = new FuncaoDados();
    $fn->setTable(strtolower($table));
    $fn->setLog();
    /*
     * atualiza um registro na tabela ali/aie
     */
    $abrangenciaAtual = filter_input(INPUT_POST, 'abrangencia_atual', FILTER_SANITIZE_STRING);
    $operacao = filter_input(INPUT_POST, 'dados_operacao', FILTER_SANITIZE_STRING); //inclusao, exclusao ou alteracao
    $tabela = filter_input(INPUT_POST, 'dados_tabela', FILTER_SANITIZE_STRING); //tabela ali ou aie
    $funcao = filter_input(INPUT_POST, 'dados_funcao', FILTER_SANITIZE_SPECIAL_CHARS);
    $td = filter_input(INPUT_POST, 'dados_td');
    $tr = filter_input(INPUT_POST, 'dados_tr');
    $pfb = filter_input(INPUT_POST, 'dados_pfb');
    $complexidade = filter_input(INPUT_POST, 'dados_complexidade', FILTER_SANITIZE_STRING);
    $impactoTemp = explode(';', filter_input(INPUT_POST, 'dados_impacto', FILTER_SANITIZE_STRING));
    $sigla = $impactoTemp[2];
    $impacto = $impactoTemp[0];
    $fator = $impactoTemp[1];
    $pfa = filter_input(INPUT_POST, 'dados_pfa');
    $obsFuncao = filter_input(INPUT_POST, 'dados_observacoes', FILTER_SANITIZE_SPECIAL_CHARS);
    $obsValidar = filter_input(INPUT_POST, 'dados_observacoes_validacao', FILTER_SANITIZE_SPECIAL_CHARS);
    $idMetodo = filter_input(INPUT_POST, 'dados_metodo');
    $entrega = filter_input(INPUT_POST, 'dados_entrega');
    $idRoteiro = filter_input(INPUT_POST, 'dados_id_roteiro');
    $fonte = filter_input(INPUT_POST, 'dados_fonte', FILTER_SANITIZE_SPECIAL_CHARS);
    $isMudanca = filter_input(INPUT_POST, 'is_mudanca', FILTER_SANITIZE_NUMBER_INT);
    $faseMudanca = filter_input(INPUT_POST, 'fase_mudanca', FILTER_SANITIZE_STRING);
    $percentualFase = filter_input(INPUT_POST, 'percentual_fase', FILTER_SANITIZE_NUMBER_INT);
    $idBaseline = filter_input(INPUT_POST, 'contagem_id_baseline', FILTER_SANITIZE_NUMBER_INT);
    $situacao = filter_input(INPUT_POST, 'situacao', FILTER_SANITIZE_NUMBER_INT);
    $idFuncaoBaseline = filter_input(INPUT_POST, 'funcao_id_baseline', FILTER_SANITIZE_NUMBER_INT);
    $acaoForms = filter_input(INPUT_POST, 'acao_forms', FILTER_SANITIZE_STRING);
    $fd = filter_input(INPUT_POST, 'dados_fd');
    $fe = filter_input(INPUT_POST, 'dados_fe');
    $isCrud = filter_input(INPUT_POST, 'is_crud', FILTER_SANITIZE_NUMBER_INT);
    $isCrudAtualizarDependentes = filter_input(INPUT_POST, 'is_crud_atualizar_dependentes', FILTER_SANITIZE_NUMBER_INT);
    $dadosFuncaoIsAlterarNome = filter_input(INPUT_POST, 'dados_funcao_is_alterar_nome', FILTER_SANITIZE_NUMBER_INT);
    $dadosFuncaoNomeAnterior = filter_input(INPUT_POST, 'dados_funcao_nome_anterior', FILTER_SANITIZE_SPECIAL_CHARS);
    $dataValidacaoInterna = NULL;
    /*
     * loop para adicionar os descricaoTR
     */
    $descricaoTR = '';
    $nome_unico = '';
    $nome_original = '';
    if (\NULL !== \filter_input(\INPUT_POST, 'dados_descricao_tr')) {
        for ($x = 0; $x < count($_POST['dados_descricao_tr']); $x++) {
            $nome_unico = explode('-', $_POST['dados_descricao_tr'][$x]);
            if (isset($nome_unico[1])) {
                if (trim($nome_unico[0]) === 'ALI' || trim($nome_unico[0]) === 'AIE') {
                    for ($x = 1; $x < count($nome_unico); $x++) {
                        $nome_original .= $nome_unico[$x] . '-';
                    }
                    $nome_original = substr($nome_original, 0, strlen($nome_original) - 1);
                    $descricaoTR .= $nome_original . ',';
                } else {
                    $descricaoTR .= $_POST['dados_descricao_tr'][$x] . ',';
                }
            } else {
                $descricaoTR .= $_POST['dados_descricao_tr'][$x] . ',';
            }
        }
        $descricaoTR = substr($descricaoTR, 0, strlen($descricaoTR) - 1);
    }
    $descricaoTDArray = \NULL !== \filter_input(\INPUT_POST, 'dados_descricao_td');
    $descricaoTD = '';
    $nome_unico = '';
    $nome_original = '';
    if (\NULL !== \filter_input(\INPUT_POST, 'dados_descricao_td')) {
        for ($x = 0; $x < count($_POST['dados_descricao_td']); $x++) {
            $nome_unico = explode('-', $_POST['dados_descricao_td'][$x]);
            if (isset($nome_unico[1])) {
                if (trim($nome_unico[0]) === 'ALI' || trim($nome_unico[0]) === 'AIE') {
                    for ($x = 1; $x < count($nome_unico); $x++) {
                        $nome_original .= $nome_unico[$x] . '-';
                    }
                    $nome_original = substr($nome_original, 0, strlen($nome_original) - 1);
                    $descricaoTD .= $nome_original . ',';
                } else {
                    $descricaoTD .= $_POST['dados_descricao_td'][$x] . ',';
                }
            } else {
                $descricaoTD .= $_POST['dados_descricao_td'][$x] . ',';
            }
        }
        $descricaoTD = substr($descricaoTD, 0, strlen($descricaoTD) - 1);
    }

    $fn->setOperacao($operacao);
    $fn->setFuncao($funcao);
    $fn->setTd($td);
    $fn->setTr($tr);
    $fn->setPfb($pfb);
    $fn->setComplexidade($complexidade);
    $fn->setImpacto($impacto);
    $fn->setPfa($pfa);
    $fn->setObsFuncao($obsFuncao);
    $fn->setObsValidar($obsValidar);
    $fn->setIdMetodo($idMetodo);
    $fn->setEntrega($entrega);
    $fn->setIdRoteiro($idRoteiro);
    $fn->setFonte($fonte);
    $fn->setDescricaoTR($descricaoTR);
    $fn->setDescricaoTD($descricaoTD);
    $fn->setIsMudanca($isMudanca);
    $fn->setFaseMudanca($faseMudanca);
    $fn->setPercentualFase($percentualFase);
    $fn->setIdBaseline($idFuncaoBaseline);
    $fn->setSituacao($situacao);
    $fn->setFd($fd);
    $fn->setFe($fe);
    $fn->setDataValidacaoInterna($dataValidacaoInterna);

    $pfn = $fn->consultaPFN($id);
    $atualizaFuncaoDados = $fn->atualiza($id);
    /*
     * verifica se a operacao eh de inclusao, a contagem eh de projeto e a acao no form eh alterar
     * tem que neste momento alterar a funcao inserida e a funcao na baseline
     * $operacao === 'I' && 
     * basta que o AC Forms seja AL para que atualize tudo
     */
    if ($abrangenciaAtual == 2 && $acaoForms === 'al') {
        //altera a observacao
        $obsFuncaoBaseline = '[' . date('d/m/Y : H:i:s') . '] INSERIDA pela Contagem de Projeto ID#' . str_pad($idContagem, 6, "0", STR_PAD_LEFT) . "\n" . $obsFuncao;
        //seta os parametros da classe
        $fn->setObsFuncao($obsFuncaoBaseline);
        //seta o id para zero porque eh a funcao baseline
        $fn->setIdBaseline(0);
        //atualiza a funcao baseline
        $atualizaBaseline = $fn->atualiza($idFuncaoBaseline);
    }
    /*
     * precisa verificar se o ALI eh CRUD e tem que atualizar os CRUDs
     */
    if (($isCrudAtualizarDependentes && $table === 'ALI' && $isCrud)) {
        /*
         * pega os ids no ALI
         */
        $fn->setTable('ali');
        $idCrud = explode(',', $fn->getIdCrud($id)['id_crud']);
        /*
         * pega as funcoes em cada transacao
         */
        $ft = new FuncaoTransacao();
        /*
         * apenas estabelece o nome
         */
        $nomeFuncaoAtual = "ali.$dadosFuncaoNomeAnterior.";
        $descricaoTD = "ali.$dadosFuncaoNomeAnterior." . str_replace(",", ",$nomeFuncaoAtual", $descricaoTD); //string
        /*
         * loop para verificar os CRUDS
         */
        for ($x = 0; $x < count($idCrud); $x++) {
            $linha = explode('-', $idCrud[$x]);
            $ft->setTable(strtolower($linha[0]));
            $descricaoTDARBanco = $ft->getDescricaoTDCRUD($linha[2]);
            /*
             * pega as descricoes atuais dos TDs
             */
            $descricaoTDCRUD = explode(',', $descricaoTDARBanco['descricao_td']);
            /*
             * faz um loop e retira todos que tem a descricao do ali que esta sendo alterado
             */
            $loopTD = count($descricaoTDCRUD);
            for ($y = 0; $y < $loopTD; $y++) {
                if (strpos($descricaoTDCRUD[$y], $nomeFuncaoAtual) !== FALSE) {
                    unset($descricaoTDCRUD[$y]);
                }
            }
            /*
             * atualiza novamente os TDs, reindexa e salva na tabela
             */
            $descricaoTDCRUDAtual = array_values($descricaoTDCRUD); //array
            $descricaoTDArray = explode(',', $descricaoTD);
            $descricaoFinalTD = array_merge($descricaoTDCRUDAtual, $descricaoTDArray);
            $descricaoStringTD = implode(',', $descricaoFinalTD);
            /*
             * atualizar os tds quando alterar o ALI que gerou os cruds
             */
            $pf = calculaLinhaPF($linha[0], 'transacao', $td, 1, $abrangenciaAtual);
            $ft->setTd($td);
            $ft->setPfb($pf['p']);
            $ft->setComplexidade($pf['c']);
            $ft->setPfa($pf['p']);
            /*
             * se tiver alteracao de nome, faz isso aqui
             * atualiza o ar tambem
             */
            if ($dadosFuncaoIsAlterarNome) {
                $nomeFuncaoAtualizada = "ali.$funcao.";
                $descricaoStringTD = str_replace($nomeFuncaoAtual, $nomeFuncaoAtualizada, $descricaoStringTD);
                /*
                 * paga os ar e atualiza o que esta mudando de nome
                 */
                $descricaoARCRUD = str_replace("ali.$dadosFuncaoNomeAnterior", "ali.$funcao", $descricaoTDARBanco['descricao_ar']);
                $ft->setDescricaoAR($descricaoARCRUD);
                /*
                 * altera tambem o nome das transacoes
                 */
                $funcaoNomeAtual = str_replace("_$dadosFuncaoNomeAnterior", "_$funcao", $descricaoTDARBanco['funcao']);
                $ft->setFuncao($funcaoNomeAtual);
            }
            $ft->setDescricaoTD($descricaoStringTD);
            $ft->atualizaCRUD($linha[2], $dadosFuncaoIsAlterarNome);
        }
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
        'tr' => $tr,
        'complexidade' => $complexidade,
        'pfb' => str_replace(',', '.', $pfb),
        'siglaFator' => $sigla . '/' . number_format($fator, 3),
        'pfa' => str_replace(',', '.', $pfa),
        'obsFuncao' => $obsFuncao,
        'pfan' => str_replace(',', '.', $pfn['pfa']),
        'pfbn' => str_replace(',', '.', $pfn['pfb']),
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
    echo json_encode(array('id' => 0, 'msg' => 'PERFIL.Acesso n&atilde;o autorizado!'));
}
