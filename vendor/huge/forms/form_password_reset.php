<?php include $_SERVER['DOCUMENT_ROOT'] . 'pf/conf/conf.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Dimension - Analise, Pontos de Funcao">
        <meta name="author" content="PF>Dimension">
        <link rel="icon" href="/pf/img/favicon.ico">
        <title>Dimension - Password reset</title>
        <link href="/pf/css/bootstrap.css" rel="stylesheet">
        <link href="/pf/css/font-awesome.min.css" rel="stylesheet">
        <link href="/pf/css/dimension.css" rel="stylesheet">
        <link href="/pf/css/sweetalert.css" rel="stylesheet">
    </head>
    <body style="overflow-x:hidden;overflow-y:auto;">
        <div class="container">
            <?php
            $user_name = filter_input(INPUT_GET, 'user_name');
            $verification_code = filter_input(INPUT_GET, 'verification_code');
            $login->checkIfEmailVerificationCodeIsValid($user_name, $verification_code);

            if ($login->passwordResetLinkIsValid()) {
                ?>
                <form method="post" role="form">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6" style="background:rgba(255,255,255,.8); padding:30px;">
                            <div class="row">
                                <div class="col-md-12">
                                    <center><img src="/pf/img/Dimension.png" class="img-thumbnail"></center>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Reinicializa&ccedil;&atilde;o de senha</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">                    
                                        <input type='hidden' name='user_name' value='<?php echo htmlspecialchars($_GET['user_name']); ?>' />
                                        <input type='hidden' name='user_password_reset_hash' value='<?php echo htmlspecialchars($_GET['verification_code']); ?>' />
                                        <label for="user_password_new"><?php echo WORDING_NEW_PASSWORD; ?></label>
                                        <input class="form-control" id="user_password_new" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="user_password_repeat"><?php echo WORDING_NEW_PASSWORD_REPEAT; ?></label>
                                        <input class="form-control" id="user_password_repeat" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button class="btn btn-success" type="submit" name="submit_new_password"><?php echo WORDING_SUBMIT_NEW_PASSWORD; ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                </form>
                <!-- no data from a password-reset-mail has been provided, so we simply show the request-a-password-reset form -->
            <?php } else { ?>
                <form method="post" action="password_reset.php" name="password_reset_form" role="form">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6" style="background:rgba(255,255,255,.8); padding:30px;">
                            <div class="row">
                                <div class="col-md-12">
                                    <center><img src="/pf/img/Dimension.png" class="img-thumbnail"></center>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Reinicializa&ccedil;&atilde;o de senha</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="user_name"><?php echo WORDING_REQUEST_PASSWORD_RESET; ?></label>
                                        <input class="form-control" id="user_name" type="text" name="user_name" required />
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-success" type="submit" name="request_password_reset"><?php echo WORDING_RESET_PASSWORD; ?></button>&nbsp;
                                        <a href="/pf/index.php"><?php echo WORDING_BACK_TO_LOGIN; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                </form>
            <?php } ?>
            <div class="row">
                <div class="col-md-12" style="text-shadow:0px 1px #000;color:white;">
                    <center><small>Copyright &copy; 2014-<?= date('Y'); ?> Dimension. Mais informa&ccedil;&otilde;es no <a href="http://pfdimension.com.br/site">s&iacute;tio</a>.</small></center>
                </div>
            </div> 
        </div>
        <script type="text/javascript" src="/pf/js/jquery-1.11.3.min.js" charset="utf-8"></script>
        <script type="text/javascript" src="/pf/js/bootstrap.min.js" charset="utf-8"></script>
        <script type="text/javascript" src="/pf/js/sweetalert.min.js" charset="utf-8"></script>
    </body>
</html>

