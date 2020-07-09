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
if ($login->isUserLoggedIn() && verificaSessao()) {
    /*
     * captura do post
     */
    $id_contagem = filter_input(INPUT_POST, 'idContagem', FILTER_SANITIZE_NUMBER_INT);
    $abAtual = filter_input(INPUT_POST, 'abAtual', FILTER_SANITIZE_NUMBER_INT);
    $operacao = filter_input(INPUT_POST, 'operacao', FILTER_SANITIZE_STRING);
    $idBaseline = filter_input(INPUT_POST, 'idBaseline', FILTER_SANITIZE_NUMBER_INT);
    $idBaselineContagem = filter_input(INPUT_POST, 'idBaselineContagem', FILTER_SANITIZE_NUMBER_INT);
    /*
     * for linha a linha para inserir nas tabelas
     */
    foreach ($_POST['fi'] as $key => $value) {
        $ln = explode('-', $value);
        $table = $ln[0];
        $idFuncao = intval($ln[1], 10);
        /*
         * verifica qual e a tabela
         */
        switch ($table) {
            case 'ali':
            case 'aie':
                $fa = new FuncaoDados();
                break;
            case 'ee':
            case 'se':
            case 'ce':
                $fa = new FuncaoTransacao();
                break;
        }
        /*
         * seta a tabela para a consulta
         */
        $fa->setTable($table === 'aie' && $idBaseline != $idBaselineContagem ? 'ali' : $table);
        /*
         * seleciona uma linha na tabela
         */
        $linha = $fa->consulta($idFuncao);
        /*
         * pega o id_baseline para inserir uma linha na contagem de baseline
         */
        $id_contagem_baseline = $linha['id_contagem'];
        /*
         * atribui as variaveis para insercao na baseline
         */
        $idc = $id_contagem_baseline; //representa do id da contagem (baseline ou projeto)
        $impacto = 41;
        $tr = ($table === 'ali' || $table === 'aie') ? $linha['tr'] : $linha['ar'];
        $complexidade = $linha['complexidade'];
        $funcao = $linha['funcao'];
        $id_baseline = 0;
        $id_gerador = 0;
        $id_metodo = $linha['id_metodo'];
        $id_roteiro = 3;
        $pfa = $linha['pfa'];
        $pfb = $linha['pfb'];
        $td = $linha['td'];
        $entrega = 1;
        $fonte = $linha['fonte'];
        $inserido_por = getEmailUsuarioLogado();
        $data_cadastro = date('Y-m-d H:i:s');
        $descricao_tr = ($table === 'ali' || $table === 'aie') ? $linha['descricao_tr'] : $linha['descricao_ar'];
        $descricao_td = $linha['descricao_td'];
        $situacao = 1;
        $is_mudanca = 0;
        $fase_mudanca = 0;
        $percentual_fase = 0;
        $fd = 0;
        $id_relacionamento = $idFuncao;
        $ultima_atualizacao = $data_cadastro;
        $atualizado_por = $inserido_por;
        // o FE - Formulario Extendido eh apenas para os ALI
        $fe = ($table === 'aie'? 0 : ($table === 'ali' ? $linha['fe'] : 0));
        $id_fator_tecnologia = $linha['id_fator_tecnologia'];
        $valor_fator_tecnologia = $linha['valor_fator_tecnologia'];
        $obsFuncao = 'INSERIDA pela Contagem de Projeto ID#' . str_pad($id_contagem, 6, "0", STR_PAD_LEFT);
        /*
         * processo especial para aie em baseline para nao duplicar
         * aie cria apenas uma referencia para o ali na baseline original
         */
        if ($abAtual == 3 && $table === 'aie') {
            switch ($complexidade) {
                case 'Alta':
                    $pfa = 10;
                    $pfb = 10;
                    break;
                case 'Media':
                    $pfa = 7;
                    $pfb = 7;
                    break;
                case 'Baixa':
                    $pfa = 5;
                    $pfb = 5;
                    break;
            }
            $obsFuncao = '';
            /*
             * insere a linha na baseline com os valores retornados
             */
            $sql = "INSERT INTO $table ("
                    . "impacto, "
                    . "tr, "
                    . "complexidade, "
                    . "funcao, "
                    . "id_contagem, "
                    . "id_baseline, "
                    . "id_gerador, "
                    . "id_metodo, "
                    . "id_roteiro, "
                    . "operacao, "
                    . "pfa, "
                    . "pfb, "
                    . "td, "
                    . "entrega, "
                    . "fonte, "
                    . "obs_funcao, "
                    . "inserido_por, "
                    . "data_cadastro, "
                    . "descricao_tr, "
                    . "descricao_td, "
                    . "situacao, "
                    . "is_mudanca, "
                    . "fase_mudanca, "
                    . "percentual_fase, "
                    . "fd, "
                    . ( $table === 'ali' || $table === 'aie' ? "fe, " : '' )
                    . "id_relacionamento, "
                   	. ( $table === 'ee' || $table === 'se' || $table === 'ce' ? "id_fator_tecnologia, valor_fator_tecnologia, " : '' )
                    . "ultima_atualizacao, "
                    . "atualizado_por) VALUES ("
                    . "'$impacto', "
                    . "'$tr', "
                    . "'$complexidade', "
                    . "'$funcao', "
                    . "'$id_contagem', "
                    . "'$id_baseline', "
                    . "'$id_gerador', "
                    . "'$id_metodo', "
                    . "'$id_roteiro', "
                    . "'$operacao', "
                    . "'$pfa', "
                    . "'$pfb', "
                    . "'$td', "
                    . "'$entrega', "
                    . "'$fonte', "
                    . "'$obsFuncao', "
                    . "'$inserido_por', "
                    . "'$data_cadastro', "
                    . "'$descricao_tr', "
                    . "'$descricao_td', "
                    . "'$situacao', "
                    . "'$is_mudanca', "
                    . "'$fase_mudanca', "
                    . "'$percentual_fase', "
                    . "'$fd', "
                    . ( $table === 'ali' || $table === 'aie' ? "'$fe', " : '' )
                    . "'$id_relacionamento', "
                    . ($table === 'ee' || $table === 'se' || $table === 'ce' ? "'$id_fator_tecnologia', '$valor_fator_tecnologia', " : '')
                    . "'$ultima_atualizacao', "
                    . "'$atualizado_por')";
            /*
             * insere uma nova funcao so que agora no projeto e pega o id para atualizar o id_gerador
             */
            $stmt = DB::prepare($sql);
            $stmt->execute();
        } else {
            /*
             * insere a linha na baseline com os valores retornados se nao for LIVRE
             */
            if ($abAtual != 1) {
                $sql = "INSERT INTO $table ("
                        . "impacto, "
                        . ($table === 'ali' || $table === 'aie' ? "tr, " : "ar, ")
                        . "complexidade, "
                        . "funcao, "
                        . "id_contagem, "
                        . "id_baseline, "
                        . "id_gerador, "
                        . "id_metodo, "
                        . "id_roteiro, "
                        . "operacao, "
                        . "pfa, "
                        . "pfb, "
                        . "td, "
                        . "entrega, "
                        . "fonte, "
                        . "obs_funcao, "
                        . "inserido_por, "
                        . "data_cadastro, "
                        . ($table === 'ali' || $table === 'aie' ? "descricao_tr, " : "descricao_ar, ")
                        . "descricao_td, "
                        . "situacao, "
                        . "is_mudanca, "
                        . "fase_mudanca, "
                        . "percentual_fase, "
                        . "fd, "
                        . ( $table === 'ali' || $table === 'aie' ? "fe, " : '' )
                        . "id_relacionamento, "
                        . ($table === 'ee' || $table === 'se' || $table === 'ce' ? "id_fator_tecnologia, valor_fator_tecnologia, " : '')
                        . "ultima_atualizacao, "
                        . "atualizado_por) VALUES ("
                        . "'$impacto', "
                        . "'$tr', "
                        . "'$complexidade', "
                        . "'$funcao', "
                        . "'$idc', "
                        . "'$id_baseline', "
                        . "'$id_gerador', "
                        . "'$id_metodo', "
                        . "'$id_roteiro', "
                        . "'$operacao', "
                        . "'$pfa', "
                        . "'$pfb', "
                        . "'$td', "
                        . "'$entrega', "
                        . "'$fonte', "
                        . "'$obsFuncao', "
                        . "'$inserido_por', "
                        . "'$data_cadastro', "
                        . "'$descricao_tr', "
                        . "'$descricao_td', "
                        . "'$situacao', "
                        . "'$is_mudanca', "
                        . "'$fase_mudanca', "
                        . "'$percentual_fase', "
                        . "'$fd', "
                        . ( $table === 'ali' || $table === 'aie' ? "'$fe', " : '' )
                        . "'$id_relacionamento', "
                        . ($table === 'ee' || $table === 'se' || $table === 'ce' ? "'$id_fator_tecnologia', '$valor_fator_tecnologia', " : '')
                        . "'$ultima_atualizacao', "
                        . "'$atualizado_por')";
                $stm = DB::prepare($sql);
                $stm->execute();
                /*
                 * pega o id que acabou de ser inserido e será o id_baseline (funcao)
                 */
                $id_inserido_baseline = DB::getInstance()->lastInsertId();
                $idc = $id_contagem;
                $id_baseline = $id_inserido_baseline;
                $obsFuncao = '';
            }
            /*
             * insere a linha na contagem com os valores retornados
             */
            $sql = "INSERT INTO $table ("
                    . "impacto, "
                    . ($table === 'ali' || $table === 'aie' ? "tr, " : "ar, ")
                    . "complexidade, "
                    . "funcao, "
                    . "id_contagem, "
                    . "id_baseline, "
                    . "id_gerador, "
                    . "id_metodo, "
                    . "id_roteiro, "
                    . "operacao, "
                    . "pfa, "
                    . "pfb, "
                    . "td, "
                    . "entrega, "
                    . "fonte, "
                    . "obs_funcao, "
                    . "inserido_por, "
                    . "data_cadastro, "
                    . ($table === 'ali' || $table === 'aie' ? "descricao_tr, " : "descricao_ar, ")
                    . "descricao_td, "
                    . "situacao, "
                    . "is_mudanca, "
                    . "fase_mudanca, "
                    . "percentual_fase, "
                    . "fd, "
                    . ( $table === 'ali' || $table === 'aie' ? "fe, " : '' )
                    . "id_relacionamento, "
                    . ($table === 'ee' || $table === 'se' || $table === 'ce' ? "id_fator_tecnologia, valor_fator_tecnologia, " : '')
                    . "ultima_atualizacao, "
                    . "atualizado_por) VALUES ("
                    . "'$impacto', "
                    . "'$tr', "
                    . "'$complexidade', "
                    . "'$funcao', "
                    . "'" . ($abAtual == 1 ? $id_contagem : $idc) . "', "
                    . "'" . ($abAtual == 1 ? 0 : $id_baseline) . "', "
                    . "'" . ($abAtual == 1 ? 0 : $id_gerador) . "', "
                    . "'$id_metodo', "
                    . "'$id_roteiro', "
                    . "'$operacao', "
                    . "'$pfa', "
                    . "'$pfb', "
                    . "'$td', "
                    . "'$entrega', "
                    . "'$fonte', "
                    . "'" . ($abAtual == 1 ? '' : $obsFuncao) . "', "
                    . "'$inserido_por', "
                    . "'$data_cadastro', "
                    . "'$descricao_tr', "
                    . "'$descricao_td', "
                    . "'$situacao', "
                    . "'$is_mudanca', "
                    . "'$fase_mudanca', "
                    . "'$percentual_fase', "
                    . "'$fd', "
                    . ( $table === 'ali' || $table === 'aie' ? "'$fe', " : '' )
                    . "'" . ($abAtual == 1 ? 0 : $id_relacionamento) . "', "
                    . ($table === 'ee' || $table === 'se' || $table === 'ce' ? "'$id_fator_tecnologia', '$valor_fator_tecnologia', " : '')
                    . "'$ultima_atualizacao', "
                    . "'$atualizado_por')";
            /*
             * insere uma nova funcao so que agora no projeto e pega o id para atualizar o id_gerador
             */
            $stmt = DB::prepare($sql);
            $stmt->execute();
            $id_inserido_projeto = DB::getInstance()->lastInsertId(); //id_gerador
            if ($abAtual != 1) {
                /*
                 * atualiza o id_gerador
                 */
                $fa->atualizaIdGerador($id_inserido_projeto, $id_inserido_baseline);
                /*
                 * atualiza o status da linha original da baseline para inativo
                 */
                $fa->atualizaCampo($table, 'is_ativo', $id_relacionamento, 0);
            }
        }
    }
    echo json_encode(array('status' => true, 'tabela' => $table, 'funcao' => $table === 'ali' || $table === 'aie' ? 'dados' : 'transacao'));
} else {
    echo json_encode(array('status' => false, 'msg' => 'Acesso n&atilde;o autorizado!'));
}