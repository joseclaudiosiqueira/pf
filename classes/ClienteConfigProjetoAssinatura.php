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

class ClienteConfigProjetoAssinatura extends CRUD {

    private $idProjeto;
    private $assinaturaNome1;
    private $assinaturaNome2;
    private $assinaturaNome3;
    private $assinaturaNome4;
    private $assinaturaNome5;
    private $assinaturaNome6;
    private $assinaturaCargo1;
    private $assinaturaCargo2;
    private $assinaturaCargo3;
    private $assinaturaCargo4;
    private $assinaturaCargo5;
    private $assinaturaCargo6;
    private $isAssinaturaRelatorio;
    
    public function __construct() {
        $this->setTable('cliente_config_projeto_assinatura');
        $this->setLog();
    }

    function setIdProjeto($idProjeto) {
        $this->idProjeto = $idProjeto;
    }

    function setAssinaturaNome1($assinaturaNome1) {
        $this->assinaturaNome1 = $assinaturaNome1;
    }

    function setAssinaturaNome2($assinaturaNome2) {
        $this->assinaturaNome2 = $assinaturaNome2;
    }

    function setAssinaturaNome3($assinaturaNome3) {
        $this->assinaturaNome3 = $assinaturaNome3;
    }

    function setAssinaturaNome4($assinaturaNome4) {
        $this->assinaturaNome4 = $assinaturaNome4;
    }

    function setAssinaturaNome5($assinaturaNome5) {
        $this->assinaturaNome5 = $assinaturaNome5;
    }

    function setAssinaturaNome6($assinaturaNome6) {
        $this->assinaturaNome6 = $assinaturaNome6;
    }

    function setAssinaturaCargo1($assinaturaCargo1) {
        $this->assinaturaCargo1 = $assinaturaCargo1;
    }

    function setAssinaturaCargo2($assinaturaCargo2) {
        $this->assinaturaCargo2 = $assinaturaCargo2;
    }

    function setAssinaturaCargo3($assinaturaCargo3) {
        $this->assinaturaCargo3 = $assinaturaCargo3;
    }

    function setAssinaturaCargo4($assinaturaCargo4) {
        $this->assinaturaCargo4 = $assinaturaCargo4;
    }

    function setAssinaturaCargo5($assinaturaCargo5) {
        $this->assinaturaCargo5 = $assinaturaCargo5;
    }

    function setAssinaturaCargo6($assinaturaCargo6) {
        $this->assinaturaCargo6 = $assinaturaCargo6;
    }

    function setIsAssinaturaRelatorio($isAssinaturaRelatorio) {
        $this->isAssinaturaRelatorio = $isAssinaturaRelatorio;
    }

    public function atualiza($idProjeto) {

        $sql = "UPDATE $this->table SET "
                . "assinatura_nome_1 = :assinaturaNome1, "
                . "assinatura_nome_2 = :assinaturaNome2, "
                . "assinatura_nome_3 = :assinaturaNome3, "
                . "assinatura_nome_4 = :assinaturaNome4, "
                . "assinatura_nome_5 = :assinaturaNome5, "
                . "assinatura_nome_6 = :assinaturaNome6,"
                . "assinatura_cargo_1 = :assinaturaCargo1, "
                . "assinatura_cargo_2 = :assinaturaCargo2, "
                . "assinatura_cargo_3 = :assinaturaCargo3, "
                . "assinatura_cargo_4 = :assinaturaCargo4, "
                . "assinatura_cargo_5 = :assinaturaCargo5, "
                . "assinatura_cargo_6 = :assinaturaCargo6, "
                . "ultima_atualizacao = :ultimaAtualizacao,"
                . "atualizado_por = :atualizadoPor,"
                . "is_assinatura_relatorio = :isAssinaturaRelatorio "
                . "WHERE id_projeto = :idProjeto";
        $stm = DB::prepare($sql);
        $stm->bindParam(':assinaturaNome1', $this->assinaturaNome1, PDO::PARAM_STR);
        $stm->bindParam(':assinaturaNome2', $this->assinaturaNome2, PDO::PARAM_STR);
        $stm->bindParam(':assinaturaNome3', $this->assinaturaNome3, PDO::PARAM_STR);
        $stm->bindParam(':assinaturaNome4', $this->assinaturaNome4, PDO::PARAM_STR);
        $stm->bindParam(':assinaturaNome5', $this->assinaturaNome5, PDO::PARAM_STR);
        $stm->bindParam(':assinaturaNome6', $this->assinaturaNome6, PDO::PARAM_STR);
        $stm->bindParam(':assinaturaCargo1', $this->assinaturaCargo1, PDO::PARAM_STR);
        $stm->bindParam(':assinaturaCargo2', $this->assinaturaCargo2, PDO::PARAM_STR);
        $stm->bindParam(':assinaturaCargo3', $this->assinaturaCargo3, PDO::PARAM_STR);
        $stm->bindParam(':assinaturaCargo4', $this->assinaturaCargo4, PDO::PARAM_STR);
        $stm->bindParam(':assinaturaCargo5', $this->assinaturaCargo5, PDO::PARAM_STR);
        $stm->bindParam(':assinaturaCargo6', $this->assinaturaCargo6, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':isAssinaturaRelatorio', $this->isAssinaturaRelatorio, PDO::PARAM_INT);
        $stm->bindParam(':idProjeto', $this->idProjeto, PDO::PARAM_INT);
        return $stm->execute();
    }

    public function insere() {
        /*
         * insere uma linha
         */
        $sql = "INSERT INTO $this->table ("
                . "id_projeto, "
                . "is_assinatura_relatorio, "
                . "ultima_atualizacao, "
                . "atualizado_por) "
                . "VALUES ("
                . ":idProjeto, "
                . ":isAssinaturaRelatorio, "
                . ":ultimaAtualizacao, "
                . ":atualizadoPor)";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idProjeto', $this->idProjeto, PDO::PARAM_INT);
        $stm->bindParam(':isAssinaturaRelatorio', $this->isAssinaturaRelatorio, PDO::PARAM_INT);        
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        return $stm->execute();
    }

    public function getConfig($id) {
        $sql = "SELECT * FROM $this->table "
                . "WHERE id_projeto = :id ";
        $stm = DB::prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha;
    }

}
