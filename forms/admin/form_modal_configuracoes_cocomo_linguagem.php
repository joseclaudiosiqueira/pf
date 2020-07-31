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
<div id="form_modal_configuracoes_cocomo_linguagem" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <form id="form_configuracoes_cocomo_linguagem">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <i class="fa fa-cogs w_calibracao_linguagem"></i>&nbsp;&nbsp;Calibra&ccedil;&atilde;o do Modelo COCOMO II.2000 - Linguagens - UFP-&gt;SLOC<br />
                    <span class="sub-header">Configura&ccedil;&otilde;es do <i>Constructive Cost Model</i> COCOMO II.2000, modelo de estimativa do tempo de desenvolvimento de um software.</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div style="min-height: 550px; max-height: 550px; overflow-x: hidden; overflow-y: scroll; width:100%;" class="scroll">
                                <table class="box-table-a" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="16%">Descri&ccedil;&atilde;o</th>
                                            <th width="12%">HH/PF Baixa</th>
                                            <th width="12%">HH/PF M&eacute;dia</th>
                                            <th width="12%">HH/PF Alta</th>
                                            <th width="12%">UFP-&gt;SLOC</th>
                                            <th width="12%">
                                                <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Fator Tecnologia - FT"
                                                      data-content="<i class='fa fa-lightbulb-o'></i>&nbsp;Melhor prática encontrada<hr>
                                                      Nos projetos de desenvolvimento, após a aplicação das regras contratuais previstas e das medições padrão do CPM e SISP, ainda poderão 
                                                      ser aplicados os Fatores de Tecnologia - FT, conforme tabela exemplificativa a abaixo.
                                                      <table class='table table-condensed table-striped table-bordered' width='100%'>
                                                      <tr><thead><tr><th width='60%'>Tipo de tecnologia</th><th width='40%'>Fator</th></tr></thead>
                                                      <tbody><tr><td>ASP, VB ou .Net</td><td>1,00</td></tr>
                                                      <tr><td>Java e demais tecnologias</td><td>1,15</td></tr>
                                                      <tr><td>SOA/BPM</td><td>1,35</td></tr></tbody></table><br />
                                                      FONTE: <a href='/pf/docs/Edital n 26.2014 - Fabrica de Software - Sara - ANVISA.docx' target='_blank'>Edital n 04.2016 - ANVISA</a>. Todos os direitos reservados."><i class="fa fa-info-circle"></i>&nbsp;Fator Tecnologia</span>
                                            </th>
                                            <th width="8%">
                                                <i id="w_is_ft" class="fa fa-dot-circle-o"></i>&nbsp;Utilizar FT?
                                            </th>
                                            <th width="8%">
                                                <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Altera&ccedil;&atilde;o de status" data-content="Voc&ecirc; pode alterar o status diretamente nas linhas de cada item.">
                                                    <i class="fa fa-info-circle"></i>&nbsp;<i id="w_linguagem_status" class="fa fa-dot-circle-o"></i>&nbsp;Status</span>
                                            </th>
                                            <th width="8%">A&ccedil;&atilde;o</th>
                                        </tr>
                                        <tr style="background-color: #fbcb09;">
                                            <td>
                                                <div class="ui fluid corner labeled input">
                                                    <input id="nova_linguagem" type="text" class="input_style" maxlength="255">
                                                    <div class="ui corner label">
                                                        <i class="asterisk icon"></i>
                                                    </div>
                                                </div>                                                     
                                            </td>
                                            <td>
                                                <div class="ui fluid corner labeled input">
                                                    <input id="baixa" type="text" class="input_style" maxlength="5" data-mask="#.##0.00" data-mask-reverse="true">
                                                    <div class="ui corner label">
                                                        <i class="asterisk icon"></i>
                                                    </div>
                                                </div>                                                         
                                            </td>
                                            <td>
                                                <div class="ui fluid corner labeled input">
                                                    <input id="media" type="text" class="input_style" maxlength="5" data-mask="#.##0.00" data-mask-reverse="true">
                                                    <div class="ui corner label">
                                                        <i class="asterisk icon"></i>
                                                    </div>
                                                </div>                                                         
                                            </td>
                                            <td>
                                                <div class="ui fluid corner labeled input">
                                                    <input id="alta" type="text" class="input_style" maxlength="5" data-mask="#.##0.00" data-mask-reverse="true">
                                                    <div class="ui corner label">
                                                        <i class="asterisk icon"></i>
                                                    </div>
                                                </div>                                                         
                                            </td>
                                            <td>
                                                <div class="ui fluid corner labeled input">
                                                    <input id="sloc" type="text" class="input_style" maxlength="3" data-mask="000">
                                                    <div class="ui corner label">
                                                        <i class="asterisk icon"></i>
                                                    </div>
                                                </div>                                                 
                                            </td>
                                            <td>
                                                <div class="ui fluid corner labeled input">
                                                    <input id="fator_tecnologia" type="text" class="input_style" maxlength="4" data-mask="#.##0.00">
                                                    <div class="ui corner label">
                                                        <i class="asterisk icon"></i>
                                                    </div>
                                                </div>                                                 
                                            </td>
                                            <td>
                                                <input id="is_ft" type="checkbox" data-toggle="toggle" data-onstyle="success" data-style="slow" data-on="Sim" data-off="Não" class="datatoggle" data-width="100" data-height="36">
                                            </td>                                            
                                            <td>
                                                <input id="is_ativo" type="checkbox" data-toggle="toggle" data-onstyle="success" data-style="slow" data-on="Ativo" data-off="Inativo" class="datatoggle" checked data-width="100" data-height="36">
                                            </td>
                                            <td>
                                                <button type="button" id="inserir-linguagem" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Adicionar</button>
                                            </td>
                                        </tr>                                        
                                    </thead>
                                    <tbody id="addLinhaLinguagem"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <strong>ATEN&Ccedil;&Atilde;O</strong>: ao finalizar fa&ccedil;a <i>logoff</i> e <i>login</i> novamente
                </div>
            </form>
        </div>
    </div>
</div>