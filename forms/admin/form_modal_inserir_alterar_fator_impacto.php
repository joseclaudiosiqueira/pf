<?php
/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER ['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verificacao do status do login
 */
?>
<!-- Modal -->
<div id="form_modal_inserir_alterar_fator_impacto" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <form id="form_inserir_alterar_item">
                <div class="modal-header">
                    <button type="button" id="fechar_item_roteiro" class="close"
                            data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times"></i></span>
                    </button>
                    <i class="fa fa-adjust"></i>&nbsp;&nbsp;Administra&ccedil;&atilde;o dos itens de roteiro<br />
                    <span class="sub-header">Configura&ccedil;&atilde;o e personaliza&ccedil;&atilde;o dos fatores de impacto</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div style="min-height: 623px; max-height: 623px; overflow-x: hidden; overflow-y: scroll; width: 100%;" class="scroll">
                                <table class="box-table-a" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="36%">Sigla / Descri&ccedil;&atilde;o</th>
                                            <th width="15%">Fonte</th>
                                            <th width="7%">Ajuste</th>
                                            <th width="18"><span class="pop" data-toggle="popover"
                                                                 data-placement="bottom" title="<i  class='fa fa-arrow-right'></i>&nbsp;Altera&ccedil;&atilde;o
                                                                 de status" data-content="Voc&ecirc; pode alterar o status
                                                                 diretamente nas linhas de cada item, caso queira alterar o
                                                                 item basta clicar na sigla descrita na primeira coluna."><i
                                                        class="fa fa-info-circle"></i>&nbsp;<i
                                                        id="w_fator_impacto_status" class="fa fa-dot-circle-o"></i>&nbsp;Status</span></th>
                                            <th width="5%">Oper.</th>
                                            <th width="15%">Aplic&aacute;vel</th>
                                            <th width="7%">Tipo</th>
                                        </tr>
                                    </thead>
                                    <tbody id="addFatorImpacto"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="item_roteiro_id_roteiro"><span class="pop"
                                                                                   data-placement="bottom" data-toggle="popover" title="<i 
                                                                                   class='fa fa-arrow-circle-right'></i> Roteiro de
                                                                                   m&eacute;trica" data-content="
                                                                                   <p align='justify'>O roteiro de m&eacute;trica especifica os
                                                                                   fatores de ajustes que devem ser considerados para os PFa.
                                                                                   Selecione um roteiro padr&atilde;o (SISP 2.0) ou o da sua
                                                                                   organiza&ccedil;&atilde;o</p>"><i class="fa fa-info-circle"></i>&nbsp;<i
                                                    id="w_item_roteiro_id_roteiro" class="fa fa-dot-circle-o"></i>&nbsp;Roteiro
                                                de m&eacute;trica</span></label> <select
                                            class="form-control input_style" id="item_roteiro_id_roteiro"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="item_roteiro_sigla"> <span class="pop"
                                                                               data-toggle="popover" data-placement="bottom" title="<i 
                                                                               class='fa fa-arrow-right'></i>&nbsp;&nbsp;Sigla do item de
                                                                               roteiro" data-content="Utilize siglas que sejam mais
                                                                               f&aacute;ceis de memorizar e pesquisar.<br>p.Ex.:
                                                                               <ul>
                                                                               <li>Inclus&atilde;o de nova funcionalidade - IN_N_F</li>
                                                                               <li>Cancelamento de funcionalidade
                                                                               (homologa&ccedil;&atilde;o) - CA_F_H</li>
                                                                               <li>Sugest&otilde;es:
                                                                               <ul>
                                                                               <li>CA - Cancelamentos</li>
                                                                               <li>IN - Inclus&otilde;es</li>
                                                                               <li>AL - Altera&ccedil;&otilde;es</li>
                                                                               <li>MI - Manuten&ccedil;&atilde;o de Interface</li>
                                                                               <li>AP - Atualiza&ccedil;&atilde;o de Plataforma</li>
                                                                               <li>MC - Manuten&ccedil;&atilde;o Corretiva</li>
                                                                               <li>AV - Atualiza&ccedil;&atilde;o de Vers&atilde;o</li>
                                                                               <li>SM - Solicita&ccedil&atilde;o de Mudan&ccedil;as</li>
                                                                               </ul>
                                                                               </li>
                                                                               </ul>"> <i class="fa fa-info-circle"></i>&nbsp;Sigla</span></label>
                                        <div class="ui fluid corner labeled input">
                                            <input type="text" class="form-control input_style"
                                                   id="item_roteiro_sigla"
                                                   placeholder="Sigla mnem&ocirc;nica do fator" required>
                                            <div class="ui corner label">
                                                <i class="asterisk icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="item_roteiro_fator"> <span class="pop"
                                                                               data-toggle="popover" data-placement="bottom" title="<i 
                                                                               class='fa fa-arrow-right'></i>&nbsp;Fatores" data-content="O
                                                                               &quot;Fator de Impacto&quot; &eacute; o respons&aacute;vel
                                                                               por definir os Pontos de Fun&ccedil;&atilde;o Ajustados. Por
                                                                               exemplo:
                                                                               <hr>PF_ADAPTATIVA = FI x PF_ALTERADO<br>PF_ADAPTATIVA = 0,75
                                                                               * 10<br>PF_ADAPTATIVA = 7,50 PFa
                                                                               <hr>Fonte: SISP 2.0 &copy;<br>Em 30/10/2015<br>p&aacute;gina
                                                                               17<br />
                                                                               <br />
                                                                               <strong>ATEN&Ccedil;&Atilde;O</strong>: por quest&otilde;es
                                                                               hist&oacute;ricas e de custos/faturamento o Fator de Impacto
                                                                               &eacute; o &uacute;nico item que depois de inserido
                                                                               n&atilde;o pode ser alterado, caso queira, desative o item e
                                                                               insira um novo!"> <i class="fa fa-info-circle"></i>&nbsp;Fator
                                                de Impacto (FI)</span></label>
                                        <div class="ui fluid corner labeled input">
                                            <input type="text" class="form-control input_style"
                                                   id="item_roteiro_fator" placeholder="9,999"
                                                   data-mask="#9.999" required>
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
                                        <label for="item_roteiro_descricao"> Descri&ccedil;&atilde;o</label>
                                        <div class="ui fluid corner labeled input">
                                            <input type="text" class="form-control input_style"
                                                   id="item_roteiro_descricao"
                                                   placeholder="Descri&ccedil;&atilde;o do fator" required>
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
                                        <label for="item_roteiro_fonte"><span class="pop"
                                                                              data-toggle="popover" data-placement="bottom" title="<i 
                                                                              class='fa fa-arrow-right'></i>&nbsp;Fonte que justifica o
                                                                              fator" data-content="Indique a fonte que estabelece o fator
                                                                              aplic&aacute;vel, por exemplo:
                                                                              <ul>
                                                                              <li>Edital de licita&ccedil;&atilde;o XYZ, p&aacute;g. 10</li>
                                                                              <li>Roteiro de M&eacute;tricas do SISP &copy;, Item 4.2,
                                                                              P&aacute;g. 10</li>
                                                                              <li>Cite o site, se houver: http://planejamento.gov.br</li>
                                                                              </ul>"> <i class="fa fa-info-circle"></i>&nbsp;Fonte</span></label>
                                        <div class="ui fluid corner labeled input">
                                            <input type="text" class="form-control input_style"
                                                   id="item_roteiro_fonte"
                                                   placeholder="Fonte de justificativa do fator" required>
                                            <div class="ui corner label">
                                                <i class="asterisk icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="border: 1px dotted #a0a0a0; border-radius: 5px; padding: 10px; margin-top: 5px; margin-bottom: 5px;">                            
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="pop" data-toggle="popover" data-placement="bottom"
                                              title="<i  class='fa fa-arrow-right'></i>&nbsp;&nbsp;Aplicabilidade"
                                              data-content="
                                              <p align='justify'>
                                              O sistema permite que o fator de ajuste seja aplic&aacute;vel
                                              apenas a determinadas funcionalidades, fazendo com que o
                                              Analista de M&eacute;trica, no momento do cadastro da
                                              contagem, possa selecionar apenas o item apropriado
                                              &agrave;quela funcionalidade. <strong>Caso nenhuma
                                              op&ccedil&atilde;o seja selecionada o sistema ir&aacute;
                                              atribuir automaticamente a todas.</strong>
                                              </p>"><i class="fa fa-info-circle"></i>&nbsp;Este fator
                                            aplica-se a:</span><br> <input type="checkbox"
                                                                       name="fatores_todos" id="fatores_todos" class="css-checkbox" /><label
                                                                       for="fatores_todos" class="css-label-check">Todos</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <small>Fun&ccedil;&otilde;es de dados</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <input onclick="verificaFatoresTodos($(this).prop('checked'));"
                                               type="checkbox" id="item_roteiro_funcao1" class="css-checkbox" /><label
                                               for="item_roteiro_funcao1" class="css-label-check">ALI</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input onclick="verificaFatoresTodos($(this).prop('checked'));"
                                               type="checkbox" id="item_roteiro_funcao2" class="css-checkbox" /><label
                                               for="item_roteiro_funcao2" class="css-label-check">AIE</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <small>Fun&ccedil;&otilde;es de transa&ccedil;&atilde;o</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <input onclick="verificaFatoresTodos($(this).prop('checked'));"
                                               type="checkbox" id="item_roteiro_funcao3" class="css-checkbox" /><label
                                               for="item_roteiro_funcao3" class="css-label-check">EE</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input onclick="verificaFatoresTodos($(this).prop('checked'));"
                                               type="checkbox" id="item_roteiro_funcao4" class="css-checkbox" /><label
                                               for="item_roteiro_funcao4" class="css-label-check">SE</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input onclick="verificaFatoresTodos($(this).prop('checked'));"
                                               type="checkbox" id="item_roteiro_funcao5" class="css-checkbox" /><label
                                               for="item_roteiro_funcao5" class="css-label-check">CE</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <small>Demais funcionalidades (BI, P&aacute;ginas
                                            est&aacute;ticas, etc)</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input onclick="verificaFatoresTodos($(this).prop('checked'));"
                                               type="checkbox" id="item_roteiro_funcao6" class="css-checkbox" /><label
                                               for="item_roteiro_funcao6" class="css-label-check">Itens Não
                                            Mensuráveis - INM</label>
                                    </div>
                                </div>
                            </div>
                            <div style="border: 1px dotted #a0a0a0; border-radius: 5px; padding: 10px; margin-top: 5px; margin-bottom: 5px;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="pop" data-toggle="popover" data-placement="bottom"
                                              title="<i  class='fa fa-arrow-right'></i>&nbsp;&nbsp;Aplicabilidade"
                                              data-content="
                                              <p align='justify'>
                                              O sistema permite que o fator de ajuste seja aplic&aacute;vel
                                              apenas a determinadas funcionalidades, fazendo com que o
                                              Analista de M&eacute;trica, no momento do cadastro da
                                              contagem, possa selecionar apenas o item apropriado
                                              &agrave;quela funcionalidade. <strong>Caso nenhuma
                                              op&ccedil&atilde;o seja selecionada o sistema ir&aacute;
                                              atribuir automaticamente a todas.</strong>
                                              </p>"><i class="fa fa-info-circle"></i>&nbsp;Aplica&ccedil;&atilde;o nas a&ccedil;&otilde;es de:</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <input type="checkbox" name="tipo_acao_todos"
                                               id="tipo_acao_todos" class="css-checkbox" /><label
                                               for="tipo_acao_todos" class="css-label-check">Todos</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input onclick="verificaAcaoTodos($(this).prop('checked'));"
                                               type="checkbox" name="tipo_acao_1" id="tipo_acao_1"
                                               class="css-checkbox" /><label for="tipo_acao_1"
                                               class="css-label-check">(I)</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input onclick="verificaAcaoTodos($(this).prop('checked'));"
                                               type="checkbox" name="tipo_acao_2" id="tipo_acao_2"
                                               class="css-checkbox" /><label for="tipo_acao_2"
                                               class="css-label-check">(A)</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input onclick="verificaAcaoTodos($(this).prop('checked'));"
                                               type="checkbox" name="tipo_acao_3" id="tipo_acao_3"
                                               class="css-checkbox" /><label for="tipo_acao_3"
                                               class="css-label-check">(E)</label>
                                    </div>
                                    <div class="col-md-2">
                                        <input onclick="verificaAcaoTodos($(this).prop('checked'));"
                                               type="checkbox" name="tipo_acao_4" id="tipo_acao_4"
                                               class="css-checkbox" /><label for="tipo_acao_4"
                                               class="css-label-check">(T)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <span class="pop" data-toggle="popover" data-placement="top"
                                          title="<i  class='fa fa-arrow-right'></i>&nbsp;Tipo do fator
                                          de impacto" data-content="Os Fatores de Impacto podem ser
                                          fixos ou ajustam pelos Pontos de Fun&ccedil;&atilde;o Brutos.
                                          Por exemplo:
                                          <hr> PF_INTERFACE = <strong>0,60PF</strong> x QUANTIDADE DE
                                          FUN&Ccedil;&Otilde;ES TRANSACIONAIS IMPACTADAS<br>
                                          PF_INTERFACE = 0,60PF * 3<br> PF_INTERFACE = 1,80PF
                                          <hr> Fonte SISP 2.0 &copy;<br>Em 30/10/2015<br>p&aacute;gina
                                          16"> <i class="fa fa-info-circle"></i>&nbsp;Tipo</span>
                                </div>
                                <div class="col-md-4">
                                    <span class="pop" data-toggle="popover" data-placement="top"
                                          title="<i  class='fa fa-arrow-right'></i>&nbsp;Tipo do fator
                                          de impacto (opera&ccedil;&atilde;o)" data-content="H&aacute;
                                          situa&ccedil;&otilde;es em que voc&ecirc; quer converter Horas
                                          de Treinamento, ou outras horas, em Pontos de
                                          Fun&ccedil;&atilde;o baseados no seu hist&oacute;rico e/ou
                                          base de conhecimento. Este tipo de convers&atilde;o pode ser
                                          encontrado no contrato da ANVISA. Mas <strong>aten&ccedil;&atilde;o</strong>,
                                          este tipo de opera&ccedil;&atilde;o &eacute;
                                          aconselh&aacute;vel apenas para o Tipo - Fixo e em Itens
                                          N&atilde;o Mensur&aacute;veis - INM.
                                          <hr> Capacita&ccedil;&atilde;o de usu&aacute;rios no uso de
                                          sistemas de forma presencial ou a dist&acirc;ncia<br /> PF =
                                          QTD HORAS / 2<br /> PF = 40 / 2 = 20PF<br />
                                          <br /> Avalia&ccedil;&atilde;o, instala&ccedil;&atilde;o e
                                          configura&ccedil;&atilde;o de software p&uacute;blicos<br />
                                          PF = QTD HORAS / 3,5<br /> PF = 35 / 3,5 = 10PF
                                          <hr>Fonte <a
                                          href='http://www.comprasnet.gov.br/ConsultaLicitacoes/download/download_editais_detalhe.asp?coduasg=253002&modprp=5&numprp=262014'
                                          target='_blank'>Edital 26.2014</a> &copy; ANVISA - pesquisa
                                          feita em 20/04/2017"><i class="fa fa-info-circle"></i>&nbsp;Operador</span>
                                </div>
                                <div class="col-md-4">
                                    <span class="pop" data-toggle="popover" data-placement="top"
                                          title="<i  class='fa fa-arrow-right'></i>&nbsp;Status do item"
                                          data-content="
                                          <p align='justify'>Durante a inser&ccedil;&atilde;o do Fator
                                          de Impacto voc&ecirc; pode alterar livremente o STATUS, mas
                                          caso voc&ecirc; esteja alterando o Fator, voc&ecirc;
                                          s&oacute; poder&aacute; troc&aacute;-lo clicando no item na
                                          listagem.</p>"><i class="fa fa-info-circle"></i>&nbsp;Situa&ccedil;&atilde;o</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input id="item_roteiro_tipo" type="checkbox"
                                               data-toggle="toggle" data-width="120" data-height="36"
                                               data-onstyle="info" data-offstyle="warning" data-style="slow"
                                               data-on="Ajusta" data-off="Fixo" checked>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input id="item_roteiro_operador" type="checkbox"
                                               data-toggle="toggle" data-width="120" data-height="36"
                                               data-onstyle="info" data-offstyle="warning" data-style="slow"
                                               data-on="Multiplicação" data-off="Divisão" checked
                                               disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input id="item_roteiro_is_ativo" type="checkbox"
                                               data-toggle="toggle" data-width="120" data-height="36"
                                               data-onstyle="success" data-style="slow" data-on="Ativo"
                                               data-off="Inativo" checked>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-8" style="text-align: left;">
                            Legenda:&nbsp;&nbsp;
                            OPERA&Ccedil;&Atilde;O: (I) Inclus&atilde;o, (E)
                            Exclus&atilde;o, (A) Altera&ccedil;&atilde;o e (T)
                            Testes&nbsp;::&nbsp; TIPO: (F) Fixo e (A) Ajuste&nbsp;&nbsp;::&nbsp;&nbsp;(M) Multiplicação e (D) Divisão
                        </div>
                        <div class="col-md-4" style="text-align: right;">
                            <input type="hidden" id="fti_id"> <input type="hidden"
                                                                     id="fti_acao" value="inserir">
                            <div class="btn-group" role="group" aria-label="...">
                                <button type="submit" class="btn btn-success"
                                        id="fti_btn_inserir" onclick="$('#fti_acao').val('inserir');">
                                    <i class="fa fa-save"></i> Salvar
                                </button>
                                <button type="button" class="btn btn-success" id="fti_btn_novo"
                                        disabled>
                                    <i class="fa fa-plus-circle"></i> Inserir outro
                                </button>
                                <button type="submit" class="btn btn-success"
                                        id="fti_btn_atualizar" onclick="$('#fti_acao').val('alterar');"
                                        disabled>
                                    <i class="fa fa-refresh"></i> Atualizar
                                </button>
                                <button type="button" class="btn btn-warning"
                                        id="fti_btn_fechar" onclick="limpaCamposFatorImpacto(true);"
                                        data-dismiss="modal">
                                    <i class="fa fa-times"></i> Fechar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
