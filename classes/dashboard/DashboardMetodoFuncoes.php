<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}

require_once DIR_CLASS . 'CRUD.php';

class DashboardMetodoFuncoes extends CRUD {

    public function insere() {
        
    }

    public function getMetodo($idEmpresa) {
        $stm = DB::prepare("
            SELECT COUNT(ali.id) AS qtd, id_metodo FROM ali ali, contagem c WHERE ali.id_contagem = c.id AND c.id_empresa = :idEmpresa GROUP BY id_metodo UNION 
            SELECT COUNT(aie.id) AS qtd, id_metodo FROM aie aie, contagem c WHERE aie.id_contagem = c.id AND c.id_empresa = :idEmpresa GROUP BY id_metodo UNION 
            SELECT COUNT(ee.id) AS qtd, id_metodo FROM ee ee, contagem c WHERE ee.id_contagem = c.id AND c.id_empresa = :idEmpresa GROUP BY id_metodo UNION 
            SELECT COUNT(se.id) AS qtd, id_metodo FROM se se, contagem c WHERE se.id_contagem = c.id AND c.id_empresa = :idEmpresa GROUP BY id_metodo UNION 
            SELECT COUNT(ce.id) AS qtd, id_metodo FROM ce ce, contagem c WHERE ce.id_contagem = c.id AND c.id_empresa = :idEmpresa GROUP BY id_metodo");
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMetodoFornecedor($idEmpresa, $idFornecedor) {
        $stm = DB::prepare("
            SELECT COUNT(ali.id) AS qtd, id_metodo FROM ali ali, contagem c WHERE ali.id_contagem = c.id AND c.id_empresa = :idEmpresa AND c.id_fornecedor = :idFornecedor GROUP BY id_metodo UNION 
            SELECT COUNT(aie.id) AS qtd, id_metodo FROM aie aie, contagem c WHERE aie.id_contagem = c.id AND c.id_empresa = :idEmpresa AND c.id_fornecedor = :idFornecedor GROUP BY id_metodo UNION 
            SELECT COUNT(ee.id) AS qtd, id_metodo FROM ee ee, contagem c WHERE ee.id_contagem = c.id AND c.id_empresa = :idEmpresa AND c.id_fornecedor = :idFornecedor GROUP BY id_metodo UNION 
            SELECT COUNT(se.id) AS qtd, id_metodo FROM se se, contagem c WHERE se.id_contagem = c.id AND c.id_empresa = :idEmpresa AND c.id_fornecedor = :idFornecedor GROUP BY id_metodo UNION 
            SELECT COUNT(ce.id) AS qtd, id_metodo FROM ce ce, contagem c WHERE ce.id_contagem = c.id AND c.id_empresa = :idEmpresa AND c.id_fornecedor = :idFornecedor GROUP BY id_metodo");
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $idFornecedor, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

}
