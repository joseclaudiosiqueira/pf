<?php

/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * variaveis do formulario
 */
$tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_SPECIAL_CHARS);
$plano = filter_input(INPUT_POST, 'plano', FILTER_SANITIZE_SPECIAL_CHARS);
$ufEstudante = filter_input(INPUT_POST, 'ufEstudante', FILTER_SANITIZE_SPECIAL_CHARS);
$instituicaoEnsino = filter_input(INPUT_POST, 'instituicaoEnsino', FILTER_SANITIZE_SPECIAL_CHARS);
$cnpjCpf = filter_input(INPUT_POST, 'cnpjCpf', FILTER_SANITIZE_SPECIAL_CHARS);
$nomeEmpresa = filter_input(INPUT_POST, 'nomeEmpresa', FILTER_SANITIZE_SPECIAL_CHARS);
$sigla = filter_input(INPUT_POST, 'sigla', FILTER_SANITIZE_SPECIAL_CHARS);
$cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_SPECIAL_CHARS);
$bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_SPECIAL_CHARS);
$cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_SPECIAL_CHARS);
$txtEstado = filter_input(INPUT_POST, 'txtEstado', FILTER_SANITIZE_SPECIAL_CHARS);
$logradouro = filter_input(INPUT_POST, 'logradouro', FILTER_SANITIZE_SPECIAL_CHARS);
$complemento = filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_SPECIAL_CHARS);
$numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_SPECIAL_CHARS);
$contatoNome = filter_input(INPUT_POST, 'contatoNome', FILTER_SANITIZE_SPECIAL_CHARS);
$contatoEmail = filter_input(INPUT_POST, 'contatoEmail', FILTER_SANITIZE_SPECIAL_CHARS);
$contatoTelefoneFixo = filter_input(INPUT_POST, 'contatoTelefoneFixo', FILTER_SANITIZE_SPECIAL_CHARS);
$contatoRamal = filter_input(INPUT_POST, 'contatoRamal', FILTER_SANITIZE_SPECIAL_CHARS);
$contatoTelefoneCelular = filter_input(INPUT_POST, 'contatoTelefoneCelular', FILTER_SANITIZE_SPECIAL_CHARS);
//nao havera mais contato financeiro
//$contatoNome1 = filter_input(INPUT_POST, 'contatoNome1', FILTER_SANITIZE_SPECIAL_CHARS);
//$contatoEmail1 = filter_input(INPUT_POST, 'contatoEmail1', FILTER_SANITIZE_SPECIAL_CHARS);
//$contatoTelefoneFixo1 = filter_input(INPUT_POST, 'contatoTelefoneFixo1', FILTER_SANITIZE_SPECIAL_CHARS);
//$contatoRamal1 = filter_input(INPUT_POST, 'contatoRamal1', FILTER_SANITIZE_SPECIAL_CHARS);
//$contatoTelefoneCelular1 = filter_input(INPUT_POST, 'contatoTelefoneCelular1', FILTER_SANITIZE_SPECIAL_CHARS);
$observacoes = filter_input(INPUT_POST, 'observacoes', FILTER_SANITIZE_SPECIAL_CHARS);
/*
 * monta a mensagem
 */
$formMensagem = 'Ol&eacute;, estamos muito felizes em saber que voc&ecirc; quer fazer parte do ecossistema Dimension&reg;. '
        . 'Nosso compromisso &eacute; que sua conta seja criada em at&eacute; 24 horas. Veja abaixo as informa&ccedil;&otilde;es que nos enviou.<br />--------------<br />' .
        '<strong>Tipo de cadastro</strong>: ' . ($tipo === 'pf' ? 'Pessoa Física' : ($tipo === 'pj' ? 'Pessoa Jurídica' : 'Estudante')) . '<br />' .
        '<strong>Plano</strong>: ' . ($plano === 'de' ? 'Demo' : 'Empresarial') . '<br />' .
        ($tipo === 'es' ? '<strong>UF Estudante</strong>: ' . $ufEstudante . ' - Instituição: ' . $instituicaoEnsino . '<br />' : '') .
        '<strong>CNPJ/CPF</strong>: ' . $cnpjCpf . '<br />' .
        '<strong>Nome/Nome Fantasia</strong>: ' . $nomeEmpresa . ' - <strong>Sigla</strong>: ' . $sigla . '<br />' .
        '<strong>CEP</strong>: ' . $cep . ' - <strong>Bairro</strong>: ' . $bairro . ' - <strong>Cidade</strong>: ' . $cidade . ' - <strong>UF</strong>: ' . strtoupper($txtEstado) . '<br />' .
        '<strong>Logradouro</strong>: ' . $logradouro . ' - <strong>Complemento</strong>: ' . ($complemento ? $complemento : 'N/A') . ' - <strong>Número</strong>: ' . $numero . '<br />' .
        '<strong>Contato (1)</strong>: ' . $contatoNome . ' - <strong>Email</strong>: ' . $contatoEmail . '<br />' .
        '<strong>Telefone Fixo</strong>: ' . $contatoTelefoneFixo . ' - <strong>Ramal</strong>: ' . ($contatoRamal ? $contatoRamal : 'N/A') . ' - <strong>Celular</strong>: ' . $contatoTelefoneCelular . '<br />' .
        '<strong>Observa&ccedil;&otilde;es</strong>:' . $observacoes;
/*
 * nao havera mais contato financeiro
 * '<strong>Contato (2)</strong>: ' . $contatoNome1 . ' - <strong>Email</strong>: ' . $contatoEmail1 . '<br />' .
 * '<strong>Telefone Fixo</strong>: ' . $contatoTelefoneFixo1 . ' - <strong>Ramal</strong>: ' . ($contatoRamal1 ? $contatoRamal1 : 'N/A') . ' - <strong>Celular</strong>: ' . $contatoTelefoneCelular1 . '<br />' .
 */
/*
 * variaveis do email
 */
$formSubject = 'Dimension - Solicita&ccedil;&atilde;o de cria&ccedil;&atilde;o de conta';
$formVerificationLink = sha1($formMensagem . date('Ymdhis'));
/*
 * envia os emails
 */
$objEmail->setEmail(array(
    'emails' => array($contatoEmail, $contatoEmail1, 'comercial@pfdimension.com.br'),
    'subject' => $formSubject,
    'mensagem' => $formMensagem,
    'verificationLink' => $formVerificationLink));
/*
 * encerra com o retorno
 */
echo json_encode($objEmail->enviar());
