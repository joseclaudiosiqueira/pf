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
<div id="form_modal_inserir_alterar_fornecedor" class="modal fade" role="dialog">
    <form id="form_inserir_alterar_fornecedor">
        <div class="modal-dialog modal-lg">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="forn-fechar" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <i class="fa fa-building-o" id="i-forn-titulo"></i>&nbsp;&nbsp;<span id="span-forn-titulo">Fornecedores</span><br />
                    <span class="sub-header">Gestão de Fornecedores e/ou Turmas de Treinamento</span>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="forn-id" name="forn-id" value="">
                    <input type="hidden" id="forn-acao" name="forn-acao" value="inserir">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4><i class="fa fa-user"></i>&nbsp;<span id="h4-forn-titulo">Informa&ccedil;&otilde;esdo Fornecedor</span></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="forn-sigla">Sigla</label>
                                        <div class="ui fluid corner labeled input">
                                            <input class="form-control input_style" id="forn-sigla"
                                                   type="text" autocomplete="off" maxlength="45"
                                                   placeholder="M&aacute;x. 45" autofocus required />
                                            <div class="ui corner label">
                                                <i class="asterisk icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="forn-nome">Nome do fornecedor</label>
                                        <div class="ui fluid corner labeled input">
                                            <input class="form-control input_style" id="forn-nome"
                                                   type="text" autocomplete="off" required />
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
                                        <label for="forn-preposto-nome">Preposto (nome)</label>
                                        <div class="ui fluid corner labeled input">
                                            <input class="form-control input_style"
                                                   id="forn-preposto-nome" type="text" autocomplete="off"
                                                   placeholder="Fulano" required />
                                            <div class="ui corner label">
                                                <i class="asterisk icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="forn-preposto-email">Preposto (email)</label>
                                        <div class="ui fluid corner labeled input">
                                            <input class="form-control input_style"
                                                   id="forn-preposto-email" type="email" autocomplete="off"
                                                   placeholder="fulano@abc.com/br" required />
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
                                        <label for="forn-preposto-email-alternativo">Preposto (email
                                            alternativo)</label> <input class="form-control input_style"
                                                                    id="forn-preposto-email-alternativo" type="email"
                                                                    autocomplete="off" placeholder="beltrano@abc.com/br" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="forn-preposto-telefone">Telefone</label>
                                        <div class="ui fluid corner labeled input">
                                            <input class="form-control input_style"
                                                   id="forn-preposto-telefone" type="text" autocomplete="off"
                                                   data-mask="(00) 0000-00009" placeholder="(00) 0000-0000"
                                                   required />
                                            <div class="ui corner label">
                                                <i class="asterisk icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="forn-preposto-ramal">Ramal</label> <input
                                            class="form-control input_style" id="forn-preposto-ramal"
                                            type="text" autocomplete="off" data-mask="0000"
                                            placeholder="0000" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="forn-preposto-telefone-celular">Telefone celular</label>
                                        <input class="form-control input_style"
                                               id="forn-preposto-telefone-celular" type="text"
                                               autocomplete="off" data-mask="(00) 0000-00009"
                                               placeholder="(00) 0000-0000" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="forn-is-ativo">Status</label> <input
                                            id="forn-is-ativo" type="checkbox" data-toggle="toggle"
                                            data-width="100" data-height="36" data-onstyle="success" data-style="slow"
                                            data-on="Ativo" data-off="Inativo" checked>
                                    </div>
                                </div>
                            </div>
                            <!--inutilidade :-)
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="p-forn">&nbsp;</label>
                                        <p id="p-forn">
                                            Apenas
                                            <kbd id="kbd-titulo">fornecedores</kbd>
                                            &lt;&lt;ATIVOS(AS)&gt;&gt; trabalham no sistema.
                                        </p>
                                    </div>
                                </div>
                            </div>-->
                            <br />
                            <div class="row">
                                <div class="col-md-6"></div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <img class="img-thumbnail" alt="captcha"
                                             onclick="refreshCaptcha($(this), $('#fmiafor-txt-captcha'));"
                                             data-toggle="tooltip" data-placement="top"
                                             title="Clique na imagem para obter outro c&oacute;digo"
                                             id="fmiafor-img-captcha" /><br />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><i class="fa fa-dot-circle-o" id="fmiafor-i-captcha"></i>&nbsp;<?php echo WORDING_REGISTRATION_CAPTCHA; ?> </label>
                                        <div class="ui fluid corner labeled input">
                                            <input class="form-control input_style" type="text"
                                                   id="fmiafor-txt-captcha" autocomplete="off" maxlength="4"
                                                   required />
                                            <div class="ui corner label">
                                                <i class="asterisk icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>
                                        <i class="fa fa-camera"></i>&nbsp;Logomarca para os relat&oacute;rios
                                    </h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <iframe
                                        style="border: 1px dotted #999; width: 100%; height: 565px; overflow: hidden; border-radius: 5px;"
                                        src="/pf/vendor/cropper/producao/crop/index.php?t=forn"
                                        id="avatar-frame-forn"
                                        class="scroll"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn-group" role="group" aria-label="...">
                        <button type="submit" class="btn btn-success"
                                id="forn-btn-inserir" onclick="$('#forn-acao').val('inserir');">
                            <i class="fa fa-save"></i> Salvar
                        </button>
                        <button type="button" class="btn btn-success" id="forn-btn-novo"
                                disabled>
                            <i class="fa fa-plus-circle"></i> Inserir outro
                        </button>
                        <button type="submit" class="btn btn-success"
                                id="forn-btn-atualizar"
                                onclick="$('#forn-acao').val('alterar');" disabled>
                            <i class="fa fa-refresh"></i> Atualizar
                        </button>
                        <button type="button" class="btn btn-warning"
                                id="forn-btn-fechar" onclick="limpaCamposFornecedor();"
                                data-dismiss="modal">
                            <i class="fa fa-times"></i> Fechar
                        </button>
                    </div>                
                </div>
            </div>
        </div>
    </form>
</div>