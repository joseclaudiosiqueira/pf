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
if ($login->isUserLoggedIn() && $tab && verificaSessao()) {
    $tab = NULL !== filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING) ? str_rot13(filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING)) : 0;
    switch ($tab) {
        case 'tab-treinamentos':
            echo json_encode(array('sucesso' => in_array_r('turmas_treinamentos', $_SESSION['perm'])));
            break;
        case 'tab-fornecedores':
            echo json_encode(array('sucesso' => in_array_r('gerenciar_fornecedor', $_SESSION['perm'])));
            break;
        case 'tab-usuarios':
            echo json_encode(array('sucesso' => in_array_r('gerenciar_usuario', $_SESSION['perm'])));
            break;
        case 'tab-roteiros':
            echo json_encode(array('sucesso' => in_array_r('gerenciar_roteiro', $_SESSION['perm'])));
            break;
        case 'tab-clientes':
            echo json_encode(array('sucesso' => in_array_r('gerenciar_cliente', $_SESSION['perm'])));
            break;
        case 'tab-contratos':
            echo json_encode(array('sucesso' => in_array_r('gerenciar_contrato', $_SESSION['perm'])));
            break;
        case 'tab-projetos':
            echo json_encode(array('sucesso' => in_array_r('gerenciar_projeto', $_SESSION['perm'])));
            break;
        case 'tab-configuracoes-empresa-fornecedor':
            echo json_encode(array('sucesso' => in_array_r('configuracao_empresa', $_SESSION['perm'])));
            break;
        case 'tab-contagens':
            echo json_encode(array('sucesso' => in_array_r('configuracao_contagem', $_SESSION['perm'])));
            break;
        case 'tab-configuracoes-empresa':
            echo json_encode(array('sucesso' => in_array_r('configuracao_relatorios', $_SESSION['perm'])));
            break;
    }
} else {
    echo json_encode(array('sucesso' => FALSE));
}
