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

class ContagemAnaliseFiscal extends CRUD {

    private $idContagem1;
    private $idContagem2;
    private $analise;
    private $tipo; //0 - comparar, 1 - analisar
    private $dataInsercao;
    private $userId;

    public function __construct() {
        $this->setTable('contagem_analise_fiscal');
        $this->setLog();
    }

    function setIdContagem1($idContagem1) {
        $this->idContagem1 = $idContagem1;
    }

    function setIdContagem2($idContagem2) {
        $this->idContagem2 = $idContagem2;
    }

    function setAnalise($analise) {
        $this->analise = $analise;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setDataInsercao($dataInsercao) {
        $this->dataInsercao = $dataInsercao;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    public function insere() {
        $sql = "INSERT INTO $this->table ("
                . "id_contagem_1, "
                . "id_contagem_2, "
                . "analise, "
                . "tipo, "
                . "data_insercao, "
                . "user_id, "
                . "atualizado_por, "
                . "ultima_atualizacao)"
                . "VALUES ("
                . ":idContagem1,"
                . ":idContagem2,"
                . ":analise,"
                . ":tipo,"
                . ":dataInsercao,"
                . ":userId,"
                . ":atualizadoPor,"
                . ":ultimaAtualizacao)";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idContagem1', $this->idContagem1, PDO::PARAM_INT);
        $stm->bindParam(':idContagem2', $this->idContagem2, PDO::PARAM_INT);
        $stm->bindParam(':analise', $this->analise, PDO::PARAM_STR);
        $stm->bindParam(':tipo', $this->tipo, PDO::PARAM_INT);
        $stm->bindParam(':dataInsercao', $this->dataInsercao);
        $stm->bindParam(':userId', $this->userId);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stm->execute();
        return DB::getInstance()->lastInsertId();
    }

    public function atualiza($idContagem1, $idContagem2 = NULL) {
        //tipo = 0 - comparar, 1 - analisar
        $sql = "UPDATE $this->table SET analise = '$this->analise' WHERE id_contagem_1 = $idContagem1 AND id_contagem_2 = $idContagem2";
        $stm = DB::prepare($sql);
        return $stm->execute();
    }

    public function isContagemAnaliseFiscal($idContagem1, $idContagem2, $tipo) {
        if ($idContagem2 == 0) {
            $sql = "SELECT count(id) AS qtd, analise FROM $this->table WHERE "
                    . "(id_contagem_1 = $idContagem1 AND id_contagem_2 = 0 AND tipo = 1)";
        } else {
            $sql = "SELECT COUNT(id) AS qtd, analise FROM $this->table WHERE "
                    . "(id_contagem_1 = $idContagem1 OR id_contagem_1 = $idContagem2) AND "
                    . "(id_contagem_2 = $idContagem2 Or id_contagem_2 = $idContagem1) AND tipo = $tipo";
        }
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function getContagemAnaliseFiscal($idContagem1, $idContagem2) {
        $sql = "SELECT * FROM $this->table WHERE id_contagem_1 = $idContagem1 AND id_contagem_2 = $idContagem2";
        $stm = DB::prepare($sql);
        $stm->execute();
        $contagemAnalise = $stm->fetch(PDO::FETCH_ASSOC);
        if ($stm->columnCount() > 0) {
            $this->setIdContagem1($contagemAnalise['id_contagem_1']);
            $this->setIdContagem2($contagemAnalise['id_contagem_2']);
            $this->setAnalise($contagemAnalise['analise']);
            $this->setTipo($contagemAnalise['tipo']);
            $this->setDataInsercao($contagemAnalise['data_insercao']);
            $this->setUserId($contagemAnalise['user_id']);
            return true;
        } else {
            return false;
        }
    }

    public function listacontagemAnalise($userId) {
        $sql = "SELECT * FROM $this->table WHERE user_id = $userId ORDER BY id DESC";
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

}
