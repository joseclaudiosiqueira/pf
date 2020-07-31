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
<div id="form_modal_funcoes_perfil_contagem" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="fechar-funcoes-perfil"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                <i class="fa fa-users"></i>&nbsp;Funcionalidades dispon&iacute;veis para a contagem #ID:&nbsp;<span id="id_contagem"></span><br />
                <span class="sub-header">Selecione a a&ccedil;&atilde;o desejada</span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                        <h4 style="display:inline;">Contagem</h4><br />
                        <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Informa&ccedil;&otilde;es"
                              data-content="ATEN&Ccedil;&Atilde;O:
                              <ul style='list-style-type:none;'>
                              <!--<li><i class='fa fa-arrow-circle-o-right'></i>&nbsp;<strong>C&oacute;pias</strong>: o sistema permite c&oacute;pias de contagens apenas para aquelas que j&aacute; foram, no m&iacute;nimo, validadas internamente. As c&oacute;pias de contagens de projeto n&atilde;o ficar&atilde;o vinculadas, ou seja, n&atilde;o far&atilde;o altera&ccedil;&otilde;es nas baselines;</li>-->
                              <li><i class='fa fa-arrow-circle-o-right'></i>&nbsp;<strong>Exclus&otilde;es</strong>: apenas contagens no processo de elabora&ccedil;&atilde;o poder&atilde;o ser exclu&iacute;das;</li>
                              <li><i class='fa fa-arrow-circle-o-right'></i>&nbsp;<strong>Privacidade</strong>: a privacidade poder&aacute; ser alterada a qualquer momento.</li>
                              <li><i class='fa fa-arrow-circle-o-right'></i>&nbsp;<strong>Atualizar Baseline</strong>: A atualiza&ccedil;&atilde;o de baseline (contagens de projeto) uma vez realizadas, a contagem n&atilde;o poder&aacute; mais ser alterada.</li>
                              <li><i class='fa fa-arrow-circle-o-right'></i>&nbsp;<strong>C&oacute;pias</strong>: As contagens podem ser copiadas somente ap&oacute;s o processo de valida&ccedil;&atilde;o interna.</li>
                              <li><i class='fa fa-arrow-circle-o-right'></i>&nbsp;<strong>Marco (baseline) de estimativa</strong>: Esta op&ccedil;&atilde;o estar&aacute; liberada enquanto a contagem estiver na etapa <strong>estimativa</strong>, as etapas Detalhada e Indicativa não permitem o salvamento de marcos.</li>
                              </ul>">
                            <i class="fa fa-info-circle"></i>&nbsp;Gerenciamento da contagem (edi&ccedil;&atilde;o, altera&ccedil;&atilde;o, valida&ccedil;&atilde;o...)
                        </span>
                        <br />
                        <div class="btn-group btn-group-justified">
                            <div class="btn-group">
                                <button id="btn_alterar" class="btn btn-default" title="Alterar a contagem" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-edit"></i><span class="not-view">&nbsp;&nbsp;Alterar</span></button>                           
                            </div>
                            <div class="btn-group">
                                <button id="btn_revisar" class="btn btn-default btn-opc" value="re" title="Revisar a contagem" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-refresh"></i><span class="not-view">&nbsp;&nbsp;Revisar</span></button>
                            </div>
                            <!--
                            <div class="btn-group">
                                <button id="btn_copiar" class="btn btn-default" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-info-circle'></i>&nbsp;Leia-me"
                                        data-content="As contagens podem ser copiadas somente ap&oacute;s o processo de valida&ccedil;&atilde;o interna. ATEN&Ccedil;&Atilde;O: as c&oacute;pias geradas ser&atilde;o sempre avulsas e sem influ&ecirc;ncias em baselines!<br /><br />
                                        <center><button type='button' class='btn btn-success'><i class='fa fa-check'></i>&nbsp;Entendi, vou gerar uma c&oacute;pia</button></center><br />"><i class="fa fa-clipboard"></i><span class="not-view">&nbsp;&nbsp;Copiar</span></button>
                            </div>-->
                            <!--<button id="btn_editar" class="btn btn-default btn-sm"><i class="fa fa-pencil-square"></i>&nbsp;&nbsp;Editar (colabora&ccedil;&atilde;o)</button>-->
                            <!--nesta versao nao havera controle de versionamento de contagens
                            <button id="btn_versao" class="btn btn-default btn-sm"><i class="fa fa-code-fork"></i>&nbsp;&nbsp;Nova vers&atilde;o</button>-->
                            <div class="btn-group">
                                <button id="btn_excluir" class="btn btn-default" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-info-circle'></i>&nbsp;Leia-me"
                                        data-content="As contagens podem ser exclu&iacute;das se ainda estiverem no processo de elabora&ccedil;&atilde;o e a a&ccedil;&atilde;o n&atilde;o poder&aacute; ser desfeita.
                                        <center>
                                        <h4>Tem certeza que deseja EXCLUIR esta contagem?</h4>
                                        <button type='button' class='btn btn-warning' id='btn-excluir-contagem' value='e' onclick='fe($(this));'><i class='fa fa-check'></i>&nbsp;Sim, quero excluir esta contagem</button>
                                        <a href='#' class='btn' id='btn-cancelar-excluir' value='c' onclick='fe($(this)); return false;'><i class='fa fa-times'></i>&nbsp;Cancelar</a></center>"><i class="fa fa-trash"></i><span class="not-view">&nbsp;&nbsp;<i class="fa fa-angle-double-left"></i>&nbsp;Excluir&nbsp;<i class="fa fa-angle-double-right"></i></span></button>
                            </div>
                            <div class="btn-group">
                                <button id="btn_baseline_estimativa" class="btn btn-success" title="Salve o marco (baseline) de estimativa para poder comparar com a contagem Detalhada posterior." data-toggle="tooltip" data-placement="bottom"><i class="fa fa-map-marker"></i><span class="not-view">&nbsp;&nbsp;Estimativa</span></button>
                            </div>
                            <div class="btn-group">
                                <button id="btn_visualizar" class="btn btn-default btn-opc" value="vw" title="Visualizar" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-search"></i><span class="not-view">&nbsp;&nbsp;Visualizar</span></button>
                            </div>
                            <!--
                            <div class="btn-group">
                                <button id="btn_comentarios" class="btn btn-success" value="7" onclick="javascript: return false;" title="(Em breve...)" data-toggle="tooltip" data-placement="bottom"><i class="fa fa-comment"></i><span class="not-view">&nbsp;&nbsp;Coment&aacute;rios</span></button>
                            </div>-->
                        </div>
                        <br />
                        <h4 style="display:inline;">Altera&ccedil;&otilde;es e/ou Finaliza&ccedil;&otilde;es</h4><br />
                        <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Altera&ccedil;&otilde;es"
                              data-content="
                              <ul style='list-style-type:none;'>
                              <li><i class='fa fa-arrow-circle-o-right'></i>&nbsp;<strong>Validador Interno</strong>: selecionando um colaborador (especialista) para valida&ccedil;&atilde;o da sua contagem. &Eacute; um colaborador da sua empresa;</li>
                              <li><i class='fa fa-arrow-circle-o-right'></i>&nbsp;<strong>Validador Externo</strong>: pode ser algum colaborador do seu Cliente que ir&aacute; validar a contagem para efeitos de homologa&ccedil;&atilde;o, faturamento, valida&ccedil&atilde;o, etc;</li>
                              <li><i class='fa fa-arrow-circle-o-right'></i>&nbsp;<strong>Auditoria Interna</strong>: Geralmente as auditorias est&atilde;o ligadas a processos internos executados por sua organiza&ccedil;&atilde;o;</li>
                              <li><i class='fa fa-arrow-circle-o-right'></i>&nbsp;<strong>Auditoria Externa</strong>: pode ser uma entidade externa, um colaborador de uma consultoria, um &Oacute;rg&atilde;o de Controle.</li>
                              <li><i class='fa fa-arrow-circle-o-right'></i>&nbsp;<strong>Gerente do Projeto</strong>: esta funcionalidade estar&aacute; liberada a partir do in&iacute;cio de 2017, sem custos adicionais.</li>
                              </ul>
                              <center><span class='dim_alert'>Mas aten&ccedil;&atilde;o, em qualquer um dos casos o colaborador dever&aacute; estar cadastrado como um usu&aacute;rio &uacute;nico; Voc&ecirc; pode finalizar os processos de auditorias internas/externas e nomear outra pessoa para realizar a atividade.<span></center>">                            
                            <i class="fa fa-info-circle"></i>&nbsp;Altera&ccedil;&otilde;es de validadores internos, externos e gerentes de projeto /  Finaliza&ccedil;&atilde;o de auditorias (internas e externas)
                        </span>
                        <br />
                        <div class="row">
                            <div class="col-md-12">
                                <div class="btn-group btn-group-justified">
                                    <div class="btn-group">
                                        <button class="btn btn-info" disabled>ALTERAR&nbsp;&nbsp;<i class="fa fa-angle-double-right"></i></button>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-default btn-acoes" id="btn_alterar_validador_interno" value="vi;al" title="Alterar o validador interno"><i class="fa fa-user"></i><span class="not-view">&nbsp;&nbsp;Validador (interno)</span></button>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-default btn-acoes" id="btn_alterar_validador_externo" value="ve;al" title="Alterar o validador externo"><i class="fa fa-user-plus"></i><span class="not-view">&nbsp;&nbsp;Validador (externo)</span></button>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-default btn-acoes" id="btn_alterar_gerente_projeto" value="gp;al" title="Alterar o gerente do projeto" disabled><i class="fa fa-suitcase"></i><span class="not-view">&nbsp;&nbsp;Gerente do projeto</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="height:4px;"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="btn-group btn-group-justified">
                                    <div class="btn-group">
                                        <button class="btn btn-info" disabled>FINALIZAR&nbsp;&nbsp;<i class="fa fa-angle-double-right"></i></button>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-default btn-fa" value="ai" id="btn_finalizar_auditoria_interna" title="Finalizar a auditoria interna"><i class="fa fa-user-secret"></i><span class="not-view">&nbsp;&nbsp;Auditoria (interna)</span></button>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-default btn-fa" value="ae" id="btn_finalizar_auditoria_externa" title="Finalizar a auditoria externa"><i class="fa fa-exchange"></i><span class="not-view">&nbsp;&nbsp;Auditoria (externa)</span></button>
                                    </div>
                                    <div class="btn-group"></div>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-md-4">
                                <h4 style="display:inline;">Alterar a privacidade da contagem</h4><br />
                                Autoriza&ccedil;&atilde;o para visualiza&ccedil;&atilde;o desta contagem<br />
                                <input class="privacidade" id="btn_privacidade" type="checkbox" data-width="120" data-height="36" data-toggle="toggle" data-onstyle="info" data-offstyle="warning" data-style="slow" data-on="<i class='fa fa-lock'></i>&nbsp;&nbsp;Privada" data-off="<i class='fa fa-unlock'></i>&nbsp;&nbsp;P&uacute;blica">
                                &nbsp;&nbsp;<strong><span id="span-privacidade"></span></strong>
                            </div>
                            <div class="col-md-4">
                                <h4 style="display:inline;">Finalizar a contagem</h4><br />
                                <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Leia-me"
                                      data-content="Finalizar a contagem quer dizer que esta n&atilde;o poder&aacute; mais ser alterada. Atente-se 
                                      que a <span class='bg-warning'><u>valida&ccedil;&atilde;o externa</u></span> &eacute; obrigat&oacute;ria, as <span class='bg-warning'><u>baselines</u></span> ser&atilde;o atualizadas e 
                                      que este processo pode ser feito nas seguintes situa&ccedil;&otilde;es:<br />
                                      ---<br />
                                      1) A contagem ser&aacute; enviada para faturamento;<br />
                                      2) O projeto alvo da contagem foi finalizado;<br />
                                      3) Dentro do seu processo junto ao cliente interno n&atilde;o haver&aacute; mais altera&ccedil;&otilde;es;<br />
                                      4) Outros casos internos.">
                                    <i class="fa fa-info-circle"></i>&nbsp;<i class="fa fa-angle-double-left"></i>&nbsp;IMPORTANTE<i class="fa fa-angle-double-right"></i>&nbsp;Saiba mais</span><br />
                                <button id='btn_finalizar' type='button' class='btn btn-success' disabled>Enviar para finaliza&ccedil;&atilde;o/faturamento</button>
                            </div>
                            <div class="col-md-4">
                                <h4 style="display:inline;">Finalizar sem faturar</h4><br />
                                <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Leia-me"
                                      data-content="Finalizar a contagem sem faturar serve para contagens que foram feitas apenas para an&aacute;lises de viabilidade de projetos e/ou
                                      contagens que utilizaram o m&eacute;todo Indicativo. Somente contagens <strong>Livres</strong>, <strong>EFd/t</strong> podem ser finalizadas sem faturamento.">
                                    <i class="fa fa-info-circle"></i>&nbsp;<i class="fa fa-angle-double-left"></i>&nbsp;IMPORTANTE<i class="fa fa-angle-double-right"></i>&nbsp;Saiba mais</span><br />                                
                                    <button id='btn_finalizar_sem_faturamento' type='button' class='btn btn-warning' disabled>Finalizar sem faturamento</button>
                            </div>
                        </div>
                        <br />
                        <h4 style="display:inline;">Valida&ccedil&atilde;o e Auditoria</h4><br />
                        <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Valida&ccedil;&otilde;es e Auditoria"
                              data-content="O sistema Dimension oferece tr&ecirc;s tipos de valida&ccedil;&otilde;es:
                              <ul style='list-style-type:none;'>
                              <li><i class='fa fa-arrow-circle-o-right'></i>&nbsp;<strong>Valida&ccedil;&atilde;o Interna</strong>: selecionando um colaborador (especialista) para valida&ccedil;&atilde;o da sua contagem. &Eacute; um colaborador da sua empresa;</li>
                              <li><i class='fa fa-arrow-circle-o-right'></i>&nbsp;<strong>Validador Externo</strong>: pode ser algum colaborador do seu Cliente que ir&aacute; validar a contagem para efeitos de homologa&ccedil;&atilde;o, faturamento, valida&ccedil&atilde;o, etc;</li>
                              <li><i class='fa fa-arrow-circle-o-right'></i>&nbsp;<strong>Auditor</strong>: pode ser uma entidade externa, um colaborador de uma consultoria, um &Oacute;rg&atilde;o de Controle.</li>
                              </ul>
                              <center><span class='dim_alert'>Mas aten&ccedil;&atilde;o, em qualquer um dos casos o colaborador dever&aacute; estar cadastrado como um usu&aacute;rio &uacute;nico.<span></center>">
                            <i class="fa fa-info-circle"></i>&nbsp;Processo de valida&ccedil;&otilde;es (internas e externas) e Auditorias (internas e externas)
                        </span>
                        <br />
                        <div class="btn-group btn-group-justified">
                            <div class="btn-group">
                                <button id="btn_validar_interno" class="btn btn-default btn-opc" value="vi"><i class="fa fa-user"></i><span class="not-view">&nbsp;&nbsp;Validar - Interno</span></button>
                            </div>
                            <div class="btn-group">
                                <button id="btn_validar_externo" class="btn btn-default btn-opc" value="ve"><i class="fa fa-user-plus"></i><span class="not-view">&nbsp;&nbsp;Validar - Externo</span></button>
                            </div>
                            <div class="btn-group">
                                <button id="btn_auditar_interno" class="btn btn-default btn-opc" value="ai"><i class="fa fa-user-secret"></i><span class="not-view">&nbsp;&nbsp;Auditar - Interno</span></button>
                            </div>
                            <div class="btn-group">
                                <button id="btn_auditar_externo" class="btn btn-default btn-opc" value="ae"><i class="fa fa-exchange"></i><span class="not-view">&nbsp;&nbsp;Auditar - Externo</span></button>
                            </div>
                        </div>
                        <!--
                        <br /><br />
                        <h4 style="display:inline;">Compartilhamento</h4><br />
                        <small>Compartilhe sua contagem com outras pessoas/empresas/&oacute;rg&atilde;os</small>
                        <br />
                        <div class="btn-group">
                            <button id="btn_empresa" class="btn btn-default btn-sm"><i class="fa fa-share"></i>&nbsp;Empresa</button>
                            <button id="btn_diretorio" class="btn btn-default btn-sm"><i class="fa fa-share-square"></i>&nbsp;&nbsp;Diret&oacute;rio p&uacute;blico</button>
                            <button id="btn_orgao" class="btn btn-default btn-sm"><i class="fa fa-share-square-o"></i>&nbsp;&nbsp;&Oacute;rg&atilde;o</button>
                        </div>-->
                        <br />
                        <h4 style="display:inline;">Exportar</h4><br />
                        Alguns formatos estar&atilde;o dispon&iacute;veis somente quando a contagem estiver validada e depender&atilde;o do plano contratado
                        <br />
                        <div class="btn-group btn-group-justified">
                            <!--
                            <div class="btn-group dropup">
                                <button id="btn_pdf" type="button" class="btn btn-default dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;. P D F&nbsp;&nbsp;<span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li id="btn_exportar_pdf_resumo"><a href="#">.PDF (resumo/planilha)</a></li>
                                    <li id="btn_exportar_pdf_detalhado"><a href="#">.PDF (detalhado)</a></li>
                                    <li id="btn_exportar_pdf_detalhado_estatisticas"><a href="#">.PDF (detalhado/estatisticas)</a></li>
                                </ul>
                            </div>
                            -->
                            <div class="btn-group">
                                <button id="btn-pdf" class="btn btn-default" title="P D F"><i class="fa fa-file-pdf-o"></i><span class="not-view">&nbsp;&nbsp;. P D F</span></button>
                            </div>
                            <div class="btn-group">
                                <button id="btn-html" class="btn btn-default" title="H T M L"><i class="fa fa-file-code-o"></i><span class="not-view">&nbsp;&nbsp;. H T M L</span></button>
                            </div>
                            <!--exportacao apenas no planejamento
                            <button id="btn-json" class="btn btn-default btn-sm"><i class="fa fa-file-o"></i>&nbsp;&nbsp;. J S O N</button>
                            <button id="btn-xml" class="btn btn-default btn-sm"><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;. X M L</button>
                            -->
                            <!--<button id="btn-ods" class="btn btn-default btn-sm"><i class="fa fa-file-text"></i>&nbsp;&nbsp;. O D S</button>-->
                            <div class="btn-group">
                                <button id="btn-xls" class="btn btn-default" title="X L S"><i class="fa fa-file-excel-o"></i><span class="not-view">&nbsp;&nbsp;. X L S</span></button>
                            </div>
                            <div class="btn-group">
                                <button id="btn-xlsx" class="btn btn-default" title="X L S X"><i class="fa fa-table"></i><span class="not-view">&nbsp;&nbsp;. X L S X</span></button>
                            </div>
                            <div class="btn-group">
                                <button id="btn-fatto" class="btn btn-success" 
                                        title="Planilha de Contagem de Pontos de Fun&ccedil;&atilde;o padr&atilde;o IFPUG. Apenas se foi utilizado o Roteiro Padrão da Planilha Vers&atilde;o 2.4" 
                                        data-toggle="tooltip" data-placement="top"><!--<img src="/pf/img/logo_fatto.png" height="24" />--><span class="not-view">&nbsp; FATTO IFPUG<u>v2.4</u></span></button>
                            </div>
                            <!--<button id="btn-ifpug" class="btn btn-default btn-sm"><i class="fa fa-table"></i>&nbsp;&nbsp;I F P U G</button>-->
                            <!--
                            <div class="btn-group">
                                <button id="btn-zip" class="btn btn-default" title="Z.I.P."><i class="fa fa-file-archive-o"></i><span class="not-view">&nbsp;&nbsp;.Z I P</span></button>
                            </div>-->
                        </div> 
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 style="display: inline;">Enviar para Valida&ccedil;&otilde;es externas e Auditorias</h4><br />
                                Clique na op&ccedil;&atilde;o dispon&iacute;vel
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="btn-group btn-group-justified" style="margin-bottom:4px;">
                                    <div class="btn-group">
                                        <button id="btn_validador_externo" class="btn btn-default btn-acoes" value="ve;in"><i class="fa fa-user-plus"></i><span class="not-view">&nbsp;&nbsp;Valida&ccedil;&atilde;o externa</span></button>
                                    </div>
                                    <div class="btn-group">
                                        <button id="btn_auditor_interno" class="btn btn-default btn-acoes" value="ai;in"><i class="fa fa-user-secret"></i><span class="not-view">&nbsp;&nbsp;Auditoria interna</span></button>
                                    </div>
                                    <div class="btn-group">
                                        <button id="btn_auditor_externo" class="btn btn-default btn-acoes" value="ae;in"><i class="fa fa-exchange"></i><span class="not-view">&nbsp;&nbsp;Auditoria externa</span></button>
                                    </div>
                                    <!--<button id="btn_colaborar" class="btn btn-default btn-sm btn-acoes" value="co"><i class="fa fa-users"></i><br />Enviar para<br /> colabora&ccedil;&atilde;o</button>-->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div style="min-height: 442px; max-height: 442px; overflow-x: hidden; overflow-y: auto; width: 100%; border: 1px dotted #d0d0d0; border-radius: 5px; padding: 5px;" id="log-tabela" class="scroll"></div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="modal-footer">
                <i class="fa fa-lightbulb-o fa-lg"></i>&nbsp;Clique na <strong>foto/imagem</strong> para selecionar ou <strong><a href="#" onclick="$('#log-tabela').empty();
                        return false;">AQUI</a></strong> para limpar a tabela.                
            </div>
        </div>
    </div>               
</div>
