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

class Projeto extends CRUD {

    private $idContrato;
    private $descricao;
    private $isAtivo;
    private $dataInicio;
    private $dataFim;
    private $idGerenteProjeto;

    public function __construct() {
        $this->setTable('projeto');
        $this->setLog();
    }

    function setIdGerenteProjeto($idGerenteProjeto) {
        $this->idGerenteProjeto = $idGerenteProjeto;
    }

    function setDataInicio($dataInicio) {
        $this->dataInicio = $dataInicio;
    }

    function setDataFim($dataFim) {
        $this->dataFim = $dataFim;
    }

    public function setIdContrato($idContrato) {
        $this->idContrato = $idContrato;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setIsAtivo($isAtivo) {
        $this->isAtivo = $isAtivo;
    }

    public function comboProjeto($idContrato, $tipo) {
        if ($tipo == '01') {
            $sql = "SELECT id, id_contrato, descricao FROM $this->table WHERE is_ativo IN (0, 1) AND id_contrato = :idContrato ORDER BY id ASC";
        } else {
            $sql = "SELECT id, id_contrato, descricao FROM $this->table WHERE is_ativo = 1 AND id_contrato = :idContrato ORDER BY id ASC";
        }

        $stmt = DB::prepare($sql);
        $stmt->bindParam(':idContrato', $idContrato, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 
     * @param string $t - tipo ATIVO/INATIVO
     * @param id_fornecedor $i - id_fornecedor
     * @return type
     */
    public function comboProjetoBaseline($t, $i = NULL) {
        $idEmpresa = getIdEmpresa();
        $sql = "SELECT p.*, cl.id_fornecedor "
                . "FROM $this->table p, contrato c, cliente cl "
                . "WHERE p.id_contrato = c.id AND "
                . "c.id_cliente = cl.id AND "
                . "cl.id_empresa = $idEmpresa "
                . (NULL !== $i ? "AND cl.id_fornecedor = $i " : "")
                . ($t === '01' ? "AND p.is_ativo IN (0,1)" : "AND p.is_ativo = 1");
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insere() {
        $sql = "INSERT INTO $this->table (
			id_contrato,
			descricao,
			is_ativo,
                        data_inicio,
                        data_fim,
                        id_gerente_projeto,
                        ultima_atualizacao,
                        atualizado_por
                        ) 
		VALUES (
			:idContrato,
			:descricao,
			:isAtivo,
                        :dataInicio,
                        :dataFim,
                        :idGerenteProjeto,
                        :ultimaAtualizacao,
                        :atualizadoPor)";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idContrato', $this->idContrato, PDO::PARAM_INT);
        $stm->bindParam(':descricao', $this->descricao, PDO::PARAM_STR);
        $stm->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
        $stm->bindParam(':dataInicio', $this->dataInicio, PDO::PARAM_STR);
        $stm->bindParam(':dataFim', $this->dataFim, PDO::PARAM_STR);
        $stm->bindParam(':idGerenteProjeto', $this->idGerenteProjeto, PDO::PARAM_INT);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->execute();
        return array('id' => DB::getInstance()->lastInsertId(), 'msg' => 'O projeto - <strong>' . $this->descricao . '</strong> - foi inserido com sucesso!');
    }

    public function atualiza($id) {
        /*
         * formata as datas
         */
        $dataInicio = date_create_from_format('d/m/Y', $this->dataInicio);
        $dataFim = date_create_from_format('d/m/Y', $this->dataFim);

        $sql = "UPDATE $this->table SET "
                . "id_contrato = :idContrato, "
                . "descricao = :descricao, "
                . "is_ativo = :isAtivo, "
                . "data_inicio = :dataInicio, "
                . "data_fim = :dataFim, "
                . "id_gerente_projeto = :idGerenteProjeto, "
                . "ultima_atualizacao = :ultimaAtualizacao, "
                . "atualizado_por = :atualizadoPor "
                . "WHERE id = :id";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idContrato', $this->idContrato, PDO::PARAM_INT);
        $stm->bindParam(':descricao', $this->descricao, PDO::PARAM_STR);
        $stm->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
        $stm->bindParam(':dataInicio', $this->dataInicio, PDO::PARAM_STR);
        $stm->bindParam(':dataFim', $this->dataFim, PDO::PARAM_STR);
        $stm->bindParam(':idGerenteProjeto', $this->idGerenteProjeto, PDO::PARAM_INT);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        return array('id' => $id, 'msg' => 'O projeto - <strong>' . $this->descricao . '</strong> - foi atualizado com sucesso!');
    }

    public function listaProjeto($id) {
        $stm = DB::prepare("SELECT "
                        . "prj.* "
                        . "FROM "
                        . "projeto prj "
                        . "WHERE "
                        . "prj.id_contrato = :id "
                        . "ORDER BY id ASC");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function alterarSatusProjeto($id) {
        $stm = DB::prepare("UPDATE $this->table SET "
                        . "is_ativo = :isAtivo, "
                        . "atualizado_por = :atualizadoPor, "
                        . "ultima_atualizacao = :ultimaAtualizacao "
                        . "WHERE id = :id");
        $stm->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stm->bindPAram(':id', $id, PDO::PARAM_INT);
        return($stm->execute());
    }

    public function verificaAcesso($id) {
        $stm = DB::prepare(""
                        . "SELECT cl.id_empresa, cl.id_fornecedor "
                        . "FROM cliente cl, contrato ct, projeto pj "
                        . "WHERE "
                        . "ct.id_cliente = cl.id AND "
                        . "pj.id_contrato = ct.id AND "
                        . "ct.id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        if ($stm->columnCount() > 0) {
            $linha = $stm->fetch(PDO::FETCH_ASSOC);
            $result = array('id_empresa' => $linha['id_empresa'], 'id_fornecedor' => $linha['id_fornecedor']);
        } else {
            $result = array('id_empresa' => 0, 'id_fornecedor' => 0);
        }
        return $result;
    }

}
