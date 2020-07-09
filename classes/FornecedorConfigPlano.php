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

class FornecedorConfigPlano extends CRUD {
    
    private $idFornecedor;
    
    function setIdFornecedor($idFornecedor) {
        $this->idFornecedor = $idFornecedor;
    }

    public function insere(){
        //
    }

    public function atualiza($id){
        //
    }
    
    public function getConfig(){
        $sql  = "SELECT pl.* FROM plano pl, fornecedor_config_plano em WHERE pl.id = em.id_plano AND em.id_fornecedor = :idFornecedor";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idFornecedor', $this->idFornecedor, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }
}
