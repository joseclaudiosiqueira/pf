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

	$fa = new Comentario ();
	$fa->setLog ();
	/*
	 * variaveis do post
	 */
	$idExterno = filter_input ( INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT );
	$tabela = filter_input ( INPUT_POST, 't', FILTER_SANITIZE_STRING );
	$dataInsercao = date ( 'Y-m-d H:i:s' );
	$userId = $converter->decode ( getUserId () );
	$comentario = filter_input ( INPUT_POST, 'c' );
	$destinatario = filter_input ( INPUT_POST, 'd', FILTER_SANITIZE_EMAIL );
	$status = $destinatario === getEmailUsuarioLogado () ? 1 : 0;
	$dataLeitura = $destinatario === getEmailUsuarioLogado () ? date ( 'Y-m-d H:i:s' ) : null;
	$isVisivel = 1;
	$roleId = getVariavelSessao ( 'roleId' );
	$idEmpresa = getIdEmpresa ();
	$idFornecedor = getIdFornecedor ();
	$idCliente = getIdClienteFornecedor ();

	$fa->setIdExterno ( $idExterno );
	$fa->setTabela ( $tabela );
	$fa->setDataInsercao ( $dataInsercao );
	$fa->setUserId ( $userId );
	$fa->setIdEmpresa ( $idEmpresa );
	$fa->setIdFornecedor ( $idFornecedor );
	$fa->setIdCliente ( $idCliente );
	$fa->setComentario ( $comentario );
	$fa->setDestinatario ( $destinatario );
	$fa->setStatus ( $status );
	$fa->setDataLeitura ( $dataLeitura );
	$fa->setIsVisivel ( $isVisivel );
	$fa->setRoleId ( $roleId );
	/*
	 * em caso de ambiente de producao envia email ao destinatario
	 */
	if (PRODUCAO) {
		switch ($tabela) {
			case 'ali' :
			case 'aie' :
				$fn = new FuncaoDados ();
				break;
			case 'ee' :
			case 'se' :
			case 'ce' :
				$fn = new FuncaoTransacao ();
				break;
			case 'ou' :
				$fn = new FuncaoOutros ();
				break;
		}
		$fn->setTable ( $tabela );
		$funcao = $fn->consulta ( $idExterno );
		/*
		 * envia um email avisando sobre o comentario
		 */
		enviaEmailComentario ( $tabela, $destinatario, $funcao, $comentario, $objEmail );
	}
	/*
	 * retorna
	 */
	echo json_encode ( $fa->getComentario ( $fa->insere () ) );
} else {
	echo json_encode ( array (
			'id' => 0,
			'msg' => 'Acesso n&atilde;o autorizado!'
	) );
}


