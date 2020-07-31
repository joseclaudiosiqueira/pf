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
<div id="form_modal_comentarios" class="modal fade" role="dialog">
    <form role="form" id="form-comentarios">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="fechar-comentarios"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <i class="fa fa-comments"></i>&nbsp;&nbsp;Coment&aacute;rios e observa&ccedil;&otilde;es sobre esta fun&ccedil;&atilde;o<br />
                    <span class="sub-header">Insira informa&ccedil;&otilde;es que possam auxiliar os validadores e/ou auditores</span>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="scroll" style="min-height: 550px; max-height: 550px; overflow-x: hidden; overflow-y: auto; width: 100%;">
                                <table width="100%">
                                    <tbody id="addComentarios"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <input type="hidden" id="comentario-id-funcao">
                            <input type="hidden" id="comentario-tabela">
                            <input type="hidden" id="comentario-linha">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="form-control input_style scroll" style="width: 100%; min-height: 450px;" placeholder="Novo coment&aacute;rio" id="txtComentario" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <strong><i class="fa fa-lightbulb-o fa-2x"></i>&nbsp;DICAS</strong><br />
                                    <i class="fa fa-arrow-circle-right"></i>&nbsp;Ao inserir um coment&aacute;rio em uma fun&ccedil;&atilde;o seja espec&iacute;fico e elabore algo que possa auxiliar o Analista em prov&aacute;veis corre&ccedil;&otilde;es e/ou ajustes..<br />
                                    <i class="fa fa-arrow-circle-right"></i>&nbsp;Para fazer refer&ecirc;ncia a links externos, utilize o bot&atilde;o de inser&ccedil;&atilde;o de links.
                                    OBS.: Poder&aacute; haver inspe&ccedil;&atilde;o autom&aacute;tica de links com vistas a evitar direcionamento para sites maliciosos e caso seja detectada uma irregularidade, o link ser&aacute; removido e o respons&aacute;vel notificado.
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i>&nbsp;Adicionar o coment&aacute;rio</button>
                </div>
            </div>
        </div>
    </form>
</div>
