<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}

require_once DIR_CLASS . 'CRUD.php';

class DashboardValorContratoPF extends CRUD {

    public function insere() {
        
    }

    public function getValorContratoPF() {
        $stm = DB::prepare("
            SELECT
                UPPER(uf) 'UF', 
                COUNT(id) 'QTD', 
                MIN(valor_pf) 'MIN', 
                MAX(valor_pf) 'MAX', 
                AVG(valor_pf) 'AVG'
            FROM
                contrato
            GROUP BY
                UF");
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

}
