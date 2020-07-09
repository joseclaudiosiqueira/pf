<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}

require_once DIR_CLASS . 'CRUD.php';

class DashboardComplexidadeFuncoes extends CRUD {

    public function insere() {
        
    }

    public function getComplexidade($idEmpresa, $id2 = NULL, $tipo = NULL) {
        $stm = DB::prepare("SELECT complexidade, sum(qtd) AS qtd FROM
                            (SELECT 'ALI', ali.complexidade, count(ali.id) AS qtd FROM ali ali, contagem c WHERE c.id = ali.id_contagem AND c.id_empresa = :idEmpresa " . (NULL !== $id2 ? "AND c.$tipo = $id2 " : " " ) . " GROUP BY ali.complexidade
                            UNION
                            SELECT 'AIE', aie.complexidade, count(aie.id) AS qtd FROM aie aie, contagem c WHERE c.id = aie.id_contagem AND c.id_empresa = :idEmpresa " . (NULL !== $id2 ? "AND c.$tipo = $id2 " : " " ) . " GROUP BY aie.complexidade
                            UNION
                            SELECT 'EE', ee.complexidade, count(ee.id) AS qtd FROM ee ee, contagem c WHERE c.id = ee.id_contagem AND c.id_empresa = :idEmpresa " . (NULL !== $id2 ? "AND c.$tipo = $id2 " : " " ) . " GROUP BY ee.complexidade
                            UNION
                            SELECT 'SE', se.complexidade, count(se.id) AS qtd FROM se se, contagem c WHERE c.id = se.id_contagem AND c.id_empresa = :idEmpresa " . (NULL !== $id2 ? "AND c.$tipo = $id2 " : " " ) . " GROUP BY se.complexidade
                            UNION
                            SELECT 'CE', ce.complexidade, count(ce.id) AS qtd FROM ce ce, contagem c WHERE c.id = ce.id_contagem AND c.id_empresa = :idEmpresa " . (NULL !== $id2 ? "AND c.$tipo = $id2 " : " " ) . " GROUP BY ce.complexidade) AS tbl GROUP BY complexidade");
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getComplexidadeFornecedor($idEmpresa, $idFornecedor, $id2 = NULL, $tipo = NULL) {
        $stm = DB::prepare("SELECT complexidade, sum(qtd) AS qtd FROM
                            (SELECT 'ALI', ali.complexidade, count(ali.id) AS qtd FROM ali ali, contagem c WHERE c.id = ali.id_contagem AND c.id_empresa = :idEmpresa AND c.id_fornecedor = :idFornecedor " . (NULL !== $id2 ? "AND c.$tipo = $id2 " : " " ) . " GROUP BY ali.complexidade
                            UNION
                            SELECT 'AIE', aie.complexidade, count(aie.id) AS qtd FROM aie aie, contagem c WHERE c.id = aie.id_contagem AND c.id_empresa = :idEmpresa AND c.id_fornecedor = :idFornecedor " . (NULL !== $id2 ? "AND c.$tipo = $id2 " : " " ) . " GROUP BY aie.complexidade
                            UNION
                            SELECT 'EE', ee.complexidade, count(ee.id) AS qtd FROM ee ee, contagem c WHERE c.id = ee.id_contagem AND c.id_empresa = :idEmpresa AND c.id_fornecedor = :idFornecedor " . (NULL !== $id2 ? "AND c.$tipo = $id2 " : " " ) . " GROUP BY ee.complexidade
                            UNION
                            SELECT 'SE', se.complexidade, count(se.id) AS qtd FROM se se, contagem c WHERE c.id = se.id_contagem AND c.id_empresa = :idEmpresa AND c.id_fornecedor = :idFornecedor " . (NULL !== $id2 ? "AND c.$tipo = $id2 " : " " ) . " GROUP BY se.complexidade
                            UNION
                            SELECT 'CE', ce.complexidade, count(ce.id) AS qtd FROM ce ce, contagem c WHERE c.id = ce.id_contagem AND c.id_empresa = :idEmpresa AND c.id_fornecedor = :idFornecedor " . (NULL !== $id2 ? "AND c.$tipo = $id2 " : " " ) . " GROUP BY ce.complexidade) AS tbl GROUP BY complexidade");
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $idFornecedor, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }    

}
