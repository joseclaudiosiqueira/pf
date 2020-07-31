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
<div id="form_modal_funcao_transacao" class="modal fade" role="dialog">
    <form id="form_transacao" role="form">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <input type="hidden" name="transacao_operacao" id="transacao_operacao" value="" title="Inclus&atilde;o, Altera&ccedil;&atilde;o, Exclus&at&atilde;o">
                <input type="hidden" name="transacao_tabela" id="transacao_tabela" value="" title="Tabela ALI / AIE">
                <input type="hidden" name="transacao_metodo" id="transacao_metodo" value="" title="metodo de inser&ccedil;&atilde;o NESMA, FP-LITE, Detalhada">
                <input type="hidden" name="transacao_id" id="transacao_id" value="" title="id da contagem">
                <input type="hidden" name="transacao_qtd_atual" id="transacao_qtd_atual" value="" title="quantidade atual">
                <input type="hidden" name="transacao_observacoes_validacao" id="transacao_observacoes_validacao" value="">
                <input type="hidden" name="transacao_id_funcao_baseline" id="transacao_id_funcao_baseline" value="">
                <div class="modal-header">
                    <button type="button" id="fechar_transacao" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <span id="transacao_h4-modal"></span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="transacao_id_roteiro">
                                            <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> Roteiro de m&eacute;trica" 
                                                  data-content="
                                                  O roteiro de m&eacute;trica especifica os fatores de impactos que devem ser considerados para os PFa. 
                                                  Caso seja um roteiro &quot;exclusivo&quot; aparecer&atilde;o as siglas [C] - para um Cliente e [F] para um fornecedor. 
                                                  <strong>IMPORTANTE</strong> salientar que os roteiros citados s&atilde;o apenas exemplos, o Dimension&reg; vem com os Roteiros do SISP por padr&atilde;o, apenas.<hr>
                                                  <strong>FONTE</strong><br />Roteiro de M&eacute;tricas SISP 2.1 - Dispon&iacute;vel <a href='http://www.sisp.gov.br' target='_new'>AQUI</a><br />
                                                  Roteiro de M&eacute;tricas da ANEEL - Dispon&iacute;vel <a href='http://www2.aneel.gov.br/aplicacoes/consulta_publica/documentos/ANEXO%20VI%20-%20Roteiro%20de%20M%C3%A9tricas%20de%20Software%20da%20ANEEL.pdf' target='_new'>AQUI</a><br />
                                                  Roteiro de M&eacute;tricas do BNB - Dispon&iacute;vel <a href='http://www.bnb.gov.br/documents/45078/47401/anexo_VII_guia_de_contagem_de_ponto_de_funcao_0209.pdf/e5824206-e460-44a9-9e23-1f068f323423' target='_new'>AQUI</a>">
                                                <i class="fa fa-info-circle"></i>&nbsp;(C) Cliente, (F) Fornecedor</span>&nbsp;|&nbsp;<a href="#" id="btn-listar-itens-transacao" data-toggle="modal" data-target="#form-modal-listar-itens-roteiro"><i class="fa fa-search"></i>&nbsp;Detalhes</a></label>                                          
                                        <select class="form-control input_style id_roteiro" id="transacao_id_roteiro" name="transacao_id_roteiro" style="background-color: #fff;" disabled></select>                
                                    </div>            
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="id_fator_tecnologia">
                                            <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> Fator Tecnologia - FT"
                                                  data-content="<i class='fa fa-lightbulb-o'></i>&nbsp;Melhor prática encontrada<hr>
                                                  Nos projetos de desenvolvimento, após a aplicação das regras contratuais previstas e das medições padrão do CPM e SISP, ainda poderão 
                                                  ser aplicados os Fatores de Tecnologia - FT, conforme tabela exemplificativa a abaixo.
                                                  <table class='table table-condensed table-striped table-bordered' width='100%'>
                                                  <tr><thead><tr><th width='60%'>Tipo de tecnologia</th><th width='40%'>Fator</th></tr></thead>
                                                  <tbody><tr><td>ASP, VB ou .Net</td><td>1,00</td></tr>
                                                  <tr><td>Java e demais tecnologias</td><td>1,15</td></tr>
                                                  <tr><td>SOA/BPM</td><td>1,35</td></tr></tbody></table><br />
                                                  FONTE: <a href='/pf/docs/Edital n 26.2014 - Fabrica de Software - Sara - ANVISA.docx' target='_blank'>Edital n 04.2016 - ANVISA</a>. Todos os direitos reservados.">
                                                <i class="fa fa-info-circle"></i> Fator Tecnologia - FT</span>
                                        </label>
                                        <select id="id_fator_tecnologia" class="form-control input_style"></select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <label for="valor_fator_tecnologia">Valor</label><br />
                                    <div class="div-label" id="valor_fator_tecnologia"></div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="transacao_op">
                                            <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> Opera&ccedil;&atilde;o" data-content="
                                                  <strong>I</strong> - Inclus&atilde;o<br>
                                                  <strong>A</strong> - Altera&ccedil;&atilde;o<br>
                                                  <strong>E</strong> - Exclus&atilde;o<br>
                                                  <strong>T</strong> - Testes
                                                  <hr>
                                                  <i class='fa fa-lightbulb-o'></i>&nbsp;<strong>DICA</strong>: 
                                                  caso esteja inserindo uma contagem de Baseline ou de Licita&ccedil;&atilde;o as opera&ccedil;&otilde;es de Altera&ccedil;&atilde;o e Exclus&atilde;o estar&atilde;o desabilitadas."><i class="fa fa-info-circle"></i>&nbsp;Opera&ccedil;&atilde;o</span></label><br>
                                        <div class="btn-group" id="transacao_op">
                                            <button type="button" class="btn btn-default" id="transacao_op1" value="I">I</button>
                                            <button type="button" class="btn btn-default" id="transacao_op2" value="A">A</button>
                                            <button type="button" class="btn btn-default" id="transacao_op3" value="E">E</button>
                                            <button type="button" class="btn btn-default" id="transacao_op4" value="T">T</button>
                                        </div>                
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="transacao_me">
                                            <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> M&eacute;todo" 
                                                  data-content="
                                                  N - NESMA Estimativa (Visite o <a href='http://nesma.org' target='_new'>site</a>)<br />
                                                  F - FP-Lite&trade; (Veja detalhes <a href='http://www.davidconsultinggroup.com/insights/publications/fp-lite-an-alternative-approach-to-sizing/' target='_new'>aqui</a>)<br />
                                                  D - Detalhado<hr>
                                                  <strong>Observa&ccedil;&atilde;o (1)</strong>: caso voc&ecirc; esteja realizando uma contagem atrav&eacute;s do m&eacute;todo 
                                                  de Elementos Funcionais (mais detalhes <a href='http://portal.tcu.gov.br/lumis/portal/file/fileDownload.jsp?fileId=8A8182A250D20C48015112098DCB35C7' target='_new'>aqui</a>), &eacute; 
                                                  importante salientar que o Dimension&reg; o utiliza em sua totalidade, ou seja: <br ><div style='text-align: center;'><strong>EF = EFd + EFt</strong></div><hr>
                                                  <strong>Observa&ccedil;&atilde;o (2)</strong>: caso voc&ecirc; esteja inserindo uma contagem de Baseline, as op&ccedil;&otilde;es [N] Nesma e [F] FP-Lite estar&atilde;o desabilitadas."><i class="fa fa-info-circle"></i>&nbsp;M&eacute;todo</span></label><br>
                                        <div class="btn-group" id="transacao_me">
                                            <button type="button" class="btn btn-default" id="transacao_me1" value="1">N</button>
                                            <button type="button" class="btn btn-default" id="transacao_me2" value="2">F</button>
                                            <button type="button" class="btn btn-default" id="transacao_me3" value="3">D</button>
                                        </div>                
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="transacao_entrega">
                                            <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> Entregas" data-content="
                                                  Digite aqui a entrega/sprint em que esta funcionalidade ser&aacute; feita. 
                                                  Lembre-se que o limite &eacute; a quantidade selecionada na ABA - Informa&ccedil;&otilde;es."><i class="fa fa-info-circle"></i>&nbsp;Entrega/Sprint</span></label><br>
                                        <input type="text" name="transacao_entrega" id="transacao_entrega" value="1" class="form-control input_style spinnumber" maxlength="2" value="1">
                                    </div>            
                                </div>
                            </div>
                            <div class="row">                    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="transacao_funcao">
                                            <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> Consulta &agrave;s baselines" 
                                                  data-content="
                                                  LEGENDA<hr>
                                                  B - A fun&ccedil;&atilde;o foi originada em uma contagem de Baseline;<br />
                                                  P - A fun&ccedil;&atilde;o foi adicionada/modificada por uma contagem de projeto;<br />
                                                  I, A, E - &Uacute;ltima opera&ccedil;&atilde;o executada: Inclus&atilde;o, Altera&ccedil;&atilde;o ou Exclus&atilde;o;<br />                                          
                                                  9999999 - Id da contagem que a fun&ccedil;&atilde;o est&aacute; associada.
                                                  ">                                    
                                                <span id="label-transacao-funcao"><i class="fa fa-info-circle"></i>&nbsp;Fun&ccedil;&atilde;o</span></span>&nbsp;|&nbsp;&nbsp;&nbsp;
                                            <a href="#" class="check-nome-funcao transacao"><i class="fa fa-check-square"></i>&nbsp;Verificar</a>
                                            <!--&nbsp;|&nbsp;&nbsp;&nbsp;<a href="#" id="btn-pesq-transacao" class="disabled" disabled><i class="fa fa-refresh"></i>&nbsp;Atualizar</a>-->
                                        </label>
                                        <div class="ui fluid corner labeled input">
                                            <input type="text" class="form-control input_style" id="transacao_funcao" name="transacao_funcao" autocomplete="off">
                                            <div class="ui corner label">
                                                <i class="asterisk icon"></i>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="transacao_fonte"><span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> Fonte(s)" data-content="Insira as fontes utilizadas para a contagem:<ul><li>Casos de uso</li><li>Requisitos</li><li>Planilhas</li><li>Modelo Entidade Relacionamento - MER</li><li>Demais documenta&ccedil;&otilde;es</li></ul>"><i class="fa fa-info-circle"></i>&nbsp;Fonte(s) utilizada(s)</span></label>
                                        <div class="ui fluid corner labeled input">
                                            <input type="text" class="form-control input_style" id="transacao_fonte" name="transacao_fonte" autocomplete="off">
                                            <div class="ui corner label">
                                                <i class="asterisk icon"></i>
                                            </div>
                                        </div>                                                 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <span class="pop" data-toggle="popover" title="<i class='fa fa-arrow-right'></i>&nbsp;Arquivos Referenciados"
                                                  data-content="&Eacute; um Arquivo L&oacute;gico Interno [ALI] lido ou mantido pela fun&ccedil;&atilde;o transacional ou um Arquivo de Interface Externa [AIE] lido pela fun&ccedil;&atilde;o transacional. 
                                                  Tamb&eacute;m chamado de Arquivo L&oacute;gico Referenciado (ALR) ou File Type Referenced [FTR].
                                                  A complexidade funcional de cada EE, SE e CE &eacute; atribu&iacute;da com base no n&uacute;mero de arquivos referenciados e tipos de dados.<hr>
                                                  <i class='fa fa-lightbulb-o'></i>&nbsp;<strong>DICA</strong><br />
                                                  Para descrever um arquivo referenciado voc&ecirc; deve seguir o seguinte padr&atilde;o:<br /><br />
                                                  <center>[<strong>tipo</strong>].[<strong>nome do arquivo</strong>]<br />
                                                  ali.comentario ou aie.comentario</center><br/>
                                                  O sistema ir&aacute; conferir se o padr&atilde;o est&aacute; sendo seguido.<br /><br />
                                                  LEGENDA: 
                                                  <span class='label label-warning'>N&atilde;o validada</span>&nbsp;
                                                  <span class='label label-success'>Validada</span>&nbsp;
                                                  <span class='label label-info'>Em revis&atilde;o</span>&nbsp;
                                                  <span class='label label-primary'>Revisada</span>
                                                  <hr>
                                                  Para colar os campos vindos de uma c&oacute;pia, posicione o cursor no campo de texto e digite <kbd>CTRL + V</kbd>. 
                                                  <strong>LEMBRE-SE</strong> de que o texto dos campos deve estar separado por Ponto-e-v&iacute;rgula. 
                                                  Caso n&atilde;o esteja neste formato, o sistema n&atilde;o realizar&aacute; a opera&ccedil;&atilde;o." 
                                                  data-placement="bottom"><i class="fa fa-info-circle"></i>&nbsp;Arquivos Referenciados (AR)</span> | 
                                            <i class="fa fa-search"></i>&nbsp;Pesquisar:&nbsp;
                                            <div class="pop" id="btn-ar-baseline" data-toggle="popover" data-placement="bottom" data-content="
                                                 <div class='scroll' style='width:100%;height:300px;overflow-x:hidden;overflow-y:auto;'>
                                                 <ul style='display: inline-block; padding: 0; list-style-type: none;' id='lst-ar-baseline'></ul>
                                                 </div>" title="<i class='fa fa-arrow-right'></i>&nbsp;Pesquisar - AR na Baseline)"
                                                 style="display: inline-block; width: 15%; border-bottom: 1px solid #d0d0d0; border-radius: 0 0 0 10px; padding: 5px; padding-left: 10px; padding-right: 10px;">
                                                <strong>Baseline</strong></div>
                                            <div class="pop" id="btn-ar-projeto" data-toggle="popover" data-placement="bottom" data-content="
                                                 <div class='scroll' style='width:100%;height:300px;overflow-x:hidden;overflow-y:auto;'>
                                                 <ul style='display: inline-block; padding: 0; list-style-type: none;' id='lst-ar-projeto'></ul>
                                                 </div>" title="<i class='fa fa-arrow-right'></i>&nbsp;Pesquisar - AR neste projeto"
                                                 style="display: inline-block; width: 15%; border-bottom: 1px solid #d0d0d0; border-radius: 0 0 10px 0; padding: 5px; padding-left: 10px; padding-right: 10px;">
                                                <strong>Projeto</strong></div>
                                            <br />Para <kbd>CTRL + V</kbd> selecione o tipo ALI/AIE
                                        </div>
                                        <div class="col-md-4">
                                            <div style="margin: 7px; vertical-align: middle;">
                                                <input id="tipo-arquivo-ali" type="radio" name="chk-tipo-arquivo" value="ali" checked>
                                                <label for="tipo-arquivo-ali"><span><span></span></span>&nbsp;&nbsp;ALI</label>
                                                <input id="tipo-arquivo-aie" type="radio" name="chk-tipo-arquivo" value="aie">
                                                <label for="tipo-arquivo-aie"><span><span></span></span>&nbsp;&nbsp;AIE</label>                                               
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="scroll input_style" style="height: 150px;max-height: 150px; overflow-x: hidden; overflow-y: auto; background-color:#fff; padding:4px; border-radius: 5px; width:100%; margin-top: 5px;">
                                                <input type="text" class="tm-input tm-input-success form-control input-medium input_style_mini paste transacao" placeholder="Inserir" id="transacao_descricao_ar" />
                                            </div>                                          
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <span class="pop" data-toggle="popover" title="<i class='fa fa-arrow-right'></i>&nbsp;Tipos de Dados" 
                                                  data-content="Campo &uacute;nico reconhecido pelo usu&aacute;rio e n&atilde;o repetido. 
                                                  Tamb&eacute;m chamado Dado Elementar Referenciado [DER] ou Data Element Type [DET].<hr>
                                                  <i class='fa fa-lightbulb-o'></i>&nbsp;<strong>DICA</strong><br />
                                                  Para descrever um tipo de dado voc&ecirc; deve  seguir o seguinte padr&atilde;o:<br /><br />
                                                  <center>[<strong>tipo</strong>].[<strong>nome do arquivo</strong>].[<strong>tipo de dado</strong>]<br />
                                                  ali.comentario.data_postagem ou aie.comentario.data_postagem</center><br/>
                                                  O sistema ir&aacute; conferir se o padr&atilde;o est&aacute; sendo seguido.<br /><br />
                                                  LEGENDA: 
                                                  <span class='label label-warning'>N&atilde;o validada</span>&nbsp;
                                                  <span class='label label-success'>Validada</span>&nbsp;
                                                  <span class='label label-info'>Em revis&atilde;o</span>&nbsp;
                                                  <span class='label label-primary'>Revisada</span>
                                                  <hr>
                                                  Para colar os campos vindos de uma c&oacute;pia, posicione o cursor no campo de texto e digite <kbd>CTRL + V</kbd>. 
                                                  <strong>LEMBRE-SE</strong> de que o texto dos campos deve estar separado por Ponto-e-v&iacute;rgula. 
                                                  Caso n&atilde;o esteja neste formato, o sistema n&atilde;o realizar&aacute; a opera&ccedil;&atilde;o.<br /><br />
                                                  Para inserir um Tipo de Dado em que n&atilde;o haja um Arquivo Referenciado, basta digitar _.[Tipo de Dado}, Ex.: _.operador1, _.operador2, etc." 
                                                  data-placement="bottom"><i class="fa fa-info-circle"></i>&nbsp;Tipos de Dados (TD)</span> | 
                                            <i class="fa fa-search"></i>&nbsp;Pesquisar:&nbsp;
                                            <div class="pop" id="btn-td-ar-baseline" data-toggle="popover" data-placement="bottom" data-content="
                                                 <div class='scroll' style='width:100%;heigth:250px;height:300px;overflow-x:hidden;overflow-y:auto;'>
                                                 <ul style='display: inline-block; padding: 0; list-style-type: none;' id='lst-td-ar-baseline'></ul>
                                                 </div>" title="<i class='fa fa-arrow-right'></i>&nbsp;Pesquisar TDs dos Arquivos Referenciados (BASELINE)"
                                                 style="display: inline-block; width: 16%; border-bottom: 1px solid #d0d0d0; border-radius: 0 0 0 10px; padding: 5px; padding-left: 10px; padding-right: 10px;">
                                                <strong>Baseline</strong></div>
                                            <div class="pop" id="btn-td-ar-projeto" data-toggle="popover" data-placement="bottom" data-content="
                                                 <div class='scroll' style='width:100%;heigth:250px;height:300px;overflow-x:hidden;overflow-y:auto;'>
                                                 <ul style='display: inline-block; padding: 0; list-style-type: none;' id='lst-td-ar-projeto'></ul>
                                                 </div>" title="<i class='fa fa-arrow-right'></i>&nbsp;Pesquisar - Arquivos Referenciados (PROJETO)"
                                                 style="display: inline-block; width: 16%; border-bottom: 1px solid #d0d0d0; border-radius: 0 0 10px 0; padding: 5px; padding-left: 10px; padding-right: 10px;">
                                                <strong>Projeto</strong></div>
                                            <br />Para <kbd>CTRL + V</kbd> selecione o Arquivo Referenciado
                                        </div>
                                        <div class="col-md-5">
                                            <div style="margin: 3px; vertical-align: middle;">
                                                <select id="sel_funcao_transacao" class="form-control input_style"><option value="0">...</option></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="scroll input_style" style="height: 150px; max-height: 150px; overflow-x: hidden; overflow-y: auto; background-color: #fff; padding:4px; width:100%; border-radius: 5px; margin-top: 5px;">
                                                <input type="text" class="tm-input tm-input-success form-control input-medium input_style_mini paste transacao" placeholder="Inserir" id="transacao_descricao_td" />
                                            </div>
                                        </div>
                                    </div>
                                </div>                          
                            </div>                      
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="transacao_impacto"><i id="w_transacao_impacto" class="fa fa-dot-circle-o"></i>&nbsp;F. Impacto&nbsp;|&nbsp;<a href="#" id="btn-transacao-detalhe-fator" data-content="" data-toggle="popover" data-placement="right" data-title="<i class='fa fa-arrow-circle-rigth'></i>&nbsp;Detalhe do Fator de Impacto" data-content="Por favor, selecione um Fator de Impacto."><i class="fa fa-search"></i>&nbsp;Detalhes</a></label>
                                                <select class="form-control input_style" id="transacao_impacto" name="transacao_impacto">
                                                    <option value="0">...</option>
                                                </select>
                                            </div>            
                                        </div>                                                                            
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="transacao_ar">
                                                    <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Arquivos Referenciados (ALR ou FTR)" data-content="
                                                          &Eacute; um arquivo l&oacute;gico interno (ALI) lido ou mantido pela fun&ccedil;&atilde;o transacional ou um arquivo de interface externa [AIE] lido pela fun&ccedil;&atilde;o transacional. 
                                                          Tamb&eacute;m chamado de Arquivo L&oacute;gico Referenciado [ALR] ou File Type Referenced [FTR]. 
                                                          A complexidade funcional de cada EE, SE e CE &eacute; atribu&iacute;da com base no n&uacute;mero de arquivos referenciados e tipos de dados.<hr>                                         
                                                          <strong>FONTE</strong><br />
                                                          <a href='http://ead.fattocs.com.br/mod/glossary/view.php?id=1374&mode=letter&hook=T&sortkey=&sortorder=' target='_new'>Gloss&aacute;rio APF</a><br />
                                                          &copy;<a href='http://www.fattocs.com' target='_new'>FATTO Consultoria e Sistemas</a>">
                                                        <i class="fa fa-info-circle"></i>&nbsp;AR</span>
                                                </label>
                                                <input type="text" class="form-control input_style" id="transacao_ar" name="transacao_ar" maxlength="3" autocomplete="off" readonly>
                                            </div>          
                                        </div>                                    
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="transacao_td">
                                                    <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Tipos de Dados (DER ou DET)" data-content="
                                                          Campo &uacute;nico reconhecido pelo usu&aacute;rio e n&atilde;o repetido. 
                                                          Tamb&eacute;m chamado Dado Elementar Referenciado [DER] ou Data Element Type [DET]<hr>
                                                          <strong>FONTE</strong><br />
                                                          <a href='http://ead.fattocs.com.br/mod/glossary/view.php?id=1374&mode=letter&hook=T&sortkey=&sortorder=' target='_new'>Gloss&aacute;rio APF</a><br />
                                                          &copy;<a href='http://www.fattocs.com' target='_new'>FATTO Consultoria e Sistemas</a>">
                                                        <i class="fa fa-info-circle"></i>&nbsp;TD</span>
                                                </label>
                                                <input type="text" class="form-control input_style" id="transacao_td" name="transacao_td" maxlength="3" readonly>
                                            </div>            
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="complexidade">Complexidade</label>
                                                <input type="text" class="form-control input_style" id="transacao_complexidade" name="transacao_complexidade" value="" readonly>
                                            </div>            
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="pfb"><span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> Pontos de Fun&ccedil;&atilde;o brutos - PFb" data-content="" id="tbl_tipos"><i class="fa fa-info-circle"></i>&nbsp;PFb</span></label>
                                                <input type="text" class="form-control input_style" id="transacao_pfb" name="transacao_pfb" readonly>
                                            </div>            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="transacao_pfa">
                                                    <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> Pontos de Fun&ccedil;&atilde;o ajustados - PFa" data-content="
                                                          Representam a quantidade de PF ajustados de acordo com algum roteiro de m&eacute;trica (Espec&iacute;fico da organiza&ccedil;&atilde;o, SISP, etc)"><i class="fa fa-info-circle"></i>&nbsp;PFa</span></label>
                                                <input type="text" class="form-control input_style" id="transacao_pfa" name="transacao_pfa" readonly>
                                            </div>            
                                        </div>                           
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="transacao_fd">
                                                    <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i>&nbsp;Fator de Documenta&ccedil;&atilde;o"
                                                          data-content="
                                                          <i class='fa fa-lightbulb-o fa-lg'></i>&nbsp;Melhor pr&aacute;tica encontrada<hr>
                                                          <div style='min-height:250px;max-height:250px;overflow-x:hidden;overflow-y:scroll;padding:3px;' class='scroll'>
                                                          <p align='justify'>
                                                          O Fator de Documenta&ccedil;&atilde;o &eacute; vari&aacute;vel entre <strong>0,00</strong> e <strong>0,20</strong> para os servi&ccedil;os de documenta&ccedil;&atilde;o.
                                                          A utiliza&ccedil;&atilde;o deste fator foi encontrada em um roteiro de m&eacute;tricas do BNB - Banco do Nordeste do Brasil que define sua aplicabilidade segundo a tabela abaixo.</p>
                                                          <small>
                                                          <table width='100%' class='table table-condensed table-striped' style='margin-bottom:5px;margin-top:5px;border:1px solid #d0d0d0;'>
                                                          <tr><td width='20%'>Disciplinas RUP-BNB*</td><td width='25%'>% Esfor&ccedil;o de documenta&ccedil;&atilde;o</td><td width='55'>Artefatos pass&iacute;veis de contrata&ccedil;&atilde;o</td></tr>
                                                          <tr><td>Requisitos</td><td>10</td><td>. Regras de Neg&oacute;cios;<br />. Especifica&ccedil;&otilde;es de Casos de Uso;<br />. Modelos de Casos de Uso;<br />. Estimativa de Tamanho.</td></tr>
                                                          <tr><td>An&aacute;lise e Design</td><td>6</td><td>. Documento de Arquitetura do Sistema;<br />. Modelo de Dados Conceitual L&oacute;gico (com a descri&ccedil;&atilde;o das entidades e atributos);<br />. Diagrama de Classes;<br />. Realiza&ccedil;&atilde;o de Caso de Uso (exclusivo para mainframe);<br />
                                                          . Dicion&aacute;rio de dados (exclusivo para mainframe);<br />
                                                          . Grupo de Execu&ccedil;&atilde;o (exclusivo para mainframe);<br />
                                                          . Estimativa de Tamanho.</td></tr>
                                                          <tr><td>Implementa&ccedil;&atilde;o</td><td>4</td>
                                                          <td>. Lista de Materiais;<br />. Plano de Implanta&ccedil;&atilde;o;<br />. Manual do Usu&aacute;rio;<br />. Estimativa de Tamanho.</td></tr>
                                                          <tr><td>TOTAL</td><td>20</td><td><strong><center>Utilize o total quando a documenta&ccedil;&atilde;o for requerida para todos os artefatos acima</center></strong></td></tr>
                                                          </table>
                                                          </small>
                                                          <strong>Observa&ccedil;&otilde;es</strong>:<br />(1) em casos de necessidade de documenta&ccedil;&atilde;o parcial, em montantes menores que os explicitados na tabela acima, 
                                                          a recomenda&ccedil;&atilde;o &eacute; que seja feita uma negocia&ccedil;&atilde;o entre CONTRATANTE e CONTRATADA. (2) em casos de utiliza&ccedil;&atilde;o de pontos de fun&ccedil;&atilde;o 
                                                          inclu&iacute;dos, onde ser&atilde;o pagos 100% do valor, a documenta&ccedil;&atilde;o &eacute; de car&aacute;ter obrigat&oacute;rio, n&atilde;o havendo a aplica&ccedil;&atilde;o de valores extras.
                                                          </div>
                                                          <hr>
                                                          Fonte:<br />
                                                          <a href='http://www.bnb.gov.br/documents/45078/47401/anexo+vii_guia_de_contratacao_pontos_de_funcao_rfp_aut_banc_0112.pdf/f4a43b8a-9cd0-47b3-91e6-8fa9a95929de' target='_new'>Guia de Contrata&ccedil;&atilde;o de PF - BNB</a><br />
                                                          <small>* Este processo refere-se ao processo do modelo apresentado, o seu pode diferir nas fases/descri&ccedil;&otilde;es.</small>
                                                          "><i class="fa fa-info-circle"></i>&nbsp;FD</span></label>
                                                <select id="transacao_fd" class="form-control input_style" disabled>
                                                    <option value="0.00">0,00</option>
                                                    <option value="0.04">0,04</option>
                                                    <option value="0.06">0,06</option>
                                                    <option value="0.10">0,10</option>
                                                    <option value="0.14">0,14</option>
                                                    <option value="0.16">0,16</option>
                                                    <option value="0.20">0,20</option>
                                                </select>
                                            </div>            
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="transacao-fase">
                                                    <span class="pop" data-toggle="popover" data-placement="right" title="<i class='fa fa-arrow-right'></i>&nbsp;Mudan&ccedil;a de requisitos" data-content="
                                                          <i class='fa fa-lightbulb-o fa-lg'></i>&nbsp;Melhor pr&aacute;tica encontrada<hr>
                                                          Voc&ecirc; deve utilizar estes c&aacute;lculos apenas se o seu projeto est&aacute; sendo gerenciado e tem atribu&iacute;dos os percentuais de execu&ccedil;&atilde;o de cada fase.
                                                          A equipe do Dimension&reg; observou estes c&aacute;lculos em alguns roteiros, a exemplo da RFB e do SERPRO. Vejamos: 
                                                          uma mudan&ccedil;a na fase de implementa&ccedil;&atilde;o com percentual de execu&ccedil;&atilde;o em 20%. O esfor&ccedil;o seria de 20% (percentual de completude) x 50%<sup>1</sup> = 10% para a fase de implementa&ccedil;&atilde;o.
                                                          Somando-se as fases anteriores Requisitos (5%) + Design (15%) + Implementa&ccedil;&atilde;o (10%) = 30%.<br />
                                                          O tamanho da mudan&ccedil;a seria:</p><br />
                                                          <center>PFb x % de completude da fase x Fator de Impacto<br />
                                                          5PFb x 30% x 75% = 1,125 PFa</center><hr>
                                                          Fonte:<br />
                                                          <a href='http://www.pgfn.gov.br/acesso-a-informacao/tecnologia-da-informacao/Roteiro_Contagem_PF_SERPRO_%207.pdf' target='_new'>Roteiro RFB/SERPRO</a> - Vers&atilde;o de 22/06/2015 (dispon&iacute;vel no site da PGFN)<br />
                                                          <sup>1</sup> Percentual atribu&iacute;do &agrave; fase de Implementa&ccedil;&atilde;o no roteiro da RFB/SERPRO, os seus percentuais podem variar de acordo com o seu contrato/roteiro.">
                                                        <i class="fa fa-info-circle"></i>&nbsp;Mudan&ccedil;a?
                                                    </span>
                                                </label>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <input type="checkbox" data-toggle="toggle" data-offstyle="warning" data-onstyle="success" data-style="slow" id="transacao-is-mudanca" data-height="36" data-on="Sim" data-off="N&atilde;o" data-width="50" disabled>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select id="transacao-fase" class="form-control input_style" tabindex="0" disabled>
                                                            <?php if (isset($_GET['id'])) { ?>
                                                                <option value="0">Selecione a fase</option>
                                                                <?= $_SESSION['contagem_estatisticas']['is_f_eng'] ? '<option value="ENG">' . $_SESSION['contagem_estatisticas']['desc_f_eng'] . ' (' . $_SESSION['contagem_estatisticas']['pct_eng'] . '%)</option>' : NULL; ?>
                                                                <?= $_SESSION['contagem_estatisticas']['is_f_des'] ? '<option value="DES">' . $_SESSION['contagem_estatisticas']['desc_f_des'] . ' (' . $_SESSION['contagem_estatisticas']['pct_des'] . '%)</option>' : NULL; ?>
                                                                <?= $_SESSION['contagem_estatisticas']['is_f_imp'] ? '<option value="IMP">' . $_SESSION['contagem_estatisticas']['desc_f_imp'] . ' (' . $_SESSION['contagem_estatisticas']['pct_imp'] . '%)</option>' : NULL; ?>
                                                                <?= $_SESSION['contagem_estatisticas']['is_f_tes'] ? '<option value="TES">' . $_SESSION['contagem_estatisticas']['desc_f_tes'] . ' (' . $_SESSION['contagem_estatisticas']['pct_tes'] . '%)</option>' : NULL; ?>
                                                                <?= $_SESSION['contagem_estatisticas']['is_f_hom'] ? '<option value="HOM">' . $_SESSION['contagem_estatisticas']['desc_f_hom'] . ' (' . $_SESSION['contagem_estatisticas']['pct_hom'] . '%)</option>' : NULL; ?>
                                                                <?= $_SESSION['contagem_estatisticas']['is_f_impl'] ? '<option value="IMPL">' . $_SESSION['contagem_estatisticas']['desc_f_impl'] . ' (' . $_SESSION['contagem_estatisticas']['pct_impl'] . '%)</option>' : NULL; ?>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <option value="0">Selecione a fase</option>
                                                                <?= $_SESSION['contagem_config']['is_f_eng'] ? '<option value="ENG">' . $_SESSION['contagem_config']['desc_f_eng'] . ' (' . $_SESSION['contagem_config']['pct_f_eng'] . '%)</option>' : NULL; ?>
                                                                <?= $_SESSION['contagem_config']['is_f_des'] ? '<option value="DES">' . $_SESSION['contagem_config']['desc_f_des'] . ' (' . $_SESSION['contagem_config']['pct_f_des'] . '%)</option>' : NULL; ?>
                                                                <?= $_SESSION['contagem_config']['is_f_imp'] ? '<option value="IMP">' . $_SESSION['contagem_config']['desc_f_imp'] . ' (' . $_SESSION['contagem_config']['pct_f_imp'] . '%)</option>' : NULL; ?>
                                                                <?= $_SESSION['contagem_config']['is_f_tes'] ? '<option value="TES">' . $_SESSION['contagem_config']['desc_f_tes'] . ' (' . $_SESSION['contagem_config']['pct_f_tes'] . '%)</option>' : NULL; ?>
                                                                <?= $_SESSION['contagem_config']['is_f_hom'] ? '<option value="HOM">' . $_SESSION['contagem_config']['desc_f_hom'] . ' (' . $_SESSION['contagem_config']['pct_f_hom'] . '%)</option>' : NULL; ?>
                                                                <?= $_SESSION['contagem_config']['is_f_impl'] ? '<option value="IMPL">' . $_SESSION['contagem_config']['desc_f_impl'] . ' (' . $_SESSION['contagem_config']['pct_f_impl'] . '%)</option>' : NULL; ?>
                                                            <?php }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="transacao-percentual-fase">
                                                    <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Percentual de completude da fase" data-content="
                                                          Insira no campo o percentual de completude da fase que o Dimension&reg; calcular&aacute; os Pontos de Fun&ccedil;&atilde;o ajustados - PFa.
                                                          Lembre-se que a quantidade &eacute; a de PF_RETRABALHO e que o percentual m&aacute;ximo &eacute; de 100% (cem), se a fase estiver conclu&iacute;da e a fase seguinte estiver no in&iacute;cio.">
                                                        <i class="fa fa-info-circle"></i>&nbsp;( % )</span>
                                                </label>
                                                <input type="text" id="transacao-percentual-fase" class="form-control input_style" data-mask="000" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <!--
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="transacao_observacoes">Observa&ccedil;&otilde;es</label>
                                                <textarea data-widearea="enable" id="transacao_observacoes" name="transacao_observacoes" class="form-control input_style scroll" maxlength="3000" style="height:150px;"></textarea>
                                            </div>
                                        </div>-->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="transacao_log">Logs do sistema</label>
                                                <div id="transacao_log" class="scroll" style="height: 175px; max-height: 175px; width: 100%; overflow-x: hidden; overflow-y: auto; border: 1px solid #d0d0d0; padding: 4px; border-radius: 5px;"></div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="transacao_observacoes">
                                    </div>
                                </div>
                            </div>              
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" id="acoes">
                        <button type="button" class="btn btn-success" id="transacao_btn_al" disabled><i class="fa fa-check-square-o"></i> Atualizar o registro</button>
                        <button type="button" class="btn btn-success" id="transacao_btn_if" disabled><i class="fa fa-check-circle"></i> Inserir e fechar</button>
                        <button type="button" class="btn btn-success" id="transacao_btn_in" disabled><i class="fa fa-plus-circle"></i> Inserir e continuar</button>
                    </div>                    
                </div>
            </div>
        </div>
    </form>
</div>