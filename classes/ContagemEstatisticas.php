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

class ContagemEstatisticas extends CRUD {

    private $idContagem;
    private $previsaoInicio;
    private $previsaoTermino;
    private $isProdutividadeGlobal;
    private $produtividadeGlobal;
    private $hlt;
    private $isFt;
    private $ft;
    private $pctEng;
    private $prodEng;
    private $profEng;
    private $perfEng;
    private $chkEng;
    private $pctDes;
    private $prodDes;
    private $profDes;
    private $perfDes;
    private $chkDes;
    private $pctImp;
    private $prodImp;
    private $profImp;
    private $perfImp;
    private $chkImp;
    private $pctTes;
    private $prodTes;
    private $profTes;
    private $perfTes;
    private $chkTes;
    private $pctHom;
    private $prodHom;
    private $profHom;
    private $perfHom;
    private $chkHom;
    private $pctImpl;
    private $prodImpl;
    private $profImpl;
    private $perfImpl;
    private $chkImpl;
    private $isFEng;
    private $descFEng;
    private $isFDes;
    private $descFDes;
    private $isFImp;
    private $descFImp;
    private $isFTes;
    private $descFTes;
    private $isFHom;
    private $descFHom;
    private $isFImpl;
    private $descFImpl;
    private $expoente;
    private $calculado;
    private $tempoDesenvolvimento;
    private $regiaoImpossivel;
    private $menorCusto;
    private $previsaoFEng;
    private $previsaoFDes;
    private $previsaoFImp;
    private $previsaoFTes;
    private $previsaoFHom;
    private $previsaoFImpl;
    private $esforcoFEng;
    private $esforcoFDes;
    private $esforcoFImp;
    private $esforcoFTes;
    private $esforcoFHom;
    private $esforcoFImpl;
    private $pctPFAEng;
    private $pctPFADes;
    private $pctPFAImp;
    private $pctPFATes;
    private $pctPFAHom;
    private $pctPFAImpl;
    private $isProdutividadeLinguagem;
    private $escalaProdutividade;
    private $produtividadeBaixa;
    private $produtividadeMedia;
    private $produtividadeAlta;
    private $hpc;
    private $hpa;
    private $fatorReducaoCronograma;
    private $aumentoEsforco;
    private $isSolicitacaoServicoCritica;
    private $tipoProjeto;
    private $esforcoTotal;
    private $tamanhoPfa;
    private $spanProdutividadeMedia;
    private $valorHpc;
    private $valorHpa;
    private $custoTotal;
    private $valorPfaContrato;

    public function __construct() {
        $this->setTable('contagem_estatisticas');
        $this->setLog();
    }

    function setIdContagem($idContagem) {
        $this->idContagem = $idContagem;
    }

    function setPrevisaoInicio($previsaoInicio) {
        $this->previsaoInicio = $previsaoInicio;
    }

    function setIsProdutividadeGlobal($isProdutividadeGlobal) {
        $this->isProdutividadeGlobal = $isProdutividadeGlobal;
    }

    function setProdutividadeGlobal($produtividadeGlobal) {
        $this->produtividadeGlobal = $produtividadeGlobal;
    }

    function setHlt($hlt) {
        $this->hlt = $hlt;
    }

    function setIsFt($isFt) {
        $this->isFt = $isFt;
    }

    function setFt($ft) {
        $this->ft = $ft;
    }

    function setPctEng($pctEng) {
        $this->pctEng = $pctEng;
    }

    function setProdEng($prodEng) {
        $this->prodEng = $prodEng;
    }

    function setProfEng($profEng) {
        $this->profEng = $profEng;
    }

    function setPerfEng($perfEng) {
        $this->perfEng = $perfEng;
    }

    function setChkEng($chkEng) {
        $this->chkEng = $chkEng;
    }

    function setPctDes($pctDes) {
        $this->pctDes = $pctDes;
    }

    function setProdDes($prodDes) {
        $this->prodDes = $prodDes;
    }

    function setProfDes($profDes) {
        $this->profDes = $profDes;
    }

    function setPerfDes($perfDes) {
        $this->perfDes = $perfDes;
    }

    function setChkDes($chkDes) {
        $this->chkDes = $chkDes;
    }

    function setPctImp($pctImp) {
        $this->pctImp = $pctImp;
    }

    function setProdImp($prodImp) {
        $this->prodImp = $prodImp;
    }

    function setProfImp($profImp) {
        $this->profImp = $profImp;
    }

    function setPerfImp($perfImp) {
        $this->perfImp = $perfImp;
    }

    function setChkImp($chkImp) {
        $this->chkImp = $chkImp;
    }

    function setPctTes($pctTes) {
        $this->pctTes = $pctTes;
    }

    function setProdTes($prodTes) {
        $this->prodTes = $prodTes;
    }

    function setProfTes($profTes) {
        $this->profTes = $profTes;
    }

    function setPerfTes($perfTes) {
        $this->perfTes = $perfTes;
    }

    function setChkTes($chkTes) {
        $this->chkTes = $chkTes;
    }

    function setPctHom($pctHom) {
        $this->pctHom = $pctHom;
    }

    function setProdHom($prodHom) {
        $this->prodHom = $prodHom;
    }

    function setProfHom($profHom) {
        $this->profHom = $profHom;
    }

    function setPerfHom($perfHom) {
        $this->perfHom = $perfHom;
    }

    function setChkHom($chkHom) {
        $this->chkHom = $chkHom;
    }

    function setPctImpl($pctImpl) {
        $this->pctImpl = $pctImpl;
    }

    function setProdImpl($prodImpl) {
        $this->prodImpl = $prodImpl;
    }

    function setProfImpl($profImpl) {
        $this->profImpl = $profImpl;
    }

    function setPerfImpl($perfImpl) {
        $this->perfImpl = $perfImpl;
    }

    function setChkImpl($chkImpl) {
        $this->chkImpl = $chkImpl;
    }

    function setIsFEng($isFEng) {
        $this->isFEng = $isFEng;
    }

    function setDescFEng($descFEng) {
        $this->descFEng = $descFEng;
    }

    function setIsFDes($isFDes) {
        $this->isFDes = $isFDes;
    }

    function setDescFDes($descFDes) {
        $this->descFDes = $descFDes;
    }

    function setIsFImp($isFImp) {
        $this->isFImp = $isFImp;
    }

    function setDescFImp($descFImp) {
        $this->descFImp = $descFImp;
    }

    function setIsFTes($isFTes) {
        $this->isFTes = $isFTes;
    }

    function setDescFTes($descFTes) {
        $this->descFTes = $descFTes;
    }

    function setIsFHom($isFHom) {
        $this->isFHom = $isFHom;
    }

    function setDescFHom($descFHom) {
        $this->descFHom = $descFHom;
    }

    function setIsFImpl($isFImpl) {
        $this->isFImpl = $isFImpl;
    }

    function setDescFImpl($descFImpl) {
        $this->descFImpl = $descFImpl;
    }

    function setExpoente($expoente) {
        $this->expoente = $expoente;
    }

    function setCalculado($calculado) {
        $this->calculado = $calculado;
    }

    function setTempoDesenvolvimento($tempoDesenvolvimento) {
        $this->tempoDesenvolvimento = $tempoDesenvolvimento;
    }

    function setRegiaoImpossivel($regiaoImpossivel) {
        $this->regiaoImpossivel = $regiaoImpossivel;
    }

    function setMenorCusto($menorCusto) {
        $this->menorCusto = $menorCusto;
    }

    function setPrevisaoFEng($previsaoFEng) {
        $this->previsaoFEng = $previsaoFEng;
    }

    function setPrevisaoFDes($previsaoFDes) {
        $this->previsaoFDes = $previsaoFDes;
    }

    function setPrevisaoFImp($previsaoFImp) {
        $this->previsaoFImp = $previsaoFImp;
    }

    function setPrevisaoFTes($previsaoFTes) {
        $this->previsaoFTes = $previsaoFTes;
    }

    function setPrevisaoFHom($previsaoFHom) {
        $this->previsaoFHom = $previsaoFHom;
    }

    function setPrevisaoFImpl($previsaoFImpl) {
        $this->previsaoFImpl = $previsaoFImpl;
    }

    function setEsforcoFEng($esforcoFEng) {
        $this->esforcoFEng = $esforcoFEng;
    }

    function setEsforcoFDes($esforcoFDes) {
        $this->esforcoFDes = $esforcoFDes;
    }

    function setEsforcoFImp($esforcoFImp) {
        $this->esforcoFImp = $esforcoFImp;
    }

    function setEsforcoFTes($esforcoFTes) {
        $this->esforcoFTes = $esforcoFTes;
    }

    function setEsforcoFHom($esforcoFHom) {
        $this->esforcoFHom = $esforcoFHom;
    }

    function setEsforcoFImpl($esforcoFImpl) {
        $this->esforcoFImpl = $esforcoFImpl;
    }

    function setPctPFAEng($pctPFAEng) {
        $this->pctPFAEng = $pctPFAEng;
    }

    function setPctPFADes($pctPFADes) {
        $this->pctPFADes = $pctPFADes;
    }

    function setPctPFAImp($pctPFAImp) {
        $this->pctPFAImp = $pctPFAImp;
    }

    function setPctPFATes($pctPFATes) {
        $this->pctPFATes = $pctPFATes;
    }

    function setPctPFAHom($pctPFAHom) {
        $this->pctPFAHom = $pctPFAHom;
    }

    function setPctPFAImpl($pctPFAImpl) {
        $this->pctPFAImpl = $pctPFAImpl;
    }

    function setIsProdutividadeLinguagem($isProdutividadeLinguagem) {
        $this->isProdutividadeLinguagem = $isProdutividadeLinguagem;
    }

    function setEscalaProdutividade($escalaProdutividade) {
        $this->escalaProdutividade = $escalaProdutividade;
    }

    function setProdutividadeBaixa($produtividadeBaixa) {
        $this->produtividadeBaixa = $produtividadeBaixa;
    }

    function setProdutividadeMedia($produtividadeMedia) {
        $this->produtividadeMedia = $produtividadeMedia;
    }

    function setProdutividadeAlta($produtividadeAlta) {
        $this->produtividadeAlta = $produtividadeAlta;
    }

    function setHpc($hpc) {
        $this->hpc = $hpc;
    }

    function setHpa($hpa) {
        $this->hpa = $hpa;
    }

    function setFatorReducaoCronograma($fatorReducaoCronograma) {
        $this->fatorReducaoCronograma = $fatorReducaoCronograma;
    }

    function setAumentoEsforco($aumentoEsforco) {
        $this->aumentoEsforco = $aumentoEsforco;
    }

    function setPrevisaoTermino($previsaoTermino) {
        $this->previsaoTermino = $previsaoTermino;
    }

    function setIsSolicitacaoServicoCritica($isSolicitacaoServicoCritica) {
        $this->isSolicitacaoServicoCritica = $isSolicitacaoServicoCritica;
    }

    function setTipoProjeto($tipoProjeto) {
        $this->tipoProjeto = $tipoProjeto;
    }

    function setEsforcoTotal($esforcoTotal) {
        $this->esforcoTotal = $esforcoTotal;
    }

    function setTamanhoPfa($tamanhoPfa) {
        $this->tamanhoPfa = $tamanhoPfa;
    }

    function setSpanProdutividadeMedia($spanProdutividadeMedia) {
        $this->spanProdutividadeMedia = $spanProdutividadeMedia;
    }

    function setValorHpc($valorHpc) {
        $this->valorHpc = $valorHpc;
    }

    function setValorHpa($valorHpa) {
        $this->valorHpa = $valorHpa;
    }

    function setCustoTotal($custoTotal) {
        $this->custoTotal = $custoTotal;
    }

    function setValorPfaContrato($valorPfaContrato) {
        $this->valorPfaContrato = $valorPfaContrato;
    }

    public function insere() {
        $sql = "INSERT INTO contagem_estatisticas ("
                . "id_contagem, "
                . "previsao_inicio, "
                . "chk_produtividade_global, "
                . "produtividade_global, "
                . "hlt, "
                . "is_ft, "
                . "ft, "
                . "pct_eng, "
                . "prod_eng, "
                . "prof_eng, "
                . "perf_eng, "
                . "chk_eng, "
                . "pct_des, "
                . "prod_des, "
                . "prof_des, "
                . "perf_des, "
                . "chk_des, "
                . "pct_imp, "
                . "prod_imp, "
                . "prof_imp, "
                . "perf_imp, "
                . "chk_imp, "
                . "pct_tes, "
                . "prod_tes, "
                . "prof_tes, "
                . "perf_tes, "
                . "chk_tes, "
                . "pct_hom, "
                . "prod_hom, "
                . "prof_hom, "
                . "perf_hom, "
                . "chk_hom, "
                . "pct_impl, "
                . "prod_impl, "
                . "prof_impl, "
                . "perf_impl, "
                . "chk_impl, "
                . "is_f_eng, "
                . "desc_f_eng, "
                . "is_f_des, "
                . "desc_f_des, "
                . "is_f_imp, "
                . "desc_f_imp, "
                . "is_f_tes, "
                . "desc_f_tes, "
                . "is_f_hom, "
                . "desc_f_hom, "
                . "is_f_impl, "
                . "desc_f_impl, "
                . "expoente, "
                . "calculado, "
                . "tempo_desenvolvimento, "
                . "regiao_impossivel, "
                . "menor_custo, "
                . "previsao_f_eng, "
                . "previsao_f_des, "
                . "previsao_f_imp, "
                . "previsao_f_tes, "
                . "previsao_f_hom, "
                . "previsao_f_impl, "
                . "esforco_f_eng, "
                . "esforco_f_des, "
                . "esforco_f_imp, "
                . "esforco_f_tes, "
                . "esforco_f_hom, "
                . "esforco_f_impl, "
                . "pct_pfa_eng, "
                . "pct_pfa_des, "
                . "pct_pfa_imp, "
                . "pct_pfa_tes, "
                . "pct_pfa_hom, "
                . "pct_pfa_impl, "
                . "valor_hpc, "
                . "valor_hpa, "
                . "custo_total, "
                . "esforco_total, "
                . "valor_pfa_contrato, "
                . "ultima_atualizacao, "
                . "atualizado_por"
                . ") VALUES ("
                . ":idContagem, "
                . ":previsaoInicio, "
                . ":isProdutividadeGlobal, "
                . ":produtividadeGlobal, "
                . ":hlt, "
                . ":isFt, "
                . ":ft, "
                . ":pctEng, "
                . ":prodEng, "
                . ":profEng, "
                . ":perfEng, "
                . ":chkEng, "
                . ":pctDes, "
                . ":prodDes, "
                . ":profDes, "
                . ":perfDes, "
                . ":chkDes, "
                . ":pctImp, "
                . ":prodImp, "
                . ":profImp, "
                . ":perfImp, "
                . ":chkImp, "
                . ":pctTes, "
                . ":prodTes, "
                . ":profTes, "
                . ":perfTes, "
                . ":chkTes, "
                . ":pctHom, "
                . ":prodHom, "
                . ":profHom, "
                . ":perfHom, "
                . ":chkHom, "
                . ":pctImpl, "
                . ":prodImpl, "
                . ":profImpl, "
                . ":perfImpl, "
                . ":chkImpl, "
                . ":isFEng, "
                . ":descFEng, "
                . ":isFDes, "
                . ":descFDes, "
                . ":isFImp, "
                . ":descFImp, "
                . ":isFTes, "
                . ":descFTes, "
                . ":isFHom, "
                . ":descFHom, "
                . ":isFImpl, "
                . ":descFImpl, "
                . ":expoente, "
                . ":calculado, "
                . ":tempoDesenvolvimento, "
                . ":regiaoImpossivel, "
                . ":menorCusto, "
                . ":previsaoFEng, "
                . ":previsaoFDes, "
                . ":previsaoFImp, "
                . ":previsaoFTes, "
                . ":previsaoFHom, "
                . ":previsaoFImpl, "
                . ":esforcoFEng, "
                . ":esforcoFDes, "
                . ":esforcoFImp, "
                . ":esforcoFTes, "
                . ":esforcoFHom, "
                . ":esforcoFImpl, "
                . ":pctPFAEng, "
                . ":pctPFADes, "
                . ":pctPFAImp, "
                . ":pctPFATes, "
                . ":pctPFAHom, "
                . ":pctPFAImpl, "
                . ":valorHpc, "
                . ":valorHpa, "
                . ":custoTotal, "
                . ":esforcoTotal, "
                . ":valorPfaContrato, "
                . ":ultimaAtualizacao, "
                . ":atualizadoPor"
                . ")";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idContagem', $this->idContagem, PDO::PARAM_INT);
        $stm->bindParam(':previsaoInicio', $this->previsaoInicio, PDO::PARAM_STR);
        $stm->bindParam(':isProdutividadeGlobal', $this->isProdutividadeGlobal, PDO::PARAM_INT);
        $stm->bindParam(':produtividadeGlobal', $this->produtividadeGlobal, PDO::PARAM_STR);
        $stm->bindParam(':hlt', $this->hlt, PDO::PARAM_STR);
        $stm->bindParam(':isFt', $this->isFt, PDO::PARAM_INT);
        $stm->bindParam(':ft', $this->ft, PDO::PARAM_STR);
        $stm->bindParam(':pctEng', $this->pctEng, PDO::PARAM_STR);
        $stm->bindParam(':prodEng', $this->prodEng, PDO::PARAM_STR);
        $stm->bindParam(':profEng', $this->profEng, PDO::PARAM_INT);
        $stm->bindParam(':perfEng', $this->perfEng, PDO::PARAM_STR);
        $stm->bindParam(':chkEng', $this->chkEng, PDO::PARAM_INT);
        $stm->bindParam(':pctDes', $this->pctDes, PDO::PARAM_STR);
        $stm->bindParam(':prodDes', $this->prodDes, PDO::PARAM_STR);
        $stm->bindParam(':profDes', $this->profDes, PDO::PARAM_INT);
        $stm->bindParam(':perfDes', $this->perfDes, PDO::PARAM_STR);
        $stm->bindParam(':chkDes', $this->chkDes, PDO::PARAM_INT);
        $stm->bindParam(':pctImp', $this->pctImp, PDO::PARAM_STR);
        $stm->bindParam(':prodImp', $this->prodImp, PDO::PARAM_STR);
        $stm->bindParam(':profImp', $this->profImp, PDO::PARAM_INT);
        $stm->bindParam(':perfImp', $this->perfImp, PDO::PARAM_STR);
        $stm->bindParam(':chkImp', $this->chkImp, PDO::PARAM_INT);
        $stm->bindParam(':pctTes', $this->pctTes, PDO::PARAM_STR);
        $stm->bindParam(':prodTes', $this->prodTes, PDO::PARAM_STR);
        $stm->bindParam(':profTes', $this->profTes, PDO::PARAM_INT);
        $stm->bindParam(':perfTes', $this->perfTes, PDO::PARAM_STR);
        $stm->bindParam(':chkTes', $this->chkTes, PDO::PARAM_INT);
        $stm->bindParam(':pctHom', $this->pctHom, PDO::PARAM_STR);
        $stm->bindParam(':prodHom', $this->prodHom, PDO::PARAM_STR);
        $stm->bindParam(':profHom', $this->profHom, PDO::PARAM_INT);
        $stm->bindParam(':perfHom', $this->perfHom, PDO::PARAM_STR);
        $stm->bindParam(':chkHom', $this->chkHom, PDO::PARAM_INT);
        $stm->bindParam(':pctImpl', $this->pctImpl, PDO::PARAM_STR);
        $stm->bindParam(':prodImpl', $this->prodImpl, PDO::PARAM_STR);
        $stm->bindParam(':profImpl', $this->profImpl, PDO::PARAM_INT);
        $stm->bindParam(':perfImpl', $this->perfImpl, PDO::PARAM_STR);
        $stm->bindParam(':chkImpl', $this->chkImpl, PDO::PARAM_INT);
        $stm->bindParam(':isFEng', $this->isFEng, PDO::PARAM_INT);
        $stm->bindParam(':descFEng', $this->descFEng, PDO::PARAM_STR);
        $stm->bindParam(':isFDes', $this->isFDes, PDO::PARAM_INT);
        $stm->bindParam(':descFDes', $this->descFDes, PDO::PARAM_STR);
        $stm->bindParam(':isFImp', $this->isFImp, PDO::PARAM_INT);
        $stm->bindParam(':descFImp', $this->descFImp, PDO::PARAM_STR);
        $stm->bindParam(':isFTes', $this->isFTes, PDO::PARAM_INT);
        $stm->bindParam(':descFTes', $this->descFTes, PDO::PARAM_STR);
        $stm->bindParam(':isFHom', $this->isFHom, PDO::PARAM_INT);
        $stm->bindParam(':descFHom', $this->descFHom, PDO::PARAM_STR);
        $stm->bindParam(':isFImpl', $this->isFImpl, PDO::PARAM_INT);
        $stm->bindParam(':descFImpl', $this->descFImpl, PDO::PARAM_STR);
        $stm->bindParam(':expoente', $this->expoente, PDO::PARAM_STR);
        $stm->bindParam(':calculado', $this->calculado, PDO::PARAM_STR);
        $stm->bindParam(':tempoDesenvolvimento', $this->tempoDesenvolvimento, PDO::PARAM_STR);
        $stm->bindParam(':regiaoImpossivel', $this->regiaoImpossivel, PDO::PARAM_STR);
        $stm->bindParam(':menorCusto', $this->menorCusto, PDO::PARAM_STR);
        $stm->bindParam(':previsaoFEng', $this->previsaoFEng, PDO::PARAM_STR);
        $stm->bindParam(':previsaoFDes', $this->previsaoFDes, PDO::PARAM_STR);
        $stm->bindParam(':previsaoFImp', $this->previsaoFImp, PDO::PARAM_STR);
        $stm->bindParam(':previsaoFTes', $this->previsaoFTes, PDO::PARAM_STR);
        $stm->bindParam(':previsaoFHom', $this->previsaoFHom, PDO::PARAM_STR);
        $stm->bindParam(':previsaoFImpl', $this->previsaoFImpl, PDO::PARAM_STR);
        $stm->bindParam(':esforcoFEng', $this->esforcoFEng, PDO::PARAM_STR);
        $stm->bindParam(':esforcoFDes', $this->esforcoFDes, PDO::PARAM_STR);
        $stm->bindParam(':esforcoFImp', $this->esforcoFImp, PDO::PARAM_STR);
        $stm->bindParam(':esforcoFTes', $this->esforcoFTes, PDO::PARAM_STR);
        $stm->bindParam(':esforcoFHom', $this->esforcoFHom, PDO::PARAM_STR);
        $stm->bindParam(':esforcoFImpl', $this->esforcoFImpl, PDO::PARAM_STR);
        $stm->bindParam(':pctPFAEng', $this->pctPFAEng, PDO::PARAM_STR);
        $stm->bindParam(':pctPFADes', $this->pctPFADes, PDO::PARAM_STR);
        $stm->bindParam(':pctPFAImp', $this->pctPFAImp, PDO::PARAM_STR);
        $stm->bindParam(':pctPFATes', $this->pctPFATes, PDO::PARAM_STR);
        $stm->bindParam(':pctPFAHom', $this->pctPFAHom, PDO::PARAM_STR);
        $stm->bindParam(':pctPFAImpl', $this->pctPFAImpl, PDO::PARAM_STR);
        $stm->bindParam(':valorHpc', $this->valorHpc, PDO::PARAM_STR);
        $stm->bindParam(':valorHpa', $this->valorHpa, PDO::PARAM_STR);
        $stm->bindParam(':custoTotal', $this->custoTotal, PDO::PARAM_STR);
        $stm->bindParam(':esforcoTotal', $this->esforcoTotal, PDO::PARAM_STR);
        $stm->bindParam(':valorPfaContrato', $this->valorPfaContrato, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor);
        $stm->execute();
        return DB::getInstance()->lastInsertId();
    }

    public function atualiza($id) {
        $sql = "UPDATE contagem_estatisticas SET "
                . "previsao_inicio = :previsaoInicio, "
                . "previsao_termino = :previsaoTermino, "
                . "chk_produtividade_global = :isProdutividadeGlobal, "
                . "produtividade_global = :produtividadeGlobal, "
                . "hlt = :hlt, "
                . "is_ft = :isFt, "
                . "ft = :ft, "
                . "pct_eng = :pctEng, "
                . "prod_eng = :prodEng, "
                . "prof_eng = :profEng, "
                . "perf_eng = :perfEng, "
                . "chk_eng = :chkEng, "
                . "pct_des = :pctDes, "
                . "prod_des = :prodDes, "
                . "prof_des = :profDes, "
                . "perf_des = :perfDes, "
                . "chk_des = :chkDes, "
                . "pct_imp = :pctImp, "
                . "prod_imp = :prodImp, "
                . "prof_imp = :profImp, "
                . "perf_imp = :perfImp, "
                . "chk_imp = :chkImp, "
                . "pct_tes = :pctTes, "
                . "prod_tes = :prodTes, "
                . "prof_tes = :profTes, "
                . "perf_tes = :perfTes, "
                . "chk_tes = :chkTes, "
                . "pct_hom = :pctHom, "
                . "prod_hom = :prodHom, "
                . "prof_hom = :profHom, "
                . "perf_hom = :perfHom, "
                . "chk_hom = :chkHom, "
                . "pct_impl = :pctImpl, "
                . "prod_impl = :prodImpl, "
                . "prof_impl = :profImpl, "
                . "perf_impl = :perfImpl, "
                . "chk_impl = :chkImpl, "
                . "is_f_eng = :isFEng, "
                . "desc_f_eng = :descFEng, "
                . "is_f_des = :isFDes, "
                . "desc_f_des = :descFDes, "
                . "is_f_imp = :isFImp, "
                . "desc_f_imp = :descFImp, "
                . "is_f_tes = :isFTes, "
                . "desc_f_tes = :descFTes, "
                . "is_f_hom = :isFHom, "
                . "desc_f_hom = :descFHom, "
                . "is_f_impl = :isFImpl, "
                . "desc_f_impl = :descFImpl, "
                . "expoente = :expoente,"
                . "calculado = :calculado, "
                . "tempo_desenvolvimento = :tempoDesenvolvimento, "
                . "regiao_impossivel = :regiaoImpossivel, "
                . "menor_custo = :menorCusto, "
                . "previsao_f_eng = :previsaoFEng, "
                . "previsao_f_des = :previsaoFDes, "
                . "previsao_f_imp = :previsaoFImp, "
                . "previsao_f_tes = :previsaoFTes, "
                . "previsao_f_hom = :previsaoFHom, "
                . "previsao_f_impl = :previsaoFImpl, "
                . "esforco_f_eng = :esforcoFEng, "
                . "esforco_f_des = :esforcoFDes, "
                . "esforco_f_imp = :esforcoFImp, "
                . "esforco_f_tes = :esforcoFTes, "
                . "esforco_f_hom = :esforcoFHom, "
                . "esforco_f_impl = :esforcoFImpl, "
                . "pct_pfa_eng = :pctPFAEng, "
                . "pct_pfa_des = :pctPFADes, "
                . "pct_pfa_imp = :pctPFAImp, "
                . "pct_pfa_tes = :pctPFATes, "
                . "pct_pfa_hom = :pctPFAHom, "
                . "pct_pfa_impl = :pctPFAImpl, "
                . "chk_produtividade_linguagem = :isProdutividadeLinguagem, "
                . "escala_produtividade = :escalaProdutividade, "
                . "produtividade_baixa = :produtividadeBaixa, "
                . "produtividade_media = :produtividadeMedia, "
                . "produtividade_alta = :produtividadeAlta, "
                . "hpc = :hpc, "
                . "hpa = :hpa, "
                . "fator_reducao_cronograma = :fatorReducaoCronograma, "
                . "aumento_esforco = :aumentoEsforco, "
                . "tipo_projeto = :tipoProjeto, "
                . "esforco_total = :esforcoTotal, "
                . "tamanho_pfa = :tamanhoPfa, "
                . "span_produtividade_media = :spanProdutividadeMedia, "
                . "valor_hpc = :valorHpc, "
                . "valor_hpa = :valorHpa, "
                . "custo_total = :custoTotal, "
                . "valor_pfa_contrato = :valorPfaContrato, "
                . "atualizado_por = :atualizadoPor, "
                . "ultima_atualizacao = :ultimaAtualizacao "
                . "WHERE id_contagem = :idContagem";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idContagem', $this->idContagem, PDO::PARAM_INT);
        $stm->bindParam(':previsaoInicio', $this->previsaoInicio);
        $stm->bindParam(':previsaoTermino', $this->previsaoTermino);
        $stm->bindParam(':isProdutividadeGlobal', $this->isProdutividadeGlobal, PDO::PARAM_INT);
        $stm->bindParam(':produtividadeGlobal', $this->produtividadeGlobal, PDO::PARAM_STR);
        $stm->bindParam(':hlt', $this->hlt, PDO::PARAM_STR);
        $stm->bindParam(':isFt', $this->isFt, PDO::PARAM_INT);
        $stm->bindParam(':ft', $this->ft, PDO::PARAM_STR);
        $stm->bindParam(':pctEng', $this->pctEng, PDO::PARAM_STR);
        $stm->bindParam(':prodEng', $this->prodEng, PDO::PARAM_STR);
        $stm->bindParam(':profEng', $this->profEng, PDO::PARAM_INT);
        $stm->bindParam(':perfEng', $this->perfEng, PDO::PARAM_STR);
        $stm->bindParam(':chkEng', $this->chkEng, PDO::PARAM_INT);
        $stm->bindParam(':pctDes', $this->pctDes, PDO::PARAM_STR);
        $stm->bindParam(':prodDes', $this->prodDes, PDO::PARAM_STR);
        $stm->bindParam(':profDes', $this->profDes, PDO::PARAM_INT);
        $stm->bindParam(':perfDes', $this->perfDes, PDO::PARAM_STR);
        $stm->bindParam(':chkDes', $this->chkDes, PDO::PARAM_INT);
        $stm->bindParam(':pctImp', $this->pctImp, PDO::PARAM_STR);
        $stm->bindParam(':prodImp', $this->prodImp, PDO::PARAM_STR);
        $stm->bindParam(':profImp', $this->profImp, PDO::PARAM_INT);
        $stm->bindParam(':perfImp', $this->perfImp, PDO::PARAM_STR);
        $stm->bindParam(':chkImp', $this->chkImp, PDO::PARAM_INT);
        $stm->bindParam(':pctTes', $this->pctTes, PDO::PARAM_STR);
        $stm->bindParam(':prodTes', $this->prodTes, PDO::PARAM_STR);
        $stm->bindParam(':profTes', $this->profTes, PDO::PARAM_INT);
        $stm->bindParam(':perfTes', $this->perfTes, PDO::PARAM_STR);
        $stm->bindParam(':chkTes', $this->chkTes, PDO::PARAM_INT);
        $stm->bindParam(':pctHom', $this->pctHom, PDO::PARAM_STR);
        $stm->bindParam(':prodHom', $this->prodHom, PDO::PARAM_STR);
        $stm->bindParam(':profHom', $this->profHom, PDO::PARAM_INT);
        $stm->bindParam(':perfHom', $this->perfHom, PDO::PARAM_STR);
        $stm->bindParam(':chkHom', $this->chkHom, PDO::PARAM_INT);
        $stm->bindParam(':pctImpl', $this->pctImpl, PDO::PARAM_STR);
        $stm->bindParam(':prodImpl', $this->prodImpl, PDO::PARAM_STR);
        $stm->bindParam(':profImpl', $this->profImpl, PDO::PARAM_INT);
        $stm->bindParam(':perfImpl', $this->perfImpl, PDO::PARAM_STR);
        $stm->bindParam(':chkImpl', $this->chkImpl, PDO::PARAM_INT);
        $stm->bindParam(':isFEng', $this->isFEng, PDO::PARAM_INT);
        $stm->bindParam(':descFEng', $this->descFEng, PDO::PARAM_STR);
        $stm->bindParam(':isFDes', $this->isFDes, PDO::PARAM_INT);
        $stm->bindParam(':descFDes', $this->descFDes, PDO::PARAM_STR);
        $stm->bindParam(':isFImp', $this->isFImp, PDO::PARAM_INT);
        $stm->bindParam(':descFImp', $this->descFImp, PDO::PARAM_STR);
        $stm->bindParam(':isFTes', $this->isFTes, PDO::PARAM_INT);
        $stm->bindParam(':descFTes', $this->descFTes, PDO::PARAM_STR);
        $stm->bindParam(':isFHom', $this->isFHom, PDO::PARAM_INT);
        $stm->bindParam(':descFHom', $this->descFHom, PDO::PARAM_STR);
        $stm->bindParam(':isFImpl', $this->isFImpl, PDO::PARAM_INT);
        $stm->bindParam(':descFImpl', $this->descFImpl, PDO::PARAM_STR);
        $stm->bindParam(':expoente', $this->expoente, PDO::PARAM_STR);
        $stm->bindParam(':calculado', $this->calculado, PDO::PARAM_STR);
        $stm->bindParam(':tempoDesenvolvimento', $this->tempoDesenvolvimento, PDO::PARAM_STR);
        $stm->bindParam(':regiaoImpossivel', $this->regiaoImpossivel, PDO::PARAM_STR);
        $stm->bindParam(':menorCusto', $this->menorCusto, PDO::PARAM_STR);
        $stm->bindParam(':previsaoFEng', $this->previsaoFEng, PDO::PARAM_STR);
        $stm->bindParam(':previsaoFDes', $this->previsaoFDes, PDO::PARAM_STR);
        $stm->bindParam(':previsaoFImp', $this->previsaoFImp, PDO::PARAM_STR);
        $stm->bindParam(':previsaoFTes', $this->previsaoFTes, PDO::PARAM_STR);
        $stm->bindParam(':previsaoFHom', $this->previsaoFHom, PDO::PARAM_STR);
        $stm->bindParam(':previsaoFImpl', $this->previsaoFImpl, PDO::PARAM_STR);
        $stm->bindParam(':esforcoFEng', $this->esforcoFEng, PDO::PARAM_STR);
        $stm->bindParam(':esforcoFDes', $this->esforcoFDes, PDO::PARAM_STR);
        $stm->bindParam(':esforcoFImp', $this->esforcoFImp, PDO::PARAM_STR);
        $stm->bindParam(':esforcoFTes', $this->esforcoFTes, PDO::PARAM_STR);
        $stm->bindParam(':esforcoFHom', $this->esforcoFHom, PDO::PARAM_STR);
        $stm->bindParam(':esforcoFImpl', $this->esforcoFImpl, PDO::PARAM_STR);
        $stm->bindParam(':pctPFAEng', $this->pctPFAEng, PDO::PARAM_STR);
        $stm->bindParam(':pctPFADes', $this->pctPFADes, PDO::PARAM_STR);
        $stm->bindParam(':pctPFAImp', $this->pctPFAImp, PDO::PARAM_STR);
        $stm->bindParam(':pctPFATes', $this->pctPFATes, PDO::PARAM_STR);
        $stm->bindParam(':pctPFAHom', $this->pctPFAHom, PDO::PARAM_STR);
        $stm->bindParam(':pctPFAImpl', $this->pctPFAImpl, PDO::PARAM_STR);
        $stm->bindParam(':isProdutividadeLinguagem', $this->isProdutividadeLinguagem, PDO::PARAM_INT);
        $stm->bindParam(':escalaProdutividade', $this->escalaProdutividade, PDO::PARAM_STR);
        $stm->bindParam(':produtividadeBaixa', $this->produtividadeBaixa, PDO::PARAM_STR );
        $stm->bindParam(':produtividadeMedia', $this->produtividadeMedia, PDO::PARAM_STR);
        $stm->bindParam(':produtividadeAlta', $this->produtividadeAlta, PDO::PARAM_STR);
        $stm->bindParam(':hpc', $this->hpc, PDO::PARAM_STR);
        $stm->bindParam(':hpa', $this->hpa, PDO::PARAM_STR);
        $stm->bindParam(':fatorReducaoCronograma', $this->fatorReducaoCronograma, PDO::PARAM_STR);
        $stm->bindParam(':aumentoEsforco', $this->aumentoEsforco, PDO::PARAM_STR);
        $stm->bindParam(':tipoProjeto', $this->tipoProjeto, PDO::PARAM_STR);
        $stm->bindParam(':tamanhoPfa', $this->tamanhoPfa, PDO::PARAM_STR);
        $stm->bindParam(':spanProdutividadeMedia', $this->spanProdutividadeMedia, PDO::PARAM_STR);
        $stm->bindParam(':esforcoTotal', $this->esforcoTotal, PDO::PARAM_STR);
        $stm->bindParam(':valorHpc', $this->valorHpc, PDO::PARAM_STR);
        $stm->bindParam(':valorHpa', $this->valorHpa, PDO::PARAM_STR);
        $stm->bindParam(':custoTotal', $this->custoTotal, PDO::PARAM_STR);
        $stm->bindParam(':valorPfaContrato', $this->valorPfaContrato, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor);
        return $stm->execute();
    }

    public function getTabelaFatorTecnologia($id_contagem) {
        $sql = "SELECT SUM(tbl1.qtd) AS quantidade, SUM(pfa) AS pfa, ccl.descricao, ccl.fator_tecnologia FROM "
                . "(SELECT 'EE', COUNT(id_fator_tecnologia) AS qtd, SUM(pfa) AS pfa, id_fator_tecnologia FROM ee WHERE id_contagem = $id_contagem GROUP BY id_fator_tecnologia UNION "
                . "SELECT 'SE', COUNT(id_fator_tecnologia) AS qtd, SUM(pfa) AS pfa, id_fator_tecnologia FROM se WHERE id_contagem = $id_contagem GROUP BY id_fator_tecnologia  UNION "
                . "SELECT 'CE', COUNT(id_fator_tecnologia) AS qtd, SUM(pfa) AS pfa, id_fator_tecnologia FROM ce WHERE id_contagem = $id_contagem GROUP BY id_fator_tecnologia ) AS tbl1, "
                . "contagem_config_linguagem ccl WHERE tbl1.id_fator_tecnologia = ccl.id "
                . "AND ccl.is_ft = 1 "
                . "GROUP BY ccl.descricao";
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getConfig() {
        $sql = "SELECT * FROM $this->table WHERE id_contagem = :idContagem";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idContagem', $this->idContagem, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

}
