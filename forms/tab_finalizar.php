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
<div class="panel panel-default">
    <div class="panel-title">
        <i class="fa fa-check-circle-o fa-lg"></i>&nbsp;&nbsp;Finalizar a contagem<br />
        <span class="sub-header">Selecione um validador interno ou valide automaticamente e defina a privacidade de sua contagem</span>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6" style="text-align: center;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h3><i class="fa fa-cogs"></i>&nbsp;&nbsp;Processo de valida&ccedil;&atilde;o interna</h3>
                            <?php
                            if (getConfigContagem('is_processo_validacao')) {
                                ?><h4><strong>As configura&ccedil;&otilde;es da sua empresa definem que o processo de valida&ccedil;&atilde;o interna &eacute; obrigat&oacute;rio.</strong></h4>
                                <?php
                            } else {
                                ?>
                                <h4><strong>Deseja utilizar o processo de valida&ccedil;&atilde;o para esta contagem?</strong></h4>
                                <input id="chk_is_processo_validacao_1" type="radio" name="chk_processo_validacao" checked> <label for="chk_is_processo_validacao_1"><span><span></span></span>&nbsp;&nbsp;Sim</label>
                                <input id="chk_is_processo_validacao_2" type="radio" name="chk_processo_validacao"> <label for="chk_is_processo_validacao_2"><span><span></span></span>&nbsp;&nbsp;N&atilde;o</label>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="btn-group">
                                <button type="button" class="btn btn-success" id="btn-validar-contagem" disabled><i class="fa fa-refresh"></i> Validar automaticamente</button>
                                <!-- atualizar contagem - ac -->
                                <button type="button" class="btn btn-success" id="btn-selecionar-validador" data-target="#form-modal-selecionar-validador"><i class="fa fa-user-plus"></i> Selecionar um validador</button>
                                <!-- selecionar validador - sv -->
                                <button type="button" class="btn btn-success" id="btn-enviar-validacao" disabled><i class="fa fa-check"></i> Enviar para valida&ccedil;&atilde;o</button>
                            </div>
                            <input type="hidden" id="is_processo_validacao" value="1">
                            <input type="hidden" id="email-validador">
                        </div>
                    </div>
                </div>
                <?php
                if (isFornecedor() && getTipoFornecedor()) {
                    ?>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                            <div style="border: 2px dotted #f68; padding: 8px; border-radius: 5px;">
                                Esta contagem est&aacute; sendo feita por um Aluno em uma <kbd>Turma de treinamento</kbd>, desta forma o processo de sele&ccedil;&atilde;o para valida&ccedil;&atilde;o interna &eacute; dispensado. Para validar basta que voc&ecirc; clique em <kbd><i class="fa fa-refresh"></i>&nbsp;Validar Automaticamente</kbd>.
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8" style="text-align: center;">
                        <div class="badge" style="visibility: hidden; padding: 15px; display: inline-block; width: 100%;" id="div-validador">
                            <button id="btn-validador-selecionado" onclick="limpaValidador();" type="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="tooltip" data-placement="bottom" title="Fechar e selecionar outro validador"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                            <img id="img-validador" class="img-circle" width="120" height="120" border="0" /><br /><br />
                            <span id="validador-selecionado"></span>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
            <div class="col-md-6">
                <h3><i class="fa fa-user-secret"></i>&nbsp;&nbsp;Privacidade da contagem</h3>
                <div>
                    <strong>ATEN&Ccedil;&Atilde;O</strong> - Caso n&atilde;o selecione uma privacidade, a contagem ser&aacute; tratada como PRIVADA.<br />
                </div>
                <ul class="fa-ul">
                    <li style="margin-bottom: 4px;"><i class="fa fa-arrow-right"></i>&nbsp;<spanclass="badge"><strong>P&Uacute;BLICA</strong></span> - Qualquer usu&aacute;rio, dentro da sua organiza&ccedil;&atilde;o, poder&aacute; visualizar a contagem;</li>
                        <li style="margin-bottom: 4px;"><i class="fa fa-arrow-right"></i>&nbsp;<span class="badge"><strong>PRIVADA</strong></span> - Apenas os envolvidos e/ou autorizados poder&atilde;o visualizar a contagem (Gerente doprojeto, Analista de M&eacute;tricas, Gestor, etc).</li>
                </ul>
                <div class="form-group">
                    <label for="privacidade">Selecione a privacidade da contagem:</label>&nbsp;&nbsp;
                    <input class="privacidade" id="privacidade" type="checkbox" data-width="120" data-height="36" data-toggle="toggle" data-onstyle="info" data-offstyle="warning" data-style="slow" data-on="<i  class='fa fa-lock'></i>&nbsp;&nbsp;Privada" data-off="<i class='fa fa-unlock'></i>&nbsp;&nbsp;P&uacute;blica" checked>
                    &nbsp;&nbsp;<strong><span id="span-privacidade"></span></strong>
                </div>
            </div>
        </div>
    </div>
</div>
