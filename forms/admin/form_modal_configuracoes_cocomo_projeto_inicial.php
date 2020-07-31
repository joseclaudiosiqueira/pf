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
<div id="form_modal_configuracoes_cocomo_projeto_inicial" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <form id="form_configuracoes_cocomo_projeto_inicial">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <span id="contagem_h4-modal">&nbsp;&nbsp;<i class="fa fa-cogs"></i>&nbsp;&nbsp;Calibra&ccedil;&atilde;o do Modelo COCOMO II.2000</span><br />
                    <span class="sub-header">Configura&ccedil;&otilde;es do <i>Constructive Cost Model</i> COCOMO II.2000, modelo de estimativa do tempo de desenvolvimento de um software.</span>
                </div>
                <div class="modal-body">
                    <div class="panel">
                        <div class="panel-heading"><strong>Escalas - Multiplicadores de Esfor&ccedil;o</strong> - Projeto Inicial</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3"></div>
                                <div class="col-md-2">Valor padr&atilde;o</div>
                                <div class="col-md-1">Baix&iacute;ssimo</div>
                                <div class="col-md-1">Muito baixo</div>
                                <div class="col-md-1">Baixo</div>
                                <div class="col-md-1">Nominal</div>
                                <div class="col-md-1">Alto</div>
                                <div class="col-md-1">Muito alto</div>
                                <div class="col-md-1">Alt&iacute;ssimo</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"><label><strong>Capacidade do Pessoal/Equite (PERS)</strong></label></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-ED-PERS" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="ED-PERS-XL">Baix&iacute;ssima</option>
                                            <option value="ED-PERS-VL">Muito baixa</option>
                                            <option value="ED-PERS-LO">Baixa</option>
                                            <option value="ED-PERS-NO">Nominal</option>
                                            <option value="ED-PERS-HI">Alta</option>
                                            <option value="ED-PERS-VH">Muito alta</option>
                                            <option value="ED-PERS-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-PERS-XL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-PERS-VL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-PERS-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-PERS-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-PERS-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-PERS-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-PERS-EH" type="text" value="" name="touch-cocomo"></div></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"><label><strong>Confiabilidade e Complexidade do Produto (RCPX)</strong></label></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-ED-RCPX" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="ED-RCPX-XL">Baix&iacute;ssima</option>
                                            <option value="ED-RCPX-VL">Muito baixa</option>
                                            <option value="ED-RCPX-LO">Baixa</option>
                                            <option value="ED-RCPX-NO">Nominal</option>
                                            <option value="ED-RCPX-HI">Alta</option>
                                            <option value="ED-RCPX-VH">Muito alta</option>
                                            <option value="ED-RCPX-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>                                
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-RCPX-XL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-RCPX-VL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-RCPX-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-RCPX-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-RCPX-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-RCPX-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-RCPX-EH" type="text" value="" name="touch-cocomo"></div></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"><label><strong>Dificuldades na plataforma (PDIF)</strong></label></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-ED-PDIF" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="ED-PDIF-LO">Baixa</option>
                                            <option value="ED-PDIF-NO">Nominal</option>
                                            <option value="ED-PDIF-HI">Alta</option>
                                            <option value="ED-PDIF-VH">Muito alta</option>
                                            <option value="ED-PDIF-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>                                  
                                <div class="col-md-1">N/A</div>
                                <div class="col-md-1">N/A</div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-PDIF-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-PDIF-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-PDIF-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-PDIF-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-PDIF-EH" type="text" value="" name="touch-cocomo"></div></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"><label><strong>Experi&ecirc;ncia da Equipe (PREX)</strong></label></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-ED-PREX" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="ED-PREX-XL">Baix&iacute;ssima</option>
                                            <option value="ED-PREX-VL">Muito baixa</option>
                                            <option value="ED-PREX-LO">Baixa</option>
                                            <option value="ED-PREX-NO">Nominal</option>
                                            <option value="ED-PREX-HI">Alta</option>
                                            <option value="ED-PREX-VH">Muito alta</option>
                                            <option value="ED-PREX-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>                                  
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-PREX-XL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-PREX-VL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-PREX-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-PREX-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-PREX-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-PREX-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-PREX-EH" type="text" value="" name="touch-cocomo"></div></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"><label><strong>Facilitadores (FCIL)</strong></label></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-ED-FCIL" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="ED-FCIL-XL">Baix&iacute;ssima</option>
                                            <option value="ED-FCIL-VL">Muito baixa</option>
                                            <option value="ED-FCIL-LO">Baixa</option>
                                            <option value="ED-FCIL-NO">Nominal</option>
                                            <option value="ED-FCIL-HI">Alta</option>
                                            <option value="ED-FCIL-VH">Muito alta</option>
                                            <option value="ED-FCIL-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>                                  
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-FCIL-XL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-FCIL-VL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-FCIL-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-FCIL-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-FCIL-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-FCIL-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-FCIL-EH" type="text" value="" name="touch-cocomo"></div></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"><label><strong>Desenvolvimento para re&uacute;so (RUSE)</strong></label></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-ED-RUSE" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="ED-RUSE-LO">Baixa</option>
                                            <option value="ED-RUSE-NO">Nominal</option>
                                            <option value="ED-RUSE-HI">Alta</option>
                                            <option value="ED-RUSE-VH">Muito alta</option>
                                            <option value="ED-RUSE-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>                                  
                                <div class="col-md-1">N/A</div>
                                <div class="col-md-1">N/A</div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-RUSE-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-RUSE-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-RUSE-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-RUSE-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-RUSE-EH" type="text" value="" name="touch-cocomo"></div></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3"><label><strong>Cronograma de desenvolvimento necess&aacute;rio (SCED)</strong></label></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-ED-SCED" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="ED-SCED-VL">Muito baixa</option>
                                            <option value="ED-SCED-LO">Baixa</option>
                                            <option value="ED-SCED-NO">Nominal</option>
                                            <option value="ED-SCED-HI">Alta</option>
                                            <option value="ED-SCED-VH">Muito alta</option>
                                        </select>
                                    </div>
                                </div>                                  
                                <div class="col-md-1">N/A</div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-SCED-VL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-SCED-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-SCED-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-SCED-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ED-SCED-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1">N/A</div>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>
