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

class Cliente extends CRUD {

    private $id;
    private $idEmpresa;
    private $idFornecedor;
    private $isAtivo;
    private $isClienteEmpresa;
    private $descricao;
    private $sigla;
    private $nome;
    private $email;
    private $nome2;
    private $email2;
    private $telefone;
    private $telefone2;
    private $ramal;
    private $ramal2;
    private $uf;
    private $logomarca;

    public function __construct() {
        $this->setTable('cliente');
        $this->setLog();
    }

    function setId($id) {
        $this->id = $id;
    }

    public function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    function setIdFornecedor($idFornecedor) {
        $this->idFornecedor = $idFornecedor;
    }

    public function setIsAtivo($isAtivo) {
        $this->isAtivo = $isAtivo;
    }

    function setIsClienteEmpresa($isClienteEmpresa) {
        $this->isClienteEmpresa = $isClienteEmpresa;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setSigla($sigla) {
        $this->sigla = $sigla;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setNome2($nome2) {
        $this->nome2 = $nome2;
    }

    public function setEmail2($email2) {
        $this->email2 = $email2;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function setTelefone2($telefone2) {
        $this->telefone2 = $telefone2;
    }

    public function setRamal($ramal) {
        $this->ramal = $ramal;
    }

    public function setRamal2($ramal2) {
        $this->ramal2 = $ramal2;
    }

    function setUf($uf) {
        $this->uf = $uf;
    }

    public function setLogomarca($logomarca) {
        $this->logomarca = $logomarca;
    }

    function getSigla($id) {
        $stm = DB::prepare("SELECT sigla FROM cliente WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $sigla = $stm->fetch(PDO::FETCH_ASSOC);
        return $sigla ['sigla'];
    }

    function getDescricao($id, $table = null) {
        $stm = DB::prepare("SELECT descricao FROM cliente WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $descricao = $stm->fetch(PDO::FETCH_ASSOC);
        return $descricao ['descricao'];
    }

    function getSiglaDescricao($id) {
        $stm = DB::prepare("SELECT sigla, descricao FROM cliente WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $siglaDescricao = $stm->fetch(PDO::FETCH_ASSOC);
        return $siglaDescricao ['sigla'] . ' / ' . $siglaDescricao ['descricao'];
    }

    public function comboCliente($idEmpresa, $idFornecedor, $tipo, $idCliente = NULL) {
        $sql = "SELECT 
                    id, 
                    id_empresa, 
                    id_fornecedor, 
                    nome, 
                    descricao, 
                    sigla, 
                    telefone, 
                    email 
                FROM 
                    $this->table 
                WHERE 
                    is_ativo IN " . ($tipo === '01' ? "(0, 1)" : "(1)") . " AND 
                    id_empresa = :idEmpresa AND 
                    id_fornecedor = :idFornecedor " . (NULL !== $idCliente ? " AND id = $idCliente " : "") . " ORDER BY descricao ASC";
        // DEBUG
        DEBUG_MODE ? error_log($sql, 0) : NULL;
        DEBUG_MODE ? error_log("id_empresa: $idEmpresa, id_fornecedor: $idFornecedor, id_cliente: $idCliente", 0) : NULL;
        $stm = DB::prepare($sql);
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $idFornecedor, PDO::PARAM_INT);
        $stm->execute();
        $ret = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $ret;
    }

    public function insere() {
        $sql = "INSERT INTO $this->table (
                    id_empresa,
                    is_ativo,
                    is_cliente_empresa,
                    descricao,
                    sigla,
                    nome,
                    email,
                    nome2,
                    email2,
                    telefone,
                    telefone2,
                    ramal,
                    ramal2,
                    uf,
                    ultima_atualizacao,
                    atualizado_por) 
		VALUES (
                    :idEmpresa,
                    :isAtivo,
                    :isClienteEmpresa,
                    :descricao,
                    :sigla,
                    :nome,
                    :email,
                    :nome2,
                    :email2,
                    :telefone,
                    :telefone2,
                    :ramal,
                    :ramal2,
                    :uf,
                    :ultimaAtualizacao,
                    :atualizadoPor)";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
        $stm->bindParam(':isClienteEmpresa', $this->isClienteEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':descricao', $this->descricao, PDO::PARAM_STR);
        $stm->bindParam(':sigla', $this->sigla, PDO::PARAM_STR);
        $stm->bindParam(':nome', $this->nome, PDO::PARAM_STR);
        $stm->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stm->bindParam(':nome2', $this->nome2, PDO::PARAM_STR);
        $stm->bindParam(':email2', $this->email2, PDO::PARAM_STR);
        $stm->bindParam(':telefone', $this->telefone, PDO::PARAM_STR);
        $stm->bindParam(':telefone2', $this->telefone2, PDO::PARAM_STR);
        $stm->bindParam(':ramal', $this->ramal, PDO::PARAM_INT);
        $stm->bindParam(':ramal2', $this->ramal2, PDO::PARAM_INT);
        $stm->bindParam(':uf', $this->uf, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->execute();
        return array(
            'id' => DB::getInstance()->lastInsertId(),
            'nome' => $this->descricao,
            'msg' => 'O cliente - <strong>' . $this->descricao . '</strong> - foi INSERIDO com sucesso.'
        );
    }

    public function atualiza($id) {
        $sql = "UPDATE $this->table SET " . "is_ativo = :isAtivo, " . "descricao = :descricao, " . "sigla = :sigla, " . "nome = :nome, " . "email = :email, " . "nome2 = :nome2, " . "email2 = :email2, " . "telefone = :telefone, " . "telefone2 = :telefone2, " . "ramal = :ramal," . "ramal2 = :ramal2," . "uf = :uf, " . "ultima_atualizacao = :ultimaAtualizacao," . "atualizado_por = :atualizadoPor " . "WHERE id = :id";
        $stm = DB::prepare($sql);
        $stm->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
        $stm->bindParam(':descricao', $this->descricao, PDO::PARAM_STR);
        $stm->bindParam(':sigla', $this->sigla, PDO::PARAM_STR);
        $stm->bindParam(':nome', $this->nome, PDO::PARAM_STR);
        $stm->bindParam(':nome2', $this->nome2, PDO::PARAM_STR);
        $stm->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stm->bindParam(':email2', $this->email2, PDO::PARAM_STR);
        $stm->bindParam(':telefone', $this->telefone, PDO::PARAM_STR);
        $stm->bindParam(':telefone2', $this->telefone2, PDO::PARAM_STR);
        $stm->bindParam(':ramal', $this->ramal, PDO::PARAM_INT);
        $stm->bindParam(':ramal2', $this->ramal2, PDO::PARAM_INT);
        $stm->bindParam(':uf', $this->uf, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        return array(
            'id' => $id,
            'descricao' => $this->descricao,
            'msg' => 'O cliente - <strong>' . $this->descricao . '</strong> - foi ATUALIZADO com sucesso.',
            'nome' => $this->nome,
            'email' => $this->email,
            'telefone' => $this->telefone
        );
    }

    public function verificaAcesso($id) {
        $stm = DB::prepare("" . "SELECT cl.id_empresa, cl.id_fornecedor " . "FROM cliente cl " . "WHERE " . "cl.id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);

        return array(
            'id_empresa' => NULL !== $linha ['id_empresa'] ? $linha ['id_empresa'] : 0,
            'id_fornecedor' => NULL !== $linha ['id_fornecedor'] ? $linha ['id_fornecedor'] : 0
        );
    }

    public function getAcessoFiscalContrato($idEmpresa, $idFornecedor) {
        $sql = "SELECT id FROM $this->table WHERE id_empresa = $idEmpresa AND id_fornecedor = $idFornecedor";
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function getEmailFiscalContrato($idContagem) {
        $sql = "SELECT cli.email2 FROM $this->table cli, contagem con WHERE cli.id = con.id_cliente AND con.id = $idContagem";
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function getIdClienteEmpresa($idEmpresa) {
        $sql = "SELECT id FROM $this->table WHERE id_empresa = $idEmpresa AND is_cliente_empresa = 1";
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function getIdClienteFornecedorEmpresa() {
        if($this->idFornecedor){
            $sql = "SELECT id, descricao, sigla FROM $this->table WHERE id_fornecedor = $this->idFornecedor";
        }
        else{
            $sql = "SELECT id, descricao, sigla FROM $this->table WHERE id_empresa = $this->idEmpresa AND id_fornecedor = 0";
        }
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIdFornecedorByCliente() {
        $sql = "SELECT id_fornecedor FROM $this->table WHERE id = :id";
        $stm = DB::prepare($sql);
        $stm->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function validaIDCliente() {
        $sql = "SELECT id FROM $this->table " . "WHERE id_empresa = $this->idEmpresa AND " . "id_fornecedor = $this->idFornecedor AND " . "id = $this->id";
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetchColumn() > 0 ? TRUE : FALSE;
    }

}
