<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER ['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}

function getConexaoBanco() {
    // define os bancos de dados de producao e desenvolvimento
    PRODUCAO ? define('BASE_DADOS', 'mysql') : define('BASE_DADOS', 'mysql');
    // acesso aos bancos de dados de producao e desenvolvimento
    if (PRODUCAO) {
        // PRODUCAO
        define('DB_HOST', 'mysql01.pfdimension1.hospedagemdesites.ws');
        define('DB_NAME', 'pfdimension1');
        define('DB_USER', 'pfdimension1');
        define('DB_PASS', 'Dimension2015');
    } else {
        // DESENVOLVIMENTO
        define('DB_HOST', 'localhost');
        define('DB_NAME', 'pfdimension1');
        define('DB_USER', 'pfdimension1');
        define('DB_PASS', 'Dimension2015');
    }
}

function sec_session_start() {
    $session_name = md5('DIM.' . $_SERVER ['REMOTE_ADDR'] . $_SERVER ['HTTP_USER_AGENT']);
    /*
     * no use this
     *
     * if (!(ini_set('session.use_only_cookies', 1))) {
     * header('Location: /pf/nao_autorizado.php');
     * exit();
     * }
     * session_set_cookie_params(
     * ini_get('session.cookie_lifetime'), ini_get('session.cookie_path'), ini_get('session.cookie_domain'), TRUE, TRUE);
     *
     */
    session_name($session_name);
    session_start();
    // TODO: session_regenerate_id(); //nao esta atualizado a sessao
}

/*
 * verificacao do status do login
 */

function verificaSessao() {
    $nome_sessao = md5('DIM.' . $_SERVER ['REMOTE_ADDR'] . $_SERVER ['HTTP_USER_AGENT']);
    if ($nome_sessao !== $_SESSION ['nome_sessao']) {
        return FALSE;
    }
    return TRUE;
}

/*
 * limpa o php_self
 */

function esc_url($url) {
    if ('' == $url) {
        return $url;
    }
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
    $strip = array(
        '%0d',
        '%0a',
        '%0D',
        '%0A'
    );
    $url = (string) $url;
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
    $url = str_replace(';//', '://', $url);
    $url = htmlentities($url);
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
    if ($url [0] !== '/') {
        return '';
    } else {
        return $url;
    }
}

function getVariavelSessao($variavel) {
    return isset($_SESSION ["$variavel"]) ? $_SESSION ["$variavel"] : FALSE;
}

function setVariavelSessao($variavel, $valor) {
    $_SESSION ["$variavel"] = $valor;
}

function getNome($nome) {
    $nm_temp = explode(" ", $nome);
    $nm_1 = $nm_temp [0];
    if (isset($nm_temp [1])) {
        if (strlen($nm_temp [1]) <= 3) {
            if (isset($nm_temp [2])) {
                $nm_2 = $nm_temp [1] . ' ' . $nm_3 = $nm_temp [2];
            }
        } else {
            $nm_2 = $nm_temp [1];
        }
    }
    return $nm_1 . ' ' . $nm_2;
}

function getNomeCurto($nome) {
    $nm_temp = explode(" ", $nome);
    $nm_1 = $nm_temp [0];
    return $nm_1;
}

function getCompleteName() {
    return $_SESSION ['complete_name'];
}

function getPathEmpresaFornecedor() {
    return $_SESSION ['path_empresa_fornecedor'];
}

function getPathEmpresaTurma() {
    return $_SESSION ['path_empresa_turma'];
}

function getIdEmpresa() {
    return isset($_SESSION ['id_empresa']) ? $_SESSION ['id_empresa'] : 0;
}

function getIdFornecedor() {
    return $_SESSION ['id_fornecedor'];
}

function getIdTurma() {
    return $_SESSION ['id_turma'];
}

function isSetIdCliente() {
    return (isset($_SESSION ['id_cliente']) && (int) $_SESSION ['id_cliente'] > 0) ? TRUE : FALSE;
}

function getIdCliente() {
    return $_SESSION ['id_cliente'];
}

function setIdCliente($idClienteFornecedor) {
    $_SESSION ['id_cliente'] = $idClienteFornecedor;
}

function getIdContagem() {
    return $_SESSION ['id_contagem'];
}

function setIdContagem($id) {
    $_SESSION ['id_contagem'] = $id;
}

function getConfigPlano($config) {
    return isset($_SESSION ['empresa_config_plano'] [$config]) ? $_SESSION ['empresa_config_plano'] [$config] : NULL;
}

function getConfigContagem($config) {
    return isset($_SESSION ['contagem_config'] [$config]) ? $_SESSION ['contagem_config'] [$config] : NULL;
}

function getEmpresaConfigPlano($config) {
    return isset($_SESSION ['empresa_config_plano'] [$config]) ? $_SESSION ['empresa_config_plano'] [$config] : NULL;
}

function getAdministrador($idEmpresa) {
    return 'Em desenvolvimento';
}

function isFornecedor() {
    return $_SESSION ['is_fornecedor'];
}

function getTipoFornecedor() {
    return $_SESSION ['tipo_fornecedor'];
}

function getPermissao($perm) {
    return in_array_r($perm, $_SESSION ['perm']);
}

function isTurma() {
    return $_SESSION ['is_turma'];
}

function isValidarAdmGestor() {
    return $_SESSION ['contagem_config'] ['is_validar_adm_gestor'];
}

function getEmailUsuarioLogado() {
    return $_SESSION ['user_email'];
}

function getUserId() {
    global $converter;
    return $converter->encode($_SESSION ['user_id']);
}

function getUserIdDecoded() {
    return $_SESSION ['user_id'];
}

function getUserIdSha1() {
    return sha1($_SESSION ['user_id']);
}

function getUserName() {
    return sha1($_SESSION ['user_name']);
}

function getUserRole($decoded = false) {
    global $converter;
    return $decoded ? $_SESSION ['user_role'] : $converter->encode($_SESSION ['user_role']);
}

function isPermitido($permissao) {
    return in_array_r($permissao, $_SESSION ['perm']);
}

function getIdClienteFornecedor() {
    $stm = DB::prepare("SELECT id FROM cliente WHERE id_empresa = :idEmpresa AND id_fornecedor = :idFornecedor");
    $idEmpresa = getIdEmpresa();
    $idFornecedor = getIdFornecedor();
    $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
    $stm->bindParam(':idFornecedor', $idFornecedor, PDO::PARAM_INT);
    $stm->execute();
    $linha = $stm->fetch(PDO::FETCH_ASSOC);
    return $linha ['id'];
}

function getIdClienteTurma() {
    $stm = DB::prepare("SELECT id FROM cliente WHERE id_empresa = :idEmpresa AND id_turma = :idTurma");
    $idEmpresa = getIdEmpresa();
    $idTurma = getIdTurma();
    $stm->bindParam(':idEmpresa', $idEmpresa, PDO::PARAM_INT);
    $stm->bindParam(':idTurma', $idTurma, PDO::PARAM_INT);
    $stm->execute();
    $linha = $stm->fetch(PDO::FETCH_ASSOC);
    return $linha ['id'];
}

function getGravatarImageUser($id) {
    $file = DIR_BASE . 'vendor/cropper/producao/crop/img/img-user/' . $id . '.png';
    $avatar = '/pf/img/user.jpg';
    if (file_exists($file)) {
        $avatar = '/pf/vendor/cropper/producao/crop/img/img-user/' . $id . '.png?' . time();
    } else {
        $avatar = '/pf/img/user.png';
    }
    return $avatar;
}

function getProdutividade() {
    return $_SESSION ['contagem_config'] ['produtividade_global'];
}

function isProdutividadeGlobal() {
    return $_SESSION ['contagem_config'] ['is_produtividade_global'];
}

function isAlterarProdutividadeGlobal() {
    return $_SESSION ['contagem_config'] ['is_alterar_produtividade_global'];
}

function isVisualizarSugestaoLinguagem() {
    return $_SESSION ['contagem_config'] ['is_visualizar_sugestao_linguagem'];
}

function getConfigCocomo($config) {
    return is_float($config) ? number_format($_SESSION ['contagem_config_cocomo'] [$config], 2) : $_SESSION ['contagem_config_cocomo'] [$config];
}

function getEstatisticasCocomo($config) {
    return $_SESSION ['contagem_estatisticas_cocomo'] [$config];
}

/**
 *
 * @param String $item
 * @param Array $array
 * @return boolean
 */
function in_array_r($item, $array) {
    return preg_match('/"' . $item . '"/i', json_encode($array));
}

if (!function_exists('classAutoLoader')) {

    function classAutoLoader($class) {
        $classFile = $_SERVER ['DOCUMENT_ROOT'] . 'pf/classes/' . $class . '.php';
        $classFile2 = $_SERVER ['DOCUMENT_ROOT'] . 'pf/classes/dashboard/' . $class . '.php';
        $classFile3 = $_SERVER ['DOCUMENT_ROOT'] . 'pf/vendor/huge/classes/' . $class . '.php';
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

function semAcento($palavra) {
    return ereg_replace("[^a-zA-Z0-9_.]", "", strtr($palavra, "Ã¡Ã Ã£Ã¢Ã©ÃªÃ­Ã³Ã´ÃµÃºÃ¼Ã§Ã�Ã€ÃƒÃ‚Ã‰ÃŠÃ�Ã“Ã”Ã•ÃšÃœÃ‡ ", "aaaaeeiooouucAAAAEEIOOOUUC_"));
}

function tamanhoArquivo($tamanho) {
    $kb = 1024;
    $mb = 1048576;
    $gb = 1073741824;
    $tb = 1099511627776;
    $rt = '';
    if ($tamanho < $kb) {
        $rt = $tamanho . " bytes";
    } else if ($tamanho >= $kb && $tamanho < $mb) {
        $kilo = number_format($tamanho / $kb, 2);
        $rt = $kilo . " KB";
    } else if ($tamanho >= $mb && $tamanho < $gb) {
        $mega = number_format($tamanho / $mb, 2);
        $rt = $mega . " MB";
    } else if ($tamanho >= $gb && $tamanho < $tb) {
        $giga = number_format($tamanho / $gb, 2);
        $rt = $giga . " GB";
    }
    return $rt;
}

function getEspacoDisco($dir_name) {
    $dir_size = 0;
    if (is_dir($dir_name)) {
        if ($dh = opendir($dir_name)) {
            while (($file = readdir($dh)) !== false) {
                if ($file != "." && $file != "..") {
                    if (is_file($dir_name . "/" . $file)) {
                        $dir_size += filesize($dir_name . "/" . $file);
                    }
                    /* check for any new directory inside this directory */
                    if (is_dir($dir_name . "/" . $file)) {
                        $dir_size += getEspacoDisco($dir_name . "/" . $file);
                    }
                }
            }
        }
    }
    isset($dh) ? closedir($dh) : NULL;
    return $dir_size;
}

function downloadFile($file, $isVideo) { // $file = include path
    if (file_exists($file) && $isVideo) {
        header("Content-type: video/webm");
        header("Content-Disposition:attachment;filename=\"$file\"");
        header("Content-length: " . filesize($file) . "\n\n");
        echo file_get_contents($file);
    }
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit();
    } else {
        header($_SERVER ["SERVER_PROTOCOL"] . " 404 Not Found");
    }
}

function decode($string) {
    return html_entity_decode($string, ENT_QUOTES);
}

/*
 * funcao de conexao com o LDAP
 * "dc=gov,dc=br"
 */

function checkldapuser($username, $password, $ldapserver, $ldapport, $ldapdomain) {
    $msg = array();
    $msg ['LDAP_SERVER'] = $ldapserver;
    $msg ['LDAP_PORT'] = $ldapport;
    $msg ['DOMAIN'] = $ldapdomain;
    $msg ['USERNAME'] = $username;
    $msg ['PASSWORD'] = 'Ok';
    $retorno = true;

    if ($connect = @ldap_connect($ldapserver)) { // if connected to ldap server
        if (ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3)) {
            $msg ['LDAP_OPT_PROTOCOL_VERSION'] = 3;
        } else {
            $msg ['LDAP_OPT_PROTOCOL_VERSION'] = 2;
        }
        // bind to ldap connection
        if (($bind = @ldap_bind($connect)) == false) {
            $msg ['BIND'] = "__FAILED__";
            $retorno = false;
        } else {
            $msg ['BIND'] = "BIND - Ok";
        }
        // search for user
        if (($res_id = @ldap_search($connect, $domain, "uid=$username")) == false) {
            $msg ['SEARCH'] = "Falha na busca em &aacute;rvore";
            $retorno = false;
        } else {
            $msg ['SEARCH'] = "SEARCH - Ok";
        }

        if (@ldap_count_entries($connect, $res_id) > 1) {
            $msg ['MORE_THAN_ONCE'] = "O usu&aacute;rio $username est&aacute; duplicado no LDAP";
            $retorno = false;
        } elseif (@ldap_count_entries($connect, $res_id) == 0) {
            $msg ['MORE_THAN_ONCE'] = 'MORE THAN ONCE - Usu&aacute;rio n&atilde;o encontrado';
        } else {
            $msg ['MORE_THAN_ONCE'] = "MORE THAN ONCE - Ok";
        }

        if (($entry_id = @ldap_first_entry($connect, $res_id)) == false) {
            $msg ['SEARCH_RESULT'] = "O resultado da consulta n&atilde;o pode ser extra&iacute;do";
            $retorno = false;
        } else {
            $msg ['SEARCH_RESULT'] = "SEARCH RESULT - Ok";
        }

        if (($user_dn = @ldap_get_dn($connect, $entry_id)) == false) {
            $msg ['USER_DN'] = "O USER-DN n&atilde;o pode ser extra&iacute;do";
            $retorno = false;
        } else {
            $msg ['USER_DN'] = "USER_DN - Ok";
        }

        if (($link_id = @ldap_bind($connect, $user_dn, $password)) == false) {
            $msg ['BIND'] = "Usu&aacute;rio e/ou Senha inv&aacute;lidos ";
            $retorno = false;
        } else {
            $msg ['BIND'] = "USER &amp;&amp; PASSWORD - Ok";
        }

        if ($retorno) {
            $msg ['STATUS'] = "<strong>Conex&atilde;o ao LDAP foi feita com sucesso!</strong>";
        } else {
            $msg ['STATUS'] = "<strong>Verifique os erros exibidos no LOG!</strong>";
        }
    } else { // no conection to ldap server
        $msg ['NO_CONNECTION'] = "Sem conex&atilde;o ao servidor: $ldapserver";
    }

    @ldap_close($connect);

    return $msg;
}

/*
 * funcao para validacao do CPF
 */

function validaCPF($cpf) {
    // determina um valor inicial para o digito $d1 e $d2
    // pra manter o respeito ;)
    $d1 = 0;
    $d2 = 0;
    // remove tudo que nÃ£o seja numero
    $cpf = preg_replace("/[^0-9]/", "", $cpf);
    // lista de cpf invalidos que serao ignorados
    $ignore_list = array(
        '00000000000',
        '01234567890',
        '11111111111',
        '22222222222',
        '33333333333',
        '44444444444',
        '55555555555',
        '66666666666',
        '77777777777',
        '88888888888',
        '99999999999'
    );
    // se o tamanho da string for dirente de 11 ou estiver
    // na lista de cpf ignorados jÃ¡ retorna false
    if (strlen($cpf) != 11 || in_array($cpf, $ignore_list)) {
        return false;
    } else {
        // inicia o processo para achar o primeiro
        // nÃºmero verificador usando os primeiros 9 dÃ­gitos
        for ($i = 0; $i < 9; $i ++) {
            // inicialmente $d1 vale zero e Ã© somando.
            // O loop passa por todos os 9 dÃ­gitos iniciais
            $d1 += $cpf [$i] * (10 - $i);
        }
        // acha o resto da divisÃ£o da soma acima por 11
        $r1 = $d1 % 11;
        // se $r1 maior que 1 retorna 11 menos $r1 se nÃ£o
        // retona o valor zero para $d1
        $d1 = ($r1 > 1) ? (11 - $r1) : 0;
        // inicia o processo para achar o segundo
        // nÃºmero verificador usando os primeiros 9 dÃ­gitos
        for ($i = 0; $i < 9; $i ++) {
            // inicialmente $d2 vale zero e Ã© somando.
            // O loop passa por todos os 9 dÃ­gitos iniciais
            $d2 += $cpf [$i] * (11 - $i);
        }
        // $r2 serÃ¡ o resto da soma do cpf mais $d1 vezes 2
        // dividido por 11
        $r2 = ($d2 + ($d1 * 2)) % 11;
        // se $r2 mair que 1 retorna 11 menos $r2 se nÃ£o
        // retorna o valor zeroa para $d2
        $d2 = ($r2 > 1) ? (11 - $r2) : 0;
        // retona true se os dois Ãºltimos dÃ­gitos do cpf
        // forem igual a concatenaÃ§Ã£o de $d1 e $d2 e se nÃ£o
        // deve retornar false.
        return (substr($cpf, - 2) == $d1 . $d2) ? true : false;
    }
}

/*
 * retorna a url atual solicitada
 */

function getURL() {
    $urlAtual = "http" . (isset($_SERVER ['HTTPS']) ? (($_SERVER ['HTTPS'] == "on") ? "s" : "") : "") . "://" . $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
    return $urlAtual;
}

class clsTexto {

    public static function valorPorExtenso($valor = 0, $bolExibirMoeda = false, $bolPalavraFeminina = false) {
        $valor = self::removerFormatacaoNumero($valor);
        $singular = null;
        $plural = null;
        if ($bolExibirMoeda) {
            $singular = array(
                "centavo",
                "real",
                "mil",
                "milhÃ£o",
                "bilhÃ£o",
                "trilhÃ£o",
                "quatrilhÃ£o"
            );
            $plural = array(
                "centavos",
                "reais",
                "mil",
                "milhÃµes",
                "bilhÃµes",
                "trilhÃµes",
                "quatrilhÃµes"
            );
        } else {
            $singular = array(
                "",
                "",
                "mil",
                "milhÃ£o",
                "bilhÃ£o",
                "trilhÃ£o",
                "quatrilhÃ£o"
            );
            $plural = array(
                "",
                "",
                "mil",
                "milhÃµes",
                "bilhÃµes",
                "trilhÃµes",
                "quatrilhÃµes"
            );
        }
        $c = array(
            "",
            "cem",
            "duzentos",
            "trezentos",
            "quatrocentos",
            "quinhentos",
            "seiscentos",
            "setecentos",
            "oitocentos",
            "novecentos"
        );
        $d = array(
            "",
            "dez",
            "vinte",
            "trinta",
            "quarenta",
            "cinquenta",
            "sessenta",
            "setenta",
            "oitenta",
            "noventa"
        );
        $d10 = array(
            "dez",
            "onze",
            "doze",
            "treze",
            "quatorze",
            "quinze",
            "dezesseis",
            "dezesete",
            "dezoito",
            "dezenove"
        );
        $u = array(
            "",
            "um",
            "dois",
            "trÃªs",
            "quatro",
            "cinco",
            "seis",
            "sete",
            "oito",
            "nove"
        );
        if ($bolPalavraFeminina) {
            if ($valor == 1) {
                $u = array(
                    "",
                    "uma",
                    "duas",
                    "trÃªs",
                    "quatro",
                    "cinco",
                    "seis",
                    "sete",
                    "oito",
                    "nove"
                );
            } else {
                $u = array(
                    "",
                    "um",
                    "duas",
                    "trÃªs",
                    "quatro",
                    "cinco",
                    "seis",
                    "sete",
                    "oito",
                    "nove"
                );
            }
            $c = array(
                "",
                "cem",
                "duzentas",
                "trezentas",
                "quatrocentas",
                "quinhentas",
                "seiscentas",
                "setecentas",
                "oitocentas",
                "novecentas"
            );
        }
        $z = 0;
        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);
        for ($i = 0; $i < count($inteiro); $i ++) {
            for ($ii = mb_strlen($inteiro [$i]); $ii < 3; $ii ++) {
                $inteiro [$i] = "0" . $inteiro [$i];
            }
        }
        // $fim identifica onde que deve se dar junÃ§Ã£o de centenas por "e" ou por "," ;)
        $rt = null;
        $fim = count($inteiro) - ($inteiro [count($inteiro) - 1] > 0 ? 1 : 2);
        for ($i = 0; $i < count($inteiro); $i ++) {
            $valor = $inteiro [$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c [$valor [0]];
            $rd = ($valor [1] < 2) ? "" : $d [$valor [1]];
            $ru = ($valor > 0) ? (($valor [1] == 1) ? $d10 [$valor [2]] : $u [$valor [2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " v&iacute;rgula " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count($inteiro) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural [$t] : $singular [$t]) : "";
            if ($valor == "000")
                $z ++;
            elseif ($z > 0)
                $z --;

            if (($t == 1) && ($z > 0) && ($inteiro [0] > 0))
                $r .= (($z > 1) ? " de " : "") . $plural [$t];

            if ($r)
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro [0] > 0) && ($z < 1)) ? (($i < $fim) ? ", " : " v&iacute;rgula ") : " ") . $r;
        }
        $rt = mb_substr($rt, 1);
        return ($rt ? trim($rt) : "zero");
    }

    public static function removerFormatacaoNumero($strNumero) {
        $strNumero = trim(str_replace("R$", null, $strNumero));
        $vetVirgula = explode(",", $strNumero);
        if (count($vetVirgula) == 1) {
            $acentos = array(
                "."
            );
            $resultado = str_replace($acentos, "", $strNumero);
            return $resultado;
        } else if (count($vetVirgula) != 2) {
            return $strNumero;
        }
        $strNumero = $vetVirgula [0];
        $strDecimal = mb_substr($vetVirgula [1], 0, 2);
        $acentos = array(
            "."
        );
        $resultado = str_replace($acentos, "", $strNumero);
        $resultado = $resultado . "." . $strDecimal;
        return $resultado;
    }

}

function pInv() {
    return json_encode(array(
        'msg' => 'Os par&acirc;metros s&atilde;o inv&aacute;lidos!',
        'alerta' => true
            ));
}

function tirarAcentos($string) {
    return preg_replace(array(
        "/(Ã¡|Ã |Ã£|Ã¢|Ã¤)/",
        "/(Ã�|Ã€|Ãƒ|Ã‚|Ã„)/",
        "/(Ã©|Ã¨|Ãª|Ã«)/",
        "/(Ã‰|Ãˆ|ÃŠ|Ã‹)/",
        "/(Ã­|Ã¬|Ã®|Ã¯)/",
        "/(Ã�|ÃŒ|ÃŽ|Ã�)/",
        "/(Ã³|Ã²|Ãµ|Ã´|Ã¶)/",
        "/(Ã“|Ã’|Ã•|Ã”|Ã–)/",
        "/(Ãº|Ã¹|Ã»|Ã¼)/",
        "/(Ãš|Ã™|Ã›|Ãœ)/",
        "/(Ã±)/",
        "/(Ã‘)/"
            ), explode(" ", "a A e E i I o O u U n N"), $string);
}

/**
 * Redirect with POST data.
 *
 * @param string $url
 *        	URL.
 * @param array $post_data
 *        	POST data. Example: array('foo' => 'var', 'id' => 123)
 * @param array $headers
 *        	Optional. Extra headers to send.
 */
function redirect_post($url, array $data, array $headers = null) {
    $params = array(
        'http' => array(
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );
    if (!is_null($headers)) {
        $params ['http'] ['header'] = '';
        foreach ($headers as $k => $v) {
            $params ['http'] ['header'] .= "$k: $v\n";
        }
    }
    $ctx = stream_context_create($params);
    $fp = @fopen($url, 'rb', false, $ctx);
    if ($fp) {
        echo @stream_get_contents($fp);
        die();
    } else {
        // Error
        throw new Exception("Error loading '$url', $php_errormsg");
    }
}

// Include php file from string with GET parameters
function include_get($phpinclude) {
    // find ? if available
    $pos_incl = strpos($phpinclude, '?');
    if ($pos_incl !== FALSE) {
        // divide the string in two part, before ? and after
        // after ? - the query string
        $qry_string = substr($phpinclude, $pos_incl + 1);
        // before ? - the real name of the file to be included
        $phpinclude = substr($phpinclude, 0, $pos_incl);
        // transform to array with & as divisor
        $arr_qstr = explode('&', $qry_string);
        // in $arr_qstr you should have a result like this:
        // ('id=123', 'active=no', ...)
        foreach ($arr_qstr as $param_value) {
            // for each element in above array, split to variable name and its value
            list ( $qstr_name, $qstr_value ) = explode('=', $param_value);
            // $qstr_name will hold the name of the variable we need - 'id', 'active', ...
            // $qstr_value - the corresponding value
            // $$qstr_name - this construction creates variable variable
            // this means from variable $qstr_name = 'id', adding another $ sign in front you will receive variable $id
            // the second iteration will give you variable $active and so on
            $qstr_name = $qstr_value;
        }
    }
    // now it's time to include the real php file
    // all necessary variables are already defined and will be in the same scope of included file
    include ($phpinclude);
}

function getRemoteAddr() {
    return $_SERVER ['REMOTE_ADDR'];
}

/**
 *
 * @param
 *        	{type} t - tabela ALI, AIE, etc.
 * @param
 *        	{type} f - funcao (dados/transacao)
 * @param
 *        	{type} d - campo TD
 * @param
 *        	{type} r - campo TR/AR
 * @param
 *        	{type} a - abrangencia atual
 * @returns {undefined}
 */
function calculaLinhaPF($t, $f, $td, $tr, $a) {
    $c = '';
    $p = 0;
    switch ($t) {
        case "ALI" :
            if ($a == 9) {
                $c = "EFd";
                $p = 1.75 + 0.96 * $tr + 0.12 * $td;
            } else {
                if (($tr == 1 && $td <= 50) || ($tr <= 5 && $td < 20)) {
                    $c = "Baixa";
                    $p = 7;
                } else {
                    if (($tr == 1 && $td > 50) || (($tr >= 2 && $tr <= 5) && ($td >= 20 && $td <= 50)) || ($tr > 5 && $td < 20)) {
                        $c = "Media";
                        $p = 10;
                    } else {
                        $c = "Alta";
                        $p = 15;
                    }
                }
            }
            break;
        case "AIE" :
            if ($a == 9) {
                $c = "EFd";
                $p = 1.25 + 0.65 * $tr + 0.08 * $td;
            } else {
                if (($tr == 1 && $td <= 50) || ($tr <= 5 && $td < 20)) {
                    $c = "Baixa";
                    $p = 5;
                } else {
                    if (($tr == 1 && $td > 50) || (($tr >= 2 && $tr <= 5) && ($td >= 20 && $td <= 50)) || ($tr > 5 && $td < 20)) {
                        $c = "Media";
                        $p = 7;
                    } else {
                        $c = "Alta";
                        $p = 10;
                    }
                }
            }
            break;
        case "EE" :
            if ($a == 9) {
                $c = "EFt";
                $p = 0.75 + 0.91 * $tr + 0.13 * $td;
            } else {
                if (($tr < 2 && $td <= 15) || ($tr == 2 && $td < 5)) {
                    $c = "Baixa";
                    $p = 3;
                } else {
                    if (($tr < 2 && $td > 15) || ($tr == 2 && ($td >= 5 && $td <= 15)) || ($tr > 2 && $td < 5)) {
                        $c = "Media";
                        $p = 4;
                    } else {
                        $c = "Alta";
                        $p = 6;
                    }
                }
            }
            break;
        case "SE" :
            if ($a == 9) {
                $c = "EFt";
                $p = 1 + 0.81 * $tr + 0.13 * $td;
            } else {
                if (($tr < 2 && $td < 20) || (($tr == 2 || $tr == 3) && $td < 6)) {
                    $c = "Baixa";
                    $p = 4;
                } else {
                    if (($tr < 2 && $td > 19) || (($tr == 2 || $tr == 3) && $td < 20) || ($td > 3 && $td < 6)) {
                        $c = "Media";
                        $p = 5;
                    } else {
                        $c = "Alta";
                        $p = 7;
                    }
                }
            }
            break;
        case "CE" :
            if ($a == 9) {
                $c = "EFt";
                $p = 0.75 + 0.76 * $tr + 0.10 * $td;
            } else {
                if (($tr < 2 && $td < 20) || (($tr == 2 || $tr == 3) && $td < 6)) {
                    $c = "Baixa";
                    $p = 3;
                } else {
                    if (($tr < 2 && $td > 19) || (($tr == 2 || $tr == 3) && $td < 20) || ($tr > 3 && $td < 6)) {
                        $c = "Media";
                        $p = 4;
                    } else {
                        $c = "Alta";
                        $p = 6;
                    }
                }
            }
            break;
    }
    // retorna
    return array(
        'c' => $c,
        'p' => $p
    );
}

function getFile($tipo, $maf, $login, $idContagem = NULL, $idUnicoArquivo = NULL) {
    if ($tipo === 'CONTAGEM') {
        include DIR_APP . 'actions/relatorios/relatorio_pdf.php';
    } elseif ($tipo === 'FATURAMENTO') {
        include DIR_APP . 'actions/relatorios/financeiro/_relatorio_faturamento_empresa.php';
    }
    return true;
}

function calculaCocomo($estatisticas) {
    //calcula para cocomo
    $coc_a = $estatisticas['COCOMO_A'];
    $coc_b = $estatisticas['COCOMO_B'];
    $coc_c = $estatisticas['COCOMO_C'];
    $coc_d = $estatisticas['COCOMO_D'];
    $sloc = $estatisticas['sloc'] / 1000;
    $custoPessoa = $estatisticas['custo_pessoa'];
    $tipoCalculo = $estatisticas['tipo_calculo'];
    //post-architecture
    $prec = $estatisticas[str_replace('-', '_', $estatisticas['PREC'])];
    $flex = $estatisticas[str_replace('-', '_', $estatisticas['FLEX'])];
    $resl = $estatisticas[str_replace('-', '_', $estatisticas['RESL'])];
    $team = $estatisticas[str_replace('-', '_', $estatisticas['TEAM'])];
    $pmat = $estatisticas[str_replace('-', '_', $estatisticas['PMAT'])];
    $rely = $estatisticas[str_replace('-', '_', $estatisticas['RELY'])];
    $data = $estatisticas[str_replace('-', '_', $estatisticas['DATA'])];
    $cplx = $estatisticas[str_replace('-', '_', $estatisticas['CPLX'])];
    $ruse = $estatisticas[str_replace('-', '_', $estatisticas['RUSE'])];
    $docu = $estatisticas[str_replace('-', '_', $estatisticas['DOCU'])];
    $time = $estatisticas[str_replace('-', '_', $estatisticas['TIME'])];
    $stor = $estatisticas[str_replace('-', '_', $estatisticas['STOR'])];
    $pvol = $estatisticas[str_replace('-', '_', $estatisticas['PVOL'])];
    $acap = $estatisticas[str_replace('-', '_', $estatisticas['ACAP'])];
    $pcap = $estatisticas[str_replace('-', '_', $estatisticas['PCAP'])];
    $pcon = $estatisticas[str_replace('-', '_', $estatisticas['PCON'])];
    $apex = $estatisticas[str_replace('-', '_', $estatisticas['APEX'])];
    $plex = $estatisticas[str_replace('-', '_', $estatisticas['PLEX'])];
    $ltex = $estatisticas[str_replace('-', '_', $estatisticas['LTEX'])];
    $tool = $estatisticas[str_replace('-', '_', $estatisticas['TOOL'])];
    $site = $estatisticas[str_replace('-', '_', $estatisticas['SITE'])];
    $sced = $estatisticas[str_replace('-', '_', $estatisticas['SCED'])];
    //early design
    $ed_pers = $estatisticas[str_replace('-', '_', $estatisticas['ED_PERS'])];
    $ed_rcpx = $estatisticas[str_replace('-', '_', $estatisticas['ED_RCPX'])];
    $ed_pdif = $estatisticas[str_replace('-', '_', $estatisticas['ED_PDIF'])];
    $ed_prex = $estatisticas[str_replace('-', '_', $estatisticas['ED_PREX'])];
    $ed_fcil = $estatisticas[str_replace('-', '_', $estatisticas['ED_FCIL'])];
    $ed_ruse = $estatisticas[str_replace('-', '_', $estatisticas['ED_RUSE'])];
    $ed_sced = $estatisticas[str_replace('-', '_', $estatisticas['ED_SCED'])];
    //expoente
    $e = $coc_b + 0.01 * (
            $prec +
            $flex +
            $resl +
            $team +
            $pmat);
    $em_pa = $rely * //Post Architecture
            $data *
            $cplx *
            $ruse *
            $docu *
            $time *
            $stor *
            $pvol *
            $acap *
            $pcap *
            $pcon *
            $apex *
            $plex *
            $ltex *
            $tool *
            $site *
            $sced;
    $em_ed = $ed_pers *
            $ed_rcpx *
            $ed_pdif *
            $ed_prex *
            $ed_fcil *
            $ed_ruse *
            $ed_sced;
    $pm = $tipoCalculo ?
            $coc_a * pow($sloc, $e) * $em_pa :
            $coc_a * pow($sloc, $e) * $em_ed;
    $f = $coc_d + 0.2 * ($e - $coc_b);
    $tdev = $coc_c * pow($pm, $f);
    $coc_custo = $pm * $custoPessoa;
    //rup
    $rup_inc_ef = $estatisticas['rup_inc_ef'] * $pm / 100;
    $rup_ela_ef = $estatisticas['rup_ela_ef'] * $pm / 100;
    $rup_con_ef = $estatisticas['rup_con_ef'] * $pm / 100;
    $rup_tra_ef = $estatisticas['rup_tra_ef'] * $pm / 100;
    $rup_inc_sc = $estatisticas['rup_inc_sc'] * $tdev / 100;
    $rup_ela_sc = $estatisticas['rup_ela_sc'] * $tdev / 100;
    $rup_con_sc = $estatisticas['rup_con_sc'] * $tdev / 100;
    $rup_tra_sc = $estatisticas['rup_tra_sc'] * $tdev / 100;
    $coc_inc_ef = $estatisticas['coc_inc_ef'] * $pm / 100;
    $coc_ela_ef = $estatisticas['coc_ela_ef'] * $pm / 100;
    $coc_con_ef = $estatisticas['coc_con_ef'] * $pm / 100;
    $coc_tra_ef = $estatisticas['coc_tra_ef'] * $pm / 100;
    $coc_inc_sc = $estatisticas['coc_inc_sc'] * $tdev / 100;
    $coc_ela_sc = $estatisticas['coc_ela_sc'] * $tdev / 100;
    $coc_con_sc = $estatisticas['coc_con_sc'] * $tdev / 100;
    $coc_tra_sc = $estatisticas['coc_tra_sc'] * $tdev / 100;
    $rup_inc_av = $rup_inc_sc > 0 ? $rup_inc_ef / $rup_inc_sc : 0;
    $rup_ela_av = $rup_ela_sc > 0 ? $rup_ela_ef / $rup_ela_sc : 0;
    $rup_con_av = $rup_con_sc > 0 ? $rup_con_ef / $rup_con_sc : 0;
    $rup_tra_av = $rup_tra_sc > 0 ? $rup_tra_ef / $rup_tra_sc : 0;
    $coc_inc_av = $coc_inc_sc > 0 ? $coc_inc_ef / $coc_inc_sc : 0;
    $coc_ela_av = $coc_ela_sc > 0 ? $coc_ela_ef / $coc_ela_sc : 0;
    $coc_con_av = $coc_con_sc > 0 ? $coc_con_ef / $coc_con_sc : 0;
    $coc_tra_av = $coc_tra_sc > 0 ? $coc_tra_ef / $coc_tra_sc : 0;
    $rup_inc_co = $custoPessoa * $rup_inc_ef;
    $rup_ela_co = $custoPessoa * $rup_ela_ef;
    $rup_con_co = $custoPessoa * $rup_con_ef;
    $rup_tra_co = $custoPessoa * $rup_tra_ef;
    $coc_inc_co = $custoPessoa * $coc_inc_ef;
    $coc_ela_co = $custoPessoa * $coc_ela_ef;
    $coc_con_co = $custoPessoa * $coc_con_ef;
    $coc_tra_co = $custoPessoa * $coc_tra_ef;
    //rup
    $rup_man_inc = $estatisticas['man_inc'] / 100 * $rup_inc_ef;
    $rup_man_ela = $estatisticas['man_ela'] / 100 * $rup_ela_ef;
    $rup_man_con = $estatisticas['man_con'] / 100 * $rup_con_ef;
    $rup_man_tra = $estatisticas['man_tra'] / 100 * $rup_tra_ef;
    $rup_env_inc = $estatisticas['env_inc'] / 100 * $rup_inc_ef;
    $rup_env_ela = $estatisticas['env_ela'] / 100 * $rup_ela_ef;
    $rup_env_con = $estatisticas['env_con'] / 100 * $rup_con_ef;
    $rup_env_tra = $estatisticas['env_tra'] / 100 * $rup_tra_ef;
    $rup_req_inc = $estatisticas['req_inc'] / 100 * $rup_inc_ef;
    $rup_req_ela = $estatisticas['req_ela'] / 100 * $rup_ela_ef;
    $rup_req_con = $estatisticas['req_con'] / 100 * $rup_con_ef;
    $rup_req_tra = $estatisticas['req_tra'] / 100 * $rup_tra_ef;
    $rup_des_inc = $estatisticas['des_inc'] / 100 * $rup_inc_ef;
    $rup_des_ela = $estatisticas['des_ela'] / 100 * $rup_ela_ef;
    $rup_des_con = $estatisticas['des_con'] / 100 * $rup_con_ef;
    $rup_des_tra = $estatisticas['des_tra'] / 100 * $rup_tra_ef;
    $rup_imp_inc = $estatisticas['imp_inc'] / 100 * $rup_inc_ef;
    $rup_imp_ela = $estatisticas['imp_ela'] / 100 * $rup_ela_ef;
    $rup_imp_con = $estatisticas['imp_con'] / 100 * $rup_con_ef;
    $rup_imp_tra = $estatisticas['imp_tra'] / 100 * $rup_tra_ef;
    $rup_ass_inc = $estatisticas['ass_inc'] / 100 * $rup_inc_ef;
    $rup_ass_ela = $estatisticas['ass_ela'] / 100 * $rup_ela_ef;
    $rup_ass_con = $estatisticas['ass_con'] / 100 * $rup_con_ef;
    $rup_ass_tra = $estatisticas['ass_tra'] / 100 * $rup_tra_ef;
    $rup_dep_inc = $estatisticas['dep_inc'] / 100 * $rup_inc_ef;
    $rup_dep_ela = $estatisticas['dep_ela'] / 100 * $rup_ela_ef;
    $rup_dep_con = $estatisticas['dep_con'] / 100 * $rup_con_ef;
    $rup_dep_tra = $estatisticas['dep_tra'] / 100 * $rup_tra_ef;
    //cocomo
    $coc_man_inc = $estatisticas['man_inc'] / 100 * $coc_inc_ef;
    $coc_man_ela = $estatisticas['man_ela'] / 100 * $coc_ela_ef;
    $coc_man_con = $estatisticas['man_con'] / 100 * $coc_con_ef;
    $coc_man_tra = $estatisticas['man_tra'] / 100 * $coc_tra_ef;
    $coc_env_inc = $estatisticas['env_inc'] / 100 * $coc_inc_ef;
    $coc_env_ela = $estatisticas['env_ela'] / 100 * $coc_ela_ef;
    $coc_env_con = $estatisticas['env_con'] / 100 * $coc_con_ef;
    $coc_env_tra = $estatisticas['env_tra'] / 100 * $coc_tra_ef;
    $coc_req_inc = $estatisticas['req_inc'] / 100 * $coc_inc_ef;
    $coc_req_ela = $estatisticas['req_ela'] / 100 * $coc_ela_ef;
    $coc_req_con = $estatisticas['req_con'] / 100 * $coc_con_ef;
    $coc_req_tra = $estatisticas['req_tra'] / 100 * $coc_tra_ef;
    $coc_des_inc = $estatisticas['des_inc'] / 100 * $coc_inc_ef;
    $coc_des_ela = $estatisticas['des_ela'] / 100 * $coc_ela_ef;
    $coc_des_con = $estatisticas['des_con'] / 100 * $coc_con_ef;
    $coc_des_tra = $estatisticas['des_tra'] / 100 * $coc_tra_ef;
    $coc_imp_inc = $estatisticas['imp_inc'] / 100 * $coc_inc_ef;
    $coc_imp_ela = $estatisticas['imp_ela'] / 100 * $coc_ela_ef;
    $coc_imp_con = $estatisticas['imp_con'] / 100 * $coc_con_ef;
    $coc_imp_tra = $estatisticas['imp_tra'] / 100 * $coc_tra_ef;
    $coc_ass_inc = $estatisticas['ass_inc'] / 100 * $coc_inc_ef;
    $coc_ass_ela = $estatisticas['ass_ela'] / 100 * $coc_ela_ef;
    $coc_ass_con = $estatisticas['ass_con'] / 100 * $coc_con_ef;
    $coc_ass_tra = $estatisticas['ass_tra'] / 100 * $coc_tra_ef;
    $coc_dep_inc = $estatisticas['dep_inc'] / 100 * $coc_inc_ef;
    $coc_dep_ela = $estatisticas['dep_ela'] / 100 * $coc_ela_ef;
    $coc_dep_con = $estatisticas['dep_con'] / 100 * $coc_con_ef;
    $coc_dep_tra = $estatisticas['dep_tra'] / 100 * $coc_tra_ef;
    return array(
        'rup_inc_ef' => $rup_inc_ef,
        'rup_ela_ef' => $rup_ela_ef,
        'rup_con_ef' => $rup_con_ef,
        'rup_tra_ef' => $rup_tra_ef,
        'rup_inc_sc' => $rup_inc_sc,
        'rup_ela_sc' => $rup_ela_sc,
        'rup_con_sc' => $rup_con_sc,
        'rup_tra_sc' => $rup_tra_sc,
        'coc_inc_ef' => $coc_inc_ef,
        'coc_ela_ef' => $coc_ela_ef,
        'coc_con_ef' => $coc_con_ef,
        'coc_tra_ef' => $coc_tra_ef,
        'coc_inc_sc' => $coc_inc_sc,
        'coc_ela_sc' => $coc_ela_sc,
        'coc_con_sc' => $coc_con_sc,
        'coc_tra_sc' => $coc_tra_sc,
        'rup_inc_av' => $rup_inc_av,
        'rup_ela_av' => $rup_ela_av,
        'rup_con_av' => $rup_con_av,
        'rup_tra_av' => $rup_tra_av,
        'coc_inc_av' => $coc_inc_av,
        'coc_ela_av' => $coc_ela_av,
        'coc_con_av' => $coc_con_av,
        'coc_tra_av' => $coc_tra_av,
        'rup_inc_co' => $rup_inc_co,
        'rup_ela_co' => $rup_ela_co,
        'rup_con_co' => $rup_con_co,
        'rup_tra_co' => $rup_tra_co,
        'coc_inc_co' => $coc_inc_co,
        'coc_ela_co' => $coc_ela_co,
        'coc_con_co' => $coc_con_co,
        'coc_tra_co' => $coc_tra_co,
        //rup
        'rup_man_inc' => $rup_man_inc,
        'rup_man_ela' => $rup_man_ela,
        'rup_man_con' => $rup_man_con,
        'rup_man_tra' => $rup_man_tra,
        'rup_env_inc' => $rup_env_inc,
        'rup_env_ela' => $rup_env_ela,
        'rup_env_con' => $rup_env_con,
        'rup_env_tra' => $rup_env_tra,
        'rup_req_inc' => $rup_req_inc,
        'rup_req_ela' => $rup_req_ela,
        'rup_req_con' => $rup_req_con,
        'rup_req_tra' => $rup_req_tra,
        'rup_des_inc' => $rup_des_inc,
        'rup_des_ela' => $rup_des_ela,
        'rup_des_con' => $rup_des_con,
        'rup_des_tra' => $rup_des_tra,
        'rup_imp_inc' => $rup_imp_inc,
        'rup_imp_ela' => $rup_imp_ela,
        'rup_imp_con' => $rup_imp_con,
        'rup_imp_tra' => $rup_imp_tra,
        'rup_ass_inc' => $rup_ass_inc,
        'rup_ass_ela' => $rup_ass_ela,
        'rup_ass_con' => $rup_ass_con,
        'rup_ass_tra' => $rup_ass_tra,
        'rup_dep_inc' => $rup_dep_inc,
        'rup_dep_ela' => $rup_dep_ela,
        'rup_dep_con' => $rup_dep_con,
        'rup_dep_tra' => $rup_dep_tra,
        //cocomo
        'coc_man_inc' => $coc_man_inc,
        'coc_man_ela' => $coc_man_ela,
        'coc_man_con' => $coc_man_con,
        'coc_man_tra' => $coc_man_tra,
        'coc_env_inc' => $coc_env_inc,
        'coc_env_ela' => $coc_env_ela,
        'coc_env_con' => $coc_env_con,
        'coc_env_tra' => $coc_env_tra,
        'coc_req_inc' => $coc_req_inc,
        'coc_req_ela' => $coc_req_ela,
        'coc_req_con' => $coc_req_con,
        'coc_req_tra' => $coc_req_tra,
        'coc_des_inc' => $coc_des_inc,
        'coc_des_ela' => $coc_des_ela,
        'coc_des_con' => $coc_des_con,
        'coc_des_tra' => $coc_des_tra,
        'coc_imp_inc' => $coc_imp_inc,
        'coc_imp_ela' => $coc_imp_ela,
        'coc_imp_con' => $coc_imp_con,
        'coc_imp_tra' => $coc_imp_tra,
        'coc_ass_inc' => $coc_ass_inc,
        'coc_ass_ela' => $coc_ass_ela,
        'coc_ass_con' => $coc_ass_con,
        'coc_ass_tra' => $coc_ass_tra,
        'coc_dep_inc' => $coc_dep_inc,
        'coc_dep_ela' => $coc_dep_ela,
        'coc_dep_con' => $coc_dep_con,
        'coc_dep_tra' => $coc_dep_tra);
}
