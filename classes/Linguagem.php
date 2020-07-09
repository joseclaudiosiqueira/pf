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

class Linguagem extends CRUD {

    private $id;
    private $descricao;
    private $isAtivo;
    private $baixa;
    private $media;
    private $alta;
    private $tipo;
    private $sloc;
    private $status;
    private $fatorTecnologia;
    private $idEmpresa;
    private $idCliente;
    private $email;
    private $dataCadastro;
    private $isFT;

    public function __construct() {
        $this->setTable('contagem_config_linguagem');
        $this->setLog();
    }

    function setId($id) {
        $this->id = $id;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setIsAtivo($isAtivo) {
        $this->isAtivo = $isAtivo;
    }

    function setBaixa($baixa) {
        $this->baixa = $baixa;
    }

    function setMedia($media) {
        $this->media = $media;
    }

    function setAlta($alta) {
        $this->alta = $alta;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setSloc($sloc) {
        $this->sloc = $sloc;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    function setFatorTecnologia($fatorTecnologia) {
        $this->fatorTecnologia = $fatorTecnologia;
    }

    function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setDataCadastro($dataCadastro) {
        $this->dataCadastro = $dataCadastro;
    }

    function setIsFT($isFT) {
        $this->isFT = $isFT;
    }

    public function comboLinguagem($tipo, $idCliente) {
        //email do usuario logado no sistema
        $idEmpresa = getIdEmpresa();
        //selecionar apenas todas se o administrador deixar visualizar linguagens publicas
        $isVisualizarSugestaoLinguagem = isVisualizarSugestaoLinguagem() ? " IN ('N', 'S') " : " IN ('N') ";
        if ($tipo == '01') {
            $sql = "SELECT id, descricao, tipo, status, id_empresa, id_cliente FROM $this->table WHERE is_ativo IN (0, 1) AND (tipo $isVisualizarSugestaoLinguagem AND id_empresa = :idEmpresa AND id_cliente = :idCliente) ORDER BY tipo, descricao ASC, status DESC";
        } else {
            $sql = "SELECT id, descricao, tipo, status, id_empresa, id_cliente FROM $this->table WHERE is_ativo = 1 AND (tipo $isVisualizarSugestaoLinguagem AND id_empresa = :idEmpresa AND id_cliente = :idCliente) ORDER BY descricao ASC";
        }
        $stm = DB::prepare($sql);
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_STR);
        $stm->bindParam(':idCliente', $idCliente, PDO::PARAM_STR);
        $stm->execute();
        $ret = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $ret;
    }

    public function comboFatorTecnologia($idCliente, $idEmpresa) {
        $sql = "SELECT "
                . "id, descricao, fator_tecnologia "
                . "FROM $this->table "
                . "WHERE id_empresa = $idEmpresa AND id_cliente = $idCliente AND is_ft = 1 "
                . "ORDER BY fator_tecnologia DESC, descricao ASC";
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFatorTecnologia($id_cliente, $id_empresa) {
        $sql = "SELECT "
                . "id, descricao, fator_tecnologia "
                . "FROM $this->table "
                . "WHERE id_empresa = $id_empresa AND id_cliente = $id_cliente AND is_ft = 1 "
                . "ORDER BY descricao ASC";
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verificaProdutividade($id) {
        $sql = "SELECT baixa, media, alta, sloc, fator_tecnologia FROM $this->table WHERE id = :id";
        $stmt = DB::prepare($sql);
        $stmt->bindParam('id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $ret = $stmt->fetch(PDO::FETCH_ASSOC);
        return $ret;
    }

    public function insere() {
        $sql = "INSERT INTO $this->table (
			descricao,
			is_ativo,
			baixa,
			media,
                        alta,
                        sloc,
                        tipo,
                        status,
                        fator_tecnologia,
                        id_empresa,
                        id_cliente,
                        email,
                        data_cadastro,
                        is_ft,
                        ultima_atualizacao,
                        atualizado_por) 
		VALUES (
			:descricao,
			:isAtivo,
			:baixa,
                        :media,
                        :alta,
                        :sloc,
                        :tipo,
                        :status,
                        :fatorTecnologia,
                        :idEmpresa,
                        :idCliente,
                        :email,
                        :dataCadastro,
                        :isFT,
                        :ultimaAtualizacao,
                        :atualizadoPor)";

        $stmt = DB::prepare($sql);
        $stmt->bindParam(':descricao', $this->descricao, PDO::PARAM_INT);
        $stmt->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
        $stmt->bindParam(':baixa', $this->baixa, PDO::PARAM_STR);
        $stmt->bindParam(':media', $this->media, PDO::PARAM_STR);
        $stmt->bindParam(':alta', $this->alta, PDO::PARAM_STR);
        $stmt->bindParam(':sloc', $this->sloc, PDO::PARAM_STR);
        $stmt->bindParam(':tipo', $this->tipo, PDO::PARAM_STR);
        $stmt->bindParam(':status', $this->status, PDO::PARAM_STR);
        $stmt->bindParam(':fatorTecnologia', $this->fatorTecnologia);
        $stmt->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stmt->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        $stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stmt->bindParam(':dataCadastro', $this->dataCadastro, PDO::PARAM_STR);
        $stmt->bindParam(':isFT', $this->isFT, PDO::PARAM_INT);
        $stmt->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stmt->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stmt->execute();
        return DB::getInstance()->lastInsertId();
    }

    public function atualiza($id) {
        $stmt = DB::prepare("UPDATE $this->table SET "
                        . "descricao = :descricao,"
                        . "is_ativo = :isAtivo,"
                        . "baixa = :baixa,"
                        . "media = :media,"
                        . "alta = :alta,"
                        . "sloc = :sloc,"
                        . "fator_tecnologia = :fatorTecnologia, "
                        . "ultima_atualizacao = :ultimaAtualizacao,"
                        . "atualizado_por = :atualizadoPor "
                        . "WHERE id = :id");
        $stmt->bindParam(':descricao', $this->descricao, PDO::PARAM_STR);
        $stmt->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
        $stmt->bindParam(':baixa', $this->baixa, PDO::PARAM_STR);
        $stmt->bindParam(':media', $this->media, PDO::PARAM_STR);
        $stmt->bindParam(':alta', $this->alta, PDO::PARAM_STR);
        $stmt->bindParam(':sloc', $this->sloc, PDO::PARAM_STR);
        $stmt->bindParam(':fatorTecnologia', $this->fatorTecnologia, PDO::PARAM_STR);
        $stmt->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stmt->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $id;
    }

    public function lista($idEmpresa, $idCliente) {
        $stm = DB::prepare("SELECT * FROM $this->table WHERE id_empresa = :idEmpresa AND id_cliente = :idCliente ORDER BY descricao ASC");
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idCliente', $idCliente, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function alterarSatusLinguagem($id, $isAtivo) {
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

    public function alterarIsFT() {
        /*
         * verifica se tem alguma contagem utilizando o fator
         */
        $verifica = DB::prepare("SELECT COUNT(*) AS QTD FROM ee, se, ce "
                        . "WHERE ee.id_fator_tecnologia = $this->id OR se.id_fator_tecnologia = $this->id OR ce.id_fator_tecnologia = $this->id");
        $verifica->execute();
        $quantidade = $verifica->fetch(PDO::FETCH_ASSOC);
        if ($quantidade['QTD'] > 0) {
            return FALSE;
        } else {
            $stm = DB::prepare("UPDATE $this->table SET "
                            . "is_ft = :isFT, "
                            . "atualizado_por = :atualizadoPor, "
                            . "ultima_atualizacao = :ultimaAtualizacao "
                            . "WHERE id = :id");
            $stm->bindParam(':isFT', $this->isFT, PDO::PARAM_INT);
            $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
            $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
            $stm->bindPAram(':id', $this->id, PDO::PARAM_INT);
            return $stm->execute();
        }
    }

    public function copia() {
        $stm = DB::prepare("INSERT INTO $this->table ("
                        . "descricao, "
                        . "is_ativo, "
                        . "baixa, "
                        . "media, "
                        . "alta, "
                        . "sloc, "
                        . "tipo, "
                        . "status, "
                        . "fator_tecnologia, "
                        . "id_empresa, "
                        . "id_cliente, "
                        . "email, "
                        . "data_cadastro,"
                        . "ultima_atualizacao,"
                        . "atualizado_por) "
                        . "SELECT "
                        . "descricao, "
                        . "is_ativo, "
                        . "baixa, "
                        . "media, "
                        . "alta, "
                        . "sloc, "
                        . "'N', "//tipo
                        . "'1', "//status
                        . "fator_tecnologia, "
                        . ":idEmpresa, "
                        . ":idCliente, "
                        . "'administrador@pfdimension.com.br', "
                        . "now(), "
                        . "now(), "
                        . "'administrador@pfdimension.com.br' "
                        . "FROM linguagem "
                        . "WHERE id_empresa = 0");
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        return $stm->execute();
    }

}
