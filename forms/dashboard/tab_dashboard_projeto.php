<?php ?>
<div class="panel-default">
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default" style="min-height: 370px;">
                <div class="panel-title">Selecione um projeto</div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input id="dashboard-projeto-todos" type="checkbox" data-width="100%" data-height="36" data-toggle="toggle" data-onstyle="info" data-offstyle="default" data-style="slow" data-on="Ativos" data-off="Todos" checked>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <select id="baseline_id_projeto" class="form-control input_style"></select>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default" style="min-height: 370px;">
                <div class="panel-title">
                    Contagens associadas ao projeto
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div style="min-height:275px; max-height:275px;overflow-x:hidden;overflow-y:scroll; width: 100%; color: #000" class="scroll">
                                <table class="box-table-a" width="98%">
                                    <tbody id="contagensAssociadas"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default" style="min-height: 350px;">
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
                                <td class="info" style="text-align: center; font-weight: bold;"><span id="contagem-complexidade-baixa-projeto"></span></td>
                            </tr>
                            <tr>
                                <td>M&eacute;dia</td>
                                <td class="warning" style="text-align: center; font-weight: bold;"><span id="contagem-complexidade-media-projeto"></span></td>
                            </tr>
                            <tr>
                                <td>Alta</td>
                                <td class="danger" style="text-align: center; font-weight: bold;"><span id="contagem-complexidade-alta-projeto"></span></td>
                            </tr>                                                                                
                            <tr>
                                <td>EF (d/t)</td>
                                <td class="success" style="text-align: center; font-weight: bold;"><span id="contagem-complexidade-ef-projeto"></span></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-9">
                        <canvas id="dashboard-grafico-complexidade-funcoes-projeto" height="127"></canvas>
                    </div>
                </div>
            </div>            
        </div>
        <div class="col-md-6">
            <div class="panel panel-default" style="min-height: 350px;">
                <div class="panel-title">Situa&ccedil;&atilde;o das funcionalidades</div>
                <div class="row">
                    <div class="col-md-12">
                        <canvas id="dashboard-grafico-contagens-situacao-funcoes-projeto" height="90"></canvas>
                    </div>
                </div>
            </div>        
        </div>         
    </div>
</div>