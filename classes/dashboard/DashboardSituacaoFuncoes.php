<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}

require_once DIR_CLASS . 'CRUD.php';

class DashboardSituacaoFuncoes extends CRUD {

    public function insere() {
        
    }

    /**
     * 
     * @param int $idEmpresa
     * @param int $id2 - id de baseline ou de projeto
     * @param int $tipo - id_baseline ou id_projeto
     * @return array
     */
    public function getSituacao($idEmpresa, $id2 = NULL, $tipo = NULL) {
        $stm = DB::prepare("SELECT 'ALI',
                COUNT(IF(ali.situacao=1,ali.id,NULL)) AS 'naovalidado',
                COUNT(IF(ali.situacao=2,ali.id,NULL)) AS 'validado',
                COUNT(IF(ali.situacao=3,ali.id,NULL)) AS 'emrevisao',
                COUNT(IF(ali.situacao=4,ali.id,NULL)) AS 'revisado'
                FROM ali ali, contagem c WHERE ali.id_contagem = c.id AND c.id_empresa = :idEmpresa 
                " . (NULL !== $id2 ? "AND c.$tipo = $id2 " : " " ) . "
            UNION
            SELECT 'AIE',
                COUNT(IF(aie.situacao=1,aie.id,NULL)) AS 'naovalidado',
                COUNT(IF(aie.situacao=2,aie.id,NULL)) AS 'validado',
                COUNT(IF(aie.situacao=3,aie.id,NULL)) AS 'emrevisao',
                COUNT(IF(aie.situacao=4,aie.id,NULL)) AS 'revisado'
                FROM aie aie, contagem c WHERE aie.id_contagem = c.id AND c.id_empresa = :idEmpresa 
                " . (NULL !== $id2 ? "AND c.$tipo = $id2 " : " " ) . "
            UNION
            SELECT 'EE',
                COUNT(IF(ee.situacao=1,ee.id,NULL)) AS 'naovalidado',
                COUNT(IF(ee.situacao=2,ee.id,NULL)) AS 'validado',
                COUNT(IF(ee.situacao=3,ee.id,NULL)) AS 'emrevisao',
                COUNT(IF(ee.situacao=4,ee.id,NULL)) AS 'revisado'
                FROM ee ee, contagem c WHERE ee.id_contagem = c.id AND c.id_empresa = :idEmpresa 
                " . (NULL !== $id2 ? "AND c.$tipo = $id2 " : " " ) . "
            UNION
            SELECT 'SE',
                COUNT(IF(se.situacao=1,se.id,NULL)) AS 'naovalidado',
                COUNT(IF(se.situacao=2,se.id,NULL)) AS 'validado',
                COUNT(IF(se.situacao=3,se.id,NULL)) AS 'emrevisao',
                COUNT(IF(se.situacao=4,se.id,NULL)) AS 'revisado'
                FROM se se, contagem c WHERE se.id_contagem = c.id AND c.id_empresa = :idEmpresa 
                " . (NULL !== $id2 ? "AND c.$tipo = $id2 " : " " ) . "
            UNION
            SELECT 'CE',
                COUNT(IF(ce.situacao=1,ce.id,NULL)) AS 'naovalidado',
                COUNT(IF(ce.situacao=2,ce.id,NULL)) AS 'validado',
                COUNT(IF(ce.situacao=3,ce.id,NULL)) AS 'emrevisao',
                COUNT(IF(ce.situacao=4,ce.id,NULL)) AS 'revisado'
                FROM ce ce, contagem c WHERE ce.id_contagem = c.id AND c.id_empresa = :idEmpresa 
                " . (NULL !== $id2 ? "AND c.$tipo = $id2 " : " " ) . "
            UNION
            SELECT 'OU',
                COUNT(IF(ou.situacao=1,ou.id,NULL)) AS 'naovalidado',
                COUNT(IF(ou.situacao=2,ou.id,NULL)) AS 'validado',
                COUNT(IF(ou.situacao=3,ou.id,NULL)) AS 'emrevisao',
                COUNT(IF(ou.situacao=4,ou.id,NULL)) AS 'revisado'
                FROM ou ou, contagem c WHERE ou.id_contagem = c.id AND c.id_empresa = :idEmpresa 
                " . (NULL !== $id2 ? "AND c.$tipo = $id2 " : " "));
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSituacaoFornecedor($idEmpresa, $idFornecedor, $id2 = NULL, $tipo = NULL) {
        $stm = DB::prepare("SELECT 'ALI',
                COUNT(IF(ali.situacao=1,ali.id,NULL)) AS 'naovalidado',
                COUNT(IF(ali.situacao=2,ali.id,NULL)) AS 'validado',
                COUNT(IF(ali.situacao=3,ali.id,NULL)) AS 'emrevisao',
                COUNT(IF(ali.situacao=4,ali.id,NULL)) AS 'revisado'
                FROM ali ali, contagem c WHERE ali.id_contagem = c.id AND c.id_empresa = :idEmpresa AND c.id_fornecedor = :idFornecedor  
                " . (NULL !== $id2 ? "AND c.$tipo = $id2 " : " " ) . "
            UNION
            SELECT 'AIE',
                COUNT(IF(aie.situacao=1,aie.id,NULL)) AS 'naovalidado',
                COUNT(IF(aie.situacao=2,aie.id,NULL)) AS 'validado',
                COUNT(IF(aie.situacao=3,aie.id,NULL)) AS 'emrevisao',
                COUNT(IF(aie.situacao=4,aie.id,NULL)) AS 'revisado'
                FROM aie aie, contagem c WHERE aie.id_contagem = c.id AND c.id_empresa = :idEmpresa AND c.id_fornecedor = :idFornecedor  
                " . (NULL !== $id2 ? "AND c.$tipo = $id2 " : " " ) . "
            UNION
            SELECT 'EE',
                COUNT(IF(ee.situacao=1,ee.id,NULL)) AS 'naovalidado',
                COUNT(IF(ee.situacao=2,ee.id,NULL)) AS 'validado',
                COUNT(IF(ee.situacao=3,ee.id,NULL)) AS 'emrevisao',
                COUNT(IF(ee.situacao=4,ee.id,NULL)) AS 'revisado'
                FROM ee ee, contagem c WHERE ee.id_contagem = c.id AND c.id_empresa = :idEmpresa AND c.id_fornecedor = :idFornecedor  
                " . (NULL !== $id2 ? "AND c.$tipo = $id2 " : " " ) . "
            UNION
            SELECT 'SE',
                COUNT(IF(se.situacao=1,se.id,NULL)) AS 'naovalidado',
                COUNT(IF(se.situacao=2,se.id,NULL)) AS 'validado',
                COUNT(IF(se.situacao=3,se.id,NULL)) AS 'emrevisao',
                COUNT(IF(se.situacao=4,se.id,NULL)) AS 'revisado'
                FROM se se, contagem c WHERE se.id_contagem = c.id AND c.id_empresa = :idEmpresa AND c.id_fornecedor = :idFornecedor  
                " . (NULL !== $id2 ? "AND c.$tipo = $id2 " : " " ) . "
            UNION
            SELECT 'CE',
                COUNT(IF(ce.situacao=1,ce.id,NULL)) AS 'naovalidado',
                COUNT(IF(ce.situacao=2,ce.id,NULL)) AS 'validado',
                COUNT(IF(ce.situacao=3,ce.id,NULL)) AS 'emrevisao',
                COUNT(IF(ce.situacao=4,ce.id,NULL)) AS 'revisado'
                FROM ce ce, contagem c WHERE ce.id_contagem = c.id AND c.id_empresa = :idEmpresa AND c.id_fornecedor = :idFornecedor 
                " . (NULL !== $id2 ? "AND c.$tipo = $id2 " : " " ) . "
            UNION
            SELECT 'OU',
                COUNT(IF(ou.situacao=1,ou.id,NULL)) AS 'naovalidado',
                COUNT(IF(ou.situacao=2,ou.id,NULL)) AS 'validado',
                COUNT(IF(ou.situacao=3,ou.id,NULL)) AS 'emrevisao',
                COUNT(IF(ou.situacao=4,ou.id,NULL)) AS 'revisado'
                FROM ou ou, contagem c WHERE ou.id_contagem = c.id AND c.id_empresa = :idEmpresa AND c.id_fornecedor = :idFornecedor 
                " . (NULL !== $id2 ? "AND c.$tipo = $id2 " : " "));
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $idFornecedor, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

}
