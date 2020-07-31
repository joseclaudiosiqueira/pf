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
<div id="form-modal-gerenciar-orgao" class="modal fade" role="dialog">
    <form id="form-linha-lista" role="form">
        <div class="modal-dialog modal-lg">
            <!-- Modal content -->
            <div class="modal-content">
                <input type="hidden" id="orgao-id" value="0">
                <div class="modal-header">
                    <button type="button" id="fechar-orgao" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <i class="fa fa-list-ul fa-lg"></i>&nbsp;&nbsp;Gestão - Hierarquia<br />
                    <span class="sub-header">D&ecirc; prefer&ecirc;ncia &agrave;s hierarquias superiores: Diretorias, Superintend&ecirc;cias, etc., com isso evite detalhamento do seu organograma</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-7">
                            <!-- verificar em novas versoes
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input id="opt1" type="radio" name="campo-pesquisa" value="1" checked>
                                                <label for="opt1"><span><span></span></span>&nbsp;&nbsp;Sigla</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input id="opt2" type="radio" name="campo-pesquisa" value="1">
                                                <label for="opt2"><span><span></span></span>&nbsp;&nbsp;Descri&ccedil;&atilde;o</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 scroll" style="overflow-y:scroll;">
                                    <div class="form-group">
                                        <input type="text" class="form-control input_style" id="pesquisa-orgao" 
                                               onkeyup="searchInTable($(this).get(0).id, $('#tbl-lista-orgaos').get(0).id, $('input[name=campo-pesquisa]:checked').val());" />
                                    </div>
                                </div>
                            </div>
                            -->
                            <div style="min-height: 504px; max-height: 504px; overflow-x: hidden; overflow-y: scroll; width: 100%;" class="scroll">
                                <table class="box-table-a" width="100%" cellpadding="4" id="tbl-lista-orgaos">
                                    <thead>
                                        <tr>
                                            <th width="10%">#ID</th>
                                            <th width="80%">Sigla.Descri&ccedil;&atilde;o</th>
                                            <th width="10%"><i id="w_orgao_status" class="fa fa-dot-circle-o"></i>&nbsp;Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="addOrgao"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-5" style="padding-top: 8px;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="orgao_id_cliente">
                                            <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-circle-right'></i>&nbsp;Inserindo &Oacute;rg&atilde;os"
                                                  data-content="<p align='justify'><strong>ATEN&Ccedil;&Atilde;O</strong><hr>
                                                  <strong>F&aacute;bricas de Softwares</strong> (CONTRATADAS) -&gt; Cadastre os &Oacute;rg&atilde;os de acordo com o seus Clientes, selecione um e monte a estrutura, que &eacute; exclusiva para cada Cliente.<hr>
                                                  <strong>&Oacute;rg&atilde;os P&uacute;blicos/Privados e Empresas</strong> (CONTRATANTES) -&gt; Cadaste os seus &Oacute;rg&atilde;os de acordo com sua estrutura, <strong>n&atilde;o</strong> selecione um Cliente.
                                                  Seus Fornecedores utilizar&atilde;o esta estrutura.<br /><br />
                                                  </p>">
                                                <strong><i class="fa fa-info-circle"></i>&nbsp;Leia-me</strong>
                                            </span>
                                            &nbsp;<i class="fa fa-angle-double-right"></i>&nbsp;&nbsp;Cliente
                                        </label>
                                        <select id="orgao_id_cliente" class="form-control input_style"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="orgao-sigla">Sigla</label>
                                        <div class="ui fluid corner labeled input">
                                            <input type="text" class="form-control input_style" id="orgao-sigla" maxlength="15" placeholder="Máximo 15 caracteres">
                                            <div class="ui corner label">
                                                <i class="asterisk icon"></i>
                                            </div>
                                        </div>                                          
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="orgao-is-ativo">&Oacute;rg&atilde;o ativo?</label><br />
                                        <input id="orgao-is-ativo" type="checkbox" data-width="100" data-height="36" data-toggle="toggle" data-onstyle="success" data-offstyle="warning" data-style="slow" data-on="Ativo" data-off="Inativo" class="btn btn-sm" checked>
                                    </div>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="orgao-descricao">Descri&ccedil;&atilde;o</label>
                                        <div class="ui fluid corner labeled input">
                                            <input type="text" class="form-control input_style" id="orgao-descricao">
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
                                        <label for="orgao-superior">&oacute;rg&atilde;o superior</label>
                                        <select class="form-control input_style" id="orgao-superior" size="7" class="scroll"></select>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <img class="img-thumbnail" alt="captcha" id="orgao-img-captcha" onclick="refreshCaptcha($(this), $('#orgao-txt-captcha'));" data-toggle="tooltip" data-placement="top" title="Clique na imagem para obter outro c&oacute;digo"/><br />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label><i class="fa fa-dot-circle-o" id="orgao-i-captcha"></i>&nbsp;<?php echo WORDING_REGISTRATION_CAPTCHA; ?><sup>*</sup></label>
                                    <div class="ui fluid corner labeled input">
                                        <input class="form-control input_style" type="text" id="orgao-txt-captcha" autocomplete="off" maxlength="4" required />
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
                    <div class="btn-group">
                        <button type="button" id="btn-salvar-orgao" class="btn btn-success"><i class="fa fa-floppy-o"></i>&nbsp;Salvar</button>
                        <button type="button" id="btn-atualizar-orgao" class="btn btn-success"><i class="fa fa-refresh"></i>&nbsp;Atualizar</button>
                        <button type="button" id="btn-novo-orgao" class="btn btn-info"><i class="fa fa-plus-circle"></i>&nbsp;Novo &Oacute;rg&atilde;o</button>
                        <button type="button" id="btn-cancelar-orgao" class="btn btn-warning"><i class="fa fa-times"></i>&nbsp;Cancelar</button>
                    </div>                    
                </div>                
            </div>
        </div>
    </form>
</div>