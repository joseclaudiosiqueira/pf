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
<div id="form-modal-comparar-contagens" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" id="modal-dialog-comparar-contagens">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="fechar-comparar-contagem" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                <i class="fa fa-list-ul fa-lg"></i>&nbsp;&nbsp;Comparação e Análise de Contagens<br />
                <span class="sub-header">Realize a an&aacute;lise e a compara&ccedil;&atilde;o entre duas contagens para aprimorar o processo de faturamento</span>
            </div>
            <div class="modal-body">
                <div class="row" id="div-compara-contagem" style="border-bottom: 2px dotted #c0c0c0; padding-bottom: 5px;">
                    <div class="col-md-6 scroll" id="col-compara-1" style="min-height: 630px; max-height: 630px; overflow-x: hidden; overflow-y: scroll;">
                        <!--<iframe id="iframe-compara-1" frameborder="0" famespacing="0" class="scroll" style="min-height: 630px; max-height: 630px; width: 100%; overflow-x: hidden; overflow-y: scroll;"></iframe>-->
                    </div>
                    <div class="col-md-6 scroll" id="col-compara-2" style="min-height: 630px; max-height: 630px; overflow-x: hidden; overflow-y: scroll;">
                        <!--<iframe id="iframe-compara-2" frameborder="0" famespacing="0" class="scroll" style="min-height: 630px; max-height: 630px; width: 100%; overflow-x: hidden; overflow-y: scroll;"></iframe>-->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="analise-fiscal-contrato"><h4>Parecer do Fiscal do Contrato em relação a análise e/ou comparação entre as contagens</h4></label>
                            <textarea class="form-control input_style scroll" style="width:100%;" id="analiseFiscalContrato" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <button type="button" class="btn btn-success" onclick="salvarAnaliseFiscalContrato();"><i class="fa fa-check-circle"></i>&nbsp;Salvar análise</button>                
                </div>
            </div>
        </div>
    </div>
</div>