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
        <i class="fa fa-info-circle fa-lg"></i>&nbsp;&nbsp;Ajustes<br />
        <span class="sub-header">Configure as informa&ccedil;&otilde;es b&aacute;sicas da sua empresa</span>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-3">
                        <strong><a href="#" data-toggle="modal" data-target="#form_modal_inserir_alterar_fornecedor" id="link_alterar_configuracoes_fornecedor"><i class="fa fa-cog"></i>&nbsp;Ajustar</a></strong><br />
                        Defini&ccedil;&otilde;es sobre os contatos administrativos do sistema e inse&ccedil;&atilde;o / altera&ccedil;&atilde;o da logomarca
                    </div>                     
                </div>
            </div>
        </div>
    </div>
</div>