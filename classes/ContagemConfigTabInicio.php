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

class ContagemConfigTabInicio extends CRUD {

    private $id;
    private $idEmpresa;
    private $idFornecedor;
    private $idCliente;
    private $idContrato;
    private $idProjeto;
    private $idOrgao;
    private $ordemServico;
    private $idLinguagem;
    private $idTipo;
    private $idEtapa;
    private $idBancoDados;
    private $idAreaAtuacao; //id_industria
    private $idProcesso;
    private $idProcessoGestao;
    private $proposito;
    private $escopo;

    public function __construct() {
        $this->setTable('contagem_config_tab_inicio');
        $this->setLog();
    }

    public function insere() {
        $sql = "INSERT INTO $this->table (id_empresa, id_fornecedor, id_cliente, id_contrato, id_projeto, id_orgao, ordem_servico, id_linguagem, id_tipo, id_etapa, id_banco_dados, id_area_atuacao, id_processo, id_processo_gestao, proposito, escopo, ultima_atualizacao, atualizado_por) VALUES "
                . "(:idEmpresa, :idFornecedor, :idCliente, :idContrato, :idProjeto, :idOrgao, :ordemServico, :idLinguagem, :idTipo, :idEtapa, :idBancoDados, :idAreaAtuacao, :idProcesso, :idProcessoGestao, :proposito, :escopo, :ultimaAtualizacao, :atualizadoPor)";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $this->idFornecedor, PDO::PARAM_INT);
        $stm->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        $stm->bindParam(':idContrato', $this->idContrato, PDO::PARAM_INT);
        $stm->bindParam(':idProjeto', $this->idProjeto, PDO::PARAM_INT);
        $stm->bindParam(':idOrgao', $this->idOrgao, PDO::PARAM_INT);
        $stm->bindParam(':ordemServico', $this->ordemServico, PDO::PARAM_STR);
        $stm->bindParam(':idLinguagem', $this->idLinguagem, PDO::PARAM_INT);
        $stm->bindParam(':idTipo', $this->idTipo, PDO::PARAM_INT);
        $stm->bindParam(':idEtapa', $this->idEtapa, PDO::PARAM_INT);
        $stm->bindParam(':idBancoDados', $this->idBancoDados, PDO::PARAM_INT);
        $stm->bindParam(':idAreaAtuacao', $this->idAreaAtuacao, PDO::PARAM_INT);
        $stm->bindParam(':idProcesso', $this->idProcesso, PDO::PARAM_INT);
        $stm->bindParam(':idProcessoGestao', $this->idProcessoGestao, PDO::PARAM_INT);
        $stm->bindParam(':proposito', $this->proposito, PDO::PARAM_STR);
        $stm->bindParam(':escopo', $this->escopo, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor);
        return $stm->execute();
    }

    public function atualiza($id) {
        //nao implementado
    }

    function listaConfiguracoesTabInicio($idCliente) {
        $sql = "SELECT "
                . "cti.id, "
                . "CONCAT(cli.sigla,' - ',cli.descricao) AS cliente, "
                . "CONCAT(con.ano,' - ',con.numero) AS contrato, "
                . "prj.descricao AS projeto,"
                . "CONCAT(org.sigla,' - ',org.descricao) AS orgao,"
                . "cti.ordem_servico AS ordemServico, "
                . "lng.descricao AS linguagem,"
                . "bda.descricao AS bancoDados,"
                . "tpo.descricao AS tipo,"
                . "etp.descricao AS etapa,"
                . "atu.descricao AS atuacao,"
                . "pro.descricao AS processo,"
                . "ges.descricao AS gestao, "
                . "cti.proposito, "
                . "cti.escopo "
                . "FROM $this->table cti,"
                . "cliente cli,"
                . "contagem_config_linguagem lng,"
                . "contagem_config_banco_dados bda,"
                . "tipo_contagem tpo,"
                . "industria atu,"
                . "processo pro,"
                . "processo_gestao ges,"
                . "contrato con, "
                . "projeto prj,"
                . "orgao org,"
                . "etapa etp "
                . "WHERE "
                . "cti.id_cliente = cli.id AND "
                . "cti.id_contrato = con.id AND "
                . "cti.id_projeto = prj.id AND "
                . "cti.id_orgao = org.id AND "
                . "cti.id_etapa = etp.id AND "
                . "cti.id_linguagem = lng.id AND "
                . "cti.id_banco_dados = bda.id AND "
                . "cti.id_tipo = tpo.id AND "
                . "cti.id_area_atuacao = atu.id AND "
                . "cti.id_processo = pro.id AND "
                . "cti.id_processo_gestao = ges.id AND "
                . "cti.id_empresa = $this->idEmpresa AND "
                . "cti.id_fornecedor = $this->idFornecedor "
                . ($idCliente ? "AND cti.id_cliente = $this->idCliente " : "")
                . "ORDER BY id DESC";
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listaIdsConfiguracoesTabInicio() {
        $sql = "SELECT * FROM $this->table WHERE id = $this->id";
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function exclui($id) {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $stm = DB::prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        return $stm->execute();
    }

    function setId($id) {
        $this->id = $id;
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

    function setIdContrato($idContrato) {
        $this->idContrato = $idContrato;
    }

    function setIdProjeto($idProjeto) {
        $this->idProjeto = $idProjeto;
    }

    function setIdOrgao($idOrgao) {
        $this->idOrgao = $idOrgao;
    }

    function setOrdemServico($ordemServico) {
        $this->ordemServico = $ordemServico;
    }

    function setIdLinguagem($idLinguagem) {
        $this->idLinguagem = $idLinguagem;
    }

    function setIdTipo($idTipo) {
        $this->idTipo = $idTipo;
    }

    function setIdEtapa($idEtapa) {
        $this->idEtapa = $idEtapa;
    }

    function setIdBancoDados($idBancoDados) {
        $this->idBancoDados = $idBancoDados;
    }

    function setIdAreaAtuacao($idAreaAtuacao) {
        $this->idAreaAtuacao = $idAreaAtuacao;
    }

    function setIdProcesso($idProcesso) {
        $this->idProcesso = $idProcesso;
    }

    function setIdProcessoGestao($idProcessoGestao) {
        $this->idProcessoGestao = $idProcessoGestao;
    }

    function setProposito($proposito) {
        $this->proposito = $proposito;
    }

    function setEscopo($escopo) {
        $this->escopo = $escopo;
    }

}
