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
if ($login->isUserLoggedIn()) {
    /*
     * classes
     */
    $fn = new Usuario();
    $cl = new Cliente();
    $cl->setTable('cliente');
    /*
     * variaveis
     */
    $idEmpresa = getIdEmpresa();
    $orderBy = NULL !== filter_input(INPUT_POST, 'orderby', FILTER_SANITIZE_STRING) ? filter_input(INPUT_POST, 'orderby', FILTER_SANITIZE_STRING) : 'user_complete_name';
    $tipo = NULL !== filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_NUMBER_INT) : 0;
    $ret = array();
    $lin = $tipo ? $fn->listaUsuariosTurma($idEmpresa, $orderBy) : $fn->listaUsuarios($idEmpresa, $orderBy);
    /*
     * loop para pegar a sigla do Cliente
     */
    foreach ($lin as $linha) {
        $ret[] = array(
            'RoleId' => $linha['RoleId'],
            'Title' => $linha['Title'],
            'eSigla' => $linha['eSigla'],
            'fSigla' => $linha['fSigla'],
            'id_cliente' => $linha['id_cliente'] ? $cl->getSigla($linha['id_cliente']) : '-',
            'id_empresa' => $linha['id_empresa'],
            'id_fornecedor' => $linha['id_fornecedor'],
            'is_ativo' => $linha['is_ativo'],
            'is_validar_adm_gestor' => $linha['is_validar_adm_gestor'],
            'short_name' => $linha['short_name'],
            'user_complete_name' => $linha['user_complete_name'],
            'user_email' => $linha['user_email'],
            'user_id' => $linha['user_id'],
            'user_active' => $linha['user_active'],
            'tipo' => $linha['tipo'],
            'avatar' => file_exists(DIR_APP . 'vendor/cropper/producao/crop/img/img-user/' . sha1($linha['user_id']) . '.png') ?
                    '/pf/vendor/cropper/producao/crop/img/img-user/' . sha1($linha['user_id']) . '.png' :
                    '/pf/img/user.jpg',
            'sha1' => sha1($linha['user_id']));
    }
    /*
     * retorno json
     */
    echo json_encode($ret);
} else {
    echo json_encode(array('msg' => 'Acesso n&atilde;o autorizado!'));
}

