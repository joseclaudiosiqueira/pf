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
        <i class="fa fa-info-circle fa-lg"></i>&nbsp;&nbsp;Relat&oacute;rios<br />
        <span class="sub-header">Personalize a forma de emiss&atilde;o dos relat&oacute;rios emitidos em .PDF</span>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <strong><a href="#" data-toggle="modal" data-target="#form_modal_relatorios" id="href-modal-relatorios"><i class="fa fa-cogs"></i>&nbsp;Configurar</a></strong><br />
                Defini&ccedil;&atilde;o das logomarcas, cabe&ccedil;alhos e rodap&eacute;s para os relat&oacute;rios dos Clientes
            </div>
        </div>
    </div>
</div>
