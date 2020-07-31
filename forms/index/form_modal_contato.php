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
<div id="modal-contato" class="modal fade" role="dialog">
    <form role="form" id="form-contato">
        <div class="modal-dialog modal-">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <i class="fa fa-envelope-o"></i>&nbsp;&nbsp;Contato<br />
                    <span class="sub-header">Preencha o formul&aacute;rio que retornaremos em at&eacute; 72h (setenta e duas) horas</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="ui fluid corner labeled input">
                                    <div class="wrap-input100 m-t-20 m-b-20">
                                        <input class="input100" id="ctn" name="ctn" type="text" autocomplete="off" style="border: none;" required autofocus />
                                        <span class="focus-input100" data-placeholder="Nome"></span>
                                        <div class="ui corner label">
                                            <i class="asterisk icon"></i>
                                        </div>                                    
                                    </div>                                                              
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">                        
                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="ui fluid corner labeled input">
                                    <div class="wrap-input100 m-t-20 m-b-20">
                                        <input class="input100" id="cte" name="cte" type="text" autocomplete="off" style="border: none;" required />
                                        <span class="focus-input100" data-placeholder="Email"></span>
                                        <div class="ui corner label">
                                            <i class="asterisk icon"></i>
                                        </div>  
                                    </div>
                                </div>                                                                                             
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="ui fluid corner labeled input">
                                    <div class="wrap-input100 m-t-20 m-b-20">
                                        <input class="input100 sp_celphones" id="ctt" name="ctt" type="text" autocomplete="off" style="border: none;" required autofocus />
                                        <span class="focus-input100" data-placeholder="Telefone"></span>
                                        <div class="ui corner label">
                                            <i class="asterisk icon"></i>
                                        </div>  
                                    </div>
                                </div>                                                              
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="ui fluid corner labeled input">
                                    <div class="wrap-input100 m-t-20 m-b-20">
                                        <textarea class="input100 scroll" id="ctm" name="ctm" rows="9" 
                                                  style="
                                                  border: none;
                                                  min-height: 135px;
                                                  outline: none;
                                                  -webkit-box-shadow: none;
                                                  -moz-box-shadow: none;
                                                  box-shadow: none;
                                                  resize: none;
                                                  padding-top: 15px;" required></textarea>
                                        <span class="focus-input100" data-placeholder="Mensagem"></span>
                                        <div class="ui corner label">
                                            <i class="asterisk icon"></i>
                                        </div> 
                                    </div>
                                </div>                                  
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <div class="form-group" style="text-align: right;">
                                <img class="img-thumbnail img-responsive" src="" alt="captcha" id="contato-img-captcha" onclick="refreshCaptcha($(this), $('#contato-txt-captcha'));" data-toggle="tooltip" data-placement="top" title="Clique na imagem para obter outro c&oacute;digo" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="ui fluid corner labeled input">
                                    <div class="wrap-input100 m-t-30 m-b-35">
                                        <input class="input100" id="contato-txt-captcha" name="contato-txt-captcha" type="text" maxlength="4" autocomplete="off" style="border: none;" required />
                                        <span class="focus-input100" data-placeholder="<?php echo WORDING_REGISTRATION_CAPTCHA; ?>"></span>
                                        <!--&nbsp;<i class="fa fa-dot-circle-o fa-2x" id="contato-i-captcha"></i>-->
                                        <div class="ui corner label">
                                            <i class="asterisk icon"></i>
                                        </div> 
                                    </div>
                                </div>                                  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                        <button class="login100-form-btn" type="submit" id="btn-enviar"><i class="fa fa-send fa-lg" id="i-btn-enviar"></i>&nbsp;&nbsp;Enviar mensagem</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
