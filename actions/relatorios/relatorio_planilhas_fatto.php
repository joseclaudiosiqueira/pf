<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
//verificacao do status do login e do id
$arrTipo = array('xls', 'ods', 'xlsx', 'ifpug', 'fatto');
//pega o id
$id = NULL !== filter_input(INPUT_GET, 'i', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_GET, 'i', FILTER_SANITIZE_NUMBER_INT) : false;
//verifica se esta logado e o id e valido
$tipo = NULL !== filter_input(INPUT_GET, 't', FILTER_SANITIZE_STRING) ? filter_input(INPUT_GET, 't', FILTER_SANITIZE_STRING) : 0;
//verifica se o tipo eh valido
$inTipo = in_array_r($tipo, $arrTipo);
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
$ro = new Roteiro();
$dro = $ro->getDescricao(4); //ID FIXO DO ROTEIRO DA FATTO
$ca->setUserEmail($user_email);
//seta id e pega historico da contagem
$ch->setIdContagem($id);
$historico = $ch->getHistorico();
//pega a abrangencia atual para SNAP e outras
$idAbrangencia = $fn->getAbrangencia($id)['id_abrangencia'];
$consultaContagem = $fn->getContagem($id, $idAbrangencia);
//id roteiro que deve ser apenas o 4 (quatro) ... arghhh
$idRoteiro = $consultaContagem['CNT_id_roteiro'];
//verifica a validade das informacoes
if ($login->isUserLoggedIn() &&
        $id &&
        (getConfigPlano('exportar_xls') || getConfigPlano('exportar_xlsx') || getConfigPlano('exportar_ods') &&
        $tipo &&
        $inTipo) && verificaSessao() && $idRoteiro == 4) {
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
     * inclui a consulta inicial e verifica em todos os casos, inclui a folha de estilos
     */
    include(DIR_BASE . 'actions/relatorios/consulta_inicial.php');
    include(DIR_BASE . 'actions/relatorios/personalizados/styles.php');
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
        $objPHPExcel->getProperties()->setCreator("Fatto Consultoria e Sistemas")
                ->setLastModifiedBy(getUserName())
                ->setTitle("Planilha de medição")
                ->setSubject("Planilha de medição")
                ->setDescription("Relatório de medicao de APF - XLS")
                ->setKeywords("planilha medição métrica apf fatto dimension")
                ->setCategory("Planilha");

        /*
         * includes das abas da planilha. Separado para facilitar a leitura
         */
        include(DIR_BASE . 'actions/relatorios/relatorio_planilhas_fatto_1_contagem.php');
        include(DIR_BASE . 'actions/relatorios/relatorio_planilhas_fatto_2_funcoes.php');
        include(DIR_BASE . 'actions/relatorios/relatorio_planilhas_fatto_3_deflatores.php');
        include(DIR_BASE . 'actions/relatorios/relatorio_planilhas_fatto_4_sumario_1.php');
        include(DIR_BASE . 'actions/relatorios/relatorio_planilhas_fatto_4_sumario_2.php');
        include(DIR_BASE . 'actions/relatorios/relatorio_planilhas_fatto_5_log_atividades.php');
        /*
         * ativa a planilha inicial
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
            $objWriter->setIncludeCharts(TRUE);
            $objWriter->save('php://output');
            exit;
        } elseif ($tipo === 'fatto') {
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
            $objWriter->setIncludeCharts(TRUE);
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