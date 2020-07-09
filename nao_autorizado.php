<?php
require_once $_SERVER['DOCUMENT_ROOT'] . (substr($_SERVER['DOCUMENT_ROOT'], -1) === '/' ? '' : '/') . 'pf/conf/conf.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Dimension - Metricas">
        <meta name="author" content="Dimension">
        <meta http-equiv="Expires" CONTENT="0">
        <meta http-equiv="Cache-Control" CONTENT="no-cache">
        <meta http-equiv="Pragma" CONTENT="no-cache">    
        <link rel="icon" href="/pf/img/favicon.ico">
        <link rel="stylesheet" type="text/css" href="/pf/css/vendor/bootstrap/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="/pf/css/vendor/font-awesome/font-awesome.css">
        <title>Dimension - M&eacute;tricas</title>
        <style type="text/css">
            /*<?= date('d') ?>*/
            body{ 
                background: url('/pf/img/background/83.jpg') fixed; background-size: cover;
                padding-top:54px;
                font-size: 13px;
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                font-family: 'Tahoma', sans-serif;
                overflow-x: hidden;
            }
        </style>
    </head>
    <body>
        <div class="container" style="color:#FFF;">
            <h1>
                <img src="/pf/img/logo_200px.png" class="img-responsive" width="64" height="64" align="left">&nbsp;&nbsp;&nbsp;Dimension
            </h1>
            <div class="jumbotron" style="background:rgba(124,124,124,.5);">
                <center>
                    <h2>
                        Acesso n&atilde;o autorizado!
                    </h2>
                    <img src="/pf/img/nao_autorizado.png" width="200" height="200">
                    <br />
                    <br />
                    <br />
                    Informamos que de acordo com a nossa pol&iacute;tica de privacidade todas as tentativas de acesso
                    n&atilde;o autorizado a qualquer informa&ccedil;&atilde;o no Dimension&reg; ser&atilde;o gravadas para posterior an&aacute;lise.
                    <br />
                    Copyright &copy; 2015-<?= date('Y'); ?>. Todos os direitos reservados. Clique <strong><a href="/pf/index.php">aqui</a></strong> para ir &agrave; p&aacute;gina inicial.<br /><br/>
                </center>
            </div>
        </div>        
    </body>
</html>
