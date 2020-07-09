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
require_once 'CRUD.php';
class Baseline extends CRUD {
	private $idEmpresa;
	private $idCliente;
	private $sigla;
	private $descricao;
	private $resumo;
	private $valorPf;
	private $valorHpa;
	private $valorHpc;
	private $isAtivo;
	public function __construct() {
		$this->setTable ( 'baseline' );
		$this->setLog ();
	}
	function setIdEmpresa($idEmpresa) {
		$this->idEmpresa = $idEmpresa;
	}
	function setIdCliente($idCliente) {
		$this->idCliente = $idCliente;
	}
	function setSigla($sigla) {
		$this->sigla = $sigla;
	}
	function setDescricao($descricao) {
		$this->descricao = $descricao;
	}
	function setResumo($resumo) {
		$this->resumo = $resumo;
	}
	function setValorPf($valorPf) {
		$this->valorPf = $valorPf;
	}
	function setValorHpa($valorHpa) {
		$this->valorHpa = $valorHpa;
	}
	function setValorHpc($valorHpc) {
		$this->valorHpc = $valorHpc;
	}
	function setIsAtivo($isAtivo) {
		$this->isAtivo = $isAtivo;
	}
	public function insere() {
		$stm = DB::prepare ( "INSERT INTO baseline (id_empresa, id_cliente, sigla, descricao, resumo, valor_pf, valor_hpc, valor_hpa, is_ativo, atualizado_por, ultima_atualizacao) " . "VALUES (:idEmpresa, :idCliente, :sigla, :descricao, :resumo, :valorPf, :valorHpa, :valorHpc, :isAtivo, :atualizado_por, :ultima_atualizacao)" );
		$stm->bindParam ( ':idEmpresa', $this->idEmpresa, PDO::PARAM_INT );
		$stm->bindParam ( ':idCliente', $this->idCliente, PDO::PARAM_INT );
		$stm->bindParam ( ':sigla', $this->sigla, PDO::PARAM_STR );
		$stm->bindParam ( ':descricao', $this->descricao, PDO::PARAM_STR );
		$stm->bindParam ( ':resumo', $this->resumo, PDO::PARAM_STR );
		$stm->bindParam ( ':valorPf', $this->valorPf );
		$stm->bindParam ( ':valorHpa', $this->valorHpa );
		$stm->bindParam ( ':valorHpc', $this->valorHpc );
		$stm->bindParam ( ':isAtivo', $this->isAtivo, PDO::PARAM_INT );
		$stm->bindParam ( ':atualizado_por', $this->atualizadoPor, PDO::PARAM_STR );
		$stm->bindParam ( ':ultima_atualizacao', $this->ultimaAtualizacao );
		$stm->execute ();
		return DB::getInstance ()->lastInsertId ();
	}
	public function atualiza($id) {
		$stm = DB::prepare ( "UPDATE baseline SET " . "sigla = :sigla, " . "descricao = :descricao, " . "resumo = :resumo, " . "valor_pf = :valorPf, " . "valor_hpa = :valorHpa, " . "valor_hpc = :valorHpc, " . "is_ativo = :isAtivo, " . "atualizado_por = :atualizado_por, " . "ultima_atualizacao = :ultima_atualizacao WHERE id = :id" );
		$stm->bindParam ( ':id', $id, PDO::PARAM_INT );
		$stm->bindParam ( ':sigla', $this->sigla, PDO::PARAM_STR );
		$stm->bindParam ( ':descricao', $this->descricao, PDO::PARAM_STR );
		$stm->bindParam ( ':resumo', $this->resumo, PDO::PARAM_STR );
		$stm->bindParam ( ':valorPf', $this->valorPf );
		$stm->bindParam ( ':valorHpa', $this->valorHpa );
		$stm->bindParam ( ':valorHpc', $this->valorHpc );
		$stm->bindParam ( ':isAtivo', $this->isAtivo, PDO::PARAM_INT );
		$stm->bindParam ( ':atualizado_por', $this->atualizadoPor, PDO::PARAM_STR );
		$stm->bindParam ( ':ultima_atualizacao', $this->ultimaAtualizacao );
		return $stm->execute ();
	}
	public function listaBaseline() {
		$stm = DB::prepare ( "SELECT id, sigla, descricao, resumo, valor_pf, valor_hpc, valor_hpa, is_ativo FROM baseline WHERE id_empresa = :idEmpresa AND id_cliente = :idCliente" );
		$stm->bindParam ( ':idEmpresa', $this->idEmpresa, PDO::PARAM_STR );
		$stm->bindParam ( ':idCliente', $this->idCliente, PDO::PARAM_INT );
		$stm->execute ();
		return $stm->fetchAll ( PDO::FETCH_ASSOC );
	}

	/**
	 *
	 * @param int $t
	 *        	- tipo - 1-Ativo e 01-Ativo/Inativo
	 * @param int $id
	 *        	- se estiver setado seleciona apenas baselines exceto a do id recebido
	 * @return array
	 */
	public function comboBaseline($t, $id = NULL, $a = NULL, $isDashboard = 0) {
		// monta o sql primeiro
		$sql = "SELECT id, sigla, descricao FROM baseline WHERE id_empresa = :idEmpresa AND is_ativo " . ($t === '1' ? ' = 1' : ' in (0, 1)') . (NULL !== $id && $a == 3 ? " AND id <> :id " : " ") . 
		// verificar aqui se eh para o dashboard e seleciona todas as baselines da empresa
		' '; // (!($isDashboard) ? "AND id_cliente = :idCliente" : NULL); TODO: verificar pois tem que listar independente do cliente.
		     // debug
		     // echo '<pre>' . $sql; die();
		$stm = DB::prepare ( $sql );
		$stm->bindParam ( ':idEmpresa', $this->idEmpresa, PDO::PARAM_INT );
		// !($isDashboard) ? $stm->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT) : NULL;
		NULL !== $id && $a == 3 ? $stm->bindParam ( ':id', $id, PDO::PARAM_INT ) : NULL;
		$stm->execute ();
		return $stm->fetchAll ( PDO::FETCH_ASSOC );
	}
	public function getSigla($id) {
		$stm = DB::prepare ( "SELECT sigla, descricao, resumo FROM $this->table WHERE id = $id" );
		$stm->execute ();
		return $stm->fetch ( PDO::FETCH_ASSOC );
	}
	public function alterarStatusBaseline($id) {
		$stm = DB::prepare ( "UPDATE $this->table SET " . "is_ativo = :isAtivo, " . "atualizado_por = :atualizadoPor, " . "ultima_atualizacao = :ultimaAtualizacao " . "WHERE id = :id" );
		$stm->bindParam ( ':isAtivo', $this->isAtivo, PDO::PARAM_INT );
		$stm->bindParam ( ':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR );
		$stm->bindParam ( ':ultimaAtualizacao', $this->ultimaAtualizacao );
		$stm->bindPAram ( ':id', $id, PDO::PARAM_INT );
		return ($stm->execute ());
	}
	public function verificaAcesso($id) {
		$stm = DB::prepare ( "" . "SELECT b.id_empresa, '0' AS id_fornecedor " . "FROM baseline b, empresa e " . "WHERE " . "b.id_empresa = e.id AND " . "b.id = :id" );
		$stm->bindParam ( ':id', $id, PDO::PARAM_INT );
		$stm->execute ();
		if ($stm->columnCount () > 0) {
			$linha = $stm->fetch ( PDO::FETCH_ASSOC );
			$result = array (
					'id_empresa' => $linha ['id_empresa'],
					'id_fornecedor' => $linha ['id_fornecedor']
			);
		} else {
			$result = array (
					'id_empresa' => 0,
					'id_fornecedor' => 0
			);
		}
		return $result;
	}
}
