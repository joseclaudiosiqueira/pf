<?php
include $_SERVER['DOCUMENT_ROOT'] . 'pf/conf/conf.php';
?>
<!DOCTYPE HTML>
<!--
/*
 * jQuery File Upload Plugin Demo 9.1.0
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
-->
<html lang="en">
    <head>
        <!-- Force latest IE rendering engine or ChromeFrame if installed -->
        <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap styles -->
        <link rel="stylesheet" href="/pf/css/bootstrap.css">
        <!-- Generic page styles -->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="/pf/css/box-table.css">
        <!-- blueimp Gallery styles -->
        <link rel="stylesheet" href="css/blueimp-gallery.min.css">
        <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
        <link rel="stylesheet" href="css/jquery.fileupload.css">
        <link rel="stylesheet" href="css/jquery.fileupload-ui.css">
        <!-- CSS adjustments for browsers with JavaScript disabled -->
        <noscript><link rel="stylesheet" href="css/jquery.fileupload-noscript.css"></noscript>
        <noscript><link rel="stylesheet" href="css/jquery.fileupload-ui-noscript.css"></noscript>
    </head>
    <body style="padding:10px;overflow-x:hidden;overflow-y:scroll;" class="scroll">       
        <!-- The file upload form used as target for the file upload widget -->
        <form id="fileupload" method="POST" enctype="multipart/form-data">
            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
            <div class="row fileupload-buttonbar">
                <div class="col-lg-5">
                    <!-- The fileinput-button span is used to style the file input field as button -->
                    <span class="btn btn-success fileinput-button btn-sm" id="btn-adicionar-arquivo">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>Adicionar</span>
                        <input type="file" name="files[]" multiple>
                    </span>
                    <button type="submit" class="btn btn-primary btn-sm start">
                        <i class="glyphicon glyphicon-upload"></i>
                        <span>Iniciar <i>upload</i></span>
                    </button>
                    <button type="reset" class="btn btn-warning btn-sm cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Cancelar</span>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm delete">
                        <i class="glyphicon glyphicon-trash"></i>
                        <span>Deletar</span>
                    </button>
                    <input type="checkbox" class="toggle" id="chk-sel-todos">
                    <label for="chk-sel-todos">Selecionar todos</label>
                    <!-- The global file processing state -->
                    <span class="fileupload-process"></span>
                </div>
                <div class="col-lg-3">
                    <p style="text-align: justify;">
                        O plano contratado por sua empresa permite anexar no m&aacute;ximo 
                        <?= getConfigPlano('quantidade_arquivos_contagem'); ?>
                        (<?= Extenso::valorPorExtenso(getConfigPlano('quantidade_arquivos_contagem'), false, false); ?>) arquivos, com
                        <?= tamanhoArquivo(getConfigPlano('upload')); ?> de tamanho cada.
                    </p>
                </div>
                <!-- The global progress state -->
                <div class="col-lg-4 fileupload-progress fade">
                    <!-- The global progress bar -->
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                    </div>
                    <!-- The extended global progress state -->
                    <div class="progress-extended">&nbsp;</div>
                </div>
            </div>
            <!-- The table listing the files available for upload/download -->
            <table role="presentation" class="box-table-a" style="width:100%;"  id="fixFiles">
                <thead>
                    <tr>
                        <th width="10%">Preview</th>
                        <th width="27%">Nome original</th>
                        <th width="27%">Descri&ccedil;&atilde;o</th>
                        <th width="16%">Tamanho</th>
                        <th width="20%">A&ccedil;&atilde;o</th>
                    </tr>
                </thead>
                <tbody class="files"></tbody>
            </table>
        </form>
        <!-- The blueimp Gallery widget -->
        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
            <div class="slides"></div>
            <h3 class="title"></h3>
            <a class="prev">‹</a>
            <a class="next">›</a>
            <a class="close">×</a>
            <a class="play-pause"></a>
            <ol class="indicator"></ol>
        </div>        
        <!-- The template to display files available for upload -->
        <script id="template-upload" type="text/x-tmpl">
            {% for (var i=0, file; file=o.files[i]; i++) { %}
            <tr class="template-upload fade">
            <td width="10%">
            <span class="preview"></span>
            </td>
            <td width="27%">
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
            </td>
            <td width="27%"></td>
            <td width="16%">
            <p class="size">Processando...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
            </td>
            <td width="20%">
            {% if (!i && !o.options.autoUpload) { %}
            <button class="btn btn-primary btn-sm start" disabled>
            <i class="glyphicon glyphicon-upload"></i>
            <span>Iniciar <i>upload</i></span>
            </button>
            {% } %}
            {% if (!i) { %}
            <button class="btn btn-warning cancel btn-sm">
            <i class="glyphicon glyphicon-ban-circle"></i>
            <span>Cancelar</span>
            </button>
            {% } %}
            </td>
            </tr>
            {% } %}
        </script>
        <!-- The template to display files available for download -->
        <script id="template-download" type="text/x-tmpl">
            {% for (var i=0, file; file=o.files[i]; i++) { %}
            <tr class="template-download fade">
            <td width="10%">
            <span class="preview">
            {% if (file.thumbnailUrl) { %}
            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
            {% } %}
            </span>
            </td>
            <td width="27%">
            <p class="name">
            {% if (file.url) { %}
            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
            {% } else { %}
            <span>{%=file.name%}</span>
            {% } %}
            </p>
            {% if (file.error) { %}
            <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
            </td>
            <td width="27%"></td>
            <td width="16%">
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
            </td>
            <td width="20%">
            {% if (file.deleteUrl) { %}
            <button class="btn btn-danger delete btn-sm" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
            <i class="glyphicon glyphicon-trash"></i>
            <span>Deletar</span>
            </button>
            <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
            <button class="btn btn-warning btn-sm cancel">
            <i class="glyphicon glyphicon-ban-circle"></i>
            <span>Cancelar</span>
            </button>
            {% } %}
            </td>
            </tr>
            {% } %}
        </script>
        <script src="/pf/js/jquery-1.11.3.min.js"></script>
        <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
        <script src="js/jquery.ui.widget.js"></script>
        <!-- The Templates plugin is included to render the upload/download listings -->
        <script src="/pf/js/tmpl.min.js"></script>
        <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
        <script src="/pf/js/load-image.all.min.js"></script>
        <!-- The Canvas to Blob plugin is included for image resizing functionality -->
        <script src="/pf/js/canvas-to-blob.min.js"></script>
        <!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
        <script src="/pf/js/bootstrap.min.js"></script>
        <!-- blueimp Gallery script -->
        <script src="/pf/js/jquery.blueimp-gallery.min.js"></script>
        <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
        <script src="js/jquery.iframe-transport.js"></script>
        <!-- The basic File Upload plugin -->
        <script src="js/jquery.fileupload.min.js"></script>
        <!-- The File Upload processing plugin -->
        <script src="js/jquery.fileupload-process.js"></script>
        <!-- The File Upload image preview & resize plugin -->
        <script src="js/jquery.fileupload-image.js"></script>
        <!-- The File Upload audio preview plugin -->
        <script src="js/jquery.fileupload-audio.js"></script>
        <!-- The File Upload video preview plugin -->
        <script src="js/jquery.fileupload-video.js"></script>
        <!-- The File Upload validation plugin -->
        <script src="js/jquery.fileupload-validate.js"></script>
        <!-- The File Upload user interface plugin -->
        <script src="js/jquery.fileupload-ui.min.js"></script>
        <!-- The main application script -->
        <script src="js/main.js"></script>
        <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
        <!--[if (gte IE 8)&(lt IE 10)]>
        <script src="js/cors/jquery.xdr-transport.js"></script>
        <![endif]-->
        <script src="/pf/js/underscore-min.js" charset="utf-8"></script>
        <script src="/pf/js/jquery.floatThead-slim.min.js" charset="utf-8"></script>
        <script type="text/javascript">
            $('#fixFiles').floatThead({scrollingTop: 0, useAbsolutePositioning: true});
        </script>
    </body>
</html>
