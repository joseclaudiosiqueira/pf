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
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-title">
                <!-- Fun&ccedil;&otilde;es de dados/transa&ccedil;&atilde;o e outras funcionalidades</strong><br> -->
                <i class="fa fa-align-justify fa-lg"></i>&nbsp;&nbsp;Estat&iacute;sticas da contagem atual<br />
                <span class="sub-header">Sem a aplica&ccedil;&atilde;o de redutores de cronograma</span>
            </div>
            <div class="panel-body" style="min-height: 282px; max-height: 282px;">
                <div class="table-responsive">
                    <table class="box-table-a" id="estatisticas">                    
                        <thead>
                            <tr>
                                <th data-type="string">Fun&ccedil;&atilde;o</th>
                                <th data-type="number">Qtd.</th>
                                <th data-type="number">PF(b)</th>
                                <th data-type="number" class="col-table">PFa</th>
                                <!--<th data-type="number" class="col-table">
                                    <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i>&nbsp;Formulário Estendido"
                                          data-content="
                                          <i class='fa fa-lightbulb-o fa-lg'></i>&nbsp;Melhor pr&aacute;tica encontrada<hr>
                                          Na ANVISA em seu contrato de F&aacute;brica de Software, que pode ser encontrado <a href='http://www.comprasnet.gov.br/ConsultaLicitacoes/download/download_editais_detalhe.asp?coduasg=253002&modprp=5&numprp=262014' target='_blank'>AQUI</a>, 
                                          o item C.11 - Formul&aacute;rio estendidos de peticionamento ou an&aacute;lise que possu&iacute;rem 75 ou mais campos ser&atilde;o somados PF conforme tabela abaixo.
                                          <table class='box-table-a'><thead><tr><th>Regra</th></thead>
                                          <tbody>
                                          <tr><td>Se 1 &lt;= ALI &lt; 50 <i class='fa fa-angle-double-right'></i> 0PF (n&atilde;o se aplica)</td></tr>
                                          <tr><td>Se 50 &lt;= ALI &lt; 75 <i class='fa fa-angle-double-right'></i> 0PF (n&atilde;o se aplica)</td></tr>
                                          <tr><td>Se 75 &lt;= ALI &lt; 100 <i class='fa fa-angle-double-right'></i> 10PF</td></tr>
                                          <tr><td>Se 100 &lt;= ALI &lt; 150 <i class='fa fa-angle-double-right'></i> 22PF</td></tr>
                                          <tr><td>Se 150 &lt;= ALI &lt; 200 <i class='fa fa-angle-double-right'></i> 42PF</td></tr>
                                          <tr><td>Se 200 &lt;= ALI &lt; 250 <i class='fa fa-angle-double-right'></i> 64PF</td></tr>
                                          <tr><td>Se 250 &lt;= ALI &lt; 300 <i class='fa fa-angle-double-right'></i> 84PF</td></tr>
                                          </tbody>
                                          </table>
                                          Fonte Edital 26.2014 &copy; ANVISA - Em 20/04/2017 - p&aacute;gina 157
                                          "><i class="fa fa-info-circle"></i>&nbsp;FE</span>
                                </th>-->
                                <th data-type="number">Varia&ccedil;&atilde;o</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>&nbsp;&nbsp;ALI</td>
                                <td><span id="qtdALI">0</span></td>
                                <td><span id="pfbALI">0.0000</span></td>
                                <td class="col-table"><strong><span id="pfaALI">0.0000</span></strong>&nbsp;&nbsp;</td>
                                <!--<td class="col-table"></td>-->
                                <td><span id="desALI"><i class="fa fa-circle"></i>&nbsp;&nbsp;&nbsp;0.0000</span>%</td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;AIE</td>
                                <td><span id="qtdAIE">0</span></td>
                                <td><span id="pfbAIE">0.0000</span></td>
                                <td class="col-table"><strong><span id="pfaAIE">0.0000</span></strong>&nbsp;&nbsp;</td>
                                <!--<td class="col-table">-</td>-->
                                <td><span id="desAIE"><i class="fa fa-circle"></i>&nbsp;&nbsp;&nbsp;0.0000</span>%</td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;EE</td>
                                <td><span id="qtdEE">0</span></td>
                                <td><span id="pfbEE">0.0000</span></td>
                                <td class="col-table"><strong><span id="pfaEE">0.0000</span></strong>&nbsp;&nbsp;</td>
                                <!--<td class="col-table">-</td>-->
                                <td><span id="desEE"><i class="fa fa-circle"></i>&nbsp;&nbsp;&nbsp;0.0000</span>%</td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;SE</td>
                                <td><span id="qtdSE">0</span></td>
                                <td><span id="pfbSE">0.0000</span></td>
                                <td class="col-table"><strong><span id="pfaSE">0.0000</span></strong>&nbsp;&nbsp;</td>
                                <!--<td class="col-table">-</td>-->
                                <td><span id="desSE"><i class="fa fa-circle"></i>&nbsp;&nbsp;&nbsp;0.0000</span>%</td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;CE</td>
                                <td><span id="qtdCE">0</span></td>
                                <td><span id="pfbCE">0.0000</span></td>
                                <td class="col-table"><strong><span id="pfaCE">0.0000</span></strong>&nbsp;&nbsp;</td>
                                <!--<td class="col-table">-</td>-->
                                <td><span id="desCE"><i class="fa fa-circle"></i>&nbsp;&nbsp;&nbsp;0.0000</span>%</td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;OU</td>
                                <td><span id="qtdOU">0</span></td>
                                <td>-</td>
                                <td><strong><span id="pfaOU">0.0000</span></strong>&nbsp;&nbsp;</td>
                                <!--<td class="col-table">-</td>-->
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>&nbsp;&nbsp;Total</td>
                                <td></td>
                                <td><span id="totPfb">0.0000</span>&nbsp;&nbsp;</td>
                                <td class="col-table"><strong><span id="totPfa">0.0000</span></strong>&nbsp;&nbsp;</td>
                                <!--<td class="col-table">-</td>-->
                                <td><span id="desvioTotal">0.0000</span>%</td>
                            </tr>              
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-title">
                <i class="fa fa-cogs fa-lg"></i>&nbsp;&nbsp;Tecnologias utilizadas<br>
                <span class="sub-header">Distribui&ccedil;&atilde;o de tecnologias utilizadas na an&aacute;lise</span>
            </div>
            <div class="panel-body scroll" style="min-height: 282px; max-height: 282px; overflow-x: hidden; overflow-y: scroll;">
                <table class="box-table-a" width="100%">
                    <thead>
                        <tr>
                            <th align="center">QTD</th>
                            <th>Tecnologia</th>
                            <th align="right">Fator</th>
                            <th align="right">%</th>
                            <th align="right">PF Local</th>
                        </tr>
                    </thead>
                    <tbody id="tabela_fator_tecnologia"></tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" align="right"><strong>Total PF Local</strong></td>
                            <td align="right"><strong><span id="total-pf-local"></span></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>        
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-title">
                <i class="fa fa-bar-chart fa-lg"></i>&nbsp;&nbsp;Gr&aacute;ficos e tend&ecirc;ncias<br>
                <!--<span class="sub-header">Clique nos <i>links</i> abaixo para visualizar outros gr&aacute;ficos<sup>1</sup></span>-->
                <span class="sub-header">Varia&ccedil;&atilde;o entre os PFa e o PFb na contagem</span>
            </div>
            <div class="panel-body" style="min-height: 282px; max-height: 282px;" id="b_estatisticas">
                <canvas id="chart_variacao" height="175"></canvas>
                <!--
                <ul class="nav nav-pills" id="n_estatisticas">
                    <li class="active"><a data-toggle="tab" href="#tab_variacao">Varia&ccedil;&atilde;o (PFa x PFb)</a></li>
                    <li><a data-toggle="tab" href="#tab_complexidade">Complexidade</a></li>
                    <li><a data-toggle="tab" href="#tab_operacao">Opera&ccedil;&atilde;o</a></li>
                </ul>               
                <div class="tab-content" id="tab_content">
                    <div id="tab_variacao" class="tab-pane fade in active" style="padding-top: 15px;">
                        <canvas id="chart_variacao" height="120"></canvas>
                    </div>
                    <div id="tab_complexidade" class="tab-pane fade in active" style="padding-top: 15px;">
                        <canvas id="chart_complexidade" height="120"></canvas>
                    </div>
                    <div id="tab_operacao" class="tab-pane fade in active" style="padding-top: 15px;">
                        <canvas id="chart_operacao" height="120"></canvas>
                    </div>          
                </div>-->
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-title">
                <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i>&nbsp;Informa&ccedil;&otilde;es" data-content="
                      <i class='fa fa-lightbulb-o'></i>&nbsp;Melhor pr&aacute;tica encontrada<br /><br />
                      <p align='justify'>A equipe do Dimension&reg; encontrou em alguns Guias de Contagens pr&aacute;ticas e considera&ccedil;&otilde;es sobre planejamento e cronogramas.
                      <strong>FONTE</strong>: Roteiro de M&eacute;tricas SISP 2.1 - Dispon&iacute;vel <a href='http://www.sisp.gov.br' target='_new'>AQUI</a></p>">
                    <i class="fa fa-info-circle"></i>&nbsp;Planejamento<br />
                </span><br />
                <span class="sub-header">Previs&otilde;es, planejamento de produtividade, prazos, esfor&ccedil;o e fatores</small>
            </div>
            <div class="panel-body" style="background-color: #fff;">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="previsao_inicio">
                                <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i>&nbsp;Estimativas de data" data-content="<p align='justify'>Insira uma data para a previs&atilde;o de in&iacute;cio. Caso nenhuma data seja informada o sistema inicia o c&aacute;lculo a partir de hoje (<?= date('d/m/Y'); ?>)</p>">
                                    <i class="fa fa-info-circle"></i>&nbsp;In&iacute;cio
                                </span>
                            </label>
                            <input type="text" class="form-control input_style input_calendar" id="previsao_inicio" value="<?= date('d/m/Y'); ?>" data-mask="00/00/0000" readonly/>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="div_previsao_termino">
                                <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i>&nbsp;Estimativas de data" data-content="<p align='justify'>Previs&atilde;o de t&eacute;rmino do projeto com base nos c&aacute;lculos da contagem.</p>">
                                    <i class="fa fa-info-circle"></i>&nbsp;T&eacute;rmino
                                </span>
                            </label><br />
                            <div style="display: inline-block; padding-left: 6px; padding-right: 6px; width: 100%;" class="div-label input_calendar" id="div_previsao_termino"></div>
                        </div>
                    </div>                    
                    <div class="col-md-2">
                        <label>
                            <span class="pop" title="<i class='fa fa-arrow-right'></i>&nbsp;Produtividade Global" data-toggle="popover" data-placement="bottom" 
                                  data-content="<p align='justify'>A produtividade global &eacute; assinalada pelo Administrador do sistema. Caso queira utilizar outro fator de produtividade neste projeto/contagem, assinale a op&ccedil;&atilde;o em [OFF] e insira os novos valores, caso voc&ecirc; tenha permiss&atilde;o.</p>">
                                <i class="fa fa-info-circle"></i>&nbsp;h/PF global?</span></label>                        
                        <div class="form-group">
                            <input type="checkbox" data-toggle="toggle" data-onstyle="success" data-style="slow" id="chk_produtividade_global" class="datatoggle" data-height="36"
                                   <?= $_SESSION['contagem_config']['is_alterar_produtividade_global'] ? '' : 'disabled'; ?> <?= $_SESSION['contagem_config']['is_produtividade_global'] ? 'checked' : ''; ?>>
                            <div style="display: inline-block; padding-left: 6px; padding-right: 6px; min-width: 110px;" class="div-label">h/PF: <strong><span id="produtividade_global"><?= number_format($_SESSION['contagem_config']['produtividade_global'], 2); ?></span></strong></div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label for="chk-produtividade-linguagem">
                            <span class="pop" title="<i class='fa fa-arrow-right'></i>&nbsp;Linguagem e/ou Tipo de Projeto" data-toggle="popover" data-placement="bottom" 
                                  data-content="<p align='justify'><i class='fa fa-lightbulb-o'></i>&nbsp;Melhor pr&aacute;tica encontrada. Produtividade baseada na linguagem ou no tipo de projeto.</p>
                                  <hr>
                                  <p align='justify'>Algumas linguagens tiveram sua produtividade definida por analogia e/ou pesquisa de mercado.
                                  Os projetos devem ser estimados com a produtividade m&eacute;dia.</p>
                                  <hr>
                                  <p><strong>FONTE</strong>:&nbsp;<a href='http://www.pgfn.gov.br/acesso-a-informacao/tecnologia-da-informacao/Roteiro_Contagem_PF_SERPRO_%207.pdf' target='_new'>Roteiro de M&eacute;tricas do SERPRO</a>. P&aacute;g. 19 a 21.</p>">
                                <i class="fa fa-info-circle"></i>&nbsp;h/PF linguagem?</span></label>
                        <div class="form-group">
                            <input type="checkbox" data-toggle="toggle" data-onstyle="success" data-style="slow" id="chk-produtividade-linguagem" data-height="36" disabled>
                            <div style="display: inline-block; padding-left: 6px; padding-right: 6px; min-width: 110px;" class="div-label"><span id="span-produtividade-linguagem">MÉDIA: <strong>12.00</strong></span></div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>
                            <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-circle-right'></i>&nbsp;Produtividade - Escala x Complexidade"
                                  data-content="<p align='justify'>A escala de produtividade da linguagem pode ser inversamente proporcional &agrave; complexidade do projeto/produto, ou seja, 
                                  escala <kbd>Baixa</kbd> para projetos de complexidade <kbd>Alta</kbd> e vice-versa.</p>"><i class="fa fa-info-circle"></i>&nbsp;Escala de produtividade</span></label>
                        <input type="hidden" id="escala-produtividade" value="media">
                        <div class="form-group">
                            <div class="btn-group" role="group" aria-label="...">
                                <button type="button" class="btn btn-default escala" id="escala-baixa" disabled>Baixa<!--&nbsp;<span class="badge badge-info" id="badge-baixa"></span>--></button>
                                <button type="button" class="btn btn-success escala" id="escala-media" disabled>M&eacute;dia<!--&nbsp;<span class="badge badge-info" id="badge-media"></span>--></button>
                                <button type="button" class="btn btn-default escala" id="escala-alta" disabled>Alta<!--&nbsp;<span class="badge badge-info" id="badge-alta"></span>--></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label>
                            <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Fator Tecnologia - FT"
                                  data-content="<i class='fa fa-lightbulb-o'></i>&nbsp;Melhor prática encontrada<hr>
                                  <p align='justify'>Nos projetos de desenvolvimento, ap&oacute;s a aplica&ccedil;&atilde;o das regras contratuais previstas e das medi&ccedil;&otilde;es padr&atilde;o do CPM e SISP, ainda poder&atilde;o 
                                  ser aplicados os Fatores de Tecnologia - FT, conforme tabela exemplificativa a abaixo.</p>
                                  <table class='table table-condensed table-striped table-bordered' width='100%'>
                                  <tr><thead><tr><th width='60%'>Tipo de tecnologia</th><th width='40%'>Fator</th></tr></thead>
                                  <tbody><tr><td>ASP, VB ou .Net</td><td>1,00</td></tr>
                                  <tr><td>Java e demais tecnologias</td><td>1,15</td></tr>
                                  <tr><td>SOA/BPM</td><td>1,35</td></tr></tbody></table>
                                  <p>FONTE: <a href='/pf/docs/Edital n 26.2014 - Fabrica de Software - Sara - ANVISA.docx' target='_blank'>Edital n 04.2016 - ANVISA</a>. Todos os direitos reservados.</p>">
                                <i class="fa fa-info-circle"></i>&nbsp;FT <span style="visibility:hidden;">(<span id="span-ft">1.00</span>)</span></span>
                        </label>
                        <div class="form-group">
                            <input class="form-control" type="checkbox" data-toggle="toggle" data-onstyle="success" data-style="slow" id="chk-ft" data-height="36" disabled>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label>
                            <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Horas L&iacute;quidas Trabalhadas - HLT" data-content="
                                  <p align='justify'>Horas L&iacute;quidas Trabalhadas - HLT &eacute; a quantidade de horas reais dispensadas pelos envolvidos em um projeto 
                                  descontando-se sa&iacute;das/pausas do tipo:</p>
                                  <ol>
                                  <li>Caf&eacute;</li>
                                  <li>Atrasos</li>
                                  <li>Pausa para o fumo</li>
                                  <li>Aprendizado espont&acirc;neo</li>
                                  <li>Reuni&otilde;es fora do contexto do projeto (Diretoria, Gerenciais, Cliente, etc.)</li>
                                  <li>Treinamentos</li></ol>
                                  <p>Defina a quantidade em fra&ccedil;&otilde;es de 0,25 da hora. Ex.: 7.25, 7.50...</p>">
                                <i class="fa fa-info-circle"></i>&nbsp;HLT
                            </span>
                        </label>
                        <div class="form-group">
                            <div style="display: inline-block; padding-left: 6px; padding-right: 6px; min-width: 100px;" class="div-label">
                                <strong>
                                    <span id="hlt"><?= (isset($_GET['ac']) && $_GET['ac'] === 'in') ? number_format($_SESSION['contagem_config']['horas_liquidas_trabalhadas'], 2) : ''; ?></span> horas</strong></div>
                        </div>
                    </div>
                </div>                 
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-title">
                <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i>&nbsp;Informa&ccedil;&otilde;es" data-content="
                      <p align='justify'>Sua empresa n&atilde;o precisa utilizar o processo modelo para a produ&ccedil;&atilde;o de softwares.
                      Este quadro representa apenas uma sugest&atilde;o na distribui&ccedil&atilde;o das fases e se n&atilde;o est&aacute; de 
                      acordo pe&ccedil;a ao Administrador do sitema para configurar os par&acirc;metros do processo de desenvolvimento mais 
                      adequado.</p><hr>
                      <p><strong>FONTE</strong>: Roteiro de M&eacute;tricas SISP 2.1 - Dispon&iacute;vel <a href='http://www.sisp.gov.br' target='_new'>AQUI</a></p>">
                    <i class="fa fa-info-circle"></i>&nbsp;Distribui&ccedil;&atilde;o no Processo Modelo - SISP vers&atilde;o 2.1 e demais vers&otilde;es
                </span><br />
                <span class="sub-header">A distribui&ccedil;&atilde;o abaixo serve apenas para estimativas e faz refer&ecirc;ncia &agrave; contagem como um todo, e n&atilde;o &agrave;s entregas individuais.</span>
            </div>
            <div class="panel-body" style="background-color: #fff;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="box-table-a">
                                <thead>
                                    <tr>
                                        <th>Fases</th>
                                        <th>Pct.</th>
                                        <th>
                                            <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Quantidade de PFa" 
                                                  data-content="<p align='justify'>Esta &eacute; a quantidade de Pontos de Fun&ccedil;&atilde;o ajustados proporcionais ao percentual de cada fase.</p>">
                                                <i class="fa fa-info-circle"></i>&nbsp;PFa</span>
                                        </th>                                      
                                        <th>h/PF</th>
                                        <th>
                                            <span class="pop" data-toggle="popover" title="<i class='fa fa-arrow-right'></i>&nbsp;Quantidade de profissionais" data-content="<p align='justify'>Quantidade de profissionais envolvidos em cada fase do projeto.</p>" data-placement="bottom">
                                                <i class="fa fa-info-circle"></i>&nbsp;Equipe
                                            </span>
                                        </th>
                                        <th><span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Perfis e nomes" 
                                                  data-content="
                                                  <p align='justify'>
                                                  Para efeitos de planejamento voc&ecirc; pode digitar o perfil ou o nome do colaborador que 
                                                  ser&aacute; utilizado na fase. Ex. Analista-Jo&atilde;o, somente Analista ou somente Jo&atilde;o.</p>
                                                  <hr>
                                                  <p align='justify'><strong>ATEN&Ccedil;&Atilde;O</strong>: a quantidade de profissionais somente reduz o cronograma em projetos acima de 100PFa, caso contr&aacute;rio
                                                  utilize os prazos da f&oacute;rmula de Capers Jones.
                                                  </p>
                                                  <hr>
                                                  <div style='text-align: center'><i class='dim_alert'>Para acrescentar outro perfil tecle <&nbsp;ENTER&nbsp;&gt; 
                                                  ou digite uma v&iacute;rgula.</i></div>"><i class="fa fa-info-circle"></i>&nbsp;Perfis/Nomes</span>
                                        </th>
                                        <th>
                                            <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Esfor&ccedil;o <i>versus</i> Dura&ccedil&atilde;o" 
                                                  data-content="
                                                  <p align='justify'>O esfor&ccedil;o, ou trabalho, &eacute; o tempo efetivo em que a tarefa ser&aacute; executada, depende da quantidade de profissionais, 
                                                  produtividade, etc., geralmente &eacute; medida em horas. Dura&ccedil;&atilde;o &eacute; o per&iacute;odo em que uma tarefa ser&aacute; executada, geralmente medida em dias/meses/anos.
                                                  Pode levar em considera&ccedil;&atilde;o os feriados, finais de semana, horas &uacute;teis no dia, etc. P.Ex.: Uma tarefa tem 12 (doze) horas de esfor&ccedil;o e dura&ccedil;&atilde;o de 4 (quatro) dias.
                                                  O Dimension&reg; utiliza a seguinte f&oacute;rmula para calcular o esfor&ccedil;o em horas de uma fase e sua dura&ccedil;&atilde;o em dias:<br />
                                                  <div style='text-align: center;'>
                                                  Esfor&ccedil;o(h) = PFa * h/PF [ 2PFa * 14,5h/PF = 29h ]<br />
                                                  Dura&ccedil;&atilde;o (d) = Esfor&ccedil;o(h) / HLT<sup>1</sup> / Equipe [ 29h / 7,25HLT / 2P = 2d ]
                                                  </div></p>
                                                  <p align='justify'>
                                                  1 - HLT - Horas L&iacute;quidas Trabalhadas, cada HLT equivale a um dia;<br />
                                                  2 - O Dimension&reg; agrega a dura&ccedil;&atilde;o em dia(s) e as casas decimais na <strong>previs&atilde;o</strong> das fases, e arredonda para um dia cheio. Ex. 3.50d = 4.0d</p>">
                                                <i class="fa fa-info-circle"></i>&nbsp;Esfor&ccedil;o(h)<br />Dura&ccedil;&atilde;o(d)</span></th>
                                        <!--<th>Custo</th>-->
                                        <th>
                                            <span class="pop" data-toggle="popover" title="<i class='fa fa-arrow-right'></i>&nbsp;Previs&atilde;o de in&iacute;cio/t&eacute;rmino" 
                                                  data-content="<p>Para calcular a previs&atilde;o de t&eacute;rmino habilite algumas fases clicando no bot&atilde;o ON/OFF ao lado na tabela abaixo. O Dimension&reg; calcula as previs&otilde;es de prazo sempre no m&eacute;todo T&eacute;rmino-In&iacute;cio - TI, sem <i>Leads</i> (antecipa&ccedil;&otilde;es)</i> e <i>Lags</i> (atrasos)</i>.</p>
                                                  <hr>
                                                  <p><strong>Mais informa&ccedil;&otilde;es</strong>: <a href='https://books.google.com.br/books?id=w8WfLeCbdG0C&pg=PA234&lpg=PA234&dq=adiantamentos+e+atrasos+pmp&source=bl&ots=oHVnmeW_dU&sig=e0-uCiSMMpatjBfVBTQqcWN6EeA&hl=pt-BR&sa=X&ved=0ahUKEwi80aOF7dbLAhXGFJAKHXDhC3IQ6AEIHTAA#v=onepage&q=adiantamentos%20e%20atrasos%20pmp&f=false' target='_new'>Google Books</a>. Autor: Maury Mello - Guia de Estudo para o Exame PMP.</p>
                                                  <hr>
                                                  <p><strong>ATEN&Ccedil;&Atilde;O</strong>: As datas s&atilde;o calculadas considerando os finais de semana como dias n&atilde;o &uacute;teis.
                                                  Para efeitos de planejamento voc&ecirc; pode considerar a dura&ccedil;&atilde;o em dias de cada fase e estimar na ferramenta de sua prefer&ecirc;ncia, exportando para .XML e/ou .CSV.</p>" data-placement="bottom">
                                                <i class="fa fa-info-circle"></i>&nbsp;Previs&otilde;es<br />de prazo</span>
                                        </th>
                                        <th>A&ccedil;&atilde;o</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ((isset($_GET['id']) ? $_SESSION['contagem_estatisticas']['is_f_eng'] : $_SESSION['contagem_config']['is_f_eng'])) { ?>
                                        <tr id="tr-f-eng">
                                            <td style="width:12%;"><div id="desc-f-eng"><?= $_SESSION['contagem_config']['desc_f_eng']; ?></div></td>
                                            <td style="width:5%;"><span id="pct-eng"><?= $_SESSION['contagem_config']['pct_f_eng']; ?></span>%</td>
                                            <td style="width:5%"><span id="pct-pfa-eng"></span></td>
                                            <td style="width:6%;white-space:nowrap;"><input type="text" class="form-control input_style prod-fases" id="prod-eng" value="<?= $_SESSION['contagem_config']['is_produtividade_global'] ? number_format($_SESSION['contagem_config']['produtividade_global'], 2) : number_format($_SESSION['contagem_config']['prod_f_eng'], 2); ?>"></td>
                                            <td style="width:6%;white-space:nowrap;"><input type="text" class="form-control input_style" id="prof-eng" value="1"></td>
                                            <td style="width:34%;"><input type="text" class="form-control input_style selectized" id="perf-eng" placeholder="Analista, Desenvolvedor, Testador ou Fulano, Beltrano"></td>
                                            <td style="width:11%;"><span id="esforco-f-eng"></span></td>
                                            <!--<td style="width:8%;"><span id="custo_fase_iniciacao" style="cursor:no-drop;" class="no-select">R$ 3.789,23</span></td>-->
                                            <td style="width:11%;"><span id="previsao-f-eng"></span></td>
                                            <td style="width:8%;">
                                                <input type="checkbox" data-toggle="toggle" data-onstyle="success" data-style="slow" id="chk-eng" data-height="36" checked>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    if ((isset($_GET['id']) ? $_SESSION['contagem_estatisticas']['is_f_des'] : $_SESSION['contagem_config']['is_f_des'])) {
                                        ?>
                                        <tr id="tr-f-des">
                                            <td style="width:12%;"><div id="desc-f-des"><?= $_SESSION['contagem_config']['desc_f_des']; ?></div></td>
                                            <td style="width:5%;"><span id="pct-des"><?= $_SESSION['contagem_config']['pct_f_des']; ?></span>%</td>
                                            <td style="width:5%"><span id="pct-pfa-des"></span></td>
                                            <td style="width:6%;white-space:nowrap;"><input type="text" class="form-control input_style prod-fases" id="prod-des" value="<?= $_SESSION['contagem_config']['is_produtividade_global'] ? number_format($_SESSION['contagem_config']['produtividade_global'], 2) : number_format($_SESSION['contagem_config']['prod_f_des'], 2); ?>"></td>
                                            <td style="width:6%;white-space:nowrap;"><input type="text" class="form-control input_style" id="prof-des" value="1"></td>
                                            <td style="width:34%;"><input type="text" class="form-control input_style selectized" id="perf-des" placeholder="Analista, Desenvolvedor, Testador ou Fulano, Beltrano"></td>
                                            <td style="width:11%;"><span id="esforco-f-des"></span></td>
                                            <td style="width:11%;"><span id="previsao-f-des"></span></td>
                                            <td style="width:8%;">
                                                <input type="checkbox" data-toggle="toggle" data-onstyle="success" data-style="slow" id="chk-des" data-height="36" checked>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    if ((isset($_GET['id']) ? $_SESSION['contagem_estatisticas']['is_f_imp'] : $_SESSION['contagem_config']['is_f_imp'])) {
                                        ?>
                                        <tr id="tr-f-imp">
                                            <td style="width:12%;"><div id="desc-f-imp"><?= $_SESSION['contagem_config']['desc_f_imp']; ?></div></td>
                                            <td style="width:5%;"><span id="pct-imp"><?= $_SESSION['contagem_config']['pct_f_imp']; ?></span>%</td>
                                            <td style="width:5%"><span id="pct-pfa-imp"></span></td>
                                            <td style="width:6%;white-space:nowrap;"><input type="text" class="form-control input_style prod-fases" id="prod-imp" value="<?= $_SESSION['contagem_config']['is_produtividade_global'] ? number_format($_SESSION['contagem_config']['produtividade_global'], 2) : number_format($_SESSION['contagem_config']['prod_f_imp'], 2); ?>"></td>
                                            <td style="width:6%;white-space:nowrap;"><input type="text" class="form-control input_style" id="prof-imp" value="1"></td>
                                            <td style="width:34%;"><input type="text" class="form-control input_style selectized" id="perf-imp" placeholder="Analista, Desenvolvedor, Testador ou Fulano, Beltrano"></td>
                                            <td style="width:11%;"><span id="esforco-f-imp"></span></td>
                                            <td style="width:11%;"><span id="previsao-f-imp"></span></td>
                                            <td style="width:8%;">
                                                <input type="checkbox" data-toggle="toggle" data-onstyle="success" data-style="slow" id="chk-imp" data-height="36" checked>
                                            </td>
                                        </tr>                                    
                                        <?php
                                    }
                                    if ((isset($_GET['id']) ? $_SESSION['contagem_estatisticas']['is_f_tes'] : $_SESSION['contagem_config']['is_f_tes'])) {
                                        ?>                                    
                                        <tr id="tr-f-tes">
                                            <td style="width:12%;"><div id="desc-f-tes"><?= $_SESSION['contagem_config']['desc_f_tes']; ?></div></td>
                                            <td style="width:5%;"><span id="pct-tes"><?= $_SESSION['contagem_config']['pct_f_tes']; ?></span>%</td>
                                            <td style="width:5%"><span id="pct-pfa-tes"></span></td>
                                            <td style="width:6%;white-space:nowrap;"><input type="text" class="form-control input_style prod-fases" id="prod-tes" value="<?= $_SESSION['contagem_config']['is_produtividade_global'] ? number_format($_SESSION['contagem_config']['produtividade_global'], 2) : number_format($_SESSION['contagem_config']['prod_f_tes'], 2); ?>"></td>
                                            <td style="width:6%;white-space:nowrap;"><input type="text" class="form-control input_style" id="prof-tes" value="1"></td>
                                            <td style="width:34%;"><input type="text" class="form-control input_style selectized" id="perf-tes" placeholder="Analista, Desenvolvedor, Testador ou Fulano, Beltrano"></td>
                                            <td style="width:11%;"><span id="esforco-f-tes"></span></td>
                                            <td style="width:11%;"><span id="previsao-f-tes"></span></td>
                                            <td style="width:8%;">
                                                <input type="checkbox" data-toggle="toggle" data-onstyle="success" data-style="slow" id="chk-tes" data-height="36" checked>
                                            </td>
                                        </tr>                                    
                                        <?php
                                    }
                                    if ((isset($_GET['id']) ? $_SESSION['contagem_estatisticas']['is_f_hom'] : $_SESSION['contagem_config']['is_f_hom'])) {
                                        ?>                                    
                                        <tr id="tr-f-hom">
                                            <td style="width:12%;"><div id="desc-f-hom"><?= $_SESSION['contagem_config']['desc_f_hom']; ?></div></td>
                                            <td style="width:5%;"><span id="pct-hom"><?= $_SESSION['contagem_config']['pct_f_hom']; ?></span>%</td>
                                            <td style="width:5%"><span id="pct-pfa-hom"></span></td>
                                            <td style="width:6%;white-space:nowrap;"><input type="text" class="form-control input_style prod-fases" id="prod-hom" value="<?= $_SESSION['contagem_config']['is_produtividade_global'] ? number_format($_SESSION['contagem_config']['produtividade_global'], 2) : number_format($_SESSION['contagem_config']['prod_f_hom'], 2); ?>"></td>
                                            <td style="width:6%;white-space:nowrap;"><input type="text" class="form-control input_style" id="prof-hom" value="1"></td>
                                            <td style="width:34%;"><input type="text" class="form-control input_style selectized" id="perf-hom" placeholder="Analista, Desenvolvedor, Testador ou Fulano, Beltrano"></td>
                                            <td style="width:11%;"><span id="esforco-f-hom"></span></td>
                                            <td style="width:11%;"><span id="previsao-f-hom"></span></td>
                                            <td style="width:8%;">
                                                <input type="checkbox" data-toggle="toggle" data-onstyle="success" data-style="slow" id="chk-hom" data-height="36" checked>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    if ((isset($_GET['id']) ? $_SESSION['contagem_estatisticas']['is_f_impl'] : $_SESSION['contagem_config']['is_f_impl'])) {
                                        ?>                                    
                                        <tr id="tr-f-impl">
                                            <td style="width:12%;"><div id="desc-f-impl"><?= $_SESSION['contagem_config']['desc_f_impl']; ?></div></td>
                                            <td style="width:5%;"><span id="pct-impl"><?= $_SESSION['contagem_config']['pct_f_impl']; ?></span>%</td>
                                            <td style="width:5%"><span id="pct-pfa-impl"></span></td>
                                            <td style="width:6%;white-space:nowrap;"><input type="text" class="form-control input_style prod-fases" id="prod-impl" value="<?= $_SESSION['contagem_config']['is_produtividade_global'] ? number_format($_SESSION['contagem_config']['produtividade_global'], 2) : number_format($_SESSION['contagem_config']['prod_f_impl'], 2); ?>"></td>
                                            <td style="width:6%;white-space:nowrap;"><input type="text" class="form-control input_style" id="prof-impl" value="1"></td>
                                            <td style="width:34%;"><input type="text" class="form-control input_style selectized" id="perf-impl" placeholder="Analista, Desenvolvedor, Testador ou Fulano, Beltrano"></td>
                                            <td style="width:11%;"><span id="esforco-f-impl"></span></td>
                                            <td style="width:11%;"><span id="previsao-f-impl"></span></td>
                                            <td style="width:8%;">
                                                <input type="checkbox" data-toggle="toggle" data-onstyle="success" data-style="slow" id="chk-impl" data-height="36" checked>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <br /><br />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default" style="min-height: 755px;"> <!--  max-height: 632px; -->
            <div class="panel-title">
                <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i>&nbsp;Informa&ccedil;&otilde;es" data-content="
                      <p>
                      O m&eacute;todo utilizado para estimar o prazo no Dimension&reg; &eacute; baseado na f&oacute;rmula de Capers Jones [Jones, 2007], que se baseia
                      no tamanho do projeto em pontos de fun&ccedil;&atilde;o, utilizando o seguinte:<br />
                      <div style='text-align: center;'><strong>Td = V&circ;t</strong></div></p>
                      <p>Onde:<br />
                      <strong>Td</strong>: prazo de desenvolvimento<br />
                      <strong>V</strong>: tamanho do projeto em pontos de fun&ccedil;&atilde;o e<br />
                      <strong>t</strong>: o expoente (t) &eacute; definido com a tabela abaixo</p><hr>
                      <p><strong>FONTE</strong>: Roteiro de M&eacute;tricas SISP 2.1 - Dispon&iacute;vel <a href='http://www.sisp.gov.br' target='_new'>AQUI</a>
                      </p>">
                    <i class="fa fa-info-circle"></i>&nbsp;Estimativa de prazo de desenvolvimento
                </span><br />
                <span class="sub-header">Apesar do c&aacute;lculo ser feito na tabela abaixo, este m&eacute;todo deve ser utilizado para projetos com tamanho acima de 100PFa.
                    Caso n&atilde;o haja dados hist&oacute;ricos de projetos, trabalhe com outras informa&ccedil;&otilde;es e modelos de estimativas.</span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="box-table-a">
                                <thead>
                                    <tr>
                                        <th>Tipo de Sistema</th>
                                        <th>Expoente (t)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width="80%">Sistema Comum - Mainframe (desenvolvimento de sistema com alto grau de reuso ou manuten&ccedil;&atilde;o evolutiva)</td>
                                        <td width="20%">
                                            <div class="form-group">
                                                <input type="radio"name="expoente" class="expoente" onclick="calculaFases();" value="0.32" id="expoente-1" checked>
                                                <label for="expoente-1"><span><span></span></span>&nbsp;&nbsp;0,32</label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio"name="expoente" class="expoente" onclick="calculaFases();" value="0.33" id="expoente-2">
                                                <label for="expoente-2"><span><span></span></span>&nbsp;&nbsp;0,33</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sistema Comum - WEB ou Cliente Servidor</td>
                                        <td>
                                            <div class="form-group">
                                                <input type="radio"name="expoente" class="expoente" onclick="calculaFases();" value="0.34" id="expoente-3">
                                                <label for="expoente-3"><span><span></span></span>&nbsp;&nbsp;0,34</label>
                                            </div>
                                            <div class="form-group">
                                                <input type="radio"name="expoente" class="expoente" onclick="calculaFases();" value="0.35" id="expoente-4">
                                                <label for="expoente-4"><span><span></span></span>&nbsp;&nbsp;0,35</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sistema OO - (se o projeto OO n&atilde;o for novidade para a equipe, n&atilde;o tiver o desenvolvimento de componentes reus&aacute;veis, considerar sistema comum)</td>
                                        <td>
                                            <div class="form-group">
                                                <input type="radio"name="expoente" class="expoente" onclick="calculaFases();" value="0.36" id="expoente-5">
                                                <label for="expoente-5"><span><span></span></span>&nbsp;&nbsp;0,36</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sistema Cliente/Servidor (com alta complexidade arquitetural e integra&ccedil;&atilde;o com outros sistemas)</td>
                                        <td>
                                            <div class="form-group">
                                                <input type="radio"name="expoente" class="expoente" onclick="calculaFases();" value="0.37" id="expoente-6">
                                                <label for="expoente-6"><span><span></span></span>&nbsp;&nbsp;0,37</label>
                                            </div>
                                        </td>
                                    </tr>                                      
                                    <tr>
                                        <td>Sistemas Gerenciais complexos com muitas integra&ccedil;&otilde;es, Datawarehousing, Geoprocessamento, Workflow</td>
                                        <td>
                                            <div class="form-group">
                                                <input type="radio"name="expoente" class="expoente" onclick="calculaFases();" value="0.39" id="expoente-7">
                                                <label for="expoente-7"><span><span></span></span>&nbsp;&nbsp;0,39</label>
                                            </div>
                                        </td>
                                    </tr>                                    
                                    <tr>
                                        <td>Software B&aacute;sico, Frameworks, Sistemas Comerciais</td>
                                        <td>
                                            <div class="form-group">
                                                <input type="radio"name="expoente" class="expoente" onclick="calculaFases();" value="0.40" id="expoente-7">
                                                <label for="expoente-8"><span><span></span></span>&nbsp;&nbsp;0,40</label>
                                            </div>
                                        </td>
                                    </tr>                                      
                                    <tr>
                                        <td>Software Militar (ex: Defesa do Espa&ccedil;o A&eacute;reo)</td>
                                        <td>
                                            <div class="form-group">
                                                <input type="radio"name="expoente" class="expoente" onclick="calculaFases();" value="0.45" id="expoente-9">
                                                <label for="expoente-9"><span><span></span></span>&nbsp;&nbsp;0,45</label>
                                            </div>
                                        </td>
                                    </tr>                                      
                                </tbody>
                            </table>
                            <p style="margin-top: 14px;">
                                <i class="fa fa-lightbulb-o"></i>&nbsp;<strong>DICA (SISP 2.1 e demais vers&otilde;es):</strong> Caso seja necess&aacute;rio receber um projeto com prazo menor que o calculado na tabela ao lado,
                                recomenda-se propor um processo de desenvolvimento incremental, priorizando funcionalidades em cada intera&ccedil;&atilde;o de acordo com a necessidade dele. Lembre-se que a redu&ccedil;&atilde;o m&aacute;xima do Td &eacute; de 25%.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default" style="min-height: 671px;"><!--  max-height: 622px; -->
            <div class="panel-title">
                <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i>&nbsp;Informa&ccedil;&otilde;es" 
                      data-content="<p>
                      O prazo calculado considera as fases selecionadas na tabela de configura&ccedil;&atilde;o. Atente-se para as Horas L&iacute;quidas Trabalhadas - HLT, que interferem
                      no c&aacute;lculo do prazo final (dura&ccedil;&atilde;o).</p><hr>
                      <p><strong>FONTE</strong>: Roteiro de M&eacute;tricas SISP 2.1 e demais vers&otilde;es - Dispon&iacute;vel <a href='http://www.sisp.gov.br' target='_new'>AQUI</a>.
                      </p>">
                    <i class="fa fa-info-circle"></i>&nbsp;Estimativa de Prazo para Projetos menores que 100PFa
                </span><br />
                <span class="sub-header">
                    Considere a produtividade 7h/PFa para projetos de baixa complexidade e 12h/PFa para complexidade m&eacute;dia. Para alta complexidade
                    avalie em conjunto CONTRATANTE e FORNECEDOR.
                </span>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="box-table-a">
                        <thead>
                            <tr>
                                <th rowspan="2">Tamanho do Projeto</th>
                                <th colspan="2">Prazo m&aacute;ximo (em dias &uacute;teis)</th>
                            </tr>
                            <tr>
                                <th>Projetos Complexidade Baixa</th>
                                <th>Projetos Complexidade M&eacute;dia</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="pf0"><td>At&eacute; 10 PFa</td><td>9 dias</td><td>15 dias</td></tr>
                            <tr id="pf1"><td>De 11 PFa a 20 PFa</td><td>18 dias</td><td>30 dias</td></tr>
                            <tr id="pf2"><td>De 21 PFa a 30 PFa</td><td>27 dias</td><td>45 dias</td></tr>
                            <tr id="pf3"><td>De 31 PFa a 40 PFa</td><td>36 dias</td><td>60 dias</td></tr>
                            <tr id="pf4"><td>De 41 PFa a 50 PFa</td><td>45 dias</td><td>75 dias</td></tr>
                            <tr id="pf5"><td>De 51 PFa a 60 PFa</td><td>54 dias</td><td>90 dias</td></tr>
                            <tr id="pf6"><td>De 61 PFa a 70 PFa</td><td>63 dias</td><td>105 dias</td></tr>
                            <tr id="pf7"><td>De 71 PFa a 85 PFa</td><td>70 dias</td><td>110 dias</td></tr>
                            <tr id="pf8"><td>De 86 PFa a 99 PFa</td><td>79 dias</td><td>110 dias</td></tr>
                    </table>
                    <br />
                    <table class="box-table-a">
                        <thead>
                            <tr id="pfx"><th colspan="3"><strong>Para projetos acima de 100PF utilize os c&aacute;lculos abaixo</strong></th></tr>
                        </thead>
                        <tbody>
                            <tr id="pfw">
                                <td colspan="2">
                                    <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Base de c&aacute;lculo PFa" 
                                          data-content="
                                          <p>A base de c&aacute;lculo dos Pontos de Fun&ccedil;&atilde;o ajustados - PFa levam em considera&ccedil;&atilde;o
                                          as fases selecionadas na tabela de previs&otilde;es do projeto/contagem e o fator de Aumento de Esfor&ccedil;o.</p>">
                                        <i class="fa fa-info-circle"></i>&nbsp;Calculado com base em (PFa)</span></td>
                                <td><strong><div style="min-width: 90px;" id="calculado" class="badge"></div></strong></td></tr>
                            <tr id="pfy">
                                <td colspan="2">Prazo &oacute;timo de desenvolvimento</td>
                                <td><strong><div style="min-width: 90px;" id="tempo-desenvolvimento" class="badge"></div></strong> meses</td></tr>
                            <tr id="pfz">
                                <td colspan="2">Regi&atilde;o imposs&iacute;vel</td>
                                <td><strong><div style="min-width: 90px;" id="regiao-impossivel" class="badge"></div></strong> meses</td></tr>
                            <tr id="pfk">
                                <td colspan="2">Prazo com menor custo</td>
                                <td><strong><div style="min-width: 90px;" id="menor-custo" class="badge"></div></strong> meses</td></tr>
                        </tbody>
                    </table>
                </div>                     
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-title">
                <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i>&nbsp;Informa&ccedil;&otilde;es" 
                      data-content="<p>
                      <i class='fa fa-lightbulb-o'></i>&nbsp;Melhores pr&aacute;ticas</p><hr>
                      <p>As estimativas abaixo foram retiradas de roteiros como do SERPRO/RFB, ANEEL e SISP 2.0/2.1 e demais vers&otilde;es, mas notamos que muitos outros &oacute;g&atilde;os utilizam pr&aacute;ticas semelhantes (Dataprev, Banco Central, Banco do Brasil, Caixa Econ&ocirc;mica, etc).<br /><br />
                      O Dimension&reg; calcula com base na <u>produtividade global</u> caso esteja assinalada, ou na <u>produtividade da linguagem</u> caso esteja assinalada, ou ainda com base na produtividade inserida em cada uma das fases do projeto.
                      </p><hr>
                      <p><strong>Mais informa&ccedil;&otilde;es</strong><br />
                      <a href='http://www.desenvolvimentoagil.com.br/scrum/' target='_new'>Desenvolvimento &aacute;gil</a><br />
                      <a href='https://qualidadebr.wordpress.com/2010/11/22/processo-incremental-x-iterativo/' target='_new'>Modelo incremental e interativo</a></p>">
                    <i class="fa fa-info-circle"></i>&nbsp;Estimativas para o projeto - Esfor&ccedil;o, Prazo, Equipe e Custo
                </span><!--<br />
                <span class="sub-header">
                    Estimativas baseadas em melhores pr&aacute;ticas do mercado
                </span>-->
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <!--<div class="ui horizontal divider">
                            Esfor&ccedil;o
                        </div>-->
                        <span class="sub-header">C&aacute;lculo de acordo com os PFa e outros fatores</span>
                    </div>
                    <div class="col-md-5">
                        <!--<div class="ui horizontal divider">
                            Prazo
                        </div>-->
                        <span class="sub-header">Considera&ccedil;&otilde;es sobre redu&ccedil;&atilde;o de cronograma</span>
                    </div>
                    <div class="col-md-4">
                        <!--<div class="ui horizontal divider">
                            Custo
                        </div>-->
                        <span class="sub-header">Estimativas de custo do projeto, do ponto de vista do Contrato</span>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <br />
                        <table width="100%" class="box-table-a">
                            <thead>
                                <tr><th width="40%">Vari&aacute;vel</th>
                                    <th width="30%">Valor (UN/R$)</th>
                                    <th width="30%">
                                        <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Melhor pr&aacute;tica"
                                              data-content="<p>&quot;&Eacute; importante ressaltar que algumas fases contidas em projetos de software devem ser consideradas separadamente, incluindo o esfor&ccedil;o, 
                                              o custo e o prazo associados. (...) Em alguns contratos, por exemplo o contrato com o cliente RFB, a fase de especifica&ccedil;&atilde;o de Requisitos
                                              &eacute; considerada fora do ciclo de vida do software, apenas para finalidade faturamento.&quot; [ROTEIRO DE M&Eacute;TRICAS SERPRO, 2015]</p><hr>
                                              <p>Se voc&ecirc; utiliza Horas de Consultor e/ou Horas de Analistas para algumas das fases, seperadamente da contagem, digite o valor das horas
                                              nos campos correspondentes e tecle [ TAB ] para que o Dimension&reg; calcule o Esfor&ccedil;o, caso contr&aacute;rio deixe em branco.</p><hr>
                                              <p><strong>ATEN&Ccedil;&Atilde;O</strong>: o c&aacute;lculo do tamanho original de PFa leva em conta as fases selecionadas para execu&ccedil;&atilde;o no projeto mais 
                                              os fatores de Criticidade da Solicita&ccedil;&atilde;o de Servi&ccedil;o ou a Compress&atilde;o do Cronograma, se for o caso.</p>">
                                            <i class="fa fa-info-circle"></i>&nbsp;Quantidade</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="height:44px;">
                                    <td>Tamanho (PFa)<span id="span-is-ft"></span></td>
                                    <td></td>
                                    <td><strong><span id="tamanho-pfa"></span></strong></td>
                                </tr>
                                <tr style="height:44px;">
                                    <td>Produtividade (h/Pf)</td>
                                    <td></td>
                                    <td><strong><span id="span-produtividade-media"></span></strong></td>
                                </tr>
                                <tr><td>Hora(s) Perfil Consultor</td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" id="valor-hpc" value="" placeholedr="R$ 0.00" class="form-control input_style money" readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control input_style btn-horas" placeholder="Hora(s)" id="hpc" value="0" data-mask="0000">
                                        </div>                                        
                                    </td>
                                </tr>
                                <tr><td>Hora(s) Perfil Analista</td>
                                    <td>
                                        <input type="text" id="valor-hpa" value="" placeholedr="R$ 0.00" class="form-control input_style money" readonly>
                                    </td>                                    
                                    <td>
                                        <input type="text" class="form-control input_style btn-horas" placeholder="Hora(s)" id="hpa" value="0" data-mask="0000">
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr style="height:44px;">
                                    <td>Esfor&ccedil;o Total (H)</td>
                                    <td></td>
                                    <td><strong><span id="span-esforco-total"></span></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="col-md-5">
                        <br />
                        <small>Selecione o tipo de projeto desta contagem e lembre-se:
                            <ul class="fa-ul">
                                <li><i class="fa fa-arrow-circle-o-right"></i>&nbsp;Redu&ccedil;&atilde;o de 10% => aumento de esfor&ccedil;o de 20%</li>
                                <li><i class="fa fa-arrow-circle-o-right"></i>&nbsp;Redu&ccedil;&atilde;o de 20% => aumento de esfor&ccedil;o de 50%</li>
                                <li><i class="fa fa-arrow-circle-o-right"></i>&nbsp;Redu&ccedil;&atilde;o de 25% => aumento de esfor&ccedil;o de 70%</li>
                            </ul>
                        </small>
                        <center>
                            <div class="btn-group btn-group-justified" role="group" aria-label="...">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-projeto" id="projeto-padrao" value="1"><i class="fa fa-circle-o"></i>&nbsp;Padr&atilde;o</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-info btn-projeto" id="projeto-urgente" value="2"><i class="fa fa-truck"></i>&nbsp;Urgente</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-warning btn-projeto" id="projeto-critico" value="3"><i class="fa fa-exclamation-circle"></i>&nbsp;Cr&iacute;tico</button>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-danger btn-projeto" id="projeto-criticidade" value="4"><i class="fa fa-bomb"></i>&nbsp;Alta Criticidade</button>
                                </div>
                            </div>
                            <input type="hidden" id="tipo-projeto" value="1">
                            <input type="hidden" id="esforco-total" value="0">
                        </center>
                        <center>
                            <strong><div class="well well-sm" id="span-tipo-projeto" style="margin-bottom:5px;">Projeto Padr&atilde;o => 1,00</div></strong>
                        </center>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="chk-solicitacao-servico-critica">O.S. Cr&iacute;tica?&nbsp;&nbsp;</label><br />
                                    <input class="form-control" type="checkbox" data-toggle="toggle" data-onstyle="success" data-style="slow" data-on="Sim" data-off="N&atilde;o" data-width="120" data-height="36" id="chk-solicitacao-servico-critica">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="data-final-projeto">T&eacute;rmino</label>
                                    <div class="div-label" id="data-final-projeto" style="font-weight: bold; text-align: center;"></div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="duracao-projeto">Dura&ccedil;&atilde;o - dia(s)</label>
                                    <div class="div-label" id="duracao-projeto" style="font-weight: bold; text-align: center;"></div>
                                </div>
                            </div>                            
                        </div>
                        <small>
                            <p>
                                Utilize em fun&ccedil;&atilde;o da criticidade e da necessidade de aloca&ccedil;&atilde;o de recursos extras para atendimento da demanda
                                no prazo estipulado pelo Cliente, lembre-se que isto acrescer&aacute; em 35% o esfor&ccedil;o do projeto, e &eacute; aconselh&aacute;vel 
                                uma redu&ccedil;&atilde;o m&aacute;xima de 25% no cronograma.
                            </p>
                        </small>
                    </div>
                    <div class="col-md-4">
                        <br />
                        <small>
                            <p>
                                Em fun&ccedil;&atilde;o da diversidade de c&aacute;lculos de estimativas de custo para os projetos/contagens o Dimension&reg; trabalha apenas com o Valor PF que est&aacute; 
                                estabelecido no cadastramento do Contrato. O valor a ser exibido aqui depende do perfil de acesso do usu&aacute;rio.
                            </p>
                        </small>
                        <center>
                            <div class="well well-sm" style="margin-bottom: 5px;min-height: 75px;vertical-align: middle;"><strong>Custo => R$ <span id="custo-total"></span></strong></div>
                            <input type="hidden" id="valor-pfa-contrato">
                        </center>
                        A f&oacute;rmula para c&aacute;lculo do custo &eacute;: <strong>CP = (HPC + HPA) + QPF x CPF</strong><br /><br/>
                        Onde:<br />
                        <strong>HPC</strong> = Custo das Horas do Perfil Consultor<br />
                        <strong>HPA</strong> = Custo das Horas do Perfil Analista<br />
                        <strong>QPF</strong> = Tamanho do Projeto em PFa - ajustado<br />
                        <strong>CPF</strong> = Custo para implementar um ponto de fun&ccedil;&atilde;o<br /><br />
                        <strong>FONTE</strong>: SISP 2.1 pág. 38 e Roteiro de M&eacute;tricas do SERPRO<br /><br />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-title">
                <span class="pop" data-placement="top" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i>&nbsp;Informa&ccedil;&otilde;es" 
                      data-content="<p>A distribui&ccedil;&atilde;o abaixo pode ser interpretada tanto para um processo incremental e interativo quanto para um processo &aacute;gil.
                      No processo incremental e interativo cada entrega deve ser dividida nas fases correspondentes e no processo &aacute;gil cada sprint deve ser representado pelo seu spint backlog.<br /><br />
                      <strong>ATEN&Ccedil;&Atilde;O</strong><br />
                      Utilize esta tabela de planejamento apenas se o seu projeto for executar 100% das fases do processo modelo. 
                      Esta estimativa leva em conta a m&eacute;dia da produtividade assinalada em h/PF para assinalar o esfor&ccedil;o e a dura&ccedil;&atilde;o de cada entrega/sprint.
                      </p><hr>
                      <p><strong>Mais informa&ccedil;&otilde;es</strong><br />
                      <a href='http://www.desenvolvimentoagil.com.br/scrum/' target='_new'>Desenvolvimento &aacute;gil</a><br />
                      <a href='https://qualidadebr.wordpress.com/2010/11/22/processo-incremental-x-iterativo/' target='_new'>Modelo incremental e interativo</a></p>">
                    <i class="fa fa-info-circle"></i>&nbsp;Distribui&ccedil;&atilde;o de acordo com as entregas/sprints previstos
                </span><br />
                <span class="sub-header">
                    <sup>1</sup> As horas de Perfil Consultor e Perfil Analista est&atilde;o distribu&iacute;das entre as entregas do projeto. Desta forma voc&ecirc; pode planejar o desembolso pelo total da entrega.<br />
                </span>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="table-responsive scroll" style="max-height: 330px; overflow-x: hidden; overflow-y: scroll">
                            <table class="box-table-a">
                                <thead>
                                    <tr>
                                        <th><span data-toggle="tooltip" class="pop" data-placement="right" title="Considere a sequ&ecirc;ncia como uma Entrega ou um Sprint"><i class="fa fa-info-circle"></i>&nbsp;Seq.</span></th>
                                        <th width="40%">Fun&ccedil;&otilde;es</th>
                                        <th align="right">PFa</th>
                                        <th align="right">% do total</th>
                                        <th align="right">Esfor&ccedil;o (h)</th>
                                        <th align="right">Dura&ccedil;&atilde;o (d)</th>
                                        <th align="right">Desembolso<sup>1</sup></th>
                                    </tr>
                                </thead>
                                <tbody id="tblEntregas"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <canvas id="chart_entregas" height="130"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

