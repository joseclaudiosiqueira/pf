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
<div id="form_modal_configuracoes_sistema" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="fechar_contrato" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                <i class="fa fa-cogs"></i>&nbsp;&nbsp;Configura&ccedil;&otilde;es gerais do sistema<br />
                <span class="sub-header">Adequa&ccedil;&atilde;o do Dimension &agrave;s suas necessidades e particularidades</span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <label>
                            Email principal do administrador do sistema
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control input_style" placeholder="fulano@abc.com.br" id="email_administrador">
                        </div>
                    </div>
                </div>        
                <div class="row">
                    <div class="col-md-8">
                        <label>
                            Quantidade m&aacute;xima de caracteres na defini&ccedil;&atilde;o do n&uacute;mero/identificador dos contratos
                        </label>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control input_style" placeholder="Quantidade" maxlength="2" id="quantidade_identificador_contrato">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="sistema_btn_al"><i class="fa fa-check-circle"></i> Atualizar</button>
            </div>            
        </div>
    </div>
</div>