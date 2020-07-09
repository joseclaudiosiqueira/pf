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
$objPHPExcel->createSheet(5);
$objPHPExcel->setActiveSheetIndex(5);
/*
 * renomeia a primeira planilha para CONTAGEM
 */
$objPHPExcel->getActiveSheet()->setTitle('Histórico de atividades');
/*
 * atribui a visualizacao da area de impressao
 */
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea('A1:F70');
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
$arrayLarguraColunas = [12, 36, 36, 36, 36, 36];
$arrayColunas = ['A', 'B', 'C', 'D', 'E', 'F'];
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
$objPHPExcel->getActiveSheet()->mergeCells('A1:F3')->setCellValue('A1', 'Histórico de atividades da contagem');
$objPHPExcel->getActiveSheet()->getStyle('A1:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:F3')->getFont()->setBold(true)->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle('A1:F3')->applyFromArray($borderStyle);
/*
 * cabecalho da planilha
 */
$objPHPExcel->getActiveSheet()->mergeCells('A4:C4')->setCellValue('A4', '=Contagem!A5&" : "&Contagem!F5')->getStyle('A4:C4')->applyFromArray($colorStyleBorder);
$objPHPExcel->getActiveSheet()->mergeCells('A5:C5')->setCellValue('A5', '=Contagem!A9&" : "&Contagem!F9')->getStyle('A5:C5')->applyFromArray($colorStyleBorder);
$objPHPExcel->getActiveSheet()->mergeCells('A6:C6')->setCellValue('A6', '=Contagem!A4&" : "&Contagem!F4')->getStyle('A6:C6')->applyFromArray($colorStyleBorder);
/*
 * segunda coluna do cabecalho
 */
$objPHPExcel->getActiveSheet()->mergeCells('D4:F4')->setCellValue('D4', '=Contagem!A8&" : "&Contagem!F8')->getStyle('D4:F4')->applyFromArray($colorStyleBorder);
$objPHPExcel->getActiveSheet()->mergeCells('D5:F5')->setCellValue('D5', '=Contagem!A10&" : "&Contagem!F10')->getStyle('D5:F5')->applyFromArray($colorStyleBorder);
$objPHPExcel->getActiveSheet()->mergeCells('D6:F6')->setCellValue('D6', '="Tipo de Contagem : "&Contagem!F6')->getStyle('D6:F6')->applyFromArray($colorStyleBorder);
/*
 * cabecalhos das colunas
 */
$objPHPExcel->getActiveSheet()->mergeCells("A8:F8")->setCellValue("A8", "Histórico de atividades da contagem")->getStyle("A8:F8")->applyFromArray($fontBold1)->applyFromArray($colorStyleCenterWhite);
$objPHPExcel->getActiveSheet()->getStyle("A8:F8")->applyFromArray($colorStyleCenterWhite);

$objPHPExcel->getActiveSheet()->setCellValue("A9", "#ID")->getStyle("A9")->applyFromArray($fontStyleWhite);
$objPHPExcel->getActiveSheet()->setCellValue("B9", "Processo")->getStyle("B9")->applyFromArray($fontStyleWhite);
$objPHPExcel->getActiveSheet()->setCellValue("C9", "Início")->getStyle("C9")->applyFromArray($fontStyleWhite);
$objPHPExcel->getActiveSheet()->setCellValue("D9", "Fim")->getStyle("D9")->applyFromArray($fontStyleWhite);
$objPHPExcel->getActiveSheet()->setCellValue("E9", "Responsável")->getStyle("E9")->applyFromArray($fontStyleWhite);
$objPHPExcel->getActiveSheet()->setCellValue("F9", "Finalizado por")->getStyle("F9")->applyFromArray($fontStyleWhite);
/*
 * seta a borda para a planilha inteira
 */
$objPHPExcel
        ->getActiveSheet()
        ->getStyle('A10:F70')
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
/*
 * lista das atividade da contagem
 */
$incremento = 10;
$idLinha = 1;
foreach ($historico as $linha) {
    $objPHPExcel->getActiveSheet()->setCellValue("A$incremento", "#" . str_pad($idLinha, 4, "0", STR_PAD_LEFT));
    $objPHPExcel->getActiveSheet()->setCellValue("B$incremento", str_replace('<br />', ' - ', (NULL !== $linha['data_fim'] ? $linha['descricao_concluido'] : $linha['descricao_em_andamento'])));
    $objPHPExcel->getActiveSheet()->setCellValue("C$incremento", date_format(date_create($linha['data_inicio']), 'd/m/Y H:i:s'));
    $objPHPExcel->getActiveSheet()->setCellValue("D$incremento", (NULL !== $linha['data_fim'] ? date_format(date_create($linha['data_fim']), 'd/m/Y H:i:s') : ''));
    $objPHPExcel->getActiveSheet()->setCellValue("E$incremento", $linha['user_email_executor']);
    $objPHPExcel->getActiveSheet()->setCellValue("F$incremento", (NULL !== $linha['data_fim'] ? $linha['finalizado_por'] : ''));
    $incremento++;
    $idLinha++;
}