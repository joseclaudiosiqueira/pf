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
    //instancia as classes
    $faturamento = new Faturamento();
    $faturamento->setTable('faturamento');
    $referencia = $faturamento->getReferencia(isset($_GET['i']) ? $_GET['i'] : 0);
    //verifica tambem o faturamento
    $contagemFaturamento = new ContagemFaturamento();
    $contagemFaturamento->setTable('contagem_faturamento');
    $lista = $contagemFaturamento->getContagemFaturamento(getIdEmpresa(), isset($_GET['i']) ? $_GET['i'] : 0);
    //variavel inicial
    $html = '';
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    //o select deve inserir o id_empresa na sessao
    // create new PDF document
    //nao coloca background neste relatorio
    $pdf->setIsBackground(false);
    // seta os diretorios para as imagens
    $pdf->setDirLogomarca(DIR_BASE . 'img/');
    $pdf->setDirLogomarcaCliente(DIR_BASE . 'img/');
    // seta os isLogomarca*
    $pdf->setIsLogomarcaCliente(true);
    $pdf->setIsLogomarcaEmpresa(false);
    // seta o sha1 das logomarcas
    $pdf->setLogomarca(NULL);
    $pdf->setLogomarcaCliente('Dimension.png');
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('');
    $pdf->SetTitle('Dimension - Metricas de Software');
    $pdf->SetSubject('');
    $pdf->SetKeywords('Métricas, Software, SNAP, APF, APT, Dimension, Pontos de Função, Pontos de Teste, Projetos');
    // cabecalho e rodape
    $pdf->setCabLinha1('Dimension&reg; - Métricas');
    $pdf->setCabLinha2('Relatório analítico de contagens para faturamento');
    $pdf->setCabLinha3('Referência: ' . $referencia);
    $pdf->setCabAlinhamento('center');
    $pdf->setRodLinha1('Dimension - Métricas');
    $pdf->setIsValidadaInternamente(true);
    // set margins
    //PDF_MARGIN_LEFT e PDF_MARGIN_RIGHT
    $pdf->SetMargins(8, PDF_MARGIN_TOP, 8);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
        require_once(dirname(__FILE__) . '/lang/eng.php');
        $pdf->setLanguageArray($l);
    }
    // ---------------------------------------------------------
    // set default font subsetting mode
    $pdf->setFontSubsetting(true);
    // Set font
    // dejavusans is a UTF-8 Unicode font, if you only need to
    // print standard ASCII chars, you can use core fonts like
    // helvetica or times to reduce file size.
    $pdf->SetFont('courier', '', 8, '', true);
    // Add a page
    // This method has several options, check the source code documentation for more information.
    $pdf->AddPage('L');
    //verifica se existe
    if ($referencia && count($lista) > 0) {
        $html .= '<table width="100%" cellpadding="4" cellspacing="0">'
                . '<tr>'
                . ' <td width="06%" style="border-bottom:1px solid #d0d0d0;"><strong>SEQ.</strong></td>'
                . ' <td width="06%" style="border-bottom:1px solid #d0d0d0;"><strong>Contagem</strong></td>'
                . ' <td width="08%" style="border-bottom:1px solid #d0d0d0;"><strong>Cadastro</strong></td>'
                . ' <td width="15%" style="border-bottom:1px solid #d0d0d0;"><strong>Respons&aacute;vel</strong></td>'
                . ' <td width="15%" style="border-bottom:1px solid #d0d0d0;"><strong>Cliente</strong></td>'
                . ' <td width="15%" style="border-bottom:1px solid #d0d0d0;"><strong>Contrato</strong></td>'
                . ' <td width="15%" style="border-bottom:1px solid #d0d0d0;"><strong>Projeto</strong></td>'
                . ' <td width="13%" style="border-bottom:1px solid #d0d0d0;"><strong>Abrang&ecirc;ncia</strong></td>'
                . ' <td width="07%" style="border-bottom:1px solid #d0d0d0;"><strong>PFa</strong></td>'
                . '</tr>';
        $bgcolor = "#f0f0f0";
        for ($x = 0; $x < count($lista); $x++) {
            $html .= '<tr>'
                    . '<td style="background-color: ' . $bgcolor . ';">#' . str_pad(($x + 1), 7, '0', STR_PAD_LEFT) . '</td>'
                    . '<td style="background-color: ' . $bgcolor . ';">#' . str_pad($lista[$x]['id_contagem'], 7, '0', STR_PAD_LEFT) . '</td>'
                    . '<td style="background-color: ' . $bgcolor . ';">' . str_replace(' ', '<br />', date_format(date_create($lista[$x]['data_cadastro']), 'd/m/Y H:i:s')) . '</td>'
                    . '<td style="background-color: ' . $bgcolor . ';">' . str_replace('@', '<br />@', $lista[$x]['responsavel']) . '</td>'
                    . '<td style="background-color: ' . $bgcolor . ';">' . str_replace('-', '<br />', trim($lista[$x]['cliente'])) . '</td>'
                    . '<td style="background-color: ' . $bgcolor . ';">' . $lista[$x]['contrato'] . '</td>'
                    . '<td style="background-color: ' . $bgcolor . ';">' . $lista[$x]['projeto'] . '</td>'
                    . '<td style="background-color: ' . $bgcolor . ';">' . str_replace('-', '<br />', trim($lista[$x]['abrangencia'])) . '</td>'
                    . '<td style="background-color: ' . $bgcolor . ';">' . number_format($lista[$x]['pfa'], 3, ',', '.') . '</td>'
                    . '</tr>';
            $bgcolor = $bgcolor === "#f0f0f0" ? "#ffffff" : "#f0f0f0";
        }
        $html .= '</table>';
    } else {
        $html .= '<table width="100%" cellpadding="4" cellspacing="0">'
                . '<tr>'
                . ' <td width="06%" style="border-bottom:1px solid #d0d0d0;"><strong>SEQ.</strong></td>'
                . ' <td width="06%" style="border-bottom:1px solid #d0d0d0;"><strong>Contagem</strong></td>'
                . ' <td width="08%" style="border-bottom:1px solid #d0d0d0;"><strong>Cadastro</strong></td>'
                . ' <td width="15%" style="border-bottom:1px solid #d0d0d0;"><strong>Respons&aacute;vel</strong></td>'
                . ' <td width="15%" style="border-bottom:1px solid #d0d0d0;"><strong>Cliente</strong></td>'
                . ' <td width="15%" style="border-bottom:1px solid #d0d0d0;"><strong>Contrato</strong></td>'
                . ' <td width="15%" style="border-bottom:1px solid #d0d0d0;"><strong>Projeto</strong></td>'
                . ' <td width="13%" style="border-bottom:1px solid #d0d0d0;"><strong>Abrang&ecirc;ncia</strong></td>'
                . ' <td width="07%" style="border-bottom:1px solid #d0d0d0;"><strong>PFa</strong></td>'
                . '</tr>'
                . '<tr><td colspan="9"><center><strong>N&atilde;o houve inser&ccedil;&atilde;o de contagens neste per&iacute;odo<br>O faturamento est&aacute; sendo feito pelo valor da mensalidade (manuten&ccedil;&atilde;o b&aacute;sica dos servi&ccedil;os).</strong></center></td></tr></table>';
    }
    // Print text using writeHTMLCell()
    isset($_GET['p']) ? $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true) : NULL;
    //output pdf file
    isset($_GET['p']) ? $pdf->Output('Relatorio.Faturamento.' . date('YmdHis') . '.pdf', 'I') : print($html);
}