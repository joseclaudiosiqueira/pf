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

class ContagemFaturamentoEmpresa extends CRUD {

    private $id;
    private $idEmpresa;
    private $idFornecedor;
    private $mesAnoFaturamento;
    private $responsavelFaturamento;
    private $idContagem;
    private $dataCadastroContagem;
    private $idCliente;
    private $idContrato;
    private $idProjeto;
    private $ordemServico;
    private $responsavelContagem;
    private $pfa;
    private $pfb;
    private $valorPFCcontrato;
    private $idAbrangencia;
    private $idEtapa;
    private $valorFaturamento;
    private $dataGeracaoFaturamento;

    public function __construct() {
        $this->setTable('contagem_faturamento_empresa');
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

    function setMesAnoFaturamento($mesAnoFaturamento) {
        $this->mesAnoFaturamento = $mesAnoFaturamento;
    }

    function setResponsavelFaturamento($responsavelFaturamento) {
        $this->responsavelFaturamento = $responsavelFaturamento;
    }

    function setIdContagem($idContagem) {
        $this->idContagem = $idContagem;
    }

    function setDataCadastroContagem($dataCadastroContagem) {
        $this->dataCadastroContagem = $dataCadastroContagem;
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

    function setOrdemServico($ordemServico) {
        $this->ordemServico = $ordemServico;
    }

    function setResponsavelContagem($responsavelContagem) {
        $this->responsavelContagem = $responsavelContagem;
    }

    function setPfa($pfa) {
        $this->pfa = $pfa;
    }

    function setPfb($pfb) {
        $this->pfb = $pfb;
    }

    function setValorPFCcontrato($valorPFCcontrato) {
        $this->valorPFCcontrato = $valorPFCcontrato;
    }

    function setIdAbrangencia($idAbrangencia) {
        $this->idAbrangencia = $idAbrangencia;
    }

    function setIdEtapa($idEtapa) {
        $this->idEtapa = $idEtapa;
    }

    function setValorFaturamento($valorFaturamento) {
        $this->valorFaturamento = $valorFaturamento;
    }

    function setDataGeracaoFaturamento($dataGeracaoFaturamento) {
        $this->dataGeracaoFaturamento = $dataGeracaoFaturamento;
    }

    public function insere() {
        $sql = "INSERT INTO $this->table ("
                . "id_empresa,
                        id_fornecedor,
                        mes_ano_faturamento,
                        responsavel_faturamento,
                        id_contagem,
                        data_cadastro_contagem,
                        id_cliente,
                        id_contrato,
                        id_projeto,
                        ordem_servico,
                        responsavel_contagem,
                        pfa,
                        pfb,
                        valor_pf_contrato,
                        id_abrangencia,
                        id_etapa,
                        valor_faturamento,
                        data_geracao_faturamento)
                    VALUES (
                        :idEmpresa,
                        :idFornecedor,
                        :mesAnoFaturamento,
                        :responsavelFaturamento,
                        :idContagem,
                        :dataCadastroContagem,
                        :idCliente,
                        :idContrato,
                        :idProjeto,
                        :ordemServico,
                        :responsavelContagem,
                        :pfa,
                        :pfb,
                        :valorPFContrato,
                        :idAbrangencia,
                        :idEtapa,
                        :valorFaturamento,
                        :dataGeracaoFaturamento)";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $this->idFornecedor, PDO::PARAM_INT);
        $stm->bindParam(':mesAnoFaturamento', $this->mesAnoFaturamento, PDO::PARAM_STR);
        $stm->bindParam(':responsavelFaturamento', $this->responsavelFaturamento, PDO::PARAM_STR);
        $stm->bindParam(':idContagem', $this->idContagem, PDO::PARAM_INT);
        $stm->bindParam(':dataCadastroContagem', $this->dataCadastroContagem, PDO::PARAM_STR);
        $stm->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        $stm->bindParam(':idContrato', $this->idContrato, PDO::PARAM_INT);
        $stm->bindParam(':idProjeto', $this->idProjeto, PDO::PARAM_INT);
        $stm->bindParam(':ordemServico', $this->ordemServico, PDO::PARAM_STR);
        $stm->bindParam(':responsavelContagem', $this->responsavelContagem, PDO::PARAM_STR);
        $stm->bindParam(':pfa', $this->pfa, PDO::PARAM_STR);
        $stm->bindParam(':pfb', $this->pfb, PDO::PARAM_STR);
        $stm->bindParam(':valorPFContrato', $this->valorPFCcontrato, PDO::PARAM_STR);
        $stm->bindParam(':idAbrangencia', $this->idAbrangencia, PDO::PARAM_INT);
        $stm->bindParam(':idEtapa', $this->idEtapa, PDO::PARAM_INT);
        $stm->bindParam(':valorFaturamento', $this->valorFaturamento, PDO::PARAM_STR);
        $stm->bindParam(':dataGeracaoFaturamento', $this->dataGeracaoFaturamento, PDO::PARAM_STR);
        return $stm->execute();
    }

    public function atualiza($id) {
        
    }

    public function getContagemFaturamentoEmpresa($mesAnoFaturamento, $idEmpresa, $idFornecedor) {
        $sql = "SELECT "
                . "cfe.id, "
                . "cfe.id_empresa, "
                . "cfe.id_fornecedor, "
                . "cfe.mes_ano_faturamento, "
                . "cfe.responsavel_faturamento, "
                . "cfe.id_contagem, "
                . "cfe.data_cadastro_contagem, "
                . "cfe.ordem_servico, "
                . "cfe.responsavel_contagem, "
                . "cfe.pfa, "
                . "cfe.pfb, "
                . "cfe.valor_pf_contrato, "
                . "cfe.valor_faturamento, "
                . "cfe.data_geracao_faturamento, "
                . "concat(cli.sigla, '-', cli.descricao) AS cliente, "
                . "concat(cnt.ano, '-', cnt.numero) AS contrato, "
                . "prj.descricao AS projeto, "
                . "abr.descricao AS abrangencia "
                . "FROM "
                . "contagem_faturamento_empresa cfe, "
                . "cliente cli, "
                . "contrato cnt, "
                . "projeto prj, "
                . "contagem_abrangencia abr "
                . "WHERE "
                . "cfe.id_cliente = cli.id AND "
                . "cfe.id_contrato = cnt.id AND "
                . "cfe.id_projeto = prj.id AND "
                . "cfe.id_abrangencia = abr.id AND "
                . "cfe.mes_ano_faturamento = '$mesAnoFaturamento' AND "
                . "cfe.id_empresa = $idEmpresa AND "
                . "cfe.id_fornecedor = $idFornecedor ORDER BY id ASC";
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

}
