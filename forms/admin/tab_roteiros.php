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
?><div class="panel panel-default">
    <div class="panel-title">
        <i class="fa fa-info-circle fa-lg"></i>&nbsp;&nbsp;Roteiros de m&eacute;tricas<br />
        <span class="sub-header">Personaliza&ccedil;&atilde;o dos roteiros de m&eacute;tricas de contagem</span>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <strong><a href="#" data-toggle="modal" data-target="#form_modal_inserir_alterar_roteiro" id="href_modal_roteiro"><i class="fa fa-sitemap fa-lg"></i>&nbsp;Roteiros de m&eacute;tricas</a></strong><br />
                Inclus&atilde;o e altera&ccedil;&atilde;o de roteiros de m&eacute;tricas
            </div>
            <div class="col-md-4">
                <strong><a href="#" data-toggle="modal" data-target="#form_modal_inserir_alterar_fator_impacto" id="href_modal_fator_impacto"><i class="fa fa-tags fa-lg"></i>&nbsp;Itens de roteiro</a></strong><br />
                Gerenciamento dos itens de roteiro e fatores de ajuste
            </div>
            <!--
            <div class="col-md-4">
                <strong><a href="#" data-toggle="modal" data-target="#form_modal_importar_roteiro" id="href_modal_importar_roteiro"><i class="fa fa-download fa-lg"></i>&nbsp;Importa&ccedil;&atilde;o</a></strong><br />
                Lista roteiros p&uacute;blicos para importa&ccedil;&atilde;o<br />
                Esta funcionalidade ser&aacute; liberada em breve.<br/>
                <script language="JavaScript">
                    SpanId = 'cntdown_importacao'
                    TargetDate = "12/31/2016 08:00 AM";
                    BackColor = null;
                    ForeColor = null;
                    CountActive = true;
                    CountStepper = -1;
                    LeadingZero = true;
                    DisplayFormat = "%%D%% Dias, %%H%% Horas, %%M%% Minutos, %%S%% Segundos.";
                    FinishMessage = "Funcionalidade liberada!";
                </script>
                <script language="JavaScript" src="/pf/js/vendor/countdown.js"></script>                
            </div>-->
        </div>
    </div>
</div>
