<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER ['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verificacao do status do login
 */
require_once 'CRUD.php';

class ContagemFornecedorConfig extends CRUD {

    private $idEmpresa;
    private $idFornecedor;
    private $idCliente;
    private $prodFEng;
    private $prodFDes;
    private $prodFImp;
    private $prodFTes;
    private $prodFHom;
    private $prodFImpl;
    private $pctFEng;
    private $pctFDes;
    private $pctFImp;
    private $pctFTes;
    private $pctFHom;
    private $pctFImpl;
    private $isFEng;
    private $isFDes;
    private $isFImp;
    private $isFTes;
    private $isFHom;
    private $isFImpl;
    private $descFEng;
    private $descFDes;
    private $descFImp;
    private $descFTes;
    private $descFHom;
    private $descFImpl;
    private $custoCocomo;
    private $idFatorTecnologiaPadrao;
    private $isFTPadrao;
    private $etapaAtualizarBaseline;

    /**
     *
     * @param mixed $etapaAtualizarBaseline
     */
    public function setEtapaAtualizarBaseline($etapaAtualizarBaseline) {
        $this->etapaAtualizarBaseline = $etapaAtualizarBaseline;
    }

    public function __construct() {
        $this->setTable('contagem_fornecedor_config');
        $this->setLog();
    }

    function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    function setIdFornecedor($idFornecedor) {
        $this->idFornecedor = $idFornecedor;
    }

    function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }

    function setProdFEng($prodFEng) {
        $this->prodFEng = $prodFEng;
    }

    function setProdFDes($prodFDes) {
        $this->prodFDes = $prodFDes;
    }

    function setProdFImp($prodFImp) {
        $this->prodFImp = $prodFImp;
    }

    function setProdFTes($prodFTes) {
        $this->prodFTes = $prodFTes;
    }

    function setProdFHom($prodFHom) {
        $this->prodFHom = $prodFHom;
    }

    function setProdFImpl($prodFImpl) {
        $this->prodFImpl = $prodFImpl;
    }

    function setPctFEng($pctFEng) {
        $this->pctFEng = $pctFEng;
    }

    function setPctFDes($pctFDes) {
        $this->pctFDes = $pctFDes;
    }

    function setPctFImp($pctFImp) {
        $this->pctFImp = $pctFImp;
    }

    function setPctFTes($pctFTes) {
        $this->pctFTes = $pctFTes;
    }

    function setPctFHom($pctFHom) {
        $this->pctFHom = $pctFHom;
    }

    function setPctFImpl($pctFImpl) {
        $this->pctFImpl = $pctFImpl;
    }

    function setIsFEng($isFEng) {
        $this->isFEng = $isFEng;
    }

    function setIsFDes($isFDes) {
        $this->isFDes = $isFDes;
    }

    function setIsFImp($isFImp) {
        $this->isFImp = $isFImp;
    }

    function setIsFTes($isFTes) {
        $this->isFTes = $isFTes;
    }

    function setIsFHom($isFHom) {
        $this->isFHom = $isFHom;
    }

    function setIsFImpl($isFImpl) {
        $this->isFImpl = $isFImpl;
    }

    function setDescFEng($descFEng) {
        $this->descFEng = $descFEng;
    }

    function setDescFDes($descFDes) {
        $this->descFDes = $descFDes;
    }

    function setDescFImp($descFImp) {
        $this->descFImp = $descFImp;
    }

    function setDescFTes($descFTes) {
        $this->descFTes = $descFTes;
    }

    function setDescFHom($descFHom) {
        $this->descFHom = $descFHom;
    }

    function setDescFImpl($descFImpl) {
        $this->descFImpl = $descFImpl;
    }

    function setCustoCocomo($custoCocomo) {
        $this->custoCocomo = $custoCocomo;
    }

    function setIdFatorTecnologiaPadrao($idFatorTecnologiaPadrao) {
        $this->idFatorTecnologiaPadrao = $idFatorTecnologiaPadrao;
    }

    function setIsFTPadrao($isFTPadrao) {
        $this->isFTPadrao = $isFTPadrao;
    }

    public function insere() {
        //
    }

    public function atualiza() {
        $sql = "UPDATE $this->table SET
					prod_f_eng = :prodFEng, 
					prod_f_des = :prodFDes, 
					prod_f_imp = :prodFImp, 
					prod_f_tes = :prodFTes, 
					prod_f_hom = :prodFHom, 
					prod_f_impl = :prodFImpl, 
					pct_f_eng = :pctFEng, 
					pct_f_des = :pctFDes, 
					pct_f_imp = :pctFImp, 
					pct_f_tes = :pctFTes, 
					pct_f_hom = :pctFHom, 
					pct_f_impl = :pctFImpl, 
					is_f_eng = :isFEng, 
					is_f_des = :isFDes, 
					is_f_imp = :isFImp, 
					is_f_tes = :isFTes, 
					is_f_hom = :isFHom, 
					is_f_impl = :isFImpl, 
					desc_f_eng = :descFEng, 
					desc_f_des = :descFDes, 
					desc_f_imp = :descFImp, 
					desc_f_tes = :descFTes, 
					desc_f_hom = :descFHom, 
					desc_f_impl = :descFImpl, 
					custo_cocomo = :custoCocomo, 
					id_fator_tecnologia_padrao = :idFatorTecnologiaPadrao, 
					is_ft_padrao = :isFTPadrao,
					etapa_atualizar_baseline = :etapaAtualizarBaseline, 
					ultima_atualizacao = :ultimaAtualizacao, 
					atualizado_por = :atualizadoPor 
				WHERE 
					id_fornecedor = :idFornecedor AND 
					id_cliente = :idCliente";
        $stm = DB::prepare($sql);
        $stm->bindParam(':prodFEng', $this->prodFEng, PDO::PARAM_INT);
        $stm->bindParam(':prodFDes', $this->prodFDes, PDO::PARAM_INT);
        $stm->bindParam(':prodFImp', $this->prodFImp, PDO::PARAM_INT);
        $stm->bindParam(':prodFTes', $this->prodFTes, PDO::PARAM_INT);
        $stm->bindParam(':prodFHom', $this->prodFHom, PDO::PARAM_INT);
        $stm->bindParam(':prodFImpl', $this->prodFImpl, PDO::PARAM_INT);
        $stm->bindParam(':pctFEng', $this->pctFEng, PDO::PARAM_INT);
        $stm->bindParam(':pctFDes', $this->pctFDes, PDO::PARAM_INT);
        $stm->bindParam(':pctFImp', $this->pctFImp, PDO::PARAM_INT);
        $stm->bindParam(':pctFTes', $this->pctFTes, PDO::PARAM_INT);
        $stm->bindParam(':pctFHom', $this->pctFHom, PDO::PARAM_INT);
        $stm->bindParam(':pctFImpl', $this->pctFImpl, PDO::PARAM_INT);
        $stm->bindParam(':isFEng', $this->isFEng, PDO::PARAM_INT);
        $stm->bindParam(':isFDes', $this->isFDes, PDO::PARAM_INT);
        $stm->bindParam(':isFImp', $this->isFImp, PDO::PARAM_INT);
        $stm->bindParam(':isFTes', $this->isFTes, PDO::PARAM_INT);
        $stm->bindParam(':isFHom', $this->isFHom, PDO::PARAM_INT);
        $stm->bindParam(':isFImpl', $this->isFImpl, PDO::PARAM_INT);
        $stm->bindParam(':descFEng', $this->descFEng, PDO::PARAM_STR);
        $stm->bindParam(':descFDes', $this->descFDes, PDO::PARAM_STR);
        $stm->bindParam(':descFImp', $this->descFImp, PDO::PARAM_STR);
        $stm->bindParam(':descFTes', $this->descFTes, PDO::PARAM_STR);
        $stm->bindParam(':descFHom', $this->descFHom, PDO::PARAM_STR);
        $stm->bindParam(':descFImpl', $this->descFImpl, PDO::PARAM_STR);
        $stm->bindParam(':custoCocomo', $this->custoCocomo);
        $stm->bindParam(':idFatorTecnologiaPadrao', $this->idFatorTecnologiaPadrao, PDO::PARAM_INT);
        $stm->bindParam(':isFTPadrao', $this->isFTPadrao, PDO::PARAM_INT);
        $stm->bindParam(':etapaAtualizarBaseline', $this->etapaAtualizarBaseline, PDO::PARAM_INT);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':idFornecedor', $this->idFornecedor, PDO::PARAM_INT);
        $stm->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        return $stm->execute();
    }

    public function getConfig() {
        $sql = "SELECT cfc.*, cce.* " . "FROM $this->table cfc, contagem_config_empresa cce " . "WHERE " . "cfc.id_fornecedor = cce.id_fornecedor AND " . "cfc.id_fornecedor = :idFornecedor AND " . "cfc.id_cliente = :idCliente ";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idFornecedor', $this->idFornecedor, PDO::PARAM_INT);
        $stm->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    /**
     *
     * @param int $idContagem
     * @return boolean[]|mixed[]
     */
    public function getEtapaAtualizarBaseline($idContagem) {
        $contagem = new Contagem ();
        /*
         * id empresa e id cliente vem da contagem
         */
        $idCliente = $contagem->getIdCliente($idContagem) ['id_cliente'];
        $idEmpresa = $contagem->getIdEmpresa($idContagem) ['id_empresa'];
        $idFornecedor = $contagem->getIdFornecedor($idContagem) ['id_fornecedor'];
        /*
         * o restante dos ids vem de contagem config
         */
        $contagem_fornecedor_config = new ContagemFornecedorConfig ();

        /*
         * para a contagem config set os ids de cliente e empresa
         */
        $contagem_fornecedor_config->setIdEmpresa($idEmpresa);
        $contagem_fornecedor_config->setIdCliente($idCliente);
        $contagem_fornecedor_config->setIdFornecedor($idFornecedor);
        /*
         * finaliza a contagem
         */
        $etapaAtualizarBaseline = $contagem_fornecedor_config->getConfig() ['etapa_atualizar_baseline'];
        /*
         * pega a abrangencia para verificar se atualiza ou nao as baselines
         */
        $abrangencia = $contagem->getAbrangencia($idContagem) ['id_abrangencia'];
        /*
         * neste ponto caso a selecao na configuracao seja para atualizar as baselines
         * na classe Contagem - atualiza por aqui porque eh o mais logico, na contagem
         * executar apenas em projetos (Abrangencia = 2)
         */
        return array(
            'abrangencia' => $abrangencia,
            'etapa_atualizar_baseline' => $etapaAtualizarBaseline
        );
    }

}
