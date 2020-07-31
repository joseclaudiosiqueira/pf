<?php ?>
<div class="panel-default">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default" style="min-height: 373px; max-height: 373px;">
                <div class="panel-title">Selecione a baseline</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12"><select id="contagem_id_baseline" class="form-control input_style"></select></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div  id="menu-funcionalidades" style="margin-top: 10px; width:100%; overflow-x: hidden; overflow-y: scroll; max-height: 226px;" class="scroll"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default" style="min-height: 373px;">
                <div class="panel-title">Complexidade das funcionalidades</div>
                <div class="panel-body">
                    <div class="col-md-3">
                        <table class="table table-striped table-condensed">
                            <tr>
                                <td width="80%">Complex.</td>
                                <td width="20%">Qtd.</td>
                            </tr>
                            <tr>
                                <td>Baixa</td>
                                <td class="info" style="text-align: center; font-weight: bold;"><span id="contagem-complexidade-baixa-baseline"></span></td>
                            </tr>
                            <tr>
                                <td>M&eacute;dia</td>
                                <td class="warning" style="text-align: center; font-weight: bold;"><span id="contagem-complexidade-media-baseline"></span></td>
                            </tr>
                            <tr>
                                <td>Alta</td>
                                <td class="danger" style="text-align: center; font-weight: bold;"><span id="contagem-complexidade-alta-baseline"></span></td>
                            </tr>                                                                                
                            <tr>
                                <td>EF (d/t)</td>
                                <td class="success" style="text-align: center; font-weight: bold;"><span id="contagem-complexidade-ef-baseline"></span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-9">
                        <canvas id="dashboard-grafico-complexidade-funcoes-baseline" height="140"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default" style="min-height: 440px; max-height: 440px;">
                <div class="panel-title"> 
                    Contagens associadas a esta baseline
                    <!--&nbsp;&nbsp.&nbsp;&nbsp;[&nbsp;Privacidade:&nbsp;&nbsp;<i class="fa fa-ban"></i>&nbsp;&nbsp;Privada&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa fa-circle-thin"></i>&nbsp;&nbsp;P&uacute;blica&nbsp;] . <i class="fa fa-angle-double-left"></i> FORNECEDOR <i class="fa fa-angle-double-right"></i>-->
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div style="height: 340px; overflow-x:hidden; overflow-y: scroll; width: 100%;" class="scroll">
                                <table class="box-table-a">
                                    <tbody id="projetosAssociados"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>                        
                </div>
            </div>
        </div>        
        <div class="col-md-4">
            <div class="panel panel-default" style="min-height: 440px;">
                <div class="panel-title">Situa&ccedil;&atilde;o das funcionalidades</div>
                <div class="row">
                    <div class="col-md-12">
                        <canvas id="dashboard-grafico-contagens-situacao-funcoes-baseline" height="200"></canvas>
                    </div>
                </div>
            </div>        
        </div>               
    </div>
    <div class="row">
        <div class="col-md-12"><!--
            <div class="well well-sm">
                <div class="row">
                    <div class="col-md-12">
                        <center><strong>Crie uma an&aacute;lise: selecione uma Baseline ao lado e clique em um dos bot&otilde;es abaixo</strong></center>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="contagem_id_cliente">Cliente</label>
                            <select class="form-control input_style" id="contagem_id_cliente" data-placeholder="Selecione o cliente" disabled></select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="id_contrato">
                                <span class="pop" data-placement="bottom" data-toggle="popover" title="<i class='fa fa-arrow-circle-right'></i>&nbsp;Tipos de contratos" 
                                      data-content="Os contratos podem ser de dois tipos no Dimension&reg;
                                      <ul>
                                      <li>[ I ]nicial (&eacute; o primeiro contrato celebrado);</li>
                                      <li>[ A ]ditivo (contratos adicionais)</li></ul>
                                      IMPORTANTE: durante o cadastro do contrato o Administador define o tipo, sendo que o primeiro &eacute; sempre Inicial">
                                    <i id="w_id_contrato" class="fa fa-dot-circle-o"></i>&nbsp;<i class="fa fa-info-circle"></i>&nbsp;Contrato</span>
                            </label><br />
                            <select class="form-control input_style" id="contagem_id_contrato" disabled>
                                <option value="0">...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="contagem_id_projeto"><i id="w_id_projeto" class="fa fa-dot-circle-o"></i>&nbsp;Projeto</label><br />
                            <select class="form-control input_style" id="contagem_id_projeto" disabled>
                                <option value="0">...</option>
                            </select>
                        </div>
                    </div>            
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group btn-group-justified">
                            <div class="btn-group">
                                <button type="button" class="btn btn-success btn-small criar-contagem" abrangencia="2" disabled><i class="fa fa-plus-circle"></i>&nbsp;Contagem de Projeto</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success btn-small criar-contagem" abrangencia="1" disabled><i class="fa fa-plus-circle"></i>&nbsp;Contagem Livre</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success btn-small criar-contagem" abrangencia="9" disabled><i class="fa fa-plus-circle"></i>&nbsp;Contagem Elementos Funcionais</button>
                            </div>                        
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-3">
                        <center><strong>Ap&oacute;s criar a an&aacute;lise, selecione as fun&ccedil;&otilde;es ao lado e clique na opera&ccedil;&atilde;o</strong></center>
                        <div class="btn-group btn-group-justified">
                            <div class="btn-group">
                                <button type="button" class="btn btn-success btn-small operacao disabled">[&nbsp;A&nbsp;] Alterar</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success btn-small operacao disabled">[&nbsp;E&nbsp;] Excluir</button>
                            </div>
                        </div>
                        <div style="width: 100%;">
                            <br />
                            <p align="justify">
                                Nesta tela &eacute; poss&iacute;vel apenas Alterar e/ou Excluir fun&ccedil;&otilde;es em Baselines. AIEs n&atilde;o podem ser 
                                trabalhados aqui. Crie a Contagem e logo ap&oacute;s edite para efetuar eventuais altera&ccedil;&otilde;es.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="scroll" style="width: 100%; min-height: 250px; max-height: 250px; overflow-x: hidden; overflow-y: scroll;">
                            <table class="table table-condensed table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="10%">Oper.</th>
                                        <th width="50%">Fun&ccedil;&atilde;o</th>
                                        <th width="10%">TD</th>
                                        <th width="10%">AR/TR</th>
                                        <th width="10%">Complex.</th>
                                        <th width="10%">PFb</th>
                                    </tr>
                                </thead>
                                <tbody id="addFuncoes"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>-->
            <div class="row">
                <!-- movido para cima -->
            </div>
        </div>
    </div>
    <div class="row">
        
    </div>
</div>