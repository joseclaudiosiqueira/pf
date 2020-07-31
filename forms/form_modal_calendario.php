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
<div id="form_modal_calendario" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                Calend&aacute;rio com as previs&otilde;es
                <button type="button" id="fechar_calendario" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
            </div>
            <div class="modal-body" style="background-color:#f0f0f0;">
                <div class="row">
                    <div class="col-md-12">
                        <div id="calendario"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>