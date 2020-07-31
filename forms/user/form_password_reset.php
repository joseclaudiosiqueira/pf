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
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Dimension - Analise, Pontos de Funcao">
        <meta name="author" content="PF>Dimension">
        <link rel="icon" href="/pf/img/favicon.ico">
        <title>Dimension - Reinicializa&ccedil;&atilde;o de senha</title>
        <!--stylesheets login clean-->
        <link rel="stylesheet" type="text/css" href="/pf/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="/pf/login/css/util.css">
        <link rel="stylesheet" type="text/css" href="/pf/login/css/main.css">
        <!--css Dimension-->
        <link rel="stylesheet" href="/pf/css/vendor/bootstrap/bootstrap.css">
        <link rel="stylesheet" href="/pf/css/vendor/font-awesome/font-awesome.css">
        <link rel="stylesheet" href="/pf/css/dimension.css">
        <link rel="stylesheet" href="/pf/css/vendor/sweetalert/sweetalert.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Abel">
        <!--semantic ui-->
        <link rel="stylesheet" type="text/css" href="/pf/js/vendor/semantic-ui/semantic.css">
        <link rel="stylesheet" type="text/css" href="/pf/js/vendor/semantic-ui/components/label.css">       
        <style>
            body {
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                font-family: 'Abel', sans-serif;
                overflow-x: hidden;
            }
        </style>
    </head>
    <body>
        <?php
        /*
         * include de cabecalho
         */
        include DIR_BASE . 'forms/selo_site_seguro.php';
        /*
         * solicitacoes de INPUT_GET
         */
        $user_name = NULL !== filter_input(INPUT_GET, 'u') ? $converter->decode(filter_input(INPUT_GET, 'u')) : '';
        $verification_code = NULL !== filter_input(INPUT_GET, 'v') ? filter_input(INPUT_GET, 'v') : '';
        /*
         * verificacoes
         */
        if ($user_name !== '' && $verification_code !== '') {
            $login->checkIfEmailVerificationCodeIsValid($user_name, $verification_code);
        }
        if ($login->passwordResetLinkIsValid()) {
            ?>
            <div class="limiter" id="complexify">
                <div class="container-login100">
                    <div class="wrap-login100 p-t-40 p-b-20">
                        <form id="form-password-change" role="form">
                            <input type='hidden' id="user-name" value='<?php echo htmlspecialchars($_GET['u']); ?>' />
                            <input type='hidden' id="user-password-reset-hash" value='<?php echo htmlspecialchars($_GET['v']); ?>' />
                            <span class="login100-form-title p-b-40">
                                <img src="/pf/img/logo_200px.png" width="56" height="48" align="center">&nbsp;&nbsp;&nbsp;Dimension
                            </span>                     
                            <div class="m-t-40 m-b-35">
                                <p align="justify">No m&iacute;nimo 10 (dez) caracteres,
                                    complexidade de 33% (trinta e tr&ecirc;s),
                                    letras, n&uacute;meros e outros caracteres como: # $ % @.
                                </p>
                            </div>                        
                            <div class="wrap-input100 m-t-40 m-b-35">
                                <input class="input100" id="user-name" type="text" autocomplete="off" required autofocus />
                                <span class="focus-input100" data-placeholder="Apenas ID único ou CPF"></span>
                            </div>
                            <div class="wrap-input100 m-b-50">
                                <input class="input100" id="user-password-new" type="password" name="user_password_new" pattern=".{10,}" required autofocus autocomplete="off" />
                                <span class="focus-input100" data-placeholder="Nova senha"></span>
                            </div>
                            <div class="wrap-input100 m-b-50">
                                <input  class="input100" id="user-password-repeat" type="password" name="user_password_repeat" pattern=".{10,}" required autocomplete="off" />
                                <span class="focus-input100" data-placeholder="Repita a nova senha"></span>
                            </div>
                            <div class="container-login100-form-btn">
                                <div class="row" style="text-align: center;">
                                    <button class="login100-form-btn" type="submit" id="btn-new-password" disabled><i class="fa fa-check"></i>&nbsp;<?php echo WORDING_SUBMIT_NEW_PASSWORD; ?></button><br />
                                    <a data-toggle="tooltip" data-placement="top" title="
                                       Aten&ccedil;&atilde;o: o link para reinicializacao da senha fica ativo por apenas uma hora, 
                                       caso n&atilde;o fa&ccedil;a a opera&ccedil;&atilde;o neste momento e ultrapasse o tempo limite, 
                                       voc&ecirc; dever&aacute; solicitar a reinicializa&ccedil;&atilde;o novamente." href="/pf/index.php" class="txt2">
                                        <i class="fa fa-times"></i>&nbsp;<?php echo WORDING_BACK_TO_LOGIN; ?></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div style="position: absolute; right: 10px; top: 50%; margin-top:-95px; width: 300px; height: 170px; border-radius: 10px; padding: 15px;" class="wrap-input100">
                <div class="row">
                    <div class="col-md-12">
                        <div class="progress">
                            <div id="complexity-bar" class="progress-bar" role="progressbar"></div>
                        </div>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-md-6" style="text-align: center;">
                        <h4>Complexidade</h4>
                        <h1 id="complexity">0%</h1>
                    </div>
                    <div class="col-md-6" style="text-align: center">
                        <h1 id="password-verify">
                            <i class="fa fa-clock-o"></i>
                        </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <br />
                        <?php include DIR_BASE . 'include/rodape.php'; ?>
                    </div>
                </div>            
            </div>      
            <!-- no data from a password-reset-mail has been provided, so we simply show the request-a-password-reset form -->
        <?php } else { ?>
            <div class="limiter" id="complexify">
                <div class="container-login100">
                    <div class="wrap-login100 p-t-40 p-b-20">
                        <form id="form-password-request" role="form">
                            <input type="hidden" id="tipo-login" name="tipo-login" value="nuvem">
                            <input type="hidden" id="opcao-identificador" name="opcao-identificador" value="0"><?= NULL !== $url ? '<input type="hidden" id="url" value="' . $url . '">' : ''; ?>
                            <span class="login100-form-title p-b-40">
                                <img src="/pf/img/logo_200px.png" width="56" height="48" align="center">&nbsp;&nbsp;&nbsp;Dimension
                            </span>                     
                            <div class="m-t-40 m-b-35">
                                <p align="justify"><?php echo WORDING_REQUEST_PASSWORD_RESET; ?></p>
                            </div>                        
                            <div class="wrap-input100 m-t-40 m-b-35">
                                <input class="input100" name="user-name" id="user-name" type="text" autocomplete="off" required autofocus />
                                <span class="focus-input100" data-placeholder="Apenas ID único ou CPF"></span>
                            </div>
                            <div class="m-b-50">
                                <label for="user-email"><p>Selecione um email para envio o das instru&ccedil;&otilde;es</p></label>
                                <select id="user-email" name="user-email" class="input100" style="border: 0; border-bottom: 2px solid #d9d9d9;">
                                    <option value="0">Aguardando...</option>
                                </select>                            
                            </div>
                            <div class="container-login100-form-btn">
                                <div class="row" style="text-align: center;">
                                    <button class="login100-form-btn" type="submit"><i class="fa fa-check"></i>&nbsp;<?php echo WORDING_RESET_PASSWORD; ?></button><br />
                                    <a href="/pf/index.php" class="txt2" style="line-break: loose;"><i class="fa fa-times"></i>&nbsp;<?php echo WORDING_BACK_TO_LOGIN; ?></a>
                                </div>
                            </div>                            
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php include DIR_BASE . 'include/rodape.php'; ?>
        <script type="text/javascript" src="/pf/js/vendor/jquery-1.11.3.min.js" charset="utf-8"></script>
        <script type="text/javascript" src="/pf/js/vendor/bootstrap.min.js" charset="utf-8"></script>
        <script type="text/javascript" src="/pf/js/vendor/sweetalert.min.js" charset="utf-8"></script>
        <script type="text/javascript" src="/pf/js/vendor/jquery.complexify.banlist.js" charset="utf-8"></script>
        <script type="text/javascript" src="/pf/js/vendor/jquery.complexify.js" charset="utf-8"></script>
        <!--labelholder-->
        <script type="text/javascript" src="/pf/js/vendor/labelholder/labelholder.min.js"></script>
        <!-- Dimension scripts -->
        <script type="text/javascript" src="/pf/js/user/DIM.FRMPASRE.js" charset="utf-8"></script>
        <!--Inicializacoes-->
        <!--end-->
        <script src="/pf/login/js/main.js"></script>
        <!--end-->           
        <script>
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
<?php
/*
 * apenas para alertar ao usuario que o link de reinicializacao de senha nao eh mais valido caso ele venha pela url
 */
if (($user_name || $verification_code) && !$login->passwordResetLinkIsValid()) {
    ?>
                    swal({
                        title: "Alerta",
                        text: "O link de reinicializa&ccedil;&atilde;o de senha n&atilde;o &eacute; mais v&aacute;lido. Por favor solicite novamente.",
                        type: "error",
                        html: true,
                        confirmButtonText: "Obrigado!"});
    <?php
}
?>
            });
            (function ($) {
                $('#user-password-new').complexify({}, function (valid, complexity) {
                    var progressBar = $('#complexity-bar');
                    progressBar.toggleClass('progress-bar-success', valid);
                    progressBar.toggleClass('progress-bar-danger', !valid);
                    progressBar.css({'width': complexity + '%'});
                    $('#complexity').text(Math.round(complexity) + '%');
                    passwordComplexity = Math.round(complexity);
                });
            })(jQuery);
            //labelholder
            $('.labelholder').labelholder();
        </script>
    </body>
</html>

