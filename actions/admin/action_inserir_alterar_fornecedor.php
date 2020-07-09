<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
$isAdministrador = getVariavelSessao('isAdministrador');
/*
 * verificacao do status do login
 */
if ($login->isUserLoggedIn() && verificaSessao() && $isAdministrador) {
    $fornecedor = new Fornecedor();
    $cliente = new Cliente();
    $contagem_config_empresa = new ContagemConfigEmpresa();
    $acao = filter_input(INPUT_POST, 'forn-acao', FILTER_SANITIZE_STRING);
    /*
     * verifica se a alteracao vem de um fornecedor ou do contratante
     */
    $id = '';
    if (isFornecedor()) {
        $id = getIdFornecedor();
    } else {
        $id = filter_input(INPUT_POST, 'forn-id', FILTER_SANITIZE_NUMBER_INT);
    }
    $idEmpresa = getIdEmpresa();
    $idClienteEmpresa = $cliente->getIdClienteEmpresa($idEmpresa)['id'];
    $sigla = filter_input(INPUT_POST, 'forn-sigla', FILTER_SANITIZE_SPECIAL_CHARS);
    $nome = filter_input(INPUT_POST, 'forn-nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $prepostoNome = filter_input(INPUT_POST, 'forn-preposto-nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $prepostoEmail = filter_input(INPUT_POST, 'forn-preposto-email', FILTER_SANITIZE_EMAIL);
    $prepostoEmailAlternativo = filter_input(INPUT_POST, 'forn-preposto-email-alternativo', FILTER_SANITIZE_EMAIL);
    $prepostoTelefone = filter_input(INPUT_POST, 'forn-preposto-telefone', FILTER_SANITIZE_STRING);
    $prepostoRamal = filter_input(INPUT_POST, 'forn-preposto-ramal', FILTER_SANITIZE_NUMBER_INT);
    $prepostoTelefoneCelular = filter_input(INPUT_POST, 'forn-preposto-telefone-celular', FILTER_SANITIZE_STRING);
    $isAtivo = filter_input(INPUT_POST, 'forn-is-ativo', FILTER_SANITIZE_NUMBER_INT);
    $tipo = filter_input(INPUT_POST, 'forn-tipo', FILTER_SANITIZE_NUMBER_INT);
    $fornecedor->setIdEmpresa($idEmpresa);
    $fornecedor->setSigla($tipo ? '(TURMA) ' . $sigla : $sigla);
    $fornecedor->setNome($nome);
    $fornecedor->setPrepostoNome($prepostoNome);
    $fornecedor->setPrepostoEmail($prepostoEmail);
    $fornecedor->setPrepostoEmailAlternativo($prepostoEmailAlternativo);
    $fornecedor->setPrepostoTelefone($prepostoTelefone);
    $fornecedor->setPrepostoRamal($prepostoRamal);
    $fornecedor->setPrepostoTelefoneCelular($prepostoTelefoneCelular);
    $fornecedor->setIsAtivo($isAtivo);
    $fornecedor->setTipo($tipo);
    if ($acao === 'inserir') {
        /*
         * insere um registro na tabela fornecedor
         */
        $idFornecedor = $fornecedor->insere();
        /*
         * insere um registro na tabela contagem_config_empresa
         */
        $contagem_config_empresa->setIdEmpresa($idEmpresa);
        $contagem_config_empresa->setIdFornecedor($idFornecedor);
        $contagem_config_empresa->insere();
        /*
         * copia um registro da tabela empresa e insere como um unico cliente para o fornecedor
         */
        $emp = new Empresa();
        $idClienteFornecedor = $emp->copiaEmpresaFornecedorCliente($idEmpresa, $idFornecedor, $tipo);
        /*
         * TODO: ao atualizar a logomarca de uma empresa que tem fornecedores tem que atualizar todas as imagens associadas
         */
        $clienteLogomarca = $emp->copiaLogomarcaEmpresaClienteFornecedor($idEmpresa, $idClienteFornecedor);
        /*
         * copia um registro da tabela empresa_config_plano e replica para a tabela fornecedor_config_plano
         * a empresa (contratante) deve restringir ou nao o plano contratado
         */
        $ecp = new EmpresaConfigPlano();
        $ecp->copiaEmpresaConfigPlanoFornecedor($idEmpresa, $idFornecedor);
        /*
         * copia o registro da contagem_config para a tabela contagem_fornecedor_config
         * o fornecedor deve atualizar as opcoes padrao
         * copiaContagemFornecedorConfig(
         * $idEmpresa, 
         * $idFornecedor, 
         * $idClienteFornecedor, 
         * $idClienteEmpresa)
         */
        $fco = new ContagemConfig();
        $fco->copiaContagemFornecedorConfig($idEmpresa, $idFornecedor, $idClienteFornecedor, $idClienteEmpresa);
        /*
         * cria um cliente_config_relatorio automatico para este fornecedor, que tem somente um Cliente
         */
        $ccr = new ClienteConfigRelatorio();
        $ccr->setIdCliente($idClienteFornecedor);
        $ccr->insere();
        /*
         * cria as configuracoes das tarefas iguais as do Contratante
         */
        $cct = new ContagemConfigTarefas();
        $cct->copiaContagemConfigTarefas($idEmpresa, $idFornecedor, $idClienteFornecedor);
        /*
         * insere uma linha na contagem_config_cocomo
         */
        $contagem_config_cocomo = new ContagemConfigCocomo();
        $contagem_config_cocomo->setIdEmpresa($idEmpresa);
        $contagem_config_cocomo->setIdCliente($idClienteFornecedor);
        $contagem_config_cocomo->insere();
        /*
         * no caso de um Fornecedor do tipo Turma de Treinamento insere um contrato e um projeto
         */
        if ($tipo) {
            /*
             * classe Contrato
             */
            $cnt = new Contrato();
            /*
             * seta os atributos da classe Contrato
             */
            $cnt->setAno(date('Y'));
            $cnt->setNumero('(TURMA) ' . $sigla);
            $cnt->setUf('TR');
            $cnt->setIdCliente($idClienteFornecedor);
            $cnt->setIsAtivo(1);
            $cnt->setPFContratado('10000');
            $cnt->setValorPF('879.56');
            $cnt->setDataInicio(date('Y-m-d'));
            $cnt->setDataFim(date('Y-m-d'));
            $cnt->setTipo('I'); //inicial
            $cnt->setIdPrimario(0);
            $cnt->setValorHpc('456.25');
            $cnt->setValorHpa('383.74');
            $insContrato = $cnt->insere();
            $idContrato = $insContrato['id'];
            /*
             * class Projeto
             */
            $prj = new Projeto();
            /*
             * seta os atributos da classe Projeto
             */
            $prj->setIdContrato($idContrato);
            $prj->setDescricao('TREINAMENTO (TURMA) ' . $sigla);
            $prj->setIsAtivo(1);
            $prj->setDataInicio(date('Y-m-d'));
            $prj->setDataFim(date('Y-m-d'));
            $prj->setIdGerenteProjeto(0);
            $insProjeto = $prj->insere();
            $idProjeto = $insProjeto['id'];
            /*
             * instancia da classe ClienteConfigProjetoAssinatura e insere as configuracoes padrao
             */
            $ccpa = new ClienteConfigProjetoAssinatura();
            $ccpa->setIdProjeto($idProjeto);
            $ccpa->setIsAssinaturaRelatorio(0);
            $ccpa->insere();
            /*
             * neste momento tambem insere um orgao principal que eh a propria turma
             */
            $orgao = new Orgao();
            $orgao->setIdEmpresa($idEmpresa);
            $orgao->setIdCliente($idClienteFornecedor);
            $orgao->setSigla($sigla);
            $orgao->setDescricao($nome);
            $orgao->setIsAtivo(1);
            $orgao->setIsEditavel(0);
            $orgao->setSuperior(NULL);
            $orgao->setUserId(0);
            $orgao->insere();
        }
        /*
         * cria o diretorio para os dashboards
         */
        mkdir(DIR_APP
                . 'dashboard'
                . DIRECTORY_SEPARATOR
                . sha1($idEmpresa)
                . DIRECTORY_SEPARATOR
                . sha1($idFornecedor), 0777, TRUE);
        /*
         * cria o diretorio para os dashboards de projeto do fornecedor
         */
        mkdir(DIR_APP
                . 'dashboard'
                . DIRECTORY_SEPARATOR
                . sha1($idEmpresa)
                . DIRECTORY_SEPARATOR
                . 'projeto'
                . DIRECTORY_SEPARATOR
                . sha1($idFornecedor), 0777, TRUE);
        /*
         * cria o diretorio do cliente em relatorio personalizado
         */
        mkdir(DIR_APP
                . 'actions'
                . DIRECTORY_SEPARATOR
                . 'relatorios'
                . DIRECTORY_SEPARATOR
                . 'personalizados'
                . DIRECTORY_SEPARATOR
                . sha1($idEmpresa)
                . DIRECTORY_SEPARATOR
                . sha1($idClienteFornecedor), 0777, TRUE);
        /*
         * retorna para a pagina principal
         */
        if ($idFornecedor) {
            echo json_encode(array('id' => $idFornecedor, 'msg' => '&nbsp;1.&nbsp;'
                . (!$tipo ? 'O fornecedor ' : 'A turma para treinamento ') . '<strong>' . $sigla . ' - ' . $nome . '</strong> foi inserido(a) com sucesso;'
                . '<br />2.&nbsp;Voc&ecirc; pode inserir uma logomarca, se houver, ou solicitar que o ' . (!$tipo ? 'Fornecedor' : 'Gestor (Instrutor)') . ' o fa&ccedil;a;'
                . (!$tipo ?
                        '<br />3.&nbsp;Adicione usu&aacute;rios a este fornecedor, configurando os perfis corretamente.</p>' :
                        '<br />3.&nbsp;Adicione os alunos a esta turma, configurando os perfis.</p>')));
        } else {
            echo json_encode(array('msg' => 'Houve um erro durante a inser&ccedil;&atilde;o das informa&ccedil;&otilde;es, '
                . 'por favor tente novamente!'));
        }
    } elseif ($acao === 'alterar') {
        $idFornecedor = $fornecedor->atualiza($id);
        if ($idFornecedor) {
            echo json_encode(array('msg' => 'As altera&ccedil;&otilde;es foram feitas com sucesso.'));
        } else {
            echo json_encode(array('msg' => 'Houve um erro durante a atualiza&ccedil;&atilde;o das informa&ccedil;&otilde;es, '
                . 'por favor tente novamente!'));
        }
    }
} else {
    echo json_encode(array('id' => 0, 'msg' => 'Acesso n&atilde;o autorizado!'));
}