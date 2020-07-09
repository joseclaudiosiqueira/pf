<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
//pagina de sumario ao final
!isset($_GET['p']) ? $pdf->addPage('P') : NULL;

$html = '   <table width="100%" border="0" cellpadding="5">'
        . '     <tr bgcolor="#d0d0d0"><td colspan="5" align="center" style="border-bottom: 1px solid #d0d0d0;"><strong>Sum&aacute;rio</strong></td></tr>'
        . '     <tr bgcolor="#f0f0f0">'
        . '         <td width="42%" style="border-bottom: 1px solid #d0d0d0;">Fun&ccedil;&atilde;o</td>'
        . '         <td width="10%" style="border-bottom: 1px solid #d0d0d0;" align="right">QTD</td>'
        . '         <td width="16%" style="border-bottom: 1px solid #d0d0d0;">Complexidade</td>'
        . '         <td width="16%" style="border-bottom: 1px solid #d0d0d0;" align="right">Total (PFb)</td>'
        . '         <td width="16%" style="border-bottom: 1px solid #d0d0d0;" align="right">Total (PFa)</td>'
        . '     </tr>';

//loop com as funcoes
for ($z = 0; $z < count($aFuncoes); $z++) {
    $html .= '      <tr>'
            . '         <td ' . ($idAbrangencia != 9 ? 'rowspan="3"' : 'height="64" valign="middle"') . '>' . $aFuncoes[$z]['sigla'] . ' - ' . $aFuncoes[$z]['descricao'] . '</td>'
            . '         <td align="right">' . ($idAbrangencia != 9 ? $statsSumario[$aFuncoes[$z]['sigla']]['b' . $aFuncoes[$z]['sigla']] : '-') . '</td>'
            . '         <td>' . ($idAbrangencia != 9 ? 'Baixa ' . $aFuncoes[$z]['baixa'] : $aFuncoes[$z]['EF']) . '</td>'
            . '         <td align="right">' . ($idAbrangencia == 9 ? number_format($statsPFB['pfb' . $aFuncoes[$z]['sigla']], 3, ",", ".") : number_format($statsSumario[$aFuncoes[$z]['sigla']]['totalB' . $aFuncoes[$z]['sigla'] . 'PFb'], 3, ",", ".")) . '</td>'
            . '         <td align="right">' . ($idAbrangencia == 9 ? number_format($statsPFA['pfa' . $aFuncoes[$z]['sigla']], 3, ",", ".") : number_format($statsSumario[$aFuncoes[$z]['sigla']]['totalB' . $aFuncoes[$z]['sigla'] . 'PFa'], 3, ",", ".")) . '</td>'
            . '     </tr>'
            . ($idAbrangencia != 9 ?
                    '     <tr>'
                    . '         <td align="right">' . $statsSumario[$aFuncoes[$z]['sigla']]['m' . $aFuncoes[$z]['sigla']] . '</td>'
                    . '         <td>M&eacute;dia ' . $aFuncoes[$z]['media'] . '</td>'
                    . '         <td align="right">' . number_format($statsSumario[$aFuncoes[$z]['sigla']]['totalM' . $aFuncoes[$z]['sigla'] . 'PFb'], 3, ",", ".") . '</td>'
                    . '         <td align="right">' . number_format($statsSumario[$aFuncoes[$z]['sigla']]['totalM' . $aFuncoes[$z]['sigla'] . 'PFa'], 3, ",", ".") . '</td>'
                    . '     </tr>'
                    . '     <tr>'
                    . '         <td align="right">' . $statsSumario[$aFuncoes[$z]['sigla']]['a' . $aFuncoes[$z]['sigla']] . '</td>'
                    . '         <td>Alta ' . $aFuncoes[$z]['alta'] . '</td>'
                    . '         <td align="right">' . number_format($statsSumario[$aFuncoes[$z]['sigla']]['totalA' . $aFuncoes[$z]['sigla'] . 'PFb'], 3, ",", ".") . '</td>'
                    . '         <td align="right">' . number_format($statsSumario[$aFuncoes[$z]['sigla']]['totalA' . $aFuncoes[$z]['sigla'] . 'PFa'], 3, ",", ".") . '</td>'
                    . '     </tr>' : '')
            . '     <tr bgcolor="#f0f0f0">'
            . '         <td style="border-bottom: 1px solid #d0d0d0;"><strong>Total</strong></td>'
            . '         <td style="border-bottom: 1px solid #d0d0d0;" align="right"><strong>' . $statsQTD['qtd' . $aFuncoes[$z]['sigla']] . '</strong></td>'
            . '         <td style="border-bottom: 1px solid #d0d0d0;" align="right">&nbsp;</td>'
            . '         <td style="border-bottom: 1px solid #d0d0d0;" align="right"><strong>' . number_format($statsPFB['pfb' . $aFuncoes[$z]['sigla']], 3, ",", ".") . '</strong></td>'
            . '         <td style="border-bottom: 1px solid #d0d0d0;" align="right"><strong>' . number_format($statsPFA['pfa' . $aFuncoes[$z]['sigla']], 3, ",", ".") . '</strong></td>'
            . '     </tr>';
}
//outras funcionalidades
//$statsSumario[$l['tipo']]['total' . $l['tipo']]
$html .= '</table>'
        . '<div width="100%" style="height:15px;">&nbsp;</div>';
$html .= '<table width="100%" border="0" cellpadding="5">'
        . '     <tr bgcolor="#f0f0f0">'
        . '         <td width="84%" style="border-bottom: 1px solid #d0d0d0;"><strong>OU - Outras Funcionalidades / INM - Itens n&atilde;o Mensur&aacute;veis</strong></td>'
        . '         <td width="16%" style="border-bottom: 1px solid #d0d0d0;" align="right"><strong>' . number_format($statsSumario['OU']['totalOU'], 3, ",", ".") . '</strong></td>'
        . '     </tr>'
        . '</table>';
//encerra a tabela
$html .= '<div width="100%" style="height:15px;">&nbsp;</div>';
//escreve a tabela
!isset($_GET['p']) ? $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true) : print $html;

$html = '   <table width="100%" border="0" cellpadding="5">'
        . '     <tr bgcolor="#d0d0d0"><td colspan="3" align="center" style="border-bottom: 1px solid #d0d0d0;"><strong>Resumo das opera&ccedil;&otilde;es</strong></td></tr>'
        . '     <tr bgcolor="#f0f0f0">'
        . '         <td style="border-bottom: 1px solid #d0d0d0;"></td>'
        . '         <td style="border-bottom: 1px solid #d0d0d0;" align="right">PFb</td>'
        . '         <td style="border-bottom: 1px solid #d0d0d0;" align="right">PFa</td>'
        . '     </tr>'
        . '     <tr>'
        . '         <td width="34%">Inclus&atilde;o</td>'
        . '         <td align="right">' . number_format($statsOPR['IPFb'], 3, ",", ".") . '</td>'
        . '         <td align="right">' . number_format($statsOPR['IPFa'], 3, ",", ".") . '</td>'
        . '     </tr>';
if ($statsOPR['NPFa'] > 0) {
    $html .= '     <tr>'
            . '         <td width="34%"><strong>Indicativa</strong></td>'
            . '         <td align="right">' . number_format($statsOPR['NPFb'], 3, ",", ".") . '</td>'
            . '         <td align="right">' . number_format($statsOPR['NPFa'], 3, ",", ".") . '</td>'
            . '     </tr>';
}
$html .= '     <tr>'
        . '         <td width="34%">Altera&ccedil;&atilde;o</td>'
        . '         <td align="right">' . number_format($statsOPR['APFb'], 3, ",", ".") . '</td>'
        . '         <td align="right">' . number_format($statsOPR['APFa'], 3, ",", ".")
        . ($statsOPR['RAPFa'] ? '<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RT: ' . number_format($statsOPR['RAPFa'], 3, ",", ".") . '(' . number_format($statsOPR['RAPFa'] / $statsOPR['APFa'] * 100, 2, ",", ".") . '%)' : '')
        . '         </td>'
        . '     </tr>'
        . '     <tr>'
        . '         <td width="34%">Exclus&atilde;o</td>'
        . '         <td align="right">' . number_format($statsOPR['EPFb'], 3, ",", ".") . '</td>'
        . '         <td align="right">' . number_format($statsOPR['EPFa'], 3, ",", ".")
        . ($statsOPR['REPFa'] ? '<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RT: ' . number_format($statsOPR['REPFa'], 3, ",", ".") . '(' . number_format($statsOPR['REPFa'] / $statsOPR['EPFa'] * 100, 2, ",", ".") . '%)' : '')
        . '         </td>'
        . '     </tr>'
        . '     <tr>'
        . '         <td width="34%">Testes</td>'
        . '         <td align="right">' . number_format($statsOPR['TPFb'], 3, ",", ".") . '</td>'
        . '         <td align="right">' . number_format($statsOPR['TPFa'], 3, ",", ".")
        . '         </td>'
        . '     </tr>';

$html .= '<tr><td colspan="3"></td></tr>'
        . '<tr>'
        . ' <td colspan="3" style="border-top: 1px solid #d0d0d0;">'
        . '<small>'
        . 'RT - Retrabalho - Pontos de Fun&ccedil;&atilde;o de retrabalho na totaliza&ccedil;&atilde;o de Altera&ccedil;&atilde;o / Exclus&atilde;o<br />'
        . 'Indicativa - Pontos de Fun&ccedil;&atilde;o de contagem NESMA - INDICATIVA;<br />'
        . 'OBS (1) No caso de PFb ser menor que PFa, verifique a soma contando com Outras funcionalidades, j&aacute; que nelas n&atilde;o h&aacute; PFb<br/>'
        . 'OBS (2) Os valores exibidos nas tabelas acima n&atilde;o cont&eacute;m c&aacute;lculos com o Fator de Redu&ccedil;&atilde;o do Cronograma nem o Fator de Aumento de Esfor&ccedil;o<br/>'
        . ($idAbrangencia == 9 ? 'OBS (3) No m&eacute;todo de Elementos Funcionais de dados/transa&ccedil;&atilde;o n&atilde;o existe o conceito de complexidade Baixa/M&eacute;dia/Alta' : '') . '</small>'
        . '</td></tr>';

$html .= '</table>';

//escreve a tabela
!isset($_GET['p']) ? $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true) : print $html;
