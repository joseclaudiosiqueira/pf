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
require_once DIR_CLASS . 'CRUD.php';

class Empresa extends CRUD {

    private $isAtivo;
    private $bairro;
    private $cep;
    private $cidade;
    private $cnpj;
    private $email;
    private $logradouro;
    private $nomeFantasia;
    private $sigla;
    private $telefone;
    private $tipoLogradouro;
    private $uf;
    private $nome;
    private $nome2;
    private $email2;
    private $ramal;
    private $telefone2;
    private $ramal2;

    public function __construct() {
        $this->setTable('empresa');
        $this->setLog();
    }

    function setIsAtivo($isAtivo) {
        $this->isAtivo = $isAtivo;
    }

    function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    function setCep($cep) {
        $this->cep = $cep;
    }

    function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setLogradouro($logradouro) {
        $this->logradouro = $logradouro;
    }

    function setNomeFantasia($nomeFantasia) {
        $this->nomeFantasia = $nomeFantasia;
    }

    function setSigla($sigla) {
        $this->sigla = $sigla;
    }

    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    function setTipoLogradouro($tipoLogradouro) {
        $this->tipoLogradouro = $tipoLogradouro;
    }

    function setUf($uf) {
        $this->uf = $uf;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setNome2($nome2) {
        $this->nome2 = $nome2;
    }

    function setEmail2($email2) {
        $this->email2 = $email2;
    }

    function setRamal($ramal) {
        $this->ramal = $ramal;
    }

    function setTelefone2($telefone2) {
        $this->telefone2 = $telefone2;
    }

    function setRamal2($ramal2) {
        $this->ramal2 = $ramal2;
    }

    public function getSigla($id) {
        $stm = DB::prepare("SELECT sigla FROM empresa WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $sigla = $stm->fetch(PDO::FETCH_ASSOC);
        return $sigla['sigla'];
    }

    function getSiglaNome($id) {
        $stm = DB::prepare("SELECT sigla, nome_fantasia FROM $this->table WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $siglaNome = $stm->fetch(PDO::FETCH_ASSOC);
        return $siglaNome['sigla'] . ' / ' . $siglaNome['nome_fantasia'];
    }

    public function insere() {
        /*
         * TODOS: !IMPORTANTES!
         * 1. inserir um registro na tabela empresa_config_plano
         * 2. inserir um registro na tabela contagem_config os valores padrao de mercado
         *      quantidade_maxima_entregas (40)
         *      is_processo_validacao (0)
         *      is_visualizar_roteiros_publicos (0)
         *      is_validar_adm_gestor (0)
         *      is_visualizar_sugestao_linguagem (1)
         *      produtividade_media (16)
         *      percentual_fase_iniciacao (15)
         *      percentual_fase_elaboracao (25)
         *      percentual_fase_construcao (50)
         *      percentual_fase_transicao (10)
         *      horas_liquidas_trabalhadas (8)
         *      is_gestao_projetos (0)
         * 3. inserir um registro vazio na tabela empresa_config
         * 
         */
        $stm = DB::prepare("INSERT INTO $this->table ("
                        . "is_ativo,"
                        . "bairro,"
                        . "cep,"
                        . "cidade,"
                        . "cnpj,"
                        . "email,"
                        . "logradouro,"
                        . "nome_fantasia,"
                        . "sigla,"
                        . "telefone,"
                        . "tipo_logradouro,"
                        . "uf,"
                        . "nome,"
                        . "nome2,"
                        . "email2,"
                        . "ramal,"
                        . "telefone2,"
                        . "ramal2,"
                        . "ultima_atualizacao,"
                        . "atualizado_por) VALUES ("
                        . ":isAtivo,"
                        . ":bairro,"
                        . ":cep,"
                        . ":cidade,"
                        . ":cnpj,"
                        . ":email,"
                        . ":logradouro,"
                        . ":nomeFantasia,"
                        . ":sigla,"
                        . ":telefone,"
                        . ":tipoLogradouro,"
                        . ":uf,"
                        . ":nome,"
                        . ":nome2,"
                        . ":email2,"
                        . ":ramal,"
                        . ":telefone2,"
                        . ":ramal2,"
                        . ":ultimaAtualizacao,"
                        . ":atualizadoPor)");
        $stm->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
        $stm->bindParam(':bairro', $this->bairro, PDO::PARAM_STR);
        $stm->bindParam(':cep', $this->cep, PDO::PARAM_STR);
        $stm->bindParam(':cidade', $this->cidade, PDO::PARAM_STR);
        $stm->bindParam(':cnpj', $this->cnpj, PDO::PARAM_STR);
        $stm->bindParam(':email', $this->email, PDO::PARAM_STR);
        $stm->bindParam(':logradouro', $this->logradouro, PDO::PARAM_STR);
        $stm->bindParam(':nomeFantasia', $this->nomeFantasia, PDO::PARAM_STR);
        $stm->bindParam(':sigla', $this->sigla, PDO::PARAM_STR);
        $stm->bindParam(':telefone', $this->telefone, PDO::PARAM_STR);
        $stm->bindParam(':tipoLogradouro', $this->tipoLogradouro, PDO::PARAM_STR);
        $stm->bindParam(':uf', $this->uf, PDO::PARAM_STR);
        $stm->bindParam(':nome', $this->nome, PDO::PARAM_STR);
        $stm->bindParam(':nome2', $this->nome2, PDO::PARAM_STR);
        $stm->bindParam(':email2', $this->email2, PDO::PARAM_STR);
        $stm->bindParam(':ramal', $this->ramal, PDO::PARAM_STR);
        $stm->bindParam(':telefone2', $this->telefone2, PDO::PARAM_STR);
        $stm->bindParam(':ramal2', $this->ramal2, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        /*
         * insere o registro
         */
        $stm->execute();
        /*
         * retorna o id da empresa criada
         */
        return DB::getInstance()->lastInsertId();
    }

    public function atualiza($id) {
        //
    }
    
    /**
     * 
     * @param int $idEmpresa
     * @param int $idFornecedor
     * @param string $tipo - Fornecedor ou Turma
     * @return int
     */
    public function copiaEmpresaFornecedorCliente($idEmpresa, $idFornecedor, $tipo) {
        $isClienteEmpresa = 1;
        $stm = DB::prepare("INSERT INTO cliente ("
                        . "id_empresa, "
                        . "id_fornecedor, "
                        . "is_cliente_empresa, " //eh o cliente_empresa padrao de um fornecedor 
                        . "descricao, "
                        . "sigla, "
                        . "nome, "
                        . "email, "
                        . "nome2, "
                        . "email2, "
                        . "telefone, "
                        . "telefone2, "
                        . "ramal, "
                        . "ramal2, "
                        . "ultima_atualizacao, "
                        . "atualizado_por) SELECT "
                        . "'$idEmpresa', "
                        . "'$idFornecedor', "
                        . "$isClienteEmpresa, "
                        . "nome_fantasia, "
                        . ($tipo ? "CONCAT('(TURMA) ', sigla), " : "sigla, ")//se for uma turma concatena
                        . "nome, "
                        . "email, "
                        . "nome2, "
                        . "email2, "
                        . "telefone, "
                        . "telefone2, "
                        . "ramal, "
                        . "ramal2, "
                        . "'$this->ultimaAtualizacao', "
                        . "'$this->atualizadoPor' "
                        . "FROM empresa "
                        . "WHERE id = :idEmpresa");
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->execute();
        return DB::getInstance()->lastInsertId();
    }

    function copiaLogomarcaEmpresaClienteFornecedor($idEmpresa, $idClienteFornecedor) {
        $logomarcaEmpresa = sha1($idEmpresa);
        $logomarcaClienteFornecedor = sha1($idClienteFornecedor);
        $extPng = '.png';
        $extJpg = '.jpeg';
        $fileEmpresa = DIR_BASE . 'vendor/cropper/producao/crop/img/img-emp/' . $logomarcaEmpresa . $extPng;
        $fileEmpresaOriginal = DIR_BASE . 'vendor/cropper/producao/crop/img/img-emp/' . $logomarcaEmpresa . '.original' . $extJpg;
        $fileClienteFornecedor = DIR_BASE . 'vendor/cropper/producao/crop/img/img-cli/' . $logomarcaClienteFornecedor . $extPng;
        $fileClienteFornecedorOriginal = DIR_BASE . 'vendor/cropper/producao/crop/img/img-cli/' . $logomarcaClienteFornecedor . '.original' . $extJpg;
        if (file_exists($fileEmpresa)) {
            $copiaArquivo = copy($fileEmpresa, $fileClienteFornecedor);
            if (file_exists($fileEmpresaOriginal)) {
                $copiaArquivo = copy($fileEmpresaOriginal, $fileClienteFornecedorOriginal);
            }
            $this->atualizaLogomarcaClienteFornecedor($idEmpresa, $idClienteFornecedor);
            return true;
        } else {
            return false;
        }
    }

    function atualizaLogomarcaClienteFornecedor($idEmpresa, $idClienteFornecedor) {
        $logomarcaClienteFornecedor = sha1($idClienteFornecedor);
        $stm = DB::prepare("UPDATE cliente SET logomarca = :logomarca WHERE id = :idClienteFornecedor");
        $stm->bindParam(':logomarca', $logomarcaClienteFornecedor, PDO::PARAM_STR);
        $stm->bindParam(':idClienteFornecedor', $idClienteFornecedor, PDO::PARAM_STR);
        $stm->execute();
        return true;
    }

    function _41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265() {
        $stm = DB::prepare("SELECT id, sigla FROM $this->table");
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

}
