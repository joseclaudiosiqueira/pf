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
<div id="form_modal_funcao_outros" class="modal fade" role="dialog">
    <form>
        <div class="modal-dialog modal-">
            <!-- Modal content -->
            <div class="modal-content">
                <input type="hidden" name="outros_operacao" id="outros_operacao" value="" title="Inclus&atilde;o, Altera&ccedil;&atilde;o, Exclus&atilde;o">
                <input type="hidden" name="outros_tabela" id="outros_tabela" value="" title="Tabela OU">
                <input type="hidden" name="outros_id" id="outros_id" value="" title="id da funcao inserida">
                <input type="hidden" name="outros_qtd_atual" id="outros_qtd_atual" value="" title="quantidade atual">
                <input type="hidden" name="outros_id_funcao_baseline" id="outros_id_funcao_baseline" value="">
                <div class="modal-header">
                    <button type="button" id="fechar_outros" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <span id="outros_h4-modal"></span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="outros_id_roteiro">
                                    <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> Roteiro de m&eacute;trica" 
                                          data-content="<p align='justify'>
                                          O roteiro de m&eacute;trica especifica os fatores de impactos que devem ser considerados para os PFa. 
                                          Caso seja um roteiro &quot;exclusivo&quot; aparecer&atilde;o as siglas (C) - para um Cliente e (F) para um fornecedor. <strong>IMPORTANTE</strong> salientar que os roteiros citados s&atilde;o apenas exemplos, o Dimension&reg; vem com os Roteiros do SISP por padr&atilde;o, apenas.</p><hr>
                                          Caso seja um roteiro &quot;exclusivo&quot; aparecer&atilde;o as siglas (C) - para um Cliente e (F) para um fornecedor.</p><hr>
                                          <strong>FONTE</strong><br />Roteiro de M&eacute;tricas SISP 2.1 - Dispon&iacute;vel <a href='http://www.sisp.gov.br' target='_new'>AQUI</a><br />
                                          Roteiro de M&eacute;tricas da ANEEL - Dispon&iacute;vel <a href='http://www2.aneel.gov.br/aplicacoes/consulta_publica/documentos/ANEXO%20VI%20-%20Roteiro%20de%20M%C3%A9tricas%20de%20Software%20da%20ANEEL.pdf' target='_new'>AQUI</a><br />
                                          Roteiro de M&eacute;tricas do BNB - Dispon&iacute;vel <a href='http://www.bnb.gov.br/documents/45078/47401/anexo_VII_guia_de_contagem_de_ponto_de_funcao_0209.pdf/e5824206-e460-44a9-9e23-1f068f323423' target='_new'>AQUI</a>">
                                        <i class="fa fa-info-circle"></i>&nbsp;Roteiro- (C) Cliente, (F) Fornecedor</span>&nbsp;|&nbsp;<a href="#" id="btn-listar-itens-outros" data-toggle="modal" data-target="#form-modal-listar-itens-roteiro"><i class="fa fa-search"></i>&nbsp;Detalhes</a></label>                                          
                                <select class="form-control input_style" id="outros_id_roteiro" name="outros_id_roteiro" style="background-color: #fff;" disabled></select>                
                            </div>            
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="outros_op"><span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> Opera&ccedil;&atilde;o" data-content="<strong>I</strong> - Inclus&atilde;o<br><strong>A</strong> - Altera&ccedil;&atilde;o<br><strong>E</strong> - Exclus&atilde;o<br><strong>T</strong> - Testes<hr>Apenas para inser&ccedil;&otilde;es que n&atilde;o estejam contempladas em ALI, AIE, EE, SE e CE."><i class="fa fa-info-circle"></i>&nbsp;Opera&ccedil;&atilde;o</span></label><br>
                                <div class="btn-group" id="dados_op">        
                                    <button type="button" class="btn btn-default" value="I" id="outros_op1">I</button>
                                    <button type="button" class="btn btn-default" value="A" id="outros_op2" disabled>A</button>
                                    <button type="button" class="btn btn-default" value="E" id="outros_op3" disabled>E</button>
                                    <!--<button type="button" class="btn btn-default" value="T" id="outros_op4" disabled>T</button>-->
                                </div>                
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="outros_entrega"><span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> Entrega" data-content="<p align='justify'>Digite aqui a entrega/sprint em que esta funcionalidade ser&aacute; feita. Lembre-se que o limite &eacute; a quantidade selecionada na ABA - Informa&ccedil;&otilde;es</p>"><i class="fa fa-info-circle"></i>&nbsp;Entrega/Sprint</span></label><br>
                                <input type="text" name="outros_entrega" id="outros_entrega" value="1" class="form-control input_style spinnumber" maxlength="2" value="1">
                            </div>         
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="outros_funcao">Descri&ccedil;&atilde;o (Fun&ccedil;&atilde;o)</label>
                                <input type="text" class="form-control input_style nao_permitido" id="outros_funcao" name="outros_funcao" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="outros_fonte"><span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> Fonte(s)" data-content="Insira as fontes utilizadas para a contagem:<ul><li>Casos de uso</li><li>Requisitos</li><li>Planilhas</li><li>Modelo Entidade Relacionamento - MER</li><li>Demais documenta&ccedil;&otilde;es</li></ul>"><i class="fa fa-info-circle"></i>&nbsp;Fonte(s) utilizada(s)</span></label>
                                <input type="text" class="form-control input_style" id="outros_fonte" name="outros_fonte" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="outros_qtd">Quantidade</label>
                                <input type="text" class="form-control input_style" id="outros_qtd" name="outros_qtd" maxlength="4" autocomplete="off">
                            </div>            
                        </div> 
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="outros_impacto"><i id="w_outros_impacto" class="fa fa-dot-circle-o"></i>&nbsp;Tipo&nbsp;|&nbsp;<a href="#" id="btn-outros-detalhe-fator" data-content="" data-toggle="popover" data-placement="bottom" data-title="<i class='fa fa-arrow-circle-rigth'></i>&nbsp;Detalhe do Fator de Impacto" data-content="Por favor, selecione um Fator de Impacto."><i class="fa fa-search"></i>&nbsp;Detalhes</a></label>
                                <select class="form-control input_style" id="outros_impacto" name="outros_impacto">
                                    <option value="0">...</option>
                                </select>
                            </div>            
                        </div>                       
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="outros_pfa"><span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> Pontos de Fun&ccedil;&atilde;o" data-content="Representa a quantidade de PF de acordo com algum roteiro de m&eacute;trica (Espec&iacute;fico da organiza&ccedil;&atilde;o, SISP, etc)"><i class="fa fa-info-circle"></i>&nbsp;PF</span></label>
                                <input type="text" class="form-control input_style" id="outros_pfa" name="outros_pfa" readonly>
                            </div>            
                        </div>            
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="outros_observacoes">Observa&ccedil;&otilde;es sobre esta fun&ccedil;&atilde;o</label>
                                <textarea rows="4" data-widearea="enable" id="outros_observacoes" name="outros_observacoes" class="form-control input_style scroll" maxlength="3000"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="outros_observacoes_validacao">Observa&ccedil;&otilde;es para auxiliar o validador</label>
                                <textarea rows="4" id="outros_observacoes_validacao" name="outros_observacoes_validacao" class="form-control input_style scroll" maxlength="3000"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" id="acoes">
                        <button type="button" class="btn btn-success" id="outros_btn_al" disabled><i class="fa fa-check-square-o"></i> Atualizar o registro</button>
                        <button type="button" class="btn btn-success" id="outros_btn_if" disabled><i class="fa fa-check-circle"></i> Inserir e fechar</button>
                        <button type="button" class="btn btn-success" id="outros_btn_in" disabled><i class="fa fa-plus-circle"></i> Inserir e continuar</button>
                    </div>                                        
                </div>
            </div>
        </div>
    </form>
</div>