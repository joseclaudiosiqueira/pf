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

class ClienteConfigRelatorio extends CRUD {

    private $idCliente;
    private $cabLinha1;
    private $cabLinha2;
    private $cabLinha3;
    private $rodLinha1;
    private $isLogomarcaEmpresa;
    private $isLogomarcaCliente;
    private $cabAlinhamento;

    public function __construct() {
        $this->setTable('cliente_config_relatorio');
        $this->setLog();
    }

    function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }

    function setCabLinha1($cabLinha1) {
        $this->cabLinha1 = $cabLinha1;
    }

    function setCabLinha2($cabLinha2) {
        $this->cabLinha2 = $cabLinha2;
    }

    function setCabLinha3($cabLinha3) {
        $this->cabLinha3 = $cabLinha3;
    }

    function setRodLinha1($rodLinha1) {
        $this->rodLinha1 = $rodLinha1;
    }

    function setIsLogomarcaEmpresa($isLogomarcaEmpresa) {
        $this->isLogomarcaEmpresa = $isLogomarcaEmpresa;
    }

    function setIsLogomarcaCliente($isLogomarcaCliente) {
        $this->isLogomarcaCliente = $isLogomarcaCliente;
    }

    function setCabAlinhamento($cabAlinhamento) {
        $this->cabAlinhamento = $cabAlinhamento;
    }

    function setUltimaAtualizacao($ultimaAtualizacao) {
        $this->ultimaAtualizacao = $ultimaAtualizacao;
    }

    function setAtualizadoPor($atualizadoPor) {
        $this->atualizadoPor = $atualizadoPor;
    }

    public function atualiza($idCliente) {

        $sql = "UPDATE cliente_config_relatorio SET "
                . "cab_linha_1 = :cabLinha1, "
                . "cab_linha_2 = :cabLinha2, "
                . "cab_linha_3 = :cabLinha3, "
                . "rod_linha_1 = :rodLinha1, "
                . "is_logomarca_empresa = :isLogomarcaEmpresa, "
                . "is_logomarca_cliente = :isLogomarcaCliente,"
                . "cab_alinhamento = :cabAlinhamento, "
                . "ultima_atualizacao = :ultimaAtualizacao,"
                . "atualizado_por = :atualizadoPor "
                . "WHERE id_cliente = :idCliente";
        $stm = DB::prepare($sql);
        $stm->bindParam(':cabLinha1', $this->cabLinha1, PDO::PARAM_STR);
        $stm->bindParam(':cabLinha2', $this->cabLinha2, PDO::PARAM_STR);
        $stm->bindParam(':cabLinha3', $this->cabLinha3, PDO::PARAM_STR);
        $stm->bindParam(':rodLinha1', $this->rodLinha1, PDO::PARAM_STR);
        $stm->bindParam(':isLogomarcaEmpresa', $this->isLogomarcaEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':isLogomarcaCliente', $this->isLogomarcaCliente, PDO::PARAM_INT);
        $stm->bindParam(':cabAlinhamento', $this->cabAlinhamento, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        return $stm->execute();
    }

    public function insere() {
        /*
         * insere uma linha
         */
        $sql = "INSERT INTO $this->table ("
                . "id_cliente, "
                . "ultima_atualizacao, "
                . "atualizado_por) "
                . "VALUES ("
                . ":idCliente, "
                . ":ultimaAtualizacao, "
                . ":atualizadoPor)";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        return $stm->execute();
    }

    /*
     * neste caso retorna a logomarca do cliente
     */

    public function getConfig($id) {
        $sql = "SELECT con.*, cli.logomarca FROM $this->table con, cliente cli "
                . "WHERE con.id_cliente = cli.id "
                . "AND id_cliente = :id";
        $stm = DB::prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha;
    }

}
