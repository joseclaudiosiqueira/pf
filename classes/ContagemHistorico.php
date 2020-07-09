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

class ContagemHistorico extends CRUD {

    private $id;
    private $idContagem;
    private $idProcesso;
    private $dataInicio;
    private $dataFim;
    private $isInserirFinalizado;
    private $isAtualizandoProcesso;
    private $finalizadoPor;
    private $idTarefa = NULL;

    public function __construct() {
        $this->setTable('contagem_historico');
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIsInserirFinalizado($isInserirFinalizado) {
        $this->isInserirFinalizado = $isInserirFinalizado;
    }

    function setIsAtualizandoProcesso($isAtualizandoProcesso) {
        $this->isAtualizandoProcesso = $isAtualizandoProcesso;
    }

    function setIdContagem($idContagem) {
        $this->idContagem = $idContagem;
    }

    function setIdProcesso($idProcesso) {
        $this->idProcesso = $idProcesso;
    }

    function setDataInicio($dataInicio) {
        $this->dataInicio = $dataInicio;
    }

    function setDataFim($dataFim) {
        $this->dataFim = $dataFim;
    }

    function setIdTarefa($idTarefa) {
        $this->idTarefa = $idTarefa;
    }

    function setFinalizadoPor($finalizadoPor) {
        $this->finalizadoPor = $finalizadoPor;
    }

    public function atualiza($id) {
        //
    }

    public function insere() {
        if (!($this->isInserirFinalizado)) {
            $this->setDataFim(NULL);
            $this->setFinalizadoPor(NULL);
        } else {
            $this->setDataFim(date('Y-m-d H:i:s'));
            $this->setFinalizadoPor($_SESSION['user_email']);
        }
        $sql = "INSERT into $this->table ("
                . "id_contagem, "
                . "id_processo, "
                . "id_tarefa, "
                . "data_inicio, "
                . "data_fim, "
                . "atualizado_por, "
                . "finalizado_por) "
                . "VALUES ("
                . ":idContagem, "
                . ":idProcesso, "
                . ":idTarefa, "
                . ":dataInicio, "
                . ":dataFim, "
                . ":atualizadoPor, "
                . ":finalizadoPor)";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idContagem', $this->idContagem, PDO::PARAM_INT);
        $stm->bindParam(':idProcesso', $this->idProcesso, PDO::PARAM_INT);
        $stm->bindParam(':idTarefa', $this->idTarefa, PDO::PARAM_INT);
        $stm->bindParam(':dataInicio', $this->dataInicio);
        $stm->bindParam(':dataFim', $this->dataFim);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':finalizadoPor', $this->finalizadoPor, PDO::PARAM_STR);
        return $stm->execute();
    }

    public function finalizaProcesso($idProcesso = NULL) {
        //finaliza o historico da contagem
        $stm = DB::prepare("UPDATE contagem_historico "
                        . "SET data_fim = :dataFim, "
                        . "finalizado_por = :finalizadoPor "
                        . (NULL !== $idProcesso ? ', id_processo = :idProcesso ' : '')
                        . "WHERE id = :id");
        $stm->bindParam(':dataFim', $this->dataFim, PDO::PARAM_STR);
        $stm->bindParam(':finalizadoPor', $this->finalizadoPor, PDO::PARAM_STR);
        NULL !== $idProcesso ? $stm->bindParam(':idProcesso', $idProcesso, PDO::PARAM_INT) : NULL;
        $stm->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stm->execute();
    }

    /**
     * retorna o id no historico da contagem que esta com a data_fim = NULL
     * 
     * @param int $idContagem
     * @return int $id
     */
    public function getProcessoAtual($idContagem, $idProcesso) {
        $stm = DB::prepare("SELECT id, id_tarefa, id_processo "
                        . "FROM $this->table "
                        . "WHERE data_fim IS NULL AND "
                        . "id_processo = :idProcesso AND "
                        . "id_contagem = :idContagem");
        $stm->bindParam(':idContagem', $idContagem, PDO::PARAM_INT);
        $stm->bindParam(':idProcesso', $idProcesso, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * retorna o id no historico da contagem que esta com a data_fim = NULL
     * 
     * @param int $idContagem
     * @param int $idProcesso
     * 
     * @return boolean
     * 
     * "1","Em elaboração","Elaborada","1"
     * "2","Em validação interna","Validada internamente","1"
     * "3","Em validação externa","Validada externamente","1"
     * "4","Em auditoria interna","Auditada internamente","1"
     * "5","Em auditoria externa","Auditada externamente","1"
     * "6","Em revisão","Revisada","1"
     * "7","Faturada","Faturada","1"
     */
    public function isValidadaInternamente($idContagem) {
        $stm = DB::prepare("SELECT count(id) AS isValidadaInternamente "
                        . "FROM $this->table "
                        . "WHERE data_fim IS NULL AND "
                        . "id_contagem = :idContagem AND "
                        . "id_processo = 2");
        $stm->bindParam(':idContagem', $idContagem, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha['isValidadaInternamente'] > 0 ? true : false;
    }

    public function isProcessoValidacaoInterna($idContagem) {
        $stm = DB::prepare("SELECT count(id) AS isProcessoValidacaoInterna "
                        . "FROM $this->table "
                        . "WHERE data_fim IS NULL AND "
                        . "id_contagem = :idContagem AND "
                        . "id_processo = 2");
        $stm->bindParam(':idContagem', $idContagem, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha['isProcessoValidacaoInterna'] > 0 ? true : false;
    }

    public function isProcessoValidacaoExterna($idContagem) {
        $stm = DB::prepare("SELECT count(id) AS isProcessoValidacaoExterna "
                        . "FROM $this->table "
                        . "WHERE data_fim IS NULL AND "
                        . "id_contagem = :idContagem AND "
                        . "id_processo = 3");
        $stm->bindParam(':idContagem', $idContagem, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha['isProcessoValidacaoExterna'] > 0 ? true : false;
    }

    public function getHistorico() {
        $stm = DB::prepare("SELECT "
                        . "ch.data_inicio, "
                        . "ch.data_fim, "
                        . "ch.finalizado_por, "
                        . "cp.descricao_em_andamento,"
                        . "cp.descricao_concluido,"
                        . "tr.user_email_executor FROM "
                        . "$this->table ch, contagem_processo cp, tarefas tr WHERE "
                        . "ch.id_processo = cp.id AND "
                        . "ch.id_tarefa = tr.id AND "
                        . "ch.id_contagem = $this->idContagem");
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * funcao que finaliza a terega de elaboracao sempre que houver uma
     * validacao interna automatica ou a contagem for enviada para validacao interna
     */
    public function finalizaTarefaElaboracao() {
        $stm = DB::prepare("UPDATE $this->table SET "
                        . "data_fim = :dataFim, "
                        . "finalizado_por = :finalizadoPor WHERE "
                        . "id_contagem = :idContagem AND "
                        . "id_processo = :idProcesso");
        $stm->bindParam(':dataFim', $this->dataFim, PDO::PARAM_STR);
        $stm->bindParam(':finalizadoPor', $this->finalizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':idContagem', $this->idContagem, PDO::PARAM_INT);
        $stm->bindParam(':idProcesso', $this->idProcesso, PDO::PARAM_STR);
        $stm->execute();
    }

}
