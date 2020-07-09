<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verifica login
 */
if ($login->isUserLoggedIn() && verificaSessao()) {
    $arrLabels = array(
        1 => 'label-processo-1',
        2 => 'label-processo-2',
        3 => 'label-processo-3',
        6 => 'label-processo-6',
        7 => 'label-processo-7',
        8 => 'label-processo-8',
        9 => 'label-processo-9',
        10 => 'label-processo-10',
        18 => 'label-processo-18',
        19 => 'label-processo-19',
        20 => 'label-processo-20',
        21 => 'label-processo-21');
    //variaveis do usuario logado
    $userId = getUserIdDecoded();
    $email = getEmailUsuarioLogado();
    //define a classe contagem analise
    $fa = new ContagemAnaliseFiscal();
    $fn = new Contagem();
    $ab = new Abrangencia();
    $us = new Usuario();
    //lista as contagens
    $ret = $fa->listaContagemAnalise($userId);
    //monta o array inicial
    $re1 = array();
    $res = array('draw' => 1, 'recordsTotal' => count($ret), 'recordsFiltered' => count($ret));
    //passa pelas contagens da listagem
    foreach ($ret as $linha) {
        $abrangencia_c1 = $fn->getAbrangencia($linha['id_contagem_1'])['id_abrangencia'];
        //estabelece se eh uma contagem de auditoria
        $isContagemAuditoria_c1 = $fn->isContagemAuditoria($linha['id_contagem_1']);
        //pega o processo e data em que a contagem esta
        $contagemProcesso_c1 = $fn->getContagemProcesso($linha['id_contagem_1'], '1, 2, 3, 6, 7, 8, 9, 10, 18, 19, 20, 21');
        //coloca a data fim do processo
        $dataFim_c1 = $contagemProcesso_c1['data_fim'] ? true : false;
        //obtem a descricao do processo atual
        $descricaoProcesso_c1 = '<center><div class="label-round '
                . (NULL === $contagemProcesso_c1['data_fim'] ? $arrLabels[$contagemProcesso_c1['id_processo']] : 'label-processo-7a') . '">'
                . (NULL === $contagemProcesso_c1['data_fim'] ? $contagemProcesso_c1['descricao_em_andamento'] : ($contagemProcesso_c1['id_processo'] == 7 ? '<i class="fa fa-flag-checkered"></i>&nbsp;' : '')
                        . $contagemProcesso_c1['descricao_concluido']
                        . '</div><br />' . date_format(date_create($contagemProcesso_c1['data_fim']), 'd/m/Y H:i:s')) . '</div>';
        //pega a privacidade de depois junto com o tipo
        $lock_c1 = '<span id="priv-' . $linha['id_contagem_1'] . '">' . ($fn->getPrivacidade($linha['id_contagem_1']) ? '<i class="fa fa-ban"></i>&nbsp;&nbsp;' : '<i class="fa fa-circle-thin"></i>&nbsp;&nbsp;') . '</span>';
        //verifica se eh uma contagem do tipo auditoria e marca para o fiscal
        if ($isContagemAuditoria_c1) {
            $labelContagemAuditoria_c1 = '&nbsp;<span class="bg-warning">[ A ]</span>';
        } else {
            $labelContagemAuditoria_c1 = '';
        }
        //verifica o tipo para poder exibir os totalizadores
        $tipo_c1 = $ab->getTipo($abrangencia_c1)['tipo'];
        switch ($tipo_c1) {
            case 'APF':
            case 'EF':
                $pfDados_c1 = $fn->totalPFADados($linha['id_contagem_1']);
                $pfTransacao_c1 = $fn->totalPFATransacao($linha['id_contagem_1']);
                $pfOutros_c1 = $fn->totalPFAOutros($linha['id_contagem_1']);
                $qtdPFA_c1 = number_format(($pfDados_c1['pfa'] + $pfTransacao_c1['pfa'] + $pfOutros_c1['pfa']), 3, ',', '.');
                $qtd_c1 = '<strong>' . $tipo_c1 . '</strong> - PFa: <strong>' . $qtdPFA_c1 . '</strong><br />'
                        . $lock_c1 . ucfirst($ab->getChave($abrangencia_c1)['chave'] . $labelContagemAuditoria_c1);
                break;
            case 'SNAP':
                $qtd_c1 = '<strong>' . $tipo_c1 . '</strong>';
                break;
            case 'APT':
                break;
        }
        //responsavel pela contagem
        $arrResponsavel_c1 = $fn->getResponsavel($linha['id_contagem_1']);
        $responsavel_c1 = $arrResponsavel_c1['responsavel'];
        $idResponsavel_c1 = $arrResponsavel_c1['user_id'];
        //pega o id do fornecedor da contagem
        $id_fornecedor_c1 = $fn->getIdFornecedor($linha['id_contagem_1'])['id_fornecedor'];
        //cliente, contrato e projeto
        $clienteContratoProjeto_c1 = $fn->getClienteContratoProjeto($linha['id_contagem_1']);
        //pega pelo id_primario, o que pode gerar versoes sem alterar o programa
        $id_c1 = '<center><a href="#" onclick="verificaAutorizacao(' . $linha['id_contagem_1'] . ', $(this)); return false;"><strong>' . str_pad($linha['id_contagem_1'], 7, '0', STR_PAD_LEFT)
                . '</strong></a><br />'
                . $fn->getSiglaFornecedor($id_fornecedor_c1)
                . '</center>';
        /*
         * verifica se o id_contagem_2 nao eh zero
         */
        if ($linha['id_contagem_2'] > 0) {
            $abrangencia_c2 = $fn->getAbrangencia($linha['id_contagem_2'])['id_abrangencia'];
            $isContagemAuditoria_c2 = $fn->isContagemAuditoria($linha['id_contagem_2']);
            $contagemProcesso_c2 = $fn->getContagemProcesso($linha['id_contagem_2'], '1, 2, 3, 6, 7, 8, 9, 10, 18, 19, 20, 21');
            $dataFim_c2 = $contagemProcesso_c2['data_fim'] ? true : false;
            $descricaoProcesso_c2 = '<center><div class="label-round '
                    . (NULL === $contagemProcesso_c2['data_fim'] ? $arrLabels[$contagemProcesso_c2['id_processo']] : 'label-processo-7a') . '">'
                    . (NULL === $contagemProcesso_c2['data_fim'] ? $contagemProcesso_c2['descricao_em_andamento'] : ($contagemProcesso_c2['id_processo'] == 7 ? '<i class="fa fa-flag-checkered"></i>&nbsp;' : '')
                            . $contagemProcesso_c2['descricao_concluido']
                            . '</div><br />' . date_format(date_create($contagemProcesso_c2['data_fim']), 'd/m/Y H:i:s')) . '</div>';
            $lock_c2 = '<span id="priv-' . $linha['id_contagem_2'] . '">' . ($fn->getPrivacidade($linha['id_contagem_2']) ? '<i class="fa fa-ban"></i>&nbsp;&nbsp;' : '<i class="fa fa-circle-thin"></i>&nbsp;&nbsp;') . '</span>';
            if ($isContagemAuditoria_c2) {
                $labelContagemAuditoria_c2 = '&nbsp;<span class="bg-warning">[ A ]</span>';
            } else {
                $labelContagemAuditoria_c2 = '';
            }
            $tipo_c2 = $ab->getTipo($abrangencia_c2)['tipo'];
            switch ($tipo_c2) {
                case 'APF':
                case 'EF':
                    $pfDados_c2 = $fn->totalPFADados($linha['id_contagem_2']);
                    $pfTransacao_c2 = $fn->totalPFATransacao($linha['id_contagem_2']);
                    $pfOutros_c2 = $fn->totalPFAOutros($linha['id_contagem_2']);
                    $qtdPFA_c2 = number_format(($pfDados_c2['pfa'] + $pfTransacao_c2['pfa'] + $pfOutros_c2['pfa']), 3, ',', '.');
                    $qtd_c2 = '<strong>' . $tipo_c2 . '</strong> - PFa: <strong>' . $qtdPFA_c2 . '</strong><br />'
                            . $lock_c2 . ucfirst($ab->getChave($abrangencia_c2)['chave'] . $labelContagemAuditoria_c2);
                    break;
                case 'SNAP':
                    $qtd_c2 = '<strong>' . $tipo_c2 . '</strong>';
                    break;
                case 'APT':
                    break;
            }
            //responsavel pela contagem
            $arrResponsavel_c2 = $fn->getResponsavel($linha['id_contagem_2']);
            $responsavel_c2 = $arrResponsavel_c2['responsavel'];
            $idResponsavel_c2 = $arrResponsavel_c2['user_id'];
            //pega o id do fornecedor da contagem
            $id_fornecedor_c2 = $fn->getIdFornecedor($linha['id_contagem_2'])['id_fornecedor'];
            //cliente, contrato e projeto
            $clienteContratoProjeto_c2 = $fn->getClienteContratoProjeto($linha['id_contagem_2']);
            //pega pelo id_primario, o que pode gerar versoes sem alterar o programa
            $id_c2 = '<center><a href="#" onclick="verificaAutorizacao(' . $linha['id_contagem_2'] . ', $(this)); return false;"><strong>' . str_pad($linha['id_contagem_2'], 7, '0', STR_PAD_LEFT)
                    . '</strong></a><br />'
                    . $fn->getSiglaFornecedor($id_fornecedor_c2)
                    . '</center>';
        }
        /*
         * monta o array de retorno
         */
        $re1[] = array(
            'col1' => '<a data-toggle="tooltip" data-placement="right" title="' . $responsavel_c1 . '" href="mailto:' . $responsavel_c1 . '"><img src="' . getGravatarImageUser(sha1($idResponsavel_c1)) . '" class="img-circle" width="56" height="56"></a>',
            'col2' => $id_c1,
            'col3' => $qtd_c1,
            'col4' => $linha['id_contagem_2'] > 0 ? '<a data-toggle="tooltip" data-placement="right" title="' . $responsavel_c2 . '" href="mailto:' . $responsavel_c2 . '"><img src="' . getGravatarImageUser(sha1($idResponsavel_c2)) . '" class="img-circle" width="56" height="56"></a>' : '-',
            'col5' => $linha['id_contagem_2'] > 0 ? $id_c2 : '',
            'col6' => $linha['id_contagem_2'] > 0 ? $qtd_c2 : '-',
            'col7' => $clienteContratoProjeto_c1['prjDescricao'] . ' <br /> '
            . $clienteContratoProjeto_c1['conOrdemServico'],
            'col8' => '<a style="cursor: default; cursor: pointer; font-weight: bold;" data-toggle="collapse" data-target="#analise_' . $linha['id'] . '"><i class="fa fa-plus-circle"></i>&nbsp;An&aacute;lise feita em ' . date_format(date_create($linha['data_insercao']), 'd/m/Y H:i:s') . '</a>'
            . '<div id="analise_' . $linha['id'] . '" class="collapse">'
            . '<div class="well well-sm">' . html_entity_decode($linha['analise']) . '</div></div>',
            'projeto' => $clienteContratoProjeto_c1['prjDescricao']
        );
    }//end foreach
    $res['data'] = $re1;
    echo json_encode($res);
}//end if
else {
    $re1[] = array(
        'col1' => '',
        'col2' => '',
        'col3' => '',
        'col4' => '',
        'col5' => '',
        'col6' => '',
        'col7' => '',
        'col8' => '',
        'projeto' => ''
    );
}