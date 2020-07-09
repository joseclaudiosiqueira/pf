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
    //instancia das classes empresa e faturamento
    $empresas = new Empresa();
    $empresas->setTable('empresa');
    //configuracao do plano
    $empresaConfigPlano = new EmpresaConfigPlano();
    $empresaConfigPlano->setTable('empresa_config_plano');
    //faturamento
    $faturamento = new Faturamento();
    $faturamento->setTable('faturamento');
    //contagem faturamento
    $contagemFaturamento = new ContagemFaturamento();
    $contagemFaturamento->setTable('contagem_faturamento');
    //contagens
    $contagem = new Contagem();
    $contagem->setTable('contagem');
    //abrangencia
    $contagemAbragencia = new ContagemAbrangencia();
    $contagemAbragencia->setTable('contagem_abrangencia');
    /*
     * pega todos os ids para o loop de faturamento
     */
    $id = $empresaConfigPlano->getIds();
    //data de geracao do faturamento
    $dataGeracao = date('Y-m-d h:i:s');
    $mes = intval(date('m'));
    $ano = intval(date('Y'));
    $mes = $mes == 1 ? 12 : ($mes - 1);
    $ano = $mes == 1 ? ($ano - 1) : $ano;
    $mes = $mes < 10 ? '0' . $mes : $mes;
    $mesAno = $mes . '/' . $ano;
    $status = 0;
    //loop que insere as contagens em contagem_faturamento e em faturamento
    for ($x = 0; $x < count($id); $x++) {
        //insert para a tabela faturamento
        $valores = $faturamento->getValorFaturamento($id[$x]['id']);
        $faturamento->setIdEmpresa($id[$x]['id']);
        $faturamento->setDataGeracao($dataGeracao);
        $faturamento->setIsFaturavel($id[$x]['is_faturavel']);
        $faturamento->setTipoFaturamento($id[$x]['tipo_faturamento']);
        $faturamento->setIndicadoPor($id[$x]['indicado_por']);
        //verifica se houve ou nao contagens
        if ($valores[0]['qtd_contagem'] > 0) {
            $faturamento->setQuantidadeContagens($valores[0]['qtd_contagem']);
            $faturamento->setValorFaturamento($valores[0]['valor_faturamento']);
            $faturamento->setMesAno($mesAno);
            $faturamento->setStatus($status);
            $idFaturamento = $faturamento->insere();
            //pega o idFaturamento e insere
            $contagens = $faturamento->getContagens($id[$x]['id']);
            for ($y = 0; $y < count($contagens); $y++) {
                //calcula os pfa da contagem
                $pfa = $contagem->totalPFADados($contagens[$y]['id'])['pfa'] + $contagem->totalPFATransacao($contagens[$y]['id'])['pfa'] + $contagem->totalPFAOutros($contagens[$y]['id'])['pfa'];
                $contagemFaturamento->setIdFaturamento($idFaturamento);
                $contagemFaturamento->setIdContagem($contagens[$y]['id']);
                $contagemFaturamento->setDataCadastro($contagens[$y]['data_cadastro']);
                $contagemFaturamento->setResponsavel($contagens[$y]['responsavel']);
                $contagemFaturamento->setCliente($contagens[$y]['sigla'] . ' - ' . $contagens[$y]['CLI_descricao']);
                $contagemFaturamento->setContrato($contagens[$y]['numero'] . '/' . $contagens[$y]['ano']);
                $contagemFaturamento->setProjeto($contagens[$y]['PRJ_descricao']);
                $contagemFaturamento->setAbrangencia($contagens[$y]['tipo'] . ' - ' . $contagens[$y]['AB_descricao']);
                $contagemFaturamento->setPfa($pfa);
                $contagemFaturamento->setPfb(0);
                $contagemFaturamento->insere();
            }
        } else {
            $faturamento->setQuantidadeContagens(0);
            $faturamento->setValorFaturamento($empresaConfigPlano->getConfig($id[$x]['id'])['mensalidade']);
            $faturamento->setMesAno($mesAno);
            $faturamento->setStatus($status);
            $idFaturamento = $faturamento->insere();
        }
    }
}