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

class ContagemBaselineEstimativa extends CRUD {

    private $idContagem;
    private $qtdALI;
    private $qtdAIE;
    private $qtdEE;
    private $qtdSE;
    private $qtdCE;
    private $qtdOU;
    private $pfbALI;
    private $pfbAIE;
    private $pfbEE;
    private $pfbSE;
    private $pfbCE;
    private $pfbOU;
    private $pfaALI;
    private $pfaAIE;
    private $pfaEE;
    private $pfaSE;
    private $pfaCE;
    private $pfaOU;

    public function __construct() {
        $this->setTable('contagem_baseline_estimativa');
        $this->setLog();
    }

    public function insere() {
        $sql = "INSERT INTO $this->table (id_contagem, atualizado_por, ultima_atualizacao) "
                . "VALUES('$this->idContagem', "
                . "'$this->atualizadoPor', "
                . "'$this->ultimaAtualizacao')";
        $stm = DB::prepare($sql);
        return $stm->execute();
    }
    
    /**
     * 
     * @return boolean
     */
    public function atualiza() {
        $sql = "INSERT INTO $this->table ("
            . "id_contagem, "
            . "qtd_ali, "
            . "qtd_aie, "
            . "qtd_ee, "
            . "qtd_se, "
            . "qtd_ce, "
            . "qtd_ou, "
            . "pfb_ali, "
            . "pfa_ali, "
            . "pfb_aie, "
            . "pfa_aie, "
            . "pfb_ee, "
            . "pfa_ee, "
            . "pfb_se, "
            . "pfa_se, "
            . "pfb_ce, "
            . "pfa_ce, "
            . "pfb_ou, "
            . "pfa_ou, "
            . "atualizado_por, "
            . "ultima_atualizacao) VALUES ("
            . "$this->idContagem, "
            . "$this->qtdALI, "
            . "$this->qtdAIE, "
            . "$this->qtdEE, "
            . "$this->qtdSE, "
            . "$this->qtdCE, "
            . "$this->qtdOU, "
            . "$this->pfbALI, "
            . "$this->pfaALI, "
            . "$this->pfbAIE, "
            . "$this->pfaAIE, "
            . "$this->pfbEE, "
            . "$this->pfaEE, "
            . "$this->pfbSE, "
            . "$this->pfaSE, "
            . "$this->pfbCE, "
            . "$this->pfaCE, "
            . "$this->pfbOU, "
            . "$this->pfaOU, "
            . "'$this->atualizadoPor', "
            . "'$this->ultimaAtualizacao')";
        $stm = DB::prepare($sql);
        return $stm->execute();
    }
    
    public function atualiza_v1() {
        $sql = "UPDATE $this->table SET "
                . "qtd_ali = $this->qtdALI, "
                . "qtd_aie = $this->qtdAIE, "
                . "qtd_ee = $this->qtdEE, "
                . "qtd_se = $this->qtdSE, "
                . "qtd_ce = $this->qtdCE, "
                . "qtd_ou = $this->qtdOU, "
                . "pfb_ali = $this->pfbALI, "
                . "pfa_ali = $this->pfaALI, "
                . "pfb_aie = $this->pfbAIE, "
                . "pfa_aie = $this->pfaAIE, "
                . "pfb_ee = $this->pfbEE, "
                . "pfa_ee = $this->pfaEE, "
                . "pfb_se = $this->pfbSE, "
                . "pfa_se = $this->pfaSE, "
                . "pfb_ce = $this->pfbCE, "
                . "pfa_ce = $this->pfaCE, "
                . "pfb_ou = $this->pfbOU, "
                . "pfa_ou = $this->pfaOU "
                . "WHERE id_contagem = $this->idContagem";
        $stm = DB::prepare($sql);
        return $stm->execute();
    }

    function setIdContagem($idContagem) {
        $this->idContagem = $idContagem;
    }

    function setQtdALI($qtdALI) {
        $this->qtdALI = $qtdALI;
    }

    function setQtdAIE($qtdAIE) {
        $this->qtdAIE = $qtdAIE;
    }

    function setQtdEE($qtdEE) {
        $this->qtdEE = $qtdEE;
    }

    function setQtdSE($qtdSE) {
        $this->qtdSE = $qtdSE;
    }

    function setQtdCE($qtdCE) {
        $this->qtdCE = $qtdCE;
    }

    function setQtdOU($qtdOU) {
        $this->qtdOU = $qtdOU;
    }

    function setPfbALI($pfbALI) {
        $this->pfbALI = $pfbALI;
    }

    function setPfbAIE($pfbAIE) {
        $this->pfbAIE = $pfbAIE;
    }

    function setPfbEE($pfbEE) {
        $this->pfbEE = $pfbEE;
    }

    function setPfbSE($pfbSE) {
        $this->pfbSE = $pfbSE;
    }

    function setPfbCE($pfbCE) {
        $this->pfbCE = $pfbCE;
    }

    function setPfbOU($pfbOU) {
        $this->pfbOU = $pfbOU;
    }

    function setPfaALI($pfaALI) {
        $this->pfaALI = $pfaALI;
    }

    function setPfaAIE($pfaAIE) {
        $this->pfaAIE = $pfaAIE;
    }

    function setPfaEE($pfaEE) {
        $this->pfaEE = $pfaEE;
    }

    function setPfaSE($pfaSE) {
        $this->pfaSE = $pfaSE;
    }

    function setPfaCE($pfaCE) {
        $this->pfaCE = $pfaCE;
    }

    function setPfaOU($pfaOU) {
        $this->pfaOU = $pfaOU;
    }

}
