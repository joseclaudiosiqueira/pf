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
if ($login->isUserLoggedIn()) {
    /*
     * realiza as alteracoes na tabela users_detail
     */
    $fn = new Usuario();
    $fn->setLog();
    $fn->setTable('users_detail');
    /*
     * variaveis do form
     */
    $idUser = $converter->decode(filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_STRING));
    $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
    $dataNascimento = '' !== filter_input(INPUT_POST, 'data_nascimento') ? preg_replace("/(\d+)\D+(\d+)\D+(\d+)/", "$3-$2-$1", filter_input(INPUT_POST, 'data_nascimento', FILTER_SANITIZE_STRING)) : NULL;
    $emailAlternativo = filter_input(INPUT_POST, 'email_alternativo', FILTER_SANITIZE_EMAIL);
    $apelido = filter_input(INPUT_POST, 'apelido', FILTER_SANITIZE_SPECIAL_CHARS);
    $telefoneFixo = filter_input(INPUT_POST, 'telefone_fixo', FILTER_SANITIZE_STRING);
    $telefoneCelular = filter_input(INPUT_POST, 'telefone_celular', FILTER_SANITIZE_STRING);
    $uf = filter_input(INPUT_POST, 'uf', FILTER_SANITIZE_STRING);
    $certificacao = filter_input(INPUT_POST, 'certificacao', FILTER_SANITIZE_STRING);
    /*
     * loop necessario para pegar todas as especialidades
     */
    $especialidades = filter_input(INPUT_POST, 'especialidades', FILTER_SANITIZE_SPECIAL_CHARS);
    if (NULL !== $especialidades) {
        $especialidades = '';
        for ($x = 0; $x < count($_POST['especialidades']); $x ++) {
            $especialidades .= $_POST['especialidades'][$x] . ',';
        }
        $especialidades = substr($especialidades, 0, strlen($especialidades) - 1);
    }
    /*
     * atributos da classe
     */
    $fn->setCpf($cpf);
    $fn->setDataNascimento($dataNascimento);
    $fn->setEmailAlternativo($emailAlternativo);
    $fn->setApelido($apelido);
    $fn->setTelefoneFixo($telefoneFixo);
    $fn->setTelefoneCelular($telefoneCelular);
    $fn->setUf($uf);
    $fn->setEspecialidades($especialidades);
    $fn->setCertificacao($certificacao);
    /*
     * realiza as operacoes na tabela historico do usuario
     */
    echo json_encode(array(
        'status' => $fn->atualizarUserDetail($idUser)
    ));
} else {
    echo json_encode(array(
        'status' => false
    ));
}
