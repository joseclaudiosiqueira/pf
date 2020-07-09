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

class Tarefa extends CRUD {

    private $idTarefa;
    private $idContagem;
    private $idTipo;
    private $idEmpresa;
    private $idFornecedor;
    private $descricao;
    private $userIdSolicitante;
    private $userEmailSolicitante;
    private $userIdExecutor;
    private $userEmailExecutor;
    private $dataInicio;
    private $dataFim;
    private $dataConclusao;
    private $concluidoPor;

    public function __construct() {
        $this->setTable('tarefas');
        $this->setLog();
    }

    function setIdTarefa($idTarefa) {
        $this->idTarefa = $idTarefa;
    }

    function setIdContagem($idContagem) {
        $this->idContagem = $idContagem;
    }

    function setIdTipo($idTipo) {
        $this->idTipo = $idTipo;
    }

    function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    function setIdFornecedor($idFornecedor) {
        $this->idFornecedor = $idFornecedor;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setUserIdSolicitante($userIdSolicitante) {
        $this->userIdSolicitante = $userIdSolicitante;
    }

    function setUserIdExecutor($userIdExecutor) {
        $this->userIdExecutor = $userIdExecutor;
    }

    function setUserEmailSolicitante($userEmailSolicitante) {
        $this->userEmailSolicitante = $userEmailSolicitante;
    }

    function setUserEmailExecutor($userEmailExecutor) {
        $this->userEmailExecutor = $userEmailExecutor;
    }

    function setDataInicio($dataInicio) {
        $this->dataInicio = $dataInicio;
    }

    function setDataFim($dataFim) {
        $this->dataFim = $dataFim;
    }

    function setDataConclusao($dataConclusao) {
        $this->dataConclusao = $dataConclusao;
    }

    function setConcluidoPor($concluidoPor) {
        $this->concluidoPor = $concluidoPor;
    }

    public function conclui($id) {
        $stm = DB::prepare("UPDATE $this->table SET "
                        . "data_conclusao = :dataConclusao, "
                        . "concluido_por = :concluidoPor "
                        . "WHERE id = :id");
        $stm->bindValue(':dataConclusao', $this->dataConclusao, PDO::PARAM_STR);
        $stm->bindValue(':concluidoPor', $this->concluidoPor, PDO::PARAM_STR);
        $stm->bindValue(':id', $id, PDO::PARAM_INT);
        return $stm->execute();
    }

    public function insere() {
        $stm = DB::prepare("INSERT INTO $this->table ("
                        . "id_contagem, "
                        . "id_tipo, "
                        . "id_empresa, "
                        . "id_fornecedor, "
                        . "descricao, "
                        . "user_id_solicitante, "
                        . "user_email_solicitante, "
                        . "user_id_executor, "
                        . "user_email_executor, "
                        . "data_inicio, "
                        . "data_fim,"
                        . "data_conclusao,"
                        . "concluido_por) VALUES ("
                        . ":idContagem, "
                        . ":idTipo, "
                        . ":idEmpresa, "
                        . ":idFornecedor, "
                        . ":descricao, "
                        . ":userIdSolicitante, "
                        . ":userEmailSolicitante, "
                        . ":userIdExecutor, "
                        . ":userEmailExecutor, "
                        . ":dataInicio, "
                        . ":dataFim,"
                        . ":dataConclusao,"
                        . ":concluidoPor)");
        $stm->bindParam(':idContagem', $this->idContagem, PDO::PARAM_INT);
        $stm->bindParam(':idTipo', $this->idTipo, PDO::PARAM_INT);
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $this->idFornecedor, PDO::PARAM_INT);
        $stm->bindParam(':descricao', $this->descricao, PDO::PARAM_STR);
        $stm->bindParam(':userIdSolicitante', $this->userIdSolicitante, PDO::PARAM_INT);
        $stm->bindParam(':userEmailSolicitante', $this->userEmailSolicitante, PDO::PARAM_STR);
        $stm->bindParam(':userIdExecutor', $this->userIdExecutor, PDO::PARAM_INT);
        $stm->bindParam(':userEmailExecutor', $this->userEmailExecutor, PDO::PARAM_STR);
        $stm->bindParam(':dataInicio', $this->dataInicio, PDO::PARAM_STR);
        $stm->bindParam(':dataFim', $this->dataFim, PDO::PARAM_STR);
        $stm->bindParam(':dataConclusao', $this->dataConclusao, PDO::PARAM_STR);
        $stm->bindParam(':concluidoPor', $this->concluidoPor, PDO::PARAM_STR);
        $stm->execute();
        return DB::getInstance()->lastInsertId();
    }

    public function atualiza($id) {
        //
    }

    public function listarMinhasTarefasPendentes() {
        $idFornecedor = getIdFornecedor();
        $stm = DB::prepare("SELECT * FROM $this->table "
                        . "WHERE "
                        . "id_empresa = :idEmpresa AND "
                        . (isFornecedor() ? "id_fornecedor = $idFornecedor AND " : "")
                        . "user_email_executor = :userEmailExecutor AND "
                        . "id_tipo <> 20 AND "
                        . "data_conclusao IS NULL ORDER BY data_inicio DESC");
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':userEmailExecutor', $this->userEmailExecutor, PDO::PARAM_STR);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarTarefasSolicitante() {
        $stm = DB::prepare("SELECT * FROM $this->table "
                        . "WHERE "
                        . "id_empresa = :idEmpresa AND "
                        . "id_fornecedor = :idFornecedor AND "
                        . "user_email_solicitante = :userEmailSolicitante AND "
                        . "user_email_solicitante <> user_email_executor AND "
                        . "data_conclusao IS NULL ORDER BY data_inicio ASC");
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $this->idFornecedor, PDO::PARAM_INT);
        $stm->bindParam(':userEmailSolicitante', $this->userEmailSolicitante, PDO::PARAM_STR);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getQuantidadeTarefasPendentes() {
        $idEmpresa = getIdEmpresa();
        $idFornecedor = getIdFornecedor();
        $stm = DB::prepare("SELECT count(id) AS qtd FROM $this->table WHERE "
                        . "user_email_executor = :userEmailExecutor AND "
                        . "id_tipo <> 20 AND "
                        . "id_empresa = $idEmpresa AND "
                        . "id_fornecedor = $idFornecedor AND "
                        . "data_conclusao IS NULL");
        $stm->bindParam(':userEmailExecutor', $_SESSION['user_email']);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserEmailSolicitante() {
        $sql = "SELECT user_email_solicitante FROM $this->table WHERE id = :idTarefa";
        $stm = DB::prepare($sql);
        $stm->bindPAram(':idTarefa', $this->idTarefa, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function getIdTarefaElaboracao() {
        $sql = "SELECT id FROM $this->table WHERE id_contagem = $this->idContagem AND id_empresa = $this->idEmpresa AND id_tipo = $this->idTipo";
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }    
}
