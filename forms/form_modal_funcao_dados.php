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
<div id="form_modal_funcao_dados" class="modal fade" role="dialog">
    <form id="form_dados" role="form">
        <div class="modal-dialog modal-lg">
            <!-- Modal content -->
            <div class="modal-content">
                <input type="hidden" name="dados_operacao" id="dados_operacao" value="" title="Inclus&atilde;o, Altera&ccedil;&atilde;o, Exclus&atilde;o">
                <input type="hidden" name="dados_tabela" id="dados_tabela" value="" title="Tabela ALI / AIE">
                <input type="hidden" name="dados_metodo" id="dados_metodo" value="" title="M&eacute;todo de inser&ccedil;&atilde;o NESMA, FP-LITE, Detalhada">
                <input type="hidden" name="dados_id" id="dados_id" value="" title="id da funcao inserida">
                <input type="hidden" name="dados_qtd_atual" id="dados_qtd_atual" value="" title="quantidade atual">
                <input type="hidden" name="dados_observacoes_validacao" id="dados_observacoes_validacao" value="">
                <input type="hidden" name="dados_id_funcao_baseline" id="dados_id_funcao_baseline" value="">
                <input type="hidden" name="dados_funcao_nome_anterior" id="dados_funcao_nome_anterior" value="">
                <input type="hidden" name="dados_funcao_is_alterar_nome" id="dados_funcao_is_alterar_nome" value="0">
                <div class="modal-header">
                    <button type="button" id="fechar_dados" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <span id="dados_h4-modal"></span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sisp">
                                            <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> Roteiro de m&eacute;trica" 
                                                  data-content="
                                                  O roteiro de m&eacute;trica especifica os fatores de impactos que devem ser considerados para os PFa. 
                                                  Selecione um roteiro padr&atilde;o (SISP 2.0, SISP 2.1, SISP Datawarehouse) ou o da sua organiza&ccedil;&atilde;o, como por exemplo o roteiro da ANEEL 1.0 - 2012 ou o Roteiro do BNB.
                                                  Caso seja um roteiro &quot;exclusivo&quot; aparecer&atilde;o as siglas (C) - para um Cliente e (F) para um fornecedor. <strong>IMPORTANTE</strong> salientar que os roteiros citados s&atilde;o apenas exemplos, o Dimension&reg; vem com os Roteiros do SISP por padr&atilde;o, apenas.</p><hr>
                                                  <strong>FONTE</strong><br />Roteiro de M&eacute;tricas SISP 2.1 - Dispon&iacute;vel <a href='http://www.sisp.gov.br' target='_new'>AQUI</a><br />
                                                  Roteiro de M&eacute;tricas da ANEEL - Dispon&iacute;vel <a href='http://www2.aneel.gov.br/aplicacoes/consulta_publica/documentos/ANEXO%20VI%20-%20Roteiro%20de%20M%C3%A9tricas%20de%20Software%20da%20ANEEL.pdf' target='_new'>AQUI</a><br />
                                                  Roteiro de M&eacute;tricas do BNB - Dispon&iacute;vel <a href='http://www.bnb.gov.br/documents/45078/47401/anexo_VII_guia_de_contagem_de_ponto_de_funcao_0209.pdf/e5824206-e460-44a9-9e23-1f068f323423' target='_new'>AQUI</a>">
                                                <i class="fa fa-info-circle"></i>&nbsp;(C) Cliente, (F) Fornecedor</span>&nbsp;|&nbsp;<a href="#" id="btn-listar-itens-dados" data-toggle="modal" data-target="#form-modal-listar-itens-roteiro"><i class="fa fa-search"></i>&nbsp;Detalhes</a></label><br />                                       
                                        <select class="form-control input_style id_roteiro" id="dados_id_roteiro" name="dados_id_roteiro" style="background-color: #fff;" disabled></select>
                                    </div>            
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="dados_op">
                                            <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> Opera&ccedil;&atilde;o" 
                                                  data-content="<strong>I</strong> - Inclus&atilde;o<br><strong>A</strong> - Altera&ccedil;&atilde;o<br><strong>E</strong> - Exclus&atilde;o<br><strong>T</strong> - Testes
                                                  <hr>
                                                  <i class='fa fa-lightbulb-o'></i>&nbsp;<strong>DICA</strong>: caso esteja inserindo uma contagem de Baseline ou de Licita&ccedil;&atilde;o as opera&ccedil;&otilde;es de Altera&ccedil;&atilde;o e Exclus&atilde;o estar&atilde;o desabilitadas."><i class="fa fa-info-circle"></i>&nbsp;Opera&ccedil;&atilde;o</span></label><br />
                                        <div class="btn-group" id="dados_op">        
                                            <button type="button" class="btn btn-default" value="I" id="dados_op1">I</button>
                                            <button type="button" class="btn btn-default" value="A" id="dados_op2">A</button>
                                            <button type="button" class="btn btn-default" value="E" id="dados_op3">E</button>
                                            <button type="button" class="btn btn-default" value="T" id="dados_op4" disabled>T</button>
                                        </div>                
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="dados_me">
                                            <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> M&eacute;todo" 
                                                  data-content="
                                                  N - NESMA Estimativa (Visite o <a href='http://nesma.org' target='_new'>site</a>)<br />
                                                  F - FP-Lite&trade; (Veja detalhes <a href='http://www.davidconsultinggroup.com/insights/publications/fp-lite-an-alternative-approach-to-sizing/' target='_new'>aqui</a>)<br />
                                                  D - Detalhado<hr>
                                                  <strong>Observa&ccedil;&atilde;o (1)</strong>: 
                                                  caso voc&ecirc; esteja realizando uma contagem atrav&eacute;s do m&eacute;todo 
                                                  de Elementos Funcionais (mais detalhes <a href='http://portal.tcu.gov.br/lumis/portal/file/fileDownload.jsp?fileId=8A8182A250D20C48015112098DCB35C7' target='_new'>aqui</a>), &eacute; 
                                                  importante salientar que o Dimension&reg; o utiliza em sua totalidade, ou seja: <strong>EF = EFd + EFt</strong><hr>
                                                  <strong>Observa&ccedil;&atilde;o (2)</strong>: caso voc&ecirc; esteja inserindo uma contagem de Baseline, as op&ccedil;&otilde;es [N] Nesma e [F] FP-Lite estar&atilde;o desabilitadas."><i class="fa fa-info-circle"></i>&nbsp;M&eacute;todo</span></label><br>
                                        <div class="btn-group" id="dados_me">
                                            <button type="button" class="btn btn-default" value="1" id="dados_me1">N</button>
                                            <button type="button" class="btn btn-default" value="2" id="dados_me2">F</button>
                                            <button type="button" class="btn btn-default" value="3" id="dados_me3">D</button>
                                        </div>                
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="dados_entrega"><span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> Entrega" data-content="<p align='justify'>Digite aqui a entrega/sprint em que esta funcionalidade ser&aacute; feita. Lembre-se que o limite &eacute; a quantidade selecionada na ABA - Informa&ccedil;&otilde;es</p>"><i class="fa fa-info-circle"></i>&nbsp;Entrega</span></label><br />
                                        <input type="text" name="dados_entrega" id="dados_entrega" value="1" class="form-control input_style spinnumber" maxlength="2" value="1">
                                    </div>            
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="is-crud" style="margin-bottom: 4px;">
                                            <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-circle-right'></i>&nbsp;CRUD?" 
                                                  data-content="O Dimension insere automaticamente as funcionalidades de transa&ccedil;&atilde;o CRUD, 
                                                  que &eacute; o acr&ocirc;nimo da express&atilde;o do idioma Ingl&ecirc;s, 
                                                  Create (Criação), Retrieve (Consulta), 
                                                  Update (Atualiza&ccedil;&atilde;o) e Delete (Destrui&ccedil;&atilde;o, Dele&ccedil;&atilde;o).
                                                  Este acr&ocirc;nimo &eacute; comumente utilizado para definir as quatro opera&ccedil;&otilde;es b&aacute;sicas usadas em Banco de Dados Relacionais.
                                                  <hr>
                                                  Exemplo:<br />
                                                  Se o ALI for <strong>comentarios</strong> o sistema ir&aacute; inserir tr&ecirc;s Entradas Externas 1) inserir_comentarios; 2) alterar_comentarios e; 3) excluir_comentarios.
                                                  Tamb&eacute;m ir&aacute; inserir uma Consulta Externa 1) consultar_comentarios">
                                                <i class="fa fa-info-circle"></i>&nbsp;CRUD?</span></label><br />
                                        <input class="form-control" type="checkbox" data-toggle="toggle" data-offstyle="default" data-onstyle="success" data-style="slow" id="is-crud" data-on="Sim" data-off="N&atilde;o" data-width="80" data-height="36" disabled>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="is-crud-atualizar-dependentes" style="margin-bottom: 4px;">
                                            <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Atualizar transa&ccedil;&otilde;es dependentes"
                                                  data-content="Marque esta opção como SIM sempre que desejar atualizar as funcionalidades de transa&ccedil;&atilde;o inseridas como CRUD deste ALI. Os TDs serão atualizados de acordo com a função original."><i class="fa fa-info-circle"></i>&nbsp;Atualizar?</span></label><br />
                                        <input class="form-control" type="checkbox" data-toggle="toggle" data-offstyle="default" data-onstyle="success" data-style="slow" id="is-crud-atualizar-dependentes" data-on="Sim" data-off="N&atilde;o" data-width="80" data-height="36">
                                    </div>
                                </div>
                            </div>
                            <div class="row">                    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dados_funcao">
                                            <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> Consulta &agrave;s baselines" 
                                                  data-content="
                                                  LEGENDA<hr>
                                                  B - A fun&ccedil;&atilde;o foi originada em uma contagem de Baseline;<br />
                                                  P - A fun&ccedil;&atilde;o foi adicionada/modificada por uma contagem de projeto;<br />
                                                  I, A, E - &Uacute;ltima opera&ccedil;&atilde;o executada: Inclus&atilde;o, Altera&ccedil;&atilde;o ou Exclus&atilde;o;<br />
                                                  9999999 - Id da contagem que a fun&ccedil;&atilde;o est&aacute; associada.
                                                  ">
                                                <span id="label-dados-funcao"><i class="fa fa-info-circle"></i>&nbsp;Fun&ccedil;&atilde;o</span></span>&nbsp;|&nbsp;
                                            <a href="#" class="check-nome-funcao dados" data-toggle="tooltip" data-placement="bottom" title="Verifica o nome da fucionalidade e duplicidades na contagem e na Baseline"><i class="fa fa-check-square"></i>&nbsp;Verificar</a>
                                            <!--&nbsp;|&nbsp;<a href="#" data-toggle="tooltip" data-placement="bottom" title="Verifica os relacionamentos da funcionalidade" class="check-relacionamento dados"><i class="fa fa-sitemap"></i>&nbsp;Relacionamentos</a>-->
                                            <!--&nbsp;|&nbsp;&nbsp;&nbsp;<a href="#" id="btn-pesq-dados" class="disabled" disabled><i class="fa fa-refresh"></i>&nbsp;Atualizar</a>-->
                                        </label>
                                        <div class="input-group">
                                            <input type="text" class="form-control input_style" id="dados_funcao" name="dados_funcao" autocomplete="off" disabled>
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-default alterar" id="alterar-funcao-dados" disabled style="min-width:115px;"><i class="fa fa-edit"></i>&nbsp;Alterar</button>                                                
                                                <button type="button" class="btn btn-default" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Alterar o nome da Função de Dados" 
                                                        data-content="O Dimension controla as altera&ccedil;&otilde;es de nomes porque precisa atualizar as funcionalidades referenciadas EE, SE e CE que utilizam esta fun&ccedil;&atilde;o de dados como Arquivo Referenciado."><i class="fa fa-info-circle"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dados_fonte"><span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> Fonte(s)" data-content="Insira as fontes utilizadas para a contagem:<ul><li>Casos de uso</li><li>Requisitos</li><li>Planilhas</li><li>Modelo Entidade Relacionamento - MER</li><li>Demais documenta&ccedil;&otilde;es</li></ul>"><i class="fa fa-info-circle"></i>&nbsp;Fonte(s) utilizada(s)</span></label>
                                        <div class="ui fluid corner labeled input">
                                            <input type="text" class="form-control input_style" id="dados_fonte" name="dados_fonte" autocomplete="off">
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
                                        <label for="dados_descricao_td">
                                            <span class="pop" data-toggle="popover" title="<i class='fa fa-arrow-right'></i>&nbsp;Tipos de Dados" 
                                                  data-content="
                                                  Campo &uacute;nico reconhecido pelo usu&aacute;rio e n&atilde;o repetido. 
                                                  Tamb&eacute;m chamado Dado Elementar Referenciado (DER) ou Data Element Type (DET).<hr>
                                                  Para colar os campos vindos de uma c&oacute;pia, posicione o cursor no campo de texto e digite <kbd>CTRL + V</kbd>. 
                                                  <strong>LEMBRE-SE</strong> de que o texto dos campos deve estar separado por Ponto-e-v&iacute;rgula. 
                                                  Caso n&atilde;o esteja neste formato, o sistema n&atilde;o realizar&aacute; a opera&ccedil;&atilde;o.<hr>
                                                  Se quiser adicionar um Tipo de Registro ao adicionar um TD, basta digitar ao lado da descri&ccedil;&atilde;o do TD um &quot;*&quot; (asterisco). 
                                                  Ex.: descricao*, em seguida tecle <kbd>ENTER</kbd>."
                                                  data-placement="bottom"><i class="fa fa-info-circle"></i>&nbsp;Descri&ccedil;&atilde;o dos Tipos de Dados (TD)</span></label>
                                        <div class="scroll input_style" style="height: 180px; max-height: 180px; overflow-x: hidden; overflow-y: auto; background-color: #fff; padding: 4px; width:100%;">
                                            <input type="text" class="tm-input tm-input-success form-control input_style_mini paste dados" placeholder="Inserir" id="dados_descricao_td" />
                                        </div>                                          
                                    </div>
                                </div>                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dados_descricao_tr">
                                            <span data-toggle="tooltip" data-placement="right" title="Copiar dos TDs"><a href="#" onclick="copiarTDs();
                                                    return false;"><i class="fa fa-clipboard"></i>&nbsp;Copiar TDs</a></span>&nbsp;
                                            <span class="pop" data-toggle="popover" title="<i class='fa fa-arrow-right'></i>&nbsp;Tipos de registros" data-content="
                                                  Um Tipo de Registro Elementar é um subgrupo de dados reconhecido pelo usuário dentro de uma função de dados. 
                                                  Pode ser um subgrupo opcional ou subgrupo obrigatório. 
                                                  Também chamado de registro lógico referenciado - RLR ou record element type - RET. 
                                                  A complexidade funcional de cada arquivo lógico é definida com base no número de tipos de dado (DET) e tipos de registro (RET) associados a ele.
                                                  No contexto de modelagem de dados, é um grupo de itens de dados relacionados que são tratados como uma unidade.<hr>
                                                  Para colar os campos vindos de uma c&oacute;pia, posicione o cursor no campo de texto e digite <kbd>CTRL + V</kbd>. 
                                                  <strong>LEMBRE-SE</strong> de que o texto dos campos deve estar separado por Ponto-e-v&iacute;rgula. 
                                                  Caso n&atilde;o esteja neste formato, o sistema n&atilde;o realizar&aacute; a opera&ccedil;&atilde;o." 
                                                  data-placement="bottom"><i class="fa fa-info-circle"></i>&nbsp;Descri&ccedil;&atilde;o dos Tipos de Registros (TR)</span></label>
                                        <div class="scroll input_style" style="height: 180px; max-height: 180px; overflow-x: hidden; overflow-y: auto; background-color: #fff; padding: 4px; width: 100%;">
                                            <input type="text" class="tm-input tm-input-success form-control input_style_mini paste dados" placeholder="Inserir" id="dados_descricao_tr" />
                                        </div>                                          
                                    </div>
                                </div>                    
                            </div>
                            <!--quebrar formulario aqui-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="dados_impacto">
                                                    <i id="w_dados_impacto" class="fa fa-dot-circle-o"></i>&nbsp;F. Impacto&nbsp;|&nbsp;
                                                    <a href="#" id="btn-dados-detalhe-fator" data-content="" data-toggle="popover" data-placement="right" data-title="<i class='fa fa-arrow-circle-rigth'></i>&nbsp;Detalhe do Fator de Impacto" data-content="Por favor, selecione um Fator de Impacto."><i class="fa fa-search"></i>&nbsp;Detalhes</a>
                                                </label>
                                                <select class="form-control input_style" id="dados_impacto" name="dados_impacto"><option value="0">...</option></select>
                                            </div>            
                                        </div>                                            
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="dados_td">
                                                    <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Tipos de Dados (DER ou DET)" data-content="
                                                          Campo &uacute;nico reconhecido pelo usu&aacute;rio e n&atilde;o repetido. Tamb&eacute;m chamado Dado Elementar Referenciado (DER) ou Data Element Type (DET)<hr>
                                                          <strong>FONTE</strong><br />
                                                          <a href='http://ead.fattocs.com.br/mod/glossary/view.php?id=1374&mode=letter&hook=T&sortkey=&sortorder=' target='_new'>Gloss&aacute;rio APF</a><br />
                                                          &copy;<a href='http://www.fattocs.com' target='_new'>FATTO Consultoria e Sistemas</a>"><i class="fa fa-info-circle"></i>&nbsp;TD</span>
                                                </label>
                                                <input type="text" class="form-control input_style" id="dados_td" name="dados_td" maxlength="3" autocomplete="off" readonly>
                                            </div>            
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="dados_tr">
                                                    <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Tipos de Registros (RLR ou RET)" data-content="
                                                          Um Tipo de Registro Elementar &eacute; um subgrupo de dados reconhecido pelo usu&aacute;rio 
                                                          dentro de uma fun&ccedil;&atilde;o de dados. Pode ser um subgrupo opcional ou subgrupo obrigat&oacute;rio.
                                                          Tamb&eacute;m chamado de registro l&oacute;gico referenciado - RLR ou record element type - RET. 
                                                          A complexidade funcional de cada arquivo l&oacute;gico &eacute; definida com base no n&uacute;mero de tipos 
                                                          de dado (DET) e tipos de registro (RET) associados a ele.<br />
                                                          No contexto de modelagem de dados, &eacute; um grupo de itens de dados relacionados que s&atilde;o tratados 
                                                          como uma unidade.<hr>                                         
                                                          <strong>FONTE</strong><br />
                                                          <a href='http://ead.fattocs.com.br/mod/glossary/view.php?id=1374&mode=letter&hook=T&sortkey=&sortorder=' target='_new'>Gloss&aacute;rio APF</a><br />
                                                          &copy;<a href='http://www.fattocs.com' target='_new'>FATTO Consultoria e Sistemas</a>"><i class="fa fa-info-circle"></i>&nbsp;TR</span>
                                                </label>
                                                <input type="text" class="form-control input_style" id="dados_tr" name="dados_tr" maxlength="3" autocomplete="off" readonly>
                                            </div>          
                                        </div>                      
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="complexidade">Complexidade</label>
                                                <input type="text" class="form-control input_style" id="dados_complexidade" name="dados_complexidade" value="" readonly>
                                            </div>            
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="pfb">
                                                    <span class="pop" data-placement="bottom" data-toggle="popover" 
                                                          title="<i class='fa fa-arrow-circle-right'></i> Pontos de Fun&ccedil;&atilde;o brutos - PFb" 
                                                          data-content="
                                                          <table class='table table-condensed table-striped'>
                                                          <thead>
                                                          <tr style='font-weight: bold; background-color: #D0D0D0; border-bottom: 2px solid #909090;'><td>Fun&ccedil;&atilde;o</td><td>M&eacute;todo</td><td>Complex.</td><td>PFb</td>
                                                          </thead>
                                                          <tbody>
                                                          <tr><td>ALI</td><td>NESMA</td><td>Baixa</td><td>7,000</td></tr>
                                                          <tr><td>ALI</td><td>FP-LITE</td><td>M&eacute;dia</td><td>10,000</td></tr>
                                                          <tr><td>AIE</td><td>NESMA</td><td>Baixa</td><td>5,000</td></tr>
                                                          <tr><td>AIE</td><td>FP-LITE</td><td>M&eacute;dia</td><td>7,000</td></tr>
                                                          <tr><td colspan='4'><strong>Elementos Funcionas de Dados (EFd)</strong><br />
                                                          ALI [ EFd = 1,75 + 0,96 * ALR + 0,12 * TD ]<br />
                                                          AIE [ EFd = 1,25 + 0,65 * RLR + 0,08 * TD ]
                                                          </td></tr>
                                                          </tbody>
                                                          </table>"><i class="fa fa-info-circle"></i>&nbsp;PFb</span></label>
                                                <input type="text" class="form-control input_style" id="dados_pfb" name="dados_pfb" readonly>
                                            </div>                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="dados_pfa"><span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i> Pontos de Fun&ccedil;&atilde;o ajustados - PFa" data-content="Representa a quantidade de PF ajustados de acordo com algum roteiro de m&eacute;trica (Espec&iacute;fico da organiza&ccedil;&atilde;o, SISP, etc)"><i class="fa fa-info-circle"></i>&nbsp;PFa</span></label>
                                                <input type="text" class="form-control input_style" id="dados_pfa" name="dados_pfa" readonly>
                                            </div>            
                                        </div>                                    
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="dados_fd">
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
                                                <select id="dados_fd" class="form-control input_style" disabled>
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
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="dados_fe">
                                                    <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i>&nbsp;Formulário Estendido"
                                                          data-content="
                                                          <i class='fa fa-lightbulb-o fa-lg'></i>&nbsp;Melhor pr&aacute;tica encontrada<hr>
                                                          Na ANVISA em seu contrato de Fábrica de Software, que pode ser encontrado <a href='http://www.comprasnet.gov.br/ConsultaLicitacoes/download/download_editais_detalhe.asp?coduasg=253002&modprp=5&numprp=262014' target='_blank'>AQUI</a>, 
                                                          o item C.11 - Formulário estendido de peticionamento ou análise que possuírem 75 ou mais campos serão somados PF conforme tabela abaixo.
                                                          <table class='box-table-a'><thead><tr><th>Regra</th></thead>
                                                          <tbody>
                                                          <tr><td>Se 1 &lt;= ALI &lt; 50 <i class='fa fa-angle-double-right'></i> 0PF (não se aplica)</td></tr>
                                                          <tr><td>Se 50 &lt;= ALI &lt; 75 <i class='fa fa-angle-double-right'></i> 0PF (não se aplica)</td></tr>
                                                          <tr><td>Se 75 &lt;= ALI &lt; 100 <i class='fa fa-angle-double-right'></i> 10PF</td></tr>
                                                          <tr><td>Se 100 &lt;= ALI &lt; 150 <i class='fa fa-angle-double-right'></i> 22PF</td></tr>
                                                          <tr><td>Se 150 &lt;= ALI &lt; 200 <i class='fa fa-angle-double-right'></i> 42PF</td></tr>
                                                          <tr><td>Se 200 &lt;= ALI &lt; 250 <i class='fa fa-angle-double-right'></i> 64PF</td></tr>
                                                          <tr><td>Se 250 &lt;= ALI &lt; 300 <i class='fa fa-angle-double-rightt'></i> 84PF</td></tr>
                                                          </tbody>
                                                          </table>
                                                          Fonte Edital 26.2014 &copy; ANVISA - Em 20/04/2017 - p&aacute;gina 157
                                                          "><i class="fa fa-info-circle"></i>&nbsp;FE</span></label>
                                                <select id="dados_fe" class="form-control input_style" disabled>
                                                    <option value="0">--</option>
                                                    <option value="10">10PF</option>
                                                    <option value="22">22PF</option>
                                                    <option value="42">42PF</option>
                                                    <option value="64">64PF</option>
                                                    <option value="84">84PF</option>
                                                </select>
                                            </div>            
                                        </div>                                            
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="dados-fase">
                                                    <span class="pop" data-toggle="popover" data-placement="right" title="<i class='fa fa-arrow-circle-right'></i>&nbsp;Mudan&ccedil;a de requisitos" data-content="
                                                          <i class='fa fa-lightbulb-o fa-lg'></i>&nbsp;Melhor pr&aacute;tica encontrada<hr>
                                                          <p align='justify'>
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
                                                        <input type="checkbox" data-toggle="toggle" data-offstyle="warning" data-onstyle="success" data-style="slow" id="dados-is-mudanca" data-height="36" data-on="Sim" data-off="N&atilde;o" data-width="50" disabled>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select id="dados-fase" class="form-control input_style" tabindex="0" style="display: inline;" disabled>
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
                                                                <?= $_SESSION['contagem_config']['is_f_eng'] ? '<option value="ENG">' . $_SESSION['contagem_estatisticas']['desc_f_eng'] . ' (' . $_SESSION['contagem_config']['pct_f_eng'] . '%)</option>' : NULL; ?>
                                                                <?= $_SESSION['contagem_config']['is_f_des'] ? '<option value="DES">' . $_SESSION['contagem_estatisticas']['desc_f_des'] . ' (' . $_SESSION['contagem_config']['pct_f_des'] . '%)</option>' : NULL; ?>
                                                                <?= $_SESSION['contagem_config']['is_f_imp'] ? '<option value="IMP">' . $_SESSION['contagem_estatisticas']['desc_f_imp'] . ' (' . $_SESSION['contagem_config']['pct_f_imp'] . '%)</option>' : NULL; ?>
                                                                <?= $_SESSION['contagem_config']['is_f_tes'] ? '<option value="TES">' . $_SESSION['contagem_estatisticas']['desc_f_tes'] . ' (' . $_SESSION['contagem_config']['pct_f_tes'] . '%)</option>' : NULL; ?>
                                                                <?= $_SESSION['contagem_config']['is_f_hom'] ? '<option value="HOM">' . $_SESSION['contagem_estatisticas']['desc_f_hom'] . ' (' . $_SESSION['contagem_config']['pct_f_hom'] . '%)</option>' : NULL; ?>
                                                                <?= $_SESSION['contagem_config']['is_f_impl'] ? '<option value="IMPL">' . $_SESSION['contagem_estatisticas']['desc_f_impl'] . ' (' . $_SESSION['contagem_config']['pct_f_impl'] . '%)</option>' : NULL; ?>
                                                            <?php }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="dados-percentual-fase">
                                                    <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-circle-right'></i>&nbsp;Percentual de completude da fase" data-content="
                                                          Insira no campo o percentual de completude da fase que o Dimension&reg; calcular&aacute; os Pontos de Fun&ccedil;&atilde;o ajustados - PFa.
                                                          Lembre-se que a quantidade &eacute; a de PF_RETRABALHO e que o percentual m&aacute;ximo &eacute; de 100% (cem), se a fase estiver conclu&iacute;da e a fase seguinte estiver no in&iacute;cio.">
                                                        <i class="fa fa-info-circle"></i>&nbsp;( % )</span>
                                                </label>
                                                <input type="text" id="dados-percentual-fase" class="form-control input_style" data-mask="000" autocomplete="off" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="dados_log"><i class="fa fa-arrow-right"></i>&nbsp;Logs e informa&ccedil;&otilde;es do sistema</label>
                                                <div id="dados_log" class="scroll" style="padding: 4px; height: 175px; max-height: 175px; width: 100%; overflow-x: hidden; overflow-y: scroll; border: 1px solid #d0d0d0; border-radius: 5px;"></div>
                                            </div>                    
                                        </div>
                                        <!--
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dados_observacoes">Observa&ccedil;&otilde;es</label>
                                                <textarea data-widearea="enable" id="dados_observacoes" name="dados_observacoes" class="form-control input_style scroll" maxlength="3000" style="height: 150px; max-height: 150px;"></textarea>
                                            </div>
                                        </div>
                                        -->
                                        <input type="hidden" name="dados_observacoes">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" id="acoes">
                        <button type="button" class="btn btn-success" id="dados_btn_al" disabled><i class="fa fa-check-square-o"></i> Atualizar o registro</button>
                        <button type="button" class="btn btn-success" id="dados_btn_if" disabled><i class="fa fa-check-circle"></i> Inserir e fechar</button>
                        <button type="button" class="btn btn-success" id="dados_btn_in" disabled><i class="fa fa-plus-circle"></i> Inserir e continuar</button>
                    </div>                                        
                </div>
            </div>
        </div>
    </form>        
</div>