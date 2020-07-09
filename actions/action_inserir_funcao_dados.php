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
    //INSTANCIA AS CLASSES
    $fn = new FuncaoDados();
    $table = strtolower(filter_input(INPUT_POST, 'dados_tabela', FILTER_SANITIZE_STRING));
    $fn->setTable($table);
    $ft = new FuncaoTransacao();
    $ft->setLog();
    $fn->setLog();
    //instancia a baseline
    $c = new Contagem();
    //verifica a abrangencia atual e se for PROJETO insere a funcao na contagem de baseline e de projeto
    $abrangenciaAtual = filter_input(INPUT_POST, 'abrangencia_atual', FILTER_SANITIZE_NUMBER_INT);
    //#ID da baseline, nao confundir com o #ID da contagem de PF da baseline
    $contagemIdBaseline = filter_input(INPUT_POST, 'contagem_id_baseline', FILTER_SANITIZE_NUMBER_INT);
    //insere um registro na tabela contagem e retorna com o #ID da contagem
    $idContagem = filter_input(INPUT_POST, 'dados_id'); //id da contagem atual
    $idRoteiro = filter_input(INPUT_POST, 'dados_id_roteiro');
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
    $obsFuncao = '[' . date('d/m/Y : H:i:s') . '] ' . filter_input(INPUT_POST, 'dados_observacoes', FILTER_SANITIZE_SPECIAL_CHARS);
    $obsValidar = filter_input(INPUT_POST, 'dados_observacoes_validacao', FILTER_SANITIZE_SPECIAL_CHARS);
    $idMetodo = filter_input(INPUT_POST, 'dados_metodo');
    $entrega = filter_input(INPUT_POST, 'dados_entrega');
    $fonte = filter_input(INPUT_POST, 'dados_fonte', FILTER_SANITIZE_SPECIAL_CHARS);
    $inseridoPor = $_SESSION['user_email'];
    $dataCadastro = date('Y-m-d H:i:s');
    $isMudanca = filter_input(INPUT_POST, 'is_mudanca', FILTER_SANITIZE_NUMBER_INT);
    $faseMudanca = filter_input(INPUT_POST, 'fase_mudanca', FILTER_SANITIZE_STRING);
    $percentualFase = filter_input(INPUT_POST, 'percentual_fase', FILTER_SANITIZE_NUMBER_INT);
    $idRelacionamento = filter_input(INPUT_POST, 'funcao_id_baseline', FILTER_SANITIZE_NUMBER_INT);
    $fd = filter_input(INPUT_POST, 'dados_fd');
    $fe = filter_input(INPUT_POST, 'dados_fe');
    $acaoForms = filter_input(INPUT_POST, 'acao_forms');
    $isCrud = filter_input(INPUT_POST, 'is_crud', FILTER_SANITIZE_NUMBER_INT);
    //loop para adicionar os descricaoTR
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
    //tipos de dados
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
    //parametros para a classe e insere normalmente
    $fn->setIdRoteiro($idRoteiro);
    $fn->setOperacao($operacao);
    $fn->setFuncao($funcao);
    $fn->setTd($td);
    $fn->setTr($tr);
    $fn->setPfb($pfb);
    $fn->setComplexidade($complexidade);
    $fn->setImpacto($impacto);
    $fn->setPfa($pfa);
    $fn->setObsValidar($obsValidar);
    $fn->setIdMetodo($idMetodo);
    $fn->setEntrega($entrega);
    $fn->setFonte($fonte);
    $fn->setInseridoPor($inseridoPor);
    $fn->setDataCadastro($dataCadastro);
    $fn->setDescricaoTR($descricaoTR);
    $fn->setDescricaoTD($descricaoTD);
    $fn->setIsMudanca($isMudanca);
    $fn->setFaseMudanca($faseMudanca);
    $fn->setPercentualFase($percentualFase);
    $fn->setFd($fd);
    $fn->setFe($fe);
    $fn->setIdRelacionamento($idRelacionamento);
    //verifica as coisas de baseline, seta outros parametros e insere na baseline
    if ($abrangenciaAtual == 2) {
        //altera a observacao
        $obsFuncaoBaseline = '[' . date('d/m/Y : H:i:s') . '] LINHA INSERIDA pela Contagem de Projeto ID#' . str_pad($idContagem, 6, "0", STR_PAD_LEFT);
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
        //autorizacao para quem insere alterar e para validacao
        $email = getEmailUsuarioLogado();
        $isAutorizadoAlterar = true;
        $isAutorizadoValidarInternamente = $fn->isValidadorInterno($email, $id);
        $situacao = 0; //inserida recentemente
        //converte o $ID em um array json
        $ret[] = array(
            'id' => $idGerador,
            'tabela' => $tabela,
            'operacao' => $operacao,
            'funcao' => $funcao,
            'td' => $td,
            'tr' => $tr,
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
    } else {
        //seta o id para a contagem normal
        $fn->setIdContagem($idContagem);
        //id da funcao associada a baseline que acabou de ser inserido
        $fn->setIdBaseline(0);
        $fn->setObsFuncao($obsFuncao);
        //insere no banco e retorna um #ID
        $idGerador = $fn->insere();
        //autorizacao para quem insere alterar e para validacao
        $email = getEmailUsuarioLogado();
        $isAutorizadoAlterar = true;
        $isAutorizadoValidarInternamente = $fn->isValidadorInterno($email, $id);
        //rever a opcao 5 - validada baseline/licitacao
        $situacao = $abrangenciaAtual == 3 || $abrangenciaAtual == 4 ? 2 : 0; //inserida recentemente
        //atualiza a situacao em cada linha para contagens de baseline e licitacao
        $abrangenciaAtual == 3 || $abrangenciaAtual == 4 ? $fn->atualizaSituacao($idGerador, 2) : NULL;
        //converte o $ID em um array json
        $ret[] = array(
            'id' => $idGerador,
            'tabela' => $tabela,
            'operacao' => $operacao,
            'funcao' => $funcao,
            'td' => $td,
            'tr' => $tr,
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
    }
    //cria os elementos de crud para cada ali inserido
    if ($table === 'ali' && $isCrud) {
        //array que armazena os ids EE-XX,...
        $arIdCrud = array();
        //variaveis genericas
        //verifica se o usuario colocou alguma descricao
        $descricaoTD = strlen($descricaoTD) > 0 ? 'ali.' . $funcao . '.' . $descricaoTD : '';
        $descricaoAR = 'ali.' . $funcao;
        //atributos genericos
        $ft->setIdRoteiro(3); //id automatico do roteiro Dimension.
        $ft->setOperacao('I');
        $ft->setIdContagem($idContagem);
        $ft->setIdBaseline(0); //atualizar depois
        $ft->setAr(1);
        $ft->setImpacto(41);
        $ft->setIdMetodo($idMetodo);
        $ft->setIsMudanca(0);
        $ft->setFaseMudanca($faseMudanca);
        $ft->setPercentualFase(0);
        $ft->setFd($fd);
        $ft->setIdRelacionamento(0);
        $ft->setIsCrud(1);
        $ft->setEntrega(1);
        $ft->setDescricaoAR($descricaoAR);
        $ft->setFonte($fonte);
        $ft->setInseridoPor($inseridoPor);
        $ft->setDataCadastro($dataCadastro);
        //fator_tecnologia neste caso eh zero
        $ft->setIdFatorTecnologia(0);
        $ft->setValorFatorTecnologia(0);
        $obsFuncao = '[' . date('d/m/Y : H:i:s') . '] LINHA INSERIDA AUTOMATICAMENTE (CRUD)' . ($abrangenciaAtual == 3 ? ' por esta contagem de Baseline.' : ' pela Contagem ID#' . str_pad($idContagem, 6, "0", STR_PAD_LEFT));
        //verifica a complexidade e o pfb
        $pfEE = calculaLinhaPF('EE', 'transacao', $td, 1, $abrangenciaAtual);
        //primeiro EE - INCLUIR
        $ft->setTable('ee');
        $ft->setTd($td);
        $ft->setPfb($pfEE['p']);
        $ft->setComplexidade($pfEE['c']);
        $ft->setPfa($pfEE['p']);
        $ft->setObsFuncao($obsFuncao);
        $ft->setObsValidar('');
        $ft->setDescricaoTD(strlen($descricaoTD) > 0 ? str_replace(',', ',ali.' . $funcao . '.', $descricaoTD) : '');
        //insere o registro
        $ft->setFuncao('inserir_' . $funcao);
        $idCrudEE1 = $ft->insere();
        //atualiza a situacao em cada linha para baseline ou licitacao
        $abrangenciaAtual == 3 || $abrangenciaAtual == 4 ? $ft->atualizaSituacao($idCrudEE1, 2) : NULL;
        $arIdCrud[] = 'EE-I-' . $idCrudEE1;
        $ft->atualizaIsCrud($idCrudEE1, 'I');
        //segundo EE - ALTERAR
        $ft->setFuncao('alterar_' . $funcao);
        $idCrudEE2 = $ft->insere();
        //atualiza a situacao em cada linha para baseline ou licitacao
        $abrangenciaAtual == 3 || $abrangenciaAtual == 4 ? $ft->atualizaSituacao($idCrudEE2, 2) : NULL;
        $arIdCrud[] = 'EE-A-' . $idCrudEE2;
        $ft->atualizaIsCrud($idCrudEE2, 'A');
        //terceiro EE - EXCLUIR
        $ft->setFuncao('excluir_' . $funcao);
        $idCrudEE3 = $ft->insere();
        //atualiza a situacao em cada linha para baseline ou licitacao
        $abrangenciaAtual == 3 || $abrangenciaAtual == 4 ? $ft->atualizaSituacao($idCrudEE3, 2) : NULL;
        $arIdCrud[] = 'EE-E-' . $idCrudEE3;
        $ft->atualizaIsCrud($idCrudEE3, 'E');
        //verifica a complexidade e o pfb
        $pfCE = calculaLinhaPF('CE', 'transacao', $td, 1, $abrangenciaAtual);
        //insere a CE - CONSULTAR
        $ft->setTable('ce');
        $ft->setFuncao('consultar_' . $funcao);
        $ft->setPfb($pfCE['p']);
        $ft->setPfa($pfCE['p']);
        $ft->setComplexidade($pfCE['c']);
        $idCrudCE = $ft->insere();
        //atualiza a situacao em cada linha para baseline ou licitacao
        $abrangenciaAtual == 3 || $abrangenciaAtual == 4 ? $ft->atualizaSituacao($idCrudCE, 2) : NULL;
        $arIdCrud[] = 'CE-C-' . $idCrudCE;
        $ft->atualizaIsCrud($idCrudCE, 'C');
        //vai na tabela ALI e atualiza os ids de crud inseridos
        $fn->atualizaALICrud($idGerador, implode(",", $arIdCrud));
        //para as contagens de projeto ainda ha que inserir cada uma das funcionalidades na baseline
        if ($abrangenciaAtual == 2) {
            //altera a observacao
            $obsFuncaoBaseline = '[' . date('d/m/Y : H:i:s') . '] LINHA INSERIDA AUTOMATICAMENTE (CRUD) pela Contagem ID#' . str_pad($idContagem, 6, "0", STR_PAD_LEFT);
            //seta os parametros da classe
            $idContagemBaseline = $c->getBaseline($contagemIdBaseline)['id'];
            $ft->setIdContagem($idContagemBaseline);
            $ft->setIdBaseline(0);
            $ft->setObsFuncao($obsFuncaoBaseline);
            $ft->setTable('ee');
            $ft->setTd($td);
            $ft->setPfb($pfEE['p']);
            $ft->setComplexidade($pfEE['c']);
            $ft->setPfa($pfEE['p']);
            $ft->setObsValidar('');
            $ft->setDescricaoTD(strlen($descricaoTD) > 0 ? str_replace(',', ',ali.' . $funcao . '.', $descricaoTD) : '');
            //insere o registro
            $ft->setFuncao('inserir_' . $funcao);
            //id na tabela que acabou de ser inserida ali, eie, ee...
            $idAtualBaselineEE1 = $ft->insere();
            $arIdCrud[] = 'EE-I-' . $idAtualBaselineEE1;
            $ft->atualizaIsCrud($idAtualBaselineEE1, 'I');
            $ft->atualizaIdGerador($idCrudEE1, $idAtualBaselineEE1);
            $ft->atualizaIdBaseline($idCrudEE1, $idAtualBaselineEE1);
            //insere o registro
            $ft->setFuncao('alterar_' . $funcao);
            //id na tabela que acabou de ser inserida ali, eie, ee...
            $idAtualBaselineEE2 = $ft->insere();
            $arIdCrud[] = 'EE-A-' . $idAtualBaselineEE2;
            $ft->atualizaIsCrud($idAtualBaselineEE2, 'A');
            $ft->atualizaIdGerador($idCrudEE2, $idAtualBaselineEE2);
            $ft->atualizaIdBaseline($idCrudEE2, $idAtualBaselineEE2);
            //insere o registro
            $ft->setFuncao('excluir_' . $funcao);
            //id na tabela que acabou de ser inserida ali, eie, ee...
            $idAtualBaselineEE3 = $ft->insere();
            $arIdCrud[] = 'EE-E-' . $idAtualBaselineEE3;
            $ft->atualizaIsCrud($idAtualBaselineEE3, 'E');
            $ft->atualizaIdGerador($idCrudEE3, $idAtualBaselineEE3);
            $ft->atualizaIdBaseline($idCrudEE3, $idAtualBaselineEE3);
            $ft->setTable('ce');
            //insere o registro
            $ft->setFuncao('consultar_' . $funcao);
            $ft->setPfb($pfCE['p']);
            $ft->setPfa($pfCE['p']);
            $ft->setComplexidade($pfCE['c']);
            //id na tabela que acabou de ser inserida ali, eie, ee...
            $idAtualBaselineCE = $ft->insere();
            $arIdCrud[] = 'CE-C-' . $idAtualBaselineCE;
            $ft->atualizaIsCrud($idAtualBaselineCE, 'C');
            $ft->atualizaIdGerador($idCrudCE, $idAtualBaselineCE);
            $ft->atualizaIdBaseline($idCrudCE, $idAtualBaselineCE);
            //atualiza a lista de cruds
            $fn->atualizaALICrud($idGerador, implode(",", $arIdCrud));
        }
    }
    //retorna com o json para a pagina chamadora
    echo json_encode($ret);
} else {
    echo json_encode(array('id' => 0, 'msg' => 'Acesso n&atilde;o autorizado!'));
}
