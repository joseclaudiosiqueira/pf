<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * veriaveis recebidas do formulario
 */
$formNome = filter_input(INPUT_POST, 'n', FILTER_SANITIZE_SPECIAL_CHARS);
$formEmail = filter_input(INPUT_POST, 'e', FILTER_SANITIZE_EMAIL);
$formTelefone = filter_input(INPUT_POST, 't', FILTER_SANITIZE_STRING);
$formMensagem = filter_input(INPUT_POST, 'm', FILTER_SANITIZE_SPECIAL_CHARS);
/*
 * variaveis do email
 */
$formSubject = 'Dimension - Contato no Site';
$formVerificationLink = sha1($formMensagem . date('Ymdhis'));

$objEmail->setEmail(array(
    'emails' => array($formEmail, 'contato@pfdimension.com.br'),
    'subject' => $formSubject,
    'mensagem' => '<font style="font-family: \'Courier New\';">' .
    'Nome: ' . $formNome . '<br />' .
    'Email: ' . $formEmail . '<br />' .
    'Telefone: ' . $formTelefone . '<br />' .
    '----------<br />' .
    $formMensagem .
    '</font>',
    'verificationLink' => $formVerificationLink));

echo json_encode($objEmail->enviar());
