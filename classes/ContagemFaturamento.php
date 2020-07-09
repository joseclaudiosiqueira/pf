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

class ContagemFaturamento extends CRUD {

    private $idFaturamento;
    private $idContagem;
    private $dataCadastro;
    private $responsavel;
    private $cliente;
    private $contrato;
    private $projeto;
    private $abrangencia;
    private $pfb;
    private $pfa;

    function setIdFaturamento($idFaturamento) {
        $this->idFaturamento = $idFaturamento;
    }

    function setIdContagem($idContagem) {
        $this->idContagem = $idContagem;
    }

    function setDataCadastro($dataCadastro) {
        $this->dataCadastro = $dataCadastro;
    }

    function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    function setContrato($contrato) {
        $this->contrato = $contrato;
    }

    function setProjeto($projeto) {
        $this->projeto = $projeto;
    }

    function setAbrangencia($abrangencia) {
        $this->abrangencia = $abrangencia;
    }

    function setPfb($pfb) {
        $this->pfb = $pfb;
    }

    function setPfa($pfa) {
        $this->pfa = $pfa;
    }

    public function insere() {
        $stm = DB::prepare("INSERT INTO $this->table ("
                        . "id_faturamento,"
                        . "id_contagem,"
                        . "data_cadastro,"
                        . "responsavel,"
                        . "cliente,"
                        . "contrato,"
                        . "projeto,"
                        . "abrangencia,"
                        . "pfb,"
                        . "pfa"
                        . ") VALUES ("
                        . ":idFaturamento,"
                        . ":idContagem,"
                        . ":dataCadastro,"
                        . ":responsavel,"
                        . ":cliente,"
                        . ":contrato,"
                        . ":projeto,"
                        . ":abrangencia,"
                        . ":pfb,"
                        . ":pfa"
                        . ")");
        $stm->bindParam(':idFaturamento', $this->idFaturamento, PDO::PARAM_INT);
        $stm->bindParam(':idContagem', $this->idContagem, PDO::PARAM_INT);
        $stm->bindParam(':dataCadastro', $this->dataCadastro, PDO::PARAM_STR);
        $stm->bindParam(':responsavel', $this->responsavel, PDO::PARAM_STR);
        $stm->bindParam(':cliente', $this->cliente, PDO::PARAM_STR);
        $stm->bindParam(':contrato', $this->contrato, PDO::PARAM_STR);
        $stm->bindParam(':projeto', $this->projeto, PDO::PARAM_STR);
        $stm->bindParam(':abrangencia', $this->abrangencia, PDO::PARAM_STR);
        $stm->bindParam(':pfb', $this->pfb);
        $stm->bindParam(':pfa', $this->pfa);
        return $stm->execute();
    }

    public function atualiza($id) {
        
    }

    public function getContagemFaturamento($idEmpresa, $idFaturamento) {
        $stm = DB::prepare(""
                . "SELECT cf.* "
                . "FROM $this->table cf, faturamento fa "
                . "WHERE fa.id = :idFaturamento AND "
                . "fa.id_empresa = :idEmpresa AND "
                . "fa.id = cf.id_faturamento");
        $stm->bindParam(':idFaturamento', $idFaturamento, PDO::PARAM_INT);
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

}
