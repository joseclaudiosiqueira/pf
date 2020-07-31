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
<!-- Modal -->
<div id="form_modal_gerenciar_perfis" class="modal fade" role="dialog">
    <form id="form_gerenciar_perfis" role="form">    
        <div class="modal-dialog modal-lg">
            <!-- Modal content -->
            <div class="modal-content">
                <input type="hidden" id="user_id_user">
                <input type="hidden" id="user_id_empresa">
                <input type="hidden" id="user_id_fornecedor_perfil">
                <input type="hidden" id="user_role_id">
                <input type="hidden" id="user_role_title">
                <input type="hidden" id="user_short_name">
                <!--<input type="hidden" id="fmiar_id" name="perfil_id">-->
                <div class="modal-header">
                    <button type="button" id="fechar_perfil" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <i class="fa fa-users"></i><span id="title-gerenciar-perfis">&nbsp;&nbsp;Gerenciamento de perfis de usu&aacute;rios</span><br />
                    <span class="sub-header">Gest&atilde;o de usu&aacute;rios do sistema Dimension para sua Empresa, Fornecedores e/ou Turmas de Treinamento</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div style="min-height: 450px; max-height: 450px; overflow-x: hidden;overflow-y:scroll; width: 100%;" class="scroll">
                                <table class="box-table-a" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#ID</th>
                                            <th>Nome</th>
                                            <th>Email</th>
                                            <th>E/F<sup>1</sup></th>
                                            <th>Perfil</th>
                                            <th>Cliente</th>
                                            <th><i id="w_usuario_status" class="fa fa-dot-circle-o"></i>&nbsp;Status</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody id="addUsuario"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4><i class="fa fa-sitemap"></i>&nbsp;Informa&ccedil;&otilde;es de acesso</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="grupos">
                                            <span class="pop" data-toggle="popover" data-placement="bottom" 
                                                  data-content="<p align='justify'>ATEN&Ccedil;&Atilde;O: algumas funcionalidades 
                                                  dispon&iacute;veis para o perfil precisam estar contratadas pelo plano da sua empresa. 
                                                  Por exemplo: um Analista de M&eacute;tricas pode inserir contagens de Licita&ccedil;&atilde;o 
                                                  apenas se a empresa contratou um plano que tenha esta funcionalidade.</p>" title="<i class='fa fa-arrow-right'></i>&nbsp;Restri&ccedil;&otilde;es do plano contratado">
                                                <i class="fa fa-info-circle"></i>&nbsp;<i id="w_perfil_grupo" class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;Selecione um perfil</span><span id="span_user_name"></span>
                                        </label>
                                        <select id="select_role_id" class="form-control input_style" disabled required>
                                            <option value="0">...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="alert-info">
                                        <p align="justify">
                                            OBSERVA&Ccedil;&Atilde;O:<br />
                                            Ao alterar um perfil/op&ccedil;&atilde;o de acesso leia sempre a lista de atribui&ccedil;&otilde;es de cada perfil para ter certeza de sua escolha, clique 
                                            <a href="#" data-toggle="modal" data-target="#form_modal_listar_atribuicoes_perfis" class="link-atribuicoes"><strong>AQUI</strong></a>.
                                        </p>
                                    </span>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" style="border:2px dotted #fc8; padding:4px;">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="chk_is_validar_adm_gestor_perfil" class="css-checkbox" disabled />
                                                <label for="chk_is_validar_adm_gestor_perfil" class="css-label-check">&nbsp;Este usu&aacute;rio pode validar contagens?</label>
                                                <br />
                                                <p align="justify">
                                                    <small>A op&ccedil;&atilde;o o lado permite que usu&aacute;rios, mesmo n&atilde;o sendo Validadores Internos, possam validar contagens e atualmente est&aacute; <strong><?= isValidarAdmGestor() ? 'habilitada' : 'desabilitada'; ?></strong> pelo Administrador. Lembre-se que isto &eacute; v&aacute;lido apenas para os perfis Administrador, Gestor e Analista de M&eacute;tricas.</small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <img class="img-thumbnail" src="" alt="captcha" id="perfil-img-captcha" onclick="refreshCaptcha($(this), $('#perfil-txt-captcha'));" data-toggle="tooltip" data-placement="top" title="Clique na imagem para obter outro c&oacute;digo" /><br />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fa fa-dot-circle-o" id="perfil-i-captcha"></i>&nbsp;<?php echo WORDING_REGISTRATION_CAPTCHA; ?><sup>*</sup></label>
                                        <input class="form-control input_style" type="text" id="perfil-txt-captcha" autocomplete="off" maxlength="4"  required />
                                    </div>
                                </div>
                            </div>                             
                        </div>
                    </div>
                </div>
                <div class="modal-footer">                            
                    <div class="row">
                        <div class="col-md-8">
                            LEGENDA: E - Empresa, F - Fornecedor | <i class="fa fa-check-circle-o fa-lg"></i>&nbsp;Administrador, Gestor e/ou Analista de M&eacute;tricas que podem fazer valida&ccedil;&otilde;es em contagens
                        </div>
                        <div class="col-md-4" style="text-align: right;">
                            <div class="btn-group" role="group" aria-label="...">
                                <button type="submit" class="btn btn-success" id="perfil_btn_atualizar" disabled><i class="fa fa-save"></i> Atualizar</button>
                                <button type="button" class="btn btn-info" id="perfil_btn_cancelar" onclick="limpaCamposPerfil(false);" disabled><i class="fa fa-undo"></i> Cancelar</button>
                                <button type="button" class="btn btn-warning" id="perfil_btn_fechar" onclick="limpaCamposPerfil(true);" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </form>    
</div>