<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}

/**
 * 
 * @param int $ab Abrangencia da contagem
 * @param int $id Id da contagem
 * @param string $vi Email do validador interno
 */
function emailSolicitarValidacaoInterna($abrangencia, $idContagem, $userEmailExecutor, $objEmail) {
    $subject = 'Dimension - Solicitação de validação interna em contagem';
    $mensagem = 'O(a) Sr(a). <a href="mailto:' . $_SESSION['user_email'] . '">' . $_SESSION['complete_name'] . '</a>,<br /><br />'
            . 'solicita valida&ccedil;&atilde;o interna em uma contagem. '
            . 'Para validar a contagem clique <a href="' . SITE_URL . 'DIM.Gateway.php?arq=0&tch=2&sub=-1&dlg=1&ac=vi&ab=' . $abrangencia . '&id=' . $idContagem . '">AQUI</a>.<br />'
            . 'Para acessar o Dimension&reg; clique <a href="' . SITE_URL . 'DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&id=' . $idContagem . '">AQUI</a> e verifique em suas tarefas pendentes.<br /><br />'
            . 'LEMBRE-SE que voc&ecirc; tem at&eacute; ' . $_SESSION['contagem_config_tarefas']['validacao_interna'] . '( ' . Extenso::valorPorExtenso($_SESSION['contagem_config_tarefas']['validacao_interna'], FALSE) . ' ) dia(s) corridos para realizar a atividade, de acordo como que foi definido pelo Administrador.';
    $verificationLink = sha1($mensagem . date('Ymdhis'));

    $objEmail->setEmail(array(
        'emails' => array($userEmailExecutor),
        'subject' => $subject,
        'mensagem' => $mensagem,
        'verificationLink' => $verificationLink));
    //envia
    $objEmail->enviar();
}

/**
 * 
 * @param int $ab Abrangencia da contagem
 * @param int $id Id da contagem
 * @param string $ve Email do validador externo
 */
function emailSolicitarValidacaoExterna($abrangencia, $idContagem, $userEmailExecutor, $objEmail) {
    $subject = 'Dimension - Solicitação de validação externa em contagem';
    $mensagem = 'O(a) Sr(a). <a href="mailto:' . $_SESSION['user_email'] . '">' . $_SESSION['complete_name'] . '</a>,<br /><br />'
            . 'solicita uma valida&ccedil;&atilde;o externa em uma contagem. '
            . 'Para validar a contagem clique <a href="' . SITE_URL . 'DIM.Gateway.php?arq=0&tch=2&sub=-1&dlg=1&ac=ve&ab=' . $abrangencia . '&id=' . $idContagem . '">AQUI</a>.<br />'
            . 'Para acessar o Dimension&reg; clique <a href="' . SITE_URL . 'DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&id=' . $idContagem . '">AQUI</a> e verifique em suas tarefas pendentes.<br /><br />'
            . 'LEMBRE-SE que voc&ecirc; tem at&eacute; ' . $_SESSION['contagem_config_tarefas']['validacao_externa'] . '( ' . Extenso::valorPorExtenso($_SESSION['contagem_config_tarefas']['validacao_externa'], FALSE) . ' ) dia(s) corridos para realizar a atividade, de acordo como que foi definido entre as partes.';
    //link de verificacao
    $verificationLink = sha1($mensagem . date('Ymdhis'));
    //variaveis do email
    $objEmail->setEmail(array(
        'emails' => array($userEmailExecutor),
        'subject' => $subject,
        'mensagem' => $mensagem,
        'verificationLink' => $verificationLink));
    //envia
    $objEmail->enviar();
}

/**
 * 
 * @param int $ab Abrangencia da contagem
 * @param int $id Id da contagem
 * @param string $vi Email do auditor interno
 */
function emailSolicitarAuditoriaInterna($abrangencia, $idContagem, $userEmailExecutor, $objEmail) {
    $subject = 'Dimension - Solicitação de auditoria interna em contagem';
    $mensagem = 'O(a) Sr(a). <a href="mailto:' . $_SESSION['user_email'] . '">' . $_SESSION['complete_name'] . '</a>,<br /><br />'
            . 'solicita uma auditoria interna em uma contagem. '
            . 'Para auditar a contagem clique <a href="' . SITE_URL . 'DIM.Gateway.php?arq=0&tch=2&sub=-1&dlg=1&ac=ai&ab=' . $abrangencia . '&id=' . $idContagem . '">AQUI</a>.<br />'
            . 'Para acessar o Dimension&reg; clique <a href="' . SITE_URL . 'DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&id=' . $idContagem . '">AQUI</a> e verifique em suas tarefas pendentes.<br /><br />'
            . 'LEMBRE-SE que voc&ecirc; tem at&eacute; ' . $_SESSION['contagem_config_tarefas']['auditoria_interna'] . '( ' . Extenso::valorPorExtenso($_SESSION['contagem_config_tarefas']['auditoria_interna'], FALSE) . ' ) dia(s) corridos para realizar a atividade, de acordo como que foi definido pelo Administrador.';
    //link de verificacao do email
    $verificationLink = sha1($mensagem . date('Ymdhis'));
    //variaveis do email
    $objEmail->setEmail(array(
        'emails' => array($userEmailExecutor),
        'subject' => $subject,
        'mensagem' => $mensagem,
        'verificationLink' => $verificationLink));
    //envia
    $objEmail->enviar();
}

/**
 * 
 * @param int $ab Abrangencia da contagem
 * @param int $id Id da contagem
 * @param string $vi Email do auditor interno
 */
function emailSolicitarAuditoriaExterna($abrangencia, $idContagem, $userEmailExecutor, $userEmailSolicitante, $objEmail) {
    $subject = 'Dimension - Solicitação de auditoria externa em contagem';
    $mensagem = 'O(a) Sr(a). <a href="mailto:' . $userEmailSolicitante . '">' . $_SESSION['complete_name'] . '</a>,<br /><br />'
            . 'solicita uma auditoria externa em uma contagem. '
            . 'Para auditar a contagem clique <a href="' . SITE_URL . 'DIM.Gateway.php?arq=0&tch=2&sub=-1&dlg=1&ac=ae&ab=' . $abrangencia . '&id=' . $idContagem . '">AQUI</a>.<br />'
            . 'Para acessar o Dimension&reg; clique <a href="' . SITE_URL . 'DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&id=' . $idContagem . '">AQUI</a> e verifique em suas tarefas pendentes.<br /><br />'
            . 'LEMBRE-SE que voc&ecirc; tem at&eacute; ' . $_SESSION['contagem_config_tarefas']['auditoria_externa'] . '( ' . Extenso::valorPorExtenso($_SESSION['contagem_config_tarefas']['auditoria_externa'], FALSE) . ' ) dia(s) corridos para realizar a atividade, de acordo como que foi definido pelo Administrador.';
    //link de verificacao do email
    $verificationLink = sha1($mensagem . date('Ymdhis'));
    //variaveis do email
    $objEmail->setEmail(array(
        'emails' => array($userEmailExecutor),
        'subject' => $subject,
        'mensagem' => $mensagem,
        'verificationLink' => $verificationLink));
    //envia
    $objEmail->enviar();
}

/**
 * 
 * @param int $id Id da contagem
 * @param string $resp responsavel pela contagem
 * @param string $tipo vi, ve, ai e ae
 */
function emailInserirAponte($idContagem, $userEmailExecutor, $tipo, $objEmail) {
    $descricao = '';
    switch ($tipo) {
        case 'vi': $descricao = 'valida&ccedil;&atilde;o interna';
            break;
        case 've': $descricao = 'valida&ccedil;&atilde;o externa';
            break;
        case 'ai': $descricao = 'auditoria interna';
            break;
        case 'ae': $descricao = 'auditoria externa';
            break;
    }
    $subject = 'Dimension - Inserção de aponte de ' . $descricao . ' em contagem';
    $mensagem = 'O Sr. ' . $_SESSION['complete_name'] . ',<br />'
            . 'inseriu um aponte de ' . $descricao . '.'
            . ' Para verificar acesse o Dimension&reg; clicando <a href="' . SITE_URL . 'DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&id=' . $idContagem . '">AQUI</a> e verifique em suas tarefas pendentes, menu &lt;Ferramentas&gt; &lt;Listar tarefas&gt;.<br /><br />';
    $verificationLink = sha1($mensagem . date('Ymdhis'));

    $objEmail->setEmail(array(
        'emails' => array($userEmailExecutor),
        'subject' => $subject,
        'mensagem' => $mensagem,
        'verificationLink' => $verificationLink));
    //envia
    $objEmail->enviar();
}

/**
 * 
 * @param int $id Id da contagem
 * @param string $resp responsavel pela contagem
 * @param string $tipo vi, ve, ai e ae
 */
function emailfinalizarAponte($idContagem, $userEmailSolicitante, $tipo, $objEmail) {
    $descricao = '';
    switch ($tipo) {
        case 'vi': $descricao = 'validação interna';
            break;
        case 've': $descricao = 'validação externa';
            break;
        case 'ai': $descricao = 'auditoria interna';
            break;
        case 'ae': $descricao = 'auditoria externa';
            break;
    }
    $subject = 'Dimension - Finalização de aponte de ' . $descricao . ' em contagem';
    $mensagem = 'O(a) Sr(a). ' . $_SESSION['complete_name'] . ',<br />'
            . 'finalizou um aponte de ' . $descricao . '.'
            . ' Para verificar acesse o Dimension&reg; clicando <a href="' . SITE_URL . 'DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&id=' . $idContagem . '">AQUI</a> e verifique em seus apontes registrados.<br /><br />';
    $verificationLink = sha1($mensagem . date('Ymdhis'));

    $objEmail->setEmail(array(
        'emails' => array($userEmailSolicitante),
        'subject' => $subject,
        'mensagem' => $mensagem,
        'verificationLink' => $verificationLink));
    //envia
    $objEmail->enviar();
}

/**
 * 
 * @param String $abrangencia - Abrangencia
 * @param Int $idContagem - Id da contagem
 * @param String $responsavel - responsavel pela revisao
 * @param String $acao - Acao (Validacao Interna ou Externa)
 */
function emailSolicitarRevisaoContagem($abrangencia, $idContagem, $userEmailExecutor, $acao, $objEmail) {
    $subject = 'Dimension - Solicitação de revisão em contagem';
    $mensagem = 'O(a) Sr(a). <a href="mailto:' . $_SESSION['user_email'] . '">' . $_SESSION['complete_name'] . '</a>,<br /><br />'
            . 'durante o processo de valida&ccedil;&atilde;o ' . ($acao === 'vi' ? 'interna' : 'externa') . ', solicita a revis&atilde;o em uma contagem.<br /><br />'
            . 'Para acessar o Dimension&reg; clique <a href="' . SITE_URL . 'DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&id=' . $idContagem . '">AQUI</a>, verifique em suas tarefas pendentes ou '
            . 'v&aacute; direto para a revis&atilde;o clicando <a href="' . SITE_URL . 'DIM.Gateway.php?arq=0&tch=2&sub=-1&dlg=1&id=' . $idContagem . '&ac=re&ab=' . $abrangencia . '">AQUI</a>.<br /><br />'
            . 'LEMBRE-SE que voc&ecirc; tem at&eacute; ' . ($acao === 'vi' ? $_SESSION['revisao_validacao_interna'] : $_SESSION['revisao_validacao_externa'])
            . '( ' . Extenso::valorPorExtenso(($acao === 'vi' ? $_SESSION['contagem_config_tarefas']['revisao_validacao_interna'] : $_SESSION['contagem_config_tarefas']['revisao_validacao_externa']), FALSE) . ' ) dia(s) corridos para realizar a atividade, de acordo como que foi definido pelo Administrador.';
    $verificationLink = sha1($mensagem . date('Ymdhis'));
    //seta as variaveis do email
    $objEmail->setEmail(array(
        'emails' => array($userEmailExecutor),
        'subject' => $subject,
        'mensagem' => $mensagem,
        'verificationLink' => $verificationLink));
    //enviar
    $objEmail->enviar();
}

function emailAvisoRevisaoItensContagem($idContagem, $linhas, $userEmailExecutor, $objEmail) {
    $subject = 'Dimension - Informações on-line sobre revisão de itens (funcionalidades)';
    $mensagem = 'O Sr. <a href="mailto:' . $_SESSION['user_email'] . '">' . $_SESSION['complete_name'] . '</a>,<br />'
            . 'provavelmente solicitará revis&atilde;o do(s) item(ns) abaixo: <br /><br />'
            . $linhas . '<br /><br />'
            . 'Acesse o Dimension&reg; clicando <a href="' . SITE_URL . 'DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&id=' . $idContagem . '">AQUI</a>. Lembre-se que isto &eacute; apenas um aviso, que ainda n&atilde;o gerou uma atividade pendente.<br /><br />'
            . 'Quanto uma atividade for gerada, voc&ecirc; terá at&eacute; ' . $_SESSION['contagem_config_tarefas']['revisao_validacao_interna'] . '( ' . Extenso::valorPorExtenso($_SESSION['contagem_config_tarefas']['revisao_validacao_interna'], FALSE) . ' ) dia(s) corridos para realizar a atividade, de acordo como que foi definido pelo Administrador.';
    $verificationLink = sha1($mensagem . date('Ymdhis'));
    //seta as variaveis do email
    $objEmail->setEmail(array(
        'emails' => array($userEmailExecutor),
        'subject' => $subject,
        'mensagem' => $mensagem,
        'verificationLink' => $verificationLink));
    //enviar
    $objEmail->enviar();
}

function enviaEmailComentario($tabela, $destinatario, $funcao, $comentario, $objEmail) {
    $subject = 'Dimension - aviso sobre inserção de comentário';
    $mensagem = 'O Sr. <a href="mailto:' . $_SESSION['user_email'] . '">' . $_SESSION['complete_name'] . '</a>,<br />'
            . 'inseriu um comentário que pode ser de seu interesse.<br /><br />'
            . 'TIPO: ' . strtoupper($tabela) . '<br />'
            . 'FUNÇÃO: ' . $funcao['funcao'] . '<br />'
            . 'COMENTÁRIO: ' . $comentario . '<br /><br />'
            . 'Acesse o Dimension&reg; clicando <a href="' . SITE_URL . 'DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&id=' . $funcao['id_contagem'] . '">AQUI</a>. Lembre-se que isto &eacute; apenas um aviso e que n&atilde;o gera nenhuma atividade pendente.';
    $verificationLink = sha1($mensagem . date('Ymdhis'));
    //seta as variaveis do email
    $objEmail->setEmail(array(
        'emails' => array($destinatario),
        'subject' => $subject,
        'mensagem' => $mensagem,
        'verificationLink' => $verificationLink));
    //enviar
    $objEmail->enviar();
}

function emailValidarContagem($idContagem, $tipo, $responsavel, $objEmail) {
    $descricao = '';
    switch ($tipo) {
        case 'vi': $descricao = 'a validação interna';
            break;
        case 've': $descricao = 'a validação externa';
            break;
        case 'ai': $descricao = 'a auditoria interna';
            break;
        case 'ae': $descricao = 'a auditoria externa';
            break;
    }
    $subject = 'Dimension - Validação interna em contagem concluída';
    $mensagem = 'O(a) Sr(a). <a href="mailto:' . $_SESSION['user_email'] . '">' . $_SESSION['complete_name'] . '</a>,<br /><br />'
            . 'Finalizou ' . $descricao . ' em uma contagem. '
            . 'Para acessar clique <a href="' . SITE_URL . 'DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&id=' . $idContagem . '">AQUI</a>.';
    //verification link
    $verificationLink = sha1($mensagem . date('Ymdhis'));
    //variaveis da mensagem
    $objEmail->setEmail(array(
        'emails' => array($responsavel),
        'subject' => $subject,
        'mensagem' => $mensagem,
        'verificationLink' => $verificationLink));
    //envia
    $objEmail->enviar();
}

/**
 * 
 * @param int $id Id da contagem
 * @param string $ve Email do fiscal do contrato
 */
function emailSolicitarFaturamento($idContagem, $userEmailExecutor, $objEmail) {
    $subject = 'Dimension - Solicitação de faturamento em contagem';
    $mensagem = 'O(a) Sr(a). <a href="mailto:' . $_SESSION['user_email'] . '">' . $_SESSION['complete_name'] . '</a>,<br /><br />'
            . 'solicita o faturamento de uma contagem. '
            . 'Para acessar o Dimension&reg; clique <a href="' . SITE_URL . 'DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&id=' . $idContagem . '">AQUI</a> e verifique em suas tarefas pendentes.<br /><br />'
            . 'LEMBRE-SE que voc&ecirc; tem at&eacute; ' . $_SESSION['contagem_config_tarefas']['faturamento'] . '( ' . Extenso::valorPorExtenso($_SESSION['contagem_config_tarefas']['faturamento'], FALSE) . ' ) dia(s) corridos para realizar a atividade, de acordo como que foi definido entre as partes.';
    //link de verificacao
    $verificationLink = sha1($mensagem . date('Ymdhis'));
    //variaveis do email
    $objEmail->setEmail(array(
        'emails' => array($userEmailExecutor),
        'subject' => $subject,
        'mensagem' => $mensagem,
        'verificationLink' => $verificationLink));
    //envia
    $objEmail->enviar();
}

function emailAvisoAutorizacaoFaturamento($idContagem, $userEmailSolicitante, $objEmail) {
    $subject = 'Dimension - Autorização de faturamento em contagem';
    $mensagem = 'O(a) Sr(a). <a href="mailto:' . $_SESSION['user_email'] . '">' . $_SESSION['complete_name'] . '</a>,<br /><br />'
            . 'autorizou o faturamento de uma contagem. '
            . 'Para acessar o Dimension&reg; clique <a href="' . SITE_URL . 'DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1&id=' . $idContagem . '">AQUI</a>.<br /><br />';
    //link de verificacao
    $verificationLink = sha1($mensagem . date('Ymdhis'));
    //variaveis do email
    $objEmail->setEmail(array(
        'emails' => array($userEmailSolicitante),
        'subject' => $subject,
        'mensagem' => $mensagem,
        'verificationLink' => $verificationLink));
    //envia
    $objEmail->enviar();
}

function emailAvisoFaturar($arrFaturar, $responsavelFaturamento, $objEmail, $arquivoEmail) {
    $subject = 'Dimension - Arquivo de faturamento disponível para download';
    $mensagem = 'Voc&ecirc; solicitou a gera&ccedil;&atilde;o de um faturamento no Dimension e o arquivo encontra-se dispon&iacute;vel para <i>download</i>.<br /><br />'
            . 'Para acessar o arquivo clique <a href="' . SITE_URL . 'arquivos/download.php?l=' . $converter->encode($arquivoEmail) . '">AQUI</a>.<br /><br />'
            . '<strong>LEMBRE-SE</strong>: para efeturar o <i>download</i> voc&ecirc; precisa estar logado no sistema, caso n&atilde;o esteja o Dimension ir&aacute; solicitar o login.';
    //link de verificacao
    $verificationLink = sha1($mensagem . date('Ymdhis'));
    //variaveis do email
    $objEmail->setEmail(array(
        'emails' => array($responsavelFaturamento),
        'subject' => $subject,
        'mensagem' => $mensagem,
        'verificationLink' => $verificationLink));
    //envia
    $objEmail->enviar();
}
