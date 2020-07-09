<?php

isset($maf) ? require_once($_SERVER['DOCUMENT_ROOT'] . (substr($_SERVER['DOCUMENT_ROOT'], -1) === '/' ? '' : '/') . 'pf/conf/conf.php') : NULL;
/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * tranforma a variavel MesAnoFaturamento em uma variavel local pois pode vir de varias chamadas
 */
$localMesAnoFaturamento = isset($maf) ? $maf : 0;
/*
 * verificacao do status do login
 */
if ($login->isUserLoggedIn() && verificaSessao() && $localMesAnoFaturamento) {
    //instancia as classes
    $faturamentoEmpresa = new ContagemFaturamentoEmpresa();
    $empresa = new Empresa();
    $fornecedor = new Fornecedor();
    $isFornecedor = isFornecedor();
    $idEmpresaFornecedor = $isFornecedor ? getIdFornecedor() : getIdEmpresa();
    $idEmpresa = getIdEmpresa();
    $idFornecedor = getIdFornecedor();
    $lista = $faturamentoEmpresa->getContagemFaturamentoEmpresa($localMesAnoFaturamento, $idEmpresa, $idFornecedor);
    //verifica tambem o faturamento
    //variavel inicial
    $html = '';
    $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    //padrao
    $pdf->SetFont('times', '', 8, '', true);
    //o select deve inserir o id_empresa na sessao
    // create new PDF document
    //nao coloca background neste relatorio
    $pdf->setIsBackground(false);
    // seta os diretorios para as imagens
    $pdf->setDirLogomarca(DIR_BASE . 'img/');
    $pdf->setDirLogomarcaCliente(DIR_BASE . 'img/');
    // seta os isLogomarca*
    $pdf->setIsLogomarcaCliente(false);
    $pdf->setIsLogomarcaEmpresa(false);
    // seta o sha1 das logomarcas
    $pdf->setLogomarca(NULL);
    $pdf->setLogomarcaCliente(NULL);
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('');
    //pega a siglaNome antes para nao fazer duas consultas
    $siglaNome = $isFornecedor ? $fornecedor->getSiglaNome($idEmpresaFornecedor) : $empresa->getSiglaNome($idEmpresaFornecedor);
    $pdf->SetTitle($siglaNome);
    $pdf->SetSubject('');
    $pdf->SetKeywords('Métricas, Software, SNAP, APF, APT, Dimension, Pontos de Função, Pontos de Teste, Projetos');
    // cabecalho e rodape
    $pdf->setCabLinha1($siglaNome);
    $pdf->setCabLinha2('Relatório analítico de contagens para faturamento');
    $pdf->setCabLinha3('Referência: ' . $localMesAnoFaturamento);
    $pdf->setCabAlinhamento('center');
    $pdf->setRodLinha1($isFornecedor ? $fornecedor->getSigla($idEmpresaFornecedor) : $empresa->getSigla($idEmpresaFornecedor));
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
    // Add a page
    // This method has several options, check the source code documentation for more information.
    $pdf->AddPage('L');
    //coloca o cabecalho antes
    $html .= '<table width="100%" cellpadding="4" cellspacing="0">'
            . '<tr>'
            . ' <td width="06%" style="border-bottom:1px solid #d0d0d0;"><strong>Seq.</strong></td>'
            . ' <td width="06%" style="border-bottom:1px solid #d0d0d0;"><strong>#ID</strong></td>'
            . ' <td width="07%" style="border-bottom:1px solid #d0d0d0;"><strong>Cadastro</strong></td>'
            . ' <td width="10%" style="border-bottom:1px solid #d0d0d0;"><strong>Respons&aacute;vel</strong></td>'
            . ' <td width="10%" style="border-bottom:1px solid #d0d0d0;"><strong>Cliente</strong></td>'
            . ' <td width="10%" style="border-bottom:1px solid #d0d0d0;"><strong>Contrato</strong></td>'
            . ' <td width="10%" style="border-bottom:1px solid #d0d0d0;"><strong>Projeto</strong></td>'
            . ' <td width="09%" style="border-bottom:1px solid #d0d0d0;"><strong>O.S./Demanda</strong></td>'
            . ' <td width="07%" style="border-bottom:1px solid #d0d0d0;"><strong>Abrang&ecirc;ncia</strong></td>'
            . ' <td width="05%" style="border-bottom:1px solid #d0d0d0;"><strong>PFb</strong></td>'
            . ' <td width="05%" style="border-bottom:1px solid #d0d0d0;"><strong>PFa</strong></td>'
            . ' <td width="07%" style="border-bottom:1px solid #d0d0d0;"><strong>PF Contrato</strong></td>'
            . ' <td width="07%" style="border-bottom:1px solid #d0d0d0;"><strong>Faturamento</strong></td>'
            . '<td colspan="5"></td>'
            . '</tr>';
    //verifica se existe
    if (count($lista) > 0) {
        $bgcolor = "#f0f0f0";
        for ($x = 0; $x < count($lista); $x++) {
            $html .= '<tr>'
                    . '<td style="background-color: ' . $bgcolor . ';">#' . str_pad(($x + 1), 7, '0', STR_PAD_LEFT) . '</td>'
                    . '<td style="background-color: ' . $bgcolor . ';">#' . str_pad($lista[$x]['id_contagem'], 7, '0', STR_PAD_LEFT) . '</td>'
                    . '<td style="background-color: ' . $bgcolor . ';">' . str_replace(' ', '<br />', date_format(date_create($lista[$x]['data_cadastro_contagem']), 'd/m/Y H:i:s')) . '</td>'
                    . '<td style="background-color: ' . $bgcolor . ';">' . str_replace('@', '<br />@', $lista[$x]['responsavel_contagem']) . '</td>'
                    . '<td style="background-color: ' . $bgcolor . ';">' . str_replace('-', '<br />', trim($lista[$x]['cliente'])) . '</td>'
                    . '<td style="background-color: ' . $bgcolor . ';">' . $lista[$x]['contrato'] . '</td>'
                    . '<td style="background-color: ' . $bgcolor . ';">' . $lista[$x]['projeto'] . '</td>'
                    . '<td style="background-color: ' . $bgcolor . ';">' . $lista[$x]['ordem_servico'] . '</td>'
                    . '<td style="background-color: ' . $bgcolor . ';">' . $lista[$x]['abrangencia'] . '</td>'
                    . '<td style="background-color: ' . $bgcolor . ';">' . number_format($lista[$x]['pfb'], 3, ',', '.') . '</td>'
                    . '<td style="background-color: ' . $bgcolor . ';">' . number_format($lista[$x]['pfa'], 3, ',', '.') . '</td>'
                    . '<td style="background-color: ' . $bgcolor . ';">R$ ' . number_format($lista[$x]['valor_pf_contrato'], 2, ',', '.') . '</td>'
                    . '<td style="background-color: ' . $bgcolor . ';">R$' . number_format($lista[$x]['valor_faturamento'], 2, ',', '.') . '</td>'
                    . '</tr>';
            $bgcolor = $bgcolor === "#f0f0f0" ? "#ffffff" : "#f0f0f0";
        }
        $html .= '</table>';
    } else {
        $html .= '<tr><td colspan="13"><center><strong>N&atilde;o houve inser&ccedil;&atilde;o de contagens neste per&iacute;odo.</strong></center></td></tr></table>';
    }
    // Print text using writeHTMLCell()
    isset($_GET['p']) || isset($_POST['p']) || $maf ? $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true) : NULL;
    //output pdf file
    isset($_GET['p']) || isset($_POST['p']) || $maf ?
                    $pdf->Output(
                            (isset($maf) ?
                                    DIR_TEMP . '/' . $idUnicoArquivo . '-faturamento-' . $localMesAnoFaturamento . '.pdf' :
                                    'Relatorio.Faturamento.' . date('YmdHis') . '.pdf'), (isset($maf) ? 'F' : 'I')) : print($html);
    return true;
}