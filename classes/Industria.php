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

class Industria extends CRUD {

    private $descricao;
    private $description;
    private $isAtivo;

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setIsAtivo($isAtivo) {
        $this->isAtivo = $isAtivo;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function comboIndustria($tipo) {
        if ($tipo == '01')
            $sql = "SELECT id, descricao, is_ativo FROM $this->table WHERE is_ativo IN (0, 1) ORDER BY id ASC";
        else
            $sql = "SELECT id, descricao, is_ativo FROM $this->table WHERE is_ativo = 1 ORDER BY id ASC";
        $stmt = DB::prepare($sql);
        $stmt->execute();
        $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $ret;
    }

    public function insere() {
        $sql = "INSERT INTO $this->table (
			descricao,
			is_ativo) 
		VALUES (
			:descricao,
			:isAtivo)";

        $stmt = DB::prepare($sql);
        $stmt->bindParam(':descricao', $this->descricao, PDO::PARAM_INT);
        $stmt->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
        $stmt->execute();
        return DB::getInstance()->lastInsertId();
    }

    public function atualiza($id) {
        //
    }

}
