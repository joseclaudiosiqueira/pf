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

class ContagemProcesso extends CRUD {

    public function __construct() {
        $this->setTable('contagem_processo');
    }

    public function insere() {
        //;
    }

    public function atualiza($id) {
        //;
    }

}
