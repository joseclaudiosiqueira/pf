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

class ContagemConfigCocomo extends CRUD {

    private $idEmpresa;
    private $idCliente;
    private $variavel;
    private $valor;

    public function __construct() {
        $this->setTable('contagem_config_cocomo');
        $this->setLog();
    }

    function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }

    function setVariavel($variavel) {
        $this->variavel = $variavel;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    public function insere() {
        $stm = DB::prepare("INSERT INTO $this->table ("
                        . "id_empresa, "
                        . "id_cliente, "
                        . "ultima_atualizacao, "
                        . "atualizado_por) VALUES ("
                        . ":idEmpresa,"
                        . ":idCliente,"
                        . ":ultimaAtualizacao,"
                        . ":atualizadoPor)");
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->execute();
        return DB::getInstance()->lastInsertId();
    }

    public function atualiza($id) {
        $stm = DB::prepare("UPDATE $this->table SET $this->variavel = '$this->valor' WHERE id_empresa = :idEmpresa AND id_cliente = :idCliente");
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        return $stm->execute();
    }

    public function getConfig($config = NULL) {
        $stm = DB::prepare("SELECT " . (NULL !== $config ? $config : '*') . " FROM $this->table WHERE id_empresa = :idEmpresa AND id_cliente = :idCliente");
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

}
