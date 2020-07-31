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
<div id="form-modal-gerenciar-baseline" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <input type="hidden" id="baseline-id" value="0">
            <div class="modal-header">
                <button type="button" id="fechar-baseline" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                <i class="fa fa-list-ul"></i>&nbsp;&nbsp;Gerenciamento de Baselines<br />
                <span class="sub-header">Cria&ccedil;&atilde;o e atualiza&ccedil;&atilde;o de Baselines de Sistemas</span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                        <!-- em uma nova versao
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="opt1" type="radio" name="campo-pesquisa" value="1" checked> <label for="opt1"><span><span></span></span>&nbsp;&nbsp;Sigla</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="opt2" type="radio" name="campo-pesquisa" value="2"> <label for="opt2"><span><span></span></span>&nbsp;&nbsp;Descri&ccedil;&atilde;o</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input id="opt3" type="radio" name="campo-pesquisa" value="3"> <label for="opt3"><span><span></span></span>&nbsp;&nbsp;Resumo</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group scroll" style="margin-right: 12px">
                                    <input type="text" class="form-control input_style"
                                           id="pesquisa-baseline"
                                           onkeyup="searchInTable($(this).get(0).id, $('#tbl-lista-baselines').get(0).id, $('input[name=campo-pesquisa]:checked').val());" />
                                </div>
                            </div>
                        </div>
                        -->
                        <div class="row">
                            <div class="col-md-12">
                                <div style="min-height: 525px; max-height: 525px; overflow-x: hidden; overflow-y: scroll; width: 100%;" class="scroll">
                                    <table class="box-table-a" width="100%" id="tbl-lista-baselines">
                                        <thead>
                                            <tr>
                                                <th width="07%">#ID</th>
                                                <th width="11%">Sigla</th>
                                                <th width="20%">Descri&ccedil;&atilde;o</th>
                                                <th width="28%">Resumo</th>
                                                <th width="08%">R$/PF</th>
                                                <th width="08%">R$/HPA</th>
                                                <th width="08%">R$/HPC</th>
                                                <th width="10%"><i id="w_baseline_status" class="fa fa-dot-circle-o"></i>&nbsp;Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="addBaseline"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5" style="padding-top: 8px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="baseline_id_cliente">Cliente</label> <select
                                        class="form-control input_style" id="baseline_id_cliente"></select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="baseline-is-ativo">Status</label><br />
                                    <input id="baseline-is-ativo" type="checkbox" data-width="100" data-height="36" data-toggle="toggle" data-onstyle="success" data-offstyle="warning" data-style="slow" data-on="Ativa" data-off="Inativa" class="datatoggle" checked>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="baseline-sigla">Sigla</label>
                                    <div class="ui fluid corner labeled input">
                                        <input type="text" class="form-control input_style" id="baseline-sigla" maxlength="15" placeholder="M&aacute;ximo 15 caracteres">
                                        <div class="ui corner label">
                                            <i class="asterisk icon"></i>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="baseline-descricao">Descri&ccedil;&atilde;o</label>
                                    <div class="ui fluid corner labeled input">
                                        <input type="text" class="form-control input_style" id="baseline-descricao">
                                        <div class="ui corner label">
                                            <i class="asterisk icon"></i>
                                        </div>
                                    </div>                                      
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="baseline-resumo">Resumo</label>
                                    <textarea class="form-control input_style scroll" rows="3" style="width: 100%" id="baseline-resumo"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="baseline-valor-pf">&nbsp;Valor R$/PF</label>
                                    <div class="ui fluid corner labeled input">
                                        <input type="text" class="form-control input_style money"
                                               id="baseline-valor-pf" placeholder="R$ 0,00" maxlength="15"
                                               autocomplete="off" required>
                                        <div class="ui corner label">
                                            <i class="asterisk icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="baseline-valor-hpc">R$/H Perfil Consultor</label>
                                    <div class="ui fluid corner labeled input">
                                        <input id="baseline-valor-hpc" type="text"
                                               class="form-control input_style money" maxlength="15"
                                               placeholder="R$ 0,00" autocomplete="off" required>
                                        <div class="ui corner label">
                                            <i class="asterisk icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="baseline-valor-hpa">R$/H Perfil Analista</label>
                                    <div class="ui fluid corner labeled input">
                                        <input id="baseline-valor-hpa" type="text"
                                               class="form-control input_style money" maxlength="15"
                                               placeholder="R$ 0,00" autocomplete="off" required>
                                        <div class="ui corner label">
                                            <i class="asterisk icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-4" style="text-align: right;">
                                <div class="form-group">
                                    <img class="img-thumbnail" alt="captcha"
                                         id="baseline-img-captcha"
                                         onclick="refreshCaptcha($(this), $('#baseline-txt-captcha'));"
                                         data-toggle="tooltip" data-placement="top"
                                         title="Clique na imagem para obter outro c&oacute;digo" /><br />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><i class="fa fa-dot-circle-o" id="baseline-i-captcha"></i>&nbsp;<?php echo WORDING_REGISTRATION_CAPTCHA; ?><sup>*</sup></label>
                                    <div class="ui fluid corner labeled input">
                                        <input class="form-control input_style" type="text" id="baseline-txt-captcha" autocomplete="off" maxlength="4" required />
                                        <div class="ui corner label">
                                            <i class="asterisk icon"></i>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button type="button" id="btn-salvar-baseline" class="btn btn-success"> <i class="fa fa-floppy-o"></i>&nbsp;Salvar</button>
                    <button type="button" id="btn-atualizar-baseline" class="btn btn-success"><i class="fa fa-refresh"></i>&nbsp;Atualizar</button>
                    <button type="button" id="btn-nova-baseline" class="btn btn-info"><i class="fa fa-plus-circle"></i>&nbsp;Nova baseline</button>
                    <button type="button" id="btn-cancelar-baseline"class="btn btn-warning"><i class="fa fa-times"></i>&nbsp;Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>