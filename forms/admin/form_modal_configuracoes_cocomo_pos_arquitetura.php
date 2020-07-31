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
<div id="form_modal_configuracoes_cocomo_pos_arquitetura" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <form id="form_configuracoes_cocomo_esforco">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <span id="contagem_h4-modal"><i class="fa fa-cogs"></i>&nbsp;&nbsp;Calibra&ccedil;&atilde;o do Modelo COCOMO II.2000</span><br />
                    <span class="sub-header">Configura&ccedil;&otilde;es do <i>Constructive Cost Model</i> COCOMO II.2000, modelo de estimativa do tempo de desenvolvimento de um software.</span>
                </div>
                <div class="modal-body">
                    <div class="scroll" style="min-height: 530px; max-height: 530px; overflow-x: hidden; overflow-y: scroll;">
                        <div class="panel-heading"><strong>Escalas - Multiplicadores de Custo</strong> - Pós-Arquitetura</div>
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
                            <div class="col-md-12"><div class="well well-sm"><a href="#" data-toggle="collapse" data-target="#collapseCPLX"><strong>Produto&nbsp;&nbsp;<i class="fa fa-chevron-down"></i></strong></a></div></div>
                        </div>                 
                        <div id="collapseCPLX" class="collapse" style="border:2px dotted #e0e0e0; padding:10px; border-radius:5px; background-color: #f0f0f0;">
                            <div class="well well-sm">
                                <strong>CPLX - Complexidade do produto</strong>   
                            </div>
                            <div class="row">
                                <div class="col-md-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Opera&ccedil;&otilde;es de Controle</strong></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-CPLX-CN" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="CPLX-CN-VL">Muito baixa</option>
                                            <option value="CPLX-CN-LO">Baixa</option>
                                            <option value="CPLX-CN-NO">Nominal</option>
                                            <option value="CPLX-CN-HI">Alta</option>
                                            <option value="CPLX-CN-VH">Muito alta</option>
                                            <option value="CPLX-CN-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-CN-VL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-CN-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-CN-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-CN-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-CN-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-CN-EH" type="text" value="" name="touch-cocomo"></div></div>                                
                            </div>
                            <div class="row">
                                <div class="col-md-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Opera&ccedil;&otilde;es Computacionais</strong></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-CPLX-CO" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="CPLX-CO-VL">Muito baixa</option>
                                            <option value="CPLX-CO-LO">Baixa</option>
                                            <option value="CPLX-CO-NO">Nominal</option>
                                            <option value="CPLX-CO-HI">Alta</option>
                                            <option value="CPLX-CO-VH">Muito alta</option>
                                            <option value="CPLX-CO-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-CO-VL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-CO-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-CO-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-CO-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-CO-VH" type="text" value="" name="touch-cocomo"></div></div>                                
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-CO-EH" type="text" value="" name="touch-cocomo"></div></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Depend&ecirc;ncias <i>Devices</i></strong></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-CPLX-DO" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="CPLX-DO-VL">Muito baixa</option>
                                            <option value="CPLX-DO-LO">Baixa</option>
                                            <option value="CPLX-DO-NO">Nominal</option>
                                            <option value="CPLX-DO-HI">Alta</option>
                                            <option value="CPLX-DO-VH">Muito alta</option>
                                            <option value="CPLX-DO-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-DO-VL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-DO-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-DO-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-DO-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-DO-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-DO-EH" type="text" value="" name="touch-cocomo"></div></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Gerenciamento de dados</strong></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-CPLX-DM" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="CPLX-DM-VL">Muito baixa</option>
                                            <option value="CPLX-DM-LO">Baixa</option>
                                            <option value="CPLX-DM-NO">Nominal</option>
                                            <option value="CPLX-DM-HI">Alta</option>
                                            <option value="CPLX-DM-VH">Muito alta</option>
                                            <option value="CPLX-DM-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-DM-VL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-DM-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-DM-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-DM-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-DM-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-DM-EH" type="text" value="" name="touch-cocomo"></div></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Interface do usu&aacute;rio</strong></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-CPLX-UI" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="CPLX-UI-VL">Muito baixa</option>
                                            <option value="CPLX-UI-LO">Baixa</option>
                                            <option value="CPLX-UI-NO">Nominal</option>
                                            <option value="CPLX-UI-HI">Alta</option>
                                            <option value="CPLX-UI-VH">Muito alta</option>
                                            <option value="CPLX-UI-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>                                
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-UI-VL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-UI-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-UI-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-UI-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-UI-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="CPLX-UI-EH" type="text" value="" name="touch-cocomo"></div></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><label><strong>RELY - Confiabilidade necess&aacute;ria</strong></label></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-RELY" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="RELY-VL">Muito baixa</option>
                                            <option value="RELY-LO">Baixa</option>
                                            <option value="RELY-NO">Nominal</option>
                                            <option value="RELY-HI">Alta</option>
                                            <option value="RELY-VH">Muito alta</option>
                                            <option value="RELY-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>                                   
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="RELY-VL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="RELY-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="RELY-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="RELY-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="RELY-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1">N/A</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><label><strong>DATA - Tamanho da base de dados</strong></label></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-DATA" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="DATA-VL">Muito baixa</option>
                                            <option value="DATA-LO">Baixa</option>
                                            <option value="DATA-NO">Nominal</option>
                                            <option value="DATA-HI">Alta</option>
                                            <option value="DATA-VH">Muito alta</option>
                                            <option value="DATA-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>                                
                                <div class="col-md-1">N/A</div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="DATA-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="DATA-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="DATA-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="DATA-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1">N/A</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><label><strong>RUSE - Re&uacute;so - desenvolvimento para outros projetos</strong></label></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-RUSE" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="RUSE-VL">Muito baixa</option>
                                            <option value="RUSE-LO">Baixa</option>
                                            <option value="RUSE-NO">Nominal</option>
                                            <option value="RUSE-HI">Alta</option>
                                            <option value="RUSE-VH">Muito alta</option>
                                            <option value="RUSE-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>                                  
                                <div class="col-md-1">N/A</div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="RUSE-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="RUSE-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="RUSE-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="RUSE-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="RUSE-EH" type="text" value="" name="touch-cocomo"></div></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><label><strong>DOCU - N&iacute;vel de documenta&ccedil;&atilde;o</strong></label></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-DOCU" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="DOCU-VL">Muito baixa</option>
                                            <option value="DOCU-LO">Baixa</option>
                                            <option value="DOCU-NO">Nominal</option>
                                            <option value="DOCU-HI">Alta</option>
                                            <option value="DOCU-VH">Muito alta</option>
                                            <option value="DOCU-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>                                  
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="DOCU-VL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="DOCU-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="DOCU-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="DOCU-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="DOCU-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1">N/A</div>
                            </div>                                    
                        </div>
                        <div class="row">
                            <div class="col-md-12"><div class="well well-sm"><a href="#" data-toggle="collapse" data-target="#collapsePLAT"><strong>Plataforma&nbsp;&nbsp;<i class="fa fa-chevron-down"></i></strong></a></div></div>
                        </div>                 
                        <div id="collapsePLAT" class="collapse" style="border:2px dotted #e0e0e0; padding:10px; border-radius:5px; background-color: #f0f0f0;">
                            <div class="row">
                                <div class="col-md-4"><label><strong>TIME - Restri&ccedil;&otilde;es e/ou imposi&ccedil;&otilde;es sobre o cronograma</strong></label></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-TIME" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="TIME-VL">Muito baixa</option>
                                            <option value="TIME-LO">Baixa</option>
                                            <option value="TIME-NO">Nominal</option>
                                            <option value="TIME-HI">Alta</option>
                                            <option value="TIME-VH">Muito alta</option>
                                            <option value="TIME-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>                                  
                                <div class="col-md-1">N/A</div>
                                <div class="col-md-1">N/A</div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="TIME-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="TIME-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="TIME-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="TIME-EH" type="text" value="" name="touch-cocomo"></div></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><label><strong>STOR - Grau de restri&ccedil;&atilde;o sobre o consumo de armazenamento</strong></label></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-STOR" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="STOR-VL">Muito baixa</option>
                                            <option value="STOR-LO">Baixa</option>
                                            <option value="STOR-NO">Nominal</option>
                                            <option value="STOR-HI">Alta</option>
                                            <option value="STOR-VH">Muito alta</option>
                                            <option value="STOR-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>                                  
                                <div class="col-md-1">N/A</div>
                                <div class="col-md-1">N/A</div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="STOR-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="STOR-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="STOR-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1">N/A</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><label><strong>PVOL - Volatilidade da plataforma</strong></label></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-PVOL" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="PVOL-VL">Muito baixa</option>
                                            <option value="PVOL-LO">Baixa</option>
                                            <option value="PVOL-NO">Nominal</option>
                                            <option value="PVOL-HI">Alta</option>
                                            <option value="PVOL-VH">Muito alta</option>
                                            <option value="PVOL-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>                                   
                                <div class="col-md-1">N/A</div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PVOL-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PVOL-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PVOL-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PVOL-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1">N/A</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><div class="well well-sm"><a href="#" data-toggle="collapse" data-target="#collapsePERS"><strong>Equipe e Pessoas&nbsp;&nbsp;<i class="fa fa-chevron-down"></i></strong></a></div></div>
                        </div>                 
                        <div id="collapsePERS" class="collapse" style="border:2px dotted #e0e0e0; padding:10px; border-radius:5px; background-color: #f0f0f0;">                             
                            <div class="row">
                                <div class="col-md-4"><label><strong>ACAP - Capacidade dos analistas (requisitos e design)</strong></label></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-ACAP" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="ACAP-VL">Muito baixa</option>
                                            <option value="ACAP-LO">Baixa</option>
                                            <option value="ACAP-NO">Nominal</option>
                                            <option value="ACAP-HI">Alta</option>
                                            <option value="ACAP-VH">Muito alta</option>
                                            <option value="ACAP-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>                                   
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ACAP-VL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ACAP-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ACAP-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ACAP-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="ACAP-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1">N/A</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><label><strong>PCAP - Capacidade dos programadores</strong></label></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-PCAP" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="PCAP-VL">Muito baixa</option>
                                            <option value="PCAP-LO">Baixa</option>
                                            <option value="PCAP-NO">Nominal</option>
                                            <option value="PCAP-HI">Alta</option>
                                            <option value="PCAP-VH">Muito alta</option>
                                            <option value="PCAP-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>                                   
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PCAP-VL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PCAP-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PCAP-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PCAP-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PCAP-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1">N/A</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><label><strong>PCON - Continuidade da equipe (<i>turnover</i>)</strong></label></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-PCON" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="PCON-VL">Muito baixa</option>
                                            <option value="PCON-LO">Baixa</option>
                                            <option value="PCON-NO">Nominal</option>
                                            <option value="PCON-HI">Alta</option>
                                            <option value="PCON-VH">Muito alta</option>
                                            <option value="PCON-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>                                   
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PCON-VL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PCON-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PCON-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PCON-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PCON-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1">N/A</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><label><strong>APEX - Experi&ecirc;ncia da equipe na aplica&ccedil;&atilde;o</strong></label></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-APEX" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="APEX-VL">Muito baixa</option>
                                            <option value="APEX-LO">Baixa</option>
                                            <option value="APEX-NO">Nominal</option>
                                            <option value="APEX-HI">Alta</option>
                                            <option value="APEX-VH">Muito alta</option>
                                            <option value="APEX-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>                                   
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="APEX-VL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="APEX-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="APEX-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="APEX-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="APEX-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1">N/A</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><label><strong>PLEX - Experi&ecirc;ncia na plataforma</strong></label></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-PLEX" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="PLEX-VL">Muito baixa</option>
                                            <option value="PLEX-LO">Baixa</option>
                                            <option value="PLEX-NO">Nominal</option>
                                            <option value="PLEX-HI">Alta</option>
                                            <option value="PLEX-VH">Muito alta</option>
                                            <option value="PLEX-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>                                   
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PLEX-VL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PLEX-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PLEX-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PLEX-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="PLEX-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1">N/A</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><label><strong>LTEX - Experi&ecirc;ncia Linguagem/Ferramentas de desenvolvimento</strong></label></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-LTEX" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="LTEX-VL">Muito baixa</option>
                                            <option value="LTEX-LO">Baixa</option>
                                            <option value="LTEX-NO">Nominal</option>
                                            <option value="LTEX-HI">Alta</option>
                                            <option value="LTEX-VH">Muito alta</option>
                                            <option value="LTEX-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>                                   
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="LTEX-VL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="LTEX-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="LTEX-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="LTEX-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="LTEX-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1">N/A</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><div class="well well-sm"><a href="#" data-toggle="collapse" data-target="#collapsePROJ"><strong>Projeto&nbsp;&nbsp;<i class="fa fa-chevron-down"></i></strong></a></div></div>
                        </div>                 
                        <div id="collapsePROJ" class="collapse" role="tabpanel" aria-labelledby="headingPROJ" style="border:2px dotted #e0e0e0; padding:10px; border-radius:5px; background-color: #f0f0f0;">                             
                            <div class="row">
                                <div class="col-md-4"><label><strong>TOOL - Uso de ferramentas para desenvolvimento</strong></label></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-TOOL" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="TOOL-VL">Muito baixa</option>
                                            <option value="TOOL-LO">Baixa</option>
                                            <option value="TOOL-NO">Nominal</option>
                                            <option value="TOOL-HI">Alta</option>
                                            <option value="TOOL-VH">Muito alta</option>
                                            <option value="TOOL-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>                                 
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="TOOL-VL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="TOOL-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="TOOL-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="TOOL-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="TOOL-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1">N/A</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><label><strong>SITE - Desenvolvimento multisite</strong></label></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-SITE" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="SITE-VL">Muito baixa</option>
                                            <option value="SITE-LO">Baixa</option>
                                            <option value="SITE-NO">Nominal</option>
                                            <option value="SITE-HI">Alta</option>
                                            <option value="SITE-VH">Muito alta</option>
                                            <option value="SITE-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>                                   
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="SITE-VL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="SITE-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="SITE-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="SITE-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="SITE-VH" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="SITE-EH" type="text" value="" name="touch-cocomo"></div></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><label><strong>SCED - Restri&ccedil;&atilde;o no cronograma</strong></label></div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select id="DEF-SCED" class="form-control input_style def-cocomo" name="sel-cocomo">
                                            <option value="SCED-VL">Muito baixa</option>
                                            <option value="SCED-LO">Baixa</option>
                                            <option value="SCED-NO">Nominal</option>
                                            <option value="SCED-HI">Alta</option>
                                            <option value="SCED-VH">Muito alta</option>
                                            <option value="SCED-EH">Alt&iacute;ssima</option>
                                        </select>
                                    </div>
                                </div>                                   
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="SCED-VL" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="SCED-LO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="SCED-NO" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="SCED-HI" type="text" value="" name="touch-cocomo"></div></div>
                                <div class="col-md-1"><div class="form-group"><input class="form-control input_style_spin" id="SCED-VH" type="text" value="" name="touch-cocomo"></div></div>
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