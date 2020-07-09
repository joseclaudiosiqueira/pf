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

class ContagemConfigTarefas extends CRUD {

    private $idEmpresa;
    private $idFornecedor;
    private $idCliente;
    private $validacaoInterna;
    private $validacaoExterna;
    private $auditoriaInterna;
    private $auditoriaExterna;
    private $revisaoValidacaoInterna;
    private $revisaoValidacaoExterna;
    private $aponteAuditoriaInterna;
    private $aponteAuditoriaExterna;
    private $faturamento;

    public function __construct() {
        $this->setTable('contagem_config_tarefas');
        $this->setLog();
    }

    function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    function setIdFornecedor($idFornecedor) {
        $this->idFornecedor = $idFornecedor;
    }

    function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }

    function setValidacaoInterna($validacaoInterna) {
        $this->validacaoInterna = $validacaoInterna;
    }

    function setValidacaoExterna($validacaoExterna) {
        $this->validacaoExterna = $validacaoExterna;
    }

    function setAuditoriaInterna($auditoriaInterna) {
        $this->auditoriaInterna = $auditoriaInterna;
    }

    function setAuditoriaExterna($auditoriaExterna) {
        $this->auditoriaExterna = $auditoriaExterna;
    }

    function setRevisaoValidacaoInterna($revisaoValidacaoInterna) {
        $this->revisaoValidacaoInterna = $revisaoValidacaoInterna;
    }

    function setRevisaoValidacaoExterna($revisaoValidacaoExterna) {
        $this->revisaoValidacaoExterna = $revisaoValidacaoExterna;
    }

    function setAponteAuditoriaInterna($aponteAuditoriaInterna) {
        $this->aponteAuditoriaInterna = $aponteAuditoriaInterna;
    }

    function setAponteAuditoriaExterna($aponteAuditoriaExterna) {
        $this->aponteAuditoriaExterna = $aponteAuditoriaExterna;
    }

    function setFaturamento($faturamento) {
        $this->faturamento = $faturamento;
    }

    public function insere() {
        $stm = DB::prepare("INSERT INTO $this->table ("
                        . "id_empresa,"
                        . "id_fornecedor,"
                        . "id_cliente, "
                        . "ultima_atualizacao,"
                        . "atualizado_por) VALUES ("
                        . ":idEmpresa,"
                        . ":idFornecedor,"
                        . ":idCliente, "
                        . ":ultimaAtualizacao,"
                        . ":atualizadoPor)");
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $this->idFornecedor, PDO::PARAM_INT);
        $stm->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        /*
         * insere e retorna
         */
        return $stm->execute();
    }

    public function atualiza($id) {
        /*
         * no caso de tarefas, eh global, atualiza para a empresa e de lambuja todos os fornecedores
         */
        $sql = "UPDATE contagem_config_tarefas SET "
                . "validacao_interna = :validacaoInterna, "
                . "validacao_externa = :validacaoExterna, "
                . "auditoria_interna = :auditoriaInterna, "
                . "auditoria_externa = :auditoriaExterna, "
                . "revisao_validacao_interna = :revisaoValidacaoInterna, "
                . "revisao_validacao_externa = :revisaoValidacaoExterna, "
                . "aponte_auditoria_interna = :aponteAuditoriaInterna, "
                . "aponte_auditoria_externa = :aponteAuditoriaExterna, "
                . "faturamento = :faturamento, "
                . "ultima_atualizacao = :ultimaAtualizacao, "
                . "atualizado_por = :atualizadoPor "
                . "WHERE id_empresa = :idEmpresa AND id_fornecedor = :idFornecedor AND id_cliente = :idCliente";
        $stm = DB::prepare($sql);
        $stm->bindParam(':validacaoInterna', $this->validacaoInterna, PDO::PARAM_INT);
        $stm->bindParam(':validacaoExterna', $this->validacaoExterna, PDO::PARAM_INT);
        $stm->bindParam(':auditoriaInterna', $this->auditoriaInterna, PDO::PARAM_INT);
        $stm->bindParam(':auditoriaExterna', $this->auditoriaExterna, PDO::PARAM_INT);
        $stm->bindParam(':revisaoValidacaoInterna', $this->revisaoValidacaoInterna, PDO::PARAM_INT);
        $stm->bindParam(':revisaoValidacaoExterna', $this->revisaoValidacaoExterna, PDO::PARAM_INT);
        $stm->bindParam(':aponteAuditoriaInterna', $this->aponteAuditoriaInterna, PDO::PARAM_INT);
        $stm->bindParam(':aponteAuditoriaExterna', $this->aponteAuditoriaExterna, PDO::PARAM_INT);
        $stm->bindParam(':faturamento', $this->faturamento, PDO::PARAM_INT);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $this->idFornecedor, PDO::PARAM_INT);
        $stm->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        return $stm->execute();
    }

    public function copiaContagemConfigTarefas($idEmpresa, $idFornecedor, $idCliente) {
        $stm = DB::prepare("INSERT INTO $this->table ("
                        . "id_empresa, "
                        . "id_fornecedor, "
                        . "id_cliente, "
                        . "validacao_interna, "
                        . "validacao_externa, "
                        . "auditoria_interna, "
                        . "auditoria_externa, "
                        . "revisao_validacao_interna, "
                        . "revisao_validacao_externa, "
                        . "aponte_auditoria_interna, "
                        . "aponte_auditoria_externa, "
                        . "faturamento, "
                        . "ultima_atualizacao, "
                        . "atualizado_por) SELECT "
                        . "'$idEmpresa', "
                        . "'$idFornecedor', "
                        . "'$idCliente', "
                        . "validacao_interna, "
                        . "validacao_externa, "
                        . "auditoria_interna, "
                        . "auditoria_externa, "
                        . "revisao_validacao_interna, "
                        . "revisao_validacao_externa, "
                        . "aponte_auditoria_interna, "
                        . "aponte_auditoria_externa, "
                        . "faturamento, "
                        . "'$this->ultimaAtualizacao', "
                        . "'$this->atualizadoPor' FROM contagem_config_tarefas WHERE "
                        . "id_empresa = :idEmpresa");
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->execute();
    }

    public function getConfig($config = NULL) {
        $sql = "SELECT " . (NULL !== $config ? $config : '*') . " FROM $this->table WHERE id_empresa = :idEmpresa AND id_fornecedor = :idFornecedor AND id_cliente = :idCliente";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $this->idFornecedor, PDO::PARAM_INT);
        $stm->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getConfigTarefas($idEmpresa, $idFornecedor, $idCliente){
        $sql = "SELECT * FROM $this->table WHERE id_empresa = :idEmpresa AND id_fornecedor = :idFornecedor AND id_cliente = :idCliente";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $idFornecedor, PDO::PARAM_INT);
        $stm->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

}
