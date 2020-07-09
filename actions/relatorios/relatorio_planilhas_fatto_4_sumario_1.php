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
$objPHPExcel->createSheet(3);
$objPHPExcel->setActiveSheetIndex(3);

/*
 * atribui a visualizacao da area de impressao
 */
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea('A1:L52');
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
$arrayLarguraColunas = [3.14, 8.57, 11.86, 1.67, 8.00, 6.14, 13.71, 8.71, 6.14, 11.86, 8.71, 6.86];
$arrayColunas = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
for ($x = 0; $x < count($arrayColunas); $x++) {
    $objPHPExcel->getActiveSheet()->getColumnDimension("$arrayColunas[$x]")->setAutoSize(false)->setWidth($arrayLarguraColunas[$x]);
}
/*
 * height da Row para esta aba
 */
$rowSumario = [15, 16, 22, 23, 29, 30, 36, 37, 43, 44];
for ($x = 0; $x < count($rowSumario); $x++) {
    $objPHPExcel->getActiveSheet()->getRowDimension($rowSumario[$x])->setRowHeight(6);
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
$objPHPExcel->getActiveSheet()->setTitle('Sumário 1');
/*
 * freeze na primeira linha
 */
$objPHPExcel->getActiveSheet()->freezePane('A4');
/*
 * retira as linhas de grade
 */
$objPHPExcel->getActiveSheet()->setShowGridlines(false);
/*
 * identificacao da contagem
 */
$objPHPExcel->getActiveSheet()->mergeCells('A1:L3')->setCellValue('A1', 'Sumário da Contagem');
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
$objPHPExcel->getActiveSheet()->mergeCells('F4:L4')->setCellValue('F4', '=Contagem!A8&" : "&Contagem!F8')->getStyle('F4:L4')->applyFromArray($colorStyleBorder);
$objPHPExcel->getActiveSheet()->mergeCells('F5:L5')->setCellValue('F5', '=Contagem!A10&" : "&Contagem!F10')->getStyle('F5:L5')->applyFromArray($colorStyleBorder);
$objPHPExcel->getActiveSheet()->mergeCells('F6:L6')->setCellValue('F6', '="Tipo de Contagem : "&Contagem!F6')->getStyle('F6:L6')->applyFromArray($colorStyleBorder);
/*
 * quebra automatica de linha do cabecalho
 */
$objPHPExcel->getActiveSheet()->getStyle('A7:L8')->getAlignment()->setWrapText(true);
/*
 * linha de cabecalho da planilha de sumario (1)
 */
$objPHPExcel->getActiveSheet()->mergeCells('A7:B8')->setCellValue('A7', 'Tipo de Função')->getStyle('A7:B8')->applyFromArray($fontStyleWhiteNoBorder)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->mergeCells('C7:F8')->setCellValue('C7', 'Complexidade Funcional')->getStyle('C7:F8')->applyFromArray($fontStyleWhiteNoBorder)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->mergeCells('G7:G8')->setCellValue('G7', 'Total PF IFPUG por Complexidade')->getStyle('G7:G8')->applyFromArray($fontStyleWhiteNoBorder)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->mergeCells('H7:H8')->setCellValue('H7', '%')->getStyle('H7:H8')->applyFromArray($fontStyleWhiteNoBorder)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('I7')->applyFromArray($fontStyleWhiteNoBorder);
$objPHPExcel->getActiveSheet()->getStyle('I8')->applyFromArray($fontStyleWhiteNoBorder);
$objPHPExcel->getActiveSheet()->mergeCells('J7:K8')->setCellValue('J7', 'Total PF Local FS por tipo de manutenção básica')->getStyle('J7:K8')->applyFromArray($fontStyleWhiteNoBorder)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->mergeCells('L7:L8')->setCellValue('L7', '%')->getStyle('L7:L8')->applyFromArray($fontStyleWhiteNoBorder)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
/*
 * corpo do sumario Entradas Externas
 */
$objPHPExcel->getActiveSheet()->setCellValue('B10', 'EE');
$objPHPExcel->getActiveSheet()->setCellValue('C10', '=COUNTIF(Funções!G8:G607,"EEL")')->getStyle('C10')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('E10', 'Baixa');
$objPHPExcel->getActiveSheet()->setCellValue('F10', 'x 3');
$objPHPExcel->getActiveSheet()->setCellValue('G10', '=C10*3')->getStyle('G10')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('J10', '=Deflatores!$G$4&"="')->getStyle('J10')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('K10', '=SUMIF(Funções!$J$8:$J$607,"EE"&Deflatores!G4,Funções!$L$8:$L$607)')->getStyle('K10')->applyFromArray($borderStyleSimples);

$objPHPExcel->getActiveSheet()->setCellValue('C11', '=COUNTIF(Funções!G8:G607,"EEA")')->getStyle('C11')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('E11', 'Média');
$objPHPExcel->getActiveSheet()->setCellValue('F11', 'x 4');
$objPHPExcel->getActiveSheet()->setCellValue('G11', '=C11*4')->getStyle('G11')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('J11', '=Deflatores!$G$5&"="')->getStyle('J11')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('K11', '=SUMIF(Funções!$J$8:$J$607,"EE"&Deflatores!G5,Funções!$L$8:$L$607)')->getStyle('K11')->applyFromArray($borderStyleSimples);

$objPHPExcel->getActiveSheet()->setCellValue('C12', '=COUNTIF(Funções!G8:G607,"EEH")')->getStyle('C12')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('E12', 'Alta');
$objPHPExcel->getActiveSheet()->setCellValue('F12', 'x 4');
$objPHPExcel->getActiveSheet()->setCellValue('G12', '=C12*6')->getStyle('G12')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('J12', '=Deflatores!$G$6&"="')->getStyle('J12')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('K12', '=SUMIF(Funções!$J$8:$J$607,"EE"&Deflatores!G6,Funções!$L$8:$L$607)')->getStyle('K12')->applyFromArray($borderStyleSimples);

$objPHPExcel->getActiveSheet()->setCellValue('B14', 'Qtd Total')->getStyle('B14')->applyFromArray($fontBold1);
$objPHPExcel->getActiveSheet()->setCellValue('C14', '=SUM(C10:C12)')->getStyle('C14')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('F14', 'Total')->getStyle('F14')->applyFromArray($fontBold1);
$objPHPExcel->getActiveSheet()->setCellValue('G14', '=SUM(G10:G12)')->getStyle('G14')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('J14', ' ')->getStyle('J14')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('K14', '=SUM(K10:K13)')->getStyle('K14')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('L14', '=IF(\'Sumário 2\'!L11<>0,K14/\'Sumário 2\'!L11,"")')->getStyle('L14')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_0);
/*
 * separador
 */
$objPHPExcel->getActiveSheet()->getStyle('A15:L15')->applyFromArray($borderStyleSimples);
/*
 * corpo do sumario Saidas Externas
 */
$objPHPExcel->getActiveSheet()->setCellValue('B17', 'SE');
$objPHPExcel->getActiveSheet()->setCellValue('C17', '=COUNTIF(Funções!G8:G607,"SEL")')->getStyle('C17')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('E17', 'Baixa');
$objPHPExcel->getActiveSheet()->setCellValue('F17', 'x 4');
$objPHPExcel->getActiveSheet()->setCellValue('G17', '=C17*4')->getStyle('G17')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('J17', '=Deflatores!$G$4&"="')->getStyle('J17')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('K17', '=SUMIF(Funções!$J$8:$J$607,"SE"&Deflatores!G4,Funções!$L$8:$L$607)')->getStyle('K17')->applyFromArray($borderStyleSimples);

$objPHPExcel->getActiveSheet()->setCellValue('C18', '=COUNTIF(Funções!G8:G607,"SEA")')->getStyle('C18')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('E18', 'Média');
$objPHPExcel->getActiveSheet()->setCellValue('F18', 'x 5');
$objPHPExcel->getActiveSheet()->setCellValue('G18', '=C18*5')->getStyle('G18')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('J18', '=Deflatores!$G$5&"="')->getStyle('J18')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('K18', '=SUMIF(Funções!$J$8:$J$607,"SE"&Deflatores!G5,Funções!$L$8:$L$607)')->getStyle('K18')->applyFromArray($borderStyleSimples);

$objPHPExcel->getActiveSheet()->setCellValue('C19', '=COUNTIF(Funções!G8:G607,"SEH")')->getStyle('C19')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('E19', 'Alta');
$objPHPExcel->getActiveSheet()->setCellValue('F19', 'x 7');
$objPHPExcel->getActiveSheet()->setCellValue('G19', '=C19*7')->getStyle('G19')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('J19', '=Deflatores!$G$6&"="')->getStyle('J19')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('K19', '=SUMIF(Funções!$J$8:$J$607,"SE"&Deflatores!G6,Funções!$L$8:$L$607)')->getStyle('K19')->applyFromArray($borderStyleSimples);

$objPHPExcel->getActiveSheet()->setCellValue('B21', 'Qtd Total')->getStyle('B21')->applyFromArray($fontBold1);
$objPHPExcel->getActiveSheet()->setCellValue('C21', '=SUM(C17:C19)')->getStyle('C21')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('F21', 'Total')->getStyle('F21')->applyFromArray($fontBold1);
$objPHPExcel->getActiveSheet()->setCellValue('G21', '=SUM(G17:G19)')->getStyle('G21')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('J21', ' ')->getStyle('J21')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('K21', '=SUM(K17:K20)')->getStyle('K21')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('L21', '=IF(\'Sumário 2\'!L11<>0,K21/\'Sumário 2\'!L11,"")')->getStyle('L21')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_0);
/*
 * separador
 */
$objPHPExcel->getActiveSheet()->getStyle('A22:L22')->applyFromArray($borderStyleSimples);
/*
 * corpo do sumario Consultas Externas
 */
$objPHPExcel->getActiveSheet()->setCellValue('B24', 'CE');
$objPHPExcel->getActiveSheet()->setCellValue('C24', '=COUNTIF(Funções!G8:G607,"CEL")')->getStyle('C24')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('E24', 'Baixa');
$objPHPExcel->getActiveSheet()->setCellValue('F24', 'x 3');
$objPHPExcel->getActiveSheet()->setCellValue('G24', '=C24*3')->getStyle('G24')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('J24', '=Deflatores!$G$4&"="')->getStyle('J24')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('K24', '=SUMIF(Funções!$J$8:$J$607,"CE"&Deflatores!G4,Funções!$L$8:$L$607)')->getStyle('K24')->applyFromArray($borderStyleSimples);

$objPHPExcel->getActiveSheet()->setCellValue('C25', '=COUNTIF(Funções!G8:G607,"CEA")')->getStyle('C25')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('E25', 'Média');
$objPHPExcel->getActiveSheet()->setCellValue('F25', 'x 4');
$objPHPExcel->getActiveSheet()->setCellValue('G25', '=C25*4')->getStyle('G25')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('J25', '=Deflatores!$G$5&"="')->getStyle('J25')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('K25', '=SUMIF(Funções!$J$8:$J$607,"CE"&Deflatores!G5,Funções!$L$8:$L$607)')->getStyle('K25')->applyFromArray($borderStyleSimples);

$objPHPExcel->getActiveSheet()->setCellValue('C26', '=COUNTIF(Funções!G8:G607,"CEH")')->getStyle('C26')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('E26', 'Alta');
$objPHPExcel->getActiveSheet()->setCellValue('F26', 'x 6');
$objPHPExcel->getActiveSheet()->setCellValue('G26', '=C26*6')->getStyle('G26')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('J26', '=Deflatores!$G$6&"="')->getStyle('J26')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('K26', '=SUMIF(Funções!$J$8:$J$607,"CE"&Deflatores!G6,Funções!$L$8:$L$607)')->getStyle('K26')->applyFromArray($borderStyleSimples);

$objPHPExcel->getActiveSheet()->setCellValue('B28', 'Qtd Total')->getStyle('B28')->applyFromArray($fontBold1);
$objPHPExcel->getActiveSheet()->setCellValue('C28', '=SUM(C24:C26)')->getStyle('C28')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('F28', 'Total')->getStyle('F28')->applyFromArray($fontBold1);
$objPHPExcel->getActiveSheet()->setCellValue('G28', '=SUM(G24:G26)')->getStyle('G28')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('J28', ' ')->getStyle('J28')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('K28', '=SUM(K24:K26)')->getStyle('K28')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('L28', '=IF(\'Sumário 2\'!L11<>0,K28/\'Sumário 2\'!L11,"")')->getStyle('L28')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_0);
/*
 * separador
 */
$objPHPExcel->getActiveSheet()->getStyle('A29:L29')->applyFromArray($borderStyleSimples);
/*
 * corpo do sumario Arquivos Logicos Internos
 */
$objPHPExcel->getActiveSheet()->setCellValue('B31', 'ALI');
$objPHPExcel->getActiveSheet()->setCellValue('C31', '=COUNTIF(Funções!G8:G607,"ALIL")')->getStyle('C31')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('E31', 'Baixa');
$objPHPExcel->getActiveSheet()->setCellValue('F31', 'x 7');
$objPHPExcel->getActiveSheet()->setCellValue('G31', '=C31*7')->getStyle('G31')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('J31', '=Deflatores!$G$4&"="')->getStyle('J31')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('K31', '=SUMIF(Funções!$J$8:$J$607,"ALI"&Deflatores!G4,Funções!$L$8:$L$607)')->getStyle('K31')->applyFromArray($borderStyleSimples);

$objPHPExcel->getActiveSheet()->setCellValue('C32', '=COUNTIF(Funções!G8:G607,"ALIA")')->getStyle('C32')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('E32', 'Média');
$objPHPExcel->getActiveSheet()->setCellValue('F32', 'x 10');
$objPHPExcel->getActiveSheet()->setCellValue('G32', '=C32*10')->getStyle('G32')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('J32', '=Deflatores!$G$5&"="')->getStyle('J32')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('K32', '=SUMIF(Funções!$J$8:$J$607,"ALI"&Deflatores!G5,Funções!$L$8:$L$607)')->getStyle('K32')->applyFromArray($borderStyleSimples);

$objPHPExcel->getActiveSheet()->setCellValue('C33', '=COUNTIF(Funções!G8:G607,"ALIH")')->getStyle('C33')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('E33', 'Alta');
$objPHPExcel->getActiveSheet()->setCellValue('F33', 'x 15');
$objPHPExcel->getActiveSheet()->setCellValue('G33', '=C33*15')->getStyle('G33')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('J33', '=Deflatores!$G$6&"="')->getStyle('J33')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('K33', '=SUMIF(Funções!$J$8:$J$607,"ALI"&Deflatores!G6,Funções!$L$8:$L$607)')->getStyle('K33')->applyFromArray($borderStyleSimples);

$objPHPExcel->getActiveSheet()->setCellValue('B35', 'Qtd Total')->getStyle('B35')->applyFromArray($fontBold1);
$objPHPExcel->getActiveSheet()->setCellValue('C35', '=SUM(C31:C33)')->getStyle('C35')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('F35', 'Total')->getStyle('F35')->applyFromArray($fontBold1);
$objPHPExcel->getActiveSheet()->setCellValue('G35', '=SUM(G31:G33)')->getStyle('G35')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('J35', ' ')->getStyle('J35')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('K35', '=SUM(K31:K33)')->getStyle('K35')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('L35', '=IF(\'Sumário 2\'!L11<>0,K35/\'Sumário 2\'!L11,"")')->getStyle('L35')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_0);
/*
 * separador
 */
$objPHPExcel->getActiveSheet()->getStyle('A36:L36')->applyFromArray($borderStyleSimples);
/*
 * corpo do sumario Arquivos de Interface Externa
 */
$objPHPExcel->getActiveSheet()->setCellValue('B38', 'AIE');
$objPHPExcel->getActiveSheet()->setCellValue('C38', '=COUNTIF(Funções!G8:G607,"AIEL")')->getStyle('C38')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('E38', 'Baixa');
$objPHPExcel->getActiveSheet()->setCellValue('F38', 'x 5');
$objPHPExcel->getActiveSheet()->setCellValue('G38', '=C38*5')->getStyle('G38')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('J38', '=Deflatores!$G$4&"="')->getStyle('J38')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('K38', '=SUMIF(Funções!$J$8:$J$607,"AIE"&Deflatores!G4,Funções!$L$8:$L$607)')->getStyle('K38')->applyFromArray($borderStyleSimples);

$objPHPExcel->getActiveSheet()->setCellValue('C39', '=COUNTIF(Funções!G8:G607,"AIEA")')->getStyle('C39')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('E39', 'Média');
$objPHPExcel->getActiveSheet()->setCellValue('F39', 'x 7');
$objPHPExcel->getActiveSheet()->setCellValue('G39', '=C39*7')->getStyle('G39')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('J39', '=Deflatores!$G$5&"="')->getStyle('J39')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('K39', '=SUMIF(Funções!$J$8:$J$607,"AIE"&Deflatores!G5,Funções!$L$8:$L$607)')->getStyle('K39')->applyFromArray($borderStyleSimples);

$objPHPExcel->getActiveSheet()->setCellValue('C40', '=COUNTIF(Funções!G8:G607,"AIEH")')->getStyle('C40')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('E40', 'Alta');
$objPHPExcel->getActiveSheet()->setCellValue('F40', 'x 10');
$objPHPExcel->getActiveSheet()->setCellValue('G40', '=C40*10')->getStyle('G40')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('J40', '=Deflatores!$G$6&"="')->getStyle('J40')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('K40', '=SUMIF(Funções!$J$8:$J$607,"AIE"&Deflatores!G6,Funções!$L$8:$L$607)')->getStyle('K40')->applyFromArray($borderStyleSimples);

$objPHPExcel->getActiveSheet()->setCellValue('B42', 'Qtd Total')->getStyle('B42')->applyFromArray($fontBold1);
$objPHPExcel->getActiveSheet()->setCellValue('C42', '=SUM(C38:C40)')->getStyle('C42')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('F42', 'Total')->getStyle('F42')->applyFromArray($fontBold1);
$objPHPExcel->getActiveSheet()->setCellValue('G42', '=SUM(G38:G40)')->getStyle('G42')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('J42', ' ')->getStyle('J42')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('K42', '=SUM(K38:K40)')->getStyle('K42')->applyFromArray($borderStyleSimples);
$objPHPExcel->getActiveSheet()->setCellValue('L42', '=IF(\'Sumário 2\'!L11<>0,K42/\'Sumário 2\'!L11,"")')->getStyle('L42')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_0);
/*
 * separador
 */
$objPHPExcel->getActiveSheet()->getStyle('A43:L43')->applyFromArray($borderStyleSimples);
/*
 * finalizacao do sumario 1
 */
$objPHPExcel->getActiveSheet()->mergeCells('B45:F45')->setCellValue('B45', 'Total PF não ajustados (contagem detalhada)');
$objPHPExcel->getActiveSheet()->setCellValue('G45', '=SUM(G14+G21+G28+G35+G42)')->getStyle('G45')->applyFromArray($borderStyleSimples);

$objPHPExcel->getActiveSheet()->mergeCells('B46:F46')->setCellValue('B46', 'Total PF não ajustados (contagem estimativa)');
$objPHPExcel->getActiveSheet()->setCellValue('G46', '=(C10+C11+C12)*4+(C17+C18+C19)*5+(C24+C25+C26)*4+(C31+C32+C33)*7+(C38+C39+C40)*5')->getStyle('G46')->applyFromArray($borderStyleSimples);

$objPHPExcel->getActiveSheet()->mergeCells('B47:F47')->setCellValue('B47', 'Total PF não ajustados (contagem estimativa)');
$objPHPExcel->getActiveSheet()->setCellValue('G47', '=(C31+C32+C33)*35+(C38+C39+C40)*1')->getStyle('G47')->applyFromArray($borderStyleSimples);
