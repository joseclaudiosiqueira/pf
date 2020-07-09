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

class EmpresaConfig extends CRUD {

    private $idEmpresa;
    private $emailAdministrador1;
    private $emailAdministrador2;
    private $telefoneAdministrador1;
    private $telefoneAdministrador2;
    private $tipoAutenticacao;
    private $ldapServer;
    private $ldapPort;
    private $ldapDomain;

    public function __construct() {
        $this->setTable('empresa_config');
        $this->setLog();
    }

    function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
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

    function setTipoAutenticacao($tipoAutenticacao) {
        $this->tipoAutenticacao = $tipoAutenticacao;
    }

    function setLdapServer($ldapServer) {
        $this->ldapServer = $ldapServer;
    }

    function setLdapPort($ldapPort) {
        $this->ldapPort = $ldapPort;
    }

    function setLdapDomain($ldapDomain) {
        $this->ldapDomain = $ldapDomain;
    }

    public function insere() {
        $sql = "INSERT INTO $this->table ("
                . "id_empresa,"
                . "email_administrador_1,"
                . "email_administrador_2,"
                . "telefone_administrador_1,"
                . "telefone_administrador_2,"
                . "ultima_atualizacao,"
                . "atualizado_por) values ("
                . ":idEmpresa,"
                . ":emailAdministrador1,"
                . ":emailAdministrador2,"
                . ":telefoneAdministrador1,"
                . ":telefoneAdministrador2,"
                . ":ultimaAtualizacao,"
                . ":atualizadoPor)";
        $stm = DB::prepare($sql);
        $stm->bindParam(':emailAdministrador1', $this->emailAdministrador1, PDO::PARAM_STR);
        $stm->bindParam(':emailAdministrador2', $this->emailAdministrador2, PDO::PARAM_STR);
        $stm->bindParam(':telefoneAdministrador1', $this->telefoneAdministrador1, PDO::PARAM_STR);
        $stm->bindParam(':telefoneAdministrador2', $this->telefoneAdministrador2, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        return $stm->execute();
    }

    public function atualiza() {
        $sql = "UPDATE $this->table SET "
                . "email_administrador_1 = :emailAdministrador1, "
                . "email_administrador_2 = :emailAdministrador2, "
                . "telefone_administrador_1 = :telefoneAdministrador1, "
                . "telefone_administrador_2 = :telefoneAdministrador2, "
                . "ultima_atualizacao = :ultimaAtualizacao, "
                . "atualizado_por = :atualizadoPor "
                . "WHERE id_empresa = :idEmpresa";
        $stm = DB::prepare($sql);
        $stm->bindParam(':emailAdministrador1', $this->emailAdministrador1, PDO::PARAM_STR);
        $stm->bindParam(':emailAdministrador2', $this->emailAdministrador2, PDO::PARAM_STR);
        $stm->bindParam(':telefoneAdministrador1', $this->telefoneAdministrador1, PDO::PARAM_STR);
        $stm->bindParam(':telefoneAdministrador2', $this->telefoneAdministrador2, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        return $stm->execute();
    }

    public function atualizaLDAP($idEmpresa) {
        $sql = "UPDATE $this->table SET "
                . "tipo_autenticacao = :tipoAutenticacao, "
                . "ldapserver = :ldapServer, "
                . "ldapport = :ldapPort, "
                . "ldapdomain = :ldapDomain, "
                . "ultima_atualizacao = :ultimaAtualizacao, "
                . "atualizado_por = :atualizadoPor "
                . "WHERE id_empresa = :idEmpresa";
        $stm = DB::prepare($sql);
        $stm->bindParam(':tipoAutenticacao', $this->tipoAutenticacao, PDO::PARAM_INT);
        $stm->bindParam(':ldapServer', $this->ldapServer, PDO::PARAM_STR);
        $stm->bindParam(':ldapPort', $this->ldapPort, PDO::PARAM_INT);
        $stm->bindParam(':ldapDomain', $this->ldapDomain, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        return $stm->execute();
    }

    public function retornaLDAP($idEmpresa) {
        $stm = DB::prepare("SELECT tipo_instalacao, tipo_autenticacao, ldapserver, ldapport, ldapdomain FROM $this->table WHERE id_empresa = :idEmpresa");
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

}
