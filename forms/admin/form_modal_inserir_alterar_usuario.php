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
<div id="form_modal_inserir_usuario" class="modal fade" role="dialog">
    <form id="form_inserir_usuario">
        <input type="hidden" id="usr_id">
        <input type="hidden" id="usr_acao" value="inserir">
        <input type="hidden" id="frmiausu_user_id" value="0">
        <input type="hidden" id="frmiausu-opcao-identificador" value="0">
        <div class="modal-dialog modal-lg">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="link_fechar_usuario" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span>
                    </button>
                    <span id="span-titulo-usuario">&nbsp;&nbsp;<i class="fa fa-users"></i>&nbsp;&nbsp;Usu&aacute;rios e Grupos</span><br />
                    <span class="sub-header">Gerenciamento de perfis de usu&aacute;rios e grupos</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4><i class="fa fa-sitemap"></i>&nbsp;Informa&ccedil;&otilde;es de acesso</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="user_name">
                                            <i id="w_user_name" class="fa fa-dot-circle-o"></i>&nbsp;<?php echo WORDING_REGISTRATION_USERNAME; ?></label>
                                        <div class="btn-group btn-group-justified">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-success"
                                                        id="chk-opcao-cpf" data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="Utilizar o CPF, digite apenas os n&uacute;meros">
                                                    <img src="/pf/img/bandeira-brasil.gif">
                                                </button>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default"
                                                        id="chk-opcao-outro" data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="Voc&ecirc; pode utilizar outro identificador, mas lembre-se que este dever&aacute; ser &uacute;nico (entre 2 e 64 caracteres - letras, n&uacute;meros e ponto)">
                                                    <img src="/pf/img/globo.png">
                                                </button>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info"
                                                        data-toggle="popover" data-placement="bottom"
                                                        title="<i  
                                                        class='fa fa-arrow-right'>
                                                        </i>&nbsp;Informa&ccedil;&otilde;es sobre o Login"
                                                        data-content="<small> O Dimension&reg; aceita
                                                        v&aacute;rias formas de Login, entenda cada uma delas e
                                                        veja a que mais se adequa ao seu caso. De qualquer forma,
                                                        lembre-se que o email de cadastro &eacute; o ponto de
                                                        contato entre o sistema e o usu&aacute;rio, ou seja, ele
                                                        pode optar por logar pelo email ou pelo ID &Uacute;nico.
                                                        <table width='100%'
                                                        class='table table-striped table-condensed'>
                                                        <thead>
                                                        <tr>
                                                        <th>Tipo</th>
                                                        <th>Descri&ccedil;&atilde;o</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                        <td>CPF</td>
                                                        <td>Recomendamos que usu&aacute;rios <strong>brasileiros</strong>
                                                        fa&ccedil;am o login pelo CPF, pois &eacute; mais
                                                        espec&iacute;fico que o email. Utilize este tipo de
                                                        login se seus usu&aacute;rios trabalham para mais de
                                                        uma empresa.
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                        <td>Outro identificador</td>
                                                        <td>Algumas empresas nacionais/internacionais trabalham
                                                        com Logins do tipo NOME.SOBRENOME e voc&ecirc; pode
                                                        utilizar, se for o caso. Entretanto, por se tratar de
                                                        um <strong>login em nuvem</strong>, as
                                                        coincid&ecirc;ncias seriam muito frequentes.
                                                        Recomendamos este tipo de login como
                                                        exce&ccedil;&atilde;o, para empresas que est&atilde;o
                                                        fora do Brasil. Para ajudar, utilize a sigla da sua
                                                        Empresa antes do login. Ex.: PTEC_rubens.lyra.
                                                        </td>
                                                        </tr>
                                                        </tbody>
                                                        </table>
                                                        </small> "><i class="fa fa-info-circle fa-lg"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="user_name">Identificador &uacute;nico do usu&aacute;rio</label>
                                        <div class="input-group">
                                            <div class="ui fluid corner labeled input">
                                                <input class="form-control input_style verifica-id-usuario" id="user_name"
                                                       type="text" name="user_name" autocomplete="off" required />
                                                <div class="ui corner label">
                                                    <i class="asterisk icon"></i>
                                                </div>
                                            </div>
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-default"
                                                        id="btn-check-name" style="min-width: 97px;">
                                                    <i class="fa fa-check"></i>&nbsp;Validar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="user_email"> 
                                            <span class="pop"
                                                  data-toggle="popover" data-placement="bottom"
                                                  title="<i 
                                                  class='fa fa-arrow-right'></i>&nbsp;Valida&ccedil;&atilde;o
                                                  do email" data-content="
                                                  <p align='justify'>
                                                  <strong>OBSERVA&Ccedil;&Atilde;O</strong>: caso o email
                                                  digitado j&aacute; esteja cadastrado como um usu&aacute;rio
                                                  Dimension&reg;, voc&ecirc; deve apenas associ&aacute;-lo
                                                  a um perfil na sua Empresa e/ou Fornecedor.
                                                  </p>"> <i class="fa fa-info-circle"></i>&nbsp;<i
                                                    id="w_user_email" class="fa fa-dot-circle-o"></i>&nbsp;<?php echo WORDING_REGISTRATION_EMAIL; ?>
                                            </span>
                                        </label>
                                        <div class="input-group">
                                            <input class="form-control input_style" id="user_email"
                                                   type="email" name="user_email" autocomplete="off" disabled
                                                   required autofocus />
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-default"
                                                        id="btn-check-email" style="min-width: 97px;">
                                                    <i class="fa fa-check"></i>&nbsp;Validar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="user_complete_name">
                                            <i id="w_user_name" class="fa fa-dot-circle-o"></i>&nbsp;<?php echo WORDING_REGISTRATION_COMPLETE_USERNAME; ?>
                                        </label>
                                        <input class="form-control input_style"
                                               id="user_complete_name" type="text" autocomplete="off"
                                               maxlength="64" disabled required />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="checkbox" id="chk_id_fornecedor"
                                               class="css-checkbox" disabled /> <label
                                               for="chk_id_fornecedor" class="css-label-check"> <span
                                                class="pop" data-toggle="tooltip" data-placement="top"
                                                title="Os perfis de Auditor Externo e Financeiro n&atilde;o podem ser associados a Fornecedores / Alunos em Treinamento. O perfil de Validador Externo n&atilde;o pode ser associado a Alunos em Treinamento."><span
                                                    id="tip-usuario-fornecedor"></span></span>
                                        </label> <select id="user_id_fornecedor"
                                                         class="form-control input_style" disabled required>
                                            <option value="0">...</option>
                                        </select>
                                    </div>								
                                    <div class="form-group">
                                        <label for="grupos"> 
                                            <span class="pop" data-toggle="popover"
                                                  data-placement="bottom"
                                                  data-content="<p       
                                                  align='justify'>ATEN&Ccedil;&Atilde;O: algumas
                                                  funcionalidades dispon&iacute;veis para o perfil precisam
                                                  estar contratadas pelo plano da sua empresa. Por exemplo: um
                                                  Analista de M&eacute;tricas pode inserir contagens de
                                                  Licita&ccedil;&atilde;o apenas se a empresa contratou um
                                                  plano que tenha esta funcionalidade.
                                                  </p>" title="<i class='fa fa-arrow-right'></i>&nbsp;Restri&ccedil;&otilde;es
                                                  do plano contratado"> <i class="fa fa-info-circle"></i>&nbsp;<i
                                                    id="w_grupo" class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;Selecione um perfil
                                            </span>
                                        </label> <select id="role_id" class="form-control input_style"
                                                         disabled required>
                                            <option value="0">...</option>
                                        </select>
                                    </div>
                                    <?php if (!(isFornecedor() && getTipoFornecedor())) { ?>
                                        <div class="form-group">
                                            <label for="user_id_cliente"> 
                                                <span class="pop"
                                                      data-toggle="popover" data-placement="bottom"
                                                      title="<i 
                                                      class='fa fa-arrow-right'></i>&nbsp;Informa&ccedil;&atilde;o
                                                      do cliente" data-content="Caso esteja inserindo um Validador
                                                      Externo ou um Fiscal de Contrato, estes dever&atilde;o ser
                                                      identificados pelo Cliente ao qual est&atilde;o associados.
                                                      Voc&ecirc; tamb&eacute;m pode associar o Fiscal de Contrato
                                                      em um n&iacute;vel mais amplo, deixando de selecionar o
                                                      Fornecedor e/ou o Cliente."> <i class="fa fa-info-circle"></i>&nbsp;Selecione o cliente </span>
                                            </label> 
                                            <select id="user_id_cliente" class="form-control input_style" disabled required>
                                                <option value="0">...</option>
                                            </select>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    if (getUserName() === '41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265') {
                                        ?>
                                        <div class="form-group">
                                            <label for="41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265">Selecione
                                                a empresa</label> <select
                                                id="41b053cf7c9e8a38a30fa0fa20b6ea2e3bb16265"
                                                class="form-control input_style" required></select>
                                        </div>                                    
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>
                                                    <i class="fa fa-black-tie"></i>&nbsp;Outras caracter&iacute;sticas do usu&aacute;rio
                                                </label><br />
                                                <input type="checkbox" id="chk_is_validar_adm_gestor"
                                                       class="css-checkbox" disabled /> <label
                                                       for="chk_is_validar_adm_gestor" class="css-label-check pop"
                                                       data-toggle="tooltip" data-placement="bottom"
                                                       title="A op&ccedil;&atilde;o permite que Administradores e Analistas de M&eacute;tricas possam validar contagens. No momento a op&ccedil;&atilde;o est&aacute; <strong>
                                                       <?= isValidarAdmGestor() ? 'habilitada' : 'desabilitada'; ?></strong>
                                                       pelo Administrador." data-content=""><i
                                                        class="fa fa-info-circle"></i>&nbsp;O usu&aacute;rio pode validar contagens?</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="checkbox" id="is-inserir-contagem-auditoria"
                                                       class="css-checkbox" /> <label
                                                       for="is-inserir-contagem-auditoria"
                                                       class="css-label-check pop" data-toggle="tooltip"
                                                       data-placement="bottom"
                                                       title="Esta op&ccedil;&atilde;o permite que o usuário realize contagens de Auditoria que s&atilde;o aquelas em que o Fiscal do Contrato pode comparar, entre esta e a contagem de outro Fornecedor (geralmente uma F&aacute;brica de Software)"
                                                       data-content=""><i class="fa fa-info-circle"></i>&nbsp;O usu&aacute;rio insere contagens de Auditoria?</label>
                                            </div>
                                        </div>
                                        <br />
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <img class="img-thumbnail" alt="captcha"
                                                         id="fmiausu-img-captcha"
                                                         onclick="refreshCaptcha($(this), $('#fmiausu-txt-captcha'));"
                                                         data-toggle="tooltip" data-placement="top"
                                                         title="Clique na imagem para obter outro c&oacute;digo" /><br />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label><i class="fa fa-dot-circle-o" id="fmiausu-i-captcha"></i>&nbsp;<?php echo WORDING_REGISTRATION_CAPTCHA; ?></label>
                                                    <div class="ui fluid corner labeled input">
                                                        <input class="form-control input_style" type="text"
                                                               id="fmiausu-txt-captcha" name="captcha" autocomplete="off"
                                                               maxlength="4" disabled required />
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
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>
                                        <i class="fa fa-user-secret"></i>&nbsp;Autoriza&ccedil;&otilde;es de acesso do grupo
                                    </h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="scroll" style="width: 100%; min-height: 535px; max-height: 535px; overflow-x: hidden; overflow-y: scroll;">
                                        <table class="box-table-a" id="fixRole">
                                            <thead>
                                                <tr>
                                                    <th width="10%" align="center">Padr&atilde;o</th>
                                                    <th width="90%">Descri&ccedil;&atilde;o</th>
                                                </tr>
                                            </thead>
                                            <tbody id="addPermission"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">                            
                    <div class="btn-group" role="group" aria-label="...">
                        <button type="submit" class="btn btn-success"
                                id="btn_inserir_usuario"
                                onclick="$('#usr_acao').val('inserir');">
                            <i class="fa fa-save"></i> Salvar
                        </button>
                        <button type="button" class="btn btn-warning"
                                id="btn_fechar_usuario" onclick="limpaCamposUsuario(true);"
                                data-dismiss="modal">
                            <i class="fa fa-times"></i> Fechar
                        </button>
                    </div></div>
            </div>
        </div>
    </form>
</div>