<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verificacao do status do login e do id
 */
$id = NULL !== filter_input(INPUT_GET, 'i', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_GET, 'i', FILTER_SANITIZE_NUMBER_INT) : false;
//verifica se esta logado e o id e valido
$arrTipo = array('xls', 'ods', 'xlsx', 'ifpug', 'fatto');
$tipo = NULL !== filter_input(INPUT_GET, 't', FILTER_SANITIZE_STRING) ? filter_input(INPUT_GET, 't', FILTER_SANITIZE_STRING) : 0;
$inTipo = in_array_r($tipo, $arrTipo);
//verifica a validade das informacoes
if ($login->isUserLoggedIn() &&
        $id &&
        (getConfigPlano('exportar_xls') || getConfigPlano('exportar_xlsx') || getConfigPlano('exportar_ods') &&
        $tipo &&
        $inTipo) && verificaSessao()) {
    //realiza todas as verificacoes antes de emitir qualquer relatorio
    $userId = getUserIdDecoded();
    //define as variaveis
    $user_email = getVariavelSessao('user_email');
    //pega o id do fornecedor
    $idFornecedor = getIdFornecedor();
    //pega o id da empresa
    $idEmpresa = getIdEmpresa();
    //instancia as classes
    $fn = new Contagem();
    $user = new Usuario();
    $ch = new ContagemHistorico();
    $cp = new ContagemProcesso();
    $ca = new ContagemAcesso();
    $cl = new Cliente();
    $ca->setUserEmail($user_email);
    //seta as tabelas
    //pega a abrangencia atual para SNAP e outras
    $idAbrangencia = $fn->getAbrangencia($id)['id_abrangencia'];
    //variavel $pass ... determina se a acao pode ser executada pelo solicitante
    $pass = false;
    //verifica se eh o responsavel pela contagem
    $isResponsavel = $fn->isResponsavel($user_email, $id);
    //verifica a privacidade da contagem
    $privacidade = $fn->getPrivacidade($id)['privacidade'];
    //verifica se pode visualizar contagens de fornecedor
    $isVisualizarContagemFornecedor = getConfigContagem('is_visualizar_contagem_fornecedor') ? true : false;
    //verifica se a contagem eh de um fornecedor
    $isContagemFornecedor = $fn->isContagemFornecedor($id);
    //verifica se eh um gestor
    $isGestor = getVariavelSessao('isGestor');
    //verifica se eh o gerente do projeto
    $isGerenteProjeto = $fn->isGerenteProjeto($user_email, $id);
    //verifica se existe autorizacao para o usuario visualizar a contagem
    $ca->setIdContagem($id);
    $isAutorizado = $ca->isAutorizado();
    //verifica se eh um gerente de conta
    $isGerenteConta = getVariavelSessao('isGerenteConta');
    //verifica se eh um perfil de diretor
    $isDiretor = getVariavelSessao('isDiretor');
    //visualizador
    $isViewer = getVariavelSessao('isViewer');
    //verifica se o perfil eh de analista de metricas e a contagem e publica e exibe
    $isPerfilAnalistaMetricas = getVariavelSessao('isAnalistaMetricas');
    //verifica se eh o validador interno da contagem
    $isValidadorInterno = $fn->isValidadorInterno($user_email, $id);
    //verifica se eh o validador externo da contagem
    $isValidadorExterno = $fn->isValidadorExterno($user_email, $id);
    //verifica se eh o auditor interno da contagem
    $isAuditorInterno = $fn->isAuditorInterno($user_email, $id);
    //verifica se eh o auditor externo da contagem
    $isAuditorExterno = $fn->isAuditorExterno($user_email, $id);
    //fiscal do contrato
    $isFiscalContrato = getVariavelSessao('isFiscalContratoCliente');
    //fiscal no nivel de empresa
    $isFiscalContratoEmpresa = getVariavelSessao('isFiscalContratoEmpresa');
    //fiscal contrato cliente
    $isFiscalContratoFornecedor = getVariavelSessao('isFiscalContratoFornecedor');
    //financeiro
    $isFinanceiro = getVariavelSessao('isFinanceiro');
    //instancia a clase cliente para verificar contagens de fornecedores e acesso do fiscal de contrato
    //o fiscal de contrato deve visualizar as contagens de fornecedores tambem
    $consultaContagem = $fn->getContagem($id, $idAbrangencia);
    //verifica se existe a contagem com o id passado
    $isContagemAutorizada = isset($consultaContagem['CNT_id']);
    //confere antes de prosseguir
    if ($isContagemAutorizada) {
        //verifica a abgrangencia e pesquisa fiscal de contrato (cliente)
        if ($consultaContagem['CNT_id_abrangencia'] != 3 && $consultaContagem['CNT_id_abrangencia'] != 4) {
            //para contagens de baseline isso nao existe, cliente, fornecedor, etc.
            //pega o id do cliente na tabela contagem e depois no users_empresa
            $idClienteContagem = $fn->getIdCliente($id)['id_cliente'];
            //para as coisas do fiscal de contrato nao ha como pegar o cliente e o fornecedor, porque nao existe
            $idClienteFiscalContrato = $user->getIdClienteFiscalContrato($userId);
            $acessoFiscalContrato = $cl->getAcessoFiscalContrato($consultaContagem['CNT_id_empresa'], $consultaContagem['CNT_id_fornecedor']);
        }
    }
    /*
     * verifica se eh um fornecedor
     */
    $isFornecedor = isFornecedor();
    $tipoFornecedor = 0;
    $idCliente = $consultaContagem['CNT_id_cliente'];
    /*
     * verifica apenas se eh uma turma, o id_cliente eh original da contagem
     */
    if ($isFornecedor && $isContagemAutorizada) {
        $fornecedor = new Fornecedor();
        $tipoFornecedor = $fornecedor->getTipo(getIdFornecedor());
    }
    /*
     * continua com os testes
     */
    if (!$tipoFornecedor && $isContagemAutorizada) {
        if ($isDiretor || $isGestor || $isGerenteConta || $isViewer || $isResponsavel || $isGerenteProjeto || $isFiscalContratoEmpresa) {
            $pass = true;
        } elseif ($isAuditorInterno || $isAuditorExterno || $isValidadorExterno || $isValidadorInterno || $isAutorizado) {
            $pass = true;
        } elseif (($isPerfilAnalistaMetricas && !$privacidade) || $isAutorizado) {
            if ($isContagemFornecedor && $isVisualizarContagemFornecedor || $isFiscalContratoFornecedor) {
                $pass = true;
            } elseif (!$isContagemFornecedor && !$privacidade) {
                $pass = true;
            } elseif ($isAutorizado) {
                $pass = true;
            }
        } elseif (($isFiscalContrato || $isFinanceiro) && $idClienteContagem == $idClienteFiscalContrato) {
            $pass = true;
        } elseif ($consultaContagem['CNT_id_fornecedor'] && $acessoFiscalContrato['id'] == $consultaContagem['CNT_id_cliente']) {
            $pass = true;
        }
    } else {
        $pass = false;
    }
    /*
     * verifica se existe um relatorio personalizado
     */
    $arquivo = DIR_APP
            . 'actions'
            . DIRECTORY_SEPARATOR
            . 'relatorios'
            . DIRECTORY_SEPARATOR
            . 'personalizados'
            . DIRECTORY_SEPARATOR
            . sha1($idEmpresa)
            . DIRECTORY_SEPARATOR
            . sha1($idCliente)
            . DIRECTORY_SEPARATOR
            . sha1($idCliente) . '_0_xlsx.php';
    $relatorioPersonalizado = file_exists($arquivo);
    /*
     * inclui a consulta inicial e verifica em todos os casos
     */
    include(DIR_BASE . 'actions/relatorios/consulta_inicial.php');
    /*
     * verifica autorizacao para a empresa e para o fornecedor
     */
    if ($idEmpresa != $consultaContagem['CNT_id_empresa']) {
        /*
         * pagina com o sumario da contagem
         */
        include(DIR_BASE . 'actions/relatorios/nao_autorizado.php');
        exit;
    }
    if ($isFornecedor) {
        if ($idFornecedor != $consultaContagem['CNT_id_fornecedor']) {
            /*
             * pagina com o sumario da contagem
             */
            include(DIR_BASE . 'actions/relatorios/nao_autorizado.php');
            exit;
        }
    }
    /*
     * verifica o acesso
     */
    if ($pass && $relatorioPersonalizado) {
        include($arquivo);
    } elseif ($pass) {
        /**
         * PHPExcel
         *
         * Copyright (C) 2006 - 2014 PHPExcel
         *
         * This library is free software; you can redistribute it and/or
         * modify it under the terms of the GNU Lesser General Public
         * License as published by the Free Software Foundation; either
         * version 2.1 of the License, or (at your option) any later version.
         *
         * This library is distributed in the hope that it will be useful,
         * but WITHOUT ANY WARRANTY; without even the implied warranty of
         * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
         * Lesser General Public License for more details.
         *
         * You should have received a copy of the GNU Lesser General Public
         * License along with this library; if not, write to the Free Software
         * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
         *
         * @category   PHPExcel
         * @package    PHPExcel
         * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
         * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
         * @version    1.8.0, 2014-03-02
         */
        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        if (PHP_SAPI == 'cli') {
            die('Este relatorio so pode ser emitido pela WEB');
        }
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Dimension - Metricas")
                ->setLastModifiedBy(getUserName())
                ->setTitle("Planilha de medicao")
                ->setSubject("Planilha de medicao")
                ->setDescription("Relatório de medicao de APF - XLS")
                ->setKeywords("planilha medicao metrica apf apt")
                ->setCategory("Planilha");

        /*
         * set a planilha (0) como ativa
         */
        $objPHPExcel->setActiveSheetIndex(0);
        /*
         * array com as colunas do primeiro merge
         */
        $column = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T');
        foreach ($column as $col) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(false)->setWidth(6);
        }
        /*
         * set a altura para auto na planilha como um todo
         */
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
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
         * array de sombreamento cinza
         */
        $colorStyleZebra = array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'F0F0F0')
            )
        );
        /*
         * seta a fonte da planilha como um todo
         */
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Liberation Sans Narrow')->setSize(11);
        /*
         * informacoes contratuais
         */
        $objPHPExcel->getActiveSheet()->mergeCells('A1:T3')->setCellValue('A1', 'Informações contratuais');
        $objPHPExcel->getActiveSheet()->getStyle('A1:T3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:T3')->getFont()->setBold(true)->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('A1:T3')->applyFromArray($colorStyle);
        $objPHPExcel->getActiveSheet()->getStyle('A1:T3')->applyFromArray($borderStyle);

        $objPHPExcel->getActiveSheet()->mergeCells('A4:D4')->setCellValue('A4', 'Cliente')->getStyle('A4:D4')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->mergeCells('E4:K4')->setCellValue('E4', $consultaContagem['CLI_descricao'])->getStyle('E4:K4')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->getStyle('E4:K4')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->mergeCells('L4:O4')->setCellValue('L4', 'Entregas')->getStyle('L4:O4')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->mergeCells('P4:T4')->setCellValue('P4', $consultaContagem['CNT_entregas'])->getStyle('P4:T4')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->getStyle('P4:T4')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->mergeCells('A5:D5')->setCellValue('A5', 'Contrato')->getStyle('A5:D5')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->mergeCells('E5:K5')->setCellValue('E5', $consultaContagem['CON_numero'] . '/' . $consultaContagem['CON_ano'])->getStyle('E5:K5')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->getStyle('E5:K5')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->mergeCells('L5:O5')->setCellValue('L5', 'Valor PF')->getStyle('L5:O5')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->mergeCells('P5:T5')->setCellValue('P5', ( isPermitido('visualizar_valor_pf') ? number_format($consultaContagem['CON_valor_pf'], 2, ",", ".") : '-'))->getStyle('P5:T5')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->getStyle('P5:P5')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->mergeCells('A6:D6')->setCellValue('A6', 'Projeto')->getStyle('A6:D6')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->mergeCells('E6:K6')->setCellValue('E6', $consultaContagem['PRJ_descricao'])->getStyle('E6:K6')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->getStyle('E6:K6')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->mergeCells('L6:O6')->setCellValue('L6', 'Demanda')->getStyle('L6:O6')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->mergeCells('P6:T6')->setCellValue('P6', $consultaContagem['CNT_ordem_servico'])->getStyle('P6:T6')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->getStyle('P6:P6')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->mergeCells('A7:D7')->setCellValue('A7', 'Responsável')->getStyle('A7:D7')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->mergeCells('E7:K7')->setCellValue('E7', $usuario['user_complete_name'])->getStyle('E7:K7')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->getStyle('E7:K7')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->mergeCells('L7:O7')->setCellValue('L7', 'Criação')->getStyle('L7:O7')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->mergeCells('P7:T7')->setCellValue('P7', date_format(date_create($consultaContagem['CNT_data_cadastro']), 'd/m/Y H:i:s'))->getStyle('P7:T7')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->getStyle('P7:T7')->getFont()->setBold(true);
        /*
         * informacoes basicas da contagem
         */
        $objPHPExcel->getActiveSheet()->mergeCells('A8:T10')->setCellValue('A8', 'Informações básicas da contagem');
        $objPHPExcel->getActiveSheet()->getStyle('A8:T10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A8:T10')->getFont()->setBold(true)->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('A8:T10')->applyFromArray($colorStyle);
        $objPHPExcel->getActiveSheet()->getStyle('A8:T10')->applyFromArray($borderStyle);

        $objPHPExcel->getActiveSheet()->mergeCells('A11:D11')->setCellValue('A11', 'Linguagem')->getStyle('A11:D11')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->mergeCells('E11:T11')->setCellValue('E11', html_entity_decode($consultaContagem['LNG_descricao']) . ' - '
                . str_replace(array('baixa', 'media', 'alta'), array('Baixa', 'Média', 'Alta'), $estatisticas['escala_produtividade'])
                . ' Hh/PF => '
                . number_format(($estatisticas['escala_produtividade'] === 'baixa' ?
                                $estatisticas['produtividade_baixa'] : ( $estatisticas ['escala_produtividade'] === 'media' ?
                                        $estatisticas['produtividade_media'] : $estatisticas['produtividade_alta'])), 2, ",", ".")
                . ' (B: ' . number_format($estatisticas['produtividade_baixa'], 2, ",", ".")
                . ' M: ' . number_format($estatisticas['produtividade_media'], 2, ",", ".")
                . ' A: ' . number_format($estatisticas['produtividade_alta'], 2, ",", ".") . ')')->getStyle('E11:T11')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->getStyle('E11:T11')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->mergeCells('A12:D12')->setCellValue('A12', 'Tipo')->getStyle('A12:D12')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->mergeCells('E12:T12')->setCellValue('E12', $consultaContagem['TPO_descricao'])->getStyle('E12:T12')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->getStyle('E12:T12')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->mergeCells('A13:D13')->setCellValue('A13', 'Etapa')->getStyle('A13:D13')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->mergeCells('E13:T13')->setCellValue('E13', $consultaContagem['ETP_descricao'])->getStyle('E13:T13')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->getStyle('E13:T13')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->mergeCells('A14:D14')->setCellValue('A14', 'Processo')->getStyle('A14:D14')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->mergeCells('E14:T14')->setCellValue('E14', $consultaContagem['PRD_descricao'])->getStyle('E14:T14')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->getStyle('E14:T14')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->mergeCells('A15:D15')->setCellValue('A15', 'Gestão')->getStyle('A15:D15')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->mergeCells('E15:T15')->setCellValue('E15', $consultaContagem['PRG_descricao'])->getStyle('E15:T15')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->getStyle('E15:T15')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->mergeCells('A16:D16')->setCellValue('A16', 'Segmento')->getStyle('A16:D16')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->mergeCells('E16:T16')->setCellValue('E16', $consultaContagem['IND_descricao'])->getStyle('E16:T16')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->getStyle('E16:T16')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->mergeCells('A17:D17')->setCellValue('A17', 'SGBD')->getStyle('A17:D17')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->mergeCells('E17:T17')->setCellValue('E17', $consultaContagem['BDO_descricao'])->getStyle('E17:T17')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->getStyle('E17:T17')->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->mergeCells('A18:D18')->setCellValue('A18', 'Abrangência')->getStyle('A18:D18')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->mergeCells('E18:T18')->setCellValue('E18', ucfirst($consultaContagem['ABR_descricao']))->getStyle('E18:T18')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->getStyle('E18:T18')->getFont()->setBold(true);
        /*
         * proposito da contagem
         */
        $objPHPExcel->getActiveSheet()->mergeCells('A19:T21')->setCellValue('A19', 'Propósito da contagem');
        $objPHPExcel->getActiveSheet()->getStyle('A19:T21')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A19:T21')->getFont()->setBold(true)->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('A19:T21')->applyFromArray($colorStyle);
        $objPHPExcel->getActiveSheet()->getStyle('A19:T21')->applyFromArray($borderStyle);

        $objPHPExcel->getActiveSheet()->mergeCells('A22:T29')->setCellValue('A22', $consultaContagem['CNT_proposito'])->getStyle('A22:T29')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->getStyle('A22:T29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        /*
         * escopo da contagem
         */
        $objPHPExcel->getActiveSheet()->mergeCells('A30:T32')->setCellValue('A30', 'Escopo da contagem');
        $objPHPExcel->getActiveSheet()->getStyle('A30:T32')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A30:T32')->getFont()->setBold(true)->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('A30:T32')->applyFromArray($colorStyle);
        $objPHPExcel->getActiveSheet()->getStyle('A30:T32')->applyFromArray($borderStyle);

        $objPHPExcel->getActiveSheet()->mergeCells('A33:T40')->setCellValue('A33', $consultaContagem['CNT_escopo'])->getStyle('A33:T40')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->getStyle('A33:T40')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        /*
         * inserindo uma imagem apena para contagens nao Baseline e Licitacao
         */
        if ($idAbrangencia != 3 && $idAbrangencia != 4) {
            $logomarca = DIR_BASE . 'vendor/cropper/producao/crop/img/' . (isFornecedor() ? 'img-forn/' : 'img-emp/') . sha1(isFornecedor() ? getIdFornecedor() : getIdEmpresa() ) . '.png';
            $logomarcaCliente = DIR_BASE . 'vendor/cropper/producao/crop/img/img-cli/' . sha1(isFornecedor() ? getIdClienteFornecedor() : $consultaContagem['CNT_id_cliente']) . '.png';
            /*
             * criando a imagem
             */
            if (file_exists($logomarcaCliente)) {
                $imgCliente = imagecreatefrompng($logomarcaCliente);
                /*
                 * cria um objeto de imagem na planilha
                 */
                $objImg = new PHPExcel_Worksheet_MemoryDrawing();
                /*
                 * insere os parametros da imagem
                 */
                $objImg->setImageResource($imgCliente)
                        ->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG)
                        ->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT)
                        ->setHeight(50)
                        ->setWidth(50)
                        ->setCoordinates('A1')
                        ->setWorksheet($objPHPExcel->getActiveSheet());
            }
        }
        /*
         * renomeia a primeira planilha para CONTAGEM
         */
        $objPHPExcel->getActiveSheet()->setTitle('CONTAGEM');
        /*
         * planilha de com as funcoes da contagem
         */
        $objPHPExcel->createSheet(1);
        $objPHPExcel->setActiveSheetIndex(1);
        /*
         * array com as colunas do primeiro merge
         */
        $column1 = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T');
        foreach ($column1 as $col) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(false)->setWidth(9);
        }
        /*
         * set a altura para auto na planilha como um todo
         */
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        /*
         * seta a fonte da planilha como um todo
         */
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Liberation Sans Narrow')->setSize(11);
        /*
         * renomeia a planilha para FUNCOES
         */
        $objPHPExcel->getActiveSheet()->setTitle('FUNCOES');
        /*
         * loop para inserir linha a linha as funcoes
         */
        $row = 6;
        $lineColor = false;
        /*
         * primeira linha de identificacao da planilha de contagem
         */
        $objPHPExcel->getActiveSheet()->mergeCells('A1:T3')->setCellValue('A1', 'Planilha de contagem de ponto de função');
        $objPHPExcel->getActiveSheet()->getStyle('A1:T3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:T3')->getFont()->setBold(true)->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('A1:T3')->applyFromArray($colorStyle);
        $objPHPExcel->getActiveSheet()->getStyle('A1:T3')->applyFromArray($borderStyle);
        /*
         * escreve o cabecalho
         */
        $objPHPExcel->getActiveSheet()->mergeCells('A4:F5')->setCellValue('A4', 'Função');
        $objPHPExcel->getActiveSheet()->mergeCells('G4:G5')->setCellValue('G4', 'Tipo');
        $objPHPExcel->getActiveSheet()->mergeCells('H4:H5')->setCellValue('H4', 'I/A/E');
        $objPHPExcel->getActiveSheet()->mergeCells('I4:I5')->setCellValue('I4', 'TD');
        $objPHPExcel->getActiveSheet()->mergeCells('J4:J5')->setCellValue('J4', 'AR/TR');
        $objPHPExcel->getActiveSheet()->mergeCells('K4:K5')->setCellValue('K4', 'Complex.');
        $objPHPExcel->getActiveSheet()->mergeCells('L4:L5')->setCellValue('L4', 'PFb');
        $objPHPExcel->getActiveSheet()->mergeCells('M4:M5')->setCellValue('M4', 'PFa');
        $objPHPExcel->getActiveSheet()->mergeCells('N4:S5')->setCellValue('N4', 'Observações');
        $objPHPExcel->getActiveSheet()->mergeCells('T4:T5')->setCellValue('T4', 'Mt.');
        /*
         * formatacao das celulas do cabecalho
         */
        $objPHPExcel->getActiveSheet()->getStyle('A4:T5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A4:T5')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->getStyle('A4:T5')->applyFromArray($colorStyle);
        $objPHPExcel->getActiveSheet()->getStyle('A4:T5')->getFont()->setBold(true)->setSize(11);
        /*
         * loop das linhas
         */
        for ($x = 0; $x < count($linhas); $x ++) {
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $row . ':F' . $row)
                    ->setCellValue('A' . $row, $linhas[$x]['funcao'] . "\n" .
                            ($linhas[$x]['tipo'] === 'ALI' || $linhas[$x]['tipo'] === 'AIE' ?
                                    "TDs: " . str_replace(',', ', ', $linhas[$x]['descricao_td']) . "\n"
                                    . "TRs: " . str_replace(',', ', ', $linhas[$x]['descricao_tr']) . "\n" :
                                    ($linhas[$x]['tipo'] !== 'OU' ?
                                            "TDs: " . str_replace(',', ', ', $linhas[$x]['descricao_td']) . "\n"
                                            . "ARs: " . str_replace(',', ', ', $linhas[$x]['descricao_tr']) . "\n" : "")
                    ));
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $linhas[$x]['tipo']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $linhas[$x]['operacao']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $linhas[$x]['td']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $linhas[$x]['tr']);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $linhas[$x]['complexidade']);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $linhas[$x]['pfb']);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $linhas[$x]['pfa']);
            /*
             * observacoes
             */
            $objPHPExcel
                    ->getActiveSheet()
                    ->mergeCells('N' . $row . ':S' . $row)
                    ->setCellValue('N' . $row, str_replace("<br />", "\n", (NULL === $linhas[$x]['obs_funcao'] ? '' : $linhas[$x]['obs_funcao'] . "\n")
                                    . $linhas[$x]['f_sigla'] . '<br />' . $linhas[$x] ['fonte']
                                    . ( $linhas [$x]['is_mudanca'] ?
                                            "\nRetrabalho: "
                                            . $linhas[$x]['fase_mudanca'] . ' - '
                                            . $linhas[$x]['percentual_fase'] . '%' : '')
                                    . ($linhas[$x]['fd'] ? '&nbsp;&nbsp;FD:' . number_format($linhas[$x]['fd'], 2, ",", ".") : '')));

            $objPHPExcel->getActiveSheet()->setCellValue('T' . $row, $linhas[$x]['m_sigla']);
            /*
             * alinhamentos, bordas e outras formatacoes
             */
            $objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':T' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':T' . $row)->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':T' . $row)->applyFromArray($borderStyle);
            /*
             * coloca a zebra nas linhas
             */
            $lineColor ? $objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':T' . $row)->applyFromArray($colorStyleZebra) : NULL;
            $lineColor = $lineColor ? false : true;
            /*
             * incrementa uma linha
             */
            $row += 1;
        }
        /*
         * inserindo uma imagem apena para contagens nao Baseline e Licitacao
         */
        if ($idAbrangencia != 3 && $idAbrangencia != 4) {
            $logomarca = DIR_BASE . 'vendor/cropper/producao/crop/img/' . (isFornecedor() ? 'img-forn/' : 'img-emp/') . sha1(isFornecedor() ? getIdFornecedor() : getIdEmpresa()) . '.png';
            $logomarcaCliente = DIR_BASE . 'vendor/cropper/producao/crop/img/img-cli/' . sha1(isFornecedor() ? getIdClienteFornecedor() : $consultaContagem['CNT_id_cliente'] ) . '.png';
            if (file_exists($logomarcaCliente)) {
                /*
                 * criando a imagem
                 */
                $imgCliente = imagecreatefrompng($logomarcaCliente);
                /*
                 * cria um objeto de imagem na planilha
                 */
                $objImg = new PHPExcel_Worksheet_MemoryDrawing();
                /*
                 * insere os parametros da imagem
                 */
                $objImg->setImageResource($imgCliente)
                        ->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG)
                        ->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT)
                        ->setHeight(50)
                        ->setWidth(50)
                        ->setCoordinates('A1')
                        ->setWorksheet($objPHPExcel->getActiveSheet());
            }
        }
        /*
         * planilha de com o sumario da contagem
         */
        $objPHPExcel->createSheet(2);
        $objPHPExcel->setActiveSheetIndex(2);
        /*
         * array com as colunas do primeiro merge
         */
        $column2 = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T');
        foreach ($column2 as $col) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(false)->setWidth(5);
        }
        /*
         * set a altura para auto na planilha como um todo
         */
        $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        /*
         * seta a fonte da planilha como um todo
         */
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setName('Liberation Sans Narrow')->setSize(11);
        /*
         * renomeia a planilha para FUNCOES
         */
        $objPHPExcel->getActiveSheet()->setTitle('SUMARIO');
        /*
         * primeira linha de identificacao da planilha de contagem
         */
        $objPHPExcel->getActiveSheet()->mergeCells('A1:T3')->setCellValue('A1', 'Sumário da contagem');
        $objPHPExcel->getActiveSheet()->getStyle('A1:T3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:T3')->getFont()->setBold(true)->setSize(14);
        $objPHPExcel->getActiveSheet()->getStyle('A1:T3')->applyFromArray($colorStyle);
        $objPHPExcel->getActiveSheet()->getStyle('A1:T3')->applyFromArray($borderStyle);
        /*
         * escreve o cabecalho
         */
        $objPHPExcel->getActiveSheet()->mergeCells('A4:J5')->setCellValue('A4', 'Função');
        $objPHPExcel->getActiveSheet()->mergeCells('K4:K5')->setCellValue('K4', 'QTD');
        $objPHPExcel->getActiveSheet()->mergeCells('L4:N5')->setCellValue('L4', 'Complexidade');
        $objPHPExcel->getActiveSheet()->mergeCells('O4:Q5')->setCellValue('O4', 'Total (PFb)');
        $objPHPExcel->getActiveSheet()->mergeCells('R4:T5')->setCellValue('R4', 'Total (PFa)');
        /*
         * formatacao das celulas do cabecalho
         */
        $objPHPExcel->getActiveSheet()->getStyle('A4:T5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A4:T5')->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->getStyle('A4:T5')->applyFromArray($colorStyle);
        $objPHPExcel->getActiveSheet()->getStyle('A4:T5')->getFont()->setBold(true)->setSize(11);
        /*
         * escreve as funcoes em suas devidas posicoes
         */
        $row = 6;
        for ($z = 0; $z < count($aFuncoes); $z++) {
            /*
             * escreve em separado de Elementos Funcionais
             */
            $objPHPExcel->getActiveSheet()->mergeCells('A' . $row . ':J' . ($row + 2))->setCellValue('A' . $row, $aFuncoes[$z]['sigla'] . ' - ' . $aFuncoes[$z]['descricao']);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, ($idAbrangencia == 9 ? $statsQTD['qtd' . $aFuncoes[$z]['sigla']] : $statsSumario[$aFuncoes[$z]['sigla']]['b' . $aFuncoes[$z]['sigla']]));
            $objPHPExcel->getActiveSheet()->mergeCells('L' . $row . ':N' . $row)->setCellValue('L' . $row, ($idAbrangencia == 9 ? $aFuncoes[$z]['EF'] : 'Baixa ' . $aFuncoes[$z]['baixa']));
            $objPHPExcel->getActiveSheet()->mergeCells('O' . $row . ':Q' . $row)->setCellValue('O' . $row, ($idAbrangencia == 9 ? number_format($statsPFB['pfb' . $aFuncoes[$z]['sigla']], 3, ",", ".") : number_format($statsSumario[$aFuncoes[$z]['sigla']]['totalB' . $aFuncoes[$z]['sigla'] . 'PFb'], 3, ",", ".")));
            $objPHPExcel->getActiveSheet()->mergeCells('R' . $row . ':T' . $row)->setCellValue('R' . $row, ($idAbrangencia == 9 ? number_format($statsPFA['pfa' . $aFuncoes[$z]['sigla']], 3, ",", ".") : number_format($statsSumario[$aFuncoes[$z]['sigla']]['totalB' . $aFuncoes[$z]['sigla'] . 'PFa'], 3, ",", ".")));
            /*
             * media
             */
            $objPHPExcel->getActiveSheet()->setCellValue('K' . ($row + 1), ($idAbrangencia == 9 ? '-' : $statsSumario[$aFuncoes[$z]['sigla']]['m' . $aFuncoes[$z]['sigla']]));
            $objPHPExcel->getActiveSheet()->mergeCells('L' . ($row + 1) . ':N' . ($row + 1))->setCellValue('L' . ($row + 1), ($idAbrangencia == 9 ? '-' : 'Média ' . $aFuncoes[$z]['media']));
            $objPHPExcel->getActiveSheet()->mergeCells('O' . ($row + 1) . ':Q' . ($row + 1))->setCellValue('O' . ($row + 1), ($idAbrangencia == 9 ? '-' : number_format($statsSumario[$aFuncoes[$z]['sigla']]['totalM' . $aFuncoes[$z]['sigla'] . 'PFb'], 3, ",", ".")));
            $objPHPExcel->getActiveSheet()->mergeCells('R' . ($row + 1) . ':T' . ($row + 1))->setCellValue('R' . ($row + 1), ($idAbrangencia == 9 ? '-' : number_format($statsSumario[$aFuncoes[$z]['sigla']]['totalM' . $aFuncoes[$z]['sigla'] . 'PFa'], 3, ",", ".")));
            /*
             * alta
             */
            $objPHPExcel->getActiveSheet()->setCellValue('K' . ($row + 2), ($idAbrangencia == 9 ? '-' : $statsSumario[$aFuncoes[$z]['sigla']]['a' . $aFuncoes[$z]['sigla']]));
            $objPHPExcel->getActiveSheet()->mergeCells('L' . ($row + 2) . ':N' . ($row + 2))->setCellValue('L' . ($row + 2), ($idAbrangencia == 9 ? '-' : 'Alta ' . $aFuncoes[$z]['alta']));
            $objPHPExcel->getActiveSheet()->mergeCells('O' . ($row + 2) . ':Q' . ($row + 2))->setCellValue('O' . ($row + 2), ($idAbrangencia == 9 ? '-' : number_format($statsSumario[$aFuncoes[$z]['sigla']]['totalA' . $aFuncoes[$z]['sigla'] . 'PFb'], 3, ",", ".")));
            $objPHPExcel->getActiveSheet()->mergeCells('R' . ($row + 2) . ':T' . ($row + 2))->setCellValue('R' . ($row + 2), ($idAbrangencia == 9 ? '-' : number_format($statsSumario[$aFuncoes[$z]['sigla']]['totalA' . $aFuncoes[$z]['sigla'] . 'PFa'], 3, ",", ".")));
            /*
             * totalizadores
             */
            $objPHPExcel->getActiveSheet()->mergeCells('A' . ($row + 3) . ':J' . ($row + 3))->setCellValue('A' . ($row + 3), 'Total');
            $objPHPExcel->getActiveSheet()->setCellValue('K' . ($row + 3), $statsQTD['qtd' . $aFuncoes[$z]['sigla']]);
            $objPHPExcel->getActiveSheet()->mergeCells('L' . ($row + 3) . ':N' . ($row + 3))->setCellValue('L' . ($row + 3), '');
            $objPHPExcel->getActiveSheet()->mergeCells('O' . ($row + 3) . ':Q' . ($row + 3))->setCellValue('O' . ($row + 3), number_format($statsPFB['pfb' . $aFuncoes[$z]['sigla']], 3, ",", "."));
            $objPHPExcel->getActiveSheet()->mergeCells('R' . ($row + 3) . ':T' . ($row + 3))->setCellValue('R' . ($row + 3), number_format($statsPFA['pfa' . $aFuncoes[$z]['sigla']], 3, ",", "."));
            /*
             * formatacao dos totalizadores
             */
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($row + 3) . ':T' . ($row + 3))->applyFromArray($colorStyle);
            /*
             * alinhamentos, bordas e outras formatacoes
             */
            $objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':T' . ($row + 3))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':T' . ($row + 3))->getAlignment()->setWrapText(true);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':T' . ($row + 3))->applyFromArray($borderStyle);
            /*
             * incrementa a linha
             */
            $row += 4;
        }
        /*
         * incrementa para separar
         */
        $row += 1;
        /*
         * outras funcionalidades
         */
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $row . ':Q' . $row)->setCellValue('A' . $row, 'OU - Outras Funcionalidades');
        $objPHPExcel->getActiveSheet()->mergeCells('R' . $row . ':T' . $row)->setCellValue('R' . $row, number_format($statsSumario['OU']['totalOU'], 3, ",", "."));
        /*
         * formatacao dos totalizadores
         */
        $objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':T' . $row)->applyFromArray($colorStyle)->applyFromArray($borderStyle);
        /*
         * incrementa para a proxima tabela
         */
        $row += 2;
        /*
         * operacoes
         */
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $row . ':N' . ($row + 1))->setCellValue('A' . $row, 'Operação');
        $objPHPExcel->getActiveSheet()->mergeCells('O' . $row . ':Q' . ($row + 1))->setCellValue('O' . $row, 'Total (PFb)');
        $objPHPExcel->getActiveSheet()->mergeCells('R' . $row . ':T' . ($row + 1))->setCellValue('R' . $row, 'Total (PFa)');
        /*
         * formatacao das celulas do cabecalho
         */
        $objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':T' . ($row + 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':T' . ($row + 1))->applyFromArray($borderStyle);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':T' . ($row + 1))->applyFromArray($colorStyle);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $row . ':T' . ($row + 1))->getFont()->setBold(true)->setSize(11);
        /*
         * acrescenta uma linha
         */
        $row += 2;
        /*
         * linhas
         */
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $row . ':N' . $row)->setCellValue('A' . $row, 'Inclusão');
        $objPHPExcel->getActiveSheet()->mergeCells('O' . $row . ':Q' . $row)->setCellValue('O' . $row, number_format($statsOPR['IPFb'], 3, ",", "."));
        $objPHPExcel->getActiveSheet()->mergeCells('R' . $row . ':T' . $row)->setCellValue('R' . $row, number_format($statsOPR['IPFa'], 3, ",", "."));
        /*
         * acrescenta uma linha
         */
        $row += 1;
        /*
         * linhas
         */
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $row . ':N' . $row)->setCellValue('A' . $row, 'Alteração');
        $objPHPExcel->getActiveSheet()->mergeCells('O' . $row . ':Q' . $row)->setCellValue('O' . $row, number_format($statsOPR['APFb'], 3, ",", "."));
        $objPHPExcel->getActiveSheet()->mergeCells('R' . $row . ':T' . $row)->setCellValue('R' . $row, number_format($statsOPR['APFa'], 3, ",", ".")
                . ($statsOPR['RAPFa'] ?
                        "\nRetrabalho: " . number_format($statsOPR['RAPFa'], 3, ",", ".") . '(' . number_format($statsOPR['RAPFa'] / $statsOPR['APFa'] * 100, 2, ",", ".") . '%)' : ''));
        /*
         * acrescenta uma linha
         */
        $row += 1;
        /*
         * linhas
         */
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $row . ':N' . $row)->setCellValue('A' . $row, 'Exclusão');
        $objPHPExcel->getActiveSheet()->mergeCells('O' . $row . ':Q' . $row)->setCellValue('O' . $row, number_format($statsOPR['EPFb'], 3, ",", "."));
        $objPHPExcel->getActiveSheet()->mergeCells('R' . $row . ':T' . $row)->setCellValue('R' . $row, number_format($statsOPR['EPFa'], 3, ",", ".")
                . ($statsOPR['REPFa'] ?
                        "\nRetrabalho: " . number_format($statsOPR['REPFa'], 3, ",", ".") . '(' . number_format($statsOPR['REPFa'] / $statsOPR['EPFa'] * 100, 2, ",", ".") . '%)' : ''));
        /*
         * acrescenta uma linha
         */
        $row += 1;
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $row . ':N' . $row)->setCellValue('A' . $row, 'Testes');
        $objPHPExcel->getActiveSheet()->mergeCells('O' . $row . ':Q' . $row)->setCellValue('O' . $row, number_format($statsOPR['TPFb'], 3, ",", "."));
        $objPHPExcel->getActiveSheet()->mergeCells('R' . $row . ':T' . $row)->setCellValue('R' . $row, number_format($statsOPR['TPFa'], 3, ",", "."));
        /*
         * alinhamentos, bordas e outras formatacoes
         */
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($row - 3) . ':T' . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT)->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($row - 3) . ':T' . $row)->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('A' . ($row - 3) . ':T' . $row)->applyFromArray($borderStyle);
        /*
         * insere uma imagem para contagens que nao sao licitacao/baseline
         */
        if ($idAbrangencia != 3 && $idAbrangencia != 4) {
            $logomarca = DIR_BASE . 'vendor/cropper/producao/crop/img/' . (isFornecedor() ? 'img-forn/' : 'img-emp/') . sha1(isFornecedor() ? getIdFornecedor() : getIdEmpresa()) . '.png';
            $logomarcaCliente = DIR_BASE . 'vendor/cropper/producao/crop/img/img-cli/' . sha1(isFornecedor() ? getIdClienteFornecedor() : $consultaContagem['CNT_id_cliente']) . '.png';
            if (file_exists($logomarcaCliente)) {
                /*
                 * criando a imagem
                 */
                $imgCliente = imagecreatefrompng($logomarcaCliente);
                /*
                 * cria um objeto de imagem na planilha
                 */
                $objImg = new PHPExcel_Worksheet_MemoryDrawing();
                /*
                 * insere os parametros da imagem
                 */
                $objImg->setImageResource($imgCliente)
                        ->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_PNG)
                        ->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT)
                        ->setHeight(50)
                        ->setWidth(50)
                        ->setCoordinates('A1')
                        ->setWorksheet($objPHPExcel->getActiveSheet());
            }
        }
        /*
         * Set active sheet index to the first sheet, so Excel opens this as the first sheet
         */
        $objPHPExcel->setActiveSheetIndex(0);
        /*
         * Redirect output to a client's web browser, depends on type
         */
        if ($tipo === 'xls') {
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Relatorio.' . date('YmdHis') . '.xls"');
            header('Cache-Control: max-age=0');
            /*
             * If you're serving to IE 9, then the following may be needed
             */
            header('Cache-Control: max-age=1');
            /*
             * If you're serving to IE over SSL, then the following may be needed
             */
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            /*
             * cria o oBjeto da planilha e joga pra tela
             */
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        } elseif ($tipo === 'ods') {
            /*
             * Redirect output to a client’s web browser (OpenDocument)
             */
            header('Content-Type: application/vnd.oasis.opendocument.spreadsheet');
            header('Content-Disposition: attachment;filename="Relatorio.' . date('YmdHis') . '.ods"');
            header('Cache-Control: max-age=0');
            /*
             * If you're serving to IE 9, then the following may be needed
             */
            header('Cache-Control: max-age=1');
            /*
             * If you're serving to IE over SSL, then the following may be needed
             */
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'OpenDocument');
            $objWriter->save('php://output');
            exit;
        } elseif ($tipo === 'xlsx') {
            /*
             * Redirect output to a client’s web browser (Excel2007)
             */
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Relatorio.' . date('YmdHis') . '.xlsx"');
            header('Cache-Control: max-age=0');
            /*
             * If you're serving to IE 9, then the following may be needed
             */
            header('Cache-Control: max-age=1');
            /*
             * If you're serving to IE over SSL, then the following may be needed
             */
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->save('php://output');
        }
    } else {
        /*
         * pagina acesso nao autorizado para os relatorios
         */
        include(DIR_BASE . 'actions/relatorios/nao_autorizado.php');
    }
} else {
    /*
     * pagina com o sumario da contagem
     */
    require_once (DIR_BASE . 'actions/relatorios/nao_autorizado.php');
}