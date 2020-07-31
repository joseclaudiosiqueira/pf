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
<div class="panel panel-default">
    <div class="panel-title">
        <i class="fa fa-info-circle fa-lg"></i>&nbsp;&nbsp;Treinamento<br />
        <span class="sub-header">Gest&atilde;o das suas turmas de treinamento</span>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <strong><a href="#" data-toggle="modal" data-target="#form_modal_inserir_alterar_fornecedor" id="fmiafor-link" class="turma-fornecedor-link"><i class="fa fa-users"></i>&nbsp;Inserir</a></strong><br />
                Inclus&atilde;o de informa&ccedil;&otilde;es das suas turmas de treinamentos<br /><br />
                <div style="border: 1px dotted #f68; padding: 5px; border-radius: 5px;">
                    Por padr&atilde;o uma <kbd>Turma de treinamento</kbd> herda o plano contratado. Entretanto, o sistema limita automaticamente as seguintes caracter&iacute;sticas, que n&atilde;o podem ser configuradas:
                    <ul class="fa-ul">
                        <li><i class="fa fa-arrow-circle-right"></i> Quantidade de entregas</li>
                        <li><i class="fa fa-arrow-circle-right"></i> Processo de valida&ccedil;&atilde;o</li>
                        <li><i class="fa fa-arrow-circle-right"></i> Visualizar roteiros p&uacute;blicos</li>
                        <li><i class="fa fa-arrow-circle-right"></i> Valida&ccedil;&atilde;o por Administradores e Analistas</li>
                        <li><i class="fa fa-arrow-circle-right"></i> Visualizar sugest&otilde;es de linguagem</li>
                        <li><i class="fa fa-arrow-circle-right"></i> Inserir contagens de <span class="bg-danger">Projeto</span>, <span class="bg-danger">Baseline</span> e/ ou <span class="bg-danger">Licita&ccedil;&atilde;o</span></li>
                    </ul>
                </div>
                <br />
                <i class="fa fa-lightbulb-o fa-lg"></i>&nbsp;<strong>DICA</strong>
                Ao inserir os treinandos na sua turma, evite inserir perfis do tipo <kbd>Administrador</kbd> e/ou <kbd>Gestor</kbd>. Insira como:
                <span class="text-success">Analista de M&eacute;tricas</span>, <span class="text-success">Validadores Internos</span>, dentre outros e monte a din&acirc;mica da sua aula.
            </div>
            <div class="col-md-3">
                <strong><span id="href_modal_inserir_alterar_fornecedor"><i class="fa fa-exchange"></i>&nbsp;Alterar/Consultar</span></strong><br />
                Selecione uma turma para proceder com a altera&ccedil;&atilde;o<br /><br />
                <div class="form-group">
                    <select class="form-control input_style combo-turma-fornecedor" id="combo_alterar_id_turma"></select>
                </div>
            </div>
            <div class="col-md-5">
                <div style="width: 100%; visibility: hidden;" id="turma-info">
                    <div class="jumbotron" style="padding:20px;">
                        <div class="row">
                            <div class="col-md-4">
                                <center>
                                    <span id="turma-span-logomarca"></span>
                                </center>
                            </div>
                            <div class="col-md-8">
                                <div class="sub_text"><i class="fa fa-building"></i>&nbsp;Nome</div><strong><span id="turma-span-nome"></span></strong><br /><br />
                                <div class="sub_text"><i class="fa fa-user"></i>&nbsp;Contato</div><strong><span id="turma-span-preposto-nome"></span></strong><br /><br />
                                <div class="sub_text"><i class="fa fa-envelope"></i>&nbsp;Email</div><span id="turma-span-preposto-email"></span><br /><br />
                                <div class="sub_text"><i class="fa fa-phone"></i>&nbsp;Telefone</div><span id="turma-span-preposto-telefone"></span><br /><br /><br />
                                <span id="div-txt-turma"></span><br /><br />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success btn-alterar-turma-fornecedor" id="turma-btn-alterar" data-toggle="modal" data-target="#form_modal_inserir_alterar_fornecedor" disabled><i class="fa fa-edit"></i>&nbsp;Alterar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
