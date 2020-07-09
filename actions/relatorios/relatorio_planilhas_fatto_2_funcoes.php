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
$objPHPExcel->createSheet(1);
$objPHPExcel->setActiveSheetIndex(1);
/*
 * array com as colunas
 */
$arrayLarguraColunas = [56.14, 5.29, 10.71, 4, 6.57, 8.29, 0, 12.29, 0, 0, 12.86, 12.29, 7.14, 11, 32.71];
$arrayColunas = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O'];
for ($x = 0; $x < count($arrayColunas); $x++) {
    $objPHPExcel->getActiveSheet()->getColumnDimension("$arrayColunas[$x]")->setAutoSize(false)->setWidth($arrayLarguraColunas[$x]);
}
/*
 * renomeia a primeira planilha para CONTAGEM
 */
$objPHPExcel->getActiveSheet()->setTitle('Funções');
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
$objPHPExcel->getActiveSheet()->freezePane('A8');
/*
 * atribui a visualizacao da area de impressao
 */
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$objPHPExcel->getActiveSheet()->getPageSetup()->setPrintArea('A1:O607');
/*
 * visualizacao de impressao
 */
$objPHPExcel->getActiveSheet()->getSheetView()->setView(PHPExcel_Worksheet_SheetView::SHEETVIEW_PAGE_BREAK_PREVIEW);
/*
 * fit to one page
 */
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(14);
/*
 * identificacao da contagem
 */
$objPHPExcel->getActiveSheet()->mergeCells('A1:O3')->setCellValue('A1', 'Planilha de contagem de ponto de função - versão 2.4');
$objPHPExcel->getActiveSheet()->getStyle('A1:O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:O3')->getFont()->setBold(true)->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle('A1:O3')->applyFromArray($borderStyle);
/*
 * cabecalho
 */
$objPHPExcel->getActiveSheet()->setCellValue('A4', 'Funções')->getStyle('A4')
        ->applyFromArray($borderStyle)
        ->applyFromArray($colorStyle);
$objPHPExcel->getActiveSheet()->setCellValue('A5', '=Contagem!A9&" : "&Contagem!F9')->getStyle('A5')
        ->applyFromArray($borderStyle)
        ->applyFromArray($colorStyle);
$objPHPExcel->getActiveSheet()->setCellValue('A6', '=Contagem!A4&" : "&Contagem!F4')->getStyle('A6')
        ->applyFromArray($borderStyle)
        ->applyFromArray($colorStyle);

$objPHPExcel->getActiveSheet()->mergeCells('B4:J4')->setCellValue('B4', '=Contagem!A8&" : "&Contagem!F8')->getStyle('B4:J4')->applyFromArray($borderStyle);
$objPHPExcel->getActiveSheet()->getStyle('B4:J4')->applyFromArray($colorStyle);
$objPHPExcel->getActiveSheet()->mergeCells('B5:J5')->setCellValue('B5', '=Contagem!A10&" : "&Contagem!F10')->getStyle('B5:J5')->applyFromArray($borderStyle);
$objPHPExcel->getActiveSheet()->getStyle('B5:J5')->applyFromArray($colorStyle);
$objPHPExcel->getActiveSheet()->mergeCells('B6:J6')->setCellValue('B6', '="Tipo da Contagem : "&Contagem!F6')->getStyle('B6:J6')->applyFromArray($borderStyle);
$objPHPExcel->getActiveSheet()->getStyle('B6:J6')->applyFromArray($colorStyle);

$objPHPExcel->getActiveSheet()->setCellValue('K4', 'PF IFPUG')->getStyle('K4')->applyFromArray($borderStyle)->applyFromArray($colorStyle);
/*
 * comentarios
 */
$objPHPExcel->getActiveSheet()->getComment('K4')->setAuthor('Fatto Consultoria e Sistemas');
$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment('K4')->getText()->createTextRun('Ponto de Função IFPUG: ' . "\r\n");
$objCommentRichText->getFont()->setBold(true)->setName('Times New Roman')->setSize(8.5);
$objPHPExcel->getActiveSheet()->getComment('K4')->getText()
        ->createTextRun('Medição baseada nas regras do IFPUG. Não considerada os deflatores nem os itens não mensuráveis. Caso a funcionalidade não tenha sido detalhada, será considerada a estimativa da NESMA.')->getFont()->setBold(false)->setName('Times New Roman')->setSize(8.5);
$objPHPExcel->getActiveSheet()->getComment("K4")->setWidth('491px');
$objPHPExcel->getActiveSheet()->getComment("K4")->setHeight('74px');

$objPHPExcel->getActiveSheet()->setCellValue('K5', 'PF Local do EM')->getStyle('K5')->applyFromArray($borderStyle)->applyFromArray($colorStyle);
/*
 * comentarios
 */
$objPHPExcel->getActiveSheet()->getComment('K5')->setAuthor('Fatto Consultoria e Sistemas');
$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment('K5')->getText()->createTextRun('Ponto de Função Local do EM: ' . "\r\n");
$objCommentRichText->getFont()->setBold(true)->setName('Times New Roman')->setSize(8.5);
$objPHPExcel->getActiveSheet()->getComment('K5')->getText()
        ->createTextRun('Medição para remuneração do Escritório de Métricas. Equivalente à medição IFPUG. Porém, considera os itens não mensuráveis previstos em contrato.')->getFont()->setBold(false)->setName('Times New Roman')->setSize(8.5);
$objPHPExcel->getActiveSheet()->getComment("K5")->setWidth('491px');
$objPHPExcel->getActiveSheet()->getComment("K5")->setHeight('74px');

$objPHPExcel->getActiveSheet()->setCellValue('K6', 'PF Local da FS')->getStyle('K6')->applyFromArray($borderStyle)->applyFromArray($colorStyle);
/*
 * comentarios
 */
$objPHPExcel->getActiveSheet()->getComment('K6')->setAuthor('Fatto Consultoria e Sistemas');
$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment('K6')->getText()->createTextRun('Ponto de Função Local da FS: ' . "\r\n");
$objCommentRichText->getFont()->setBold(true)->setName('Times New Roman')->setSize(8.5);
$objPHPExcel->getActiveSheet()->getComment('K6')->getText()
        ->createTextRun('Medição para remuneração da Fábrica de Software. Equivalente à medição IFPUG. Porém, considera os deflatores e os itens não mensuráveis previstos em contrato.')->getFont()->setBold(false)->setName('Times New Roman')->setSize(8.5);
$objPHPExcel->getActiveSheet()->getComment("K6")->setWidth('491px');
$objPHPExcel->getActiveSheet()->getComment("K6")->setHeight('74px');

$objPHPExcel->getActiveSheet()->setCellValue('L4', '=SUM(H8:H607)')->getStyle('L4')->applyFromArray($borderStyle)->applyFromArray($colorStyle);
$objPHPExcel->getActiveSheet()->setCellValue('L5', '=SUM(K8:K607)')->getStyle('L5')->applyFromArray($borderStyle)->applyFromArray($colorStyle);
$objPHPExcel->getActiveSheet()->setCellValue('L6', '=SUM(L8:L607)')->getStyle('L6')->applyFromArray($borderStyle)->applyFromArray($colorStyle);
/*
 * duas casas decimais
 */
$objPHPExcel->getActiveSheet()->getStyle('L4:L6')->getNumberFormat()->setFormatCode('#,##0.00');

$objPHPExcel->getActiveSheet()->mergeCells('M4:O4')->getStyle('M4:O4')->applyFromArray($borderStyle);
$objPHPExcel->getActiveSheet()->getStyle('M4:O4')->applyFromArray($colorStyle);
$objPHPExcel->getActiveSheet()->mergeCells('M5:O5')->getStyle('M5:O5')->applyFromArray($borderStyle);
$objPHPExcel->getActiveSheet()->getStyle('M5:O5')->applyFromArray($colorStyle);
$objPHPExcel->getActiveSheet()->mergeCells('M6:O6')->getStyle('M6:O6')->applyFromArray($borderStyle);
$objPHPExcel->getActiveSheet()->getStyle('M6:O6')->applyFromArray($colorStyle);
/*
 * linha de cabecalho da planilha funcoes
 */
$objPHPExcel->getActiveSheet()->setCellValue('A7', 'Nome da Função')->getStyle('A7')
        ->applyFromArray($fontStyleWhite)
        ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
/*
 * comentarios
 */
$objPHPExcel->getActiveSheet()->getComment('A7')->setAuthor('Fatto Consultoria e Sistemas');
$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment('A7')->getText()->createTextRun('Nome da Função: ' . "\r\n");
$objCommentRichText->getFont()->setBold(true)->setName('Tahoma')->setSize(8);
$objPHPExcel->getActiveSheet()->getComment('A7')->getText()
        ->createTextRun('O processo é a menor unidade de atividade significativa para o usuário?' . "\r\n\r\n" . 'É auto-contido e deixa o negócio da aplicação em um estado consistente?')->getFont()->setBold(false)->setName('Tahoma')->setSize(8);
$objPHPExcel->getActiveSheet()->getComment("A7")->setWidth('245px');
$objPHPExcel->getActiveSheet()->getComment("A7")->setHeight('113px');

$objPHPExcel->getActiveSheet()->setCellValue('B7', 'Tipo')->getStyle('B7')->applyFromArray($fontStyleWhite);
/*
 * comentarios
 */
$objPHPExcel->getActiveSheet()->getComment('B7')->setAuthor('Fatto Consultoria e Sistemas');
$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment('B7')->getText()->createTextRun('Tipo de Função: ' . "\r\n");
$objCommentRichText->getFont()->setBold(true)->setName('Tahoma')->setSize(8);
$objPHPExcel->getActiveSheet()->getComment('B7')->getText()
        ->createTextRun('ALI, AIE, EE, SE, CE' . "\r\n" . 'ou' . "\r\n" . 'Itens não mensuráveis')->getFont()->setBold(false)->setName('Tahoma')->setSize(8);
$objPHPExcel->getActiveSheet()->getComment("B7")->setWidth('202px');
$objPHPExcel->getActiveSheet()->getComment("B7")->setHeight('74px');


$objPHPExcel->getActiveSheet()->setCellValue('C7', 'Manutenção')->getStyle('C7')->applyFromArray($fontStyleWhite);
/*
 * comentarios
 */
$objPHPExcel->getActiveSheet()->getComment('C7')->setAuthor('Fatto Consultoria e Sistemas');
$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment('C7')->getText()->createTextRun('Tipo de Manutenção na Função: ' . "\r\n");
$objCommentRichText->getFont()->setBold(true)->setName('Tahoma')->setSize(8);
$objPHPExcel->getActiveSheet()->getComment('C7')->getText()
        ->createTextRun('I, A, E' . "\r\n" . 'ou' . "\r\n" . 'Itens não mensuráveis')->getFont()->setBold(false)->setName('Tahoma')->setSize(8);
$objPHPExcel->getActiveSheet()->getComment("C7")->setWidth('326px');
$objPHPExcel->getActiveSheet()->getComment("C7")->setHeight('74px');

$objPHPExcel->getActiveSheet()->setCellValue('D7', 'TD')->getStyle('D7')->applyFromArray($fontStyleWhite);
/*
 * comentarios
 */
$objPHPExcel->getActiveSheet()->getComment('D7')->setAuthor('Fatto Consultoria e Sistemas');
$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment('D7')->getText()->createTextRun('Tipos de Ddados (DETs) ' . "\r\n");
$objCommentRichText->getFont()->setBold(true)->setName('Tahoma')->setSize(8);
$objPHPExcel->getActiveSheet()->getComment("D7")->setWidth('148px');
$objPHPExcel->getActiveSheet()->getComment("D7")->setHeight('74px');

$objPHPExcel->getActiveSheet()->setCellValue('E7', 'AR/TR')->getStyle('E7')->applyFromArray($fontStyleWhite);
/*
 * comentarios
 */
$objPHPExcel->getActiveSheet()->getComment('E7')->setAuthor('Fatto Consultoria e Sistemas');
$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment('E7')->getText()->createTextRun('Arquivos Referenciados / Tipos de Registros ' . "\r\n");
$objCommentRichText->getFont()->setBold(true)->setName('Tahoma')->setSize(8);
$objPHPExcel->getActiveSheet()->getComment("E7")->setWidth('236px');
$objPHPExcel->getActiveSheet()->getComment("E7")->setHeight('74px');

$objPHPExcel->getActiveSheet()->setCellValue('F7', 'Complex.')->getStyle('F7')->applyFromArray($fontStyleWhite);
/*
 * comentarios
 */
$objPHPExcel->getActiveSheet()->getComment('F7')->setAuthor('Fatto Consultoria e Sistemas');
$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment('F7')->getText()->createTextRun('Grau de complexidade específico atribuído a uma função ' . "\r\n");
$objCommentRichText->getFont()->setBold(true)->setName('Tahoma')->setSize(8);
$objPHPExcel->getActiveSheet()->getComment("F7")->setWidth('365px');
$objPHPExcel->getActiveSheet()->getComment("F7")->setHeight('74px');

$objPHPExcel->getActiveSheet()->setCellValue('G7', 'ctl')->getStyle('G7')->applyFromArray($fontStyleWhite);
$objPHPExcel->getActiveSheet()->setCellValue('H7', 'PF IFPUG')->getStyle('H7')->applyFromArray($fontStyleWhite);
$objPHPExcel->getActiveSheet()->setCellValue('I7', 'C')->getStyle('I7')->applyFromArray($fontStyleWhite);
$objPHPExcel->getActiveSheet()->setCellValue('J7', 'ctl2')->getStyle('J7')->applyFromArray($fontStyleWhite);
$objPHPExcel->getActiveSheet()->setCellValue('K7', 'PF Local do EM')->getStyle('K7')->applyFromArray($fontStyleWhite);
$objPHPExcel->getActiveSheet()->setCellValue('L7', 'PF Local da FS')->getStyle('L7')->applyFromArray($fontStyleWhite);
$objPHPExcel->getActiveSheet()->setCellValue('M7', 'Pacote')->getStyle('M7')->applyFromArray($fontStyleWhite);
/*
 * comentarios
 */
$objPHPExcel->getActiveSheet()->getComment('M7')->setAuthor('Fatto Consultoria e Sistemas');
$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment('M7')->getText()->createTextRun('Normalmente utilizado para contagem de baseline, onde o desenvolvimento foi realizado de forma incremental. Isto indica em qual(is) pacote(s) cada funcionalidade foi impactada. Em algumas situações pode ser informado o número do projeto, demanda ou incremento.');
$objCommentRichText->getFont()->setBold(true)->setName('Tahoma')->setSize(8);
$objPHPExcel->getActiveSheet()->getComment("M7")->setWidth('292px');
$objPHPExcel->getActiveSheet()->getComment("M7")->setHeight('97px');

$objPHPExcel->getActiveSheet()->setCellValue('N7', 'Referência')->getStyle('N7')->applyFromArray($fontStyleWhite);
/*
 * comentarios
 */
$objPHPExcel->getActiveSheet()->getComment('N7')->setAuthor('Fatto Consultoria e Sistemas');
$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment('N7')->getText()->createTextRun('Referência ao documento que justifica a contagem da funcionalidade');
$objCommentRichText->getFont()->setBold(true)->setName('Tahoma')->setSize(8);
$objPHPExcel->getActiveSheet()->getComment("N7")->setWidth('292px');
$objPHPExcel->getActiveSheet()->getComment("N7")->setHeight('74px');

$objPHPExcel->getActiveSheet()->setCellValue('O7', 'Observações')->getStyle('O7')->applyFromArray($fontStyleWhite)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
/*
 * seta a borda para a planilha inteira
 */
$objPHPExcel
        ->getActiveSheet()
        ->getStyle('A8:O607')
        ->getBorders()
        ->getAllBorders()
        ->setBorderStyle(PHPExcel_Style_Border::BORDER_DOTTED);
/*
 * seta as colunas F, H, K e L com a cor cinza
 */
$objPHPExcel
        ->getActiveSheet()
        ->getStyle('F8:L607')
        ->applyFromArray($colorStyleCabecalho11);
/*
 * seta as colunas B, C, D, F, G, H, I, J, K e L alinhadas ao centro
 */
$objPHPExcel
        ->getActiveSheet()
        ->getStyle('B8:L607')
        ->applyFromArray($colorStyleCenterWhite);

/*
 * PEGA TODAS AS FUNCIONALIDADES DA CONTAGEM
 */
$i = 8;
foreach ($linhas as $ln) {
    $objPHPExcel->getActiveSheet()->setCellValue("A$i", $ln['funcao']);
    $objPHPExcel->getActiveSheet()->setCellValue("B$i", ($ln['tipo'] === 'OU' ? $ln['f_sigla'] : $ln['tipo']));
    $objPHPExcel->getActiveSheet()->setCellValue("C$i", $ln['f_sigla']);
    $objPHPExcel->getActiveSheet()->setCellValue("D$i", $ln['td']);
    $objPHPExcel->getActiveSheet()->setCellValue("E$i", $ln['tr']);
    $objPHPExcel->getActiveSheet()->setCellValue("F$i", '=IF(ISBLANK(B' . $i . '),"",IF(I' . $i . '="L","Baixa",IF(I' . $i . '="A","Média",IF(I8="","","Alta"))))');
    $objPHPExcel->getActiveSheet()->setCellValue("G$i", '=CONCATENATE(B' . $i . ',I' . $i . ')');
    $objPHPExcel->getActiveSheet()->setCellValue("H$i", '=IF(ISBLANK(B' . $i . '),"",IF(B' . $i . '="ALI",IF(I' . $i . '="L",7,IF(I' . $i . '="A",10,15)),IF(B' . $i . '="AIE",IF(I' . $i . '="L",5,IF(I' . $i . '="A",7,10)),IF(B' . $i . '="SE",IF(I' . $i . '="L",4,IF(I' . $i . '="A",5,7)),IF(OR(B' . $i . '="EE",B' . $i . '="CE"),IF(I' . $i . '="L",3,IF(I' . $i . '="A",4,6)),0)))))');
    $objPHPExcel->getActiveSheet()->setCellValue("I$i", '=IF(OR(ISBLANK(D' . $i . '),ISBLANK(E' . $i . ')),IF(OR(B' . $i . '="ALI",B' . $i . '="AIE"),"L",IF(OR(B' . $i . '="EE",B' . $i . '="SE",B' . $i . '="CE"),"A","")),IF(B' . $i . '="EE",IF(E' . $i . '>=3,IF(D' . $i . '>=5,"H","A"),IF(E' . $i . '>=2,IF(D' . $i . '>=16,"H",IF(D' . $i . '<=4,"L","A")),IF(D' . $i . '<=15,"L","A"))),IF(OR(B' . $i . '="SE",B' . $i . '="CE"),IF(E' . $i . '>=4,IF(D' . $i . '>=6,"H","A"),IF(E' . $i . '>=2,IF(D' . $i . '>=20,"H",IF(D' . $i . '<=5,"L","A")),IF(D' . $i . '<=19,"L","A"))),IF(OR(B' . $i . '="ALI",B' . $i . '="AIE"),IF(E' . $i . '>=6,IF(D' . $i . '>=20,"H","A"),IF(E' . $i . '>=2,IF(D' . $i . '>=51,"H",IF(D' . $i . '<=19,"L","A")),IF(D' . $i . '<=50,"L","A"))),""))))');
    $objPHPExcel->getActiveSheet()->setCellValue("J$i", '=CONCATENATE(B' . $i . ',C' . $i . ')');
    $objPHPExcel->getActiveSheet()->setCellValue("K$i", '=IF(OR(H' . $i . '="",H' . $i . '=0),L' . $i . ',H' . $i . ')');
    $objPHPExcel->getActiveSheet()->setCellValue("L$i", '=IF(NOT(ISERROR(VLOOKUP(B' . $i . ',Deflatores!G$42:H$64,2,FALSE))),VLOOKUP(B' . $i . ',Deflatores!G$42:H$64,2,FALSE),IF(OR(ISBLANK(C' . $i . '),ISBLANK(B' . $i . ')),"",VLOOKUP(C' . $i . ',Deflatores!G$4:H$38,2,FALSE)*H' . $i . '+VLOOKUP(C' . $i . ',Deflatores!G$4:I$38,3,FALSE)))');
    $objPHPExcel->getActiveSheet()->setCellValue("M$i", " ");
    $objPHPExcel->getActiveSheet()->setCellValue("N$i", $ln['fonte']);
    $objPHPExcel->getActiveSheet()->setCellValue("O$i", $ln['obs_funcao']);
    $i++;
}