<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}

require_once DIR_CLASS . 'CRUD.php';

class DashboardBaseline extends CRUD {

    public function insere() {
        
    }

    public function getFuncionalidades($idBaseline, $idEmpresa) {
        $stm = DB::prepare("
            SELECT 'ali' AS tipo, ali.id, ali.funcao, ali.descricao_td, ali.descricao_tr, ali.situacao, ali.pfb, ali.complexidade  
            FROM ali ali, contagem c, baseline b, empresa e
            WHERE ali.id_contagem = c.id AND c.id_baseline = b.id AND b.id_empresa = e.id AND b.id = :idBaseline AND ali.is_ativo = 1 AND e.id = :idEmpresa AND ali.id_baseline = 0  
            UNION 
            SELECT 'aie' AS tipo, aie.id, aie.funcao, aie.descricao_td, aie.descricao_tr, aie.situacao, aie.pfb, aie.complexidade  
            FROM aie aie, contagem c, baseline b, empresa e
            WHERE aie.id_contagem = c.id AND c.id_baseline = b.id AND b.id_empresa = e.id AND b.id = :idBaseline AND aie.is_ativo = 1 AND e.id = :idEmpresa AND aie.id_baseline = 0  
            UNION 
            SELECT 'ee' AS tipo, ee.id, ee.funcao, ee.descricao_td, ee.descricao_ar, ee.situacao, ee.pfb, ee.complexidade  
            FROM ee ee, contagem c, baseline b, empresa e
            WHERE ee.id_contagem = c.id AND c.id_baseline = b.id AND b.id_empresa = e.id AND b.id = :idBaseline AND ee.is_ativo = 1 AND e.id = :idEmpresa AND ee.id_baseline = 0  
            UNION 
            SELECT 'se' AS tipo, se.id, se.funcao, se.descricao_td, se.descricao_ar, se.situacao, se.pfb, se.complexidade  
            FROM se se, contagem c, baseline b, empresa e
            WHERE se.id_contagem = c.id AND c.id_baseline = b.id AND b.id_empresa = e.id AND b.id = :idBaseline AND se.is_ativo = 1 AND e.id = :idEmpresa AND se.id_baseline = 0  
            UNION 
            SELECT 'ce' AS tipo, ce.id, ce.funcao, ce.descricao_td, ce.descricao_ar, ce.situacao, ce.pfb, ce.complexidade  
            FROM ce ce, contagem c, baseline b, empresa e
            WHERE ce.id_contagem = c.id AND c.id_baseline = b.id AND b.id_empresa = e.id AND b.id = :idBaseline AND ce.is_ativo = 1 AND e.id = :idEmpresa AND ce.id_baseline = 0 ");
        $stm->bindParam(':idBaseline', $idBaseline, PDO::PARAM_INT);
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getContagens($idBaseline) {
        $stm = DB::prepare("SELECT "
                        . "c.id, "
                        . "c.user_id, "
                        . "c.responsavel, "
                        . "c.data_cadastro, "
                        . "c.ordem_servico,"
                        . "c.id_abrangencia,"
                        . "c.privacidade,"
                        . "c.id_fornecedor  "
                        . "FROM "
                        . "contagem c "
                        . "WHERE "
                        . "c.id_baseline = $idBaseline "
                        . "ORDER BY id DESC");
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

}
