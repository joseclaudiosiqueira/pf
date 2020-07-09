<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos ( $_SERVER ['SCRIPT_NAME'], basename ( __FILE__ ) )) {
	header ( 'Location: /pf/nao_autorizado.php' );
	die ();
}
/*
 * verifica login
 */
if ($login->isUserLoggedIn () && verificaSessao ()) {
	$fa = new Cliente ();
	$roteiro = new Roteiro ();
	$idEmpresa = getIdEmpresa ();
	$idFornecedor = isFornecedor () ? getIdFornecedor () : 0;
	$tipoCliente = 0; // apenas ativos
	$arrClientes = $fa->comboCliente ( $idEmpresa, $idFornecedor, $tipoCliente );
	$retClientes = array ();
	foreach ( $arrClientes as $linha ) {
		// id, id_empresa, id_fornecedor, nome, descricao, sigla
		$file = DIR_APP . 'vendor/cropper/producao/crop/img/img-cli/' . sha1 ( $linha ['id'] ) . '.png';
		$logo = file_exists ( $file ) ? '/pf/vendor/cropper/producao/crop/img/img-cli/' . sha1 ( $linha ['id'] ) . '.png?' . date ( 'Ymdhis' ) : '/pf/img/servico.png';
		/*
		 * pega os roteiros inclusive os exclusivos do Cliente
		 */
		$roteiros = $roteiro->comboRoteiro ( 1, $idEmpresa, $idFornecedor, $linha ['id'] );
		/*
		 * monta os dois arrays
		 */
		$retClientes [] = array (
				'id' => $linha ['id'],
				'id_empresa' => $linha ['id_empresa'],
				'id_fornecedor' => $linha ['id_fornecedor'],
				'nome' => $linha ['nome'],
				'descricao' => $linha ['descricao'],
				'sigla' => $linha ['sigla'],
				'email' => strlen ( $linha ['email'] ) > 0 ? $linha ['email'] : 'nao@fornecido',
				'telefone' => strlen ( $linha ['telefone'] ) > 0 ? $linha ['telefone'] : '(00) 0000-0000',
				'logo' => $logo,
				'roteiros' => $roteiros
		);
	}
	/*
	 * agora tem que mesclar os dois arrays
	 */
	echo json_encode ( array (
			'clientes' => $retClientes
	) );
} else {
	echo json_encode ( array (
			'msg' => 'Acesso n&atilde;o autorizado!'
	) );
}