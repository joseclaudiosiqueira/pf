<?php
/**
 * Please note: we can use unencoded characters like ö, é etc here as we use the html5 doctype with utf8 encoding
 * in the application's header (in views/_header.php). To add new languages simply copy this file,
 * and create a language switch in your root files.
 */
// login & registration classes
define ( "MESSAGE_ACCOUNT_NOT_ACTIVATED", "Sua conta ainda não foi ativada. Favor clicar no link de confirmação enviado por email." );
define ( "MESSAGE_CAPTCHA_WRONG", "Captcha incorreto!" );
define ( "MESSAGE_COOKIE_INVALID", "Cookie inválido" );
define ( "MESSAGE_DATABASE_ERROR", "Erro de conexão com o banco de dados." );
define ( "MESSAGE_EMAIL_ALREADY_EXISTS", "Este e-mail já está registrado. Tente usar a \"recuperação de senha\"." );
define ( "MESSAGE_EMAIL_CHANGE_FAILED", "Desculpe, a alteração de e-mail falhou." );
define ( "MESSAGE_EMAIL_CHANGED_SUCCESSFULLY", "Seu e-mail foi alterado com sucesso. Novo e-mail é " );
define ( "MESSAGE_EMAIL_EMPTY", "Email não pode ficar em branco" );
define ( "MESSAGE_EMAIL_INVALID", "Seu e-mail possui um formato inválido" );
define ( "MESSAGE_EMAIL_SAME_LIKE_OLD_ONE", "Desculpe, este email é o mesmo do atual. Por favor informe outro email." );
define ( "MESSAGE_EMAIL_TOO_LONG", "Email não pode ter mais de 255 caracteres" );
define ( "MESSAGE_LINK_PARAMETER_EMPTY", "Link vazio." );
define ( "MESSAGE_LOGGED_OUT", "Você saiu.." );
// The "login failed"-message is a security improved feedback that doesn't show a potential attacker if the user exists or not
define ( "MESSAGE_LOGIN_FAILED", "Login falhou." );
define ( "MESSAGE_OLD_PASSWORD_WRONG", "Sua senha antiga está incorreta." );
define ( "MESSAGE_PASSWORD_BAD_CONFIRM", "As senhas informadas não coincidem" );
define ( "MESSAGE_PASSWORD_CHANGE_FAILED", "Desculpe, a alteração de senha falhou." );
define ( "MESSAGE_PASSWORD_CHANGED_SUCCESSFULLY", "Senha alterada com sucesso!" );
define ( "MESSAGE_PASSWORD_EMPTY", "Senha está em branco" );
define ( "MESSAGE_PASSWORD_RESET_MAIL_FAILED", "Email de recuperação de senha não foi enviado! Erro: " );
define ( "MESSAGE_PASSWORD_RESET_MAIL_SUCCESSFULLY_SENT", "Email de recuperação de senha enviado!" );
define ( "MESSAGE_PASSWORD_TOO_SHORT", "Tamanho mínimo da senha é de 6 caracteres" );
define ( "MESSAGE_PASSWORD_WRONG", "Senha incorreta. Tente novamente." );
define ( "MESSAGE_PASSWORD_WRONG_3_TIMES", "Você inseriu uma senha incorreta 3 vezes ou mais. Favor aguardar 30 segundos e tente novamente." );
define ( "MESSAGE_REGISTRATION_ACTIVATION_NOT_SUCCESSFUL", "Desculpe, nenhum id encontrado..." );
define ( "MESSAGE_REGISTRATION_ACTIVATION_SUCCESSFUL", "Ativação bem sucedida! Você pode entrar agora!" );
define ( "MESSAGE_REGISTRATION_FAILED", "Desculpe, seu registro falhou. Volte e tente novamente." );
define ( "MESSAGE_RESET_LINK_HAS_EXPIRED", "Este link de recuperação expirou. Use o link sempre em menos de uma hora." );
define ( "MESSAGE_VERIFICATION_MAIL_ERROR", "Desculpe, não foi possível enviar um email de verificação. Sua conta não foi criada." );
define ( "MESSAGE_VERIFICATION_MAIL_NOT_SENT", "Email de verificação não foi enviado! Erro: " );
define ( "MESSAGE_VERIFICATION_MAIL_SENT", "Sua conta foi criada e enviamos um email. Clique no link de verificação deste email." );
define ( "MESSAGE_USER_DOES_NOT_EXIST", "Este usuário não existe" );
define ( "MESSAGE_USERNAME_BAD_LENGTH", "Usuário não pode conter menos que 2 caracteres ou mais que 64" );
define ( "MESSAGE_USERNAME_CHANGE_FAILED", "Desculpe, a alteração do nome de usuário falhou" );
define ( "MESSAGE_USERNAME_CHANGED_SUCCESSFULLY", "Seu nome de usuário foi alterado com sucesso. Novo nome de usuário é " );
define ( "MESSAGE_USERNAME_EMPTY", "Campo nome de usuário está vazio" );
define ( "MESSAGE_USERNAME_EXISTS", "Desculpe, este nome de usuário já foi utilizado. Escolha outro." );
define ( "MESSAGE_USERNAME_INVALID", "Nome de usuário fora do padrão: somente a-Z e números são permitidos, 2 a 64 caracteres" );
define ( "MESSAGE_USERNAME_SAME_LIKE_OLD_ONE", "Desculpe, o nome de usuário é o mesmo atual. Escolha outro." );
define ( "MESSAGE_CPF_INVALID", "O CPF digitado n&aacute;o &eacute; v&aacute;lido." );
define ( "MESSAGE_IS_EXISTENTE", "Já existe um usuário cadastrado na sua empresa/fornecedor com estas informações (username, email)" );
// views
define ( "WORDING_BACK_TO_LOGIN", "Retornar ao login" );
define ( "WORDING_CHANGE_EMAIL", "Alterar email" );
define ( "WORDING_CHANGE_PASSWORD", "Alterar senha" );
define ( "WORDING_CHANGE_USERNAME", "Alterar nome de usuário" );
define ( "WORDING_CURRENTLY", "atualmente" );
define ( "WORDING_EDIT_USER_DATA", "Editar dados do usuário" );
define ( "WORDING_EDIT_YOUR_CREDENTIALS", "Você está logado e pode editar suas informações aqui" );
define ( "WORDING_FORGOT_MY_PASSWORD", "Esqueci a senha" );
define ( "WORDING_LOGIN", "Entrar" );
define ( "WORDING_LOGOUT", "Sair" );
define ( "WORDING_NEW_EMAIL", "Novo email" );
define ( "WORDING_NEW_PASSWORD", "Nova senha" );
define ( "WORDING_NEW_PASSWORD_REPEAT", "Repetir nova senha" );
define ( "WORDING_NEW_USERNAME", "Novo nome de usuário (não pode ficar vazio e deve ser azAZ09 e possuir 2-64 caracteres)" );
define ( "WORDING_OLD_PASSWORD", "Sua senha antiga" );
define ( "WORDING_PASSWORD", "Senha" );
define ( "WORDING_PROFILE_PICTURE", "Sua foto de perfil (do gravatar):" );
define ( "WORDING_REGISTER", "Registrar" );
define ( "WORDING_REGISTER_NEW_ACCOUNT", "Registrar nova conta" );
define ( "WORDING_REGISTRATION_CAPTCHA", "Digite os caracteres" );
define ( "WORDING_REGISTRATION_EMAIL", "Email do usuário, válido para ativação | Clique em [ VALIDAR ]" );
define ( "WORDING_ACTIVATION_EMAIL", "Digite o email cadastrado no sistema, é o mesmo no qual você recebeu o link de ativação, e tecle [TAB]." );
define ( "WORDING_REGISTRATION_PASSWORD", "Senha (min. 6 caracteres!)" );
define ( "WORDING_REGISTRATION_PASSWORD_REPEAT", "Repita a senha" );
define ( "WORDING_REGISTRATION_USERNAME", "Selecione uma forma [CPF / World] e clique em [ VALIDAR ]" );
define ( "WORDING_ACTIVATION_USERNAME", "Digite o ID &uacute;nico do usu&aacute;rio ou o seu CPF (apenas os números), e tecle [TAB]" );
define ( "WORDING_REGISTRATION_COMPLETE_USERNAME", "Nome completo do usuário" );
define ( "WORDING_REMEMBER_ME", "Manter logado (por 2 semanas)" );
define ( "WORDING_REQUEST_PASSWORD_RESET", "Informe apenas ID de usu&aacute;rio ou o seu CPF. O sistema enviar&aacute; as instruções de reinicialização da senha para o email cadastrado, caso tenha mais de um, selecione para o qual deseja o envio. Caso voc&ecirc; recorde a senha, descarte a mensagem. <strong>Lembre-se</strong> que voc&ecirc; tem uma hora para reinicializar a senha, caso contr&aacute;rio o link se tornar&aacute; inv&aacute;lido." );
define ( "WORDING_RESET_PASSWORD", "Enviar instruções" );
define ( "WORDING_SUBMIT_NEW_PASSWORD", "Confirmar" );
define ( "WORDING_USERNAME", "Nome de usuário" );
define ( "WORDING_YOU_ARE_LOGGED_IN_AS", "Você está logado como " );
define ( "WORDING_USERNAME_PASSWORD_CHANGE", "Utilize suas informa&ccedil;&otilde;es de LOGIN. <strong>ATEN&Ccedil;&Atilde;O</strong>: digite seu ID &uacute;nico ou o seu CPF, n&atilde;o insira seu email aqui." );
