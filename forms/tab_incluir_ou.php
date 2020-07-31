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
        <i class="fa fa-caret-right fa-lg"></i>&nbsp;&nbsp;Outras funcionalidades<br />
        <span class="sub-header">Itens N&atilde;o Mensur&aacute;veis - INM</span>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row-legenda">
                    <i id="w_ou" class="fa fa-dot-circle-o fa-lg"></i>
                    <?php include('legenda.php'); ?>
                    &nbsp;&nbsp;<i class="fa fa-ellipsis-v"></i>&nbsp;&nbsp;
                    Selecionado(s):&nbsp;&nbsp;
                    <strong><div id="span-selecionados-OU" style="display:inline-block;min-width:60px;text-align:right;">0</div></strong>&nbsp;&nbsp;<i class="fa fa-ellipsis-v"></i>
                </div>
            </div>
        </div>
        <div class="container-tabs">
            <div class="table-responsive">
                <table class="box-table-a" id="fixOU">
                    <thead>
                        <tr>
                            <th width="4%" style="padding-top:12px;"><input type="checkbox" class="css-checkbox" id="select-OU" /><label for="select-OU" class="css-label-check">#SEQ</label></th>
                            <th width="4%">OP</th>
                            <th width="31%">Fun&ccedil;&atilde;o / Descri&ccedil;&atilde;o</th>
                            <th width="5%">QTD</th>
                            <th width="5%">PF</th>
                            <th width="21%">Tipo</th>
                            <th width="6%">Entrega</th>
                            <!--<th width="16%">Observa&ccedil;&otilde;es</th>-->
                            <th width="21%">
                    <div class="btn-group btn-group-justified">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-info" id="btn_adicionar_ou"><i class="fa fa-plus-circle"></i><span class="not-view">&nbsp;Adicionar</span></button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-info" id="btn_validar_OU" disabled><i class="fa fa-check-square-o"></i><span class="not-view">&nbsp;Validar</span></button>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-info" id="btn_revisar_OU" disabled><i class="fa fa-clipboard"></i><span class="not-view">&nbsp;Revisar</span></button>
                        </div>
                    </div>                      
                    </th>   
                    </tr>
                    </thead>
                    <tbody id="addOU"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>