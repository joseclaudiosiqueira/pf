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
<div id="form_modal_configuracoes_banco_dados" class="modal fade" role="dialog">
    <div class="modal-dialog modal-">
        <!-- Modal content -->
        <form id="form_configuracoes_banco_dados">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <span id="contagem_h4-modal"><i class="fa fa-database w_calibracao_banco_dados"></i>&nbsp;&nbsp;Inser&ccedil;&atilde;o e atualiza&ccedil;&atilde;o de Bancos de Dados</span><br />
                    <span class="sub-header">Insira as informa&ccedil;&otilde;es sempre que n&atilde;o encontrar no padr&atilde;o do Dimension</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div style="min-height: 550px; max-height: 550px; overflow-x: hidden; overflow-y: scroll; width: 100%;" class="scroll">
                                <table class="box-table-a" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="80%">Descri&ccedil;&atilde;o</th>
                                            <th width="10%">
                                                <span class="pop" data-toggle="popover" data-placement="bottom" title="<i class='fa fa-arrow-right'></i>&nbsp;Altera&ccedil;&atilde;o de status" data-content="Voc&ecirc; pode alterar o status diretamente nas linhas de cada item.">
                                                    <i class="fa fa-info-circle"></i>&nbsp;<i id="w_banco_dados_status" class="fa fa-dot-circle-o"></i>&nbsp;Status</span>
                                            </th>
                                            <th width="10%">A&ccedil;&atilde;o</th>
                                        </tr>
                                        <tr style="background-color: #fbcb09;">
                                            <td width="80%">
                                                <div class="ui fluid corner labeled input">
                                                    <input id="novo_banco_dados" type="text" class="input_style" maxlength="255">
                                                    <div class="ui corner label">
                                                        <i class="asterisk icon"></i>
                                                    </div>
                                                </div>                                                
                                            </td>
                                            <td width="10%"><input id="banco_dados_is_ativo" type="checkbox" data-toggle="toggle" data-onstyle="success" data-style="slow" data-on="Ativo" data-off="Inativo" class="datatoggle" checked data-width="100" data-height="36"></td>
                                            <td width="10%"><button type="button" id="inserir-banco-dados" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Adicionar</button></td>
                                        </tr>                                        
                                    </thead>
                                    <tbody id="addLinhaBancoDados"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <strong>ATEN&Ccedil;&Atilde;O</strong>: ao finalizar fa&ccedil;a <i>logoff</i> e <i>login</i> novamente
                </div>
            </div>
        </form>            
    </div>
</div>