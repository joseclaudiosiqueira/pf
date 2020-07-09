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

class ContagemApontes extends CRUD {

    private $id;
    private $idContagem;
    private $idTarefa;
    private $tipo;
    private $aponte;
    private $userId;
    private $inseridoPor;
    private $dataInsercao;
    private $status;
    private $destinatario;
    private $resolvidoPor;
    private $dataResolucao;
    private $observacoes;

    public function __construct() {
        $this->setTable('contagem_apontes');
        $this->setLog();
    }

    function setId($id) {
        $this->id = $id;
    }

    function getId() {
        return $this->id;
    }

    function setIdContagem($idContagem) {
        $this->idContagem = $idContagem;
    }

    function setIdTarefa($idTarefa) {
        $this->idTarefa = $idTarefa;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setAponte($aponte) {
        $this->aponte = $aponte;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setInseridoPor($inseridoPor) {
        $this->inseridoPor = $inseridoPor;
    }

    function setDataInsercao($dataInsercao) {
        $this->dataInsercao = $dataInsercao;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setDestinatario($destinatario) {
        $this->destinatario = $destinatario;
    }

    function setResolvidoPor($resolvidoPor) {
        $this->resolvidoPor = $resolvidoPor;
    }

    function setDataResolucao($dataResolucao) {
        $this->dataResolucao = $dataResolucao;
    }

    function setObservacoes($observacoes) {
        $this->observacoes = $observacoes;
    }

    function getTipo() {
        $stm = DB::prepare("SELECT tipo FROM $this->table WHERE id = :id");
        $stm->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha['tipo'];
    }

    public function insere() {
        $stm = DB::prepare("INSERT INTO $this->table ("
                        . "id_contagem,"
                        . "id_tarefa,"
                        . "tipo,"
                        . "aponte,"
                        . "user_id,"
                        . "inserido_por,"
                        . "data_insercao,"
                        . "destinatario) VALUES ("
                        . ":idContagem,"
                        . ":idTarefa,"
                        . ":tipo,"
                        . ":aponte,"
                        . ":userId,"
                        . ":inseridoPor,"
                        . ":dataInsercao,"
                        . ":destinatario)");
        $stm->bindParam(':idContagem', $this->idContagem, PDO::PARAM_INT);
        $stm->bindParam(':idTarefa', $this->idTarefa, PDO::PARAM_INT);
        $stm->bindParam(':tipo', $this->tipo, PDO::PARAM_STR);
        $stm->bindParam(':aponte', $this->aponte, PDO::PARAM_STR);
        $stm->bindParam(':userId', $this->userId, PDO::PARAM_INT);
        $stm->bindParam(':inseridoPor', $this->inseridoPor, PDO::PARAM_STR);
        $stm->bindParam(':dataInsercao', $this->dataInsercao);
        $stm->bindParam(':destinatario', $this->destinatario, PDO::PARAM_STR);
        $stm->execute();
        //retorna o id inserido
        return DB::getInstance()->lastInsertId();
    }

    public function atualiza($id) {
        //
    }

    public function listaApontes($idContagem, $email = NULL) {
        $idCliente = getIdCliente();
        $idFornecedor = getIdFornecedor();
        $idEmpresa = getIdEmpresa();
        $sql = "SELECT DISTINCT "
                . "a.id, "
                . "a.data_insercao, "
                . "a.user_id, "
                . "a.aponte, "
                . "a.destinatario, "
                . "a.status, "
                . "a.data_resolucao, "
                . "a.observacoes, "
                . "a.resolvido_por, "
                . "r.short_name,"
                . "ue.user_email,"
                . "u.user_complete_name,"
                . "IFNULL(ud.apelido, u.user_complete_name) AS apelido "
                . "FROM $this->table a, rbac_roles r, rbac_userroles ru, users u, users_detail ud, users_empresa ue "
                . "WHERE "
                . "a.id_contagem = $idContagem AND "
                . (NULL !== $email ? "a.inserido_por = '$email' AND " : "")
                . "ru.RoleId = r.ID AND "
                . "ru.UserId = a.user_id AND "
                . "u.user_id = a.user_id AND "
                . "a.user_id = ud.id AND "
                . "u.user_id = ue.id_user AND "
                . "ue.is_ativo = 1 AND "
                //TODO: verificar, pois parece que nao precisa.
                . "ru.id_cliente = $idCliente AND "
                . "ru.id_empresa = $idEmpresa AND "
                . "ru.id_fornecedor = $idFornecedor "
                . "ORDER BY a.id DESC";
        $stm = DB::prepare($sql);
        //DEBUG
        //DEBUG_MODE ? error_log($sql, 0) : NULL;
        //$stm->bindParam(':idContagem', $idContagem, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizaStatus() {
        $stm = DB::prepare("UPDATE $this->table SET status = 1, data_resolucao = NOW(), resolvido_por = :resolvidoPor, observacoes = :observacoes WHERE id = :id");
        $stm->bindValue(':id', $this->id, PDO::PARAM_INT);
        $stm->bindValue(':resolvidoPor', $this->resolvidoPor, PDO::PARAM_STR);
        $stm->bindValue(':observacoes', $this->observacoes, PDO::PARAM_STR);
        return $stm->execute();
    }

    public function getAponte() {
        $stm = DB::prepare("SELECT "
                        . "a.*, "
                        . "r.short_name, "
                        . "ue.user_email, "
                        . "IFNULL(ud.apelido, u.user_complete_name) AS apelido "
                        . "FROM $this->table a, rbac_roles r, rbac_userroles ru, users u, users_detail ud, users_empresa ue "
                        . "WHERE "
                        . "a.id = :id AND "
                        . "ru.RoleId = r.ID AND "
                        . "ru.UserId = a.user_id AND "
                        . "u.user_id = a.user_id AND "
                        . "a.user_id = ud.id AND "
                        . "u.user_id = ue.id_user");
        $stm->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function getDescricaoAponte() {
        $stm = DB::prepare("SELECT aponte, id FROM $this->table WHERE id_contagem = :idContagem AND id_tarefa = :idTarefa");
        $stm->bindValue(':idContagem', $this->idContagem, PDO::PARAM_INT);
        $stm->bindValue(':idTarefa', $this->idTarefa, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

}
