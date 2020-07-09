<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * perfis
 */
$isGestor = getVariavelSessao('isGestor');
$isAdministrador = getVariavelSessao('isAdministrador');
/*
 * verificacao do status do login
 */
if ($login->isUserLoggedIn() && verificaSessao() && ($isAdministrador || $isGestor)) {
    /*
     * instancia da classe Cliente e a classe ClienteConfigRelatorio
     */
    $fn = new Cliente();
    $cr = new ClienteConfigRelatorio();
    /*
     * atribui a acao INSERIR/ALTERAR a variavel acao
     */
    $acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_STRING);
    /*
     * pega o id do cliente mesmo que seja vazio
     */
    $id = NULL !== filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT) : 0;
    /*
     * seta os atributos da classe
     */
    $idEmpresa = getIdEmpresa();
    $idFornecedor = getIdFornecedor();
    $sigla = filter_input(INPUT_POST, 'sigla', FILTER_SANITIZE_SPECIAL_CHARS);
    $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
    $fn->setIdEmpresa(filter_input(INPUT_POST, 'id_empresa', FILTER_SANITIZE_NUMBER_INT));
    $fn->setIsAtivo(filter_input(INPUT_POST, 'is_ativo'));
    $fn->setIsClienteEmpresa(0); //cliente primario para a lista de orgaos
    $fn->setDescricao($descricao);
    $fn->setSigla($sigla);
    $fn->setNome(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS));
    $fn->setEmail(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $fn->setNome2(filter_input(INPUT_POST, 'nome2', FILTER_SANITIZE_SPECIAL_CHARS));
    $fn->setEmail2(filter_input(INPUT_POST, 'email2', FILTER_SANITIZE_EMAIL));
    $fn->setTelefone(filter_input(INPUT_POST, 'telefone'));
    $fn->setTelefone2(filter_input(INPUT_POST, 'telefone2'));
    $fn->setRamal(filter_input(INPUT_POST, 'ramal'));
    $fn->setRamal2(filter_input(INPUT_POST, 'ramal2'));
    $fn->setUF(filter_input(INPUT_POST, 'uf'));
    /*
     * executa a acao solicitada pelo usuario e retorna o .JSON
     */
    switch ($acao) {
        case 'inserir':
            /*
             * insere as configuracoes padrao dos relatorios dos clientes
             */
            $insere = $fn->insere();
            /*
             * seta o id_cliente para as configuracoes
             */
            $cr->setIdCliente($insere['id']);
            $cr->insere($insere['id']); //insere os valores padrao das configuracoes
            /*
             * agora insere tambem o root na arvore de orgaos
             */
            $orgao = new Orgao();
            /*
             * cria o orgao superior, que eh o proprio cliente
             */
            $orgao->setIdEmpresa($idEmpresa);
            $orgao->setIdCliente($insere['id']); //neste caso e orgao do contratante
            $orgao->setSigla($sigla);
            $orgao->setDescricao($descricao);
            $orgao->setIsAtivo(1);
            $orgao->setIsEditavel(0);
            $orgao->setSuperior(NULL); //primeiro na hierarquia da empresa
            $orgao->setLFT(1);
            $orgao->setRGT(2);
            $orgao->setUserId(0);
            $orgao->insere();
            /*
             * insere as configuracoes do cliente
             * contagem_config
             * contagem_config_banco_dados
             * contagem_config_cocomo
             * contagem_config_linguagem
             * contagem_config_tarefas
             */
            $contagem_config = new ContagemConfig();
            $contagem_config_tarefas = new ContagemConfigTarefas();
            $contagem_config_linguagem = new Linguagem();
            $contagem_config_banco_dados = new BancoDados();
            $contagem_config_cocomo = new ContagemConfigCocomo();
            /*
             * contagem_config
             */
            $contagem_config->setIdEmpresa($idEmpresa);
            $contagem_config->setIdCliente($insere['id']);
            $contagem_config->insere();
            //contagem_config_tarefas
            /*
             * pega o id da empresa e insere um registro em contagem_config_tarefas
             */
            $contagem_config_tarefas->setIdEmpresa($idEmpresa);
            $contagem_config_tarefas->setIdFornecedor($idFornecedor);
            $contagem_config_tarefas->setIdCliente($insere['id']);
            $contagem_config_tarefas->insere();
            /*
             * insere as configuracoes das linguagens
             */
            $contagem_config_linguagem->setIdEmpresa($idEmpresa);
            $contagem_config_linguagem->setIdCliente($insere['id']);
            $contagem_config_linguagem->copia();
            /*
             * insere uma linha na contagem_config_cocomo
             */
            $contagem_config_cocomo->setIdEmpresa($idEmpresa);
            $contagem_config_cocomo->setIdCliente($insere['id']);
            $contagem_config_cocomo->insere();
            /*
             * nesta modalidade agora insere um registro de configuracao para banco de dados
             */
            $contagem_config_banco_dados->setIdEmpresa($idEmpresa);
            $contagem_config_banco_dados->setIdCliente($insere['id']);
            $contagem_config_banco_dados->copia();
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
                    . sha1($insere['id']), 0777, TRUE);
            /*
             * retorna
             */
            echo json_encode($insere);
            break;
        case 'alterar':
            /*
             * apenas atualiza as informacoes
             */
            echo json_encode($fn->atualiza($id));
            break;
    }
} else {
    echo json_encode(array('id' => 0, 'nome' => NULL, 'msg' => 'Acesso n&atilde;o autorizado!'));
}

