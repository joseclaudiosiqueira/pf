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
<div id="form_modal_inserir_cliente" class="modal fade" role="dialog">
    <form id="form_inserir_alterar_cliente">
        <div class="modal-dialog modal-lg">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="fechar_cliente" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <i class="fa fa-users"></i>&nbsp;&nbsp;Clientes<br />
                    <span class="sub-header">Gerenciamento das informa&ccedil;&otilde;es dos seus clientes</span>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="fmiacli_id" name="fmiacli_id">
                    <input type="hidden" id="fmiacli_acao" name="fmiacli_acao" value="inserir">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4><i class="fa fa-user"></i>&nbsp;Informa&ccedil;&otilde;es do Cliente</h4>
                                </div>
                            </div>                          
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">                   
                                        <label for="nome">Nome do cliente<sup>*</sup></label>
                                        <div class="ui fluid corner labeled input">
                                            <input class="form-control input_style" id="fmiacli_descricao" type="text" name="fmiacli_descricao" autocomplete="off" placeholder="Nome do cliente (255)" required autofocus/>
                                            <div class="ui corner label">
                                                <i class="asterisk icon"></i>
                                            </div>
                                        </div>                                            
                                    </div>
                                </div>                                  
                                <div class="col-md-6">
                                    <div class="form-group">                 
                                        <label for="nome">Sigla<sup>*</sup></label>
                                        <div class="ui fluid corner labeled input">
                                            <input class="form-control input_style" id="fmiacli_sigla" type="text" name="fmiacli_sigla" autocomplete="off" maxlength="15" placeholder="M&aacute;x. 15" required/>
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
                                        <label for="email">Contato<sup>*</sup></label>
                                        <div class="ui fluid corner labeled input">
                                            <input class="form-control input_style" id="fmiacli_nome" type="text" name="fmiacli_nome" autocomplete="off" placeholder="Fulano" required />
                                            <div class="ui corner label">
                                                <i class="asterisk icon"></i>
                                            </div>
                                        </div>                                           
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email (contato)<sup>*</sup></label>
                                        <div class="ui fluid corner labeled input">
                                            <input class="form-control input_style" id="fmiacli_email" type="email" name="fmiacli_email" autocomplete="off" placeholder="fulano@abc.com/br" required />
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
                                        <label for="telefone">Telefone <sup>*</sup></label>
                                        <div class="ui fluid corner labeled input">
                                            <input class="form-control input_style" id="fmiacli_telefone" type="text" name="fmiacli_telefone" autocomplete="off" data-mask="(00) 0000 0000" placeholder="(00) 0000 0000" required />
                                            <div class="ui corner label">
                                                <i class="asterisk icon"></i>
                                            </div>
                                        </div>                                           
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ramal">Ramal</label>
                                        <input class="form-control input_style" id="fmiacli_ramal" type="text" name="fmiacli_ramal" autocomplete="off" data-mask="0000" placeholder="0000" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email2">
                                            <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-circle-right'></i>&nbsp;Fiscaliza&ccedil;&atilde;o contratual"
                                                  data-content="<strong>ATEN&Ccedil;&Atilde;O</strong>: este contato servir&aacute; para tratamento de assuntos contratuais. Geralmente &eacute; o fiscal do contrato ou um grupo designado para tal.">
                                                <i class="fa fa-info-circle"></i>&nbsp;Contato (fiscaliza&ccedil;&atilde;o)</span></label>
                                        <input class="form-control input_style" id="fmiacli_nome2" type="text" name="fmiacli_nome2" autocomplete="off" placeholder="Beltrano" />
                                    </div>
                                </div>                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email2">
                                            <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-circle-right'></i>&nbsp;Email/Grupo de Fiscaliza&ccedil;&atilde;o"
                                                  data-content="Este email receber&aacute; as notifica&ccedil;&otilde;es sobre contagens que foram para faturamento. Pode ser um email individual ou uma caixa postal de um grupo. 
                                                  N&atilde;o necessariamente o Fiscal de Contrato, o importante aqui &eacute; explicitar quem far&aacute; o tr&acirc;mite de faturamento e aprova&ccedil;&atilde;o."><i class="fa fa-info-circle"></i>&nbsp;Email (fiscaliza&ccedil;&atilde;o)<sup>*</sup></span></label>
                                        <input class="form-control input_style" id="fmiacli_email2" type="email" name="fmiacli_email2" autocomplete="off" placeholder="beltrano@abc.com/br" />
                                    </div>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefone2">Telefone (fiscaliza&ccedil;&atilde;o)</label>
                                        <input class="form-control input_style" id="fmiacli_telefone2" type="text" name="fmiacli_telefone2" autocomplete="off" data-mask="(00) 0000 0000" placeholder="(00) 0000 0000" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ramal2">Ramal (fiscaliza&ccedil;&atilde;o)</label>
                                        <input class="form-control input_style" id="fmiacli_ramal2" type="text" name="fmiacli_ramal2" autocomplete="off" data-mask="0000" placeholder="0000" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fmiacli_uf">Estado</label>
                                        <select class="form-control input_style" id="fmiacli_uf"> 
                                            <option value="estado">Selecione o Estado</option> 
                                            <option value="ac">Acre</option> 
                                            <option value="al">Alagoas</option> 
                                            <option value="am">Amazonas</option> 
                                            <option value="ap">Amapá</option> 
                                            <option value="ba">Bahia</option> 
                                            <option value="ce">Ceará</option> 
                                            <option value="df">Distrito Federal</option> 
                                            <option value="es">Espírito Santo</option> 
                                            <option value="go">Goiás</option> 
                                            <option value="ma">Maranhão</option> 
                                            <option value="mt">Mato Grosso</option> 
                                            <option value="ms">Mato Grosso do Sul</option> 
                                            <option value="mg">Minas Gerais</option> 
                                            <option value="pa">Pará</option> 
                                            <option value="pb">Paraíba</option> 
                                            <option value="pr">Paraná</option> 
                                            <option value="pe">Pernambuco</option> 
                                            <option value="pi">Piauí</option> 
                                            <option value="rj">Rio de Janeiro</option> 
                                            <option value="rn">Rio Grande do Norte</option> 
                                            <option value="ro">Rondônia</option> 
                                            <option value="rs">Rio Grande do Sul</option> 
                                            <option value="rr">Roraima</option> 
                                            <option value="sc">Santa Catarina</option> 
                                            <option value="se">Sergipe</option> 
                                            <option value="sp">São Paulo</option> 
                                            <option value="to">Tocantins</option> 
                                        </select>                                                    
                                    </div>
                                </div>                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="fmiacli_is_ativo">Status</label><br />
                                        <input id="fmiacli_is_ativo" type="checkbox" data-toggle="toggle" data-width="100" data-height="36" data-onstyle="success" data-style="slow" data-on="Ativo" data-off="Inativo" checked>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <small><p align="justify"><strong>ATEN&Ccedil;&Atilde;O</strong>: somente Clientes <kbd>ATIVOS</kbd> ser&atilde;o listados nas Contagens e associa&ccedil;&atilde;o a contratos.</p></small>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <center>
                                            <img class="img-thumbnail" src="" alt="captcha" id="fmiacli-img-captcha" onclick="refreshCaptcha($(this), $('#fmiacli-txt-captcha'));" data-toggle="tooltip" data-placement="top" title="Clique na imagem para obter outro c&oacute;digo" /><br />
                                        </center>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-dot-circle-o" id="fmiacli-i-captcha"></i>&nbsp;<?php echo WORDING_REGISTRATION_CAPTCHA; ?> <sup>*</sup></label>
                                        <div class="ui fluid corner labeled input">
                                            <input class="form-control input_style" type="text" id="fmiacli-txt-captcha" autocomplete="off" maxlength="4" required />
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
                                    <iframe style="border:1px dotted #999; width:100%; height:560px; overflow: hidden; border-radius: 5px;" src="/pf/vendor/cropper/producao/crop/index.php?t=cli" id="avatar-frame-cli"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group" aria-label="...">
                        <button type="submit" class="btn btn-success" id="fmiacli_btn_inserir" onclick="$('#fmiacli_acao').val('inserir');"><i class="fa fa-save"></i> Salvar</button>
                        <button type="button" class="btn btn-success" id="fmiacli_btn_novo" disabled><i class="fa fa-plus-circle"></i> Inserir outro</button>
                        <button type="submit" class="btn btn-success" id="fmiacli_btn_atualizar" onclick="$('#fmiacli_acao').val('alterar');" disabled><i class="fa fa-refresh"></i> Atualizar</button>
                        <button type="button" class="btn btn-warning" id="fmiacli_btn_fechar" onclick="limpaCamposCliente();" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>