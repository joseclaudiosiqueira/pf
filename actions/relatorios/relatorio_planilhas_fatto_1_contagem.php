<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * set a planilha (0) como ativa
 */
$objPHPExcel->setActiveSheetIndex(0);
/*
 * atribui a visualizacao da area de impressao
 */
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea('A1:V45');
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
 * array com as colunas do primeiro merge
 */
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false)->setWidth(10.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(false)->setWidth(3);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(false)->setWidth(8.86);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false)->setWidth(4.86);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(false)->setWidth(4.29);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(false)->setWidth(4.86);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(false)->setWidth(6.29);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(false)->setWidth(6.29);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(false)->setWidth(6.29);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(false)->setWidth(6.29);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(false)->setWidth(6.29);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(false)->setWidth(6.29);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(false)->setWidth(18.71);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(false)->setWidth(8.57);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(false)->setWidth(11.86);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(false)->setWidth(6.14);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(false)->setWidth(3);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(false)->setWidth(3);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(false)->setWidth(8.29);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(false)->setWidth(3);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(false)->setWidth(3);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(false)->setWidth(3);
/*
 * set a altura para auto na planilha como um todo
 */
$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
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
$objPHPExcel->getActiveSheet()->setTitle('Contagem');
/*
 * freeze na primeira linha
 */
$objPHPExcel->getActiveSheet()->freezePane('A4');
/*
 * identificacao da contagem
 */
$objPHPExcel->getActiveSheet()->mergeCells('A1:V3')->setCellValue('A1', 'Identificação da Contagem');
$objPHPExcel->getActiveSheet()->getStyle('A1:V3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:V3')->getFont()->setBold(true)->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle('A1:V3')->applyFromArray($borderStyle);

$objPHPExcel->getActiveSheet()->mergeCells('A4:E4')->setCellValue('A4', 'Empresa')->getStyle('A4:E4')->applyFromArray($fontStyleBlue);
$objPHPExcel->getActiveSheet()->mergeCells('F4:N4')->setCellValue('F4', $consultaContagem['CLI_descricao'])->getStyle('F4:N4')->applyFromArray($borderStyle);
//segunda coluna
$objPHPExcel->getActiveSheet()->mergeCells('O4:P4')->setCellValue('O4', 'PF IFPUG')->getStyle('O4:P4')->applyFromArray($fontStyleBlue);
$objPHPExcel->getActiveSheet()->mergeCells('Q4:V4')->setCellValue('Q4', '=Funções!L4')->getStyle('Q4:V4')->applyFromArray($borderStyle);
$objPHPExcel->getActiveSheet()->getStyle('Q4:V4')->applyFromArray($colorStyle);
/*
 * comentarios das tres primeiras linhas de valor
 */
$objPHPExcel->getActiveSheet()
        ->getComment('Q4')
        ->setAuthor('Fatto Consultoria e Sistemas');
$objCommentRichText = $objPHPExcel->getActiveSheet()
                ->getComment('Q4')
                ->getText()->createTextRun('Ponto de Função IFPUG: ');
$objCommentRichText->getFont()
        ->setBold(true)
        ->setName('Times New Roman')
        ->setSize(8.5);
$objPHPExcel->getActiveSheet()
        ->getComment('Q4')
        ->getText()->createTextRun('medição baseada nas regras do IFPUG. Não considerada os deflatores nem os itens não mensuráveis. Caso a funcionalidade não tenha sido detalhada, será considerada a estimativa da NESMA.')
        ->getFont()
        ->setBold(false)
        ->setName('Times New Roman')
        ->setSize(8.5);
$objPHPExcel->getActiveSheet()->getComment("Q4")->setWidth('242px');
$objPHPExcel->getActiveSheet()->getComment("Q4")->setHeight('100px');

//segunda linha
$objPHPExcel->getActiveSheet()->mergeCells('A5:E5')->setCellValue('A5', 'Aplicação')->getStyle('A5:E5')->applyFromArray($fontStyleBlue);
$objPHPExcel->getActiveSheet()->mergeCells('F5:N5')->setCellValue('E5', $consultaContagem['PRJ_descricao'])->getStyle('F5:N5')->applyFromArray($borderStyle);
//segunda coluna
$objPHPExcel->getActiveSheet()->mergeCells('O5:P5')->setCellValue('O5', 'PF Local EM')->getStyle('O5:P5')->applyFromArray($fontStyleBlue);
$objPHPExcel->getActiveSheet()->mergeCells('Q5:V5')->setCellValue('Q5', '=Funções!L5')->getStyle('Q5:V5')->applyFromArray($borderStyle);
$objPHPExcel->getActiveSheet()->getStyle('Q5:V5')->applyFromArray($colorStyle);
/*
 * comentarios das tres primeiras linhas de valor
 */
$objPHPExcel->getActiveSheet()
        ->getComment('Q5')
        ->setAuthor('Fatto Consultoria e Sistemas');
$objCommentRichText = $objPHPExcel->getActiveSheet()
                ->getComment('Q5')
                ->getText()->createTextRun('Ponto de Função Local do EM: ');
$objCommentRichText->getFont()
        ->setBold(true)
        ->setName('Times New Roman')
        ->setSize(8.5);
$objPHPExcel->getActiveSheet()
        ->getComment('Q5')
        ->getText()->createTextRun('medição para remuneração do Escritório de Métricas. Equivalente à medição do IFPUG. Porém, considera os itens não mensuráveis previstos em contrato')
        ->getFont()
        ->setBold(false)
        ->setName('Times New Roman')
        ->setSize(8.5);
$objPHPExcel->getActiveSheet()->getComment("Q5")->setWidth('242px');
$objPHPExcel->getActiveSheet()->getComment("Q5")->setHeight('100px');

//terceira linha
$objPHPExcel->getActiveSheet()->mergeCells('A6:E6')->setCellValue('A6', 'Tipo de Contagem')->getStyle('A6:E6')->applyFromArray($fontStyleBlue);
$objPHPExcel->getActiveSheet()->mergeCells('F6:N6')->setCellValue('F6', $consultaContagem['TPO_descricao'])->getStyle('F6:N6')->applyFromArray($borderStyle);
//segunda coluna
$objPHPExcel->getActiveSheet()->mergeCells('O6:P6')->setCellValue('O6', 'PF Local FS')->getStyle('O6:P6')->applyFromArray($fontStyleBlue);
$objPHPExcel->getActiveSheet()->mergeCells('Q6:V6')->setCellValue('Q6', '=Funções!L6')->getStyle('Q6:V6')->applyFromArray($borderStyle);
$objPHPExcel->getActiveSheet()->getStyle('Q6:V6')->applyFromArray($colorStyle);
/*
 * comentarios das tres primeiras linhas de valor
 */
$objPHPExcel->getActiveSheet()
        ->getComment('Q6')
        ->setAuthor('Fatto Consultoria e Sistemas');
$objCommentRichText = $objPHPExcel->getActiveSheet()
                ->getComment('Q6')
                ->getText()->createTextRun('Ponto de Função Local da FS: ');
$objCommentRichText->getFont()
        ->setBold(true)
        ->setName('Times New Roman')
        ->setSize(8.5);
$objPHPExcel->getActiveSheet()
        ->getComment('Q6')
        ->getText()->createTextRun('medição para remuneração da Fábrica de Software. Equivalente à medição do IFPUG. Porém, considera os deflatores e os itens não mensuráveis previstos em contrato')
        ->getFont()
        ->setBold(false)
        ->setName('Times New Roman')
        ->setSize(8.5);
$objPHPExcel->getActiveSheet()->getComment("Q6")->setWidth('242px');
$objPHPExcel->getActiveSheet()->getComment("Q6")->setHeight('100px');
/*
 * duas casas decimais
 */
$objPHPExcel->getActiveSheet()->getStyle('Q4:Q6')->getNumberFormat()->setFormatCode('#,##0.00');

//quarta linha
$objPHPExcel->getActiveSheet()->mergeCells('A7:E7')->setCellValue('A7', 'Nível de Detalhe')->getStyle('A7:E7')->applyFromArray($fontStyleBlue);
$objPHPExcel->getActiveSheet()->mergeCells('F7:N7')->setCellValue('F7', $consultaContagem['ETP_descricao'])->getStyle('F7:N7')->applyFromArray($borderStyle);
//segunda coluna
$objPHPExcel->getActiveSheet()->mergeCells('O7:Q7')->setCellValue('O7', 'Tecnologia')->getStyle('O7:Q7')->applyFromArray($fontStyleBlue);
$objPHPExcel->getActiveSheet()->mergeCells('R7:V7')->setCellValue('R7', html_entity_decode($consultaContagem['LNG_descricao']))->getStyle('R7:V7')->applyFromArray($borderStyle);

//quinta linha
$objPHPExcel->getActiveSheet()->mergeCells('A8:E8')->setCellValue('A8', 'Projeto')->getStyle('A8:E8')->applyFromArray($fontStyleBlue);
$objPHPExcel->getActiveSheet()->mergeCells('F8:N8')->setCellValue('F8', $consultaContagem['PRJ_descricao'])->getStyle('F8:N8')->applyFromArray($borderStyle);
//segunda coluna
$objPHPExcel->getActiveSheet()->mergeCells('O8:Q8')->setCellValue('O8', 'Versão do Guia')->getStyle('O8:Q8')->applyFromArray($fontStyleBlue);
$objPHPExcel->getActiveSheet()->mergeCells('R8:V8')->setCellValue('R8', $dro['descricao'])->getStyle('R8:V8')->applyFromArray($borderStyle);

//sexta linha
$objPHPExcel->getActiveSheet()->mergeCells('A9:E9')->setCellValue('A9', 'Responsável')->getStyle('A9:E9')->applyFromArray($fontStyleBlue);
$objPHPExcel->getActiveSheet()->mergeCells('F9:N9')->setCellValue('F9', $usuario['user_complete_name'])->getStyle('F9:N9')->applyFromArray($borderStyle);
//segunda coluna
$objPHPExcel->getActiveSheet()->mergeCells('O9:Q9')->setCellValue('O9', 'Criação')->getStyle('O9:Q9')->applyFromArray($fontStyleBlue);
$objPHPExcel->getActiveSheet()->mergeCells('R9:V9')->setCellValue('R9', date_format(date_create($consultaContagem['CNT_data_cadastro']), 'd/m/Y H:i:s'))->getStyle('R9:V9')->applyFromArray($borderStyle);

//setima linha
$objPHPExcel->getActiveSheet()->mergeCells('A10:E10')->setCellValue('A10', 'Revisor')->getStyle('A10:E10')->applyFromArray($fontStyleBlue);
$objPHPExcel->getActiveSheet()->mergeCells('F10:N10')->setCellValue('F10', ' ')->getStyle('F10:N10')->applyFromArray($borderStyle);
//segunda coluna
$objPHPExcel->getActiveSheet()->mergeCells('O10:Q10')->setCellValue('O10', 'Revisão')->getStyle('O10:Q10')->applyFromArray($fontStyleBlue);
$objPHPExcel->getActiveSheet()->mergeCells('R10:V10')->setCellValue('R10', ' ')->getStyle('R10:V10')->applyFromArray($borderStyle);

/*
 * proposito da contagem
 */
$objPHPExcel->getActiveSheet()->mergeCells('A11:V11')->setCellValue('A11', 'Propósito da contagem');
$objPHPExcel->getActiveSheet()->getStyle('A11:V11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A11:V11')->getFont()->setBold(true)->setSize(10);
$objPHPExcel->getActiveSheet()->getStyle('A11:V11')->applyFromArray($colorStyle);
$objPHPExcel->getActiveSheet()->getStyle('A11:V11')->applyFromArray($borderStyle);

$objPHPExcel->getActiveSheet()->mergeCells('A12:V15')->setCellValue('A12', $consultaContagem['CNT_proposito'])->getStyle('A12:V15')->applyFromArray($borderStyle);
$objPHPExcel->getActiveSheet()->getStyle('A12:V15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
/*
 * escopo da contagem
 */
$objPHPExcel->getActiveSheet()->mergeCells('A16:V16')->setCellValue('A16', 'Escopo da contagem');
$objPHPExcel->getActiveSheet()->getStyle('A16:V16')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A16:V16')->getFont()->setBold(true)->setSize(10);
$objPHPExcel->getActiveSheet()->getStyle('A16:V16')->applyFromArray($colorStyle);
$objPHPExcel->getActiveSheet()->getStyle('A16:V16')->applyFromArray($borderStyle);

$objPHPExcel->getActiveSheet()->mergeCells('A17:V20')->setCellValue('A17', $consultaContagem['CNT_escopo'])->getStyle('A17:V20')->applyFromArray($borderStyle);
$objPHPExcel->getActiveSheet()->getStyle('A17:V20')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
/*
 * documentacao utilizada na contagem
 */
$objPHPExcel->getActiveSheet()->mergeCells('A21:V21')->setCellValue('A21', 'Documentação Utilizada na Análise');
$objPHPExcel->getActiveSheet()->getStyle('A21:V21')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A21:V21')->getFont()->setBold(true)->setSize(10);
$objPHPExcel->getActiveSheet()->getStyle('A21:V21')->applyFromArray($colorStyle);
$objPHPExcel->getActiveSheet()->getStyle('A21:V21')->applyFromArray($borderStyle);
/*
 * pega o diretorio da contagem e lista os aquivos
 */
$directory = (PRODUCAO ? DIR_PRODUCAO : DIR_WAMP)
        . 'pf.arquivos' . DIRECTORY_SEPARATOR
        . str_pad(getIdEmpresa(), 11, "0", STR_PAD_LEFT) . DIRECTORY_SEPARATOR
        . str_pad($id, 11, "0", STR_PAD_LEFT);
$scanned_directory = array_diff(scandir($directory), array('..', '.', 'thumbnail'));
$lista_arquivos = str_replace(";", "\r", implode(";", $scanned_directory));

$objPHPExcel->getActiveSheet()->mergeCells('A22:V45')->setCellValue('A22', $lista_arquivos)->getStyle('A22:V45')->applyFromArray($borderStyle);
$objPHPExcel->getActiveSheet()->getStyle('A22')->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('A22:V45')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
