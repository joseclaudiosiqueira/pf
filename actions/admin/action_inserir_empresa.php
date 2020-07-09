<?php

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
if ($login->isUserLoggedIn() && getUserName() === '41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265' && verificaSessao()) {
    /*
     * insercao basica para inicio de uma empresa
     */
    $empresa = new Empresa();
    $empresa_config = new EmpresaConfig();
    $empresa_config_plano = new EmpresaConfigPlano();
    $cliente = new Cliente();
    $orgao = new Orgao();
    $contagem_config = new ContagemConfig();
    $contagem_config_empresa = new ContagemConfigEmpresa();
    $contagem_config_tarefas = new ContagemConfigTarefas();
    $contagem_config_linguagem = new Linguagem();
    $contagem_config_banco_dados = new BancoDados();
    $contagem_config_cocomo = new ContagemConfigCocomo();
    $cliente_config_relatorio = new ClienteConfigRelatorio();
    /*
     * dados do formulario
     */
    $bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_SPECIAL_CHARS);
    $cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);
    $cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_SPECIAL_CHARS);
    $cnpj = filter_input(INPUT_POST, 'cnpj', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
    $logradouro = filter_input(INPUT_POST, 'logradouro', FILTER_SANITIZE_SPECIAL_CHARS);
    $nomeFantasia = filter_input(INPUT_POST, 'nomeFantasia', FILTER_SANITIZE_SPECIAL_CHARS);
    $sigla = filter_input(INPUT_POST, 'sigla', FILTER_SANITIZE_STRING);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
    $tipoLogradouro = filter_input(INPUT_POST, 'tipoLogradouro', FILTER_SANITIZE_STRING);
    $uf = filter_input(INPUT_POST, 'uf', FILTER_SANITIZE_STRING);
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $nome2 = filter_input(INPUT_POST, 'nome2', FILTER_SANITIZE_SPECIAL_CHARS);
    $email2 = filter_input(INPUT_POST, 'email2', FILTER_SANITIZE_EMAIL);
    $ramal = filter_input(INPUT_POST, 'ramal', FILTER_SANITIZE_STRING);
    $telefone2 = filter_input(INPUT_POST, 'telefone2', FILTER_SANITIZE_STRING);
    $ramal2 = filter_input(INPUT_POST, 'ramal2', FILTER_SANITIZE_STRING);
    $idPlano = filter_input(INPUT_POST, 'idPlano', FILTER_SANITIZE_STRING);
    $mensalidade = filter_input(INPUT_POST, 'mensalidade', FILTER_SANITIZE_STRING);
    $valorContagem = filter_input(INPUT_POST, 'valorContagem', FILTER_SANITIZE_STRING);
    $isFaturavel = filter_input(INPUT_POST, 'isFaturavel', FILTER_SANITIZE_NUMBER_INT);
    $indicadoPor = filter_input(INPUT_POST, 'indicadoPor', FILTER_SANITIZE_EMAIL);
    $tipoFaturamento = filter_input(INPUT_POST, 'tipoFaturamento', FILTER_SANITIZE_NUMBER_INT);
    $dataInicio = date('Y-m-d H:i:s');
    $dataFim = date('Y-m-d H:i:s');
    $idFornecedor = 0;
    /*
     * sets da classe empresa
     */
    $empresa->setIsAtivo(1);
    $empresa->setBairro($bairro);
    $empresa->setCep($cep);
    $empresa->setCidade($cidade);
    $empresa->setCnpj($cnpj);
    $empresa->setEmail($email);
    $empresa->setLogradouro($logradouro);
    $empresa->setNomeFantasia($nomeFantasia);
    $empresa->setSigla($sigla);
    $empresa->setTelefone($telefone);
    $empresa->setTipoLogradouro($tipoLogradouro);
    $empresa->setUf($uf);
    $empresa->setNome($nome);
    $empresa->setNome2($nome2);
    $empresa->setEmail2($email2);
    $empresa->setRamal($ramal);
    $empresa->setTelefone2($telefone2);
    $empresa->setRamal2($ramal2);
    /*
     * insere uma empresa e pega o id
     */
    $idEmpresa = $empresa->insere();
    /*
     * pega o id da empresa e insere em empresa_config
     */
    $empresa_config->setIdEmpresa($idEmpresa);
    $empresa_config->setEmailAdministrador1($email);
    $empresa_config->setEmailAdministrador2($email2);
    $empresa_config->setTelefoneAdministrador1($telefone);
    $empresa_config->setTelefoneAdministrador2($telefone2);
    $empresa_config->insere();
    /*
     * pega o id da empresa e insere em empresa_config_plano
     */
    $empresa_config_plano->setIdEmpresa($idEmpresa);
    $empresa_config_plano->setIdPlano($idPlano);
    $empresa_config_plano->setDataInicio($dataInicio);
    $empresa_config_plano->setDataFim($dataFim);
    $empresa_config_plano->setMensalidade($mensalidade);
    $empresa_config_plano->setValorContagem($valorContagem);
    $empresa_config_plano->setIsFaturavel($isFaturavel);
    $empresa_config_plano->setIndicadoPor($indicadoPor);
    $empresa_config_plano->setTipoFaturamento($tipoFaturamento);
    $empresa_config_plano->insere();
    /*
     * cria um cliente que eh a propria empresa
     */
    $cliente->setIdEmpresa($idEmpresa);
    $cliente->setIsAtivo(1);
    $cliente->setIsClienteEmpresa(1); //cliente primario para a lista de orgaos
    $cliente->setDescricao($nomeFantasia);
    $cliente->setSigla($sigla);
    $cliente->setNome($nome);
    $cliente->setEmail($email);
    $cliente->setNome2($nome2);
    $cliente->setEmail2($email2);
    $cliente->setTelefone($telefone);
    $cliente->setTelefone2($telefone2);
    $cliente->setRamal($ramal);
    $cliente->setRamal2($ramal2);
    $cliente->setUF($uf);
    /*
     * insere as configuracoes padrao dos relatorios dos clientes
     * insere um cliente antes para todas as outras configuracoes 
     */
    $idCliente = $cliente->insere();
    /*
     * pega o id da empresa e insere um registro na contagem_config
     */
    $contagem_config->setIdEmpresa($idEmpresa);
    $contagem_config->setIdCliente($idCliente['id']);
    $contagem_config->insere();
    /*
     * insere as configuracoes padrao para a empresa
     */
    $contagem_config_empresa->setIdEmpresa($idEmpresa);
    $contagem_config_empresa->setIdFornecedor($idFornecedor);
    $contagem_config_empresa->insere();
    /*
     * pega o id da empresa e insere um registro em contagem_config_tarefas
     */
    $contagem_config_tarefas->setIdEmpresa($idEmpresa);
    $contagem_config_tarefas->setIdFornecedor($idFornecedor);
    $contagem_config_tarefas->setIdCliente($idCliente['id']);
    $contagem_config_tarefas->insere();
    /*
     * insere as configuracoes das linguagens
     */
    $contagem_config_linguagem->setIdEmpresa($idEmpresa);
    $contagem_config_linguagem->setIdCliente($idCliente['id']);
    $contagem_config_linguagem->copia();
    /*
     * insere uma linha na contagem_config_cocomo
     */
    $contagem_config_cocomo->setIdEmpresa($idEmpresa);
    $contagem_config_cocomo->setIdCliente($idCliente['id']);
    $contagem_config_cocomo->insere();
    /*
     * nesta modalidade agora insere um registro de configuracao para banco de dados
     */
    $contagem_config_banco_dados->setIdEmpresa($idEmpresa);
    $contagem_config_banco_dados->setIdCliente($idCliente['id']);
    $contagem_config_banco_dados->copia();
    /*
     * seta o id_cliente para as configuracoes
     */
    $cliente_config_relatorio->setIdCliente($idCliente['id']);
    $cliente_config_relatorio->insere($idCliente['id']); //insere os valores padrao das configuracoes
    /*
     * cria o orgao superior, que eh o proprio cliente
     */
    $orgao->setIdEmpresa($idEmpresa);
    $orgao->setIdCliente($idCliente['id']); //neste caso e orgao do contratante
    $orgao->setSigla($sigla);
    $orgao->setDescricao($nomeFantasia);
    $orgao->setIsAtivo(1);
    $orgao->setIsEditavel(0);
    $orgao->setSuperior(NULL); //primeiro na hierarquia da empresa
    $orgao->setLFT(1);
    $orgao->setRGT(2);
    $orgao->setUserId(0);
    $orgao->insere();
    /*
     * cria o diretorio para os dashboards
     */
    mkdir(DIR_APP
            . 'dashboard'
            . DIRECTORY_SEPARATOR
            . sha1($idEmpresa), 0777, TRUE);
    /*
     * cria o diretorio projeto para os dashboards
     */
    mkdir(DIR_APP
            . 'dashboard'
            . DIRECTORY_SEPARATOR
            . sha1($idEmpresa)
            . DIRECTORY_SEPARATOR
            . 'projeto', 0777, TRUE);
    /*
     * cria um diretorio especial para relatorios personalizados
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
            . sha1($idCliente['id']), 0777, TRUE);
    /*
     * retorna com sucesso apos as insercoes
     */
    echo json_encode(array('id' => $idEmpresa, 'msg' => 'A empresa #ID' . str_pad($idEmpresa, 6, '0', STR_PAD_LEFT) . ' e as suas configura&ccedil;&otilde;es foram criadas com sucesso!'));
} else {
    echo json_encode(array('id' => 0, 'msg' => 'Acesso n&atilde;o autorizado!'));
}