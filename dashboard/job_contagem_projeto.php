<?php

// salvar lista.funcoes.baseline
// salvar quantidades
$projeto = new DashboardProjeto();
// consulta ao dashboard
$c = new DashboardSituacaoFuncoes();
$d = new DashboardComplexidadeFuncoes();
/* arrays para cada linha de funcionalidade TODO: verificar
$arFuncoes = array();
$arNodesTD = array();
$arNodesTR = array();
$arTR = array();
$arTD = array();
 * 
 */
//varre todas as empresas
foreach ($empresas as $empresa) {
    $idEmpresa = $empresa['id'];
    $projetos = $projeto->consultaGenerica("SELECT p.id FROM projeto p, contrato c, cliente cl WHERE p.id_contrato = c.id AND c.id_cliente = cl.id AND cl.id_empresa = $idEmpresa");
    foreach ($projetos as $linha) {
        $funcionalidades = $projeto->getFuncionalidades($linha['id']);
        // O parâmetro "a" indica que o arquivo será aberto para escrita
        $fp1 = fopen(DIR_APP . 'dashboard' . DIRECTORY_SEPARATOR . sha1($empresa['id']) . DIRECTORY_SEPARATOR . 'projeto' . DIRECTORY_SEPARATOR . sha1($linha['id']) . '.lista.funcoes.projeto.json', 'wb+');
        // Escreve o conteúdo JSON no arquivo
        $escreve1 = fwrite($fp1, json_encode($funcionalidades));
        // Fecha o arquivo
        fclose($fp1);
        // loop porque precisa pegar o processo em que a contagem se encontra
        $arrContagens = array();
        $contagens = $projeto->getContagens($linha['id']);
        foreach ($contagens as $cn) {
            $contagemProcesso = $fa->getContagemProcesso($cn['id'], '1, 2, 3, 6, 7, 8, 9, 10, 18, 19, 20, 21');
            $descricaoProcesso = NULL === $contagemProcesso['data_fim'] ? $contagemProcesso['descricao_em_andamento'] : $contagemProcesso['descricao_concluido'];
            $siglaFornecedor = $cn['id_fornecedor'] != 0 ? $f->getSigla($cn['id_fornecedor']) : '';
            $arrContagens[] = array(
                'id' => $cn['id'],
                'user_id' => $cn['user_id'],
                'user_email' => $cn['responsavel'],
                'data_cadastro' => $cn['data_cadastro'],
                'ordem_servico' => $cn['ordem_servico'],
                'id_abrangencia' => $cn['id_abrangencia'],
                'privacidade' => $cn['privacidade'],
                'processo' => $descricaoProcesso,
                'sigla' => $siglaFornecedor,
                'id_fornecedor' => $cn['id_fornecedor']
            );
        }
        // O parâmetro "a" indica que o arquivo será aberto para escrita
        $fp2 = fopen(DIR_APP . 'dashboard' . DIRECTORY_SEPARATOR . sha1($empresa['id']) . DIRECTORY_SEPARATOR . 'projeto' . DIRECTORY_SEPARATOR . sha1($linha['id']) . '.lista.contagens.projeto.json', 'wb+');
        // Escreve o conteúdo JSON no arquivo
        $escreve2 = fwrite($fp2, json_encode($arrContagens));
        // Fecha o arquivo
        fclose($fp2);
        // pega ainda as baselines e verifica a situacao das funcionalidades
        $situacao = $c->getSituacao($idEmpresa, $linha['id'], 'id_projeto');
        $arSituacao = array(
            'data' => array(
                0,
                0,
                0,
                0
            ),
            'labels' => array(
                'Não validado',
                'Validado',
                'Em revisão',
                'Revisado'
            )
        );
        foreach ($situacao as $ln) {
            $arSituacao['data'][0] += $ln['naovalidado'];
            $arSituacao['data'][1] += $ln['validado'];
            $arSituacao['data'][2] += $ln['emrevisao'];
            $arSituacao['data'][3] += $ln['revisado'];
        }
        $arSituacao['labels'][0] = $arSituacao['labels'][0] . ' [ ' . $arSituacao['data'][0] . ' ] ';
        $arSituacao['labels'][1] = $arSituacao['labels'][1] . ' [ ' . $arSituacao['data'][1] . ' ] ';
        $arSituacao['labels'][2] = $arSituacao['labels'][2] . ' [ ' . $arSituacao['data'][2] . ' ] ';
        $arSituacao['labels'][3] = $arSituacao['labels'][3] . ' [ ' . $arSituacao['data'][3] . ' ] ';
        // Escreve o conteúdo JSON no arquivo
        $fp3 = fopen(DIR_APP . 'dashboard' . DIRECTORY_SEPARATOR . sha1($empresa['id']) . DIRECTORY_SEPARATOR . 'projeto' . DIRECTORY_SEPARATOR . sha1($linha['id']) . '.situacao.funcoes.json', 'wb+');
        $escreve3 = fwrite($fp3, json_encode($situacao));
        // Escreve o conteudo consolidado no arquivo
        $fp4 = fopen(DIR_APP . 'dashboard' . DIRECTORY_SEPARATOR . sha1($empresa['id']) . DIRECTORY_SEPARATOR . 'projeto' . DIRECTORY_SEPARATOR . sha1($linha['id']) . '.situacao.funcoes.consolidado.json', 'wb+');
        $escreve4 = fwrite($fp4, json_encode($arSituacao));
        // Fecha o arquivo
        fclose($fp3);
        fclose($fp4);
        // para a complexidade das funcionalidades
        $complexidade = $d->getComplexidade($idEmpresa, $linha['id'], 'id_projeto');
        $arComplexidade = array(
            'data' => array(
                0,
                0,
                0,
                0
            ),
            'labels' => array(
                'Baixa',
                'Média',
                'Alta',
                'EF (d/t)'
            )
        );
        foreach ($complexidade as $row) {
            switch ($row['complexidade']) {
                case 'Baixa':
                    $arComplexidade['data'][0] = (int) $row['qtd'];
                    break;
                case 'Media':
                    $arComplexidade['data'][1] = (int) $row['qtd'];
                    break;
                case 'Alta':
                    $arComplexidade['data'][2] = (int) $row['qtd'];
                    break;
                case 'EFd':
                case 'EFt':
                    $arComplexidade['data'][3] = (int) $row['qtd'];
                    break;
            }
        }
        // Tranforma o array $dados em JSON
        $dados_json = json_encode($arComplexidade);
        // O parâmetro "a" indica que o arquivo será aberto para escrita
        // cada empresa em seu diretorio especifico
        // o primeiro sha1 e somente o id da empresa e o segundo sha1 tem o pad com zeros a equerda
        $fp5 = fopen(DIR_APP . 'dashboard' . DIRECTORY_SEPARATOR . sha1($empresa['id']) . DIRECTORY_SEPARATOR . 'projeto' . DIRECTORY_SEPARATOR . sha1($linha['id']) . '.complexidade.funcoes.json', 'wb+');
        // Escreve o conteúdo JSON no arquivo
        $escreve5 = fwrite($fp5, $dados_json);
        // Fecha o arquivo
        fclose($fp5);
    }
}
/* para todos os fornecedores - TODO: verificar
$arFuncoesFornecedor = array();
$arNodesTDFornecedor = array();
$arNodesTRFornecedor = array();
$arTRFornecedor = array();
$arTDFornecedor = array();
 * 
 */
//varre todas as empresas
foreach ($fornecedores as $fornecedor) {
    $idEmpresa = $fornecedor['id_empresa'];
    $idFornecedor = $fornecedor['id'];
    $projetos = $projeto->consultaGenericaFornecedor(""
            . "SELECT "
            . "     p.id "
            . "FROM "
            . "     projeto p, "
            . "     contrato c, "
            . "     cliente cl "
            . "WHERE "
            . "     p.id_contrato = c.id AND "
            . "     c.id_cliente = cl.id AND "
            . "     cl.id_empresa = $idEmpresa AND "
            . "     cl.id_fornecedor = $idFornecedor");
    foreach ($projetos as $linha) {
        $funcionalidades = $projeto->getFuncionalidades($linha['id']);
        // O parâmetro "a" indica que o arquivo será aberto para escrita
        $fp1 = fopen(DIR_APP
                . 'dashboard'
                . DIRECTORY_SEPARATOR
                . sha1($idEmpresa)
                . DIRECTORY_SEPARATOR
                . 'projeto'
                . DIRECTORY_SEPARATOR
                . sha1($idFornecedor)
                . DIRECTORY_SEPARATOR
                . sha1($linha['id'])
                . '.lista.funcoes.projeto.json', 'wb+');
        // Escreve o conteúdo JSON no arquivo
        $escreve1 = fwrite($fp1, json_encode($funcionalidades));
        // Fecha o arquivo
        fclose($fp1);
        // loop porque precisa pegar o processo em que a contagem se encontra
        $arrContagens = array();
        $contagens = $projeto->getContagens($linha['id']);
        foreach ($contagens as $cn) {
            $contagemProcesso = $fa->getContagemProcesso($cn['id'], '1, 2, 3, 6, 7, 8, 9, 10, 18, 19, 20, 21');
            $descricaoProcesso = NULL === $contagemProcesso['data_fim'] ? $contagemProcesso['descricao_em_andamento'] : $contagemProcesso['descricao_concluido'];
            $siglaFornecedor = $cn['id_fornecedor'] != 0 ? $f->getSigla($cn['id_fornecedor']) : '';
            $arrContagens[] = array(
                'id' => $cn['id'],
                'user_id' => $cn['user_id'],
                'user_email' => $cn['responsavel'],
                'data_cadastro' => $cn['data_cadastro'],
                'ordem_servico' => $cn['ordem_servico'],
                'id_abrangencia' => $cn['id_abrangencia'],
                'privacidade' => $cn['privacidade'],
                'processo' => $descricaoProcesso,
                'sigla' => $siglaFornecedor,
                'id_fornecedor' => $cn['id_fornecedor']
            );
        }
        // O parâmetro "a" indica que o arquivo será aberto para escrita
        $fp2 = fopen(DIR_APP
                . 'dashboard'
                . DIRECTORY_SEPARATOR
                . sha1($idEmpresa)
                . DIRECTORY_SEPARATOR
                . 'projeto'
                . DIRECTORY_SEPARATOR
                . sha1($idFornecedor)
                . DIRECTORY_SEPARATOR
                . sha1($linha['id']) . '.lista.contagens.projeto.json', 'wb+');
        // Escreve o conteúdo JSON no arquivo
        $escreve2 = fwrite($fp2, json_encode($arrContagens));
        // Fecha o arquivo
        fclose($fp2);
        // pega ainda as baselines e verifica a situacao das funcionalidades
        $situacao = $c->getSituacao($idEmpresa, $linha['id'], 'id_projeto');
        $arSituacao = array(
            'data' => array(
                0,
                0,
                0,
                0
            ),
            'labels' => array(
                'Não validado',
                'Validado',
                'Em revisão',
                'Revisado'
            )
        );
        foreach ($situacao as $ln) {
            $arSituacao['data'][0] += $ln['naovalidado'];
            $arSituacao['data'][1] += $ln['validado'];
            $arSituacao['data'][2] += $ln['emrevisao'];
            $arSituacao['data'][3] += $ln['revisado'];
        }
        $arSituacao['labels'][0] = $arSituacao['labels'][0] . ' [ ' . $arSituacao['data'][0] . ' ] ';
        $arSituacao['labels'][1] = $arSituacao['labels'][1] . ' [ ' . $arSituacao['data'][1] . ' ] ';
        $arSituacao['labels'][2] = $arSituacao['labels'][2] . ' [ ' . $arSituacao['data'][2] . ' ] ';
        $arSituacao['labels'][3] = $arSituacao['labels'][3] . ' [ ' . $arSituacao['data'][3] . ' ] ';
        // Escreve o conteúdo JSON no arquivo
        $fp3 = fopen(DIR_APP 
                . 'dashboard' 
                . DIRECTORY_SEPARATOR 
                . sha1($idEmpresa) 
                . DIRECTORY_SEPARATOR 
                . 'projeto' 
                . DIRECTORY_SEPARATOR 
                . sha1($idFornecedor)
                . DIRECTORY_SEPARATOR
                . sha1($linha['id']) . '.situacao.funcoes.json', 'wb+');
        $escreve3 = fwrite($fp3, json_encode($situacao));
        // Escreve o conteudo consolidado no arquivo
        $fp4 = fopen(DIR_APP 
                . 'dashboard' 
                . DIRECTORY_SEPARATOR 
                . sha1($idEmpresa) 
                . DIRECTORY_SEPARATOR 
                . 'projeto' 
                . DIRECTORY_SEPARATOR 
                . sha1($idFornecedor)
                . DIRECTORY_SEPARATOR
                . sha1($linha['id']) 
                . '.situacao.funcoes.consolidado.json', 'wb+');
        $escreve4 = fwrite($fp4, json_encode($arSituacao));
        // Fecha o arquivo
        fclose($fp3);
        fclose($fp4);
        // para a complexidade das funcionalidades
        $complexidade = $d->getComplexidade($idEmpresa, $linha['id'], 'id_projeto');
        $arComplexidade = array(
            'data' => array(
                0,
                0,
                0,
                0
            ),
            'labels' => array(
                'Baixa',
                'Média',
                'Alta',
                'EF (d/t)'
            )
        );
        foreach ($complexidade as $row) {
            switch ($row['complexidade']) {
                case 'Baixa':
                    $arComplexidade['data'][0] = (int) $row['qtd'];
                    break;
                case 'Media':
                    $arComplexidade['data'][1] = (int) $row['qtd'];
                    break;
                case 'Alta':
                    $arComplexidade['data'][2] = (int) $row['qtd'];
                    break;
                case 'EFd':
                case 'EFt':
                    $arComplexidade['data'][3] = (int) $row['qtd'];
                    break;
            }
        }
        // Tranforma o array $dados em JSON
        $dados_json = json_encode($arComplexidade);
        // O parâmetro "a" indica que o arquivo será aberto para escrita
        // cada empresa em seu diretorio especifico
        // o primeiro sha1 e somente o id da empresa e o segundo sha1 tem o pad com zeros a equerda
        $fp5 = fopen(DIR_APP 
                . 'dashboard' 
                . DIRECTORY_SEPARATOR 
                . sha1($idEmpresa) 
                . DIRECTORY_SEPARATOR 
                . 'projeto' 
                . DIRECTORY_SEPARATOR
                . sha1($idFornecedor)
                . DIRECTORY_SEPARATOR
                . sha1($linha['id']) . '.complexidade.funcoes.json', 'wb+');
        // Escreve o conteúdo JSON no arquivo
        $escreve5 = fwrite($fp5, $dados_json);
        // Fecha o arquivo
        fclose($fp5);
    }
}