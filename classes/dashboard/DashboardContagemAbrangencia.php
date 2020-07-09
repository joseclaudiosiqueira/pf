<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}

require_once DIR_CLASS . 'CRUD.php';

class DashboardContagemAbrangencia extends CRUD {

    public function insere() {
        
    }

    public function getSituacao($idEmpresa) {
        $stm = DB::prepare("SELECT ab.descricao AS descricao, COUNT(c.id) AS qtd FROM contagem c, contagem_abrangencia ab "
                        . "WHERE c.id_abrangencia = ab.id AND c.id_empresa = :idEmpresa GROUP BY descricao");
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSituacaoFornecedor($idEmpresa, $idFornecedor) {
        $stm = DB::prepare("SELECT ab.descricao AS descricao, COUNT(c.id) AS qtd FROM contagem c, contagem_abrangencia ab "
                        . "WHERE c.id_abrangencia = ab.id AND c.id_empresa = :idEmpresa AND c.id_fornecedor = :idFornecedor GROUP BY descricao");
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $idFornecedor, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

}
