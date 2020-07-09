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
if ($login->isUserLoggedIn()) {
    $id = $converter->decode(filter_input(INPUT_POST, 'i', FILTER_SANITIZE_STRING));
    $userDetail = new Usuario();
    $userDetail->setTable('users_detail');
    $linha = $userDetail->consulta($id);
    echo json_encode(
            array(
                'cpf' => $linha['cpf'],
                'data_nascimento' => NULL !== $linha['data_nascimento'] ? date_format(date_create($linha['data_nascimento']), 'd/m/Y') : '',
                'email_alternativo' => html_entity_decode($linha['email_alternativo'], ENT_QUOTES),
                'apelido' => html_entity_decode($linha['apelido'], ENT_QUOTES),
                'telefone_fixo' => $linha['telefone_fixo'],
                'telefone_celular' => $linha['telefone_celular'],
                'especialidades' => explode(",", html_entity_decode($linha['especialidades'], ENT_QUOTES)),
                'uf' => $linha['uf'],
                'certificacao' => $linha['certificacao']
            )
    );
}

