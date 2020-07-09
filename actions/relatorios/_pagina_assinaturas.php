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
$pdf->addPage('P');

$html = '   <table width="100%" border="0" cellpadding="5">'
        . '     <tr bgcolor="#d0d0d0"><td colspan="2" align="center" style="border-bottom: 1px solid #d0d0d0;"><strong>Carimbos e assinaturas dos respons&aacute;veis</strong></td></tr>'
        . '     <tr>' .
        ($assinaturas['assinatura_nome_1'] && $assinaturas['assinatura_cargo_1'] ?
                '         <td width="50%">'
                . '             <br><br><br><br><br><br><br><br><br>'
                . '             <table width="100%">'
                . '                 <tr><td style="border-top:1px solid black;">' . $assinaturas['assinatura_nome_1'] . '</td></tr>'
                . '                 <tr><td>' . $assinaturas['assinatura_cargo_1'] . '</td></tr>'
                . '             </table>'
                . '         </td>' : '<td></td>') .
        ($assinaturas['assinatura_nome_2'] && $assinaturas['assinatura_cargo_2'] ?
                '         <td width="50%">'
                . '             <br><br><br><br><br><br><br><br><br>'
                . '             <table width="100%">'
                . '                 <tr><td style="border-top:1px solid black;">' . $assinaturas['assinatura_nome_2'] . '</td></tr>'
                . '                 <tr><td>' . $assinaturas['assinatura_cargo_2'] . '</td></tr>'
                . '             </table>'
                . '         </td>' : '<td></td>')
        . '     </tr>'
        . '     <tr>' .
        ($assinaturas['assinatura_nome_3'] && $assinaturas['assinatura_cargo_3'] ?
                '         <td width="50%">'
                . '             <br><br><br><br><br><br><br><br><br>'
                . '             <table width="100%">'
                . '                 <tr><td style="border-top:1px solid black;">' . $assinaturas['assinatura_nome_3'] . '</td></tr>'
                . '                 <tr><td>' . $assinaturas['assinatura_cargo_3'] . '</td></tr>'
                . '             </table>'
                . '         </td>' : '<td></td>') .
        ($assinaturas['assinatura_nome_4'] && $assinaturas['assinatura_cargo_4'] ?
                '         <td width="50%">'
                . '             <br><br><br><br><br><br><br><br><br>'
                . '             <table width="100%">'
                . '                 <tr><td style="border-top:1px solid black;">' . $assinaturas['assinatura_nome_4'] . '</td></tr>'
                . '                 <tr><td>' . $assinaturas['assinatura_cargo_4'] . '</td></tr>'
                . '             </table>'
                . '         </td>' : '<td></td>')
        . '     </tr>'
        . '     <tr>' .
        ($assinaturas['assinatura_nome_5'] && $assinaturas['assinatura_cargo_5'] ?
                '         <td width="50%">'
                . '             <br><br><br><br><br><br><br><br><br>'
                . '             <table width="100%">'
                . '                 <tr><td style="border-top:1px solid black;">' . $assinaturas['assinatura_nome_5'] . '</td></tr>'
                . '                 <tr><td>' . $assinaturas['assinatura_cargo_5'] . '</td></tr>'
                . '             </table>'
                . '         </td>' : '<td></td>') .
        ($assinaturas['assinatura_nome_6'] && $assinaturas['assinatura_cargo_6'] ?
                '         <td width="50%">'
                . '             <br><br><br><br><br><br><br><br><br>'
                . '             <table width="100%">'
                . '                 <tr><td style="border-top:1px solid black;">' . $assinaturas['assinatura_nome_6'] . '</td></tr>'
                . '                 <tr><td>' . $assinaturas['assinatura_cargo_6'] . '</td></tr>'
                . '             </table>'
                . '         </td>' : '<td></td>')
        . '     </tr>'
        . '     <tr>'
        . '         <td>'
        . '             <br><br><br><br><br><br><br><br><br>'
        . '             <table width="100%">'
        . '                 <tr><td style="border-top:1px solid black;">' . $usuario['user_complete_name'] . '</td></tr>'
        . '                 <tr><td>Respons&aacute;vel pela contagem</td></tr>'
        . '             </table>'        
        . '         </td>'
        . '         <td></td>'
        . '     </tr>'
        . '</table>';

//escreve a tabela
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);



