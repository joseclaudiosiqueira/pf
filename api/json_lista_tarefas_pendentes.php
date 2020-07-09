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
    $tr = new Tarefa();
    $ca = new ContagemApontes();
    $ca->setTable('contagem_apontes');
    $cn = new Contagem(); //para pegar a abrangencia da contagem
    $tr->setIdEmpresa(getIdEmpresa());
    $tr->setIdFornecedor(getIdFornecedor());
    $tr->setUserEmailExecutor(getEmailUsuarioLogado());
    $ret = $tr->listarMinhasTarefasPendentes();
    $re1 = array();
    $res = array('draw' => 1, 'recordsTotal' => count($ret), 'recordsFiltered' => count($ret));
    foreach ($ret as $linha) {
        $ini = date_format(date_create($linha['data_inicio']), 'd/m/Y');
        $fim = date_format(date_create($linha['data_fim']), 'd/m/Y');
        $sol = explode('@', $linha['user_email_solicitante']); //pega apenas o user antes do @ do solicitante
        $acao = ''; //insere o link para a acao desejada
        $descricao = $linha['descricao'];
        $abrangencia = $cn->getAbrangencia($linha['id_contagem']);
        //set os valores para os apontes
        $ca->setIdContagem($linha['id_contagem']);
        $ca->setIdTarefa($linha['id']);
        $aponte = $ca->getDescricaoAponte();
        $descricaoAponte = $aponte['aponte'];
        $idAponte = $aponte['id'];
        /*
         * verifica a acao que pode ser feita
         * id descricao
          1  VALIDAÇÃO INTERNA
          2  VALIDAÇÃO EXTERNA
          3  AUDITORIA INTERNA
          4  AUDITORIA EXTERNA
          5  REVISÃO
          6  EDIÇÃO COMPARTILHADA
         * 7 APONTE AUDITORIA INTERNA
         * 8 APONTE AUDITORIA EXTERNA
         * 9 APONTE VALIDACAO INTERNA
         * 10 APONTE VALIDACAO EXTERNA
         * 11 REVISAO VALIDACAO INTERNA
         * 12 REVISAO VALIDACAO EXTERNA
         * 13 VALIDACAO AUTOMATICA DE CONTAGEM
         * 14 ELABORACAO DE CONTAGEM
         */
        switch ($linha['id_tipo']) {
            case 1:
                $acao = '<a href="' . SITE_URL . 'DIM.Gateway.php?arq=0&tch=2&sub=-1&dlg=1&ac=vi&ab=' . $abrangencia['id_abrangencia'] . '&id=' . $linha['id_contagem'] . '"><i class="fa fa-play-circle"></i>&nbsp;INICIAR</a>';
                break;
            case 2:
                $acao = '<a href="' . SITE_URL . 'DIM.Gateway.php?arq=0&tch=2&sub=-1&dlg=1&ac=ve&ab=' . $abrangencia['id_abrangencia'] . '&id=' . $linha['id_contagem'] . '"><i class="fa fa-play-circle"></i>&nbsp;INICIAR</a>';
                break;
            case 3:
                $acao = '<a href="' . SITE_URL . 'DIM.Gateway.php?arq=0&tch=2&sub=-1&dlg=1&ac=ai&ab=' . $abrangencia['id_abrangencia'] . '&id=' . $linha['id_contagem'] . '"><i class="fa fa-play-circle"></i>&nbsp;INICIAR</a>';
                break;
            case 7:
            case 8:
            case 9:
            case 10:
                $descricao .= '<br />'
                        . '<a href="#" data-toggle="collapse" data-target="#descricao' . $linha['id'] . '"><i class="fa fa-plus"></i>&nbsp;Detalhes do aponte</a>'
                        . ' <div class="collapse" id="descricao' . $linha['id'] . '">'
                        . '     <div class="panel">'
                        . '         <div class="panel-body">'
                            . '         <div style="padding: 10px; border:1px dotted #d0d0d0; border-radius: 5px; margin-bottom: 5px;">'
                        . '             ' . $descricaoAponte 
                        . '             </div>'
                        . '             <div id="aponte' . $idAponte . '">'
                        . '                 <textarea class="form-control scroll input_style" rows="5" id="aponte-' . $idAponte . '"></textarea><br />'
                        . '                 <script>CKEDITOR.replace(\'aponte-' . $idAponte . '\');</script>'
                        . '             </div>'
                        . '             <button type="button" class="btn btn-success" onclick="finalizarAponte(' . $idAponte . ', ' . $linha['id'] . ', ' . $linha['id_contagem'] . ');"><i class="fa fa-check-square"></i>&nbsp;Responder e finalizar</button><br /><br />'
                        . '         </div>'
                        . '     </div>'
                        . ' </div>';
                break;
            case 11:
            case 12:
                $acao = '<a href="' . SITE_URL . 'DIM.Gateway.php?arq=0&tch=2&sub=-1&dlg=1&ac=re&ab=' . $abrangencia['id_abrangencia'] . '&id=' . $linha['id_contagem'] . '"><i class="fa fa-play-circle"></i>&nbsp;INICIAR</a>';
                break;
            case 14:
            case 20:
                $acao = '<a href="' . SITE_URL . 'DIM.Gateway.php?arq=0&tch=2&sub=-1&dlg=1&ac=al&ab=' . $abrangencia['id_abrangencia'] . '&id=' . $linha['id_contagem'] . '"><i class="fa fa-arrow-circle-right"></i>&nbsp;CONTINUAR</a>';
                break;
        }
        /*
         * verifica o avatar
         */
        $avatar = file_exists(DIR_APP . 'vendor/cropper/producao/crop/img/img-user/' . sha1($linha['user_id_solicitante']) . '.png') ? '/pf/vendor/cropper/producao/crop/img/img-user/' . sha1($linha['user_id_solicitante']) . '.png?' . date('YmdHis') : '/pf/img/user.png';
        /*
         * compara a data final para verificar se ainda esta no prazo
         * 1 - atrasada
         * 0 - em andamento
         */
        $status = strtotime(date('Y-m-d H:i:s')) > strtotime($linha['data_fim']) ? 1 : 0;
        $re1[] = array(
            'descricao' => $descricao,
            'prazos' => '<strong>Ini: ' . $ini . '<br />'
            . ' <font style="color:' . ($status ? 'red' : 'green') . ';">Fim: ' . $fim . '</font></strong>',
            'solicitante' => '<a href="mailto:' . $linha['user_email_solicitante'] . '"><i class="fa fa-envelope"></i>&nbsp;' . $sol[0] . '</a>',
            'acoes' => $acao,
            'avatar' => '<a href="mailto:' . $linha['user_email_solicitante'] . '"><img src="' . $avatar . '" class="img-circle" width="48" height"48" style="border: 1px solid #d0d0d0;" /></a>'
        );
    }
    $res['data'] = $re1;
    echo json_encode($res);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}