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

class FuncaoOutros extends CRUD {

    private $id;
    private $idContagem;
    private $idRoteiro;
    private $operacao;
    private $funcao;
    private $qtd;
    private $impacto;
    private $entrega;
    private $pfa;
    private $obsFuncao;
    private $obsValidar;
    private $obsValidadorInterno;
    private $obsValidadorExterno;
    private $obsAuditorInterno;
    private $obsAuditorExterno;
    private $obsRevisor;
    private $fonte;
    private $inseridoPor;
    private $dataCadastro;
    private $dataAuditoriaInterna;
    private $dataAuditoriaExterna;
    private $dataValidacaoInterna;
    private $dataValidacaoExterna;
    private $auditorInterno;
    private $auditorExterno;
    private $validadorInterno;
    private $validadorExterno;
    private $situacao;
    private $idBaseline;

    function setId($id) {
        $this->id = $id;
    }

    function setIdContagem($idContagem) {
        $this->idContagem = $idContagem;
    }

    function setIdRoteiro($idRoteiro) {
        $this->idRoteiro = $idRoteiro;
    }

    function setOperacao($operacao) {
        $this->operacao = $operacao;
    }

    function setFuncao($funcao) {
        $this->funcao = $funcao;
    }

    function setQtd($qtd) {
        $this->qtd = $qtd;
    }

    function setImpacto($impacto) {
        $this->impacto = $impacto;
    }

    function setEntrega($entrega) {
        $this->entrega = $entrega;
    }

    function setPfa($pfa) {
        $this->pfa = $pfa;
    }

    function setObsFuncao($obsFuncao) {
        $this->obsFuncao = $obsFuncao;
    }

    function setObsValidar($obsValidar) {
        $this->obsValidar = $obsValidar;
    }

    function setObsValidadorInterno($obsValidadorInterno) {
        $this->obsValidadorInterno = $obsValidadorInterno;
    }

    function setObsValidadorExterno($obsValidadorExterno) {
        $this->obsValidadorExterno = $obsValidadorExterno;
    }

    function setObsAuditorInterno($obsAuditorInterno) {
        $this->obsAuditorInterno = $obsAuditorInterno;
    }

    function setObsAuditorExterno($obsAuditorExterno) {
        $this->obsAuditorExterno = $obsAuditorExterno;
    }

    function setObsRevisor($obsRevisor) {
        $this->obsRevisor = $obsRevisor;
    }

    function setFonte($fonte) {
        $this->fonte = $fonte;
    }

    function setInseridoPor($inseridoPor) {
        $this->inseridoPor = $inseridoPor;
    }

    function setDataCadastro($dataCadastro) {
        $this->dataCadastro = $dataCadastro;
    }

    function setDataAuditoriaInterna($dataAuditoriaInterna) {
        $this->dataAuditoriaInterna = $dataAuditoriaInterna;
    }

    function setDataAuditoriaExterna($dataAuditoriaExterna) {
        $this->dataAuditoriaExterna = $dataAuditoriaExterna;
    }

    function setDataValidacaoInterna($dataValidacaoInterna) {
        $this->dataValidacaoInterna = $dataValidacaoInterna;
    }

    function setDataValidacaoExterna($dataValidacaoExterna) {
        $this->dataValidacaoExterna = $dataValidacaoExterna;
    }

    function setAuditorInterno($auditorInterno) {
        $this->auditorInterno = $auditorInterno;
    }

    function setAuditorExterno($auditorExterno) {
        $this->auditorExterno = $auditorExterno;
    }

    function setValidadorInterno($validadorInterno) {
        $this->validadorInterno = $validadorInterno;
    }

    function setValidadorExterno($validadorExterno) {
        $this->validadorExterno = $validadorExterno;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setIdBaseline($idBaseline) {
        $this->idBaseline = $idBaseline;
    }

    //funcao que atualiza o id_gerador quando uma contagem inserir uma funcao na baseline
    public function atualizaIdGerador($idGerador, $idBaseline) {
        $stm = DB::prepare("UPDATE $this->table SET id_gerador = :idGerador WHERE id = :idBaseline");
        $stm->bindParam(':idGerador', $idGerador, PDO::PARAM_INT);
        $stm->bindParam(':idBaseline', $idBaseline, PDO::PARAM_INT);
        return $stm->execute();
    }
    public function retornaIdGerador($id) {
        $stm = DB::prepare("SELECT id_gerador, id_contagem FROM $this->table WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }
    public function insere() {
        $sql = "
        INSERT INTO $this->table (
        id_contagem,
        id_roteiro,
        operacao,
        funcao,
        qtd,
        impacto,
        entrega,
        pfa,
        obs_funcao,
        obs_validar,
        fonte,
        inserido_por,
        data_cadastro,
        id_baseline,
        ultima_atualizacao,
        atualizado_por)
        VALUES (
        :idContagem,
        :idRoteiro,
        :operacao,
        :funcao,
        :qtd,
        :impacto,
        :entrega,
        :pfa,
        :obsFuncao,
        :obsValidar,
        :fonte,
        :inseridoPor,
        :dataCadastro,
        :idBaseline,
        :ultimaAtualizacao,
        :atualizadoPor)";

        $stmt = DB::prepare($sql);
        $stmt->bindParam(':idContagem', $this->idContagem, PDO::PARAM_INT);
        $stmt->bindParam(':idRoteiro', $this->idRoteiro, PDO::PARAM_INT);
        $stmt->bindParam(':operacao', $this->operacao, PDO::PARAM_STR);
        $stmt->bindParam(':funcao', $this->funcao, PDO::PARAM_STR);
        $stmt->bindParam(':qtd', $this->qtd, PDO::PARAM_INT);
        $stmt->bindParam(':impacto', $this->impacto, PDO::PARAM_STR);
        $stmt->bindParam(':entrega', $this->entrega, PDO::PARAM_STR);
        $stmt->bindParam(':pfa', $this->pfa, PDO::PARAM_STR);
        $stmt->bindParam(':obsFuncao', $this->obsFuncao, PDO::PARAM_STR);
        $stmt->bindParam(':obsValidar', $this->obsValidar, PDO::PARAM_STR);
        $stmt->bindParam(':fonte', $this->fonte, PDO::PARAM_STR);
        $stmt->bindParam(':inseridoPor', $this->inseridoPor, PDO::PARAM_STR);
        $stmt->bindParam(':dataCadastro', $this->dataCadastro, PDO::PARAM_STR);
        $stmt->bindParam(':idBaseline', $this->idBaseline, PDO::PARAM_INT);
        $stmt->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stmt->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stmt->execute();
        return DB::getInstance()->lastInsertId();
    }

    public function atualiza($id) {
        $sql = "
        UPDATE $this->table SET
        operacao = :operacao,
        funcao = :funcao,
        qtd = :qtd,
        impacto = :impacto,
        entrega = :entrega,
        pfa = :pfa,
        obs_funcao = :obsFuncao,
        obs_validar = :obsValidar,
        fonte = :fonte,
        id_roteiro = :idRoteiro,
        id_baseline = :idBaseline,
        situacao = :situacao,
        ultima_atualizacao = :ultimaAtualizacao,
        atualizado_por = :atualizadoPor
        WHERE
        id = :id";

        $stmt = DB::prepare($sql);
        $stmt->bindParam(':operacao', $this->operacao, PDO::PARAM_STR);
        $stmt->bindParam(':funcao', $this->funcao, PDO::PARAM_STR);
        $stmt->bindParam(':qtd', $this->qtd, PDO::PARAM_INT);
        $stmt->bindParam(':impacto', $this->impacto, PDO::PARAM_STR);
        $stmt->bindParam(':entrega', $this->entrega, PDO::PARAM_STR);
        $stmt->bindParam(':pfa', $this->pfa, PDO::PARAM_STR);
        $stmt->bindParam(':obsFuncao', $this->obsFuncao, PDO::PARAM_STR);
        $stmt->bindParam(':obsValidar', $this->obsValidar, PDO::PARAM_STR);
        $stmt->bindParam(':fonte', $this->fonte, PDO::PARAM_STR);
        $stmt->bindParam(':idRoteiro', $this->idRoteiro, PDO::PARAM_INT);
        $stmt->bindParam(':idBaseline', $this->idBaseline, PDO::PARAM_INT);
        $stmt->bindParam(':situacao', $this->situacao, PDO::PARAM_INT);
        $stmt->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stmt->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

}
