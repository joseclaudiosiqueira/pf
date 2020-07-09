<?php

/**
 * Handles the user registration
 * @author Panique
 * @link http://www.php-login.net
 * @link https://github.com/panique/php-login-advanced/
 * @license http://opensource.org/licenses/MIT MIT License
 */
class Registration {

    /**
     *
     * @var object $db_connection The database connection
     */
    private $db_connection = null;

    /**
     *
     * @var bool success state of registration
     */
    public $registration_successful = false;

    /**
     *
     * @var bool success state of verification
     */
    public $verification_successful = false;

    /**
     *
     * @var array collection of error messages
     */
    public $errors = array();

    /**
     *
     * @var array collection of success / neutral messages
     */
    public $messages = array();

    public function __construct() {
        
    }

    /**
     * Checks if database connection is opened and open it if not
     */
    private function databaseConnection() {
        /*
         * connection already opened
         */
        if ($this->db_connection != null) {
            return true;
        } else {
            /*
             * create a database connection, using the constants from config/config.php
             */
            try {
                // Generate a database connection, using the PDO connector
                // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
                // Also important: We include the charset, as leaving it out seems to be a security issue:
                // @see http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers#Connecting_to_MySQL says:
                // "Adding the charset to the DSN is very important for security reasons,
                // most examples you'll see around leave it out. MAKE SURE TO INCLUDE THE CHARSET!"
                $this->db_connection = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
                return true;
                /*
                 * If an error is catched, database connection failed
                 */
            } catch (PDOException $e) {
                $this->errors [] = MESSAGE_DATABASE_ERROR;
                return false;
            }
        }
    }

    /**
     * handles the entire registration process.
     * checks all error possibilities, and creates a new user in the database if everything is fine
     */
    public function registerNewUser($user_name, $user_email, $id_empresa, $user_complete_name, $id_fornecedor, $id_cliente, $role_id, $is_id_existente, $user_id, $is_validar_adm_gestor, $opcao_identificador, $user_active, $user_activation_hash, $isInserirContagemAuditoria) {
        /*
         * array de retorno para tela de insercao
         */
        $arrJson = [];
        /*
         * pega os dados da empresa
         */
        $empresa = new Empresa ();
        $sigla = $empresa->getSigla($id_empresa);
        $atualizado_por = $_SESSION ['user_email'];
        $ultima_atualizacao = date('Y/m/d H:i:s');
        /*
         * variaveis do email
         */
        global $objEmail;
        /*
         * criptografia
         */
        global $converter;
        /*
         * check provided data validity
         * TODO: check for "return true" case early, so put this first
         */
        if (empty($user_name)) {
            $this->errors [] = MESSAGE_USERNAME_EMPTY;
        } elseif (strlen($user_name) < 2 || strlen($user_name) > 64) {
            $this->errors [] = MESSAGE_USERNAME_BAD_LENGTH;
        } elseif ($opcao_identificador && !preg_match('/^[a-z._\d]{2,64}$/i', $user_name)) {
            $this->errors [] = MESSAGE_USERNAME_INVALID;
        } elseif (!$opcao_identificador && !preg_match("/^[0-9]{11}$/", $user_name) && !validaCPF($user_name)) {
            $this->errors [] = MESSAGE_CPF_INVALID;
        } elseif (empty($user_email)) {
            $this->errors [] = MESSAGE_EMAIL_EMPTY;
        } elseif (strlen($user_email) > 255) {
            $this->errors [] = MESSAGE_EMAIL_TOO_LONG;
        } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $this->errors [] = MESSAGE_EMAIL_INVALID;
            // finally if all the above checks are ok
        } else if ($this->databaseConnection()) {
            /*
             * faz um select e verifica se ja existe um usuario com a chave primaria na tabela empresa (id_empresa, id_fornecedor, id_cliente
             */
            $query_existe_empresa = $this->db_connection->prepare("" . "SELECT id FROM users_empresa WHERE " . "id_empresa = '$id_empresa' AND " . "id_fornecedor = '$id_fornecedor' AND " . "id_cliente = '$id_cliente' AND " . "user_email = '$user_email'");
            $query_existe_empresa->execute();
            if ($query_existe_empresa->rowCount() > 0) {
                $this->errors [] = MESSAGE_IS_EXISTENTE;
            } else {
                /*
                 * se nao houver um id existente cria um usuario na tabela users
                 */
                if (!($is_id_existente)) {
                    $query_new_user_insert = $this->db_connection->prepare('' . 'INSERT INTO users (' . 'user_name, ' . 'user_registration_ip, ' . 'user_registration_datetime, ' . 'user_registration_email, ' . 'user_complete_name) ' . 'VALUES(' . ':user_name, ' . ':user_registration_ip, ' . 'now(), ' . ':user_registration_email, ' . ':user_complete_name)');
                    $query_new_user_insert->bindValue(':user_name', $user_name, PDO::PARAM_STR);
                    $query_new_user_insert->bindValue(':user_registration_ip', getRemoteAddr(), PDO::PARAM_STR);
                    $query_new_user_insert->bindValue(':user_registration_email', getEmailUsuarioLogado(), PDO::PARAM_STR);
                    $query_new_user_insert->bindValue(':user_complete_name', $user_complete_name, PDO::PARAM_STR);
                    $query_new_user_insert->execute();
                    /*
                     * id of new user
                     */
                    $user_id = $this->db_connection->lastInsertId();
                    /*
                     * atualiza a tabela com o hash que sera gerado a partir do ID e do Email
                     */
                    $user_activation_hash = $converter->encode($user_id . ';' . $user_email);
                    $query_update_hash = $this->db_connection->prepare("UPDATE users SET user_activation_hash = :user_activation_hash WHERE user_id = :user_id");
                    $query_update_hash->bindValue(':user_activation_hash', $user_activation_hash, PDO::PARAM_STR);
                    $query_update_hash->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                    $query_update_hash->execute();
                    /*
                     * insere um registro limpo na tabela user_detail para preenchimento posterior apenas se o id nao existir
                     */
                    $query_new_user_detail = $this->db_connection->prepare("INSERT INTO users_detail (id, " . ($opcao_identificador ? "" : "cpf, ") . "atualizado_por, " . "ultima_atualizacao) VALUES (" . ":userId, " . ($opcao_identificador ? "" : ":cpf, ") . ":atualizadoPor, " . ":ultimaAtualizacao)");
                    $query_new_user_detail->bindValue(':userId', $user_id, PDO::PARAM_INT);
                    $opcao_identificador ? NULL : $query_new_user_detail->bindValue(':cpf', $user_name, PDO::PARAM_STR);
                    $query_new_user_detail->bindValue(':atualizadoPor', $atualizado_por);
                    $query_new_user_detail->bindValue(':ultimaAtualizacao', $ultima_atualizacao);
                    $query_new_user_detail->execute();
                    /*
                     * realiza outras operacoes
                     */
                } else {
                    if (PRODUCAO) {
                        $subject = "Dimension :: Cadastro de perfil de usu&aacute;rio";
                        $mensagem = "" . "Prezado(a) Sr(a). $user_complete_name,<br /><br />A Empresa $sigla o(a) inseriu como um usu&aacute;rio no sistema de contagem de pontos de fun&ccedil;&atilde;o Dimension&reg;.<br />" . "Para acess&aacute;-lo basta ir ao link <a href='" . SITE_URL . "'>Dimension</a> e digitar seu login e senha.<br />" . "Notamos que voc&ecirc; j&aacute; &eacute; um usu&aacute;rio do sistema, por isso suas informa&ccedil;&otilde;es permanecem as mesmas." . (!($user_active) ? "Entretanto, percebemos tamb&eacute;m que voc&eacute; ainda n&atilde;o ativou seu usu&aacute;rio, fa&ccedil;a isso clicando " . "<a href='" . EMAIL_VERIFICATION_URL . '&i=' . $converter->encode($user_id . ';' . $user_email) . "'>AQUI</a>" : "") . "<br /><br />";
                        $verificationLink = sha1($mensagem . date('Ymdhis'));
                        /*
                         * envia o email
                         */
                        $objEmail->setEmail(array(
                            'emails' => array(
                                $user_email
                            ),
                            'subject' => $subject,
                            'mensagem' => $mensagem,
                            'verificationLink' => $verificationLink
                        ));

                        $objEmail->enviar();
                    }
                }
                /*
                 * insert into empresa (associa este usuario a esta empresa) agora coloca o fornecedor tambem
                 */
                $query_new_user_empresa = $this->db_connection->prepare("INSERT INTO users_empresa (" . "id_empresa, " . "id_fornecedor, " . "id_cliente, " . "id_user, " . "is_validar_adm_gestor, " . "is_inserir_contagem_auditoria, " . "user_email, " . "ultima_atualizacao, " . "atualizado_por) VALUES (" . ":id_empresa, " . ":id_fornecedor, " . ":id_cliente, " . ":id_user, " . ":is_validar_adm_gestor, " . ":is_inserir_contagem_auditoria, " . ":user_email, " . "'$ultima_atualizacao', " . "'$atualizado_por')");
                $query_new_user_empresa->bindValue(':id_empresa', $id_empresa, PDO::PARAM_INT);
                $query_new_user_empresa->bindValue(':id_fornecedor', $id_fornecedor, PDO::PARAM_INT);
                $query_new_user_empresa->bindValue(':id_cliente', $id_cliente, PDO::PARAM_INT);
                $query_new_user_empresa->bindValue(':id_user', $user_id, PDO::PARAM_INT);
                $query_new_user_empresa->bindValue(':is_validar_adm_gestor', $is_validar_adm_gestor, PDO::PARAM_INT);
                $query_new_user_empresa->bindValue(':is_inserir_contagem_auditoria', $isInserirContagemAuditoria, PDO::PARAM_INT);
                $query_new_user_empresa->bindValue(':user_email', $user_email);
                $query_new_user_empresa->execute();
                /*
                 * inserir na tabela rbac_userroles para que o usuario possa logar no sistema
                 */
                $query_new_user_role = $this->db_connection->prepare('INSERT INTO rbac_userroles (' . 'UserId, ' . 'RoleId, ' . 'AssignmentDate, ' . 'id_empresa, ' . 'id_fornecedor, ' . 'id_cliente, ' . 'ultima_atualizacao, ' . 'atualizado_por) VALUES (' . ':user_id, ' . ':role_id, ' . 'now(), ' . ':id_empresa, ' . ':id_fornecedor, ' . ':id_cliente, ' . ':ultimaAtualizacao, ' . ':atualizadoPor)');
                $query_new_user_role->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                $query_new_user_role->bindValue(':role_id', $role_id, PDO::PARAM_INT);
                $query_new_user_role->bindValue(':id_empresa', $id_empresa, PDO::PARAM_INT);
                $query_new_user_role->bindValue(':id_fornecedor', $id_fornecedor, PDO::PARAM_INT);
                $query_new_user_role->bindValue(':id_cliente', $id_cliente, PDO::PARAM_INT);
                $query_new_user_role->bindValue(':ultimaAtualizacao', $ultima_atualizacao);
                $query_new_user_role->bindValue(':atualizadoPor', $atualizado_por, PDO::PARAM_STR);
                $query_new_user_role->execute();
                /*
                 * inserir um registro na tabela usuario_historico
                 */
                $query_new_user_historico = $this->db_connection->prepare("INSERT INTO usuario_historico (" . "user_id, " . "id_empresa, " . "id_fornecedor, " . "id_cliente, " . "operacao, " . "atualizado_por, " . "ultima_atualizacao) VALUES (" . ":userId, " . ":idEmpresa, " . ":idFornecedor, " . ":idCliente, " . ":operacao, " . ":atualizadoPor, " . ":ultimaAtualizacao)");
                $query_new_user_historico->bindValue(':userId', $user_id, PDO::PARAM_INT);
                $query_new_user_historico->bindValue(':idEmpresa', $id_empresa, PDO::PARAM_INT);
                $query_new_user_historico->bindValue(':idFornecedor', $id_fornecedor, PDO::PARAM_INT);
                $query_new_user_historico->bindValue(':idCliente', $id_cliente, PDO::PARAM_INT);
                $query_new_user_historico->bindValue(':operacao', 'inserir', PDO::PARAM_STR);
                $query_new_user_historico->bindValue(':atualizadoPor', $atualizado_por, pdo::PARAM_STR);
                $query_new_user_historico->bindValue(':ultimaAtualizacao', $ultima_atualizacao);
                $query_new_user_historico->execute();
                /*
                 * TODO: !IMPORTANT! configurar o email do Dimension no ambiente de desenvolvimento
                 */
                $link = EMAIL_VERIFICATION_URL . '&i=' . $converter->encode($user_id . ';' . $user_email);
                /*
                 * manda apenas se for producao
                 */
                if (PRODUCAO) {
                    if ($query_new_user_insert) {
                        $subject = "Dimension :: Cadastro de perfil de usu&iacute;rio";
                        $mensagem = "" . "Prezado(a) Sr(a). $user_complete_name,<br /><br />A Empresa $sigla o(a) inseriu como um usu&aacute;rio no sistema de contagem de pontos de fun&ccedil;&atilde;o Dimension&reg;.<br />" . "Como &eacute; o cadastro inicial, voc&ecirc; precisa ativar o seu usu&aacute;rio, para isto clique <a href=\"$link\"><strong>AQUI</strong></a> e inicie o processo.<br />" . "<strong>Informa&ccedil;&atilde;o importante</strong>:<br />" . "&nbsp;&nbsp;&nbsp;-&nbsp;ID do Usu&aacute;rio ou CPF: $user_name;<br/>" . "&nbsp;&nbsp;&nbsp;-&nbsp;Email: $user_email.<br />" . "Utilize-os para se identificar/ativar seu usu&aacute;rio no sistema.";
                        $verificationLink = sha1($mensagem . date('Ymdhis'));
                        /*
                         * envia email
                         */
                        $objEmail->setEmail(array(
                            'emails' => array(
                                $user_email
                            ),
                            'subject' => $subject,
                            'mensagem' => $mensagem,
                            'verificationLink' => $verificationLink
                        ));
                        if ($objEmail->enviar()) {
                            /*
                             * when mail has been send successfully
                             */
                            $this->messages [] = MESSAGE_VERIFICATION_MAIL_SENT;
                            $this->registration_successful = true;
                        } else {
                            // By Dimension - nao deletar o usuario - entrar com suporte para habilitar novamente
                            // delete this users account immediately, as we could not send a verification email
                            // $query_delete_user = $this->db_connection->prepare('DELETE FROM users WHERE user_id=:user_id');
                            // $query_delete_user->bindValue(':user_id', $user_id, PDO::PARAM_INT);
                            // $query_delete_user->execute();
                            $this->errors [] = MESSAGE_VERIFICATION_MAIL_ERROR;
                        }
                    } else {
                        $this->errors [] = MESSAGE_REGISTRATION_FAILED;
                    }
                }
                /*
                 * confere tudo e envia mensagem de sucesso
                 */
                if ($user_id) {
                    $arrJson [] = array(
                        'msg' => 'sucesso',
                        'user_id' => $user_id,
                        'user_name' => $user_name,
                        'link' => (PRODUCAO ? '' : $link)
                    );
                } else {
                    $arrJson [] = $this->errors;
                }
            }
        }
        return $arrJson;
    }

    /**
     * checks the id/verification code combination and set the user's activation status to true (=1) in the database
     */
    public function verifyNewUser($user_id, $user_password, $user_activation_hash) {
        // global encryption
        global $converter;
        // if database connection opened
        if ($this->databaseConnection()) {
            // check if we have a constant HASH_COST_FACTOR defined (in config/hashing.php),
            // if so: put the value into $hash_cost_factor, if not, make $hash_cost_factor = null
            $hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);
            // crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character hash string
            // the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4, by the password hashing
            // compatibility library. the third parameter looks a little bit shitty, but that's how those PHP 5.5 functions
            // want the parameter: as an array with, currently only used with 'cost' => XX.
            $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT, array(
                'cost' => $hash_cost_factor
                    ));
            // try to update user with specified information
            $query_update_user = $this->db_connection->prepare('UPDATE users SET user_active = 1, user_activation_hash = NULL, user_password_hash = :user_password_hash WHERE user_id = :user_id AND user_activation_hash = :user_activation_hash');
            $query_update_user->bindValue(':user_id', intval(trim($converter->decode($user_id))), PDO::PARAM_INT);
            $query_update_user->bindValue(':user_password_hash', $user_password_hash, PDO::PARAM_STR);
            $query_update_user->bindValue(':user_activation_hash', $user_activation_hash, PDO::PARAM_STR);
            $query_update_user->execute();
            if ($query_update_user->rowCount() > 0) {
                $this->verification_successful = true;
                // $this->messages[] = MESSAGE_REGISTRATION_ACTIVATION_SUCCESSFUL;
            } else {
                $this->verification_successful = false;
                // $this->errors[] = MESSAGE_REGISTRATION_ACTIVATION_NOT_SUCCESSFUL;
            }
        }
        return $this->verification_successful;
    }

    /**
     *
     * @param string $tipo
     *        	'user_name' <user_email> nao eh mais utilizado </user_email>
     * @param string $info
     *        	nome ou email do usuario
     */
    public function verificaNomeEmailAtivacao($tipo, $info, $hash) {
        $arr = [];
        $query = '';
        // criptografia
        global $converter;
        // verifica conexao
        if ($this->databaseConnection()) {
            switch ($tipo) {
                case 'name':
                    /*
                     * inserido um like pois o base64 coloca alguns "=" no final da string
                     */
                    $query = $this->db_connection->prepare("SELECT user_id FROM users WHERE user_name= :user_name AND user_active = 0 AND user_activation_hash like '$hash%'");
                    $query->bindValue(':user_name', $info, PDO::PARAM_STR);
                    // $query->bindValue(':hash', $hash, PDO::PARAM_STR);
                    $query->execute();
                    $result = $query->fetchAll(PDO::FETCH_ASSOC);
                    if (count($result) > 0) {
                        $arr [] = array(
                            'success' => true,
                            'msg' => ''
                        );
                    } else {
                        $arr [] = array(
                            'success' => false,
                            'msg' => 'Este usu&aacute;rio n&atilde;o tem ativa&ccedil;&atilde;o pendente.'
                        );
                    }
                    break;
                case 'email' :
                    $var = explode(';', $converter->decode($hash));
                    $email = $var [1];
                    $arr [] = $email !== $info ? array(
                        'success' => false,
                        'msg' => 'O Email digitado n&atilde;o confere com o que est&aacute; registrado.'
                            ) : array(
                        'success' => true,
                        'msg' => ''
                    );
                    break;
            }
        } else {
            $arr [] = array(
                'success' => false,
                'msg' => 'Sem conex&atild;o ao banco de dados.'
            );
        }
        return $arr;
    }

    public function verificaNomeUsuario($user_name, $opcao = null) {
        // array com a resposta para o json
        $arrJson = [];
        // check if username or email already exists
        if ($this->databaseConnection()) {
            $query_check_user_name = $this->db_connection->prepare('SELECT user_name, user_id FROM users WHERE user_name = :user_name');
            $query_check_user_name->bindValue(':user_name', $user_name, PDO::PARAM_STR);
            $query_check_user_name->execute();
            $result = $query_check_user_name->fetchAll(PDO::FETCH_ASSOC);
            // verifica se ha um usuario com este nome
            if (count($result) > 0) {
                $arrJson [] = array(
                    'existe' => true,
                    'erro' => '',
                    'msg' => $opcao ? 'J&aacute; existe um usu&aacute;rio cadastrado com este ID &Uacute;nico.' : 'J&aacute; existe um usu&aacute;rio cadastrado com este CPF.',
                    'user_id' => $result [0] ['user_id'],
                    'user_name' => $result [0] ['user_name']
                );
            } else {
                $arrJson [] = array(
                    'erro' => '',
                    'existe' => false
                );
            }
        }
        return $arrJson;
    }

    public function verificaNomeUsuarioEmpresa($user_name) {
        /*
         * array com a resposta para o json
         */
        $arrJson = [];
        $existeDimension = false;
        /*
         * verifica se o nome/cpf existe no Dimension
         */
        if ($this->databaseConnection()) {
            /*
             * verifica se o usuario esta cadastrado na empresa e depois se esta cadastrado no Dimension (r)
             */
            $query_check_user_name = $this->db_connection->prepare('SELECT user_name, user_id, user_complete_name, user_active, user_activation_hash FROM users WHERE user_name = :user_name');
            $query_check_user_name->bindValue(':user_name', $user_name, PDO::PARAM_STR);
            $query_check_user_name->execute();
            $result = $query_check_user_name->fetchAll(PDO::FETCH_ASSOC);
            /*
             * verifica se ha um usuario com este nome
             */
            if (count($result) > 0) {
                /*
                 * existe no Dimension(r)
                 */
                $existeDimension = true;
                /*
                 * monta o json de resposta
                 */
                $arrJson [] = array(
                    'existeDimension' => $existeDimension,
                    'erro' => '',
                    'user_id' => $result [0] ['user_id'],
                    'user_name' => $result [0] ['user_name'],
                    'user_complete_name' => $result [0] ['user_complete_name'],
                    'user_active' => $result [0] ['user_active'],
                    'user_activation_hash' => $result [0] ['user_activation_hash']
                );
            } else {
                $arrJson [] = array(
                    'existeDimension' => false,
                    'erro' => '',
                    'msg' => '',
                    'user_id' => 0,
                    'user_name' => '',
                    'user_complete_name' => '',
                    'user_active' => 0,
                    'user_activation_hash' => ''
                );
            }
        }
        return $arrJson;
    }

    /**
     * Author: Jose Claudio
     * funcao que verifica se ja existe um email cadastrado no sistema e retorna true ou false
     * se existir um usuario o sistema alerta para a necessidade de adicao apenas do perfil
     * se existir associacao na empresa o sistema alerta para acessar as funcionalidades de alteracao de perfil
     *
     * @param string $userEmail
     * @return boolean
     */
    public function verificaEmailUsuario($userEmail, $userId, $idEmpresa = NULL, $idFornecedor = NULL, $idCliente = NULL) {
        /*
         * array com a resposta para o json
         */
        $arrJson = [];
        $isEmpresa = false;
        /*
         * verifica a conexao com o banco de dados
         */
        if ($this->databaseConnection()) {
            $query_check_user_empresa = $this->db_connection->prepare('SELECT id_user, id_empresa, user_email FROM users_empresa WHERE ' . 'user_email = :userEmail ' . (NULL !== $idEmpresa ? 'AND id_empresa = :idEmpresa ' : '') . (NULL !== $idFornecedor ? 'AND id_fornecedor = :idFornecedor' : '') . (NULL !== $idCliente ? 'AND id_cliente = :idCliente' : ''));
            $query_check_user_empresa->bindValue(':userEmail', $userEmail, PDO::PARAM_STR);
            NULL !== $idEmpresa ? $query_check_user_empresa->bindValue(':idEmpresa', $idEmpresa, PDO::PARAM_INT) : NULL;
            NULL !== $idFornecedor ? $query_check_user_empresa->bindValue(':idFornecedor', $idFornecedor, PDO::PARAM_INT) : NULL;
            NULL !== $idCliente ? $query_check_user_empresa->bindValue(':idCliente', $idCliente, PDO::PARAM_INT) : NULL;
            $query_check_user_empresa->execute();
            $result_empresa = $query_check_user_empresa->fetchAll(PDO::FETCH_ASSOC);
            /*
             * verifica se existe um email cadastrado para uma ou mais empresas
             */
            if (isset($result_empresa [0] ['id_user'])) {
                $isEmpresa = true;
                if ($userId > 0) {
                    /*
                     * pega o restante dos dados na tabela users no caso de comentarios, por exemplo
                     */
                    $query_check_user_email = $this->db_connection->prepare('SELECT user_id, user_name, user_complete_name FROM users WHERE user_id = :userId');
                    $query_check_user_email->bindValue(':userId', $userId, PDO::PARAM_STR);
                    $query_check_user_email->execute();
                    $result_email = $query_check_user_email->fetchAll(PDO::FETCH_ASSOC);
                }
            }
            // retorna
            $arrJson [] = array(
                'existe' => isset($result_empresa [0] ['id_user']) ? true : false,
                'existe_id' => isset($result_empresa [0] ['id_user']) ? true : false,
                'existe_empresa' => $isEmpresa,
                'user_id' => isset($result_empresa [0] ['id_user']) ? $result_empresa [0] ['id_user'] : 0,
                'user_name' => isset($result_email [0] ['user_name']) ? $result_email [0] ['user_name'] : '',
                'user_email' => $userEmail,
                'user_complete_name' => isset($result_email [0] ['user_complete_name']) ? $result_email [0] ['user_complete_name'] : ''
            );
        }
        return $arrJson;
    }

    public function getSiglaEmpresaUsuario($user_id) {
        $stm = $this->db_connection->prepare("SELECT sigla FROM empresa WHERE id = :id");
        $stm->bindParam(':id', $user_id, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['sigla'];
    }

    public function getSiglaFornecedorUsuario($user_id) {
        $stm = $this->db_connection->prepare("SELECT sigla FROM fornecedor WHERE id = :id");
        $stm->bindParam(':id', $user_id, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['sigla'];
    }

    public function isFornecedorAtivo($id) {
        $stm = $this->db_connection->prepare("SELECT is_ativo FROM fornecedor WHERE id = :id");
        $stm->bindParam(':id', $id, PDO::PARAM_INT);
        $stm->execute();
        $linha = $stm->fetch(PDO::FETCH_ASSOC);
        return $linha ['is_ativo'];
    }

    public function getEmpresaFornecedorUsuario($user_id, $user_email = null) {
        /*
         * variaveis iniciais
         */
        $arr = [];
        global $converter;
        /*
         * classes para pegar as siglas
         */
        $empresa = new Empresa ();
        $fornecedor = new Fornecedor ();
        $cliente = new Cliente ();
        $usuario = new Usuario ();
        /*
         * sql
         */
        $stm = $this->db_connection->prepare("" . "SELECT " . " ue.id_empresa, " . " ue.id_fornecedor," . " ue.id_cliente, " . " rb.RoleId " . "FROM " . " users_empresa ue, " . " users u, " . " rbac_userroles rb " . "WHERE " . " ue.id_user = u.user_id AND " . " ue.id_user = :userId AND " . " u.user_active = 1 AND " . " ue.is_ativo = 1 AND " . " rb.id_empresa = ue.id_empresa AND " . " rb.id_fornecedor = ue.id_fornecedor AND " . " rb.UserId = $user_id " . (isset($user_email) ? " AND " . " ue.user_email = :userEmail" : ""));
        isset($user_email) ? $stm->bindParam(':userEmail', $user_email) : NULL;
        $stm->bindParam(':userId', $user_id, PDO::PARAM_INT);
        $stm->execute();
        $ret = $stm->fetchAll(PDO::FETCH_ASSOC);
        /*
         * loop para pegar as empresas/clientes que o usuario eh ativo
         */
        foreach ($ret as $linha) {
            /*
             * monta a linha de sigla
             */
            $isFornecedor = $linha ['id_fornecedor'];
            $isFornecedorAtivo = $this->isFornecedorAtivo($linha ['id_fornecedor']);
            $siglaEmpresa = $empresa->getSigla($linha ['id_empresa']);
            $siglaFornecedor = $linha ['id_fornecedor'] && $isFornecedorAtivo ? $fornecedor->getSigla($linha ['id_fornecedor']) : 0;
            $siglaCliente = $linha ['id_cliente'] ? $cliente->getSigla($linha ['id_cliente']) : 0;
            $papelUsuario = $usuario->getUserRole($user_id, TRUE, $linha ['RoleId']);
            /*
             * concatena todas as siglas e verifica se o fornecedor esta ativo
             */
            if (!$isFornecedor) {
                $arr [] = array(
                    'existe' => TRUE,
                    'id' => $converter->encode($linha ['id_empresa'] . ';' . $linha ['id_fornecedor'] . ';' . $linha ['id_cliente'] . ';' . $linha ['RoleId'] . ';' . $user_id),
                    'sigla' => $siglaEmpresa . ($siglaFornecedor ? '&nbsp;&#187;&nbsp;' . $siglaFornecedor : '') . ($siglaCliente ? '&nbsp;&#187;&nbsp;' . $siglaCliente : '') . '&nbsp;&#187;&nbsp;' . $papelUsuario
                );
            } elseif ($isFornecedor && $isFornecedorAtivo) {
                $arr [] = array(
                    'existe' => TRUE,
                    'id' => $converter->encode($linha ['id_empresa'] . ';' . $linha ['id_fornecedor'] . ';' . $linha ['id_cliente'] . ';' . $linha ['RoleId'] . ';' . $user_id),
                    'sigla' => $siglaEmpresa . ($siglaFornecedor ? '&nbsp;&#187;&nbsp;' . $siglaFornecedor : '') . ($siglaCliente ? '&nbsp;&#187;&nbsp;' . $siglaCliente : '') . '&nbsp;&#187;&nbsp;' . $papelUsuario
                );
            }
        }
        return $arr;
    }

}
