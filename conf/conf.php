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
date_default_timezone_set('America/Sao_Paulo');
/*
 * testes no sistema e envio de log de erros
 */
define('DEBUG_MODE', FALSE);
/*
 * !IMPORTANTE! NENHUMA ACAO DEVE VIR ANTES DESTAS LINHAS
 * constante que define se o ambiente eh de producao ou nao
 * @DIR_FILE - define o diretorio de upload de arquivos para a producao ou desenvolvimento
 * em ambas as formas os arquivos ficam fora do servidor WEB atendido pelo apache
 */
define('DIR_PRODUCAO', '/storage/ssd1/524/4344524/');
define('DIR_DESENVOLVIMENTO', 'D:' . DIRECTORY_SEPARATOR . 'wamp64' . DIRECTORY_SEPARATOR . 'www' . DIRECTORY_SEPARATOR . 'pf' . DIRECTORY_SEPARATOR);
define('DIR_WAMP', 'C:' . DIRECTORY_SEPARATOR . 'wamp64' . DIRECTORY_SEPARATOR);
define('PRODUCAO', $_SERVER ['DOCUMENT_ROOT'] . (substr($_SERVER ['DOCUMENT_ROOT'], - 1) === '/' ? '' : '/') === 'D:/wamp64/www/' ? FALSE : TRUE );
define('DIR_BASE', PRODUCAO ? DIR_PRODUCAO . 'public_html/pf/' : DIR_DESENVOLVIMENTO );
/*
 * responsavel pela leitura das classes
 */
if (!function_exists('classAutoLoader')) {

    function classAutoLoader($class) {
        $classFile = DIR_BASE . 'classes/' . $class . '.php';
        $classFile2 = DIR_BASE . 'classes/dashboard/' . $class . '.php';
        $classFile3 = DIR_BASE . 'vendor/huge/classes/' . $class . '.php';
        if (is_file($classFile) && !class_exists($class)) {
            include $classFile;
        }
        if (is_file($classFile2) && !class_exists($class)) {
            include $classFile2;
        }
        if (is_file($classFile3) && !class_exists($class)) {
            include $classFile3;
        }
    }

    spl_autoload_register('classAutoLoader');
}
/*
 * define as outras constantes
 */
PRODUCAO ? define('DIR_TEMP', DIR_PRODUCAO . 'tmp/') : define('DIR_TEMP', DIR_WAMP . 'tmp/');
PRODUCAO ? define('DIR_UPLOAD', DIR_PRODUCAO . 'pf.upload/') : define('DIR_UPLOAD', DIR_WAMP . 'pf.upload/');
PRODUCAO ? define('DIR_UPLOAD_IMPORT', DIR_PRODUCAO . 'pf.upload/import/') : define('DIR_UPLOAD_IMPORT', DIR_WAMP . 'pf.upload/import/');
PRODUCAO ? define('DIR_FILE', DIR_PRODUCAO . 'pf.arquivos/') : define('DIR_FILE', DIR_WAMP . 'pf.arquivos/');
PRODUCAO ? define('DIR_VIDEO', DIR_PRODUCAO . 'pf.videos/') : define('DIR_VIDEO', DIR_WAMP . 'pf.videos/');
PRODUCAO ? define('DIR_CLASS', DIR_PRODUCAO . 'public_html/pf/classes/') : define('DIR_CLASS', DIR_WAMP . 'www/pf/classes/');
PRODUCAO ? define('DIR_APP', DIR_PRODUCAO . 'public_html/pf/') : define('DIR_APP', DIR_WAMP . 'www' . DIRECTORY_SEPARATOR . 'pf' . DIRECTORY_SEPARATOR);
// define os bancos de dados de producao e desenvolvimento
PRODUCAO ? define('BASE_DADOS', 'mysql') : define('BASE_DADOS', 'mysql');
// acesso aos bancos de dados de producao e desenvolvimento
if (PRODUCAO && BASE_DADOS === 'mysql') {
    // PRODUCAO
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'id4344524_pfdimension1');
    define('DB_USER', 'id4344524_pfdimension1');
    define('DB_PASS', 'Dimension2015');
    define('SITE_URL', 'https://pfdimension.000webhostapp.com/pf/');
} else {
    if (BASE_DADOS === 'mysql') {
        // DESENVOLVIMENTO
        define('DB_HOST', 'localhost');
        define('DB_NAME', 'pfdimension');
        define('DB_USER', 'id4344524_pfdimension1');
        define('DB_PASS', 'Dimension2015');
        define('SITE_URL', 'http://localhost/pf/');
    } elseif (BASE_DADOS === 'pgsql') {
        // DESENVOLVIMENTO
        define('DB_HOST', 'localhost');
        define('DB_NAME', 'pfdimension1');
        define('DB_USER', 'pfdimension1');
        define('DB_PASS', 'Dimension2015');
        define('SITE_URL', 'http://localhost/pf/');
    }
}
/*
 * includes
 */
require_once DIR_BASE . 'conf/functions.php';
require_once DIR_BASE . 'conf/functions_email.php';
require_once DIR_BASE . 'classes/Encryption.php';
// controle de acesso logins
require_once DIR_BASE . 'vendor/huge/config/config.php';
require_once DIR_BASE . 'vendor/huge/translations/pt_BR.php';
// sera substuituido pela classe geral PHPMail
require_once DIR_BASE . 'vendor/PHPMailer/PHPMailerAutoload.php';
// Leitura das classes do RBAC - Role Based Access Control
require_once DIR_BASE . 'vendor/huge/classes/Login.php';
require_once DIR_BASE . 'vendor/PhpRbac/autoload.php';
// leitura das classes para geracao dos boletos
require_once DIR_BASE . 'vendor/Boleto/autoloader.php';
// inclusao das classes do phpexcel
require_once DIR_BASE . 'vendor/PHPExcel/Classes/PHPExcel.php';
// inclusao da classe nusoap para o webservice
// require_once DIR_APP . 'vendor/nusoap/lib/nusoap.php';
// TODO: verificar outra biblioteca ou atualizar esta
/*
 * instancia do email
 */
$objEmail = Email::getInstance();
$objEmail->config();
/*
 * instancia o rbac
 */
$login = Login::getInstance();
/*
 * conversao para variaveis criptografadas
 */
$rbac = new \PhpRbac\Rbac ();
/*
 * cria o login para verificar o usuario
 */
$converter = Encryption::getInstance();
/*
 * include dos arrays de validacao dos arquivos permitidos, em separado para dimunir linhas no .conf
 */
require_once 'arr_actions.php';
require_once 'arr_api.php';
require_once 'arr_formulario.php';
require_once 'arr_subdiretorio.php';
require_once 'arr_tipo_chamada.php';
/*
 * verifica se esta logado
 */
if ($login->isUserLoggedIn()) {
    /*
     * verifica se o usuario pode inserir contagens de auditoria
     */
    $usuario = new Usuario ();
    $contagem = new Contagem ();
    $users_empresa = new UsersEmpresa ();
    $userId = getUserIdDecoded();
    $email = getEmailUsuarioLogado();
    $idEmpresa = getIdEmpresa();
    $idFornecedor = getIdFornecedor();
    $isFornecedor = isFornecedor();
    $cliente = new Cliente;
    /*
     * agora tem a necessidade de saber o roleId
     */
    $usuario->setRoleId(getVariavelSessao('role_id'));
    /*
     * agora pode pesquisar
     */
    $isInserirContagemAuditoria = $usuario->isInserirContagemAuditoria($userId, $idFornecedor);
    if (!(getVariavelSessao('is_inserir_contagem_auditoria'))) {
        setVariavelSessao('is_inserir_contagem_auditoria', $isInserirContagemAuditoria);
    }
    // estabelece o id ... empresa ou fornecedor e o id do cliente caso esteja atuando como fornecedor
    $id = isFornecedor() ? getIdFornecedor() : getIdEmpresa();
    // se for uma empresa tem que pegar o id cliente empresa
    $idClienteEmpresa = $cliente->getIdClienteEmpresa($idEmpresa)['id'];
    // id que eh do cliente exclusivo do fornecedor
    $idCliente = isFornecedor() ? getIdClienteFornecedor() : $idClienteEmpresa;
    // este id cliente eh o id que ser utilizado na contagem
    $idClienteContagem = isset($_GET ['icl']) ? $_GET ['icl'] : (isset($_GET ['ac']) && $_GET ['ac'] !== 'in' ? $contagem->getIdCliente($_GET ['id']) ['id_cliente'] : 0);
    // id da contagem no caso de alteracoes
    $idContagem = (isset($_GET ['id']) && NULL !== filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) ? filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) : 0;
    /*
     * instancia a classe de controle das variaveis da empresa
     */
    if (isFornecedor()) {
        $contagem_config = new ContagemFornecedorConfig ();
        // seta o id do fornecedor
        $contagem_config->setIdFornecedor(getIdFornecedor());
        // configuracoes do fornecedor
        $empresa_config_plano = new FornecedorConfigPlano();
        $empresa_config_plano->setIdFornecedor(getIdFornecedor());
        setIdCliente($idCliente);
    } else {
        $contagem_config = new ContagemConfig ();
        // seta o id da empresa
        $contagem_config->setIdEmpresa(getIdEmpresa());
        // configuracoes da empresa
        $empresa_config_plano = new EmpresaConfigPlano();
        $empresa_config_plano->setIdEmpresa(getIdEmpresa());
        // verifica se o usuario esta associado a um cliente e redefine o id_cliente na $_SESSION
        $isUsuarioCliente = $users_empresa->getIdClienteUsuario($idEmpresa, $idFornecedor, $userId);
        $idCliente = $isUsuarioCliente ? $isUsuarioCliente : $idCliente;
        setIdCliente($idCliente);
    }
    // tentativa de carregar o perfil do usuario apenas uma vez evitando varios selects nas listas e consultas
    if (!isset($_SESSION ['isPerfilSistema'])) {
        setVariavelSessao('isPerfilSistema', 1);
        setVariavelSessao('isAdministrador', $usuario->isAdministrador($userId));
        setVariavelSessao('isAdministradorFornecedor', $usuario->isAdministradorFornecedor($userId));
        setVariavelSessao('isAnalistaMetricas', $usuario->isAnalistaMetricas($userId));
        setVariavelSessao('isAnalistaMetricasFornecedor', $isFornecedor ? $usuario->isAnalistaMetricas($userId, $idFornecedor) : 0 );
        setVariavelSessao('isDiretor', $usuario->isDiretor($userId));
        setVariavelSessao('isFinanceiro', $usuario->isFinanceiro($userId));
        setVariavelSessao('isFiscalContratoCliente', $usuario->isFiscalContrato($userId));
        setVariavelSessao('isFiscalContratoFornecedor', $isFornecedor ? $usuario->isFiscalContratoFornecedor($userId, $idFornecedor) : 0 );
        setVariavelSessao('isFiscalContratoEmpresa', $usuario->isFiscalContratoEmpresa($userId));
        setVariavelSessao('isGerenteConta', $usuario->isGerenteConta($userId));
        setVariavelSessao('isGerenteContaFornecedor', $isFornecedor ? $usuario->isGerenteContaFornecedor($userId, $idFornecedor) : 0 );
        setVariavelSessao('isGerenteProjeto', $usuario->isGerenteProjeto($email, $id));
        // TODO: este select de isGerenteProjeto estah incorreto, CORRIGIR!
        // setVariavelSessao('isGerenteProjetoContagem',$usuario->isGerenteProjetoContagem($email, $idContagem));
        setVariavelSessao('isGerenteProjetoFornecedor', $isFornecedor ? $usuario->isGerenteProjetoFornecedor($userId, $idFornecedor) : 0 );
        setVariavelSessao('isGestor', $usuario->isGestor($userId));
        setVariavelSessao('isGestorFornecedor', $isFornecedor ? $usuario->isGestorFornecedor($userId, $idFornecedor) : 0 );
        setVariavelSessao('isInstrutor', $usuario->isInstrutor($userId));
        setVariavelSessao('isViewer', $usuario->isViewer($userId));
        // setar o role id para selecionar os comentarios - agora grava na sessao o RoleId (Login.php - linha 855) $usuario->getUserRoleId($userId)
        setVariavelSessao('roleId', getVariavelSessao('role_id'));
    }
    // faz apenas uma vez durante a sessao... refresh nao adianta, tem que fazer logout e login
    if (!(getVariavelSessao('perm'))) {
        setVariavelSessao('perm', $rbac->checkAll(getVariavelSessao('user_id'), getIdEmpresa(), getIdFornecedor(), getVariavelSessao('role_id')));
    }
    if (!(getVariavelSessao('empresa_config_plano'))) {
        setVariavelSessao('empresa_config_plano', $empresa_config_plano->getConfig());
    }
    // estas precisam do novo parametro id_cliente
    if (isset($_GET ['id']) || isset($_GET ['icl'])) {
        // configuracoes da contagem
        // isFornecedor() ? $idCliente : $idClienteContagem 
        $contagem_config->setIdCliente($idClienteContagem);
        setVariavelSessao('contagem_config', $contagem_config->getConfig());
        // configuracoes das tarefas
        $contagem_config_tarefas = new ContagemConfigTarefas ();
        $contagem_config_tarefas->setIdEmpresa(getIdEmpresa());
        $contagem_config_tarefas->setIdFornecedor(getIdFornecedor());
        $contagem_config_tarefas->setIdCliente(isFornecedor() ? $idCliente : $idClienteContagem );
        setVariavelSessao('contagem_config_tarefas', $contagem_config_tarefas->getConfig());
        // configuracoes do cocomo
        $contagem_config_cocomo = new ContagemConfigCocomo ();
        $contagem_config_cocomo->setIdEmpresa(getIdEmpresa());
        $contagem_config_cocomo->setIdCliente(isFornecedor() ? $idCliente : $idClienteContagem );
        setVariavelSessao('contagem_config_cocomo', $contagem_config_cocomo->getConfig());
        /*
         * aqui sempre mata a sessao
         */
        if (isset($_GET ['id']) && NULL !== filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)) {
            $contagem_estatisticas = new ContagemEstatisticas ();
            $contagem_estatisticas->setIdContagem($idContagem);
            $contagem_estatisticas_cocomo = new ContagemEstatisticasCocomo ();
            $contagem_estatisticas_cocomo->setIdContagem($idContagem);
            // pesquisa com um id setado
            setVariavelSessao('contagem_estatisticas', $contagem_estatisticas->getConfig());
            setVariavelSessao('contagem_estatisticas_cocomo', $contagem_estatisticas_cocomo->getConfig());
        } else {
            // entra aqui caso nao haja um id, ou seja, eh uma inclusao
            $contagem_estatisticas = new ContagemEstatisticas ();
            $contagem_config->setIdCliente(isFornecedor() ? $idCliente : $idClienteContagem );
            isFornecedor() ? $contagem_config->setIdFornecedor(getIdFornecedor()) : $contagem_config->setIdEmpresa(getIdEmpresa());
            // caso seja uma insercao vai nos defaults
            setVariavelSessao('contagem_estatisticas', $contagem_estatisticas->getConfig());
            setVariavelSessao('contagem_estatisticas_cocomo', $contagem_config_cocomo->getConfig());
        }
    } else {
        $contagem_config->setIdCliente($idCliente);
        !isset($_SESSION ['contagem_config']) ? setVariavelSessao('contagem_config', $contagem_config->getConfig()) : NULL;
        !isset($_SESSION ['contagem_config_cocomo']) ? setVariavelSessao('contagem_config_cocomo', []) : NULL;
        !isset($_SESSION ['contagem_estatisticas']) ? setVariavelSessao('contagem_estatisticas', []) : NULL;
        !isset($_SESSION ['contagem_estatisticas_cocomo']) ? setVariavelSessao('contagem_estatisticas_cocomo', []) : NULL;
    }
}
/*
 * desabilita os menus e links de acao da pagina de acordo com o perfil e a acao solicitada
 * $bt[0][0] - inserir/atualizar informacoes
 * $bt[0][1] - solicitar revisao
 * $bt[0][2] - observacoes (ver/inserir)
 * $bt[0][3][0] - validar interna
 * $bt[0][3][1] - validar externa
 * $bt[0][3][2] - auditar interna
 * $bt[0][3][3] - auditar externa
 * $bt[0][4] - botao do menu caso seja uma das quatro opcoes acima
 * $bt[0][5] - salvar revisao e enviar para validacao
 * $bt[0][6] - elaborar relatorio de validacao externa e auditorias interna/externa
 */
$bt = [];
/*
 * identifica a pagina de contagens
 */
$page_context = '';
/*
 * pagina de contexto para insercao / alteracao / validacao e auditoria nas contagens
 */
$array_page_context = [
    'nulo',
    'livre',
    'projeto',
    'baseline',
    'licitacao',
    'snap',
    'apt',
    'indicativa',
    'financeiro',
    'ef',
    'estimativa'
];
/*
 * pegar a acao logo aqui para facilitar as manipulacoes
 */
$ac = NULL !== filter_input(INPUT_GET, 'ac', FILTER_SANITIZE_STRING) ? filter_input(INPUT_GET, 'ac', FILTER_SANITIZE_STRING) : '';
/*
 * pegar a variavel aud (auditoria - contagem) aqui para facilitar as manipulacoes
 * essa variavel recebe apenas o valor 1 (um) ou entao false
 */
$isContagemAuditoria = NULL !== filter_input(INPUT_GET, 'aud', FILTER_SANITIZE_NUMBER_INT) && filter_input(INPUT_GET, 'aud', FILTER_SANITIZE_NUMBER_INT) == 1 ? filter_input(INPUT_GET, 'aud', FILTER_SANITIZE_NUMBER_INT) : FALSE;
/*
 * array para as funcoes nos botoes de acao
 *
 */
switch ($ac) {
    case 'vi' :
        $bt [0] [0] = 'disabled'; // inserir/atualizar informacoes
        $bt [0] [1] = ''; // solicitar revisao
        $bt [0] [2] = ''; // observacoes (ver/inserir)
        $bt [0] [3] [0] = ''; // validar interna
        $bt [0] [3] [1] = 'disabled'; // validar externa
        $bt [0] [3] [2] = 'disabled'; // auditar interna
        $bt [0] [3] [3] = 'disabled'; // auditar externa
        $bt [0] [4] = 'disabled'; // finalizar revisao
        $bt [0] [5] = 'disabled'; // finalizar edicao compartilhada
        $bt [0] [6] = ''; // permite inserir apontes
        break;
    case 've' :
        $bt [0] [0] = 'disabled'; // inserir/atualizar informacoes
        $bt [0] [1] = ''; // solicitar revisao
        $bt [0] [2] = ''; // observacoes (ver/inserir)
        $bt [0] [3] [0] = 'disabled'; // validar interna
        $bt [0] [3] [1] = ''; // validar externa
        $bt [0] [3] [2] = 'disabled'; // auditar interna
        $bt [0] [3] [3] = 'disabled'; // auditar externa
        $bt [0] [4] = 'disabled'; // finalizar revisao
        $bt [0] [5] = 'disabled'; // finalizar edicao compartilhada
        $bt [0] [6] = ''; // relatorios de validacoes e auditorias
        break;
    case 'ai' :
        $bt [0] [0] = 'disabled'; // inserir/atualizar informacoes
        $bt [0] [1] = 'disabled'; // solicitar revisao
        $bt [0] [2] = ''; // observacoes (ver/inserir)
        $bt [0] [3] [0] = 'disabled'; // validar interna
        $bt [0] [3] [1] = 'disabled'; // validar externa
        $bt [0] [3] [2] = ''; // auditar interna
        $bt [0] [3] [3] = 'disabled'; // auditar externa
        $bt [0] [4] = 'disabled'; // finalizar revisao
        $bt [0] [5] = 'disabled'; // finalizar edicao compartilhada
        $bt [0] [6] = ''; // relatorios de validacoes e auditorias
        break;
    case 'ae' :
        $bt [0] [0] = 'disabled'; // inserir/atualizar informacoes
        $bt [0] [1] = 'disabled'; // solicitar revisao
        $bt [0] [2] = ''; // observacoes (ver/inserir)
        $bt [0] [3] [0] = 'disabled'; // validar interna
        $bt [0] [3] [1] = 'disabled'; // validar externa
        $bt [0] [3] [2] = 'disabled'; // auditar interna
        $bt [0] [3] [3] = ''; // auditar externa
        $bt [0] [4] = 'disabled'; // finalizar revisao
        $bt [0] [5] = 'disabled'; // finalizar edicao compartilhada
        $bt [0] [6] = ''; // relatorios de validacoes e auditorias
        break;
    case 'in' :
        $bt [0] [0] = ''; // inserir/atualizar informacoes
        $bt [0] [1] = 'disabled'; // solicitar revisao
        $bt [0] [2] = ''; // observacoes (ver/inserir)
        $bt [0] [3] [0] = 'disabled'; // validar interna
        $bt [0] [3] [1] = 'disabled'; // validar externa
        $bt [0] [3] [2] = 'disabled'; // auditar interna
        $bt [0] [3] [3] = 'disabled'; // auditar externa
        $bt [0] [4] = 'disabled'; // finalizar revisao
        $bt [0] [5] = 'disabled'; // finalizar edicao compartilhada
        $bt [0] [6] = 'disabled'; // relatorios de validacoes e auditorias
        setIdContagem(0);
        break;
    case 'al' :
        $bt [0] [0] = ''; // inserir/atualizar informacoes
        $bt [0] [1] = 'disabled'; // solicitar revisao
        $bt [0] [2] = ''; // observacoes (ver/inserir)
        $bt [0] [3] [0] = 'disabled'; // validar interna
        $bt [0] [3] [1] = 'disabled'; // validar externa
        $bt [0] [3] [2] = 'disabled'; // auditar interna
        $bt [0] [3] [3] = 'disabled'; // auditar externa
        $bt [0] [4] = 'disabled'; // finalizar revisao
        $bt [0] [5] = 'disabled'; // finalizar edicao compartilhada
        $bt [0] [6] = 'disabled'; // relatorios de validacoes e auditorias
        break;
    case 're' :
        $bt [0] [0] = ''; // inserir/atualizar informacoes
        $bt [0] [1] = 'disabled'; // solicitar revisao
        $bt [0] [2] = ''; // observacoes (ver/inserir)
        $bt [0] [3] [0] = 'disabled'; // validar interna
        $bt [0] [3] [1] = 'disabled'; // validar externa
        $bt [0] [3] [2] = 'disabled'; // auditar interna
        $bt [0] [3] [3] = 'disabled'; // auditar externa
        $bt [0] [4] = ''; // finalizar revisao
        $bt [0] [5] = 'disabled'; // finalizar edicao compartilhada
        $bt [0] [6] = 'disabled'; // relatorios de validacoes e auditorias
        break;
    default :
        $bt [0] [0] = 'disabled'; // inserir/atualizar informacoes
        $bt [0] [1] = 'disabled'; // solicitar revisao
        $bt [0] [2] = 'disabled'; // observacoes (ver/inserir)
        $bt [0] [3] [0] = 'disabled'; // validar interna
        $bt [0] [3] [1] = 'disabled'; // validar externa
        $bt [0] [3] [2] = 'disabled'; // auditar interna
        $bt [0] [3] [3] = 'disabled'; // auditar externa
        $bt [0] [4] = 'disabled'; // finalizar revisao
        $bt [0] [5] = 'disabled'; // finalizar edicao compartilhada
        $bt [0] [6] = 'disabled'; // relatorios de validacoes e auditorias
}