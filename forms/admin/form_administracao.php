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
if ($login->isUserLoggedIn() && getPermissao('administracao') && verificaSessao()) {
    $usuario = new Usuario();
    $userId = getUserIdDecoded();
    $idFornecedor = getIdFornecedor();
    $idEmpresa = getIdEmpresa();
    $isFiscalContrato = getVariavelSessao('isFiscalContratoCliente');
    $isFiscalContratoEmpresa = getVariavelSessao('isFiscalContratoEmpresa');
    $isFiscalContratoFornecedor = getVariavelSessao('isFiscalContratoFornecedor');
    /*
     * verifica se eh um instrutor e habilita fornecedores para cadastrar turmas
     */
    $isInstrutor = getVariavelSessao('isInstrutor');
    $tipoFornecedor = getTipoFornecedor();
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <?php include(DIR_BASE . 'include/inc_meta.php'); /* include para as tags meta das paginas HTML */ ?>
        <body style="background-color: #EDEDED;">
            <?php include(DIR_BASE . 'include/inc_navbar.php'); ?>
            <div>
                <!-- inicio do conteudo -->
                <div class="panel-body">
                    <form action="<?= esc_url($_SERVER['PHP_SELF']); ?>">
                        <ul id="ul-adm" class="nav nav-tabs"><!--  style="background-color: rgba(255,255,255,.9);" -->
                            <?php if (getPermissao('turmas_treinamentos') && !isFornecedor() && getConfigPlano('id') == 3) { ?>
                                <li class="tab-adm" id="tab-treinamentos">
                                    <a data-toggle="tab" href="#treinamentos">
                                        <div class="top-title">
                                            <i class="fa fa-graduation-cap fa-lg"></i><!--<span class="not-view"><br>
                                                Turmas e Treinamentos<br />&nbsp;</span>-->
                                        </div>
                                        <span class="not-view">
                                            <strong>Educa&ccedil;&atilde;o</strong></span></a></li>
                                <?php
                            }
                            if (getPermissao('gerenciar_fornecedor') && !(isFornecedor() || getConfigPlano('id') < 3)) {
                                ?>
                                <li class="tab-adm" id="tab-fornecedores">
                                    <a data-toggle="tab" href="#fornecedores">
                                        <div class="top-title">
                                            <i class="fa fa-truck fa-lg"></i><!--<span class="not-view"><br>
                                                Gerenciar fornecedores<br />&nbsp;</span>-->
                                        </div>
                                        <span class="not-view">
                                            <strong>Fornecedores</strong></span></a></li>
                                <?php
                            }
                            if (getPermissao('gerenciar_usuario') && !((isFornecedor() && !getPermissao('gerenciar_usuario')) || getConfigPlano('id') < 3)) {
                                ?>
                                <li class="tab-adm" id="tab-usuarios">
                                    <a data-toggle="tab" href="#usuarios">
                                        <div class="top-title">
                                            <i class="fa fa-user fa-lg"></i><!--<span class="not-view"><br>
                                                Gerenciar Usu&aacute;rios e Alunos</span>-->
                                        </div>
                                        <span class="not-view">
                                            <strong>Usu&aacute;rios</strong></span></a></li>
                                <?php
                            }
                            if (getPermissao('gerenciar_roteiro') && !(isFornecedor() || getConfigPlano('id') < 3)) {
                                ?>
                                <li class="tab-adm" id="tab-roteiros">
                                    <a data-toggle="tab" href="#roteiros">
                                        <div class="top-title">
                                            <i class="fa fa-sitemap fa-lg"></i><!--<span class="not-view"><br>
                                                Gerenciar roteiros e itens</span>-->
                                        </div>
                                        <span class="not-view">
                                            <strong>Roteiros</strong></span></a></li>
                                <?php
                            }
                            if (getPermissao('gerenciar_cliente')) {
                                ?>
                                <li class="tab-adm" id="tab-clientes">
                                    <a data-toggle="tab" href="#clientes">
                                        <div class="top-title">
                                            <i class="fa fa-users fa-lg"></i><!--<span class="not-view"><br>
                                                Gerenciar clientes<br />&nbsp;</span>-->
                                        </div>
                                        <span class="not-view">
                                            <strong>Clientes</strong></span></a></li>
                                <?php
                            }
                            if (getPermissao('gerenciar_contrato')) {
                                ?>
                                <li class="tab-adm" id="tab-contratos">
                                    <a data-toggle="tab" href="#contratos">
                                        <div class="top-title">
                                            <i class="fa fa-file-text-o fa-lg"></i><!--<span class="not-view"><br>
                                                Gerenciar contratos<br />&nbsp;</span>-->
                                        </div>
                                        <span class="not-view">
                                            <strong>Contratos</strong></span></a></li>
                                <?php
                            }
                            if (getPermissao('gerenciar_projeto')) {
                                ?>
                                <li class="tab-adm" id="tab-projetos">
                                    <a data-toggle="tab" href="#projetos">
                                        <div class="top-title">
                                            <i class="fa fa-calendar fa-lg"></i><!--<span class="not-view"><br>
                                                Gerenciar projetos contratados</span>-->
                                        </div>
                                        <span class="not-view">
                                            <strong>Projetos</strong></span></a></li>
                                <?php
                            }
                            if (getPermissao('configuracao_empresa')) {
                                ?>
                                <li class="tab-adm" id="configuracoes-empresa-fornecedores"></li>
                                <?php
                            }
                            if (getPermissao('configuracao_contagem')) {
                                ?>
                                <li class="tab-adm" id="tab-contagens">
                                    <a data-toggle="tab" href="#contagem">
                                        <div class="top-title">
                                            <i class="fa fa-list-alt fa-lg"></i><!--<span class="not-view"><br>
                                                Configurar contagens e tarefas</span>-->
                                        </div>
                                        <span class="not-view">
                                            <strong>Contagem</strong></span></a></li>                                   
                                <?php
                            }
                            if (getPermissao('configuracao_relatorios')) {
                                ?>
                                <li class="tab-adm" id="configuracoes-empresa-fornecedor"></li>
                                <?php
                            }
                            if (getPermissao('configuracao_relatorios')) {
                                ?>
                                <li class="tab-adm" id="configuracoes-empresa">
                                    <a data-toggle="tab" href="#relatorios">
                                        <div class="top-title">
                                            <i class="fa fa-files-o fa-lg"></i><!--<span class="not-view"><br>
                                                Configurar relat&oacute;rios<br /></span>-->
                                        </div>
                                        <span class="not-view">
                                            <strong>Relat&oacute;rios</strong></span></a></li>
                                <?php
                            }
                            ?>
                        </ul>
                        <div class="tab-content tab-transp">
                            <div id="treinamentos" class="tab-pane fade in">
                                <?php (getPermissao('turmas_treinamentos') || $isInstrutor && !((isFornecedor() && !$tipoFornecedor) || getConfigPlano('id') < 3)) ? include('tab_treinamentos.php') : NULL; ?>
                            </div>                              
                            <div id="fornecedores" class="tab-pane fade in">
                                <?php getPermissao('gerenciar_fornecedor') ? include('tab_fornecedores.php') : NULL; ?>
                            </div>                            
                            <div id="clientes" class="tab-pane fade in">
                                <?php getPermissao('gerenciar_cliente') ? include 'tab_clientes.php' : NULL; ?>
                            </div>
                            <div id="contratos" class="tab-pane fade in">
                                <?php getPermissao('gerenciar_contrato') ? include 'tab_contratos.php' : NULL; ?>
                            </div>
                            <div id="projetos" class="tab-pane fade in">
                                <?php getPermissao('gerenciar_projeto') ? include 'tab_projetos.php' : NULL; ?>
                            </div>                            
                            <div id="usuarios" class="tab-pane fade in">
                                <?php getPermissao('gerenciar_usuario') ? include 'tab_usuarios.php' : NULL; ?>
                            </div>
                            <div id="contagem" class="tab-pane fade in">
                                <?php getPermissao('configuracao_contagem') ? include 'tab_contagem.php' : NULL; ?>
                            </div>
                            <div id="roteiros" class="tab-pane fade in">
                                <?php getPermissao('gerenciar_roteiro') ? include 'tab_roteiros.php' : NULL; ?>
                            </div>
                            <div id="empresa" class="tab-pane fade in">
                                <?php getPermissao('configuracao_empresa') ? include 'tab_empresa.php' : NULL; ?>
                            </div>
                            <div id="conf-fornecedor" class="tab-pane fade in">
                                <?php getPermissao('configuracao_empresa') ? include 'tab_ajustes.php' : NULL; ?>
                            </div>
                            <div id="relatorios" class="tab-pane fade in">
                                <?php getPermissao('configuracao_relatorios') ? include 'tab_relatorios.php' : NULL; ?>
                            </div>                             
                        </div>
                    </form>
                </div>
                <?php include DIR_BASE . 'forms/form_modal_selecionar_cliente.php'; ?>
                <?php getConfigPlano('id') == 3 && getPermissao('gerenciar_contrato') ? include ('form_modal_inserir_alterar_contrato.php') : NULL; ?>
                <?php getConfigPlano('id') == 3 && getPermissao('gerenciar_projeto') ? include ('form_modal_inserir_alterar_projeto.php') : NULL; ?>
                <?php getConfigPlano('id') == 3 && getPermissao('gerenciar_usuario') ? include ('form_modal_inserir_alterar_usuario.php') : NULL; ?>
                <?php getConfigPlano('id') == 3 && getPermissao('gerenciar_cliente') ? include ('form_modal_inserir_alterar_cliente.php') : NULL; ?>
                <?php getConfigPlano('id') == 3 && (getPermissao('gerenciar_fornecedor') || $isInstrutor && !((isFornecedor() && !$tipoFornecedor) || getConfigPlano('id') < 3)) ? include ('form_modal_inserir_alterar_fornecedor.php') : NULL; ?>
                <?php getConfigPlano('id') == 3 && getPermissao('administracao') ? include ('form_modal_configuracoes_autenticacao.php') : NULL; ?>
                <?php getUserName() === '41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265' ? include ('form_modal_inserir_empresa.php') : NULL; ?>
                <?php getPermissao('configuracao_contagem') ? include ('form_modal_inserir_alterar_fator_impacto.php') : NULL; ?>
                <?php getPermissao('configuracao_contagem') ? include ('form_modal_configuracoes_contagem.php') : NULL; ?>
                <?php getPermissao('configuracao_contagem') ? include ('form_modal_configuracoes_tab_inicio.php') : NULL; ?>
                <?php getPermissao('configuracao_contagem') ? include ('form_modal_configuracoes_tarefas.php') : NULL; ?>
                <?php getPermissao('configuracao_contagem') ? include ('form_modal_configuracoes_cocomo_escala.php') : NULL; ?>
                <?php getPermissao('configuracao_contagem') ? include ('form_modal_configuracoes_cocomo_pos_arquitetura.php') : NULL; ?>
                <?php getPermissao('configuracao_contagem') ? include ('form_modal_configuracoes_cocomo_projeto_inicial.php') : NULL; ?>
                <?php getPermissao('configuracao_contagem') ? include ('form_modal_configuracoes_cocomo_fases.php') : NULL; ?>
                <?php getPermissao('configuracao_contagem') ? include ('form_modal_configuracoes_cocomo_linguagem.php') : NULL; ?>
                <?php getPermissao('configuracao_contagem') ? include ('form_modal_configuracoes_banco_dados.php') : NULL; ?>
                <?php getPermissao('configuracao_empresa') ? include ('form_modal_configuracoes_empresa.php') : NULL; ?>
                <?php getPermissao('configuracao_relatorios') ? include ('form_modal_configuracoes_relatorios.php') : NULL; ?>
                <?php getPermissao('gerenciar_roteiro') ? include ('form_modal_inserir_alterar_roteiro.php') : NULL; ?>
                <?php getPermissao('gerenciar_usuario') ? include ('form_modal_gerenciar_perfis.php') : NULL; ?>
                <?php getPermissao('gerenciar_usuario') ? include ('form_modal_listar_usuarios.php') : NULL; ?>
                <?php getPermissao('gerenciar_usuario') ? include ('form_modal_listar_atribuicoes_perfis.php') : NULL; ?>
                <!-- final do conteudo -->
            </div>
            <script type="text/javascript" src="/pf/js/min/vendor/jquery/jquery-1.11.3.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/vendor/jquery/jquery-ui.min.js?v=201705111850" charset="utf-8"></script> 
            <script type="text/javascript" src="/pf/js/min/vendor/jquery/jquery.mask.min.js?v=201705111850" charset="utf-8"></script>                                 
            <script type="text/javascript" src="/pf/js/min/vendor/jquery/jquery.floatThead-slim.min.js?v=201705111850" charset="utf-8"></script>                        
            <script type="text/javascript" src="/pf/js/min/vendor/jquery/jquery.bootstrap-touchspin.min.js?v=201705111850" charset="utf-8"></script>                        
            <script type="text/javascript" src="/pf/js/min/vendor/datatables/jquery.dataTables.min.js?v=201705111850" charset="utf-8" ></script>
            <script type="text/javascript" src="/pf/js/min/vendor/bootstrap/bootstrap.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/vendor/bootstrap/bootstrap-dialog.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/vendor/bootstrap/bootstrap-toggle.min.js?v=201705111850" charset="utf-8" ></script>
            <script type="text/javascript" src="/pf/js/min/vendor/bootstrap/bootstrap-datepicker.min.js?v=201705111850" charset="utf-8"></script>            
            <script type="text/javascript" src="/pf/js/min/vendor/underscore/underscore-min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/vendor/charcount/charCount.min.js?v=201705111850" charset="utf-8" ></script>
            <script type="text/javascript" src="/pf/js/min/vendor/extenso/extenso.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/vendor/sweetalert/sweetalert.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/vendor/tagmanager/tagmanager.min.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/min/vendor/ckeditor/ckeditor.js?v=201705111850"></script>
            <!-- Dimension(c) scripts -->
            <script type="text/javascript" src="/pf/js/DIM.APIDIM.js?v=201705111850?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/DIM.MNUDIM.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/user/DIM.FMOUSD.js?v=201705111850" charset="utf-8"></script>
            <script type="text/javascript" src="/pf/js/admin/DIM.FMOCTI.js?v=201705111850" charset="utf-8"></script>
            <?php
            echo getPermissao('form_gerenciar_baselines') ?
                    '<script type="text/javascript" src="/pf/js/DIM.FMOGBA.js?v=201705111850" charset="utf-8"></script>' : NULL;
            echo (getPermissao('form_gerenciar_orgao') && getVariavelSessao('isGestor') || getVariavelSessao('isAdministrador')) ?
                    '<script type="text/javascript" src="/pf/js/DIM.FMOORG.js?v=201705111850" charset="utf-8"></script>' : NULL;
            ?>            
            <!-- Dimension(c) scripts adiministracao -->
            <script type="text/javascript" src="/pf/js/admin/DIM.FADMDIM.js?v=201705111850" charset="utf-8"></script>
            <?php echo getPermissao('configuracao_contagem') ? '<script type="text/javascript" src="/pf/js/admin/DIM.FMOCCON.js?v=201705111850" charset="utf-8"></script>' : NULL; ?>
            <?php echo getPermissao('configuracao_contagem') ? '<script type="text/javascript" src="/pf/js/admin/DIM.FMOCOTA.js?v=201705111850" charset="utf-8"></script>' : NULL; ?>
            <?php echo getPermissao('configuracao_contagem') ? '<script type="text/javascript" src="/pf/js/admin/DIM.FMOCOCO.js?v=201705111850" charset="utf-8"></script>' : NULL; ?><!--escala / fatores-->
            <?php echo getPermissao('configuracao_contagem') ? '<script type="text/javascript" src="/pf/js/admin/DIM.FMOCOLG.js?v=201705111850" charset="utf-8"></script>' : NULL; ?><!--linguagem-->
            <?php echo getPermissao('configuracao_contagem') ? '<script type="text/javascript" src="/pf/js/admin/DIM.FMOCOBD.js?v=201705111850" charset="utf-8"></script>' : NULL; ?><!--banco de dados-->
            <?php echo getPermissao('configuracao_empresa') ? '<script type="text/javascript" src="/pf/js/admin/DIM.FMOCOEM.js?v=201705111850" charset="utf-8"></script>' : NULL; ?>
            <?php echo getPermissao('configuracao_relatorios') ? '<script type="text/javascript" src="/pf/js/admin/DIM.FMOCREL.js?v=201705111850" charset="utf-8"></script>' : NULL; ?>
            <?php echo getPermissao('gerenciar_cliente') ? '<script type="text/javascript" src="/pf/js/admin/DIM.FMOIACL.js?v=201705111850" charset="utf-8"></script>' : NULL; ?>
            <?php echo getPermissao('gerenciar_contrato') ? '<script type="text/javascript" src="/pf/js/admin/DIM.FMOIACO.js?v=201705111850" charset="utf-8"></script>' : NULL; ?>
            <?php echo getPermissao('gerenciar_projeto') ? '<script type="text/javascript" src="/pf/js/admin/DIM.FMOIAPJ.js?v=201705111850" charset="utf-8"></script>' : NULL; ?>
            <?php echo getPermissao('gerenciar_usuario') ? '<script type="text/javascript" src="/pf/js/admin/DIM.FMOIAUS.js?v=201705111850" charset="utf-8"></script>' : NULL; ?>
            <?php echo getPermissao('gerenciar_roteiro') ? '<script type="text/javascript" src="/pf/js/admin/DIM.FMOIARO.js?v=201705111850" charset="utf-8"></script>' : NULL; ?>
            <?php echo getPermissao('gerenciar_roteiro') ? '<script type="text/javascript" src="/pf/js/admin/DIM.FMOIAFI.js?v=201705111850" charset="utf-8"></script>' : NULL; ?>            
            <?php echo getPermissao('gerenciar_usuario') ? '<script type="text/javascript" src="/pf/js/admin/DIM.FMOLUSU.js?v=201705111850" charset="utf-8"></script>' : NULL; ?>
            <?php echo getPermissao('gerenciar_usuario') ? '<script type="text/javascript" src="/pf/js/admin/DIM.FMOLSAP.js?v=201705111850" charset="utf-8"></script>' : NULL; ?>
            <?php echo getPermissao('gerenciar_baseline') ? '<script type="text/javascript" src="/pf/js/DIM.FMOGBA.js?v=201705111850" charset="utf-8"></script>' : NULL; ?>
            <?php echo getPermissao('configuracao_empresa') && getPermissao('administracao') ? '<script type="text/javascript" src="/pf/js/admin/DIM.FMOCOAU.js?v=201705111850" charset="utf-8"></script>' : NULL; ?>            
            <?php echo getPermissao('gerenciar_fornecedor') || getPermissao('turmas_treinamentos') ? '<script type="text/javascript" src="/pf/js/admin/DIM.FMOIAFO.js?v=201705111850" charset="utf-8"></script>' : NULL; ?>            
            <!--generico-->
            <script type="text/javascript" src="/pf/js/DIM.FMOAPO.js?v=201705111850" charset="utf-8"></script>
        </body>
    </html>
    <?php
} else {
    header("Location: /pf/index.php");
}    