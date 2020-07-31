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
    $usuario = new Usuario();
    $userId = getUserIdDecoded();
    $idFornecedor = getIdFornecedor();
    $idEmpresa = getIdEmpresa();
    $isFiscalContrato = getVariavelSessao('isFiscalContratoCliente');
    $isFiscalContratoEmpresa = getVariavelSessao('isFiscalContratoEmpresa');
    $isFiscalContratoFornecedor = getVariavelSessao('isFiscalContratoFornecedor');
    /*
     * verificacao de validade da chamada ao formulario antes dos headers para poder redirecionar
     */
    if (NULL === filter_input(INPUT_GET, 'ac', FILTER_SANITIZE_STRING) || strlen(filter_input(INPUT_GET, 'ac', FILTER_SANITIZE_STRING)) < 1) {
        header("Location: /pf/index.php");
    } else {
        /*
         * instancia da classe
         */
        $cn = new Contagem();
        /*
         * pega as informacoes do usuario logado
         */
        $userId = getUserIdDecoded();
        $userEmail = getEmailUsuarioLogado();
        /*
         * pega o id da contagem e a acao
         */
        $idContagem = isset($_GET['id']) ? intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)) : 0;
        /*
         * verifica o id valido e redireciona
         */
        if ($idContagem < 1 && $ac !== 'in') {
            header("Location: /pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1");
        }
        /*
         * pega o id do cliente e valida assim como na contagem
         */
        $idCliente = isset($_GET['icl']) ? intval(filter_input(INPUT_GET, 'icl', FILTER_SANITIZE_NUMBER_INT)) : 0;
        /*
         * verifica se eh valido
         */
        if ($idCliente && $ac === 'in') {
            $cliente = new Cliente();
            $cliente->setIdEmpresa(getIdEmpresa());
            $cliente->setIdFornecedor(getIdFornecedor());
            $cliente->setId($idCliente);
            $validaCliente = $cliente->validaIDCliente();
            if (!$validaCliente) {
                header("Location: /pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1");
            }
        }
        /*
         * identifica a pagina de contagens
         */
        $page_context = 'form_inserir_alterar_contagem_';
        /*
         * verifica se o usuario pode executar a acao
         * (1) independente, (2) projeto, (3) baseline, (4)licitacao, (5) snap, (6) apt e (9) ef
         */
        $abrangencia = NULL !== filter_input(INPUT_GET, 'ab', FILTER_SANITIZE_NUMBER_INT) ? filter_input(INPUT_GET, 'ab', FILTER_SANITIZE_NUMBER_INT) : 1;
        /*
         * verifica se o usuario pode acessar a pagina, independemente do menu
         * confere o acesso e o plano da empresa
         */
        $isPermitido = (
                getPermissao($page_context . $array_page_context[$abrangencia]) &&
                getConfigPlano('contagem_' . $array_page_context[$abrangencia]));

        if (!$isPermitido) {
            header("Location: /pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1");
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
         * todos podem ver o formulario mas nao entram com a acao 'in' incluir
         */
        $isTipoValido = in_array_r($ac, $arTipoContagem) ? true : false;

        if (!$isTipoValido) {
            header("Location: /pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1");
        } elseif ($ac === 'in' && !getPermissao('inserir_contagem')) {
            header("Location: /pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1");
        } elseif ($ac === 'al' && !getPermissao('alterar_contagem')) {
            header("Location: /pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1");
        } elseif ($ac === 'vi' && !getPermissao('validar_contagem')) {
            header("Location: /pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1");
        } elseif ($ac === 've' && !getPermissao('validar_externa')) {
            /*
             * antes de redirecionar verifica se eh um vi fazendo o papel de ve no caso de contagem de fornecedor
             */
            $isContagemFornecedor = $cn->isContagemFornecedor($idContagem);
            /*
             * verifica se eh um validador interno fazendo o papel de validador externo
             */
            $us = new Usuario();
            $isPerfilValidadorInterno = $us->isPerfilValidadorInterno($userId);
            /*
             * verifica e redireciona
             */
            if (!($isPerfilValidadorInterno && $isContagemFornecedor)) {
                header("Location: /pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1");
            }
        } elseif ($ac === 'ai' && !getPermissao('auditar_interna')) {
            header("Location: /pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1");
        } elseif ($ac === 'ae' && !getPermissao('auditar_externa')) {
            header("Location: /pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1");
        } elseif ($ac === 're' && !getPermissao('revisar_contagem')) {
            header("Location: /pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1");
        } elseif (isFornecedor() && getTipoFornecedor() && ($abrangencia == 2 || $abrangencia == 3 || $abrangencia == 4)) {
            header("Location: /pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1");
        }
        ?>
        <!DOCTYPE html>
        <html lang="en">
            <?php include(DIR_BASE . 'include/inc_meta.php'); /* include para as tags meta das paginas HTML */ ?>
            <body onload="setTimeout(ocultaDivLoading, 1000)" style="background-color: #EDEDED;">
                <div class="wrapper" id="div-fade-loading">
                    <div style="text-align: center;">
                        <img src="/pf/img/wait_big.gif" />
                    </div>
                </div>                
                <?php include(DIR_BASE . 'include/inc_navbar.php'); ?>
                <div class="panel-body">
                    <ul class="nav nav-tabs" style="background-color: #EDEDED;" id="tabs-contagem">
                        <li data-toggle="tabs" id="li-info" class="active" data-toggle="tooltip" data-placement="bottom" title="Informa&ccedil;&otilde;es da contagem">
                            <a data-toggle="tab" href="#info">
                                <div class="top-title">
                                    <i class="fa fa-info-circle fa-lg"></i><!--&nbsp;<br />
                                    Informa&ccedil;&otilde;es da contagem-->
                                </div>
                                <span class="not-view">
                                    <strong><?= strtoupper($array_page_context[$abrangencia]); ?></strong></a></li>
                        </span>
                        <li data-toggle="tabs" id="li-ali" data-toggle="tooltip" data-placement="bottom" title="Arquivos L&oacute;gicos Internos">
                            <a data-toggle="tab" href="#ali">
                                <div class="top-title">
                                    <i class="fa fa-database fa-lg"></i><!--&nbsp;<br />
                                    Arquivos L&oacute;gicos Internos-->
                                </div>
                                <span class="not-view">
                                    <strong>ALI</strong></a></li>
                        </span>
                        <li data-toggle="tabs" id="li-aie" data-toggle="tooltip" data-placement="bottom" title="Arquivos de Interface Externa">
                            <a data-toggle="tab" href="#aie">
                                <div class="top-title">
                                    <i class="fa fa-sign-in fa-lg"></i><!--&nbsp;<br />
                                    Arquivos de Interface Externa-->
                                </div>
                                <span class="not-view">
                                    <strong>AIE</strong></a></li>
                        </span>
                        <li data-toggle="tabs" id="li-ee" data-toggle="tooltip" data-placement="bottom" title="Entradas Externas">
                            <a data-toggle="tab" href="#ee">
                                <div class="top-title">
                                    <i class="fa fa-keyboard-o fa-lg"></i><!--&nbsp;<br />
                                    Entradas Externas-->
                                </div>
                                <span class="not-view">
                                    <strong>EE</strong></a></li>
                        </span>
                        <li data-toggle="tabs" id="li-se" data-toggle="tooltip" data-placement="bottom" title="Sa&iacute;das Externas">
                            <a data-toggle="tab" href="#se">
                                <div class="top-title">
                                    <i class="fa fa-external-link fa-lg"></i><!--&nbsp;<br />
                                    Sa&iacute;das Externas-->
                                </div>
                                <span class="not-view">
                                    <strong>SE</strong></a></li>
                        </span>
                        <li data-toggle="tabs" id="li-ce" data-toggle="tooltip" data-placement="bottom" title="Consultas Externas">
                            <a data-toggle="tab" href="#ce">
                                <div class="top-title">
                                    <i class="fa fa-desktop fa-lg"></i><!--&nbsp;<br />
                                    Consultas Externas-->
                                </div>
                                <span class="not-view">
                                    <strong>CE</strong></a></li>
                        </span>
                        <!-- baseline e licitacao -->
                        <?php if ($abrangencia != 3 && $abrangencia != 4) { ?>
                            <li data-toggle="tabs" id="li-ou" data-toggle="tooltip" data-placement="bottom" title="Itens n&atilde;o mensur&aacute;veis">
                                <a data-toggle="tab" href="#ou">
                                    <div class="top-title">
                                        <i class="fa fa-sitemap fa-lg"></i><!--&nbsp;<br />
                                        Itens n&atilde;o mensur&aacute;veis-->
                                    </div>
                                    <span class="not-view">
                                        <strong>INM</strong></a></li>
                            </span>
                            <?php
                        }
                        ?>
                        <?php if ($abrangencia != 3 && $abrangencia != 4) { ?>    
                            <li data-toggle="tabs" id="li-ane" class="disabled" data-toggle="tooltip" data-placement="bottom" title="Gerenciador de arquivos anexos">
                                <a data-toggle="tab" href="#ane">
                                    <div class="top-title">
                                        <i class="fa fa-folder-open-o fa-lg"></i><!--&nbsp;<br />
                                        Gerenciador de arquivos anexos-->
                                    </div>
                                    <span class="not-view">
                                        <strong><span id="span_id_contagem"></span></strong>
                                    </span>
                                </a>
                            </li> 
                            <!-- baseline e licitacao -->
                            <li data-toggle="tabs" id="li-est" class="disabled" data-toggle="tooltip" data-placement="bottom" title="Tempo, custo e equipe" style="visibility: <?= ($abrangencia == 3 || $abrangencia == 4) ? 'hidden' : 'visible'; ?>;">
                                <a data-toggle="tab" href="#est">
                                    <div class="top-title"><i class="fa fa-pie-chart fa-lg" id="wait-estatisticas"></i><!--&nbsp;<br />
                                        Tempo, custo e equipe-->
                                    </div>
                                    <span class="not-view">
                                        <strong>Estat&iacute;sticas</strong>
                                    </span>
                                </a></li>
                            <li data-toggle="tabs" id="li-coc" class="disabled" data-toggle="tooltip" data-placement="bottom" title="Tempo, custo e equipe" style="visibility: <?= ($abrangencia == 3 || $abrangencia == 4) ? 'hidden' : 'visible'; ?>;">
                                <a data-toggle="tab" href="#coc">
                                    <div class="top-title"><i class="fa fa-bar-chart fa-lg" id="wait-cocomo"></i><!--&nbsp;<br />
                                        Tempo, custo e equipe-->
                                    </div>
                                    <span class="not-view">
                                        <strong>COCOMO</strong>
                                    </span>
                                </a></li>
                            <li data-toggle="tabs" id="li-fin" class="disabled" data-toggle="tooltip" data-placement="bottom" title="Processo de valida&ccedil;&atilde;o e privacidade">
                                <a data-toggle="tab" href="#fin">
                                    <div class="top-title">
                                        <i class="fa fa-gears fa-lg"></i><!--&nbsp;<br />
                                        Processo de valida&ccedil;&atilde;o e privacidade-->
                                    </div>
                                    <span class="not-view">
                                        <strong>Finalizar</strong>
                                    </span>
                                </a></li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content tab-transp">
                        <div id="info" class="tab-pane fade in active">
                            <?php include('tab_inicio.php'); ?>
                        </div>
                        <div id="ali" class="tab-pane fade in">
                            <?php include('tab_incluir_ali.php'); ?>
                        </div>
                        <div id="aie" class="tab-pane fade in">
                            <?php include('tab_incluir_aie.php'); ?>
                        </div>
                        <div id="ee" class="tab-pane fade in">
                            <?php include('tab_incluir_ee.php'); ?>                
                        </div>  
                        <div id="se" class="tab-pane fade in">
                            <?php include('tab_incluir_se.php'); ?>                
                        </div>  
                        <div id="ce" class="tab-pane fade in">
                            <?php include('tab_incluir_ce.php'); ?>
                        </div>
                        <div id="ou" class="tab-pane fade in">
                            <?php include('tab_incluir_ou.php'); ?>
                        </div> 
                        <div id="ane" class="tab-pane fade in">
                            <?php include('tab_arquivos.php'); ?>
                        </div>
                        <div id="est" class="tab-pane fade in">
                            <?php include('tab_estatisticas.php'); ?>
                        </div>
                        <div id="coc" class="tab-pane fade in">
                            <?php include('tab_cocomo.php'); ?>
                        </div>
                        <!--baseline e licitacao -->
                        <?php if ($abrangencia != 3 && $abrangencia != 4) { ?>
                            <div id="fin" class="tab-pane fade in">
                                <?php include('tab_finalizar.php'); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php include('form_modal_funcao_dados.php'); ?>
                <?php include('form_modal_funcao_transacao.php'); ?>
                <?php include('form_modal_funcao_outros.php'); ?>
                <?php include('form_modal_calendario.php'); ?>
                <?php include('form_modal_comentarios.php'); ?>
                <?php include('form_modal_selecionar_validador.php'); ?>
                <?php include('form_modal_listar_itens_roteiro.php'); ?>
                <?php include('form_modal_pesquisar_funcoes.php'); ?>
                <?php include('form_modal_pesquisar_funcoes_livre.php'); ?>
                <?php include('form_modal_inserir_indicativa.php'); ?>
                <?php include('form_modal_help_copiar_colar.php'); ?>
                <?php include('form_modal_colar.php'); ?>
                <?php include('admin/form_modal_configuracoes_tab_inicio.php'); ?>
                <?php include('form_modal_selecionar_cliente.php'); ?>
                <!-- final do container -->
                <script type="text/javascript" src="/pf/js/min/vendor/jquery/jquery-1.11.3.min.js?v=201705111850" charset="utf-8"></script>
                <script type="text/javascript" src="/pf/js/min/vendor/jquery/jquery.mask.min.js?v=201705111850" charset="utf-8"></script>                                 
                <script type="text/javascript" src="/pf/js/min/vendor/jquery/jquery.floatThead-slim.min.js?v=201705111850" charset="utf-8"></script>                        
                <script type="text/javascript" src="/pf/js/min/vendor/datatables/jquery.dataTables.min.js?v=201705111850" charset="utf-8" ></script>
                <script type="text/javascript" src="/pf/js/min/vendor/bootstrap/bootstrap.min.js?v=201705111850" charset="utf-8"></script>
                <script type="text/javascript" src="/pf/js/min/vendor/bootstrap/bootstrap-toggle.min.js?v=201705111850" charset="utf-8" ></script>
                <script type="text/javascript" src="/pf/js/min/vendor/datepicker/datepicker.min.js?v=201705111850" charset="utf-8"></script>
                <script type="text/javascript" src="/pf/js/min/vendor/underscore/underscore-min.js?v=201705111850" charset="utf-8"></script>
                <script type="text/javascript" src="/pf/js/min/vendor/charcount/charCount.min.js?v=201705111850" charset="utf-8" ></script>
                <script type="text/javascript" src="/pf/js/min/vendor/extenso/extenso.min.js?v=201705111850" charset="utf-8"></script>
                <script type="text/javascript" src="/pf/js/min/vendor/sweetalert/sweetalert.min.js?v=201705111850" charset="utf-8"></script>
                <script type="text/javascript" src="/pf/js/vendor/tagmanager.js?v=201705111850" charset="utf-8"></script>
                <script type="text/javascript" src="/pf/js/min/vendor/ckeditor/ckeditor.js?v=201705111850"></script>                
                <script type="text/javascript" src="/pf/js/min/vendor/jquery/jquery.bootstrap-touchspin.min.js?v=201705111850" charset="utf-8"></script>                            
                <script type="text/javascript" src="/pf/js/min/vendor/selectize/selectize.min.js?v=201705111850" charset="utf-8"></script>
                <!-- RGraph Charts - no needs anymore
                <script type="text/javascript" src="/pf/js/min/vendor/rgraph/RGraph.common.core.min.js?v=201705111850"></script>
                <script type="text/javascript" src="/pf/js/min/vendor/rgraph/RGraph.common.dynamic.min.js?v=201705111850"></script>
                <script type="text/javascript" src="/pf/js/min/vendor/rgraph/RGraph.common.key.min.js?v=201705111850"></script>
                <script type="text/javascript" src="/pf/js/min/vendor/rgraph/RGraph.line.min.js?v=201705111850"></script>    
                <script type="text/javascript" src="/pf/js/min/vendor/rgraph/RGraph.bar.min.js?v=201705111850"></script>
                <script type="text/javascript" src="/pf/js/min/vendor/rgraph/RGraph.drawing.rect.min.js?v=201705111850"></script>-->
                <!-- new Chart.js -->
                <script type="text/javascript" src="/pf/js/vendor/chartjs/Chart.js"></script>
                <!-- biblioteca md5 Google -->
                <script type="text/javascript" src="/pf/js/min/vendor/google/md5.min.js?v=201705111850"></script>
                <!-- fileUpload -->
                <script type="text/javascript" src="/pf/vendor/fileUpload/js/jquery.ui.widget.js?v=201705111850"></script>
                <script type="text/javascript" src="/pf/js/vendor/tmpl.min.js?v=201705111850"></script>
                <script type="text/javascript" src="/pf/js/vendor/load-image.all.min.js?v=201705111850"></script>
                <script type="text/javascript" src="/pf/js/vendor/canvas-to-blob.min.js?v=201705111850"></script>
                <script type="text/javascript" src="/pf/js/vendor/jquery.blueimp-gallery.min.js?v=201705111850"></script>
                <script type="text/javascript" src="/pf/vendor/fileUpload/js/jquery.iframe-transport.js?v=201705111850"></script>
                <script type="text/javascript" src="/pf/vendor/fileUpload/js/jquery.fileupload.js?v=201705111850"></script>
                <script type="text/javascript" src="/pf/vendor/fileUpload/js/jquery.fileupload-process.js?v=201705111850"></script>
                <script type="text/javascript" src="/pf/vendor/fileUpload/js/jquery.fileupload-image.js?v=201705111850"></script>
                <script type="text/javascript" src="/pf/vendor/fileUpload/js/jquery.fileupload-audio.js?v=201705111850"></script>
                <script type="text/javascript" src="/pf/vendor/fileUpload/js/jquery.fileupload-video.js?v=201705111850"></script>
                <script type="text/javascript" src="/pf/vendor/fileUpload/js/jquery.fileupload-validate.js?v=201705111850"></script>
                <script type="text/javascript" src="/pf/vendor/fileUpload/js/jquery.fileupload-ui.js?v=201705111850"></script>
                <script type="text/javascript" src="/pf/vendor/fileUpload/js/main.js?v=201705111850"></script>
                <script type="text/javascript" src="/pf/login/js/main.js?v=201705111850"></script>
                <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
                <!--[if (gte IE 8)&(lt IE 10)]>
                <script src="/pf/vendor/fileUpload/js/cors/jquery.xdr-transport.js?v=201705111850"></script>
                <![endif]-->
                <!-- Dimension(c) scripts -->
                <script type="text/javascript" src="/pf/js/DIM.APIDIM.js?v=201705111850" charset="utf-8"></script>
                <script type="text/javascript" src="/pf/js/admin/DIM.FMOCTI.js?v=201705111850" charset="utf-8"></script>
                <script type="text/javascript" src="/pf/js/DIM.INSLIN.js?v=201705111850" charset="utf-8"></script>
                <script type="text/javascript" src="/pf/js/DIM.FUNDAD.js?v=201705111850" charset="utf-8"></script>
                <script type="text/javascript" src="/pf/js/DIM.FUNOUT.js?v=201705111850" charset="utf-8"></script>    
                <script type="text/javascript" src="/pf/js/DIM.FUNTRA.js?v=201705111850" charset="utf-8"></script>
                <script type="text/javascript" src="/pf/js/DIM.MNUDIM.js?v=201705111850" charset="utf-8"></script>
                <script type="text/javascript" src="/pf/js/DIM.MSGDIM.js?v=201705111850" charset="utf-8"></script>
                <script type="text/javascript" src="/pf/js/DIM.ESTDIM.js?v=201705111850" charset="utf-8"></script>
                <!--antes por que a funcao de calculaCocomo esta aqui-->                
                <script type="text/javascript" src="/pf/js/DIM.ESTCOC.js?v=201705111850" charset="utf-8"></script>
                <!--precedente por conta da funcao limpaValidador()-->
                <script type="text/javascript" src="/pf/js/DIM.FINDIM.js?v=201705111850" charset="utf-8"></script>
                <script type="text/javascript" src="/pf/js/DIM.FMOCOM.js?v=201705111850" charset="utf-8"></script>
                <script type="text/javascript" src="/pf/js/DIM.FLSIRO.js?v=201705111850" charset="utf-8"></script>
                <script type="text/javascript" src="/pf/js/DIM.FIACON.js?v=201705111850" charset="utf-8"></script>
                <script type="text/javascript" src="/pf/js/DIM.FMOAPO.js?v=201705111850" charset="utf-8"></script>
                <script type="text/javascript" src="/pf/js/DIM.FMOPFU.js?v=201705111850" charset="utf-8"></script>
                <?php
                echo getPermissao('form_gerenciar_baselines') ? '<script type="text/javascript" src="/pf/js/DIM.FMOGBA.js?v=201705111850" charset="utf-8"></script>' : NULL;
                echo (getPermissao('form_gerenciar_orgao') && getVariavelSessao('isGestor')) ? '<script type="text/javascript" src="/pf/js/DIM.FMOORG.js?v=201705111850" charset="utf-8"></script>' : NULL;
                echo ($ac == 'in' || $ac === 'al') ? '<script type="text/javascript" src="/pf/js/DIM.FMOSVA.js?v=201705111850" charset="utf-8"></script>' : NULL;
                ?>
                <script type="text/javascript" src="/pf/js/min/user/DIM.FMOUSD.min.js?v=201705111850" charset="utf-8"></script>
                <script type="text/javascript">
                $('#' + 'fryrpg-NYV'.dScr()).prop('qvfnoyrq'.dScr(), !isAutorizadoValidarInternamente);//select-ALI
                $('#' + 'fryrpg-NVR'.dScr()).prop('qvfnoyrq'.dScr(), !isAutorizadoValidarInternamente);//select-AIE
                $('#' + 'fryrpg-RR'.dScr()).prop('qvfnoyrq'.dScr(), !isAutorizadoValidarInternamente);//select-EE
                $('#' + 'fryrpg-FR'.dScr()).prop('qvfnoyrq'.dScr(), !isAutorizadoValidarInternamente);//select-SE
                $('#' + 'fryrpg-PR'.dScr()).prop('qvfnoyrq'.dScr(), !isAutorizadoValidarInternamente);//select-CE
                $('#' + 'fryrpg-BH'.dScr()).prop('qvfnoyrq'.dScr(), !isAutorizadoValidarInternamente);//select-OU
                </script>
                <script type="text/javascript">
                    CKEDITOR.replace('txtAponte');
                    CKEDITOR.replace('txtComentario');
                    CKEDITOR.config.height = 330;
                    CKEDITOR.config.font_defaultLabel = 'Abel';
                    CKEDITOR.config.fontSize_defaultLabel = '18px;';
                </script>
                <script type="text/javascript">
                    $('body').popover({
                        selector: '[rel=popover]',
                        trigger: "click"
                    }).on("show.bs.popover", function (e) {
                        // hide all other popovers
                        $("[rel=popover]").not(e.target).popover("hide");
                        $(".popover").remove();
                    });
                </script>
                <script type="text/javascript">
                    $('.ui.dropdown')
                            .dropdown();
                </script>
            </body>
        </html>
        <?php
    }
} else {
    $urlAtual = $converter->encode(getURL());
    header("Location: /pf/index.php?url=$urlAtual");
}    