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
// cria a instancia de uma contagem
$c = new Contagem();
$ch = new ContagemHistorico();
$ch->setIdContagem($id);
$historico = $ch->getHistorico();
$ce = new ContagemEstatisticas();
$co = new ContagemEstatisticasCocomo();
$r = new ClienteConfigRelatorio();
$u = new Usuario();
$ca = new ClienteConfigProjetoAssinatura();
// variaveis
$linhas = array(); // array que armazena todas as linhas ALI, AIE, etc.
$linhasTd = array();
$linhasTr = array();
// precisa pegar antes para saber se eh baseline/licitacao
$idAbrangencia = $c->getAbrangencia($id)['id_abrangencia'];
// seleciona todas as linhas de funcao
$funcoes = $c->getListaFuncoes($id);
$configRelatorio = $r->getConfig($consultaContagem['CNT_id_cliente']);
$sqlEst = "SELECT * FROM contagem_estatisticas ce, contagem_estatisticas_cocomo co WHERE ce.id_contagem = :id AND co.id_contagem = :id";
$estatisticas = $ce->consulta($id, true, $sqlEst, 'id_contagem');
$usuario = $u->getCompleteName($consultaContagem['CNT_user_id']);
$assinaturas = $ca->getConfig($consultaContagem['CNT_id_projeto']);
/*
 * pontos de funcao brutos e ajustados totais
 */
$pfaDados = $c->totalPFADados($id);
$pfaTransacao = $c->totalPFATransacao($id);
$pfaOutros = $c->totalPFAOutros($id);
/*
 * array generico contendo as fases
 */
$fases = array(
    'eng',
    'des',
    'imp',
    'tes',
    'hom',
    'impl'
);
$naoExecutada = ''; // armazena alguma fase que esta prevista mas nao ser executada
/*
 * array contendo as informacoes basicas de cada funcao de transaca e dados
 */
$aFuncoes = array(
    array(
        'sigla' => 'ALI',
        'descricao' => 'Arquivos Lógicos Internos',
        'baixa' => 'x7',
        'media' => 'x10',
        'alta' => 'x15',
        'EF' => 'EFd'
    ),
    array(
        'sigla' => 'AIE',
        'descricao' => 'Arquivos de Interface Externa',
        'baixa' => 'x5',
        'media' => 'x7',
        'alta' => 'x10',
        'EF' => 'EFd'
    ),
    array(
        'sigla' => 'EE',
        'descricao' => 'Entradas Externas',
        'baixa' => 'x3',
        'media' => 'x4',
        'alta' => 'x6',
        'EF' => 'EFt'
    ),
    array(
        'sigla' => 'SE',
        'descricao' => 'Saídas Externas',
        'baixa' => 'x4',
        'media' => 'x5',
        'alta' => 'x7',
        'EF' => 'EFt'
    ),
    array(
        'sigla' => 'CE',
        'descricao' => 'Consultas Externas',
        'baixa' => 'x3',
        'media' => 'x4',
        'alta' => 'x6',
        'EF' => 'EFt'
    )
);

/*
 * variaveis que serao somadas nos loops
 */
$statsPFA = array(
    'pfaALI' => 0,
    'pfaAIE' => 0,
    'pfaEE' => 0,
    'pfaSE' => 0,
    'pfaCE' => 0,
    'pfaOU' => 0
);
$statsPFB = array(
    'pfbALI' => 0,
    'pfbAIE' => 0,
    'pfbEE' => 0,
    'pfbSE' => 0,
    'pfbCE' => 0,
    'pfbOU' => 0
);
$statsQTD = array(
    'qtdALI' => 0,
    'qtdAIE' => 0,
    'qtdEE' => 0,
    'qtdSE' => 0,
    'qtdCE' => 0,
    'qtdOU' => 0,
    'total' => 0
);
$statsOPR = array(
    'IPFb' => 0,
    'APFb' => 0,
    'EPFb' => 0,
    'TPFb' => 0,
    'NPFb' => 0,
    'IPFa' => 0,
    'APFa' => 0,
    'EPFa' => 0,
    'TPFa' => 0,
    'NPFa' => 0,
    'RAPFa' => 0,
    'REPFa' => 0
);
$statsDes = array(
    'desALI' => 0,
    'desAIE' => 0,
    'desEE' => 0,
    'desSE' => 0,
    'desCE' => 0,
    'desOU' => 0
);
/*
 * array contendo as estatisticas de complexidades e totais para o sumario
 */
$statsSumario = array(
    'ALI' => array(
        'bALI' => 0,
        'mALI' => 0,
        'aALI' => 0,
        'EFdALI' => 0,
        'totalBALIPFb' => 0,
        'totalMALIPFb' => 0,
        'totalAALIPFb' => 0,
        'totalBALIPFa' => 0,
        'totalMALIPFa' => 0,
        'totalAALIPFa' => 0,
        'totalEFdALIPFa' => 0,
        'totalEFdALIPFb' => 0,
        'totalFEALI' => 0
    ),
    'AIE' => array(
        'bAIE' => 0,
        'mAIE' => 0,
        'aAIE' => 0,
        'EFdAIE' => 0,
        'totalBAIEPFb' => 0,
        'totalMAIEPFb' => 0,
        'totalAAIEPFb' => 0,
        'totalBAIEPFa' => 0,
        'totalMAIEPFa' => 0,
        'totalAAIEPFa' => 0,
        'totalEFdAIEPFa' => 0,
        'totalEFdAIEPFb' => 0
    ),
    'EE' => array(
        'bEE' => 0,
        'mEE' => 0,
        'aEE' => 0,
        'EFtEE' => 0,
        'totalBEEPFb' => 0,
        'totalMEEPFb' => 0,
        'totalAEEPFb' => 0,
        'totalBEEPFa' => 0,
        'totalMEEPFa' => 0,
        'totalAEEPFa' => 0,
        'totalEFtEEPFa' => 0,
        'totalEFtEEPFb' => 0
    ),
    'SE' => array(
        'bSE' => 0,
        'mSE' => 0,
        'aSE' => 0,
        'EFtSE' => 0,
        'totalBSEPFb' => 0,
        'totalMSEPFb' => 0,
        'totalASEPFb' => 0,
        'totalBSEPFa' => 0,
        'totalMSEPFa' => 0,
        'totalASEPFa' => 0,
        'totalEFtSEPFa' => 0,
        'totalEFtSEPFb' => 0
    ),
    'CE' => array(
        'bCE' => 0,
        'mCE' => 0,
        'aCE' => 0,
        'EFtCE' => 0,
        'totalBCEPFb' => 0,
        'totalMCEPFb' => 0,
        'totalACEPFb' => 0,
        'totalBCEPFa' => 0,
        'totalMCEPFa' => 0,
        'totalACEPFa' => 0,
        'totalEFtCEPFa' => 0,
        'totalEFtCEPFb' => 0
    ),
    'OU' => array(
        'totalOU' => 0
    )
);
$linhasDados = array();
$linhasTransacao = array();
$linhasOutros = array();
/*
 * array com as entregas
 */
$entregas = array();
/*
 * verifica se existem funcoes e faz o loop nas variaveis
 */
if (count($funcoes) > 0) {
    // armazena as variaveis que serao utilizadas ao longo do relatorio
    $iniColor = '';
    foreach ($funcoes as $l) {
        // armazena no array os valores para os tds
        $ln = array(
            'iniColor' => $iniColor,
            'funcao' => $l['funcao'],
            'tipo' => $l['tipo'],
            'operacao' => $l['operacao'],
            'td' => $l['tipo'] === 'OU' ? 'QTD:' . $l['td'] : $l['td'],
            'tr' => $l['tipo'] === 'OU' ? '-' : $l['tr'],
            'complexidade' => $l['tipo'] === 'OU' ? '-' : $l['complexidade'],
            'pfb' => $l['tipo'] === 'OU' ? '-' : number_format($l['pfb'], 3, ",", "."),
            'pfa' => number_format($l['pfa'], 3, ",", "."),
            'obs_funcao' => $l['obs_funcao'],
            'm_sigla' => $l['tipo'] === 'OU' ? '-' : $l['m_sigla'],
            'is_mudanca' => $l['is_mudanca'],
            'fase_mudanca' => $l['fase_mudanca'],
            'percentual_fase' => $l['percentual_fase'],
            'fd' => $l['fd'],
            'fe' => $l['fe'],
            'fonte' => $l['fonte'],
            'fator' => $l['fator'],
            'f_sigla' => $l['f_sigla'],
            'f_descricao' => $l['f_descricao'],
            'descricao_td' => $l['descricao_td'],
            'descricao_tr' => $l['descricao_tr'],
            'situacao' => $l['situacao'],
            'fator_tecnologia' => $l['fator_tecnologia'],
            'id_metodo' => $l['id_metodo']
        ); // 1-NESMA, 2-FP-Lite, 3-Detalhado
        switch ($l['tipo']) {
            case 'ALI':
            case 'AIE':
                $linhasDados[] = $ln;
                break;
            case 'EE':
            case 'SE':
            case 'CE':
                $linhasTransacao[] = $ln;
                break;
            case 'OU':
                $linhasOutros[] = $ln;
                break;
        }
        // adiciona de qualquer jeito
        $linhas[] = $ln;
        // calcula as estatisticas
        $statsQTD['qtd' . $l['tipo']] += 1;
        $statsQTD['total'] += 1;
        $statsPFB['pfb' . $l['tipo']] += $l['pfb'];
        $statsPFA['pfa' . $l['tipo']] += $l['pfa'];
        // operacao
        $statsOPR[$l['operacao'] . 'PFb'] += $l['pfb'];
        $statsOPR[$l['operacao'] . 'PFa'] += $l['pfa'];
        // formulario estendido
        if ($l['tipo'] === 'ALI' && $l['fe'] > 0) {
            $statsSumario['ALI']['totalFEALI'] += $l['fe'];
        }
        // verifica A/E para colocar retrabalho
        if ($l['is_mudanca']) {
            if ($l['operacao'] === 'A') {
                $statsOPR['R' . $l['operacao'] . 'PFa'] += $l['pfa'];
            } elseif ($l['operacao'] === 'E') {
                $statsOPR['R' . $l['operacao'] . 'PFa'] += $l['pfa'];
            }
        }
        // calcula para o sumario
        switch ($l['complexidade']) {
            case 'Baixa':
                $statsSumario[$l['tipo']]['b' . $l['tipo']] += 1;
                $statsSumario[$l['tipo']]['totalB' . $l['tipo'] . 'PFb'] += $l['pfb'];
                $statsSumario[$l['tipo']]['totalB' . $l['tipo'] . 'PFa'] += $l['pfa'];
                break;
            case 'Media':
                $statsSumario[$l['tipo']]['m' . $l['tipo']] += 1;
                $statsSumario[$l['tipo']]['totalM' . $l['tipo'] . 'PFb'] += $l['pfb'];
                $statsSumario[$l['tipo']]['totalM' . $l['tipo'] . 'PFa'] += $l['pfa'];
                break;
            case 'Alta':
                $statsSumario[$l['tipo']]['a' . $l['tipo']] += 1;
                $statsSumario[$l['tipo']]['totalA' . $l['tipo'] . 'PFb'] += $l['pfb'];
                $statsSumario[$l['tipo']]['totalA' . $l['tipo'] . 'PFa'] += $l['pfa'];
                break;
            case 'EFd':
                $statsSumario[$l['tipo']]['EFd' . $l['tipo']] += 1;
                $statsSumario[$l['tipo']]['totalEFd' . $l['tipo'] . 'PFb'] += $l['pfb'];
                $statsSumario[$l['tipo']]['totalEFd' . $l['tipo'] . 'PFa'] += $l['pfa'];
                break;
            case 'EFt':
                $statsSumario[$l['tipo']]['EFt' . $l['tipo']] += 1;
                $statsSumario[$l['tipo']]['totalEFt' . $l['tipo'] . 'PFb'] += $l['pfb'];
                $statsSumario[$l['tipo']]['totalEFt' . $l['tipo'] . 'PFa'] += $l['pfa'];
                break;
            default:
                $statsSumario[$l['tipo']]['total' . $l['tipo']] += $l['pfa'];
                break;
        }
        // soma os totais
        // alterna as cores das linhas
        $iniColor = ($iniColor === '' ? '#f0f0f0' : '');
        // coloca no array entregas
        if (array_key_exists('ENT-' . $l['entrega'], $entregas)) {
            $entregas['ENT-' . $l['entrega']]['ENTREGA-' . $l['entrega']] .= $l['tipo'] . '-' . $l['funcao'] . ',';
            $entregas['ENT-' . $l['entrega']]['ENTREGA-PFA-' . $l['entrega']] += $l['pfa'];
        } else {
            $entregas['ENT-' . $l['entrega']] = array(
                'ENTREGA-' . $l['entrega'] => $l['tipo'] . '-' . $l['funcao'] . ',',
                'ENTREGA-PFA-' . $l['entrega'] => $l['pfa']
            );
        }
    }
    // variacoes
    $statsDes['desALI'] = ($statsPFA['pfaALI'] && $statsPFB['pfbALI']) ? 100 - ($statsPFA['pfaALI'] / $statsPFB['pfbALI'] * 100) : 0;
    $statsDes['desAIE'] = ($statsPFA['pfaAIE'] && $statsPFB['pfbAIE']) ? 100 - ($statsPFA['pfaAIE'] / $statsPFB['pfbAIE'] * 100) : 0;
    $statsDes['desEE'] = ($statsPFA['pfaEE'] && $statsPFB['pfbEE']) ? 100 - ($statsPFA['pfaEE'] / $statsPFB['pfbEE'] * 100) : 0;
    $statsDes['desSE'] = ($statsPFA['pfaSE'] && $statsPFB['pfbSE']) ? 100 - ($statsPFA['pfaSE'] / $statsPFB['pfbSE'] * 100) : 0;
    $statsDes['desCE'] = ($statsPFA['pfaCE'] && $statsPFB['pfbCE']) ? 100 - ($statsPFA['pfaCE'] / $statsPFB['pfbCE'] * 100) : 0;
}