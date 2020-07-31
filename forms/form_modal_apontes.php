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
<div id="form_modal_apontes" class="modal fade" role="dialog">
    <form role="form" id="form-aponte">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="fechar-apontes"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <i class="fa fa-comments"></i>&nbsp;&nbsp;Apontes de valida&ccedil;&otilde;es e auditorias<br />
                    <span class="sub-header">Insira suas considera&ccedil;&otilde;es a respeito desta contagem</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="scroll" style="min-height: 575px; max-height: 575px; overflow-x: hidden; overflow-y: auto; width: 100%;">
                                <table width="100%">
                                    <tbody id="addApontes"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input type="hidden" id="aponte-tipo">
                            <input type="hidden" id="aponte-linha">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control input_style scroll" style="width:100%;" placeholder="Novo coment&aacute;rio" id="txtAponte" name="txtAponte" required></textarea>                                       
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <strong><i class="fa fa-lightbulb-o fa-2x"></i>&nbsp;DICAS</strong><br />
                                        <i class="fa fa-arrow-circle-right"></i>&nbsp;Voc&ecirc; pode inserir todos os apontes em forma de um relat&oacute;rio resumido ou um aponte por vez;<br />
                                        <i class="fa fa-arrow-circle-right"></i>&nbsp;Cada vez que Voc&ecirc; insere um aponte, uma tarefa associada ser&aacute; criada;<br />
                                        <i class="fa fa-arrow-circle-right"></i>&nbsp;Especifique a fun&ccedil;&atilde;o que est&aacute; sendo verificada/auditada. <strong><em>Ex.: &quot;ALI - FUNCIONARIO - A quantidade de TRs especificada n&atilde;o est&aacute; de acordo com o modelo de dados apresentado nos aquivos anexos&quot;</em></strong><br />
                                        <i class="fa fa-arrow-circle-right"></i>&nbsp;Para fazer refer&ecirc;ncia a links externos, utilize o bot&atilde;o de inser&ccedil;&atilde;o de links.
                                        OBS.: Poder&aacute; haver inspe&ccedil;&atilde;o autom&aacute;tica de links com vistas a evitar direcionamento para sites maliciosos e caso seja detectada uma irregularidade, o link ser&aacute; removido e o respons&aacute;vel notificado.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Registrar aponte</button>
                </div>
            </div>
        </div>
    </form>
</div>