<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}

require_once DIR_CLASS . 'CRUD.php';

class DashboardContagemMes extends CRUD {

    public function insere() {
        
    }

    public function getContagens($idEmpresa) {
        $stm = DB::prepare("SELECT 
            COUNT(IF(MONTH(data_cadastro)=1,id,NULL)) AS JAN,
            COUNT(IF(MONTH(data_cadastro)=2,id,NULL)) AS FEV,
            COUNT(IF(MONTH(data_cadastro)=3,id,NULL)) AS MAR,
            COUNT(IF(MONTH(data_cadastro)=4,id,NULL)) AS ABR,
            COUNT(IF(MONTH(data_cadastro)=5,id,NULL)) AS MAI,
            COUNT(IF(MONTH(data_cadastro)=6,id,NULL)) AS JUN,
            COUNT(IF(MONTH(data_cadastro)=7,id,NULL)) AS JUL,
            COUNT(IF(MONTH(data_cadastro)=8,id,NULL)) AS AGO,
            COUNT(IF(MONTH(data_cadastro)=9,id,NULL)) AS `SET`,
            COUNT(IF(MONTH(data_cadastro)=10,id,NULL)) AS `OUT`,
            COUNT(IF(MONTH(data_cadastro)=11,id,NULL)) AS NOV,
            COUNT(IF(MONTH(data_cadastro)=12,id,NULL)) AS DEZ
        FROM contagem c 
        WHERE id_empresa = :idEmpresa AND
            YEAR(data_cadastro) = '" . date('Y') . "'");
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function getContagensFornecedor($idEmpresa, $idFornecedor) {
        $stm = DB::prepare("SELECT 
            COUNT(IF(MONTH(data_cadastro)=1,id,NULL)) AS JAN,
            COUNT(IF(MONTH(data_cadastro)=2,id,NULL)) AS FEV,
            COUNT(IF(MONTH(data_cadastro)=3,id,NULL)) AS MAR,
            COUNT(IF(MONTH(data_cadastro)=4,id,NULL)) AS ABR,
            COUNT(IF(MONTH(data_cadastro)=5,id,NULL)) AS MAI,
            COUNT(IF(MONTH(data_cadastro)=6,id,NULL)) AS JUN,
            COUNT(IF(MONTH(data_cadastro)=7,id,NULL)) AS JUL,
            COUNT(IF(MONTH(data_cadastro)=8,id,NULL)) AS AGO,
            COUNT(IF(MONTH(data_cadastro)=9,id,NULL)) AS `SET`,
            COUNT(IF(MONTH(data_cadastro)=10,id,NULL)) AS `OUT`,
            COUNT(IF(MONTH(data_cadastro)=11,id,NULL)) AS NOV,
            COUNT(IF(MONTH(data_cadastro)=12,id,NULL)) AS DEZ
        FROM contagem c 
        WHERE
            id_empresa = :idEmpresa AND
            id_fornecedor = :idFornecedor AND 
            YEAR(data_cadastro) = '" . date('Y') . "'");
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $idFornecedor, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

}
