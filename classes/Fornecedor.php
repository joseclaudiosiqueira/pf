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
class Fornecedor extends CRUD {
	private $idEmpresa;
	private $sigla;
	private $nome;
	private $prepostoNome;
	private $prepostoTelefoneCelular;
	private $prepostoTelefone;
	private $prepostoRamal;
	private $prepostoEmail;
	private $prepostoEmailAlternativo;
	private $logomarca;
	private $isAtivo;
	private $tipo;
	public function __construct() {
		$this->setTable ( 'fornecedor' );
		$this->setLog ();
	}
	function getIdEmpresa() {
		return $this->idEmpresa;
	}
	function getPrepostoNome() {
		return $this->prepostoNome;
	}
	function getPrepostoTelefoneCelular() {
		return $this->prepostoTelefoneCelular;
	}
	function getPrepostoTelefone() {
		return $this->prepostoTelefone;
	}
	function getPrepostoRamal() {
		return $this->prepostoRamal;
	}
	function getPrepostoEmail() {
		return $this->prepostoEmail;
	}
	function getPrepostoEmailAlternativo() {
		return $this->prepostoEmailAlternativo;
	}
	function getLogomarca() {
		return $this->logomarca;
	}
	function setIdEmpresa($idEmpresa) {
		$this->idEmpresa = $idEmpresa;
	}
	function setSigla($sigla) {
		$this->sigla = $sigla;
	}
	function setNome($nome) {
		$this->nome = $nome;
	}
	function setPrepostoNome($prepostoNome) {
		$this->prepostoNome = $prepostoNome;
	}
	function setPrepostoTelefoneCelular($prepostoTelefoneCelular) {
		$this->prepostoTelefoneCelular = $prepostoTelefoneCelular;
	}
	function setPrepostoTelefone($prepostoTelefone) {
		$this->prepostoTelefone = $prepostoTelefone;
	}
	function setPrepostoRamal($prepostoRamal) {
		$this->prepostoRamal = $prepostoRamal;
	}
	function setPrepostoEmail($prepostoEmail) {
		$this->prepostoEmail = $prepostoEmail;
	}
	function setPrepostoEmailAlternativo($prepostoEmailAlternativo) {
		$this->prepostoEmailAlternativo = $prepostoEmailAlternativo;
	}
	function setLogomarca($logomarca) {
		$this->logomarca = $logomarca;
	}
	function setIsAtivo($isAtivo) {
		$this->isAtivo = $isAtivo;
	}
	function setTipo($tipo) {
		$this->tipo = $tipo;
	}
	function getSigla($id) {
		$stm = DB::prepare ( "SELECT sigla FROM fornecedor WHERE id = :id" );
		$stm->bindParam ( ':id', $id, PDO::PARAM_INT );
		$stm->execute ();
		$sigla = $stm->fetch ( PDO::FETCH_ASSOC );
		return $sigla ['sigla'];
	}
	function getNome($id) {
		$stm = DB::prepare ( "SELECT nome FROM fornecedor WHERE id = :id" );
		$stm->bindParam ( ':id', $id, PDO::PARAM_INT );
		$stm->execute ();
		$nome = $stm->fetch ( PDO::FETCH_ASSOC );
		return $nome ['nome'];
	}
	function getSiglaNome($id) {
		$stm = DB::prepare ( "SELECT sigla, nome FROM $this->table WHERE id = :id" );
		$stm->bindParam ( ':id', $id, PDO::PARAM_INT );
		$stm->execute ();
		$siglaNome = $stm->fetch ( PDO::FETCH_ASSOC );
		return $siglaNome ['sigla'] . ' / ' . $siglaNome ['nome'];
	}
	function getTipo($id) {
		/*
		 * 0 - Fornecedor
		 * 1 - Turma
		 */
		$stm = DB::prepare ( "SELECT tipo FROM fornecedor WHERE id = :id" );
		$stm->bindParam ( ':id', $id, PDO::PARAM_INT );
		$stm->execute ();
		$tipo = $stm->fetch ( PDO::FETCH_ASSOC );
		return $tipo ['tipo'] == 1 ? 1 : 0;
	}
	function isAtivo($idFornecedor) {
		$stm = DB::prepare ( "SELECT is_ativo FROM fornecedor WHERE id = :id" );
		$stm->bindParam ( ':id', $idFornecedor, PDO::PARAM_INT );
		$stm->execute ();
		$isAtivo = $stm->fetch ( PDO::FETCH_ASSOC );
		return $isAtivo ['is_ativo'] == 1 ? 1 : 0;
	}
	public function insere() {
		$stm = DB::prepare ( "INSERT INTO $this->table " . "(id_empresa, " . "sigla, " . "nome, " . "preposto_nome, " . "preposto_telefone, " . "preposto_ramal, " . "preposto_telefone_celular, " . "preposto_email, " . "preposto_email_alternativo, " . "tipo, " . "is_ativo, " . "ultima_atualizacao, " . "atualizado_por) VALUES (" . ":idEmpresa, " . ":sigla, " . ":nome, " . ":prepostoNome, " . ":prepostoTelefone, " . ":prepostoRamal, " . ":prepostoTelefoneCelular, " . ":prepostoEmail, " . ":prepostoEmailAlternativo, " . ":tipo, " . ":isAtivo, " . ":ultimaAtualizacao," . ":atualizadoPor)" );
		$stm->bindPAram ( ':idEmpresa', $this->idEmpresa, PDO::PARAM_INT );
		$stm->bindPAram ( ':sigla', $this->sigla, PDO::PARAM_STR );
		$stm->bindPAram ( ':nome', $this->nome, PDO::PARAM_STR );
		$stm->bindPAram ( ':prepostoNome', $this->prepostoNome, PDO::PARAM_STR );
		$stm->bindPAram ( ':prepostoTelefone', $this->prepostoTelefone, PDO::PARAM_STR );
		$stm->bindPAram ( ':prepostoRamal', $this->prepostoRamal, PDO::PARAM_STR );
		$stm->bindPAram ( ':prepostoTelefoneCelular', $this->prepostoTelefoneCelular, PDO::PARAM_STR );
		$stm->bindPAram ( ':prepostoEmail', $this->prepostoEmail, PDO::PARAM_STR );
		$stm->bindPAram ( ':prepostoEmailAlternativo', $this->prepostoEmailAlternativo, PDO::PARAM_STR );
		$stm->bindPAram ( ':tipo', $this->tipo, PDO::PARAM_INT );
		$stm->bindPAram ( ':isAtivo', $this->isAtivo, PDO::PARAM_INT );
		$stm->bindParam ( ':ultimaAtualizacao', $this->ultimaAtualizacao );
		$stm->bindParam ( ':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR );
		$stm->execute ();
		return DB::getInstance ()->lastInsertId ();
	}
	public function atualiza($id) {
		$stm = DB::prepare ( "UPDATE $this->table SET " . "sigla = :sigla, " . "nome = :nome, " . "preposto_nome = :prepostoNome, " . "preposto_telefone = :prepostoTelefone, " . "preposto_ramal = :prepostoRamal, " . "preposto_telefone_celular = :prepostoTelefoneCelular, " . "preposto_email = :prepostoEmail, " . "preposto_email_alternativo = :prepostoEmailAlternativo, " . "is_ativo = :isAtivo, " . "ultima_atualizacao = :ultimaAtualizacao, " . "atualizado_por = :atualizadoPor " . "WHERE id = :id" );
		$stm->bindParam ( ':sigla', $this->sigla, PDO::PARAM_STR );
		$stm->bindParam ( ':nome', $this->nome, PDO::PARAM_STR );
		$stm->bindParam ( ':prepostoNome', $this->prepostoNome, PDO::PARAM_STR );
		$stm->bindParam ( ':prepostoTelefone', $this->prepostoTelefone, PDO::PARAM_STR );
		$stm->bindParam ( ':prepostoRamal', $this->prepostoRamal, PDO::PARAM_STR );
		$stm->bindParam ( ':prepostoTelefoneCelular', $this->prepostoTelefoneCelular, PDO::PARAM_STR );
		$stm->bindParam ( ':prepostoEmail', $this->prepostoEmail, PDO::PARAM_STR );
		$stm->bindParam ( ':prepostoEmailAlternativo', $this->prepostoEmailAlternativo, PDO::PARAM_STR );
		$stm->bindPAram ( ':isAtivo', $this->isAtivo, PDO::PARAM_INT );
		$stm->bindParam ( ':ultimaAtualizacao', $this->ultimaAtualizacao );
		$stm->bindParam ( ':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR );
		$stm->bindParam ( ':id', $id, PDO::PARAM_INT );
		return $stm->execute ();
	}
	public function comboFornecedor($idEmpresa, $tipo, $tp) {
		if ($tipo === '01') {
			$sql = "SELECT id, id_empresa, nome, sigla, is_ativo FROM $this->table WHERE is_ativo IN (0, 1) AND id_empresa = :idEmpresa AND tipo = :tipo ORDER BY nome ASC";
		} else {
			$sql = "SELECT id, id_empresa, nome, sigla, is_ativo FROM $this->table WHERE id_empresa = :idEmpresa AND is_ativo = 1 AND tipo = :tipo ORDER BY nome ASC";
		}
		$stm = DB::prepare ( $sql );
		$stm->bindParam ( ':idEmpresa', $idEmpresa, PDO::PARAM_INT );
		$stm->bindParam ( ':tipo', $tp, PDO::PARAM_INT );
		$stm->execute ();
		$ret = $stm->fetchAll ( PDO::FETCH_ASSOC );
		return $ret;
	}
}
