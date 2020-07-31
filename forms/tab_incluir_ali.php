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
<div class="panel panel-default">
    <div class="panel-title">
        <i class="fa fa-caret-right fa-lg"></i>&nbsp;&nbsp;Fun&ccedil;&atilde;o de Dados<br />
        <span class="sub-header">Arquivo L&oacute;gico Interno - ALI</span>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row-legenda">
                    <i id="w_ali" class="fa fa-dot-circle-o fa-lg"></i>  
                    <?php include('legenda.php'); ?>
                    &nbsp;&nbsp;<i class="fa fa-ellipsis-v"></i>&nbsp;&nbsp;
                    Selecionado(s):&nbsp;&nbsp;
                    <strong><div id="span-selecionados-ALI" style="display:inline-block;min-width:60px;text-align:right;">0</div></strong>&nbsp;&nbsp;<i class="fa fa-ellipsis-v"></i>&nbsp;&nbsp;&nbsp;&nbsp;
                    <!--
                    <div style="display: inline-block; line-height: 32px;height: 32px;">
                        <span class="pop" data-toggle="modal" data-target="#form_modal_help_copiar_colar">
                            <i class="fa fa-question-circle"></i>&nbsp;Copiar e Colar</span></div>-->
                    <br />
                    <i class="fa fa-sort fa-lg"></i>&nbsp;Ordenar:&nbsp;&nbsp;
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'ali', $('#addALI')[0], 'dados', 'id', 'ASC');">#SEQ</button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'ali', $('#addALI')[0], 'dados', 'data_validacao_interna', 'ASC');">N&atilde;o validadas</button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'ali', $('#addALI')[0], 'dados', 'data_validacao_interna', 'DESC');">Validadas</button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'ali', $('#addALI')[0], 'dados', 'situacao', 'DESC');">A revisar</button>                
                        <button type="button" class="btn btn-default btn-sm" disabled>OP:</button>                
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'ali', $('#addALI')[0], 'dados', 'operacao', 'DESC');"><i class="fa fa-angle-down"></i></button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'ali', $('#addALI')[0], 'dados', 'operacao', 'ASC');"><i class="fa fa-angle-up"></i></button>
                        <button type="button" class="btn btn-default btn-sm" disabled>PFa:</button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'ali', $('#addALI')[0], 'dados', 'pfa', 'DESC');"><i class="fa fa-angle-down"></i></button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'ali', $('#addALI')[0], 'dados', 'pfa', 'ASC');"><i class="fa fa-angle-up"></i></button>
                        <button type="button" class="btn btn-default btn-sm" disabled>Complex.:</button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'ali', $('#addALI')[0], 'dados', 'complexidade', 'DESC');"><i class="fa fa-angle-down"></i></button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'ali', $('#addALI')[0], 'dados', 'complexidade', 'ASC');"><i class="fa fa-angle-up"></i></button>                
                        <button type="button" class="btn btn-default btn-sm" disabled>Entrega</button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'ali', $('#addALI')[0], 'dados', 'entrega', 'DESC');"><i class="fa fa-angle-down"></i></button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'ali', $('#addALI')[0], 'dados', 'entrega', 'ASC');"><i class="fa fa-angle-up"></i></button>                                
                        <button type="button" class="btn btn-success btn-sm btn-pesquisar-funcoes" value="ali" id="btn-pesquisar-ali"><i class="fa fa-search-plus"></i><span class="not-view">&nbsp;Baselines</span></button>&nbsp;&nbsp;
                        <button type="button" class="btn btn-success btn-sm btn-adicionar-indicativa" value="ali" disabled><i class="fa fa-magic"></i><span class="not-view">&nbsp;[INDICATIVA]</span></button>                
                    </div>
                </div>              
            </div>
        </div>
        <div class="container-tabs">
            <div class="table-responsive">
                <table class="box-table-a" id="fixALI">
                    <thead>
                        <tr>
                            <th width="4%" style="padding-top:12px;"><input type="checkbox" class="css-checkbox" id="select-ALI" /><label for="select-ALI" class="css-label-check">#SEQ</label></th>
                            <th width="4%">OP</th>
                            <th width="19%">Fun&ccedil;&atilde;o</th>
                            <th width="3%">TD</th>
                            <th width="3%">TR</th>
                            <th width="6%">Complex.</th>
                            <th width="5%">PFb</th>
                            <th width="26%">Sigla/Fator</th>
                            <th width="5%">PFa</th>
                            <th width="6%">Entrega</th>
                            <!--<th width="15%">Observa&ccedil;&otilde;es</th>-->
                            <th width="21%">
                    <div class="btn-group btn-group-justified">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-info" id="btn_adicionar_ali"><i class="fa fa-plus-circle"></i><span class="not-view">&nbsp;Adicionar</span></button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-info" id="btn_validar_ALI" disabled><i class="fa fa-check-square-o"></i><span class="not-view">&nbsp;Validar</span></button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-info" id="btn_revisar_ALI" disabled><i class="fa fa-clipboard"></i><span class="not-view">&nbsp;Revisar</span></button>
                        </div>
                    </div>                      
                    </th>                        
                    </tr>
                    </thead>
                    <tbody id="addALI"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>