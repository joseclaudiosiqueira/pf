<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * PLANILHA COM O PRIMEIRO SUMARIO
 */
$objPHPExcel->createSheet(4);
$objPHPExcel->setActiveSheetIndex(4);

/*
 * atribui a visualizacao da area de impressao
 */
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea('A1:M70');
/*
 * visualizacao de impressao
 */
$objPHPExcel->getActiveSheet()->getSheetView()->setView(PHPExcel_Worksheet_SheetView::SHEETVIEW_PAGE_BREAK_PREVIEW);
/*
 * fit to one page
 */
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(1);
/*
 * set a altura para auto na planilha como um todo
 */
$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
/*
 * array com as colunas
 */
$arrayLarguraColunas = [3.43, 32.86, 36.71, 7.29, 10.14, 9.57, 12.57, 12.57, 12.86, 7.86, 2.43, 13.86, 2.00, 15.00];
$arrayColunas = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M'];
for ($x = 0; $x < count($arrayColunas); $x++) {
    $objPHPExcel->getActiveSheet()->getColumnDimension("$arrayColunas[$x]")->setAutoSize(false)->setWidth($arrayLarguraColunas[$x]);
}
/*
 * seta a fonte da planilha como um todo
 */
$objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Franklin Gothic Medium')->setSize(9);
/*
 * inserindo uma imagems padrao da Fatto
 */
$logomarca = DIR_BASE . 'img/logo_fatto.png';
$img = imagecreatefrompng($logomarca);
/*
 * cria um objeto de imagem na planilha
 */
$objImg = new PHPExcel_Worksheet_MemoryDrawing();
/*
 * insere os parametros da imagem
 */
$objImg->setImageResource($img)
        ->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG)
        ->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT)
        ->setHeight(44)
        ->setWidth(123)
        ->setCoordinates('A1')
        ->setWorksheet($objPHPExcel->getActiveSheet());
/*
 * renomeia a primeira planilha para CONTAGEM
 */
$objPHPExcel->getActiveSheet()->setTitle('Sumário 2');
/*
 * freeze na primeira linha
 */
$objPHPExcel->getActiveSheet()->freezePane('A4');
/*
 * retira as linhas de grade
 */
$objPHPExcel->getActiveSheet()->setShowGridlines(false);
/*
 * formatacao dos numeros com duas casas decimais, percentual, cores e alinhamento ao centro
 */
$objPHPExcel->getActiveSheet()->getStyle('E10:E44')->applyFromArray($colorStyleCenter);
$objPHPExcel->getActiveSheet()->getStyle('F10:F44')->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('F10:F44')->applyFromArray($colorStyleCenter);
$objPHPExcel->getActiveSheet()->getStyle('G10:G44')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_0);
$objPHPExcel->getActiveSheet()->getStyle('G10:G44')->applyFromArray($colorStyleCenter);
$objPHPExcel->getActiveSheet()->getStyle('H10:H44')->applyFromArray($colorStyleCenter);
$objPHPExcel->getActiveSheet()->getStyle('I10:I44')->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('I10:I44')->applyFromArray($colorStyleCenter);
$objPHPExcel->getActiveSheet()->getStyle('J10:J44')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
$objPHPExcel->getActiveSheet()->getStyle('J10:J44')->applyFromArray($colorStyleCenter);
$objPHPExcel->getActiveSheet()->getStyle('E47:E69')->applyFromArray($colorStyleCenter);
$objPHPExcel->getActiveSheet()->getStyle('H47:H69')->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('H47:H69')->applyFromArray($colorStyleCenter);
$objPHPExcel->getActiveSheet()->getStyle('I47:I69')->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('I47:I69')->applyFromArray($colorStyleCenter);
$objPHPExcel->getActiveSheet()->getStyle('J47:J69')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
$objPHPExcel->getActiveSheet()->getStyle('J47:J69')->applyFromArray($colorStyleCenter);
/*
 * preenchimento das formulas das colunas [J] e [K]
 */
for ($x = 10; $x <= 44; $x++) {
    $objPHPExcel->getActiveSheet()->getStyle("B$x:D$x")
            ->applyFromArray($fontStyleBlueOnly)
            ->applyFromArray($borderStyle);
    $objPHPExcel->getActiveSheet()->getStyle("E$x:J$x")
            ->applyFromArray($borderStyle);
    $objPHPExcel->getActiveSheet()->getStyle("D$x")
            ->applyFromArray($colorStyleCenterWhite);
}
/*
 * preenchimento das formulas das colunas [J] e [K] - segunda parte
 */
for ($x = 47; $x <= 69; $x++) {
    $objPHPExcel->getActiveSheet()->mergeCells("B$x:C$x")->getStyle("B$x:D$x")
            ->applyFromArray($fontStyleBlueOnly)
            ->applyFromArray($borderStyle);
    $objPHPExcel->getActiveSheet()->getStyle("E$x:E$x")
            ->applyFromArray($borderStyle);
    $objPHPExcel->getActiveSheet()->getStyle("H$x:J$x")
            ->applyFromArray($borderStyle);
    $objPHPExcel->getActiveSheet()->getStyle("D$x")
            ->applyFromArray($colorStyleCenterWhite);
}
/*
 * identificacao da contagem
 */
$objPHPExcel->getActiveSheet()->mergeCells('A1:M3')->setCellValue('A1', 'Sumário por Deflatores e Itens não mensuráveis');
$objPHPExcel->getActiveSheet()->getStyle('A1:L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:L3')->getFont()->setBold(true)->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle('A1:L3')->applyFromArray($borderStyle);
/*
 * cabecalho da planilha
 */
$objPHPExcel->getActiveSheet()->mergeCells('A4:E4')->setCellValue('A4', '=Contagem!A5&" : "&Contagem!F5')->getStyle('A4:E4')->applyFromArray($colorStyleBorder);
$objPHPExcel->getActiveSheet()->mergeCells('A5:E5')->setCellValue('A5', '=Contagem!A9&" : "&Contagem!F9')->getStyle('A5:E5')->applyFromArray($colorStyleBorder);
$objPHPExcel->getActiveSheet()->mergeCells('A6:E6')->setCellValue('A6', '=Contagem!A4&" : "&Contagem!F4')->getStyle('A6:E6')->applyFromArray($colorStyleBorder);
/*
 * segunda coluna do cabecalho
 */
$objPHPExcel->getActiveSheet()->mergeCells('F4:M4')->setCellValue('F4', '=Contagem!A8&" : "&Contagem!F8')->getStyle('F4:M4')->applyFromArray($colorStyleBorder);
$objPHPExcel->getActiveSheet()->mergeCells('F5:M5')->setCellValue('F5', '=Contagem!A10&" : "&Contagem!F10')->getStyle('F5:M5')->applyFromArray($colorStyleBorder);
$objPHPExcel->getActiveSheet()->mergeCells('F6:M6')->setCellValue('F6', '="Tipo de Contagem : "&Contagem!F6')->getStyle('F6:M6')->applyFromArray($colorStyleBorder);
/*
 * tabela com os deflatores - vir da lista dos itens de roteiro
 */
$objPHPExcel->getActiveSheet()->setCellValue('L10', 'PF Local da FS')->getStyle('L10')->applyFromArray($borderStyle);
$objPHPExcel->getActiveSheet()->getStyle('L10')->applyFromArray($colorStyleCenterWhite);
$objPHPExcel->getActiveSheet()->setCellValue('L11', '=Contagem!Q6')->getStyle('L11')->applyFromArray($fontStyleYellowBorderBold);
$objPHPExcel->getActiveSheet()->getStyle('L11')->getNumberFormat()->setFormatCode('#,##0.00');

$objPHPExcel->getActiveSheet()->setCellValue('L13', 'Total IFPUG')->getStyle('L13')->applyFromArray($borderStyle);
$objPHPExcel->getActiveSheet()->getStyle('L13')->applyFromArray($colorStyleCenterWhite);
$objPHPExcel->getActiveSheet()->setCellValue('L14', '=Contagem!Q4')->getStyle('L14')->applyFromArray($fontStyleYellowBorderBold);
$objPHPExcel->getActiveSheet()->getStyle('L14')->getNumberFormat()->setFormatCode('#,##0.00');
/*
 * cabecalhos das colunas
 */
$objPHPExcel->getActiveSheet()->mergeCells("B9:D9")->setCellValue("B9", "Deflatores aplicados a Itens Funcionais")->getStyle("B9:D9")->applyFromArray($fontBold1)->applyFromArray($colorStyleCenterWhite);
$objPHPExcel->getActiveSheet()->getStyle("B9:J9")->applyFromArray($colorStyleCenterWhite);

$objPHPExcel->getActiveSheet()->setCellValue("E9", "Quantidade")->getStyle("E9")->applyFromArray($borderStyle);
$objPHPExcel->getActiveSheet()->setCellValue("F9", "PF IFPUG")->getStyle("F9")->applyFromArray($borderStyle);
$objPHPExcel->getActiveSheet()->setCellValue("G9", "Deflator")->getStyle("G9")->applyFromArray($borderStyle);
$objPHPExcel->getActiveSheet()->setCellValue("H9", "Contrib. Fixa")->getStyle("H9")->applyFromArray($borderStyle);
$objPHPExcel->getActiveSheet()->setCellValue("I9", "PF Local da FS")->getStyle("I9")->applyFromArray($borderStyle);
$objPHPExcel->getActiveSheet()->setCellValue("J9", "% LOCAL")->getStyle("J9")->applyFromArray($borderStyle);

$objPHPExcel->getActiveSheet()->mergeCells("B46:D46")->setCellValue("B46", "Itens não Funcionais (Tipo de Função)")->getStyle("B46:D46")->applyFromArray($fontBold1)->applyFromArray($colorStyleCenterWhite);
$objPHPExcel->getActiveSheet()->mergeCells("F46:G46")->getStyle("F46:G46")->applyFromArray($borderStyle);//excecao
$objPHPExcel->getActiveSheet()->getStyle("B46:J46")->applyFromArray($colorStyleCenterWhite);

$objPHPExcel->getActiveSheet()->setCellValue("E46", "Quantidade")->getStyle("E46")->applyFromArray($borderStyle);
$objPHPExcel->getActiveSheet()->setCellValue("H46", "Contrib. Fixa")->getStyle("H46")->applyFromArray($borderStyle);
$objPHPExcel->getActiveSheet()->setCellValue("I46", "PF Local da FS")->getStyle("I46")->applyFromArray($borderStyle);
$objPHPExcel->getActiveSheet()->setCellValue("J46", "% LOCAL")->getStyle("J46")->applyFromArray($borderStyle);
//merge das celulas [B] e [C]
for ($z = 10; $z <= 44; $z++) {
    $objPHPExcel->getActiveSheet()->mergeCells("B$z:C$z");
}
$incremento = 4;
for ($x = 10; $x <= 44; $x++) {
    $objPHPExcel->getActiveSheet()->setCellValue("B$x", "=\"\"&Deflatores!B$incremento");
    $objPHPExcel->getActiveSheet()->setCellValue("D$x", "=\"\"&Deflatores!G$incremento");
    $objPHPExcel->getActiveSheet()->setCellValue("E$x", "=IF(D$x=\"\",\"\",COUNTIF(Funções!C$8:C$607,D$x))");
    $objPHPExcel->getActiveSheet()->setCellValue("F$x", "=SUMIF(Funções!\$C$8:\$C$607,Deflatores!G$incremento,Funções!\$H$8:\$H$607)");
    $objPHPExcel->getActiveSheet()->setCellValue("G$x", "=IF(ISBLANK(Deflatores!H$incremento),\"\",Deflatores!H$incremento)");
    $objPHPExcel->getActiveSheet()->setCellValue("H$x", "=IF(ISBLANK(Deflatores!I$incremento),\"\",Deflatores!I$incremento)");
    $objPHPExcel->getActiveSheet()->setCellValue("I$x", "=IF(F$x=0,Deflatores!K$incremento,F$x*G$x)");
    $objPHPExcel->getActiveSheet()->setCellValue("J$x", '=IF($L$11<>0,I' . $x . '/$L$11,"")');
    $incremento++;
}

$incremento = 42;
for ($x = 47; $x <= 69; $x++) {
    $objPHPExcel->getActiveSheet()->setCellValue("B$x", "=\"\"&Deflatores!B$incremento");
    $objPHPExcel->getActiveSheet()->setCellValue("D$x", "=\"\"&Deflatores!G$incremento");
    $objPHPExcel->getActiveSheet()->setCellValue("E$x", "=IF(ISNUMBER(Deflatores!J$incremento),Deflatores!J$incremento,\"-\")");
    $objPHPExcel->getActiveSheet()->setCellValue("H$x", "=IF(ISBLANK(Deflatores!H$incremento),\"\",Deflatores!H$incremento)");
    $objPHPExcel->getActiveSheet()->setCellValue("I$x", "=IF(ISNUMBER(H$x),E$x*H$x,\"\")");
    $objPHPExcel->getActiveSheet()->setCellValue("J$x", "=IF(ISNUMBER(I$x),IF(\$L\$11<>0,I$x/\$L\$11,\"\"),\"\")");
    $incremento++;
}


