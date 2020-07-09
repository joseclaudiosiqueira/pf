<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}

require_once DIR_CLASS . 'CRUD.php';

class DashboardProjeto extends CRUD {

    public function insere() {
        
    }

    public function getFuncionalidades($idProjeto) {
        $stm = DB::prepare("
            SELECT 'ali' AS tipo, ali.id, ali.funcao, ali.descricao_td, ali.descricao_tr, ali.situacao, ali.pfb, ali.complexidade  
            FROM ali ali, contagem c, projeto p 
            WHERE c.id_projeto = p.id AND ali.id_contagem = c.id AND p.id = :idProjeto AND ali.is_ativo = 1
            UNION 
            SELECT 'aie' AS tipo, aie.id, aie.funcao, aie.descricao_td, aie.descricao_tr, aie.situacao, aie.pfb, aie.complexidade  
            FROM aie aie, contagem c, projeto p 
            WHERE c.id_projeto = p.id AND aie.id_contagem = c.id AND p.id = :idProjeto AND aie.is_ativo = 1
            UNION 
            SELECT 'ee' AS tipo, ee.id, ee.funcao, ee.descricao_td, ee.descricao_ar, ee.situacao, ee.pfb, ee.complexidade  
            FROM ee ee, contagem c, projeto p 
            WHERE c.id_projeto = p.id AND ee.id_contagem = c.id AND p.id = :idProjeto AND ee.is_ativo = 1
            UNION 
            SELECT 'se' AS tipo, se.id, se.funcao, se.descricao_td, se.descricao_ar, se.situacao, se.pfb, se.complexidade  
            FROM se se, contagem c, projeto p 
            WHERE c.id_projeto = p.id AND se.id_contagem = c.id AND p.id = :idProjeto AND se.is_ativo = 1  
            UNION 
            SELECT 'ce' AS tipo, ce.id, ce.funcao, ce.descricao_td, ce.descricao_ar, ce.situacao, ce.pfb, ce.complexidade  
            FROM ce ce, contagem c, projeto p 
            WHERE c.id_projeto = p.id AND ce.id_contagem = c.id AND p.id = :idProjeto AND ce.is_ativo = 1");
        $stm->bindParam(':idProjeto', $idProjeto, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getContagens($idProjeto) {
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
                        . "id_abrangencia IN (1, 2, 7, 9, 10) AND "
                        . "c.id_projeto = $idProjeto "
                        . "ORDER BY id DESC");
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

}
