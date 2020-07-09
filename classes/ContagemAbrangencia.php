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
require_once DIR_CLASS . 'CRUD.php';

class ContagemAbrangencia extends CRUD {

    protected $table = 'contagem_abrangencia';
    private $descricao;
    private $chave;
    private $isAtivo;

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setChave($chave) {
        $this->chave = $chave;
    }

    public function setIsAtivo($isAtivo) {
        $this->isAtivo = $isAtivo;
    }

    public function getIdAbrangencia() {
        $sql = "SELECT id FROM $this->table WHERE sigla = '$this->chave'";
        $stm = DB::prepare($sql);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha['id'];
    }

    public function getAbrangencia($id) {
        $stm = DB::prepare("SELECT descricao, chave, tipo FROM $this->table WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function insere() {
        //
    }

    public function atualiza($id) {
        //
    }

}
