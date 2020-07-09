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

class ContagemConfigEmpresa extends CRUD {

    private $idEmpresa;
    private $idFornecedor;
    private $quantidadeMaximaEntregas;
    private $isProcessoValidacao;
    private $isVisualizarRoteirosPublicos;
    private $isValidarAdmGestor;
    private $isVisualizarSugestaoLinguagem;
    private $isProdutividadeGlobal;
    private $produtividadeGlobal;
    private $isAlterarProdutividadeGlobal;
    private $horasLiquidasTrabalhadas;
    private $isGestaoProjetos;
    private $isVisualizarContagemFornecedor;
    private $isVisualizarContagemTurma;
    private $isVisualizarTodasFiscalContrato;
    private $isExcluirCRUDIndependente;

    public function __construct() {
        $this->setTable('contagem_config_empresa');
        $this->setLog();
    }

    function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    function setIdFornecedor($idFornecedor) {
        $this->idFornecedor = $idFornecedor;
    }

    function setQuantidadeMaximaEntregas($quantidadeMaximaEntregas) {
        $this->quantidadeMaximaEntregas = $quantidadeMaximaEntregas;
    }

    function setIsProcessoValidacao($isProcessoValidacao) {
        $this->isProcessoValidacao = $isProcessoValidacao;
    }

    function setIsVisualizarRoteirosPublicos($isVisualizarRoteirosPublicos) {
        $this->isVisualizarRoteirosPublicos = $isVisualizarRoteirosPublicos;
    }

    function setIsValidarAdmGestor($isValidarAdmGestor) {
        $this->isValidarAdmGestor = $isValidarAdmGestor;
    }

    function setIsVisualizarSugestaoLinguagem($isVisualizarSugestaoLinguagem) {
        $this->isVisualizarSugestaoLinguagem = $isVisualizarSugestaoLinguagem;
    }

    function setIsProdutividadeGlobal($isProdutividadeGlobal) {
        $this->isProdutividadeGlobal = $isProdutividadeGlobal;
    }

    function setProdutividadeGlobal($produtividadeGlobal) {
        $this->produtividadeGlobal = $produtividadeGlobal;
    }

    function setIsAlterarProdutividadeGlobal($isAlterarProdutividadeGlobal) {
        $this->isAlterarProdutividadeGlobal = $isAlterarProdutividadeGlobal;
    }

    function setHorasLiquidasTrabalhadas($horasLiquidasTrabalhadas) {
        $this->horasLiquidasTrabalhadas = $horasLiquidasTrabalhadas;
    }

    function setIsGestaoProjetos($isGestaoProjetos) {
        $this->isGestaoProjetos = $isGestaoProjetos;
    }

    function setIsVisualizarContagemFornecedor($isVisualizarContagemFornecedor) {
        $this->isVisualizarContagemFornecedor = $isVisualizarContagemFornecedor;
    }

    function setIsVisualizarContagemTurma($isVisualizarContagemTurma) {
        $this->isVisualizarContagemTurma = $isVisualizarContagemTurma;
    }

    function setIsExcluirCRUDIndependente($isExcluirCRUDIndependente) {
        $this->isExcluirCRUDIndependente = $isExcluirCRUDIndependente;
    }

    function setIsVisualizarTodasFiscalContrato($isVisualizarTodasFiscalContrato) {
        $this->isVisualizarTodasFiscalContrato = $isVisualizarTodasFiscalContrato;
    }

    public function insere() {
        $stm = DB::prepare("INSERT INTO $this->table ("
                        . "id_empresa,"
                        . "id_fornecedor,"
                        . "ultima_atualizacao,"
                        . "atualizado_por) VALUES ("
                        . ":idEmpresa,"
                        . ":idFornecedor,"
                        . ":ultimaAtualizacao,"
                        . ":atualizadoPor)");
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $this->idFornecedor, PDO::PARAM_INT);
        /*
         * insere e retorna
         */
        return $stm->execute();
    }

    public function atualiza() {
        $sql = "UPDATE $this->table SET "
                . "quantidade_maxima_entregas = :quantidadeMaximaEntregas, "
                . "is_processo_validacao = :isProcessoValidacao, "
                . "is_visualizar_roteiros_publicos = :isVisualizarRoteirosPublicos, "
                . "is_validar_adm_gestor = :isValidarAdmGestor, "
                . "is_visualizar_sugestao_linguagem = :isVisualizarSugestaoLinguagem, "
                . "is_produtividade_global = :isProdutividadeGlobal, "
                . "produtividade_global = :produtividadeGlobal, "
                . "is_alterar_produtividade_global = :isAlterarProdutividadeGlobal, "
                . "is_visualizar_contagem_turma = :isVisualizarContagemTurma, "
                . "horas_liquidas_trabalhadas = :horasLiquidasTrabalhadas, "
                . "is_visualizar_todas_fiscal_contrato = :isVisualizarTodasFiscalContrato, "
                . "is_gestao_projetos = :isGestaoProjetos, "
                . "is_visualizar_contagem_fornecedor = :isVisualizarContagemFornecedor, "
                . "is_excluir_crud_independente = :isExcluirCRUDIndependente, "
                . "ultima_atualizacao = :ultimaAtualizacao, "
                . "atualizado_por = :atualizadoPor "
                . "WHERE id_empresa = :idEmpresa AND "
                . "id_fornecedor = :idFornecedor";
        $stm = DB::prepare($sql);
        $stm->bindParam(':quantidadeMaximaEntregas', $this->quantidadeMaximaEntregas, PDO::PARAM_INT);
        $stm->bindParam(':isProcessoValidacao', $this->isProcessoValidacao, PDO::PARAM_INT);
        $stm->bindParam(':isVisualizarRoteirosPublicos', $this->isVisualizarRoteirosPublicos, PDO::PARAM_INT);
        $stm->bindParam(':isValidarAdmGestor', $this->isValidarAdmGestor, PDO::PARAM_INT);
        $stm->bindParam(':isVisualizarSugestaoLinguagem', $this->isVisualizarSugestaoLinguagem, PDO::PARAM_INT);
        $stm->bindParam(':isProdutividadeGlobal', $this->isProdutividadeGlobal, PDO::PARAM_INT);
        $stm->bindParam(':produtividadeGlobal', $this->produtividadeGlobal, PDO::PARAM_INT);
        $stm->bindParam(':isAlterarProdutividadeGlobal', $this->isAlterarProdutividadeGlobal, PDO::PARAM_INT);
        $stm->bindParam(':isVisualizarContagemTurma', $this->isVisualizarContagemTurma, PDO::PARAM_INT);
        $stm->bindParam(':horasLiquidasTrabalhadas', $this->horasLiquidasTrabalhadas, PDO::PARAM_INT);
        $stm->bindParam(':isVisualizarTodasFiscalContrato', $this->isVisualizarTodasFiscalContrato, PDO::PARAM_INT);
        $stm->bindParam(':isGestaoProjetos', $this->isGestaoProjetos, PDO::PARAM_INT);
        $stm->bindParam(':isVisualizarContagemFornecedor', $this->isVisualizarContagemFornecedor, PDO::PARAM_INT);
        $stm->bindPAram(':isExcluirCRUDIndependente', $this->isExcluirCRUDIndependente, PDO::PARAM_INT);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $this->idFornecedor, PDO::PARAM_INT);
        return $stm->execute();
    }

    /**
     * 
     * @return array
     */
    public function getConfig() {
        // esta configuracao eh somente para a empresa, na aba da empresa
        $sql = "SELECT * FROM $this->table WHERE id_empresa = :idEmpresa AND id_fornecedor = :idFornecedor";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $this->idFornecedor, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

}
