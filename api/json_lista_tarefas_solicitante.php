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
    $us = new Usuario();
    $tr = new Tarefa();
    $ca = new ContagemApontes();
    $tr->setIdEmpresa(getIdEmpresa());
    $tr->setIdFornecedor(getIdFornecedor());
    $tr->setUserEmailSolicitante(getEmailUsuarioLogado());
    $ret = $tr->listarTarefasSolicitante();
    $re1 = array();
    $res = array('draw' => 1, 'recordsTotal' => count($ret), 'recordsFiltered' => count($ret));
    foreach ($ret as $linha) {
        $ini = date_format(date_create($linha['data_inicio']), 'd/m/Y');
        $fim = date_format(date_create($linha['data_fim']), 'd/m/Y');
        $exe = $linha['user_email_executor'] ? explode('@', $linha['user_email_executor']) : 0; //pega apenas o user antes do @ do executor
        $descricao = $linha['descricao'];
        //set os valores para os apontes
        $ca->setIdContagem($linha['id_contagem']);
        $ca->setIdTarefa($linha['id']);
        $descricaoAponte = $ca->getDescricaoAponte()['aponte'];
        /*
         * pega o id do usuario executor pelo email
         */
        $userId = $linha['user_id_executor'] ? $us->getIDByEmail(getIdEmpresa(), getIdFornecedor(), $linha['user_email_executor']) : 0;
        /*
         * compara a data final para verificar se ainda esta no prazo
         * 1 - atrasada
         * 0 - em andamento
         */
        $status = strtotime(date('Y-m-d H:i:s')) > strtotime($linha['data_fim']) ? 1 : 0;
        //apenas para apontes de validacao e auditorias
        switch ($linha['id_tipo']) {
            case 7:
            case 8:
            case 9:
            case 10:
                $descricao .= '.&nbsp;&nbsp;<a href="#" data-toggle="collapse" data-target="#descricao' . $linha['id'] . '"><i class="fa fa-plus"></i>&nbsp;Detalhes</a>'
                        . '<div class="collapse" id="descricao' . $linha['id'] . '"><div class="well well-sm">' . $descricaoAponte . '</div></div>';
                break;
        }
        /*
         * verifica o avatar
         */
        $avatar = file_exists(DIR_APP . 'vendor/cropper/producao/crop/img/img-user/' . sha1($userId['id_user']) . '.png') ? '/pf/vendor/cropper/producao/crop/img/img-user/' . sha1($userId['id_user']) . '.png?' . date('YmdHis') : '/pf/img/user.png';
        $re1[] = array(
            'descricao' => $descricao,
            'executor' => '',
            'prazos' => '<strong>Ini: ' . $ini . '<br />'
            . ' <font style="color:' . ($status ? 'red' : 'green') . ';">Fim: ' . $fim . '</font></strong>',
            'acoes' => '',
            'avatar' => '<a href="mailto:' . $linha['user_email_executor'] . '"><img src="' . $avatar . '" class="img-circle" width="48" height"48" style="border: 1px solid #d0d0d0;" /></a>'
        );
    }
    $res['data'] = $re1;
    echo json_encode($res);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}