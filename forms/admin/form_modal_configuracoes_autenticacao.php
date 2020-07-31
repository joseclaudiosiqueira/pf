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
<div id="form_modal_configuracoes_autenticacao" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <form id="form_configuracoes_autenticacao">
                <div class="modal-header">
                    <button type="button" id="fechar_autenticacao" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <i class="fa fa-user-secret"></i>Configura&ccedil;&otilde;es de autentica&ccedil;&atilde;o<br />
                    <span class="sub-header">Consulte o administrador de rede da sua empresa antes de alterar estas configura&ccedil;&otilde;es</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">                          
                            <div class="row">
                                <div class="col-md-12">
                                    <h4><i class="fa fa-user"></i>&nbsp;Informa&ccedil;&otilde;es de autentica&ccedil;&atilde;o</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">    
                                        <label for="ldaptipo">Tipo de autentica&ccedil;&atilde;o</label>
                                        <select class="form-control input_style" id="ldaptipo">
                                            <option value="0">Nuvem Dimension</option>
                                            <option value="1">LDAP Server</option>
                                        </select>
                                    </div>
                                </div>
                            </div>                              
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="username">
                                            Usu&aacute;rio
                                        </label>
                                        <input type="text" class="form-control input_style" placeholder="Usuario" id="username" value="" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">
                                            Senha
                                        </label>                                    
                                        <input type="password" class="form-control input_style"  id="password" value="" >
                                    </div>
                                </div>
                            </div>                
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="ldapserver">
                                            Endere&ccedil;o do servidor LDAP
                                        </label>                                    
                                        <input type="text" class="form-control input_style" placeholder="servidor.com.br" id="ldapserver" value="" >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="ldapport">
                                            Porta
                                        </label>                                    
                                        <input type="text" class="form-control input_style" placeholder="99999" id="ldapport" value="389" data-mask="99999" >
                                    </div>
                                </div>                                
                            </div> 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="domain">
                                            Dom&iacute;nio (domain)
                                        </label>                                    
                                        <input type="text" class="form-control input_style" placeholder="dc=gov,dc=br" id="ldapdomain" value="" >
                                    </div>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <img class="img-thumbnail" src="" alt="captcha" id="ldap-img-captcha" onclick="refreshCaptcha($(this), $('#ldap-txt-captcha'));" data-toggle="tooltip" data-placement="top" title="Clique na imagem para obter outro c&oacute;digo" /><br />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-dot-circle-o" id="ldap-i-captcha"></i>&nbsp;<?php echo WORDING_REGISTRATION_CAPTCHA; ?><sup>*</sup></label>
                                        <input class="form-control input_style" type="text" id="ldap-txt-captcha" autocomplete="off" maxlength="4" required />
                                    </div>
                                </div>
                            </div>                        
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4><i class="fa fa-list"></i>&nbsp;Log de conex&atilde;o com o servidor</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="span-retorno-ldap" style="border:1px dotted #999;width:100%;height:393px;overflow:hidden;padding:15px;border-radius:5px;"></div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" id="acoes">
                        <button type="button" class="btn btn-success" id="ldap_btn_ts"><i class="fa fa-cogs"></i> Testar</button>
                        <button type="submit" class="btn btn-success" id="ldap_btn_al"><i class="fa fa-check-circle"></i> Atualizar</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>