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
<div id="form-modal-listar-itens-roteiro" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                <i class="fa fa-list"></i>&nbsp;&nbsp;Lista itens do roteiro de m&eacute;tricas<br />
                <span class="sub-header">Itens do roteiro selecionado e Fatores de impacto</span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="scroll" style="width:100%; min-height: 535px; max-height:535px; overflow-x: hidden; overflow-y: scroll;">
                            <table class="box-table-a" id="fixRole">
                                <thead>
                                    <tr>
                                        <th width="15%">Sigla</th>
                                        <th width="30%">Descri&ccedil;&atilde;o</th>
                                        <th width="10%">FI</th>
                                        <th width="15%">Fonte</th>
                                        <th width="15%">Opera&ccedil;&atilde;o(&otilde;es)</th>
                                        <th width="15%">Aplic&aacute;vel</th>
                                    </tr>
                                </thead>
                                <tbody id="addItemLista"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                Legenda: I = Inclus&atilde;o; A = Altera&ccedil;&atilde;o; E = Exclus&atilde;o; T = Testes
            </div>
        </div>
    </div>
</div>