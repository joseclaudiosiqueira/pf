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
<div id="form_modal_configuracoes_tarefas" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content -->
        <div class="modal-content">
            <form id="form_configuracoes_tarefas" role="form">
                <div class="modal-header">
                    <button type="button" id="fechar_configuracoes_tarefas" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <i class="fa fa-tasks"></i>&nbsp;&nbsp;Prazos autom&aacute;ticos das tarefas<br />
                    <span class="sub-header">Defina, de acordo com o seu processo, os tempos em que cada atividade dever&aacute; ser executada</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <span class="badge" style="width: 100%; line-height: 24px;">
                                Atualize nos campos abaixo os prazos autom&aacute;ticos de dura&ccedil;&atilde;o m&eacute;dia das tarefas geradas pelo sistema.<br />
                                Os prazos ser&atilde;o calculados para gerar a data final das tarefas a partir da cria&ccedil;&atilde;o, em dias corridos.<br />
                                Ex.: [AUDITORIA INTERNA] - Cria&ccedil;&atilde;o: 27/01/2015 - Prazo 10 dias - Data Final: 05/02/2015.
                            </span>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>
                                    Valida&ccedil;&otilde;es internas (entre um e dez dias - padr&atilde;o: 5)
                                    <br />
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" class="form-control input_style_spin spinnumber" id="t_validacao_interna" value="" maxlength="2" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>
                                    Valida&ccedil;&otilde;es externas (entre um e vinte dias - padr&atilde;o: 10)
                                    <br />
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" class="form-control input_style_spin spinnumber" id="t_validacao_externa" value="" maxlength="2" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>
                                    Auditorias internas (entre um e vinte dias - padr&atilde;o: 10)
                                    <br />
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" class="form-control input_style_spin spinnumber" id="t_auditoria_interna" value="" maxlength="2" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>
                                    Auditorias externas (entre um e sessenta - padr&atilde;o: 30)
                                    <br />
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" class="form-control input_style_spin spinnumber" id="t_auditoria_externa" value="" maxlength="2" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>
                                    Revis&otilde;es das valida&ccedil;&otilde;es internas (entre um e dez dias - padr&atilde;o: 5)
                                    <br />
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" class="form-control input_style_spin spinnumber" id="t_revisao_validacao_interna" value="" maxlength="2" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>
                                    Revis&otilde;es das valida&ccedil;&otilde;es externas (entre um e dez dias - padr&atilde;o: 5)
                                    <br />
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" class="form-control input_style_spin spinnumber" id="t_revisao_validacao_externa" value="" maxlength="2" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>
                                    Apontes das auditorias internas (entre um e trinta dias - padr&atilde;o: 15)
                                    <br />
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" class="form-control input_style_spin spinnumber" id="t_aponte_auditoria_interna" value="" maxlength="2" required>
                            </div>
                        </div>
                    </div>                     
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>
                                    Apontes das auditorias externas (entre um e trinta dias - padr&atilde;o: 15)
                                    <br />
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" class="form-control input_style_spin spinnumber" id="t_aponte_auditoria_externa" value="" maxlength="2" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>
                                    Atividades de Faturamento (entre cinco e quinze dias - padr&atilde;o: 5)
                                    <br />
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" class="form-control input_style_spin spinnumber" id="t_faturamento" value="" maxlength="2" required>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-3">
                            <div class="form-group" style="text-align:right;">
                                <a href="#"><img class="img-thumbnail" src="" alt="captcha" id="fmctar-img-captcha" onclick="refreshCaptcha($(this), $('#fmctar-txt-captcha'));" data-toggle="tooltip" data-placement="top" title="Clique na imagem para obter outro c&oacute;digo" /></a><br />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><i class="fa fa-dot-circle-o" id="fmctar-i-captcha"></i>&nbsp;<?php echo WORDING_REGISTRATION_CAPTCHA; ?></label>
                                <div class="ui fluid corner labeled input">
                                    <input class="form-control input_style" type="text" id="fmctar-txt-captcha" autocomplete="off" maxlength="4" required />
                                    <div class="ui corner label">
                                        <i class="asterisk icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" id="acoes">
                        <button type="submit" class="btn btn-success" id="btn-atualizar-configuracoes"><i class="fa fa-refresh"></i> Atualizar</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i> Fechar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>