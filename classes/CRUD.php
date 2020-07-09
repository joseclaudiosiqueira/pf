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
require_once DIR_CLASS . 'DB.php';

abstract class CRUD extends DB {

    protected $table;
    protected $ultimaAtualizacao;
    protected $atualizadoPor;

    abstract public function insere();

    //abstract public function atualiza($id);

    public function setTable($table) {
        $this->table = $table;
    }

    public function setUltimaAtualizacao($ultimaAtualizacao) {
        $this->ultimaAtualizacao = $ultimaAtualizacao;
    }

    public function setAtualizadoPor($atualizadoPor) {
        $this->atualizadoPor = $atualizadoPor;
    }

    public function exclui($id) {
        /*
         * tem que excluir da baseline e da contagem de projeto
         */
        $sql = "DELETE FROM $this->table WHERE id = :id || id_gerador = :id";
        $stm = DB::prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        return $stm->execute();
    }

    public function concluirRevisaoLinha($id) {
        $sql = "UPDATE $this->table SET situacao = 4 WHERE id = :id";
        $stm = DB::prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        return $stm->execute();
    }

    /**
     * 
     * @param int $id id do objeto, generico
     * @param string $sql true ou false para fazer outro sql
     * @return array linha da tabela
     */
    public function consulta($id, $isSql = NULL, $sql = NULL, $id_primario = NULL, $funcao = NULL, $idContagem = NULL) {
        $inSql = NULL !== $isSql ? $sql : (NULL !== $funcao ? "SELECT * FROM $this->table WHERE funcao = :funcao" : "SELECT * FROM $this->table WHERE " . (NULL !== $id_primario ? $id_primario : "id" ) . " = :id");
        $stm = DB::prepare($inSql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * 
     * @param int $id id do objeto, generico
     * @param boolean $sql true ou false para fazer outro sql
     * @return array linha da tabela
     */
    public function consultaGenerica($sql) {
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function consultaGenericaFornecedor($sql) {
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function consultaClienteFornecedor($idEmpresa, $idFornecedor) {
        $sql = "SELECT * FROM $this->table WHERE id_empresa = :idEmpresa AND id_fornecedor = :idFornecedor";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $idFornecedor, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function listaFuncao($id, $tbl, $ordem = NULL, $tipo = NULL) {
        $sql = "SELECT '$tbl' AS tbl, $tbl.*, "
                . "(SELECT COUNT(c1.id) FROM comentarios c1 WHERE c1.id_externo = $tbl.id AND c1.status = 0) AS nLido, "
                . "(SELECT COUNT(c2.id) FROM comentarios c2 WHERE c2.id_externo = $tbl.id AND c2.status = 1) AS lido "
                . "FROM $this->table $tbl "
                . "LEFT JOIN comentarios c ON $tbl.id = c.id_externo AND c.tabela = '$tbl' "
                . "WHERE $tbl.id_contagem = :id AND "
                . "$tbl.is_ativo = 1 "
                . "GROUP BY $tbl.id "
                . (NULL !== $ordem ? "ORDER BY $tbl.$ordem " : "")
                . (NULL !== $tipo ? $tipo : "");
        $stm = DB::prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function siglaFator($table, $id) {
        $sql = "SELECT sigla, fator FROM $table WHERE id = :id";
        $stm = DB::prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        $sigla = $linha['sigla'];
        $fator = number_format($linha['fator'], 3);
        return $sigla . '/' . $fator;
    }

    public function consultaPFN($id) {
        $sql = "SELECT pfa, pfb FROM $this->table WHERE id = :id";
        $stm = DB::prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha;
    }

    /**
     * 
     * @param String $tabela
     * @param String $campo
     * @param Int $id
     * @param String $valor
     * @return array
     */
    public function atualizaCampo($tabela, $campo, $id, $valor) {
        $sql = "UPDATE " . strtolower($tabela) . " SET $campo = :valor WHERE id = :id";
        $stm = DB::prepare($sql);
        $stm->bindParam(':valor', $valor);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        return $stm->execute();
    }

    public function validarFuncao($id) {
        $dataValidacaoInterna = date('Y-m-d H:i:s');
        $validadorInterno = $_SESSION['user_email'];
        /*
         * recebe um ou mais ids em um array
         */
        for ($x = 0; $x < count($id); $x++) {
            $sql = "UPDATE $this->table "
                    . "SET data_validacao_interna = :dataValidacaoInterna, "
                    . "validador_interno = :validadorInterno, "
                    . "situacao = 2 "
                    . "WHERE id = :id";
            $stm = DB::prepare($sql);
            $stm->bindParam(':dataValidacaoInterna', $dataValidacaoInterna, PDO::PARAM_STR);
            $stm->bindParam(':validadorInterno', $validadorInterno, PDO::PARAM_STR);
            $stm->bindParam(':id', $id[$x], PDO::PARAM_STR);
            $stm->execute();
        }
        return true;
    }

    public function revisarFuncao($idFuncao, $userEmailExecutor, $idContagem) {
        global $objEmail;
        /*
         * recebe um ou mais ids em um array e insere as linhas na situacao 3 revisao
         */
        for ($x = 0; $x < count($idFuncao); $x++) {
            $sql = "UPDATE $this->table "
                    . "SET situacao = 3 "
                    . "WHERE id = :id";
            $stm = DB::prepare($sql);
            $stm->bindParam(':id', $idFuncao[$x], PDO::PARAM_STR);
            $stm->execute();
        }
        /*
         * seleciona os nomes das funcoes
         */
        $ids = implode(',', $idFuncao);
        $stm = DB::prepare("SELECT funcao FROM $this->table WHERE id IN (:id)");
        $stm->bindParam(':id', $ids);
        $stm->execute();
        $row = $stm->fetchAll(PDO::FETCH_ASSOC);
        $linhas = '';
        foreach ($row as $l) {
            $linhas .= $l['funcao'] . ',';
        }
        $linhas = str_replace(',', ', ', substr($linhas, 0, strlen($linhas) - 1));
        /*
         * envia email informando sobre a solicitacao de revisao nos itens
         * apenas em ambiente de producao
         */
        if (PRODUCAO) {
            emailAvisoRevisaoItensContagem($idContagem, $linhas, $userEmailExecutor, $objEmail);
        }

        return true;
    }

    public function nValidarFuncao($id) {
        /*
         * recebe um ou mais ids em um array e insere as linhas na situacao 3 revisao
         */
        for ($x = 0; $x < count($id); $x++) {
            $sql = "UPDATE $this->table "
                    . "SET situacao = 1 "
                    . "WHERE id = :id";
            $stm = DB::prepare($sql);
            $stm->bindParam(':id', $id[$x], PDO::PARAM_STR);
            $stm->execute();
        }
        return true;
    }

    public function getDescricao($id, $table) {
        $sql = "SELECT descricao FROM $table WHERE id = :id";
        $stm = DB::prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha['descricao'];
    }

    public function atualizaLogomarca($id, $logomarca, $tipo) {
        switch ($tipo) {
            case 'cli': $sql = "UPDATE $this->table SET logomarca = :logomarca WHERE id = :id";
                break;
            case 'emp': $sql = "UPDATE $this->table SET logomarca = :logomarca WHERE id_empresa = :id";
                break;
            case 'forn': $sql = "UPDATE $this->table SET logomarca = :logomarca WHERE id = :id";
        }
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':logomarca', $logomarca, PDO::PARAM_STR);
        $stmt->execute();
    }

    /*
     * grava log da ultima atualizacao nas tabelas
     */

    public function setLog() {
        $this->setUltimaAtualizacao(date('Y-m-d H:i:s'));
        $this->setAtualizadoPor(isset($_SESSION['user_email']) ? $_SESSION['user_email'] : NULL);
    }

    public function gravaLog($id) {
        $stm = DB::prepare("UPDATE $this->table SET atualizado_por = :atualizadoPor, ultima_atualizacao = :ultimaAtualizacao WHERE id = :id");
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        return $stm->execute();
    }

    /*
     * para facilitar a formatacao das datas
     */

    public function setData($data) {
        return date_format(date_create(preg_replace("/(\d+)\D+(\d+)\D+(\d+)/", "$3-$2-$1", $data)), 'Y-m-d');
    }

    /*
     * funcoes genericas para insercao de observacoes
     */

    public function atualizaObsValidadorInterno($id, $obsValidadorInterno) {
        $sql = "UPDATE $this->table SET obs_validador_interno = :obsValidadorInterno WHERE id = :id";
        $stmt = DB::prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':obsValidadorInterno', $obsValidadorInterno, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function atualizaObsValidadorExterno($id, $obsValidadorExterno) {
        $sql = "UPDATE $this->table SET obs_validador_externo = :obsValidadorExterno WHERE id = :id";
        $stmt = DB::prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':obsValidadorExterno', $obsValidadorExterno, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function atualizaObsAuditorInterno($id, $obsAuditorInterno) {
        $sql = "UPDATE $this->table SET obs_auditor_interno = :obsAuditorInterno WHERE id = :id";
        $stmt = DB::prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':obsAuditorInterno', $obsAuditorInterno, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function atualizaObsAuditorExterno($id, $obsAuditorExterno) {
        $sql = "UPDATE $this->table SET obs_auditor_externo = :obsAuditorExterno WHERE id = :id";
        $stmt = DB::prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':obsAuditorExterno', $obsAuditorExterno, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function atualizaObsRevisor($id, $obsRevisor) {
        $sql = "UPDATE $this->table SET obs_revisor = :obsRevisor WHERE id = :id";
        $stmt = DB::prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':obsRevisor', $obsRevisor, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * 
     * @param int $idContagem
     * @param int $idFuncao
     * @param string $funcao -  ali, aie, ee ...
     * 
     * funcoes booleanas idValidadaInternamente, isValidadaExternamente ...
     * 
     */
    public function isValidadaInternamente($idFuncao) {
        $stm = DB::prepare("SELECT situacao FROM $this->table WHERE id = :id");
        $stm->bindParam(':id', $idFuncao, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function isValidadaExternamente($idFuncao) {
        $stm = DB::prepare("SELECT count(*) AS isValidada FROM $this->table WHERE id = :idFuncao AND data_validacao_externa IS NULL");
        $stm->bindParam(':idFuncao', $idFuncao, PDO::PARAM_INT);
        $stm->execute();
        $dataValidacaoExterna = $stm->fetch(PDO::FETCH_ASSOC);
        return $dataValidacaoExterna['isValidada'];
    }

    public function isAuditadaInternamente($idFuncao) {
        $stm = DB::prepare("SELECT count(*) AS isValidada FROM $this->table WHERE id = :idFuncao AND data_auditoria_interna IS NULL");
        $stm->bindParam(':idFuncao', $idFuncao, PDO::PARAM_INT);
        $stm->execute();
        $dataAuditoriaInterna = $stm->fetch(PDO::FETCH_ASSOC);
        return $dataAuditoriaInterna['isValidada'];
    }

    public function isAuditadaExternamente($idFuncao) {
        $stm = DB::prepare("SELECT count(*) AS isValidada FROM $this->table WHERE id = :idFuncao AND data_auditoria_externa IS NULL");
        $stm->bindParam(':idFuncao', $idFuncao, PDO::PARAM_INT);
        $stm->execute();
        $dataAuditoriaExterna = $stm->fetch(PDO::FETCH_ASSOC);
        return $dataAuditoriaExterna['isValidada'];
    }

    public function isValidadorInterno($email, $id) {
        return $this->executaSQL($email, $id, 'validador_interno');
    }

    public function isValidadorExterno($email, $id) {
        return $this->executaSQL($email, $id, 'validador_externo');
    }

    public function isAuditorInterno($email, $id) {
        return $this->executaSQL($email, $id, 'auditor_interno');
    }

    public function isAuditorExterno($email, $id) {
        return $this->executaSQL($email, $id, 'auditor_externo');
    }

    public function isGerenteProjeto($email, $id) {
        return $this->executaSQL($email, $id, 'gerente_projeto');
    }

    public function isResponsavel($email, $id) { //responsavel pelo cadastro da contagem
        return $this->executaSQL($email, $id, 'responsavel');
    }

    public function isContagemProcessoAuditoria($id, $idProcesso) {
        $stm = DB::prepare("SELECT count(*) AS isProcesso FROM contagem_historico WHERE id = :id AND id_processo = :idProcesso AND data_fim IS NULL");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->bindParam(':idProcesso', $idProcesso, PDO::PARAM_INT);
        $stm->execute();
        $isContagemProcessoAuditoria = $stm->fetch(PDO::FETCH_ASSOC);
        return $isContagemProcessoAuditoria['isProcesso'];
    }

    /**
     * 
     * @param string $email
     * @param int $id
     * @param string $param
     * @return boolean
     */
    public function executaSQL($email, $id, $param) {
        $sql = "SELECT count(id) AS isPerfil FROM contagem WHERE $param = :email AND id = :id";
        $stm = DB::prepare($sql);
        $stm->bindParam(':email', $email, PDO::PARAM_STR);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha['isPerfil'] ? true : false;
    }

    public function validaAcessoContagem($id) {
        $email = getVariavelSessao('user_email');
        $userId = getVariavelSessao('user_id');
        /*
         * verifica em qual processo esta a contagem
         */
        $processo = $this->getContagemProcesso($id, '1, 2, 3, 6, 7, 8, 9, 10, 11');
        $idProcesso = $processo['id_processo'];
        $dataFim = NULL === $processo['data_fim'] ? true : false; //nao acabou ainda
        /*
         * auditoria interna
         */
        $processoAuditoriaInterna = $this->getContagemProcessoAuditoria($id, 4);
        $idProcessoAuditoriaInterna = $processoAuditoriaInterna['id_processo'];
        $dataFimAuditoriaInterna = NULL === $processoAuditoriaInterna['data_fim'] ? true : false; //nao acabou ainda ou nao tem processo
        /*
         * auditoria externa
         */
        $processoAuditoriaExterna = $this->getContagemProcessoAuditoria($id, 5);
        $idProcessoAuditoriaExterna = $processoAuditoriaExterna['id_processo'];
        $dataFimAuditoriaExterna = NULL === $processoAuditoriaExterna['data_fim'] ? true : false; //nao acabou ainda ou nao tem processo        
        /*
         * verifica se o usuario e um gestor
         */
        $usuario = new Usuario();
        $isGestor = getVariavelSessao('isGestor');
        $isFiscalContrato = getVariavelSessao('isFiscalContrato');
        $isFiscalContratoCliente = getVariavelSessao('isFiscalContratoCliente');
        $isFiscalContratoFornecedor = getVariavelSessao('isFiscalContratoFornecedor');
        $isFinanceiro = getVariavelSessao('isFinanceiro');
        $contagem = new Contagem();
        $consultaContagem = $contagem->consulta($id);
        /*
         * novos metodos aqui para otimizar consultas ao banco
         */
        //$isResponsavel = $this->isResponsavel($email, $id);
        //$privacidade = $contagem->getPrivacidade($id)['privacidade'];
        //$abrangencia = $contagem->getAbrangencia($id)['id_abrangencia'];
        //$idEtapa = $contagem->getIdEtapa($id)['id_etapa'];
        //$isContagemFornecedor = $contagem->isContagemFornecedor($id);
        //$idCliente = $contagem->getIdCliente($id)['id_cliente'];
        $idRoteiro = $consultaContagem['id_roteiro'];
        $isResponsavel = getEmailUsuarioLogado() === $consultaContagem['responsavel'] ? TRUE : FALSE;
        $privacidade = $consultaContagem['privacidade'];
        $abrangencia = $consultaContagem['id_abrangencia'];
        $idEtapa = $consultaContagem['id_etapa'];
        /*
         * verifica se eh uma contagem de fornecedor e desabilita os botoes VI, VE e AI
         */
        $isContagemFornecedor = (int) $consultaContagem['id_fornecedor'] > 0 ? TRUE : FALSE;
        /*
         * pega o id_cliente da contagem para o caso de validacoes externas fiscal de contrato do cliente
         */
        $idCliente = $consultaContagem['id_cliente'];
        $idClienteFiscalContrato = $usuario->getIdClienteFiscalContrato($userId);
        /*
         * verifica se eh um fornecedor
         */
        $isFornecedor = isFornecedor();
        $tipoFornecedor = 0;
        $isGestorFornecedor = 0;
        $isGerenteContaFornecedor = 0;
        $isGerenteProjetoFornecedor = 0;
        $idFornecedor = 0; //default
        /*
         * verifica a acao especial de contagens de auditoria
         */
        $isContagemAuditoria = $contagem->isContagemAuditoria($id);
        /*
         * verifica se e uma turma
         */
        if ($isFornecedor) {
            $fornecedor = new Fornecedor();
            $idFornecedor = getIdFornecedor(); //retorna da sessao
            $tipoFornecedor = $fornecedor->getTipo($idFornecedor);
            if (!($tipoFornecedor)) {//0 = fornecedor / 1 - turma
                /*
                 * ser for um gestor um fornecedor, gerente de conta, gestor e gerente de projeto tambem envia para faturamento
                 */
                $isGestorFornecedor = getVariavelSessao('isGestorFornecedor');
                $isGerenteContaFornecedor = getVariavelSessao('isGerenteContaFornecedor');
                $isGerenteProjetoFornecedor = getVariavelSessao('isGerenteProjetoFornecedor');
            } else {
                $isAluno = getVariavelSessao('isAnalistaMetricasFornecedor');
                $isInstrutor = getVariavelSessao('isInstrutor');
            }
        }
        /*
         * verifica se tem quantidades de ALIs, AIEs, etc
         */
        $listaFuncoes = $contagem->getListaFuncoes($id);
        $qtdFuncoes = count($listaFuncoes) > 0 ? TRUE : FALSE;
        /*
         * TODO: verifica se todas as funcionalidades dos projetos associados a esta baseline foram validados
         */

        /*
         * "1","Em elaboracao","Elaborada","1"
         * "2","Em validacao interna","Validada internamente","1"
         * "3","Em validacao externa","Validada externamente","1"
         * "4","Em auditoria interna","Auditada internamente","1"
         * "5","Em auditoria externa","Auditada externamente","1"
         * "6","Em revisao","Revisada","1"
         * "7","Faturada","Faturada","1"
         * "8","Em revisao<br />Validacao Interna","1"
         * "9","Em revisao<br />Validacao Externa","1"
         * 
         */
        $ret = array(
            'btn_alterar' => (($isResponsavel || $isGestor || ($isFornecedor && ($isGestorFornecedor))) && !(($idProcesso == 2 && $dataFim) || ($idProcesso == 3 && $dataFim) || $idProcesso == 6 || $idProcesso == 7 || $idProcesso == 8 || $idProcesso == 9 || $idProcesso == 11)) ? true : false,
            'btn_revisar' => (($isResponsavel || $isGestor) && ($idProcesso == 8 || $idProcesso == 9)) ? true : false,
            'btn_copiar' => ($idProcesso > 2 && $idProcesso != 6) && getPermissao('inserir_contagem') ? true : false, //todos que tem acesso podem copiar, ja que gera uma nova contagem apenas apos o processo de validacao interna
            'btn_colaborar' => ($isResponsavel && getConfigPlano('edicao_compartilhada') && $idProcesso == 1) ? false : false,
            'btn_editar' => (getConfigPlano('edicao_compartilhada') && $this->getResponsavelEdicaoCompartilhada($email, $id) && !(($idProcesso == 2 && !$dataFim) || ($idProcesso == 3 && !$dataFim) || $idProcesso == 7)) ? true : false,
            'btn_versao' => ($isResponsavel && $idProcesso != 2) ? true : false,
            'btn_excluir' => ($isResponsavel && $idProcesso == 1 && $processo['qtd_processos'] <= 1) ? true : false,
            'btn_baseline_estimativa' => ($isGestor || $isResponsavel) && $qtdFuncoes && $idEtapa == 2 ? true : false,
            'btn_atualizar_baseline' => false, //$isValidarBaseline,
            'btn_finalizar' => (($isFinanceiro || $isFiscalContrato || $isGestor || ($isFornecedor && ($isGestorFornecedor || $isGerenteProjetoFornecedor || $isGerenteContaFornecedor))) && $idProcesso == 3 && !$dataFim) || ($isGestorFornecedor && (($idProcesso == 2 || $idProcesso == 10) && !$dataFim && $isContagemAuditoria)) ? true : false,
            'btn_visualizar' => ($isFiscalContratoCliente && $idCliente == $idClienteFiscalContrato ) || ($isFornecedor && $isFiscalContratoFornecedor) || $isFiscalContrato || ($tipoFornecedor && ($isAluno || $isInstrutor)) ? true : false,
            'btn_alterar_validador_interno' => ($isGestor || ($isFornecedor && $isGestorFornecedor )) && ($idProcesso == 2 && $dataFim) ? true : false,
            'btn_alterar_validador_externo' => ($isGestor || ($isFornecedor && $isGestorFornecedor)) && ($idProcesso == 3 && $dataFim) ? true : false,
            'btn_finalizar_auditoria_interna' => ($isGestor || ($isFornecedor && $isGestorFornecedor)) && ($idProcessoAuditoriaInterna == 4 && $dataFimAuditoriaInterna) ? true : false,
            'btn_finalizar_auditoria_externa' => ($isGestor || ($isFornecedor && $isGestorFornecedor)) && ($idProcessoAuditoriaExterna == 5 && $dataFimAuditoriaExterna) ? true : false,
            'btn_alterar_gerente_projeto' => false, //$isGestor ? true : false,
            'privacidade' => $privacidade,
            'btn_privacidade' => (($isResponsavel || $isGestor) && ($idProcesso != 2 && $idProcesso != 3 && $idProcesso != 6 && $idProcesso != 8 && $idProcesso != 9)) ? true : false,
            'btn_validar_interno' => (($isGestor || ($isFornecedor && $isGestorFornecedor) || $this->isValidadorInterno($email, $id)) && $idProcesso == 2 && $dataFim) ? true : false,
            'btn_validar_externo' => ($this->isValidadorExterno($email, $id) && $idProcesso == 3 && $dataFim) ? true : false,
            'btn_auditar_interno' => ($idProcessoAuditoriaInterna == 4 && $dataFimAuditoriaInterna) && $this->isAuditorInterno($email, $id),
            'btn_auditar_externo' => ($idProcessoAuditoriaExterna == 5 && $dataFimAuditoriaExterna) && $this->isAuditorExterno($email, $id),
            'btn_empresa' => (getConfigPlano('compartilhar_contagens') && isset($_SESSION['compartilhar_empresa'])) ? true : false,
            'btn_diretorio' => (getConfigPlano('compartilhar_contagens') && isset($_SESSION['compartilhar_diretorio'])) ? true : false,
            'btn_orgao' => (getConfigPlano('compartilhar_contagens') && isset($_SESSION['compartilhar_orgao'])) ? true : false,
            'btn_exportar_pdf_resumo' => (($isResponsavel || $this->isGerenteProjeto($email, $id)) && getConfigPlano('exportar_pdf')) ? true : false,
            'btn_exportar_pdf_detalhado' => (($isResponsavel || $this->isGerenteProjeto($email, $id)) && getConfigPlano('exportar_pdf')) ? true : false,
            'btn_exportar_pdf_detalhado_estatisticas' => (($isResponsavel || $this->isGerenteProjeto($email, $id)) && getConfigPlano('exportar_pdf')) ? true : false,
            'btn_pdf' => true,
            'btn_html' => (getConfigPlano('exportar_html') && isPermitido('exportar_html') && !$tipoFornecedor) ? true : false,
            'btn_json' => (getConfigPlano('exportar_json') && isPermitido('exportar_json') && !$tipoFornecedor) ? true : false,
            'btn_xml' => (getConfigPlano('exportar_xml') && isPermitido('exportar_xml') && !$tipoFornecedor) ? true : false,
            'btn_ods' => (getConfigPlano('exportar_ods') && isPermitido('exportar_ods') && !$tipoFornecedor) ? true : false,
            'btn_xls' => (getConfigPlano('exportar_xls') && isPermitido('exportar_xls') && !$tipoFornecedor) ? true : false,
            'btn_xlsx' => (getConfigPlano('exportar_xlsx') && isPermitido('exportar_xlsx') && !$tipoFornecedor) ? true : false,
            'btn_ifpug' => (getConfigPlano('exportar_ifpug') && isPermitido('exportar_ifpug') && !$tipoFornecedor) ? true : false,
            'btn_zip' => (getConfigPlano('exportar_zip') && isPermitido('exportar_zip') && !$tipoFornecedor) ? true : false,
            'id_processo' => $idProcesso,
            'data_fim' => $dataFim,
            'qtd_processos' => $processo['qtd_processos'],
            //retira os processos 11 - Baseline Validada, 18 - baseline e 19 - licitacao
            //habilita quando houver funcoes na contagem
            'btn_validador_externo' => (((($isResponsavel || $isGestor || ($isFornecedor && $isGestorFornecedor)) && $idProcesso != 11) && $qtdFuncoes) && !(($idProcesso == 2 && $dataFim) || ($idProcesso == 3 && $dataFim) || $idProcesso == 6 || $idProcesso == 7 || $idProcesso == 8 || $idProcesso == 9)) && !($idProcesso == 1) && getConfigPlano('validacao_externa') ?
                    ((($isFornecedor && $isContagemFornecedor) ? ($abrangencia == 3 || $abrangencia == 4 ? false : true) : ((!$isFornecedor && !$isContagemFornecedor) ? ($abrangencia == 3 || $abrangencia == 4 ? false : true) : ((!$isFornecedor && $isContagemFornecedor) ? false : false)))) : false,
            'btn_auditor_interno' => (($isResponsavel || $isGestor || ($isFornecedor && $isGestorFornecedor)) && $idProcesso != 11) && $qtdFuncoes && getConfigPlano('auditoria_interna') ?
                    ((($isFornecedor && $isContagemFornecedor) ? true : ((!$isFornecedor && !$isContagemFornecedor) && !($idProcessoAuditoriaInterna == 4 && $dataFimAuditoriaInterna) ? true : ((!$isFornecedor && $isContagemFornecedor) ? false : false)))) : false,
            'btn_auditor_externo' => ($isResponsavel || $isGestor) && $qtdFuncoes && getConfigPlano('auditoria_externa') && !(isFornecedor()) && !($idProcessoAuditoriaExterna == 5 && $dataFimAuditoriaExterna) ? true : false,
            'id_cliente' => $idCliente,
            'id_roteiro' => $idRoteiro,
            'btn_fatto' => $idRoteiro == 4 ? true : false,
            'btn_fatto_nesma' => $idRoteiro == 4 ? true : false
        );
        return $ret;
    }

    /**
     * 
     * @param string $email
     * @param int $id
     * 
     * @return boolean
     */
    public function getResponsavelEdicaoCompartilhada($email, $id) {
        $stm = DB::prepare("SELECT COUNT(id) AS isPerfil FROM contagem_edicao_compartilhada WHERE id_contagem = :id AND user_email = :email");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->bindParam(':email', $email, PDO::PARAM_STR);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha['isPerfil'];
    }

    public function getContagemProcesso($id, $idProcesso) {
        /*
         * Esta funcao retorna o estagio em que a contagem se encontra
         * 
         * "1","Em elaboracao","Elaborada","1"
         * "2","Em validacao interna","Validada internamente","1"
         * "3","Em validacao externa","Validada externamente","1"
         * "4","Em auditoria interna","Auditada internamente","1"
         * "5","Em auditoria externa","Auditada externamente","1"
         * "6","Em revisao","Revisada","1"
         * "7","Faturada","Faturada","1"
         * "8","Em revisao<br />Validacao Interna","1"
         * "9","Em revisao<br />Validacao Externa","1"
         * 
         */
        $stm = DB::prepare("SELECT cp.descricao_em_andamento, cp.descricao_concluido, ch.id_processo, ch.data_fim "
                        . "FROM contagem_processo cp, contagem_historico ch "
                        . "WHERE cp.id = ch.id_processo AND "
                        . "ch.id_contagem = :id AND "
                        . "ch.id_processo IN ($idProcesso) " //apenas os processos dependentes
                        . "ORDER BY ch.id DESC");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        $qtd = $stm->fetchAll(PDO::FETCH_ASSOC);
        return array(
            'descricao_em_andamento' => $linha['descricao_em_andamento'],
            'descricao_concluido' => $linha['descricao_concluido'],
            'data_fim' => $linha['data_fim'],
            'id_processo' => $linha['id_processo'],
            'qtd_processos' => count($qtd));
    }

    public function getContagemProcessoAuditoria($id, $idProcesso) {
        /*
         * Esta funcao retorna o estagio em que a contagem se encontra
         *
         * "1","Em elaboracao","Elaborada","1"
         * "2","Em validacao interna","Validada internamente","1"
         * "3","Em validacao externa","Validada externamente","1"
         * "4","Em auditoria interna","Auditada internamente","1"
         * "5","Em auditoria externa","Auditada externamente","1"
         * "6","Em revisao","Revisada","1"
         * "7","Faturada","Faturada","1"
         * "8","Em revisao<br />Validacao Interna","1"
         * "9","Em revisao<br />Validacao Externa","1"
         *
         */
        $stm = DB::prepare("SELECT cp.descricao_em_andamento, cp.descricao_concluido, ch.id_processo, ch.data_fim "
                        . "FROM contagem_processo cp, contagem_historico ch "
                        . "WHERE cp.id = ch.id_processo AND "
                        . "ch.id_contagem = :id AND "
                        . "ch.id_processo = :idProcesso " //apenas os processos auditoria interna/externa
                        . "ORDER BY ch.id DESC");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->bindParam(':idProcesso', $idProcesso, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        $qtd = $stm->fetchAll(PDO::FETCH_ASSOC);
        return array(
            'descricao_em_andamento' => $linha['descricao_em_andamento'],
            'descricao_concluido' => $linha['descricao_concluido'],
            'data_fim' => $linha['data_fim'],
            'id_processo' => $linha['id_processo'],
            'qtd_processos' => count($qtd));
    }

    public function getArquivos($tipo, $idEmpresa) {
        $stm = DB::prepare("SELECT tbl.id, tbl.situacao, tbl.funcao, tbl.data_cadastro, tbl.id_contagem, b.sigla, tbl.id_gerador, tbl.operacao "
                        . "FROM $tipo tbl, contagem c, baseline b WHERE tbl.id_contagem IN ("
                        . "SELECT id FROM contagem WHERE id_abrangencia = 3 AND id_empresa = $idEmpresa) AND "
                        . "c.id_baseline = b.id AND "
                        . "tbl.id_contagem = c.id AND "
                        . "tbl.situacao = 2 "
                        . "ORDER BY data_cadastro DESC");
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    //retorna o id pelo id da funcao
    function getIdByDescricao($descricao, $id_contagem) {
        $stm = DB::prepare("SELECT id FROM $this->table WHERE funcao = :funcao AND id_contagem = :id_contagem");
        $stm->bindParam(':funcao', $descricao, PDO::PARAM_STR);
        $stm->bindParam(':id_contagem', $id_contagem, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    //no caso de baseline e licitacao ja insere como validada
    public function atualizaSituacao($idFuncao, $situacao) {
        $sql = "UPDATE $this->table SET situacao = :situacao WHERE id = :id";
        $stm = DB::prepare($sql);
        $stm->bindParam(':situacao', $situacao, PDO::PARAM_STR);
        $stm->bindParam(':id', $idFuncao, PDO::PARAM_INT);
        $stm->execute();
    }

    //pega o id_baseline que e o id da funcao de baseline para atualizar as duas ao mesmo tempo
    //quando validar baseline apenas coloca com is_ativa = 1 e situacao = 2 (validada)
    public function getIdFuncaoBaselineAlteracao($id) {
        $sql = "SELECT id_baseline FROM $this->table WHERE id = $id";
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

}
