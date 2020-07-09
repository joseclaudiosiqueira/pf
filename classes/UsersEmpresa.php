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

class UsersEmpresa extends CRUD {

    public function __construct() {
        $this->setTable('users_empresa');
        $this->setLog();
    }

    public function insere() {
        ;
    }

    public function getUserId($userEmail, $idEmpresa) {
        $stm = DB::prepare("SELECT DISTINCT id_user FROM $this->table WHERE user_email = :email AND id_empresa = $idEmpresa");
        $stm->bindParam(':email', $userEmail, PDO::PARAM_STR);
        $stm->execute();
        $id_user = $stm->fetch(PDO::FETCH_ASSOC);
        return $id_user['id_user'];
    }

    public function getIdClienteUsuario($idEmpresa, $idFornecedor, $id_user) {
        $stm = DB::prepare("SELECT id_cliente FROM $this->table WHERE id_empresa = $idEmpresa AND id_fornecedor = $idFornecedor AND id_user = $id_user");
        $stm->execute();
        $id_cliente = $stm->fetch(PDO::FETCH_ASSOC);
        return $id_cliente['id_cliente'];
    }

}
