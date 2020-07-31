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
<div id="form_modal_projeto" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <form id="form_inserir_alterar_projeto">
                <input type="hidden" id="prj_id">
                <input type="hidden" id="prj_acao" value="inserir">                
                <div class="modal-header">
                    <button type="button" id="fechar_projeto" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <i class="fa fa-calendar"></i>&nbsp;&nbsp;Projetos<br />
                    <span class="sub-header">Gerenciamento dos projetos associados &agrave;s contagens</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div style="min-height: 535px; max-height: 535px; overflow-x: hidden; overflow-y: scroll; width: 100%;" class="scroll">
                                <table class="box-table-a" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="60%">Projeto
                                            <th width="15%">In&iacute;cio</th>
                                            <th width="15%">Fim</th>
                                            <th width="10%"><i id="w_projeto_status" class="fa fa-dot-circle-o"></i>&nbsp;Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="addProjeto"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="prj_id_cliente">
                                            <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Clientes" data-content="<p align='justify'>Nesta lista s&atilde;o exibidos apenas os clientes <strong>ATIVOS</strong>. Caso o contrato n&atilde;o esteja na lista, contate um dos Gestores ou o <a href='mailto:<?= getAdministrador(getIdEmpresa()); ?>'>Administrador</a> do sistema.</p>">
                                                <i class="fa fa-info-circle"></i>&nbsp;Cliente(s)
                                            </span>
                                        </label>
                                        <select class="form-control input_style" id="prj_id_cliente"></select>
                                    </div>            
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="id_contrato">
                                            <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Contratos" data-content="<p align='justify'>Nesta lista s&atilde;o exibidos apenas os contratos <strong>ATIVOS</strong>. Caso o contrato n&atilde;o esteja na lista, contate um dos Gestores ou o <a href='mailto:<?= getAdministrador(getIdEmpresa()); ?>'>Administrador</a> do sistema.</p>">
                                                <i id="w_id_contrato" class="fa fa-dot-circle-o"></i>
                                                <i class="fa fa-info-circle"></i>&nbsp;Contrato(s)
                                            </span>
                                        </label>
                                        <select class="form-control input_style" id="prj_id_contrato" disabled></select>
                                    </div>            
                                </div>
                            </div>
                            <div class="row">                    
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="prj_descricao">
                                            <span class="pop" data-toggle="popover" data-placement="bottom" data-content="<p align='justify'>Digite uma descri&ccedil;&atilde;o suscinta do projeto com no m&aacute;ximo 255 (duzentos e cinquenta e cinco) caracteres." title="<i class='fa fa-arrow-right'></i>&nbsp;Descricao"><i class="fa fa-info-circle"></i>&nbsp;Descri&ccedil;&atilde;o</span>
                                        </label>
                                        <div class="ui fluid corner labeled input">
                                            <input type="text" class="form-control input_style" id="prj_descricao" placeholder="Descri&ccedil;&atilde;o" maxlength="255" autocomplete="off" required>
                                            <div class="ui corner label">
                                                <i class="asterisk icon"></i>
                                            </div>
                                        </div>                                         
                                    </div>
                                </div>              
                            </div>
                            <div class="row">      
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="prj_data_inicio">In&iacute;cio do projeto</label>
                                        <input type="text" class="form-control input_calendar input_style" placeholder="dd/mm/yyyy" id="prj_data_inicio" autocomplete="off" data-mask="99/99/9999">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="prj_data_fim">Final do projeto</label>
                                        <input type="text" class="form-control input_calendar input_style" placeholder="dd/mm/yyyy" id="prj_data_fim" autocomplete="off" data-mask="99/99/9999">
                                    </div>
                                </div>                                 
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="prj_is_ativo">Status</label><br>
                                        <input id="prj_is_ativo" type="checkbox" data-width="100" data-height="36" data-toggle="toggle" data-onstyle="success" data-style="slow" data-on="Ativo" data-off="Inativo" class="btn btn-sm" checked disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="prj_id_gerente_projeto"><span class="pop" data-toggle="popover" data-placement="bottom" data-content="A funcionalidade abaixo estar&aacute; dispon&iacute;vel apenas se sua empresa for utilizar Gest&atilde;o de Projetos nas contagens." title="<i class='fa fa-arrow-right'></i>&nbsp;Gest&atilde;o de projetos"><i class="fa fa-info-circle"></i>&nbsp;Gerente do projeto</span></label><br>
                                        <select id="prj_id_gerente_projeto" class="form-control input_style" <?= $_SESSION['contagem_config']['is_gestao_projetos'] ? '' : 'disabled'; ?>></select>
                                    </div>                                    
                                </div>
                            </div>
                            <div style="border: 1px dotted #c0c0c0; border-radius: 5px; padding: 20px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <img class="img-thumbnail" alt="captcha" id="fmiapro-img-captcha" onclick="refreshCaptcha($(this), $('#fmiapro-txt-captcha'));" data-toggle="tooltip" data-placement="top" title="Clique na imagem para obter outro c&oacute;digo"/><br />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><i class="fa fa-dot-circle-o" id="fmiapro-i-captcha"></i>&nbsp;<?php echo WORDING_REGISTRATION_CAPTCHA; ?></label>
                                            <div class="ui fluid corner labeled input">
                                                <input class="form-control input_style" type="text" id="fmiapro-txt-captcha" autocomplete="off" maxlength="4" required />
                                                <div class="ui corner label">
                                                    <i class="asterisk icon"></i>
                                                </div>
                                            </div>                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>               
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group" aria-label="...">
                        <button type="submit" class="btn btn-success" id="prj_btn_inserir" onclick="$('#prj_acao').val('inserir');"><i class="fa fa-save"></i> Salvar</button>
                        <button type="button" class="btn btn-success" id="prj_btn_novo" disabled><i class="fa fa-plus-circle"></i> Inserir outro</button>
                        <button type="submit" class="btn btn-success" id="prj_btn_atualizar" onclick="$('#prj_acao').val('alterar');" disabled><i class="fa fa-refresh"></i> Atualizar</button>
                        <button type="button" class="btn btn-warning" id="prj_btn_fechar" onclick="limpaCamposProjeto(true);" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
                    </div></div>
            </form>
        </div>
    </div>
</div>