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
<div id="form_modal_configuracoes_cocomo_escala" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <form id="form_configuracoes_cocomo_escala">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <span id="contagem_h4-modal"><i class="fa fa-cogs"></i>&nbsp;&nbsp;Calibra&ccedil;&atilde;o do Modelo COCOMO II.2000</span><br />
                    <span class="sub-header">Configura&ccedil;&otilde;es do <i>Constructive Cost Model</i> COCOMO II.2000, modelo de estimativa do tempo de desenvolvimento de um software.</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <strong>Variáveis de calibra&ccedil;&atilde;o padr&atilde;o do COCOMO II.2000 (A, B, C e D)</strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"><div class="form-group">
                                <label for="COCOMO-A">A</label>
                                <input class="form-control input_style" id="COCOMO-A" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1"><div class="form-group">
                                <label for="COCOMO-B">B</label>
                                <input class="form-control input_style" id="COCOMO-B" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1"><div class="form-group">
                                <label for="COCOMO-C">C</label>
                                <input class="form-control input_style" id="COCOMO-C" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1"><div class="form-group">
                                <label for="COCOMO-D">D</label>
                                <input class="form-control input_style" id="COCOMO-D" type="text" value="" name="touch-cocomo"></div></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <strong>Valores dos Fatores de Escala (SF<sub>j</sub> - COCOMO II.2000)</strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-2">Valor padr&atilde;o</div>
                        <div class="col-md-1">Muito baixo</div>
                        <div class="col-md-1">Baixo</div>
                        <div class="col-md-1">Nominal</div>
                        <div class="col-md-1">Alto</div>
                        <div class="col-md-1">Muito alto</div>
                        <div class="col-md-1">Alt&iacute;ssimo</div>
                    </div>                    
                    <div class="row">
                        <div class="col-md-4"><label><strong>PREC - Preced&ecirc;ncia</strong></label></div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select id="DEF-PREC" class="form-control input_style def-cocomo" name="sel-cocomo">
                                    <option value="PREC-VL">Muito baixa</option>
                                    <option value="PREC-LO">Baixa</option>
                                    <option value="PREC-NO">Nominal</option>
                                    <option value="PREC-HI">Alta</option>
                                    <option value="PREC-VH">Muito alta</option>
                                    <option value="PREC-EH">Alt&iacute;ssima</option>
                                </select>
                            </div>
                        </div>                                
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PREC-VL" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PREC-LO" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PREC-NO" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PREC-HI" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PREC-VH" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1">N/A</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><label><strong>FLEX - Flexibilidade no desenvolvimento</strong></label></div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select id="DEF-FLEX" class="form-control input_style def-cocomo" name="sel-cocomo">
                                    <option value="FLEX-VL">Muito baixa</option>
                                    <option value="FLEX-LO">Baixa</option>
                                    <option value="FLEX-NO">Nominal</option>
                                    <option value="FLEX-HI">Alta</option>
                                    <option value="FLEX-VH">Muito alta</option>
                                    <option value="FLEX-EH">Alt&iacute;ssima</option>
                                </select>
                            </div>
                        </div>                                
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="FLEX-VL" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="FLEX-LO" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="FLEX-NO" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="FLEX-HI" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="FLEX-VH" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1">N/A</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><label><strong>RESL - Arquitetura e Resolu&ccedil;&atilde;o de Riscos</strong></label></div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select id="DEF-RESL" class="form-control input_style def-cocomo" name="sel-cocomo">
                                    <option value="RESL-VL">Muito baixa</option>
                                    <option value="RESL-LO">Baixa</option>
                                    <option value="RESL-NO">Nominal</option>
                                    <option value="RESL-HI">Alta</option>
                                    <option value="RESL-VH">Muito alta</option>
                                    <option value="RESL-EH">Alt&iacute;ssima</option>
                                </select>
                            </div>
                        </div>                                
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="RESL-VL" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="RESL-LO" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="RESL-NO" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="RESL-HI" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="RESL-VH" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1">N/A</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><label><strong>TEAM - Coes&atilde;o da equipe</strong></label></div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select id="DEF-TEAM" class="form-control input_style def-cocomo" name="sel-cocomo">
                                    <option value="TEAM-VL">Muito baixa</option>
                                    <option value="TEAM-LO">Baixa</option>
                                    <option value="TEAM-NO">Nominal</option>
                                    <option value="TEAM-HI">Alta</option>
                                    <option value="TEAM-VH">Muito alta</option>
                                    <option value="TEAM-EH">Alt&iacute;ssima</option>
                                </select>
                            </div>
                        </div>                                
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="TEAM-VL" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="TEAM-LO" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="TEAM-NO" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="TEAM-HI" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="TEAM-VH" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1">N/A</div>
                    </div>                 
                    <div class="row">
                        <div class="col-md-4"><label><strong>PMAT - Maturidade do Processo de Desenvolvimento</strong></label></div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select id="DEF-PMAT" class="form-control input_style def-cocomo" name="sel-cocomo">
                                    <option value="PMAT-VL">Muito baixa</option>
                                    <option value="PMAT-LO">Baixa</option>
                                    <option value="PMAT-NO">Nominal</option>
                                    <option value="PMAT-HI">Alta</option>
                                    <option value="PMAT-VH">Muito alta</option>
                                    <option value="PMAT-EH">Alt&iacute;ssima</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PMAT-VL" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PMAT-LO" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PMAT-NO" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PMAT-HI" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PMAT-VH" type="text" value="" name="touch-cocomo"></div></div>
                        <div class="col-md-1">N/A</div>
                    </div>
                </div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>