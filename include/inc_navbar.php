<?php
/*
 * actions, forms e jsons nao podem ser chamados diretamente
 */
if (stripos($_SERVER['SCRIPT_NAME'], basename(__FILE__))) {
    header('Location: /pf/nao_autorizado.php');
    die();
}
/*
 * seta a classe de tarefas para pegar as tarefas pendentes
 */
$tarefas = new Tarefa();
$pendentes = $tarefas->getQuantidadeTarefasPendentes()['qtd'];
?>
<nav class="navbar navbar-inverse navbar-fixed-top" style="padding-top: 2px;">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed"
                    data-toggle="collapse" data-target="#navbar" aria-expanded="false"
                    aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span> <span
                    class="icon-bar"></span> <span class="icon-bar"></span> <span
                    class="icon-bar"></span>
            </button>
            <div style="margin-top: 10px; color: #fff; margin-right: 20px; line-height: 30px; min-width: 128px;">
                <img src="/pf/img/logo_200px.png" class="img-responsive" width="36" height="30" align="left">&nbsp;&nbsp;&nbsp;Dimension
            </div>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <?php
            /*
             * desabilita os botoes e links de acao da pagina de acordo com o perfil e a acao solicitada
             * $bt[0][0] - inserir/atualizar informacoes
             * $bt[0][1] - solicitar revisao
             * $bt[0][2] - observacoes (ver/inserir)
             * $bt[0][3][0] - validar interna
             * $bt[0][3][1] - validar externa
             * $bt[0][3][2] - auditar interna
             * $bt[0][3][3] - auditar externa
             * $bt[0][4] - botao do menu caso seja uma das quatro opcoes acima
             * $bt[0][5] - salvar contagem
             * $bt[0][6] - relatorios de validacoes e auditorias
             *
             * TODO: IMPORTANTE - Os cliques nas tabs desabilitam o botao "Inserir/Atualizar informacoes"
             */
            ?>
            <ul class="nav navbar-nav"
                style="border-left: 1px solid #333; border-right: 1px solid #333;">
                    <?php echo $bt[0][0] === 'disabled' ? NULL : '<li style="background-color: #111; display: inline-block; margin: 0;" data-toggle="tooltip" data-placement="bottom" title="Salvar as informa&ccedil;&otilde;es" class="salvar-contagem" id="salvar-contagem"><a href="#"><i class="fa fa-floppy-o fa-lg id-contagem"></i></a></li>'; ?>
                    <?php echo $bt[0][1] === 'disabled' ? NULL : '<li style="background-color: #111; display: inline-block; margin: 0;" data-toggle="tooltip" data-placement="bottom" title="Solicitar revis&atilde;o na contagem" class="solicitar-revisao" id="solicitar-revisao"><a href="#"><i class="fa fa-pencil-square-o fa-lg c-revisao"></i></a></li>'; ?>
                    <?php echo $bt[0][6] === 'disabled' ? NULL : '<li style="background-color: #111; display: inline-block; margin: 0;" data-toggle="tooltip" data-placement="bottom" title="Apontes de valida&ccedil;&otilde;es e auditorias)" class="relatorio-apontes" id="relatorio-apontes"><a href="#"><i class="fa fa-file-text-o fa-lg c-apontes"></i></a></li>'; ?>
                    <?php echo $bt[0][3][0] === 'disabled' ? NULL : '<li style="background-color: #111; display: inline-block; margin: 0;" data-toggle="tooltip" data-placement="bottom" title="Finalizar a valida&ccedil;&atilde;o interna da contagem" class="finalizar-v-interna" id="finalizar-v-interna"><a href="#"><i class="fa fa-sign-in fa-lg v-interna"></i></a></li>'; ?>
                    <?php echo $bt[0][3][1] === 'disabled' ? NULL : '<li style="background-color: #111; display: inline-block; margin: 0;" data-toggle="tooltip" data-placement="bottom" title="Finalizar a valida&ccedil;&atilde;o externa da contagem" class="finalizar-v-externa" id="finalizar-v-externa"><a href="#"><i class="fa fa-sign-out fa-lg v-externa"></i></a></li>'; ?>
                    <?php echo $bt[0][3][2] === 'disabled' ? NULL : '<li style="background-color: #111; display: inline-block; margin: 0;" data-toggle="tooltip" data-placement="bottom" title="Finalizar a auditoria interna da contagem" class="<?= $bt[0][3][2]; ?> finalizar-a-interna" id="finalizar-a-interna"><a href="#"><i class="fa fa-flag-checkered fa-lg a-interna"></i></a></li>'; ?>
                    <?php echo $bt[0][3][3] === 'disabled' ? NULL : '<li style="background-color: #111; display: inline-block; margin: 0;" data-toggle="tooltip" data-placement="bottom" title="Finalizar a auditoria externa da contagem" class="<?= $bt[0][3][3]; ?> finalizar-a-externa" id="finalizar-a-externa"><a href="#"><i class="fa fa-flag-o fa-lg a-externa"></i></a></li>'; ?>
                    <?php echo $bt[0][4] === 'disabled' ? NULL : '<li style="background-color: #111; display: inline-block; margin: 0;" data-toggle="tooltip" data-placement="bottom" title="Finalizar a revis&atilde;o e enviar para valida&ccedil;&atilde;o" class="<?= $bt[0][4]; ?> finalizar-revisao" id="finalizar-revisao"><a href="#"><i class="fa fa-check-square-o fa-lg f-revisao"></i></a></li>'; ?>
            </ul>
            <ul class="nav navbar-nav">
                <li class="dropdown"><a href="#" class="dropdown-toggle"
                                        data-toggle="dropdown" role="button" aria-expanded="false"><i
                            class="fa fa-chevron-down"></i> Arquivo</a>
                    <ul class="dropdown-menu" role="menu" id="menu-arquivo">
                        <?php echo (getPermissao('form_inserir_alterar_contagem_livre') && getPermissao('inserir_contagem') && getConfigPlano('contagem_' . $array_page_context[1])) ? '<li><a href="#" id="contagem_livre"><i class="fa fa-unlink"></i>&nbsp;&nbsp;<strong>Inserir</strong> contagem livre</a></li>' : NULL; ?>
                        <?php echo (getPermissao('form_inserir_alterar_contagem_livre') && getPermissao('inserir_contagem') && getConfigPlano('contagem_' . $array_page_context[1]) && getVariavelSessao('is_inserir_contagem_auditoria')) ? '<li><a href="#" id="contagem_auditoria"><i class="fa fa-user-secret"></i>&nbsp;&nbsp;<strong>Inserir</strong> contagem auditoria</a></li>' : NULL; ?>
                        <?php echo (getPermissao('form_inserir_alterar_contagem_projeto') && getPermissao('inserir_contagem') && getconfigPlano('contagem_' . $array_page_context[2]) && (isFornecedor() && getTipoFornecedor() ? false : true)) ? '<li><a href="#" id="contagem_projeto"><i class="fa fa-sitemap"></i>&nbsp;&nbsp;<strong>Inserir</strong> contagem de projeto</a></li>' : NULL; ?>
                        <?php echo (getPermissao('form_inserir_alterar_contagem_baseline') && getPermissao('inserir_contagem') && getConfigPlano('contagem_' . $array_page_context[3]) && (isFornecedor() && getTipoFornecedor() ? false : true)) ? '<li><a href="#" id="contagem_baseline"><i class="fa fa-sliders"></i>&nbsp;&nbsp;<strong>Inserir</strong> contagem de baseline</a></li>' : NULL; ?>
                        <?php //echo (getPermissao('form_inserir_alterar_contagem_licitacao') && getPermissao('inserir_contagem') && getConfigPlano('contagem_' . $array_page_context[4]) && (isFornecedor() && getTipoFornecedor() ? false : true)) ? '<li><a href="#" id="contagem_licitacao"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;<strong>Inserir</strong> contagem de licita&ccedil;&atilde;o</a></li>' : NULL; ?>
                        <?php echo (getPermissao('form_inserir_alterar_contagem_snap') && getPermissao('inserir_contagem') && getconfigPlano('contagem_' . $array_page_context[5])) ? '<li><a href="#" id="contagem_snap"><i class="fa fa-cogs"></i>&nbsp;&nbsp;<strong>Inserir</strong> contagem SNAP</a></li>' : NULL; ?>
                        <?php echo (getPermissao('form_inserir_alterar_contagem_apt') && getPermissao('inserir_contagem') && getConfigPlano('contagem_' . $array_page_context[6])) ? '<li><a href="#" id="contagem_apt"><i class="fa fa-bug"></i>&nbsp;&nbsp;<strong>Inserir</strong> contagem APT</a></li>' : NULL; ?>
                        <?php echo (getPermissao('form_inserir_alterar_contagem_ef') && getPermissao('inserir_contagem') && getConfigPlano('contagem_' . $array_page_context[9])) ? '<li><a href="#" id="contagem_ef"><i class="fa fa-tachometer"></i>&nbsp;&nbsp;<strong>Inserir</strong> contagem EF (d/t)</a></li>' : NULL; ?>
                    </ul></li>
                <li class="dropdown"><a href="#" class="dropdown-toggle"
                                        data-toggle="dropdown" role="button" aria-expanded="false"><i
                            class="fa fa-chevron-down"></i> Ferramentas</a>
                    <ul class="dropdown-menu" role="menu" id="menu-administracao">
                        <li><a href="#" id="listar-contagens"><i class="fa fa-list"></i>&nbsp;&nbsp;<strong>Listar</strong>
                                contagens</a></li>
                        <li><a href="#" id="listar-minhas-contagens"><i class="fa fa-user"></i>&nbsp;&nbsp;<strong>Listar</strong>
                                minhas contagens</a></li>
                        <!--
                        <li><a href="#" id="listar-contagens-acesso"><i class="fa fa-users"></i>&nbsp;&nbsp;<strong>Listar</strong> contagens que tenho acesso</a></li>-->
                        <?php echo getPermissao('listar_contagens_em_faturamento') && !(getTipoFornecedor()) ? '<li><a href="#" id="listar-contagens-em-faturamento"><i class="fa fa-check"></i>&nbsp;&nbsp;<strong>Listar</strong> contagens em faturamento</a></li>' : NULL; ?>
                        <?php echo getPermissao('listar_contagens_faturamento_autorizado') && !(getTipoFornecedor()) ? '<li><a href="#" id="listar-contagens-faturamento-autorizado"><i class="fa fa-flag-checkered"></i>&nbsp;&nbsp;<strong>Listar</strong> contagens faturamento autorizado</a></li>' : NULL; ?>
                        <?php echo getPermissao('listar_contagens_faturadas') && !(getTipoFornecedor()) ? '<li><a href="#" id="listar-contagens-faturadas"><i class="fa fa-money"></i>&nbsp;&nbsp;<strong>Listar</strong> contagens faturadas</a></li>' : NULL; ?>
                        <?php echo getPermissao('listar_contagens_baseline') && !(getTipoFornecedor()) ? '<li><a href="#" id="listar-contagens-baseline"><i class="fa fa-sliders"></i>&nbsp;&nbsp;<strong>Listar</strong> Baselines</a></li>' : NULL; ?>
                        <?php echo ($isFiscalContrato || $isFiscalContratoEmpresa || $isFiscalContratoFornecedor) ? '<li><a href="#" id="listar-contagens-analise"><i class="fa fa-user-secret"></i>&nbsp;&nbsp;<strong>Listar</strong> minhas an&aacute;lises</a></li>' : NULL; ?>
                        <?php //echo getPermissao('listar_contagens_licitacao') && !(getTipoFornecedor()) ? '<li><a href="#" id="listar-contagens-licitacao"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;<strong>Listar</strong> contagens (licita&ccedil&otilde;es)</a></li>' : NULL; ?>
                        <li class="divider"></li>
                        <li><a href="#" id="listar-tarefas-pendentes"><i
                                    class="fa fa-calendar"></i>&nbsp;&nbsp;<strong>Minhas tarefas</strong>
                                pendentes</a></li>
                        <li><a href="#" id="listar-tarefas-solicitante"><i
                                    class="fa fa-calendar-plus-o"></i>&nbsp;&nbsp;<strong>Tarefas
                                    pendentes </strong> que solicitei</a></li>
                        <!--esta opcao utiliza a permissao de contagem_baseline-->
                        <?php echo (getPermissao('form_gerenciar_baselines') && getConfigPlano('contagem_' . $array_page_context[3]) && !isFornecedor()) ? '<li class="divider"></li><li><a href="#" id="link-gerenciar-baseline" data-toggle="modal" data-target="#form-modal-gerenciar-baseline"><i class="fa fa-line-chart"></i>&nbsp;&nbsp;<strong>Gerenciar</strong> Baselines</a></li>' : NULL; ?>
                        <?php echo (getPermissao('form_gerenciar_orgao') && (getVariavelSessao('isGestor') || getVariavelSessao('isAdministrador'))) ? '<li><a href="#" class="link-gerenciar-orgao" data-toggle="modal" data-target="#form-modal-gerenciar-orgao"><i class="fa fa-sitemap"></i>&nbsp;&nbsp;<strong>Gerenciar</strong> &Oacute;rg&atilde;os</a></li>' : NULL; ?>
                        <!--&& !isFornecedor()-->
                        <?php echo (getPermissao('form_dashboard')) ? (getPermissao('form_gerenciar_baselines') ? '' : '<li class="divider"></li>') . '<li><a href="#" id="link-form-dashboard"><i class="fa fa-area-chart"></i>&nbsp;&nbsp;<strong>Dashboards</strong></a></li>' : NULL; ?>
                        <!--//-->
                        <?php echo (getPermissao('form_financeiro')) || (getPermissao('administracao')) ? '<li class="divider"></li>' : NULL; ?>
                        <?php echo (getPermissao('form_financeiro')) ? '<li><a href="#" id="link-financeiro" data-toggle="modal" data-target="#form-financeiro"><i class="fa fa-dollar"></i>&nbsp;&nbsp;M&oacute;dulo Financeiro</a></li>' : NULL; ?>
                        <?php echo (getPermissao('administracao')) ? '<li><a id="administracao" href="#"><i class="fa fa-tasks"></i>&nbsp;&nbsp;M&oacute;dulo administrativo</a></li>' : NULL; ?>
                    </ul></li>
                <li><a href="#"
                       onclick="sobre();
                               return false;"><i
                            class="fa fa-info-circle fa-lg"></i>&nbsp;Sobre</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <div data-toggle="tooltip" data-placement="bottom"
                         title="Minhas tarefas pendentes"
                         style="cursor: default; cursor: pointer; width: 48px; height: 48px; border-radius: 24px; line-height: 48px; background-color: #ffcc66; text-align: center; font-weight: bold;"
                         id="navbar-listar-tarefas-pendentes"><?= $pendentes; ?></div>
                </li>
                <li><span> <span
                            style="cursor: default; cursor: pointer; color: #fff;"
                            class="label not-show" id="perfil_usuario" data-toggle="popover"
                            data-placement="bottom" email="<?= $_SESSION['user_email']; ?>"
                            title="<i  class='fa fa-arrow-right'></i>&nbsp;Perfil do
                            usu&aacute;rio" data-content='
                            <center>
                            <img class="img-circle" width="148" height="148"
                            src="<?= getGravatarImageUser(getUserIdSha1()); ?>"
                            id="img-perfil-popover"> <br />
                            <?= getCompleteName(); ?> - <?= getUserRole(true); ?><br />
                            <br /> <a href="mailto:<?= getEmailUsuarioLogado(); ?>"><?= getEmailUsuarioLogado(); ?></a><br />
                            <br />
                            <button type="button" class="btn btn-success"
                            data-toggle="modal" data-target="#form_modal_user_detail"
                            onclick="detailLink();">
                            <i class="fa fa-arrow-circle-right"></i>&nbsp;Completar o
                            perfil e/ou alterar a foto.
                            </button>
                            &nbsp;'>
                            </center> <img class="img-circle" width="48" height="48"
                                           src="<?= getGravatarImageUser(getUserIdSha1()); ?>"
                                           align="absmiddle" id="img-perfil-nav-bar"
                                           style="border: 1px solid #666;">&nbsp;&nbsp;<?= getNomeCurto($_SESSION['complete_name']) . ' . ' . getPathEmpresaFornecedor(); ?></span>
                        <a style="color: #fff;" href="/pf/index.php?logout">.&nbsp;<i
                                class="fa fa-sign-out fa-lg"></i>&nbsp;<?= WORDING_LOGOUT; ?></a>&nbsp;&nbsp;
                    </span></li>
            </ul>
        </div>
    </div>
</nav>
<?php include DIR_BASE . 'forms/user/form_modal_user_detail.php'; ?>
<?php include DIR_BASE . 'forms/form_modal_listar_tarefas_pendentes.php'; ?>
<?php include DIR_BASE . 'forms/form_modal_listar_tarefas_solicitante.php'; ?>
<?php (getPermissao('form_gerenciar_baselines') && getConfigPlano('contagem_' . $array_page_context[3]) && !isFornecedor()) ? include DIR_BASE . 'forms/form_modal_gerenciar_baseline.php' : NULL; ?>
<?php (getPermissao('form_gerenciar_orgao') && (getVariavelSessao('isGestor') || getVariavelSessao('isAdministrador'))) ? include DIR_BASE . 'forms/form_modal_gerenciar_orgao.php' : NULL; ?>
<?php include DIR_BASE . 'forms/form_modal_apontes.php'; ?>