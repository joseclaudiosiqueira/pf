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
        <i class="fa fa-info-circle fa-lg"></i>&nbsp;&nbsp;Usu&aacute;rios<br />
        <span class="sub-header">Gerencie sua base de usu&aacute;rios no sistema</span>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo!(isFornecedor()) ? '<strong><a href="#" data-toggle="modal" data-target="#form_modal_inserir_usuario" id="fmiausu-link"><i class="fa fa-user-plus"></i>&nbsp;Inserir</a></strong>' : '<strong><i class="fa fa-user-plus"></i>&nbsp;Inserir</strong>'; ?><br />
                        Inclus&atilde;o de novos usu&aacute;rios
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <strong><a href="#" data-toggle="modal" data-target="#form_modal_inserir_usuario" id="fmiaaluno-link"><i class="fa fa-graduation-cap"></i>&nbsp;Alunos / Instrutor</a></strong><br />
                        Inclus&atilde;o de novos alunos/instrutor em turmas de treinamento<br /><br />
                        <div style="border: 1px dotted #f68; padding: 5px; border-radius: 5px;">
                            Ao inserir um aluno em uma <kbd>Turma de treinamento</kbd> ele passa a compor a base de usu&aacute;rios do Dimension&reg;,
                            desta forma voc&ecirc; n&atilde;o precisa cadastrar novamente quando houver a necessidade de convert&ecirc;-lo em um <strong>Usu&aacute;rio</strong> 
                            que executa atividades relacionadas &agrave;s contagens.<br /><br />
                            <kbd>ATEN&Ccedil;&Atilde;O</kbd> sempre que for criada uma nova turma de treinamento, um <span class="bg-danger">Instrutor</span> deverá, obrigatoriamente, ser cadastrado/associado &agrave; turma, 
                            pois ele realizar&aacute; a gest&atilde;o, inserindo novos alunos e/ou gerenciando/verificando as contagens feitas, isso desonera o administrador do sistema.
                        </div>  
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <strong><?php echo!(isFornecedor()) ? '<a href="#" data-toggle="modal" data-target="#form_modal_listar_usuarios" id="lnus">' : NULL; ?><i class="fa fa-user"></i>&nbsp;Listar perfis [<span class="text-info">usu&aacute;rios</span>]<?php echo!(isFornecedor()) ? '</a>' : NULL; ?></strong><br />
                        Listar perfis de usu&aacute;rios (ativar/inativar)
                    </div>
                </div>        
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <strong><?php echo getTipoFornecedor() || !(isFornecedor()) ? '<a href="#" data-toggle="modal" data-target="#form_modal_listar_usuarios" id="lnal">' : NULL; ?><i class="fa fa-graduation-cap"></i>&nbsp;Listar perfis [<span class="text-info">alunos</span>]<?php echo getTipoFornecedor() || !(isFornecedor()) ? '</a>' : NULL; ?></strong><br />
                        Listar perfis de alunos (ativar/inativar)
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <strong><a href="#" data-toggle="modal" data-target="#form_modal_listar_atribuicoes_perfis" class="link-atribuicoes"><i class="fa fa-list"></i>&nbsp;Listar configura&ccedil;&atilde;o dos perfis</a></strong><br />
                        Listar atribui&ccedil;&otilde;es de cada perfil de usu&aacute;rio dentro do sistema Dimension&reg;
                    </div>
                </div>      
            </div>
        </div>
    </div>
</div>

