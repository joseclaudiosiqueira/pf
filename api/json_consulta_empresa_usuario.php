<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verifica login
 */
$ret = new Registration();
/*
 * incrementa a variavel de consultas dentro do login e se for maior que cinco exibe o captcha antes de enviar uma nova consulta V2.0
 *
  if (!isset($_SESSION['qtd_consultas_empresa'])) {
  $_SESSION['qtd_consultas_empresa'] = 1;
  } else {
  $_SESSION['qtd_consultas_empresa'] = $_SESSION['qtd_consultas_empresa'] + 1;
  }
 */
$user = filter_input(INPUT_POST, 'user_name', FILTER_SANITIZE_STRING);
$arrEmpresas = [];
/*
 * consulta pelo user_name
 */
if (!filter_var($user, FILTER_VALIDATE_EMAIL)) {
    $arr_user_id = $ret->verificaNomeUsuario($user);
} else {
    $arr_user_id = $ret->verificaEmailUsuario($user, 0);
}
/*
 * pega as variaveis do primeiro json
 */
$user_id = isset($arr_user_id[0]['user_id']) ? $arr_user_id[0]['user_id'] : 0;
$user_email = isset($arr_user_id[0]['user_email']) ? $arr_user_id[0]['user_email'] : NULL;
/*
 * faz um novo loop para verificar os perfis
 */
if ($user_id) {
    /*
     * verifica ao que o usuario esta associado
     */
    $associacoesUsuario = $ret->getEmpresaFornecedorUsuario($user_id, $user_email);
    /*
     * insere no array e retorna para a pagina
     */
    if (count($associacoesUsuario) > 0) {
        $arrEmpresas = $associacoesUsuario;
    } else {
        $arrEmpresas[] = array('existe' => false);
    }
} else {
    $arrEmpresas[] = array('existe' => false);
}
echo json_encode($arrEmpresas);
