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
<div id="form_modal_listar_tarefas_solicitante" class="modal fade" role="dialog">
    <div class="modal-dialog modal-">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                <i class="fa fa-briefcase"></i>&nbsp;&nbsp;Tarefas pendentes que solicitei<br />
                <span class="sub-header">Registro e acompanhamento de tarefas</span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="scroll" style="max-height: 635px; min-height: 635px; overflow-x: hidden; overflow-y: scroll;">
                            <table class="box-table-a" id="tableTarefasSolicitante" width="100%">
                                <thead>
                                    <tr>
                                        <th>Respons&aacute;vel</th>
                                        <th>Descri&ccedil;&atilde;o</th>
                                        <th>Prazos</th>
                                        <th>A&ccedil;&otilde;es</th>
                                    </tr>
                                </thead>                            
                            </table>
                        </div>                            
                    </div>                    
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>



