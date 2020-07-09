<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos ( $_SERVER ['SCRIPT_NAME'], basename ( __FILE__ ) )) {
	header ( 'Location: /pf/nao_autorizado.php' );
	die ();
}
/*
 * verificacao do status do login
 */
if ($login->isUserLoggedIn () && verificaSessao ()) {
	/*
	 * captura do post
	 */
	$idContagem = filter_input ( INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT );
	$userEmailExecutor = filter_input ( INPUT_POST, 'e', FILTER_SANITIZE_EMAIL );
	$etapaAtualizarBaseline = filter_input ( INPUT_POST, 'eab', FILTER_SANITIZE_NUMBER_INT );
	$dataConclusao = date ( 'Y-m-d H:i:s' );
	/*
	 * instancia as classes
	 */
	$fn = new Contagem ();
	$ch = new ContagemHistorico ();
	$tr = new Tarefa ();
	/*
	 * neste ponto caso a selecao na configuracao seja para atualizar as baselines
	 * na classe Contagem - atualiza por aqui porque eh o mais logico, na contagem
	 * executar apenas em projetos (Abrangencia = 2)
	 */
	if (isFornecedor ()) {
		$contagemFornecedorConfig = new ContagemFornecedorConfig ();
		$configuracoes = $contagemFornecedorConfig->getEtapaAtualizarBaseline ( $idContagem );
		$abrangencia = $configuracoes ['abrangencia'];
		$etapaAtualizarBaseline = $configuracoes ['etapa_atualizar_baseline'];
		// DEBUG_MODE
		DEBUG_MODE ? error_log ( 'Abrangencia: ' . $abrangencia ) : NULL;
		DEBUG_MODE ? error_log ( 'Processo: ' . $etapaAtualizarBaseline ) : NULL;
		/*
		 * verifica os processos e atualiza a baseline
		 */
		($abrangencia == 2 && $etapaAtualizarBaseline == 10) ? $fn->atualizarBaseline ( $idContagem ) : NULL;
	} else {
		$contagemConfig = new ContagemConfig ();
		$configuracoes = $contagemConfig->getEtapaAtualizarBaseline ( $idContagem );
		$abrangencia = $configuracoes ['abrangencia'];
		$etapaAtualizarBaseline = $configuracoes ['etapa_atualizar_baseline'];
		// DEBUG_MODE
		DEBUG_MODE ? error_log ( 'Abrangencia: ' . $abrangencia ) : NULL;
		DEBUG_MODE ? error_log ( 'Processo: ' . $etapaAtualizarBaseline ) : NULL;
		/*
		 * verifica os processos e atualiza a baseline
		 */
		($abrangencia == 2 && $etapaAtualizarBaseline == 10) ? $fn->atualizarBaseline ( $idContagem ) : NULL;
	}
	/*
	 * ******************************
	 *
	 * 1 - Em elaboracao
	 * 2 - Em validacao interna
	 * 3 - Em validacao externa
	 * 4 - Em auditoria interna
	 * 5 - Em auditoria externa
	 * 6 - Em revisao
	 * 7 - Faturada
	 * 8 - Em revisao (validacao interna)
	 * 9 - Em revisao (validacao externa)
	 * 10- Validacao interna automatica
	 *
	 * *******************************
	 */
	/*
	 * set a auditor interno
	 */
	$fn->setValidadorInterno ( $userEmailExecutor );
	/*
	 * variaveis para a tarefa de validacao interna automatica
	 */
	$dataFim = date ( 'Y-m-d H:i:s' );
	$tr->setIdContagem ( $idContagem );
	$tr->setIdTipo ( 13 ); // validacao interna automatica
	$tr->setIdEmpresa ( getIdEmpresa () );
	$tr->setIdFornecedor ( getIdFornecedor () );
	$tr->setDescricao ( 'VALIDACAO INTERNA AUTOMATICA na contagem #ID: ' . str_pad ( $idContagem, 7, '0', STR_PAD_LEFT ) );
	$tr->setUserIdSolicitante ( getUserIdDecoded () );
	$tr->setUserEmailSolicitante ( getEmailUsuarioLogado () );
	$tr->setUserIdExecutor ( getUserIdDecoded () );
	$tr->setUserEmailExecutor ( getEmailUsuarioLogado () );
	$tr->setDataInicio ( date ( 'Y-m-d H:i:s' ) );
	$tr->setDataFim ( $dataFim );
	$tr->setDataConclusao ( $dataFim );
	$tr->setConcluidoPor ( $userEmailExecutor );
	$idTarefa = $tr->insere ();
	/*
	 * a contagem apenas cria uma tarefa de validacao interna
	 */
	$fn->atualizaProcessoValidacaoInterna ( $idContagem, true ); // true = valida todas as funcionalidades
	/*
	 * cria um novo processo dentro da trilha da contagem
	 */
	$ch->setIdProcesso ( 10 ); // no historico da contagem - Em validacao externas
	$ch->setIdContagem ( $idContagem );
	$ch->setDataInicio ( date ( 'Y-m-d H:i:s' ) );
	$ch->setDataFim ( $dataFim );
	$ch->setAtualizadoPor ( getEmailUsuarioLogado () );
	$ch->setFinalizadoPor ( getEmailUsuarioLogado () );
	$ch->setIdTarefa ( $idTarefa );
	$ch->setIsInserirFinalizado ( true );
	$ch->insere ();
	/*
	 * baixa a tarefa de elaboracao da contagem
	 */
	$tarefa = $ch->getProcessoAtual ( $idContagem, 1 );
	$idBaixa = $tarefa ['id_tarefa'];
	// atualizar a tarefa de validacao da contagem
	$tr->setDataConclusao ( $dataConclusao );
	$tr->setConcluidoPor ( getEmailUsuarioLogado () );
	$tr->conclui ( $idBaixa );
	/*
	 * baixa o historico da atividade de elaboracao da contagem
	 */
	$ch->setIdContagem ( $idContagem );
	$ch->setDataFim ( $dataFim );
	$ch->setFinalizadoPor ( getEmailUsuarioLogado () );
	$ch->setIdProcesso ( 1 );
	$ch->finalizaTarefaElaboracao ();
	/*
	 * retorna para o script chamador
	 */
	echo json_encode ( array (
			'msg' => 'A contagem foi validada automaticamente.'
	) );
} else {
	echo json_encode ( array (
			'msg' => 'Acesso n&atilde;o autorizado!'
	) );
}