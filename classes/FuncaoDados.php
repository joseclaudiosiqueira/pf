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

class FuncaoDados extends CRUD {

    private $id;
    private $idContagem;
    private $idRoteiro;
    private $operacao;
    private $funcao;
    private $td;
    private $tr;
    private $pfb;
    private $complexidade;
    private $impacto;
    private $pfa;
    private $obsFuncao;
    private $obsValidar;
    private $idMetodo;
    private $entrega;
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
    private $descricaoTR;
    private $descricaoTD;
    private $situacao;
    private $isMudanca;
    private $faseMudanca;
    private $percentualFase;
    private $idBaseline;
    private $fd;
    private $fe;
    private $idGerador;
    private $idRelacionamento;
    private $isCrud;
    private $idCrud; //armazena os ids das funcoes criadas pelo crud no padrao ex.: EE-90,EE-92,...,CE-94

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

    function setTd($td) {
        $this->td = $td;
    }

    function setTr($tr) {
        $this->tr = $tr;
    }

    function setPfb($pfb) {
        $this->pfb = $pfb;
    }

    function setComplexidade($complexidade) {
        $this->complexidade = $complexidade;
    }

    function setImpacto($impacto) {
        $this->impacto = $impacto;
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

    function setIdMetodo($idMetodo) {
        $this->idMetodo = $idMetodo;
    }

    function setEntrega($entrega) {
        $this->entrega = $entrega;
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

    function setDescricaoTR($descricaoTR) {
        $this->descricaoTR = $descricaoTR;
    }

    function setDescricaoTD($descricaoTD) {
        $this->descricaoTD = $descricaoTD;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setIsMudanca($isMudanca) {
        $this->isMudanca = $isMudanca;
    }

    function setFaseMudanca($faseMudanca) {
        $this->faseMudanca = $faseMudanca;
    }

    function setPercentualFase($percentualFase) {
        $this->percentualFase = $percentualFase;
    }

    function setIdBaseline($idBaseline) {
        $this->idBaseline = $idBaseline;
    }

    function setFd($fd) {
        $this->fd = $fd;
    }
    function setFe($fe) {
        $this->fe = $fe;
    }

        function setIdGerador($idGerador) {
        $this->idGerador = $idGerador;
    }

    function setIdRelacionamento($idRelacionamento) {
        $this->idRelacionamento = $idRelacionamento;
    }

    function setIsCrud($isCrud) {
        $this->isCrud = $isCrud;
    }

    function setIdCrud($idCrud) {
        $this->idCrud = $idCrud;
    }

    function getIdCrud($id) {
        $stm = DB::prepare("SELECT id_crud FROM $this->table WHERE id = $id");
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    //essencialmente pega um id e verifica qual eh o id_baseline associado
    //usada muito quanto estao inserindo uma funcao na baseline e ao mesmo tempo em alteracao
    //ou seja, o usuario acabou de inserir uma funcao e na lista clicou em alterar, o sistema tem que alterar as duas
    //funcoes, a do projeto e a da baseline
    function getIdBaseline($idFuncao) {
        $stm = DB::prepare("SELECT id_baseline FROM $this->table WHERE id = :idFuncao");
        $stm->bindParam(':idFuncao', $idFuncao, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
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
        td,
        tr,
        pfb,
        complexidade,
        impacto,
        pfa,
        obs_funcao,
        obs_validar,
        id_metodo,
        entrega,
        fonte,
        inserido_por,
        data_cadastro,
        descricao_tr,
        descricao_td,
        is_mudanca,
        fase_mudanca,
        percentual_fase,
        id_baseline,
        fd,
        fe,
        id_relacionamento,
        ultima_atualizacao,
        atualizado_por
        )
        VALUES (
        :idContagem,
        :idRoteiro,
        :operacao,
        :funcao,
        :td,
        :tr,
        :pfb,
        :complexidade,
        :impacto,
        :pfa,
        :obsFuncao,
        :obsValidar,
        :idMetodo,
        :entrega,
        :fonte,
        :inseridoPor,
        :dataCadastro,
        :descricaoTR,
        :descricaoTD,
        :isMudanca,
        :faseMudanca,
        :percentualFase,
        :idBaseline,
        :fd,
        :fe,
        :idRelacionamento,
        :ultimaAtualizacao,
        :atualizadoPor)";

        $stmt = DB::prepare($sql);
        $stmt->bindParam(':idContagem', $this->idContagem, PDO::PARAM_INT);
        $stmt->bindParam(':idRoteiro', $this->idRoteiro, PDO::PARAM_INT);
        $stmt->bindParam(':operacao', $this->operacao, PDO::PARAM_STR);
        $stmt->bindParam(':funcao', $this->funcao, PDO::PARAM_STR);
        $stmt->bindParam(':td', $this->td, PDO::PARAM_INT);
        $stmt->bindParam(':tr', $this->tr, PDO::PARAM_STR);
        $stmt->bindParam(':pfb', $this->pfb, PDO::PARAM_STR);
        $stmt->bindParam(':complexidade', $this->complexidade, PDO::PARAM_STR);
        $stmt->bindParam(':impacto', $this->impacto, PDO::PARAM_STR);
        $stmt->bindParam(':pfa', $this->pfa, PDO::PARAM_STR);
        $stmt->bindParam(':obsFuncao', $this->obsFuncao, PDO::PARAM_STR);
        $stmt->bindParam(':obsValidar', $this->obsValidar, PDO::PARAM_STR);
        $stmt->bindParam(':idMetodo', $this->idMetodo, PDO::PARAM_INT);
        $stmt->bindParam(':entrega', $this->entrega, PDO::PARAM_STR);
        $stmt->bindParam(':fonte', $this->fonte, PDO::PARAM_STR);
        $stmt->bindParam(':inseridoPor', $this->inseridoPor, PDO::PARAM_STR);
        $stmt->bindParam(':dataCadastro', $this->dataCadastro, PDO::PARAM_STR);
        $stmt->bindParam(':descricaoTR', $this->descricaoTR, PDO::PARAM_STR);
        $stmt->bindParam(':descricaoTD', $this->descricaoTD, PDO::PARAM_STR);
        $stmt->bindParam(':isMudanca', $this->isMudanca, PDO::PARAM_INT);
        $stmt->bindParam(':faseMudanca', $this->faseMudanca, PDO::PARAM_STR);
        $stmt->bindParam(':percentualFase', $this->percentualFase, PDO::PARAM_INT);
        $stmt->bindParam(':idBaseline', $this->idBaseline, PDO::PARAM_INT);
        $stmt->bindParam(':fd', $this->fd, PDO::PARAM_INT);
        $stmt->bindParam(':fe', $this->fe, PDO::PARAM_INT);
        $stmt->bindParam(':idRelacionamento', $this->idRelacionamento, PDO::PARAM_INT);
        $stmt->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stmt->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stmt->execute();
        return DB::getInstance()->lastInsertId();
    }

    public function atualiza($id, $tpo = NULL) {
        /*
         * sempre que atualizar a situacao vai para um
         */
        $sql = "
        UPDATE $this->table SET
        operacao = :operacao,
        funcao = :funcao,
        td = :td,
        tr = :tr,
        pfb = :pfb,
        complexidade= :complexidade,
        impacto = :impacto,
        pfa = :pfa,
        obs_funcao = :obsFuncao,
        obs_validar = :obsValidar,
        id_metodo = :idMetodo,
        entrega  = :entrega,
        fonte = :fonte,
        id_roteiro = :idRoteiro,
        descricao_tr = :descricaoTR,
        descricao_td = :descricaoTD,
        is_mudanca = :isMudanca,
        fase_mudanca = :faseMudanca,
        percentual_fase = :percentualFase,
        id_baseline = :idBaseline,
        situacao = :situacao,
        fd = :fd,
        fe = :fe,
        data_validacao_interna = :dataValidacaoInterna,
        ultima_atualizacao = :ultimaAtualizacao,
        atualizado_por = :atualizadoPor
        WHERE
        " . (NULL === $tpo ? 'id' : 'id_baseline') . " = :id";

        $stmt = DB::prepare($sql);
        $stmt->bindParam(':operacao', $this->operacao, PDO::PARAM_STR);
        $stmt->bindParam(':funcao', $this->funcao, PDO::PARAM_STR);
        $stmt->bindParam(':td', $this->td, PDO::PARAM_INT);
        $stmt->bindParam(':tr', $this->tr, PDO::PARAM_STR);
        $stmt->bindParam(':pfb', $this->pfb, PDO::PARAM_STR);
        $stmt->bindParam(':complexidade', $this->complexidade, PDO::PARAM_STR);
        $stmt->bindParam(':impacto', $this->impacto, PDO::PARAM_STR);
        $stmt->bindParam(':pfa', $this->pfa, PDO::PARAM_STR);
        $stmt->bindParam(':obsFuncao', $this->obsFuncao, PDO::PARAM_STR);
        $stmt->bindParam(':obsValidar', $this->obsValidar, PDO::PARAM_STR);
        $stmt->bindParam(':idMetodo', $this->idMetodo, PDO::PARAM_INT);
        $stmt->bindParam(':entrega', $this->entrega, PDO::PARAM_STR);
        $stmt->bindParam(':fonte', $this->fonte, PDO::PARAM_STR);
        $stmt->bindParam(':idRoteiro', $this->idRoteiro, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':descricaoTR', $this->descricaoTR, PDO::PARAM_STR);
        $stmt->bindParam(':descricaoTD', $this->descricaoTD, PDO::PARAM_STR);
        $stmt->bindParam(':isMudanca', $this->isMudanca, PDO::PARAM_INT);
        $stmt->bindParam(':faseMudanca', $this->faseMudanca, PDO::PARAM_STR);
        $stmt->bindParam(':percentualFase', $this->percentualFase, PDO::PARAM_INT);
        $stmt->bindParam(':idBaseline', $this->idBaseline, PDO::PARAM_INT);
        $stmt->bindParam(':situacao', $this->situacao, PDO::PARAM_INT);
        $stmt->bindParam(':fd', $this->fd, PDO::PARAM_INT);
        $stmt->bindParam(':fe', $this->fe, PDO::PARAM_INT);
        $stmt->bindParam(':dataValidacaoInterna', $this->dataValidacaoInterna);
        $stmt->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stmt->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function getTiposRegistros($id, $abrangencia) {
        $stm = DB::prepare("SELECT * FROM ("
                        . "SELECT DISTINCT 'ALI' AS arquivo, a.descricao_tr "
                        . "FROM ali a, contagem c "
                        . "WHERE a.id_contagem = c.id AND c.id_projeto = :id AND c.id_abrangencia = :abrangencia AND a.descricao_tr <> '' "
                        . "UNION SELECT DISTINCT 'AIE' AS arquivo, a.descricao_tr "
                        . "FROM aie a, contagem c "
                        . "WHERE a.id_contagem = c.id AND c.id_projeto = :id AND c.id_abrangencia = :abrangencia AND a.descricao_tr <> '' ) AS t1 "
                        . "ORDER BY arquivo DESC, descricao_tr ASC");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->bindParam(':abrangencia', $abrangencia, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizaALICrud($id, $idCrud) {
        $stm = DB::prepare("UPDATE ali SET id_crud = '$idCrud', is_crud = 1 WHERE id = $id");
        $stm->execute();
    }

    public function consultaRelacionamentos($funcao) {
        $sql = "";
    }

    public function atualizaIdCrud($id, $idCrudAtualizado) {
        $sql = "UPDATE $this->table SET id_crud = '$idCrudAtualizado' WHERE id = $id";
        $stm = DB::prepare($sql);
        $stm->execute();
    }

    public function getIdContagem($id) {
        $sql = "SELECT id_contagem FROM $this->table WHERE id = $id OR id_relacionamento = $id";
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

}
