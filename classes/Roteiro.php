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

class Roteiro extends CRUD {

    private $idRoteiro;
    private $descricao;
    private $isAtivo;
    private $idEmpresa;
    private $idFornecedor;
    private $idCliente;
    private $observacoes;
    private $tipo;
    private $idRoteiroImportado;

    public function __construct() {
        $this->setTable('roteiro');
        $this->setLog();
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setIsAtivo($isAtivo) {
        $this->isAtivo = $isAtivo;
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

    function setObservacoes($observacoes) {
        $this->observacoes = $observacoes;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setIdRoteiro($idRoteiro) {
        $this->idRoteiro = $idRoteiro;
    }

    function setIdRoteiroImportado($idRoteiroImportado) {
        $this->idRoteiroImportado = $idRoteiroImportado;
    }

    function getDescricaoRoteiro($descricao) {
        $idEmpresa = getIdEmpresa(); //functions que retona o idEmpresa do usuario logado
        $stm = DB::prepare("SELECT descricao FROM $this->table WHERE descricao = :descricao AND id_empresa = :idEmpresa");
        $stm->bindParam(':descricao', $descricao, PDO::PARAM_INT);
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
     * retorna o id da empresa dona do roteiro
     */

    function getIdEmpresa($idRoteiro) {
        $stm = DB::prepare("SELECT id_empresa FROM roteiro WHERE id = :id");
        $stm->bindParam(':id', $idRoteiro, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha['id_empresa'];
    }

    /*
     * retorna as contagens que utilizam um roteiro para evitar alteracoes e inconsistencias
     */

    function getRoteirosUtilizacao($id) {
        $sql = "SELECT SUM(qtd) AS qtd FROM ( "
                . "SELECT COUNT(ali.id_roteiro) AS qtd FROM ali ali WHERE ali.id_roteiro = :idRoteiro UNION "
                . "SELECT COUNT(aie.id_roteiro) AS qtd FROM aie aie WHERE aie.id_roteiro = :idRoteiro UNION "
                . "SELECT COUNT(ee.id_roteiro) AS qtd FROM ee ee WHERE ee.id_roteiro = :idRoteiro UNION "
                . "SELECT COUNT(se.id_roteiro) AS qtd FROM se se WHERE se.id_roteiro = :idRoteiro UNION "
                . "SELECT COUNT(ce.id_roteiro) AS qtd FROM ce ce WHERE ce.id_roteiro = :idRoteiro UNION "
                . "SELECT COUNT(ou.id_roteiro) AS qtd FROM ou ou WHERE ou.id_roteiro = :idRoteiro ) AS tbl01";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idRoteiro', $id, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha['qtd'] ? true : false;
    }

    /**
     * 
     * TODO: ver a questao da visualizacao dos roteiros compartilhados
     */
    public function comboRoteiro($tipo, $idEmpresa, $idFornecedor, $idCliente) {
        /*
         * verifica se eh um gestor alterando uma contagem de fornecedor em um roteiro exclusivo
         */
        $isGestor = getVariavelSessao('isGestor');
        $isGerenteConta = getVariavelSessao('isGerenteConta');
        $isGerenteProjeto = getVariavelSessao('isGerenteProjeto');
        $isViewer = getVariavelSessao('isViewer');
        $isDiretor = getVariavelSessao('isDiretor');
        $isFiscalContratoEmpresa = getVariavelSessao('isFiscalContratoEmpresa');
        $isFiscalContratoCliente = getVariavelSessao('isFiscalContratoCliente');
        $isFiscalContratoFornecedor = getVariavelSessao('isFiscalContratoFornecedor');
        $isFiscalContrato = ($isFiscalContratoCliente || $isFiscalContratoEmpresa || $isFiscalContratoFornecedor) ? TRUE : FALSE;
        $isAnalistaMetricas = getVariavelSessao('isAnalistaMetricas');
        $isVisualizarContagemFornecedor = getConfigContagem('is_visualizar_contagem_fornecedor');
        /*
         * monta o sql para 0,1 (ativos e inativos) ou 1 (ativos)
         */
        $isAtivo = '';
        /*
         * array de retorno
         */
        $arrRoteiros = [];

        if ($tipo === '01') {
            $isAtivo = 'is_ativo IN (0, 1)';
        } else {
            $isAtivo = 'is_ativo = 1';
        }
        /*
         * roteiro generico, selecionar os outros roteiros Cliente e Fornecedor
         */
        $sql = "SELECT "
                . "id, descricao, id_cliente, id_fornecedor "
                . "FROM $this->table "
                . "WHERE "
                . "$isAtivo AND "
                . "(id_empresa = :idEmpresa || id_empresa = 0) AND "
                . "(id_fornecedor = 0 AND id_cliente = 0) ";
        /*
         * verifica se eh para um fornecedor exclusivo
         */
        if ($idFornecedor) {
            $sql .= "UNION "
                    . "SELECT "
                    . "id, descricao, id_cliente, id_fornecedor "
                    . "FROM $this->table "
                    . "WHERE "
                    . "$isAtivo AND "
                    . "id_empresa = :idEmpresa AND "
                    . "id_fornecedor = :idFornecedor ";
        }
        /*
         * verifica os roteiros para um cliente exclusivo
         */
        if ($idCliente) {
            $sql .= "UNION "
                    . "SELECT "
                    . "id, descricao, id_cliente, id_fornecedor "
                    . "FROM $this->table "
                    . "WHERE "
                    . "$isAtivo AND "
                    . "id_empresa = :idEmpresa AND "
                    . "id_cliente = :idCliente ";
        }
        /*
         * agrega os roteiros exclusivos Cliente e Fornecedor, 
         * no caso de um gestor da empresa visualizando/alterando uma contagem
         * ou de um analista de metricas com autorizacao para visualizar a contagem
         */
        if ($isGestor || $isViewer || $isGerenteConta || $isGerenteProjeto || $isFiscalContrato || $isDiretor || ($isAnalistaMetricas && $isVisualizarContagemFornecedor)) {
            $sql .= "UNION SELECT id, descricao, id_cliente, id_fornecedor "
                    . "FROM $this->table "
                    . "WHERE "
                    . "$isAtivo AND "
                    . "id_empresa = :idEmpresa AND "
                    . "id_fornecedor <> 0 ";
        }

        $stmt = DB::prepare($sql);
        $stmt->bindValue(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        ($idFornecedor) ? $stmt->bindValue(':idFornecedor', $idFornecedor, PDO::PARAM_INT) : NULL;
        ($idCliente) ? $stmt->bindValue(':idCliente', $idCliente, PDO::PARAM_INT) : NULL;
        $stmt->execute();
        $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
        /*
         * verifica se fornecedor e/ou cliente estao designados e pega a sigla
         * instancia a classe Cliente e Fornecedor
         */
        $cliente = new Cliente();
        $fornecedor = new Fornecedor();

        foreach ($ret as $linha) {
            $arrRoteiros[] = array(
                'id' => $linha['id'],
                'descricao' => $linha['descricao'] . (($idCliente && $linha['id_cliente'] > 0) ? ' &gt; (C) ' . $cliente->getSigla($linha['id_cliente']) : '') . (($idFornecedor && $linha['id_fornecedor'] > 0) ? ' &gt (F) ' . $fornecedor->getSigla($linha['id_fornecedor']) : ''));
        }

        return $arrRoteiros;
    }

    public function comboRoteiroTodos($tipo, $idEmpresa) {
        /*
         * verifica se eh um gestor alterando uma contagem de fornecedor em um roteiro exclusivo
         */
        $isGestor = getVariavelSessao('isGestor');
        $isGerenteConta = getVariavelSessao('isGerenteConta');
        $isGerenteProjeto = getVariavelSessao('isGerenteProjeto');
        $isViewer = getVariavelSessao('isViewer');
        $isDiretor = getVariavelSessao('isDiretor');
        $isFiscalContratoEmpresa = getVariavelSessao('isFiscalContratoEmpresa');
        $isFiscalContratoCliente = getVariavelSessao('isFiscalContratoCliente');
        $isFiscalContratoFornecedor = getVariavelSessao('isFiscalContratoFornecedor');
        $isFiscalContrato = ($isFiscalContratoCliente || $isFiscalContratoEmpresa || $isFiscalContratoFornecedor) ? TRUE : FALSE;
        $isAnalistaMetricas = getVariavelSessao('isAnalistaMetricas');
        $isVisualizarContagemFornecedor = getConfigContagem('is_visualizar_contagem_fornecedor');
        /*
         * monta o sql para 0,1 (ativos e inativos) ou 1 (ativos)
         */
        $isAtivo = '';
        /*
         * array de retorno
         */
        $arrRoteiros = [];

        if ($tipo === '01') {
            $isAtivo = 'is_ativo IN (0, 1)';
        } else {
            $isAtivo = 'is_ativo = 1';
        }
        /*
         * id empresa 0 porque sao os roteiros padrao
         */
        $sql = "SELECT "
                . "* "
                . "FROM $this->table "
                . "WHERE "
                . "id_empresa = :idEmpresa || id_empresa = 0 ";

        /*
         * agrega os roteiros exclusivos Cliente e Fornecedor, 
         * no caso de um gestor da empresa visualizando/alterando uma contagem
         * ou de um analista de metricas com autorizacao para visualizar a contagem
         */
        if ($isGestor || $isViewer || $isGerenteConta || $isGerenteProjeto || $isFiscalContrato || $isDiretor || ($isAnalistaMetricas && $isVisualizarContagemFornecedor)) {
            $sql .= "UNION SELECT * "
                    . "FROM $this->table "
                    . "WHERE "
                    . "$isAtivo AND "
                    . "id_empresa = :idEmpresa AND "
                    . "id_fornecedor <> 0 ";
        }

        $stmt = DB::prepare($sql);
        $stmt->bindValue(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stmt->execute();
        $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
        /*
         * instancia classes Cliente e Fornecedor
         */
        $fornecedor = new Fornecedor();
        $cliente = new Cliente();

        foreach ($ret as $linha) {
            $arrRoteiros[] = array(
                'id' => $linha['id'],
                'descricao' => html_entity_decode($linha['descricao'] . (($linha['id_cliente'] > 0) ? ' &gt; (C) ' . $cliente->getSigla($linha['id_cliente']) : '') . (($linha['id_fornecedor'] > 0) ? ' &gt (F) ' . $fornecedor->getSigla($linha['id_fornecedor']) : ''), ENT_QUOTES),
                'observacoes' => html_entity_decode($linha['observacoes'], ENT_QUOTES),
                'is_ativo' => $linha['is_ativo'],
                'id_empresa' => $linha['id_empresa'],
                'id_fornecedor' => $linha['id_fornecedor'],
                'id_cliente' => $linha['id_cliente'],
                'tipo' => $linha['tipo'],
                'id_roteiro_importado' => $linha['id_roteiro_importado']
            );
        }

        return $arrRoteiros;
    }

    public function listaRoteiros($idEmpresa) {
        $sql = "SELECT * FROM $this->table WHERE id_empresa = :idEmpresa || id_empresa = 0";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $linha;
    }

    public function alterarStatusRoteiro($id, $isAtivo) {
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

    public function alterarTipoRoteiro($id, $tipo) {
        $stm = DB::prepare("UPDATE $this->table SET "
                        . "tipo = :tipo, "
                        . "atualizado_por = :atualizadoPor, "
                        . "ultima_atualizacao = :ultimaAtualizacao "
                        . "WHERE id = :id");
        $stm->bindParam(':tipo', $this->tipo, PDO::PARAM_INT);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stm->bindPAram(':id', $id, PDO::PARAM_INT);
        return($stm->execute());
    }

    public function insere() {
        $sql = "INSERT INTO $this->table (
        descricao,
        observacoes,
        is_ativo,
        id_empresa,
        id_fornecedor,
        id_cliente,
        tipo,
        id_roteiro_importado,
        ultima_atualizacao,
        atualizado_por) 
        VALUES (
        :descricao,
        :observacoes,
        :isAtivo,
        :idEmpresa,
        :idFornecedor,
        :idCliente,
        :tipo,
        :idRoteiroImportado,
        :ultimaAtualizacao,
        :atualizadoPor)";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':descricao', $this->descricao, PDO::PARAM_STR);
        $stmt->bindParam(':observacoes', $this->observacoes, PDO::PARAM_STR);
        $stmt->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
        $stmt->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stmt->bindParam(':idFornecedor', $this->idFornecedor, PDO::PARAM_INT);
        $stmt->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        $stmt->bindParam(':tipo', $this->tipo, PDO::PARAM_INT);
        $stmt->bindPAram(':idRoteiroImportado', $this->idRoteiroImportado, PDO::PARAM_INT);
        $stmt->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stmt->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stmt->execute();
        return DB::getInstance()->lastInsertId();
    }

    public function atualiza($idRoteiro) {
        $sql = "UPDATE $this->table SET 
                    descricao = :descricao,
                    observacoes = :observacoes,
                    is_ativo = :isAtivo,
                    id_empresa = :idEmpresa,
                    id_fornecedor = :idFornecedor,
                    id_cliente = :idCliente,
                    tipo = :tipo,
                    id_roteiro_importado = :idRoteiroImportado,
                    ultima_atualizacao = :ultimaAtualizacao,
                    atualizado_por = :atualizadoPor "
                . "WHERE id = :idRoteiro";

        $stmt = DB::prepare($sql);
        $stmt->bindPAram(':idRoteiro', $this->idRoteiro, PDO::PARAM_INT);
        $stmt->bindParam(':descricao', $this->descricao, PDO::PARAM_STR);
        $stmt->bindParam(':observacoes', $this->observacoes, PDO::PARAM_STR);
        $stmt->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
        $stmt->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stmt->bindParam(':idFornecedor', $this->idFornecedor, PDO::PARAM_INT);
        $stmt->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        $stmt->bindParam(':tipo', $this->tipo, PDO::PARAM_INT);
        $stmt->bindPAram(':idRoteiroImportado', $this->idRoteiroImportado, PDO::PARAM_INT);
        $stmt->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stmt->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stmt->execute();
        return $idRoteiro;
    }

    public function getDescricao($idRoteiro, $tabela = NULL) {
        $sql = "SELECT descricao FROM $this->table WHERE id = :idRoteiro";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idRoteiro', $idRoteiro, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }
    
}
