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
<div id="form-modal-inserir-alterar-listas" class="modal fade" role="dialog" style="margin-top: 80px;">
    <div class="modal-dialog">
        <!-- Modal content -->
        <div class="modal-content">
            <form id="form-linha-lista" role="form">
                <input type="hidden" id="id-linha-descricao" value="0"><!--caso seja uma alteracao via ID -->
                <input type="hidden" id="operacao-linha-lista" value="inserir"><!--inserir/alterar/excluir -->
                <input type="hidden" id="id-span-linha-lista" value=""><!--ID do span na descricao -->
                <input type="hidden" id="descricao-anterior" value=""><!-- descricao anterior que sera posta no input -->
                <input type="hidden" id="descricao-funcao-td" value=""><!-- dados/transacao -->
                <input type="hidden" id="id-descricao-td" value=""><!-- ID da descricao do TD -->
                <div class="modal-header">
                    <button type="button" id="fechar-listas" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <span>&nbsp;&nbsp;<i class="fa fa-list-ul fa-lg"></i>&nbsp;&nbsp;Inser&ccedil;&atilde;o, Exclus&atilde;o e Altera&ccedil;&atilde;o de descri&ccedil;&otilde;es</span>
                </div>
                <div class="modal-body" style="background-color:#f0f0f0;">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <input type="text" class="form-control input_style" id="descricao-linha-lista" autocomplete="off" required autofocus>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <button type="button" class="btn btn-default btn-block" id="btn-adicionar-linha-lista"><i class="fa fa-plus-circle"></i>&nbsp;Adicionar</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div style="min-height:309px;max-height:309px;overflow-x:hidden;overflow-y:scroll;width:100%;border-bottom:2px solid #d0d0d0;margin-bottom:5px;" class="scroll">
                                <table class="box-table-a" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="15%">#ID</th>
                                            <th width="78%">Descri&ccedil;&atilde;o</th>
                                            <th width="7%">A&ccedil;&atilde;o</th>
                                        </tr>
                                    </thead>
                                    <tbody id="addLinhaLista"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <strong>INSTRU&Ccedil;&Otilde;ES</strong>:<br />
                            <small>
                                <ul>
                                    <li>Para alterar uma descri&ccedil;&atilde;o clique no link habilitado em cada caso <u>#ID</u> ou <u>Descri&ccedil;&atilde;o</u>;</li>
                                    <li>Caso esteja efetuanto uma altera&ccedil;&atilde;o em uma funcionalidade j&aacute; gravada no banco, as altera&ccedil;&otilde;es feitas aqui ser&atilde;o armazenadas automaticamente.</li>
                                </ul>
                            </small>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>