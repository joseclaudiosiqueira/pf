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
    /*
     * verifica se veio um post de id_cliente por conta da tab_inico em inserir contagem
     */
    $idCliente = NULL !== filter_input(INPUT_POST, 'idc', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'idc', FILTER_SANITIZE_NUMBER_INT) : 0;
    $config = new ContagemConfigTabInicio();
    $config->setIdEmpresa(getIdEmpresa());
    $config->setIdFornecedor(isFornecedor() ? getIdFornecedor() : 0);
    $config->setIdCliente($idCliente);
    $linhas = $config->listaConfiguracoesTabInicio($idCliente);
    $arrayLista = array();
    foreach ($linhas as $row) {
        $arrayLista[] = array(
            'id' => $row['id'],
            'cliente' => $row['cliente'],
            'contrato' => $row['contrato'],
            'projeto' => $row['projeto'],
            'orgao' => $row['orgao'],
            'ordemServico' => $row['ordemServico'],
            'linguagem' => file_exists(DIR_APP . 'img' . DIRECTORY_SEPARATOR . 'icone-linguagem' . DIRECTORY_SEPARATOR . $row['linguagem'] . '.png') ? '<img src="/pf/img/icone-linguagem/' . $row['linguagem'] . '.png" width="80" height="80" class="img-rounded img-thumbnail">' : '<div class="file-not-exists">' . $row['linguagem'] . '</div>',
            'bancoDados' => file_exists(DIR_APP . 'img' . DIRECTORY_SEPARATOR . 'icone-banco-dados' . DIRECTORY_SEPARATOR . $row['bancoDados'] . '.png') ? '<img src="/pf/img/icone-banco-dados/' . $row['bancoDados'] . '.png" width="80" height="80" class="img-rounded img-thumbnail">' : '<div class="file-not-exists">' . $row['bancoDados'] . '</div>',
            'tipo' => $row['tipo'],
            'etapa' => $row['etapa'],
            'atuacao' => $row['atuacao'],
            'processo' => $row['processo'],
            'gestao' => file_exists(DIR_APP . 'img' . DIRECTORY_SEPARATOR . 'icone-processo-gestao' . DIRECTORY_SEPARATOR . $row['gestao'] . '.png') ? '<img src="/pf/img/icone-processo-gestao/' . $row['gestao'] . '.png" width="80" height="80" class="img-rounded img-thumbnail">' : '<div class="file-not-exists">' . $row['gestao'] . '</div>',
            'proposito' => $row['proposito'],
            'escopo' => $row['escopo'],
        	'bancoDadosDescricao' => $row['bancoDados']
        );
    }
    echo json_encode($arrayLista);
} else {
    echo json_encode(array(
        'sucesso' => FALSE,
        'msg' => 'Acesso n&tilde;o autorizado!'
    ));
}