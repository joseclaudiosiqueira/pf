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
<div id="modal-nova-conta" class="modal fade" role="dialog">
    <div class="modal-dialog modal-">
        <!-- Modal content -->
        <div class="modal-content">
            <form role="form" id="form-nova-conta">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="fechar-nova-conta"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <i class="fa fa-user-plus"></i>&nbsp;&Oacute;tima decis&atilde;o!<br />
                    <span class="sub-header">Preencha o formul&aacute;rio abaixo para criar a sua conta, &eacute; livre e responderemos em at&eacute; 72h (setenta e duas) horas</span>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="tipo"> <input type="hidden" id="plano">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group login100-form-title2">
                                Selecione um tipo
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group login100-form-title2">
                                Selecione um plano
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group ">
                                <div class="btn-group btn-block" role="group" aria-label="...">
                                    <button id="pf" type="button" class="btn btn-default col-lg-4"><i class="fa fa-user"></i>&nbsp;P. F&iacute;sica</button>
                                    <button id="pj" type="button" class="btn btn-default col-lg-4"><i class="fa fa-building"></i>&nbsp;P. Jur&iacute;dica</button>
                                    <button id="es" type="button" class="btn btn-default col-lg-4" data-toggle="collapse" data-target="#div-estudante"><i class="fa fa-graduation-cap"></i>&nbsp;Estudante</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="btn-group btn-block" role="group" aria-label="...">
                                    <button id="de" type="button" class="btn btn-default col-lg-4"><i class="fa fa-desktop"></i>&nbsp;Demo</button>
                                    <button id="em" type="button" class="btn btn-default col-lg-4"><i class="fa fa-bank"></i>&nbsp;Empresa</button>
                                    <button id="co" type="button" class="btn btn-default col-lg-4" disabled>&nbsp;&nbsp;</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="div-estudante" class="collapse" style="border: 1px dotted #666; padding: 10px; margin-bottom: 10px;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <h5 style="display: inline;">Ajude-nos a melhorar os nossos
                                            servi&ccedil;os</h5>
                                        <br /> <small>Estas informa&ccedil;&otilde;es t&ecirc;m cunho
                                            meramente estat&iacute;stico, sem qualquer
                                            associa&ccedil;&atilde;o com o seu perfil.</small>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="wrap-input100 m-t-20 m-b-20">
                                                <select class="input100" id="uf-estudante" style="border: none;">
                                                    <option value="estado">Selecione o Estado</option>
                                                    <option value="ac">Acre</option>
                                                    <option value="al">Alagoas</option>
                                                    <option value="am">Amazonas</option>
                                                    <option value="ap">Amap&aacute;</option>
                                                    <option value="ba">Bahia</option>
                                                    <option value="ce">Cear&aacute;</option>
                                                    <option value="df">Distrito Federal</option>
                                                    <option value="es">Esp&iacute;rito Santo</option>
                                                    <option value="go">Goi&aacute;s</option>
                                                    <option value="ma">Maranh&atilde;o</option>
                                                    <option value="mt">Mato Grosso</option>
                                                    <option value="ms">Mato Grosso do Sul</option>
                                                    <option value="mg">Minas Gerais</option>
                                                    <option value="pa">Par&aacute;</option>
                                                    <option value="pb">Para&iacute;ba</option>
                                                    <option value="pr">Paran&aacute;</option>
                                                    <option value="pe">Pernambuco</option>
                                                    <option value="pi">Piau&iacute;</option>
                                                    <option value="rj">Rio de Janeiro</option>
                                                    <option value="rn">Rio Grande do Norte</option>
                                                    <option value="ro">Rond&ocirc;nia</option>
                                                    <option value="rs">Rio Grande do Sul</option>
                                                    <option value="rr">Roraima</option>
                                                    <option value="sc">Santa Catarina</option>
                                                    <option value="se">Sergipe</option>
                                                    <option value="sp">S&atilde;o Paulo</option>
                                                    <option value="to">Tocantins</option>
                                                </select>
                                                <span class="focus-input100" data-placeholder=""></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="wrap-input100 m-t-20 m-b-20">
                                                <input class="input100" id="instituicao-ensino" type="text" autocomplete="off" />
                                                <span class="focus-input100" data-placeholder="Institui&ccedil;&atilde;o de ensino"></span>
                                            </div>                                              
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="ui fluid corner labeled input">
                                    <div class="wrap-input100 m-t-20 m-b-20">
                                        <input class="input100" id="cnpj-cpf" type="text" onblur="validar(this);" autocomplete="off" style="border: none;" disabled required />
                                        <span class="focus-input100" data-placeholder="CPF/CNPJ"></span>
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
                                        <input class="input100" id="nome-empresa" type="text" onblur="validar(this);" autocomplete="off" style="border: none;" required />
                                        <span class="focus-input100" data-placeholder="Nome"></span>
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
                                        <input class="input100" id="sigla" type="text" autocomplete="off" style="border: none;" required />
                                        <span class="focus-input100" data-placeholder="Iniciais/SIGLA"></span>
                                        <div class="ui corner label">
                                            <i class="asterisk icon"></i>
                                        </div>
                                    </div>                                                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="ui fluid corner labeled input">
                                    <div class="wrap-input100 m-t-20 m-b-20">
                                        <input class="input100" id="cep" type="text" autocomplete="off" data-mask="99999999" maxlength="8" autocomplete="off" style="border: none;" required />
                                        <span class="focus-input100" data-placeholder="CEP - Apenas números"></span>
                                        <div class="ui corner label">
                                            <i class="asterisk icon"></i>
                                        </div>                                      
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="wrap-input100 m-t-20 m-b-20">
                                    <input class="input100" id="bairro" type="text" autocomplete="off" readonly />
                                    <span class="focus-input100" data-placeholder=""></span>
                                </div>                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="wrap-input100 m-t-20 m-b-20">
                                    <input class="input100" id="cidade" type="text" autocomplete="off" readonly />
                                    <span class="focus-input100" data-placeholder=""></span>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="wrap-input100 m-t-20 m-b-20">
                                    <input class="input100" id="txt-estado" type="text" autocomplete="off" readonly />
                                    <span class="focus-input100" data-placeholder=""></span>
                                </div>                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="wrap-input100 m-t-20 m-b-20">
                                    <input class="input100" id="logradouro" type="text" autocomplete="off" readonly />
                                    <span class="focus-input100" data-placeholder=""></span>
                                </div>                                
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="wrap-input100 m-t-20 m-b-20">
                                    <input class="input100" id="complemento" type="text" autocomplete="off" />
                                    <span class="focus-input100" data-placeholder="Complemento"></span>
                                </div>                                
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="wrap-input100 m-t-20 m-b-20">
                                    <input class="input100" id="numero" type="text" autocomplete="off" maxlength="6" data-mask="999999" />
                                    <span class="focus-input100" data-placeholder="Número"></span>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <span class="pop login100-form-title2" data-toggle="popover" data-placement="right"
                                      title="<i class='fa fa-arrow-right'></i>&nbsp;Contato
                                      principal" data-content="&Eacute; atrav&eacute;s deste contato que vamos
                                      iniciar o cadastro do primeiro usu&aacute;rio no sistema. Voc&ecirc; pode
                                      informar um contato seu, caso deseje, ou um contato
                                      administrativo. <strong>ATEN&Ccedil;&Atilde;O</strong>: este contato ser&aacute;
                                      cadastrado como o primeiro &quot;Administrador&quot; do
                                      sistema."><i class="fa fa-info-circle"></i>&nbsp;Contato principal</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="ui fluid corner labeled input">
                                    <div class="wrap-input100 m-t-20 m-b-20">
                                        <input class="input100" id="contato-nome" type="text" autocomplete="off" style="border: none;" required />
                                        <span class="focus-input100" data-placeholder="Nome completo"></span>
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
                                        <input class="input100" id="contato-email" type="email" autocomplete="off" style="border: none;" required />
                                        <span class="focus-input100" data-placeholder="Email"></span>
                                        <div class="ui corner label">
                                            <i class="asterisk icon"></i>
                                        </div>                                    
                                    </div>                                  
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="ui fluid corner labeled input">
                                    <div class="wrap-input100 m-t-20 m-b-20">
                                        <input class="input100" id="contato-telefone-fixo" data-mask="(00) 0000 0000" type="text" autocomplete="off" style="border: none;" required />
                                        <span class="focus-input100" data-placeholder="Telefone fixo"></span>
                                        <div class="ui corner label">
                                            <i class="asterisk icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="wrap-input100 m-t-20 m-b-20">
                                    <input class="input100" id="contato-ramal" type="text" data-mask="000000" autocomplete="off" />
                                    <span class="focus-input100" data-placeholder="Ramal"></span>
                                </div>                                  
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="ui fluid corner labeled input">
                                    <div class="wrap-input100 m-t-20 m-b-20">
                                        <input class="input100 sp_celphones" id="contato-telefone-celular" type="text" autocomplete="off" style="border: none;" required />
                                        <span class="focus-input100" data-placeholder="Celular"></span>
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
                                <div class="wrap-input100 m-t-20 m-b-20">
                                    <textarea class="input100 scroll" id="cobservacoes" 
                                              style="
                                              border: none;
                                              min-height: 150px;
                                              outline: none;
                                              -webkit-box-shadow: none;
                                              -moz-box-shadow: none;
                                              box-shadow: none;
                                              resize: none;
                                              padding-top: 15px;" required></textarea>
                                    <span class="focus-input100" data-placeholder="Observa&ccedil;&otilde;es, coment&aacute;rios e/ou sugest&otilde;es"></span>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-7"></div>
                    <div class="col-md-5">
                        <button class="login100-form-btn" type="submit" id="btn-criar-conta" data-toggle="tooltip" data-placement="left" title="Clique apenas uma vez e aguarde o retorno...">
                            <i class="fa fa-user-plus fa-lg" id="i-btn-criar-conta"></i>&nbsp;&nbsp;Clique aqui e crie sua conta
                        </button>
                    </div>                    
                </div>
            </form>
        </div>
    </div>
</div>