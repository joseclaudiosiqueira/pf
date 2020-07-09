<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * nao exibe caso esteja comparando
 */
if (!(isset($_GET['cp']))) {
    !isset($_GET['p']) ? $pdf->addPage('L') : NULL;
    //verifica quais fases estao selecionadas para estabelecer o PFa por entrega
    $percentualTotalFases = 0;
    $percentualTotalFases += $estatisticas['chk_eng'] ? $estatisticas['pct_eng'] / 100 : 0;
    $percentualTotalFases += $estatisticas['chk_des'] ? $estatisticas['pct_des'] / 100 : 0;
    $percentualTotalFases += $estatisticas['chk_imp'] ? $estatisticas['pct_imp'] / 100 : 0;
    $percentualTotalFases += $estatisticas['chk_tes'] ? $estatisticas['pct_tes'] / 100 : 0;
    $percentualTotalFases += $estatisticas['chk_hom'] ? $estatisticas['pct_hom'] / 100 : 0;
    $percentualTotalFases += $estatisticas['chk_impl'] ? $estatisticas['pct_impl'] / 100 : 0;
    //verifica a produtividade media
    $produtividade = ($estatisticas['chk_produtividade_global'] ?
                    number_format($estatisticas['produtividade_global'], 2) :
                    ($estatisticas['chk_produtividade_linguagem'] ? number_format($estatisticas['produtividade_' . $escala], 2) : number_format($produtividade_media_calculada, 2)));
    //escreve o cabecalho da tabela
    $html = '   <table width="100%" border="0" cellpadding="5">'
            . '     <tr bgcolor="#d0d0d0"><td colspan="9" align="center" style="border-bottom: 1px solid #d0d0d0;"><strong>Planejamento de entregas</strong></td></tr>'
            . '     <tr bgcolor="#f0f0f0">'
            . '         <td style="border-bottom: 1px solid #d0d0d0;" width="06%">Seq.</td>'
            . '         <td style="border-bottom: 1px solid #d0d0d0;" width="49%">Funcionalidade</td>'
            . '         <td style="border-bottom: 1px solid #d0d0d0;" width="09%" align="right">PFa</td>'
            . '         <td style="border-bottom: 1px solid #d0d0d0;" width="09%" align="right">%Total</td>'
            . '         <td style="border-bottom: 1px solid #d0d0d0;" width="09%" align="right">Esfor&ccedil;o(h)</td>'
            . '         <td style="border-bottom: 1px solid #d0d0d0;" width="09%" align="right">Dura&ccedil;&atilde;o(d)</td>'
            . '         <td style="border-bottom: 1px solid #d0d0d0;" width="09%" align="right">Desembolso<sup>1</sup></td>'
            . '     </tr>';
    //loop para escrever as linhas das entregas
    for ($x = 0; $x < count($entregas); $x++) {
        //outras variaveis
        $hlt = $estatisticas['hlt'];
        //variaveis iniciais para os calculos
        $funcao = $entregas['ENT-' . ($x + 1)]['ENTREGA-' . ($x + 1)];
        $esforcoOriginal = $entregas['ENT-' . ($x + 1)]['ENTREGA-PFA-' . ($x + 1)] * $produtividade;
        //total de pfa da contagem para a entrega PFA-1
        $pfaEntrega = ($entregas['ENT-' . ($x + 1)]['ENTREGA-PFA-' . ($x + 1)] *
                $estatisticas['aumento_esforco'] *
                ($estatisticas['is_ft'] ? $estatisticas['ft'] : 1)) *
                $percentualTotalFases;
        $esforcoHoras = $pfaEntrega * $produtividade;
        //reducao no cronograma
        $duracaoDias = ($esforcoOriginal / $hlt) * $fator_reducao_cronograma;
        //percentual sobre o total da contagem
        $percentualTotal = $estatisticas['tamanho_pfa'] > 0 ? ($pfaEntrega / $estatisticas['tamanho_pfa']) * 100 : 0;
        $desembolso = $percentualTotal / 100 * ($estatisticas['custo_total'] > 0 ? $estatisticas['custo_total'] : 1);
        //escreve a linha de entregas
        $html .= '<tr>'
                . ' <td>#' . str_pad(($x + 1), 5, "0", STR_PAD_LEFT) . '</td>'
                . ' <td>' . str_replace(",", ", ", substr($funcao, 0, strlen($funcao) - 1)) . '</td>'
                . ' <td align="right">' . number_format($pfaEntrega, 4, ",", ".") . '</td>'
                . ' <td align="right">' . number_format($percentualTotal, 4, ",", ".") . '%</td>'
                . ' <td align="right">' . number_format($esforcoHoras, 4, ",", ".") . ' hora(s)</td>'
                . ' <td align="right">' . number_format($duracaoDias, 4, ",", ".") . ' dia(s)</td>'
                . ' <td align="right">R$ ' . (isPermitido('visualizar_valor_pf') ? number_format($desembolso, 2, ",", ".") : '-') . '</td>'
                . '</tr>';
    }
    $html .= '<tr><td colspan="9"></td></tr>'
            . '<tr>'
            . ' <td colspan="9" style="border-top: 1px solid #d0d0d0;">'
            . '<small>'
            . '<sup>1</sup> As horas de Perfil Consultor e Perfil Analista est&atilde;o distribu&iacute;das entre as entregas do projeto. Desta forma voc&ecirc; pode planejar o desembolso pelo total da entrega;<br />'
            . '(*) Os c&aacute;lculos foram baseados na Produtividade M&eacute;dia de '
            . number_format($produtividade, 2, ",", ".") . 'h/PF' . '(<i>'
            . clsTexto::valorPorExtenso(number_format($produtividade, 2, ",", ".")) . '</i>) horas por Ponto de Fun&ccedil;&atilde;o;<br />'
            . '(**) Horas L&iacute;quidas Trabalhadas (HLT) => '
            . number_format($hlt, 2, ",", ".") . 'h (<i>'
            . clsTexto::valorPorExtenso(number_format($hlt, 2, ",", ".")) . '</i>) horas por dia de trabalho.'
            . (!isPermitido('visualizar_valor_pf') ? '<br>(***) Seu perfil n&atilde;o permite visualizar os valores em Reais para faturamento' : '') . '</small></td></tr>';

    $html .= '</table>';
    //escreve a tabela
    !isset($_GET['p']) ? $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true) : print $html;
}