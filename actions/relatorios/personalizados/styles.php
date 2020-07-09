<?php

/*
 * array que coloca as bordas em todas as celulas
 */
$borderStyleDouble = array(
    'borders' => array(
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
            'color' => array('rgb' => '000000')
        )
    )
);
/*
 * array que coloca as bordas em todas as celulas
 */
$borderStyleSimples = array(
    'borders' => array(
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        )
    )
);
/*
 * array que coloca as bordas em todas as celulas
 */
$fontBold1 = array(
    'font' => array(
        'bold' => true,
        'size' => 9,
        'name' => 'Franklin Gothic Medium'
    )
);
/*
 * array que coloca as bordas em todas as celulas
 */
$borderStyleDotted = array(
    'borders' => array(
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_DOTTED,
            'color' => array('rgb' => '1F497D')
        )
    )
);

/*
 * array que coloca as bordas em todas as celulas
 */
$borderStyleDottedBlack = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_DOTTED,
            'color' => array('rgb' => '000000')
        )
    )
);
/*
 * array que coloca as bordas em todas as celulas
 */
$borderStyleDottedBlackCenter = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_DOTTED,
            'color' => array('rgb' => '000000')
        )
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    )
);
/*
 * array que coloca as bordas em todas as celulas
 */
$borderStyleDottedBottomRight = array(
    'borders' => array(
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOTTED, 'color' => array('rgb' => '1F497D')),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_DOTTED, 'color' => array('rgb' => '1F497D'))
    )
);
/*
 * array que coloca as bordas em todas as celulas
 */
$borderStyleDottedRight = array(
    'borders' => array(
        'right' => array(
            'style' => PHPExcel_Style_Border::BORDER_DOTTED,
            'color' => array('rgb' => '1F497D')
        )
    )
);
/*
 * para bordas em formato de quadrado
 */
$borderStyleQuad = array(
    'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '1F497D')),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '1F497D')),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '1F497D')),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '1F497D')),
    )
);

/*
 * para bordas em formato de quadrado dotted
 */
$borderStyleThreeDotted = array(
    'borders' => array(
        'left' => array('style' => PHPExcel_Style_Border::BORDER_DOTTED, 'color' => array('rgb' => '000000')),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOTTED, 'color' => array('rgb' => '000000')),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_DOTTED, 'color' => array('rgb' => '000000')),
    )
);
/*
 * para bordas em formato de quadrado apenas right e bottom
 */
$borderStyleQuadMedium = array(
    'borders' => array(
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('rgb' => '000000')),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('rgb' => '000000')),
    )
);
/*
 * para bordas em formato de quadrado
 */
$borderStyleQuadEscuro = array(
    'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'D9D9D9')
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    )
);
/*
 * para bordas em formato de quadrado
 */
$borderStyleQuadClaro = array(
    'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'F2F2F2')
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    )
);
/*
 * para bordas em formato de quadrado
 */
$borderStyleQuadEscuroBold = array(
    'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'D9D9D9')
    ),
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '000000'),
        'size' => 9,
        'name' => 'Verdana'
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    )
);
/*
 * para bordas em formato de quadrado
 */
$borderStyleQuadClaroBold = array(
    'borders' => array(
        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'F2F2F2')
    ),
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '000000'),
        'size' => 9,
        'name' => 'Verdana'
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    )
);
/*
 * para bordas em formato de quadrado
 */
$borderStyleQuadClaroBoldTotal = array(
    'borders' => array(
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('rgb' => '000000')),
        'top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('rgb' => '000000')),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'F2F2F2')
    ),
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '000000'),
        'size' => 9,
        'name' => 'Verdana'
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    )
);
/*
 * para bordas em formato de linha abaixo (bottom)
 */
$borderStyleBottom = array(
    'borders' => array(
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
    )
);
/*
 * array cores de cabecalho, secundarias e cinzas
 */
$colorStyleCabecalho = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '1F497D')
    )
);
/*
 * array cores de cabecalho, secundarias e cinzas
 */
$colorStyleCabecalho10 = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '1F497D')
    ),
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => 'FFFFFF'),
        'size' => 10,
        'name' => 'Verdana'
    )
);
/*
 * array cores de cabecalho, secundarias e cinzas
 */
$colorStyleCabecalho11 = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'C0C0C0')
    )
);
/*
 * array cores de cabecalho, secundarias e cinzas
 */
$colorStyleCabecalhoFonteAzulFundoCinza = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'C0C0C0')
    ),
    'font' => array(
        'color' => array('rgb' => '0000FF'),
        'size' => 9,
        'name' => 'Franklin Gothic Medium'
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        )
    )
);
/*
 * array cores de cabecalho, secundarias e cinzas (com font bold)
 */
$colorStyleCabecalhoBold = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '1F497D')
    ),
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => 'FFFFFF'),
        'size' => 9,
        'name' => 'Verdana'
    )
);
/*
 * array cores de cabecalho, secundarias e cinzas (com font bold)
 */
$colorStyleCabecalhoBold8 = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '1F497D')
    ),
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => 'FFFFFF'),
        'size' => 8,
        'name' => 'Verdana'
    )
);
/*
 * array cores de cabecalho, secundarias e cinzas (com font bold)
 */
$colorStyleCabecalho10NotFill = array(
    'font' => array(
        'bold' => false,
        'color' => array('rgb' => '1F497D'),
        'size' => 10,
        'name' => 'Verdana'
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000')
        )
    )
);
/*
 * array cores de cabecalho, secundarias e cinzas (com font bold)
 */
$colorStyleCabecalhoBold10 = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '1F497D')
    ),
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => 'FFFFFF'),
        'size' => 10,
        'name' => 'Verdana'
    )
);
$colorStyleSecundaria = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'DAEEF3')
    )
);
/*
 * array de sombreamento cinza escuro
 */
$colorStyleZebra = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'D9D9D9')
    )
);
/*
 * array de sombreamento cinza claro
 */
$colorStyleZebraClaro = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'F2F2F2')
    )
);
/*
 * array de sombreamento cinza mais escuro
 */
$colorStyleZebraEscuro = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'BFBFBF')
    )
);
/*
 * seta a fonte como bold e zebrada
 */
$fontBoldZebra = array(
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '000000'),
        'size' => 9,
        'name' => 'Verdana'
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'D9D9D9')
    )
);
/*
 * seta a fonte como bold e zebrada
 */
$fontBoldZebraClaro = array(
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '000000'),
        'size' => 9,
        'name' => 'Verdana'
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'F2F2F2')
    )
);
/*
 * seta a fonte como bold sem zebra
 */
$fontBold = array(
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '000000'),
        'size' => 9,
        'name' => 'Verdana'
    )
);
/*
 * font normal, fill (F0F0F0), border line bottom
 */
$fonteTotalizadores = array(
    'font' => array(
        'bold' => false,
        'color' => array('rgb' => '000000'),
        'size' => 9,
        'name' => 'Verdana'
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'F2F2F2')
    ),
    'borders' => array(
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'rgb' => '000000')
        )
    )
);

$contagemDottedAzulCenter = array(
    'font' => array(
        'bold' => false,
        'color' => array('rgb' => '000000'),
        'size' => 9,
        'name' => 'Verdana'
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'DAEEF3')
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_DOTTED,
            'color' => array('rgb' => '000000')
        )
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    )
);
/*
 * array que coloca as bordas em todas as celulas
 */
$borderStyle = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    )
);
/*
 * array de sombreamento cinza
 */
$colorStyle = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'C0C0C0')
    )
);
/*
 * array de sombreamento cinza com borda
 */
$colorStyleBorder = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'C0C0C0')
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    )
);
/*
 * array de sombreamento cinza e texto centralizado
 */
$colorStyleCenter = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'C0C0C0')
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    )
);
/*
 * array de sombreamento cinza e texto centralizado
 */
$colorStyleCenterWhite = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    )
);
/*
 * array fonte azul com borda
 */
$fontStyleBlue = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'FFFFFF')
    ),
    'font' => array(
        'bold' => false,
        'color' => array('rgb' => '0000FF'),
        'size' => 9,
        'name' => 'Franklin Gothic Medium'),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    )
);
/*
 * array fonte azul com borda
 */
$fontStyleBlueOnly = array(
    'font' => array(
        'color' => array('rgb' => '0000FF'),
        'size' => 9,
        'name' => 'Franklin Gothic Medium')
);
/*
 * array fonte azul com borda
 */
$fontStyleWhite = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '808080')
    ),
    'font' => array(
        'bold' => false,
        'color' => array('rgb' => 'FFFFFF'),
        'size' => 8,
        'name' => 'Franklin Gothic Medium'),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    )
);
/*
 * array fonte azul com borda
 */
$fontStyleWhiteNoBorder = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '808080')
    ),
    'font' => array(
        'bold' => false,
        'color' => array('rgb' => 'FFFFFF'),
        'size' => 8,
        'name' => 'Franklin Gothic Medium')
);
/*
 * array fonte amarela com borda e negrito
 */
$fontStyleYellowBorderBold = array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'FFFF00')
    ),
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '000000'),
        'size' => 9,
        'name' => 'Franklin Gothic Medium'),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    )
);
