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
$user_id = 0;
$user_email = 0;
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
        <?php include DIR_BASE . 'forms/selo_site_seguro.php'; ?>
        <?php
        if (isset($_GET['i'])) {
            /*
             * monta as variaveis de ID e Email
             */
            $url = explode(';', $converter->decode($_GET['i']));
            $user_id = isset($url[0]) ? $url[0] : 0;
            $user_email = isset($url[1]) ? $url[1] : 0;
            // verifica se esta tudo certo
            if (($user_id && is_numeric($user_id)) && ($user_email && filter_var($user_email, FILTER_VALIDATE_EMAIL))) {
                ?>
                <div class="limiter" id="complexify">
                    <div class="container-login100">
                        <div class="wrap-login100-w780 p-t-20 p-b-20">
                            <form id="form-register-user" role="form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" id="user_id" value="<?= $converter->encode($user_id); ?>"> <input type="hidden" id="activation_hash" value="<?= filter_input(INPUT_GET, 'i', FILTER_SANITIZE_STRING); ?>">                                
                                        <span class="login100-form-title p-b-40"><img src="/pf/img/logo_200px.png" width="56" height="48" align="center">&nbsp;&nbsp;&nbsp;Dimension</span>                     
                                        <div class="m-t-40 m-b-35">
                                            <strong>Ativa&ccedil;&atilde;o de usu&aacute;rio</strong><br />
                                            <p align="justify">
                                                <i id="w-user-name" class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;
                                                <i id="w-user-email" class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;
                                                A senha deve conter no m&iacute;nimo 10 (dez) caracteres, complexidade de 33% (trinta e tr&ecirc;s), letras, n&uacute;meros e outros caracteres como: # $ % @.</p>
                                        </div>                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="wrap-input100 m-t-40 m-b-35">
                                            <input class="input100" id="user-name" type="text" autocomplete="off" required autofocus />
                                            <span class="focus-input100" data-placeholder="ID único ou o CPF"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wrap-input100 m-t-40 m-b-35">
                                            <input class="input100" id="user-email" type="text" autocomplete="off" required disabled />
                                            <span class="focus-input100" data-placeholder="Email cadastrado no sistema"></span>
                                        </div>                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="wrap-input100 m-b-50">
                                            <input class="input100" id="user-password-new" type="password" name="user_password_new" pattern=".{10,}" required disabled autocomplete="off" />
                                            <span class="focus-input100" data-placeholder="Senha"></span>
                                        </div>                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wrap-input100 m-b-50">
                                            <input  class="input100" id="user-password-repeat" type="password" name="user_password_repeat" pattern=".{10,}" required disabled autocomplete="off" />
                                            <span class="focus-input100" data-placeholder="Repita a senha"></span>
                                        </div>                                        
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-6"></div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <center>
                                                <img class="img-thumbnail" alt="captcha"
                                                     id="fmiausu-img-captcha"
                                                     onclick="refreshCaptcha($(this), $('#fmiausu-txt-captcha'));"
                                                     data-toggle="tooltip" data-placement="top"
                                                     title="Clique na imagem para obter outro c&oacute;digo"
                                                     style="border: none;"/><br />
                                            </center>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="wrap-input100 m-b-50">
                                            <!--<label><i class="fa fa-dot-circle-o" id="fmiausu-i-captcha"></i>&nbsp;</label>-->
                                                <input class="input100" type="text"
                                                       id="fmiausu-txt-captcha" name="captcha" autocomplete="off"
                                                       maxlength="4" disabled required />
                                                <span class="focus-input100" data-placeholder="<?php echo WORDING_REGISTRATION_CAPTCHA; ?>"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <div class="row" style="text-align: center;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <button class="login100-form-btn" type="submit" id="btn-new-password" disabled><i class="fa fa-check"></i>&nbsp;<?php echo WORDING_SUBMIT_NEW_PASSWORD; ?></button><br />
                                        <a href="/pf/index.php" class="txt2"><i class="fa fa-times"></i>&nbsp;<?php echo WORDING_BACK_TO_LOGIN; ?></a>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div style="
                     position: absolute; 
                     right: 10px; 
                     top: 50%; 
                     margin-top:-95px; 
                     width: 300px; 
                     min-height: 170px; 
                     border-radius: 
                     10px; 
                     padding: 15px; 
                     border: 1px dotted #d0d0d0;
                     border-bottom: 2px solid #d0d0d0;
                     background-color: rgba(255, 255, 255, .8);" class="wrap-input100">
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
                            <h4>Password Check</h4>
                            <h1 id="password-verify"><i class="fa fa-clock-o"></i></h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <br /><?php include DIR_BASE . 'include/rodape.php'; ?>
                        </div>
                    </div>            
                </div>                     
                <?php
            }
        }
        if (!$user_id || !$user_email) {
            ?>
            <div id="complexify">
                <div class="container-login100">
                    <form id="form-register-user" role="form">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" id="user_id" value="<?= $converter->encode($user_id); ?>"> <input type="hidden" id="activation_hash" value="<?= filter_input(INPUT_GET, 'i', FILTER_SANITIZE_STRING); ?>">                                
                                <span class="login100-form-title p-b-40"><img src="/pf/img/logo_200px.png" width="56" height="48" align="center">&nbsp;&nbsp;&nbsp;Dimension</span>                     
                                <div class="m-t-40 m-b-35">
                                    <h3>
                                        &nbsp;&nbsp;<strong>ATEN&Ccedil;&Atilde;O</strong>: as
                                        informa&ccedil;&otilde;es s&atilde;o
                                        inv&aacute;lidas!&nbsp;&nbsp;
                                    </h3>
                                </div>
                                <br />
                                <div class="row" style="text-align: center;">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <a href="/pf/index.php" class="txt2"><i class="fa fa-times"></i>&nbsp;<?php echo WORDING_BACK_TO_LOGIN; ?></a>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php
        }
        ?>
        <?php include DIR_BASE . 'include/rodape.php'; ?>
        <script type="text/javascript" src="/pf/js/vendor/jquery-1.11.3.min.js" charset="utf-8"></script>
        <script type="text/javascript" src="/pf/js/vendor/bootstrap.min.js" charset="utf-8"></script>
        <script type="text/javascript" src="/pf/js/vendor/sweetalert.min.js" charset="utf-8"></script>
        <script type="text/javascript" src="/pf/js/vendor/jquery.complexify.banlist.js" charset="utf-8"></script>
        <script type="text/javascript" src="/pf/js/vendor/jquery.complexify.js" charset="utf-8"></script>
        <script type="text/javascript" src="/pf/js/vendor/jquery.mask.min.js" charset="utf-8"></script>
        <!-- Dimension scripts -->
        <script type="text/javascript" src="/pf/js/DIM.APIDIM.js" charset="utf-8"></script>
        <script type="text/javascript" src="/pf/js/user/DIM.FRMREGUS.js" charset="utf-8"></script>
        <!--elegant form-->
        <script src="/pf/login/js/main.js"></script>
        <!--end-->     
    </body>
</html>