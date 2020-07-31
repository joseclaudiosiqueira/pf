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
<div id="form_modal_inserir_alterar_roteiro" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <form id="form_inserir_alterar_roteiro" role="form">
                <input type="hidden" id="fmiar_id" name="fmiar_id">
                <input type="hidden" id="fmiar_acao" name="fmiar_acao" value="inserir">
                <div class="modal-header">
                    <button type="button" id="fechar_roteiro" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times"></i></span>
                    </button>
                    <i class="fa fa-file-text"></i>&nbsp;&nbsp;Roteiros de m&eacute;tricas<br />
                    <span class="sub-header">Gerenciamento e personaliza&ccedil;&atilde;o de roteiros</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div style="min-height: 535px; max-height: 535px; overflow-x: hidden; overflow-y: scroll; width: 100%;" class="scroll">
                                <table class="box-table-a" width="100%">
                                    <thead>
                                        <tr>
                                            <th nowrap>Descri&ccedil;&atilde;o<br /><small>LEGENDA:<br />(C) Cliente, (F) Fornecedor</small></th>
                                            <th>Observa&ccedil;&otilde;es</th>
                                            <th nowrap><i id="w_roteiro_status" class="fa fa-dot-circle-o"></i>&nbsp;Status</th>
                                            <th nowrap><i id="w_roteiro_tipo" class="fa fa-dot-circle-o"></i>&nbsp;Tipo</th>
                                            <!-- sem importacoes por enquanto -->
                                            <!--<th nowrap>Importado de</th> -->
                                        </tr>
                                    </thead>
                                    <tbody id="addRoteiro"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="fmiar_descricao">
                                            <span class="pop"
                                                  data-toggle="popover" data-placement="bottom" title="<i 
                                                  class='fa fa-arrow-right'></i>&nbsp;Descri&ccedil;&atilde;o"
                                                  data-content="
                                                  <p align='justify'>
                                                  Insira uma descri&ccedil;&atilde;o simples com poucos
                                                  caracteres. Ex.: SISP 2.0, Roteiro ABC v1.0. <strong>ATEN&Ccedil;&Atilde;O</strong>:
                                                  o sistema permite que sejam inseridas
                                                  descri&ccedil;&otilde;es iguais, entretanto alertamos para
                                                  que sejam diferentes em cada caso, porque em alguns
                                                  relat&oacute;rios apenas a descri&ccedil;&atilde;o
                                                  ser&aacute; apresentada.
                                                  </p>"><i id="w_fmiar_descricao" class="fa fa-dot-circle-o"></i>&nbsp;<i
                                                    class="fa fa-info-circle"></i>&nbsp;Descri&ccedil;&atilde;o</span></label>
                                        <div class="ui fluid corner labeled input">
                                            <input type="text" id="fmiar_descricao"
                                                   class="form-control input_style"
                                                   placeholder="Ex.: SISP 2.0, Roteiro ABC v1.0" required>
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
                                        <label for="fmiar_descricao">Observa&ccedil;&otilde;es</label>
                                        <textarea class="form-control input_style scroll" rows="4"
                                                  id="fmiar_observacoes"
                                                  placeholder="Observa&ccedil;&otilde;es sobre este roteiro"
                                                  maxlength="2000"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4" style="padding-top: 6px;">
                                    <label> <span class="pop" data-toggle="popover"
                                                  data-placement="bottom" data-title="<i 
                                                  class='fa fa-arrow-right'></i>&nbsp;Roteiro exclusivo"
                                                  data-content="
                                                  <p>
                                                  Voc&ecirc; pode inserir roteiros exclusivos tanto para
                                                  Clientes quanto para Fornecedores. Habilitando um ou o outro
                                                  a funcionalidade de compartilhamento de roteiro ser&aacute;
                                                  automaticamente desabilitada. Caso n&atilde;o selecione
                                                  nenhuma das op&ccedil;&otilde;es o roteiro ficar&aacute;
                                                  dispon&iacute;vel para sua organiza&ccedil;&atilde;o,
                                                  op&ccedil;&atilde;o <i>default</i> e recomendada na maioria
                                                  dos casos.<br />
                                                  <strong>ATEN&Ccedil;&Atilde;O</strong>: caso esta
                                                  op&ccedil;&atilde;o esteja desabilitada quando for
                                                  solicitada uma altera&ccedil;&atilde;o &eacute; porque o
                                                  roteiro j&aacute; est&aacute; sendo utilizado em alguma
                                                  contagem.
                                                  </p>"> <i class="fa fa-info-circle"></i>&nbsp;Roteiro
                                            exclusivo?</span></label>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control input_style"
                                               id="fmiar_is_exclusivo" type="checkbox" data-width="100" data-height="36"
                                               data-toggle="toggle" data-onstyle="primary"
                                               data-offstyle="success" data-style="slow"
                                               data-off="N&atilde;o" data-on="Sim">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <input id="chk_roteiro_exclusivo_1" type="radio"
                                           name="chk_generico" disabled> <label
                                           for="chk_roteiro_exclusivo_1"><span><span></span></span>&nbsp;&nbsp;Cliente</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <select id="generico_id_cliente"
                                                class="form-control input_style" disabled></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <input id="chk_roteiro_exclusivo_2" type="radio"
                                           name="chk_generico" disabled> <label
                                           for="chk_roteiro_exclusivo_2"><span><span></span></span>&nbsp;&nbsp;Fornecedor</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <select id="generico_id_fornecedor"
                                                class="form-control input_style" disabled>Fornecedor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fmiar_is_ativo">Status</label><br /> <input
                                            id="fmiar_is_ativo" type="checkbox" data-width="100" data-height="36"
                                            data-toggle="toggle" data-onstyle="success" data-style="slow"
                                            data-on="Ativo" data-off="Inativo" checked>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="fmiar_is_compartilhado"> <span class="pop"
                                                                                   data-toggle="popover" data-placement="bottom" data-title="<i 
                                                                                   class='fa fa-arrow-right'></i>&nbsp;Compartilhamento de
                                                                                   roteiros" data-content="
                                                                                   <p>O Dimension permite que voc&ecirc; compartilhe com
                                                                                   outras pessoas/empresas o seu roteiro, disponibilizando-o
                                                                                   publicamente. Um roteiro compartilhado deve ser importado
                                                                                   por outros, deixando o seu roteiro de forma intacta, ou
                                                                                   seja, quem importa um roteiro tem sua pr&oacute;pria
                                                                                   c&oacute;pia, podendo adapt&aacute;-la &agrave;s suas
                                                                                   necessidades. Caso voc&ecirc; altere o roteiro original
                                                                                   (este) o importado permanecer&aacute; da mesma forma.</p>"><i
                                                    class="fa fa-info-circle"></i>&nbsp;Privacidade</span>
                                        </label><br /> <input class="form-control input_style"
                                                              id="fmiar_is_compartilhado" type="checkbox" data-height="36"
                                                              data-toggle="toggle" data-width="100" data-onstyle="warning"
                                                              data-style="slow" data-on="P&uacute;blico" data-off="Privado"
                                                              class="datatoggle">
                                    </div>
                                </div>
                            </div>
                            <br />
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <img class="img-thumbnail" src="" alt="captcha"
                                             id="fmiar-img-captcha"
                                             onclick="refreshCaptcha($(this), $('#fmiar-txt-captcha'));"
                                             data-toggle="tooltip" data-placement="top"
                                             title="Clique na imagem para obter outro c&oacute;digo" /><br />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fa fa-dot-circle-o" id="fmiar-i-captcha"></i>&nbsp;<?php echo WORDING_REGISTRATION_CAPTCHA; ?><sup>*</sup></label>
                                        <div class="ui fluid corner labeled input">
                                            <input class="form-control input_style" type="text"
                                                   id="fmiar-txt-captcha" autocomplete="off" maxlength="4"
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
                                id="fmiar_btn_inserir"
                                onclick="$('#fmiar_acao').val('inserir');">
                            <i class="fa fa-save"></i> Salvar
                        </button>
                        <button type="button" class="btn btn-success"
                                id="fmiar_btn_novo" disabled>
                            <i class="fa fa-plus-circle"></i> Inserir outro
                        </button>
                        <button type="submit" class="btn btn-success"
                                id="fmiar_btn_atualizar"
                                onclick="$('#fmiar_acao').val('alterar');" disabled>
                            <i class="fa fa-refresh"></i> Atualizar
                        </button>
                        <button type="button" class="btn btn-warning"
                                id="fmiar_btn_fechar" onclick="limpaCamposRoteiro();"
                                data-dismiss="modal">
                            <i class="fa fa-times"></i> Fechar
                        </button>
                    </div></div>
            </form>
        </div>
    </div>
</div>