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
if ($login->isUserLoggedIn() && verificaSessao()) {
    $fn = new ClienteConfigRelatorio();
    $fn->setTable('cliente_config_relatorio');
    $id = \filter_input(INPUT_POST, 'i');
    $linha = $fn->getConfig($id);
    $ret = array(
        'id_cliente' => $linha['id_cliente'],
        'cab_linha_1' => html_entity_decode($linha['cab_linha_1'], ENT_QUOTES),
        'cab_linha_2' => html_entity_decode($linha['cab_linha_2'], ENT_QUOTES),
        'cab_linha_3' => html_entity_decode($linha['cab_linha_3'], ENT_QUOTES),
        'rod_linha_1' => html_entity_decode($linha['rod_linha_1'], ENT_QUOTES),
        'is_logomarca_empresa' => $linha['is_logomarca_empresa'],
        'is_logomarca_cliente' => $linha['is_logomarca_cliente'],
        'logomarca' => $linha['logomarca'],
        'cab_alinhamento' => $linha['cab_alinhamento']
    );
    echo json_encode($ret);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}