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

class EmpresaConfigPlano extends CRUD {

    private $idEmpresa;
    private $idPlano;
    private $dataInicio;
    private $dataFim;
    private $mensalidade;
    private $valorContagem;
    private $isFaturavel;
    private $indicadoPor;
    private $tipoFaturamento;

    public function __construct() {
        $this->setTable('empresa_config_plano');
        $this->setLog();
    }

    function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    function setIdPlano($idPlano) {
        $this->idPlano = $idPlano;
    }

    function setDataInicio($dataInicio) {
        $this->dataInicio = $dataInicio;
    }

    function setDataFim($dataFim) {
        $this->dataFim = $dataFim;
    }

    function setMensalidade($mensalidade) {
        $this->mensalidade = $mensalidade;
    }

    function setValorContagem($valorContagem) {
        $this->valorContagem = $valorContagem;
    }

    function setIsFaturavel($isFaturavel) {
        $this->isFaturavel = $isFaturavel;
    }

    function setIndicadoPor($indicadoPor) {
        $this->indicadoPor = $indicadoPor;
    }

    function setTipoFaturamento($tipoFaturamento) {
        $this->tipoFaturamento = $tipoFaturamento;
    }

    public function insere() {
        $stm = DB::prepare("INSERT INTO $this->table ("
                        . "id_empresa,"
                        . "id_plano,"
                        . "data_inicio,"
                        . "data_fim,"
                        . "mensalidade,"
                        . "valor_contagem,"
                        . "is_faturavel,"
                        . "indicado_por,"
                        . "tipo_faturamento,"
                        . "ultima_atualizacao,"
                        . "atualizado_por) VALUES ("
                        . ":idEmpresa,"
                        . ":idPlano,"
                        . ":dataInicio,"
                        . ":dataFim,"
                        . ":mensalidade,"
                        . ":valorContagem,"
                        . ":isFaturavel,"
                        . ":indicadoPor,"
                        . ":tipoFaturamento,"
                        . ":ultimaAtualizacao,"
                        . ":atualizadoPor)");
        $stm->bindParam(':idPlano', $this->idPlano, PDO::PARAM_INT);
        $stm->bindParam(':dataInicio', $this->dataInicio, PDO::PARAM_STR);
        $stm->bindParam(':dataFim', $this->dataFim, PDO::PARAM_STR);
        $stm->bindParam(':mensalidade', $this->mensalidade);
        $stm->bindParam(':valorContagem', $this->valorContagem);
        $stm->bindParam(':isFaturavel', $this->isFaturavel, PDO::PARAM_INT);
        $stm->bindParam(':indicadoPor', $this->indicadoPor, PDO::PARAM_STR);
        $stm->bindParam(':tipoFaturamento', $this->tipoFaturamento, PDO::PARAM_INT);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        /*
         * insere e retorna
         */
        return $stm->execute();
    }

    public function getConfig() {
        $sql = "SELECT pl.*, em.mensalidade FROM plano pl, empresa_config_plano em WHERE pl.id = em.id_plano AND em.id_empresa = :idEmpresa";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function copiaEmpresaConfigPlanoFornecedor($idEmpresa, $idFornecedor) {
        $stm = DB::prepare("INSERT INTO fornecedor_config_plano ("
                        . "id_fornecedor, "
                        . "id_plano, "
                        . "data_inicio, "
                        . "data_fim, "
                        . "ultima_atualizacao, "
                        . "atualizado_por) SELECT "
                        . "'$idFornecedor', "
                        . "id_plano, "
                        . "data_inicio, "
                        . "data_fim, "
                        . "'$this->ultimaAtualizacao', "
                        . "'$this->atualizadoPor' FROM "
                        . "empresa_config_plano WHERE "
                        . "id_empresa = :idEmpresa");
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->execute();
        $id = DB::getInstance()->lastInsertId();
        return $id;
    }

    function getIds() {
        $stm = DB::prepare("SELECT id_empresa AS id, is_faturavel, indicado_por, tipo_faturamento FROM $this->table");
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

}
