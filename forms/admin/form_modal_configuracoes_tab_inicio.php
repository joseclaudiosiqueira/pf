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
<div id="form_modal_configuracoes_tab_inicio" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" id="fmocti-modal">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="fechar_configuracoes_tab_inicio" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                <i class="fa fa-list-alt"></i>&nbsp;&nbsp;Padr&atilde;o de informa&ccedil;&otilde;es iniciais da contagem<br />
                <span class="sub-header">Selecione o padr&atilde;o de preenchimento autom&aacute;tico mais adequado</span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7" id="col-tabela-1">
                        <div style="min-height: 573px; max-height: 573px; overflow-x: hidden; overflow-y: scroll; width: 100%;" class="scroll">
                            <table class="box-table-a">
                                <thead>
                                    <tr>
                                        <th width="30%">Composi&ccedil;&atilde;o</th>
                                        <th width="50%">Descri&ccedil;&otilde;es</th>
                                        <th width="20%">A&ccedil;&atilde;o</th>
                                    </tr>
                                </thead>
                                <tbody id="addConfiguracoesTabInicio"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-5" id="col-tabela-2">
                        <div class="panel-group" id="accordion-configuracoes-iniciais">
                            <div class="panel panel-default">
                                <div class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion-configuracoes-iniciais" href="#collapse-configuracoes-gerais">
                                        <i class="fa fa-chevron-down"></i>&nbsp;Informa&ccedil;&otilde;es b&aacute;sicas</a>
                                </div>
                                <div id="collapse-configuracoes-gerais" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fmocti_id_cliente">Cliente</label><br />
                                                    <select class="form-control input_style" id="fmocti_id_cliente" data-placeholder="Selecione o cliente" title="Cliente"></select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fmocti_id_contrato">
                                                        <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i>&nbsp;Tipos de contratos" 
                                                              data-content="Os contratos podem ser de dois tipos no Dimension&reg;
                                                              <ul>
                                                              <li>[ I ]nicial (&eacute; o primeiro contrato celebrado);</li>
                                                              <li>[ A ]ditivo (contratos adicionais)</li></ul>
                                                              IMPORTANTE: durante o cadastro do contrato o Administador define o tipo, sendo que o primeiro &eacute; sempre Inicial">
                                                            <i id="w_id_contrato" class="fa fa-dot-circle-o"></i>&nbsp;<i class="fa fa-info-circle"></i>&nbsp;Contrato</span>
                                                    </label><br />
                                                    <select class="form-control input_style" id="fmocti_id_contrato" title="Contrato">
                                                        <option value="0">...</option>
                                                    </select>
                                                </div>                    
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fmocti_id_projeto"><i id="w_id_projeto" class="fa fa-dot-circle-o"></i>&nbsp;Projeto</label><br />
                                                    <select class="form-control input_style" id="fmocti_id_projeto" title="Projeto">
                                                        <option value="0">...</option>
                                                    </select>
                                                </div>                   
                                            </div>
                                            <div class="col-md-6">
                                                <div class="for-group">
                                                    <label for="fmocti_id-orgao">
                                                        <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-circle-right'></i>&nbsp;Outras denomina&ccedil;&otilde;es" 
                                                              data-content="Este campo pode ter outras denomina&ccedil;&otilde;es:
                                                              <ul class='fa-ul'>
                                                              <li><i class='fa fa-angle-double-right'></i>&nbsp;Setor / Lota&ccedil;&atilde;o;</li>
                                                              <li><i class='fa fa-angle-double-right'></i>&nbsp;Departamento;</li>
                                                              <li><i class='fa fa-angle-double-right'></i>&nbsp;&Oacute;rg&atilde;o, etc.</li>
                                                              </ul>
                                                              <strong>LEMBRE-SE</strong>: a refer&ecirc;ncia &eacute; de quem est&aacute; demandando">
                                                            <i id="w_id_orgao" class="fa fa-dot-circle-o"></i>&nbsp;<i class="fa fa-info-circle"></i>&nbsp;&Oacute;rg&atilde;o</span>
                                                    </label><br />
                                                    <select id="fmocti_id_orgao" class="form-control input_style">
                                                        <option value="0">...</option>
                                                    </select>
                                                </div>
                                            </div>      
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">        
                                                    <label for="fmocti_ordem_servico">
                                                        <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> Outras denomina&ccedil;&otilde;es"
                                                              data-content="Este campo tem v&aacute;rias denomina&ccedil;&otilde;es:<ul><li>Demanda</li><li>Solicita&ccedil;&atilde;o</li></ul>
                                                              <i class='fa fa-lightbulb-o'></i>&nbsp;<strong>DICA</strong>: quando for inserir uma contagem de Baseline, digite OS-BASELINE, isto facilita buscas.">
                                                            <i class="fa fa-info-circle"></i>&nbsp;Ordem de Servi&ccedil;o</span>                    
                                                    </label><br />
                                                    <input type="text" id="fmocti_ordem_servico" maxlength="45" class="form-control input_style">
                                                </div>
                                            </div>                                 
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fmocti_id_linguagem">
                                                        <span id="lbl_linguagem" class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> Linguagem de programa&ccedil;&atilde;o" 
                                                              data-content="Caso n&atilde;o encontre a linguagem de programa&ccedil;&atilde;o utilizada por sua aplica&ccedil;&atilde;o/contagem, entre em contato com o Administrador do sistema para que ele atualize o cadastro."><i class="fa fa-info-circle"></i>&nbsp;Linguagem</span>
                                                    </label><br />
                                                    <select id="fmocti_id_linguagem" name="fmocti_id_linguagem" title="Linguagem" class="form-control input_style"></select>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="row">                                
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fmocti_id_banco_dados">
                                                        <span id="lbl_banco_dados" class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> Banco de dados (SGBD)" 
                                                              data-content="Caso n&atilde;o encontre o Banco de Dados utilizado por sua aplica&ccedil;&atilde;o/contagem, entre em contato com o Administrador do sistema para que ele atualize o cadastro."><i class="fa fa-info-circle"></i>&nbsp;Banco de dados (SGBD)</span>
                                                    </label><br />
                                                    <select id="fmocti_id_banco_dados" name="fmocti_id_banco_dados" title="Banco de dados (SGBD)" class="form-control input_style"></select>
                                                </div> 
                                            </div>         
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fmocti_id_tipo_contagem">Tipo</label><br />
                                                    <select id="fmocti_id_tipo_contagem" name="fmocti_id_tipo_contagem" title="Tipo da contagem" class="form-control input_style"></select>
                                                </div> 
                                            </div>   
                                        </div>                        
                                        <div class="row">     
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fmocti_id_etapa"><span id="idEtapa">Etapa</span></label><br />
                                                    <select id="fmocti_id_etapa" name="fmocti_id_etapa" title="Etapa" class="form-control input_style"></select>
                                                </div> 
                                            </div>                                 
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="id_industria">&Aacute;rea de atua&ccedil;&atilde;o</label><br />
                                                    <select id="fmocti_id_industria" name="fmocti_id_industria" title="&Aacute;rea de atua&ccedil;&atilde;o" class="form-control input_style"></select>
                                                </div> 
                                            </div>        
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fmocti_id_processo">Processo</label><br />
                                                    <select id="fmocti_id_processo" name="fmocti_id_processo" title="Processo de Desenvolvimento" class="form-control input_style"></select>
                                                </div> 
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="id_processo_gestao">Processo de Gest&atilde;o</label><br />
                                                    <select id="fmocti_id_processo_gestao" name="fmocti_id_processo_gestao" title="Processo de Gest&atilde;o do Desenvolvimento" class="form-control input_style"></select>
                                                </div> 
                                            </div>                                     
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion-configuracoes-iniciais" href="#collapse-configuracoes-proposito-escopo">
                                        <i class="fa fa-chevron-down"></i>&nbsp;Prop&oacute;sito e Escopo</a>
                                </div>
                                <div id="collapse-configuracoes-proposito-escopo" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="ui form">
                                                        <div class="field">
                                                            <label for="fmocti_proposito">Prop&oacute;sito da contagem</label>
                                                            <textarea rows="5" id="fmocti_proposito" name="fmocti_proposito" class="scroll" maxlength="3000" title="Proposito"></textarea>                    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="ui form">
                                                        <div class="field">
                                                            <label for="fmocti_escopo">Escopo da contagem</label>
                                                            <textarea rows="5" id="fmocti_escopo" name="fmocti_escopo" class="scroll" maxlength="3000"  title="Escopo"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>      
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                                                                      
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="fmocti-footer">
                <div class="btn-group">
                    <button type="button" class="btn btn-success" id="btn-adicionar-configuracao-tab-inicio"><i class="fa fa-plus-circle"></i>&nbsp;Adicionar</button>
                </div>
            </div>
        </div>
    </div>
</div>