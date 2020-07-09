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

class FuncaoTransacao extends CRUD {

    private $id;
    private $idContagem;
    private $idRoteiro;
    private $idCrud;
    private $operacao;
    private $funcao;
    private $ar;
    private $entrega;
    private $td;
    private $pfb;
    private $complexidade;
    private $impacto;
    private $pfa;
    private $obsFuncao;
    private $obsValidar;
    private $idMetodo;
    private $obsValidadorInterno;
    private $obsValidadorExterno;
    private $obsAuditorInterno;
    private $obsAuditorExterno;
    private $obsRevisor;
    private $descricaoAR;
    private $descricaoTD;
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
    private $isMudanca;
    private $faseMudanca;
    private $percentualFase;
    private $idBaseline;
    private $fd;
    private $idGerador;
    private $idRelacionamento;
    private $isCrud;
    private $tipoCrud;
    private $idFatorTecnologia;
    private $valorFatorTecnologia;

    function setId($id) {
        $this->id = $id;
    }

    function setIdContagem($idContagem) {
        $this->idContagem = $idContagem;
    }

    function setIdRoteiro($idRoteiro) {
        $this->idRoteiro = $idRoteiro;
    }

    function setIdCrud($idCrud) {
        $this->idCrud = $idCrud;
    }

    function setOperacao($operacao) {
        $this->operacao = $operacao;
    }

    function setFuncao($funcao) {
        $this->funcao = $funcao;
    }

    function setAr($ar) {
        $this->ar = $ar;
    }

    function setEntrega($entrega) {
        $this->entrega = $entrega;
    }

    function setTd($td) {
        $this->td = $td;
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

    function setDescricaoAR($descricaoAR) {
        $this->descricaoAR = $descricaoAR;
    }

    function setDescricaoTD($descricaoTD) {
        $this->descricaoTD = $descricaoTD;
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

    function setIdGerador($idGerador) {
        $this->idGerador = $idGerador;
    }

    function setIdRelacionamento($idRelacionamento) {
        $this->idRelacionamento = $idRelacionamento;
    }

    function setIsCrud($isCrud) {
        $this->isCrud = $isCrud;
    }

    function setTipoCrud($tipoCrud) {
        $this->tipoCrud = $tipoCrud;
    }

    function setIdFatorTecnologia($idFatorTecnologia) {
        $this->idFatorTecnologia = $idFatorTecnologia;
    }

    function setValorFatorTecnologia($valorFatorTecnologia) {
        $this->valorFatorTecnologia = $valorFatorTecnologia;
    }

    //funcao que atualiza o id_gerador quando uma contagem inserir uma funcao na baseline
    public function atualizaIdGerador($idGerador, $idBaseline) {
        $stm = DB::prepare("UPDATE $this->table SET id_gerador = :idGerador WHERE id = :idBaseline");
        $stm->bindParam(':idGerador', $idGerador, PDO::PARAM_INT);
        $stm->bindParam(':idBaseline', $idBaseline, PDO::PARAM_INT);
        return $stm->execute();
    }

    //funcao que atualiza o id_gerador quando uma contagem inserir uma funcao na baseline com CRUD
    public function atualizaIdBaseline($idGerador, $idBaseline) {
        $stm = DB::prepare("UPDATE $this->table SET id_baseline = :idBaseline WHERE id = :idGerador");
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
        ar,
        entrega,
        td,
        pfb,
        complexidade,
        impacto,
        pfa,
        obs_funcao,
        obs_validar,
        id_metodo,
        descricao_td,
        descricao_ar,
        fonte,
        inserido_por,
        data_cadastro,
        is_mudanca,
        fase_mudanca,
        percentual_fase,     
        id_baseline,
        fd,
        id_relacionamento,
        id_fator_tecnologia,
        valor_fator_tecnologia,
        ultima_atualizacao,
        atualizado_por
        )
        VALUES (
        :idContagem,
        :idRoteiro,
        :operacao,
        :funcao,
        :ar,
        :entrega,
        :td,
        :pfb,
        :complexidade,
        :impacto,
        :pfa,
        :obsFuncao,
        :obsValidar,
        :idMetodo,
        :descricaoTD,
        :descricaoAR,
        :fonte,
        :inseridoPor,
        :dataCadastro,
        :isMudanca,
        :faseMudanca,
        :percentualFase,   
        :idBaseline,
        :fd,
        :idRelacionamento,
        :idFatorTecnologia,
        :valorFatorTecnologia,
        :ultimaAtualizacao,
        :atualizadoPor)";
        /*
         * jamais vou entender, entretanto agora precisa de um teste aqui no percentual_fase
         */
        $percentualFase = $this->percentualFase ? $this->percentualFase : 0;
        /*
         * continua normalmente
         */
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':idContagem', $this->idContagem, PDO::PARAM_INT);
        $stmt->bindParam(':idRoteiro', $this->idRoteiro, PDO::PARAM_INT);
        $stmt->bindParam(':operacao', $this->operacao, PDO::PARAM_STR);
        $stmt->bindParam(':funcao', $this->funcao, PDO::PARAM_STR);
        $stmt->bindParam(':ar', $this->ar, PDO::PARAM_STR);
        $stmt->bindParam(':entrega', $this->entrega, PDO::PARAM_INT);
        $stmt->bindParam(':td', $this->td, PDO::PARAM_INT);
        $stmt->bindParam(':pfb', $this->pfb, PDO::PARAM_STR);
        $stmt->bindParam(':complexidade', $this->complexidade, PDO::PARAM_STR);
        $stmt->bindParam(':impacto', $this->impacto, PDO::PARAM_STR);
        $stmt->bindParam(':pfa', $this->pfa, PDO::PARAM_STR);
        $stmt->bindParam(':obsFuncao', $this->obsFuncao, PDO::PARAM_STR);
        $stmt->bindParam(':obsValidar', $this->obsValidar, PDO::PARAM_STR);
        $stmt->bindParam(':idMetodo', $this->idMetodo, PDO::PARAM_INT);
        $stmt->bindParam(':descricaoTD', $this->descricaoTD, PDO::PARAM_STR);
        $stmt->bindParam(':descricaoAR', $this->descricaoAR, PDO::PARAM_STR);
        $stmt->bindParam(':fonte', $this->fonte, PDO::PARAM_STR);
        $stmt->bindParam(':inseridoPor', $this->inseridoPor, PDO::PARAM_STR);
        $stmt->bindParam(':dataCadastro', $this->dataCadastro, PDO::PARAM_STR);
        $stmt->bindParam(':isMudanca', $this->isMudanca, PDO::PARAM_INT);
        $stmt->bindParam(':faseMudanca', $this->faseMudanca, PDO::PARAM_STR);
        $stmt->bindParam(':percentualFase', $percentualFase, PDO::PARAM_STR);
        $stmt->bindParam(':idBaseline', $this->idBaseline, PDO::PARAM_INT);
        $stmt->bindParam(':fd', $this->fd, PDO::PARAM_INT);
        $stmt->bindParam(':idRelacionamento', $this->idRelacionamento, PDO::PARAM_INT);
        $stmt->bindParam(':idFatorTecnologia', $this->idFatorTecnologia, PDO::PARAM_INT);
        $stmt->bindParam(':valorFatorTecnologia', $this->valorFatorTecnologia, PDO::PARAM_STR);
        $stmt->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stmt->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stmt->execute();
        return DB::getInstance()->lastInsertId();
    }

    public function atualiza($id, $tpo = NULL) {
        $sql = "
        UPDATE $this->table SET
        operacao = :operacao,
        funcao = :funcao,
        ar = :ar,
        entrega = :entrega,
        td = :td,
        pfb = :pfb,
        complexidade = :complexidade,
        impacto = :impacto,
        pfa = :pfa,
        obs_funcao = :obsFuncao,
        obs_validar = :obsValidar,
        id_metodo = :idMetodo,
        descricao_td = :descricaoTD,
        descricao_ar = :descricaoAR,
        id_roteiro = :idRoteiro,
        fonte = :fonte,
        is_mudanca = :isMudanca,
        fase_mudanca = :faseMudanca,
        percentual_fase = :percentualFase,     
        id_baseline = :idBaseline,
        situacao = :situacao,
        fd = :fd,
        data_validacao_interna = :dataValidacaoInterna,
        id_fator_tecnologia = :idFatorTecnologia,
        valor_fator_tecnologia = :valorFatorTecnologia,
        ultima_atualizacao = :ultimaAtualizacao,
        atualizado_por = :atualizadoPor
        WHERE
        " . (NULL === $tpo ? 'id' : 'id_baseline') . " = :id";

        /*
         * jamais vou entender, entretanto agora precisa de um teste aqui no percentual_fase
         */
        $percentualFase = $this->percentualFase ? $this->percentualFase : 0;
        /*
         * continua normalmente
         */
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':operacao', $this->operacao, PDO::PARAM_STR);
        $stmt->bindParam(':funcao', $this->funcao, PDO::PARAM_STR);
        $stmt->bindParam(':ar', $this->ar, PDO::PARAM_STR);
        $stmt->bindParam(':entrega', $this->entrega, PDO::PARAM_INT);
        $stmt->bindParam(':td', $this->td, PDO::PARAM_INT);
        $stmt->bindParam(':pfb', $this->pfb, PDO::PARAM_STR);
        $stmt->bindParam(':complexidade', $this->complexidade, PDO::PARAM_STR);
        $stmt->bindParam(':impacto', $this->impacto, PDO::PARAM_STR);
        $stmt->bindParam(':pfa', $this->pfa, PDO::PARAM_STR);
        $stmt->bindParam(':obsFuncao', $this->obsFuncao, PDO::PARAM_STR);
        $stmt->bindParam(':obsValidar', $this->obsValidar, PDO::PARAM_STR);
        $stmt->bindParam(':idMetodo', $this->idMetodo, PDO::PARAM_INT);
        $stmt->bindParam(':descricaoTD', $this->descricaoTD, PDO::PARAM_STR);
        $stmt->bindParam(':descricaoAR', $this->descricaoAR, PDO::PARAM_STR);
        $stmt->bindParam(':idRoteiro', $this->idRoteiro, PDO::PARAM_STR);
        $stmt->bindParam(':fonte', $this->fonte, PDO::PARAM_STR);
        $stmt->bindParam(':idRoteiro', $this->idRoteiro, PDO::PARAM_INT);
        $stmt->bindParam(':isMudanca', $this->isMudanca, PDO::PARAM_INT);
        $stmt->bindParam(':faseMudanca', $this->faseMudanca, PDO::PARAM_STR);
        $stmt->bindParam(':percentualFase', $percentualFase, PDO::PARAM_STR);
        $stmt->bindParam(':idBaseline', $this->idBaseline, PDO::PARAM_INT);
        $stmt->bindParam(':situacao', $this->situacao, PDO::PARAM_INT);
        $stmt->bindParam(':fd', $this->fd, PDO::PARAM_INT);
        $stmt->bindParam(':dataValidacaoInterna', $this->dataValidacaoInterna);
        $stmt->bindParam(':idFatorTecnologia', $this->idFatorTecnologia, PDO::PARAM_INT);
        $stmt->bindParam(':valorFatorTecnologia', $this->valorFatorTecnologia, PDO::PARAM_STR);
        $stmt->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stmt->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function getArquivosReferenciados($idBaseline) {
        $stm = DB::prepare("SELECT * FROM ("
                        . "SELECT DISTINCT 'ali' AS arquivo, a.funcao, a.situacao, a.operacao, a.obs_funcao "
                        . "FROM ali a, contagem c "
                        . "WHERE c.id = :idBaseline AND a.id_contagem = :idBaseline AND a.is_ativo = 1 AND a.id_baseline = 0 "
                        . "UNION SELECT DISTINCT 'aie' AS arquivo, a.funcao, a.situacao, a.operacao, a.obs_funcao "
                        . "FROM aie a, contagem c "
                        . "WHERE c.id = :idBaseline AND a.id_contagem = :idBaseline AND a.is_ativo = 1 AND a.id_baseline = 0) AS t1 "
                        . "ORDER BY arquivo DESC, funcao ASC");
        $stm->bindParam(':idBaseline', $idBaseline, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTipoDados($id, $tags) {
        /*
         * recebe as tags e separa em ali e aie
         */
        $arAli = array();
        $arAie = array();
        $arTags = explode(',', $tags);
        /*
         * coloca as tags em suas arrays
         */
        for ($x = 0; $x < count($arTags); $x++) {
            $arTpo = explode('.', $arTags[$x]);
            if ($arTpo[0] === 'ali') {
                $arAli[] = $arTpo[1];
            } else {
                $arAie[] = $arTpo[1];
            }
        }
        if (count($arAie) > 0 || count($arAli) > 0) {
            $sql = "SELECT * FROM ("
                    . (count($arAli) > 0 ? "SELECT DISTINCT concat('ali.', a.funcao) AS arquivo, a.descricao_td AS funcao, a.situacao FROM ali a, contagem c "
                            . "WHERE a.id_contagem = c.id AND c.id = :id AND a.funcao IN('" . str_replace(",", "','", implode(",", $arAli)) . "') AND a.is_ativo = 1 AND a.id_baseline = 0 " : "")
                    . ((count($arAli) > 0 && count($arAie) > 0) ? "UNION " : "")
                    . (count($arAie) > 0 ? "SELECT DISTINCT concat('aie.', a.funcao) AS arquivo, a.descricao_td AS funcao, a.situacao FROM aie a, contagem c "
                            . "WHERE a.id_contagem = c.id AND c.id = :id AND a.funcao IN('" . str_replace(",", "','", implode(",", $arAie)) . "') AND a.is_ativo = 1 AND a.id_baseline = 0 " : "")
                    . ") AS t1 ORDER BY arquivo DESC, funcao ASC";
            $stm = DB::prepare($sql);
            $stm->bindParam(':id', $id, PDO::PARAM_INT);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return array('arquivo' => 'nao.encontrado', 'funcao' => 'favor verificar');
        }
    }

    public function atualizaIsCrud($id, $tipoCrud) {
        $stm = DB::prepare("UPDATE $this->table SET is_crud = $this->isCrud, tipo_crud='$tipoCrud' WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
    }

    public function getALICrud($id, $table) {
        /*
         * seleciona o arquivo referenciado atraves da funcao excluida
         */
        $sql = "SELECT $table.id, $table.id_baseline, $table.tipo_crud, $table.id_contagem, $table.descricao_ar FROM $this->table $table WHERE $table.id = $id";
        $stm = DB::prepare($sql);
        $stm->execute();
        $arquivo = $stm->fetch(PDO::FETCH_ASSOC);
        $arquivoReferenciado = explode('.', $arquivo['descricao_ar'])[1];
        $idContagem = $arquivo['id_contagem'];
        $tipoCrud = $arquivo['tipo_crud'];
        $idBaselineFuncao = $arquivo['id_baseline'];
        /*
         * seleciona o ali que foi alterado
         */
        $sqlALI = "SELECT '$tipoCrud' AS tipo_crud, '$idBaselineFuncao' AS id_baseline, ali.id, ali.id_crud FROM ali ali WHERE ali.id_contagem = $idContagem AND funcao = '$arquivoReferenciado'";
        $stmALI = DB::prepare($sqlALI);
        $stmALI->execute();
        return $stmALI->fetch(PDO::FETCH_ASSOC);
    }

    public function getIdContagem($id) {
        $sql = "SELECT id_contagem FROM $this->table WHERE id = $id OR id_relacionamento = $id";
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * 
     * @param int $id - id da funcao a ser atualizada EE, CE
     * @param boolean $ar - se alterou o nome da funcao, altera o AR correspondente
     * @return boolean
     */
    public function atualizaCRUD($id, $ar) {
        $sql = "UPDATE $this->table SET "
                . "td = '$this->td', "
                . "pfa = '$this->pfa', "
                . "pfb = '$this->pfb', "
                . "complexidade = '$this->complexidade', "
                . "descricao_td = '$this->descricaoTD' "
                . ($ar ? ", descricao_ar = '$this->descricaoAR' " : "")
                . ($ar ? ", funcao = '$this->funcao' " : "")
                . "WHERE id = $id || id_baseline = $id";
        $stm = DB::prepare($sql);
        return $stm->execute();
    }

    public function getDescricaoTDCRUD($id) {
        $sql = "SELECT funcao, descricao_td, descricao_ar FROM $this->table WHERE id = $id";
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

}
