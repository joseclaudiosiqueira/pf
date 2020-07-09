<?php
include $_SERVER['DOCUMENT_ROOT'] . (substr($_SERVER['DOCUMENT_ROOT'], -1) === '/' ? '' : '/') . 'pf/conf/conf.php';
$avatar_id = '';
if ('emp' === filter_input(INPUT_GET, 't', FILTER_SANITIZE_STRING)) {
    $avatar_id = getIdEmpresa();
} elseif ('user' === filter_input(INPUT_GET, 't', FILTER_SANITIZE_STRING)) {
    $avatar_id = $converter->decode(getUserId());
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/pf/css/dimension.css">
        <link rel="stylesheet" href="/pf/css/vendor/bootstrap/bootstrap.css">
        <link rel="stylesheet" href="/pf/vendor/cropper/dist/cropper.min.css">
        <link rel="stylesheet" href="/pf/css/vendor/font-awesome/font-awesome.css">
        <link rel="stylesheet" href="/pf/css/vendor/sweetalert/sweetalert.css">
        <link rel="stylesheet" href="/pf/vendor/fileUpload/css/jquery.fileupload.css">
        <!--
        <link href="https://fonts.googleapis.com/css?family=Abel:400,400i,700" rel="stylesheet">-->
        <link rel="stylesheet" href="css/main.css">
        <style type="text/css">
            body{
                /*font-family: 'Abel', sans-serif;*/
                font-size: 16px;
                font-weight: 400;
                overflow: hidden;
            }
        </style>        
    </head>
    <body class="scroll">
        <div class="container" id="crop-avatar">
            <!-- Current avatar -->
            <div class="avatar-view" title="Clique para alterar a imagem">
                <div style="text-align: center;">
                    <img src="/pf/img/empty_logo.pt_BR.jpg" id="avatar_img" alt="Avatar" class="img-thumbnail">
                </div>
            </div>
            <div style="text-align: center;">
                Para alterar e/ou inserir clique na imagem<br />
                <i class="fa fa-lightbulb-o"></i>&nbsp;DICA - d&ecirc; prefer&ecirc;ncia a .JPG ou .PNG.<br />Se estiver inserindo uma logomarca, tente utilizar uma imagem com o fundo branco
            </div>
            <!-- Cropping modal -->
            <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
                <div class="modal-dialog modal-lg" style="max-width: 95%;">
                    <form class="avatar-form" action="crop.php" enctype="multipart/form-data" method="post">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="user_detail_btn_fechar"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                                <i class="fa fa-user"></i>&nbsp;&nbsp;Imagem para o <i>avatar</i><br />
                                <span class="sub-header">Selecione uma imagem no formato apropriado, edite e confirme</span>
                            </div>                        
                            <div class="modal-body">
                                <input type="hidden" class="avatar-src" name="avatar_src">
                                <input type="hidden" class="avatar-data" name="avatar_data">
                                <input type="hidden" class="avatar-tipo" name="avatar_tipo" value="<?= NULL !== filter_input(INPUT_GET, 't', FILTER_SANITIZE_STRING) ? filter_input(INPUT_GET, 't', FILTER_SANITIZE_STRING) : 'img'; ?>">
                                <input type="hidden" class="avatar-id" name="avatar_id" id="avatar_id" value="<?= $avatar_id; ?>">
                                <input type="hidden" class="avatar-tipo-fornecedor" name="avatar_tipo_forncedor" value="<?= getTipoFornecedor(); ?>">
                                <!-- Crop and preview -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="avatar-preview preview-md"></div>
                                        <div class="avatar-preview preview-sm"></div>                                            
                                    </div>
                                    <div class="col-md-8">
                                        <div class="avatar-wrapper"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <span class="btn btn-success fileinput-button" id="btn-adicionar-arquivo">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    <span>Selecionar uma imagem</span>
                                    <input type="file" class="avatar-input" id="avatarInput" name="avatar_file">
                                </span>&nbsp;&nbsp;
                                <button type="submit" class="btn btn-primary avatar-save"><i class="fa fa-save"></i>&nbsp;Conclu&iacute;do</button>&nbsp;&nbsp;&nbsp;
                                <a href="#" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal -->
            <!-- Loading state -->
            <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
        </div>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->        
        <script src="/pf/js/vendor/jquery-1.11.3.min.js"></script>
        <script src="/pf/js/vendor/bootstrap.min.js"></script>
        <script src="/pf/js/vendor/sweetalert.min.js"></script>
        <script src="/pf/vendor/cropper/dist/cropper.min.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>
