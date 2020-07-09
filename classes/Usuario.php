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

/*
 * tambem utilizada com user_detail
 * esta classe foi criada para conter os metodos de acesso e alteracao de usuarios nao contemplados
 * pelo RBAC
 * Geralmente altera dados em users_detail e users_empresa
 */

class Usuario extends CRUD {
    /*
     * atributos genericos
     */

    private $isAtivo;
    private $roleId;
    private $isValidarAdmGestor;
    /*
     * atributos da tabela users_detail
     */
    private $cpf;
    private $dataNascimento;
    private $emailAlternativo;
    private $apelido;
    private $telefoneFixo;
    private $telefoneCelular;
    private $especialidades;
    private $uf;
    private $certificacao;

    public function __construct() {
        $this->setTable('users');
    }

    function setIsAtivo($isAtivo) {
        $this->isAtivo = $isAtivo;
    }

    function setRoleId($roleId) {
        $this->roleId = $roleId;
    }

    function setIsValidarAdmGestor($isValidarAdmGestor) {
        $this->isValidarAdmGestor = $isValidarAdmGestor;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function setDataNascimento($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
    }

    function setEmailAlternativo($emailAlternativo) {
        $this->emailAlternativo = $emailAlternativo;
    }

    function setApelido($apelido) {
        $this->apelido = $apelido;
    }

    function setTelefoneFixo($telefoneFixo) {
        $this->telefoneFixo = $telefoneFixo;
    }

    function setTelefoneCelular($telefoneCelular) {
        $this->telefoneCelular = $telefoneCelular;
    }

    function setEspecialidades($especialidades) {
        $this->especialidades = $especialidades;
    }

    function setUf($uf) {
        $this->uf = $uf;
    }

    function setCertificacao($certificacao) {
        $this->certificacao = $certificacao;
    }

    /*
     * retorna o short_name da role do usuario
     */

    public function getUserRole($userId, $isRoleId = FALSE, $roleId = NULL) {
        $stm = DB::prepare("SELECT r.short_name FROM rbac_roles r, rbac_userroles ru WHERE ru.roleId = r.ID AND ru.UserId = :userId " . ($isRoleId ? "AND ru.RoleId = :roleId" : ""));
        $stm->bindValue(':userId', $userId, PDO::PARAM_INT);
        $isRoleId ? $stm->bindValue(':roleId', $roleId, PDO::PARAM_INT) : NULL;
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['short_name'];
    }

    /*
     * retorna o id da user_role do usuario
     */

    public function getUserRoleId($userId) {
        $stm = DB::prepare("SELECT r.id FROM rbac_roles r, rbac_userroles ru WHERE ru.roleId = r.ID AND ru.UserId = :userId");
        $stm->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['id'];
    }

    /*
     * funcao que retorna apenas o titulo da role
     */

    public function getRoleTitle($roleId) {
        $stm = DB::prepare("SELECT r.Title, r.short_name FROM rbac_roles r WHERE r.ID = :roleId");
        $stm->bindValue(':roleId', $roleId, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function consultaValidador($idEmpresa, $idFornecedor, $userEmail, $escopo, $idCliente = NULL) {
        /*
         * 2 - validador interno
         * 3 - validador externo
         * 4 - auditor interno
         * 5 - auditor externo
         * 6 - gestor
         *
         */
        switch ($escopo) {
            case 'vi' :
                $perfis = '2, 6';
                if (!isFornecedor()) {
                    $idFornecedor = 0;
                }
                $idCliente = 0;
                break;
            case 've':
                /*
                 * verifica se eh um fornecedor e traz os validadores internos
                 * nesta versao tem que colocar os validadores com um perfil de validador externo no Fornecedor
                 * $perfis = isFornecedor () ? '2, 6' : '3';
                 */
                $perfis = '3';
                break;
            case 'ai' :
                $perfis = '4';
                break;
            case 'ae' :
                $perfis = '5';
                break;
            default :
                $perfis = '0';
                break;
        }
        /*
         * nesta versao os Validadores Externos estao cadastrados no fornecedor
         *
         * $sql = "SELECT u.user_id, u.user_complete_name, ue.user_email, ud.telefone_celular, ud.telefone_fixo, ud.email_alternativo FROM " . "users u, users_empresa ue, rbac_userroles rb, users_detail ud " . "WHERE " . "rb.RoleId IN ('$perfis') AND " . "ud.id = rb.UserId AND " . "rb.UserId = ue.id_user AND " . "ue.id_user = u.user_id AND " . "rb.UserId = u.user_id AND " . "ue.is_ativo = 1 AND " . "u.user_active = 1 AND " . "rb.id_empresa = $idEmpresa AND " . ((isFornecedor () && $escopo === 've') ? "rb.id_fornecedor = $idFornecedor AND " : "rb.id_fornecedor = $idFornecedor AND ") . ((! isFornecedor () && $escopo === 've') ? "ue.id_cliente = $idCliente AND " : "") . "ue.user_email <> '$userEmail' " . (($escopo === 'vi') ? "UNION " . "SELECT u.user_id, u.user_complete_name, ue.user_email, ud.telefone_celular, ud.telefone_fixo, ud.email_alternativo FROM " . "users u, users_empresa ue, rbac_userroles rb, users_detail ud " . "WHERE " . "ud.id = rb.UserId AND " . "rb.UserId = ue.id_user AND " . "ue.id_user = u.user_id AND " . "rb.UserId = u.user_id AND " . "ue.is_ativo = 1 AND " . "u.user_active = 1 AND " . "ue.is_validar_adm_gestor = 1 AND " . "rb.id_empresa = $idEmpresa AND " . ((isFornecedor () && $escopo === 've') ? "rb.id_fornecedor = $idFornecedor AND " : "rb.id_fornecedor = $idFornecedor AND ") . "ue.user_email <> '$userEmail'" : '');
         * $stm = DB::prepare ( $sql );
         * $stm->bindValue ( ':idEmpresa', $idEmpresa, PDO::PARAM_INT );
         * (isFornecedor () && $escopo === 've') ? $stm->bindValue ( ':idFornecedor', 0, PDO::PARAM_INT ) : $stm->bindValue ( ':idFornecedor', $idFornecedor, PDO::PARAM_INT );
         * (! isFornecedor () && $escopo === 've') ? $stm->bindParam ( ':idCliente', $idCliente, PDO::PARAM_INT ) : null;
         * $stm->bindValue ( ':userEmail', $userEmail, PDO::PARAM_STR );
         * $stm->bindValue ( ':perfis', $perfis, PDO::PARAM_STR );
         * $stm->execute ();
         * return $stm->fetchAll ( PDO::FETCH_ASSOC );
         */
        $sql = "
        SELECT
            u.user_id,
            u.user_complete_name, 
            ue.user_email, 
            ud.telefone_celular, 
            ud.telefone_fixo, 
            ud.email_alternativo
        FROM
            users_detail ud,
            rbac_userroles rb,
            users_empresa ue,
            users u
        WHERE
            ud.id = rb.UserId AND
            ud.id = ue.id_user AND
            ue.id_user = rb.UserId AND 
            u.user_id = ud.id AND
            u.user_id = rb.UserId AND
            u.user_id = ue.id_user AND
            u.user_active = 1 AND 
            rb.RoleId IN ($perfis) AND
            rb.id_empresa = $idEmpresa AND 
            rb.id_fornecedor = $idFornecedor AND "
                . ((NULL !== $idCliente && $idFornecedor && ($escopo === 've' || $escopo === 'ae')) ? " rb.id_cliente = $idCliente AND " : " rb.id_cliente = 0 AND ")
                . "
            ue.is_ativo = 1 AND 
            ue.id_empresa = $idEmpresa AND 
            ue.id_fornecedor = $idFornecedor AND
            ue.user_email <> '$userEmail' ";
        /*
         * TODO: verificar estas questoes por conta de fornecedores e clientes para validadores
         */
        $sql .= (($escopo === 'vi') ? "UNION
                SELECT 
                    u.user_id, 
                    u.user_complete_name, 
                    ue.user_email, 
                    ud.telefone_celular, 
                    ud.telefone_fixo, 
                    ud.email_alternativo 
                FROM 
                    users u, 
                    users_empresa ue, 
                    rbac_userroles rb, 
                    users_detail ud 
                WHERE
                    ud.id = rb.UserId AND
                    ud.id = ue.id_user AND
                    ue.id_user = rb.UserId AND 
                    u.user_id = ud.id AND
                    u.user_id = rb.UserId AND
                    u.user_id = ue.id_user AND
                    u.user_active = 1 AND 
                    rb.id_empresa = $idEmpresa AND 
                    rb.id_fornecedor = $idFornecedor AND "
                        . ((NULL !== $idCliente && ($escopo === 've' || $escopo === 'ae')) ? " rb.id_cliente = $idCliente AND " : " rb.id_cliente = 0 AND ")
                        . "
                    ue.is_ativo = 1 AND 
                    ue.is_validar_adm_gestor = 1 AND
                    ue.id_empresa = $idEmpresa AND 
                    ue.id_fornecedor = $idFornecedor AND
                    ue.id_cliente = $idCliente AND 
                    ue.user_email <> '$userEmail'" : "");
        //DEBUG
        //DEBUG_MODE ? error_log($sql, 0) : NULL;
        $stm = DB::prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGerenteProjeto($id) {
        if ($_SESSION ['contagem_config'] ['is_gestao_projetos']) {
            $sql = "SELECT ue.user_email, u.user_complete_name FROM users u, projeto p, users_empresa ue WHERE u.user_id = p.id_gerente_projeto AND u.user_id = ue.id_user AND p.id = :id";
            $stm = DB::prepare($sql);
            $stm->bindValue(':id', $id, PDO::PARAM_INT);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_ASSOC);
        } else {
            return array(
                'user_email' => 'nao@aplicavel',
                'complete_name' => 'Não aplicável'
            );
        }
    }

    public function comboGerenteProjeto($idEmpresa) {
        $sql = "
            SELECT
                u.user_id, u.user_complete_name
            FROM
                users u, users_empresa ue, rbac_userroles ru
            WHERE 
                u.user_id = ue.id_user AND
                u.user_id = ru.UserId AND
                ue.id_user = ru.UserId AND
                ru.RoleId = 8 AND
                ue.is_ativo = 1 AND
                ue.id_empresa = :idEmpresa";
        $stm = DB::prepare($sql);
        $stm->bindValue(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insere() {
        //
    }

    public function atualiza($id) {
        //
    }

    public function consultaPerfil($id) {
        /*
         * Perfis
         * ADM - Administrador
         * GES - Gestor
         * CON - Contador (analista de metricas)
         * VEX - Validador externo
         * VIN - Validador interno
         * AUD - Auditor
         * GER - Grupo de gerentes
         * DIR - Grupo de diretores
         */
    }

    public function isAdministrador($userId) {
        $idEmpresa = getIdEmpresa();
        $stm = DB::prepare($this->getSQLUser());
        $stm->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stm->bindValue(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindValue(':RoleId', $this->roleId, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['RoleId'] == 1 ? 1 : 0;
    }

    public function isAdministradorFornecedor($userId) {
        $idEmpresa = getIdEmpresa();
        $idFornededor = getIdFornecedor();
        $stm = DB::prepare($this->getSQLUser($idFornededor));
        $stm->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stm->bindValue(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindValue(':RoleId', $this->roleId, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['RoleId'] == 1 ? 1 : 0;
    }

    public function isAnalistaMetricas($userId, $idFornecedor = NULL) {
        $idEmpresa = getIdEmpresa();
        $stm = DB::prepare($this->getSQLUser($idFornecedor ? $idFornecedor : NULL ));
        $stm->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stm->bindValue(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindValue(':RoleId', $this->roleId, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['RoleId'] == 7 ? 1 : 0;
    }

    public function isGestor($userId) {
        $idEmpresa = getIdEmpresa();
        $stm = DB::prepare($this->getSQLUser());
        $stm->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stm->bindValue(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindValue(':RoleId', $this->roleId, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['RoleId'] == 6 ? 1 : 0;
    }

    public function isGestorFornecedor($userId, $idFornecedor) {
        $idEmpresa = getIdEmpresa();
        $stm = DB::prepare($this->getSQLUser($idFornecedor));
        $stm->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stm->bindValue(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindValue(':RoleId', $this->roleId, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['RoleId'] == 6 ? 1 : 0;
    }

    public function isGerenteConta($userId) {
        $idEmpresa = getIdEmpresa();
        $stm = DB::prepare($this->getSQLUser());
        $stm->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stm->bindValue(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindValue(':RoleId', $this->roleId, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['RoleId'] == 9 ? 1 : 0;
    }

    public function isGerenteContaFornecedor($userId, $idFornecedor) {
        $idEmpresa = getIdEmpresa();
        $stm = DB::prepare($this->getSQLUser($idFornecedor));
        $stm->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stm->bindValue(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindValue(':RoleId', $this->roleId, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['RoleId'] == 9 ? 1 : 0;
    }

    /*
     * tem uma outra funcao CRUD::isGerenteProjeto($email, $id)
     * TODO: verificar a possibilidade de migrar para esta
     *
     * public function isGerenteProjeto($userId) {
     * $idEmpresa = getIdEmpresa();
     * $stm = DB::prepare($this->getSQLUser());
     * $stm->bindValue(':userId', $userId, PDO::PARAM_INT);
     * $stm->bindValue(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
     * $stm->execute();
     * $linha = $stm->fetch(PDO::FETCH_ASSOC);
     * return $linha['RoleId'] == 8 ? 1 : 0;
     * }
     *
     */

    public function isGerenteProjetoFornecedor($userId, $idFornecedor) {
        $idEmpresa = getIdEmpresa();
        $stm = DB::prepare($this->getSQLUser($idFornecedor));
        $stm->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stm->bindValue(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindValue(':RoleId', $this->roleId, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['RoleId'] == 8 ? 1 : 0;
    }

    public function isDiretor($userId) {
        $idEmpresa = getIdEmpresa();
        $stm = DB::prepare($this->getSQLUser());
        $stm->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stm->bindValue(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindValue(':RoleId', $this->roleId, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['RoleId'] == 10 ? 1 : 0;
    }

    public function isViewer($userId) {
        $idEmpresa = getIdEmpresa();
        $stm = DB::prepare($this->getSQLUser());
        $stm->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stm->bindValue(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindValue(':RoleId', $this->roleId, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['RoleId'] == 11 ? 1 : 0;
    }

    public function isPerfilValidadorInterno($userId) {
        $idEmpresa = getIdEmpresa();
        $stm = DB::prepare($this->getSQLUser());
        $stm->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stm->bindValue(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindValue(':RoleId', $this->roleId, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['RoleId'] == 2 ? 1 : 0;
    }

    public function isInstrutor($userId) {
        $idEmpresa = getIdEmpresa();
        $idFornecedor = getIdFornecedor(); // sempre por se tratar de uma turma
        $stm = DB::prepare($this->getSQLUser($idFornecedor));
        $stm->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stm->bindValue(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindValue(':RoleId', $this->roleId, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['RoleId'] == 14 ? 1 : 0;
    }

    public function isFiscalContrato($userId) {
        $idEmpresa = getIdEmpresa();
        $stm = DB::prepare($this->getSQLUser());
        $stm->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stm->bindValue(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindValue(':RoleId', $this->roleId, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['RoleId'] == 16 ? 1 : 0;
    }

    public function isFiscalContratoEmpresa($userId) {
        $idEmpresa = getIdEmpresa();
        $stm = DB::prepare($this->getSQLUser());
        $stm->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stm->bindValue(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindValue(':RoleId', $this->roleId, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['RoleId'] == 16 && !($linha ['id_cliente']) ? 1 : 0;
    }

    public function isFiscalContratoFornecedor($userId, $idFornecedor) {
        $idEmpresa = getIdEmpresa();
        $stm = DB::prepare($this->getSQLUser($idFornecedor));
        $stm->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stm->bindValue(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindValue(':RoleId', $this->roleId, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['RoleId'] == 16 ? 1 : 0;
    }

    public function getIdClienteFiscalContrato($userId) {
        $idEmpresa = getIdEmpresa();
        $idFornecedor = isFornecedor() ? getIdFornecedor() : 0;
        $stm = DB::prepare($this->getSQLUser($idFornecedor));
        $stm->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stm->bindValue(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindValue(':RoleId', $this->roleId, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['id_cliente'];
    }

    public function isFinanceiro($userId) {
        $idEmpresa = getIdEmpresa();
        $stm = DB::prepare($this->getSQLUser());
        $stm->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stm->bindValue(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindValue(':RoleId', $this->roleId, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['RoleId'] == 13 ? 1 : 0;
    }

    public function isInserirContagemAuditoria($userId, $idFornecedor) {
        $idEmpresa = getIdEmpresa();
        $stm = DB::prepare($this->getSQLUser($idFornecedor));
        $stm->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stm->bindValue(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindValue(':RoleId', $this->roleId, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['is_inserir_contagem_auditoria'] == 1 ? 1 : 0;
    }

    public function getSQLUser($idFornecedor = NULL) {
        return "SELECT "
                . "     r.RoleId, "
                . "     ue.id_cliente, "
                . "     ue.is_inserir_contagem_auditoria "
                . "FROM "
                . "     rbac_userroles r, "
                . "     users_empresa ue "
                . "WHERE "
                . "     r.UserId = ue.id_user AND "
                . "     ue.id_empresa = :idEmpresa AND "
                . "     r.RoleId = :RoleId AND "
                . (NULL !== $idFornecedor ? "ue.id_fornecedor = $idFornecedor AND " : "ue.id_fornecedor = 0 AND ")
                . "     r.UserId = :userId";
    }

    public function listaUsuarios($idEmpresa, $orderBy = null) {
        /*
         * o primeiro select traz os usuarios da empresa
         * o segundo selecet traz os usuarios dos fornecedores
         */
        $stm = DB::prepare(
                        "SELECT * FROM (
                    SELECT 
                        ue.id_cliente, 
                        ue.is_validar_adm_gestor, 
                        rb.RoleId, 
                        r.short_name, 
                        r.Title, 
                        u.user_id, 
                        u.user_complete_name, 
                        u.user_active, 
                        ue.user_email, 
                        ue.id_empresa, 
                        ue.id_fornecedor, 
                        ue.is_ativo, 
                        e.sigla AS eSigla, 
                        '-' AS fSigla, 
                        '-' AS tipo
                    FROM 
                        users u, 
                        users_empresa ue, 
                        empresa e, 
                        rbac_userroles rb, 
                        rbac_roles r
                   WHERE 
                        u.user_id = ue.id_user AND 
                        e.id = ue.id_empresa AND 
                        u.user_id = rb.UserId AND 
                        rb.RoleId = r.ID AND 
                        rb.id_empresa = ue.id_empresa AND 
                        ue.id_fornecedor = 0 AND 
                        e.id = :idEmpresa AND 
                        ue.is_excluido = 0 AND
                        rb.id_fornecedor = 0
                   UNION
                   SELECT 
                        ue.id_cliente, 
                        ue.is_validar_adm_gestor, 
                        rb.RoleId, 
                        r.short_name, 
                        r.Title, 
                        u.user_id, 
                        u.user_complete_name, 
                        u.user_active, 
                        ue.user_email, 
                        ue.id_empresa, 
                        ue.id_fornecedor, 
                        ue.is_ativo, 
                        '-' AS eSigla, 
                        f.sigla AS fSigla, 
                        f.tipo AS tipo
                   FROM 
                        users u, 
                        users_empresa ue, 
                        empresa e, 
                        fornecedor f, 
                        rbac_userroles rb, 
                        rbac_roles r
                   WHERE 
                        u.user_id = ue.id_user AND 
                        e.id = ue.id_empresa AND 
                        u.user_id = rb.UserId AND 
                        rb.RoleId = r.ID AND 
                        rb.id_empresa = ue.id_empresa AND 
                        ue.id_fornecedor = f.id AND 
                        ue.id_fornecedor > 0 AND 
                        f.tipo = 0 AND 
                        e.id = :idEmpresa AND 
                        ue.is_excluido = 0 AND 
                        rb.id_fornecedor > 0) AS tbl1 ORDER BY $orderBy ASC");
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->execute();
        $lista = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $lista;
    }

    public function listaUsuariosTurma($idEmpresa, $orderBy = null) {
        /*
         * o primeiro select traz os usuarios da empresa
         * o segundo selecet traz os usuarios dos fornecedores
         */
        $stm = DB::prepare("
            SELECT * FROM (
                SELECT 
                    ue.id_cliente, 
                    ue.is_validar_adm_gestor, 
                    rb.RoleId, 
                    r.short_name, 
                    r.Title, 
                    u.user_id, 
                    u.user_complete_name, 
                    u.user_active, 
                    ue.user_email, 
                    ue.id_empresa, 
                    ue.id_fornecedor, 
                    ue.is_ativo, 
                    '-' AS eSigla, 
                    f.sigla AS fSigla, 
                    f.tipo AS tipo
                FROM 
                    users u, 
                    users_empresa ue, 
                    empresa e, 
                    fornecedor f, 
                    rbac_userroles rb, 
                    rbac_roles r
                WHERE 
                    u.user_id = ue.id_user AND 
                    e.id = ue.id_empresa AND 
                    u.user_id = rb.UserId AND 
                    rb.RoleId = r.ID AND 
                    rb.id_empresa = ue.id_empresa AND
                    u.user_id = rb.UserId AND  
                    ue.id_fornecedor = f.id AND 
                    ue.id_fornecedor > 0 AND 
                    f.tipo = 1 AND 
                    e.id = :idEmpresa AND 
                    ue.is_excluido = 0 AND
                    rb.id_fornecedor > 0) AS tbl1 
                ORDER BY 
                    $orderBy ASC");
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->execute();
        $lista = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $lista;
    }

    public function alterarStatusUsuario($idUser, $idEmpresa, $idFornecedor) {
        $stm = DB::prepare("UPDATE $this->table SET "
                        . "is_ativo = :isAtivo, "
                        . "atualizado_por = :atualizadoPor, "
                        . "ultima_atualizacao = :ultimaAtualizacao "
                        . "WHERE id_user = :idUser AND "
                        . "id_empresa = :idEmpresa AND "
                        . "id_fornecedor = :idFornecedor");
        $stm->bindParam(':isAtivo', $this->isAtivo, PDO::PARAM_INT);
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $idFornecedor, PDO::PARAM_INT);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stm->bindPAram(':idUser', $idUser, PDO::PARAM_INT);
        return ($stm->execute());
    }

    public function alterarPerfilUsuario($idUser, $idEmpresa, $idFornecedor) {
        $stm = DB::prepare("UPDATE rbac_userroles SET " . "RoleId = :RoleId, " . "atualizado_por = :atualizadoPor, " . "ultima_atualizacao = :ultimaAtualizacao " . "WHERE UserId = :idUser AND " . "id_empresa = :idEmpresa AND " . "id_fornecedor = :idFornecedor");
        $stm->bindParam(':RoleId', $this->roleId, PDO::PARAM_INT);
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $idFornecedor, PDO::PARAM_INT);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stm->bindPAram(':idUser', $idUser, PDO::PARAM_INT);
        return ($stm->execute());
    }

    public function alterarIsValidarAdmGestor($idUser, $idEmpresa, $idFornecedor) {
        $stm = DB::prepare("UPDATE users_empresa SET " . "is_validar_adm_gestor = :isValidarAdmGestor, " . "atualizado_por = :atualizadoPor, " . "ultima_atualizacao = :ultimaAtualizacao " . "WHERE id_empresa = :idEmpresa AND " . "id_fornecedor = :idFornecedor AND " . "id_user = :idUser");
        $stm->bindParam(':isValidarAdmGestor', $this->isValidarAdmGestor, PDO::PARAM_INT);
        $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
        $stm->bindParam(':idFornecedor', $idFornecedor, PDO::PARAM_INT);
        $stm->bindParam(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindParam(':ultimaAtualizacao', $this->ultimaAtualizacao);
        $stm->bindPAram(':idUser', $idUser, PDO::PARAM_INT);
        return ($stm->execute());
    }

    public function atualizarUserDetail($id) {
        $stm = DB::prepare("UPDATE $this->table SET " . "cpf = :cpf, " . "data_nascimento = :dataNascimento, " . "email_alternativo = :emailAlternativo, " . "apelido = :apelido, " . "telefone_fixo = :telefoneFixo, " . "telefone_celular = :telefoneCelular, " . "especialidades = :especialidades, " . "uf = :uf, " . "certificacao = :certificacao, " . "atualizado_por = :atualizadoPor, " . "ultima_atualizacao = :ultimaAtualizacao " . "WHERE id = :id");
        $stm->bindValue(':id', $id, PDO::PARAM_INT);
        $stm->bindValue(':cpf', $this->cpf, PDO::PARAM_STR);
        $stm->bindValue(':dataNascimento', $this->dataNascimento);
        $stm->bindValue(':emailAlternativo', $this->emailAlternativo, PDO::PARAM_STR);
        $stm->bindValue(':apelido', $this->apelido, PDO::PARAM_STR);
        $stm->bindValue(':telefoneFixo', $this->telefoneFixo, PDO::PARAM_STR);
        $stm->bindValue(':telefoneCelular', $this->telefoneCelular, PDO::PARAM_STR);
        $stm->bindValue(':especialidades', $this->especialidades, PDO::PARAM_STR);
        $stm->bindValue(':uf', $this->uf, PDO::PARAM_STR);
        $stm->bindValue(':certificacao', $this->certificacao, PDO::PARAM_STR);
        $stm->bindValue(':atualizadoPor', $this->atualizadoPor, PDO::PARAM_STR);
        $stm->bindValue(':ultimaAtualizacao', $this->ultimaAtualizacao);

        return ($stm->execute());
    }

    function getCompleteName($id) {
        $stm = DB::prepare("SELECT user_complete_name FROM $this->table WHERE user_id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    function getIDByEmail($idEmpresa, $idFornecedor, $userEmail) {
        $stm = DB::prepare("SELECT id_user FROM users_empresa WHERE id_empresa = $idEmpresa AND id_fornecedor = $idFornecedor AND user_email = '$userEmail'");
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

}
