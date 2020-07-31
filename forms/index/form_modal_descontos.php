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
<div id="form-modal-descontos" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                <h3 style="display:inline;">&nbsp;&nbsp;<i class="fa fa-building-o"></i>&nbsp;&nbsp;Informa&ccedil;&otilde;es para o Plano EMPRESARIAL</h3>
            </div>
            <div class="modal-body">
                <div style="min-height: 455px; max-height: 455px;overflow-x: hidden;" class="scroll">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <i class="fa fa-exclamation-triangle"></i>&nbsp;NOTAS sobre os usu&aacute;rios
                                </div>
                                <div class="panel-body">
                                    A tabela ao lado descreve todos os perfis de usu&aacute;rios dentro do sistema Dimension&reg;. 
                                    Acreditamos que a cobran&ccedil;a <i>pay-per-use</i> facilite sua vida. Veja que voc&ecirc; pode cadastrar Validadores Internos (seu Cliente), Auditores Externos (&Oacute;rg&atilde;os de Controle),
                                    Gerentes de Conta (Preposto), Diretores, etc., que são perfis importantes e desempenham um papel fundamental no processo de dimensionamento e faturamento da sua Empresa e n&atilde;o paga por isso, 
                                    a quantidade de usu&aacute;rios &eacute; ilimitada. Acreditamos tamb&eacute;m que esta integra&ccedil;&atilde;o Privado &amp; Governo seja vital para o funcionamento do ecossistema Dimension&reg;.
                                    Por isso, Auditores Externos e Validadores Externos n&atilde;o podem e nem devem ser cobrados, isso tamb&eacute;m nos motivou a adotar o <i>pay-per-use</i>. Nossa miss&atilde;o &eacute; fazer com que todo o processo, 
                                    desde a contagem at&eacute; o faturamento seja facilitado, fornecendo visibilidade aos CONTRATANTES, geralmente
                                    Governo. Por isso disponibilizamos ferramentas que auxiliam na comunica&ccedil;&atilde;o integrada com os FORNECEDORES.<br />
                                    <small><strong>*O perfil gerente de projetos estar&aacute; dispon&iacute;vel at&eacute; o final de 2016.</strong></small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <table class="table table-striped table-condensed" width="100%">
                                <thead>
                                    <tr>
                                        <th colspan="2">
                                <h3 style="display:inline;">PERFIS DO SISTEMA</h3>
                                </th>
                                </tr>
                                <tr>
                                    <th width="20%">Usu&aacute;rio</th>
                                    <th width="80%">Descri&ccedil;&atilde;o</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Administrador</td>
                                        <td>Realiza as fun&ccedil;&otilde;es administrativas no sistema</td>
                                    </tr>
                                    <tr>
                                        <td>Gestor</td>
                                        <td>Realiza as fun&ccedil;&otilde;es de gest&atilde;o em rela&ccedil;&atilde;o &agrave; contagens</td>
                                    </tr>
                                    <tr>
                                        <td>Validador Interno</td>
                                        <td>Realiza as valida&ccedil;&otilde;es internas na sua empresa</td>
                                    </tr>
                                    <tr>
                                        <td>Analista de M&eacute;tricas</td>
                                        <td>Fun&ccedil;&atilde;o que realiza/insere as contagens no sistema</td>
                                    </tr>
                                    <tr>
                                        <td>Auditor Interno</td>
                                        <td>Realizam as auditorias internas nas contagens. &Eacute; uma fun&ccedil;&atilde;o interna &agrave; sua Empresa</td>
                                    </tr>
                                    <tr>
                                        <td>Gerente de Projetos*</td>
                                        <td>Este &eacute; o perfil respons&aacute;vel por gerenciar as contagens associadas aos projetos no Cliente. Pode agrupar contagens, e trocar os respons&aacute;veis.</td>
                                    </tr>
                                    <tr>
                                        <td>Validador Externo</td>
                                        <td>Geralmente s&atilde;o os perfis associados aos Clientes que validam as contagens e facilitam o processo de faturamento</td>
                                    </tr>
                                    <tr>
                                        <td>Auditor Externo</td>
                                        <td>Perfil de auditoria externa geralmente associado a &Oacute;rg&atilde;os de Controle - TCU, CGU, TCEs, etc.</td>
                                    </tr>
                                    <tr>
                                        <td>Fiscal de Contrato</td>
                                        <td>Perfil associado ao fiscal, ou fiscais, de Contrato. Geralmente s&atilde;o os que v&atilde;o resolver conflitos entre
                                            o <kbd>CONTRATANTE</kbd> e a <kbd>CONTRATADA</kbd>. Se voc&ecirc; tem uma empresa contratada exclusivamente para realizar contagens,
                                            este perfil &eacute; o que resolver&aacute; os conflitos de contagens.</td>
                                    </tr>
                                    <tr>
                                        <td>Outros perfis</td>
                                        <td>Gerente de Contas, Diretores, Visualizadores, Gerentes (outros) e Financeiro.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
