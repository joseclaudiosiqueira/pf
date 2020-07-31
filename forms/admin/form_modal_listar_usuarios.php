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
<div id="form_modal_listar_usuarios" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="fechar_lista" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                <i class="fa fa-users"></i><span id="title-lista-usuarios">&nbsp;&nbsp;Lista perfis de usu&aacute;rios cadastrados para sua Empresa, Fornecedor e/ou Cliente</span><br />
                <span class="sub-header">Verifica&ccedil;&atilde;o de usu&aacute;rios e perfis cadastrados no sistema Dimension</span>
            </div>
            <div class="modal-body">
                <!--nothing here ...
                <div class="row not-view">
                    <div class="col-md-8" style="padding-top: 7px;">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input id="opt1" type="radio" name="campo-pesquisa" value="1" checked>
                                    <label for="opt1"><span><span></span></span>&nbsp;&nbsp;Nome</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input id="opt2" type="radio" name="campo-pesquisa" value="2">
                                    <label for="opt2"><span><span></span></span>&nbsp;&nbsp;Email</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input id="opt3" type="radio" name="campo-pesquisa" value="3">
                                    <label for="opt3"><span><span></span></span>&nbsp;&nbsp;Empresa</label>                            
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">                            
                                    <input id="opt4" type="radio" name="campo-pesquisa" value="4">
                                    <label for="opt4"><span><span></span></span>&nbsp;&nbsp;Perfil</label>                            
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">                            
                                    <input id="opt5" type="radio" name="campo-pesquisa" value="5">
                                    <label for="opt5"><span><span></span></span>&nbsp;&nbsp;Cliente</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">                            
                                    <input id="opt6" type="radio" name="campo-pesquisa" value="6">
                                    <label for="opt6"><span><span></span></span>&nbsp;&nbsp;Status</label>                            
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 scroll" style="overflow-y: scroll;">
                        <div class="form-group">
                            <input type="text" class="form-control input_style" id="pesquisa-perfil" 
                                   onkeyup="searchInTable($(this).get(0).id, $('#tbl-lista-usuarios').get(0).id, $('input[name=campo-pesquisa]:checked').val());" />
                        </div>
                    </div>
                </div>-->
                <div class="row">
                    <div class="col-md-12">
                        <div style="min-height: 535px; max-height: 535px; overflow-x: auto; overflow-y: scroll; width:100%;" class="scroll">
                            <table class="box-table-a" width="100%" id="tbl-lista-usuarios">
                                <thead>
                                    <tr>
                                        <th width="05%">#ID</th>
                                        <th width="25%">Nome</th>
                                        <th width="20%">Email</th>
                                        <th width="12%">E/F/T<sup>1</sup></th>
                                        <th width="13%">Perfil</th>
                                        <th width="11%">Cliente</th>
                                        <th width="07%"><i id="w_lista_usuario_status" class="fa fa-dot-circle-o"></i>&nbsp;Status</th>
                                        <th width="07%">Status<sup>2</sup>
                                    </tr>
                                </thead>
                                <tbody id="addListaUsuario"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <sup>1</sup> E - Empresa, F - Fornecedor, T - Treinamento (turma) | 
                <i class="fa fa-check-circle-o fa-lg"></i>&nbsp;Administrador, Gestor e/ou Analista de M&eacute;tricas que podem fazer valida&ccedil;&otilde;es em contagens | 
                <sup>2</sup> Status de ativa&ccedil;&atilde;o do usu&aacute;rio no Dimension&reg;                
            </div>
        </div>
    </div>
</div>