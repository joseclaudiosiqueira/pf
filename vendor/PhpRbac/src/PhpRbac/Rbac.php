<?php

namespace PhpRbac;

use \Jf;

/**
 * @file
 * Provides NIST Level 2 Standard Role Based Access Control functionality
 *
 * @defgroup phprbac Rbac Functionality
 * @{
 * Documentation for all PhpRbac related functionality.
 */
class Rbac {

    public function __construct($unit_test = '') {
        if ((string) $unit_test === 'unit_test') {
            require_once dirname(dirname(__DIR__)) . '/tests/database/database.config';
        } else {
            require_once dirname(dirname(__DIR__)) . '/database/database.config';
        }

        require_once 'core/lib/Jf.php';

        $this->Permissions = Jf::$Rbac->Permissions;
        $this->Roles = Jf::$Rbac->Roles;
        $this->Users = Jf::$Rbac->Users;
    }

    public function assign($role, $permission) {
        return Jf::$Rbac->assign($role, $permission);
    }

    public function check($permission, $user_id) {
        return Jf::$Rbac->check($permission, $user_id);
    }

    /*
     * Dimension
     * implementacao do metodo que retorna todas as permissoes do usuario
     * evita o connection e select no db a cada atualizacao de pagina
     * armazena as informacoes em uma array na sessao
     */
    public function checkAll($user_id, $id_empresa, $id_fornecedor, $role_id) {
        return Jf::$Rbac->checkAll($user_id, $id_empresa, $id_fornecedor, $role_id);
    }

    //Dimension
    //implementado para exibir todas as roles cadastradas no sistema
    public function getAllRoles() {
        return Jf::$Rbac->getAllRoles();
    }
    
    //Dimension
    //implementado para retornar todas as permissoes do usuario para a empresa atual
    public function checkPermissions($UserID, $id_empresa){
        return Jf::$Rbac->checkPermissions($UserID, $id_empresa);
    }

    //Dimension
    //implementado para exibir todas as roles cadastradas no sistema
    public function getAllPermissions($id) {
        return Jf::$Rbac->getAllPermissions($id);
    }

    public function enforce($permission, $user_id) {
        return Jf::$Rbac->enforce($permission, $user_id);
    }

    public function reset($ensure = false) {
        return Jf::$Rbac->reset($ensure);
    }

    public function tablePrefix() {
        return Jf::$Rbac->tablePrefix();
    }

}

/** @} */ // End group phprbac */
