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
    $fn = new ClienteConfigRelatorio();
    $idCliente = filter_input(INPUT_POST, 'relatorio_id_cliente', FILTER_SANITIZE_NUMBER_INT);
    $cabLinha1 = htmlspecialchars(filter_input(INPUT_POST, 'txt-cab-linha-1'), ENT_QUOTES);
    $cabLinha2 = htmlspecialchars(filter_input(INPUT_POST, 'txt-cab-linha-2'), ENT_QUOTES);
    $cabLinha3 = htmlspecialchars(filter_input(INPUT_POST, 'txt-cab-linha-3'), ENT_QUOTES);
    $rodLinha1 = htmlspecialchars(filter_input(INPUT_POST, 'txt-rod-linha-1'), ENT_QUOTES);
    $isLogomarcaEmpresa = filter_input(INPUT_POST, 'is-logomarca-empresa', FILTER_SANITIZE_NUMBER_INT);
    $isLogomarcaCliente = filter_input(INPUT_POST, 'is-logomarca-cliente', FILTER_SANITIZE_NUMBER_INT);
    $cabAlinhamento = filter_input(INPUT_POST, 'txt-cab-alinhamento', FILTER_SANITIZE_STRING);

    $fn->setIdCliente($idCliente);
    $fn->setCabLinha1($cabLinha1);
    $fn->setCabLinha2($cabLinha2);
    $fn->setCabLinha3($cabLinha3);
    $fn->setRodLinha1($rodLinha1);
    $fn->setIsLogomarcaEmpresa($isLogomarcaEmpresa);
    $fn->setIsLogomarcaCliente($isLogomarcaCliente);
    $fn->setCabAlinhamento($cabAlinhamento);

    $atualiza = $fn->atualiza($idCliente);

    if ($atualiza) {
        echo json_encode(array('msg' => 'As configura&ccedil;&otilde;es dos relat&oacute;rios para este cliente foram atualizadas com sucesso.'));
    } else {
        echo json_encode(array('msg' => 'Houve um erro durante a atualiza&ccedil;&atilde;o das informa&ccedil;&otilde;es, por favor tente novamente!'));
    }
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}




