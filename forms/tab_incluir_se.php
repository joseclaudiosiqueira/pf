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
        <i class="fa fa-caret-right fa-lg"></i>&nbsp;&nbsp;Fun&ccedil;&atilde;o de Transa&ccedil;&atilde;o<br />
        <span class="sub-header">Sa&iacute;da Externa - SE</span>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row-legenda">
                    <i id="w_se" class="fa fa-dot-circle-o fa-lg"></i>
                    <?php include('legenda.php'); ?>
                    &nbsp;&nbsp;<i class="fa fa-ellipsis-v"></i>&nbsp;&nbsp;
                    Selecionado(s):&nbsp;&nbsp;
                    <strong><div id="span-selecionados-SE" style="display:inline-block;min-width:60px;text-align:right;">0</div></strong>&nbsp;&nbsp;<i class="fa fa-ellipsis-v"></i>&nbsp;&nbsp;&nbsp;&nbsp;
                    <br />
                    <i class="fa fa-sort fa-lg"></i>&nbsp;Ordenar:&nbsp;&nbsp;
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'se', $('#addSE')[0], 'transacao', 'id', 'ASC');">#SEQ</button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'se', $('#addSE')[0], 'transacao', 'data_validacao_interna', 'ASC');">N&atilde;o validadas</button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'se', $('#addSE')[0], 'transacao', 'data_validacao_interna', 'DESC');">Validadas</button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'se', $('#addSE')[0], 'transacao', 'situacao', 'DESC');">A revisar</button>                
                        <button type="button" class="btn btn-default btn-sm" disabled>OP:</button>                
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'se', $('#addSE')[0], 'transacao', 'operacao', 'DESC');"><i class="fa fa-angle-down"></i></button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'se', $('#addSE')[0], 'transacao', 'operacao', 'ASC');"><i class="fa fa-angle-up"></i></button>
                        <button type="button" class="btn btn-default btn-sm" disabled>PFa:</button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'se', $('#addSE')[0], 'transacao', 'pfa', 'DESC');"><i class="fa fa-angle-down"></i></button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'se', $('#addSE')[0], 'transacao', 'pfa', 'ASC');"><i class="fa fa-angle-up"></i></button>
                        <button type="button" class="btn btn-default btn-sm" disabled>Complex.:</button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'se', $('#addSE')[0], 'transacao', 'complexidade', 'DESC');"><i class="fa fa-angle-down"></i></button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'se', $('#addSE')[0], 'transacao', 'complexidade', 'ASC');"><i class="fa fa-angle-up"></i></button>                
                        <button type="button" class="btn btn-default btn-sm" disabled>Entrega</button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'se', $('#addSE')[0], 'transacao', 'entrega', 'DESC');"><i class="fa fa-angle-down"></i></button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript: listaFuncao(idContagem, 'se', $('#addSE')[0], 'transacao', 'entrega', 'ASC');"><i class="fa fa-angle-up"></i></button>                
                        <button type="button" class="btn btn-success btn-sm btn-pesquisar-funcoes" value="se" id="btn-pesquisar-se"><i class="fa fa-search-plus"></i><span class="not-view">&nbsp;Baselines</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-tabs">
            <div class="table-responsive">
                <table class="box-table-a" id="fixSE">
                    <thead>
                        <tr>
                            <th width="4%" style="padding-top:12px;"><input type="checkbox" class="css-checkbox" id="select-SE" /><label for="select-SE" class="css-label-check">#SEQ</label></th>
                            <th width="4%">OP</th>
                            <th width="19%">Fun&ccedil;&atilde;o</th>
                            <th width="3%">TD</th>
                            <th width="3%">AR</th>
                            <th width="6%">Complex.</th>
                            <th width="5%">PFb</th>
                            <th width="24%">Sigla/Fator</th>
                            <th width="5%">PFa</th>
                            <th width="6%">Entrega</th>
                            <!--<th width="15%">Observa&ccedil;&otilde;es</th>-->
                            <th width="21%">
                    <div class="btn-group btn-group-justified">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-info" id="btn_adicionar_se"><i class="fa fa-plus-circle"></i><span class="not-view">&nbsp;Adicionar</span></button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-info" id="btn_validar_SE" disabled><i class="fa fa-check-square-o"></i><span class="not-view">&nbsp;Validar</span></button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-info" id="btn_revisar_SE" disabled><i class="fa fa-clipboard"></i><span class="not-view">&nbsp;Revisar</span></button>
                        </div>
                    </div>                      
                    </th>    
                    </tr>
                    </thead>
                    <tbody id="addSE"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>