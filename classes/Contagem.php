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
require_once DIR_CLASS . 'CRUD.php';

class Contagem extends CRUD {

    // private $idSha1;
    private $idContagem;
    private $userId;
    private $idEmpresa;
    private $idFornecedor;
    private $idCliente;
    private $idContrato;
    private $idProjeto;
    private $idLinguagem;
    private $idTipoContagem;
    private $idEtapa;
    private $idProcesso;
    private $idProcessoGestao;
    private $arrFuncoes = array(
        'ali',
        'aie',
        'ee',
        'se',
        'ce',
        'ou'
    );
    private $idPrimario;
    private $versao;
    private $idBaseline;
    private $idOrgao;
    /*
     * 1 - avulsa, 2 - projeto, 3 - baseline, 4 - licitacao
     */
    private $idAbrangencia;
    private $idBancoDados;
    private $idIndustria;
    /*
     * atributos da contagem
     */
    private $dataCadastro;
    private $entregas;
    private $proposito;
    private $escopo;
    private $ordemServico;
    /*
     * 1 - privada, 2 - publica
     */
    private $privacidade;
    /*
     * grupo de usuarios (cadastrador, auditor, validador)
     */
    private $responsavel;
    private $gerenteProjeto;
    private $auditorInterno;
    private $auditorExterno;
    private $validadorInterno;
    private $validadorExterno;
    /*
     * variavel principal que identifica em qual processo a contagem esta
     */
    private $idContagemProcesso;
    /*
     * etapas de processo (is) boolean
     */
    private $isExcluida;
    /*
     * para estatisticas das contagens que nao passarem pelo processo de validacao
     */
    private $isProcessoValidacao;
    /*
     * variavel que controla a versao atual que esta ativa
     */
    private $isVersaoAtual;
    /*
     * veriavel que verifica se alguem bloqueou a contagem para edicao
     */
    private $isBloqueada;
    private $emailBloqueio;
    private $dataBloqueio;
    /*
     * armazena a associacao entre contagens
     */
    private $idAssociada;
    /*
     * armazena data para faturamento e encerramento
     */
    private $isAutorizadaFaturamento;
    private $userIdAutorizadorFaturamento;
    private $userEmailAutorizadorFaturamento;
    private $dataAutorizadaFaturamento;
    private $isFaturada;
    private $userIdFaturador;
    private $userEmailFaturador;
    private $dataFaturada;
    private $idRoteiro;
    /*
     * contagem de auditoria
     */
    private $isContagemAuditoria;

    public function __construct() {
        $this->setTable('contagem');
        $this->setLog();
    }

    function setIdContagem($idContagem) {
        $this->idContagem = $idContagem;
    }

    public function getPrivacidade($id) {
        $stm = DB::prepare("SELECT privacidade FROM $this->table WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function getIdEmpresa($id) {
        $stm = DB::prepare("SELECT id_empresa FROM $this->table WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function getIdCliente($id) {
        $stm = DB::prepare("SELECT id_cliente FROM $this->table WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function getIdFornecedor($id) {
        $stm = DB::prepare("SELECT id_fornecedor FROM $this->table WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserId($id) {
        $stm = DB::prepare("SELECT user_id FROM $this->table WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    /**
     *
     * @param Int $id
     * @return Array (is_bloqueada, email_bloqueio, data_bloqueio)
     */
    function getIsBloqueada($id) {
        $stm = DB::prepare("SELECT is_bloqueada, email_bloqueio, data_bloqueio FROM contagem WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    // retorna o id gerador pelo id da funcao
    function getIdByFuncao($id) {
        $stm = DB::prepare("SELECT id_contagem FROM $this->table WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    function setBloqueio($id) {
        $this->isBloqueada = 1;
        $this->emailBloqueio = $_SESSION ['user_email'];
        $this->dataBloqueio = date('Y-m-d H:i:s');
        $stm = DB::prepare("UPDATE contagem SET " . "is_bloqueada = :isBloqueada, " . "email_bloqueio = :emailBloqueio, " . "data_bloqueio = :dataBloqueio " . "WHERE id = :id");
        $stm->bindParam(':isBloqueada', $this->isBloqueada, PDO::PARAM_INT);
        $stm->bindParam(':emailBloqueio', $this->emailBloqueio, PDO::PARAM_STR);
        $stm->bindParam(':dataBloqueio', $this->dataBloqueio);
        $stm->execute();
    }

    function isBaselineNaoConsolidada($idContagem) {
        $stm = DB::prepare("SELECT SUM(id) AS qtd FROM (" . "SELECT count(id) AS id FROM ali WHERE id_contagem = $idContagem AND situacao <> 2 UNION " . "SELECT count(id) AS id FROM aie WHERE id_contagem = $idContagem AND situacao <> 2 UNION " . "SELECT count(id) AS id FROM ee WHERE id_contagem = $idContagem AND situacao <> 2 UNION " . "SELECT count(id) AS id FROM se WHERE id_contagem = $idContagem AND situacao <> 2 UNION " . "SELECT count(id) AS id FROM ce WHERE id_contagem = $idContagem AND situacao <> 2 UNION " . "SELECT count(id) AS id FROM ou WHERE id_contagem = $idContagem AND situacao <> 2) AS soma");
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['qtd'] > 0 ? true : false;
    }

    function setDataCadastro($dataCadastro) {
        $this->dataCadastro = $dataCadastro;
    }

    function setVersao($versao) {
        $this->versao = $versao;
    }

    function setIdPrimario($idPrimario) {
        $this->idPrimario = $idPrimario;
    }

    function setEmailBloqueio($emailBloqueio) {
        $this->emailBloqueio = $emailBloqueio;
    }

    function setDataBloqueio($dataBloqueio) {
        $this->dataBloqueio = $dataBloqueio;
    }

    function getIsVersaoAtual($idPrimario) {
        $stm = DB::prepare("SELECT is_versao_atual FROM $this->table WHERE id_primario = :idPrimario AND is_versao_atual = 1");
        $stm->bindParam(':idPrimario', $idPrimario, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        $this->setIsVersaoAtual($linha ['is_versao_atual'] ? true : false );
        return $this->isVersaoAtual;
    }

    function setIsVersaoAtual($isVersaoAtual) {
        $this->isVersaoAtual = $isVersaoAtual;
    }

    function setIdSha1($idSha1) {
        $this->idSha1 = $idSha1;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    public function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    public function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }

    public function setIdContrato($idContrato) {
        $this->idContrato = $idContrato;
    }

    public function setIdProjeto($idProjeto) {
        $this->idProjeto = $idProjeto;
    }

    public function setIdLinguagem($idLinguagem) {
        $this->idLinguagem = $idLinguagem;
    }

    public function setIdTipoContagem($idTipoContagem) {
        $this->idTipoContagem = $idTipoContagem;
    }

    public function setIdEtapa($idEtapa) {
        $this->idEtapa = $idEtapa;
    }

    public function setIdProcesso($idProcesso) {
        $this->idProcesso = $idProcesso;
    }

    public function setIdProcessoGestao($idProcessoGestao) {
        $this->idProcessoGestao = $idProcessoGestao;
    }

    public function setIdAbrangencia($idAbrangencia) {
        $this->idAbrangencia = $idAbrangencia;
    }

    public function setIdBancoDados($idBancoDados) {
        $this->idBancoDados = $idBancoDados;
    }

    public function setIdIndustria($idIndustria) {
        $this->idIndustria = $idIndustria;
    }

    // atributos da contagem
    public function setEntregas($entregas) {
        $this->entregas = $entregas;
    }

    public function setProposito($proposito) {
        $this->proposito = $proposito;
    }

    public function setEscopo($escopo) {
        $this->escopo = $escopo;
    }

    public function setOrdemServico($ordemServico) {
        $this->ordemServico = $ordemServico;
    }

    public function setPrivacidade($privacidade) {
        $this->privacidade = $privacidade;
    }

    public function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    public function setGerenteProjeto($gerenteProjeto) {
        $this->gerenteProjeto = $gerenteProjeto;
    }

    public function setAuditorInterno($auditorInterno) {
        $this->auditorInterno = $auditorInterno;
    }

    public function setAuditorExterno($auditorExterno) {
        $this->auditorExterno = $auditorExterno;
    }

    public function setValidadorInterno($validadorInterno) {
        $this->validadorInterno = $validadorInterno;
    }

    public function setValidadorExterno($validadorExterno) {
        $this->validadorExterno = $validadorExterno;
    }

    public function setIsExcluida($idContagem) {
        $stm = DB::prepare("UPDATE $this->table SET is_excluida = 1 WHERE id = :idContagem");
        $stm->bindParam(':idContagem', $idContagem, PDO::PARAM_INT);
        return $stm->execute();
    }

    public function setIsProcessoValidacao($isProcessoValidacao) {
        $this->isProcessoValidacao = $isProcessoValidacao;
    }

    public function setIdContagemProcesso($idContagemProcesso) {
        $this->idContagemProcesso = $idContagemProcesso;
    }

    function setIdFornecedor($idFornecedor) {
        $this->idFornecedor = $idFornecedor;
    }

    function setIdAssociada($idAssociada) {
        $this->idAssociada = $idAssociada;
    }

    function setIsBloqueada($isBloqueada) {
        $this->isBloqueada = $isBloqueada;
    }

    function setIdBaseline($idBaseline) {
        $this->idBaseline = $idBaseline;
    }

    function setIdOrgao($idOrgao) {
        $this->idOrgao = $idOrgao;
    }

    function setIsAutorizadaFaturamento($isAutorizadaFaturamento) {
        $this->isAutorizadaFaturamento = $isAutorizadaFaturamento;
    }

    function setUserIdAutorizadorFaturamento($userIdAutorizadorFaturamento) {
        $this->userIdAutorizadorFaturamento = $userIdAutorizadorFaturamento;
    }

    function setUserEmailAutorizadorFaturamento($userEmailAutorizadorFaturamento) {
        $this->userEmailAutorizadorFaturamento = $userEmailAutorizadorFaturamento;
    }

    function setDataAutorizadaFaturamento($dataAutorizadaFaturamento) {
        $this->dataAutorizadaFaturamento = $dataAutorizadaFaturamento;
    }

    function setIsFaturada($isFaturada) {
        $this->isFaturada = $isFaturada;
    }

    function setUserIdFaturador($userIdFaturador) {
        $this->userIdFaturador = $userIdFaturador;
    }

    function setUserEmailFaturador($userEmailFaturador) {
        $this->userEmailFaturador = $userEmailFaturador;
    }

    function setDataFaturada($dataFaturada) {
        $this->dataFaturada = $dataFaturada;
    }

    function setIdRoteiro($idRoteiro) {
        $this->idRoteiro = $idRoteiro;
    }

    public function isContagemFornecedor($idContagem) {
        $stm = DB::prepare("SELECT id_fornecedor FROM contagem WHERE id = :id");
        $stm->bindParam(':id', $idContagem, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return ((int) $linha ['id_fornecedor'] > 0) ? 1 : 0;
    }

    function setIsContagemAuditoria($isContagemAuditoria) {
        $this->isContagemAuditoria = $isContagemAuditoria;
    }

    /**
     *
     * @param int $id
     * @return boolean true = privada
     *         false = publica
     *        
     *         public function getPrivacidade($id) {
     *         $stm = DB::prepare("SELECT privacidade FROM contagem WHERE id = :id");
     *         $stm->bindParam(':id', $id, PDO::PARAM_INT);
     *         $stm->execute();
     *         $linha = $stm->fetch(PDO::FETCH_ASSOC);
     *         return $linha['privacidade'] ? true : false;
     *         }
     *        
     */
    public function getAbrangencia($id) {
        $stm = DB::prepare("SELECT id_abrangencia FROM contagem WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    /**
     *
     * @param int $id
     *        	- id da contagem
     *        	verifica a maior entrega entre as funcionalidades cadastradas
     */
    public function verificaEntregas($id) {
        $sql = "SELECT MAX(entrega) AS entrega FROM (" . "SELECT MAX(entrega) AS entrega FROM ali WHERE id_contagem = :id " . "UNION " . "SELECT MAX(entrega) AS entrega FROM aie WHERE id_contagem = :id " . "UNION " . "SELECT MAX(entrega) AS entrega FROM ee WHERE id_contagem = :id " . "UNION " . "SELECT MAX(entrega) AS entrega FROM se WHERE id_contagem = :id " . "UNION " . "SELECT MAX(entrega) AS entrega FROM ce WHERE id_contagem = :id " . "UNION " . "SELECT MAX(entrega) AS entrega FROM ou WHERE id_contagem = :id) AS maxEntrega";
        $stm = DB::prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function insere() {
        $sql = "
        INSERT INTO $this->table (
        data_cadastro,
        id_empresa,
        id_fornecedor,
        id_cliente,
        id_contrato,
        id_projeto,
        responsavel,
        entregas,
        id_linguagem,
        id_tipo_contagem,
        id_etapa,
        id_processo,
        id_processo_gestao,
        id_banco_dados,
        id_baseline,
        id_orgao,
        proposito,
        escopo,
        id_abrangencia,
        ordem_servico,
        privacidade,
        id_industria,
        gerente_projeto,
        is_bloqueada,
        is_contagem_auditoria,
        email_bloqueio,
        data_bloqueio,
        user_id,
        id_roteiro,
        atualizado_por,
        ultima_atualizacao)                
        VALUES (
        :dataCadastro,
        :idEmpresa,
        :idFornecedor,
        :idCliente,
        :idContrato,
        :idProjeto,
        :responsavel,
        :entregas,
        :idLinguagem,
        :idTipoContagem,
        :idEtapa,
        :idProcesso,
        :idProcessoGestao,
        :idBancoDados,
        :idBaseline,
        :idOrgao,
        :proposito,
        :escopo,
        :idAbrangencia,
        :ordemServico,
        :privacidade,
        :idIndustria,
        :gerenteProjeto,
        :isBloqueada,
        :isContagemAuditoria,
        :emailBloqueio,
        :dataBloqueio,
        :userId,
        :idRoteiro,
        :atualizadoPor,
        :ultimaAtualizacao)";

        $stm = DB::prepare($sql);
        $stm->bindParam(':dataCadastro', $this->dataCadastro);
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $this->idFornecedor, PDO::PARAM_INT);
        $stm->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        $stm->bindParam(':idContrato', $this->idContrato, PDO::PARAM_INT);
        $stm->bindParam(':idProjeto', $this->idProjeto, PDO::PARAM_INT);
        $stm->bindParam(':responsavel', $this->responsavel, PDO::PARAM_STR);
        $stm->bindParam(':entregas', $this->entregas, PDO::PARAM_INT);
        $stm->bindParam(':idLinguagem', $this->idLinguagem, PDO::PARAM_INT);
        $stm->bindParam(':idTipoContagem', $this->idTipoContagem, PDO::PARAM_INT);
        $stm->bindParam(':idEtapa', $this->idEtapa, PDO::PARAM_INT);
        $stm->bindParam(':idProcesso', $this->idProcesso, PDO::PARAM_INT);
        $stm->bindParam(':idProcessoGestao', $this->idProcessoGestao, PDO::PARAM_INT);
        $stm->bindParam(':idBancoDados', $this->idBancoDados, PDO::PARAM_INT);
        $stm->bindParam(':idBaseline', $this->idBaseline, PDO::PARAM_INT);
        $stm->bindParam(':idOrgao', $this->idOrgao, PDO::PARAM_INT);
        $stm->bindParam(':proposito', $this->proposito, PDO::PARAM_STR);
        $stm->bindParam(':escopo', $this->escopo, PDO::PARAM_STR);
        $stm->bindParam(':idAbrangencia', $this->idAbrangencia, PDO::PARAM_INT);
        $stm->bindParam(':ordemServico', $this->ordemServico, PDO::PARAM_STR);
        $stm->bindParam(':privacidade', $this->privacidade, PDO::PARAM_STR);
        $stm->bindParam(':idIndustria', $this->idIndustria, PDO::PARAM_INT);
        $stm->bindParam(':gerenteProjeto', $this->gerenteProjeto, PDO::PARAM_STR);
        $stm->bindParam(':isBloqueada', $this->isBloqueada, PDO::PARAM_INT);
        $stm->bindParam(':isContagemAuditoria', $this->isContagemAuditoria, PDO::PARAM_INT);
        $stm->bindParam(':emailBloqueio', $this->emailBloqueio, PDO::PARAM_STR);
        $stm->bindParam(':dataBloqueio', $this->dataBloqueio);
        $stm->bindParam(':userId', $this->userId);
        $stm->bindParam(':idRoteiro', $this->idRoteiro, PDO::PARAM_INT);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stm->execute();
        $id = DB::getInstance()->lastInsertId();
        /*
         * atualiza o id primario que no caso e o proprio id
         * Uma contagem sofre alteracao de versao somente apos a validacao interna
         */
        $stm_id_primario = DB::prepare("UPDATE contagem SET id_primario = :id WHERE id = :id");
        $stm_id_primario->bindParam(':id', $id, PDO::PARAM_INT);
        $stm_id_primario->execute();

        return $id;
    }

    /*
     * atualiza a insercao quando for uma contagem de baseline ou licitacao
     * para nao haver processo de validacao
     */

    public function atualizaInsercaoBaseline() {
        
    }

    public function atualizaIdSha1($id) {
        $stm = DB::prepare("UPDATE $this->table SET id_sha1 = '$this->idSha1' WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
    }

    public function atualiza($id) {
        $sql = "
        UPDATE $this->table SET
        id_cliente=:idCliente,
        id_contrato=:idContrato,
        id_projeto=:idProjeto,
        responsavel=:responsavel,
        entregas=:entregas,
        id_linguagem=:idLinguagem,
        id_tipo_contagem=:idTipoContagem,
        id_etapa=:idEtapa,
        id_processo=:idProcesso,
        id_processo_gestao=:idProcessoGestao,
        id_banco_dados=:idBancoDados,
        id_baseline = :idBaseline,
        id_orgao = :idOrgao,
        proposito=:proposito,
        escopo=:escopo,
        ordem_servico=:ordemServico,
        id_industria=:idIndustria,
        gerente_projeto=:gerenteProjeto,
        privacidade=:privacidade,
        is_bloqueada=:isBloqueada,
        email_bloqueio=:emailBloqueio,
        data_bloqueio=:dataBloqueio,
        atualizado_por=:atualizadoPor,
        ultima_atualizacao=:ultimaAtualizacao
        WHERE
        id=:id";

        $stm = DB::prepare($sql);
        $stm->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        $stm->bindParam(':idContrato', $this->idContrato, PDO::PARAM_INT);
        $stm->bindParam(':idProjeto', $this->idProjeto, PDO::PARAM_INT);
        $stm->bindParam(':responsavel', $this->responsavel, PDO::PARAM_STR);
        $stm->bindParam(':entregas', $this->entregas, PDO::PARAM_INT);
        $stm->bindParam(':idLinguagem', $this->idLinguagem, PDO::PARAM_INT);
        $stm->bindParam(':idTipoContagem', $this->idTipoContagem, PDO::PARAM_INT);
        $stm->bindParam(':idEtapa', $this->idEtapa, PDO::PARAM_INT);
        $stm->bindParam(':idProcesso', $this->idProcesso, PDO::PARAM_INT);
        $stm->bindParam(':idProcessoGestao', $this->idProcessoGestao, PDO::PARAM_INT);
        $stm->bindParam(':idBancoDados', $this->idBancoDados, PDO::PARAM_INT);
        $stm->bindParam(':idBaseline', $this->idBaseline, PDO::PARAM_INT);
        $stm->bindParam(':idOrgao', $this->idOrgao, PDO::PARAM_INT);
        $stm->bindParam(':proposito', $this->proposito, PDO::PARAM_STR);
        $stm->bindParam(':escopo', $this->escopo, PDO::PARAM_STR);
        $stm->bindParam(':ordemServico', $this->ordemServico, PDO::PARAM_STR);
        $stm->bindParam(':idIndustria', $this->idIndustria, PDO::PARAM_INT);
        $stm->bindParam(':gerenteProjeto', $this->gerenteProjeto, PDO::PARAM_STR);
        $stm->bindParam(':privacidade', $this->privacidade, PDO::PARAM_INT);
        $stm->bindParam(':isBloqueada', $this->isBloqueada, PDO::PARAM_INT);
        $stm->bindParam(':emailBloqueio', $this->emailBloqueio, PDO::PARAM_STR);
        $stm->bindParam(':dataBloqueio', $this->dataBloqueio);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        return $id;
    }

    public function atualizaPrivacidade($id) {
        $stm = DB::prepare("UPDATE $this->table SET privacidade = :privacidade WHERE id = :id");
        $stm->bindParam(':privacidade', $this->privacidade, PDO::PARAM_INT);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        return $stm->execute();
    }

    /**
     *
     * @param int $idEmpresa
     * @param int $idFornecedor
     * @param string $p
     * @param string $v
     * @param string $dataInicio
     * @param string $dataFim
     * @param boolean $isGestor
     * @param boolean $isGerenteConta
     * @param boolean $isDiretor
     * @param boolean $isVisualizarContagemFornecedor
     * @param boolean $abrangencia
     * @return array
     */
    public function listaContagem($idEmpresa, $idFornecedor, $p, $v, $dataInicio = NULL, $dataFim = NULL, $isGestor = FALSE, $isGerenteConta = FALSE, $isDiretor = FALSE, $isVisualizarContagemFornecedor = FALSE, $abrangencia, $isInstrutor = FALSE, $isFiscalContrato = FALSE, $fau, $fat, $minhas, $acessos) {
        // associa o email as atribuicoes na contagem
        $email = getEmailUsuarioLogado();
        // pega o user role
        $userRole = getUserRole(true);
        $inSQL = "";
        // verifica se eh um fornecedor ou empresa
        if ($userRole === 'Auditor Interno' || $userRole === 'Auditor Externo' || $userRole === 'Validador Externo') {
            $inSQL = $userRole === 'Auditor Interno' ? " AND co.auditor_interno = '$email' " : ($userRole === 'Auditor Externo' ? " AND co.auditor_externo = '$email' " : ($userRole === 'Validador Externo' ? " AND co.validador_externo = '$email' " : " "));
            /*
             * obrigatorio verificar aqui se eh um fornecedor ou nao
             */
            if (isFornecedor()) {
                $inSQL = " AND co.id_fornecedor = :idFornecedor ";
            }
        } else if (isFornecedor()) {
            $inSQL = " AND co.id_fornecedor = :idFornecedor ";
        } else {
            if ($isGestor || $isGerenteConta || $isDiretor || $isInstrutor || $isFiscalContrato) {
                $inSQL = " AND (co.privacidade = 0 OR co.privacidade = 1)";
            } else {
                if ($isVisualizarContagemFornecedor) {
                    $inSQL = " AND (co.responsavel = '$email' OR " . "co.validador_interno = '$email' OR " . "co.validador_externo = '$email' OR " . "co.auditor_interno = '$email' OR " . "co.auditor_externo = '$email' OR " . "co.id_fornecedor >= 0)";
                } else {
                    $inSQL = " AND (co.responsavel = '$email' OR " . "co.validador_interno = '$email' OR " . "co.validador_externo = '$email' OR " . "co.auditor_interno = '$email' OR " . "co.auditor_externo = '$email' OR " . "co.id_fornecedor = 0)";
                }
            }
        }
        // verifica o parametro de pesquisa
        switch ($p) {
            case 'os' :
                $paramSQL = " AND co.ordem_servico like '%$v%'";
                break;
            case 'id' :
                $paramSQL = $v ? " AND co.id = :id " : "";
                break;
            case 'responsavel' :
                $paramSQL = " AND co.responsavel like '%$v%' ";
                break;
            case 'projeto' :
                $paramSQL = " AND prj.descricao like '%$v%' ";
                break;
            case 'cliente' :
                $paramSQL = " AND (cli.descricao like '%$v%' OR cli.sigla like '%$v%') ";
                break;
            case 'id_projeto' :
                $paramSQL = " AND co.id_projeto = $v ";
                break;
            case 'id_baseline' :
                $paramSQL = " AND co.id_baseline = $v ";
                break;
            case 'id_orgao' :
                $paramSQL = " AND co.id_orgao = $v ";
                break;
            case 'data' :
                $datas = explode(" ", $v);
                $diA = DateTime::createFromFormat('d/m/Y', $datas [0]);
                $dfA = DateTime::createFromFormat('d/m/Y', $datas [1]);
                $dfA->modify('+1 day');
                $di = $diA->format('Y-m-d');
                $df = $dfA->format('Y-m-d');
                $paramSQL = " AND co.data_cadastro BETWEEN '$di' AND '$df' ";
                break;
            case 'fornecedor' :
                $paramSQL = " AND co.id_fornecedor = '$v' ";
                break;
            default :
                $paramSQL = "";
        }
        // estabelece as datas
        if (!$p) {
            $dtIni = NULL !== $dataInicio ? $dataInicio : date('Y-m-01', strtotime("-5 month", strtotime(date('Y-m-01'))));
            $dtFim = NULL !== $dataFim ? $dataFim : date('Y-m-01', strtotime("+6 month", strtotime($dtIni)));
        }

        // monta o sql total
        $sql = "
            SELECT " . ($abrangencia === 'baseline' || $abrangencia === 'licitacao' ? 'DISTINCT' : '') . "
                co.*, ce.tamanho_pfa, " . "concat(cli.sigla, ' - ', cli.descricao) AS cliente, " . ($abrangencia === 'baseline' || $abrangencia === 'licitacao' ? $abrangencia === 'baseline' ? "'BASELINE' AS contrato, " : "'LICITACAO' AS contrato, " : "concat(con.numero, '/', con.ano) AS contrato, ") . ($abrangencia === 'baseline' || $abrangencia === 'licitacao' ? $abrangencia === 'baseline' ? "'BASELINE' AS projeto, " : "'LICITACAOO' AS projeto, " : "prj.descricao AS projeto, ") . "
                ab.tipo,
                ab.chave,
                ab.descricao
            FROM 
                contagem co, 
                contagem_estatisticas ce, " . (!($abrangencia === 'baseline' || $abrangencia === 'licitacao') ? "cliente cli, contrato con, projeto prj, contagem_abrangencia ab " : "cliente cli, contagem_abrangencia ab ") . "
            WHERE 
                co.id_empresa = :idEmpresa AND
                co.id = ce.id_contagem AND 
                co.id_cliente = cli.id AND 
                co.id_contrato = " . ($abrangencia === 'baseline' || $abrangencia === 'licitacao' ? '0' : 'con.id') . "  AND
                co.id_projeto = " . ($abrangencia === 'baseline' || $abrangencia === 'licitacao' ? '0' : 'prj.id') . "  AND " . ($abrangencia === 'baseline' || $abrangencia === 'licitacao' ? $abrangencia === 'baseline' ? 'co.id_abrangencia = 3 AND ' : 'co.id_abrangencia = 4 AND ' : '') . "
                co.id_abrangencia = ab.id AND " . ($fau ? 'co.is_autorizada_faturamento = 1 AND co.is_faturada = 0 AND ' : '') . ($fat ? 'co.is_faturada = 1 AND ' : 'co.is_faturada = 0 AND ') . ($p ? "" : " co.data_cadastro BETWEEN :dataInicio AND :dataFim AND ") . "co.is_versao_atual = 1 " . ($minhas ? "AND responsavel = '$email' " : '') . $inSQL . (!($abrangencia === 'baseline' || $abrangencia === 'licitacao') ? $paramSQL : $p === 'id' ? $paramSQL : '') . " AND co.is_excluida = 0 ORDER BY co.id DESC";
        // debug
        // return $sql;
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        // filtra pelos trinta dias iniciais apenas se na vier de um parametro
        !$p ? $stmt->bindParam(':dataInicio', $dtIni) : null;
        !$p ? $stmt->bindParam(':dataFim', $dtFim) : null;
        isFornecedor() ? $stmt->bindParam(':idFornecedor', $idFornecedor, PDO::PARAM_INT) : null;
        // && $abrangencia !== 'baseline'
        // verifica o parametro de pesquisa
        switch ($p) {
            case 'id' :
                $v ? $stmt->bindParam(':id', $v, PDO::PARAM_INT) : null;
                break;
        }
        // debug
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPFFuncoes($id, $tabela) {
        $sql = "SELECT IFNULL(SUM(pfa),0) AS pfa, 
            IFNULL(SUM(pfb),0) AS pfb, COUNT(*) AS qtd " . "FROM $tabela " . "WHERE id_contagem = $id";
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function totalPFADados($id) {
        $sql = "
        SELECT IFNULL(SUM(ali.pfa),0) AS pfa, IFNULL(SUM(ali.pfb),0) AS pfb FROM ali ali, contagem c WHERE c.id = ali.id_contagem AND c.id = :idAli
        UNION
        SELECT IFNULL(SUM(aie.pfa),0) AS pfa, IFNULL(SUM(aie.pfb),0) AS pfb FROM aie aie, contagem c WHERE c.id = aie.id_contagem AND c.id = :idAie";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':idAli', $id, PDO::PARAM_INT);
        $stmt->bindParam(':idAie', $id, PDO::PARAM_INT);
        $stmt->execute();
        $linha = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pfa = 0;
        $pfb = 0;
        foreach ($linha as $row) {
            $pfa += $row ['pfa'];
            $pfb += $row ['pfb'];
        }
        return array(
            'pfa' => $pfa,
            'pfb' => $pfb
        );
    }

    public function totalPFATransacao($id) {
        $sql = "
        SELECT IFNULL(SUM(ee.pfa),0) AS pfa, IFNULL(SUM(ee.pfb),0) AS pfb FROM ee ee, contagem c WHERE c.id = ee.id_contagem AND c.id = :idEe
        UNION
        SELECT IFNULL(SUM(se.pfa),0) AS pfa, IFNULL(SUM(se.pfb),0) AS pfb FROM se se, contagem c WHERE c.id = se.id_contagem AND c.id = :idSe
        UNION
        SELECT IFNULL(SUM(ce.pfa),0) AS pfa, IFNULL(SUM(ce.pfb),0) AS pfb FROM ce ce, contagem c WHERE c.id = ce.id_contagem AND c.id = :idCe";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':idEe', $id, PDO::PARAM_INT);
        $stmt->bindParam(':idSe', $id, PDO::PARAM_INT);
        $stmt->bindParam(':idCe', $id, PDO::PARAM_INT);
        $stmt->execute();
        $linha = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pfa = 0;
        $pfb = 0;
        foreach ($linha as $row) {
            $pfa += $row ['pfa'];
            $pfb += $row ['pfb'];
        }
        return array(
            'pfa' => $pfa,
            'pfb' => $pfb
        );
    }

    public function totalPFAOutros($id) {
        $sql = "
        SELECT IFNULL(SUM(ou.pfa),0) AS pfa, IFNULL(SUM(ou.pfa),0) AS pfb FROM ou ou, contagem c WHERE c.id = ou.id_contagem AND c.id = :idOu";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':idOu', $id, PDO::PARAM_INT);
        $stmt->execute();
        $linha = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pfa = 0;
        $pfb = 0;
        foreach ($linha as $row) {
            $pfa += $row ['pfa'];
            $pfb += $row ['pfb'];
        }
        return array(
            'pfa' => $pfa,
            'pfb' => $pfb
        );
    }

    /**
     *
     * @param Int $id
     */
    public function getDataCadastro($id) {
        $stm = DB::prepare("SELECT data_inicio " . "FROM contagem_historico " . "WHERE id_contagem = :id " . "ORDER BY id ASC");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return date_format(date_create($linha ['data_inicio']), 'd/m/Y H:i:s');
    }

    /**
     *
     * @param Int $id
     */
    public function getSiglaFornecedor($id) {
        $stm = DB::prepare("SELECT sigla " . "FROM fornecedor " . "WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['sigla'];
    }

    public function atualizaProcessoValidacaoInterna($idContagem, $op = true, $isProjeto = false) {
        $stm = DB::prepare("UPDATE contagem " . "SET is_processo_validacao = :isProcessoValidacao, " . "validador_interno = :validadorInterno " . "WHERE id = :idContagem");
        $stm->bindParam(':isProcessoValidacao', $this->isProcessoValidacao, PDO::PARAM_INT);
        $stm->bindParam(':validadorInterno', $this->validadorInterno, PDO::PARAM_STR);
        $stm->bindParam(':idContagem', $idContagem, PDO::PARAM_INT);
        $stm->execute();
        /*
         * valida todas as funcoes de dados e transacao
         */
        if ($op) {
            for ($i = 0; $i < count($this->arrFuncoes); $i ++) {
                // obrigado setar a tabela para validar a funcao em validaFuncao()
                $this->setTable($this->arrFuncoes [$i]);
                $this->validarFuncao($this->getIdsFuncoes($idContagem, $this->arrFuncoes [$i]));
            }
            // TODO: se for uma contagem de projeto tem que validar todas as funcionalidades na baseline
            // verificar se eh neste ponto que fara a execucao desta rotina
            // a validacao sera feita na consolidacao da baseline
            if ($isProjeto) {
                
            }
        }
    }

    public function atualizaProcessoValidacaoExterna($idContagem) {
        $stm = DB::prepare("UPDATE contagem SET " . "validador_externo = :validadorExterno " . "WHERE id = :idContagem");
        $stm->bindParam(':validadorExterno', $this->validadorExterno, PDO::PARAM_STR);
        $stm->bindParam(':idContagem', $idContagem, PDO::PARAM_INT);
        $stm->execute();
    }

    public function atualizaProcessoAuditoriaInterna($idContagem) {
        $stm = DB::prepare("UPDATE contagem SET " . "auditor_interno = :auditorInterno " . "WHERE id = :idContagem");
        $stm->bindParam(':auditorInterno', $this->auditorInterno, PDO::PARAM_STR);
        $stm->bindParam(':idContagem', $idContagem, PDO::PARAM_INT);
        $stm->execute();
    }

    public function atualizaProcessoAuditoriaExterna($idContagem) {
        $stm = DB::prepare("UPDATE contagem SET " . "auditor_externo = :auditorExterno " . "WHERE id = :idContagem");
        $stm->bindParam(':auditorExterno', $this->auditorExterno, PDO::PARAM_STR);
        $stm->bindParam(':idContagem', $idContagem, PDO::PARAM_INT);
        $stm->execute();
    }

    /**
     *
     * @param int $idContagem
     * @param string $funcao
     *        	ali, aie, ee ...
     */
    public function getIdsFuncoes($idContagem, $funcao) {
        $arrLinhas = [];
        $stm = DB::prepare("SELECT id FROM $funcao WHERE id_contagem = :idContagem");
        $stm->bindParam(':idContagem', $idContagem, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetchAll(PDO::FETCH_ASSOC);
        foreach ($linha as $row) {
            $arrLinhas [] = $row ['id'];
        }
        return $arrLinhas;
    }

    public function verificaFuncoesValidacao($idContagem) {
        // nem [vi] nem [ve] podem ser finalizadas se houver apontes pendentes
        // tem que enviar para revisao
        $stm = DB::prepare("" . "SELECT sum(id) AS QTD " . "FROM (" . "SELECT COUNT(ali.id) AS id FROM ali ali, contagem c WHERE c.id = ali.id_contagem AND ali.situacao IN (1, 3, 4) AND c.id = :idContagem UNION " . "SELECT COUNT(aie.id) AS id FROM aie aie, contagem c WHERE c.id = aie.id_contagem AND aie.situacao IN (1, 3, 4) AND c.id = :idContagem UNION " . "SELECT COUNT(ee.id) AS id FROM ee ee, contagem c WHERE c.id = ee.id_contagem AND ee.situacao IN (1, 3, 4) AND c.id = :idContagem UNION " . "SELECT COUNT(se.id) AS id FROM se se, contagem c WHERE c.id = se.id_contagem AND se.situacao IN (1, 3, 4) AND c.id = :idContagem UNION " . "SELECT COUNT(ce.id) AS id FROM ce ce, contagem c WHERE c.id = ce.id_contagem AND ce.situacao IN (1, 3, 4) AND c.id = :idContagem UNION " . "SELECT COUNT(ou.id) AS id FROM ou ou, contagem c WHERE c.id = ou.id_contagem AND ou.situacao IN (1, 3, 4) AND c.id = :idContagem UNION " . "SELECT COUNT(ca.id) AS id FROM contagem_apontes ca, contagem c WHERE c.id = ca.id_contagem AND ca.status = 0 AND (ca.tipo = 'vi' OR ca.tipo = 've') AND c.id = :idContagem " . ") AS resultado");
        $stm->bindParam(':idContagem', $idContagem, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['QTD'];
    }

    public function verificaFuncoesRevisao($idContagem, $email = NULL) {
        $stm = DB::prepare("" . "SELECT sum(id) AS QTD " . "FROM (" . "SELECT COUNT(ali.id) AS id FROM ali ali, contagem c WHERE c.id = ali.id_contagem AND (ali.situacao = 3 || ali.situacao = 1) AND c.id = :idContagem UNION " . "SELECT COUNT(aie.id) AS id FROM aie aie, contagem c WHERE c.id = aie.id_contagem AND (aie.situacao = 3 || aie.situacao = 1) AND c.id = :idContagem UNION " . "SELECT COUNT(ee.id) AS id FROM ee ee, contagem c WHERE c.id = ee.id_contagem AND (ee.situacao = 3 || ee.situacao = 1) AND c.id = :idContagem UNION " . "SELECT COUNT(se.id) AS id FROM se se, contagem c WHERE c.id = se.id_contagem AND (se.situacao = 3 || se.situacao = 1) AND c.id = :idContagem UNION " . "SELECT COUNT(ce.id) AS id FROM ce ce, contagem c WHERE c.id = ce.id_contagem AND (ce.situacao = 3 || ce.situacao = 1) AND c.id = :idContagem UNION " . "SELECT COUNT(ou.id) AS id FROM ou ou, contagem c WHERE c.id = ou.id_contagem AND (ou.situacao = 3 || ou.situacao = 1) AND c.id = :idContagem UNION " . "SELECT COUNT(ca.id) AS id FROM contagem_apontes ca, contagem c WHERE c.id = ca.id_contagem AND ca.status = 0 AND ca.inserido_por = '$email' AND (ca.tipo = 'vi' OR ca.tipo = 've') AND c.id = :idContagem " . ") AS resultado");
        $stm->bindParam(':idContagem', $idContagem, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['QTD'];
    }

    public function verificaFuncoesFinalizarRevisao($idContagem, $email = NULL) {
        $stm = DB::prepare("" . "SELECT sum(id) AS QTD " . "FROM (" . "SELECT COUNT(ali.id) AS id FROM ali ali, contagem c WHERE c.id = ali.id_contagem AND ali.situacao = 3 AND c.id = :idContagem UNION " . "SELECT COUNT(aie.id) AS id FROM aie aie, contagem c WHERE c.id = aie.id_contagem AND aie.situacao = 3 AND c.id = :idContagem UNION " . "SELECT COUNT(ee.id) AS id FROM ee ee, contagem c WHERE c.id = ee.id_contagem AND ee.situacao = 3 AND c.id = :idContagem UNION " . "SELECT COUNT(se.id) AS id FROM se se, contagem c WHERE c.id = se.id_contagem AND se.situacao = 3 AND c.id = :idContagem UNION " . "SELECT COUNT(ce.id) AS id FROM ce ce, contagem c WHERE c.id = ce.id_contagem AND ce.situacao = 3 AND c.id = :idContagem UNION " . "SELECT COUNT(ou.id) AS id FROM ou ou, contagem c WHERE c.id = ou.id_contagem AND ou.situacao = 3 AND c.id = :idContagem UNION " . "SELECT COUNT(ca.id) AS id FROM contagem_apontes ca, contagem c WHERE c.id = ca.id_contagem AND ca.status = 0 AND ca.destinatario = '$email' AND (ca.tipo = 'vi' OR ca.tipo = 've') AND c.id = :idContagem " . ") AS resultado");
        $stm->bindParam(':idContagem', $idContagem, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['QTD'];
    }

    /**
     * retorna o id da contagem de baseline para consultar funcoes
     *
     * @param int $idBaseline
     * @return array
     */
    public function getBaseline($idBaseline) {
        $stm = DB::prepare("SELECT * FROM $this->table WHERE id_baseline = :idBaseline AND id_abrangencia = 3");
        $stm->bindParam(':idBaseline', $idBaseline, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Esta funcao tem a responsabilidade de retornar as funcoes de contagens de baseline
     *
     * @param string $tabela
     * @param int $idBaseline
     * @param int $idContagemBaseline
     * @return array
     */
    public function getFuncaoBaseline($tabela, $idBaseline = NULL, $idContagemBaseline = NULL, $idContagemAtual = NULL) {
        /*
         * caso seja uma consulta ali-aie tem que restringir pela empresa
         */
        $idEmpresa = getIdEmpresa();
        /*
         * monta o sql separadamente
         */
        if ($tabela === 'aie' || $tabela === 'ali-aie') {
            $sql = "SELECT "
                    . "tbl.id, "
                    . "tbl.situacao, "
                    . "tbl.funcao, "
                    . "tbl.data_cadastro, "
                    . "tbl.id_contagem, "
                    . "tbl.pfa, "
                    . "tbl.pfb, "
                    . "tbl.atualizado_por, "
                    . "tbl.td AS td, tbl.tr AS tr, "
                    . "b.sigla, b.descricao, tbl.id_gerador, tbl.operacao,"
                    . "tbl.id_relacionamento, "
                    . "tbl.id_fator_tecnologia, "
                    . "tbl.valor_fator_tecnologia "
                    . "FROM ali tbl, contagem c, baseline b "
                    . "WHERE "
                    . "c.id_baseline = b.id AND "
                    . "c.id_baseline = :idBaseline AND "
                    . "tbl.id NOT IN (SELECT id_relacionamento FROM aie WHERE id_contagem = $idContagemAtual) AND "
                    . "tbl.id_contagem = c.id AND "
                    . "tbl.situacao = 2 AND "
                    . "tbl.operacao IN ('I', 'A') "
                    . "ORDER BY funcao ASC, data_cadastro DESC";
            $stm = DB::prepare($sql);
            $stm->bindParam(':idBaseline', $idBaseline, PDO::PARAM_INT);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $sql = "SELECT "
                    . "tbl.id, "
                    . "tbl.situacao, "
                    . "tbl.funcao, "
                    . "tbl.data_cadastro, "
                    . "tbl.id_contagem, "
                    . "tbl.pfa, "
                    . "tbl.pfb, "
                    . "tbl.atualizado_por, "
                    . ($tabela === 'aie' || $tabela === 'ali-aie' || $tabela === 'ali' ? "tbl.td AS td, tbl.tr AS tr, " : "tbl.td AS td, tbl.ar AS tr, ")
                    . "b.sigla, b.descricao, tbl.id_gerador, tbl.operacao, "
                    . "tbl.id_fator_tecnologia, "
                    . "tbl.valor_fator_tecnologia "
                    . "FROM " . ($tabela === 'aie' || $tabela === 'ali-aie' ? 'ali' : $tabela)
                    . " tbl, contagem c, baseline b WHERE "
                    . (NULL !== $idContagemBaseline && ($tabela === 'aie' || $tabela === 'ali-aie') ? "tbl.id_contagem <> :idContagemBaseline AND c.id_empresa = $idEmpresa AND " : " ")
                    . (NULL !== $idBaseline && $idBaseline > 0 ? "c.id_baseline = :idBaseline AND " : " ")
                    . (NULL !== $idBaseline && $idBaseline == 0 && $idContagemBaseline > 0 ? " b.id <> :idContagemBaseline AND " : " c.id_baseline = b.id AND ")
                    . "tbl.id NOT IN (SELECT id_relacionamento FROM "
                    . ($tabela === 'aie' || $tabela === 'ali-aie' ? 'ali' : $tabela)
                    . " WHERE "
                    . "id_contagem = $idContagemBaseline) AND "
                    . "tbl.id_contagem = c.id AND "
                    . "tbl.situacao = 2 AND "
                    . "tbl.operacao IN ('I', 'A') AND "
                    . "c.id_baseline = :idBaseline "
                    . "ORDER BY funcao ASC, data_cadastro DESC";
            // return $sql;
            // die();
            $stm = DB::prepare($sql);
            NULL !== $idContagemBaseline && ($tabela === 'aie' || $tabela === 'ali-aie') ? $stm->bindParam(':idContagemBaseline', $idContagemBaseline, PDO::PARAM_INT) : NULL;
            NULL !== $idBaseline && $idBaseline > 0 ? $stm->bindParam(':idBaseline', $idBaseline, PDO::PARAM_INT) : NULL;
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    /**
     * Esta funcao tem a responsabilidade de retornar as funcoes de contagens de baseline para os projetos
     *
     * @param string $tabela - tabela (ali, aie, etc)
     * @param int $idBaseline - id da baseline selecionada na combo
     * @param int $idContagemBaseline - id da baseline da contagem de projeto
     * @param int $abAtual - abrangencia da contagem 2-projeto, 3-baseline
     * @return array
     */
    public function getFuncaoBaselineProjeto($tabela, $idBaseline = NULL, $idContagem = NULL, $idBaselineContagem = NULL, $abAtual = NULL) {
        /*
         * guarda a tabela original de consulta para excluir eventuais aies inseridos em baselines
         */
        $tabela_original = $tabela;
        /*
         * caso seja uma consulta ali-aie tem que restringir pela empresa
         */
        $idEmpresa = getIdEmpresa();
        /*
         * tem que fazer tres coisas:
         * 1) se for pesquisar aie na baseline do projeto, tras os AIEs da propria baseline
         * 2) se for pesquisar aie e nao for da baseline do projeto, tras os alis da baseline pesquisada
         * 3) para as outras funcionalidades continua o mesmo processo
         */
        if ($abAtual == 2 && $tabela === 'aie') { // pesquisar os aies da propria baseline do projeto
            /*
             * o idContagem tem que mudar para saber de qual contagem de baseline virao os aies
             */
            $ids = $this->getBaseline($idBaseline);
            $idContagem = $ids ['id'];
            $idBaselineContagem = $ids ['id_baseline'];
            /*
             * se o id_baseline da contagem nao for igual o id_baseline do combo, deve trazer os alis da baseline do combo
             */
            if ($idBaselineContagem != $idBaseline) {
                $tabela = 'ali';
            }
            /*
             * monta o sql
             */
            $sql = "SELECT " . "tbl.id, " . "tbl.situacao, " . "tbl.funcao, " . "tbl.data_cadastro, " . "tbl.id_contagem, " . "tbl.pfa, " . "tbl.pfb, " . "tbl.atualizado_por, " . "tbl.td AS td, tbl.tr AS tr, " . "b.sigla, " . "b.descricao, " . "tbl.id_gerador, " . "tbl.operacao, " . "tbl.id_relacionamento, " . "tbl.id_fator_tecnologia, " . "tbl.valor_fator_tecnologia " . "FROM $tabela tbl, contagem c, baseline b WHERE " . "tbl.id_contagem = c.id AND " . "c.id_baseline = b.id AND " . "c.id_empresa = $idEmpresa AND " . "c.id_baseline = " . ($tabela === 'aie' ? $idBaselineContagem : $idBaseline) . " AND tbl.is_ativo = 1 AND tbl.id_gerador > 0 AND tbl.operacao IN ('A', 'I') AND " .
                    // retira funcoes que ja estao na contagem de baseline
                    "tbl.id NOT IN (SELECT id_relacionamento FROM " . ($tabela === 'ali' ? 'aie' : $tabela) . " WHERE id_contagem = " . ($idContagem ? $idContagem : 0) .
                    // retira aies que estao na contagem de baseline
                    ($tabela_original === 'aie' && $idBaselineContagem != $idBaseline ? " UNION SELECT a.id FROM ali a, contagem c " . "WHERE a.id_contagem = c.id AND c.id_baseline = $idBaseline) AND " : ") AND ") . "tbl.situacao = 2 AND " . "tbl.is_ativo = 1 AND " . "tbl.operacao IN ('I', 'E') " . // somente ativas no caso de uma contagem de projeto ter bloqueado a funcionalidade
                    "ORDER BY funcao ASC, data_cadastro DESC";
        } else {
            /*
             * monta o sql
             */
            $sql = "SELECT " . "tbl.id, " . "tbl.situacao, " . "tbl.funcao, " . "tbl.data_cadastro, " . "tbl.id_contagem, " . "tbl.pfa, " . "tbl.pfb, " . "tbl.atualizado_por, " . ($tabela === 'ali' || $tabela === 'aie' ? "tbl.td AS td, tbl.tr AS tr, " : "tbl.td AS td, tbl.ar AS tr, ") . "b.sigla, " . "b.descricao, " . "tbl.id_gerador, " . "tbl.operacao, " . "tbl.id_fator_tecnologia, " . "tbl.valor_fator_tecnologia " . "FROM $tabela tbl, contagem c, baseline b WHERE " . "tbl.id_contagem = c.id AND " . "c.id_baseline = b.id AND " . "c.id_empresa = $idEmpresa AND " . "c.id_baseline = $idBaselineContagem AND " . "tbl.id NOT IN (SELECT id_relacionamento FROM $tabela WHERE id_contagem = $idContagem) AND " . "tbl.situacao = 2 AND " . // somente as validadas
                    "tbl.is_ativo = 1 AND tbl.id_gerador > 0 AND tbl.operacao IN ('A', 'I') " .
                    // tambem nao seleciona mais os que foram excluidos
                    // somente os ativos por conta da anulacao nas baselines (travamento de linhas pelas contagens)
                    "ORDER BY funcao ASC, data_cadastro DESC";
        }
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Esta funcao tem a responsabilidade de retornar as funcoes de contagens de baseline para os projetos
     *
     * @param string $tabela - tabela (ali, aie, etc)
     * @param int $idBaseline - id da baseline selecionada na combo
     * @param int $idContagemBaseline - id da baseline da contagem de projeto
     * @param int $abAtual - abrangencia da contagem 2-projeto, 3-baseline
     * @return array
     */
    public function getFuncaoBaselineLivre($tabela, $idBaseline = NULL, $idContagem = NULL, $idBaselineContagem = NULL, $abAtual = NULL) {
        /*
         * guarda a tabela original de consulta para excluir eventuais aies inseridos em baselines
         */
        $tabela_original = $tabela;
        /*
         * caso seja uma consulta ali-aie tem que restringir pela empresa
         */
        $idEmpresa = getIdEmpresa();
        /*
         * tem que fazer tres coisas:
         * 1) se for pesquisar aie na baseline do projeto, tras os AIEs da propria baseline
         * 2) se for pesquisar aie e nao for da baseline do projeto, tras os alis da baseline pesquisada
         * 3) para as outras funcionalidades continua o mesmo processo
         */
        if ($abAtual == 1 && $tabela === 'aie') { // pesquisar os aies da propria baseline do projeto
            /*
             * o idContagem tem que mudar para saber de qual contagem de baseline virao os aies
             */
            $ids = $this->getBaseline($idBaseline);
            $idContagem = $ids ['id'];
            $idBaselineContagem = $ids ['id_baseline'];
            /*
             * se o id_baseline da contagem nao for igual o id_baseline do combo, deve trazer os alis da baseline do combo
             */
            if ($idBaselineContagem != $idBaseline) {
                $tabela = 'ali';
            }
            /*
             * monta o sql
             */
            $sql = "SELECT DISTINCT
                        tbl.id, 
                        tbl.situacao, 
                        tbl.funcao, 
                        tbl.data_cadastro, 
                        tbl.id_contagem, 
                        tbl.pfa, 
                        tbl.pfb, 
                        tbl.atualizado_por, 
                        tbl.td AS td, tbl.tr AS tr, 
                        b.sigla, 
                        b.descricao, 
                        tbl.id_gerador, 
                        tbl.operacao, 
                        tbl.id_relacionamento, 
                        tbl.id_fator_tecnologia, 
                        tbl.valor_fator_tecnologia 
                    FROM 
                        $tabela tbl, 
                        contagem c, 
                        baseline b 
                    WHERE 
                        tbl.id_contagem = c.id AND 
                        tbl.id_contagem = b.id AND
                        c.id_baseline = b.id AND 
                        c.id_empresa = $idEmpresa AND 
                        c.id_baseline = " . ($tabela === 'aie' ? $idBaselineContagem : $idBaseline) . " AND
                        tbl.id NOT IN (
                            SELECT 
                                id_relacionamento 
                            FROM " . ($tabela === 'ali' ? 'aie' : $tabela) . "
                            WHERE 
                                id_contagem = " . ($idContagem ? $idContagem : 0) . ($tabela_original === 'aie' && $idBaselineContagem != $idBaseline ?
                            " UNION 
                                        SELECT 
                                            a.id 
                                        FROM 
                                            ali a, 
                                            contagem c 
                                        WHERE 
                                            a.id_contagem = c.id AND 
                                            c.id_baseline = $idBaseline) AND " :
                            ") AND ") . "
                                tbl.situacao = 2 AND 
                                tbl.is_ativo = 1 AND 
                                tbl.operacao IN ('I', 'A')
                    ORDER BY 
                        funcao ASC, 
                        data_cadastro DESC";
        } else {
            /*
             * monta o sql
             */
            $sql = "SELECT 
                        tbl.id, 
                        tbl.situacao, 
                        tbl.funcao,
                        tbl.data_cadastro,
                        tbl.id_contagem,
                        tbl.pfa, 
                        tbl.pfb, 
                        tbl.atualizado_por, " . ($tabela === 'ali' || $tabela === 'aie' ? "tbl.td AS td, tbl.tr AS tr, " : "tbl.td AS td, tbl.ar AS tr, ") . "b.sigla, 
                        b.descricao, 
                        tbl.id_gerador, 
                        tbl.operacao, 
                        tbl.id_fator_tecnologia, 
                        tbl.valor_fator_tecnologia 
                    FROM $tabela tbl, contagem c, baseline b 
                    WHERE 
                        tbl.id_contagem = c.id AND
                        tbl.id_contagem = b.id AND
                        c.id_baseline = b.id AND 
                        c.id_empresa = $idEmpresa AND 
                        c.id_baseline = $idBaselineContagem AND 
                        tbl.id NOT IN (
                                SELECT 
                                    id_relacionamento 
                                FROM 
                                    $tabela 
                                WHERE 
                                    id_contagem = $idContagem) AND 
                        tbl.situacao = 2 AND
                        tbl.is_ativo = 1 AND 
                        tbl.operacao IN ('I', 'A') 
                    ORDER BY 
                        funcao ASC, data_cadastro DESC";
        }
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIdFuncaoBaseline($id, $tabela) {
        $stm = DB::prepare("SELECT id, id_baseline, id_relacionamento FROM $tabela WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function getListaFuncoes($idContagem) {
        $stm = DB::prepare("
                    SELECT 'ALI' AS tipo, funcao, ali.operacao, td as td, tr as tr, complexidade as complexidade, pfb, fator, f.fonte, f.sigla AS f_sigla, f.descricao AS f_descricao, pfa, obs_funcao, m.sigla AS m_sigla, entrega, is_mudanca, fase_mudanca, percentual_fase, fd, fe, descricao_td, descricao_tr, situacao, '' AS fator_tecnologia, id_metodo FROM ali ali, metodo m, fator_impacto f WHERE ali.id_contagem = :idContagem AND ali.impacto = f.id AND m.id = ali.id_metodo AND ali.is_ativo = 1 UNION 
                    SELECT 'AIE' AS tipo, funcao, aie.operacao, td as td, tr as tr, complexidade as complexidade, pfb, fator, f.fonte, f.sigla AS f_sigla, f.descricao AS f_descricao, pfa, obs_funcao, m.sigla AS m_sigla, entrega, is_mudanca, fase_mudanca, percentual_fase, fd, '0' AS fe, descricao_td, descricao_tr, situacao, '' AS fator_tecnologia, id_metodo FROM aie aie, metodo m, fator_impacto f WHERE aie.id_contagem = :idContagem AND aie.impacto = f.id AND m.id = aie.id_metodo AND aie.is_ativo = 1 UNION 
                    SELECT 'EE' AS tipo, funcao, ee.operacao, td as td, ar as tr, complexidade as complexidade, pfb, fator, f.fonte, f.sigla AS f_sigla, f.descricao AS f_descricao, pfa, obs_funcao, m.sigla AS m_sigla, entrega, is_mudanca, fase_mudanca, percentual_fase, fd, '0' AS fe, descricao_td, descricao_ar AS descricao_tr, situacao, lng.descricao AS fator_tecnologia, id_metodo FROM ee ee, metodo m, fator_impacto f, contagem_config_linguagem lng WHERE ee.id_contagem = :idContagem AND ee.impacto = f.id AND m.id = ee.id_metodo AND lng.id = ee.id_fator_tecnologia AND ee.is_ativo = 1 UNION 
                    SELECT 'SE' AS tipo, funcao, se.operacao, td as td, ar as tr, complexidade as complexidade, pfb, fator, f.fonte, f.sigla AS f_sigla, f.descricao AS f_descricao, pfa, obs_funcao, m.sigla AS m_sigla, entrega, is_mudanca, fase_mudanca, percentual_fase, fd, '0' AS fe, descricao_td, descricao_ar AS descricao_tr, situacao, lng.descricao AS fator_tecnologia, id_metodo FROM se se, metodo m, fator_impacto f, contagem_config_linguagem lng WHERE se.id_contagem = :idContagem AND se.impacto = f.id AND m.id = se.id_metodo AND lng.id = se.id_fator_tecnologia AND se.is_ativo = 1 UNION 
                    SELECT 'CE' AS tipo, funcao, ce.operacao, td as td, ar as tr, complexidade as complexidade, pfb, fator, f.fonte, f.sigla AS f_sigla, f.descricao AS f_descricao, pfa, obs_funcao, m.sigla AS m_sigla, entrega, is_mudanca, fase_mudanca, percentual_fase, fd, '0' AS fe, descricao_td, descricao_ar AS descricao_tr, situacao, lng.descricao AS fator_tecnologia, id_metodo FROM ce ce, metodo m, fator_impacto f, contagem_config_linguagem lng WHERE ce.id_contagem = :idContagem AND ce.impacto = f.id AND m.id = ce.id_metodo AND lng.id = ce.id_fator_tecnologia AND ce.is_ativo = 1 UNION 
                    SELECT 'OU' AS tipo, funcao, ou.operacao, qtd as td, '' as tr, '' as complexidade, pfb, fator, f.fonte, f.sigla AS f_sigla, f.descricao AS f_descricao, pfa, obs_funcao, '' AS m_sigla, entrega, '' AS is_mudanca, '' AS fase_mudanca, '' AS percentual_fase, '' AS fd, '0' AS fe, '' AS descricao_td, '' AS descricao_tr, situacao, '' AS fator_tecnologia, '0' AS id_metodo FROM ou ou, fator_impacto f WHERE ou.impacto = f.id AND id_contagem = :idContagem");
        $stm->bindParam(':idContagem', $idContagem, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Funcao que retorna as informacoes da contagem para os relatorios
     * alem dos ids traz as descricoes
     *
     * @param $idContagem
     */
    public function getContagem($idContagem, $idAbrangencia = NULL) {
        $sql = "SELECT "
                . "     cnt.data_cadastro AS CNT_data_cadastro, "
                . "     cnt.escopo AS CNT_escopo, "
                . "     cnt.proposito AS CNT_proposito, "
                . "     cnt.responsavel AS CNT_responsavel, "
                . "     cnt.entregas AS CNT_entregas, "
                . "     cnt.ordem_servico AS CNT_ordem_servico, "
                . "     cnt.id_cliente AS CNT_id_cliente, "
                . "     cnt.id_projeto AS CNT_id_projeto, "
                . "     cnt.id_empresa AS CNT_id_empresa, "
                . "     cnt.id_fornecedor AS CNT_id_fornecedor, "
                . "     cnt.id AS CNT_id, "
                . "     cnt.user_id AS CNT_user_id, "
                . "     cnt.validador_interno AS CNT_validador_interno, "
                . "     cnt.validador_externo AS CNT_validador_externo, "
                . "     cnt.auditor_interno AS CNT_auditor_interno, "
                . "     cnt.auditor_externo AS CNT_auditor_externo, "
                . "     cnt.id_abrangencia AS CNT_id_abrangencia, "
                . "     cnt.id_roteiro AS CNT_id_roteiro, "
                . ($idAbrangencia == 4 ? "'LICITAÇÃO' AS CLI_descricao, 'LIC' AS CLI_sigla, " : "cnt.id_orgao AS CNT_id_orgao, " . "cli.descricao AS CLI_descricao, ")
                . ($idAbrangencia == 3 || $idAbrangencia == 4 ? ($idAbrangencia == 3 ? "'BASELINE' AS CON_numero, cnt.id AS CON_ano, '0' AS CON_valor_pf, " : "'LICITACAO' AS CON_numero, cnt.id AS CON_ano, '0' AS CON_valor_pf, ") : "con.numero AS CON_numero, con.ano AS CON_ano, con.valor_pf AS CON_valor_pf, ")
                . ($idAbrangencia == 3 || $idAbrangencia == 4 ? $idAbrangencia == 3 ? "'BASELINE' AS PRJ_descricao, " : "'LICITACAO' AS PRJ_descricao, " : "prj.descricao AS PRJ_descricao, ")
                . "     lng.descricao AS LNG_descricao, "
                . "     tpo.descricao AS TPO_descricao, "
                . "     etp.descricao AS ETP_descricao, "
                . "     ind.descricao AS IND_descricao, "
                . "     bdo.descricao AS BDO_descricao, "
                . "     prd.descricao AS PRD_descricao, "
                . "     prg.descricao AS PRG_descricao, "
                . "     abr.chave AS ABR_chave, "
                . "     abr.descricao AS ABR_descricao "
                . ($idAbrangencia == 4 || $idAbrangencia == 3 ? ", 'N/A' AS ORG_sigla, 'N/A' AS ORG_descricao " : ", org.sigla AS ORG_sigla, " . "org.descricao AS ORG_descricao ")
                . " FROM "
                . "     contagem cnt, "
                . ($idAbrangencia == 4 ? "" : ($idAbrangencia == 3 ? "cliente cli, " : "cliente cli, contrato con, projeto prj, "))
                . "     contagem_config_linguagem lng, "
                . "     tipo_contagem tpo, "
                . "     etapa etp, "
                . "     industria ind, "
                . "     contagem_config_banco_dados bdo, "
                . "     processo prd, "
                . "     processo_gestao prg,"
                . "     contagem_abrangencia abr "
                . ($idAbrangencia == 4 || $idAbrangencia == 3 ? "" : ", orgao org ")
                . " WHERE "
                . ($idAbrangencia == 4 ? "" : ($idAbrangencia == 3 ? "cnt.id_cliente = cli.id AND " : "cnt.id_cliente = cli.id AND cnt.id_contrato = con.id AND cnt.id_projeto = prj.id AND "))
                . "     cnt.id_linguagem = lng.id AND "
                . "     cnt.id_tipo_contagem = tpo.id AND "
                . "     cnt.id_etapa = etp.id AND "
                . "     cnt.id_industria = ind.id AND "
                . "     cnt.id_banco_dados = bdo.id AND "
                . "     cnt.id_processo = prd.id AND "
                . "     cnt.id_processo_gestao = prg.id AND "
                . "     cnt.id_abrangencia = abr.id AND "
                . ($idAbrangencia == 4 || $idAbrangencia == 3 ? "" : "    cnt.id_orgao = org.id AND ")
                . "     cnt.id = :idContagem";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idContagem', $idContagem, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function getResponsavel($idContagem) {
        $stm = DB::prepare("SELECT responsavel, user_id FROM $this->table WHERE id = :idContagem");
        $stm->bindParam(':idContagem', $idContagem, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function excluiValidadores($id) {
        $stm = DB::prepare("UPDATE $this->table SET validador_interno = NULL, validador_externo = NULL WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        return $stm->execute();
    }

    public function isPermitido($idEmpresa, $idFornecedor, $idContagem) {
        $stm = DB::prepare("SELECT c.id FROM contagem c, empresa e WHERE c.id_empresa = $idEmpresa AND c.id_fornecedor = $idFornecedor AND c.id = $idContagem");
        $stm->execute();
        return $stm->columnCount() > 0 ? true : false;
    }

    public function autorizarFaturamento() {
        $sql = "UPDATE $this->table SET " . "is_autorizada_faturamento = :isAutorizadaFaturamento, " . "user_id_autorizador_faturamento = :userIdAutorizadorFaturamento, " . "user_email_autorizador_faturamento = :userEmailAutorizadorFaturamento, " . "data_autorizada_faturamento = :dataAutorizadaFaturamento " . "WHERE id = :idContagem";
        $stm = DB::prepare($sql);
        $stm->bindParam(':isAutorizadaFaturamento', $this->isAutorizadaFaturamento, PDO::PARAM_INT);
        $stm->bindParam(':userIdAutorizadorFaturamento', $this->userIdAutorizadorFaturamento, PDO::PARAM_INT);
        $stm->bindParam(':userEmailAutorizadorFaturamento', $this->userEmailAutorizadorFaturamento, PDO::PARAM_STR);
        $stm->bindParam(':dataAutorizadaFaturamento', $this->dataAutorizadaFaturamento);
        $stm->bindParam(':idContagem', $this->idContagem, PDO::PARAM_INT);
        return $stm->execute();
    }

    public function faturar() {
        $sql = "UPDATE $this->table SET " . "is_faturada = :isFaturada, " . "user_id_faturador = :userIdFaturador, " . "user_email_faturador = :userEmailFaturador, " . "data_faturada = :dataFaturada " . "WHERE id = :idContagem";
        $stm = DB::prepare($sql);
        $stm->bindParam(':isFaturada', $this->isFaturada, PDO::PARAM_INT);
        $stm->bindParam(':userIdFaturador', $this->userIdFaturador, PDO::PARAM_INT);
        $stm->bindParam(':userEmailFaturador', $this->userEmailFaturador, PDO::PARAM_STR);
        $stm->bindParam(':dataFaturada', $this->dataFaturada);
        $stm->bindParam(':idContagem', $this->idContagem, PDO::PARAM_INT);
        return $stm->execute();
    }

    public function isContagemAuditoria($idContagem) {
        $sql = "SELECT is_contagem_auditoria FROM $this->table WHERE id = $idContagem";
        $stm = DB::prepare($sql);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['is_contagem_auditoria'];
    }

    public function getClienteContratoProjeto($idContagem) {
        $sql = "SELECT 
					cli.sigla AS cliSigla, 
					cli.descricao AS cliDescricao, 
					cnt.ano AS cntAno, 
					cnt.numero AS cntNumero, 
					prj.descricao AS prjDescricao, 
					con.ordem_servico AS conOrdemServico 
				FROM 
					contagem con, 
					cliente cli, 
					contrato cnt, projeto prj 
				WHERE 
					con.id_cliente = cli.id AND 
					con.id_projeto = prj.id AND 
					con.id_contrato = cnt.id AND 
					con.id = $idContagem";
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function getIdEtapa($id) {
        $sql = "SELECT id_etapa FROM $this->table WHERE id = $id";
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    /**
     *
     * @param int $idContagem
     * @return boolean
     */
    public function atualizarBaseline($idContagem) {
        /*
         * atualizando funcao a funcao - ALI, AIE, EE, etc
         */
        $sql = "SELECT 'ALI' AS 'COL', id_gerador FROM ali WHERE id_gerador IN (SELECT id FROM ali WHERE id_contagem = :idContagem) UNION 
				SELECT 'AIE', id_gerador FROM aie WHERE id_gerador IN (SELECT id FROM aie WHERE id_contagem = :idContagem) UNION 
				SELECT 'EE', id_gerador FROM ee WHERE id_gerador IN (SELECT id FROM ee WHERE id_contagem = :idContagem) UNION 
				SELECT 'SE', id_gerador FROM se WHERE id_gerador IN (SELECT id FROM se WHERE id_contagem = :idContagem) UNION 
				SELECT 'CE', id_gerador FROM ce WHERE id_gerador IN (SELECT id FROM ce WHERE id_contagem = :idContagem) UNION 
				SELECT 'OU', id_gerador FROM ou WHERE id_gerador IN (SELECT id FROM ou WHERE id_contagem = :idContagem)";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idContagem', $idContagem, PDO::PARAM_INT);
        $stm->execute();
        $ids = $stm->fetchAll(PDO::FETCH_ASSOC);
        DEBUG_MODE ? error_log(json_encode($ids), 0) : NULL;
        /*
         * percorre todas as tabelas
         */
        foreach ($ids as $row) {
            $sqlUpdateBaseline = "UPDATE " . strtolower($row ['COL']) . " SET situacao = 2 WHERE id_gerador = '" . $row ['id_gerador'] . "'";
            DEBUG_MODE ? error_log($sqlUpdateBaseline, 0) : NULL;
            $stmUpdateBaseline = DB::prepare($sqlUpdateBaseline);
            $stmUpdateBaseline->execute();
        }
        return true;
    }

}
