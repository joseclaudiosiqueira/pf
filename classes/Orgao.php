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

class Orgao extends CRUD {

    private $idEmpresa;
    private $idCliente;
    private $sigla;
    private $descricao;
    private $isAtivo;
    private $isEditavel;
    private $superior;
    private $LFT;
    private $RGT;
    private $userId;

    public function __construct() {
        $this->setTable('orgao');
        $this->setLog();
    }

    function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }

    function setSigla($sigla) {
        $this->sigla = $sigla;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setIsAtivo($isAtivo) {
        $this->isAtivo = $isAtivo;
    }

    function setIsEditavel($isEditavel) {
        $this->isEditavel = $isEditavel;
    }

    function setSuperior($superior) {
        $this->superior = $superior;
    }

    function setLFT($LFT) {
        $this->LFT = $LFT;
    }

    function setRGT($RGT) {
        $this->RGT = $RGT;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    //TODO: ver coisas de cadastro de orgaos para clientes e para empresa
    //criar um orgao quando criar um cliente quando for empresa cadastrando cliente
    //nao criar quando for um fornecedor cadastrando um cliente
    //ver na selecao quando for empresa contando colocando cliente tem que selecionar o orgao
    //cuidado quando for empresa que cadastra cliente e essa empresa for o proprio orgao
    public function insere() {
        $stm = DB::prepare("INSERT INTO $this->table ("
                        . "id_empresa, "
                        . "id_cliente, "
                        . "sigla, "
                        . "descricao, "
                        . "is_ativo, "
                        . "is_editavel, "
                        . "superior, "
                        . "lft, "
                        . "rgt, "
                        . "user_id, "
                        . "atualizado_por, "
                        . "ultima_atualizacao) "
                        . "VALUES ("
                        . ":idEmpresa, "
                        . ":idCliente, "
                        . ":sigla, "
                        . ":descricao, "
                        . ":isAtivo, "
                        . ":isEditavel, "
                        . ":superior, "
                        . "'1','2',"
                        . ":userId, "
                        . ":atualizado_por, "
                        . ":ultima_atualizacao)");
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        $stm->bindParam(':sigla', $this->sigla, PDO::PARAM_STR);
        $stm->bindParam(':descricao', $this->descricao, PDO::PARAM_STR);
        $stm->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
        $stm->bindParam(':isEditavel', $this->isEditavel, PDO::PARAM_INT);
        $stm->bindParam(':superior', $this->superior, PDO::PARAM_INT);
        $stm->bindParam(':userId', $this->userId, PDO::PARAM_INT);
        $stm->bindParam(':atualizado_por', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':ultima_atualizacao', $this->ultimaAtualizacao);
        $stm->execute();
        return DB::getInstance()->lastInsertId();
    }
    
    /*
     * por enquanto apenas inativa e cadastra outro
     */
    public function atualiza($id) {
        $stm = DB::prepare("UPDATE $this->table SET "
                        . "sigla = :sigla, "
                        . "descricao = :descricao, "
                        . "is_ativo = :isAtivo, "
                        . "superior = :superior, "
                        . "lft = :lft, "
                        . "rgt = :rgt, "
                        . "atualizado_por = :atualizado_por, "
                        . "ultima_atualizacao = :ultima_atualizacao WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->bindParam(':sigla', $this->sigla, PDO::PARAM_STR);
        $stm->bindParam(':descricao', $this->descricao, PDO::PARAM_STR);
        $stm->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
        $stm->bindParam(':superior', $this->superior, PDO::PARAM_INT);
        $stm->bindParam(':lft', $this->LFT, PDO::PARAM_INT);
        $stm->bindParam(':rgt', $this->RGT, PDO::PARAM_INT);
        $stm->bindParam(':atualizado_por', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':ultima_atualizacao', $this->ultimaAtualizacao);
        return $stm->execute();
    }

    public function listaOrgao() {
        $stm = DB::prepare("SELECT id, sigla, descricao, is_ativo, is_editavel FROM $this->table WHERE id_empresa = :idEmpresa");
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_STR);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * 
     * @param int $t - tipo - 1-Ativo e 01-Ativo/Inativo
     * @param int $id - se estiver setado seleciona apenas baselines exceto a do id recebido
     * @return array
     */
    public function comboOrgao($t, $id) {
        $stm = DB::prepare("SELECT id, concat(sigla,' - ', descricao) AS descricao FROM $this->table WHERE id_empresa = :idEmpresa AND is_ativo "
                        . ($t === '1' ? ' = 1' : ' in (0, 1)'));
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_STR);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSigla($id) {
        $stm = DB::prepare("SELECT sigla, descricao FROM $this->table WHERE id = $id");
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function alterarStatusOrgao($id) {
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

    public function getTree($tipo, $idCliente = 0, $parent = 0) {
        $sql = "SELECT CONCAT(node.sigla, '.', node.descricao) AS descricao, node.id FROM $this->table node, $this->table parent "
                . "WHERE node.lft BETWEEN parent.lft AND parent.rgt AND "
                . "parent.id = :parent ORDER BY node.lft ASC";
        $stm = DB::prepare($sql);
        $stm->bindParam(':parent', $parent, PDO::PARAM_INT);
        switch ($tipo) {
            case 'array':
                $stm->execute();
                $orgaos = $stm->fetchAll(PDO::FETCH_ASSOC);
                break;
            case 'hierarquia':
                $stm->execute();
                $orgaos = $this->hierarquia($stm->fetchAll(PDO::FETCH_ASSOC));
                break;
            case 'identada':
                $orgaos = $this->identada($idCliente);
                break;
        }
        //retorno
        return $orgaos;
    }

    private function hierarquia($lista) {
        $orgaos = '';
        $iterator = new RecursiveIteratorIterator(new recursiveArrayIterator($lista));
        try {
            foreach ($iterator as $key => $value) {
                $orgaos .= $value . '<br />';
            }
        } catch (Exception $e) {
            $orgaos = $e->getMessage();
        }
        return $orgaos;
    }

    private function identada($idCliente = 0) {
        //idEmpresa
        $idEmpresa = getIdEmpresa();
        //lista de orgaos
        $orgaos = array();
        $chartConfig = array(
            'chart' => array('container' => '#tree_sample'),
            'nodeStructure' => array(
                'text' => array('name' => 'Parent node'),
                'children' => array(
                    array('text' => array('name' => 'First child')),
                    array('text' => array('name' => 'Second child')),
                    array('text' => array('name' => 'Third child')))
            )
        );
        //pegar o lft e o rgt do root node ($id)
        $sql = "SELECT id, lft, rgt FROM orgao WHERE id_empresa = $idEmpresa AND id_cliente = $idCliente ORDER BY id ASC LIMIT 1";
        $stm = DB::prepare($sql);
        $stm->execute();
        $row = $stm->fetch(PDO::FETCH_ASSOC);
        // start with an empty $right stack  
        $right = array();
        // now, retrieve all descendants of the $root node
        $sql2 = "SELECT CONCAT(sigla, ' - ', descricao) AS descricao, lft, rgt, id, is_ativo, is_editavel FROM orgao "
                . "WHERE lft BETWEEN " . $row['lft'] . " AND "
                . $row['rgt'] . " AND id_empresa = $idEmpresa AND id_cliente = $idCliente ORDER BY lft ASC";
        $stm2 = DB::prepare($sql2);
        $stm2->execute();
        $row2 = $stm2->fetchAll(PDO::FETCH_ASSOC);
        // display each row  
        foreach ($row2 as $row) {
            //only check stack if there is one  
            if (count($right) > 0) {
                // check if we should remove a node from the stack  
                while ($right[count($right) - 1] < $row['rgt']) {
                    array_pop($right);
                }
            }
            // display indented node title
            $orgaos[] = array(
                'descricao' => str_repeat('&#183;&#183;&#183;&#183;&#183;', count($right)) . '&#10171; ' . $row['descricao'],
                'id' => $row['id'],
                'is_ativo' => $row['is_ativo'],
                'is_editavel' => $row['is_editavel']);
            // add this node to the stack  
            $right[] = $row['rgt'];
        }
        //retorna
        //echo '<pre>';
        //print_r($chartConfig);
        return $orgaos;
    }

    /**
     * 
     * @param int $id - id do orgao superior
     * @throws Exception
     */
    public function addOrgao($id) {
        $idEmpresa = getIdEmpresa();
        try {
            DB::getInstance()->beginTransaction();
            $stm = DB::prepare("SELECT @myRight := rgt FROM orgao WHERE id = :id");
            $stm->bindParam(':id', $id);
            $stm->execute();
            /*
             * increment the nodes by two 
             */
            DB::getInstance()->exec("UPDATE orgao SET rgt = rgt + 2 WHERE rgt > @myRight AND id_empresa = $idEmpresa");
            DB::getInstance()->exec("UPDATE orgao SET lft = lft + 2 WHERE lft > @myRight AND id_empresa = $idEmpresa");
            /*
             * * * insert the new node 
             * ** 
             */
            $stmInsere = DB::prepare("INSERT INTO orgao("
                            . "id_empresa, "
                            . "id_cliente, "
                            . "sigla, "
                            . "descricao, "
                            . "is_ativo, "
                            . "is_editavel, "
                            . "superior, "
                            . "lft, "
                            . "rgt, "
                            . "user_id, "
                            . "atualizado_por, "
                            . "ultima_atualizacao) VALUES("
                            . ":idEmpresa, "
                            . ":idCliente,"
                            . ":sigla,"
                            . ":descricao,"
                            . ":isAtivo,"
                            . ":isEditavel,"
                            . ":superior, "
                            . "@myRight + 1, "
                            . "@myRight + 2,"
                            . ":userId,"
                            . ":atualizadoPor,"
                            . ":ultimaAtualizacao)");
            $stmInsere->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
            $stmInsere->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
            $stmInsere->bindParam(':sigla', $this->sigla, PDO::PARAM_STR);
            $stmInsere->bindParam(':descricao', $this->descricao, PDO::PARAM_STR);
            $stmInsere->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
            $stmInsere->bindParam(':isEditavel', $this->isEditavel, PDO::PARAM_INT);
            $stmInsere->bindParam(':superior', $this->superior, PDO::PARAM_INT);
            $stmInsere->bindParam(':userId', $this->userId, PDO::PARAM_INT);
            $stmInsere->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
            $stmInsere->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
            $stmInsere->execute();
            /*
             * commit the transaction 
             */
            DB::getInstance()->commit();
        } catch (Exception $e) {
            DB::getInstance()->rollBack();
            throw new Exception($e);
        }
    }

    public function addOrgaoSubordinado($id) {
        try {
            DB::getInstance()->beginTransaction();
            $stm = DB::getInstance()->prepare("SELECT @myLeft := lft FROM orgao WHERE id = $id");
            $stm->execute();
            DB::getInstance()->exec("UPDATE orgao SET rgt = rgt + 2 WHERE rgt > @myLeft");
            DB::getInstance()->exec("UPDATE orgao SET lft = lft + 2 WHERE lft > @myLeft");
            $stmInsere = DB::prepare("INSERT INTO orgao("
                            . "id_empresa, "
                            . "id_cliente, "
                            . "sigla, "
                            . "descricao, "
                            . "is_ativo, "
                            . "is_editavel, "
                            . "superior, "
                            . "lft, "
                            . "rgt, "
                            . "user_id, "
                            . "atualizado_por, "
                            . "ultima_atualizacao) VALUES("
                            . ":idEmpresa, "
                            . ":idCliente,"
                            . ":sigla,"
                            . ":descricao,"
                            . ":isAtivo,"
                            . ":isEditavel,"
                            . ":superior, "
                            . "@myLeft + 1, "
                            . "@myLeft + 2,"
                            . ":userId,"
                            . ":atualizadoPor,"
                            . ":ultimaAtualizacao)");
            $stmInsere->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
            $stmInsere->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
            $stmInsere->bindParam(':sigla', $this->sigla, PDO::PARAM_STR);
            $stmInsere->bindParam(':descricao', $this->descricao, PDO::PARAM_STR);
            $stmInsere->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
            $stmInsere->bindParam(':isEditavel', $this->isEditavel, PDO::PARAM_INT);
            $stmInsere->bindParam(':superior', $this->superior, PDO::PARAM_INT);
            $stmInsere->bindParam(':userId', $this->userId, PDO::PARAM_INT);
            $stmInsere->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
            $stmInsere->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
            $stmInsere->execute();
            $idInserido = DB::getInstance()->lastInsertId();
            DB::getInstance()->commit();
            return $idInserido;
        } catch (Exception $e) {
            DB::getInstance()->rollBack();
            throw new Exception($e);
        }
    }

}
