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
<div id="form_modal_configuracoes_empresa" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <form id="form_configuracoes">
                <div class="modal-header">
                    <button type="button" id="fechar_configuracoes_empresa" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <i class="fa fa-cogs"></i>&nbsp;&nbsp;Configura&ccedil;&otilde;es gerais da Empresa<br />
                    <span class="sub-header">Defina os contatos principais da sua empresa, emails, telefones e logomarca</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4><i class="fa fa-user"></i>&nbsp;Informa&ccedil;&otilde;es da Empresa para o sistema</h4>
                                </div>
                            </div>                          
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email_administrador_1">
                                            Email principal do administrador do sistema
                                        </label>
                                        <div class="ui fluid corner labeled input">
                                            <input type="email" class="form-control input_style" placeholder="fulano@abc.com.br" id="email_administrador_1" required>
                                            <div class="ui corner label">
                                                <i class="asterisk icon"></i>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email_administrador_2">
                                            Email alternativo do administrador do sistema
                                        </label>                                    
                                        <input type="email" class="form-control input_style" placeholder="fulano@abc.com.br" id="email_administrador_2">
                                    </div>
                                </div>
                            </div>                
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="telefone_administrador_1">
                                            Telefone de contato (1)
                                        </label>                                    
                                        <input type="text" class="form-control input_style" placeholder="(99) 99999-9999" id="telefone_administrador_1" data-mask="(00) 0000-0000" required>
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="telefone_administrador_2">
                                            Telefone de contato (2)
                                        </label>                                    
                                        <input type="text" class="form-control input_style" placeholder="(99) 99999-9999" id="telefone_administrador_2" data-mask="(00) 0000-0000">
                                    </div>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <img class="img-thumbnail" src="" alt="captcha" id="fmcemp-img-captcha" onclick="refreshCaptcha($(this), $('#fmcemp-txt-captcha'));" data-toggle="tooltip" data-placement="top" title="Clique na imagem para obter outro c&oacute;digo" /><br />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-dot-circle-o" id="fmcemp-i-captcha"></i>&nbsp;<?php echo WORDING_REGISTRATION_CAPTCHA; ?> <sup>*</sup></label>
                                        <div class="ui fluid corner labeled input">
                                            <input class="form-control input_style" type="text" id="fmcemp-txt-captcha" autocomplete="off" maxlength="4" required />
                                            <div class="ui corner label">
                                                <i class="asterisk icon"></i>
                                            </div>
                                        </div>                                         
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4><i class="fa fa-camera"></i>&nbsp;Logomarca para os relat&oacute;rios</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <iframe style="border: 1px dotted #999; width: 100%; height: 565px; overflow: hidden; border-radius: 5px;" src="/pf/vendor/cropper/producao/crop/index.php?t=emp" id="avatar-frame-emp"></iframe>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" id="acoes">
                        <button type="submit" class="btn btn-success" id="sistema_btn_al"><i class="fa fa-check-circle"></i> Atualizar</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
                    </div> 
                </div>
            </form>
        </div>
    </div>
</div>