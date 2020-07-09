<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}

require_once DIR_CLASS . 'CRUD.php';

class DashboardContagemSituacao extends CRUD {

    public function insere() {
        
    }

    public function getProcesso($idEmpresa) {
        $sql = "SELECT cp.id AS id, count(ch.id) AS qtd "
                . "FROM contagem c, contagem_processo cp, contagem_historico ch "
                . "WHERE "
                . "ch.id_contagem = c.id AND "
                . "ch.id_processo = cp.id AND "
                . "c.id_empresa = :idEmpresa AND "
                . "ch.id_processo in (1, 2, 3, 4, 5, 7, 8, 9) AND "
                . "ch.data_fim IS NULL "
                . "GROUP BY id";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getProcessoFornecedor($idEmpresa, $idFornecedor) {
        $sql = "SELECT cp.id AS id, count(ch.id) AS qtd "
                . "FROM contagem c, contagem_processo cp, contagem_historico ch "
                . "WHERE "
                . "ch.id_contagem = c.id AND "
                . "ch.id_processo = cp.id AND "
                . "c.id_empresa = :idEmpresa AND "
                . "c.id_fornecedor = :idFornecedor AND "
                . "ch.id_processo in (1, 2, 3, 4, 5, 7, 8, 9) AND "
                . "ch.data_fim IS NULL "
                . "GROUP BY id";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $idFornecedor, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
