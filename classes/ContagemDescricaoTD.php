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

class ContagemDescricaoTD extends CRUD
{

    private $idPrimario;

    private $funcao;

    private $descricao;

    function setIdPrimario($idPrimario)
    {
        $this->idPrimario = $idPrimario;
    }

    function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    function setFuncao($funcao)
    {
        $this->funcao = $funcao;
    }

    public function insere()
    {
        $sql = "INSERT INTO $this->table (id_primario, " . "funcao, " . "descricao, " . "ultima_atualizacao, " . "atualizado_por) values (:idPrimario, " . ":funcao, " . ":descricao, " . ":ultimaAtualizacao, " . ":atualizadoPor)";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idPrimario', $this->idPrimario, PDO::PARAM_INT);
        $stm->bindParam(':funcao', $this->funcao, PDO::PARAM_STR);
        $stm->bindParam(':descricao', $this->descricao, pdo::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->execute();
        return DB::getInstance()->lastInsertId();
    }

    public function atualiza($id)
    {
        $sql = "UPDATE $this->table SET descricao = :descricao, " . "ultima_atualizacao = :ultimaAtualizacao, " . "atualizado_por = :atualizadoPor WHERE id = :id";
        $stm = DB::prepare($sql);
        $stm->bindParam(':descricao', $this->descricao, pdo::PARAM_STR);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        return $stm->execute();
    }

    /**
     *
     * @param int $id
     * @param string $funcao
     * @return array
     */
    public function listaDescricaoTD($id, $funcao)
    {
        $sql = "SELECT id, id_primario, descricao FROM $this->table WHERE id_primario = :id AND funcao = :funcao";
        $stm = DB::prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->bindParam(':funcao', $funcao, PDO::PARAM_STR);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getQuantidadeTD($id, $funcao)
    {
        $stm = DB::prepare("SELECT count(id) AS quantidade FROM $this->table WHERE id_primario = :id AND funcao = :funcao");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->bindParam(':funcao', $funcao, PDO::PARAM_STR);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha['quantidade'];
    }
}
