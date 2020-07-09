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
    /*
     * retorna os fatores de impacto do roteiro selecionado
     */
    $id = \NULL !== filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'i', FILTER_SANITIZE_NUMBER_INT) : 0;
    $tipoConsulta = \NULL !== filter_input(INPUT_POST, 't', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 't', FILTER_SANITIZE_NUMBER_INT) : 0;
    $funcao = \NULL !== filter_input(INPUT_POST, 'f', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'f', FILTER_SANITIZE_STRING) : 0;
    $fn = new ContagemDescricaoTD();
    $fn->setTable('contagem_descricao_td');
    $arr = [];
    /*
     * tipo $tipoConsulta - indica se e uma lista ou consulta
     * 0 = lista
     * 1 = unico
     * 
     */
    if ($tipoConsulta) {
        $linha = $fn->consulta($id);
        $arr[] = (array(
            'id' => $linha['id'],
            'id_primario' => $linha['id_primario'],
            'descricao' => $linha['descricao']
        ));
    } else {
        $ret = $fn->listaDescricaoTD($id, $funcao);
        foreach ($ret as $linha) {
            $arr[] = (array(
                'id' => $linha['id'],
                'id_primario' => $linha['id_primario'],
                'descricao' => $linha['descricao']
            ));
        }
    }
    echo json_encode($arr);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}