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
     * instancia da classe Projeto
     */
    $fn = new Projeto();
    $fn->setTable('projeto');
    $fn->setLog();
    /*
     * instancia da classe ClienteConfigProjetoAssinatura
     */
    $ccpa = new ClienteConfigProjetoAssinatura();
    $ccpa->setTable('cliente_config_projeto_assinatura');
    /*
     * atribui a acao INSERIR/ALTERAR a variavel acao
     */
    $acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);
    /*
     * pega o id do contrato mesmo que seja vazio
     */
    $id = NULL !== filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT) : 0;
    /*
     * seta os atributos da classe
     */
    $fn->setIdContrato(filter_input(INPUT_POST, 'id_contrato'));
    $fn->setDescricao(filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS));
    $fn->setIsAtivo(filter_input(INPUT_POST, 'is_ativo'));
    $fn->setDataInicio($fn->setData(filter_input(INPUT_POST, 'data_inicio')));
    $fn->setDataFim($fn->setData(filter_input(INPUT_POST, 'data_fim')));
    $fn->setIdGerenteProjeto(filter_input(INPUT_POST, 'id_gerente_projeto'));
    $fn->setLog();
    /*
     * executa a acao solicitada pelo usuario e retorna o .JSON
     */
    switch ($acao) {
        case 'inserir':
            $insere = $fn->insere();
            /*
             * insere automaticamente as configuracoes das assinaturas para o projeto
             */
            $idProjeto = $insere['id'];
            $ccpa->setIdProjeto($idProjeto);
            $ccpa->setIsAssinaturaRelatorio(1);
            $ccpa->setLog();
            $ccpa->insere();
            echo json_encode($insere);
            break;
        case 'alterar':
            $fn->setLog();
            $atualiza = $fn->atualiza($id);
            echo json_encode($atualiza);
            break;
    }
} else {
    echo json_encode(array('id' => 0, 'msg' => 'Acesso n&atilde;o autorizado!'));
}