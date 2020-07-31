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
     * verifica o usuario logado
     */
    $usuario = new Usuario();
    $userId = getUserIdDecoded();
    $isGestor = getVariavelSessao('isGestor');
    $isGerenteConta = getVariavelSessao('isGerenteConta');
    $idFornecedor = getIdFornecedor();
    $idEmpresa = getIdEmpresa();
    $isGestorFornecedor = getVariavelSessao('isGestorFornecedor');
    $isGerenteContaFornecedor = getVariavelSessao('isGerenteContaFornecedor');
    $isFiscalContrato = getVariavelSessao('isFiscalContratoCliente');
    $isFiscalContratoFornecedor = getVariavelSessao('isFiscalContratoFornecedor');
    $isFiscalContratoEmpresa = getVariavelSessao('isFiscalContratoEmpresa');
    /* criando dashboard para fornecedor
    if (isFornecedor()) {
        header("Location: /pf/DIM.Gateway.php?arq=3&tch=2&sub=-1&dlg=1");
    }
     * 
     */
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <?php include(DIR_BASE . 'include/inc_meta.php'); /* include para as tags meta das paginas HTML */ ?>
        <body>
            <style type="text/css">
                body{
                    background-color: #EDEDED;
                    margin-top: 15px;
                }
                .situacao-0{
                    font-weight: bold;
                    color: #F9E79F;
                    line-height: 27px;
                }
                .situacao-1{
                    font-weight: bold;
                    color: #2ECC71;
                    line-height: 27px;
                }
                .situacao-2{
                    font-weight: bold;
                    color: #239B56;
                    line-height: 27px;
                }
                .situacao-3{
                    font-weight: bold;
                    color: #82E0AA;
                    line-height: 27px;
                }                
                .situacao-4{
                    font-weight: bold;
                    color: #5DADE2;
                    line-height: 27px;
                }
                .situacao-5{
                    font-weight: bold;
                    color: #A0B041;
                    line-height: 27px;
                }                         
                .situacao-6{
                    font-weight: bold;
                    color: #154360;
                    line-height: 27px;
                }
                .situacao-7{
                    font-weight: bold;
                    color: #E5A041;
                    line-height: 27px;
                }    
            </style>
            <?php include(DIR_BASE . 'include/inc_navbar.php'); ?>
            <div>
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#dashboard-visao-geral">
                                <div class="top-title">
                                    <i class="fa fa-info-circle fa-lg"></i>
                                </div>
                                <strong>Geral</strong></a>
                        </li>
                        <?php
                        if (!isFornecedor()) {
                        ?>
                        <li>
                            <a data-toggle="tab" href="#dashboard-baseline">
                                <div class="top-title">
                                    <i class="fa fa-sliders fa-lg"></i>
                                </div>
                                <strong>Baselines</strong></a>
                        </li>
                        <?php
                        }
                        ?>                        
                        <li>
                            <a data-toggle="tab" href="#dashboard-projeto">
                                <div class="top-title">
                                    <i class="fa fa-sitemap fa-lg"></i>
                                </div>
                                <strong>Projetos</strong></a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#dashboard-financeiro">
                                <div class="top-title">
                                    <i class="fa fa-money fa-lg"></i>
                                </div>
                                <strong>Financeiro</strong></a>
                        </li>                          
                    </ul>
                    <div class="tab-content tab-dashboard">
                        <div id="dashboard-visao-geral" class="tab-pane fade in active">
                            <?php include('tab_dashboard_visao_geral.php'); ?>
                        </div>
                        <?php
                        if (!isFornecedor()) {
                        ?>
                        <div id="dashboard-baseline" class="tab-pane fade in">
                            <?php include('tab_dashboard_baseline.php'); ?>
                        </div>
                        <?php
                        }
                        ?>
                        <div id="dashboard-projeto" class="tab-pane fade in">
                            <?php include('tab_dashboard_projeto.php'); ?>
                        </div>
                        <div id="dashboard-financeiro" class="tab-pane fade in">
                            <?php include('tab_dashboard_financeiro.php'); ?>
                        </div>                          
                    </div>
                </div>
            </div>
            <?php include DIR_BASE . 'forms/form_modal_funcoes_perfil_contagem.php'; ?>
            <?php include DIR_BASE . 'forms/form_modal_selecionar_cliente.php'; ?>      
            <?php $isFiscalContrato || $isFiscalContratoFornecedor || $isFiscalContratoEmpresa ? include DIR_BASE . 'forms/form_modal_comparar_contagens.php' : NULL; ?>      
            <!-- final do container -->
            <script type="text/javascript" src="/pf/js/min/vendor/jquery/jquery-1.11.3.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/vendor/jquery/jquery-ui.min.js?v=201705111850" charset="utf-8"></script> 
            <script type="text/javascript" src="/pf/js/min/vendor/jquery/jquery.mask.min.js?v=201705111850" charset="utf-8"></script>                                 
            <script type="text/javascript" src="/pf/js/min/vendor/jquery/jquery.floatThead-slim.min.js?v=201705111850" charset="utf-8"></script>                        
            <script type="text/javascript" src="/pf/js/min/vendor/datatables/jquery.dataTables.min.js?v=201705111850" charset="utf-8" ></script>
            <script type="text/javascript" src="/pf/js/min/vendor/bootstrap/bootstrap.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/vendor/bootstrap/bootstrap-dialog.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/vendor/bootstrap/bootstrap-toggle.min.js?v=201705111850" charset="utf-8" ></script>
            <script type="text/javascript" src="/pf/js/min/vendor/datepicker/datepicker.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/vendor/underscore/underscore-min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/vendor/charcount/charCount.min.js?v=201705111850" charset="utf-8" ></script>
            <script type="text/javascript" src="/pf/js/min/vendor/extenso/extenso.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/vendor/sweetalert/sweetalert.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/vendor/tagmanager/tagmanager.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/vendor/ckeditor/ckeditor.js?v=201705111850"></script>
            <!-- the new charts.js -->
            <script type="text/javascript" src="/pf/js/vendor/chartjs/Chart.js?v=201705111850"></script>
            <!-- RGraph Charts -->
            <script type="text/javascript" src="/pf/vendor/RGraph/libraries/RGraph.common.core.js?v=201705111850"></script>
            <!-- biblioteca tree view -->
            <script type="text/javascript" src="/pf/js/vendor/treeview/bootstrap-treeview.js?v=201705111850"></script>
            <!-- biblioteca md5 Google -->
            <script language="javascript" src="/pf/js/vendor/md5.js?v=201705111850"></script>
            <!--bootstrap touch spin -->
            <script type="text/javascript" src="/pf/js/vendor/jquery.bootstrap-touchspin.min.js?v=201705111850" charset="utf-8"></script>            
            <!-- Dimension(c) scripts -->
            <script type="text/javascript" src="/pf/js/DIM.APIDIM.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.MNUDIM.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.FLSCON.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.FMOFPC.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.FMOCPC.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.FMOAPO.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/user/DIM.FMOUSD.js?v=201705111850" charset="utf-8"></script>
            <!-- Dimension (c) script for dashboard -->
            <script type="text/javascript" src="/pf/js/DIM.MSGDIM.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/dashboard/DIM.FMDASH.js?v=201705111851" charset="utf-8"></script>
            <?php
            echo getPermissao('form_gerenciar_baselines') ?
                    '<script type="text/javascript" src="/pf/js/DIM.FMOGBA.js?v=201705111850" charset="utf-8"></script>' : NULL;
            echo (getPermissao('form_gerenciar_orgao') && (getVariavelSessao('isGestor') || getVariavelSessao('isAdministrador'))) ?
                    '<script type="text/javascript" src="/pf/js/DIM.FMOORG.js?v=201705111850" charset="utf-8"></script>' : NULL;
            ?>            
            <!--CKEditor-->
            <script type="text/javascript">
                //reinicializa os tooltips
                $('[data-toggle="tooltip"]').tooltip({html: true});
    <?php if ($isFiscalContrato || $isFiscalContratoFornecedor || $isFiscalContratoEmpresa) { ?>
                    DIMCKEditor = CKEDITOR.replace('analiseFiscalContrato', {
                        height: 400
                    });<?php } ?>
            </script>
        </body>
    </html>
    <?php
} else {
    $urlAtual = $converter->encode(getURL());
    header("Location: /pf/index.php?url=$urlAtual");
}
