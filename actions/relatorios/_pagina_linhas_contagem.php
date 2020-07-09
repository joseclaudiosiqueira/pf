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
!isset($_GET['p']) ? $pdf->addPage('L') : NULL;
/*
 * continua com o processamento da pagina
 */
//' . (isset($_GET['cp']) ? 'cellspacing="3"' : '') . '
//  border="' . (isset($_GET['cp']) ? '1' : '0') . '"
$html = ''
        . '<table width="100%" border="0" cellpadding="5">'
        . '     <tr>'
        . '         <td colspan="10" align="center">'
        . '             <strong>Funcionalidades previstas nesta contagem/projeto</strong>'
        . '         </td>'
        . '     </tr>'
        . '     <tr>'
        . '         <td width="0.5%"></td>'
        . '         <td width="030%" style="border-bottom: 1px solid #d0d0d0;">Fun&ccedil;&atilde;o*</td>'
        . '         <td width="005%" style="border-bottom: 1px solid #d0d0d0;" align="center">Tipo</td>'
        . '         <td width="005%" style="border-bottom: 1px solid #d0d0d0;" align="center">Op.</td>'
        . '         <td width="005%" style="border-bottom: 1px solid #d0d0d0;" align="center">TD</td>'
        . '         <td width="005%" style="border-bottom: 1px solid #d0d0d0;" align="center">AR/TR</td>'
        . '         <td width="005%" style="border-bottom: 1px solid #d0d0d0;" align="center">Cplx.</td>'
        . '         <td width="005%" style="border-bottom: 1px solid #d0d0d0;" align="center">PFb</td>'
        . '         <td width="005%" style="border-bottom: 1px solid #d0d0d0;" align="center">PFa</td>'
        . '         <td width="34.5%" style="border-bottom: 1px solid #d0d0d0;">Observa&ccedil;&otilde;es</td>'
        . '     </tr>';
//loop no array com as linhas criadas
for ($x = 0; $x < count($linhas); $x++) {
    $html .= '<tr bgcolor="' . $linhas[$x]['iniColor'] . '">'
            . ' <td style="background-color: ' . ($linhas[$x]['situacao'] == 1 ? 'red' : ($linhas[$x]['situacao'] == 2 ? 'green' : ($linhas[$x]['situacao'] == 3 ? 'blue' : 'white'))) . ';"></td>'
            . ' <td>' . $linhas[$x]['funcao'] . '<br>'
            . ($linhas[$x]['tipo'] === 'ALI' || $linhas[$x]['tipo'] === 'AIE' ?
                    '<small><strong>TDs</strong>: ' . str_replace(',', ', ', $linhas[$x]['descricao_td']) . '</small><br>'
                    . '<small><strong>TRs</strong>: ' . str_replace(',', ', ', $linhas[$x]['descricao_tr']) . '</small><br>' :
                    ($linhas[$x]['tipo'] !== 'OU' ?
                            '<small><strong>TDs</strong>: ' . str_replace(',', ', ', $linhas[$x]['descricao_td']) . '</small><br>'
                            . '<small><strong>ARs</strong>: ' . str_replace(',', ', ', $linhas[$x]['descricao_tr']) . '</small><br>' : ''))
            . '</td>'
            . ' <td align="center">' . $linhas[$x]['tipo'] . '</td>'
            . ' <td align="center">' . $linhas[$x]['operacao'] . '</td>'
            . ' <td align="center">' . $linhas[$x]['td'] . '</td>'
            . ' <td align="center">' . $linhas[$x]['tr'] . '</td>'
            . ' <td align="center">' . $linhas[$x]['complexidade'] . '</td>'
            . ' <td align="right">' . $linhas[$x]['pfb'] . '</td>'
            . ' <td align="right">' . $linhas[$x]['pfa'] . '</td>'
            . ' <td>' . (NULL === $linhas[$x]['obs_funcao'] ? '' : $linhas[$x]['obs_funcao'] . '<br />')
            . $linhas[$x]['f_sigla'] . '<br />' . $linhas[$x]['fonte']
            . ($linhas[$x]['is_mudanca'] ?
                    '<br />Retrabalho: '
                    . $linhas[$x]['fase_mudanca'] . ' - '
                    . $linhas[$x]['percentual_fase'] . '%' : '')
            . ($linhas[$x]['fd'] ? '&nbsp;&nbsp;FD:' . number_format($linhas[$x]['fd'], 2, ",", ".") : '') . '</td>'
            //Metodo -> nao eh necessario
            //. ' <td align="center">' . $linhas[$x]['m_sigla'] . '</td>'
            . '</tr>';
}

$html .= ''
        . '<tr>'
        . ' <td colspan="10" style="border-top: 1px solid #d0d0d0;">'
        . '<small>'
        . '(*) Abaixo do nome de cada fun&ccedil;&atilde;o est&atilde;o as descri&ccedil;&otilde;es dos ARs/TRs e TDs<br />'
        . '(Mt.) M&eacute;todo: N - Nesma, F - FP-Lite, D - Detalhada | FI - Fator de Impacto | FD - Fator de Documenta&ccedil;&atilde;o<br />'
        . '(Op.) Opera&ccedil;&atilde;o: I - Inclus&atilde;o, E - Exclus&atilde;o, A - Altera&ccedil;&atilde;o e T - Testes<br />'
        . '(QTD) Para Outras funcionalidades com fator fixo, o PFa &eacute; contado multiplicando-se a quantidade pelo Fator de Impacto<br />'
        . '<strong>ATEN&Ccedil;&Atilde;O</strong>: nos m&eacute;todos NESMA e FP-Lite o Dimension permite inserir as descri&ccedil;&otilde;es de TD/TR/AR, entretanto, para efeitos de '
        . 'c&aacute;lculos n&atilde;o acumula nas quantidades, a n&atilde;o ser que voc&ecirc; utilize o m&eacute;todo Detalhado.</small>'
        . '</td></tr>';
//encerra tabela e escreve a pagina
$html .= '</table>';

!isset($_GET['p']) ? $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true) : print $html;