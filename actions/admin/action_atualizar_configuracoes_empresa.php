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
if ($login->isUserLoggedIn() && verificaSessao()) {

    $fn = new EmpresaConfig();
    $fn->setTable('empresa_config');
    $fn->setLog();
    
    $idEmpresa = getIdEmpresa();
    $emailAdministrador1 = filter_input(INPUT_POST, 'email_administrador_1', FILTER_SANITIZE_EMAIL);
    $emailAdministrador2 = filter_input(INPUT_POST, 'email_administrador_2', FILTER_SANITIZE_EMAIL) !== '' ? filter_input(INPUT_POST, 'email_administrador_2', FILTER_SANITIZE_EMAIL) : '';
    $telefoneAdministrador1 = filter_input(INPUT_POST, 'telefone_administrador_1', FILTER_SANITIZE_STRING);
    $telefoneAdministrador2 = filter_input(INPUT_POST, 'telefone_administrador_2', FILTER_SANITIZE_STRING);

    $fn->setIdEmpresa($idEmpresa);
    $fn->setEmailAdministrador1($emailAdministrador1);
    $fn->setEmailAdministrador2($emailAdministrador2);
    $fn->setTelefoneAdministrador1($telefoneAdministrador1);
    $fn->setTelefoneAdministrador2($telefoneAdministrador2);

    $atualiza = $fn->atualiza();

    if ($atualiza) {
        echo json_encode(array('msg' => 'As altera&ccedil;&otilde;es foram feitas com sucesso.&nbsp;<strong>OBSERVA&Ccedil;&Atilde;O:</strong> Algumas altera&ccedil;&otilde;es necessitam que os usu&aacute;rios fa&ccedil;am login novamente para surtir efeito!'));
    } else {
        echo json_encode(array('msg' => 'Houve um erro durante a atualiza&ccedil;&atilde;o das informa&ccedil;&otilde;es, por favor tente novamente!'));
    }
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}



