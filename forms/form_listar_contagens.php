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
     * identifica a pagina de contagens
     */
    $page_context = 'form_listar_registros_';
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
        <body style="background-color: #EDEDED;">
            <?php include(DIR_BASE . 'include/inc_navbar.php'); ?>
            <br />
            <div class="tab-transp">
                <div class="panel panel-default">
                    <div class="panel-title">
                        <i class="fa fa-list-alt fa-lg"></i>&nbsp;&nbsp;Contagens<br />
                        <span class="sub-header">Lista de contagens em andamento e fitros para refinamento das pesquisas</span>
                    </div>
                    <div class="panel-body">   
                        <!-- inicio do conteudo -->
                        <!--
                        <div class="row">
                            <div class="col-md-12">
                                <button class="my-buttom-group">button1</button>
                                <button class="my-buttom-group">button2</button>
                                <button class="my-buttom-group">button3</button>
                                <button class="my-buttom-group alerta">button4</button>
                                <button class="my-buttom-group disabled">button5</button>
                                <button class="my-buttom-group success">button6</button>
                            </div>
                        </div>-->
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12">
                                <div class="listagem-filtros">
                                    <a data-toggle="collapse" data-parent="#collapseOne" href="#collapseOne"><i class="fa fa-eye fa-lg" id="eye"></i><span class="not-view"><span id="cabecalho">&nbsp;&nbsp;Exibir filtros</span></span></a>
                                </div>
                                <div class="listagem-filtros">
                                    <a role="button" class="limpar-filtros"><i class="fa fa-filter fa-lg"></i><span class="not-view">&nbsp;&nbsp;Limpar filtros</span></a>
                                </div>
                                <div class="listagem-filtros">
                                    <a role="button" class="limpar-filtros"><i class="fa fa-refresh fa-lg"></i><span class="not-view">&nbsp;&nbsp;Atualizar Lista</span></a>
                                </div>                              
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel-group" id="accordion">
                                    <div id="collapseOne" class="panel-collapse collapse out">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <div class="wrap-input100 m-t-20">
                                                            <input type="text" class="input100" id="input-os" placeholder="" autocomplete="off">
                                                            <span class="focus-input100" data-placeholder="Ordem de Servi&ccedil;o"></span>
                                                        </div>
                                                        <!--
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" id="pesq-os" type="button"><i class="fa fa-search"></i></button>
                                                        </span>-->
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <div class="wrap-input100 m-t-20">
                                                            <input type="text" class="input100" id="input-responsavel" placeholder="" autocomplete="off">
                                                            <span class="focus-input100" data-placeholder="Respons&aacute;vel"></span>
                                                        </div>                                                        
                                                        <!--
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-default" id="pesq-responsavel" type="button"><i class="fa fa-search"></i></button>
                                                        </span>-->
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <div class="wrap-input100 m-t-20">
                                                            <input type="text" class="input100" id="input-projeto" placeholder="" autocomplete="off">
                                                            <span class="focus-input100" data-placeholder="Projeto"></span>
                                                        </div> 
                                                        <!--<span class="input-group-btn">
                                                            <button class="btn btn-default" id="pesq-projeto" type="button"><i class="fa fa-search"></i></button>
                                                        </span>-->
                                                    </div>
                                                </div>                               
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <div class="wrap-input100 m-t-20">
                                                            <input type="text" class="input100" id="input-cliente" placeholder="" autocomplete="off">
                                                            <span class="focus-input100" data-placeholder="Cliente"></span>
                                                        </div>                                                             
                                                        <!--<span class="input-group-btn">
                                                            <button class="btn btn-default" id="pesq-cliente" type="button"><i class="fa fa-search"></i></button>
                                                        </span>-->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <div class="wrap-input100 m-t-20">
                                                            <select id="combo-projeto-lista-contagens" name="combo-projeto-lista-contagens" class="input100" style="border: none">
                                                                <option value="0">Projeto...</option>
                                                            </select>
                                                        </div>                                                           
                                                    </div>
                                                </div>                                                 
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <div class="wrap-input100 m-t-20">
                                                            <select id="combo-baseline-lista-contagens" name="combo-projeto-lista-contagens" class="input100" style="border: none">
                                                                <option value="0">Projeto...</option>
                                                            </select>
                                                        </div>                                                           
                                                    </div>
                                                </div>                                                
                                                <div class="col-md-1">
                                                    <div class="form-group" style="padding-top: 38px;">
                                                        <?php if (!isFornecedor() && (getConfigContagem('is_visualizar_contagem_fornecedor') || $isGestor)) { ?>
                                                            <input 
                                                                id="forn-ativo-inativo" 
                                                                type="checkbox"
                                                                data-width="100%"
                                                                data-toggle="toggle" 
                                                                data-onstyle="success" 
                                                                data-offstyle="info" 
                                                                data-style="slow" 
                                                                data-on="<i class='fa fa-dot-circle-o'></i>&nbsp;&nbsp;Todos" 
                                                                data-off="<i class='fa fa-check-circle'></i>&nbsp;&nbsp;Ativos"
                                                                data-height="36">
                                                                <?php
                                                            }
                                                            ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <?php if (!isFornecedor() && (getConfigContagem('is_visualizar_contagem_fornecedor') || $isGestor)) { ?>
                                                            <div class="wrap-input100 m-t-20">
                                                                <select class="input100" id="pesquisa_id_fornecedor" style="border: none;">
                                                                    <option value="0">Fornecedor...</option>
                                                                </select>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group" style="padding-top: 38px;">
                                                        <?php if ((getConfigContagem('is_visualizar_contagem_turma') && !isFornecedor()) || $isGestor) { ?>
                                                            <input 
                                                                id="turma-ativo-inativo" 
                                                                type="checkbox"
                                                                data-width="100%"
                                                                data-toggle="toggle" 
                                                                data-onstyle="success" 
                                                                data-offstyle="info" 
                                                                data-style="slow" 
                                                                data-on="<i class='fa fa-dot-circle-o'></i>&nbsp;&nbsp;Todas" 
                                                                data-off="<i class='fa fa-check-circle'></i>&nbsp;&nbsp;Ativas"
                                                                data-height="36">
                                                                <?php
                                                            }
                                                            ?>                   
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <?php if ((getConfigContagem('is_visualizar_contagem_turma') && !isFornecedor()) || $isGestor) { ?>
                                                            <div class="wrap-input100 m-t-20">
                                                                <select class="input100" id="pesquisa_id_turma" style="border: none;">
                                                                    <option value="0">Turma...</option>
                                                                </select>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>                                                 
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="wrap-input100 m-t-20">
                                                            <input type="text" class="input100 input_calendar" placeholder="" id="data-inicial" data-mask="00/00/0000">
                                                            <span class="focus-input100" data-placeholder="dd/mm/yyyy"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <div class="wrap-input100 m-t-20">
                                                            <input type="text" class="input100 input_calendar" placeholder="" id="data-final" data-mask="00/00/0000">
                                                            <span class="focus-input100" data-placeholder="dd/mm/yyyy"></span>
                                                        </div>                                                    
                                                    </div>
                                                </div>
                                                <div class="col-md-2" style="padding-top: 15px;">
                                                    <div class="form-group">
                                                        <div class="container-login100-form-btn">
                                                            <button class="login100-form-btn" name="pesq-data" id="pesq-data" aria-label="Pesquisar">Pesquisar pelas datas</button>                            
                                                        </div>                                                        
                                                    </div>
                                                </div>                                                
                                            </div>
                                            <?php
                                            /*
                                             * verifica se eh um gestor ou um gerente de contas para poder exibir a div de faturamento
                                             */
                                            if ($isGestor || $isGerenteConta || $isGestorFornecedor || $isGerenteContaFornecedor) {
                                                ?>
                                                <div class="well" style="background-color: #e8ffed;">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <strong>Gestor | Gerente de Conta</strong><br />
                                                            <ul>
                                                                <li>&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i>&nbsp;Para faturar contagens, marque o <i>check</i>&nbsp;&nbsp;<strong>Faturar</strong> e clique nos #IDs.</li>
                                                                <li>&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i>&nbsp;Verifique o status <span class="label-round-2 label-processo-7a">&nbsp;&nbsp;&nbsp;<i class="fa fa-flag-checkered"></i>&nbsp;&nbsp;&nbsp;Faturamento autorizado&nbsp;&nbsp;&nbsp;</span> pois apenas neste status a contagem dever&aacute; ser faturada.</li>
                                                                <li>&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i>&nbsp;O Dimension ir&aacute; atualizar a lista de contagens e gerar os arquivos necess&aacute;rios.</li>
                                                                <li>&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i>&nbsp;Ao final do processo voc&ecirc; receber&aacute; um email informando o caminho para o <i>download</i> do arquivo contendo as informa&ccedil;&otilde;es do faturamento.</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-1">
                                                            <div class="form-group" style="padding-top: 40px;">
                                                                <input type="checkbox" class="css-checkbox form-control" id="faturar"><label for="faturar" class="css-label-check">Faturar</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <div class="wrap-input100 m-t-20">
                                                                    <input type="text" id="mes-ano-faturamento" class="input100" data-mask="00-0000" placeholder="" autofocus disabled/>
                                                                    <span class="focus-input100" data-placeholder="99-9999"></span>
                                                                </div>
                                                            </div>
                                                        </div>                                                        
                                                        <div class="col-md-2">
                                                            <div class="form-group" style="padding-top: 15px;">
                                                                <div class="container-login100-form-btn">
                                                                    <button type="button" class="login100-form-btn" id="btn-faturar" disabled><i class="fa fa-check-square-o" id="i-btn-faturar"></i><span id="s-btn-faturar">&nbsp;Gerar faturamento</span></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if ($isFiscalContrato || $isFiscalContratoFornecedor || $isFiscalContratoEmpresa) {
                                                ?>
                                                <div class="well" style="background-color: #e8ffed;">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <strong>Fiscal de Contrato</strong><br />
                                                            <ul>
                                                                <li>&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i>&nbsp;Para comparar contagens, marque e clique nos dois #IDs, para analisar, marque e clique no #ID</li>
                                                                <li>&nbsp;&nbsp;&nbsp;<i class="fa fa-caret-right"></i>&nbsp;<strong>ATEN&Ccedil&Atilde;O</strong>: selecione primeiro a contagem da <span class="label-success label-round-2">F&aacute;brica de Software</span></li>
                                                            </ul>
                                                            <input type="checkbox" class="css-checkbox" id="comparar-contagens"><label for="comparar-contagens" class="css-label-check">Comparar
                                                                &nbsp;<span class="bg-primary-2" id="comparar-id-1">0000000</span>&nbsp;-&nbsp;<span class="bg-primary-2" id="comparar-id-2">0000000</span>&nbsp;</label>&nbsp;&nbsp;|&nbsp;&nbsp;
                                                            <!--<input type="checkbox" class="css-checkbox" id="dois-monitores"><label for="dois-monitores" class="css-label-check" data-toggle="tooltip" data-placement="bottom" title="Selecione esta op&ccedil;&atilde;o caso queira abrir as contagens em dois monitores"><i class="fa fa-desktop"></i>&nbsp;<i class="fa fa-desktop"></i></label>&nbsp;&nbsp;|&nbsp;&nbsp;-->
                                                            <input type="checkbox" class="css-checkbox" id="realizar-analise-fiscal"><label for="realizar-analise-fiscal" class="css-label-check">Analisar</label>&nbsp;&nbsp;|&nbsp;&nbsp;
                                                            <input type="checkbox" class="css-checkbox" id="exibir-alertas"><label for="exibir-alertas" class="css-label-check" data-toggle="tooltip" data-placement="bottom" title="Caso esta op&ccedil;&atilde;o esteja habilitada o sistema pede confirma&ccedil;&atilde;o antes de realizar a opera&ccedil;&atilde;o para autorizar o faturamento">Solicitar confirma&ccedil;&otilde;es</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Informa&ccedil;&otilde;es"
                                      data-content="A lista inicial apresenta apenas as contagens entre a data de hoje e dois meses atr&aacute;s. Para acessar outras contagens utilize os filtros.<hr>
                                      Caso esteja na lista de contagens de baseline o sinal [ <font style='color: red;'><i class='fa fa-circle'></i></font> ] indica que h&aacute; funcionalidades inseridas por projetos que ainda n&atilde;o foram validadas (baseline n&atilde;o consolidada).
                                      <!--<hr>As contagens em processo de faturamento/faturadas n&atilde;o aparecem nesta listagem, caso tenha acesso, utilize o menu Ferramentas.-->">
                                    <i class="fa fa-info-circle fa-lg"></i>&nbsp;Lista contagens e an&aacute;lises, m&ecirc;s de refer&ecirc;ncia: <?= date('m'); ?>/<?= date('Y'); ?>
                                </span>&nbsp;&nbsp;|&nbsp;&nbsp;
                                Privacidade:&nbsp;&nbsp;<i class="fa fa-ban fa-lg"></i>&nbsp;&nbsp;Privada&nbsp;&nbsp;.&nbsp;&nbsp;<i class="fa fa-circle-thin fa-lg"></i>&nbsp;&nbsp;P&uacute;blica
                                &nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa fa-bullseye fa-lg"></i> contagem realizada por uma Auditoria para aferições.<br />
                                <table class="box-table-a" id="dataTable" width="100%">
                                    <thead id="tblListaThead">
                                        <tr>
                                            <th width="05%" id="th1"><div id="sp1" style="text-align: center;">Resp.</div></th>
                                    <th width="06%" id="th2"><span id="sp2">#ID</span></th>
                                    <th width="08%" id="th3"><span id="sp3">Fornecedor</span></th>
                                    <th width="18%" id="th4"><span id="sp4">Processo</span></th>
                                    <th width="10%" id="th5"><span id="sp5">M&eacute;trica</span></th>
                                    <th width="27%" id="th6"><span id="sp6">Cliente/Contrato - O.S.</span></th>
                                    <th width="26%" id="th7"><span id="sp7">Projeto</span></th>
                                    <th width="00%" id="th8"><span id="sp8"></span></th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <!-- final do conteudo -->
                        </div>
                    </div>
                </div>
            </div>
            <br /><br />
            <?php include DIR_BASE . 'forms/form_modal_funcoes_perfil_contagem.php'; ?>
            <?php include DIR_BASE . 'forms/form_modal_selecionar_cliente.php'; ?>
            <?php $isFiscalContrato || $isFiscalContratoFornecedor || $isFiscalContratoEmpresa ? include DIR_BASE . 'forms/form_modal_comparar_contagens.php' : NULL; ?>
            <!-- final do container -->
            <script type="text/javascript" src="/pf/js/min/vendor/jquery/jquery-1.11.3.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/vendor/jquery/jquery-ui.min.js?v=201705111850" charset="utf-8"></script> 
            <script type="text/javascript" src="/pf/js/min/vendor/jquery/jquery.mask.min.js?v=201705111850" charset="utf-8"></script>                                 
            <script type="text/javascript" src="/pf/js/min/vendor/jquery/jquery.floatThead-slim.min.js?v=201705111850" charset="utf-8"></script>                        
            <script type="text/javascript" src="/pf/js/vendor/jquery.dataTables.js?v=201705111850" charset="utf-8" ></script>
            <script type="text/javascript" src="/pf/js/min/vendor/bootstrap/bootstrap.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/vendor/bootstrap/bootstrap-dialog.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/vendor/bootstrap/bootstrap-toggle.min.js?v=201705111850" charset="utf-8" ></script>
            <script type="text/javascript" src="/pf/js/min/vendor/datepicker/datepicker.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/vendor/underscore/underscore-min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/vendor/charcount/charCount.min.js?v=201705111850" charset="utf-8" ></script>
            <script type="text/javascript" src="/pf/js/min/vendor/extenso/extenso.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/vendor/sweetalert/sweetalert.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/vendor/tagmanager/tagmanager.min.js?v=201705111850" charset="utf-8"></script>
            <!--ckeditor TODO: ver problema com o .min.js-->
            <script type="text/javascript" src="/pf/js/min/vendor/ckeditor/ckeditor.js?v=201705111850"></script>
            <!-- biblioteca tree view -->
            <!--<script type="text/javascript" src="/pf/js/vendor/treeview/bootstrap-treeview.js?v=201705111850"></script>-->
            <script type="text/javascript" src="/pf/js/min/vendor/treeview/bootstrap-treeview.min.js?v=201705111850"></script>
            <!-- biblioteca md5 Google -->
            <!--<script language="javascript" src="/pf/js/vendor/md5.js?v=201705111850"></script>-->
            <script language="javascript" src="/pf/js/min/vendor/md5/md5.min.js?v=201705111850"></script>
            <!--bootstrap touch spin -->
            <!--<script type="text/javascript" src="/pf/js/vendor/jquery.bootstrap-touchspin.min.js?v=201705111850" charset="utf-8"></script>-->
            <script type="text/javascript" src="/pf/js/min/vendor/touchspin/jquery.bootstrap-touchspin.min.js?v=201705111850" charset="utf-8"></script>            
            <!-- Dimension(c) scripts -->
            <script type="text/javascript" src="/pf/js/DIM.APIDIM.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.MNUDIM.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.FLSCON.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.FMOFPC.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.FMOCPC.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.FMOAPO.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/user/DIM.FMOUSD.js?v=201705111850" charset="utf-8"></script>
            <!--end-->
            <script src="/pf/login/js/main.min.js"></script>        
            <!--
            <script type="text/javascript" src="/pf/js/min/DIM.APIDIM.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/DIM.MNUDIM.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/DIM.FLSCON.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/DIM.FMOFPC.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/DIM.FMOCPC.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/DIM.FMOAPO.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/user/DIM.FMOUSD.min.js?v=201705111850" charset="utf-8"></script>-->
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