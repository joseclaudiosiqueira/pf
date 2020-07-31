<?php
/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER ['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * verificacao do status do login
 */
?>
<!-- Modal -->
<div id="form_modal_contrato" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <form id="form_inserir_alterar_contrato">
                <input type="hidden" id="fmiacon_id" name="fmiacon_id">
                <input type="hidden" id="fmiacon_acao" name="fmiacon_acao" value="inserir">
                <div class="modal-header">
                    <button type="button" id="fechar_contrato" class="close"
                            data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times"></i></span>
                    </button>
                    <i class="fa fa-file-text"></i>&nbsp;&nbsp;Contratos e aditivos contratuais<br />
                    <span class="sub-header">Gerenciamento das informa&ccedil;&otilde;es de contratos e aditivos</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div style="min-height: 510px; max-height: 510px; overflow-x: hidden; overflow-y: scroll; width: 100%;" class="scroll">
                                <table class="box-table-a" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="26%">N&uacute;mero/Ano/UF</th>
                                            <th width="11%">In&iacute;cio</th>
                                            <th width="11%">Fim</th>
                                            <th width="11%">Tipo</th>
                                            <th width="10%"><i id="w_contrato_status" class="fa fa-dot-circle-o"></i>&nbsp;Status</th>
                                            <th width="07%">R$ / PF</th>
                                            <th width="07%">HPC</th>
                                            <th width="07%">HPA</th>
                                        </tr>
                                    </thead>
                                    <tbody id="addContrato"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="fmiacon_id_cliente">
                                            <span class="pop"
                                                  data-toggle="popover" data-placement="bottom" title="<i 
                                                  class='fa fa-arrow-right'></i>&nbsp;Clientes" data-content="
                                                  <p align='justify'>
                                                  Nesta lista s&atilde;o exibidos apenas os clientes <strong>ATIVOS</strong>.
                                                  Caso o cliente n&atilde;o esteja na lista, contate um dos
                                                  Gestores ou o <a
                                                  href='mailto:<?= getAdministrador(getIdEmpresa()); ?>'>Administrador</a>
                                                  do sistema.
                                                  </p>"><i id="w_fmiacon_id_cliente"
                                                     class="fa fa-dot-circle-o"></i>&nbsp;<i
                                                     class="fa fa-info-circle"></i>&nbsp;Cliente</span></label> <select
                                            class="form-control input_style" id="fmiacon_id_cliente"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fmiacon_numero">
                                            <span class="pop"
                                                  data-toggle="popover" data-placement="bottom"
                                                  data-content="<p  align='justify'>O n&uacute;mero do contrato
                                                  pode conter tanto letras quanto n&uacute;meros. P.ex.:
                                                  AG-012356, MN012A-0261, entretanto a quantidade
                                                  m&aacute;xima de caracteres &eacute; de 40 (quarenta)."
                                                  title="<i class='fa fa-arrow-right'></i>&nbsp;N&uacute;mero
                                                  / identificador"><i class="fa fa-info-circle"></i>&nbsp;N&uacute;mero
                                            </span>
                                        </label>
                                        <div class="ui fluid corner labeled input">
                                            <input type="text" class="form-control input_style"
                                                   id="fmiacon_numero" placeholder="Identificador"
                                                   maxlength="40" autocomplete="off" required>
                                            <div class="ui corner label">
                                                <i class="asterisk icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="fmiacon_ano">&nbsp;Ano</label>
                                        <div class="ui fluid corner labeled input">
                                            <input type="text" class="form-control input_style"
                                                   id="fmiacon_ano" placeholder="Ano" maxlength="4"
                                                   data-mask="9999" autocomplete="off" required>
                                            <div class="ui corner label">
                                                <i class="asterisk icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="fmiacon_uf">
                                            <span class="pop"
                                                  data-toggle="popover" data-placement="bottom"
                                                  data-content="A UF a que o contrato pertence nos ajudar&aacute; a gerar estat&iacute;sticas mais confi&aacute;veis."
                                                  title="<i class='fa fa-arrow-right'></i>&nbsp;Unidade Federativa"><i class="fa fa-info-circle"></i>&nbsp;Estado
                                            </span>
                                        </label>                                        
                                        <select class="form-control input_style" id="fmiacon_uf"> 
                                            <option value="0">Selecione o Estado</option> 
                                            <option value="ac">Acre</option> 
                                            <option value="al">Alagoas</option> 
                                            <option value="am">Amazonas</option> 
                                            <option value="ap">Amapá</option> 
                                            <option value="ba">Bahia</option> 
                                            <option value="ce">Ceará</option> 
                                            <option value="df">Distrito Federal</option> 
                                            <option value="es">Espírito Santo</option> 
                                            <option value="go">Goiás</option> 
                                            <option value="ma">Maranhão</option> 
                                            <option value="mt">Mato Grosso</option> 
                                            <option value="ms">Mato Grosso do Sul</option> 
                                            <option value="mg">Minas Gerais</option> 
                                            <option value="pa">Pará</option> 
                                            <option value="pb">Paraíba</option> 
                                            <option value="pr">Paraná</option> 
                                            <option value="pe">Pernambuco</option> 
                                            <option value="pi">Piauí</option> 
                                            <option value="rj">Rio de Janeiro</option> 
                                            <option value="rn">Rio Grande do Norte</option> 
                                            <option value="ro">Rondônia</option> 
                                            <option value="rs">Rio Grande do Sul</option> 
                                            <option value="rr">Roraima</option> 
                                            <option value="sc">Santa Catarina</option> 
                                            <option value="se">Sergipe</option> 
                                            <option value="sp">São Paulo</option> 
                                            <option value="to">Tocantins</option> 
                                        </select>                                                    
                                    </div>
                                </div>                                  
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fmiacon-data-inicio">&nbsp;In&iacute;cio do
                                            contrato</label>
                                        <input type="text"
                                               class="form-control input_calendar input_style"
                                               placeholder="dd/mm/yyyy" id="fmiacon-data-inicio"
                                               data-mask="99/99/9999" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fmiacon-data-fim">&nbsp;Final do contrato</label>
                                        <input type="text"
                                               class="form-control input_calendar input_style"
                                               placeholder="dd/mm/yyyy" id="fmiacon-data-fim"
                                               data-mask="99/99/9999" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fmiacon_pf_contratado">&nbsp;PF Contratado</label>
                                        <div class="ui fluid corner labeled input">
                                            <input type="text" class="form-control input_style"
                                                   id="fmiacon_pf_contratado" placeholder="0" maxlength="15"
                                                   data-mask="000000000000000" autocomplete="off" required>
                                            <div class="ui corner label">
                                                <i class="asterisk icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fmiacon_valor_pf">&nbsp;Valor R$ / PF</label>
                                        <div class="ui fluid corner labeled input">
                                            <input type="text" class="form-control input_style money"
                                                   id="fmiacon_valor_pf" placeholder="R$ 0,00" maxlength="15"
                                                   autocomplete="off" required>
                                            <div class="ui corner label">
                                                <i class="asterisk icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fmiacon_valor_hpc">Horas Perfil Consultor</label>
                                        <input id="fmiacon_valor_hpc" type="text"
                                               class="form-control input_style money" maxlength="15"
                                               placeholder="R$ 0,00" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fmiacon_valor_hpa">Horas Perfil Analista</label> <input
                                            id="fmiacon_valor_hpa" type="text"
                                            class="form-control input_style money" maxlength="15"
                                            placeholder="R$ 0,00" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="fmiacon_tipo"> <span class="pop"
                                                                         data-toggle="popover" data-placement="bottom" title="<i 
                                                                         class='fa fa-arrow-right'></i>&nbsp;Contratos &AMP; Aditivos"
                                                                         data-content="ATEN&Ccedil;&Atilde;O: os contratos
                                                                         cadastrados como ADITIVOS ter&atilde;o todos os projetos do
                                                                         contrato inicial para efeitos de cadastramento das
                                                                         contagens."> <i class="fa fa-info-circle"></i>&nbsp;Tipo</span></label><br />
                                        <input id="fmiacon_tipo" type="checkbox" data-width="100" data-height="36"
                                               data-toggle="toggle" data-onstyle="success"
                                               data-offstyle="info" data-style="slow" data-on="Inicial"
                                               data-off="Aditivo" class="toggle" checked disabled>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="fmiacon_is_ativo">Status</label><br /> <input
                                            id="fmiacon_is_ativo" type="checkbox" data-width="100" data-height="36"
                                            data-toggle="toggle" data-onstyle="success" data-style="slow"
                                            data-on="Ativo" data-off="Inativo" class="toggle" checked
                                            disabled>
                                    </div>
                                </div>                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fmiacon_id"> <span class="pop"
                                                                       data-toggle="popover" data-placement="bottom"
                                                                       data-content="<p  align='justify'>Caso voc&ecirc; esteja
                                                                       cadastrando um aditivo, ser&aacute; necess&aacute;rio
                                                                       selecionar o contrato a que este aditivo faz parte. Se
                                                                       n&atilde;o houver nenhum contrato cadastrado, por favor,
                                                                       cadastre um antes de selecionar aditivos.
                                                                       </p>" title="<i class='fa fa-arrow-right'></i>&nbsp;Contratos
                                                                       e aditivos"> <i class="fa fa-dot-circle-o"
                                                            id="w_id_contrato"></i>&nbsp;<i class="fa fa-info-circle"></i>&nbsp;Contrato(s)
                                            </span></label> <select id="tipo_id_contrato"
                                                                class="form-control input_style" disabled></select>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <img class="img-thumbnail" src="" alt="captcha"
                                             id="fmiacon-img-captcha"
                                             onclick="refreshCaptcha($(this), $('#fmiacon-txt-captcha'));"
                                             data-toggle="tooltip" data-placement="top"
                                             title="Clique na imagem para obter outro c&oacute;digo" /><br />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fa fa-dot-circle-o" id="fmiacon-i-captcha"></i>&nbsp;<?php echo WORDING_REGISTRATION_CAPTCHA; ?></label>
                                        <div class="ui fluid corner labeled input">
                                            <input class="form-control input_style" type="text"
                                                   id="fmiacon-txt-captcha" autocomplete="off" maxlength="4"
                                                   required />
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
                    <div class="btn-group" role="group" aria-label="...">
                        <button type="submit" class="btn btn-success"
                                id="fmiacon_btn_inserir"
                                onclick="$('#fmiacon_acao').val('inserir');">
                            <i class="fa fa-save"></i> Salvar
                        </button>
                        <button type="button" class="btn btn-success"
                                id="fmiacon_btn_novo" disabled>
                            <i class="fa fa-plus-circle"></i> Inserir outro
                        </button>
                        <button type="submit" class="btn btn-success"
                                id="fmiacon_btn_atualizar"
                                onclick="$('#fmiacon_acao').val('alterar');" disabled>
                            <i class="fa fa-refresh"></i> Atualizar
                        </button>
                        <button type="button" class="btn btn-warning"
                                id="fmiacon_btn_fechar" onclick="limpaCamposContrato(true);"
                                data-dismiss="modal">
                            <i class="fa fa-times"></i> Fechar
                        </button>
                    </div></div>
            </form>
        </div>
    </div>
</div>