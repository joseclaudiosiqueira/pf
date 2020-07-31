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
<div id="form_modal_colar" class="modal fade" role="dialog">
    <input type="hidden" name="tbl-colar" id="tbl-colar" value="">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                <i class="fa fa-check-square-o fa-lg"></i>&nbsp;&nbsp;Valida&ccedil;&otilde;es e confirma&ccedil;&atilde;o<br />
                <span class="sub-header">Inser&ccedil;&atilde;o autom&aacute;tica de funcionalidades por CTRL + C (copiar) e CTRL + V (colar)</span>
            </div>
            <div class="modal-body">
                <div class="row scroll" style="overflow-x: hidden; overflow-y: scroll; ">
                    <div class="col-md-12">
                        <div class="scroll" style="min-height: 545px; max-height: 545px; overflow-x: hidden; overflow-y: auto; width: 100%; border-bottom-left-radius: 8px; border-top-left-radius: 8px;">
                            <table class="box-table-a table table-condensed">
                                <thead>
                                    <tr>
                                        <th width="03%">St.</th>
                                        <th width="05%">Opera&ccedil;&atilde;o</th>
                                        <th width="08%">Fun&ccedil;&atilde;o</th>
                                        <th width="05%">Tipo</th>
                                        <th width="18%">TD</th>
                                        <th width="18%">AR/TR</th>
                                        <th width="05%">Compl.</th>
                                        <th width="05%">PFb</th>
                                        <th width="05%">Mt.</th>
                                        <th width="26%">Observa&ccedil;&otilde;es</th>
                                    </tr>
                                </thead>
                                <tbody id="addPaste"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <button type="button" id="inserir-funcoes-colar" class="btn btn-success"><i class="fa fa-plus-circle fa-lg"></i>&nbsp;Inserir estas funcionalidades</button>
                </div>
            </div>
        </div>
    </div>
</div>