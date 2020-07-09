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

class FornecedorConfig extends CRUD {

    private $emailAdministrador1;
    private $emailAdministrador2;
    private $telefoneAdministrador1;
    private $telefoneAdministrador2;
    
    public function __construct() {
        $this->setTable('fornecedor_config');
        $this->setLog();
    }

    function setEmailAdministrador1($emailAdministrador1) {
        $this->emailAdministrador1 = $emailAdministrador1;
    }

    function setEmailAdministrador2($emailAdministrador2) {
        $this->emailAdministrador2 = $emailAdministrador2;
    }

    function setTelefoneAdministrador1($telefoneAdministrador1) {
        $this->telefoneAdministrador1 = $telefoneAdministrador1;
    }

    function setTelefoneAdministrador2($telefoneAdministrador2) {
        $this->telefoneAdministrador2 = $telefoneAdministrador2;
    }

    public function insere() {
        //
    }

    public function atualiza($idEmpresa ,$idFornecedor) {
        $data = date('Y-m-d H:i:s');
        $sql = "UPDATE fornecedor_config SET "
                . "email_administrador_1 = :emailAdministrador1, "
                . "email_administrador_2 = :emailAdministrador2, "
                . "telefone_administrador_1 = :telefoneAdministrador1, "
                . "telefone_administrador_2 = :telefoneAdministrador2, "
                . "ultima_atualizacao = :ultimaAtualizacao, "
                . "atualizado_por = :atualizadoPor "
                . "WHERE id_empresa = :idEmpresa AND "
                . "id_fornecedor = :idFornecedor";
        $stm = DB::prepare($sql);
        $stm->bindParam(':emailAdministrador1', $this->emailAdministrador1, PDO::PARAM_STR);
        $stm->bindParam(':emailAdministrador2', $this->emailAdministrador2, PDO::PARAM_STR);
        $stm->bindParam(':telefoneAdministrador1', $this->telefoneAdministrador1, PDO::PARAM_STR);
        $stm->bindParam(':telefoneAdministrador2', $this->telefoneAdministrador2, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $data, PDO::PARAM_STR);
        $stm->bindParam(':atualizadoPor', $_SESSION['user_email'], PDO::PARAM_STR);
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $idFornecedor, PDO::PARAM_INT);
        return $stm->execute();
    }

}
