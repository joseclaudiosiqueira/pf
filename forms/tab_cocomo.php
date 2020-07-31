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
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-title">
                <i class="fa fa-caret-right fa-lg"></i>&nbsp;&nbsp;COCOMO II - 2000 - Constructive Cost Model<br />
                <span class="sub-header">Informa&ccedil;&otilde;es b&aacute;sicas do projeto de contagem</span>
            </div>
            <div class="panel-body" style="min-height: 215px;">
                <div class="row">
                    <div class="col-md-3">
                        <label for="coc-ufp">Pontos de Fun&ccedil;&atilde;o<br />N&atilde;o-Ajustados</label>
                        <div class="input_style" id="coc-ufp"></div>
                    </div>
                    <div class="col-md-6">
                        <label for="coc-lng">Linguagem<br />1PFb =&gt; <span id="coc-sloc-conversao"></span>SLOC</label>
                        <div class="input_style" id="coc-lng"></div>
                    </div>
                    <div class="col-md-3">
                        <label for="tipo-calculo">Selecione o m&eacute;todo<br />de c&aacute;lculo</label>
                        <div>
                            <input type="checkbox" data-toggle="toggle" data-onstyle="success" data-style="slow" id="tipo-calculo" data-on="P&oacute;s Arquitetura" data-off="Projeto Inicial" data-width="150" data-height="36">
                        </div>
                    </div>                    
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        Constantes de calibra&ccedil;&atilde;o do modelo
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <label for="COCOMO-A">
                            <a href="#" id="OR-COCOMO-A" class="or-cocomo" value="<?= number_format(getConfigCocomo('COCOMO_A'), 2); ?>"
                               data-toggle="tooltip" data-placement="top" title="Recuperar o valor original"><i class="fa fa-history"></i>&nbsp;A</a></label>
                        <div class="form-group">
                            <input class="form-control input_style_spin" id="COCOMO-A" type="text" value="<?= number_format(getConfigCocomo('COCOMO_A'), 2); ?>" name="touch-cocomo"></div>
                    </div>
                    <div class="col-md-3">
                        <label for="COCOMO-B">
                            <a href="#" id="OR-COCOMO-B" class="or-cocomo" value="<?= number_format(getConfigCocomo('COCOMO_B'), 2); ?>"
                               data-toggle="tooltip" data-placement="top" title="Recuperar o valor original"><i class="fa fa-history"></i>&nbsp;B</a></label>
                        <div class="form-group">
                            <input class="form-control input_style_spin" id="COCOMO-B" type="text" value="<?= number_format(getConfigCocomo('COCOMO_B'), 2); ?>" name="touch-cocomo"></div>                        
                    </div>
                    <div class="col-md-3">
                        <label for="COCOMO-C">
                            <a href="#" id="OR-COCOMO-C" class="or-cocomo" value="<?= number_format(getConfigCocomo('COCOMO_C'), 2); ?>"
                               data-toggle="tooltip" data-placement="top" title="Recuperar o valor original"><i class="fa fa-history"></i>&nbsp;C</a></label>
                        <div class="form-group">
                            <input class="form-control input_style_spin" id="COCOMO-C" type="text" value="<?= number_format(getConfigCocomo('COCOMO_C'), 2); ?>" name="touch-cocomo"></div> 
                    </div>
                    <div class="col-md-3">
                        <label for="COCOMO-D">
                            <a href="#" id="OR-COCOMO-D" class="or-cocomo" value="<?= number_format(getConfigCocomo('COCOMO_D'), 2); ?>"
                               data-toggle="tooltip" data-placement="top" title="Recuperar o valor original"><i class="fa fa-history"></i>&nbsp;D</a></label>
                        <div class="form-group">
                            <input class="form-control input_style_spin" id="COCOMO-D" type="text" value="<?= number_format(getConfigCocomo('COCOMO_D'), 2); ?>" name="touch-cocomo"></div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-title">
                <i class="fa fa-caret-right fa-lg"></i>&nbsp;&nbsp;C&aacute;lculos iniciais<br />
                <span class="sub-header">C&aacute;lculos padr&atilde;o do modelo</span>
            </div>
            <div class="panel-body" style="min-height: 215px;">
                <div class="row">
                    <div class="col-md-3">
                        <label for="coc-esforco">Esfor&ccedil;o<br />PM -&gt; Pessoas/M&ecirc;s</label>
                        <div class="input_style" id="coc-esforco"></div></div>                    
                    <div class="col-md-3">
                        <label for="coc-cronograma">Cronograma<br />M -&gt; Meses</label>
                        <div class="input_style" id="coc-cronograma"></div></div>
                    <div class="col-md-3">
                        <label for="coc-custo">Custo por pessoa padrão<br />
                            <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Custo por pessoa no Dimension&reg;"
                                  data-content="O Dimension calcula o Custo por Pessoa baseado no valor do PF estabelecido no contrato.
                                  O c&aacute;lculo &eacute; feito desta forma para evitar distor&ccedil;&otilde;es no planejamento de custos.
                                  Utilizamos a seguinte f&oacute;rmula:<br /><br />
                                  CT = TPFa * VPF<br />
                                  M = [(TPFa * P) / HLT] / 21<br />
                                  PM = CT / M<br />
                                  <hr>
                                  <strong>ONDE:</strong><br />
                                  <table class='table table-condensed table-striped'>
                                  <thead>
                                  <tr>
                                  <th>Vari&aacute;vel</th>
                                  <th>Descri&ccedil;&atilde;o</th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <tr><td>CT</td><td>Custo Total do projeto</td></tr>
                                  <tr><td>M</td><td>Dura&ccedil;&atilde;o do projeto em meses</td></tr>
                                  <tr><td>PM</td><td>Custo / pessoa / m&ecirc;s (<i>Person Months - PM)</i></td></tr>
                                  <tr><td>TPFa</td><td>Total de pontos de fun&ccedil;&atilde;o ajustados</td></tr>
                                  <tr><td>VPF</td><td>Valor do ponto de fun&ccedil;&atilde;o no contrato</td></tr>
                                  <tr><td>P</td><td>Produtividade (HH/PF)</td></tr>
                                  <tr><td>HLT</td><td>Horas L&iacute;quidas Trabalhadas</td></tr>
                                  <tr><td>DU = 21</td><td>Constante de dias úteis no m&ecirc;s</td></tr>
                                  </tbody>
                                  </table>">
                                <i class="fa fa-info-circle"></i>&nbsp;R$&nbsp;<span id="coc-custo-pessoa">0.00</span></span>
                        </label>
                        <div class="input_style" id="coc-custo"></div>
                    </div>                 
                    <div class="col-md-3">
                        <label for="coc-sloc">SLOC<br />Source Lines of Code </label>
                        <div class="input_style" id="coc-sloc"></div>
                    </div>              
                </div>
            </div>
        </div>        
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-title">
        <i class="fa fa-caret-right fa-lg"></i>&nbsp;&nbsp;Vari&aacute;veis padr&atilde;o do sistema para os c&aacute;lculos<br />
        <span class="sub-header">Direcionadores do Tamanho do Software</span>
    </div>
    <div class="panel-body">
        <div class="panel-group" id="accordion-cocomo">
            <div class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion-cocomo" href="#collapse-cocomo-pos-arquitetura">
                    <i class="fa fa-chevron-down"></i>&nbsp;P&oacute;s Arquitetura</a>
            </div>
            <div id="collapse-cocomo-pos-arquitetura" class="panel-collapse collapse">
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-1">Muito baixo</div>
                    <div class="col-md-1">Baixo</div>
                    <div class="col-md-1">Nominal</div>
                    <div class="col-md-1">Alto</div>
                    <div class="col-md-1">Muito alto</div>
                    <div class="col-md-1">Alt&iacute;ssimo</div>
                </div>
                <div class="row">
                    <div class="col-md-12"><div class="well well-sm"><strong>Direcionadores de Escala do Software</strong></div></div>
                </div>                        
                <div class="row" id="dotted">
                    <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Preced&ecirc;ncia/Similaridade com outros projetos (PREC)</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PREC" id="PREC-VL" value="<?= number_format(getConfigCocomo('PREC_VL'), 2); ?>" <?= getConfigCocomo('DEF_PREC') === 'PREC-VL' ? 'checked' : ''; ?>><label for="PREC-VL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PREC" id="PREC-LO" value="<?= number_format(getConfigCocomo('PREC_LO'), 2); ?>" <?= getConfigCocomo('DEF_PREC') === 'PREC-LO' ? 'checked' : ''; ?>><label for="PREC-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PREC" id="PREC-NO" value="<?= number_format(getConfigCocomo('PREC_NO'), 2); ?>" <?= getConfigCocomo('DEF_PREC') === 'PREC-NO' ? 'checked' : ''; ?>><label for="PREC-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PREC" id="PREC-HI" value="<?= number_format(getConfigCocomo('PREC_HI'), 2); ?>" <?= getConfigCocomo('DEF_PREC') === 'PREC-HI' ? 'checked' : ''; ?>><label for="PREC-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PREC" id="PREC-VH" value="<?= number_format(getConfigCocomo('PREC_VH'), 2); ?>" <?= getConfigCocomo('DEF_PREC') === 'PREC-VH' ? 'checked' : ''; ?>><label for="PREC-VH"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PREC" id="PREC-EH" value="<?= number_format(getConfigCocomo('PREC_EH'), 2); ?>" <?= getConfigCocomo('DEF_PREC') === 'PREC-EH' ? 'checked' : ''; ?>><label for="PREC-EH"><span><span></span></span></label></div>
                </div>
                <div class="row" id="dotted">
                    <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Flexibilidade de Desenvolvimento(FLEX)</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="FLEX" id="FLEX-VL" value="<?= number_format(getConfigCocomo('FLEX_VL'), 2); ?>" <?= getConfigCocomo('DEF_FLEX') === 'FLEX-VL' ? 'checked' : ''; ?>><label for="FLEX-VL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="FLEX" id="FLEX-LO" value="<?= number_format(getConfigCocomo('FLEX_LO'), 2); ?>" <?= getConfigCocomo('DEF_FLEX') === 'FLEX-LO' ? 'checked' : ''; ?>><label for="FLEX-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="FLEX" id="FLEX-NO" value="<?= number_format(getConfigCocomo('FLEX_NO'), 2); ?>" <?= getConfigCocomo('DEF_FLEX') === 'FLEX-NO' ? 'checked' : ''; ?>><label for="FLEX-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="FLEX" id="FLEX-HI" value="<?= number_format(getConfigCocomo('FLEX_HI'), 2); ?>" <?= getConfigCocomo('DEF_FLEX') === 'FLEX-HI' ? 'checked' : ''; ?>><label for="FLEX-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="FLEX" id="FLEX-VH" value="<?= number_format(getConfigCocomo('FLEX_VH'), 2); ?>" <?= getConfigCocomo('DEF_FLEX') === 'FLEX-VH' ? 'checked' : ''; ?>><label for="FLEX-VH"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="FLEX" id="FLEX-EH" value="<?= number_format(getConfigCocomo('FLEX_EH'), 2); ?>" <?= getConfigCocomo('DEF_FLEX') === 'FLEX-EH' ? 'checked' : ''; ?>><label for="FLEX-EH"><span><span></span></span></label></div>
                </div>
                <div class="row" id="dotted">
                    <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Arquitetura / Resolu&ccedil;&atilde;o de Riscos (RESL)</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="RESL" id="RESL-VL" value="<?= number_format(getConfigCocomo('RESL_VL'), 2); ?>" <?= getConfigCocomo('DEF_RESL') === 'RESL-VL' ? 'checked' : ''; ?>><label for="RESL-VL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="RESL" id="RESL-LO" value="<?= number_format(getConfigCocomo('RESL_LO'), 2); ?>" <?= getConfigCocomo('DEF_RESL') === 'RESL-LO' ? 'checked' : ''; ?>><label for="RESL-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="RESL" id="RESL-NO" value="<?= number_format(getConfigCocomo('RESL_NO'), 2); ?>" <?= getConfigCocomo('DEF_RESL') === 'RESL-NO' ? 'checked' : ''; ?>><label for="RESL-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="RESL" id="RESL-HI" value="<?= number_format(getConfigCocomo('RESL_HI'), 2); ?>" <?= getConfigCocomo('DEF_RESL') === 'RESL-HI' ? 'checked' : ''; ?>><label for="RESL-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="RESL" id="RESL-VH" value="<?= number_format(getConfigCocomo('RESL_VH'), 2); ?>" <?= getConfigCocomo('DEF_RESL') === 'RESL-VH' ? 'checked' : ''; ?>><label for="RESL-VH"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="RESL" id="RESL-EH" value="<?= number_format(getConfigCocomo('RESL_EH'), 2); ?>" <?= getConfigCocomo('DEF_RESL') === 'RESL-EH' ? 'checked' : ''; ?>><label for="RESL-EH"><span><span></span></span></label></div>
                </div>
                <div class="row" id="dotted">
                    <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Coes&atilde;o da Equipe (TEAM)</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="TEAM" id="TEAM-VL" value="<?= number_format(getConfigCocomo('TEAM_VL'), 2); ?>" <?= getConfigCocomo('DEF_TEAM') === 'TEAM-VL' ? 'checked' : ''; ?>><label for="TEAM-VL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="TEAM" id="TEAM-LO" value="<?= number_format(getConfigCocomo('TEAM_LO'), 2); ?>" <?= getConfigCocomo('DEF_TEAM') === 'TEAM-LO' ? 'checked' : ''; ?>><label for="TEAM-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="TEAM" id="TEAM-NO" value="<?= number_format(getConfigCocomo('TEAM_NO'), 2); ?>" <?= getConfigCocomo('DEF_TEAM') === 'TEAM-NO' ? 'checked' : ''; ?>><label for="TEAM-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="TEAM" id="TEAM-HI" value="<?= number_format(getConfigCocomo('TEAM_HI'), 2); ?>" <?= getConfigCocomo('DEF_TEAM') === 'TEAM-HI' ? 'checked' : ''; ?>><label for="TEAM-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="TEAM" id="TEAM-VH" value="<?= number_format(getConfigCocomo('TEAM_VH'), 2); ?>" <?= getConfigCocomo('DEF_TEAM') === 'TEAM-VH' ? 'checked' : ''; ?>><label for="TEAM-VH"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="TEAM" id="TEAM-EH" value="<?= number_format(getConfigCocomo('TEAM_EH'), 2); ?>" <?= getConfigCocomo('DEF_TEAM') === 'TEAM-EH' ? 'checked' : ''; ?>><label for="TEAM-EH"><span><span></span></span></label></div>
                </div>
                <div class="row" id="dotted">
                    <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Maturidade do Processo de Desenvolvimento (PMAT)</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PMAT" id="PMAT-VL" value="<?= number_format(getConfigCocomo('PMAT_VL'), 2); ?>" <?= getConfigCocomo('DEF_PMAT') === 'PMAT-VL' ? 'checked' : ''; ?>><label for="PMAT-VL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PMAT" id="PMAT-LO" value="<?= number_format(getConfigCocomo('PMAT_LO'), 2); ?>" <?= getConfigCocomo('DEF_PMAT') === 'PMAT-LO' ? 'checked' : ''; ?>><label for="PMAT-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PMAT" id="PMAT-NO" value="<?= number_format(getConfigCocomo('PMAT_NO'), 2); ?>" <?= getConfigCocomo('DEF_PMAT') === 'PMAT-NO' ? 'checked' : ''; ?>><label for="PMAT-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PMAT" id="PMAT-HI" value="<?= number_format(getConfigCocomo('PMAT_HI'), 2); ?>" <?= getConfigCocomo('DEF_PMAT') === 'PMAT-HI' ? 'checked' : ''; ?>><label for="PMAT-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PMAT" id="PMAT-VH" value="<?= number_format(getConfigCocomo('PMAT_VH'), 2); ?>" <?= getConfigCocomo('DEF_PMAT') === 'PMAT-VH' ? 'checked' : ''; ?>><label for="PMAT-VH"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PMAT" id="PMAT-EH" value="<?= number_format(getConfigCocomo('PMAT_EH'), 2); ?>" <?= getConfigCocomo('DEF_PMAT') === 'PMAT-EH' ? 'checked' : ''; ?>><label for="PMAT-EH"><span><span></span></span></label></div>
                </div>
                <div class="row">
                    <div class="col-md-12"><div class="well well-sm"><strong>Direcionadores de Esfor&ccedil;o e Custo</strong></div></div>
                </div>
                <div class="row">
                    <div class="col-md-12"><div class="well well-sm"><strong>Produto de Software</strong></div></div>
                </div>                
                <div class="row" id="dotted">
                    <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Grau de Confian&ccedil;a (RELY)</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="RELY" id="RELY-VL" value="<?= number_format(getConfigCocomo('RELY_VL'), 2); ?>" <?= getConfigCocomo('DEF_RELY') === 'RELY-VL' ? 'checked' : ''; ?>><label for="RELY-VL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="RELY" id="RELY-LO" value="<?= number_format(getConfigCocomo('RELY_LO'), 2); ?>" <?= getConfigCocomo('DEF_RELY') === 'RELY-LO' ? 'checked' : ''; ?>><label for="RELY-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="RELY" id="RELY-NO" value="<?= number_format(getConfigCocomo('RELY_NO'), 2); ?>" <?= getConfigCocomo('DEF_RELY') === 'RELY-NO' ? 'checked' : ''; ?>><label for="RELY-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="RELY" id="RELY-HI" value="<?= number_format(getConfigCocomo('RELY_HI'), 2); ?>" <?= getConfigCocomo('DEF_RELY') === 'RELY-HI' ? 'checked' : ''; ?>><label for="RELY-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="RELY" id="RELY-VH" value="<?= number_format(getConfigCocomo('RELY_VH'), 2); ?>" <?= getConfigCocomo('DEF_RELY') === 'RELY-VH' ? 'checked' : ''; ?>><label for="RELY-VH"><span><span></span></span></label></div>
                    <div class="col-md-1">N/A</div>
                </div>
                <div class="row" id="dotted">
                    <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tamanho da Base de Dados (DATA)</div>
                    <div class="col-md-1">N/A</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="DATA" id="DATA-LO" value="<?= number_format(getConfigCocomo('DATA_LO'), 2); ?>" <?= getConfigCocomo('DEF_DATA') === 'DATA-LO' ? 'checked' : ''; ?>><label for="DATA-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="DATA" id="DATA-NO" value="<?= number_format(getConfigCocomo('DATA_NO'), 2); ?>" <?= getConfigCocomo('DEF_DATA') === 'DATA-NO' ? 'checked' : ''; ?>><label for="DATA-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="DATA" id="DATA-HI" value="<?= number_format(getConfigCocomo('DATA_HI'), 2); ?>" <?= getConfigCocomo('DEF_DATA') === 'DATA-HI' ? 'checked' : ''; ?>><label for="DATA-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="DATA" id="DATA-VH" value="<?= number_format(getConfigCocomo('DATA_VH'), 2); ?>" <?= getConfigCocomo('DEF_DATA') === 'DATA-VH' ? 'checked' : ''; ?>><label for="DATA-VH"><span><span></span></span></label></div>
                    <div class="col-md-1">N/A</div>
                </div>
                <div class="row" id="dotted">
                    <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Complexidade do Produto de Software (CPLX)</div>
                    <div class="col-md-1" id="CPLX-VL" style="min-height:24px;"></div>
                    <div class="col-md-1" id="CPLX-LO" style="min-height:24px;"></div>
                    <div class="col-md-1" id="CPLX-NO" style="min-height:24px;"></div>
                    <div class="col-md-1" id="CPLX-HI" style="min-height:24px;"></div>
                    <div class="col-md-1" id="CPLX-VH" style="min-height:24px;"></div>
                    <div class="col-md-1" id="CPLX-EH" style="min-height:24px;"></div>
                    <input type="hidden" id="CPLX">
                </div>
                <div class="well well-sm">
                    <div class="row" id="dotted">
                        <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opera&ccedil;&otilde;es de Controle</div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-CN" id="CPLX-CN-VL" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_CN_VL'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_CN') === 'CPLX-CN-VL' ? 'checked' : ''; ?>><label for="CPLX-CN-VL"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-CN" id="CPLX-CN-LO" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_CN_LO'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_CN') === 'CPLX-CN-LO' ? 'checked' : ''; ?>><label for="CPLX-CN-LO"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-CN" id="CPLX-CN-NO" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_CN_NO'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_CN') === 'CPLX-CN-NO' ? 'checked' : ''; ?>><label for="CPLX-CN-NO"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-CN" id="CPLX-CN-HI" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_CN_HI'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_CN') === 'CPLX-CN-HI' ? 'checked' : ''; ?>><label for="CPLX-CN-HI"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-CN" id="CPLX-CN-VH" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_CN_VH'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_CN') === 'CPLX-CN-VH' ? 'checked' : ''; ?>><label for="CPLX-CN-VH"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-CN" id="CPLX-CN-EH" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_CN_EH'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_CN') === 'CPLX-CN-EH' ? 'checked' : ''; ?>><label for="CPLX-CN-EH"><span><span></span></span></label></div>
                    </div>
                    <div class="row" id="dotted">
                        <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opera&ccedil;&otilde;es Computacionais</div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-CO" id="CPLX-CO-VL" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_CO_VL'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_CO') === 'CPLX-CO-VL' ? 'checked' : ''; ?>><label for="CPLX-CO-VL"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-CO" id="CPLX-CO-LO" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_CO_LO'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_CO') === 'CPLX-CO-LO' ? 'checked' : ''; ?>><label for="CPLX-CO-LO"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-CO" id="CPLX-CO-NO" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_CO_NO'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_CO') === 'CPLX-CO-NO' ? 'checked' : ''; ?>><label for="CPLX-CO-NO"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-CO" id="CPLX-CO-HI" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_CO_HI'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_CO') === 'CPLX-CO-HI' ? 'checked' : ''; ?>><label for="CPLX-CO-HI"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-CO" id="CPLX-CO-VH" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_CO_VH'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_CO') === 'CPLX-CO-VH' ? 'checked' : ''; ?>><label for="CPLX-CO-VH"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-CO" id="CPLX-CO-EH" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_CO_EH'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_CO') === 'CPLX-CO-EH' ? 'checked' : ''; ?>><label for="CPLX-CO-EH"><span><span></span></span></label></div>
                    </div>
                    <div class="row" id="dotted">
                        <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opera&ccedil;&otilde;es Dependentes <i>devices</i></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-DO" id="CPLX-DO-VL" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_DO_VL'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_DO') === 'CPLX-DO-VL' ? 'checked' : ''; ?>><label for="CPLX-DO-VL"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-DO" id="CPLX-DO-LO" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_DO_LO'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_DO') === 'CPLX-DO-LO' ? 'checked' : ''; ?>><label for="CPLX-DO-LO"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-DO" id="CPLX-DO-NO" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_DO_NO'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_DO') === 'CPLX-DO-NO' ? 'checked' : ''; ?>><label for="CPLX-DO-NO"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-DO" id="CPLX-DO-HI" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_DO_HI'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_DO') === 'CPLX-DO-HI' ? 'checked' : ''; ?>><label for="CPLX-DO-HI"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-DO" id="CPLX-DO-VH" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_DO_VH'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_DO') === 'CPLX-DO-VH' ? 'checked' : ''; ?>><label for="CPLX-DO-VH"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-DO" id="CPLX-DO-EH" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_DO_EH'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_DO') === 'CPLX-DO-EH' ? 'checked' : ''; ?>><label for="CPLX-DO-EH"><span><span></span></span></label></div>
                    </div>
                    <div class="row" id="dotted">
                        <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opera&ccedil;&otilde;es Gest&atilde;o de Dados</div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-DM" id="CPLX-DM-VL" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_DM_VL'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_DM') === 'CPLX-DM-VL' ? 'checked' : ''; ?>><label for="CPLX-DM-VL"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-DM" id="CPLX-DM-LO" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_DM_LO'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_DM') === 'CPLX-DM-LO' ? 'checked' : ''; ?>><label for="CPLX-DM-LO"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-DM" id="CPLX-DM-NO" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_DM_NO'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_DM') === 'CPLX-DM-NO' ? 'checked' : ''; ?>><label for="CPLX-DM-NO"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-DM" id="CPLX-DM-HI" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_DM_HI'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_DM') === 'CPLX-DM-HI' ? 'checked' : ''; ?>><label for="CPLX-DM-HI"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-DM" id="CPLX-DM-VH" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_DM_VH'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_DM') === 'CPLX-DM-VH' ? 'checked' : ''; ?>><label for="CPLX-DM-VH"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-DM" id="CPLX-DM-EH" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_DM_EH'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_DM') === 'CPLX-DM-EH' ? 'checked' : ''; ?>><label for="CPLX-DM-EH"><span><span></span></span></label></div>
                    </div>				
                    <div class="row" id="dotted">
                        <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Opera&ccedil;&otilde;es de Gerenciamento na Interface do Usu&aacute;rio</div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-UI" id="CPLX-UI-VL" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_UI_VL'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_UI') === 'CPLX-UI-VL' ? 'checked' : ''; ?>><label for="CPLX-UI-VL"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-UI" id="CPLX-UI-LO" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_UI_LO'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_UI') === 'CPLX-UI-LO' ? 'checked' : ''; ?>><label for="CPLX-UI-LO"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-UI" id="CPLX-UI-NO" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_UI_NO'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_UI') === 'CPLX-UI-NO' ? 'checked' : ''; ?>><label for="CPLX-UI-NO"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-UI" id="CPLX-UI-HI" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_UI_HI'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_UI') === 'CPLX-UI-HI' ? 'checked' : ''; ?>><label for="CPLX-UI-HI"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-UI" id="CPLX-UI-VH" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_UI_VH'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_UI') === 'CPLX-UI-VH' ? 'checked' : ''; ?>><label for="CPLX-UI-VH"><span><span></span></span></label></div>
                        <div class="col-md-1"><input class="rd-cocomo" type="radio" name="CPLX-UI" id="CPLX-UI-EH" data="CPLX" value="<?= number_format(getConfigCocomo('CPLX_UI_EH'), 2); ?>" <?= getConfigCocomo('DEF_CPLX_UI') === 'CPLX-UI-EH' ? 'checked' : ''; ?>><label for="CPLX-UI-EH"><span><span></span></span></label></div>
                    </div>				                    
                </div>
                <div class="row" id="dotted">
                    <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Desenvolvimento para Re&uacute;so (RUSE)</div>
                    <div class="col-md-1">N/A</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="RUSE" id="RUSE-LO" value="<?= number_format(getConfigCocomo('RUSE_LO'), 2); ?>" <?= getConfigCocomo('DEF_RUSE') === 'RUSE-LO' ? 'checked' : ''; ?>><label for="RUSE-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="RUSE" id="RUSE-NO" value="<?= number_format(getConfigCocomo('RUSE_NO'), 2); ?>" <?= getConfigCocomo('DEF_RUSE') === 'RUSE-NO' ? 'checked' : ''; ?>><label for="RUSE-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="RUSE" id="RUSE-HI" value="<?= number_format(getConfigCocomo('RUSE_HI'), 2); ?>" <?= getConfigCocomo('DEF_RUSE') === 'RUSE-HI' ? 'checked' : ''; ?>><label for="RUSE-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="RUSE" id="RUSE-VH" value="<?= number_format(getConfigCocomo('RUSE_VH'), 2); ?>" <?= getConfigCocomo('DEF_RUSE') === 'RUSE-VH' ? 'checked' : ''; ?>><label for="RUSE-VH"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="RUSE" id="RUSE-EH" value="<?= number_format(getConfigCocomo('RUSE_EH'), 2); ?>" <?= getConfigCocomo('DEF_RUSE') === 'RUSE-EH' ? 'checked' : ''; ?>><label for="RUSE-EH"><span><span></span></span></label></div>
                </div>
                <div class="row" id="dotted">
                    <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;N&iacute;vel de Documenta&ccedil;&atilde;o (DOCU)</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="DOCU" id="DOCU-VL" value="<?= number_format(getConfigCocomo('DOCU_VL'), 2); ?>" <?= getConfigCocomo('DEF_DOCU') === 'DOCU-VL' ? 'checked' : ''; ?>><label for="DOCU-VL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="DOCU" id="DOCU-LO" value="<?= number_format(getConfigCocomo('DOCU_LO'), 2); ?>" <?= getConfigCocomo('DEF_DOCU') === 'DOCU-LO' ? 'checked' : ''; ?>><label for="DOCU-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="DOCU" id="DOCU-NO" value="<?= number_format(getConfigCocomo('DOCU_NO'), 2); ?>" <?= getConfigCocomo('DEF_DOCU') === 'DOCU-NO' ? 'checked' : ''; ?>><label for="DOCU-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="DOCU" id="DOCU-HI" value="<?= number_format(getConfigCocomo('DOCU_HI'), 2); ?>" <?= getConfigCocomo('DEF_DOCU') === 'DOCU-HI' ? 'checked' : ''; ?>><label for="DOCU-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="DOCU" id="DOCU-VH" value="<?= number_format(getConfigCocomo('DOCU_VH'), 2); ?>" <?= getConfigCocomo('DEF_DOCU') === 'DOCU-VH' ? 'checked' : ''; ?>><label for="DOCU-VH"><span><span></span></span></label></div>
                    <div class="col-md-1">N/A</div>
                </div>
                <div class="row">
                    <div class="col-md-12"><div class="well well-sm"><strong>Plataforma</strong></div></div>
                </div>                 
                <div class="row" id="dotted">
                    <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Restri&ccedil;&otilde;es de Tempo (TIME)</div>
                    <div class="col-md-1">N/A</div>
                    <div class="col-md-1">N/A</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="TIME" id="TIME-NO" value="<?= number_format(getConfigCocomo('TIME_NO'), 2); ?>" <?= getConfigCocomo('DEF_TIME') === 'TIME-NO' ? 'checked' : ''; ?>><label for="TIME-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="TIME" id="TIME-HI" value="<?= number_format(getConfigCocomo('TIME_HI'), 2); ?>" <?= getConfigCocomo('DEF_TIME') === 'TIME-HI' ? 'checked' : ''; ?>><label for="TIME-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="TIME" id="TIME-VH" value="<?= number_format(getConfigCocomo('TIME_VH'), 2); ?>" <?= getConfigCocomo('DEF_TIME') === 'TIME-VH' ? 'checked' : ''; ?>><label for="TIME-VH"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="TIME" id="TIME-EH" value="<?= number_format(getConfigCocomo('TIME_EH'), 2); ?>" <?= getConfigCocomo('DEF_TIME') === 'TIME-EH' ? 'checked' : ''; ?>><label for="TIME-EH"><span><span></span></span></label></div>
                </div>
                <div class="row" id="dotted">
                    <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Grau de restri&ccedil;&atilde;o de armazenamento (STOR)</div>
                    <div class="col-md-1">N/A</div>
                    <div class="col-md-1">N/A</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="STOR" id="STOR-NO" value="<?= number_format(getConfigCocomo('STOR_NO'), 2); ?>" <?= getConfigCocomo('DEF_STOR') === 'STOR-NO' ? 'checked' : ''; ?>><label for="STOR-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="STOR" id="STOR-HI" value="<?= number_format(getConfigCocomo('STOR_HI'), 2); ?>" <?= getConfigCocomo('DEF_STOR') === 'STOR-HI' ? 'checked' : ''; ?>><label for="STOR-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="STOR" id="STOR-VH" value="<?= number_format(getConfigCocomo('STOR_VH'), 2); ?>" <?= getConfigCocomo('DEF_STOR') === 'STOR-VH' ? 'checked' : ''; ?>><label for="STOR-VH"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="STOR" id="STOR-EH" value="<?= number_format(getConfigCocomo('STOR_EH'), 2); ?>" <?= getConfigCocomo('DEF_STOR') === 'STOR-EH' ? 'checked' : ''; ?>><label for="STOR-EH"><span><span></span></span></label></div>
                </div>
                <div class="row" id="dotted">
                    <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Volatilidade da Plataforma (PVOL)</div>
                    <div class="col-md-1">N/A</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PVOL" id="PVOL-LO" value="<?= number_format(getConfigCocomo('PVOL_LO'), 2); ?>" <?= getConfigCocomo('DEF_PVOL') === 'PVOL-LO' ? 'checked' : ''; ?>><label for="PVOL-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PVOL" id="PVOL-NO" value="<?= number_format(getConfigCocomo('PVOL_NO'), 2); ?>" <?= getConfigCocomo('DEF_PVOL') === 'PVOL-NO' ? 'checked' : ''; ?>><label for="PVOL-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PVOL" id="PVOL-HI" value="<?= number_format(getConfigCocomo('PVOL_HI'), 2); ?>" <?= getConfigCocomo('DEF_PVOL') === 'PVOL-HI' ? 'checked' : ''; ?>><label for="PVOL-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PVOL" id="PVOL-VH" value="<?= number_format(getConfigCocomo('PVOL_VH'), 2); ?>" <?= getConfigCocomo('DEF_PVOL') === 'PVOL-VH' ? 'checked' : ''; ?>><label for="PVOL-VH"><span><span></span></span></label></div>
                    <div class="col-md-1">N/A</div>
                </div>
                <div class="row">
                    <div class="col-md-12"><div class="well well-sm"><strong>Pessoas / Equipe</strong></div></div>
                </div>                  
                <div class="row" id="dotted">
                    <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Capacidade dos Analistas (ACAP)</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ACAP" id="ACAP-VL" value="<?= number_format(getConfigCocomo('ACAP_VL'), 2); ?>" <?= getConfigCocomo('DEF_ACAP') === 'ACAP-VL' ? 'checked' : ''; ?>><label for="ACAP-VL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ACAP" id="ACAP-LO" value="<?= number_format(getConfigCocomo('ACAP_LO'), 2); ?>" <?= getConfigCocomo('DEF_ACAP') === 'ACAP-LO' ? 'checked' : ''; ?>><label for="ACAP-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ACAP" id="ACAP-NO" value="<?= number_format(getConfigCocomo('ACAP_NO'), 2); ?>" <?= getConfigCocomo('DEF_ACAP') === 'ACAP-NO' ? 'checked' : ''; ?>><label for="ACAP-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ACAP" id="ACAP-HI" value="<?= number_format(getConfigCocomo('ACAP_HI'), 2); ?>" <?= getConfigCocomo('DEF_ACAP') === 'ACAP-HI' ? 'checked' : ''; ?>><label for="ACAP-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ACAP" id="ACAP-VH" value="<?= number_format(getConfigCocomo('ACAP_VH'), 2); ?>" <?= getConfigCocomo('DEF_ACAP') === 'ACAP-VH' ? 'checked' : ''; ?>><label for="ACAP-VH"><span><span></span></span></label></div>
                    <div class="col-md-1">N/A</div>
                </div>
                <div class="row" id="dotted">
                    <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Capacidade dos Programadores (PCAP)</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PCAP" id="PCAP-VL" value="<?= number_format(getConfigCocomo('PCAP_VL'), 2); ?>" <?= getConfigCocomo('DEF_PCAP') === 'PCAP-VL' ? 'checked' : ''; ?>><label for="PCAP-VL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PCAP" id="PCAP-LO" value="<?= number_format(getConfigCocomo('PCAP_LO'), 2); ?>" <?= getConfigCocomo('DEF_PCAP') === 'PCAP-LO' ? 'checked' : ''; ?>><label for="PCAP-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PCAP" id="PCAP-NO" value="<?= number_format(getConfigCocomo('PCAP_NO'), 2); ?>" <?= getConfigCocomo('DEF_PCAP') === 'PCAP-NO' ? 'checked' : ''; ?>><label for="PCAP-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PCAP" id="PCAP-HI" value="<?= number_format(getConfigCocomo('PCAP_HI'), 2); ?>" <?= getConfigCocomo('DEF_PCAP') === 'PCAP-HI' ? 'checked' : ''; ?>><label for="PCAP-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PCAP" id="PCAP-VH" value="<?= number_format(getConfigCocomo('PCAP_VH'), 2); ?>" <?= getConfigCocomo('DEF_PCAP') === 'PCAP-VH' ? 'checked' : ''; ?>><label for="PCAP-VH"><span><span></span></span></label></div>
                    <div class="col-md-1">N/A</div>
                </div>
                <div class="row" id="dotted">
                    <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Continuidade da Equipe - <i>turnover</i> (PCON)</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PCON" id="PCON-VL" value="<?= number_format(getConfigCocomo('PCON_VL'), 2); ?>" <?= getConfigCocomo('DEF_PCON') === 'PCON-VL' ? 'checked' : ''; ?>><label for="PCON-VL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PCON" id="PCON-LO" value="<?= number_format(getConfigCocomo('PCON_LO'), 2); ?>" <?= getConfigCocomo('DEF_PCON') === 'PCON-LO' ? 'checked' : ''; ?>><label for="PCON-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PCON" id="PCON-NO" value="<?= number_format(getConfigCocomo('PCON_NO'), 2); ?>" <?= getConfigCocomo('DEF_PCON') === 'PCON-NO' ? 'checked' : ''; ?>><label for="PCON-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PCON" id="PCON-HI" value="<?= number_format(getConfigCocomo('PCON_HI'), 2); ?>" <?= getConfigCocomo('DEF_PCON') === 'PCON-HI' ? 'checked' : ''; ?>><label for="PCON-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PCON" id="PCON-VH" value="<?= number_format(getConfigCocomo('PCON_VH'), 2); ?>" <?= getConfigCocomo('DEF_PCON') === 'PCON-VH' ? 'checked' : ''; ?>><label for="PCON-VH"><span><span></span></span></label></div>
                    <div class="col-md-1">N/A</div>
                </div>
                <div class="row" id="dotted">
                    <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Experi&ecirc;ncia na Aplica&ccedil;&atilde;o (APEX/AEXP)</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="APEX" id="APEX-VL" value="<?= number_format(getConfigCocomo('APEX_VL'), 2); ?>" <?= getConfigCocomo('DEF_APEX') === 'APEX-VL' ? 'checked' : ''; ?>><label for="APEX-VL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="APEX" id="APEX-LO" value="<?= number_format(getConfigCocomo('APEX_LO'), 2); ?>" <?= getConfigCocomo('DEF_APEX') === 'APEX-LO' ? 'checked' : ''; ?>><label for="APEX-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="APEX" id="APEX-NO" value="<?= number_format(getConfigCocomo('APEX_NO'), 2); ?>" <?= getConfigCocomo('DEF_APEX') === 'APEX-NO' ? 'checked' : ''; ?>><label for="APEX-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="APEX" id="APEX-HI" value="<?= number_format(getConfigCocomo('APEX_HI'), 2); ?>" <?= getConfigCocomo('DEF_APEX') === 'APEX-HI' ? 'checked' : ''; ?>><label for="APEX-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="APEX" id="APEX-VH" value="<?= number_format(getConfigCocomo('APEX_VH'), 2); ?>" <?= getConfigCocomo('DEF_APEX') === 'APEX-VH' ? 'checked' : ''; ?>><label for="APEX-VH"><span><span></span></span></label></div>
                    <div class="col-md-1">N/A</div>
                </div>
                <div class="row" id="dotted">
                    <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Experi&ecirc;ncia P&oacute;s Arquitetura (PLEX/PEXP)</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PLEX" id="PLEX-VL" value="<?= number_format(getConfigCocomo('PLEX_VL'), 2); ?>" <?= getConfigCocomo('DEF_PLEX') === 'PLEX-VL' ? 'checked' : ''; ?>><label for="PLEX-VL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PLEX" id="PLEX-LO" value="<?= number_format(getConfigCocomo('PLEX_LO'), 2); ?>" <?= getConfigCocomo('DEF_PLEX') === 'PLEX-LO' ? 'checked' : ''; ?>><label for="PLEX-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PLEX" id="PLEX-NO" value="<?= number_format(getConfigCocomo('PLEX_NO'), 2); ?>" <?= getConfigCocomo('DEF_PLEX') === 'PLEX-NO' ? 'checked' : ''; ?>><label for="PLEX-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PLEX" id="PLEX-HI" value="<?= number_format(getConfigCocomo('PLEX_HI'), 2); ?>" <?= getConfigCocomo('DEF_PLEX') === 'PLEX-HI' ? 'checked' : ''; ?>><label for="PLEX-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="PLEX" id="PLEX-VH" value="<?= number_format(getConfigCocomo('PLEX_VH'), 2); ?>" <?= getConfigCocomo('DEF_PLEX') === 'PLEX-VH' ? 'checked' : ''; ?>><label for="PLEX-VH"><span><span></span></span></label></div>
                    <div class="col-md-1">N/A</div>
                </div>
                <div class="row" id="dotted">
                    <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Experi&ecirc;ncia na Linguagem de Programa&ccedil;&atilde;o e Ferramentas (LTEX)</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="LTEX" id="LTEX-VL" value="<?= number_format(getConfigCocomo('LTEX_VL'), 2); ?>" <?= getConfigCocomo('DEF_LTEX') === 'LTEX-VL' ? 'checked' : ''; ?>><label for="LTEX-VL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="LTEX" id="LTEX-LO" value="<?= number_format(getConfigCocomo('LTEX_LO'), 2); ?>" <?= getConfigCocomo('DEF_LTEX') === 'LTEX-LO' ? 'checked' : ''; ?>><label for="LTEX-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="LTEX" id="LTEX-NO" value="<?= number_format(getConfigCocomo('LTEX_NO'), 2); ?>" <?= getConfigCocomo('DEF_LTEX') === 'LTEX-NO' ? 'checked' : ''; ?>><label for="LTEX-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="LTEX" id="LTEX-HI" value="<?= number_format(getConfigCocomo('LTEX_HI'), 2); ?>" <?= getConfigCocomo('DEF_LTEX') === 'LTEX-HI' ? 'checked' : ''; ?>><label for="LTEX-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="LTEX" id="LTEX-VH" value="<?= number_format(getConfigCocomo('LTEX_VH'), 2); ?>" <?= getConfigCocomo('DEF_LTEX') === 'LTEX-VH' ? 'checked' : ''; ?>><label for="LTEX-VH"><span><span></span></span></label></div>
                    <div class="col-md-1">N/A</div>
                </div>
                <div class="row">
                    <div class="col-md-12"><div class="well well-sm"><strong>Projeto</strong></div></div>
                </div>
                <div class="row" id="dotted">
                    <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Utiliza&ccedil;&atilde;o de Ferramentas de Desenvolvimento (TOOL)</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="TOOL" id="TOOL-VL" value="<?= number_format(getConfigCocomo('TOOL_VL'), 2); ?>" <?= getConfigCocomo('DEF_TOOL') === 'TOOL-VL' ? 'checked' : ''; ?>><label for="TOOL-VL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="TOOL" id="TOOL-LO" value="<?= number_format(getConfigCocomo('TOOL_LO'), 2); ?>" <?= getConfigCocomo('DEF_TOOL') === 'TOOL-LO' ? 'checked' : ''; ?>><label for="TOOL-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="TOOL" id="TOOL-NO" value="<?= number_format(getConfigCocomo('TOOL_NO'), 2); ?>" <?= getConfigCocomo('DEF_TOOL') === 'TOOL-NO' ? 'checked' : ''; ?>><label for="TOOL-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="TOOL" id="TOOL-HI" value="<?= number_format(getConfigCocomo('TOOL_HI'), 2); ?>" <?= getConfigCocomo('DEF_TOOL') === 'TOOL-HI' ? 'checked' : ''; ?>><label for="TOOL-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="TOOL" id="TOOL-VH" value="<?= number_format(getConfigCocomo('TOOL_VH'), 2); ?>" <?= getConfigCocomo('DEF_TOOL') === 'TOOL-VH' ? 'checked' : ''; ?>><label for="TOOL-VH"><span><span></span></span></label></div>
                    <div class="col-md-1">N/A</div>
                </div>
                <div class="row" id="dotted">
                    <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Desenvolvimento Multisite (SITE)</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="SITE" id="SITE-VL" value="<?= number_format(getConfigCocomo('SITE_VL'), 2); ?>" <?= getConfigCocomo('DEF_SITE') === 'SITE-VL' ? 'checked' : ''; ?>><label for="SITE-VL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="SITE" id="SITE-LO" value="<?= number_format(getConfigCocomo('SITE_LO'), 2); ?>" <?= getConfigCocomo('DEF_SITE') === 'SITE-LO' ? 'checked' : ''; ?>><label for="SITE-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="SITE" id="SITE-NO" value="<?= number_format(getConfigCocomo('SITE_NO'), 2); ?>" <?= getConfigCocomo('DEF_SITE') === 'SITE-NO' ? 'checked' : ''; ?>><label for="SITE-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="SITE" id="SITE-HI" value="<?= number_format(getConfigCocomo('SITE_HI'), 2); ?>" <?= getConfigCocomo('DEF_SITE') === 'SITE-HI' ? 'checked' : ''; ?>><label for="SITE-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="SITE" id="SITE-VH" value="<?= number_format(getConfigCocomo('SITE_VH'), 2); ?>" <?= getConfigCocomo('DEF_SITE') === 'SITE-VH' ? 'checked' : ''; ?>><label for="SITE-VH"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="SITE" id="SITE-EH" value="<?= number_format(getConfigCocomo('SITE_EH'), 2); ?>" <?= getConfigCocomo('DEF_SITE') === 'SITE-EH' ? 'checked' : ''; ?>><label for="SITE-EH"><span><span></span></span></label></div>
                </div>
                <div class="row" id="dotted">
                    <div class="col-md-6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Restri&ccedil;&atilde;o ao Cronograma do Projeto (SCED)</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="SCED" id="SCED-VL" value="<?= number_format(getConfigCocomo('SCED_VL'), 2); ?>" <?= getConfigCocomo('DEF_SCED') === 'SCED-VL' ? 'checked' : ''; ?>><label for="SCED-VL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="SCED" id="SCED-LO" value="<?= number_format(getConfigCocomo('SCED_LO'), 2); ?>" <?= getConfigCocomo('DEF_SCED') === 'SCED-LO' ? 'checked' : ''; ?>><label for="SCED-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="SCED" id="SCED-NO" value="<?= number_format(getConfigCocomo('SCED_NO'), 2); ?>" <?= getConfigCocomo('DEF_SCED') === 'SCED-NO' ? 'checked' : ''; ?>><label for="SCED-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="SCED" id="SCED-HI" value="<?= number_format(getConfigCocomo('SCED_HI'), 2); ?>" <?= getConfigCocomo('DEF_SCED') === 'SCED-HI' ? 'checked' : ''; ?>><label for="SCED-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="SCED" id="SCED-VH" value="<?= number_format(getConfigCocomo('SCED_VH'), 2); ?>" <?= getConfigCocomo('DEF_SCED') === 'SCED-VH' ? 'checked' : ''; ?>><label for="SCED-VH"><span><span></span></span></label></div>
                    <div class="col-md-1">N/A</div>
                </div>
            </div>
            <div class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion-cocomo" href="#collapse-cocomo-projeto-inicial">
                    <i class="fa fa-chevron-down"></i>&nbsp;Projeto Inicial (<i>Early Design</i>)</a>
            </div>
            <div id="collapse-cocomo-projeto-inicial" class="panel-default panel-collapse collapse">
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-1">Baix&iacute;ssimo</div>
                    <div class="col-md-1">Muito baixo</div>
                    <div class="col-md-1">Baixo</div>
                    <div class="col-md-1">Nominal</div>
                    <div class="col-md-1">Alto</div>
                    <div class="col-md-1">Muito alto</div>
                    <div class="col-md-1">Alt&iacute;ssimo</div>
                </div>
                <div class="row" id="dotted">
                    <div class="col-md-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Capacidade da Equipe/Pessoal (PERS)</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-PERS" id="ED-PERS-XL" value="<?= number_format(getConfigCocomo('ED_PERS_XL'), 2); ?>" <?= getConfigCocomo('DEF_ED_PERS') === 'ED-PERS-XL' ? 'checked' : ''; ?>><label for="ED-PERS-XL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-PERS" id="ED-PERS-VL" value="<?= number_format(getConfigCocomo('ED_PERS_VL'), 2); ?>" <?= getConfigCocomo('DEF_ED_PERS') === 'ED-PERS-VL' ? 'checked' : ''; ?>><label for="ED-PERS-VL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-PERS" id="ED-PERS-LO" value="<?= number_format(getConfigCocomo('ED_PERS_LO'), 2); ?>" <?= getConfigCocomo('DEF_ED_PERS') === 'ED-PERS-LO' ? 'checked' : ''; ?>><label for="ED-PERS-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-PERS" id="ED-PERS-NO" value="<?= number_format(getConfigCocomo('ED_PERS_NO'), 2); ?>" <?= getConfigCocomo('DEF_ED_PERS') === 'ED-PERS-NO' ? 'checked' : ''; ?>><label for="ED-PERS-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-PERS" id="ED-PERS-HI" value="<?= number_format(getConfigCocomo('ED_PERS_HI'), 2); ?>" <?= getConfigCocomo('DEF_ED_PERS') === 'ED-PERS-HI' ? 'checked' : ''; ?>><label for="ED-PERS-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-PERS" id="ED-PERS-VH" value="<?= number_format(getConfigCocomo('ED_PERS_VH'), 2); ?>" <?= getConfigCocomo('DEF_ED_PERS') === 'ED-PERS-VH' ? 'checked' : ''; ?>><label for="ED-PERS-VH"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-PERS" id="ED-PERS-EH" value="<?= number_format(getConfigCocomo('ED_PERS_EH'), 2); ?>" <?= getConfigCocomo('DEF_ED_PERS') === 'ED-PERS-EH' ? 'checked' : ''; ?>><label for="ED-PERS-EH"><span><span></span></span></label></div>
                </div>
                <div class="row" id="dotted">
                    <div class="col-md-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;N&iacute;vel de Confian&ccedil;a e Complexidade (RCPX)</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-RCPX" id="ED-RCPX-XL" value="<?= number_format(getConfigCocomo('ED_RCPX_XL'), 2); ?>" <?= getConfigCocomo('DEF_ED_RCPX') === 'ED-RCPX-XL' ? 'checked' : ''; ?>><label for="ED-RCPX-XL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-RCPX" id="ED-RCPX-VL" value="<?= number_format(getConfigCocomo('ED_RCPX_VL'), 2); ?>" <?= getConfigCocomo('DEF_ED_RCPX') === 'ED-RCPX-VL' ? 'checked' : ''; ?>><label for="ED-RCPX-VL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-RCPX" id="ED-RCPX-LO" value="<?= number_format(getConfigCocomo('ED_RCPX_LO'), 2); ?>" <?= getConfigCocomo('DEF_ED_RCPX') === 'ED-RCPX-LO' ? 'checked' : ''; ?>><label for="ED-RCPX-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-RCPX" id="ED-RCPX-NO" value="<?= number_format(getConfigCocomo('ED_RCPX_NO'), 2); ?>" <?= getConfigCocomo('DEF_ED_RCPX') === 'ED-RCPX-NO' ? 'checked' : ''; ?>><label for="ED-RCPX-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-RCPX" id="ED-RCPX-HI" value="<?= number_format(getConfigCocomo('ED_RCPX_HI'), 2); ?>" <?= getConfigCocomo('DEF_ED_RCPX') === 'ED-RCPX-HI' ? 'checked' : ''; ?>><label for="ED-RCPX-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-RCPX" id="ED-RCPX-VH" value="<?= number_format(getConfigCocomo('ED_RCPX_VH'), 2); ?>" <?= getConfigCocomo('DEF_ED_RCPX') === 'ED-RCPX-VH' ? 'checked' : ''; ?>><label for="ED-RCPX-VH"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-RCPX" id="ED-RCPX-EH" value="<?= number_format(getConfigCocomo('ED_RCPX_EH'), 2); ?>" <?= getConfigCocomo('DEF_ED_RCPX') === 'ED-RCPX-EH' ? 'checked' : ''; ?>><label for="ED-RCPX-EH"><span><span></span></span></label></div>
                </div>
                <div class="row" id="dotted">
                    <div class="col-md-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Complexidade da Plataforma (PDIF)</div>
                    <div class="col-md-1">N/A</div>
                    <div class="col-md-1">N/A</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-PDIF" id="ED-PDIF-LO" value="<?= number_format(getConfigCocomo('ED_PDIF_LO'), 2); ?>" <?= getConfigCocomo('DEF_ED_PDIF') === 'ED-PDIF-LO' ? 'checked' : ''; ?>><label for="ED-PDIF-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-PDIF" id="ED-PDIF-NO" value="<?= number_format(getConfigCocomo('ED_PDIF_NO'), 2); ?>" <?= getConfigCocomo('DEF_ED_PDIF') === 'ED-PDIF-NO' ? 'checked' : ''; ?>><label for="ED-PDIF-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-PDIF" id="ED-PDIF-HI" value="<?= number_format(getConfigCocomo('ED_PDIF_HI'), 2); ?>" <?= getConfigCocomo('DEF_ED_PDIF') === 'ED-PDIF-HI' ? 'checked' : ''; ?>><label for="ED-PDIF-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-PDIF" id="ED-PDIF-VH" value="<?= number_format(getConfigCocomo('ED_PDIF_VH'), 2); ?>" <?= getConfigCocomo('DEF_ED_PDIF') === 'ED-PDIF-VH' ? 'checked' : ''; ?>><label for="ED-PDIF-VH"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-PDIF" id="ED-PDIF-EH" value="<?= number_format(getConfigCocomo('ED_PDIF_EH'), 2); ?>" <?= getConfigCocomo('DEF_ED_PDIF') === 'ED-PDIF-EH' ? 'checked' : ''; ?>><label for="ED-PDIF-EH"><span><span></span></span></label></div>
                </div>                        
                <div class="row" id="dotted">
                    <div class="col-md-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Experi&ecirc;ncia da Equipe/Pessoal (PREX)</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-PREX" id="ED-PREX-XL" value="<?= number_format(getConfigCocomo('ED_PREX_XL'), 2); ?>" <?= getConfigCocomo('DEF_ED_PREX') === 'ED-PREX-XL' ? 'checked' : ''; ?>><label for="ED-PREX-XL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-PREX" id="ED-PREX-VL" value="<?= number_format(getConfigCocomo('ED_PREX_VL'), 2); ?>" <?= getConfigCocomo('DEF_ED_PREX') === 'ED-PREX-VL' ? 'checked' : ''; ?>><label for="ED-PREX-VL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-PREX" id="ED-PREX-LO" value="<?= number_format(getConfigCocomo('ED_PREX_LO'), 2); ?>" <?= getConfigCocomo('DEF_ED_PREX') === 'ED-PREX-LO' ? 'checked' : ''; ?>><label for="ED-PREX-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-PREX" id="ED-PREX-NO" value="<?= number_format(getConfigCocomo('ED_PREX_NO'), 2); ?>" <?= getConfigCocomo('DEF_ED_PREX') === 'ED-PREX-NO' ? 'checked' : ''; ?>><label for="ED-PREX-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-PREX" id="ED-PREX-HI" value="<?= number_format(getConfigCocomo('ED_PREX_HI'), 2); ?>" <?= getConfigCocomo('DEF_ED_PREX') === 'ED-PREX-HI' ? 'checked' : ''; ?>><label for="ED-PREX-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-PREX" id="ED-PREX-VH" value="<?= number_format(getConfigCocomo('ED_PREX_VH'), 2); ?>" <?= getConfigCocomo('DEF_ED_PREX') === 'ED-PREX-VH' ? 'checked' : ''; ?>><label for="ED-PREX-VH"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-PREX" id="ED-PREX-EH" value="<?= number_format(getConfigCocomo('ED_PREX_EH'), 2); ?>" <?= getConfigCocomo('DEF_ED_PREX') === 'ED-PREX-EH' ? 'checked' : ''; ?>><label for="ED-PREX-EH"><span><span></span></span></label></div>
                </div>
                <div class="row" id="dotted">
                    <div class="col-md-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Facilitadores (FCIL)</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-FCIL" id="ED-FCIL-XL" value="<?= number_format(getConfigCocomo('ED_FCIL_XL'), 2); ?>" <?= getConfigCocomo('DEF_ED_FCIL') === 'ED-FCIL-XL' ? 'checked' : ''; ?>><label for="ED-FCIL-XL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-FCIL" id="ED-FCIL-VL" value="<?= number_format(getConfigCocomo('ED_FCIL_VL'), 2); ?>" <?= getConfigCocomo('DEF_ED_FCIL') === 'ED-FCIL-VL' ? 'checked' : ''; ?>><label for="ED-FCIL-VL"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-FCIL" id="ED-FCIL-LO" value="<?= number_format(getConfigCocomo('ED_FCIL_LO'), 2); ?>" <?= getConfigCocomo('DEF_ED_FCIL') === 'ED-FCIL-LO' ? 'checked' : ''; ?>><label for="ED-FCIL-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-FCIL" id="ED-FCIL-NO" value="<?= number_format(getConfigCocomo('ED_FCIL_NO'), 2); ?>" <?= getConfigCocomo('DEF_ED_FCIL') === 'ED-FCIL-NO' ? 'checked' : ''; ?>><label for="ED-FCIL-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-FCIL" id="ED-FCIL-HI" value="<?= number_format(getConfigCocomo('ED_FCIL_HI'), 2); ?>" <?= getConfigCocomo('DEF_ED_FCIL') === 'ED-FCIL-HI' ? 'checked' : ''; ?>><label for="ED-FCIL-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-FCIL" id="ED-FCIL-VH" value="<?= number_format(getConfigCocomo('ED_FCIL_VH'), 2); ?>" <?= getConfigCocomo('DEF_ED_FCIL') === 'ED-FCIL-VH' ? 'checked' : ''; ?>><label for="ED-FCIL-VH"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-FCIL" id="ED-FCIL-EH" value="<?= number_format(getConfigCocomo('ED_FCIL_EH'), 2); ?>" <?= getConfigCocomo('DEF_ED_FCIL') === 'ED-FCIL-EH' ? 'checked' : ''; ?>><label for="ED-FCIL-EH"><span><span></span></span></label></div>
                </div>
                <div class="row" id="dotted">
                    <div class="col-md-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Desenvolvimento para Re&uacute;so (RUSE)</div>
                    <div class="col-md-1">N/A</div>
                    <div class="col-md-1">N/A</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-RUSE" id="ED-RUSE-LO" value="<?= number_format(getConfigCocomo('ED_RUSE_LO'), 2); ?>" <?= getConfigCocomo('DEF_ED_RUSE') === 'ED-RUSE-LO' ? 'checked' : ''; ?>><label for="ED-RUSE-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-RUSE" id="ED-RUSE-NO" value="<?= number_format(getConfigCocomo('ED_RUSE_NO'), 2); ?>" <?= getConfigCocomo('DEF_ED_RUSE') === 'ED-RUSE-NO' ? 'checked' : ''; ?>><label for="ED-RUSE-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-RUSE" id="ED-RUSE-HI" value="<?= number_format(getConfigCocomo('ED_RUSE_HI'), 2); ?>" <?= getConfigCocomo('DEF_ED_RUSE') === 'ED-RUSE-HI' ? 'checked' : ''; ?>><label for="ED-RUSE-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-RUSE" id="ED-RUSE-VH" value="<?= number_format(getConfigCocomo('ED_RUSE_VH'), 2); ?>" <?= getConfigCocomo('DEF_ED_RUSE') === 'ED-RUSE-VH' ? 'checked' : ''; ?>><label for="ED-RUSE-VH"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-RUSE" id="ED-RUSE-EH" value="<?= number_format(getConfigCocomo('ED_RUSE_EH'), 2); ?>" <?= getConfigCocomo('DEF_ED_RUSE') === 'ED-RUSE-EH' ? 'checked' : ''; ?>><label for="ED-RUSE-EH"><span><span></span></span></label></div>
                </div>                        
                <div class="row" id="dotted">
                    <div class="col-md-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Restri&ccedil;&atilde;o ao Cronograma do Projeto (SCED)</div>
                    <div class="col-md-1">N/A</div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-SCED" id="ED-SCED-VL" value="<?= number_format(getConfigCocomo('ED_SCED_VL'), 2); ?>" <?= getConfigCocomo('DEF_ED_SCED') === 'ED-SCED-VL' ? 'checked' : ''; ?>><label for="ED-SCED-VL"><span><span></span></span></label></div>                         
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-SCED" id="ED-SCED-LO" value="<?= number_format(getConfigCocomo('ED_SCED_LO'), 2); ?>" <?= getConfigCocomo('DEF_ED_SCED') === 'ED-SCED-LO' ? 'checked' : ''; ?>><label for="ED-SCED-LO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-SCED" id="ED-SCED-NO" value="<?= number_format(getConfigCocomo('ED_SCED_NO'), 2); ?>" <?= getConfigCocomo('DEF_ED_SCED') === 'ED-SCED-NO' ? 'checked' : ''; ?>><label for="ED-SCED-NO"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-SCED" id="ED-SCED-HI" value="<?= number_format(getConfigCocomo('ED_SCED_HI'), 2); ?>" <?= getConfigCocomo('DEF_ED_SCED') === 'ED-SCED-HI' ? 'checked' : ''; ?>><label for="ED-SCED-HI"><span><span></span></span></label></div>
                    <div class="col-md-1"><input class="rd-cocomo" type="radio" name="ED-SCED" id="ED-SCED-VH" value="<?= number_format(getConfigCocomo('ED_SCED_VH'), 2); ?>" <?= getConfigCocomo('DEF_ED_SCED') === 'ED-SCED-VH' ? 'checked' : ''; ?>><label for="ED-SCED-VH"><span><span></span></span></label></div>
                    <div class="col-md-1">N/A</div>
                </div>                
            </div>            
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-title">
                <i class="fa fa-caret-right fa-lg"></i>&nbsp;&nbsp;Rational Unified Proccess - RUP<br />
                <span class="sub-header">Cronograma baseado nas especifica&ccedil;&otilde;es do projeto e da contagem</span>
            </div>
            <div class="panel-body">        
                <div class="table-responsive">
                    <table class="box-table-a table table-condensed">
                        <thead>
                            <tr><th><strong>Fase</strong></th>
                                <th><strong>Esfor&ccedil;o (PM)</strong></th>
                                <th><strong>Cronograma (M)</strong></th>
                                <th><strong>M&eacute;dia</strong></th>
                                <th><strong>Custo (R$)</strong></th>
                            </tr>                                
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Concep&ccedil;&atilde;o</strong></td>
                                <td><span id="rup-inc-ef"></span></td>
                                <td><span id="rup-inc-sc"></span></td>
                                <td><span id="rup-inc-av"></span></td>
                                <td><span id="rup-inc-co"></span></td>
                            </tr>
                            <tr>
                                <td><strong>Elabora&ccedil;&atilde;o</strong></td>
                                <td><span id="rup-ela-ef"></span></td>
                                <td><span id="rup-ela-sc"></span></td>
                                <td><span id="rup-ela-av"></span></td>
                                <td><span id="rup-ela-co"></span></td>
                            </tr>
                            <tr>
                                <td><strong>Constru&ccedil;&atilde;o</strong></td>
                                <td><span id="rup-con-ef"></span></td>
                                <td><span id="rup-con-sc"></span></td>
                                <td><span id="rup-con-av"></span></td>
                                <td><span id="rup-con-co"></span></td>
                            </tr>
                            <tr>
                                <td><strong>Transi&ccedil;&atilde;o</strong></td>
                                <td><span id="rup-tra-ef"></span></td>
                                <td><span id="rup-tra-sc"></span></td>
                                <td><span id="rup-tra-av"></span></td>
                                <td><span id="rup-tra-co"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-title">
                <i class="fa fa-caret-right fa-lg"></i>&nbsp;&nbsp;Constructive Cost Model - COCOMO II.2000<br />
                <span class="sub-header">Cronograma baseado nas especifica&ccedil;&otilde;es do projeto e da contagem</span>
            </div>
            <div class="panel-body">         
                <div class="table-responsive">
                    <table class="box-table-a table table-condensed">
                        <thead>
                            <tr><th><strong>Fase</strong></th>
                                <th><strong>Esfor&ccedil;o (PM)</strong></th>
                                <th><strong>Cronograma (M)</strong></th>
                                <th><strong>M&eacute;dia</strong></th>
                                <th><strong>Custo (R$)</strong></th>
                            </tr>                                
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Concep&ccedil;&atilde;o</strong></td>
                                <td><span id="coc-inc-ef"></span></td>
                                <td><span id="coc-inc-sc"></span></td>
                                <td><span id="coc-inc-av"></span></td>
                                <td><span id="coc-inc-co"></span></td>
                            </tr>
                            <tr>
                                <td><strong>Elabora&ccedil;&atilde;o</strong></td>
                                <td><span id="coc-ela-ef"></span></td>
                                <td><span id="coc-ela-sc"></span></td>
                                <td><span id="coc-ela-av"></span></td>
                                <td><span id="coc-ela-co"></span></td>
                            </tr>
                            <tr>
                                <td><strong>Constru&ccedil;&atilde;o</strong></td>
                                <td><span id="coc-con-ef"></span></td>
                                <td><span id="coc-con-sc"></span></td>
                                <td><span id="coc-con-av"></span></td>
                                <td><span id="coc-con-co"></span></td>
                            </tr>
                            <tr>
                                <td><strong>Transi&ccedil;&atilde;o</strong></td>
                                <td><span id="coc-tra-ef"></span></td>
                                <td><span id="coc-tra-sc"></span></td>
                                <td><span id="coc-tra-av"></span></td>
                                <td><span id="coc-tra-co"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>                    
</div>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-title">
                <i class="fa fa-caret-right fa-lg"></i>&nbsp;&nbsp;Rational Unified Proccess - RUP<br />
                <span class="sub-header">Distribui&ccedil;&atilde;o de esfor&ccedil;o pelas fases</span>
            </div>
            <div class="panel-body">         
                <div class="table-responsive">
                    <table class="box-table-a table table-condensed">
                        <thead>
                            <tr><th><strong>Fase/Atividade</strong></th>
                                <th><strong>Concep&ccedil;&atilde;o</strong></th>
                                <th><strong>Elabora&ccedil;&atilde;o</strong></th>
                                <th><strong>Constru&ccedil;&atilde;o</strong></th>
                                <th><strong>Transi&ccedil;&atilde;o</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Gerenciamento</strong></td>
                                <td><span id="rup-man-inc"></span></td>
                                <td><span id="rup-man-ela"></span></td>
                                <td><span id="rup-man-con"></span></td>
                                <td><span id="rup-man-tra"></span></td>
                            </tr>
                            <tr>
                                <td><strong>Ambiente/ Configura&ccedil;&atilde;o</strong></td>
                                <td><span id="rup-env-inc"></span></td>
                                <td><span id="rup-env-ela"></span></td>
                                <td><span id="rup-env-con"></span></td>
                                <td><span id="rup-env-tra"></span></td>
                            </tr>
                            <tr>
                                <td><strong>Requisitos</strong></td>
                                <td><span id="rup-req-inc"></span></td>
                                <td><span id="rup-req-ela"></span></td>
                                <td><span id="rup-req-con"></span></td>
                                <td><span id="rup-req-tra"></span></td>
                            </tr>
                            <tr>
                                <td><strong>Design (projeto)</strong></td>
                                <td><span id="rup-des-inc"></span></td>
                                <td><span id="rup-des-ela"></span></td>
                                <td><span id="rup-des-con"></span></td>
                                <td><span id="rup-des-tra"></span></td>
                            </tr>
                            <tr>
                                <td><strong>Implementa&ccedil;&atilde;o</strong></td>
                                <td><span id="rup-imp-inc"></span></td>
                                <td><span id="rup-imp-ela"></span></td>
                                <td><span id="rup-imp-con"></span></td>
                                <td><span id="rup-imp-tra"></span></td>
                            </tr>
                            <tr><td><strong>Avalia&ccedil;&atilde;o / Testes</strong></td>
                                <td><span id="rup-ass-inc"></span></td>
                                <td><span id="rup-ass-ela"></span></td>
                                <td><span id="rup-ass-con"></span></td>
                                <td><span id="rup-ass-tra"></span></td>
                            </tr>
                            <tr><td><strong>Implanta&ccedil;&atilde;o</strong></td>
                                <td><span id="rup-dep-inc"></span></td>
                                <td><span id="rup-dep-ela"></span></td>
                                <td><span id="rup-dep-con"></span></td>
                                <td><span id="rup-dep-tra"></span></td>
                            </tr>
                        </tbody>
                    </table>     
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-title">
                <i class="fa fa-caret-right fa-lg"></i>&nbsp;&nbsp;Constructive Cost Model - COCOMO II.2000<br />
                <span class="sub-header">Distribui&ccedil;&atilde;o de esfor&ccedil;o pelas fases</span>
            </div>
            <div class="panel-body">          
                <div class="table-responsive">
                    <table class="box-table-a table table-condensed">
                        <thead>
                            <tr><th><strong>Fase/Atividade</strong></th>
                                <th><strong>Concep&ccedil;&atilde;o</strong></th>
                                <th><strong>Elabora&ccedil;&atilde;o</strong></th>
                                <th><strong>Constru&ccedil;&atilde;o</strong></th>
                                <th><strong>Transi&ccedil;&atilde;o</strong></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Gerenciamento</strong></td>
                                <td><span id="coc-man-inc"></span></td>
                                <td><span id="coc-man-ela"></span></td>
                                <td><span id="coc-man-con"></span></td>
                                <td><span id="coc-man-tra"></span></td>
                            </tr>
                            <tr>
                                <td><strong>Ambiente/ Configura&ccedil;&atilde;o</strong></td>
                                <td><span id="coc-env-inc"></span></td>
                                <td><span id="coc-env-ela"></span></td>
                                <td><span id="coc-env-con"></span></td>
                                <td><span id="coc-env-tra"></span></td>
                            </tr>
                            <tr>
                                <td><strong>Requisitos</strong></td>
                                <td><span id="coc-req-inc"></span></td>
                                <td><span id="coc-req-ela"></span></td>
                                <td><span id="coc-req-con"></span></td>
                                <td><span id="coc-req-tra"></span></td>
                            </tr>
                            <tr>
                                <td><strong>Design (projeto)</strong></td>
                                <td><span id="coc-des-inc"></span></td>
                                <td><span id="coc-des-ela"></span></td>
                                <td><span id="coc-des-con"></span></td>
                                <td><span id="coc-des-tra"></span></td>
                            </tr>
                            <tr>
                                <td><strong>Implementa&ccedil;&atilde;o</strong></td>
                                <td><span id="coc-imp-inc"></span></td>
                                <td><span id="coc-imp-ela"></span></td>
                                <td><span id="coc-imp-con"></span></td>
                                <td><span id="coc-imp-tra"></span></td>
                            </tr>
                            <tr><td><strong>Avalia&ccedil;&atilde;o / Testes</strong></td>
                                <td><span id="coc-ass-inc"></span></td>
                                <td><span id="coc-ass-ela"></span></td>
                                <td><span id="coc-ass-con"></span></td>
                                <td><span id="coc-ass-tra"></span></td>
                            </tr>
                            <tr><td><strong>Implanta&ccedil;&atilde;o</strong></td>
                                <td><span id="coc-dep-inc"></span></td>
                                <td><span id="coc-dep-ela"></span></td>
                                <td><span id="coc-dep-con"></span></td>
                                <td><span id="coc-dep-tra"></span></td>
                            </tr>
                        </tbody>
                    </table>     
                </div>
            </div>
        </div>
        <br />
    </div>                    
    <!--
    <div class="col-md-6">
        <canvas id="coc-chart" width="700" height="400" class="img-responsive"></canvas>
    </div>-->
</div>