<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verificacao do status do login
 */
require_once 'CRUD.php';

class UsuarioHistorico extends CRUD {
    
    private $userId;
    private $idEmpresa;
    private $idFornecedor;
    private $operacao;
    
    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    function setIdFornecedor($idFornecedor) {
        $this->idFornecedor = $idFornecedor;
    }

    function setOperacao($operacao) {
        $this->operacao = $operacao;
    }

    function setAtualizadoPor($atualizadoPor) {
        $this->atualizadoPor = $atualizadoPor;
    }

    function setUltimaAtualizacao($ultimaAtualizacao) {
        $this->ultimaAtualizacao = $ultimaAtualizacao;
    }

    public function atualiza($id){
        //
    }
    public function insere(){
        $stm = DB::prepare("INSERT INTO $this->table ("
                . "user_id, "
                . "id_empresa, "
                . "id_fornecedor, "
                . "operacao, "
                . "atualizado_por, "
                . "ultima_atualizacao) VALUES ("
                . ":userId, "
                . ":idEmpresa, "
                . ":idFornecedor, "
                . ":operacao, "
                . ":atualizadoPor, "
                . ":ultimaAtualizacao)");
        $stm->bindParam(':userId', $this->userId, PDO::PARAM_INT);
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $this->idFornecedor, PDO::PARAM_INT);
        $stm->bindParam(':operacao', $this->operacao, PDO::PARAM_STR);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, pdo::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stm->execute();
    }
}

