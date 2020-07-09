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
!(isset($_GET['p'])) ? $pdf->addPage('P') : NULL;
//define no inicio para as multiplicacoes posteriores
$fatorTecnologia = ($estatisticas['is_ft'] ? $estatisticas['ft'] : 1);
//array com os expoentes
$arrExpoente = array(
    '0.00' => 'N&atilde;o especificado',
    '0.32' => 'Sistema Comum - Mainframe (desenvolvimento de sistema com alto grau de reuso ou manuten&ccedil;&atilde;o evolutiva)',
    '0.33' => 'Sistema Comum - Mainframe (desenvolvimento de sistema com alto grau de reuso ou manuten&ccedil;&atilde;o evolutiva)',
    '0.34' => 'Sistema Comum - WEB ou Cliente Servidor',
    '0.35' => 'Sistema Comum - WEB ou Cliente Servidor',
    '0.36' => 'Sistema OO - (se o projeto OO n&atilde;o for novidade para a equipe, n&atilde;o tiver o desenvolvimento de componentes reus&aacute;veis, considerar sistema comum)',
    '0.37' => 'Sistema Cliente/Servidor (com alta complexidade arquitetural e integra&ccedil;&atilde;o com outros sistemas)',
    '0.39' => 'Sistemas Gerenciais complexos com muitas integra&ccedil;&otilde;es, Datawarehousing, Geoprocessamento, Workflow',
    '0.40' => 'Software B&aacute;sico, Frameworks, Sistemas Comerciais',
    '0.45' => 'Software Militar (ex: Defesa do Espa&ccedil;o A&eacute;reo)');
//variavel que armazena [baixa, media, alta]
$escala = $estatisticas['escala_produtividade'];
//variavel que armazena o fator de reducao do cronograma
$fator_reducao_cronograma = $estatisticas['fator_reducao_cronograma'];
//verifica cada uma das fases na config_contagem e escreve
//variavel que armazena a produtividade de cada fase para calculo da media quando nao eh
//utilizada a produtividade global nem a produtividade linguagem
//a outra armazena a quantidade para realizar a divisao apenas nas fases ativas
$produtividade_fases = 0;
$quantidade_fases = 0;
$html_fases = '';
$pfaFasesSelecionadas = 0;
for ($x = 0; $x < count($fases); $x++) {
    if ($estatisticas['is_f_' . $fases[$x]]) {
        if ($estatisticas['chk_' . $fases[$x]]) {
            $html_fases .= '<tr>'
                    . ' <td>' . $estatisticas['desc_f_' . $fases[$x]] . '</td>'
                    . ' <td align="center">' . $estatisticas['pct_' . $fases[$x]] . '%</td>'
                    . ' <td align="center">' . number_format($estatisticas['pct_pfa_' . $fases[$x]], 4, ",", ".") . '</td>'
                    . ' <td align="right">' . number_format($estatisticas['prod_' . $fases[$x]], 2, ",", ".") . '</td>'
                    . ' <td align="center">' . $estatisticas['prof_' . $fases[$x]] . '</td>'
                    . ' <td>' . $estatisticas['perf_' . $fases[$x]] . '</td>'
                    . ' <td>' . str_replace('.', ',', $estatisticas['esforco_f_' . $fases[$x]]) . '</td>'
                    . ' <td>' . $estatisticas['previsao_f_' . $fases[$x]] . '</td>'
                    . '</tr>';
            $produtividade_fases += number_format($estatisticas['prod_' . $fases[$x]], 2);
            $quantidade_fases += 1;
            $pfaFasesSelecionadas += $estatisticas['pct_pfa_' . $fases[$x]];
        } else {
            $naoExecutada .= $estatisticas['desc_f_' . $fases[$x]] . ',';
        }
    }
}
$produtividade_media_calculada = ($produtividade_fases > 0 && $quantidade_fases > 0) ? $produtividade_fases / $quantidade_fases : 0;
$naoExecutada = substr($naoExecutada, 0, strlen($naoExecutada) - 1); //retira a virgula do final
$html = '<div width="100%" style="height:15px;">&nbsp;</div>';
$html .= '<table width="100%" border="0" cellpadding="5">
            <tr bgcolor="#c0c0c0"><td colspan="5" align="center" style="border-bottom: 1px solid #d0d0d0;"><strong>Estat&iacute;sticas</strong></td></tr>
            <tr bgcolor="#f0f0f0">
                <td width="38%" style="border-bottom: 1px solid #d0d0d0;">Fun&ccedil;&atilde;o</td>
                <td width="06%" style="border-bottom: 1px solid #d0d0d0;">Qtd.</td>
                <td width="19%" style="border-bottom: 1px solid #d0d0d0;" align="right">PF(b)</td>
                <td width="19%" style="border-bottom: 1px solid #d0d0d0;" align="right">PF(a)</td>
                <td width="18%" style="border-bottom: 1px solid #d0d0d0;" align="right">Varia&ccedil;&atilde;o</td>
            </tr>';
for ($y = 0; $y < count($aFuncoes); $y++) {
    $html .= '<tr>
                <td>' . $aFuncoes[$y]['sigla'] . ' - ' . $aFuncoes[$y]['descricao'] . '</td>
                <td>' . $statsQTD['qtd' . $aFuncoes[$y]['sigla']] . '</td>
                <td align="right">' . number_format($statsPFB['pfb' . $aFuncoes[$y]['sigla']], 4, ",", ".") . '</td>
                <td align="right">' . number_format($statsPFA['pfa' . $aFuncoes[$y]['sigla']], 4, ",", ".") . '</td>
                <td align="right">' . number_format($statsDes['des' . $aFuncoes[$y]['sigla']], 4, ",", ".") . '%</td>
            </tr>';
}
//Outras em separado
$html .= '<tr>
                <td>Outras</td>
                <td>' . $statsQTD['qtdOU'] . '</td>
                <td align="right">-</td>
                <td align="right">' . number_format($statsPFA['pfaOU'], 4, ",", ".") . '</td>
                <td align="right">-</td>
            </tr>
            <tr bgcolor="#f0f0f0">
                <td style="border-top: 1px solid #d0d0d0;"><strong>Totais</strong></td>
                <td style="border-top: 1px solid #d0d0d0;"><strong>' . $statsQTD['total'] . '</strong></td>
                <td style="border-top: 1px solid #d0d0d0;" align="right"><strong>' . number_format(array_sum($statsPFB), 4, ",", ".") . '</strong></td>
                <td style="border-top: 1px solid #d0d0d0;" align="right"><strong>' . number_format(array_sum($statsPFA), 4, ",", ".") . '</strong></td>
                <td style="border-top: 1px solid #d0d0d0;" align="right">-</td>
            </tr>';
$html .= '</table><div width="100%" style="height:15px;">&nbsp;</div>';

$html .= '<table width="100%" border="0" cellpadding="5">'
        . '             <tr bgcolor="#c0c0c0"><td colspan="2" align="center" style="border-bottom: 1px solid #d0d0d0;"><strong>Fatores para o Prazo, Custo e Esfor&ccedil;o</strong></td></tr>'
        . '             <tr bgcolor="#f0f0f0">'
        . '                 <td style="border-bottom: 1px solid #d0d0d0;" width="65%">Tipo de projeto</td>'
        . '                 <td style="border-bottom: 1px solid #d0d0d0;" width="35%" align="center">Selecionado</td>'
        . '             </tr>'
        . '             <tr>'
        . '                 <td>Padr&atilde;o</td>'
        . '                 <td align="center"><strong>' . ($estatisticas['tipo_projeto'] == 1 ? 'SIM' : '-') . '</strong></td>'
        . '             </tr>'
        . '             <tr>'
        . '                 <td>Urgente</td>'
        . '                 <td align="center"><strong>' . ($estatisticas['tipo_projeto'] == 2 ? 'SIM' : '-') . '</strong></td>'
        . '             </tr>'
        . '             <tr>'
        . '                 <td>Cr&iacute;tico</td>'
        . '                 <td align="center"><strong>' . ($estatisticas['tipo_projeto'] == 3 ? 'SIM' : '-') . '</strong></td>'
        . '             </tr>'
        . '             <tr>'
        . '                 <td>Alta Criticidade</td>'
        . '                 <td align="center"><strong>' . ($estatisticas['tipo_projeto'] == 4 ? 'SIM' : '-') . '</strong></td>'
        . '             </tr>'
        . '             <tr>'
        . '                 <td>Solicita&ccedil;&atilde;o Cr&iacute;tica</td>'
        . '                 <td align="center"><strong>' . ($estatisticas['tipo_projeto'] == 5 ? 'SIM' : '-') . '</strong></td>'
        . '             </tr>'
        . '             <tr>'
        . '                 <td>Fator de Redu&ccedil;&atilde;o do Cronograma</td>'
        . '                 <td align="center"><strong>' . number_format($estatisticas['fator_reducao_cronograma'], 3, ",", ".") . ' - ' . (1 - $estatisticas['fator_reducao_cronograma']) * 100 . '%</strong>'
        . '                 </td>'
        . '             </tr>'
        . '             <tr>'
        . '                 <td>Fator de Aumento do Esfor&ccedil;o</td>'
        . '                 <td align="center"><strong>' . number_format($estatisticas['aumento_esforco'], 3, ",", ".") . '</strong>'
        . '                 </td>'
        . '             </tr>'
        . '             <tr>'
        . '                 <td>Expoente (t)<br><small>' . $arrExpoente[number_format($estatisticas['expoente'], 2)] . '</small></td>'
        . '                 <td align="center"><strong>' . number_format($estatisticas['expoente'], 2, ",", ".") . '</strong></td>'
        . '             </tr>'
        . '             <tr>'
        . '                 <td>Fator Tecnologia - FT</td>'
        . '                 <td align="center"><strong>' . ($estatisticas['is_ft'] ? number_format($estatisticas['ft'], 2, ',', '.') : '-') . '</strong></td>'
        . '              </tr>'
        . '         </table>
            <div width="100%" style="height:15px;">&nbsp;</div>';
//define os totais para nao fazer confusao com os decimais
$valorTotalPFA = $pfaFasesSelecionadas * $estatisticas['valor_pfa_contrato'];
$valorTotalPFAAjustado = $pfaFasesSelecionadas * $estatisticas['valor_pfa_contrato'] * $estatisticas['aumento_esforco'];
$valorTotalHPC = $estatisticas['valor_hpc'] * $estatisticas['hpc'];
$valorTotalHPCAjustado = $estatisticas['valor_hpc'] * $estatisticas['hpc'] * $estatisticas['aumento_esforco'];
$valorTotalHPA = $estatisticas['valor_hpa'] * $estatisticas['hpa'];
$valorTotalHPAAjustado = $estatisticas['valor_hpa'] * $estatisticas['hpa'] * $estatisticas['aumento_esforco'];
$valorTotal = $valorTotalPFA + $valorTotalHPC + $valorTotalHPA;
$valorTotalAjustado = $valorTotalPFAAjustado + $valorTotalHPCAjustado + $valorTotalHPAAjustado;
//escreve o html
$html .= '<table width="100%" border="0" cellpadding="5">'
        . '             <tr bgcolor="#c0c0c0"><td colspan="6" align="center" style="border-bottom: 1px solid #d0d0d0;"><strong>Esfor&ccedil;o e Custo (Ajustados)</strong></td></tr>'
        . '             <tr bgcolor="#f0f0f0">'
        . '                 <td width="34%" style="border-bottom: 1px solid #d0d0d0;">Vari&aacute;vel</td>'
        . '                 <td width="13%" style="border-bottom: 1px solid #d0d0d0;">Qtd.</td>'
        . '                 <td width="13%" style="border-bottom: 1px solid #d0d0d0;">Unidade</td>'
        . '                 <td width="20%" style="border-bottom: 1px solid #d0d0d0;" align="right">Valor</td>'
        . '                 <td width="20%" style="border-bottom: 1px solid #d0d0d0;" align="right">Total</td>'
        . '             </tr>'
        . '             <tr>'
        . '                 <td>Tamanho</td>'
        . '                 <td>' . number_format($pfaFasesSelecionadas * $estatisticas['aumento_esforco'], 4, ",", ".") . '</td>'
        . '                 <td>PFa</td>'
        . '                 <td align="right">' . (isPermitido('visualizar_valor_pf') ? ' R$ ' . number_format($estatisticas['valor_pfa_contrato'], 2, ",", ".") : '-') . '</td>'
        . '                 <td align="right">' . (isPermitido('visualizar_valor_pf') ? ' R$ ' . number_format($valorTotalPFA, 2, ",", ".") : '-') . '</td>'
        . '             </tr>'
        . '             <tr>'
        . '                 <td>Produtividade</td>'
        . '                 <td>' . ($estatisticas['chk_produtividade_global'] ?
                number_format($estatisticas['produtividade_global'], 2, ",", ".") :
                ($estatisticas['chk_produtividade_linguagem'] ? number_format($estatisticas['produtividade_' . $escala], 2, ",", ".") : number_format($produtividade_media_calculada, 2, ",", "."))) . '</td>'
        . '                 <td>h/PF</td>'
        . '                 <td></td>'
        . '                 <td></td>'
        . '             </tr>'
        . '             <tr>'
        . '                 <td>Horas Perfil Consultor</td>'
        . '                 <td>' . $estatisticas['hpc'] . '</td>'
        . '                 <td>H/h</td>'
        . '                 <td align="right">' . (isPermitido('visualizar_valor_pf') ? ' R$ ' . number_format($estatisticas['valor_hpc'], 2, ",", ".") : '-') . '</td>'
        . '                 <td align="right">' . (isPermitido('visualizar_valor_pf') ? ' R$ ' . number_format($valorTotalHPC, 2, ",", ".") : '-') . '</td>'
        . '             </tr>'
        . '             <tr>'
        . '                 <td>Horas Perfil Analista</td>'
        . '                 <td>' . $estatisticas['hpa'] . '</td>'
        . '                 <td>H/h</td>'
        . '                 <td align="right">' . (isPermitido('visualizar_valor_pf') ? ' R$ ' . number_format($estatisticas['valor_hpa'], 2, ",", ".") : '-') . '</td>'
        . '                 <td align="right">' . (isPermitido('visualizar_valor_pf') ? ' R$ ' . number_format($valorTotalHPA, 2, ",", ".") : '-') . '</td>'
        . '             </tr>'
        . '             <tr>'
        . '                 <td>Esfor&ccedil;o Total</td>'
        . '                 <td>' . number_format($estatisticas['esforco_total'], 4, ",", ".") . '</td>'
        . '                 <td>hora(s)</td>'
        . '                 <td></td>'
        . '                 <td></td>'
        . '             </tr>'
        . '             <tr bgcolor="#f0f0f0">'
        . '                 <td style="border-top: 1px solid #d0d0d0;"><strong>Custo total</strong></td>'
        . '                 <td style="border-top: 1px solid #d0d0d0;"></td>'
        . '                 <td style="border-top: 1px solid #d0d0d0;">R$</td>'
        . '                 <td style="border-top: 1px solid #d0d0d0;"></td>'
        . '                 <td align="right" style="border-top: 1px solid #d0d0d0;"><strong>' . (isPermitido('visualizar_valor_pf') ? ' R$ ' . number_format($valorTotalAjustado, 2, ",", ".") : '-') . '</strong></td>'
        . '             </tr>';
$html .= ''
        . '<tr>'
        . ' <td colspan="6" style="border-top: 1px solid #d0d0d0;">'
        . '<small>'
        . '(1) Os valores exibidos na coluna <strong>Total</strong> consideram Fator de Redu&ccedil;&atilde;o do Cronograma. o Aumento de Esfor&ccedil;o e o Fator Tecnologia.<br />'
        . '(2) PF(b) - Pontos de Fun&ccedil;&atilde;o Brutos | PF(a) - Pontos de Fun&ccedil;&atilde;o Ajustados'
        . (!isPermitido('visualizar_valor_pf') ? '<br>(3) Seu perfil n&atilde;o permite visualizar os valores em Reais para faturamento' : '') . '</small>'
        . '</td></tr>';

$html .= '</table><div width="100%" style="height:15px;">&nbsp;</div>';

!isset($_GET['p']) ? $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true) : print $html;

!isset($_GET['p']) ? $pdf->addPage('L') : NULL;
/*
 * nao exibe caso esteja comparando
 */
if (!(isset($_GET['cp']))) {
    $html = '<table width="100%" border="0" cellpadding="5">
                <tr bgcolor="#c0c0c0"><td colspan="4" align="center" style="border-bottom: 1px solid #d0d0d0;"><strong>Planejamento</strong></td></tr>
                <tr bgcolor="#f0f0f0">
                    <td width="20%" style="border-bottom: 1px solid #d0d0d0;">Previs&atilde;o de in&iacute;cio</td>
                    <td width="24%" style="border-bottom: 1px solid #d0d0d0;">Produtividade Global</td>
                    <td width="24%" style="border-bottom: 1px solid #d0d0d0;">Produtividade Linguagem</td>
                    <td width="32%" style="border-bottom: 1px solid #d0d0d0;">HLT</td>
                </tr>
                <tr>
                    <td>' . date_format(date_create($estatisticas['previsao_inicio']), 'd/m/Y') . '</td>
                    <td>'
            . number_format($estatisticas['produtividade_global'], 2, ",", ".")
            . ' - Utilizada: ' . ($estatisticas['chk_produtividade_global'] ? '<strong>SIM</strong>' : 'NÃO') . '</td>
                    <td>'
            . str_replace(array('baixa', 'media', 'alta'), array('Baixa', 'Média', 'Alta'), $estatisticas['escala_produtividade'])
            . ' => ' . number_format($estatisticas['produtividade_' . $escala], 2, ",", ".")
            . ' - Utilizada: ' . ($estatisticas['chk_produtividade_linguagem'] ? '<strong>SIM</strong>' : 'NÃO') . '</td>
                    <td>' . number_format($estatisticas['hlt'], 2, ",", ".") . ' hora(s) por dia</td>
                </tr>
              </table>
              
              <table width="100%" border="0" cellpadding="5">             
                <tr bgcolor="#f0f0f0">
                    <td width="19%" style="border-bottom: 1px solid #d0d0d0;">Fases</td>
                    <td width="6%" style="border-bottom: 1px solid #d0d0d0;" align="center">PCT</td>
                    <td width="6%" style="border-bottom: 1px solid #d0d0d0;" align="center">PFa</td>
                    <td width="6%" style="border-bottom: 1px solid #d0d0d0;" align="center">hh/PF</td>
                    <td width="6%" style="border-bottom: 1px solid #d0d0d0;" align="center">Equipe</td>
                    <td width="29%" style="border-bottom: 1px solid #d0d0d0;">Perfis/Nomes</td>
                    <td width="12%" style="border-bottom: 1px solid #d0d0d0;">Esfor&ccedil;o</td>
                    <td width="16%" style="border-bottom: 1px solid #d0d0d0;">Previs&otilde;es</td>
                </tr>';
    $html_fases .= '<tr>'
            . '<td colspan="8" style="border-top: 1px solid #d0d0d0;">'
            . '<small>'
            . '(0) Utilize estas informa&ccedil;&otilde;es para um planejamento global e para cada itera&ccedil;&atilde;o utilize o quadro &quot;Planejamento de Entregas&quot;<br>'
            . '(1) Os valores exibidos j&aacute; consideram o Fator de Redu&ccedil;&atilde;o do Cronograma e o Aumento de Esfor&ccedil;o, caso sejam aplic&aacute;veis. Para informa&ccedil;&otilde;es mais detalhadas veja a se&ccedil;&atilde;o &quot;Planejamento de Entregas&quot;<br>';
    //finaliza a tabela
    //verifica se produtividade_global e produtividade_linguagem nao foram utilizadas
    $naoProdutividades = !($estatisticas['chk_produtividade_global'] || $estatisticas['chk_produtividade_linguagem']) ? TRUE : FALSE;
    $html .= $naoExecutada ?
            $html_fases .= '(2) A(s) fase(s) de <strong>' . str_replace(',', ', ', $naoExecutada) . '</strong> apesar de prevista(s) no processo de desenvolvimento, n&atilde;o ser&aacute;(&atilde;o) executada(s) neste projeto<br>' : $html_fases;

    $html .= $naoProdutividades ? $naoExecutada ?
                    '(3) A produtividade m&eacute;dia foi calculada com base na produtividade associada a cada fase</small></td></tr>' :
                    '(2) A produtividade m&eacute;dia foi calculada com base na produtividade associada a cada fase</small></td></tr>' : '</small></td></tr>';

    $html .= '</table>';
} else {
    $html = '';
}
!isset($_GET['p']) ? $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, TRUE, '', TRUE) : print $html;
