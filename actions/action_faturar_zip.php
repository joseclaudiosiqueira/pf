<?php

set_time_limit(0);
/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verificacao do status do login
 */
if ($login->isUserLoggedIn() && verificaSessao()) {
    /*
     * instancia as classes
     */
    $fn = new Contagem();
    $us = new Usuario();
    $cf = new ContagemFaturamentoEmpresa();
    $ct = new Contrato();
    /*
     * informacoes para autorizacao
     */
    $userId = getUserIdDecoded();
    $idEmpresa = getIdEmpresa();
    $idFornecedor = getIdFornecedor();
    $responsavelFaturamento = getEmailUsuarioLogado();
    $isGestor = getVariavelSessao('isGestor');
    $isGestorFornecedor = getVariavelSessao('isGestorFornecedor');
    $isGerenteConta = getVariavelSessao('isGerenteConta');
    $isGerenteContaFornecedor = getVariavelSessao('isGerenteContaFornecedor');
    /*
     * verifica o acesso do usuario
     */
    if (($isGestor || $isGestorFornecedor || $isGerenteConta || $isGerenteContaFornecedor)) {
        /*
         * cria um id_unico para os arquivos baseado em sha1 id_empresa, id_fornecedor
         */
        $idUnicoArquivo = sha1($idEmpresa, $idFornecedor);
        /*
         * seta as variaveis de faturamento para a Contagem()
         */
        $mesAnoFaturamento = $_POST['maf']; //filter_input(INPUT_POST, 'maf');
        $arrFaturar = $_POST['fat']; //filter_input(INPUT_POST, 'fat');
        $arquivo = $idUnicoArquivo . '-faturamento-' . $mesAnoFaturamento;
        $arquivoEmail = DIR_FILE . str_pad(getIdEmpresa(), 11, '0', STR_PAD_LEFT) . DIRECTORY_SEPARATOR . 'faturamento' . DIRECTORY_SEPARATOR . $arquivo . '.zip';
        /*
         * inicia o processo de geracao do arquivo zip
         */
        $zipFile = new ZipArchive();
        /*
         * verifica se o diretorio de faturamento ja esta criado, senao cria um
         */
        !(is_dir(DIR_FILE . str_pad(getIdEmpresa(), 11, '0', STR_PAD_LEFT) . DIRECTORY_SEPARATOR . 'faturamento' . DIRECTORY_SEPARATOR)) ?
                        mkdir(DIR_FILE . str_pad(getIdEmpresa(), 11, '0', STR_PAD_LEFT) . DIRECTORY_SEPARATOR . 'faturamento', 0777, TRUE) : NULL;
        /*
         * cria o arquivo zip dentro do diretorio
         */
        $criar = $zipFile->open($arquivoEmail, ZipArchive::CREATE);
        /*
         * cria o dir base apontando para a empresa
         */
        $dir_base = DIR_FILE . str_pad(getIdEmpresa(), 11, '0', STR_PAD_LEFT);
        /*
         * se foi possivel criar continua executando o zip
         */
        if ($criar) {
            for ($x = 0; $x < count($arrFaturar); $x++) {
                $idContagem = $arrFaturar[$x];
                /*
                 * instancia a classe contagem para colocar os dados em contagemFaturamentoEmpresa
                 */
                $contagem = $fn->consulta($idContagem);
                $pfDados = $fn->totalPFADados($idContagem);
                $pfTransacao = $fn->totalPFATransacao($idContagem);
                $pfOutros = $fn->totalPFAOutros($idContagem);
                /*
                 * totaliza os pfa a pfb
                 */
                $pfa = $pfDados['pfa'] + $pfTransacao['pfa'] + $pfOutros['pfa'];
                $pfb = $pfDados['pfb'] + $pfTransacao['pfb'] + $pfOutros['pfb'];
                /*
                 * verifica o valor do PF do contrato
                 */
                $valorPFContrato = $ct->valorPFContrato($contagem['id_contrato'])['valor_pf'];
                $valorFaturamento = $pfa * $valorPFContrato;
                /*
                 * armazenar as informacoes de faturamento
                 */
                $cf->setIdEmpresa($idEmpresa);
                $cf->setIdFornecedor($idFornecedor);
                $cf->setMesAnoFaturamento($mesAnoFaturamento);
                $cf->setResponsavelFaturamento($responsavelFaturamento);
                $cf->setIdContagem($contagem['id']);
                $cf->setDataCadastroContagem($contagem['data_cadastro']);
                $cf->setIdCliente($contagem['id_cliente']);
                $cf->setIdContrato($contagem['id_contrato']);
                $cf->setIdProjeto($contagem['id_projeto']);
                $cf->setOrdemServico($contagem['ordem_servico']);
                $cf->setResponsavelContagem($contagem['responsavel']);
                $cf->setPfa($pfa);
                $cf->setPfb($pfb);
                $cf->setValorPFCcontrato($valorPFContrato);
                $cf->setIdAbrangencia($contagem['id_abrangencia']);
                $cf->setIdEtapa($contagem['id_etapa']);
                $cf->setValorFaturamento($valorFaturamento);
                $cf->setDataGeracaoFaturamento(date('Y-m-d H:i:s'));
                $cf->insere();
                /*
                 * faz as operacoes de geracao do pdf
                 */
                getFile('CONTAGEM', $mesAnoFaturamento, $login, $idContagem, NULL);
                $zipFile->addFile(DIR_TEMP . DIRECTORY_SEPARATOR . 'contagem-' . str_pad($idContagem, 11, '0', STR_PAD_LEFT) . '.pdf', 'contagem-' . str_pad($idContagem, 11, '0', STR_PAD_LEFT) . '.pdf');
                $zipFile->addEmptyDir(str_pad($idContagem, 11, '0', STR_PAD_LEFT));
                if (is_dir($dir_base . DIRECTORY_SEPARATOR . (str_pad($idContagem, 11, '0', STR_PAD_LEFT)))) {
                    $dirHandle = opendir($dir_base . DIRECTORY_SEPARATOR . (str_pad($idContagem, 11, '0', STR_PAD_LEFT)));
                    while ($file = readdir($dirHandle)) {
                        if ($file !== '.' && $file !== '..' && $file !== 'thumbnail' && !(strpos($file, 'Contagem-'))) {
                            $zipFile->addFile($dir_base . DIRECTORY_SEPARATOR . (str_pad($idContagem, 11, '0', STR_PAD_LEFT)) . DIRECTORY_SEPARATOR . $file, str_pad($idContagem, 11, '0', STR_PAD_LEFT) . DIRECTORY_SEPARATOR . $file);
                            /*
                             * TODO: precisa limpar o /temp
                             */
                        }
                    }
                }
            }
            /*
             * gera o pdf com o total do faturamento e adiciona ao arquivo zip
             */
            getFile('FATURAMENTO', $mesAnoFaturamento, $login, NULL, $idUnicoArquivo);
            $zipFile->addFile(DIR_TEMP . DIRECTORY_SEPARATOR . $idUnicoArquivo . '-faturamento-' . $mesAnoFaturamento . '.pdf', 'faturamento-' . $mesAnoFaturamento . '.pdf');
        }
        /*
         * fecha o arquivo zip
         */
        $zipFile->close();
        /*
         * envia email informando sobre a autorizacao de faturamento da contagem
         */
        if (PRODUCAO) {
            emailAvisoFaturar($arrFaturar, $responsavelFaturamento, $objEmail, $arquivoEmail);
        }
    }
} else {
    echo json_encode(array('sucesso' => FALSE));
}
