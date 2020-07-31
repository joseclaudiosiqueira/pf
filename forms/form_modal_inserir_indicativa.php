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
<div id="form-modal-inserir-indicativa" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <form role="form">
                <input type="hidden" id="tabela-indicativa" value="">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
                    <span>&nbsp;&nbsp;<i class="fa fa-list-ul fa-lg"></i>&nbsp;&nbsp;Inserir fun&ccedil;&atilde;o [ <span id="titulo-indicativa"></span> ] - INDICATIVA</span>
                </div>
                <div class="modal-body" style="background-color:#f0f0f0;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <i class="fa fa-lightbulb-o"></i>&nbsp;DICAS<br />
                                <ul class="fa-ul">
                                    <li><i class="fa fa-arrow-circle-o-right"></i>&nbsp;Insira o nome das fun&ccedil;&otilde;es de <strong><span id="indicativa-titulo-2"></span></strong> separadas por ponto-e-v&iacute;rgula;</li>
                                    <li><i class="fa fa-arrow-circle-o-right"></i>&nbsp;N&atilde;o utilize caracteres acentuados e/ou especiais;</li>
                                    <li><i class="fa fa-arrow-circle-o-right"></i>&nbsp;Ao finalizar a sua lista clique no bot&atilde;o [ <i class="fa fa-plus-circle"></i>&nbsp;INSERIR ].</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txt-indicativa">Nome(s) / descri&ccedil;&otilde;es</label>
                                <textarea id="text-indicativa" rows="10" class="form-control input_style scroll" maxlength="3000"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="text-align: right">
                        <hr>
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-success" id="btn-adicionar-indicativa"><i class="fa fa-plus-circle"></i>&nbsp;Adicionar</button>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="modal-footer"></div>
            </form>
        </div>
    </div>
</div>
