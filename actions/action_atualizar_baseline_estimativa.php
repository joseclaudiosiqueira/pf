<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * variaveis iniciais
 */
$contagem = new Contagem();
$emailUsuarioLogado = getVariavelSessao('user_email');
$idContagem = filter_input(INPUT_POST, 'idc', FILTER_SANITIZE_NUMBER_INT);
$isResponsavel = $contagem->isResponsavel($emailUsuarioLogado, $idContagem);
$isGestor = getVariavelSessao('isGestor') || getVariavelSessao('isGestorFornecedor') || $isResponsavel; //gestores e o responsavel pela contagem atualizam as baselines das contagens
/*
 * verificacao do status do login
 */
if ($login->isUserLoggedIn() && verificaSessao() && $isGestor) {
    $baselineEstimativa = new ContagemBaselineEstimativa();
    $baselineEstimativa->setLog();
    $baselineEstimativa->setIdContagem($idContagem);
    $tabelas = array('ali', 'aie', 'ee', 'se', 'ce', 'ou');
    $arrayBaselineEstimativas = array(
        'qtd_ali' => 0,
        'qtd_aie' => 0,
        'qtd_ee' => 0,
        'qtd_se' => 0,
        'qtd_ce' => 0,
        'qtd_ou' => 0,
        'pfb_ali' => 0,
        'pfa_ali' => 0,
        'pfb_aie' => 0,
        'pfa_aie' => 0,
        'pfb_ee' => 0,
        'pfa_ee' => 0,
        'pfb_se' => 0,
        'pfa_se' => 0,
        'pfb_ce' => 0,
        'pfa_ce' => 0,
        'pfb_ou' => 0,
        'pfa_ou' => 0,
    );
    /*
     * pega as variaveis da contagem
     */
    for ($x = 0; $x < count($tabelas); $x++) {
        $consultaPF = $contagem->getPFFuncoes($idContagem, $tabelas[$x]);
        $arrayBaselineEstimativas['qtd_' . $tabelas[$x]] = $consultaPF['qtd'];
        $arrayBaselineEstimativas['pfb_' . $tabelas[$x]] = $consultaPF['pfb'];
        $arrayBaselineEstimativas['pfa_' . $tabelas[$x]] = $consultaPF['pfa'];
    }
    /*
     * atualiza a tabela
     */
    $baselineEstimativa->setQtdALI($arrayBaselineEstimativas['qtd_ali']);
    $baselineEstimativa->setQtdAIE($arrayBaselineEstimativas['qtd_aie']);
    $baselineEstimativa->setQtdEE($arrayBaselineEstimativas['qtd_ee']);
    $baselineEstimativa->setQtdSE($arrayBaselineEstimativas['qtd_se']);
    $baselineEstimativa->setQtdCE($arrayBaselineEstimativas['qtd_ce']);
    $baselineEstimativa->setQtdOU($arrayBaselineEstimativas['qtd_ou']);
    //pfa e pfb
    $baselineEstimativa->setPfbALI($arrayBaselineEstimativas['pfb_ali']);
    $baselineEstimativa->setPfaALI($arrayBaselineEstimativas['pfa_ali']);
    $baselineEstimativa->setPfbAIE($arrayBaselineEstimativas['pfb_aie']);
    $baselineEstimativa->setPfaAIE($arrayBaselineEstimativas['pfa_aie']);
    $baselineEstimativa->setPfbEE($arrayBaselineEstimativas['pfb_ee']);
    $baselineEstimativa->setPfaEE($arrayBaselineEstimativas['pfa_ee']);
    $baselineEstimativa->setPfbSE($arrayBaselineEstimativas['pfb_se']);
    $baselineEstimativa->setPfaSE($arrayBaselineEstimativas['pfa_se']);
    $baselineEstimativa->setPfbCE($arrayBaselineEstimativas['pfb_ce']);
    $baselineEstimativa->setPfaCE($arrayBaselineEstimativas['pfa_ce']);
    $baselineEstimativa->setPfbOU($arrayBaselineEstimativas['pfb_ou']);
    $baselineEstimativa->setPfaOU($arrayBaselineEstimativas['pfa_ou']);
    /*
     * atualiza a baseline de estimativa
     */
    echo json_encode(array(
        'sucesso' => $baselineEstimativa->atualiza(),
        'msg' => 'Baseline de estimativa salva com sucesso!'));
} else {
    echo json_encode(array('sucesso' => TRUE, 'msg' => 'Não autorizado!'));
}

