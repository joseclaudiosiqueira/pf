<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER ['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verificacao do status do login
 */
require_once 'CRUD.php';

class ModuloSistema extends CRUD {

    private $id;
    private $idSistema;
    private $descricao;
    private $isAtivo;
    private $atualizadoPor;
    private $ultimaAtualizacao;

    public function __construct() {
        $this->setTable('modulo_sistema');
        $this->setLog();
    }

    public function insere() {
        $sql = "INSERT INTO $this->table (
                        id,
                        id_sistema,
                        descricao,
                        is_ativo,
                        ultima_atualizacao,
                        atualizado_por) 
		VALUES (
                        :id,
                        :idEmpresa,
                        :descricao,
                        :isAtivo,
                        :ultimaAtualizacao,
                        :atualizadoPor)";
        $stm = DB::prepare($sql);
        $stm->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stm->bindParam(':idSistema', $this->idSistema, PDO::PARAM_INT);
        $stm->bindParam(':descricao', $this->descricao, PDO::PARAM_INT);
        $stm->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->execute();
        return DB::getInstance()->lastInsertId();
    }

    public function atualiza($id) {
        $sql = "UPDATE $this->table SET "
                . "id_sistema = $this->idSistema, "
                . "descricao = $this->descricao, "
                . "is_ativo = $this->isAtivo, "
                . "ultima_atualizacao = $this->ultimaAtualizacao, "
                . "atualizado_por = $this->atualizadoPor WHERE id = $this->id";
        $stm = DB::prepare($sql);
        return $stm->execute();
    }

    public function comboModuloSistema() {
        $sql = "SELECT id, descricao FROM modulo_sistema WHERE id_sistema = $this->idSistema";
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fecthAll(PDO::FETCH_ASSOC);
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdSistema($idSistema) {
        $this->idSistema = $idSistema;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setIsAtivo($isAtivo) {
        $this->isAtivo = $isAtivo;
    }

    function setAtualizadoPor($atualizadoPor) {
        $this->atualizadoPor = $atualizadoPor;
    }

    function setUltimaAtualizacao($ultimaAtualizacao) {
        $this->ultimaAtualizacao = $ultimaAtualizacao;
    }

}
