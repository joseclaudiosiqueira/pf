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
    if (NULL !== filter_input(INPUT_POST, 'idc', FILTER_SANITIZE_NUMBER_INT)) {
        //id da contagem
        $id = filter_input(INPUT_POST, 'idc', FILTER_SANITIZE_NUMBER_INT);
        $estatisticas = new ContagemEstatisticas();
        $estatisticas->setIdContagem($id);
        //outras variaveis
        $tabela_fator_tecnologia = $estatisticas->getTabelaFatorTecnologia($id);
        $quantidade_total = 0;
        $numero_linhas = 0;
        $percentual_de_cada = array();
        //faz os calculos percentuais e deixa disponivel no array
        foreach ($tabela_fator_tecnologia as $fator) {
            $quantidade_total += $fator['quantidade'];
            $numero_linhas++;
        }
        if ($numero_linhas) {
            for ($x = 0; $x < $numero_linhas; $x++) {
                $percentual_de_cada[] = number_format($tabela_fator_tecnologia[$x]['quantidade'] / $quantidade_total, 4);
            }
        }
        echo json_encode(array('fator_tecnologia' => $tabela_fator_tecnologia, 'percentual_de_cada' => $percentual_de_cada));
    } else {
        echo json_encode(array('sucesso' => true, 'msg' => 'A contagem ainda n&atilde;o foi salva ou n&atilde;o possui um #ID associado'));
    }
} else {
    echo json_encode(array('sucesso' => false, 'msg' => 'Acesso n&atilde;o autorizado!'));
}
