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
if ($login->isUserLoggedIn()) {
    /*
     * identifica a pagina de contagens
     */
    $page_context = 'form_';
    /*
     * verifica se o usuario pode acessar a pagina, independemente do menu
     * confere o acesso e o plano da empresa
     * 8 = financeiro
     */
    $isPermitido = (
            in_array_r($page_context . $array_page_context[8], $_SESSION['perm']));

    if (!$isPermitido) {
        header("Location: /pf/DIM.Gateway.php?arq=5&tch=2&sub=1&dlg=1");
    }
    /*
     * verifica o usuario logado
     */
    $usuario = new Usuario();
    $userId = getUserIdDecoded();
    $isGestor = getVariavelSessao('isGestor');
    $isGerenteConta = getVariavelSessao('isGerenteConta');
    $idFornecedor = getIdFornecedor();
    $isGestorFornecedor = getVariavelSessao('isGestorFornecedor');
    $isGerenteContaFornecedor = getVariavelSessao('isGerenteContaFornecedor');
    $isFiscalContrato = getVariavelSessao('isFiscalContratoCliente');
    $isFiscalContratoFornecedor = getVariavelSessao('isFiscalContratoFornecedor');
    $isFiscalContratoEmpresa = getVariavelSessao('isFiscalContratoEmpresa');
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
                    background: white; /* url("/pf/img/ui-anim_basic_16x16.gif") right center no-repeat;*/
                }
            </style>
            <?php include(DIR_BASE . 'include/inc_navbar.php'); ?>
            <div class="container-fluid">
                <!-- inicio do conteudo -->
                <div class="panel-body">
                    <div class="tab-content tab-transp" style="min-height:515px;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th colspan="4">ATEN&Ccedil;&Atilde;O: Faturamentos<br />
                                        <small>
                                            <i class="fa fa-arrow-right"></i>&nbsp;o Dimension&reg; n&atilde;o solicita nem armazena informa&ccedil;&otilde;es sobre os meios de pagamentos;<br />
                                            <i class="fa fa-arrow-right"></i>&nbsp;Informe apenas no site o PAGSeguro da UOL;<br />
                                            <i class="fa fa-arrow-right"></i>&nbsp;Voc&ecirc; ser&aacute; direcionado para uma outra [janela] segura;</small>
                                    </th>
                                    <th colspan="4">
                                        <small>
                                            <i class="fa fa-arrow-right"></i>&nbsp;N&atilde;o enviamos solicita&ccedil;&otilde;es de pagamento via email;<br />
                                            <i class="fa fa-arrow-right"></i>&nbsp;Para iniciar qualquer tipo de pagamento acesse por aqui;<br />
                                            <i class="fa fa-arrow-right"></i>&nbsp;Os pagamentos levam cerca de tr&ecirc;s a cinco dias para serem baixados;<br />
                                            <i class="fa fa-arrow-right"></i>&nbsp;<sup>1</sup>&nbsp;PENDENTE - Faturamento feito por contrato de presta&ccedil;&atilde;o de servi&ccedil;os (&oacute;rg&atilde;os P&uacute;blicos / Empresas).</small>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="10%">#SEQ</th>
                                    <th width="10%">REF.</th>
                                    <th width="10%">Data</th>
                                    <th width="10%">Contagens</th>
                                    <th width="10%">Detalhes</th>
                                    <th width="10%">Faturamento</th>
                                    <th width="10%">Status</th>
                                    <th width="30%">Detalhes</th>
                                </tr>
                            </thead>
                            <tbody id="addFaturamento"></tbody>
                        </table>
                    </div>
                </div>
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
            <!-- genericos -->
            <script type="text/javascript" src="/pf/js/vendor/charCount.js" charset="utf-8" ></script>
            <script type="text/javascript" src="/pf/js/vendor/extenso.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/vendor/bootstrap-datepicker.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/vendor/tagmanager.js" charset="utf-8"></script>
            <!--selectize-->
            <script type="text/javascript" src="/pf/js/vendor/selectize.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/vendor/jquery.floatThead-slim.min.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/vendor/sweetalert.min.js" charset="utf-8"></script>
            <!-- RGraph Charts -->
            <!-- biblioteca md5 Google -->
            <script language="javascript" src="/pf/js/vendor/md5.js"></script>
            <!--bootstrap touch spin -->
            <script type="text/javascript" src="/pf/js/vendor/jquery.bootstrap-touchspin.min.js" charset="utf-8"></script>            
            <!-- Dimension(c) scripts -->    
            <script type="text/javascript" src="/pf/js/DIM.APIDIM.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.MNUDIM.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.MSGDIM.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.FMOCOM.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.FMOGBA.js" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/financeiro/DIM.FRMFIN.js" charset="utf-8"></script>
        </body>
    </html>
    <?php
} else {
    $urlAtual = $converter->encode(getURL());
    header("Location: /pf/index.php?url=$urlAtual");
}
