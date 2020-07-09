<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
//seta as variaveis
$table = NULL !== filter_input(INPUT_POST, 'tabela', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'tabela', FILTER_SANITIZE_STRING) : 0;
$id = NULL !== filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT) : 0;
$abrangenciaAtual = NULL !== filter_input(INPUT_POST, 'abrangencia_atual', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'abrangencia_atual', FILTER_SANITIZE_NUMBER_INT) : 0;
$operacao = NULL !== filter_input(INPUT_POST, 'operacao', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'operacao', FILTER_SANITIZE_STRING) : 0;
$isCrud = NULL !== filter_input(INPUT_POST, 'isCrud', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'isCrud', FILTER_SANITIZE_NUMBER_INT) : 0;
if ($table && ($table === 'ALI' || $table === 'AIE' || $table === 'EE' || $table === 'SE' || $table === 'CE' || $table === 'OU') && $id && $abrangenciaAtual && $abrangenciaAtual <= 10 && ($isCrud == 0 || $isCrud == 1)) {
    /*
     * instancia a classe
     */
    switch ($table) {
        case 'ALI':
        case 'AIE': $fn = new FuncaoDados();
            break;
        case 'SE':
        case 'CE':
        case 'EE': $fn = new FuncaoTransacao();
            break;
        case 'OU': $fn = new FuncaoOutros();
            break;
    }
    /*
     * seta a tabela (vai setar outra vez mais abaixo no codigo)
     */
    $fn->setTable(strtolower($table));
    /*
     * verifica as responsabilidades
     */
    $contagem = new Contagem();
    $usuario = new Usuario();
    $email = getEmailUsuarioLogado();
    $userId = getUserIdDecoded();
    $idFornecedor = getIdFornecedor();
    $idContagem = $fn->getIdContagem($id)['id_contagem'];
    /*
     * responsavel gestor e gestor_fornecedor
     */
    $isResponsavel = $contagem->isResponsavel($email, $idContagem);
    $isGestor = $usuario->isGestor($userId);
    $isGestorFornecedor = $usuario->isGestorFornecedor($userId, $idFornecedor);
    /*
     * verificacao do status do login
     */
    if ($login->isUserLoggedIn() && verificaSessao() && ($isResponsavel || $isGestor || $isGestorFornecedor)) {
        /*
         * verifica primeiro se um ALI CRUD porque tem que excluir todas as CRUDS
         */
        if ($isCrud && $table === 'ALI') {
            $fn->setTable('ali');
            $idCrud = explode(',', $fn->getIdCrud($id)['id_crud']);
            $ft = new FuncaoTransacao();
            for ($x = 0; $x < count($idCrud); $x++) {
                $linha = explode('-', $idCrud[$x]);
                $ft->setTable($linha[0]);
                $ft->exclui($linha[2]);
            }
        }
        /*
         * verifica se foi inserida por um CRUD e atualiza a tabela ALI com as referencias
         */ else if ($isCrud) {
            $ftExcluir = new FuncaoTransacao();
            $ftExcluir->setTable(strtolower($table));
            $linhaExcluir = $ftExcluir->getALICrud($id, strtolower($table), $abrangenciaAtual);
            $linhaIdCrud = $table . '-' . $linhaExcluir['tipo_crud'] . '-' . $id;
            $posExcluir = strpos($linhaExcluir['id_crud'], $linhaIdCrud);
            $strExcluir = substr($linhaExcluir['id_crud'], $posExcluir, (5 + strlen($id)));
            /*
             * aponta para a tabela ALI
             */
            $fnExcluir = new FuncaoDados();
            $fnExcluir->setTable('ali');
            /*
             * verifica as restricoes finais de excluir no meio do caracter e/ou no final retirando a virgula ou as virgulas
             */
            $idCrudAtualizado1 = str_replace(',,', ',', str_replace($strExcluir, '', $linhaExcluir['id_crud']));
            $idCrudAtualizado2 = substr($idCrudAtualizado1, -1) === ',' ?
                    substr($idCrudAtualizado1, 0, strlen($idCrudAtualizado1) - 1) :
                    (substr($idCrudAtualizado1, 0, 1) === ',' ? substr($idCrudAtualizado1, 1, strlen($idCrudAtualizado1) - 1) : $idCrudAtualizado1);
            $fnExcluir->atualizaIdCrud($linhaExcluir['id'], $idCrudAtualizado2);
            /*
             * se for baseline tem que retirar a referencia da baseline tambem
             */
            if ($abrangenciaAtual == 2) {
                $idBaselineFuncao = $linhaExcluir['id_baseline'];
                /*
                 * com o id_baseline pega a string novamente
                 */
                $linhaIdCrudBaseline = $table . '-' . $linhaExcluir['tipo_crud'] . '-' . $idBaselineFuncao;
                $posExcluirBaseline = strpos($idCrudAtualizado2, $linhaIdCrudBaseline);
                $strExcluirBaseline = substr($idCrudAtualizado2, $posExcluirBaseline, (5 + strlen($idBaselineFuncao)));
                /*
                 * verifica as restricoes finais de excluir no meio do caracter e/ou no final retirando a virgula ou as virgulas
                 */
                $idCrudAtualizado3 = str_replace(',,', ',', str_replace($strExcluirBaseline, '', $idCrudAtualizado2));
                $idCrudAtualizado4 = substr($idCrudAtualizado3, -1) === ',' ?
                        substr($idCrudAtualizado3, 0, strlen($idCrudAtualizado3) - 1) :
                        (substr($idCrudAtualizado3, 0, 1) === ',' ? substr($idCrudAtualizado3, 1, strlen($idCrudAtualizado3) - 1) : $idCrudAtualizado3);
                $fnExcluir->atualizaIdCrud($linhaExcluir['id'], $idCrudAtualizado4);
            }
        }
        /*
         * seta as atualizacoes
         */
        $fn->setLog();
        /*
         * seta a tabela
         */
        $fn->setTable(strtolower($table));
        /*
         * excluir primeiro a funcao da baseline
         */
        if ($abrangenciaAtual == 2) {//contagem de projeto
            $con = new Contagem();
            $funcaoBaseline = $con->getIdFuncaoBaseline($id, $table);
            $idFuncaoBaseline = $funcaoBaseline['id_baseline'];
            $idRelacionamento = $funcaoBaseline['id_relacionamento'];
            /*
             * atualiza novamente o status da funcao de baseline antiga para ativo (1)
             */
            $fn->atualizaCampo($table, 'is_ativo', $idRelacionamento, 1);
            /*
             * exclui tambem a funcao de baseline caso ainda nao esteja validada
             */
            $exclui = $fn->exclui($idFuncaoBaseline);
        }
        /*
         * exclui a funcao original
         */
        $exclui = $fn->exclui($id);
        /*
         * monta o retorno
         */
        $ret = array();
        /*
         * json de retorno
         */
        if ($fn) {
            $ret[] = array('isExcluida' => 1);
        } else {
            $ret[] = array('isExcluida' => 0);
        }
        /*
         * retorna para a funcao chamadora api.js->function excluirLinha(id, tb, node, pfa, pfb)
         */
        echo json_encode($ret);
    } else {
        echo json_encode(array('isExcluida' => 0, 'msg' => 'Acesso n&atilde;o autorizado!'));
    }
} else {
    echo json_encode(array('isExcluida' => 0, 'msg' => 'Acesso n&atilde;o autorizado!'));
}