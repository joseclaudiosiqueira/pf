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
        <i class="fa fa-info-circle fa-lg"></i>&nbsp;&nbsp;Contratos<br />
        <span class="sub-header">Mantenha seus contratos sempre atualizados</span>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <strong><a href="#" data-toggle="modal" data-target="#form_modal_contrato" id="fmiacon-link"><i class="fa fa-file-text"></i>&nbsp;Gerenciar</a></strong><br />
                Inclus&atilde;o e altera&ccedil;&atilde;o de contratos e aditivos contratuais
            </div>
        </div>
    </div>
</div>

