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

class FatorTecnologia extends CRUD {

    private $id;
    private $id_cliente;
    private $descricao;
    private $fator;
    private $is_ativo;

    function setId($id) {
        $this->id = $id;
    }

    function setId_cliente($id_cliente) {
        $this->id_cliente = $id_cliente;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setFator($fator) {
        $this->fator = $fator;
    }

    function setIs_ativo($is_ativo) {
        $this->is_ativo = $is_ativo;
    }

    public function insere() {
        $sql = "INSERT INTO $this->table (id_cliente, descricao, fator, is_ativo, atualizado_por, ultima_atualizacao) "
                . "VALUES ("
                . "$this->id_cliente,"
                . "'$this->descricao',"
                . "$this->fator,"
                . "$this->is_ativo,"
                . "'$this->atualizadoPor',"
                . "'$this->ultimaAtualizacao')";
        $stm = DB::prepare($sql);
        $stm->execute();
        return DB::getInstance()->lastInsertId();
    }

    public function atualiza() {
        $sql = "UPDATE $this->table SET "
                . "descricao = '$this->descricao', "
                . "fator = $this->fator, "
                . "is_ativo = $this->is_ativo, "
                . "atualizado_por = '$this->atualizadoPor, "
                . "ultima_atualizacao = $this->ultimaAtualizacao "
                . "WHERE id = $this->id";
        $stm = DB::prepare($sql);
        return $stm->execute();
    }

}
