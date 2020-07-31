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
<div id="form-modal-pesquisar-funcoes-livre" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="fechar-pesquisa-funcoes"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>                
                <i class="fa fa-map-marker"></i>&nbsp;&nbsp;Pesquisa funcionalidades<br />
                <span class="sub-header">Fun&ccedil;&otilde;es de Dados e Transa&ccedil;&atilde;o em Linhas de Base [Livre]</span>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                        <div id="div-pesquisa-funcao"></div>
                    </div>
                    <div class="col-md-5">
                        <select id="id-baseline-pesquisa-livre" class="form-control input_style"></select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="scroll" style="min-height: 420px; max-height: 420px; overflow-x: hidden; overflow-y: auto; width: 100%; padding: 5px;" id="addPesquisaFuncoesLivre"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <label for="btn-operacao">Selecione a opera&ccedil&atilde;o desejada:</label>
                <div class="btn-group" id="btn-operacao">
                    <button type="button" class="btn btn-success btn-adicionar-funcoes" id="opi" value="I"><span class="badge">I</span> Incluir</button>
                    <button type="button" class="btn btn-warning btn-adicionar-funcoes" id="opa" value="A"><span class="badge">A</span> Alterar</button>
                    <button type="button" class="btn btn-danger btn-adicionar-funcoes" id="ope" value="E"><span class="badge">E</span> Excluir</button>
                </div>
            </div>
        </div>
    </div>
</div>
