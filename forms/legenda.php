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
<div style="display:inline-block">&nbsp;</div>
<div style="display: inline-block; line-height: 32px;height: 32px;"><img src="/pf/img/bg_nn_16.png" class="img-circle">&nbsp;Inserida</div>&nbsp;&nbsp;
<div style="display: inline-block; line-height: 32px;height: 32px;"><img src="/pf/img/bg_va_16.png" class="img-circle">&nbsp;Validada</div>&nbsp;&nbsp;
<div style="display: inline-block; line-height: 32px;height: 32px;"><img src="/pf/img/bg_nv_16.png" class="img-circle">&nbsp;N&atilde;o validada</div>&nbsp;&nbsp;
<div style="display: inline-block; line-height: 32px;height: 32px;"><img src="/pf/img/bg_mu_16.png" class="img-circle">&nbsp;Em revis&atilde;o</div>&nbsp;&nbsp;
<div style="display: inline-block; line-height: 32px;height: 32px;"><img src="/pf/img/bg_re_16.png" class="img-circle">&nbsp;Revisada</div>&nbsp;&nbsp;
<div style="display: inline-block; line-height: 32px;height: 32px;">
    |&nbsp;&nbsp;<span class="pop" data-placement="bottom" data-toggle="popover" 
          title="<i class='fa fa-arrow-right'></i>&nbsp;Opera&ccedil;&atilde;o"
          data-content="<table class='table table-condensed table-striped' width='100%'>
          <thead>
          <tr><th>Sigla</th><th>Opera&ccedil;&atilde;o</th><th>Aplic&aacute;vel</th></tr></thead>
          <tbody>
          <tr><td>I</td><td>Inclus&atilde;o</td><td>ALI, AIE, EE, SE, CE e N&atilde;o mensur&aacute;veis</td></tr>
          <tr><td>A</td><td>Altera&ccedil;&atilde;o</td><td>ALI, AIE, EE, SE, CE e N&atilde;o mensur&aacute;veis</td></tr>
          <tr><td>E</td><td>Exclus&atilde;o</td><td>ALI, AIE, EE, SE, CE e N&atilde;o mensur&aacute;veis</td></tr>
          <tr><td>T</td><td>Testes</td><td>EE, SE e CE</td></tr>
          <tr><td>N</td><td>Nesma [INDICATIVA]</td><td>ALI, AIE</td></tr></tbody>
          </table>"><i class="fa fa-info-circle"></i>&nbsp;Opera&ccedil;&atilde;o</span>    
</div>
<!--
<div style="display: inline-block; line-height: 32px;height: 32px;">
    |&nbsp;<span class="pop" data-toggle="modal" data-target="#form_modal_help_copiar_colar">
        <i class="fa fa-info-circle"></i>&nbsp;Copiar e Colar</span>&nbsp;&nbsp;
</div>-->

