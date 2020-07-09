<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
//verifica o tipo e adiciona a pagina
!isset($_GET['p']) ? $pdf->addPage('L') : NULL;

$html = '
        <table width="100%" border="0" cellpadding="5">
            <tr bgcolor="#f0f0f0"><td colspan="6" align="center" style="border-bottom: 1px solid #d0d0d0;"><strong>Hist&oacute;rico de atividades da Contagem</strong></td></tr>
            <tr>
                <td width="05%"><strong>#ID</strong></td>
                <td width="21%"><strong>Processo</strong></td>
                <td width="13%"><strong>In&iacute;cio</strong></td>
                <td width="13%"><strong>Fim</strong></td>
                <td width="24%"><strong>Respons&aacute;vel</strong></td>
                <td width="24%"><strong>Finalizado por</strong></td>
                </tr>';
$idLinha = 1;

foreach ($historico as $linha) {
    $html .= '<tr style="font-size:' . (!isset($_GET['p']) ? '70%' : '100%') . ';">'
            . '<td>#' . str_pad($idLinha, 4, "0", STR_PAD_LEFT) . '</td>'
            . '<td>' . str_replace('<br />', ' - ', (NULL !== $linha['data_fim'] ? $linha['descricao_concluido'] : $linha['descricao_em_andamento'])) . '</td>'            
            . '<td>' . date_format(date_create($linha['data_inicio']), 'd/m/Y H:i:s') . '</td>'
            . '<td>' . (NULL !== $linha['data_fim'] ? date_format(date_create($linha['data_fim']), 'd/m/Y H:i:s') : '') . '</td>'
            . '<td>' . $linha['user_email_executor'] . '</td>'
            . '<td>' . (NULL !== $linha['data_fim'] ? $linha['finalizado_por'] : '') . '</td></tr>';
    $idLinha++;
}
$html .= '</table>';

//escreve a tabela
!isset($_GET['p']) ? $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true) : print $html;

