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
<div id="form_modal_configuracoes_contagem" class="modal fade"
     role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <form id="form_configuracoes_contagem">
                <div class="modal-header">
                    <button type="button" id="fechar_configuracoes_contagem" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <i class="fa fa-file-text fa-lg"></i>&nbsp;&nbsp;Configura&ccedil;&otilde;es das contagens<br />
                    <span class="sub-header">Adeque o sistema &agrave; sua forma e m&eacute;todos de trabalho, configure os tempos das atividades, fases e muito mais...</span>
                </div>
                <div class="modal-body">
                    <div class="panel-group" id="accordion-configuracoes-contagem">
                        <div class="panel panel-default">
                            <div class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion-configuracoes-contagem" href="#collapse-configuracoes-contagem-empresa"> <i class="fa fa-chevron-down"></i>&nbsp;Configura&ccedil;&otilde;es gen&eacute;ricas - Empresa</a>
                            </div>
                            <div id="collapse-configuracoes-contagem-empresa"
                                 class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><span class="pop" data-toggle="popover"
                                                             data-placement="bottom" data-content="<p  align='justify'>A
                                                             quantidade m&aacute;xima permitida pelo sistema
                                                             Dimension &eacute; 99 (noventa e nove) e a default
                                                             &eacute; 20 (vinte).
                                                             </p>"title="<i class='fa fa-arrow-right'></i>&nbsp;Quantidade
                                                             de entregas"><i class="fa fa-info-circle"></i> Quantidade
                                                        m&aacute;xima de entregas nas contagens
                                                    </span><br /> </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="text"
                                                       class="form-control input-sm input_style_spin spinnumber"
                                                       placeholder="Quantidade" id="quantidade_maxima_entregas"
                                                       value="" maxlength="2" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><span class="pop" data-toggle="popover"
                                                             data-placement="bottom"
                                                             data-content="<p    
                                                             align='justify'>Se o processo de valida&ccedil;&atilde;o
                                                             &eacute; facultativo na sua empresa/optativo pelo seu
                                                             Cliente, deixe que os Analistas de M&eacute;tricas
                                                             escolham se v&atilde;o enviar ou n&atilde;o as contagens
                                                             para valida&ccedil;&atilde;o. <strong>LEMBRE-SE que este
                                                             &eacute; o processo de valida&ccedil;&atilde;o interno,
                                                             as valida&ccedil;&otilde;es externas e auditorias
                                                             continuam da mesma forma.
                                                             </p>" title="<i class='fa fa-arrow-right'></i>&nbsp;Processo
                                                             de Valida&ccedil;&atilde;o"><i class="fa fa-info-circle"></i>
                                                        O processo de valida&ccedil;&atilde;o &eacute;
                                                        obrigat&oacute;rio? 

                                                    </span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="checkbox" data-toggle="toggle"
                                                       data-size="small" data-width="60" data-onstyle="success"
                                                       data-style="slow" data-on="Sim" data-off="N&atilde;o"
                                                       id="is_processo_validacao">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label><span class="pop" data-toggle="popover"
                                                         data-placement="bottom"
                                                         data-content="<p     
                                                         align='justify'>O Dimension&copy; oferece a possibilidade
                                                         das empresas compartilharem seus roteiros de
                                                         m&eacute;tricas, tornando-os p&uacute;blicos. Nas
                                                         op&ccedil;&otilde;es abaixo voc&ecirc; decide se sua equipe
                                                         de Analistas de M&eacute;tricas pode importar ou n&atilde;o
                                                         os itens de roteiros p&uacute;blicos.
                                                         </p>" title="<i class='fa fa-arrow-right'></i>&nbsp;Roteiros
                                                         p&uacute;blicos&reg;"><i class="fa fa-info-circle"></i>
                                                    Importar roteiros p&uacute;blicos&reg;
                                                </span></label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="checkbox" data-toggle="toggle"
                                                       data-size="small" data-width="60" data-onstyle="success"
                                                       data-style="slow" data-on="Sim" data-off="N&atilde;o"
                                                       id="is_visualizar_roteiros_publicos">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label><span id="pop_content_adm_validar" class="pop"
                                                         data-toggle="popover" data-placement="bottom"
                                                         data-content="" title="<i        class='fa fa-arrow-right'></i>&nbsp;Valida&ccedil;&otilde;es"><i
                                                        class="fa fa-info-circle"></i> Administradores e/ou
                                                    Analistas de M&eacute;tricas validam contagens? </span> </label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="checkbox" data-toggle="toggle"
                                                       data-size="small" data-width="60" data-onstyle="success"
                                                       data-style="slow" data-on="Sim" data-off="N&atilde;o"
                                                       id="is_validar_adm_gestor">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label><span class="pop" data-toggle="popover"
                                                         data-placement="bottom"
                                                         data-content="O Dimension inclui automaticamente, caso esteja habilitada a op&ccedil;&atilde;o de CRUD, tr&ecirc;s fun&ccedil;&otilde;es de transa&ccedil;&atilde;o de Entrada Externa-EE e uma Consulta Externa-CE. Caso voc&ecirc; permita, o Analista pode excluir individualmente cada linha inserida ou s&oacute; poder&aacute; excluir as linhas se a fun&ccedil;&atilde;o principal inclu&iacute;da ALI for exclu&iacute;da."
                                                         title="<i  class='fa fa-arrow-right'></i>&nbsp;Excluir
                                                         fun&ccedil;&otilde;es CRUD"><i class="fa fa-info-circle"></i>
                                                    Fun&ccedil;&otilde;es de CRUD podem ser exclu&iacute;das
                                                    individualmente?</span></label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="checkbox" data-toggle="toggle"
                                                       data-size="small" data-width="60" data-onstyle="success"
                                                       data-style="slow" data-on="Sim" data-off="N&atilde;o"
                                                       id="is_excluir_crud_independente">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label><span class="pop" data-toggle="popover"
                                                         data-placement="bottom"
                                                         data-content="
                                                         <div
                                                         class='row'>
                                                         <div class='col-md-12'>
                                                         <p align='justify'>ALERTA: permitir que os Analistas
                                                         possam alterar a produtividade global no momento das
                                                         contagens ajuda a estabelecer uma base de conhecimento
                                                         mais confi&aacute;vel.</p>
                                                         </div>
                                                         </div>
                                                         <div class='row'>
                                                         <div class='col-md-12'>
                                                         <img
                                                         src='/pf/img/ajuda/img_ajuda_alterar_produtividade_global.png'
                                                         class='img-thumbnail'>
                                                         </div>
                                                         </div>
                                                         " title="<i class='fa fa-arrow-right'></i>&nbsp;Produtividade
                                                         global"><i class="fa fa-info-circle"></i> Alterar a
                                                    produtividade durante a elabora&ccedil;&atilde;o das
                                                    contagens?</span> </label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="checkbox" data-toggle="toggle" data-size="small"
                                                       data-width="60" data-onstyle="success" data-style="slow"
                                                       data-on="Sim" data-off="N&atilde;o"
                                                       id="is_alterar_produtividade_global">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label><span class="pop" data-toggle="popover"
                                                         data-placement="bottom" data-content="<p      

                                                         align='justify'>A produtividade global (h/PF) inserida aqui
                                                         servir&aacute; de base apenas para as estimativas das
                                                         contagens. Clique na op&ccedil;&atilde;o e insira a
                                                         produtividade global, em horas, ou insira a produtividade
                                                         por fases.
                                                         </p>" title="<i class='fa fa-arrow-right'></i>&nbsp;Produtividade
                                                         global"><i class="fa fa-info-circle"></i> Utilizar a
                                                    produtividade global nas fases?
                                                </span><br />
                                                <div class="label label-danger"
                                                     style="visibility: hidden; font-weight: normal; white-space: normal; position: absolute; top: 17px; left: 17px; box-shadow: 3px 5px 5px #666; z-index: 5096;"
                                                     id="alerta_produtividade">
                                                    A produtividade digitada est&aacute; --&gt;&nbsp;<span
                                                        id="msg_produtividade"></span>&nbsp;<-- geralmente a
                                                    produtividade gira em torno de 6h/PF (alta) e 18.5h/PF
                                                    (baixa).
                                                </div> </label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="checkbox" data-toggle="toggle" data-size="small"
                                                       data-width="60" data-onstyle="success" data-style="slow"
                                                       data-on="Sim" data-off="N&atilde;o"
                                                       id="is_produtividade_global">
                                            </div>
                                            <div class="form-group">
                                                <input type="text"
                                                       class="form-control input-sm input_style_spin spinhpf"
                                                       placeholder="Horas" id="produtividade_global" value=""
                                                       maxlength="5" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label><span class="pop" data-toggle="popover"
                                                         data-placement="bottom" data-content="<p      
                                                         align='justify'>Por padr&atilde;o o Dimension&reg; permite
                                                         que apenas os Gestores, Gerentes de Conta e Diretores vejam
                                                         todas as contagens da sua Empresa/Fornecedores, no entanto,
                                                         voc&ecirc; pode permitir que os seus analistas de
                                                         m&eacute;tricas possam ver, as contagens dos seus
                                                         fornecedores.
                                                         <hr> <strong>ATEN&Ccedil;&Atilde;O</strong>: esta
                                                         permiss&atilde;o altera apenas a visualiza&ccedil;&atilde;o
                                                         de contagens dos Fornecedores, as permiss&otilde;es de
                                                         P&uacute;blica / Privada permanecem as mesmas.
                                                         </p>" title="<i class='fa fa-arrow-right'></i>&nbsp;Contagem
                                                         -&gt; Fornecedores"><i class="fa fa-info-circle"></i> Os
                                                    Analistas de M&eacute;tricas visualizam contagens dos
                                                    Fornecedores?
                                                </span> </label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="checkbox" data-toggle="toggle" data-size="small"
                                                       data-width="60" data-onstyle="success" data-style="slow"
                                                       data-on="Sim" data-off="N&atilde;o"
                                                       id="is_visualizar_contagem_fornecedor">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label><span id="pop_content_gestao_projetos" class="pop"
                                                         data-toggle="popover" data-placement="top"
                                                         title="<i 
                                                         class='fa fa-arrow-right'></i>&nbsp;Gest&atilde;o de
                                                         projetos" data-content=""><i class="fa fa-info-circle"></i>
                                                    Utilizar funcionalidades de gest&atilde;o de projetos nas
                                                    contagens?</span><br /> </label>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="checkbox" data-toggle="toggle" data-size="small"
                                                   data-width="60" data-onstyle="success" data-style="slow"
                                                   data-on="Sim" data-off="N&atilde;o" id="is_gestao_projetos"
                                                   disabled>
                                        </div>
                                        <div class="col-md-4">
                                            <label><span class="pop" data-toggle="popover"
                                                         data-placement="bottom" data-content="<p      
                                                         align='justify'>Esta op&ccedil;&atilde;o faz com que as
                                                         contagens feitas em turmas de treinamento sejam exibidas
                                                         inicialmente ou n&atilde;o na lista de contagens. Por
                                                         padr&atilde;o o Dimension&reg; n&atilde;o exibe estas
                                                         contagens para n&atilde;o <i>poluir</i> a tela inicial.
                                                         <hr> <strong>LEMBRE-SE</strong>: esta
                                                         configura&ccedil;&atilde;o aplica-se &agrave;s suas
                                                         contagens, quanto &agrave;s <kbd>Turmas de treinamento</kbd>
                                                         elas s&atilde;o exibidas por padr&atilde;o.
                                                         </p>" title="<i class='fa fa-arrow-right'></i>&nbsp;Contagem
                                                         -&gt; Treinamento"><i class="fa fa-info-circle"></i>
                                                    Diretores, Gestores/Gerentes, Fiscais e Analistas vizualizam
                                                    as contagens de <kbd>Turmas de treinamento</kbd>?
                                                </span> </label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="checkbox" data-toggle="toggle" data-size="small"
                                                       data-width="60" data-onstyle="success" data-style="slow"
                                                       data-on="Sim" data-off="N&atilde;o"
                                                       id="is_visualizar_contagem_turma">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <label><span id="pop_content_horas_liquidas" class="pop"
                                                             data-toggle="popover" data-placement="top"
                                                             title="<i 
                                                             class='fa fa-arrow-right'></i>&nbsp;Horas
                                                             L&iacute;quidas Trabalhadas - HLT"data-content=""><i
                                                            class="fa fa-info-circle"></i> Horas L&iacute;quidas
                                                        Trabalhadas - HLT</span><br />
                                                    <div class="label label-danger"
                                                         style="visibility: hidden; font-size: 82.5%;; font-weight: normal; white-space: normal;"
                                                         id="alerta_hlt">...</div> </label>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input type="text"
                                                           class="form-control input-sm input_style_spin"
                                                           id="horas_liquidas_trabalhadas" value="" maxlength="4"
                                                           required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <label><span class="pop" data-toggle="popover"
                                                             data-placement="top"
                                                             title="<i     
                                                             class='fa fa-arrow-right'></i>&nbsp;Visualizar todas as
                                                             contagens" data-content="Utilize esta op&ccedil;&atilde;o
                                                             caso o Fiscal do Contrato queira visualizar, na lista
                                                             inicial, todas as contagens que est&atilde;o sendo feitas.
                                                             Caso esteja como <kbd>N&Atilde;O</kbd> o Fiscal visualiza
                                                             apenas as contagens <span class='bg-success'>Em faturamento</span>
                                                             e <span class='bg-success'>Faturadas</span>"><i
                                                            class="fa fa-info-circle"></i> O Fiscal do Contrato
                                                        visualiza todas as contagens?</span><br />
                                                    <div class="label label-danger"
                                                         style="visibility: hidden; font-size: 82.5%;; font-weight: normal; white-space: normal;"
                                                         id="alerta_hlt">...</div> </label>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input type="checkbox" data-toggle="toggle"
                                                           data-size="small" data-width="60" data-onstyle="success"
                                                           data-style="slow" data-on="Sim" data-off="N&atilde;o"
                                                           id="is-visualizar-todas-fiscal-contrato">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion-configuracoes-contagem" href="#collapse-configuracoes-contagem-cliente"> <i class="fa fa-chevron-down"></i>&nbsp;Configura&ccedil;&otilde;es personalizadas - Cliente</a>
                            </div>
                            <div id="collapse-configuracoes-contagem-cliente"
                                 class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="checkbox" id="is-f-eng" class="css-checkbox"
                                                       checked disabled /><label for="is-f-eng"
                                                       class="css-label-check"><strong>Obrigat&oacute;ria</strong></label>
                                                <div class="ui fluid corner labeled input">
                                                    <input type="text" class="form-control input_style"
                                                           id="desc-f-eng" value="" required>
                                                    <div class="ui corner label">
                                                        <i class="asterisk icon"></i>
                                                    </div>
                                                </div>
                                                <input type="text"
                                                       class="form-control input-sm input_style_spin spinhpf"
                                                       id="prod-f-eng" value="" maxlength="5" required> <input
                                                       type="text"
                                                       class="form-control input-sm input_style_spin spinpct"
                                                       id="pct-f-eng" value="" maxlength="2" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="checkbox" id="is-f-des" class="css-checkbox"
                                                       checked disabled /><label for="is-f-des"
                                                       class="css-label-check"><strong>Obrigat&oacute;ria</strong></label>
                                                <div class="ui fluid corner labeled input">
                                                    <input type="text" class="form-control input_style"
                                                           id="desc-f-des" value="" required>
                                                    <div class="ui corner label">
                                                        <i class="asterisk icon"></i>
                                                    </div>
                                                </div>
                                                <input type="text"
                                                       class="form-control input-sm input_style_spin spinhpf"
                                                       id="prod-f-des" value="" maxlength="5" required> <input
                                                       type="text"
                                                       class="form-control input-sm input_style_spin spinpct"
                                                       id="pct-f-des" value="" maxlength="2" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="div-fases-desabilita" id="div-imp"
                                                 style="visibility: hidden;"></div>
                                            <div class="form-group">
                                                <input type="checkbox" id="is-f-imp" class="css-checkbox" /><label
                                                    for="is-f-imp" class="css-label-check">Utilizar?</label>
                                                <div class="ui fluid corner labeled input">
                                                    <input type="text" class="form-control input_style"
                                                           id="desc-f-imp" value="" required>
                                                    <div class="ui corner label">
                                                        <i class="asterisk icon"></i>
                                                    </div>
                                                </div>
                                                <input type="text"
                                                       class="form-control input-sm input_style_spin spinhpf"
                                                       id="prod-f-imp" value="" maxlength="5" required> <input
                                                       type="text"
                                                       class="form-control input-sm input_style_spin spinpct"
                                                       id="pct-f-imp" value="" maxlength="2" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="div-fases-desabilita" id="div-tes"
                                                 style="visibility: hidden;"></div>
                                            <div class="form-group">
                                                <input type="checkbox" id="is-f-tes" class="css-checkbox" /><label
                                                    for="is-f-tes" class="css-label-check">Utilizar?</label>
                                                <div class="ui fluid corner labeled input">
                                                    <input type="text" class="form-control input_style"
                                                           id="desc-f-tes" value="" required>
                                                    <div class="ui corner label">
                                                        <i class="asterisk icon"></i>
                                                    </div>
                                                </div>
                                                <input type="text"
                                                       class="form-control input-sm input_style_spin spinhpf"
                                                       id="prod-f-tes" value="" maxlength="5" required> <input
                                                       type="text"
                                                       class="form-control input-sm input_style_spin spinpct"
                                                       id="pct-f-tes" value="" maxlength="2" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="div-fases-desabilita" id="div-hom"
                                                 style="visibility: hidden;"></div>
                                            <div class="form-group">
                                                <input type="checkbox" id="is-f-hom" class="css-checkbox" /><label
                                                    for="is-f-hom" class="css-label-check">Utilizar?</label>
                                                <div class="ui fluid corner labeled input">
                                                    <input type="text" class="form-control input_style"
                                                           id="desc-f-hom" value="" required>
                                                    <div class="ui corner label">
                                                        <i class="asterisk icon"></i>
                                                    </div>
                                                </div>
                                                <input type="text"
                                                       class="form-control input-sm input_style_spin spinhpf"
                                                       id="prod-f-hom" value="" maxlength="5" required> <input
                                                       type="text"
                                                       class="form-control input-sm input_style_spin spinpct"
                                                       id="pct-f-hom" value="" maxlength="2" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <div class="div-fases-desabilita" id="div-impl"
                                                     style="visibility: hidden;"></div>
                                                <input type="checkbox" id="is-f-impl" class="css-checkbox" /><label
                                                    for="is-f-impl" class="css-label-check">Utilizar?</label>
                                                <div class="ui fluid corner labeled input">
                                                    <input type="text" class="form-control input_style"
                                                           id="desc-f-impl" value="" required>
                                                    <div class="ui corner label">
                                                        <i class="asterisk icon"></i>
                                                    </div>
                                                </div>
                                                <input type="text"
                                                       class="form-control input-sm input_style_spin spinhpf"
                                                       id="prod-f-impl" value="" maxlength="5" required> <input
                                                       type="text"
                                                       class="form-control input-sm input_style_spin spinpct"
                                                       id="pct-f-impl" value="" maxlength="2" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="padding: 10px;"></div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label><span class="pop" data-toggle="popover"
                                                         data-placement="bottom" data-content="<p      
                                                         align='justify'>O percentual de distribui&ccedil;&atilde;o
                                                         servir&aacute; de base para os c&aacute;lculos de
                                                         dura&ccedil;&atilde;o das fases. Utilize a mais condizente
                                                         com a realidade da sua empresa.
                                                         </p>" title="<i class='fa fa-arrow-right'></i>&nbsp;Distribui&ccedil;&atilde;o"><i
                                                        class="fa fa-info-circle"></i> Distribui&ccedil&atilde;o nas
                                                    fases do processo de desenvolvimento
                                                </span><br />
                                                <div class="label label-danger"
                                                     style="visibility: hidden; font-weight: normal; white-space: normal; position: absolute; top: 17px; left: 17px; box-shadow: 3px 5px 5px #666; z-index: 5209;"
                                                     id="alerta_distribuicao">A distribui&ccedil;&atilde;o nas
                                                    fases deve totalizar 100% e nenhuma das fases pode ser 0%
                                                    (zero) ou maior que 97% (noventa e sete), portanto
                                                    dever&aacute; haver no m&iacute;nimo duas fases ativas.</div>
                                            </label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="text" class="form-control input-sm input_style"
                                                       id="sistema_total_fases" value="100" maxlength="3"
                                                       style="font-weight: bold;" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="id_fator_tecnologia_padrao"> <span class="pop"
                                                                                           data-placement="bottom" data-toggle="popover"
                                                                                           title="<i 
                                                                                           class='fa fa-arrow-circle-right'></i> Fator Tecnologia
                                                                                           - FT" data-content="<i class='fa fa-lightbulb-o'></i>&nbsp;Melhor
                                                                                           pr&aacute;tica encontrada
                                                                                           <hr> Nos projetos de desenvolvimento, ap&oacute;s a
                                                                                           aplica&ccedil;&atilde;o das regras contratuais previstas e
                                                                                           das medi&ccedil;&otilde;es padr&atilde;o do CPM e SISP,
                                                                                           ainda poder&atilde;o ser aplicados os Fatores de Tecnologia
                                                                                           - FT, conforme tabela exemplificativa a abaixo.
                                                                                           <table
                                                                                           class='table table-condensed table-striped table-bordered'
                                                                                           width='100%'>
                                                                                           <tr>
                                                                                           <thead>
                                                                                           <tr>
                                                                                           <th width='60%'>Tipo de tecnologia</th>
                                                                                           <th width='40%'>Fator</th>
                                                                                           </tr>
                                                                                           </thead>
                                                                                           <tbody>
                                                                                           <tr>
                                                                                           <td>ASP, VB ou .Net</td>
                                                                                           <td>1,00</td>
                                                                                           </tr>
                                                                                           <tr>
                                                                                           <td>Java e demais tecnologias</td>
                                                                                           <td>1,15</td>
                                                                                           </tr>
                                                                                           <tr>
                                                                                           <td>SOA/BPM</td>
                                                                                           <td>1,35</td>
                                                                                           </tr>
                                                                                           </tbody>
                                                                                           </table> <br /> FONTE: <a
                                                                                           href='/pf/docs/Edital n 26.2014 - Fabrica de Software - Sara - ANVISA.docx'
                                                                                           target='_blank'>Edital n 04.2016 - ANVISA</a>. Todos os
                                                                                           direitos reservados."> <i class="fa fa-info-circle"></i>
                                                    Fator Tecnologia - FT (padr&atilde;o)</span>
                                            </label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <select id="id_fator_tecnologia_padrao"
                                                        class="form-control input_style"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="etapa-atualizar-baseline"> <span class="pop"
                                                                                         data-placement="bottom" data-toggle="popover"
                                                                                         title="<i 
                                                                                         class='fa fa-arrow-right'></i>&nbsp;Selecione uma
                                                                                         etapa" data-content="<i class='fa fa-lightbulb-o'></i>&nbsp;Aten&ccedil;&atilde;o,
                                                                                         esta escolha &eacute; muito importante pois refletir&aacute;
                                                                                         no encerramento/finaliza&ccedil;&atilde;o da contagem e
                                                                                         consequente atualiza&ccedil;&atilde;o das <strong>Baselines.</strong>&nbsp;
                                                                                         Escolha uma fase em que a propabilidade de
                                                                                         altera&ccedil;&atilde;o da Contagem seja <kbd>baixa</kbd>. O
                                                                                         padr&atilde;o do Dimension &eacute; a fase de
                                                                                         autoriza&ccedil;&atilde;o para faturamento, pois neste
                                                                                         momento todas as discuss&otilde;es e revis&otilde;es
                                                                                         j&aacute; foram realizadas.
                                                                                         <hr>
                                                                                         <kbd>Lembre-se:</kbd>&nbsp;Na finaliza&ccedil;&atilde;o da Contagem (Envio para Faturamento) as Baselines s&atilde;o obrigatoriamente atualizadas.
                                                                                         </strong>"> <i
                                                        class="fa fa-info-circle"></i> No encerramento de qual fase
                                                    as <strong>Baselines</strong> ser&atilde;o atualizadas? </span>
                                            </label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <!-- TODO: por enquanto o codigo esta unico, fazer json depois -->
                                                <select id="etapa-atualizar-baseline"
                                                        name="etapa-atualizar-baseline"
                                                        class="form-control input_style">
                                                    <option value="2">Ap&oacute;s a valida&ccedil;&atilde;o
                                                        interna</option>
                                                    <option value="10">Ap&oacute;s a valida&ccedil;&atilde;o
                                                        interna (autom&aacute;tica)</option>
                                                    <option value="3">Ap&oacute;s a valida&ccedil;&atilde;o
                                                        externa</option>
                                                    <option value="7">No envio para o faturamento (finaliza&ccedil;&atilde;o)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="is_ft_padrao"> <span class="pop"
                                                                             data-placement="bottom" data-toggle="popover"
                                                                             title="<i 
                                                                             class='fa fa-arrow-right'></i> Fator Tecnologia - FT"
                                                                             data-content="<i class='fa fa-lightbulb-o'></i>&nbsp;Melhor
                                                                             pr&aacute;tica encontrada
                                                                             <hr> O Fator Tecnologia n&atilde;o &eacute;
                                                                             obrigat&oacute;rio, mas se durante a
                                                                             elabora&ccedil;&atilde;o o analista quiser utilizar ou se o
                                                                             seu contrato prev&ecirc;, basta alterar na pr&oacute;pria
                                                                             contagem."> <i class="fa fa-info-circle"></i> Utilizar FT
                                                    nas an&aacute;lises?</span>
                                            </label>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="checkbox" data-toggle="toggle" data-width="60"
                                                       data-size="small" data-onstyle="success" data-style="slow"
                                                       data-on="Sim" data-off="N&atilde;o" id="is_ft_padrao">
                                            </div>
                                        </div>
                                        <div class="col-md-4"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <br />
                                    <div class="form-group"
                                         style="text-align: center; vertical-align: middle">
                                        <a href="#"><img class="img-thumbnail" src="" alt="captcha"
                                                         id="fmccon-img-captcha"
                                                         onclick="refreshCaptcha($(this), $('#fmccon-txt-captcha'));"
                                                         data-toggle="tooltip" data-placement="top"
                                                         title="Clique na imagem para obter outro c&oacute;digo" /></a><br />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <br />
                                    <div class="form-group">
                                        <label><i class="fa fa-dot-circle-o" id="fmccon-i-captcha"></i>&nbsp;<?php echo WORDING_REGISTRATION_CAPTCHA; ?><sup>*</sup></label>
                                        <div class="ui fluid corner labeled input">
                                            <input class="form-control input_style" type="text"
                                                   id="fmccon-txt-captcha" autocomplete="off" maxlength="4"
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
                    <div class="row">
                        <div class="col-md-8" style="text-align: left;">
                            <strong>ATEN&Ccedil;&Atilde;O</strong>: ao finalizar fa&ccedil;a <i>logoff</i> e <i>login</i> novamente
                        </div>
                        <div class="col-md-4">
                            <div class="btn-group" id="acoes">
                                <button type="submit" class="btn btn-success"
                                        id="sistema_atualizar">
                                    <i class="fa fa-refresh"></i> Atualizar
                                </button>
                                <button type="button" class="btn btn-warning"
                                        data-dismiss="modal">
                                    <i class="fa fa-times"></i> Fechar
                                </button>
                            </div>
                        </div>
                    </div>                    
                </div>
            </form>
        </div>
    </div>
</div>