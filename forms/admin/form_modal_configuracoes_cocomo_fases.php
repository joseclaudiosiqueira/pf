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
<div id="form_modal_configuracoes_cocomo_fases" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <form id="form_configuracoes_cocomo_fases">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <span><i class="fa fa-cogs"></i>&nbsp;&nbsp;Calibra&ccedil;&atilde;o do Modelo COCOMO II.2000</span><br />
                    <span class="sub-header">Configura&ccedil;&otilde;es do <i>Constructive Cost Model</i> COCOMO II.2000, modelo de estimativa do tempo de desenvolvimento de um software.</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12"><strong>Configura&ccedil;&atilde;o de distribui&ccedil;&atilde;o percentual nas fases  e atividades - RUP / COCOMO II.2000</strong></div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-2">Concep&ccedil;&atilde;o</div>
                            <div class="col-md-2">Elabora&ccedil;&atilde;o</div>
                            <div class="col-md-2">Constru&ccedil;&atilde;o</div>
                            <div class="col-md-2">Transi&ccedil;&atilde;o</div>
                            <div class="col-md-1">Totais (%)</div>
                        </div>                    
                        <div class="row">
                            <div class="col-md-3"><label><strong>RUP - Cronograma</strong></label></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="rup-inc-sc" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="rup-ela-sc" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="rup-con-sc" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="rup-tra-sc" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-1"><input type="text" class="form-control input_style" id="total-rup-sc" value="100.00" style="font-weight: bold;" readonly></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><label><strong>RUP - Esfor&ccedil;o</strong></label></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="rup-inc-ef" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="rup-ela-ef" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="rup-con-ef" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="rup-tra-ef" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-1"><input type="text" class="form-control input_style" id="total-rup-ef" value="100.00" style="font-weight: bold;" readonly></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><label><strong>COCOMO II.2000 - Cronograma</strong></label></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="coc-inc-sc" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="coc-ela-sc" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="coc-con-sc" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="coc-tra-sc" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-1"><input type="text" class="form-control input_style" id="total-coc-sc" value="125.00" style="font-weight: bold;" readonly></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><label><strong>COCOMO II.2000 - Esfor&ccedil;o</strong></label></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="coc-inc-ef" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="coc-ela-ef" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="coc-con-ef" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="coc-tra-ef" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-1"><input type="text" class="form-control input_style" id="total-coc-ef" value="118.00" style="font-weight: bold;" readonly></div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3"><label><strong>Gerenciamento</strong></label></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="man-inc" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="man-ela" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="man-con" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="man-tra" type="text" value="" name="touch-cocomo"></div></div>
                        </div>                            
                        <div class="row">
                            <div class="col-md-3"><label><strong>Ambiente / Configura&ccedil;&atilde;o</strong></label></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="env-inc" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="env-ela" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="env-con" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="env-tra" type="text" value="" name="touch-cocomo"></div></div>
                        </div>                            
                        <div class="row">
                            <div class="col-md-3"><label><strong>Requisitos</strong></label></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="req-inc" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="req-ela" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="req-con" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="req-tra" type="text" value="" name="touch-cocomo"></div></div>
                        </div>                            
                        <div class="row">
                            <div class="col-md-3"><label><strong>Design (Projeto)</strong></label></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="des-inc" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="des-ela" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="des-con" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="des-tra" type="text" value="" name="touch-cocomo"></div></div>
                        </div>                            
                        <div class="row">
                            <div class="col-md-3"><label><strong>Implementa&ccedil;&atilde;o</strong></label></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="imp-inc" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="imp-ela" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="imp-con" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="imp-tra" type="text" value="" name="touch-cocomo"></div></div>
                        </div>                            
                        <div class="row">
                            <div class="col-md-3"><label><strong>Testes</strong></label></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="ass-inc" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="ass-ela" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="ass-con" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="ass-tra" type="text" value="" name="touch-cocomo"></div></div>
                        </div>                            
                        <div class="row">
                            <div class="col-md-3"><label><strong>Implanta&ccedil;&atilde;o</strong></label></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="dep-inc" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="dep-ela" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="dep-con" type="text" value="" name="touch-cocomo"></div></div>
                            <div class="col-md-2"><div class="form-group"><input class="form-control input_style_spin" id="dep-tra" type="text" value="" name="touch-cocomo"></div></div>
                        </div>                            
                        <div class="row">
                            <div class="col-md-3"><label><strong>Totais (%)</strong></label></div>
                            <div class="col-md-2"><input type="text" class="form-control input_style" id="total-inc" value="100" style="font-weight: bold;" readonly></div>
                            <div class="col-md-2"><input type="text" class="form-control input_style" id="total-ela" value="100" style="font-weight: bold;" readonly></div>
                            <div class="col-md-2"><input type="text" class="form-control input_style" id="total-con" value="100" style="font-weight: bold;" readonly></div>
                            <div class="col-md-2"><input type="text" class="form-control input_style" id="total-tra" value="100" style="font-weight: bold;" readonly></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>