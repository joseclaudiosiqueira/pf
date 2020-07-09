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

class Comentario extends CRUD {

    private $id;
    private $idExterno;
    private $tabela;
    private $dataInsercao;
    private $userId;
    private $idEmpresa;
    private $idFornecedor;
    private $idCliente;
    private $comentario;
    private $destinatario;
    private $status;
    private $dataLeitura;
    private $isVisivel;
    private $roleId;

    public function __construct() {
        $this->setTable('comentarios');
    }

    /**
     *
     * @param mixed $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    function setIdExterno($idExterno) {
        $this->idExterno = $idExterno;
    }

    function setTabela($tabela) {
        $this->tabela = $tabela;
    }

    function setDataInsercao($dataInsercao) {
        $this->dataInsercao = $dataInsercao;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    /**
     *
     * @param mixed $idEmpresa
     */
    public function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    /**
     *
     * @param mixed $idFornecedor
     */
    public function setIdFornecedor($idFornecedor) {
        $this->idFornecedor = $idFornecedor;
    }

    /**
     *
     * @param mixed $idCliente
     */
    public function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }

    function setComentario($comentario) {
        $this->comentario = $comentario;
    }

    function setDestinatario($destinatario) {
        $this->destinatario = $destinatario;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setDataLeitura($dataLeitura) {
        $this->dataLeitura = $dataLeitura;
    }

    function setIsVisivel($isVisivel) {
        $this->isVisivel = $isVisivel;
    }

    function setRoleId($roleId) {
        $this->roleId = $roleId;
    }

    public function atualizaStatus($id) {
        $stm = DB::prepare("UPDATE $this->table SET status = 1, data_leitura = NOW() WHERE id = :id");
        $stm->bindValue(':id', $id, PDO::PARAM_INT);
        return $stm->execute();
    }

    public function atualizaVisibilidade($id) {
        $stm = DB::prepare("UPDATE $this->table SET is_visivel = 0 WHERE id = :id");
        $stm->bindValue(':id', $id, PDO::PARAM_INT);
        return $stm->execute();
    }

    public function insere() {
        $sql = "INSERT INTO $this->table (
                        id_externo,
                        tabela,
                        data_insercao,
                        user_id,
						id_empresa,
						id_fornecedor,
						id_cliente,
                        comentario,
                        destinatario,
                        status,
                        data_leitura,
                        is_visivel,
                        role_id,
                        ultima_atualizacao,
                        atualizado_por) 
		VALUES (
                        :idExterno,
                        :tabela,
                        :dataInsercao,
                        :userId,
						:idEmpresa,
						:idFornecedor,
						:idCliente,
                        :comentario,
                        :destinatario,
                        :status,
                        :dataLeitura,
                        :isVisivel,
                        :roleId,
                        :ultimaAtualizacao,
                        :atualizadoPor)";
        $stm = DB::prepare($sql);
        $stm->bindParam(':idExterno', $this->idExterno, PDO::PARAM_INT);
        $stm->bindParam(':tabela', $this->tabela, PDO::PARAM_STR);
        $stm->bindParam(':dataInsercao', $this->dataInsercao);
        $stm->bindParam(':userId', $this->userId, PDO::PARAM_INT);
        $stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $this->idFornecedor, PDO::PARAM_INT);
        $stm->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        $stm->bindParam(':comentario', $this->comentario, PDO::PARAM_STR);
        $stm->bindParam(':destinatario', $this->destinatario, PDO::PARAM_STR);
        $stm->bindParam(':status', $this->status, PDO::PARAM_INT);
        $stm->bindParam(':dataLeitura', $this->dataLeitura);
        $stm->bindParam(':isVisivel', $this->isVisivel, PDO::PARAM_INT);
        $stm->bindParam(':roleId', $this->roleId, PDO::PARAM_INT);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->execute();
        return DB::getInstance()->lastInsertId();
    }

    public function atualiza($id) {
        $sql = "UPDATE $this->table SET " . "comentario = :comentario, " . "ultima_atualizacao = :ultimaAtualizacao, " . "atualizado_por = :atualizadoPor " . "WHERE id = :id";
        $stm = DB::prepare($sql);
        $stm->bindParam(':comentario', $this->descricao, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao, PDO::PARAM_STR);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        return $stm->execute();
    }

    /**
     *
     * @param int $id
     *        	- ID Externo associado a funcionalidade
     * @param string $tbl
     *        	- Tabela em que foi feito o comentario (LIE, AIE, etc)
     * @param int $idr
     *        	- Id da Role de quem fez o comentario
     * @return array
     */
    public function listaComentarios() {
        $sql = "SELECT DISTINCT 
                    c.id, 
                    c.id_externo, 
                    c.data_insercao, 
                    c.user_id, 
                    c.comentario, 
                    c.destinatario, 
                    c.status, 
                    c.data_leitura, 
                    c.ultima_atualizacao, 
                    c.atualizado_por, 
                    r.short_name, 
                    ue.user_email, 
                    u.user_complete_name, 
                    IFNULL(ud.telefone_fixo, '0000-0000') AS telefone_fixo, 
                    IFNULL(ud.telefone_celular, '0000-0000') AS telefone_celular, 
                    IFNULL(ud.apelido, u.user_complete_name) AS apelido 
                FROM 
                    $this->table c, 
                    rbac_roles r, 
                    rbac_userroles ru, 
                    users u, 
                    users_detail ud, 
                    users_empresa ue 
                WHERE 
                    c.id_externo = :idExterno AND 
                    c.tabela = :tabela AND
                    ru.RoleId = r.ID AND 
                    ru.UserId = c.user_id AND 
                    u.user_id = c.user_id AND 
                    c.user_id = ud.id AND 
                    u.user_id = ue.id_user AND 
                    ru.RoleId = c.role_id 
                ORDER BY c.id DESC";
        /*
         * a regra eh que: se visualiza a contagem, visualiza os comentarios, que estao
         * mais associados a funcionalidade
         *  AND
            ue.id_empresa = :idEmpresa AND
            ue.id_fornecedor = :idFornecedor AND
            ue.id_cliente = :idCliente
         */
        $stm = DB::prepare($sql);
        $stm->bindParam(':idExterno', $this->idExterno, PDO::PARAM_INT);
        $stm->bindParam(':tabela', $this->tabela, PDO::PARAM_STR);
        //$stm->bindParam(':idEmpresa', $this->idEmpresa, PDO::PARAM_INT);
        //$stm->bindParam(':idFornecedor', $this->idFornecedor, PDO::PARAM_INT);
        //$stm->bindParam(':idCliente', $this->idCliente, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getComentario($id) {
        $stm = DB::prepare("SELECT " . "c.id, " . "c.id_externo, " . "c.data_insercao, " . "c.user_id, " . "c.comentario, " . "c.destinatario, " . "c.status, " . "c.data_leitura, " . "c.ultima_atualizacao, " . "c.atualizado_por, " . "r.short_name, " . "ue.user_email, " . "IFNULL(ud.telefone_fixo, '0000-0000') AS telefone_fixo, " . "IFNULL(ud.telefone_celular, '0000-0000') AS telefone_celular, " . "IFNULL(ud.apelido, u.user_complete_name) AS apelido " . "FROM $this->table c, rbac_roles r, rbac_userroles ru, users u, users_detail ud, users_empresa ue " . "WHERE " . "c.id = :id AND " . "ru.RoleId = r.ID AND " . "ru.UserId = c.user_id AND " . "u.user_id = c.user_id AND " . "c.user_id = ud.id AND " . "u.user_id = ue.id_user");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

}
