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
if ($login->isUserLoggedIn() && getPermissao('gerenciar_contrato') && verificaSessao()) {
    /*
     * atribui a acao INSERIR/ALTERAR a variavel acao
     */
    $acao = NULL !== filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING) : 0;
    /*
     * pega o id do contrato mesmo que seja vazio
     */
    $id = NULL !== filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT) ? intval(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT)) : 0;
    /*
     * pega antes o id do cliente
     */
    $idCliente = NULL !== filter_input(INPUT_POST, 'id_cliente', FILTER_SANITIZE_NUMBER_INT) ? intval(filter_input(INPUT_POST, 'id_cliente', FILTER_SANITIZE_NUMBER_INT)) : 0;
    /*
     * verifica as variaveis
     */
    if ($acao !== 'inserir' && $acao !== 'alterar') {
        echo json_encode(array('id' => 0, 'msg' => 'Acao::DIF::Alterar::Inserir'));
    } elseif (!is_int($id) || !is_int($idCliente)) {
        echo json_encode(array('id' => 0, 'msg' => 'Acao::DIF::Intval'));
    } else {
        /*
         * verifica se o usuario pode inserir um contrato neste cliente
         */
        $cl = new Cliente();
        $pass = $cl->verificaAcesso($idCliente);
        if ($pass['id_empresa'] == getIdEmpresa() && $pass['id_fornecedor'] == getIdFornecedor()) {
            /*
             * instancia da classe Contrato
             */
            $fn = new Contrato();
            $fn->setLog();
            /*
             * seta os atributos da classe
             */
            $fn->setAno(filter_input(INPUT_POST, 'ano', FILTER_SANITIZE_NUMBER_INT));
            $fn->setNumero(filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_SPECIAL_CHARS));
            $fn->setUf(filter_input(INPUT_POST, 'uf', FILTER_SANITIZE_SPECIAL_CHARS));
            $fn->setIdCliente(filter_input(INPUT_POST, 'id_cliente', FILTER_SANITIZE_NUMBER_INT));
            $fn->setIsAtivo(filter_input(INPUT_POST, 'is_ativo'), FILTER_SANITIZE_NUMBER_INT);
            $fn->setPFContratado(filter_input(INPUT_POST, 'pf_contratado', FILTER_SANITIZE_NUMBER_INT));
            $fn->setValorPF(filter_input(INPUT_POST, 'valor_pf'));
            $fn->setDataInicio($fn->setData(filter_input(INPUT_POST, 'data_inicio'), FILTER_SANITIZE_STRING));
            $fn->setDataFim($fn->setData(filter_input(INPUT_POST, 'data_fim'), FILTER_SANITIZE_STRING));
            $fn->setTipo(filter_input(INPUT_POST, 'tipo'), FILTER_SANITIZE_STRING);
            $fn->setIdPrimario(filter_input(INPUT_POST, 'id_primario'), FILTER_SANITIZE_NUMBER_INT);
            $fn->setValorHpc(filter_input(INPUT_POST, 'valor_hpc'));
            $fn->setValorHpa(filter_input(INPUT_POST, 'valor_hpa'));
            /*
             * executa a acao solicitada pelo usuario e retorna o .JSON
             */
            switch ($acao) {
                case 'inserir': echo json_encode($fn->insere());
                    break;
                case 'alterar': echo json_encode($fn->atualiza($id));
                    break;
            }
        } else {
            echo json_encode(array('id' => 0, 'msg' => 'Acao::DIF::idEmpresa::IdFornecedor'));
        }
    }
} else {
    echo json_encode(array('id' => 0, 'msg' => 'Acao::DIF::NLogado::AcessoNegado'));
}