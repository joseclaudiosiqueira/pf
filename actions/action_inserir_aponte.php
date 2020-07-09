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
    $fa = new ContagemApontes();
    $co = new Contagem();
    $ue = new UsersEmpresa();
    //variaveis do post
    $idContagem = filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT);
    $tipo = filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING);
    $dataInsercao = date('Y-m-d H:i:s');
    $userIdSolicitante = getUserIdDecoded();
    $userEmailSolicitante = getEmailUsuarioLogado();
    $aponte = filter_input(INPUT_POST, 'a');
    $userEmailExecutor = filter_input(INPUT_POST, 'd', FILTER_SANITIZE_EMAIL);
    $userIdExecutor = $ue->getUserId($userEmailExecutor, getIdEmpresa());
    $inseridoPor = getEmailUsuarioLogado();
    $idEmpresa = getIdEmpresa();
    /*
     * o fornecedor sera sempre o fornecedor da contagem no caso de validacoes externas de fornecedores
     */
    $idFornecedor = $co->getIdFornecedor($idContagem)['id_fornecedor'];
    //cria uma tarefa e associa ao aponte para conclusao posterior
    $tr = new Tarefa();
    $tr->setTable('tarefas');
    //parametros da tarefa
    switch ($tipo) {
        case 'ai': $idTipo = 7;
            $descricaoTipo = 'AUDITORIA INTERNA';
            $prazoConclusao = '+' . $_SESSION['contagem_config_tarefas']['aponte_auditoria_interna'] . ' days';
            $dataFim = date('Y-m-d H:i:s', strtotime($prazoConclusao));
            break;
        case 'ae': $idTipo = 8;
            $descricaoTipo = 'AUDITORIA EXTERNA';
            $prazoConclusao = '+' . $_SESSION['contagem_config_tarefas']['aponte_auditoria_externa'] . ' days';
            $dataFim = date('Y-m-d H:i:s', strtotime($prazoConclusao));
            break;
        case 'vi': $idTipo = 9;
            $prazoConclusao = '+' . $_SESSION['contagem_config_tarefas']['revisao_validacao_interna'] . ' days';
            $dataFim = date('Y-m-d H:i:s', strtotime($prazoConclusao));
            $descricaoTipo = 'VALIDAÇÃO INTERNA';
            break;
        case 've': $idTipo = 10;
            $descricaoTipo = 'VALIDAÇÃO EXTERNA';
            $prazoConclusao = '+' . $_SESSION['contagem_config_tarefas']['revisao_validacao_externa'] . ' days';
            $dataFim = date('Y-m-d H:i:s', strtotime($prazoConclusao));
            break;
    }
    $tr->setIdContagem($idContagem);
    $tr->setIdTipo($idTipo);
    $tr->setIdEmpresa($idEmpresa);
    $tr->setIdFornecedor($idFornecedor);
    $tr->setDescricao('APONTE DE ' . $descricaoTipo . ' na contagem #ID: ' . str_pad($idContagem, 6, '0', STR_PAD_LEFT));
    $tr->setUserIdSolicitante($userIdSolicitante);
    $tr->setUserEmailSolicitante($userEmailSolicitante);
    $tr->setUserIdExecutor($userIdExecutor);
    $tr->setUserEmailExecutor($userEmailExecutor);
    $tr->setDataInicio(date('Y-m-d H:i:s'));
    $tr->setDataFim($dataFim);
    //insere a tarefa e pega o id
    $idTarefa = $tr->insere();
    //seta as variaveis do aponte
    $fa->setIdContagem($idContagem);
    $fa->setIdTarefa($idTarefa);
    $fa->setTipo($tipo);
    $fa->setAponte($aponte);
    $fa->setDestinatario($userEmailExecutor);
    $fa->setDataInsercao($dataInsercao);
    $fa->setInseridoPor($inseridoPor);
    $fa->setUserId($userIdSolicitante);
    /*
     * neste novo modelo seta o id aqui
     */
    $fa->setId($fa->insere());
    /*
     * envia email apenas em ambiente de producao
     */
    if (PRODUCAO) {
        //idContagem, responsavel e tipo
        emailInserirAponte($idContagem, $userEmailExecutor, $tipo, $objEmail);
    }
    echo json_encode($fa->getAponte($fa->getId()));
} else {
    echo json_encode(array('id' => 0, 'msg' => 'Acesso n&atilde;o autorizado!'));
}