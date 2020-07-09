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

class ContagemAcesso extends CRUD {

    private $idContagem;
    private $userEmail;
    private $isAtivo;
    private $concedidoEm;
    private $concedidoPor;
    private $revogadoEm;
    private $revogadoPor;

    public function __construct() {
        $this->setTable('contagem_acesso');
    }

    function getIdContagem() {
        return $this->idContagem;
    }

    function getUserEmail() {
        return $this->userEmail;
    }

    function getIsAtivo() {
        return $this->isAtivo;
    }

    function getConcedidoEm() {
        return $this->concedidoEm;
    }

    function getConcedidoPor() {
        return $this->concedidoPor;
    }

    function getRevogadoEm() {
        return $this->revogadoEm;
    }

    function getRevogadoPor() {
        return $this->revogadoPor;
    }

    function setIdContagem($idContagem) {
        $this->idContagem = $idContagem;
    }

    function setUserEmail($userEmail) {
        $this->userEmail = $userEmail;
    }

    function setIsAtivo($isAtivo) {
        $this->isAtivo = $isAtivo;
    }

    function setConcedidoEm($concedidoEm) {
        $this->concedidoEm = $concedidoEm;
    }

    function setConcedidoPor($concedidoPor) {
        $this->concedidoPor = $concedidoPor;
    }

    function setRevogadoEm($revogadoEm) {
        $this->revogadoEm = $revogadoEm;
    }

    function setRevogadoPor($revogadoPor) {
        $this->revogadoPor = $revogadoPor;
    }

    public function isAutorizado() {
        $sql = "SELECT count(id) AS id FROM $this->table WHERE user_email = :userEmail AND id_contagem = :idContagem AND is_ativo = 1";
        $stm = DB::prepare($sql);
        $stm->bindParam(':userEmail', $this->userEmail, PDO::PARAM_STR);
        $stm->bindParam(':idContagem', $this->idContagem, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha['id'];
    }

    public function insere() {
        $stm = DB::prepare("INSERT INTO $this->table ("
                        . "id_contagem, "
                        . "user_email, "
                        . "concedido_em, "
                        . "concedido_por)"
                        . "VALUES ("
                        . ":idContagem,"
                        . ":userEmail,"
                        . ":concedidoEm,"
                        . ":concedidoPor)");
        $stm->bindParam(':idContagem', $this->idContagem, PDO::PARAM_INT);
        $stm->bindParam(':userEmail', $this->userEmail, PDO::PARAM_STR);
        $stm->bindParam(':concedidoEm', $this->concedidoEm, PDO::PARAM_STR);
        $stm->bindParam(':concedidoPor', $this->concedidoPor, PDO::PARAM_STR);
        $stm->execute();
    }

    public function atualiza($id) {
        //
    }

}
