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
<div class="panel panel-default">
    <div class="panel-title">
        <i class="fa fa-file fa-lg"></i>&nbsp;&nbsp;Arquivos<br />
        <span class="sub-header">Gerenciamento de arquivos anexos &agrave; contagem</span>
    </div>
    <div class="panel-body">
        <!-- The file upload form used as target for the file upload widget -->
        <form id="fileupload" method="POST" enctype="multipart/form-data">
            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
            <div class="row fileupload-buttonbar">
                <div class="col-lg-4">
                    <div class="btn-group btn-group-justified">
                        <!-- The fileinput-button span is used to style the file input field as button -->
                        <div class="btn-group">
                            <span class="btn btn-success fileinput-button btn-sm" id="btn-adicionar-arquivo">
                                <i class="glyphicon glyphicon-plus"></i>
                                <span class="not-view">Adicionar</span>
                                <input type="file" name="files[]" id="files-add" multiple>
                            </span>
                        </div>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-primary btn-sm start" id="files-start">
                                <i class="glyphicon glyphicon-upload"></i>
                                <span class="not-view">Upload</span>
                            </button>
                        </div>
                        <div class="btn-group">
                            <button type="reset" class="btn btn-warning btn-sm cancel" id="files-cancel">
                                <i class="glyphicon glyphicon-ban-circle"></i>
                                <span class="not-view">Cancelar</span>
                            </button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-danger btn-sm delete" id="files-delete">
                                <i class="glyphicon glyphicon-trash"></i>
                                <span class="not-view">Deletar</span>
                            </button>
                        </div>
                    </div>
                    <!--
                    -->
                    <!-- The global file processing state -->
                    <!---->
                </div>
                <div class="col-lg-1" style="vertical-align: middle; height: 40px; line-height: 40px;">
                    <input class="toggle css-checkbox" id="chk-sel-todos" type="checkbox"><label for="chk-sel-todos" class="css-label-check">Todos</label>
                </div>
                <div class="col-lg-2"><span class="fileupload-process"></span></div>
                <!-- The global progress state -->
                <div class="col-lg-5 fileupload-progress fade">
                    <!-- The global progress bar -->
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                    </div>
                    <!-- The extended global progress state -->
                    <div class="progress-extended">&nbsp;</div>
                </div>
            </div>
            <!--
            <div class="row">
                <div class="col-lg-12">          
                    O plano contratado por sua empresa permite anexar&nbsp;
            <?= getConfigPlano('quantidade_arquivos_contagem') ? getConfigPlano('quantidade_arquivos_contagem') : 'um n&uacute;mero ilimitado de '; ?>
            <?= getConfigPlano('quantidade_arquivos_contagem') ? '(' . Extenso::valorPorExtenso(getConfigPlano('quantidade_arquivos_contagem'), false, false) . ')' : ''; ?> arquivos, com
            <?= tamanhoArquivo(getConfigPlano('upload')); ?> de tamanho cada.
                </div>
            </div>
            -->
            <!-- The table listing the files available for upload/download -->
            <div class="scroll" style="max-height: 500px; overflow-x: hidden; overflow-y: scroll;">
                <table role="presentation" class="box-table-a table table-condensed" id="fixFiles" width="98%">
                    <thead>
                        <tr>
                            <th width="10%">Preview</th>
                            <th width="43%">Nome original</th>
                            <th width="29%">Tamanho</th>
                            <th width="18%">A&ccedil;&atilde;o</th>
                        </tr>
                    </thead>
                    <tbody class="files" id="addFiles"></tbody>
                </table>
            </div>
        </form>
        <!-- The blueimp Gallery widget -->
        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
            <div class="slides"></div>
            <h3 class="title"></h3>
            <a class="prev">&lt;</a>
            <a class="next">&gt;</a>
            <a class="close">X</a>
            <a class="play-pause"></a>
            <ol class="indicator"></ol>
        </div>
    </div>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
    <td width="10%">
    <span class="preview"></span>
    </td>
    <td width="48%">
    <p class="name">{%=file.name%}</p>
    <strong class="error text-danger"></strong>
    </td>
    <td width="22%">
    <div class="row">
    <div class="col-md-4"><span class="size">Processando...</span></div>
    <div class="col-md-8">
    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
    </div>
    </td>
    <td width="20%">
    {% if (!i && !o.options.autoUpload) { %}
    <div class="btn-group btn-group-justified">
    <div class="btn-group">
    <button class="btn btn-primary btn-sm start" disabled>
    <i class="glyphicon glyphicon-upload"></i>
    <span class="not-view">Upload</span>
    </button>
    </div>
    <div class="btn-group">
    {% } %}
    {% if (!i) { %}
    <button class="btn btn-warning cancel">
    <i class="glyphicon glyphicon-ban-circle"></i>
    <span class="not-view">Cancelar</span>
    </button>
    </div>
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
    <td width="48%">
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
    <td width="22%">
    <span class="size">{%=o.formatFileSize(file.size)%}</span>
    </td>
    <td width="20%">
    {% if (file.deleteUrl) { %}
    <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } if(!isAutorizadoAlterar) { %} disabled {% } %}>
    <i class="glyphicon glyphicon-trash"></i>
    <span class="not-view">Deletar</span>
    </button>
    <input type="checkbox" id="del-{%=i%}" name="delete" value="1" class="toggle css-checkbox"  {% if(!isAutorizadoAlterar) { %} disabled {% } %}><label for="del-{%=i%}" class="css-label-check">&nbsp;</label>
    {% } else { %}
    <button class="btn btn-warning cancel">
    <i class="glyphicon glyphicon-ban-circle"></i>
    <span class="not-view">Cancelar</span>
    </button>
    {% } %}
    </td>
    </tr>
    {% } %}
</script>
