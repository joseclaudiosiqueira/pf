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
	// variaveis do post
	$id = filter_input ( INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT );
	$tpo = filter_input ( INPUT_POST, 't', FILTER_SANITIZE_STRING );
	// seta os usuarios que vao finalizar os processos
	$validadorInterno = getEmailUsuarioLogado ();
	$validadorExterno = getEmailUsuarioLogado ();
	$auditorInterno = getEmailUsuarioLogado ();
	$auditorExterno = getEmailUsuarioLogado ();
	// usuario logado no momento sera o concluinte das atividades
	$concluidoPor = getEmailUsuarioLogado ();
	$finalizadoPor = getEmailUsuarioLogado ();
	$dataFim = date ( 'Y-m-d H:i:s' );
	$dataConclusao = date ( 'Y-m-d H:i:s' );
	// variavel de retorno
	$sucesso = false;
	// instancia das classes
	$fn = new Contagem ();
	$ch = new ContagemHistorico ();
	$ch->setIsAtualizandoProcesso ( true );
	$tr = new Tarefa ();
	$idTarefa = 0;
	// verifica qual acao sera executada
	if ($tpo === 'vi') {
		// verifica se esta tudo certo para a validacao interna da contagem
		$qtd = $fn->verificaFuncoesValidacao ( $id );
		// apenas se todos os itens podem ser validados
		if ($qtd == 0) {
			// atualiza o processo de validacao interna e o validador
			$fn->setIsProcessoValidacao ( 1 );
			$fn->setValidadorInterno ( $validadorInterno );
			$fn->atualizaProcessoValidacaoInterna ( $id, false );
			// atualiza o historico da contagem
			$tarefa = $ch->getProcessoAtual ( $id, 2 );
			$idTarefa = $tarefa ['id_tarefa'];
			// id para finalizar o historico da contagem
			$idHistorico = $tarefa ['id'];
			// atualizar a tarefa de validacao da contagem
			$tr->setDataConclusao ( $dataConclusao );
			$tr->setConcluidoPor ( $concluidoPor );
			$tr->conclui ( $idTarefa );
			// atualiza o processo de validacao interna da contagem
			$ch->setDataFim ( $dataFim );
			$ch->setFinalizadoPor ( $finalizadoPor );
			$ch->setId ( $idHistorico );
			$ch->finalizaProcesso ();
			/*
			 * neste ponto caso a selecao na configuracao seja para atualizar as baselines
			 * na classe Contagem - atualiza por aqui porque eh o mais logico, na contagem
			 * executar apenas em projetos (Abrangencia = 2)
			 */
			if (isFornecedor ()) {
				$contagemFornecedorConfig = new ContagemFornecedorConfig ();
				$configuracoes = $contagemFornecedorConfig->getEtapaAtualizarBaseline ( $id );
				$abrangencia = $configuracoes ['abrangencia'];
				$etapaAtualizarBaseline = $configuracoes ['etapa_atualizar_baseline'];
				// DEBUG_MODE
				DEBUG_MODE ? error_log ( 'Abrangencia: ' . $abrangencia ) : NULL;
				DEBUG_MODE ? error_log ( 'Processo: ' . $etapaAtualizarBaseline ) : NULL;
				/*
				 * verifica os processos e atualiza a baseline
				 */
				($abrangencia == 2 && $etapaAtualizarBaseline == 2) ? $fn->atualizarBaseline ( $id ) : NULL;
			} else {
				$contagemConfig = new ContagemConfig ();
				$configuracoes = $contagemConfig->getEtapaAtualizarBaseline ( $id );
				$abrangencia = $configuracoes ['abrangencia'];
				$etapaAtualizarBaseline = $configuracoes ['etapa_atualizar_baseline'];
				// DEBUG_MODE
				DEBUG_MODE ? error_log ( 'Abrangencia: ' . $abrangencia ) : NULL;
				DEBUG_MODE ? error_log ( 'Processo: ' . $etapaAtualizarBaseline ) : NULL;
				/*
				 * verifica os processos e atualiza a baseline
				 */
				($abrangencia == 2 && $etapaAtualizarBaseline == 2) ? $fn->atualizarBaseline ( $id ) : NULL;
			}
			// atualiza a variavel de retorno
			$sucesso = true;
		}
	} elseif ($tpo === 've') { // verifica se esta tudo certo para a validacao externa da contagem
		$qtd = $fn->verificaFuncoesValidacao ( $id );
		// apenas se todos os itens podem ser validados
		if ($qtd == 0) {
			// atualiza o processo de validacao externa e o validador
			$fn->setValidadorExterno ( $validadorExterno );
			$fn->atualizaProcessoValidacaoExterna ( $id, false );
			// atualiza o historico da contagem
			$tarefa = $ch->getProcessoAtual ( $id, 3 );
			$idTarefa = $tarefa ['id_tarefa'];
			// id para finalizar o historico da contagem
			$idHistorico = $tarefa ['id'];
			// atualizar a tarefa de validacao da contagem
			$tr->setDataConclusao ( date ( 'Y--m-d H:i:s' ) );
			$tr->setConcluidoPor ( getEmailUsuarioLogado () );
			$tr->conclui ( $idTarefa );
			// atualiza o processo de validacao externa da contagem
			$ch->setDataFim ( $dataFim );
			$ch->setFinalizadoPor ( $finalizadoPor );
			$ch->setId ( $idHistorico );
			$ch->finalizaProcesso ();
			/*
			 * neste ponto caso a selecao na configuracao seja para atualizar as baselines
			 * na classe Contagem - atualiza por aqui porque eh o mais logico, na contagem
			 * executar apenas em projetos (Abrangencia = 2)
			 */
			if (isFornecedor ()) {
				$contagemFornecedorConfig = new ContagemFornecedorConfig ();
				$configuracoes = $contagemFornecedorConfig->getEtapaAtualizarBaseline ( $id );
				$abrangencia = $configuracoes ['abrangencia'];
				$etapaAtualizarBaseline = $configuracoes ['etapa_atualizar_baseline'];
				// DEBUG_MODE
				DEBUG_MODE ? error_log ( 'Abrangencia: ' . $abrangencia ) : NULL;
				DEBUG_MODE ? error_log ( 'Processo: ' . $etapaAtualizarBaseline ) : NULL;
				/*
				 * verifica os processos e atualiza a baseline
				 */
				($abrangencia == 2 && $etapaAtualizarBaseline == 3) ? $fn->atualizarBaseline ( $id ) : NULL;
			} else {
				$contagemConfig = new ContagemConfig ();
				$configuracoes = $contagemConfig->getEtapaAtualizarBaseline ( $id );
				$abrangencia = $configuracoes ['abrangencia'];
				$etapaAtualizarBaseline = $configuracoes ['etapa_atualizar_baseline'];
				// DEBUG_MODE
				DEBUG_MODE ? error_log ( 'Abrangencia: ' . $abrangencia ) : NULL;
				DEBUG_MODE ? error_log ( 'Processo: ' . $etapaAtualizarBaseline ) : NULL;
				/*
				 * verifica os processos e atualiza a baseline
				 */
				($abrangencia == 2 && $etapaAtualizarBaseline == 3) ? $fn->atualizarBaseline ( $id ) : NULL;
			}
			// atualiza a variavel de retorno
			$sucesso = true;
		}
	} elseif ($tpo === 'ai') {
		// atualiza o processo de auditoria interna e o auditor
		$fn->setAuditorInterno ( $auditorInterno );
		$fn->atualizaProcessoAuditoriaInterna ( $id, false );
		// atualiza o historico da contagem
		$tarefa = $ch->getProcessoAtual ( $id, 4 );
		$idTarefa = $tarefa ['id_tarefa'];
		// id para finalizar o historico da contagem
		$idHistorico = $tarefa ['id'];
		// atualizar a tarefa de validacao da contagem
		$tr->setDataConclusao ( date ( 'Y--m-d H:i:s' ) );
		$tr->setConcluidoPor ( getEmailUsuarioLogado () );
		$tr->conclui ( $idTarefa );
		// atualiza o processo de auditoria interna da contagem
		$ch->setDataFim ( $dataFim );
		$ch->setFinalizadoPor ( $finalizadoPor );
		$ch->setId ( $idHistorico );
		$ch->finalizaProcesso ();
		// atualiza
		$sucesso = true;
	} elseif ($tpo === 'ae') {
		// atualiza o processo de auditoria interna e o auditor
		$fn->setAuditorExterno ( $auditorExterno );
		$fn->atualizaProcessoAuditoriaExterna ( $id, false );
		// atualiza o historico da contagem
		$tarefa = $ch->getProcessoAtual ( $id, 5 );
		$idTarefa = $tarefa ['id_tarefa'];
		// id para finalizar o historico da contagem
		$idHistorico = $tarefa ['id'];
		// atualizar a tarefa de validacao da contagem
		$tr->setDataConclusao ( date ( 'Y--m-d H:i:s' ) );
		$tr->setConcluidoPor ( getEmailUsuarioLogado () );
		$tr->conclui ( $idTarefa );
		// atualiza o processo de auditoria interna da contagem
		$ch->setDataFim ( $dataFim );
		$ch->setFinalizadoPor ( $finalizadoPor );
		$ch->setId ( $idHistorico );
		$ch->finalizaProcesso ();
		// atualiza
		$sucesso = true;
	}
	if ($sucesso && PRODUCAO) {
		$responsavel = $fn->getResponsavel ( $id ) ['responsavel'];
		// envia o email para os envolvidos informando a conclusao da validacao
		emailValidarContagem ( $id, $tpo, $responsavel, $objEmail );
	}
	// retorna
	echo json_encode ( array (
			'sucesso' => $sucesso,
			'id_tarefa' => $idTarefa
	) );
} else {
	echo json_encode ( array (
			'sucesso' => false,
			'id_tarefa' => 0,
			'msg' => 'Acesso n&atilde;o autorizado!'
	) );
}
