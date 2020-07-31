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
<div id="form_modal_listar_atribuicoes_perfis" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <form role="form">
                <div class="modal-header">
                    <button type="button" id="fechar_perfil_ap" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <i class="fa fa-users"></i>&nbsp;&nbsp;Perfis de usu&aacute;rios<br />
                    <span class="sub-header">Lista de atribui&ccedil;&otilde;es dos perfis de usu&aacute;rios</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <h4>
                                    <label for="grupos">
                                        <span class="pop" data-toggle="popover" data-placement="bottom" 
                                              data-content="<p align='justify'>ATEN&Ccedil;&Atilde;O: algumas funcionalidades 
                                              dispon&iacute;veis para o perfil precisam estar contratadas pelo plano da sua empresa. 
                                              Por exemplo: um Analista de M&eacute;tricas pode inserir contagens de Licita&ccedil;&atilde;o 
                                              apenas se a empresa contratou um plano que tenha esta funcionalidade.</p>" title="<i class='fa fa-arrow-right'></i>&nbsp;Restri&ccedil;&otilde;es do plano contratado">
                                            <i class="fa fa-info-circle"></i>&nbsp;<i id="w_atribuicao" class="fa fa-dot-circle-o"></i>&nbsp;&nbsp;Selecione um perfil</span>
                                    </label>
                                </h4>
                                <select id="atribuicao_id" class="form-control input_style">
                                    <option value="0">...</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <h4><i class="fa fa-user-secret"></i>&nbsp;Autoriza&ccedil;&otilde;es de acesso do grupo</h4>
                            <div class="scroll" style="width:100%; min-height: 535px; max-height:535px; overflow-x: hidden; overflow-y: scroll;">
                                <table class="box-table-a" id="fixRole">
                                    <thead>
                                        <tr>
                                            <th width="10%" align="center">Padr&atilde;o</th>
                                            <th width="90%">Descri&ccedil;&atilde;o</th>
                                        </tr>
                                    </thead>
                                    <tbody id="addAtribuicao"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>                   
                </div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>