<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * PLANILHA COM AS FUNCIONALIDADES DA CONTAGEM
 */
$objPHPExcel->createSheet(2);
$objPHPExcel->setActiveSheetIndex(2);
/*
 * array com as colunas
 */
$arrayLarguraColunas = [10.86, 10.86, 10.86, 10.86, 22.57, 52.57, 7, 12.57, 9.14, 9.86, 9.86, 0];
$arrayColunas = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
for ($x = 0; $x < count($arrayColunas); $x++) {
    $objPHPExcel->getActiveSheet()->getColumnDimension("$arrayColunas[$x]")->setAutoSize(false)->setWidth($arrayLarguraColunas[$x]);
}
/*
 * height da Row para esta aba
 */
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(36);
/*
 * renomeia a primeira planilha para CONTAGEM
 */
$objPHPExcel->getActiveSheet()->setTitle('Deflatores');
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
 * freeze na primeira linha
 */
$objPHPExcel->getActiveSheet()->freezePane('A2');
/*
 * atribui a visualizacao da area de impressao
 */
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea('A1:K64');
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
 * identificacao da contagem
 */
$objPHPExcel->getActiveSheet()->mergeCells('A1:K1')->setCellValue('A1', 'Itens Não Mensuráveis');
$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true)->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($borderStyle);
/*
 * cabecalho
 */
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Funções')->mergeCells('A2:F2')->getStyle('A2:F2')->applyFromArray($colorStyleCabecalhoFonteAzulFundoCinza);
$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Sigla')->mergeCells('G2:G3')->getStyle('G2:G3')->applyFromArray($colorStyleCabecalhoFonteAzulFundoCinza);
$objPHPExcel->getActiveSheet()->setCellValue('H2', 'Contribuição em PF Local')->mergeCells('H2:I2')->getStyle('H2:I2')->applyFromArray($colorStyleCabecalhoFonteAzulFundoCinza);
$objPHPExcel->getActiveSheet()->setCellValue('J2', 'PF IFPUG')->mergeCells('J2:J3')->getStyle('J2:J3')->applyFromArray($colorStyleCabecalhoFonteAzulFundoCinza);
$objPHPExcel->getActiveSheet()->setCellValue('K2', 'PF Local FS')->mergeCells('K2:K3')->getStyle('K2:K3')->applyFromArray($colorStyleCabecalhoFonteAzulFundoCinza);
$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Contrato')->getStyle('A3')->applyFromArray($colorStyleCabecalhoFonteAzulFundoCinza);
$objPHPExcel->getActiveSheet()->setCellValue('B3', 'Descrição')->mergeCells('B3:E3')->getStyle('B3:E3')->applyFromArray($colorStyleCabecalhoFonteAzulFundoCinza);
$objPHPExcel->getActiveSheet()->setCellValue('F3', 'Origem')->getStyle('F3')->applyFromArray($colorStyleCabecalhoFonteAzulFundoCinza);
$objPHPExcel->getActiveSheet()->setCellValue('H3', 'Percentual (%)')->getStyle('H3')->applyFromArray($colorStyleCabecalhoFonteAzulFundoCinza);
$objPHPExcel->getActiveSheet()->setCellValue('I3', 'Fixa (PF)')->getStyle('I3')->applyFromArray($colorStyleCabecalhoFonteAzulFundoCinza);
/*
 * tres primeiras celulas do contrato
 */
$objPHPExcel->getActiveSheet()->setCellValue('A4', 'Adicionada');
$objPHPExcel->getActiveSheet()->setCellValue('A5', 'Alterada');
$objPHPExcel->getActiveSheet()->setCellValue('A6', 'Excluída');
/*
 * valores da celula [L] que esta oculta
 */
$objPHPExcel->getActiveSheet()->setCellValue('L37', 'ALI');
$objPHPExcel->getActiveSheet()->setCellValue('L38', 'AIE');
$objPHPExcel->getActiveSheet()->setCellValue('L39', 'EE');
$objPHPExcel->getActiveSheet()->setCellValue('L40', 'CE');
$objPHPExcel->getActiveSheet()->setCellValue('L41', 'SE');
/*
 * loop pra encurtar codigo
 */
for ($x = 42; $x <= 64; $x++) {
    $objPHPExcel->getActiveSheet()->setCellValue('L' . $x, '=""&G' . $x);
}
/*
 * preenchimento das formulas das colunas [J] e [K]
 */
for ($x = 4; $x <= 38; $x++) {
    $objPHPExcel->getActiveSheet()->setCellValue("J$x", '=SUMIF(Funções!$C$8:$C$607,Deflatores!G' . $x . ',Funções!$H$8:$H$607)');
    $objPHPExcel->getActiveSheet()->setCellValue("K$x", "=IF(H$x=\"\",COUNTIF(Funções!C$8:C$607,G$x)*I$x,H$x*J$x)");
    /*
     * aproveita e aplica o estilo azul na fonte
     */
    $objPHPExcel->getActiveSheet()->getStyle("B$x:G$x")->applyFromArray($fontStyleBlueOnly);
}
/*
 * preenchimento das formulas das colunas [J] e [K] - segunda parte
 */
for ($x = 42; $x <= 64; $x++) {
    $objPHPExcel->getActiveSheet()->setCellValue("J$x", '=COUNTIF(Funções!B$8:B$607,G' . $x . ')');
    $objPHPExcel->getActiveSheet()->setCellValue("K$x", '=SUMIF(Funções!B$8:B$607,$G' . $x . ',Funções!K$8:K$607)');
    /*
     * aproveita e aplica o estilo azul na fonte
     */
    $objPHPExcel->getActiveSheet()->getStyle("B$x:G$x")->applyFromArray($fontStyleBlueOnly);
}
/*
 * merge das celulas da linha [39]
 */
$objPHPExcel->getActiveSheet()->mergeCells('A39:K39');
/*
 * estilos gerais da aba
 */
$objPHPExcel->getActiveSheet()->getStyle('A2:K64')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
/*
 * primeira coluna [cinza] e colunas J e K [cinzas]
 */
$objPHPExcel->getActiveSheet()->getStyle('A4:A38')->applyFromArray($colorStyle);
$objPHPExcel->getActiveSheet()->getStyle('A42:A64')->applyFromArray($colorStyle);
$objPHPExcel->getActiveSheet()->getStyle('J4:K38')->applyFromArray($colorStyleCenter);
$objPHPExcel->getActiveSheet()->getStyle('J42:K64')->applyFromArray($colorStyleCenter);
$objPHPExcel->getActiveSheet()->getStyle('G4:I38')->applyFromArray($colorStyleCenterWhite);
$objPHPExcel->getActiveSheet()->getStyle('G42:I64')->applyFromArray($colorStyleCenterWhite);
/*
 * formatacao dos numeros com duas casas decimais e percentual
 */
$objPHPExcel->getActiveSheet()->getStyle('I4:K38')->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('H42:H64')->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('K42:K64')->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('H42:H64')->getNumberFormat()->setFormatCode('#,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('H4:H21')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_0);
$objPHPExcel->getActiveSheet()->getStyle('H23:H38')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_0);
/*
 * merge das celulas [H] e [I] para bater com o cabecalho
 */
for ($x = 42; $x <= 64; $x++) {
    $objPHPExcel->getActiveSheet()->mergeCells("H$x:I$x");
}
/*
 * segundo cabecalho apos a linha [39]
 */
$objPHPExcel->getActiveSheet()->setCellValue('A40', 'Itens Não Mensuráveis')->mergeCells('A40:F40')->getStyle('A40:F40')->applyFromArray($colorStyleCabecalhoFonteAzulFundoCinza);
$objPHPExcel->getActiveSheet()->setCellValue('G40', 'Sigla')->mergeCells('G40:G41')->getStyle('G40:G41')->applyFromArray($colorStyleCabecalhoFonteAzulFundoCinza);
$objPHPExcel->getActiveSheet()->setCellValue('H40', 'Contribuição em PF Local')->mergeCells('H40:I41')->getStyle('H40:I41')->applyFromArray($colorStyleCabecalhoFonteAzulFundoCinza);
$objPHPExcel->getActiveSheet()->setCellValue('J40', 'Quantidade')->mergeCells('J40:J41')->getStyle('J40:J41')->applyFromArray($colorStyleCabecalhoFonteAzulFundoCinza);
$objPHPExcel->getActiveSheet()->setCellValue('K40', 'PF Local FS')->mergeCells('K40:K41')->getStyle('K40:K41')->applyFromArray($colorStyleCabecalhoFonteAzulFundoCinza);
$objPHPExcel->getActiveSheet()->setCellValue('A41', 'Contrato')->getStyle('A41')->applyFromArray($colorStyleCabecalhoFonteAzulFundoCinza);
$objPHPExcel->getActiveSheet()->setCellValue('B41', 'Descrição')->mergeCells('B41:E41')->getStyle('B41:E41')->applyFromArray($colorStyleCabecalhoFonteAzulFundoCinza);
$objPHPExcel->getActiveSheet()->setCellValue('F41', 'Origem')->getStyle('F41')->applyFromArray($colorStyleCabecalhoFonteAzulFundoCinza);
/*
 * merge das celulas [B] a [E]
 */
for ($x = 4; $x <= 38; $x++) {
    $objPHPExcel->getActiveSheet()->mergeCells("B$x:E$x");
}
/*
 * segunda parte
 */
for ($x = 42; $x <= 64; $x++) {
    $objPHPExcel->getActiveSheet()->mergeCells("B$x:E$x");
}
/*
 * para itens nao mensuraveis ja deixa fixo
 */
$objPHPExcel->getActiveSheet()
        ->setCellValue('B42', 'Páginas Estáticas')
        ->setCellValue('F42', 'SISP - 4.11 Desenvolvimento, Manutenção e Publicação de Páginas Estáticas')
        ->setCellValue('G42', 'PAG')
        ->setCellValue('H42', '0.60');

$objPHPExcel->getActiveSheet()
        ->setCellValue('B43', 'Manutenção Cosmética (atrelada a algo não funcional')
        ->setCellValue('F43', 'SISP - 4.7 Manutenção Cosmética')
        ->setCellValue('G43', 'COSNF')
        ->setCellValue('H43', '0.60');

$objPHPExcel->getActiveSheet()
        ->setCellValue('B44', 'Dados de Código')
        ->setCellValue('F44', '-')
        ->setCellValue('G44', 'DC')
        ->setCellValue('H44', '0.00');
for ($x = 45; $x <= 64; $x++) {
    $objPHPExcel->getActiveSheet()
            ->setCellValue("G$x", "           .");
}
/*
 * Pega os Deflatores do Roteiro FATTO 2.4
 */
$fi = new FatorImpacto();
$linhasFi = $fi->listaFatorImpactoTodosFATTO(4); //ATENCAO = ROTEIRO COM ID FIXO = [4]
$i = 4;
foreach ($linhasFi as $lf) {
    $objPHPExcel->getActiveSheet()->setCellValue("B$i", $lf['descricao']);
    $objPHPExcel->getActiveSheet()->setCellValue("F$i", $lf['fonte']);
    $objPHPExcel->getActiveSheet()->setCellValue("G$i", $lf['sigla']);
    $lf['tipo'] === 'A' ?
                    $objPHPExcel->getActiveSheet()->setCellValue("H$i", $lf['fator']) :
                    $objPHPExcel->getActiveSheet()->setCellValue("I$i", $lf['fator']);
    $i++;
}