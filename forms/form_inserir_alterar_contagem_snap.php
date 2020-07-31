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
if ($login->isUserLoggedIn() && verificaSessao()) {
    /*
     * verificacao de validade da chamada ao formulario antes dos headers para poder redirecionar
     */
    if (NULL === filter_input(INPUT_GET, 'ac', FILTER_SANITIZE_STRING) || strlen(filter_input(INPUT_GET, 'ac', FILTER_SANITIZE_STRING)) < 1) {
        header("Location: /pf/index.php");
    } else {
        /*
         * identifica a pagina de contagens
         */
        $page_context = 'form_inserir_alterar_contagem_';
        /*
         * verifica se o usuario pode executar a acao
         * (0) avulsa, (1) projeto, (2) baseline, (3)licitacao e (4) snap
         */
        $abrangencia = NULL !== filter_input(INPUT_GET, 'ab', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_GET, 'ab', FILTER_SANITIZE_NUMBER_INT) : 1;
        /*
         * verifica se o usuario pode acessar a pagina, independemente do menu
         * confere o acesso e o plano da empresa
         */
        $isPermitido = (
                in_array_r($page_context . $array_page_context[$abrangencia], $_SESSION['perm']) &&
                $_SESSION['empresa_config_plano']['contagem_' . $array_page_context[$abrangencia]]);

        if (!$isPermitido) {
            header("Location: /pf/forms/form_listar_contagens.php");
        }
        /*
         * verifica a acao solicitada no formulario
         * in - inserir
         * al - alterar
         * vi - validacao interna
         * ve - validacao externa
         * ai - auditoria interna
         * ae - auditoria externa
         * vw - viewer (gerentes de projeto, gerentes, diretores, viewers, etc)
         * re - revisar
         */
        $arTipoContagem = ['in', 'al', 'vi', 've', 'ai', 'ae', 'vw', 're'];
        /*
         * verifica o tipo e redireciona para os tipos certos caso tenha autorizacao
         */
        $isTipoValido = in_array_r($ac, $arTipoContagem) ? true : false;
        if (!$isTipoValido) {
            header("Location: form_listar_contagens.php");
        }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <?php include(DIR_BASE . 'include/inc_meta.php'); /* include para as tags meta das paginas HTML */ ?>
        <body class="fuelux">
            <?php include DIR_BASE . 'forms/selo_site_seguro.php'; ?>
            <style type="text/css">
                .ui-autocomplete {
                    z-index:2147483647;
                    max-height: 150px;
                    min-width: 300px;
                    max-width: 400px;
                    overflow-y: auto;
                    overflow-x: hidden;
                    font-size: 12px !important;
                    text-overflow: ellipsis;
                    white-space:nowrap;        
                }
                .ui-autocomplete-loading {
                    background: white; 
                }              
            </style>
            <?php include(DIR_BASE . 'include/inc_navbar.php'); ?>
            <div class="container-fluid">
                <div class="panel-body">
                    <ul class="nav nav-tabs" style="background-color: rgba(255,255,255,.9);">
                        <li class="active">
                            <a data-toggle="tab" href="#info">
                                <div class="top-title">
                                    <i class="fa fa-info-circle fa-lg"></i>&nbsp;<br>
                                    <small>Informa&ccedil;&otilde;es da contagem</small>
                                </div>
                                <small><strong>In&iacute;cio</strong></small></a></li>
                        <li>
                            <a data-toggle="tab" href="#doper">
                                <div class="top-title">
                                    <i class="fa fa-keyboard-o fa-lg"></i>&nbsp;<br>
                                    <small>SNAP Counting Sheet</small>
                                </div>
                                <small><strong>SCS</strong></small></a></li>
                        <li>
                            <a data-toggle="tab" href="#ane">
                                <div class="top-title">
                                    <i class="fa fa-floppy-o fa-lg"></i>&nbsp;<br>
                                    <small>Gerenciador de arquivos anexos</small>
                                </div>
                                <small>#ID:&nbsp;<strong><span id="span_id_contagem"></span></small></strong></a></li>
                        <li>
                            <a data-toggle="tab" href="#est">
                                <div class="top-title">
                                    <i class="fa fa-pie-chart fa-lg"></i>&nbsp;<br>
                                    <small>Resumo e informa&ccedil;&otilde;es SNAP</small>
                                </div>
                                <small><strong>Estat&iacute;sticas</strong></small></a></li>                                
                        <li>
                            <a data-toggle="tab" href="#fin">
                                <div class="top-title">
                                    <i class="fa fa-gears fa-lg"></i>&nbsp;<br>
                                    <small>Processo de valida&ccedil;&atilde;o e privacidade</small>
                                </div>
                                <small><strong>Finalizar</strong></small></a></li>
                        <li class="disabled">
                            <a data-toggle="tab" href="">
                                <div class="top-title">
                                    <i class="fa fa-bullseye fa-lg"></i>&nbsp;<br>
                                    <small>Abrang&ecirc;ncia da contagem</small>
                                </div>
                                <strong><span id="tpo-contagem"><?= strtoupper($array_page_context[$abrangencia]); ?></span></strong></a>
                        </li>
                    </ul>
                    <div class="tab-content tab-transp" style="min-height:510px;">
                        <div id="info" class="tab-pane fade in active">
                            <?php include('tab_inicio.php'); ?>
                        </div>
                        <div id="doper" class="tab-pane fade in">
                            <?php include('snap/tab_data_operations.php'); ?>
                        </div>
                        <div id="ane" class="tab-pane fade in">
                            <?php include('tab_arquivos.php'); ?>
                        </div>
                        <div id="est" class="tab-pane fade in">
                            <?php //include('tab_finalizar.php'); ?>
                        </div>                        
                        <div id="fin" class="tab-pane fade in">
                            <?php include('tab_finalizar.php'); ?>
                        </div>
                    </div>
                </div>
                <?php include('form_modal_comentarios.php'); ?>
                <?php include('form_modal_selecionar_validador.php'); ?>
                <!-- final do conteudo -->
            </div>
            <!-- final do container -->
            <script type="text/javascript" src="/pf/js/vendor/jquery-1.11.3.min.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/vendor/jquery.dataTables.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/vendor/jquery.metadata.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/vendor/jquery-ui.js" charset="utf-8"></script> 
            <script type="text/javascript" src="/pf/js/vendor/jquery.mask.min.js" charset="utf-8"></script>                                 
            <script type="text/javascript" src="/pf/js/vendor/bootstrap.min.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/vendor/bootstrap-dialog.min.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/vendor/bootstrap-editable.min.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/vendor/bootstrap-toggle.min.js" charset="utf-8" ></script>
            <script type="text/javascript" src="/pf/js/vendor/underscore-min.js" charset="utf-8"></script>
            <!--para o placard-->
            <script type="text/javascript" src="/pf/js/vendor/fuelux.min.js" charset="utf-8"></script>
            <!--genericos-->
            <script type="text/javascript" src="/pf/js/vendor/charCount.js" charset="utf-8" ></script>
            <script type="text/javascript" src="/pf/js/vendor/extenso.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/vendor/bootstrap-datepicker.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/vendor/tagmanager.js" charset="utf-8"></script>
            <!--selectize-->
            <script type="text/javascript" src="/pf/js/vendor/selectize.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/vendor/jquery.floatThead-slim.min.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/vendor/sweetalert.min.js" charset="utf-8"></script>
            <!-- RGraph Charts -->
            <script type="text/javascript" src="/pf/vendor/RGraph/libraries/RGraph.common.core.js"></script>
            <script type="text/javascript" src="/pf/vendor/RGraph/libraries/RGraph.common.dynamic.js"></script>
            <script type="text/javascript" src="/pf/vendor/RGraph/libraries/RGraph.line.js"></script>    
            <script type="text/javascript" src="/pf/vendor/RGraph/libraries/RGraph.bar.js"></script>
            <script type="text/javascript" src="/pf/vendor/RGraph/libraries/RGraph.common.key.js"></script>
            <script type="text/javascript" src="/pf/vendor/RGraph/libraries/RGraph.drawing.rect.js"></script>
            <!-- biblioteca md5 Google -->
            <script language="javascript" src="/pf/js/vendor/md5.js"></script>
            <!-- Basic for Gantt Charts -->
            <script language="javascript" src="/pf/js/vendor/jsgantt/jsgantt.js"></script>
            <!-- fileUpload -->
            <script src="/pf/vendor/fileUpload/js/jquery.ui.widget.js"></script>
            <script src="/pf/js/vendor/tmpl.min.js"></script>
            <script src="/pf/js/vendor/load-image.all.min.js"></script>
            <script src="/pf/js/vendor/canvas-to-blob.min.js"></script>
            <script src="/pf/js/vendor/jquery.blueimp-gallery.min.js"></script>
            <script src="/pf/vendor/fileUpload/js/jquery.iframe-transport.js"></script>
            <script src="/pf/vendor/fileUpload/js/jquery.fileupload.js"></script>
            <script src="/pf/vendor/fileUpload/js/jquery.fileupload-process.js"></script>
            <script src="/pf/vendor/fileUpload/js/jquery.fileupload-image.js"></script>
            <script src="/pf/vendor/fileUpload/js/jquery.fileupload-audio.js"></script>
            <script src="/pf/vendor/fileUpload/js/jquery.fileupload-video.js"></script>
            <script src="/pf/vendor/fileUpload/js/jquery.fileupload-validate.js"></script>
            <script src="/pf/vendor/fileUpload/js/jquery.fileupload-ui.js"></script>
            <script src="/pf/vendor/fileUpload/js/main.js"></script>
            <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
            <!--[if (gte IE 8)&(lt IE 10)]>
            <script src="/pf/vendor/fileUpload/js/cors/jquery.xdr-transport.js"></script>
            <![endif]-->
            <!--bootstrap touch spin -->
            <script type="text/javascript" src="/pf/js/vendor/jquery.bootstrap-touchspin.min.js" charset="utf-8"></script>            
            <!-- Dimension(c) scripts -->    
            <script type="text/javascript" src="/pf/js/DIM.APIDIM.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.INSLIN.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.FUNDAD.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.FUNOUT.js" charset="utf-8"></script>    
            <script type="text/javascript" src="/pf/js/DIM.FUNTRA.js" charset="utf-8"></script>  
            <script type="text/javascript" src="/pf/js/DIM.MNUDIM.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.MSGDIM.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.ESTDIM.js" charset="utf-8"></script>    
            <script type="text/javascript" src="/pf/js/DIM.FINDIM.js" charset="utf-8"></script>
            <?php
            echo ($ac == 'in' || $ac === 'al') ?
                    '<script type="text/javascript" src="/pf/js/DIM.FMOSVA.js" charset="utf-8"></script>' : NULL;
            ?>
            <script type="text/javascript" src="/pf/js/DIM.FMOCOM.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.FLSIRO.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.FIACON.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.FMOLST.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.FMOAPO.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.FMOPFU.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/user/DIM.FMOUSD.js" charset="utf-8"></script>
            <?php
            echo getPermissao('gerenciar_baseline') ?
                    '<script type="text/javascript" src="/pf/js/DIM.FMOGBA.js" charset="utf-8"></script>' : NULL;
            ?>
        </body>
    </html>
    <?php
} else {
    $urlAtual = $converter->encode(getURL());
    header("Location: /pf/index.php?url=$urlAtual");
}