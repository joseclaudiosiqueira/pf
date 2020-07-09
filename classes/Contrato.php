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

class Contrato extends CRUD {

    private $ano;
    private $numero;
    private $uf;
    private $idCliente;
    private $isAtivo;
    private $PFContratado;
    private $valorPF;
    private $dataInicio;
    private $dataFim;
    private $tipo; //Original ou Aditivo
    private $idPrimario; //somente para aditivos. O id_primario do contrato inicial e o proprio id
    private $valorHpc;
    private $valorHpa;

    public function __construct() {
        $this->setTable('contrato');
        $this->setLog();
    }

    public function setAno($ano) {
        $this->ano = $ano;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }
    
    function setUf($uf) {
        $this->uf = $uf;
    }

    public function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }

    public function setIsAtivo($isAtivo) {
        $this->isAtivo = $isAtivo;
    }

    function setPFContratado($PFContratado) {
        $this->PFContratado = $PFContratado;
    }

    public function setValorPF($valorPF) {
        $this->valorPF = $valorPF;
    }

    public function setDataInicio($dataInicio) {
        $this->dataInicio = $dataInicio;
    }

    public function setDataFim($dataFim) {
        $this->dataFim = $dataFim;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setIdPrimario($idPrimario) {
        $this->idPrimario = $idPrimario;
    }

    function setValorHpc($valorHpc) {
        $this->valorHpc = $valorHpc;
    }

    function setValorHpa($valorHpa) {
        $this->valorHpa = $valorHpa;
    }

    public function comboContrato($idCliente, $tipo, $isContagemAuditoria = NULL) {
        //precisa inicializar um array antes para poder selecionar os contratos que sao de fornecedores + empresa
        $arrRetorno = array();
        //pega o id empresa caso seja uma contagem de auditoria
        $idEmpresa = getIdEmpresa();
        //verifica antes se eh uma contagem de auditoria
        if ($isContagemAuditoria) {
            $sql = "SELECT con.id, con.id_cliente, con.numero, con.ano, con.uf, con.tipo, emp.sigla, cli.id_fornecedor FROM $this->table con, cliente cli, empresa emp "
                    . "WHERE con.is_ativo IN (0, 1) AND "
                    . "con.id_cliente = cli.id AND "
                    . "cli.id_empresa = emp.id AND "
                    . "emp.id = $idEmpresa "
                    . " ORDER BY sigla ASC, id_fornecedor DESC";
        } else {
            if ($tipo == '01') {
                $sql = "SELECT id, id_cliente, numero, uf, ano, tipo, '-' AS sigla FROM $this->table WHERE is_ativo IN (0, 1) AND id_cliente = $idCliente ORDER BY id ASC";
            } else {
                $sql = "SELECT id, id_cliente, numero, uf, ano, tipo, '-' AS sigla FROM $this->table WHERE is_ativo = 1 AND id_cliente = $idCliente ORDER BY id ASC";
            }
        }
        $stm = DB::prepare($sql);
        $stm->execute();
        //loop dos contratos
        $ret = $stm->fetchAll(PDO::FETCH_ASSOC);
        //sempre com um item vazio para nao dar erro no script
        $arrRetorno[] = array(
            'id' => 0,
            'numeroAno' => 'Selecione um contrato',
            'tipo' => '',
            'sigla' => '');
        if ($isContagemAuditoria) {
            foreach ($ret as $linha) {
                if ($linha['id_fornecedor'] > 0) {
                    $sql = "SELECT id, sigla, tipo FROM fornecedor WHERE id = :idFornecedor";
                    $stmSigla = DB::prepare($sql);
                    $stmSigla->bindParam(':idFornecedor', $linha['id_fornecedor']);
                    $stmSigla->execute();
                    $siglaFornecedor = $stmSigla->fetch(PDO::FETCH_ASSOC);
                    //apenas fornecedores, retirar turmas daqui
                    if (!$siglaFornecedor['tipo']) {
                        $arrRetorno[] = array('id' => $linha['id'],
                            'numeroAno' => ' [ ' . strtoupper($linha['uf']) . ' ] ' . $linha['numero'] . '/' . $linha['ano'],
                            'tipo' => '[ ' . $linha['tipo'] . ' ]',
                            'sigla' => '[ ' . $linha['tipo'] . ' ] ' . $linha['sigla'] . ' &laquo; ' . $siglaFornecedor['sigla'] . ' &raquo; ');
                    }
                } else {
                    $arrRetorno[] = array('id' => $linha['id'],
                        'numeroAno' => ' [ ' . strtoupper($linha['uf']) . ' ] ' . $linha['numero'] . '/' . $linha['ano'],
                        'tipo' => '[ ' . $linha['tipo'] . ' ]',
                        'sigla' => '[ ' . $linha['tipo'] . ' ] ' . $linha['sigla'] . ' . ');
                }
            }
            return $arrRetorno;
        } else {
            foreach ($ret as $linha) {
                $arrRetorno[] = array('id' => $linha['id'],
                    'numeroAno' => ' [ ' . strtoupper($linha['uf']) . ' ] ' . $linha['numero'] . '/' . $linha['ano'],
                    'tipo' => '[ ' . $linha['tipo'] . ' ]',
                    'sigla' => '[ ' . $linha['tipo'] . ' ] ' . $linha['sigla']);
            }
            return $arrRetorno;
        }
    }

    public function valorPFContrato($idContrato) {
        $sql = "SELECT valor_pf FROM $this->table WHERE id = :idContrato";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idContrato', $idContrato, PDO::PARAM_INT);
        $stm->execute();
        $ret = $stm->fetch(PDO::FETCH_ASSOC);
        return $ret;
    }

    public function insere() {
        $sql = "INSERT INTO $this->table (
            ano,
            numero,
            uf,
            id_cliente,
            is_ativo,
            pf_contratado,
            valor_pf,
            data_inicio,
            data_fim,
            tipo,
            id_primario,
            valor_hpc,
            valor_hpa,
            ultima_atualizacao,
            atualizado_por) 
        VALUES (
            :ano,
            :numero,
            :uf,
            :idCliente,
            :isAtivo,
            :PFContratado,
            :valorPF,
            :dataInicio,
            :dataFim,
            :tipo,
            :idPrimario,
            :valorHpc,
            :valorHpa,
            :ultimaAtualizacao,
            :atualizadoPor)";
        $stm = DB::prepare($sql);
        $stm->bindParam(':ano', $this->ano, PDO::PARAM_INT);
        $stm->bindParam(':numero', $this->numero, PDO::PARAM_STR);
        $stm->bindParam(':uf', $this->uf, PDO::PARAM_STR);
        $stm->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        $stm->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
        $stm->bindParam(':valorPF', $this->valorPF, PDO::PARAM_STR);
        $stm->bindParam(':PFContratado', $this->PFContratado, PDO::PARAM_INT);
        $stm->bindParam(':dataInicio', $this->dataInicio, PDO::PARAM_STR);
        $stm->bindParam(':dataFim', $this->dataFim, PDO::PARAM_STR);
        $stm->bindPAram(':tipo', $this->tipo, PDO::PARAM_STR);
        $stm->bindParam(':idPrimario', $this->idPrimario, PDO::PARAM_INT);
        $stm->bindParam(':valorHpc', $this->valorHpc, PDO::PARAM_STR);
        $stm->bindParam(':valorHpa', $this->valorHpa, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->execute();
        $id = DB::getInstance()->lastInsertId();
        /*
         * verifica se o idPrimario eh zero e atualiza como o propio pai (id)
         */
        if (!($this->idPrimario)) {
            $this->atualizaIdPrimario($id);
        }
        return array(
            'id' => $id,
            'msg' => 'O contrato - <strong>' . $this->numero . '/' . $this->ano . '</strong> - foi INSERIDO com sucesso.');
    }

    public function atualizaIdPrimario($id) {
        $sql = "UPDATE $this->table SET id_primario = :id WHERE id = :id";
        $stm = DB::prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
    }

    public function atualiza($id) {
        /*
         * RESTRICOES
         * - nao altera valor_pf com contagens associadas
         * - nao altera id_cliente com contagens associadas
         */
        $sql = "UPDATE $this->table SET "
                . "ano = :ano, "
                . "numero = :numero, "
                . "uf = :uf, "
                . "id_cliente = :idCliente, "
                . "is_ativo = :isAtivo, "
                . "pf_contratado = :PFContratado, "
                . "valor_pf = :valorPF, "
                . "data_inicio = :dataInicio, "
                . "data_fim = :dataFim, "
                . "tipo = :tipo, "
                . "id_primario = :idPrimario,"
                . "valor_hpc = :valorHpc, "
                . "valor_hpa = :valorHpa "
                . "WHERE id = :id";
        $stm = DB::prepare($sql);
        $stm->bindParam(':ano', $this->ano, PDO::PARAM_INT);
        $stm->bindParam(':numero', $this->numero, PDO::PARAM_STR);
        $stm->bindParam(':uf', $this->uf, PDO::PARAM_STR);
        $stm->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        $stm->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
        $stm->bindParam(':PFContratado', $this->PFContratado, PDO::PARAM_INT);
        $stm->bindParam(':valorPF', $this->valorPF, PDO::PARAM_STR);
        $stm->bindParam(':dataInicio', $this->dataInicio, PDO::PARAM_STR);
        $stm->bindParam(':dataFim', $this->dataFim, PDO::PARAM_STR);
        $stm->bindPAram(':tipo', $this->tipo, PDO::PARAM_STR);
        $stm->bindParam(':idPrimario', $this->idPrimario, PDO::PARAM_INT);
        $stm->bindParam(':valorHpc', $this->valorHpc, PDO::PARAM_STR);
        $stm->bindParam(':valorHpa', $this->valorHpa, PDO::PARAM_STR);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        return array('id' => $id, 'msg' => 'O contrato - <strong>' . $this->numero . '/' . $this->ano . '</strong> - foi atualizado com sucesso!');
    }

    public function listaContrato($id) {
        $sql = "SELECT "
                . "con.*, "
                . "cli.descricao "
                . "FROM "
                . "contrato con, "
                . "cliente cli  "
                . "WHERE "
                . "con.id_cliente = cli.id AND "
                . "con.id_cliente = :id "
                . "ORDER BY id ASC, id_primario ASC";
        $stm = DB::prepare($sql);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $linha;
    }

    public function getIdPrimario($id) {
        $sql = "SELECT id, id_primario, ano, numero FROM $this->table WHERE id = :id";
        $stm = DB::prepare($sql);
        $stm->bindPAram(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha;
    }

    public function alterarSatusContrato($id) {
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

    public function getValorHora($id) {
        $stm = DB::prepare("SELECT valor_hpc, valor_hpa, valor_pf FROM contrato WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function verificaAcesso($id) {
        $stm = DB::prepare(""
                        . "SELECT cl.id_empresa, cl.id_fornecedor "
                        . "FROM cliente cl, contrato ct "
                        . "WHERE "
                        . "ct.id_cliente = cl.id AND "
                        . "ct.id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        if ($stm->columnCount() > 0) {
            $linha = $stm->fetch(PDO::FETCH_ASSOC);
            $result = array('id_empresa' => $linha['id_empresa'], 'id_fornecedor' => $linha['id_fornecedor']);
        } else {
            $result = array('id_empresa' => 0, 'id_fornecedor' => 0);
        }
        return $result;
    }

}
