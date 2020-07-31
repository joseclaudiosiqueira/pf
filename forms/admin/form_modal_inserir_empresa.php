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
<div id="form_modal_inserir_empresa" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <form id="form_inserir_empresa">
                <div class="modal-header">
                    <button type="button" id="fechar_inserir_empresa" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <i class="fa fa-plus-circle fa-lg"></i>&nbsp;&nbsp;Inser&ccedil;&atilde;o de nova Empresa<br />
                    <span class="sub-header">Gerenciamento de novas empresas no sistema Dimension - Exclusivo do Root</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4><i class="fa fa-globe"></i>&nbsp;Informa&ccedil;&otilde;es demogr&aacute;ficas</h4>
                                </div>
                            </div>                          
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cep">C.E.P.</label>
                                        <input type="text" class="form-control input_style" placeholder="C.E.P." id="cep" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cidade">Cidade</label>
                                        <input type="text" class="form-control input_style" placeholder="Cidade" id="cidade" required>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bairro">Bairro</label>
                                        <input type="text" class="form-control input_style" placeholder="Bairro" id="bairro" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="uf">U.F.</label>
                                        <select class="form-control input_style" id="uf"> 
                                            <option value="00">Selecione a U.F.</option> 
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
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="logradouro">Logradouro</label>
                                        <input type="text" class="form-control input_style" placeholder="Logradouro" id="logradouro" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tipoLogradouro">Logradouro</label>
                                        <input type="text" class="form-control input_style" placeholder="Tipo de logradouro" id="tipoLogradouro">
                                    </div>
                                </div>                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4><i class="fa fa-dollar"></i>&nbsp;Informa&ccedil;&otilde;es para faturamento</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cnpj">CNPJ/CPF</label>
                                        <input type="text" class="form-control input_style" placeholder="CNPJ/CPF" id="cnpj" data-mask="000000000000000" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sigla">Sigla</label>
                                        <input type="text" class="form-control input_style" placeholder="Sigla" id="sigla">
                                    </div>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nomeFantasia">Nome fantasia</label>
                                        <input type="text" class="form-control input_style" placeholder="Nome fantasia" id="nomeFantasia" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="3">Plano</label>
                                        <select id="idPlano" class="form-control input_style">
                                            <option value="0">Selecione o plano</option>
                                            <option value="1">Demo</option>
                                            <option value="2">Estudante</option>
                                            <option value="3">Empresarial</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="mensalidade">Mensalidade</label>
                                        <input type="text" class="form-control input_style money" placeholder="0,00" maxlength="6" id="mensalidade">
                                    </div>
                                </div>                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="valorContagem">Vlr. das contagens</label>
                                        <input type="text" class="form-control input_style money" placeholder="0,00" maxlength="6" id="valorContagem">
                                    </div>
                                </div>                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="isFaturavel">Fatur&aacute;vel</label><br />
                                        <input id="isFaturavel" type="checkbox" data-width="120" data-height="36" data-toggle="toggle" data-onstyle="success" data-offstyle="warning" data-style="slow" data-on="Sim" data-off="N&atilde;o" checked>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="indicadoPor">Indicação</label>
                                        <input type="email" class="form-control input_style" id="indicadoPor">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tipoFaturamento">Tipo de faturamento</label>
                                        <input id="tipoFaturamento" type="checkbox" data-width="120" data-height="36" data-toggle="toggle" data-onstyle="success" data-offstyle="warning" data-style="slow" data-on="Dimension" data-off="Contrato" checked>
                                    </div>
                                </div>                                                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h4><i class="fa fa-phone-square"></i>&nbsp;Informa&ccedil;&otilde;es dos contatos</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nome">Nome</label>
                                        <input type="text" class="form-control input_style" placeholder="Nome" id="nome" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control input_style" placeholder="Email" id="email">
                                    </div>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="telefone">Telefone</label>
                                        <input type="text" class="form-control input_style" placeholder="Telefone" id="telefone" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="ramal">Ramal</label>
                                        <input type="text" class="form-control input_style" placeholder="Ramal" id="ramal">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nome2">Nome (2)</label>
                                        <input type="text" class="form-control input_style" placeholder="Nome (2)" id="nome2" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email2">Email (2)</label>
                                        <input type="email" class="form-control input_style" placeholder="Email (2)" id="email2">
                                    </div>
                                </div>                                
                            </div>                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="telefone2">Telefone (2)</label>
                                        <input type="text" class="form-control input_style" placeholder="Telefone (2)" id="telefone2">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="ramal2">Ramal (2)</label>
                                        <input type="text" class="form-control input_style" placeholder="Ramal (2)" id="ramal2">
                                    </div>
                                </div>                                
                            </div>                            
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-2" style="text-align: right;">
                            <div class="form-group">
                                <img class="img-thumbnail" src="" alt="captcha" id="fmcempinc-img-captcha" onclick="refreshCaptcha($(this), $('#fmcempinc-txt-captcha'));" data-toggle="tooltip" data-placement="top" title="Clique na imagem para obter outro c&oacute;digo" /><br />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label><i class="fa fa-dot-circle-o" id="fmcempinc-i-captcha"></i>&nbsp;<?php echo WORDING_REGISTRATION_CAPTCHA; ?> <sup>*</sup></label>
                                <div class="ui fluid corner labeled input">
                                    <input class="form-control input_style" type="text" id="fmcempinc-txt-captcha" autocomplete="off" maxlength="4" required />
                                    <div class="ui corner label">
                                        <i class="asterisk icon"></i>
                                    </div>                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">                            
                    <div class="btn-group" id="acoes">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check-circle"></i> Inserir</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>