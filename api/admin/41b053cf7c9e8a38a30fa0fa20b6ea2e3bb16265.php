<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * esta funcionalidade esta disponivel apenas para o usuario DIMENSION_root
 */
if ($login->isUserLoggedIn() && getUserName() === '41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265' && verificaSessao()) {
    $empresa = new Empresa();
    $comboEmpresa = $empresa->_41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265();
    echo json_encode($comboEmpresa);
}
