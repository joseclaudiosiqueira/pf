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
require_once 'CRUD.php';

class BancoDados extends CRUD {

    private $descricao;
    private $isAtivo;
    private $tipo;
    private $status;
    private $email;
    private $dataCadastro;
    private $idEmpresa;
    private $idCliente;

    public function __construct() {
        $this->setTable('contagem_config_banco_dados');
        $this->setLog();
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setIsAtivo($isAtivo) {
        $this->isAtivo = $isAtivo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setDataCadastro($dataCadastro) {
        $this->dataCadastro = $dataCadastro;
    }

    function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }

    public function comboBancoDados($tipo, $idCliente) {
        $idEmpresa = getIdEmpresa();
        if ($tipo == '01') {
            $sql = "SELECT id, descricao, tipo, status, id_empresa, id_cliente FROM $this->table WHERE is_ativo IN (0, 1) AND id_empresa = :idEmpresa AND id_cliente = :idCliente ORDER BY tipo, descricao ASC, status DESC";
        } else {
            $sql = "SELECT id, descricao, tipo, status, id_empresa, id_cliente FROM $this->table WHERE is_ativo = 1 AND id_empresa = :idEmpresa AND id_cliente = :idCliente ORDER BY descricao ASC";
        }
        $stm = DB::prepare($sql);
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
        $stm->execute();
        $ret = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $ret;
    }

    public function insere() {
        $sql = "INSERT INTO $this->table (
			descricao,
			is_ativo,
                        tipo,
                        status,
                        email,
                        data_cadastro,
                        id_empresa,
                        id_cliente, 
                        ultima_atualizacao,
                        atualizado_por) 
		VALUES (
			:descricao,
			:isAtivo,
                        :tipo,
                        :status,
                        :email,
                        :dataCadastro,
                        :idEmpresa,
                        :idCliente,
                        :ultimaAtualizacao,
                        :atualizadoPor)";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':descricao', $this->descricao, PDO::PARAM_INT);
        $stmt->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
        $stmt->bindParam(':tipo', $this->tipo, PDO::PARAM_STR);
        $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':dataCadastro', $this->dataCadastro, PDO::PARAM_STR);
        $stmt->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stmt->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        $stmt->bindPAram(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stmt->bindParam(':atualizadoPor', $this->atualizadoPor);
        $stmt->execute();
        return DB::getInstance()->lastInsertId();
    }

    public function atualiza($id) {
        $stmt = DB::prepare("UPDATE $this->table SET "
                        . "descricao = :descricao,"
                        . "is_ativo = :isAtivo,"
                        . "ultima_atualizacao = :ultimaAtualizacao,"
                        . "atualizado_por = :atualizadoPor "
                        . "WHERE id = :id");
        $stmt->bindParam(':descricao', $this->descricao, PDO::PARAM_INT);
        $stmt->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
        $stmt->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stmt->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $id;
    }

    public function lista($idEmpresa, $idCliente) {
        $stm = DB::prepare("SELECT * FROM $this->table WHERE id_empresa = :idEmpresa AND id_cliente = :idCliente");
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function copia() {
        $stm = DB::prepare("INSERT INTO $this->table ("
                        . "descricao, "
                        . "is_ativo, "
                        . "tipo, "
                        . "status, "
                        . "email, "
                        . "data_cadastro, "
                        . "id_empresa, "
                        . "id_cliente, "
                        . "ultima_atualizacao, "
                        . "atualizado_por) "
                        . "SELECT "
                        . "descricao, "
                        . "is_ativo, "
                        . "'N', "//tipo
                        . "'1', "//status
                        . "'administrador@pfdimension.com.br', "
                        . "now(), "
                        . ":idEmpresa, "
                        . ":idCliente, "
                        . "now(), "
                        . "'administrador@pfdimension.com.br' "
                        . "FROM banco_dados "
                        . "WHERE id_empresa = 0");
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        return $stm->execute();
    }

    public function alterarSatusBancoDados($id, $isAtivo) {
        $stm = DB::prepare("UPDATE $this->table SET "
                        . "is_ativo = :isAtivo, "
                        . "atualizado_por = :atualizadoPor, "
                        . "ultima_atualizacao = :ultimaAtualizacao "
                        . "WHERE id = :id");
        $stm->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stm->bindPAram(':id', $id, PDO::PARAM_INT);
        return($stm->execute());
    }

}
