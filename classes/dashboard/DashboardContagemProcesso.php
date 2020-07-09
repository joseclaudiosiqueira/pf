<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}

require_once DIR_CLASS . 'CRUD.php';

class DashboardContagemProcesso extends CRUD {

    public function insere() {
        
    }

    public function getSituacao($idEmpresa) {
        $stm = DB::prepare("SELECT p.descricao AS descricao, COUNT(c.id) AS qtd FROM contagem c, processo p "
                . "WHERE c.id_processo = p.id AND c.id_empresa = :idEmpresa GROUP BY descricao");
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

}
