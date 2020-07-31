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
        <i class="fa fa-info-circle fa-lg"></i>&nbsp;&nbsp;Projetos<br />
        <span class="sub-header">Gerencie os projetos ativos na sua organiza&ccedil;&atilde;o</span>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <strong><a href="#" data-toggle="modal" data-target="#form_modal_projeto" id="fmiapro-link"><i class="fa fa-calendar"></i>&nbsp;Gerenciar</a></strong><br />
                Gestão da inclus&atilde;o e altera&ccedil;&atilde;o dos projetos aplic&aacute;veis &agrave;s contagens
            </div>
        </div>
    </div>
</div>
