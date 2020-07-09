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

class Abrangencia extends CRUD {

    private $descricao;
    private $chave;
    private $ativo;
    private $tipo;

    public function __construct() {
        $this->setTable('contagem_abrangencia');
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setChave($chave) {
        $this->chave = $chave;
    }

    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getChaveAbrangencia($id) {
        $sql = "SELECT ca.chave, ca.id, co.is_contagem_auditoria, co.id_roteiro FROM contagem_abrangencia ca, contagem co WHERE co.id_abrangencia = ca.id AND co.id = :id";
        $stm = DB::prepare($sql);
        $stm->bindValue(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function getIdAbrangencia() {
        $sql = "SELECT id FROM contagem_abrangencia WHERE chave = '$this->chave'";
        $stm = DB::prepare($sql);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha['id'];
    }

    public function insere() {
        //
    }

    public function atualiza($id) {
        //
    }

    public function listaAbrangencia() {
        $stm = DB::prepare("SELECT id, chave FROM contagem_abrangencia WHERE is_ativo = 1");
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTipo($idAbrangencia) {
        $stm = DB::prepare("SELECT tipo FROM contagem_abrangencia WHERE id = $idAbrangencia");
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getChave($idAbrangencia) {
        $stm = DB::prepare("SELECT chave FROM contagem_abrangencia WHERE id = $idAbrangencia");
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }
    

}
