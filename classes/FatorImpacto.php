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

class FatorImpacto extends CRUD {

    private $isAtivo;
    private $descricao;
    private $fator;
    private $fonte;
    private $idRoteiro;
    private $operacao;
    private $operador;
    private $sigla;
    private $tipo;
    private $aplica;

    public function __construct() {
        $this->setTable('fator_impacto');
        $this->setLog();
    }

    function setIsAtivo($isAtivo) {
        $this->isAtivo = $isAtivo;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setFator($fator) {
        $this->fator = $fator;
    }

    function setFonte($fonte) {
        $this->fonte = $fonte;
    }

    function setIdRoteiro($idRoteiro) {
        $this->idRoteiro = $idRoteiro;
    }

    function setOperacao($operacao) {
        $this->operacao = $operacao;
    }

    function setOperador($operador) {
        $this->operador = $operador;
    }

    function setSigla($sigla) {
        $this->sigla = $sigla;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setAplica($aplica) {
        $this->aplica = $aplica;
    }

    public function comboFatorImpacto($idRoteiro, $aplica, $operacao, $tipo) {
        /*
         * monta o sql para 0,1 (ativos e inativos) ou 1 (ativos)
         */
        $isAtivo = '';
        if ($tipo === '01') {
            $isAtivo = 'is_ativo IN (0, 1) AND';
        } else {
            $isAtivo = 'is_ativo = 1 AND';
        }
        if ($aplica && $operacao) {
            $sql = "SELECT id, sigla, descricao, fator, aplica, tipo, fonte, operacao, operador, is_ativo, id_roteiro FROM $this->table WHERE $isAtivo id_roteiro = :idRoteiro AND aplica LIKE '%$aplica;%' AND operacao LIKE '%$operacao;%'";
        } else {
            $sql = "SELECT id, sigla, descricao, fator, aplica, tipo, fonte, operacao, operador, is_ativo, id_roteiro FROM $this->table WHERE $isAtivo id_roteiro = :idRoteiro";
        }
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':idRoteiro', $idRoteiro, PDO::PARAM_INT);
        $stmt->execute();
        $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $ret;
    }

    function consultaFatorImpacto($id) {
        $sql = "SELECT id, sigla, descricao, fator, aplica, tipo, fonte, operacao, operador, is_ativo, id_roteiro FROM $this->table WHERE id = :id";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $ret = $stmt->fetch(PDO::FETCH_ASSOC);
        return $ret;
    }

    function getListaINM($tabela, $id_roteiro) {
        $sql = "SELECT id, descricao, fator FROM $this->table WHERE id_roteiro = $id_roteiro AND aplica LIKE '%$tabela%'";
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    function getLista($tabela, $id_roteiro) {
        $sql = "SELECT id, descricao, fator, sigla FROM $this->table WHERE id_roteiro = $id_roteiro AND aplica NOT LIKE '%$tabela%'";
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function alterarSatusFatorImpacto($id, $isAtivo) {
        $stm = DB::prepare("UPDATE $this->table SET "
                        . "is_ativo = :isAtivo, "
                        . "atualizado_por = :atualizadoPor, "
                        . "ultima_atualizacao = :ultimaAtualizacao "
                        . "WHERE id = :id");
        $stm->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stm->bindPAram(':id', $id, PDO::PARAM_INT);
        return($stm->execute());
    }

    public function insere() {
        $sql = "INSERT INTO $this->table (
			is_ativo,
                        descricao,
                        fator,
                        fonte,
                        id_roteiro,
                        operacao,
                        operador,
                        sigla,
                        tipo,
                        aplica,
                        ultima_atualizacao,
                        atualizado_por) 
		VALUES (
                        :isAtivo,
                        :descricao,
                        :fator,
                        :fonte,
                        :idRoteiro,
                        :operacao,
                        :operador,
                        :sigla,
                        :tipo,
                        :aplica,
                        :ultimaAtualizacao,
                        :atualizadoPor
		)";
        $stm = DB::prepare($sql);
        $stm->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
        $stm->bindParam(':descricao', $this->descricao, PDO::PARAM_STR);
        $stm->bindParam(':fator', $this->fator, PDO::PARAM_STR);
        $stm->bindParam(':fonte', $this->fonte, PDO::PARAM_STR);
        $stm->bindParam(':idRoteiro', $this->idRoteiro, PDO::PARAM_INT);
        $stm->bindParam(':operacao', $this->operacao, PDO::PARAM_STR);
        $stm->bindParam(':operador', $this->operador, PDO::PARAM_STR);
        $stm->bindParam(':sigla', $this->sigla, PDO::PARAM_STR);
        $stm->bindParam(':tipo', $this->tipo, PDO::PARAM_STR);
        $stm->bindParam(':aplica', $this->aplica, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor);
        $stm->execute();

        return array('id' => DB::getInstance()->lastInsertId(), 'msg' => 'O item (Fator de Impacto - FI) foi inserido com sucesso.');
    }

    public function atualiza($id) {
        $stm = DB::prepare(""
                        . "UPDATE $this->table SET "
                        . "is_ativo = :isAtivo, "
                        . "descricao = :descricao, "
                        . "fator = :fator, "
                        . "fonte = :fonte, "
                        . "operacao = :operacao, "
                        . "operador = :operador, "
                        . "sigla = :sigla, "
                        . "tipo = :tipo, "
                        . "aplica = :aplica, "
                        . "ultima_atualizacao = :ultimaAtualizacao, "
                        . "atualizado_por = :atualizadoPor "
                        . "WHERE id = :id");
        $stm->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
        $stm->bindParam(':descricao', $this->descricao, PDO::PARAM_STR);
        $stm->bindParam(':fator', $this->fator, PDO::PARAM_STR);
        $stm->bindParam(':fonte', $this->fonte, PDO::PARAM_STR);
        $stm->bindParam(':operacao', $this->operacao, PDO::PARAM_STR);
        $stm->bindParam(':operador', $this->operador, PDO::PARAM_STR);
        $stm->bindParam(':sigla', $this->sigla, PDO::PARAM_STR);
        $stm->bindParam(':tipo', $this->tipo, PDO::PARAM_STR);
        $stm->bindParam(':aplica', $this->aplica, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();

        return array('id' => $id, 'msg' => 'O item (Fator de Impacto - FI) foi alterado com sucesso.');
    }

    public function listaFatorImpacto($idRoteiro, $like) {
        $stm = DB::prepare("SELECT * FROM $this->table WHERE id_roteiro = :idRoteiro AND is_ativo = 1 AND aplica LIKE '%$like%' ORDER BY id");
        $stm->bindValue(':idRoteiro', $idRoteiro, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /*
     * lista todos os itens, exceto os OU - INM
     */
    public function listaFatorImpactoTodosFATTO($idRoteiro){
        $stm = DB::prepare("SELECT * FROM $this->table WHERE id_roteiro = :idRoteiro AND is_ativo = 1 AND aplica <> 'OU;' ORDER BY id");
        $stm->bindValue(':idRoteiro', $idRoteiro, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);        
    }
    
    /*
     * lista todos os OU - INM (apenas)
     */
    public function listaFatorImpactoINMFATTO($idRoteiro){
        $stm = DB::prepare("SELECT * FROM $this->table WHERE id_roteiro = :idRoteiro AND is_ativo = 1 AND aplica = 'OU;' ORDER BY id");
        $stm->bindValue(':idRoteiro', $idRoteiro, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);        
    }

}
