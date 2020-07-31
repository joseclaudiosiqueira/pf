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
<div id="form_modal_selecionar_cliente" class="modal fade" role="dialog">
    <div class="modal-dialog modal-">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                <i class="fa fa-briefcase"></i>&nbsp;Selecione um Cliente<br />
                <span class="sub-header">Selecione o Cliente e o Roteiro de M&eacute;tricas a ser utilizado e clique no bot&atilde;o [<i class="fa fa-check-circle"></i>&nbsp;Iniciar] para criar uma contagem</span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="scroll" id="addListaCliente" style="min-height: 550px; max-height: 550px; overflow-x: hidden; overflow-y: auto;"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>