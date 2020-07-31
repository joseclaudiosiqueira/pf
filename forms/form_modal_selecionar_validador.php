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
<div id="form-modal-selecionar-validador" class="modal fade" role="dialog">
    <div class="modal-dialog modal-">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="fechar_validador" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                <i class="fa fa-user-plus"></i>&nbsp;&nbsp;Selecionar um validador<br />
                <span class="sub-header">Valida&ccedil;&atilde;o interna da contagem</span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div style="min-height:519px;max-height:519px;overflow-x:hidden;overflow-y:scroll;width:100%;" class="scroll">
                            <table class="box-table-a" width="100%">
                                <thead>
                                    <tr>
                                        <th>Avatar</th>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <!--<th>Estat&iacute;sticas ( <i class="fa fa-refresh"></i> a cada 24h )</th>-->
                                    </tr>
                                </thead>
                                <tbody id="addValidador"></tbody>
                            </table>
                        </div>  
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <i class="fa fa-lightbulb-o fa-lg"></i>&nbsp;Clique na foto/imagem para selecionar o validador
            </div>            
        </div>
    </div>
</div>